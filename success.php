<?php
session_start();
require_once "includes/connect.php";

// 1) Guard
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
    header("Location: index.php");
    exit;
}
$userId    = (int)$_SESSION['id'];
$orderID   = $_GET['orderID'] ?? null;
if (!$orderID) {
    header("Location: index.php");
    exit;
}

// 2) Pull slot & amounts from session
$week     = $_SESSION['chooseweek']  ?? '';
$day      = $_SESSION['chooseday']   ?? 0;
$time     = $_SESSION['choosetime']  ?? 0;
$total    = $_SESSION['grandTotal']  ?? 0.0;
$discount = $_SESSION['discount']    ?? 0.0;

// 3) Insert into ORDERS
// Oracle DATE from PHP: use TO_DATE on SYSDATE or pass from PHP
$ordersSql = "
  INSERT INTO ORDERS
    (ORDER_ID, COLLECTION_WEEK, COLLECTION_DAY, COLLECTION_TIME,
     PAYMENT, DISCOUNT, ORDER_DATE, FK1_USER_ID)
  VALUES
    ('$orderID', '$week', $day, $time,
     $total, $discount, SYSDATE, $userId)";
$stm = oci_parse($conn, $ordersSql);
oci_execute($stm, OCI_COMMIT_ON_SUCCESS);

// 4) Move each cart row into ORDER_PRODUCT
$cartSql = "SELECT * FROM CART WHERE FK1_USER_ID = $userId";
$cartStm = oci_parse($conn, $cartSql);
oci_execute($cartStm);
while ($c = oci_fetch_assoc($cartStm)) {
    $qty   = (int)$c['QUANTITY'];
    $pid   = (int)$c['FK2_PRODUCT_ID'];

    // fetch product name & price
    $pstm = oci_parse($conn, "SELECT PRODUCT_NAME, PRODUCT_PRICE FROM PRODUCT WHERE PRODUCT_ID = $pid");
    oci_execute($pstm);
    $p = oci_fetch_assoc($pstm);

    $name  = addslashes($p['PRODUCT_NAME']);
    $price = (float)$p['PRODUCT_PRICE'];

    $opSql = "
      INSERT INTO ORDER_PRODUCT
        (QUANTITY, PRODUCT_NAME, PRODUCT_PRICE, FK1_ORDER_ID, FK2_PRODUCT_ID)
      VALUES
        ($qty, '$name', $price, '$orderID', $pid)";
    $opStm = oci_parse($conn, $opSql);
    oci_execute($opStm, OCI_COMMIT_ON_SUCCESS);
}

// 5) Empty the cart
$empty = oci_parse($conn, "DELETE FROM CART WHERE FK1_USER_ID = $userId");
oci_execute($empty, OCI_COMMIT_ON_SUCCESS);

// 6) Clear session values
unset($_SESSION['grandTotal'], $_SESSION['discount'],
      $_SESSION['chooseweek'], $_SESSION['chooseday'], $_SESSION['choosetime']);

// 7) Redirect to invoice
header("Location: invoice.php?id=" . urlencode($orderID));
exit;
