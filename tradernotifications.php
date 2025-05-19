<?php include('includes/traderheader.php'); ?>

<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">
    <?php include('includes/tradersidebar.php'); ?>

    <main class="col-12 col-md content-box border me-3 py-4 px-4">
      <div class="mx-auto w-100">
    
        <!-- Dummy Notifications -->
       <?php
$notifications = [
  ['type' => 'New Order', 'message' => 'You received a new order ORD1001.', 'time' => '2025-05-17 10:30', 'is_read' => false],
  ['type' => 'Low Stock', 'message' => 'Product "Milk 1L" is low on stock.', 'time' => '2025-05-16 16:15', 'is_read' => false],
  ['type' => 'Order Delivered', 'message' => 'Order ORD0998 has been marked as Delivered.', 'time' => '2025-05-15 14:00', 'is_read' => true],
  ['type' => 'Review Received', 'message' => 'Customer reviewed your product "Cheddar Cheese".', 'time' => '2025-05-14 18:22', 'is_read' => true],
  ['type' => 'System Notice', 'message' => 'System maintenance scheduled on May 20.', 'time' => '2025-05-14 09:00', 'is_read' => true],
  ['type' => 'New Message', 'message' => 'You have a new message from supplier.', 'time' => '2025-05-13 15:30', 'is_read' => false],
  ['type' => 'Stock Replenished', 'message' => 'Product "Butter 500g" stock replenished.', 'time' => '2025-05-12 11:45', 'is_read' => true],
  ['type' => 'Promotion', 'message' => 'New promotion available on dairy products.', 'time' => '2025-05-11 08:00', 'is_read' => true],
  ['type' => 'Order Cancelled', 'message' => 'Order ORD0987 has been cancelled by customer.', 'time' => '2025-05-10 17:25', 'is_read' => false],
  ['type' => 'System Alert', 'message' => 'Unexpected downtime on May 18.', 'time' => '2025-05-09 21:10', 'is_read' => true],
];
?>
        <div class="list-group border rounded" style="max-height: 600px; overflow-y: auto; background-color: #f8f9fa;">
  <?php foreach ($notifications as $note): ?>
    <div class="list-group-item list-group-item-action border-0 <?= !$note['is_read'] ? 'bg-light' : '' ?>">
      <div class="d-flex w-100 justify-content-between">
        <h6 class="mb-1"><?= htmlspecialchars($note['type']) ?></h6>
        <small class="text-muted"><?= date('d M Y, H:i', strtotime($note['time'])) ?></small>
      </div>
      <p class="mb-1"><?= htmlspecialchars($note['message']) ?></p>
      <?php if (!$note['is_read']): ?>
        <button class="btn btn-sm btn-outline-primary">Mark as Read</button>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>


      </div>
    </main>
  </div>
</div>

<?php include('includes/traderfooter.php'); ?>
