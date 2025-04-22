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
                <li><a class="dropdown-item" href="#">Bakery</a></li>
                <li><a class="dropdown-item" href="#">Delicatessen</a></li>
              </ul>
            </li>
            <li class="nav-item"><a class="nav-link" href="#bestsellers">Best Sellers</a></li>
            <li class="nav-item"><a class="nav-link" href="contactus.php">Contact Us</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Become a Trader</a></li>
          </ul>
        </div>
        <div class="d-flex align-items-center">
          <input class="form-control search-box me-3" type="search" placeholder="Search" />
          <a href="#" class="icon-btn"><i class="fas fa-heart"></i></a>
          <a href="#" class="icon-btn"><i class="fas fa-shopping-cart"></i></a>
          <a href="login.php" class="icon-btn"><i class="fas fa-user"></i></a>
        </div>
      </div>
    </div>
  </nav>
  <!-- NAVBAR END -->