
<?php 
require 'includes/db_connect.php';
include 'includes/header.php'; 
?>


<section class="container py-5">
    <h1 class="text-center mb-5 fw-bold" style="letter-spacing:1px;">My Work</h1>
    <?php
    // Gather all unique tech stacks for filter buttons
    $techs = [];
    $stmt = $pdo->query("SELECT tech_stack FROM projects");
    while ($row = $stmt->fetch()) {
        $parts = array_map('trim', explode(',', $row['tech_stack']));
        foreach ($parts as $t) {
            if ($t && !in_array($t, $techs)) $techs[] = $t;
        }
    }
    sort($techs);
    ?>
    <div class="text-center mb-4">
        <button class="btn btn-outline-dark mx-1 filter-btn active" data-filter="all">All</button>
        <?php foreach ($techs as $tech): ?>
            <button class="btn btn-outline-primary mx-1 filter-btn" data-filter="<?php echo htmlspecialchars(strtolower(str_replace(' ', '-', $tech))); ?>"><?php echo htmlspecialchars($tech); ?></button>
        <?php endforeach; ?>
    </div>
    <div class="row g-4 justify-content-center" id="portfolio-grid">
        <?php
        $stmt = $pdo->query("SELECT * FROM projects ORDER BY created_at DESC");
        while ($project = $stmt->fetch()):
            $tech_classes = '';
            $parts = array_map('trim', explode(',', $project['tech_stack']));
            foreach ($parts as $t) {
                $tech_classes .= ' tech-' . strtolower(str_replace(' ', '-', $t));
            }
        ?>
        <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch portfolio-item<?php echo $tech_classes; ?>" style="opacity:0;transform:translateY(40px);transition:all 0.7s cubic-bezier(.4,2,.6,1);">
            <div class="card shadow-lg border-0 h-100" style="border-radius:18px;overflow:hidden;">
                <div style="height:220px;overflow:hidden;">
                    <img src="<?php echo htmlspecialchars($project['image_url']); ?>" class="card-img-top portfolio-img" alt="<?php echo htmlspecialchars($project['title']); ?>" style="height:220px;object-fit:cover;transition:transform 0.4s cubic-bezier(.4,2,.6,1);">
                </div>
                <div class="card-body d-flex flex-column">
                    <h5 class="card-title fw-bold mb-2" style="color:#232946;letter-spacing:0.5px;">
                        <?php echo htmlspecialchars($project['title']); ?>
                    </h5>
                    <p class="card-text mb-3" style="flex:1 1 auto;min-height:60px;">
                        <?php echo htmlspecialchars($project['description']); ?>
                    </p>
                    <div class="mb-2">
                        <?php foreach ($parts as $t): ?>
                            <span class="badge bg-primary bg-opacity-75 me-1" style="font-size:1em;">
                                <?php echo htmlspecialchars($t); ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <div class="card-footer bg-white border-0 text-end">
                    <a href="<?php echo isset($project['project_url']) ? htmlspecialchars($project['project_url']) : '#'; ?>" class="btn btn-outline-primary btn-sm" target="_blank">
                        <i class="bi bi-box-arrow-up-right"></i> View Project
                    </a>
                </div>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>
<script>
// Portfolio filter logic
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        const filter = this.getAttribute('data-filter');
        document.querySelectorAll('.portfolio-item').forEach(item => {
            if (filter === 'all' || item.classList.contains('tech-' + filter)) {
                item.style.display = '';
                setTimeout(() => {
                    item.style.opacity = 1;
                    item.style.transform = 'translateY(0)';
                }, 10);
            } else {
                item.style.opacity = 0;
                item.style.transform = 'translateY(40px)';
                setTimeout(() => { item.style.display = 'none'; }, 400);
            }
        });
    });
});
// Fade-in animation on load
window.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.portfolio-item').forEach((item, i) => {
        setTimeout(() => {
            item.style.opacity = 1;
            item.style.transform = 'translateY(0)';
        }, 120 * i);
    });
    // Image hover zoom
    document.querySelectorAll('.portfolio-img').forEach(img => {
        img.addEventListener('mouseenter', () => {
            img.style.transform = 'scale(1.08)';
        });
        img.addEventListener('mouseleave', () => {
            img.style.transform = 'scale(1)';
        });
    });
});
</script>

<?php include 'includes/footer.php'; ?>