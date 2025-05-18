<?php include('../includes/traderheader.php'); ?>

<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">
    <?php include('../includes/tradersidebar.php'); ?>

     <main class="col-12 col-md content-box border me-3 py-4 px-3">
  <div class="mx-auto" style="max-width: 900px;">
        <h3 class="text-center mb-4 fw-bold">Add Product</h3>

        <form action="save_product.php" method="POST" enctype="multipart/form-data">
          <div class="row mb-3 align-items-center">
            <label for="product_name" class="col-md-4 col-form-label fw-semibold">Product Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="product_name" name="product_name" required>
            </div>
          </div>

          <div class="row mb-3 align-items-center">
            <label for="category" class="col-md-4 col-form-label fw-semibold">Category</label>
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

          <div class="row mb-3 align-items-center">
            <label for="description" class="col-md-4 col-form-label fw-semibold">Product Description</label>
            <div class="col-md-8">
              <textarea class="form-control" id="description" name="description" rows="2" required></textarea>
            </div>
          </div>

          <div class="row mb-3 align-items-center">
            <label for="allergy" class="col-md-4 col-form-label fw-semibold">Allergy Information</label>
            <div class="col-md-8">
              <textarea class="form-control" id="allergy" name="allergy" rows="2"></textarea>
            </div>
          </div>

        <!-- Price -->
<div class="row mb-3 align-items-center">
  <label for="price" class="col-md-4 col-form-label fw-semibold">Price (£)</label>
  <div class="col-md-8">
    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Price" required>
  </div>
</div>

<!-- Discount -->
<div class="row mb-3 align-items-center">
  <label for="discount" class="col-md-4 col-form-label fw-semibold">Discount (%)</label>
  <div class="col-md-8">
    <input type="number" step="0.01" class="form-control" id="discount" name="discount" placeholder="Discount (%)">
  </div>
</div>

<!-- Final Price -->
<div class="row mb-3 align-items-center">
  <label for="final_price" class="col-md-4 col-form-label fw-semibold">Final Price (£)</label>
  <div class="col-md-8">
    <input type="number" step="0.01" class="form-control" id="final_price" name="final_price" placeholder="Final Price" readonly>
  </div>
</div>


          <div class="row mb-3 align-items-center">
            <label for="stock" class="col-md-4 col-form-label fw-semibold">Stock Quantity</label>
            <div class="col-md-8">
              <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
          </div>

          <div class="row mb-4 align-items-center">
            <label for="product_image" class="col-md-4 col-form-label fw-semibold">Product Image</label>
            <div class="col-md-8">
              <input type="file" class="form-control" id="product_image" name="product_image" required accept="image/*">
            </div>
          </div>

          <div class="d-flex justify-content-center gap-3">
            <button type="submit" class="btn btn-success px-4">Save Changes</button>
            <a href="../pages/traderaddproduct.php" class="btn btn-primary px-4">Add New Product</a>
          </div>
        </form>
      </div>
    </main>
  </div>
</div>

<?php include('../includes/traderfooter.php'); ?>
