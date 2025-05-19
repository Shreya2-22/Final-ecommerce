<?php
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Optional: Clear any session messages
unset($_SESSION['passmessage']);
unset($_SESSION['failmessage']);

// Redirect to login or homepage
header("Location: login.php"); // or index.php
exit();
?>
