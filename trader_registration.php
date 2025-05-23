<?php include "includes/connect.php"; ?>
<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['id'])) {
  if ($_SESSION['role'] === 'customer') {
    header("Location: index.php");
    exit();
  } elseif ($_SESSION['role'] === 'trader') {
    header("Location: traderdashboard.php");
    exit();
  } elseif ($_SESSION['role'] === 'admin') {
    header("Location: admin_dashboard.php");
    exit();
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Create Trader Account</title>
  <link rel="stylesheet" type="text/css" href="css/alert.css">
  <?php
  $pageTitle = "Trader Registration";
   include "includes/header.php"; ?>
  <style>
    .error {
      color: red;
      font-style: italic;
    }

    #customer_message {
      margin-top: 20px;
    }
  </style>
</head>

<body>
  <?php
  if (isset($_POST['btnSubmit'])) {
    $name = $_POST['Trad_name'];
    $email = $_POST['Trad_Email'];
    $dob = $_POST['Trad_Dob'];
    $phone = $_POST['Trad_Phone'];
    $username = $_POST['Trad_Username'];
    $password = $_POST['Trad_Password'];
    $confirm_password = $_POST['Trad_Confirm_Password'];
    $shop_name = $_POST['Shop_name'];
    $type = $_POST['Shop_Type'];
    $image = $_FILES['Trad_Image']['name'];
    $role = "trader";
    $status = "Not Verified";
    $error = 0;

    if (strlen($name) < 5) {
      $error_name = "Fullname should be at least six characters";
      $error++;
    }
    if ($name == null) {
      $error_name = "Please enter your fullname first";
      $error++;
    }
    if (!preg_match("/^[_\\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\\.)+[a-zA-Z]{2,6}$/i", $email)) {
      $error_email = "Please enter a valid email, like yourname@abc.com";
      $error++;
    }
    if ($email == null) {
      $error_email = "Please enter your email";
      $error++;
    }
    if (!preg_match('/^[0-9]{10}+$/', $phone)) {
      $error_phone = "Please enter valid mobile number";
      $error++;
    }
    if ($phone == null) {
      $error_phone = "Please enter your mobile number";
      $error++;
    }
    if (strlen($username) < 5) {
      $error_username = "Username should be at least five characters";
      $error++;
    }
    if ($username == null) {
      $error_username = "Please enter your username";
      $error++;
    }
    if (!preg_match('@[A-Z]@', $password) || !preg_match('@[a-z]@', $password) || !preg_match('@[0-9]@', $password) || !preg_match('@[^\\w]@', $password)) {
      $error_password = "Password must include uppercase, lowercase, number, and special character";
      $error++;
    }
    if (strlen($password) < 6) {
      $error_password = "Password must be greater than six characters";
      $error++;
    }
    if ($password == null) {
      $error_password = "Please enter your password";
      $error++;
    }
    if ($confirm_password == null) {
      $error_confirm_password = "No password given";
      $error++;
    }
    if ($password != $confirm_password) {
      $error_confirm_password = "Password does not match";
      $error++;
    }
    if ($type == null) {
      $error_type = "Please select your shop type";
      $error++;
    }
    if ($image == null) {
      $error_image = "Please upload your image";
      $error++;
    }

    if ($error == 0) {
      $password = password_hash($password, PASSWORD_DEFAULT);
      $target_dir = "images/categories/";
      $target_file = $target_dir . basename($image);
      move_uploaded_file($_FILES["Trad_Image"]["tmp_name"], $target_file);

      $query = "INSERT INTO user_master(Name, Email, DOB, Phone, Username, Password, Shop_Name, Shop_Type, Shop_Image, Role, Status) 
              VALUES ('$name', '$email', '$dob', '$phone', '$username', '$password', '$shop_name', '$type', '$image', '$role', '$status')";

      if ($result = oci_parse($conn, $query)) {
        oci_execute($result);
        $_SESSION['passmessage'] = "Account Registration Successful";
      }
    }
  }
  ?>
  <?php if (isset($_SESSION['passmessage'])): ?>
    <div id="success-message" style="position: fixed; top: 10px; left: 50%; transform: translateX(-50%); background-color: #d4edda; color: #155724; padding: 12px 24px; border: 1px solid #c3e6cb; border-radius: 6px; z-index: 1000;">
      <?php echo $_SESSION['passmessage'];
      unset($_SESSION['passmessage']); ?>
    </div>
    <script>
      setTimeout(function() {
        document.getElementById("success-message").style.display = "none";
      }, 3000);
    </script>
  <?php endif; ?>
  <link rel="stylesheet" href="css/trader_registration.css" />
  <div class="register-container">
    <div class="register-box">
      <h3>Create account</h3>
      <form action="" method="POST" enctype="multipart/form-data">
        <div class="mb-2">
          <label class="form-label">Full Name</label>
          <input type="text" name="Trad_name" class="form-control" placeholder="Enter your full name" value="<?php if (isset($name)) echo $name ?>">
          <?php if (isset($error_name)) echo '<div class="error">' . $error_name . '</div>'; ?>
        </div>

        <div class="mb-2">
          <label class="form-label">Email Address</label>
          <input type="email" name="Trad_Email" class="form-control" placeholder="xyz@gmail.com" value="<?php if (isset($email)) echo $email ?>">
          <?php if (isset($error_email)) echo '<div class="error">' . $error_email . '</div>'; ?>
        </div>

        <div class="mb-2">
          <label class="form-label">Date of Birth</label>
          <input type="date" name="Trad_Dob" class="form-control" value="<?php if (isset($dob)) echo $dob ?>">
        </div>

        <div class="mb-2">
          <label class="form-label">Mobile Number</label>
          <input type="tel" name="Trad_Phone" class="form-control" placeholder="Mobile number" value="<?php if (isset($phone)) echo $phone ?>">
          <?php if (isset($error_phone)) echo '<div class="error">' . $error_phone . '</div>'; ?>
        </div>

        <div class="mb-2">
          <label class="form-label">Username</label>
          <input type="text" name="Trad_Username" class="form-control" placeholder="Username" value="<?php if (isset($username)) echo $username ?>">
          <?php if (isset($error_username)) echo '<div class="error">' . $error_username . '</div>'; ?>
        </div>

        <div class="mb-2">
          <label class="form-label">Password</label>
          <input type="password" name="Trad_Password" class="form-control" placeholder="Password">
          <?php if (isset($error_password)) echo '<div class="error">' . $error_password . '</div>'; ?>
        </div>

        <div class="mb-2">
          <label class="form-label">Confirm Password</label>
          <input type="password" name="Trad_Confirm_Password" class="form-control" placeholder="Confirm Password">
          <?php if (isset($error_confirm_password)) echo '<div class="error">' . $error_confirm_password . '</div>'; ?>
        </div>

        <div class="mb-2">
          <label class="form-label">Shop Name</label>
          <input type="text" name="Shop_name" class="form-control" placeholder="Enter shop name" value="<?php if (isset($shop_name)) echo $shop_name ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">Shop Type</label>
          <select name="Shop_Type" class="form-select">
            <option disabled selected value="">Select</option>
            <option value="Greengrocer">Greengrocer</option>
            <option value="Butcher">Butcher</option>
            <option value="Fishmonger">Fishmonger</option>
            <option value="Bakery">Bakery</option>
            <option value="Delicatessen">Delicatessen</option>
          </select>
          <?php if (isset($error_type)) echo '<div class="error">' . $error_type . '</div>'; ?>
        </div>

        <div class="mb-2">
          <label class="form-label">Choose Profile Image</label>
          <input type="file" name="Trad_Image" class="form-control" accept="image/*">
          <?php if (isset($error_image)) echo '<div class="error">' . $error_image . '</div>'; ?>
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
          <label class="form-check-label" for="terms">
            I agree to Cleck-E-Mart's <a href="#">Terms and Conditions</a>
          </label>
        </div>

        <div class="d-grid mb-3">
          <button type="submit" name="btnSubmit" class="btn text-white" style="background-color: #C49A6C;">SIGN UP</button>
        </div>

        <div class="text-center">
          Already have an account? <a href="login.php">Sign in</a>
        </div>
      </form>
    </div>
  </div>
  <?php include("includes/footer.php"); ?>
</body>

</html>