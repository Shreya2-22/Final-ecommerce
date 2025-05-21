<?php
// pass_change.php
session_start();
require 'includes/connect.php';

// 1) Gather & validate params
$token  = $_GET['token']  ?? '';
$userId = (int)($_GET['id'] ?? 0);

if (!$token || !$userId) {
    $_SESSION['failmessage'] = 'Invalid reset link.';
    header('Location: pass_reset.php');
    exit;
}

// 2) Case-insensitive token check
$sql = "
  SELECT 1
    FROM PASSWORD_RESET
   WHERE LOWER(token)       = LOWER('{$token}')
     AND fk1_user_id        = {$userId}
";
$stm = oci_parse($conn, $sql);
oci_execute($stm);
if (!oci_fetch($stm)) {
    $_SESSION['failmessage'] = 'Invalid or expired reset link.';
    header('Location: pass_reset.php');
    exit;
}

// 3) Handle form submission
$errors = [];
if (isset($_POST['submit'])) {
    $new     = trim($_POST['newpass'] ?? '');
    $confirm = trim($_POST['conpass'] ?? '');

    if ($new === '') {
        $errors['newpass'] = 'Please enter a new password.';
    }
    if ($confirm === '') {
        $errors['conpass'] = 'Please confirm your new password.';
    } elseif ($new !== $confirm) {
        $errors['conpass'] = 'Passwords do not match.';
    }

    if (empty($errors)) {
        // Update password
        $hash   = password_hash($new, PASSWORD_DEFAULT);
        $updSql = "
          UPDATE user_master
             SET password = '{$hash}'
           WHERE user_id  = {$userId}
        ";
        $uStm = oci_parse($conn, $updSql);
        oci_execute($uStm, OCI_COMMIT_ON_SUCCESS);

        // Delete token
        $delSql = "
          DELETE FROM PASSWORD_RESET
           WHERE LOWER(token)       = LOWER('{$token}')
             AND fk1_user_id        = {$userId}
        ";
        $dStm = oci_parse($conn, $delSql);
        oci_execute($dStm, OCI_COMMIT_ON_SUCCESS);

        $_SESSION['passmessage'] = 'Your password has been reset. Please log in.';
        header('Location: login.php');
        exit;
    }
}

include 'includes/header.php';
?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Reset Your Password</h2>
  <?php if (!empty($_SESSION['failmessage'])): ?>
    <div class="alert alert-danger mb-4">
      <?= $_SESSION['failmessage']; unset($_SESSION['failmessage']); ?>
    </div>
  <?php endif; ?>

  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <form method="POST" novalidate>
        <div class="mb-3">
          <label class="form-label">New Password *</label>
          <input
            type="password" name="newpass"
            class="form-control <?= isset($errors['newpass'])?'is-invalid':'' ?>"
          >
          <div class="invalid-feedback"><?= $errors['newpass'] ?? '' ?></div>
        </div>
        <div class="mb-3">
          <label class="form-label">Confirm Password *</label>
          <input
            type="password" name="conpass"
            class="form-control <?= isset($errors['conpass'])?'is-invalid':'' ?>"
          >
          <div class="invalid-feedback"><?= $errors['conpass'] ?? '' ?></div>
        </div>
        <div class="d-grid">
          <button type="submit" name="submit" class="btn btn-primary">
            Submit
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'includes/footer.php'; clearMsg(); ?>
