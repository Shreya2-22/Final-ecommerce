<title>Collection slot & checkout</title>

<?php
session_start();
require_once "includes/connect.php";

// ─── 1) AUTH GUARD ────────────────────────────────────────────────────────────
if (empty($_SESSION['id']) || $_SESSION['role'] !== 'customer') {
    $_SESSION['failmessage'] = "You need to be logged in as a customer.";
    header("Location: login.php");
    exit;
}
$uid = (int)$_SESSION['id'];

// ─── 2) RECOMPUTE CART TOTAL ──────────────────────────────────────────────────
// Inline the user ID to avoid any bind-variable naming issues
$sql = "
  SELECT NVL(SUM(c.quantity * p.product_price),0) AS total
    FROM cart c
    JOIN product p
      ON p.product_id = c.fk2_product_id
   WHERE c.fk1_user_id = {$uid}
";
$stm = oci_parse($conn, $sql);
oci_execute($stm);
$row = oci_fetch_assoc($stm);
$grandTotal = $row ? (float)$row['TOTAL'] : 0.0;

// ─── 3) RECALL SLOT SELECTION ─────────────────────────────────────────────────
$oldWeek = $_SESSION['chooseweek'] ?? '';
$oldDay  = $_SESSION['chooseday']  ?? '';
$oldTime = $_SESSION['choosetime'] ?? '';

// ─── 4) HANDLE “APPLY” CLICK ─────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['btnApply'])) {
    // reset payment gate
    $_SESSION['payEnabled'] = false;

    $week = $_POST['chooseweek'] ?? '';
    $day  = (int)($_POST['chooseday'] ?? 0);
    $time = (int)($_POST['choosetime'] ?? 0);

    if ($week && $day && $time) {
        date_default_timezone_set('Asia/Kathmandu');
        $today = (int)date('w');  // 0 (Sun) – 6 (Sat)
        $hour  = (int)date('G');  // 0–23

        $avail = [10,13,16];
        $err   = 0;

        // same-week logic
        if ($week === 'thisWeek') {
            if ($day <= $today) {
                $_SESSION['failmessage'] = $today >= 5
                    ? "Please choose a slot next week."
                    : "Please choose a slot at least 24 hrs ahead.";
                $err++;
            }
            elseif ($day - $today === 1) {
                if      ($hour >= 16) $err++;
                elseif  ($hour >= 13) $avail = [16];
                elseif  ($hour >= 10) $avail = [13,16];
            }
            if (!$err && !in_array($time, $avail, true)) {
                $_SESSION['failmessage'] = "Please choose a slot at least 24 hrs ahead.";
                $err++;
            }
        }

        if (!$err) {
            $_SESSION['passmessage']  = "Slot selection successful.";
            $_SESSION['chooseweek']   = $week;
            $_SESSION['chooseday']    = $day;
            $_SESSION['choosetime']   = $time;
            $_SESSION['payEnabled']   = true;
        }

    } else {
        $_SESSION['failmessage'] = "Please choose all slots.";
    }

    header("Location: collection.php");
    exit;
}

// ─── 5) SHOULD WE RENDER PAYPAL? ───────────────────────────────────────────────
$pay = !empty($_SESSION['payEnabled']) && $grandTotal > 0;
if (!empty($_SESSION['payEnabled']) && $grandTotal <= 0) {
    $_SESSION['failmessage'] = "Your cart is empty. Add items before payment.";
}

include "includes/header.php";
?>
<link rel="stylesheet" href="css/collection.css">

<div class="container py-5 col-lg-6 mx-auto" id="main">
  <!-- FLASHES -->
  <?php if (!empty($_SESSION['failmessage'])): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <?= $_SESSION['failmessage'] ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['failmessage']); ?>
  <?php endif; ?>

  <?php if (!empty($_SESSION['passmessage'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <?= $_SESSION['passmessage'] ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['passmessage']); ?>
  <?php endif; ?>

  <!-- COLLECTION SLOT FORM -->
  <div class="card shadow-sm mb-4">
    <div class="card-header">
      <h5 class="text-center mb-0">Collection Slot</h5>
    </div>
    <div class="card-body">
      <form method="POST" novalidate>
        <div class="mb-3">
          <label class="form-label">Choose Week <span class="text-danger">*</span></label>
          <select name="chooseweek" class="form-select" required>
            <option disabled hidden>-- Choose Week --</option>
            <option value="thisWeek" <?= $oldWeek==='thisWeek'?'selected':'' ?>>This Week</option>
            <option value="nextWeek" <?= $oldWeek==='nextWeek'?'selected':'' ?>>Next Week</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Choose Day <span class="text-danger">*</span></label>
          <select name="chooseday" class="form-select" required>
            <option disabled hidden>-- Choose Day --</option>
            <option value="3" <?= $oldDay===3?'selected':'' ?>>Wednesday</option>
            <option value="4" <?= $oldDay===4?'selected':'' ?>>Thursday</option>
            <option value="5" <?= $oldDay===5?'selected':'' ?>>Friday</option>
          </select>
        </div>
        <div class="mb-3">
          <label class="form-label">Collection Time <span class="text-danger">*</span></label>
          <select name="choosetime" class="form-select" required>
            <option disabled hidden>-- Choose Time --</option>
            <option value="10" <?= $oldTime===10?'selected':'' ?>>10 AM – 1 PM</option>
            <option value="13" <?= $oldTime===13?'selected':'' ?>>1 PM – 4 PM</option>
            <option value="16" <?= $oldTime===16?'selected':'' ?>>4 PM – 7 PM</option>
          </select>
        </div>
        <div class="text-center">
          <button name="btnApply" type="submit" class="btn btn-primary px-4">Apply</button>
        </div>
      </form>
    </div>
  </div>

  <!-- PAYMENT GATEWAY CARD -->
  <div class="card shadow-sm">
    <div class="card-header">
      <h5 class="text-center mb-0">Payment Gateway</h5>
    </div>
    <div class="card-body text-center">
      <img src="images/PayPal.png" class="img-fluid mb-3" style="max-width:60%;" alt="PayPal Logo">
      <div id="paypal-payment-button"></div>
    </div>
  </div>
</div>

<?php if ($pay): ?>
  <!--
    6) PayPal SDK — single line below. Swap out the client-id with
       YOUR sandbox REST-API App’s Client ID from developer.paypal.com
  -->
  <script src="https://www.paypal.com/sdk/js?client-id=AWF3eVi_e4SE83h5VKIrE80N111AQclcNIVLQZuxKLowoVoZyQdWfutzgSg2vq9r739mDw4IPPqJYP8_&currency=GBP&disable-funding=credit,card"></script>
  <script>
    // pass PHP total to JS
    const total = <?= json_encode($grandTotal) ?>;

    paypal.Buttons({
      style:  { layout:'vertical', color:'blue', shape:'pill', label:'checkout' },
      createOrder: (d, a) =>
        a.order.create({ purchase_units:[{
          amount: { value: total.toFixed(2), currency_code:'GBP' }
        }] }),
      onApprove: (d, a) =>
        a.order.capture().then(() => {
          window.location.href = `success.php?orderID=${ encodeURIComponent(d.orderID) }`;
        }),
      onCancel: () => alert('Payment cancelled.'),
      onError: err => {
        console.error('PayPal error:', err);
        alert(`Payment error: ${ err.message || err }`);
      }
    }).render('#paypal-payment-button');
  </script>
<?php endif; ?>

<?php include "includes/footer.php"; ?>
