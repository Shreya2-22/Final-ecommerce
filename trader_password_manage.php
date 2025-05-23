<?php
session_start();
include 'includes/connect.php';

// Restrict to traders only
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'trader') {
    header('Location: index.php');
    exit();
}

$error = 0;

if (isset($_POST['btnSubmit'])) {
    $currentpass = trim($_POST['currentpass']);
    $newpass     = trim($_POST['newpass']);
    $confirmpass = trim($_POST['confirmpass']);

    // ... (validation logic remains unchanged) ...

    // If no errors, update
    if ($error === 0) {
        $new_hashed = password_hash($newpass, PASSWORD_DEFAULT);
        $update_sql = "UPDATE user_master SET password = :newpass WHERE user_id = :id";
        $stmt2 = oci_parse($conn, $update_sql);
        oci_bind_by_name($stmt2, ':newpass', $new_hashed);
        oci_bind_by_name($stmt2, ':id', $_SESSION['id']);
        oci_execute($stmt2);

        $_SESSION['passmessage'] = 'Password Updated Successfully';
        header('Location: traderprofile.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password &ndash; Cleck-E-Mart</title>
    <link rel="stylesheet" href="css/manage.css">
    <?php include 'includes/traderheader.php'; include 'includes/tradersidebar.php'; ?>
    <style>
        /* Header / breadcrumb wrapper aligned with sidebar */
        .page-header {
            margin-left: 260px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #eef3ed;
            border-bottom: 1px solid #ddd;
        }
        .page-header .title {
            font-size: 28px;
            margin: 0;
            color: #333;
        }
        .page-header .breadcrumb {
            font-size: 14px;
            color: #666;
        }
        /* Main content wrapper */
        .content-wrapper {
            margin-left: 150px;
            margin-top:50px; /* pull up closer to header */
            padding: 0 20px 20px;
        }
        /* Centered form container (smaller and rounded) */
        .change-password-container {
            max-width: 500px;   /* further reduced width */
            margin: 0 auto;
            background: #ffffff;
            padding: 6px 8px; /* tighter padding */
            border-radius: 16px; /* more rounded */
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            position: relative;
            top: -250px;
        }
        .change-password-container h2 {
            text-align: left;
            margin: 0 0 10px 0; /* removed top margin */
            font-size: 18px;      /* smaller font */
            color: #222;
        }
        .change-password-container label {
            display: block;
            margin-bottom: 4px;
            font-weight: 600;
            color: #444;
        }
        .change-password-container input[type="password"] {
            width: 100%;
            padding: 10px 10px;    /* smaller height */
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 12px; /* rounded inputs */
            font-size: 14px;
        }
        .change-password-container .error {
            color: #d9534f;
            font-size: 12px;
            margin-top: -10px;
            margin-bottom: 10px;
        }
        #btnSubmit {
            width: 100%;
            padding: 8px;       /* smaller button */
            background-color: #F48037;
            color: #fff;
            font-size: 14px;    /* smaller text */
            border: none;
            border-radius: 12px; /* rounded button */
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #btnSubmit:hover {
            background-color: #7CC355;
        }
        @media only screen and (max-width: 768px) {
            .page-header, .content-wrapper {
                margin-left: 0;
                margin-top: 0;
            }
            .change-password-container {
                max-width: 100%;
                margin: 10px;
                top: 0;
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    
    <div class="content-wrapper">
        <div class="change-password-container">
            <h2>Change Password</h2>
            <form method="POST" action="">
                <label for="pcurrent">Current Password <span>*</span></label>
                <input type="password" id="pcurrent" name="currentpass" placeholder="Current password">
                <?php if (isset($error_current)) echo '<div class="error">'.$error_current.'</div>'; ?>

                <label for="pnew">New Password <span>*</span></label>
                <input type="password" id="pnew" name="newpass" placeholder="New password">
                <?php if (isset($error_new)) echo '<div class="error">'.$error_new.'</div>'; ?>

                <label for="pconfirm">Confirm Password <span>*</span></label>
                <input type="password" id="pconfirm" name="confirmpass" placeholder="Confirm password">
                <?php if (isset($error_confirm)) echo '<div class="error">'.$error_confirm.'</div>'; ?>

                <button type="submit" name="btnSubmit" id="btnSubmit">Save</button>
            </form>
        </div>
    </div>
    <?php include 'includes/traderfooter.php'; ?>
</body>
</html>
