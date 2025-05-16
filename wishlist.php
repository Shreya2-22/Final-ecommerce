<?php
session_start();
include "includes/connect.php";
include "includes/header.php";
?>

<style type="text/css">
    .wishlist-table {
        background-color: #fff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(191, 223, 60, 0.1);
        margin-bottom: 80px;
    }

    .wishlist-table th {
        background-color: rgb(193, 177, 119);
        color: white;
        text-align: center;
        font-weight: 600;
        vertical-align: middle;
    }

    .wishlist-table td {
        background-color: #f9f9f9;
        text-align: center;
        vertical-align: middle;
    }

    .wishlist-table img {
        width: 80px;
        border-radius: 8px;
    }

    .btn-addcart {
        background-color: #C49A6C;
        color: white;
        font-size: 0.85rem;
        padding: 5px 12px;
        border-radius: 8px;
    }

    .btn-addcart:hover {
        background-color: #a88052;
    }

    .btn-delete {
        background-color: #dc3545;
        color: white;
        font-size: 0.85rem;
        padding: 5px 10px;
        border-radius: 8px;
    }

    .btn-delete:hover {
        background-color: #b52a38;
    }

    .wishlist-title {
        color: #2e5f2e;
        font-weight: bold;
    }

    hr.head1 {
        border-top: 4px solid #343A40;
        width: 10%;
        border-radius: 2px;
    }

    #wishlist-margin {
        margin-top: 30px;
        margin-bottom: 10px;
    }

    #wishlist-container {
        margin-bottom: 100px;
    }

    th,
    td {
        font-size: 18px;
    }

    @media screen and (max-width: 768px) {

        th,
        td {
            font-size: 14px;
        }
    }

    @media screen and (max-width: 450px) {

        th,
        td {
            font-size: 12px;
        }
    }
</style>

<div class="container" id="wishlist-margin">
    <div class="row">
        <div class="col-12 text-center">
            <h1 class="display-8 fw-bold text-success">My Wishlist</h1>
            <hr class="head1 mx-auto">
        </div>
    </div>
</div>

<div class="container" id="wishlist-container" style="min-height: 40vh;">
    <div class="table-responsive">
        <table class="table wishlist-table">
            <thead class="table-dark text-center">
                <tr>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_wishlist = "SELECT * FROM WISHLIST WHERE FK2_USER_ID =" . $_SESSION['id'];
                $wishlist_result = oci_parse($conn, $select_wishlist);
                oci_execute($wishlist_result);

                while ($row = oci_fetch_assoc($wishlist_result)) {
                    $select_product = "SELECT P.*, S.SHOP_NAME FROM PRODUCT P JOIN SHOP S ON P.FK1_SHOP_ID = S.SHOP_ID WHERE P.PRODUCT_ID = " . $row['FK1_PRODUCT_ID'];
                    $product_result = oci_parse($conn, $select_product);
                    oci_execute($product_result);
                    $prodrow = oci_fetch_assoc($product_result);
                    $shopname = $prodrow['SHOP_NAME'];
                ?>
                    <tr class="text-center">
                        <td>
                            <a href="productdescription.php?id=<?php echo $prodrow['PRODUCT_ID'] ?>">
                                <img src="images/product_images/<?php echo $prodrow['PRODUCT_IMAGE']; ?>" style="width: 80px; border-radius: 10px;" alt="Product">
                            </a>
                        </td>
                        <td>
                            <div class="fw-semibold"><?php echo ucwords($prodrow['PRODUCT_NAME']); ?></div>
                            <div class="text-muted" style="font-size: 0.85rem;">From: <?php echo $shopname; ?></div>
                        </td>
                        <td>£ <?php echo $prodrow['PRODUCT_PRICE']; ?></td>
                        <td><?php echo $prodrow['STOCK']; ?></td>

                        <td>
                            <a href="addtocart.php?prod=<?php echo $prodrow['PRODUCT_ID']; ?>" class="btn btn-addcart me-2">Add to Cart</a>
                            <a href="delete_wishlist.php?id=<?php echo $prodrow['PRODUCT_ID']; ?>" class="btn btn-delete" onclick="return confirm('Remove from wishlist?')">
                                <i class="fa-solid fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>





<?php
include "includes/footer.php";
clearMsg();
?>