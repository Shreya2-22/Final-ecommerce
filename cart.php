<?php
session_start();
require 'includes/connect.php';  // <-- point this to your actual DB-connect file

// 1) Auth guard
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
    $_SESSION['failmessage'] = "You need to be logged in as a customer.";
    header("Location: login.php");
    exit;
}
$userId = (int)$_SESSION['id'];

// 2) Handle “Update quantity”
if (isset($_POST['update'])) {
    $cartId = (int)$_POST['cart_Id'];
    $newQty = max(1, min(20, (int)$_POST['update_quantity']));

    // a) Sum of all *other* lines
    $sql = "
      SELECT NVL(SUM(quantity),0) AS total_excl
        FROM cart
       WHERE fk1_user_id = $userId
         AND id           <> $cartId
    ";
    $stm = oci_parse($conn, $sql);
    oci_execute($stm);
    $row       = oci_fetch_assoc($stm);
    $totalExcl = (int)$row['TOTAL_EXCL'];

    if ($totalExcl + $newQty > 20) {
        $_SESSION['failmessage'] = "Cannot exceed 20 items in your cart.";
    } else {
        // b) Update this one line (note the space before AND!)
        $updSql = "
          UPDATE cart
             SET quantity = $newQty
           WHERE id           = $cartId
             AND fk1_user_id = $userId
        ";
        $upd = oci_parse($conn, $updSql);
        oci_execute($upd, OCI_COMMIT_ON_SUCCESS);
        $_SESSION['passmessage'] = "Cart updated successfully.";
    }

    header("Location: cart.php");
    exit;
}

// 3) Fetch everything in the cart + product info
$cartItems = [];
$subTotal  = 0.0;

$sql = "SELECT * FROM cart WHERE fk1_user_id = $userId";
$stm = oci_parse($conn, $sql);
oci_execute($stm);

while ($c = oci_fetch_assoc($stm)) {
    $pid = (int)$c['FK2_PRODUCT_ID'];

    // get product details
    $pstm = oci_parse($conn, "SELECT * FROM product WHERE product_id = $pid");
    oci_execute($pstm);
    $p = oci_fetch_assoc($pstm);

    $item = [
        'CART_ID'       => $c['ID'],
        'QUANTITY'      => (int)$c['QUANTITY'],
        'PRODUCT_IMAGE' => $p['PRODUCT_IMAGE'],
        'PRODUCT_NAME'  => $p['PRODUCT_NAME'],
        'PRODUCT_PRICE' => (float)$p['PRODUCT_PRICE'],
    ];
    // compute line total
    $item['LINE_TOTAL'] = $item['QUANTITY'] * $item['PRODUCT_PRICE'];
    $subTotal         += $item['LINE_TOTAL'];

    $cartItems[] = $item;
}
?>
<?php
// … your existing PHP logic above …
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>My Cart – Cleck-E-Mart</title>
  <?php include "includes/header.php"; ?>
  <link rel="stylesheet" href="css/style_temp.css">
</head>
<body class="bg-light">

  <div class="container py-5">
    <!-- Flash messages -->
    <?php if (!empty($_SESSION['failmessage'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['failmessage'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php unset($_SESSION['failmessage']); endif; ?>

    <?php if (!empty($_SESSION['passmessage'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['passmessage'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php unset($_SESSION['passmessage']); endif; ?>

    <div class="row">
      <!-- Cart Items -->
      <div class="col-lg-8 mb-4">
        <div class="card shadow-sm">
          <div class="card-header bg-white">
            <a href="product.php" class="fw-semibold text-decoration-none" style="color:rgb(108, 161, 196); font-size: 1.15rem;">
      Shop More <-
    </a>
            <h5 class="mb-0">Your Shopping Cart</h5>
          </div>
          <div class="card-body p-0">
            <?php if (empty($cartItems)): ?>
              <div class="p-4 text-center text-muted">Your cart is empty.</div>
            <?php else: ?>
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th scope="col">Product</th>
                      <th scope="col">Price</th>
                      <th scope="col" class="text-center">Qty</th>
                      <th scope="col" class="text-end">Total</th>
                      <th scope="col" class="text-center">Remove</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($cartItems as $it): ?>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center">
                            <img src="images/product_images\<?= htmlspecialchars($it['PRODUCT_IMAGE']) ?>"
                                 class="rounded" width="60" height="60" alt="">
                            <span class="ms-3"><?= htmlspecialchars($it['PRODUCT_NAME']) ?></span>
                          </div>
                        </td>
                        <td>£<?= number_format($it['PRODUCT_PRICE'],2) ?></td>
                        <td class="text-center">
                          <form method="POST" class="d-inline-flex">
                            <input type="hidden" name="cart_Id" value="<?= $it['CART_ID'] ?>">
                            <input type="number"
                                   name="update_quantity"
                                   class="form-control form-control-sm text-center"
                                   style="width: 60px;"
                                   min="1" max="20"
                                   value="<?= $it['QUANTITY'] ?>">
                            <button type="submit" name="update"
                                    class="btn btn-sm btn-primary ms-2">
                              Update
                            </button>
                          </form>
                        </td>
                        <td class="text-end">£<?= number_format($it['LINE_TOTAL'],2) ?></td>
                        <td class="text-center">
                          <a href="delete.php?ID=<?= $it['CART_ID'] ?>"
                             onclick="return confirm('Delete this item?')"
                             class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash"></i>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>

      <!-- Summary & Actions -->
      <div class="col-lg-4">
        <div class="card shadow-sm">
          <div class="card-body">
            <h6 class="fw-bold mb-3">Order Summary</h6>
            <dl class="row mb-3">
              <dt class="col-6">Sub Total:</dt>
              <dd class="col-6 text-end">£<?= number_format($subTotal,2) ?></dd>
            </dl>

            <form action="coupon.php" method="POST" class="input-group mb-3">
              <input type="text" name="coupon"
                     class="form-control form-control-sm"
                     placeholder="Coupon code">
              <button class="btn btn-outline-secondary btn-sm"
                      type="submit">Apply</button>
            </form>

            <dl class="row mb-3">
              <dt class="col-6">Discount:</dt>
              <dd class="col-6 text-end text-danger">-£<?= number_format($_SESSION['discount'] ?? 0,2) ?></dd>
            </dl>
            <hr>
            <dl class="row mb-4">
              <dt class="col-6 fs-5">Grand Total:</dt>
              <dd class="col-6 fs-5 text-end">£<?= number_format($subTotal - ($_SESSION['discount'] ?? 0),2) ?></dd>
            </dl>

            <form action="delete.php" method="POST" onsubmit="return confirm('Empty whole cart?');">
              <button type="submit" name="deleteBtn"
                      class="btn btn-outline-danger btn-sm w-100 mb-2">
                Empty Cart
              </button>
            </form>
            <a href="collection.php"
               class="btn btn-primary btn-sm w-100">
              Proceed to Checkout
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include "includes/footer.php"; clearMsg(); ?>
</body>
</html>
