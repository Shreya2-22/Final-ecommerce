<?php include('includes/traderheader.php'); ?>

<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">
    <?php include('includes/tradersidebar.php'); ?>

    <main class="col-12 col-md content-box border me-3 py-4 px-4">
      <div class="mx-auto" style="max-width: 900px;">
        <h3 class="text-center mb-4 fw-bold">Product Details</h3>

        <?php
        $productName = isset($_GET['product_name']) ? $_GET['product_name'] : 'Sample Product';
        $category = isset($_GET['category']) ? $_GET['category'] : 'Bakery';
        ?>

        <!-- Product Name -->
        <h4 class="text-primary text-center mb-4"><?= htmlspecialchars($productName) ?></h4>

        <!-- Product Image -->
        <div class="text-center mb-5">
          <img src="../assets/sample-product.jpg" class="img-fluid rounded shadow" style="max-height: 250px;" alt="Product Image">
        </div>

        <!-- Product Details in Label - Box Layout -->
        <div class="row mb-3 align-items-center">
          <label class="col-md-4 fw-semibold">Category:</label>
          <div class="col-md-8 border rounded py-2 px-3 bg-light"><?= htmlspecialchars($category) ?></div>
        </div>

        <div class="row mb-3 align-items-center">
          <label class="col-md-4 fw-semibold">Price:</label>
          <div class="col-md-8 border rounded py-2 px-3 bg-light">£10.00</div>
        </div>

        <div class="row mb-3 align-items-center">
          <label class="col-md-4 fw-semibold">Discount (%):</label>
          <div class="col-md-8 border rounded py-2 px-3 bg-light">15%</div>
        </div>

        <div class="row mb-3 align-items-center">
          <label class="col-md-4 fw-semibold">Price After Discount:</label>
          <div class="col-md-8 border rounded py-2 px-3 bg-light">£8.50</div>
        </div>

        <div class="row mb-3 align-items-center">
          <label class="col-md-4 fw-semibold">Description:</label>
          <div class="col-md-8 border rounded py-2 px-3 bg-light">Freshly baked and delicious!</div>
        </div>

        <div class="row mb-3 align-items-center">
          <label class="col-md-4 fw-semibold">Allergy Info:</label>
          <div class="col-md-8 border rounded py-2 px-3 bg-light">Contains gluten and dairy</div>
        </div>

        <div class="row mb-4 align-items-center">
          <label class="col-md-4 fw-semibold">Stock Quantity:</label>
          <div class="col-md-8 border rounded py-2 px-3 bg-light">30</div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-center gap-3">
          <a href="traderproductdetail.php" class="btn btn-secondary px-4">Back</a>
          <a href="traderupdateproductform.php?category=<?= urlencode($category) ?>&product_name=<?= urlencode($productName) ?>" class="btn btn-warning px-4">Edit</a>
          <!-- Delete Button Triggers Modal -->
          <button class="btn btn-danger px-4" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
            Delete
          </button>

        </div>
      </div>
    </main>
  </div>
</div>

<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered"> <!-- Just added this class -->
    <div class="modal-content border-danger">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete the product "<strong><?= htmlspecialchars($productName) ?></strong>"?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <a href="deleteproduct.php?category=<?= urlencode($category) ?>&product_name=<?= urlencode($productName) ?>" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>


<?php include('includes/traderfooter.php'); ?>