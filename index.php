<?php

include "includes/connect.php";
include "includes/header.php";
//session_destroy();
?>

<!-- Homepage Slider -->
<div id="homepageCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
  <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="carousel-item active position-relative">
      <img src="images/vegetable_slider.jpg" class="d-block w-100" alt="Slide 1"
        style="height: 500px; object-fit: cover;" />

      <!-- Shop Now Button Overlay -->
      <a href="product.php?catg=143" class="btn position-absolute px-4 py-2 text-white"
        style="background-color: #C49A6C; border-radius: 8px; bottom: 80px; left: 57.5%; transform: translateX(-50%);">
        Shop Now
      </a>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item position-relative">
      <img src="images/breadslider.jpg" class="d-block w-100" alt="Slide 2"
        style="height: 500px; object-fit: cover;" />
      <a href="product.php?catg=141" class="btn position-absolute px-4 py-2 text-white"
        style="background-color: #C49A6C; border-radius: 8px; bottom: 80px; left: 57.5%; transform: translateX(-50%);">
        Shop Now
      </a>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item position-relative">
      <img src="images/fishmonger_slider.jpg" class="d-block w-100" alt="Slide 3"
        style="height: 500px; object-fit: cover;" />
      <a href="product.php?catg=142" class="btn position-absolute px-4 py-2 text-white"
        style="background-color: #C49A6C; border-radius: 8px; bottom: 80px; left: 72.5%; transform: translateX(-50%);">
        Shop Now
      </a>
    </div>

    <!-- Slide 4 -->
    <div class="carousel-item position-relative">
      <img src="images/butcher_slider.jpg" class="d-block w-100" alt="Slide 3"
        style="height: 500px; object-fit: cover;" />
      <a href="product.php?catg=145" class="btn position-absolute px-4 py-2 text-white"
        style="background-color: #C49A6C; border-radius: 8px; bottom: 80px; left: 72.5%; transform: translateX(-50%);">
        Shop Now
      </a>
    </div>


    <!-- Slide 5 -->
    <div class="carousel-item position-relative">
      <img src="images/delicatessen_slider.jpg" class="d-block w-100" alt="Slide 3"
        style="height: 500px; object-fit: cover;" />
      <a href="product.php?catg=144" class="btn position-absolute px-4 py-2 text-white"
        style="background-color: #C49A6C; border-radius: 8px; bottom: 80px; left: 75.5%; transform: translateX(-50%);">
        Shop Now
      </a>
    </div>

  </div>

  <!-- Controls  -->
  <button class="carousel-control-prev" type="button" data-bs-target="#homepageCarousel" data-bs-slide="prev"
    style="width: 5%;">
    <span class="carousel-control-prev-icon" aria-hidden="true" style="filter: invert(1);"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#homepageCarousel" data-bs-slide="next"
    style="width: 5%;">
    <span class="carousel-control-next-icon" aria-hidden="true" style="filter: invert(1);"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

</div>


<!-- Shop by Traders Section (Dynamic) -->
<section class="container my-5">
  <h2 class="text-center fw-bold mb-5" style="color: #2e5f2e;">Shop by Traders</h2>


  <div class="row justify-content-center text-center g-4">
    <?php
    $query = "SELECT * FROM user_master WHERE ROLE = 'trader'";
    $result = oci_parse($conn, $query);
    oci_execute($result);

    while ($row = oci_fetch_assoc($result)) {
      $shopImage = $row['SHOP_IMAGE'];
      $shopName = $row['SHOP_NAME'];
      $userId = $row['USER_ID'];

    ?>
      <div class="col-6 col-md-4 col-lg-2">
        <a href="product.php?catg=<?php echo $userId; ?>" class="text-decoration-none">
          <img src="images/categories/<?php echo $shopImage; ?>" class="img-fluid rounded shadow-sm mb-2" alt="<?php echo $shopName; ?>" style="height: 200px; width: 200px; object-fit: cover;">
        </a>
      </div>
    <?php } ?>
  </div>
</section>


