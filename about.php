<?php 
require 'includes/db_connect.php';
include 'includes/header.php'; 

$stmt = $pdo->query("SELECT * FROM about WHERE id = 1");
$about = $stmt->fetch();
?>

<div class="row align-items-center">
    <div class="col-md-4 text-center">
        <?php if (!empty($about['photo_url'])): ?>
            <img src="<?php echo htmlspecialchars($about['photo_url']); ?>" class="img-fluid rounded-circle mb-3" alt="Profile Photo">
        <?php endif; ?>
    </div>
    <div class="col-md-8">
        <h1>About Me</h1>
        <p class="lead"><?php echo nl2br(htmlspecialchars($about['bio'] ?? '')); ?></p>
        <hr>
        <h3>My Skills</h3>
        <p>
            <?php 
            $skills = explode(',', $about['skills'] ?? '');
            foreach ($skills as $skill):
            ?>
                <span class="badge bg-primary fs-6 m-1"><?php echo htmlspecialchars(trim($skill)); ?></span>
            <?php endforeach; ?>
        </p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>