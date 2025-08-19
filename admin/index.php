<?php
// Start the session to access session variables.
session_start();

// Check if the 'user_id' session variable is set.
// This variable is only set when an admin successfully logs in.
if (isset($_SESSION['user_id'])) {
    // If the user is logged in, redirect them to the main dashboard.
    header("Location: dashboard.php");
} else {
    // If the user is not logged in, redirect them to the login page.
    header("Location: login.php");
}
// Ensure no more code is executed after the redirect.
exit();
?>