<?php
session_start();
include "includes/connect.php";
include "includes/header.php";
?>

<style type="text/css">
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
        margin-bottom: 80px;
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

        @media screen and (max-width: 450px) {

            th,
            td {
                font-size: 12px;
            }
</style>

<div class="container" id="wishlist-margin">
    <div class="row">
        <div class="col-12 text-center">
            <h1>My Wishlist</h1>
            <hr class="head1">
        </div>
    </div>
</div>

<div class="container" id="wishlist-container">
    <table class="table table-striped table-dark">
        <thead>
            <tr>
                <th scope="col">Image</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Stock</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $select_wishlist = "SELECT * FROM WISHLIST WHERE FK2_USER_ID =" . $_SESSION['id'];
            $wishlist_result = oci_parse($conn, $select_wishlist);
            oci_execute($wishlist_result);


            while ($row = oci_fetch_assoc($wishlist_result)) {
                $select_product = "SELECT * FROM PRODUCT WHERE PRODUCT_ID=" . $row['FK1_PRODUCT_ID'];
                //echo $select_product;
                $product_result = oci_parse($conn, $select_product);
                oci_execute($product_result);
                $prodrow = oci_fetch_assoc($product_result);
            ?>

                <tr>
                    <th scope="row"><a href="productdescription.php?id=<?php echo $prodrow['PRODUCT_ID'] ?>"><img src="images/product_images/<?php echo $prodrow['PRODUCT_IMAGE']; ?>" style="width: 80px; border-radius: 10px;"></a></th>
                    <td style="vertical-align: middle;"><?php echo ucwords($prodrow['PRODUCT_NAME']); ?></td>
                    <td style="vertical-align: middle;">£ <?php echo $prodrow['PRODUCT_PRICE']; ?></td>
                    <td style="vertical-align: middle;"><?php echo $prodrow['STOCK']; ?></td>
                    <td style="vertical-align: middle;"><a href="delete_wishlist.php?id=<?php echo $prodrow['PRODUCT_ID']; ?>" onclick="return confirm('Are you sure you want to remove this item from wishlist?')"><i class="fa-solid fa-trash text-white"></i></a></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>




<?php
include "includes/footer.php";
clearMsg();
?>