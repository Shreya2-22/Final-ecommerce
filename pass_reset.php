<?php
// pass_reset.php
session_start();
require 'includes/connect.php';

if (isset($_POST['submit'])) {
    $email = trim($_POST['email'] ?? '');
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['failmessage'] = 'Please enter a valid email address.';
    } else {
        // Lookup user
        $sql = "SELECT user_id FROM user_master WHERE email = :email";
        $stm = oci_parse($conn, $sql);
        oci_bind_by_name($stm, 'email', $email);
        oci_execute($stm);

        if ($row = oci_fetch_assoc($stm)) {
            $userId = $row['USER_ID'];
            // Generate and store token
            $token = bin2hex(openssl_random_pseudo_bytes(16));
            $ins = oci_parse($conn,
                "INSERT INTO PASSWORD_RESET(token, fk1_user_id)
                 VALUES(:token, :uid)"
            );
            oci_bind_by_name($ins, 'token', $token);
            oci_bind_by_name($ins, 'uid',   $userId);
            oci_execute($ins, OCI_COMMIT_ON_SUCCESS);

            header("Location: pass_reset_email.php?token={$token}&id={$userId}&email=" . urlencode($email));
            exit;
        } else {
            $_SESSION['failmessage'] = 'That email address is not registered.';
        }
    }
}

include 'includes/header.php';
?>

<!-- Make body flex-column full height -->
<script>
  document.documentElement.style.height = '100%';
  document.body.classList.add('d-flex','flex-column','min-vh-100','p-0');
</script>

<main class="flex-fill">
  <div class="container py-5">
    <h2 class="mb-4 text-center">Forgot Password</h2>

    <!-- Flash messages -->
    <?php if (!empty($_SESSION['failmessage'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?= $_SESSION['failmessage']; unset($_SESSION['failmessage']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['passmessage'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?= $_SESSION['passmessage']; unset($_SESSION['passmessage']); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    <?php endif; ?>

    <div class="row justify-content-center">
      <div class="col-md-6 col-lg-5">
        <form method="POST" novalidate>
          <div class="mb-3">
            <label class="form-label">Email Address</label>
            <input
              type="email"
              name="email"
              class="form-control"
              placeholder="Enter your email"
              required
            >
          </div>
          <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">
              Send Reset Link
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>

<?php
include 'includes/footer.php';
clearMsg();
