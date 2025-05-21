<?php
session_start();
require 'includes/connect.php';  // adjust path if needed

// Pagination settings
$perPage = 8;
$page    = max(1, intval($_GET['page'] ?? 1));
$offset  = ($page - 1) * $perPage;
$maxRow  = $offset + $perPage;

// Handle filters and sorting
$conds = [];
$params = [];
$refs = [];

// Category filter
if (!empty($_GET['catg'])) {
    $conds[] = "u.USER_ID = :catg";
    $params[':catg'] = (int)$_GET['catg'];
}

// Price range
if (isset($_GET['min'], $_GET['max']) && $_GET['min'] !== '' && $_GET['max'] !== '') {
    $conds[] = "p.PRODUCT_PRICE BETWEEN :min AND :max";
    $params[':min'] = (float)$_GET['min'];
    $params[':max'] = (float)$_GET['max'];
}

// Search
if (!empty($_GET['search'])) {
    $conds[] = "(LOWER(p.PRODUCT_NAME) LIKE LOWER(:search) OR LOWER(s.SHOP_NAME) LIKE LOWER(:search))";
    $params[':search'] = '%' . $_GET['search'] . '%';
}

// Base SQL with ROWNUM pagination
$baseSql = "
SELECT * FROM (
    SELECT a.*, ROWNUM rnum FROM (
        SELECT p.PRODUCT_ID, p.PRODUCT_NAME, p.PRODUCT_PRICE, p.PRODUCT_IMAGE, p.PRODUCT_RATING,
               s.SHOP_NAME, u.USER_ID
          FROM PRODUCT p
          JOIN SHOP s ON p.FK1_SHOP_ID = s.SHOP_ID
          JOIN USER_MASTER u ON s.FK1_USER_ID = u.USER_ID"
      . (count($conds) ? " WHERE " . implode(' AND ', $conds) : '')
      . "\n        ORDER BY " . (
          !empty($_GET['sort_item']) && in_array($_GET['sort_item'], ['priceASC','priceDSC','nameASC','nameDSC'])
            ? ([
                'priceASC' => 'p.PRODUCT_PRICE ASC',
                'priceDSC' => 'p.PRODUCT_PRICE DESC',
                'nameASC'  => 'p.PRODUCT_NAME ASC',
                'nameDSC'  => 'p.PRODUCT_NAME DESC'
              ][$_GET['sort_item']])
            : 'p.PRODUCT_NAME'
        )
      . "\n    ) a WHERE ROWNUM <= :maxRow
) WHERE rnum > :offset
";

// Prepare and bind
$stmt = oci_parse($conn, $baseSql);
foreach ($params as $key => $value) {
    $refs[$key] = $value;
    oci_bind_by_name($stmt, $key, $refs[$key]);
}
oci_bind_by_name($stmt, ':offset', $offset);
oci_bind_by_name($stmt, ':maxRow', $maxRow);

// Execute and fetch products
oci_execute($stmt);
$products = [];
while ($row = oci_fetch_assoc($stmt)) {
    $products[] = $row;
}

// Count total rows for pagination
$countSql = "
SELECT COUNT(*) AS TOTAL
  FROM PRODUCT p
  JOIN SHOP s ON p.FK1_SHOP_ID = s.SHOP_ID
  JOIN USER_MASTER u ON s.FK1_USER_ID = u.USER_ID"
  . (count($conds) ? " WHERE " . implode(' AND ', $conds) : '');

$cstmt = oci_parse($conn, $countSql);
foreach ($params as $key => $value) {
    $refs[$key] = $value;
    oci_bind_by_name($cstmt, $key, $refs[$key]);
}
oci_execute($cstmt);
$total = (int)oci_fetch_assoc($cstmt)['TOTAL'];
$totalPages = (int)ceil($total / $perPage);

// Helper to build persistent query strings
function buildQueryString($overrides = []) {
    $qs = $_GET;
    foreach ($overrides as $k => $v) {
        if ($v === null) {
            unset($qs[$k]);
        } else {
            $qs[$k] = $v;
        }
    }
    return http_build_query($qs);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Products – Cleck-E-Mart</title>
  <?php include 'includes/header.php'; ?>
  <style>
    /* Card hover lift effect */
    .card:hover { transform: translateY(-5px); transition: transform 0.3s; }
    .card .rating img { height: 14px; }
  </style>
</head>
<body style="background-color: #F0F8E0;">
  <div class="container py-5">
    <div class="row">
      <!-- Sidebar Filters -->
      <aside class="col-lg-3 mb-4 sidebar">
        <div class="card"><div class="card-body">
          <form method="get" action="product.php">
            <h5>Search</h5>
            <div class="mb-3">
              <input type="text" name="search" class="form-control form-control-sm" placeholder="Search products..."
                     value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            </div>
            <h5>Category</h5>
            <?php
              $tr = oci_parse($conn, "SELECT USER_ID, SHOP_TYPE FROM USER_MASTER WHERE ROLE='trader'");
              oci_execute($tr);
              while ($t = oci_fetch_assoc($tr)): ?>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="catg" id="cat<?= $t['USER_ID'] ?>"
                         value="<?= $t['USER_ID'] ?>" <?= (isset($_GET['catg']) && $_GET['catg']==$t['USER_ID'])?'checked':'' ?> />
                  <label class="form-check-label" for="cat<?= $t['USER_ID'] ?>"><?= htmlspecialchars($t['SHOP_TYPE']) ?></label>
                </div>
            <?php endwhile; ?>
            <h5 class="mt-3">Price</h5>
            <div class="input-group mb-2">
              <input type="number" name="min" class="form-control form-control-sm" placeholder="Min" min="0"
                     value="<?= htmlspecialchars($_GET['min'] ?? '') ?>">
              <span class="input-group-text">-</span>
              <input type="number" name="max" class="form-control form-control-sm" placeholder="Max" min="0"
                     value="<?= htmlspecialchars($_GET['max'] ?? '') ?>">
            </div>
            <h5 class="mt-3">Sort by</h5>
            <select name="sort_item" class="form-select form-select-sm mb-3">
              <option value="">Default</option>
              <option value="priceASC" <?= (($_GET['sort_item'] ?? '')=='priceASC')?'selected':'' ?>>Price: Low ↑</option>
              <option value="priceDSC" <?= (($_GET['sort_item'] ?? '')=='priceDSC')?'selected':'' ?>>Price: High ↓</option>
              <option value="nameASC" <?= (($_GET['sort_item'] ?? '')=='nameASC')?'selected':'' ?>>Name: A–Z</option>
              <option value="nameDSC" <?= (($_GET['sort_item'] ?? '')=='nameDSC')?'selected':'' ?>>Name: Z–A</option>
            </select>
            <button type="submit" class="btn btn-sm btn-primary w-100">Apply Filters</button>
            <a href="product.php" class="btn btn-sm btn-link w-100 mt-1">Reset</a>
          </form>
        </div></div>
      </aside>

      <!-- Product Grid -->
      <main class="col-lg-9">
        <div class="row g-3">
          <?php if (empty($products)): ?>
            <div class="col-12 text-center text-muted">No products found.</div>
          <?php else: ?>
            <?php foreach ($products as $prod): ?>
              <div class="col-6 col-md-4 col-xl-3">
                <div class="card h-100 shadow-sm">
                  <img src="images/product_images/<?= htmlspecialchars(trim($prod['PRODUCT_IMAGE'])) ?>" class="card-img-top" style="height:160px; object-fit:cover;" alt="">
                  <div class="card-body d-flex flex-column">
                    <h6 class="card-title"><?= htmlspecialchars($prod['PRODUCT_NAME']) ?></h6>
                    <p class="shop mb-1"><?= htmlspecialchars($prod['SHOP_NAME']) ?></p>
                    <div class="rating mb-2"><img src="images/ratings/<?= htmlspecialchars($prod['PRODUCT_RATING']) ?>" alt="Rating"></div>
                    <p class="price mb-2">£<?= number_format($prod['PRODUCT_PRICE'],2) ?></p>
                    <div class="mt-auto d-flex justify-content-between">
                      <a href="productdescription.php?id=<?= $prod['PRODUCT_ID'] ?>" class="btn btn-sm btn-outline-secondary">View</a>
                      <a href="addtocart.php?prod=<?= $prod['PRODUCT_ID'] ?>" class="btn btn-sm btn-primary">Add to Cart</a>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
          <nav class="mt-4"><ul class="pagination justify-content-center">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= ($i === $page)? 'active':'' ?>">
                <a class="page-link" href="product.php?<?= buildQueryString(['page'=>$i]) ?>"><?= $i ?></a>
              </li>
            <?php endfor; ?>
          </ul></nav>
        <?php endif; ?>
      </main>
    </div>
  </div>
  <?php include 'includes/footer.php'; clearMsg(); ?>
</body>
</html>
