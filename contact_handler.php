<?php
session_start();
require 'includes/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL));
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING));

    if (empty($name) || empty($email) || empty($message)) {
        $_SESSION['error'] = "Please fill out all fields.";
        header("Location: contact.php");
        exit();
    }

    try {
        // 1. Save message to the database
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);

        // 2. (Optional) Send an email notification
        // Note: mail() function might not work on local servers like XAMPP without configuration.
        $to = "your-email@example.com"; // CHANGE THIS!
        $subject = "New Message from your Portfolio from " . $name;
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: no-reply@yourdomain.com"; // CHANGE THIS!
        
        // mail($to, $subject, $body, $headers);

        $_SESSION['message'] = "Thank you for your message! I will get back to you shortly.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "There was a problem sending your message. Please try again.";
        // Optional: log the error -> error_log($e->getMessage());
    }
    
    header("Location: contact.php");
    exit();
}
?>