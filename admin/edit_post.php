<?php
require_once '../includes/db_connect.php';
require_once 'includes/auth_check.php';

// Initialize variables
$title = $content = '';
$is_edit = false;

// Edit mode
if (isset($_GET['id'])) {
    $is_edit = true;
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
    if ($post) {
        $title = $post['title'];
        $content = $post['content'];
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    if ($is_edit) {
        $stmt = $pdo->prepare("UPDATE posts SET title=?, content=? WHERE id=?");
        $stmt->execute([$title, $content, $id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->execute([$title, $content]);
    }
    header("Location: manage_posts.php");
    exit();
}
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
    <h1><?php echo $is_edit ? 'Edit' : 'Add'; ?> Blog Post</h1>
    <form method="post">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($title); ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" rows="8" required><?php echo htmlspecialchars($content); ?></textarea>
        </div>
        <button type="submit" class="btn btn-success">Save</button>
        <a href="manage_posts.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
