<?php
// Replace this with any password you want to encrypt
$password = 'Shreya_@123';

// Encrypt (hash) the password using bcrypt
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Display the result
echo "Original Password: $password\n";
echo "Encrypted (Hashed) Password: $hashedPassword\n";
?>
