<?php
// includes/header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($pageTitle ?? "Cleck-E-Mart") ?></title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- Your custom styles -->
  <link rel="stylesheet" href="css/header_footer.css" />
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-custom py-0 shadow-sm">
    <div class="container-fluid px-4">
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="images/logo.png" alt="Logo" class="logo-img" />
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <ul class="navbar-nav mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" href="<?= (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? 'manageTrader.php' : 'index.php' ?>">
              <?= (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') ? 'Manage Trader' : 'Home' ?>
            </a>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              All Categories
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="product.php?catg=143">Greengrocer</a></li>
              <li><a class="dropdown-item" href="product.php?catg=145">Butcher</a></li>
              <li><a class="dropdown-item" href="product.php?catg=142">Fishmonger</a></li>
              <li><a class="dropdown-item" href="product.php?catg=141">Bakery</a></li>
              <li><a class="dropdown-item" href="product.php?catg=144">Delicatessen</a></li>
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

        <div class="d-flex align-items-center">
          <!-- Search -->
          <form action="product.php" method="get" class="me-3">
            <div class="input-group">
              <span class="input-group-text bg-white border-end-0">
                <i class="fas fa-search text-muted"></i>
              </span>
              <input
                type="search" name="search"
                class="form-control border-start-0 search-box"
                placeholder="Search by product, shop, price…"
                value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
              />
            </div>
          </form>

          <!-- Icons logic -->
          <?php if (isset($_SESSION['id']) && $_SESSION['role'] === 'customer'): ?>
            <a href="wishlist.php" class="icon-btn"><i class="fas fa-heart"></i></a>
            <a href="cart.php" class="icon-btn"><i class="fas fa-shopping-cart"></i></a>
            <div class="dropdown">
              <a class="icon-btn dropdown-toggle" href="#" role="button" id="profileMenu" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-user-circle"></i>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileMenu">
                <li><a class="dropdown-item" href="customer_profile_setting.php"><i class="fas fa-user-cog me-2"></i>Profile Settings</a></li>
                <li><a class="dropdown-item" href="myorder.php"><i class="fas fa-box me-2"></i>My Orders</a></li>
                <li><a class="dropdown-item" href="reviews.php"><i class="fas fa-star me-2"></i>My Reviews</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i>Logout</a></li>
              </ul>
            </div>

          <?php elseif (isset($_SESSION['id']) && $_SESSION['role'] === 'trader'): ?>
            <a href="cart.php" class="icon-btn"><i class="fas fa-shopping-cart"></i></a>
            <a href="logout.php" class="icon-btn text-black"><i class="fas fa-sign-out-alt"></i></a>

          <?php elseif (isset($_SESSION['id']) && $_SESSION['role'] === 'admin'): ?>
            <a href="logout.php" class="icon-btn text-black"><i class="fas fa-sign-out-alt"></i></a>

          <?php else: ?>
            <a href="login.php" class="icon-btn" title="Login required"><i class="fas fa-heart"></i></a>
            <a href="cart.php" class="icon-btn"><i class="fas fa-shopping-cart"></i></a>
            <a href="login.php" class="icon-btn"><i class="fas fa-user"></i></a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <!-- Flash messages -->
  <?php if (!empty($_SESSION['passmessage']) || !empty($_SESSION['failmessage'])): ?>
    <div class="position-relative z-3">
      <div class="container mt-2">
        <div class="alert <?= isset($_SESSION['passmessage']) ? 'alert-success' : 'alert-danger' ?> alert-dismissible fade show" role="alert" id="alert-box">
          <?= $_SESSION['passmessage'] ?? $_SESSION['failmessage']; ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      </div>
    </div>
    <script>
      setTimeout(() => {
        const alertEl = document.getElementById('alert-box');
        if (alertEl) bootstrap.Alert.getOrCreateInstance(alertEl).close();
      }, 3000);
    </script>
    <?php unset($_SESSION['passmessage'], $_SESSION['failmessage']); ?>
  <?php endif; ?>
