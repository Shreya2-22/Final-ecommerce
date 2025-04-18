<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cleck-E-Mart</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
  <!-- Custom CSS (optional) -->
  <link rel="stylesheet" href="/css/style.css" />

  <style>
    body {
      background-color: #F0F8E0;
      font-family: 'Segoe UI', sans-serif;
    }

    .navbar-brand {
      padding-top: 0 !important;
      padding-bottom: 0 !important;
      margin-top: -5px;
      margin-bottom: -5px;
    }

    .navbar-custom {
      background-color: #D0E8C1;
      font-size: 0.95rem;
      padding-top: 0.2rem !important;
      padding-bottom: 0.2rem !important;
    }

    .navbar-brand img {
      height: 60px;
      width: auto;
      object-fit: contain;
    }

    .navbar-brand span {
      font-weight: 600;
      font-size: 1.2rem;
      margin-left: 8px;
    }

    .nav-link {
      color: #000 !important;
      margin-right: 18px;
      font-weight: 500;
    }

    .nav-link:hover {
      color: #006838 !important;
    }

    .search-box {
      border-radius: 30px;
      padding: 6px 18px;
      width: 260px;
      /* wider search bar */
      border: 1px solid #ccc;
    }

    .icon-btn {
      font-size: 1.2rem;
      color: #000;
      margin-left: 16px;
    }

    .icon-btn:hover {
      color: #006838;
    }

    .dropdown-menu {
      background-color: #D0E8C1 !important;
      border: none;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      /* soft shadow */
    }

    .dropdown-item {
      color: #000 !important;
      font-weight: 500;
    }

    .dropdown-item:hover {
      background-color: #C4DEB2 !important;
      /* a slight green shade on hover */
      color: #006838 !important;
    }
  </style>
</head>

<body>

  <!-- ✅ NAVBAR START -->
  <nav class="navbar navbar-expand-lg navbar-custom py-0 shadow-sm">
    <div class="container-fluid px-4">

      <!-- 🔰 Logo + Brand -->
      <a class="navbar-brand d-flex align-items-center" href="index.php">
        <img src="images/logo.png" alt="Logo" class="logo-img" />
      </a>


      <!-- 📱 Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- 📋 Menu + Search + Icons -->
      <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
        <!-- Nav Links -->
        <!-- Nav Links Shifted Right -->
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


        <!-- Right side: search + icons -->
        <div class="d-flex align-items-center">
          <input class="form-control search-box me-3" type="search" placeholder="Search" />
          <a href="#" class="icon-btn"><i class="fas fa-heart"></i></a>
          <a href="#" class="icon-btn"><i class="fas fa-shopping-cart"></i></a>
          <a href="login.php" class="icon-btn"><i class="fas fa-user"></i></a>
        </div>
      </div>
    </div>
  </nav>
  <!-- ✅ NAVBAR END -->