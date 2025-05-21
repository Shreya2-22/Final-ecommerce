<?php
// customer_password_manage.php
session_start();
require 'includes/connect.php';

// 1) Guard: only customers
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
    header('Location: login.php');
    exit;
}
$userId = (int)$_SESSION['id'];

// 2) Handle form submission
$errors = [];
if (isset($_POST['btnSubmit'])) {
    $current = trim($_POST['currentpass'] ?? '');
    $new     = trim($_POST['newpass'] ?? '');
    $confirm = trim($_POST['confirmpass'] ?? '');

    // fetch existing hash
    $sql = "SELECT password FROM user_master WHERE user_id = {$userId}";
    $stm = oci_parse($conn, $sql);
    oci_execute($stm);
    $row = oci_fetch_assoc($stm);
    $hash = $row['PASSWORD'] ?? '';

    // validate current
    if ($current === '') {
        $errors['current'] = 'Please enter your current password.';
    } elseif (!password_verify($current, $hash)) {
        $errors['current'] = 'Current password is incorrect.';
    }

    // validate new
    if ($new === '') {
        $errors['new'] = 'Please enter a new password.';
    } elseif (password_verify($new, $hash)) {
        $errors['new'] = 'New password cannot be the same as the old one.';
    }

    // validate confirm
    if ($confirm === '') {
        $errors['confirm'] = 'Please confirm your new password.';
    } elseif ($confirm !== $new) {
        $errors['confirm'] = 'Passwords do not match.';
    }

    // if no errors, update
    if (empty($errors)) {
        $newHash = password_hash($new, PASSWORD_DEFAULT);
        $updSql  = "
  UPDATE user_master
     SET password = '{$newHash}'
   WHERE user_id  = {$userId}
";
        $ustm = oci_parse($conn, $updSql);
        oci_execute($ustm, OCI_COMMIT_ON_SUCCESS);
        $_SESSION['passmessage'] = 'Password updated successfully.';
        header('Location: customer_profile_setting.php');
        exit;
    }
}

include 'includes/header.php';
?>
<div class="container py-5">
    <h2 class="mb-4 text-center">Change Password</h2>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form method="POST" novalidate>
                <!-- Current Password -->
                <div class="mb-3">
                    <label class="form-label">Current Password *</label>
                    <input type="password" name="currentpass"
                        class="form-control <?= isset($errors['current']) ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= $errors['current'] ?? '' ?></div>
                </div>
                <!-- New Password -->
                <div class="mb-3">
                    <label class="form-label">New Password *</label>
                    <input type="password" name="newpass"
                        class="form-control <?= isset($errors['new']) ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= $errors['new'] ?? '' ?></div>
                </div>
                <!-- Confirm Password -->
                <div class="mb-3">
                    <label class="form-label">Confirm New Password *</label>
                    <input type="password" name="confirmpass"
                        class="form-control <?= isset($errors['confirm']) ? 'is-invalid' : '' ?>">
                    <div class="invalid-feedback"><?= $errors['confirm'] ?? '' ?></div>
                </div>
                <div class="d-grid">
                    <button type="submit" name="btnSubmit" class="btn btn-primary">
                        Update Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php include 'includes/footer.php';
clearMsg(); ?>