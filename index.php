
<?php 
require 'includes/db_connect.php';
include 'includes/header.php'; 

$stmt_about = $pdo->query("SELECT * FROM about WHERE id = 1");
$about = $stmt_about->fetch();
?>

<!-- Hero Section -->

<!-- Hero Section -->
<section class="text-center py-5 mb-5 hero-section">
    <h1 class="hero-title mb-2">I'm Agyemang Kofi Hackman</h1>
    <h2 class="hero-subtitle mb-3">IT Professional & Web Developer</h2>
    <p class="hero-tagline mb-4">Building smart solutions with <span class="hero-highlight">PHP</span>, <span class="hero-highlight">MySQL</span>, and creativity</p>
    <a href="portfolio.php" class="btn btn-primary btn-lg me-2">View My Work</a>
    <a href="assets/uploads/resume.pdf" class="btn btn-outline-primary btn-lg" download>Download Resume</a>
</section>

<!-- About Me Section -->
<section class="row align-items-center mb-5">
    <div class="col-md-4 text-center">
        <?php if (!empty($about['photo_url'])): ?>
            <img src="<?php echo htmlspecialchars($about['photo_url']); ?>" class="img-fluid rounded-circle mb-3" alt="Profile Photo" style="width:220px;height:220px;object-fit:cover;">
        <?php endif; ?>
    </div>
    <div class="col-md-8">
        <h2>About Me</h2>
        <p class="lead"><?php echo nl2br(htmlspecialchars($about['bio'] ?? 'A passionate developer creating modern web solutions.')); ?></p>
        <a href="about.php" class="btn btn-outline-primary">Read More</a>
    </div>
</section>

<!-- Featured Projects Section -->
<section class="mb-5">
    <h2 class="text-center mb-4" style="font-weight:800;color:#d4af37;text-shadow:0 2px 8px rgba(212,175,55,0.12);">Featured Projects</h2>
    <div class="row">
        <?php
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC LIMIT 6");
        while ($project = $stmt->fetch()):
        ?>
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <img src="<?php echo htmlspecialchars($project['image_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($project['title']); ?>">
                <div class="card-body">
                    <h5 class="card-title fw-bold"><?php echo htmlspecialchars($project['title']); ?></h5>
                    <p class="card-text"><?php echo substr(htmlspecialchars($project['description']), 0, 100); ?>...</p>
                    <a href="portfolio.php" class="btn btn-sm btn-outline-primary">View Details</a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>


<!-- Skills Section -->
<section class="mb-5">
    <h2 class="text-center mb-4">Skills</h2>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex flex-wrap justify-content-center align-items-center gap-4 mb-4">
                <?php
                $skills = $pdo->query("SELECT * FROM skills ORDER BY id ASC")->fetchAll();
                foreach ($skills as $skill):
                    if (!empty($skill['image'])) {
                        echo '<img src="' . htmlspecialchars($skill['image']) . '" alt="' . htmlspecialchars($skill['name']) . '" class="animated-skill-icon" title="' . htmlspecialchars($skill['name']) . '">';
                    } else {
                        echo '<span class="badge bg-secondary">' . htmlspecialchars($skill['name']) . '</span>';
                    }
                endforeach;
                ?>
            </div>
        </div>
    </div>
</section>

<!-- Contact Section -->
<section class="mb-5">
    <h2 class="text-center mb-4">Contact</h2>
    <div class="d-flex justify-content-center gap-4 mb-3">
        <a href="mailto:mirthfulmickgh12@gmail.com" class="btn btn-outline-dark"><i class="bi bi-envelope"></i> Email</a>
        <a href="https://www.linkedin.com/in/hackmankofiagyemang" class="btn btn-outline-primary" target="_blank"><i class="bi bi-linkedin"></i> LinkedIn</a>
        <a href="https://github.com/OriginalHacQ" class="btn btn-outline-dark" target="_blank"><i class="bi bi-github"></i> GitHub</a>
    </div>
</section>

<?php include 'includes/footer.php'; ?>