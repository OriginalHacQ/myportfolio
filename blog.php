<?php
require_once 'includes/db_connect.php';
$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>
<?php include 'includes/header.php'; ?>
<div class="container mt-4">
    <h1>Blog</h1>
    <?php foreach ($posts as $post): ?>
        <div class="card mb-4">
            <div class="card-body">
                <h3 class="card-title"><?php echo htmlspecialchars($post['title']); ?></h3>
                <p class="card-text"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <small class="text-muted">Posted on <?php echo $post['created_at']; ?></small>
            </div>
        </div>
    <?php endforeach; ?>
    <?php if (empty($posts)): ?>
        <p>No blog posts yet.</p>
    <?php endif; ?>
</div>
<?php include 'includes/footer.php'; ?>
