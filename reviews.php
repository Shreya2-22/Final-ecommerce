<?php
include "includes/connect.php";
session_start();

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>My Reviews</title>
  <?php
  $pageTitle = "Reviews";
   include "includes/header.php"; ?>
  <style>
    body { background-color: #f4fbe8; }
    .review-card {
      border-radius: 12px;
      background-color: #ffffff;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
      padding: 1rem;
    }
    .review-avatar {
      width: 60px;
      height: 60px;
    }
  </style>
</head>
<body>
  <div class="container py-5">
    <h3 class="mb-4 text-center">My Product Reviews</h3>
    <?php
    $sql = "SELECT R.REVIEW_TEXT, R.RATING, R.REVIEW_DATE, P.PRODUCT_NAME, P.PRODUCT_IMAGE
            FROM REVIEW R
            JOIN PRODUCT P ON R.FK_PRODUCT_ID = P.PRODUCT_ID
            WHERE R.FK_USER_ID = :user_id
            ORDER BY R.REVIEW_DATE DESC";

    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":user_id", $user_id);
    oci_execute($stmt);

    while ($row = oci_fetch_assoc($stmt)) {
    ?>
      <div class="card mb-3 review-card">
        <div class="row g-0 align-items-center">
          <div class="col-auto px-3">
            <img src="images/product_images/<?php echo $row['PRODUCT_IMAGE']; ?>" class="img-fluid rounded" style="width: 80px; height: 80px; object-fit: cover;" alt="<?php echo $row['PRODUCT_NAME']; ?>">
          </div>
          <div class="col">
            <div class="card-body py-2">
              <h6 class="card-title mb-1">Product: <strong><?php echo htmlspecialchars($row['PRODUCT_NAME']); ?></strong></h6>
              <p class="mb-1">Rating: <strong><?php echo $row['RATING']; ?>/5</strong></p>
              <p class="small text-muted"><?php echo htmlspecialchars($row['REVIEW_TEXT']); ?></p>
              <p class="small text-muted">Reviewed on: <?php echo date('d M Y', strtotime($row['REVIEW_DATE'])); ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
  <?php include "includes/footer.php"; ?>
</body>
</html>
