<?php
session_start();
session_unset();
session_destroy();

// Optional: Restart session to show logout message
session_start();
$_SESSION['passmessage'] = "Logged out successfully.";

// Optional redirect to login or home
$redirect = isset($_GET['redirect']) && $_GET['redirect'] === 'login'
    ? 'login.php'
    : 'index.php';

header("Location: $redirect");
exit();
?>
