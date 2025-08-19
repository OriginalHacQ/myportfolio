
<?php
require_once '../includes/db_connect.php';
require_once 'includes/auth_check.php';
// Fetch all posts
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="mb-0" style="font-weight:800;letter-spacing:1px;">Manage Blog Posts</h1>
            <a href="edit_post.php" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Add New Post</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="border-radius:18px;">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Title</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td style="font-weight:600;font-size:1.1em;"><?php echo htmlspecialchars($post['title']); ?></td>
                                    <td><?php echo $post['created_at']; ?></td>
                                    <td>
                                        <a href="edit_post.php?id=<?php echo $post['id']; ?>" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                                        <a href="manage_posts.php?delete=<?php echo $post['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Delete this post?');"><i class="bi bi-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<?php
// Handle delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_posts.php");
    exit();
}
