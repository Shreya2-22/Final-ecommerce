<?php
session_start();
require_once "includes/connect.php";

// 1) Guard & get order ID
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer' || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}
$userId  = (int)$_SESSION['id'];
$orderID = $_GET['id'];

// 2) Fetch order header
$sql = "
  SELECT COLLECTION_WEEK, COLLECTION_DAY, COLLECTION_TIME,
         PAYMENT, DISCOUNT, TO_CHAR(ORDER_DATE,'DD-MM-YYYY HH24:MI:SS') AS ODATE
    FROM ORDERS
   WHERE ORDER_ID = '$orderID'
     AND FK1_USER_ID = $userId";
$stm = oci_parse($conn, $sql);
oci_execute($stm);
$order = oci_fetch_assoc($stm);
if (!$order) {
    header("Location: index.php");
    exit;
}

// 3) Fetch order products
$items = [];
$prodSql = "
  SELECT PRODUCT_NAME, PRODUCT_PRICE, QUANTITY
    FROM ORDER_PRODUCT
   WHERE FK1_ORDER_ID = '$orderID'";
$prm = oci_parse($conn, $prodSql);
oci_execute($prm);
while ($r = oci_fetch_assoc($prm)) {
    $r['SUBTOTAL'] = $r['PRODUCT_PRICE'] * $r['QUANTITY'];
    $items[]       = $r;
}

// 4) Compute totals
$total = array_sum(array_column($items, 'SUBTOTAL'));
$discount = (float)$order['DISCOUNT'];
$grand   = $total - $discount;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Invoice <?= htmlspecialchars($orderID) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Ubuntu&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/invoice.css">
</head>
<body>
  <div class="main_container">
    <div class="header_container">
      <div class="logo">
        <img src="images/logo.png" alt="Logo" width="100">
      </div>
      <div class="invoice_1">
        <h3>INVOICE</h3>
        <span>No: <?= htmlspecialchars($orderID) ?></span>
      </div>
    </div>

    <div class="customer_details">
      <span><?= htmlspecialchars($_SESSION['username'] ?? 'Customer') ?></span>
      <span>Date Issued: <?= $order['ODATE'] ?></span>
      <span>Collection: <?= htmlspecialchars($order['COLLECTION_DAY']) ?>,
        <?= htmlspecialchars($order['COLLECTION_TIME']) ?>h (<?= htmlspecialchars($order['COLLECTION_WEEK']) ?>)
      </span>
    </div>

    <div class="invoice_table">
      <table>
        <thead>
          <tr>
            <th>ITEMS</th>
            <th>PRICE</th>
            <th>QUANTITY</th>
            <th>SUBTOTAL</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $it): ?>
            <tr>
              <td><?= htmlspecialchars($it['PRODUCT_NAME']) ?></td>
              <td>£<?= number_format($it['PRODUCT_PRICE'],2) ?></td>
              <td><?= $it['QUANTITY'] ?></td>
              <td>£<?= number_format($it['SUBTOTAL'],2) ?></td>
            </tr>
          <?php endforeach; ?>
          <tr class="totals">
            <td colspan="2"></td>
            <td><strong>Total:</strong></td>
            <td>£<?= number_format($total,2) ?></td>
          </tr>
          <tr class="totals">
            <td colspan="2"></td>
            <td><strong>Discount:</strong></td>
            <td>£<?= number_format($discount,2) ?></td>
          </tr>
          <tr class="grand">
            <td colspan="2"></td>
            <td><strong>Grand Total:</strong></td>
            <td>£<?= number_format($grand,2) ?></td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="footer_container">
      <div>
        <b>PAYMENT GATEWAY</b>
        <img src="images/PayPal.png" alt="PayPal" width="80">
        <span>Verified <i class="fa fa-check-circle" style="color:#4caf50"></i></span>
      </div>
    </div>
  </div>
</body>
</html>
