<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cleck-E-Mart</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/header_footer.css" />
</head>

<body>
  <!-- NAVBAR -->
  <nav class="navbar navbar-expand-lg navbar-custom py-0 shadow-sm">
    <div class="container-fluid px-4">

      <!-- Logo -->
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="images/logo.png" alt="Logo" class="logo-img" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <div class="ms-3">
          <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                All Categories
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Greengrocer</a></li>
                <li><a class="dropdown-item" href="#">Butcher</a></li>
                <li><a class="dropdown-item" href="#">Fishmonger</a></li>
                <li><a class="dropdown-item" href="bakery.php">Bakery</a></li>
                <li><a class="dropdown-item" href="#">Delicatessen</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="index.php#bestsellers">Best Sellers</a></li>
            <li class="nav-item"><a class="nav-link" href="contactus.php">Contact Us</a></li>
            <?php if (!isset($_SESSION['id'])): ?>
              <li class="nav-item">
                <a class="nav-link" href="switch_to_trader.php">Become a Trader</a>
              </li>
            <?php endif; ?>

          </ul>
        </div>
        <div class="d-flex align-items-center">
          <input class="form-control search-box me-3" type="search" placeholder="Search" />
          <?php
          if (session_status() == PHP_SESSION_NONE) {
            session_start();
          }
          if (isset($_SESSION['id']) && $_SESSION['role'] == 'customer') {
            echo '<a href="wishlist.php" class="icon-btn"><i class="fas fa-heart"></i></a>';
          } else {
            echo '<a href="login.php" class="icon-btn" title="Login required"><i class="fas fa-heart"></i></a>';
          }
          ?>
          <a href="cart.php" class="icon-btn"><i class="fas fa-shopping-cart"></i></a>
          <?php if (isset($_SESSION['id'])): ?>
            <a href="logout.php" class="icon-btn"><i class="fas fa-sign-out-alt"></i></a>
          <?php else: ?>
            <a href="login.php" class="icon-btn"><i class="fas fa-user"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
  <!-- NAVBAR END -->
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