<?php include('../includes/traderheader.php'); ?>

<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">
    <?php include('../includes/tradersidebar.php'); ?>

    <main class="col-12 col-md content-box border me-3 py-4 px-4">
      <div class="mx-auto w-100">

        <!-- Search by Order ID -->
        <form method="GET" class="mb-4">
          <div class="input-group">
            <input type="text" class="form-control" name="search_order" placeholder="Search by Order ID" 
              value="<?= isset($_GET['search_order']) ? htmlspecialchars($_GET['search_order']) : '' ?>">
            <button class="btn btn-primary" type="submit">Search</button>
          </div>
        </form>

        <?php
        $orders = [
          ['order_id' => 'ORD1001', 'customer_name' => 'Alice Johnson', 'order_date' => '2025-05-10 14:32', 'status' => 'Pending', 'total' => 54.75],
          ['order_id' => 'ORD1002', 'customer_name' => 'Bob Smith', 'order_date' => '2025-05-09 09:15', 'status' => 'Delivered', 'total' => 120.00],
          ['order_id' => 'ORD1003', 'customer_name' => 'Charlie Lee', 'order_date' => '2025-05-08 18:45', 'status' => 'Processing', 'total' => 89.50],
          ['order_id' => 'ORD1004', 'customer_name' => 'Diana Green', 'order_date' => '2025-05-07 11:22', 'status' => 'Dispatched', 'total' => 30.25],
          ['order_id' => 'ORD1005', 'customer_name' => 'Ethan Clark', 'order_date' => '2025-05-06 17:05', 'status' => 'Pending', 'total' => 75.00],
          ['order_id' => 'ORD1006', 'customer_name' => 'Fiona Davis', 'order_date' => '2025-05-05 13:14', 'status' => 'Delivered', 'total' => 50.00],
          ['order_id' => 'ORD1007', 'customer_name' => 'George King', 'order_date' => '2025-05-04 15:33', 'status' => 'Processing', 'total' => 102.40],
          ['order_id' => 'ORD1008', 'customer_name' => 'Hannah Scott', 'order_date' => '2025-05-03 12:00', 'status' => 'Pending', 'total' => 45.99],
          ['order_id' => 'ORD1009', 'customer_name' => 'Ian Bell', 'order_date' => '2025-05-02 10:45', 'status' => 'Dispatched', 'total' => 60.50],
          ['order_id' => 'ORD1010', 'customer_name' => 'Jane Cooper', 'order_date' => '2025-05-01 09:30', 'status' => 'Delivered', 'total' => 75.00],
        ];

        $ordersPerPage = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
        $searchTerm = isset($_GET['search_order']) ? trim($_GET['search_order']) : '';

        if ($searchTerm !== '') {
          $filteredOrders = array_filter($orders, function($order) use ($searchTerm) {
            return stripos($order['order_id'], $searchTerm) !== false;
          });
        } else {
          $filteredOrders = $orders;
        }

        $totalOrders = count($filteredOrders);
        $totalPages = max(10, ceil($totalOrders / $ordersPerPage));
        $offset = ($page - 1) * $ordersPerPage;
        $ordersToShow = array_slice($filteredOrders, $offset, $ordersPerPage);
        ?>

        <?php if ($totalOrders > 0): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Order ID</th>
                  <th>Customer Name</th>
                  <th>Order Date</th>
                  <th>Status</th>
                  <th>Total Amount ($)</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($ordersToShow as $order): ?>
                <tr>
                  <td><?= htmlspecialchars($order['order_id']) ?></td>
                  <td><?= htmlspecialchars($order['customer_name']) ?></td>
                  <td><?= date('d M Y, H:i', strtotime($order['order_date'])) ?></td>
                  <td>
                    <form method="POST" action="update_order_status.php" class="d-flex align-items-center">
                      <input type="hidden" name="order_id" value="<?= htmlspecialchars($order['order_id']) ?>">
                      <select name="status" class="form-select form-select-sm me-2">
                        <?php
                          $statuses = ['Pending', 'Processing', 'Dispatched', 'Delivered'];
                          foreach ($statuses as $statusOption) {
                            $selected = ($order['status'] === $statusOption) ? 'selected' : '';
                            echo "<option value=\"$statusOption\" $selected>$statusOption</option>";
                          }
                        ?>
                      </select>
                      <button type="submit" class="btn btn-sm btn-success">Update</button>
                    </form>
                  </td>
                  <td><?= number_format($order['total'], 2) ?></td>
                  <td>
                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#orderDetailsModal" 
                      data-orderid="<?= htmlspecialchars($order['order_id']) ?>" 
                      data-customer="<?= htmlspecialchars($order['customer_name']) ?>" 
                      data-date="<?= date('d M Y, H:i', strtotime($order['order_date'])) ?>"
                      data-status="<?= htmlspecialchars($order['status']) ?>"
                      data-total="<?= number_format($order['total'], 2) ?>"
                    >
                      View Details
                    </button>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

         <!-- Pagination Controls -->
<nav aria-label="Orders pagination">
  <ul class="pagination justify-content-start">

    <?php
    // Limit pagination to 10 total pages
    $maxPagesToShow = 3;
    $totalPages = min($totalPages, 10);

    // Calculate the start and end page for current window
    $startPage = max(1, $page - 1);
    $endPage = min($startPage + $maxPagesToShow - 1, $totalPages);

    if (($endPage - $startPage + 1) < $maxPagesToShow && $startPage > 1) {
      $startPage = max(1, $endPage - $maxPagesToShow + 1);
    }
    ?>

    <!-- Previous Button -->
    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
      <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">Prev</a>
    </li>

    <!-- Page Numbers -->
    <?php for ($p = $startPage; $p <= $endPage; $p++): ?>
      <li class="page-item <?= $p == $page ? 'active' : '' ?>">
        <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $p])) ?>"><?= $p ?></a>
      </li>
    <?php endfor; ?>

    <!-- Next Button -->
    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
      <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">Next</a>
    </li>

  </ul>
</nav>

        <?php else: ?>
          <p class="text-center mt-5 text-muted fs-5">No orders found.</p>
        <?php endif; ?>
      </div>
    </main>
  </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-labelledby="orderDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="orderDetailsModalLabel">Order Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" style="max-height:75vh; overflow-y: auto;">
        <h6>Order ID: <span id="modalOrderId"></span></h6>
        <p><strong>Customer:</strong> <span id="modalCustomer"></span></p>
        <p><strong>Order Date:</strong> <span id="modalOrderDate"></span></p>

        <hr>
        <h6>Products</h6>
        <table class="table table-sm table-bordered">
          <thead class="table-light">
            <tr>
              <th>Product ID</th>
              <th>Product Name</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Discount</th>
              <th>Subtotal</th>
            </tr>
          </thead>
          <tbody id="productDetailsBody">
            <!-- Rows inserted by JS -->
          </tbody>
        </table>

        <div class="text-end">
          <strong>Total Amount: $<span id="modalTotal"></span></strong>
        </div>

        <hr>
        <h6>Delivery Information</h6>
        <p>Name: John Doe</p>
        <p>Email: johndoe@example.com</p>
        <p>Phone: 123-456-7890</p>
      </div>
    </div>
  </div>
</div>


<?php include('../includes/traderfooter.php'); ?>
