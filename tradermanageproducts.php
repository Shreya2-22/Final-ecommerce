<?php include('includes/traderheader.php'); ?>

<div class="container-fluid" style="margin-top: -10px;">
  <div class="row gx-3 ms-2 align-items-start">
    <?php include('includes/tradersidebar.php'); ?>

    <main class="col-12 col-md content-box border me-3 py-4 px-4">
      <div class="mx-auto w-100">

        <!-- Search by Product ID -->
        <form method="GET" class="mb-4">
          <div class="input-group">
            <input type="text" class="form-control" name="search_product" placeholder="Search by Product ID" 
              value="<?= isset($_GET['search_product']) ? htmlspecialchars($_GET['search_product']) : '' ?>">
            <button class="btn btn-primary" type="submit">Search</button>
          </div>
        </form>

        <?php
        // Sample product data
        $products = [
          ['product_id' => 'PROD001', 'product_name' => 'Milk 1L', 'price' => 3.50, 'stock' => 25],
          ['product_id' => 'PROD002', 'product_name' => 'Cheddar Cheese', 'price' => 7.20, 'stock' => 10],
          ['product_id' => 'PROD003', 'product_name' => 'Butter 500g', 'price' => 4.00, 'stock' => 15],
          ['product_id' => 'PROD004', 'product_name' => 'Yogurt 150g', 'price' => 1.20, 'stock' => 30],
          ['product_id' => 'PROD005', 'product_name' => 'Cream 250ml', 'price' => 2.80, 'stock' => 12],
          ['product_id' => 'PROD006', 'product_name' => 'Orange Juice 1L', 'price' => 3.00, 'stock' => 20],
          ['product_id' => 'PROD007', 'product_name' => 'Eggs Dozen', 'price' => 5.00, 'stock' => 40],
          ['product_id' => 'PROD008', 'product_name' => 'Butter Milk 1L', 'price' => 3.75, 'stock' => 18],
          ['product_id' => 'PROD009', 'product_name' => 'Sour Cream 200g', 'price' => 2.50, 'stock' => 22],
          ['product_id' => 'PROD010', 'product_name' => 'Mozzarella Cheese', 'price' => 8.00, 'stock' => 8],
        ];

        $productsPerPage = 10;
        $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int) $_GET['page'] : 1;
        $searchTerm = isset($_GET['search_product']) ? trim($_GET['search_product']) : '';

        if ($searchTerm !== '') {
          $filteredProducts = array_filter($products, function($product) use ($searchTerm) {
            return stripos($product['product_id'], $searchTerm) !== false;
          });
        } else {
          $filteredProducts = $products;
        }

        $totalProducts = count($filteredProducts);
        $totalPages = max(10, ceil($totalProducts / $productsPerPage));
        $offset = ($page - 1) * $productsPerPage;
        $productsToShow = array_slice($filteredProducts, $offset, $productsPerPage);
        ?>

        <?php if ($totalProducts > 0): ?>
          <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
              <thead class="table-light">
                <tr>
                  <th>Product ID</th>
                  <th>Product Name</th>
                  <th>Price ($)</th>
                  <th>Stock Level</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($productsToShow as $product): ?>
                <tr>
                  <td><?= htmlspecialchars($product['product_id']) ?></td>
                  <td><?= htmlspecialchars($product['product_name']) ?></td>
                  <td><?= number_format($product['price'], 2) ?></td>
                  <td><?= (int)$product['stock'] ?></td>
                  <td>
                    <a href="traderproductdetailform.php?product_id=<?= urlencode($product['product_id']) ?>" class="btn btn-sm btn-outline-primary me-1">View</a>
                    <a href="traderupdateproductform.php?product_id=<?= urlencode($product['product_id']) ?>" class="btn btn-sm btn-outline-warning me-1">Edit</a>
                    <form method="POST" action="deleteproduct.php" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete <?= htmlspecialchars($product['product_name']) ?>?');">
                      <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                      <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                  </td>
                </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- Pagination Controls -->
          <nav aria-label="Products pagination">
            <ul class="pagination justify-content-start">

              <?php
              // Limit pagination to 10 pages max
              $maxPagesToShow = 3;
              $totalPages = min($totalPages, 10);

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
          <p class="text-center mt-5 text-muted fs-5">No products found.</p>
        <?php endif; ?>
      </div>
    </main>
  </div>
</div>

<?php include('includes/traderfooter.php'); ?>