<!-- Best Sellers Section -->
<section class="container my-5">
  <h2 id="bestsellers" class="text-center fw-bold mb-4" style="color: #2e5f2e;">Best Sellers</h2>
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 id="bestsellers" class="fw-bold" style="color: #2e5f2e;"></h2>
    <a href="product.php" class="fw-semibold text-decoration-none" style="color: #C49A6C; font-size: 1.15rem;">
      View More →
    </a>
  </div>

  <div class="row justify-content-center g-4">
    <?php
    $query = "SELECT P.*, S.SHOP_NAME FROM PRODUCT P JOIN SHOP S ON P.FK1_SHOP_ID = S.SHOP_ID WHERE DISPLAY_TYPE = 'bestselling'";
    $result = oci_parse($conn, $query);
    oci_execute($result);

    // Fetch wishlist products for the logged-in customer
    $wishlist = [];
    if (isset($_SESSION['id']) && $_SESSION['role'] == 'customer') {
      $wishlist_query = "SELECT FK1_PRODUCT_ID FROM WISHLIST WHERE FK2_USER_ID = " . $_SESSION['id'];
      $wishlist_result = oci_parse($conn, $wishlist_query);
      oci_execute($wishlist_result);
      while ($wish_item = oci_fetch_assoc($wishlist_result)) {
        $wishlist[] = $wish_item['FK1_PRODUCT_ID'];
      }
    }

    while ($row = oci_fetch_assoc($result)) {
      $productName = ucwords($row['PRODUCT_NAME']);
      $shopName = $row['SHOP_NAME'];
      $productPrice = '£' . number_format($row['PRODUCT_PRICE'], 2);
      $productImage = $row['PRODUCT_IMAGE'];
      $ratingStars = $row['PRODUCT_RATING']; // e.g., '4star.jpg' or '5star.jpg'
      $ratingValue = (int)substr($ratingStars, 0, 1);
    ?>
      <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
        <div class="card h-100 shadow-sm border-0" style="width: 90%; border-radius: 12px; overflow: hidden;">
          <div style="height: 160px; overflow: hidden;">
            <a href="productdescription.php?id=<?php echo $row['PRODUCT_ID']; ?>" class="text-decoration-none">
              <!-- Product Image -->
              <img src="images/product_images/<?php echo $productImage; ?>" class="w-100" alt="<?php echo $productName; ?>" style="object-fit: cover; height: 100%;">
            </a>
          </div>
          <div class="card-body text-center p-2">
            <h6 class="fw-semibold mb-1" style="font-size: 0.95rem;">
              <?php echo $productName; ?><br>
              <span class="text-muted" style="font-size: 0.8rem;"><?php echo $shopName; ?></span>
            </h6>
            <p class="text-muted mb-1" style="font-size: 0.85rem;"><?php echo $productPrice; ?></p>
            <p class="text-warning mb-1" style="font-size: 0.85rem;">
              <?php echo str_repeat('&#9733;', $ratingValue); ?>
              <?php echo str_repeat('&#9734;', 5 - $ratingValue); ?>
            </p>
            <div class="d-flex justify-content-center align-items-center gap-2">
              <?php
              $heartClass = "far fa-heart text-dark"; // default for guest
              $wishlistLink = "login.php"; // default redirect to login

              if (isset($_SESSION['id']) && $_SESSION['role'] == 'customer') {
                $isInWishlist = in_array($row['PRODUCT_ID'], $wishlist);
                $heartClass = $isInWishlist ? 'fas fa-heart text-danger' : 'far fa-heart text-dark';
                $wishlistLink = "wishlist_query.php?id=" . $row['PRODUCT_ID']; // actual wishlist action
              }
              ?>
              <a href="<?php echo $wishlistLink; ?>" class="fs-5">
                <i class="<?php echo $heartClass; ?>"></i>
              </a>


              <a href="addtocart.php?prod=<?php echo $row['PRODUCT_ID']; ?>" class="btn btn-sm text-white px-3 py-1" style="background-color: #C49A6C; font-size: 0.85rem;">Add to Cart</a>
            </div>

          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</section>

<?php
include "includes/footer.php";
clearMsg();
?>