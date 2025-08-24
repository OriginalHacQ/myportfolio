
<?php
require '../includes/db_connect.php';
include 'includes/header.php';
// Get some stats for the dashboard
$project_count = $pdo->query("SELECT count(*) FROM projects")->fetchColumn();
$message_count = $pdo->query("SELECT count(*) FROM messages")->fetchColumn();
?>

<div class="container-fluid">
    <div class="row mb-4 mt-3">
        <div class="col-12">
            <div class="p-4 text-center" style="background:rgba(255,255,255,0.7);border-radius:18px;box-shadow:0 2px 12px rgba(35,41,70,0.07);">
                <h1 class="display-5 mb-2" style="color:#232946;font-weight:900;">Welcome, Admin!</h1>
                <p class="lead mb-0">Your professional dashboard overview.</p>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background:#fff;border-radius:18px;">
                <div class="card-body text-center py-4">
                    <div class="mb-2" style="font-size:2.5rem;color:#232946;"><i class="bi bi-briefcase"></i></div>
                    <h2 class="mb-1" style="font-weight:800;letter-spacing:1px;">Projects</h2>
                    <div class="display-6 mb-2" style="color:#eebbc3;font-weight:900;"><?php echo $project_count; ?></div>
                    <a href="manage_projects.php" class="btn btn-outline-primary w-100">Manage Projects</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background:#fff;border-radius:18px;">
                <div class="card-body text-center py-4">
                    <div class="mb-2" style="font-size:2.5rem;color:#232946;"><i class="bi bi-envelope"></i></div>
                    <h2 class="mb-1" style="font-weight:800;letter-spacing:1px;">Messages</h2>
                    <div class="display-6 mb-2" style="color:#eebbc3;font-weight:900;"><?php echo $message_count; ?></div>
                    <a href="view_messages.php" class="btn btn-outline-primary w-100">View Messages</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background:#fff;border-radius:18px;">
                <div class="card-body text-center py-4">
                    <div class="mb-2" style="font-size:2.5rem;color:#232946;"><i class="bi bi-person"></i></div>
                    <h2 class="mb-1" style="font-weight:800;letter-spacing:1px;">Profile</h2>
                    <div class="mb-2 text-muted">Edit your about page and settings</div>
                    <a href="edit_about.php" class="btn btn-outline-primary w-100">Edit About</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm border-0" style="background:#fff;border-radius:18px;">
                <div class="card-body text-center py-4">
                    <div class="mb-2" style="font-size:2.5rem;color:#232946;"><i class="bi bi-file-earmark-pdf"></i></div>
                    <h2 class="mb-1" style="font-weight:800;letter-spacing:1px;">Resume</h2>
                    <div class="mb-2 text-muted">Upload or delete your resume</div>
                    <a href="manage_resume.php" class="btn btn-outline-primary w-100">Manage Resume</a>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="background:#fff;border-radius:18px;">
                <div class="card-body p-4">
                    <h4 class="mb-3" style="color:#232946;font-weight:700;">Recent Activity</h4>
                    <ul class="list-unstyled mb-0" style="max-height:180px;overflow-y:auto;">
                        <?php
                        $recent_projects = $pdo->query("SELECT title, created_at FROM projects ORDER BY created_at DESC LIMIT 5")->fetchAll();
                        foreach ($recent_projects as $proj) {
                            echo '<li>📦 <b>Project:</b> ' . htmlspecialchars($proj['title']) . ' <span class="text-muted">(' . date('M d, Y', strtotime($proj['created_at'])) . ')</span></li>';
                        }
                        $recent_msgs = $pdo->query("SELECT name, received_at FROM messages ORDER BY received_at DESC LIMIT 5")->fetchAll();
                        foreach ($recent_msgs as $msg) {
                            echo '<li>📬 <b>Message from:</b> ' . htmlspecialchars($msg['name']) . ' <span class="text-muted">(' . date('M d, Y', strtotime($msg['received_at'])) . ')</span></li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0" style="background:#fff;border-radius:18px;">
                <div class="card-body p-4">
                    <h4 class="mb-3" style="color:#232946;font-weight:700;">Quick Stats</h4>
                    <ul class="list-unstyled mb-0">
                        <li>📝 <b>Admin logged in</b> - <?php echo date('M d, Y H:i'); ?></li>
                        <li>📦 <b><?php echo $project_count; ?> projects</b> currently in portfolio</li>
                        <li>📬 <b><?php echo $message_count; ?> messages</b> received</li>
                        <li>🔄 Dashboard refreshed</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm border-0" style="background:#eebbc3;border-radius:18px;">
                <div class="card-body p-4">
                    <h4 class="mb-3" style="color:#232946;font-weight:700;">Quick Tips</h4>
                    <ul class="list-unstyled mb-0">
                        <li>✨ <b>Tip:</b> Use the sidebar to access all admin features.</li>
                        <li>🛡️ <b>Security:</b> Remember to log out after making changes.</li>
                        <li>🚀 <b>Pro Tip:</b> Add new projects and blog posts regularly to keep your portfolio fresh!</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>