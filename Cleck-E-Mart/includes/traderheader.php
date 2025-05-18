<?php
session_start();
$traderName = $_SESSION['trader_name'] ?? 'Trader';
?>

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
    <link rel="stylesheet" href="../assets/css/traderheader.css" />
    <link rel="stylesheet" href="../assets/css/trader-style.css" />
</head>
<body>
    <!-- HEADER -->
    <header class="bg-light"style="margin-top: -10px;">
        <div class="container-fluid d-flex align-items-center flex-wrap">
            <img src="../assets/images/2.png" alt="Trader Logo" class="ms-2 " />
            <h2 class="ms-2 mb-0">Trader <br>Center</h2>

         <!-- Breadcrumb Navigation -->
    <nav aria-label="breadcrumb" class="ms-5">
      <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
        
  <a href="../pages/traderdashboard.php" class="text-decoration-none text-dark">Home</a>


        </li>
        <?php
  $pageMap = [
    'traderprofile.php' => 'My Account',
    'traderaddproduct.php' => 'Add Product',
    'traderupdateproduct.php' => 'Update Product',
    'tradermanageproducts.php' => 'Manage Products',
    'tardernotifications.php'=> 'Notifications',
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

  