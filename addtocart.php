<?php
session_start();
require 'includes/connect.php';  // make sure this sets $conn correctly

// 1) Must be a logged-in customer
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
    $_SESSION['failmessage'] = "You need to be logged in as a customer.";
    header("Location: login.php");
    exit;
}
$userId = (int)$_SESSION['id'];

// 2) Grab the product ID
if (!isset($_GET['prod']) || !is_numeric($_GET['prod'])) {
    $_SESSION['failmessage'] = "Invalid product ID in URL.";
    header("Location: index.php");
    exit;
}
$prodId = (int)$_GET['prod'];

// 3) Quick stock check (text field)
$res = oci_parse($conn, "SELECT STOCK FROM PRODUCT WHERE PRODUCT_ID = $prodId");
oci_execute($res);
$row = oci_fetch_assoc($res);
if (!$row || strtoupper(trim($row['STOCK'])) === 'OUT OF STOCK') {
    $_SESSION['failmessage'] = "This item is currently out of stock.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

// 4) Check total-cart cap
$res = oci_parse($conn,
    "SELECT NVL(SUM(QUANTITY),0) AS TOTAL
       FROM CART
      WHERE FK1_USER_ID = $userId"
);
oci_execute($res);
$totalInCart = (int)oci_fetch_assoc($res)['TOTAL'];
if ($totalInCart >= 20) {
    $_SESSION['failmessage'] = "Cannot exceed 20 items in your cart.";
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
}

// 5) Insert or update
// see if it’s already in the cart
$res = oci_parse($conn,
    "SELECT ID, QUANTITY
       FROM CART
      WHERE FK1_USER_ID = $userId
        AND FK2_PRODUCT_ID = $prodId"
);
oci_execute($res);

if ($existing = oci_fetch_assoc($res)) {
    // bump quantity
    $cid = (int)$existing['ID'];
    $sql = "UPDATE CART SET QUANTITY = QUANTITY + 1 WHERE ID = $cid";
    $upd = oci_parse($conn, $sql);
    $ok  = oci_execute($upd, OCI_COMMIT_ON_SUCCESS);
    $action = $ok ? "increased" : "failed to increase";
}
else {
    // insert new row (trigger sets ID)
    $sql = "INSERT INTO CART (QUANTITY, FK2_PRODUCT_ID, FK1_USER_ID)
            VALUES (1, $prodId, $userId)";
    $ins = oci_parse($conn, $sql);
    $ok  = oci_execute($ins, OCI_COMMIT_ON_SUCCESS);
    $action = $ok ? "added" : "failed to add";
}

// 6) Debug output
if (!$ok) {
    $e = oci_error($ins ?? $upd);
    $_SESSION['failmessage'] = "DB error: " . $e['message'];
} else {
    $_SESSION['passmessage'] = "Product $action to cart (prodId=$prodId).";
}

// 7) Redirect back
header("Location: cart.php");
exit;
