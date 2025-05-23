<?php
session_start();
include "includes/connect.php";

// Check if trader is logged in
if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'trader') {
    header("Location: login.php");
    exit();
}

$trader_id = $_SESSION['id'];

// Get trader's shop ID
$shop_query = "SELECT SHOP_ID FROM SHOP WHERE FK1_USER_ID = :trader_id";
$shop_stmt = oci_parse($conn, $shop_query);
oci_bind_by_name($shop_stmt, ":trader_id", $trader_id);
oci_execute($shop_stmt);

$shop_row = oci_fetch_assoc($shop_stmt);
$shop_id = $shop_row['SHOP_ID'];

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];
    $delete_query = "DELETE FROM PRODUCT WHERE PRODUCT_ID = :delete_id AND FK1_SHOP_ID = :shop_id";
    $delete_stmt = oci_parse($conn, $delete_query);
    oci_bind_by_name($delete_stmt, ":delete_id", $delete_id);
    oci_bind_by_name($delete_stmt, ":shop_id", $shop_id);
    oci_execute($delete_stmt);
    $_SESSION['passmessage'] = "Product deleted successfully.";
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Pagination setup
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 5;
$offset = ($page - 1) * $perPage;

// Count total products
$count_query = "SELECT COUNT(*) AS TOTAL FROM PRODUCT WHERE FK1_SHOP_ID = :shop_id";
$count_stmt = oci_parse($conn, $count_query);
oci_bind_by_name($count_stmt, ":shop_id", $shop_id);
oci_execute($count_stmt);
$total_row = oci_fetch_assoc($count_stmt);
$total_products = $total_row['TOTAL'];
$total_pages = ceil($total_products / $perPage);

// Fetch paginated products
$product_query = "SELECT * FROM (
    SELECT a.*, ROWNUM rnum FROM (
        SELECT PRODUCT_ID, PRODUCT_NAME, PRODUCT_IMAGE, PRODUCT_PRICE FROM PRODUCT
        WHERE FK1_SHOP_ID = :shop_id ORDER BY PRODUCT_ID DESC
    ) a WHERE ROWNUM <= :max_row
) WHERE rnum > :min_row";

$product_stmt = oci_parse($conn, $product_query);
$max_row = $offset + $perPage;
$min_row = $offset;
oci_bind_by_name($product_stmt, ":shop_id", $shop_id);
oci_bind_by_name($product_stmt, ":max_row", $max_row);
oci_bind_by_name($product_stmt, ":min_row", $min_row);
oci_execute($product_stmt);
?>
<!DOCTYPE html>
<html>
<head>
  <title>Delete Products</title>
  <link rel="stylesheet" href="css/style_temp.css">
  <?php include "includes/traderheader.php"; include "includes/tradersidebar.php"; ?>
  <style>
    .main {
      margin-top: -20px;
    }
    .product-card {
      border: 1px solid #ccc;
      border-radius: 8px;
      padding: 10px 16px;
      margin: 2px auto;
      background-color: #fff;
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 0.85rem;
      max-width: 500px;
    }
    .product-img {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border-radius: 4px;
    }
    .product-card h5 {
      font-size: 0.95rem;
      margin-bottom: 4px;
    }
    .product-card p {
      font-size: 0.8rem;
      margin: 0;
    }
    .btn-sm {
      font-size: 0.75rem;
      padding: 4px 10px;
    }
    .pagination {
      text-align: right;
      margin: 6px auto 24px;
      max-width: 500px;
    }
    .pagination a {
      margin: 0 5px;
      padding: 5px 12px;
      border: 1px solid #ccc;
      text-decoration: none;
      border-radius: 4px;
      font-size: 0.85rem;
    }
    .pagination a.active {
      background-color: #007bff;
      color: white;
      border-color: #007bff;
    }
    .main {
  margin-top: 0 !important;
  padding-top: 0 !important;
}

.container.pt-0 {
  padding-top: 0 !important;
  margin-top: -250px; /* Optional: Adjust based on how much lift you need */
}

  </style>
</head>
<body>
<div class="main">
  <div class="container pt-0 pb-5">
    <h3 class="mb-5 text-center">Delete Products</h3>
    <?php if (isset($_SESSION['passmessage'])): ?>
      <div class="alert alert-success text-center">
        <?php echo $_SESSION['passmessage']; unset($_SESSION['passmessage']); ?>
      </div>
    <?php endif; ?>
    <?php while ($row = oci_fetch_assoc($product_stmt)): ?>
      <div class="product-card">
        <div class="d-flex align-items-center gap-3">
          <img src="images/product_images/<?php echo $row['PRODUCT_IMAGE']; ?>" class="product-img" alt="">
          <div>
            <h5><?php echo htmlspecialchars($row['PRODUCT_NAME']); ?></h5>
            <p class="text-muted">Price: &pound;<?php echo number_format($row['PRODUCT_PRICE'], 2); ?></p>
          </div>
        </div>
        <form method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
          <input type="hidden" name="delete_id" value="<?php echo $row['PRODUCT_ID']; ?>">
          <button type="submit" class="btn btn-danger btn-sm">Delete</button>
        </form>
      </div>
    <?php endwhile; ?>
    <!-- Pagination Links -->
    <div class="pagination">
      <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>"> <?php echo $i; ?> </a>
      <?php endfor; ?>
    </div>
  </div>
</div>
<?php include "includes/footer.php"; ?>
</body>
</html>
