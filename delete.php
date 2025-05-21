<?php
session_start();
require 'includes/connect.php';  // adjust path if needed

// 1) Auth guard
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
    $_SESSION['failmessage'] = "You need to be logged in as a customer.";
    header("Location: login.php");
    exit;
}
$userId = (int)$_SESSION['id'];

// 2) Remove a single item?
if (isset($_GET['ID']) && is_numeric($_GET['ID'])) {
    $cid = (int)$_GET['ID'];
    $sql = "DELETE FROM cart WHERE id = $cid AND fk1_user_id = $userId";
    $stm = oci_parse($conn, $sql);
    oci_execute($stm, OCI_COMMIT_ON_SUCCESS);
    $_SESSION['passmessage'] = "Item removed successfully.";
    header("Location: cart.php");
    exit;
}

// 3) Empty the whole cart?
if (isset($_POST['deleteBtn'])) {
    $sql = "DELETE FROM cart WHERE fk1_user_id = $userId";
    $stm = oci_parse($conn, $sql);
    oci_execute($stm, OCI_COMMIT_ON_SUCCESS);
    $_SESSION['passmessage'] = "Cart emptied successfully.";
    header("Location: cart.php");
    exit;
}

// 4) Fallback
header("Location: cart.php");
exit;
