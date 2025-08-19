
<?php
require '../includes/db_connect.php';
include 'includes/header.php';

// Handle add, edit, delete skill (with image upload)
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_skill'])) {
        $skill = trim($_POST['skill']);
        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            $file_type = mime_content_type($_FILES['image']['tmp_name']);
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($file_type, $allowed) && in_array($ext, ['png','jpg','jpeg','gif'])) {
                $target_dir = '../assets/skill_icons/';
                $img_name = 'skill_' . uniqid() . '.' . $ext;
                $target_file = $target_dir . $img_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_path = 'assets/skill_icons/' . $img_name;
                }
            }
        }
        if ($skill) {
            $stmt = $pdo->prepare("INSERT INTO skills (name, image) VALUES (?, ?)");
            $stmt->execute([$skill, $image_path]);
            $msg = '<div class="alert alert-success">Skill added.</div>';
        }
    } elseif (isset($_POST['edit_skill'])) {
        $id = (int)$_POST['skill_id'];
        $skill = trim($_POST['skill']);
        $image_path = $_POST['current_image'];
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $allowed = ['image/png', 'image/jpeg', 'image/jpg', 'image/gif'];
            $file_type = mime_content_type($_FILES['image']['tmp_name']);
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            if (in_array($file_type, $allowed) && in_array($ext, ['png','jpg','jpeg','gif'])) {
                $target_dir = '../assets/skill_icons/';
                $img_name = 'skill_' . uniqid() . '.' . $ext;
                $target_file = $target_dir . $img_name;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    // Delete old image if exists
                    if (!empty($image_path) && file_exists('../' . $image_path)) {
                        unlink('../' . $image_path);
                    }
                    $image_path = 'assets/skill_icons/' . $img_name;
                }
            }
        }
        if ($skill) {
            $stmt = $pdo->prepare("UPDATE skills SET name = ?, image = ? WHERE id = ?");
            $stmt->execute([$skill, $image_path, $id]);
            $msg = '<div class="alert alert-success">Skill updated.</div>';
        }
    } elseif (isset($_POST['delete_skill'])) {
        $id = (int)$_POST['skill_id'];
        // Delete image file
        $stmt = $pdo->prepare("SELECT image FROM skills WHERE id = ?");
        $stmt->execute([$id]);
        $img = $stmt->fetchColumn();
        if ($img && file_exists('../' . $img)) {
            unlink('../' . $img);
        }
        $stmt = $pdo->prepare("DELETE FROM skills WHERE id = ?");
        $stmt->execute([$id]);
        $msg = '<div class="alert alert-success">Skill deleted.</div>';
    }
}

// Fetch all skills
$skills = $pdo->query("SELECT * FROM skills ORDER BY id ASC")->fetchAll();
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="mb-0" style="font-weight:800;letter-spacing:1px;">Manage Skills</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card shadow-sm border-0" style="border-radius:18px;">
                <div class="card-body p-4">
                    <?php if ($msg) echo $msg; ?>
                    <form method="post" enctype="multipart/form-data" class="mb-4 row g-2 align-items-center">
                        <div class="col-md-5">
                            <input type="text" name="skill" class="form-control" placeholder="Add new skill" required>
                        </div>
                        <div class="col-md-5">
                            <input type="file" name="image" class="form-control" accept="image/*">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" name="add_skill" class="btn btn-success w-100"><i class="bi bi-plus-circle"></i> Add</button>
                        </div>
                    </form>
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr><th>Logo</th><th>Skill</th><th style="width:120px;">Actions</th></tr>
                        </thead>
                        <tbody>
                        <?php foreach ($skills as $sk): ?>
                            <tr>
                                <form method="post" enctype="multipart/form-data" class="d-flex align-items-center">
                                    <td>
                                        <?php if (!empty($sk['image'])): ?>
                                            <img src="../<?php echo htmlspecialchars($sk['image']); ?>" alt="" width="36" height="36" style="object-fit:contain;border-radius:6px;">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <input type="hidden" name="skill_id" value="<?php echo $sk['id']; ?>">
                                        <input type="text" name="skill" value="<?php echo htmlspecialchars($sk['name']); ?>" class="form-control" required>
                                        <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($sk['image']); ?>">
                                        <input type="file" name="image" class="form-control mt-1" accept="image/*">
                                    </td>
                                    <td>
                                        <button type="submit" name="edit_skill" class="btn btn-outline-primary btn-sm me-1"><i class="bi bi-pencil"></i></button>
                                        <button type="submit" name="delete_skill" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this skill?');"><i class="bi bi-trash"></i></button>
                                    </td>
                                </form>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
