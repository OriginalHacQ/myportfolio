<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// --- Database Credentials ---
$db_host = 'localhost';
$db_name = 'myportfolio'; // The name of your database
$db_user = 'root';         // Default XAMPP MySQL username
$db_pass = '';             // Default XAMPP MySQL password (empty)

// --- PDO Connection ---
try {
    // Create a new PDO instance
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8mb4", $db_user, $db_pass);
    
    // Set PDO attributes for error handling and fetch mode
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // If connection fails, stop the script and show an error
    die("ERROR: Could not connect to the database. " . $e->getMessage());
}
?>