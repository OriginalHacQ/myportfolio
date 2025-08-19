
<?php
require '../includes/db_connect.php';
include 'includes/header.php';

// --- FORM SUBMISSION LOGIC ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bio = $_POST['bio'];
    $skills = $_POST['skills'];
    $current_photo = $_POST['current_photo'];
    $photo_url = $current_photo;

    // --- Photo Upload Handling with Validation ---
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif', 'image/jpg'];
        $file_type = mime_content_type($_FILES['photo']['tmp_name']);
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        if (in_array($file_type, $allowed_types) && in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
            $target_dir = "../assets/uploads/";
            $image_name = 'profile-' . uniqid() . '.' . $ext;
            $target_file = $target_dir . $image_name;
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo_url = "assets/uploads/" . $image_name;
                if (!empty($current_photo) && file_exists('../' . $current_photo)) {
                    unlink('../' . $current_photo);
                }
            } else {
                $_SESSION['message'] = "Failed to upload image. Please try again.";
                header("Location: edit_about.php"); exit();
            }
        } else {
            $_SESSION['message'] = "Invalid file type. Please upload a JPG, PNG, or GIF image.";
            header("Location: edit_about.php"); exit();
        }
    }
    $stmt = $pdo->prepare("UPDATE about SET bio = ?, skills = ?, photo_url = ? WHERE id = 1");
    $stmt->execute([$bio, $skills, $photo_url]);
    $_SESSION['message'] = "About page updated successfully.";
    header("Location: edit_about.php"); exit();
}

// Fetch current data
$stmt = $pdo->query("SELECT * FROM about WHERE id = 1");
$about = $stmt->fetch();
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="mb-0" style="font-weight:800;letter-spacing:1px;">Edit 'About Me' Page</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0" style="border-radius:18px;">
                <div class="card-body p-4">
                    <form action="edit_about.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="current_photo" value="<?php echo htmlspecialchars($about['photo_url']); ?>">
                        <div class="mb-3">
                            <label for="bio" class="form-label">Biography</label>
                            <textarea class="form-control" name="bio" rows="8" required><?php echo htmlspecialchars($about['bio']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="skills" class="form-label">Skills (comma-separated)</label>
                            <input type="text" class="form-control" name="skills" value="<?php echo htmlspecialchars($about['skills']); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="photo" class="form-label">Profile Photo</label>
                            <input type="file" class="form-control" name="photo">
                            <?php if (!empty($about['photo_url'])): ?>
                                <p class="mt-2">Current Photo:<br> <img src="../<?php echo htmlspecialchars($about['photo_url']); ?>" width="120" class="rounded-circle shadow"></p>
                            <?php endif; ?>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>