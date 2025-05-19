<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Trader Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Epilogue:wght@400;700&display=swap" rel="stylesheet" />
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/traderheader.css" />
  <link rel="stylesheet" href="css/trader_style.css" />
</head>

<body>
  <!-- HEADER -->
  <header class="bg-light" style="margin-top: -10px;">
    <div class="container-fluid d-flex align-items-center flex-wrap">
      <img src="images/2.png" alt="Trader Logo" class="ms-2 " />
      <h2 class="ms-2 mb-0">Trader <br>Center</h2>

      <!-- Breadcrumb Navigation -->
      <nav aria-label="breadcrumb" class="ms-5">
        <ol class="breadcrumb mb-0">
          <li class="breadcrumb-item">

            <a href="traderdashboard.php" class="text-decoration-none text-dark">Home</a>


          </li>
          <?php
          $pageMap = [
            'traderprofile.php' => 'My Account',
            'traderaddproduct.php' => 'Add Product',
            'traderupdateproduct.php' => 'Update Product',
            'tradermanageproducts.php' => 'Manage Products',
            'tardernotifications.php' => 'Notifications',
            'tarderorders.php' => 'View Orders',
            'traderproductdetail.php' => 'Product Details'   // Add more mappings as needed
          ];
          $currentPage = basename($_SERVER['PHP_SELF']);
          ?>

          <?php if ($currentPage !== 'traderdashboard.php') { ?>
            <li class="breadcrumb-item active" aria-current="page">
              <?= $pageMap[$currentPage] ?? ucfirst(str_replace('_', ' ', basename($currentPage, '.php'))) ?>
            </li>
          <?php } ?>

        </ol>
      </nav>
    </div>



  </header>

   <?php if (isset($_SESSION['passmessage']) || isset($_SESSION['failmessage'])): ?>
    <div id="alert-wrapper" class="position-relative z-3">
      <div class="container mt-0">
        <div class="alert <?= isset($_SESSION['passmessage']) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show shadow-sm small px-3 py-2 text-center" role="alert" style="margin-bottom: 0;">
          <?= $_SESSION['passmessage'] ?? $_SESSION['failmessage']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      </div>
    </div>
    <?php unset($_SESSION['passmessage'], $_SESSION['failmessage']); ?>
  <?php endif; ?>

  <script>
    // Auto-dismiss after 3 seconds
    document.addEventListener("DOMContentLoaded", () => {
      const alertEl = document.querySelector(".alert");
      if (alertEl) {
        setTimeout(() => {
          const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
          bsAlert.close();
        }, 3000);
      }
    });
  </script>