<?php
// myorder.php
session_start();
require 'includes/connect.php';

if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
    header('Location: login.php');
    exit;
}
$userId = (int)$_SESSION['id'];

// fetch orders (inline $userId so no binding errors)
$sql = "
  SELECT ORDER_ID,
         ORDER_DATE,
         COLLECTION_DAY,
         COLLECTION_TIME
    FROM ORDERS
   WHERE FK1_USER_ID = {$userId}
ORDER BY ORDER_DATE DESC
";
$stm = oci_parse($conn, $sql);
oci_execute($stm);

$orders = [];
while ($row = oci_fetch_assoc($stm)) {
    $orders[] = $row;
}

include 'includes/header.php';
?>
<div class="container py-5">
  <h2 class="mb-4">My Orders</h2>
  <?php if (empty($orders)): ?>
    <div class="alert alert-info">You have not placed any orders yet.</div>
  <?php else: ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Order ID</th>
            <th>Date</th>
            <th>Slot</th>
            <th>Receipt</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $i => $o):
            // Oracle returns ORDER_DATE as "DD-MON-YY HH.MI.SS.FF AM"
            $dt = explode(' ', $o['ORDER_DATE'])[0];
          ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($o['ORDER_ID']) ?></td>
              <td><?= htmlspecialchars($dt) ?></td>
              <td>
                <?= htmlspecialchars($o['COLLECTION_DAY']) ?><br>
                <?= htmlspecialchars($o['COLLECTION_TIME']) ?>
              </td>
              <td>
                <a href="invoice.php?id=<?= urlencode($o['ORDER_ID']) ?>"
                   class="btn btn-sm btn-outline-secondary" target="_blank">
                  View
                </a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>
<?php include 'includes/footer.php'; clearMsg(); ?>
