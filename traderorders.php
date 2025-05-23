<?php
session_start();
include "includes/connect.php";

// Restrict access to traders
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

// Pagination setup
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$perPage = 5;
$offset = ($page - 1) * $perPage;

// Count total orders involving this trader's products
$count_query = "
    SELECT COUNT(*) AS TOTAL
    FROM ORDER_PRODUCT op
    JOIN PRODUCT p ON op.FK2_PRODUCT_ID = p.PRODUCT_ID
    WHERE p.FK1_SHOP_ID = :shop_id";
$count_stmt = oci_parse($conn, $count_query);
oci_bind_by_name($count_stmt, ":shop_id", $shop_id);
oci_execute($count_stmt);
$total_row = oci_fetch_assoc($count_stmt);
$total_orders = $total_row['TOTAL'];
$total_pages = ceil($total_orders / $perPage);

// Fetch trader's paginated orders
$order_query = "
    SELECT * FROM (
        SELECT ROWNUM rnum, x.* FROM (
            SELECT 
                o.ORDER_ID,
                o.ORDER_DATE,
                u.Name AS CUSTOMER_NAME,
                u.Email AS CUSTOMER_EMAIL,
                p.PRODUCT_NAME,
                op.QUANTITY,
                op.PRODUCT_PRICE
            FROM ORDERS o
            JOIN ORDER_PRODUCT op ON o.ORDER_ID = op.FK1_ORDER_ID
            JOIN PRODUCT p ON op.FK2_PRODUCT_ID = p.PRODUCT_ID
            JOIN USER_MASTER u ON o.FK1_USER_ID = u.USER_ID
            WHERE p.FK1_SHOP_ID = :shop_id
            ORDER BY o.ORDER_DATE DESC
        ) x WHERE ROWNUM <= :max_row
    ) WHERE rnum > :min_row";

$order_stmt = oci_parse($conn, $order_query);
$max_row = $offset + $perPage;
$min_row = $offset;
oci_bind_by_name($order_stmt, ":shop_id", $shop_id);
oci_bind_by_name($order_stmt, ":max_row", $max_row);
oci_bind_by_name($order_stmt, ":min_row", $min_row);
oci_execute($order_stmt);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Trader Orders</title>
    <link rel="stylesheet" href="css/style_temp.css">
    <?php include "includes/traderheader.php"; include "includes/tradersidebar.php"; ?>
    <style>
        .main {
            padding: 0;
            margin-top: 0 !important;
        }
        .container.pt-0 {
            padding-top: 0 !important;
            margin-top: -250px;
        }
        h3.mb-1 {
            margin-top: 0 !important;
            margin-bottom: 12px;
        }
        .order-card {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin: 10px auto;
            padding: 12px 20px;
            max-width: 700px;
            font-size: 0.9rem;
        }
        .order-card h5 {
            margin: 0 0 6px;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            margin: 0 4px;
            padding: 6px 12px;
            border: 1px solid #ccc;
            text-decoration: none;
            border-radius: 4px;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<div class="main">
    <div class="container pt-0 pb-1">
        <h3 class="mb-1 text-center">Customer Orders</h3>

        <?php while ($row = oci_fetch_assoc($order_stmt)): ?>
            <div class="order-card">
                <h5>Order #<?php echo $row['ORDER_ID']; ?></h5>
                <p><strong>Product:</strong> <?php echo htmlspecialchars($row['PRODUCT_NAME']); ?></p>
                <p><strong>Quantity:</strong> <?php echo $row['QUANTITY']; ?></p>
                <p><strong>Price:</strong> £<?php echo number_format($row['PRODUCT_PRICE'], 2); ?></p>
                <p><strong>Order Date:</strong> <?php echo $row['ORDER_DATE']; ?></p>
                <p><strong>Customer:</strong> <?php echo htmlspecialchars($row['CUSTOMER_NAME']); ?> (<?php echo $row['CUSTOMER_EMAIL']; ?>)</p>
            </div>
        <?php endwhile; ?>

        <div class="pagination">
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <a href="?page=<?php echo $i; ?>" class="<?php if ($i == $page) echo 'active'; ?>"><?php echo $i; ?></a>
            <?php endfor; ?>
        </div>
    </div>
</div>
<?php include "includes/footer.php"; ?>
</body>
</html>
