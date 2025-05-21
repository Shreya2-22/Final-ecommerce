<?php
session_start();
require 'includes/connect.php';  // adjust path if needed

// 1) Auth guard (optional—you might allow guests)
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
    $_SESSION['failmessage'] = "You need to be logged in as a customer.";
    header("Location: cart.php");
    exit;
}

if (!isset($_POST['coupon']) || trim($_POST['coupon']) === '') {
    $_SESSION['failmessage'] = "Please enter a coupon code.";
    header("Location: cart.php");
    exit;
}

$code = strtoupper(trim($_POST['coupon']));

// 2) Look up the voucher
$sql = "
  SELECT discount, valid_till
    FROM voucher
   WHERE UPPER(code) = '$code'
";
$stm = oci_parse($conn, $sql);
oci_execute($stm);
$v = oci_fetch_assoc($stm);

if (!$v) {
    $_SESSION['failmessage'] = "Invalid coupon code.";
    header("Location: cart.php");
    exit;
}

// 3) Check expiration
// Oracle DATE comes back as string in NLS format; compare in SQL for reliability:
$todayCheck = oci_parse($conn,
    "SELECT 1 
       FROM voucher 
      WHERE UPPER(code) = '$code' 
        AND valid_till >= TRUNC(SYSDATE)"
);
oci_execute($todayCheck);
if (!oci_fetch($todayCheck)) {
    $_SESSION['failmessage'] = "This coupon has expired.";
    header("Location: cart.php");
    exit;
}

// 4) Apply discount
$_SESSION['discount']    = (float)$v['DISCOUNT'];
$_SESSION['passmessage'] = "Coupon applied: £" . number_format($_SESSION['discount'],2) . " off.";

header("Location: cart.php");
exit;
