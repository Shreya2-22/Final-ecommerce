<?php include ('../includes/traderheader.php'); ?>

 <div class="container-fluid" style="margin-top: -10px;">
    <div class="row gx-3 ms-2 align-items-start">

<?php include ('../includes/tradersidebar.php');?>

  <main class="col-12 col-md px-md-3 py-4 border content-box pt-0 pb-0 me-3 d-flex justify-content-center align-items-center">
    <div class="text-center">
       <h3 class="fw-bold mb-3">Welcome Trader <?php echo htmlspecialchars($traderName); ?></h3>

        <div class="display-1 mb-3">📦</div> <!-- Big box icon -->
        <p class="fs-5 fw-semibold mb-4">Upload Your First Product</p>
        <form action="traderaddproduct.php" href="../pages/traderaddproduct.php" method="get">
            <button type="submit" class="btn btn-success px-4 py-2 fw-bold">Add Product</button>
        </form>
    </div>
</main>
        </div>
    </div>

  <?php include ('../includes/traderfooter.php'); ?>