<?php
// Run this script once to generate a hashed password for your admin user
$plainPassword = 'hack123';
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);
echo "Hashed password for 'hack123':<br>" . $hashedPassword;
