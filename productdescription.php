<?php
include "includes/connect.php";
session_start();

$id = $_GET['id'];

// Submit Review
if (isset($_POST['submitReview']) && isset($_SESSION['id'])) {
  $review_text = trim($_POST['review']);
  $rating = $_POST['rating'];
  $user_id = $_SESSION['id'];

  $sql = "INSERT INTO REVIEW (REVIEW_TEXT, RATING, FK_USER_ID, FK_PRODUCT_ID) VALUES (:review, :rating, :user_id, :product_id)";
  $stmt = oci_parse($conn, $sql);
  oci_bind_by_name($stmt, ":review", $review_text);
  oci_bind_by_name($stmt, ":rating", $rating);
  oci_bind_by_name($stmt, ":user_id", $user_id);
  oci_bind_by_name($stmt, ":product_id", $id);
  oci_execute($stmt);
}

$query = "SELECT P.*, S.SHOP_NAME FROM PRODUCT P JOIN SHOP S ON P.FK1_SHOP_ID = S.SHOP_ID WHERE PRODUCT_ID = $id";
$result = oci_parse($conn, $query);
oci_execute($result);
$row = oci_fetch_assoc($result);
$image = $row['PRODUCT_IMAGE'];
$rating = $row['PRODUCT_RATING'];
$shop_name = $row['SHOP_NAME'];

$heart = "heart-white";
if (isset($_SESSION['id'])) {
  $wishlist_product = "SELECT * FROM WISHLIST WHERE FK1_PRODUCT_ID = $id AND FK2_USER_ID =" . $_SESSION['id'];
  $wishlist_Presult = oci_parse($conn, $wishlist_product);
  oci_execute($wishlist_Presult);
  if ($wishRow = oci_fetch_assoc($wishlist_Presult)) {
    $heart = "heart-red";
  }
}
?>
<!doctype html>
<html lang="en">
<head>
  <title>Product Description</title>
  <?php
  $pageTitle = "Product Description";
   include "includes/header.php"; ?>
  <style>
    body { background-color: #f4fbe8; }
    .PRODUCT_IMAGE { width: 100%; height: auto; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
    .product-detail { background: #fdfdf5; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .rating-image { height: 24px; width: auto; }
    .heart-red { font-size: 32px; color: #DB1F64; }
    .heart-white { font-size: 32px; color: #fff; text-shadow: 0 0 3px #FF0000, 0 0 5px #DB1F64; }
    .review-card { border-radius: 12px; background-color: #ffffff; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05); }
    .review-avatar { width: 60px; height: 60px; }
  </style>
</head>
<body>
  <div class="container my-5">
    <div class="row product-detail">
      <div class="col-md-6 mb-4">
        <img class="PRODUCT_IMAGE" src="images/product_images/<?php echo $image; ?>" alt="<?php echo $row['PRODUCT_NAME']; ?>">
      </div>
      <div class="col-md-6">
        <h2 class="fw-bold mb-2"><?php echo ucwords($row['PRODUCT_NAME']); ?></h2>
        <p class="text-muted mb-1">From: <strong><?php echo $shop_name; ?></strong></p>
        <img src="images/ratings/<?php echo $rating; ?>" alt="Rating" class="rating-image mb-3">
        <h4 class="text-success">&pound;<?php echo number_format($row['PRODUCT_PRICE'], 2); ?></h4>
        <p><?php echo $row['PRODUCT_DESC']; ?></p>
        <p class="text-muted"><strong>Allergy Info:</strong> <?php echo $row['ALLERGY_INFO']; ?></p>
        <div class="d-flex align-items-center gap-3">
          <a href="addtocart.php?prod=<?php echo $row['PRODUCT_ID']; ?>" class="btn btn-warning text-white px-4">Add to Cart</a>
          <a href="wishlist_query.php?id=<?php echo $row['PRODUCT_ID']; ?>">
            <i class="fa-solid fa-heart <?php echo $heart; ?>"></i>
          </a>
        </div>
      </div>
    </div>
  </div>

  <!-- Reviews -->
  <div class="container my-5">
    <h4 class="text-center mb-4">Top Reviews</h4>
    <?php
    $rev_query = "SELECT R.REVIEW_TEXT, R.RATING, U.USERNAME FROM REVIEW R JOIN USER_MASTER U ON R.FK_USER_ID = U.USER_ID WHERE FK_PRODUCT_ID = $id ORDER BY REVIEW_DATE DESC";
    $rev_result = oci_parse($conn, $rev_query);
    oci_execute($rev_result);
    while ($rev = oci_fetch_assoc($rev_result)) {
    ?>
      <div class="card mb-3 review-card p-2">
        <div class="row g-0 align-items-center">
          <div class="col-auto px-3">
            <img src="images/dummy.png" class="img-fluid rounded-circle review-avatar" alt="Reviewer">
          </div>
          <div class="col">
            <div class="card-body py-2">
              <h6 class="card-title mb-1"><?php echo htmlspecialchars($rev['USERNAME']); ?> rated <?php echo $rev['RATING']; ?>/5</h6>
              <p class="card-text small text-muted mb-0"><?php echo htmlspecialchars($rev['REVIEW_TEXT']); ?></p>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>

  <!-- Submit Review -->
  <?php if (isset($_SESSION['id'])) { ?>
  <div class="container mb-5">
    <h4 class="text-center mb-4">Give Review</h4>
    <form method="POST">
      <div class="mb-3">
        <label for="review" class="form-label">Review</label>
        <textarea class="form-control" name="review" rows="3" placeholder="Write a review..." required></textarea>
      </div>
      <div class="mb-3">
        <label for="rating" class="form-label">Rating (1 to 5)</label>
        <select name="rating" class="form-select" required>
          <option value="">Select rating</option>
          <option value="1">1</option>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4">4</option>
          <option value="5">5</option>
        </select>
      </div>
      <button type="submit" name="submitReview" class="btn btn-success">Submit</button>
    </form>
  </div>
  <?php } ?>

  <?php include "includes/footer.php"; ?>
</body>
</html>
