<?php include('../includes/traderheader.php'); ?>

<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">
    <?php include('../includes/tradersidebar.php'); ?>

    <main class="col-12 col-md content-box border me-3 py-4 px-4">
      <div class="mx-auto" style="max-width: 800px;">
        <?php
        $category = $_GET['category'] ?? '';
        $product_name = $_GET['product_name'] ?? '';

        $product = [
          'description' => 'Fresh local apples.',
          'allergy' => 'None',
          'price' => 3.99,
          'discount' => 10,
          'final_price' => 3.59,
          'stock' => 100,
          'image' => '../images/products/apple.jpg'
        ];
        ?>

        <form action="save_updated_product.php" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="category" value="<?php echo htmlspecialchars($category); ?>">
          <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">

          <!-- Non-editable Info Box -->
          <div class="border rounded p-3 mb-4">
            <div class="row mb-3 align-items-center">
              <label class="col-md-4 col-form-label fw-semibold">Category</label>
              <div class="col-md-8">
                <input type="text" class="form-control" readonly value="<?php echo htmlspecialchars($category); ?>">
              </div>
            </div>
            <div class="row mb-3 align-items-center">
              <label class="col-md-4 col-form-label fw-semibold">Product Name</label>
              <div class="col-md-8">
                <input type="text" class="form-control" readonly value="<?php echo htmlspecialchars($product_name); ?>">
              </div>
            </div>
    

          <!-- Editable Info -->
          <div class="row mb-3 align-items-center">
            <label for="description" class="col-md-4 col-form-label fw-semibold">Product Description</label>
            <div class="col-md-8">
              <textarea class="form-control" id="description" name="description" rows="2"><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
          </div>

          <div class="row mb-3 align-items-center">
            <label for="allergy" class="col-md-4 col-form-label fw-semibold">Allergy Information</label>
            <div class="col-md-8">
              <textarea class="form-control" id="allergy" name="allergy" rows="2"><?php echo htmlspecialchars($product['allergy']); ?></textarea>
            </div>
          </div>

          <!-- Price and Stock Box -->
    
            <div class="row mb-3 align-items-center">
              <label class="col-md-4 col-form-label fw-semibold">Price (£)</label>
              <div class="col-md-8">
                  <input type="number" step="0.01" class="form-control" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" required>
                </div>
    </div>
    <div class="row mb-3 align-items-center">
  <label for="discount" class="col-md-4 col-form-label fw-semibold">Discount (%)</label>
                <div class="col-md-8">
                  <input type="number" step="0.01" class="form-control" name="discount" value="<?php echo htmlspecialchars($product['discount']); ?>" placeholder="Discount (%)">
                </div>
    </div>
    <div class="row mb-3 align-items-center">
  <label for="discount" class="col-md-4 col-form-label fw-semibold">Discount (%)</label>
                <div class="col-md-8">
                  <input type="number" step="0.01" class="form-control" name="final_price" value="<?php echo htmlspecialchars($product['final_price']); ?>" readonly>
                </div>
              </div>
        
            <div class="row mb-0 align-items-center">
              <label for="stock" class="col-md-4 col-form-label fw-semibold">Stock Quantity</label>
              <div class="col-md-8">
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($product['stock']); ?>" required>
              </div>
            </div>
        

          <!-- Image Section -->
          <div class="row mb-2 mt-3 align-items-center">
            <label class="col-md-4 col-form-label fw-semibold">Product Image</label>
            <div class="col-md-8 d-flex align-items-center gap-4">
              <div class="text-center">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="Current Image" class="rounded-circle border" style="width: 100px; height: 100px; object-fit: cover;">
                <div class="small mt-2">Current</div>
              </div>
              <div class="text-center">
                <label for="product_image" class="d-block">
                  <div class="rounded-circle bg-light border d-flex justify-content-center align-items-center" style="width: 100px; height: 100px; cursor: pointer;">
                    <i class="fas fa-plus fa-2x text-secondary"></i>
                  </div>
                </label>
                <input type="file" accept="image/*" class="d-none" id="product_image" name="product_image">
                <div class="small mt-2">Change</div>
              </div>
            </div>
          </div>

          <!-- Submit Button -->
          <div class="d-flex justify-content-between mt-4">
  <a href="traderupdateproduct.php" class="btn btn-secondary px-4">Back</a>
  
  <?php if ($saved): ?>
    <button type="button" class="btn btn-success px-4" disabled>Saved</button>
  <?php else: ?>
    <button type="submit" class="btn btn-success px-4">Save Changes</button>
  <?php endif; ?>
</div>
        </form>
      </div>
    </main>
  </div>
</div>

<?php include('../includes/traderfooter.php'); ?>
