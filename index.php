<?php include("includes/header.php"); ?>
<!-- Homepage Slider -->
<div id="homepageCarousel" class="carousel slide mt-3" data-bs-ride="carousel">
  <div class="carousel-inner">

    <!-- Slide 1 -->
    <div class="carousel-item active position-relative">
      <img src="images/vegetable_slider.jpg" class="d-block w-100" alt="Slide 1"
        style="height: 500px; object-fit: cover;" />

      <!-- Shop Now Button Overlay -->
      <a href="#" class="btn position-absolute px-4 py-2 text-white"
        style="background-color: #C49A6C; border-radius: 8px; bottom: 80px; left: 57.5%; transform: translateX(-50%);">
        Shop Now
      </a>
    </div>

    <!-- Slide 2 -->
    <div class="carousel-item position-relative">
      <img src="images/bread_slider.jpg" class="d-block w-100" alt="Slide 2"
        style="height: 500px; object-fit: cover;" />
      <a href="#" class="btn position-absolute px-4 py-2 text-white"
        style="background-color: #C49A6C; border-radius: 8px; bottom: 80px; left: 57.5%; transform: translateX(-50%);">
        Shop Now
      </a>
    </div>

    <!-- Slide 3 -->
    <div class="carousel-item position-relative">
      <img src="images/Slider3.png" class="d-block w-100" alt="Slide 3"
        style="height: 500px; object-fit: cover;" />
      <a href="#" class="btn position-absolute px-4 py-2 text-white"
        style="background-color: #C49A6C; border-radius: 8px; bottom: 80px; left: 57.5%; transform: translateX(-50%);">
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


<!-- Shop By traders section -->
<section class="container my-5">
  <h2 class="text-center fw-bold mb-5" style="color: #2e5f2e;">Shop by Traders</h2>

  <div class="row justify-content-center text-center g-5">

    <!-- Greengrocer -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="greengrocer.php" class="text-decoration-none">
        <img src="images/categories/Greengrocery.jpg" class="img-fluid rounded shadow-sm mb-2" alt="Greengrocer" style="height: 200px; width: 200px; object-fit: cover;">
        <h6 class="fw-semibold text-dark">Greengrocer</h6>
      </a>
    </div>

    <!-- Butcher -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="butcher.php" class="text-decoration-none">
        <img src="images/categories/butcher.jpg" class="img-fluid rounded shadow-sm mb-2" alt="Butcher" style="height: 200px; width: 200px; object-fit: cover;">
        <h6 class="fw-semibold text-dark">Butcher</h6>
      </a>
    </div>

    <!-- Fishmonger -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="fishmonger.php" class="text-decoration-none">
        <img src="images/categories/Fishmonger.jpg" class="img-fluid rounded shadow-sm mb-2" alt="Fishmonger" style="height: 200px; width: 200px; object-fit: cover;">
        <h6 class="fw-semibold text-dark">Fishmonger</h6>
      </a>
    </div>

    <!-- Bakery -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="bakery.php" class="text-decoration-none">
        <img src="images/categories/bakery.jpg" class="img-fluid rounded shadow-sm mb-2" alt="Bakery" style="height: 200px; width: 200px; object-fit: cover;">
        <h6 class="fw-semibold text-dark">Bakery</h6>
      </a>
    </div>

    <!-- Delicatessen -->
    <div class="col-6 col-md-4 col-lg-2">
      <a href="delicatessen.php" class="text-decoration-none">
        <img src="images/categories/delicatessen.jpg" class="img-fluid rounded shadow-sm mb-2" alt="Delicatessen" style="height: 200px; width: 200px; object-fit: cover;">
        <h6 class="fw-semibold text-dark">Delicatessen</h6>
      </a>
    </div>

  </div>
</section>

<?php
$bestSellers = [
  ["name" => "Capsicum", "price" => "£3.99", "shop" => "Fresh Organic", "rating" => 5, "image" => "Capsicum.jpg"],
  ["name" => "Salmon", "price" => "£6.49", "shop" => "Ocean Fresh", "rating" => 5, "image" => "Salmon.jpg"],
  ["name" => "Chocolate Donut", "price" => "$1.25", "shop" => "Artisan Breads and Pastries", "rating" => 4, "image" => "Chocolatedonut.jpg"],
  ["name" => "Fresh Crab", "price" => "£8.99", "shop" => "Ocean Fresh", "rating" => 5, "image" => "Crab.jpg"],
  ["name" => "Organic Tomatoes", "price" => "£3.25", "shop" => "Fresh Organic", "rating" => 4, "image" => "toma.webp"],
  ["name" => "Croissant", "price" => "£2.50", "shop" => "Artisan Breads and Pastries", "rating" => 5, "image" => "Croissant.jpg"],
  ["name" => "Chicken Drumstick", "price" => "£4.45", "shop" => "Butcher's Block", "rating" => 5, "image" => "Chicken Drumstick.jpg"],
  ["name" => "Cheddar Cheese", "price" => "£5.20 ", "shop" => "Fresh Organic", "rating" => 4, "image" => "Cheddarcheese.jpeg"],
];
?>

<!-- Best Sellers Section -->
<section class="container my-5">
  <h2 id="bestsellers" class="text-center fw-bold mb-5" style="color: #2e5f2e;">Best Sellers</h2>

  <div class="row justify-content-center g-4">
    <?php foreach ($bestSellers as $product): ?>
      <div class="col-6 col-md-4 col-lg-3 d-flex justify-content-center">
        <div class="card h-100 shadow-sm border-0" style="width: 90%; border-radius: 12px; overflow: hidden;">
          <div style="height: 160px; overflow: hidden;">
            <img src="images/Bestsellers/<?php echo $product['image']; ?>" class="w-100" alt="<?php echo $product['name']; ?>" style="object-fit: cover; height: 100%;">
          </div>
          <div class="card-body text-center p-2">
            <h6 class="fw-semibold mb-1" style="font-size: 0.95rem;"><?php echo $product['name']; ?></h6>
            <p class="text-muted mb-1" style="font-size: 0.85rem;"><?php echo $product['price']; ?></p>
            <p class="mb-1 text-secondary" style="font-size: 0.8rem;"><?php echo $product['shop']; ?></p>
            <p class="text-warning mb-1" style="font-size: 0.85rem;">
              <?php echo str_repeat('&#9733;', $product['rating']); ?>
              <?php echo str_repeat('&#9734;', 5 - $product['rating']); ?>
            </p>
            <div class="d-flex justify-content-center align-items-center gap-2">
              <a href="#" class="text-dark fs-5"><i class="far fa-heart"></i></a>
              <a href="#" class="btn btn-sm text-white px-3 py-1" style="background-color: #C49A6C; font-size: 0.85rem;">Add to Cart</a>
            </div>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include("includes/footer.php"); ?>