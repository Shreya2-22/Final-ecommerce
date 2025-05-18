<?php
session_start();

// Destroy all session data
$_SESSION = [];
session_destroy();

// Optional: Set a logout success message using cookies or query param if needed

// Redirect to login page (change path as needed)
header("Location: ..pages/traderlogin.php");
exit;
?>
