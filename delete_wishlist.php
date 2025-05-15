<?php
include "includes/connect.php";
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $delete_wishlist = "DELETE FROM WISHLIST WHERE FK1_PRODUCT_ID = $id AND FK2_USER_ID =" . $_SESSION['id'];
    $delete_result = oci_parse($conn, $delete_wishlist);
    oci_execute($delete_result);
    header("Location: " . $_SERVER["HTTP_REFERER"]);
    $_SESSION['passmessage'] = "item removed from wishlist";
}
