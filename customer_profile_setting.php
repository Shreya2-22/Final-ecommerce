<?php
// customer_profile_setting.php
session_start();
require 'includes/connect.php';

// 1) Guard
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
    header('Location: login.php');
    exit;
}
$userId = (int)$_SESSION['id'];

if (isset($_POST['btnSubmit'])) {
    $name     = trim($_POST['name']);
    $username = trim($_POST['username']);
    $phone    = trim($_POST['phone']);
    $dob      = trim($_POST['dob']);
    $errors   = [];

    if ($name === '')     $errors['name']     = 'Name is required.';
    if ($username === '') $errors['username'] = 'Username is required.';
    if ($phone === '')    $errors['phone']    = 'Phone number is required.';
    if ($dob === '')      $errors['dob']      = 'Date of birth is required.';

    if (empty($errors)) {
        // Inline update
        $updateSql = "
          UPDATE user_master
             SET name     = '" . str_replace("'", "''", $name) . "',
                 username = '" . str_replace("'", "''", $username) . "',
                 phone    = '" . str_replace("'", "''", $phone) . "',
                 dob      = '" . str_replace("'", "''", $dob) . "'
           WHERE user_id  = {$userId}
        ";
        $ustm = oci_parse($conn, $updateSql);
        oci_execute($ustm, OCI_COMMIT_ON_SUCCESS);

        $_SESSION['passmessage'] = 'Profile updated successfully.';
        // reload so we fetch fresh data
        header('Location: customer_profile_setting.php');
        exit;
    }
}

// 3) Fetch current data
// 3) Fetch current data (inline userId)
$sql = "
  SELECT name, username, email, phone, dob, gender
    FROM user_master
   WHERE user_id = {$userId}
";
$stm = oci_parse($conn, $sql);
oci_execute($stm);
$user = oci_fetch_assoc($stm);

$pageTitle = "Customer Profile";
// 4) Render
include 'includes/header.php';
?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Edit Profile</h2>

  <!-- Center the form -->
  <div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
      <form method="POST" novalidate>
        <!-- Name -->
        <div class="mb-3">
          <label class="form-label">Full Name *</label>
          <input type="text" name="name"
                 class="form-control <?= isset($errors['name'])?'is-invalid':'' ?>"
                 value="<?= htmlspecialchars($user['NAME'] ?? '') ?>">
          <div class="invalid-feedback"><?= $errors['name'] ?? '' ?></div>
        </div>

        <!-- Username -->
        <div class="mb-3">
          <label class="form-label">Username *</label>
          <input type="text" name="username"
                 class="form-control <?= isset($errors['username'])?'is-invalid':'' ?>"
                 value="<?= htmlspecialchars($user['USERNAME'] ?? '') ?>">
          <div class="invalid-feedback"><?= $errors['username'] ?? '' ?></div>
        </div>

        <!-- Mobile No -->
        <div class="mb-3">
          <label class="form-label">Mobile No *</label>
          <input type="tel" name="phone"
                 class="form-control <?= isset($errors['phone'])?'is-invalid':'' ?>"
                 value="<?= htmlspecialchars($user['PHONE'] ?? '') ?>">
          <div class="invalid-feedback"><?= $errors['phone'] ?? '' ?></div>
        </div>

        <!-- Date of Birth -->
        <div class="mb-3">
          <label class="form-label">Date of Birth *</label>
          <input type="date" name="dob"
                 class="form-control <?= isset($errors['dob'])?'is-invalid':'' ?>"
                 value="<?= date('Y-m-d', strtotime($user['DOB'] ?? '')) ?>">
          <div class="invalid-feedback"><?= $errors['dob'] ?? '' ?></div>
        </div>

        <!-- Email (disabled) -->
        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <input type="email" class="form-control" disabled
                 value="<?= htmlspecialchars($user['EMAIL'] ?? '') ?>">
        </div>

        <!-- Gender (disabled) -->
        <div class="mb-3">
          <label class="form-label">Gender</label>
          <input type="text" class="form-control" disabled
                 value="<?= htmlspecialchars($user['GENDER'] ?? '') ?>">
        </div>

        <!-- Change password -->
        <div class="mb-4">
          <a href="customer_password_manage.php">Change Password</a>
        </div>

        <!-- Submit -->
        <div class="d-grid">
          <button type="submit" name="btnSubmit" class="btn btn-primary">
            Save Changes
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<?php include 'includes/footer.php'; clearMsg(); ?>
