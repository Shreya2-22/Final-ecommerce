<?php
session_start();

// Clear all session variables
$_SESSION = [];

// Destroy the session cookie if it exists
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Optional: set a logout success message (can be shown in login page)
session_start(); // restart session to store message
$_SESSION['passmessage'] = "✅ You have been logged out successfully.";

// Redirect to login page
header("Location: login.php");
exit();
