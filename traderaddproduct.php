<?php
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
?>

<?php
include "includes/connect.php";


if (isset($_POST['Submitbtn'])) {
  $name = $_POST['name'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $productdescription = $_POST['proddesc'];
  $allergyinformation = $_POST['allergyinfo'];
  $productimage = $_FILES['prodimg']['name'];
  $target_dir = "images/product_images/";
  $target_file = $target_dir . basename($_FILES["prodimg"]["name"]);

  if (move_uploaded_file($_FILES["prodimg"]["tmp_name"], $target_file)) {
    // Upload successful
  } else {
    $error_image = "❌ Failed to upload product image.";
    $error++;
  }


  $stock = "Stock";
  $rating = "4.5star.jpg";
  $error = 0;

  if (strlen($name) < 5) {
    $error_pname =  "Product name should be atleast six characters";
    $error++;
  }

  if ($name == null) {
    $error_pname =  "Please enter your the product name first";
    $error++;
  }
  if (!preg_match("/^[0-9]+(\.[0-9]{2})?$/", $price)) {
    $error_price =  "Please enter the numbers only";
    $error++;
  }
  if ($price == null) {
    $error_price =  "Please enter the price";
    $error++;
  }
  if ($quantity == null) {
    $error_quantity =  "Please enter the quantity";
    $error++;
  }
  if (strlen($productdescription) < 10) {
    $error_description =  "Product description should be atleast 10 characters";
    $error++;
  }

  if ($productdescription == null) {
    $error_description =  "Please enter the product description";
    $error++;
  }
  if (strlen($allergyinformation) < 10) {
    $error_allergy =  "Allergy information should be atleast 10 characters";
    $error++;
  }

  if ($allergyinformation == null) {
    $error_allergy =  "Please enter the allergy information";
    $error++;
  }

  if ($productimage == null) {
    $error_image =  "Please upload your image";
    $error++;
  }

  if (!isset($_POST['shopType'])) {
    $error_type =  "Please select the trader type";
    $error++;
  } else {
    $shopType = $_POST['shopType'];
  }

  if ($error == 0) {
    $query = "INSERT INTO PRODUCT (PRODUCT_IMAGE, PRODUCT_RATING, PRODUCT_NAME, PRODUCT_DESC, ALLERGY_INFO, PRODUCT_PRICE, QUANTITY, STOCK, FK1_SHOP_ID) values('$productimage', '$rating', '$name', '$productdescription', '$allergyinformation', '$price', '$quantity', '$stock', $shopType)";

    if ($result = oci_parse($conn, $query)); {
      oci_execute($result);
      $name = "";
      $price = "";
      $quantity = "";
      $productdescription = "";
      $allergyinformation = "";
      $productimage = "";
      $shopType = "";
      $_SESSION['passmessage'] = "Product added successfully";
    }
  }
}

?>
<!DOCTYPE html>
<html>

<head>


  <title></title>

  <link rel="stylesheet" href="css/manage.css">

  <?php
  include "includes/traderheader.php";
  ?>
  <style>
    @media only screen and (max-width: 600px) {
      #abc {
        font-size: 6px;
      }

      h2 {
        font-size: 16px;
      }

      a {
        padding: 0;
      }
    }

    #abc {
      background-color: #F48037;
      border-radius: none;
      transition: 0.4s;
      margin-bottom: 20px;
      color: #fff;
    }

    #abc:hover {
      background-color: #7CC355;
      color: #fff;
    }

    .error {
      color: red;
      font-style: italic;
    }
  </style>

</head>

<body>
  <div class="container-fluid mt-0">
    <div class="row">
      <?php include('includes/tradersidebar.php'); ?>

      <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h3 class="text-center mb-3 fw-bold">Add Product</h3>

        <?php if (isset($_SESSION['passmessage'])): ?>
          <div class='alert alert-success' id='success-alert'><?= $_SESSION['passmessage']; ?></div>
          <?php unset($_SESSION['passmessage']); ?>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="mx-auto" style="max-width: 800px;">
          <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" class="form-control" name="name" value="<?php if (isset($name)) echo $name ?>"><br>
            <div class="mb-0"><?php if (isset($error_pname)) echo '<div class="error">' . $error_pname . '</div>'; ?>
            </div>

            <div class="mb-3">
              <label class="form-label">Category</label>
              <select class="form-select" name="shopType" required>
                <option selected disabled>Choose category</option>
                <?php
                $query_shop = "SELECT * FROM SHOP WHERE FK1_USER_ID =" . $_SESSION['id'];
                $result = oci_parse($conn, $query_shop);
                oci_execute($result);

                while ($row = oci_fetch_assoc($result)) {

                ?><option value="<?php echo $row['SHOP_ID']; ?>"><?php echo $row['SHOP']; ?></option>
                <?php } ?>
              </select>
              <div class="mb-3"><?php if (isset($error_type)) echo '<div class="error">' . $error_type . '</div>'; ?> </div>

              <div class="mb-3">
                <label class="form-label">Product Description</label>
                <textarea class="form-control" name="proddesc" rows="3"><?php if (isset($productdescription)) echo $productdescription ?></textarea>
                <div class="mb-3"><?php if (isset($error_description)) echo '<div class="error">' . $error_description . '</div>'; ?> </div>

                <div class="mb-3">
                  <label class="form-label">Allergy Information</label>
                  <textarea class="form-control" name="allergyinfo" rows="2"><?php if (isset($allergyinformation)) echo $allergyinformation ?></textarea>
                  <div class="mb-3"><?php if (isset($error_allergy)) echo '<div class="error">' . $error_allergy . '</div>'; ?> </div>


                  <div class="mb-3">
                    <label class="form-label">Price (£)</label>
                    <input type="number" step="0.01" class="form-control" name="price" value="<?php if (isset($price)) echo $price ?>">
                    <div class="mb-3"><?php if (isset($error_price)) echo '<div class="error">' . $error_price . '</div>'; ?> </div>

                    <div class="mb-3">
                      <label class="form-label">Quantity</label>
                      <input type="number" class="form-control" name="quantity" min="1" max="1000" value="<?php if (isset($quantity)) echo $quantity ?>" min="1" max="1000">
                      <div class="mb-3"><?php if (isset($error_quantity)) echo '<div class="error">' . $error_quantity . '</div>'; ?>
                        <?php if (isset($error_quantity)) echo '<div class="error">' . $error_quantity . '</div>'; ?>
                      </div>

                      <div class="mb-4">
                        <label class="form-label">Product Image</label>
                        <input type="file" class="form-control" name="prodimg" value="<?php if (isset($productimage)) echo $productimage ?>">
                      </div>
                    </div>
                    <div class="mb-3"><?php if (isset($error_image)) echo '<div class="error">' . $error_image . '</div>'; ?> </div>

                    <div class="text-center">
                      <button type="submit" name="Submitbtn" class="btn btn-success px-5">Add Product</button>
                    </div>
        </form>
      </main>
    </div>
  </div>

  <script>
    //dropdown produts 
    var dropdown = document.getElementsByClassName("dropdown-btn");
    var i;

    for (i = 0; i < dropdown.length; i++) {
      dropdown[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var dropdownContent = this.nextElementSibling;
        if (dropdownContent.style.display === "block") {
          dropdownContent.style.display = "none";
        } else {
          dropdownContent.style.display = "block";
        }
      });
    }
  </script>

  <script>
    setTimeout(function() {
      const alert = document.getElementById('success-alert');
      if (alert) {
        alert.style.display = 'none';
      }
    }, 3000);
  </script>

  <?php include('includes/traderfooter.php');
  clearMsg();  ?>