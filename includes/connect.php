<?php
// establishes $conn
$dbUser = 'ecommerce';
$dbPass = 'ecommerce';
$dbString = '//localhost/xe';
$conn = oci_connect($dbUser, $dbPass, $dbString);
if (!$conn) {
    $e = oci_error();
    die("Oracle connect error: " . htmlentities($e['message']));
}
