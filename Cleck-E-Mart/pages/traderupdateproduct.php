<?php include('../includes/traderheader.php'); ?>

<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">
    <?php include('../includes/tradersidebar.php'); ?>

    <main class="col-12 col-md content-box border me-3 py-4 px-4">
      <div class="mx-auto" style="max-width: 700px;">
        <h3 class="text-center mb-5 fw-bold mt-5">Update Products</h3>

        <form action="traderupdateproductform.php" method="GET">
          <!-- Category Selection -->
          <div class="row mb-4 align-items-center">
            <label for="category" class="col-md-4 col-form-label fw-semibold">Select Category</label>
            <div class="col-md-8">
              <select class="form-select" id="category" name="category" required>
                <option selected disabled>Choose category</option>
                <option value="Greengrocer">Greengrocer</option>
                <option value="Fishmonger">Fishmonger</option>
                <option value="Butcher">Butcher</option>
                <option value="Delicatessen">Delicatessen</option>
                <option value="Bakery">Bakery</option>
              </select>
            </div>
          </div>

          <!-- Product Name Search -->
          <div class="row mb-4 align-items-center">
            <label for="product_name" class="col-md-4 col-form-label fw-semibold">Product Name</label>
            <div class="col-md-8">
              <input type="search" class="form-control" id="product_name" name="product_name" placeholder="Enter product name" required>
            </div>
          </div>

          <!-- Navigation Buttons -->
          <div class="d-flex justify-content-center gap-3 mt-4">
            <a href="traderdashboard.php" class="btn btn-secondary px-4">Back</a>
            <button type="submit" class="btn btn-primary px-4">Next</button>
          </div>
        </form>
      </div>
    </main>
  </div>
</div>

<?php include('../includes/traderfooter.php'); ?>
