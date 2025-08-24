<?php
require '../includes/db_connect.php';
include 'includes/header.php';


$resumePath = '../assets/uploads/resume.pdf';
$resumeExists = file_exists($resumePath);

// Handle upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['resume'])) {
    $file = $_FILES['resume'];
    if ($file['error'] === UPLOAD_ERR_OK && strtolower(pathinfo($file['name'], PATHINFO_EXTENSION)) === 'pdf') {
        if (move_uploaded_file($file['tmp_name'], $resumePath)) {
            $message = 'Resume uploaded successfully!';
            $resumeExists = true;
        } else {
            $error = 'Failed to upload resume.';
        }
    } else {
        $error = 'Please upload a valid PDF file.';
    }
}
// Handle delete
if (isset($_POST['delete_resume'])) {
    if ($resumeExists && unlink($resumePath)) {
        $message = 'Resume deleted successfully!';
        $resumeExists = false;
    } else {
        $error = 'No resume to delete or failed to delete.';
    }
}
?>
<div class="container mt-4">
    <h2 class="mb-4">Manage Resume</h2>
    <?php if (!empty($message)): ?>
        <div class="alert alert-success"> <?= htmlspecialchars($message) ?> </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"> <?= htmlspecialchars($error) ?> </div>
    <?php endif; ?>
    <div class="card p-4 mb-3">
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="resume" class="form-label">Upload Resume (PDF only):</label>
                <input type="file" class="form-control" id="resume" name="resume" accept="application/pdf" required>
            </div>
            <button type="submit" class="btn btn-primary">Upload Resume</button>
        </form>
    </div>
    <?php if ($resumeExists): ?>
        <div class="mb-3">
            <a href="../assets/uploads/resume.pdf" target="_blank" class="btn btn-outline-success">View Current Resume</a>
            <form method="post" style="display:inline;">
                <button type="submit" name="delete_resume" class="btn btn-outline-danger" onclick="return confirm('Delete the current resume?');">Delete Resume</button>
            </form>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">No resume currently uploaded.</div>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
