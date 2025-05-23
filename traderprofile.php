<?php
session_start();
require 'includes/connect.php';

if ($_SESSION['role'] !== 'trader') {
  header("Location: index.php");
  exit();
}

if (isset($_POST['SubmitChange'])) {
  $fullname = $_POST['name'];
  $username = $_POST['username'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $shopname = $_POST['shopname'];
  $shoptype = $_POST['shoptype'];
  $error = 0;

  if (!empty($_FILES['image']['name'])) {
    $image = basename($_FILES['image']['name']);
    $target_dir = "images/categories/";
    $target_file = $target_dir . $image;
    move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
  } else {
    $image = $_POST['existing_image'];
  }

  if (strlen($fullname) < 3) $error_name = "Full name should be at least three characters";
  if (!$fullname) $error_name = "Name must not be empty";
  if (strlen($username) < 5) $error_username = "Username must be at least five characters";
  if (!$username) $error_username = "Username must not be empty";
  if (!preg_match('/^[0-9]{10}$/', $phone)) $error_phone = "Please enter valid mobile number";
  if (!$phone) $error_phone = "Phone number must not be empty";

  if (!isset($error_name) && !isset($error_username) && !isset($error_phone)) {
    $update_query = "UPDATE user_master SET NAME = :fullname, USERNAME = :username, PHONE = :phone, EMAIL = :email, SHOP_NAME = :shopname, SHOP_TYPE = :shoptype, SHOP_IMAGE = :image WHERE USER_ID = :userid";
    $stmt = oci_parse($conn, $update_query);
    oci_bind_by_name($stmt, ':fullname', $fullname);
    oci_bind_by_name($stmt, ':username', $username);
    oci_bind_by_name($stmt, ':phone', $phone);
    oci_bind_by_name($stmt, ':email', $email);
    oci_bind_by_name($stmt, ':shopname', $shopname);
    oci_bind_by_name($stmt, ':shoptype', $shoptype);
    oci_bind_by_name($stmt, ':image', $image);
    oci_bind_by_name($stmt, ':userid', $_SESSION['id']);
    oci_execute($stmt);
    $_SESSION['passmessage'] = "Profile updated successfully";
  }
}

$getid_query = "SELECT * FROM user_master WHERE USER_ID = " . $_SESSION['id'];
$id_result = oci_parse($conn, $getid_query);
oci_execute($id_result);
$row = oci_fetch_assoc($id_result);
?>

<link rel="stylesheet" href="css/manage.css">
<?php
include "includes/traderheader.php";
include "includes/tradersidebar.php";
?>

<style>
  .profile-wrapper {
    padding: 20px 0 150px;
    display: flex;
    justify-content: center;
    margin-top: -246px;
  }

  .profile-box {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0,0,0,0.05);
    padding: 20px;
    width: 100%;
    max-width: 600px;
  }

  .profile-image-preview {
    width: 140px;
    height: 140px;
    object-fit: cover;
    border: 4px solid #F48037;
    border-radius: 50%;
  }

  .small-image-preview {
    width: 65px;
    height: 65px;
    object-fit: cover;
    border-radius: 6px;
    margin-left: 0;
    margin-top: 6px;
  }
</style>

<div class="container profile-wrapper">
  <div class="profile-box">
    <h2 class="fw-bold mb-4">Manage Trader Profile</h2>
    <form action="" method="POST" enctype="multipart/form-data">
      <div class="text-center mb-4">
        <img src="images/categories/<?= htmlspecialchars($row['SHOP_IMAGE']) ?>" class="profile-image-preview">
      </div>

      <input type="hidden" name="existing_image" value="<?= htmlspecialchars($row['SHOP_IMAGE']) ?>">

      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" name="name" value="<?= htmlspecialchars($row['NAME']) ?>">
        <?php if (isset($error_name)) echo '<div class="error text-danger">'.$error_name.'</div>'; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" name="username" value="<?= htmlspecialchars($row['USERNAME']) ?>">
        <?php if (isset($error_username)) echo '<div class="error text-danger">'.$error_username.'</div>'; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Phone</label>
        <input type="text" class="form-control" name="phone" value="<?= htmlspecialchars($row['PHONE']) ?>">
        <?php if (isset($error_phone)) echo '<div class="error text-danger">'.$error_phone.'</div>'; ?>
      </div>

      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="text" class="form-control" name="email" value="<?= htmlspecialchars($row['EMAIL']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Shop Name</label>
        <input type="text" class="form-control" name="shopname" value="<?= htmlspecialchars($row['SHOP_NAME']) ?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Shop Type</label>
        <input type="text" class="form-control" name="shoptype" value="<?= htmlspecialchars($row['SHOP_TYPE']) ?>">
      </div>

      <div class="mb-4">
        <label class="form-label d-block">Change Profile Image</label>
        <input type="file" class="form-control mb-2" name="image">
        <div>
          <img src="images/categories/<?= htmlspecialchars($row['SHOP_IMAGE']) ?>" class="small-image-preview">
        </div>
      </div>

      <div class="mb-4 text-center">
        <a href="trader_password_manage.php">Want to change password?</a>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn text-white" style="background-color:#F48037;" name="SubmitChange">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<?php include "includes/footer.php"; clearMsg(); ?>
