<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include "includes/connect.php";

if ($_SESSION['role'] != 'trader') {
  header("Location: login.php");
  exit();
}

// Fetch butcher products
$products = [];
$productDetails = [];

$fetch_query = "SELECT P.PRODUCT_ID, P.PRODUCT_NAME, P.PRODUCT_DESC, P.ALLERGY_INFO, P.PRODUCT_PRICE, P.QUANTITY, P.PRODUCT_IMAGE
                FROM PRODUCT P
                JOIN SHOP S ON P.FK1_SHOP_ID = S.SHOP_ID
                WHERE S.SHOP = 'Butcher' AND S.FK1_USER_ID = :userid";

$stmt = oci_parse($conn, $fetch_query);
oci_bind_by_name($stmt, ":userid", $_SESSION['id']);
oci_execute($stmt);

while ($row = oci_fetch_assoc($stmt)) {
  $products[] = $row;
  $productDetails[$row['PRODUCT_ID']] = $row;
}

// Handle update
if (isset($_POST['update'])) {
  $pid = $_POST['productid'];
  $name = $_POST['name'];
  $desc = $_POST['proddesc'];
  $allergy = $_POST['allergyinfo'];
  $price = $_POST['price'];
  $qty = $_POST['quantity'];
  $img = $_FILES['prodimg']['name'];

  // If no new image, fetch current image from DB
  if (empty($img)) {
    $getImageQuery = "SELECT PRODUCT_IMAGE FROM PRODUCT WHERE PRODUCT_ID = :pid";
    $imgStmt = oci_parse($conn, $getImageQuery);
    oci_bind_by_name($imgStmt, ":pid", $pid);
    oci_execute($imgStmt);
    $row = oci_fetch_assoc($imgStmt);
    $img = $row['PRODUCT_IMAGE'];
  } else {
    $target_dir = "images/product_images/";
    $target_file = $target_dir . basename($img);
    move_uploaded_file($_FILES["prodimg"]["tmp_name"], $target_file);
  }

  // Use safe bind variable name :pdesc (NOT :desc)
  $update = "UPDATE PRODUCT SET 
    PRODUCT_NAME = :name,
    PRODUCT_DESC = :pdesc,
    ALLERGY_INFO = :allergy,
    PRODUCT_PRICE = :price,
    QUANTITY = :qty,
    PRODUCT_IMAGE = :imgval
    WHERE PRODUCT_ID = :pid";

  $stmt = oci_parse($conn, $update);
  oci_bind_by_name($stmt, ":name", $name);
  oci_bind_by_name($stmt, ":pdesc", $desc); // ✅ fixed
  oci_bind_by_name($stmt, ":allergy", $allergy);
  oci_bind_by_name($stmt, ":price", $price);
  oci_bind_by_name($stmt, ":qty", $qty);
  oci_bind_by_name($stmt, ":imgval", $img);
  oci_bind_by_name($stmt, ":pid", $pid);

  if (oci_execute($stmt)) {
    $_SESSION['passmessage'] = "✅ Product updated.";
  } else {
    $e = oci_error($stmt);
    $_SESSION['failmessage'] = "❌ Update failed: " . $e['message'];
  }

  echo "<script>location.href='traderupdateproduct.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Update Butcher Products</title>
  <link rel="stylesheet" href="css/manage.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <?php include "includes/traderheader.php"; ?>
  <style>
    .error { color: red; font-style: italic; }
    #preview-image {
      width: 100px;
      height: auto;
      margin-top: 10px;
      display: none;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <?php include('includes/tradersidebar.php'); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <h3 class="text-center my-4 fw-bold">Update Butcher Product</h3>

      <?php if (isset($_SESSION['passmessage'])): ?>
        <div class='alert alert-success'><?= $_SESSION['passmessage']; unset($_SESSION['passmessage']); ?></div>
      <?php endif; ?>
      <?php if (isset($_SESSION['failmessage'])): ?>
        <div class='alert alert-danger'><?= $_SESSION['failmessage']; unset($_SESSION['failmessage']); ?></div>
      <?php endif; ?>

      <form action="" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 800px;">
        <div class="mb-3">
          <label class="form-label">Select Product</label>
          <select name="productid" id="productSelect" class="form-select" required>
            <option selected disabled>-- Choose Butcher Product --</option>
            <?php foreach ($products as $p): ?>
              <option value="<?= $p['PRODUCT_ID'] ?>"><?= $p['PRODUCT_NAME'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div id="formFields" style="display: none;">
          <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="proddesc" id="desc" class="form-control" rows="3" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Allergy Info</label>
            <textarea name="allergyinfo" id="allergy" class="form-control" rows="2" required></textarea>
          </div>

          <div class="mb-3">
            <label class="form-label">Price (£)</label>
            <input type="number" name="price" id="price" class="form-control" step="0.01" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity" id="qty" class="form-control" min="1" max="1000" required>
          </div>

          <div class="mb-3">
            <label class="form-label">Replace Image (optional)</label>
            <input type="file" name="prodimg" class="form-control">
            <img id="preview-image" src="" alt="Current Image" />
          </div>

          <div class="text-center">
            <button type="submit" name="update" class="btn btn-warning px-5">Update Product</button>
          </div>
        </div>
      </form>
    </main>
  </div>
</div>

<script>
  const productData = <?= json_encode($productDetails) ?>;

  $('#productSelect').on('change', function () {
    const selectedId = $(this).val();
    if (!selectedId) return;

    const data = productData[selectedId];
    $('#formFields').show();
    $('#name').val(data.PRODUCT_NAME);
    $('#desc').val(data.PRODUCT_DESC);
    $('#allergy').val(data.ALLERGY_INFO);
    $('#price').val(data.PRODUCT_PRICE);
    $('#qty').val(data.QUANTITY);

    if (data.PRODUCT_IMAGE) {
      $('#preview-image').attr('src', 'images/product_images/' + data.PRODUCT_IMAGE).show();
    } else {
      $('#preview-image').hide();
    }
  });

  setTimeout(() => {
    $('.alert').fadeOut();
  }, 3000);
</script>

<?php include('includes/traderfooter.php'); ?>
</body>
</html>
  