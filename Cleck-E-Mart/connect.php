<?php
$dbUser = 'CLECK';
$dbPass = 'emart';

// Recommended full TNS format for clarity
$dbString = '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521))(CONNECT_DATA=(SERVICE_NAME=XE)))';

$conn = oci_connect($dbUser, $dbPass, $dbString);
if (!$conn) {
    $e = oci_error();
    die("Oracle connect error: " . htmlentities($e['message']));
}
echo "Connected to Oracle 11g XE successfully!";
?>
