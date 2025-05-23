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
function isActive($page)
{
    global $currentPage;
    return $currentPage === $page ? 'active' : '';
}
?>

<nav class="col-12 col-md-2 p-3 border sidebar-box pt-0 pb-0">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link text-black <?= isActive('traderprofile.php') ?>" href="traderprofile.php">
                <i class="fas fa-user me-2"></i> My Account
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center text-black <?= $isProductPage ? 'active' : '' ?>"
                data-bs-toggle="collapse" href="#productsMenu" role="button"
                aria-expanded="<?= $isProductPage ? 'true' : 'false' ?>" aria-controls="productsMenu">
                <span><i class="fas fa-box me-2"></i> Manage Products</span>
                <i class="fas fa-chevron-down toggle-icon"></i>
            </a>

            <div class="collapse ps-4 <?= $isProductPage ? 'show' : '' ?>" id="productsMenu">
                <a class="nav-link text-black <?= isActive('traderaddproduct.php') ?>" href="traderaddproduct.php">
                    <i class="fas fa-plus me-2"></i> Add Products
                </a>
                <a class="nav-link text-black <?= isActive('traderupdateproduct.php') ?>" href="traderupdateproduct.php">
                    <i class="fas fa-edit me-2"></i> Update Products
                </a>
                
                <a class="nav-link text-black <?= isActive('trader_delete_products.php') ?>" href="trader_delete_products.php">
                    <i class="fas fa-tasks me-2"></i> Delete Products
                </a>
            </div>
        </li>

        
         <li class="nav-item">
            <a class="nav-link text-black <?= isActive('traderorders.php') ?>" href="traderorders.php">
                <i class="fas fa-shopping-cart me-2"></i> View Orders
            </a>
        </li>
       
        
        <li class="nav-item">
            <a id="logoutSidebarLink" class="nav-link text-black" href="traderlogout.php" >
                <i class="fas fa-sign-out-alt me-2"></i> Logout
            </a>
        </li>

    </ul>
</nav>