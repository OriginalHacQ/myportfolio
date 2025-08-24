<?php
// Securely update the admin password in the database
require 'includes/db_connect.php';

$newPassword = 'YourNewStrongPassword'; // Change this to your new strong password
$hash = password_hash('hack1030', PASSWORD_DEFAULT);

$sql = "UPDATE users SET password = :hash WHERE username = 'admin'";
$stmt = $pdo->prepare($sql);
$stmt->execute(['hash' => $hash]);

if ($stmt->rowCount()) {
    echo "Admin password updated successfully.";
} else {
    echo "No admin user found or password unchanged.";
}
