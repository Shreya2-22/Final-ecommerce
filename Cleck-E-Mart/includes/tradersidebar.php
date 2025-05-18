<?php
$currentPage = basename($_SERVER['PHP_SELF']);
$productPages = [
    'traderaddproduct.php',
    'traderupdateproduct.php',
    'traderproductdetail.php',
    'tradermanageproducts.php',
    'traderproductdetailform.php',
    'traderupdateproductform.php'
];
$isProductPage = in_array($currentPage, $productPages);

// Reusable helper to set 'active' class
function isActive($page) {
    global $currentPage;
    return $currentPage === $page ? 'active' : '';
}
?>

<nav class="col-12 col-md-2 p-3 border sidebar-box pt-0 pb-0">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-black <?= isActive('traderprofile.php') ?>" href="../pages/traderprofile.php">
                <i class="fas fa-user me-2"></i> My Account
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center text-black <?= $isProductPage ? 'active' : '' ?>"
               data-bs-toggle="collapse" href="#productsMenu" role="button"
               aria-expanded="<?= $isProductPage ? 'true' : 'false' ?>" aria-controls="productsMenu">
                <span><i class="fas fa-box me-2"></i> Products</span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </a>

            <div class="collapse ps-4 <?= $isProductPage ? 'show' : '' ?>" id="productsMenu">
                <a class="nav-link text-black <?= isActive('traderaddproduct.php') ?>" href="../pages/traderaddproduct.php">
                    <i class="fas fa-plus me-2"></i> Add Products
                </a>
                <a class="nav-link text-black <?= isActive('traderupdateproduct.php') ?>" href="../pages/traderupdateproduct.php">
                    <i class="fas fa-edit me-2"></i> Update Products
                </a>
                <a class="nav-link text-black <?= isActive('traderproductdetail.php') ?>" href="../pages/traderproductdetail.php">
                    <i class="fas fa-info-circle me-2"></i> Product Details
                </a>
                <a class="nav-link text-black <?= isActive('tradermanageproducts.php') ?>" href="../pages/tradermanageproducts.php">
                    <i class="fas fa-tasks me-2"></i> Manage Products
                </a>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link text-black <?= isActive('traderorders.php') ?>" href="../pages/traderorders.php">
                <i class="fas fa-shopping-cart me-2"></i> View Orders
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-black <?= isActive('tradernotifications.php') ?>" href="../pages/tradernotifications.php">
                <i class="fas fa-bell me-2"></i> Notifications
            </a>
        </li>
        <li class="nav-item">
           <a href="#" class="nav-link text-black" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
  <i class="fas fa-key me-2"></i> Change Password
</a>
        </li>
        <li class="nav-item">
  <a id="logoutSidebarLink" class="nav-link text-black" href="#" data-bs-toggle="modal" data-bs-target="#logoutModal">
    <i class="fas fa-sign-out-alt me-2"></i> Logout
  </a>
</li>

    </ul>
</nav>
