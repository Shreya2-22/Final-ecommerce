<?php include('includes/traderheader.php'); ?>
<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'trader') {
  $_SESSION['failmessage'] = "❌ You need to log out as a customer before accessing the trader dashboard.";
  header("Location: login.php");
  exit();
}
?>
<?php if (isset($_SESSION['passmessage'])): ?>
        <div class="alert alert-success text-center">
          <?= $_SESSION['passmessage']; ?>
          <?php unset($_SESSION['passmessage']); ?>
        </div>
      <?php endif; ?>
      <?php if (isset($_SESSION['failmessage'])): ?>
        <div class="alert alert-danger text-center">
          <?= $_SESSION['failmessage']; ?>
          <?php unset($_SESSION['failmessage']); ?>
        </div>
      <?php endif; ?>


<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">

    <?php include('includes/tradersidebar.php'); ?>

    <main class="col-12 col-md px-md-3 py-4 border content-box pt-0 pb-0 me-3 d-flex justify-content-center align-items-center">
      

      <div class="text-center">
        <h3 class="fw-bold mb-3">Welcome, <?= htmlspecialchars($_SESSION['username']); ?> 👋</h3>


        <div class="display-1 mb-3">📦</div> <!-- Big box icon -->


        <div class="mt-4">
          <a href="traderaddproduct.php" class="btn btn-success px-4 py-2 fw-bold">
            Add Product
          </a>
        </div>



      </div>
    </main>
  </div>
</div>
<script>
  setTimeout(() => {
    const alert = document.querySelector('.alert');
    if (alert) alert.style.display = 'none';
  }, 3000);
</script>


<?php include('includes/traderfooter.php'); ?>