<?php include('includes/traderheader.php'); ?>

<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">

    <?php include('includes/tradersidebar.php'); ?>

    <?php
      // Simulated trader data – replace with actual DB data
      $trader = [
        'fullname' => 'John Doe',
        'email' => 'john@example.com',
        'phone' => '9876543210',
        'trader_id' => 'T123456',
        'shop_name' => 'Doe Mart',
        'profile_image' => null  // Replace with actual image path if uploaded
      ];

      $defaultImage = '<i class="fas fa-user-circle fa-7x text-secondary"></i>';
    ?>

   <main class="col-12 col-md content-box border me-3 py-4 px-3">
  <div class="mx-auto" style="max-width: 600px;">

        <h3 class="text-center mb-4 fw-bold">Profile Settings</h3>

        <!-- Profile Image Upload -->
        <div class="d-flex flex-column align-items-center mb-4">
          <?php if (!empty($trader['profile_image'])): ?>
            <img src="<?php echo $trader['profile_image']; ?>" alt="Profile Image" class="rounded-circle mb-2" style="width: 120px; height: 120px; object-fit: cover;">
          <?php else: ?>
            <?php echo $defaultImage; ?>
          <?php endif; ?>
          
          <form action="upload_photo.php" method="POST" enctype="multipart/form-data" class="mt-2">
            <input type="file" name="profile_image" class="form-control w-auto mb-2" required>
            <button type="submit" class="btn btn-outline-primary btn-sm">Upload Photo</button>
          </form>
        </div>

        <!-- Profile Form -->
        <form action="update_profile.php" method="POST">
          <div class="row mb-3 align-items-center">
            <label for="fullname" class="col-md-4 col-form-label fw-semibold">Full Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="fullname" name="fullname" value="<?php echo $trader['fullname']; ?>" required>
            </div>
          </div>

          <div class="row mb-3 align-items-center">
            <label for="email" class="col-md-4 col-form-label fw-semibold">Email</label>
            <div class="col-md-8">
              <input type="email" class="form-control" id="email" name="email" value="<?php echo $trader['email']; ?>" required>
            </div>
          </div>

          <div class="row mb-3 align-items-center">
            <label for="phone" class="col-md-4 col-form-label fw-semibold">Phone Number</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $trader['phone']; ?>" required>
            </div>
          </div>

          <div class="row mb-3 align-items-center">
            <label for="trader_id" class="col-md-4 col-form-label fw-semibold">Trader ID</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="trader_id" name="trader_id" value="<?php echo $trader['trader_id']; ?>" readonly>
            </div>
          </div>

          <div class="row mb-4 align-items-center">
            <label for="shop_name" class="col-md-4 col-form-label fw-semibold">Shop Name</label>
            <div class="col-md-8">
              <input type="text" class="form-control" id="shop_name" name="shop_name" value="<?php echo $trader['shop_name']; ?>" required>
            </div>
          </div>

          <!-- Buttons -->
          <div class="d-flex justify-content-center gap-3">
            <button type="submit" class="btn btn-success px-4">Save Changes</button>
            <button type="reset" class="btn btn-secondary px-4">Reset</button>
          </div>
        </form>
      </div>
    </main>
  </div>
</div>
<?php include('includes/traderfooter.php'); ?>
