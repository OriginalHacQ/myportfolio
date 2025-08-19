<?php
require '../includes/db_connect.php';
include 'includes/header.php';

$project = ['id' => '', 'title' => '', 'description' => '', 'tech_stack' => '', 'image_url' => ''];
$page_title = 'Add New Project';
$is_edit = false;

// --- EDIT MODE: Check for ID and fetch project data ---
if (isset($_GET['id'])) {
    $is_edit = true;
    $project_id = $_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM projects WHERE id = ?");
    $stmt->execute([$project_id]);
    $project = $stmt->fetch();
    if (!$project) {
        $_SESSION['message'] = "Project not found.";
        header("Location: manage_projects.php");
        exit();
    }
    $page_title = 'Edit Project';
}

// --- FORM SUBMISSION LOGIC ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $tech_stack = $_POST['tech_stack'];
    $id = $_POST['id'];
    $current_image = $_POST['current_image'];
    $image_url = $current_image;

    // --- Image Upload Handling ---
    if (isset($_FILES['project_image']) && $_FILES['project_image']['error'] == 0) {
        $target_dir = "../assets/uploads/";
        $image_name = uniqid() . '-' . basename($_FILES["project_image"]["name"]);
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES["project_image"]["tmp_name"], $target_file)) {
            $image_url = "assets/uploads/" . $image_name;
            // Optionally, delete the old image if it exists and is different
            if ($is_edit && !empty($current_image) && file_exists('../' . $current_image)) {
                unlink('../' . $current_image);
            }
        } else {
            $_SESSION['message'] = "Error uploading file.";
            header("Location: manage_projects.php"); exit();
        }
    }

    if ($is_edit || !empty($id)) {
        // --- UPDATE ---
        $stmt = $pdo->prepare("UPDATE projects SET title=?, description=?, tech_stack=?, image_url=? WHERE id=?");
        $stmt->execute([$title, $description, $tech_stack, $image_url, $id]);
        $_SESSION['message'] = "Project updated successfully.";
    } else {
        // --- INSERT ---
        $stmt = $pdo->prepare("INSERT INTO projects (title, description, tech_stack, image_url) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $description, $tech_stack, $image_url]);
        $_SESSION['message'] = "Project added successfully.";
    }

    header("Location: manage_projects.php");
    exit();
}
?>

<h1><?php echo $page_title; ?></h1>

<form action="edit_project.php<?php if ($is_edit) echo '?id='.$project['id']; ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($project['id']); ?>">
    <input type="hidden" name="current_image" value="<?php echo htmlspecialchars($project['image_url']); ?>">

    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo htmlspecialchars($project['title']); ?>" required>
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea class="form-control" name="description" rows="5" required><?php echo htmlspecialchars($project['description']); ?></textarea>
    </div>
    <div class="mb-3">
        <label for="tech_stack" class="form-label">Tech Stack (comma-separated)</label>
        <input type="text" class="form-control" name="tech_stack" value="<?php echo htmlspecialchars($project['tech_stack']); ?>">
    </div>
    <div class="mb-3">
        <label for="project_image" class="form-label">Project Image</label>
        <input type="file" class="form-control" name="project_image">
        <?php if ($is_edit && !empty($project['image_url'])): ?>
            <p class="mt-2">Current Image: <img src="../<?php echo htmlspecialchars($project['image_url']); ?>" width="150"></p>
        <?php endif; ?>
    </div>

    <button type="submit" class="btn btn-primary">Save Project</button>
    <a href="manage_projects.php" class="btn btn-secondary">Cancel</a>
</form>

</div></body>
</html>