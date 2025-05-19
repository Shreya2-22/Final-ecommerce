<?php include ('../includes/traderheader.php'); ?>

<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">
    <?php include ('../includes/tradersidebar.php'); ?>

    <main class="col-12 col-md px-md-3 py-4 border content-box pt-0 pb-0 me-3">
      <div class="container text-center">
        <h3 class="fw-bold mb-4 mt-5">Welcome Back, <?php echo htmlspecialchars($traderName); ?> 👋</h3>

        <!-- Dashboard Cards -->
        <div class="row g-4 justify-content-center mb-4 mt-2">
          <div class="col-md-4">
            <div class="card border-success shadow-sm h-100">
              <div class="card-body text-center">
                <i class="fas fa-box fa-2x text-success mb-3"></i>
                <h5 class="card-title fw-bold">Manage Products</h5>
                <p class="card-text">Add, update, or remove your products.</p>
                <a href="tradermanageproducts.php" class="btn btn-outline-success">Manage</a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card border-primary shadow-sm h-100">
              <div class="card-body text-center">
                <i class="fas fa-shopping-basket fa-2x text-primary mb-3"></i>
                <h5 class="card-title fw-bold">Orders</h5>
                <p class="card-text">View and process customer orders.</p>
                <a href="traderorders.php" class="btn btn-outline-primary">View Orders</a>
              </div>
            </div>
          </div>

          <div class="col-md-4">
            <div class="card border-warning shadow-sm h-100">
              <div class="card-body text-center">
                <i class="fas fa-bell fa-2x text-warning mb-3"></i>
                <h5 class="card-title fw-bold">Notifications</h5>
                <p class="card-text">Check stock alerts or system notices.</p>
                <a href="tradernotifications.php" class="btn btn-outline-warning">Notifications</a>
              </div>
            </div>
          </div>
        </div>

        <!-- Optional Summary -->
        <div class="row justify-content-center mt-5">
          <div class="col-md-10">
            <div class="alert alert-info text-start">
              <strong>Quick Tip:</strong> Keep your product stock updated and respond to orders promptly to ensure great customer satisfaction!
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</div>

<?php include ('../includes/traderfooter.php'); ?>
