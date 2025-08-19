<?php
require '../includes/db_connect.php';
require 'includes/auth_check.php';

if (!isset($_GET['id'])) {
    header("Location: manage_projects.php");
    exit();
}

$id = $_GET['id'];

// First, get the image URL to delete the file
$stmt = $pdo->prepare("SELECT image_url FROM projects WHERE id = ?");
$stmt->execute([$id]);
$project = $stmt->fetch();

if ($project && !empty($project['image_url'])) {
    if (file_exists('../' . $project['image_url'])) {
        unlink('../' . $project['image_url']);
    }
}

// Now, delete the database record
$stmt = $pdo->prepare("DELETE FROM projects WHERE id = ?");
$stmt->execute([$id]);

$_SESSION['message'] = "Project deleted successfully.";
header("Location: manage_projects.php");
exit();
?>