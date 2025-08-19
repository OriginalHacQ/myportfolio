
<?php require_once 'auth_check.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #f4f6fb 0%, #b8c1ec 100%);
        }
        .metis-sidebar {
            min-height: 100vh;
            background: #232946;
            color: #fff;
            width: 230px;
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            box-shadow: 2px 0 12px rgba(35,41,70,0.08);
        }
        .metis-sidebar .nav-link {
            color: #b8c1ec;
            font-weight: 500;
            padding: 1rem 1.5rem;
            border-radius: 0 24px 24px 0;
            margin-bottom: 0.2rem;
            transition: background 0.2s, color 0.2s;
        }
        .metis-sidebar .nav-link.active, .metis-sidebar .nav-link:hover {
            background: #eebbc3;
            color: #232946;
        }
        .metis-sidebar .nav-link i { margin-right: 0.7rem; }
        .metis-topbar {
            margin-left: 230px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(35,41,70,0.04);
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .metis-content {
            margin-left: 230px;
            padding: 2.5rem 2rem 2rem 2rem;
        }
        @media (max-width: 991px) {
            .metis-sidebar, .metis-content, .metis-topbar { margin-left: 0 !important; }
            .metis-sidebar { position: relative; width: 100%; min-height: auto; }
        }
    </style>
</head>
<body>


<div class="metis-sidebar d-flex flex-column p-3">
    <div class="text-center mb-4">
    <img src="../images/admin_logo.jpg" alt="Admin Logo" style="width:48px;height:48px;border-radius:12px;box-shadow:0 2px 8px rgba(0,0,0,0.08);">
        <div class="fw-bold mt-2" style="font-size:1.2rem;letter-spacing:1px;">Admin</div>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='dashboard.php') echo ' active'; ?>" href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='manage_projects.php') echo ' active'; ?>" href="manage_projects.php"><i class="bi bi-briefcase"></i> Projects</a>
    <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='edit_about.php') echo ' active'; ?>" href="edit_about.php"><i class="bi bi-person"></i> About Me</a>
    <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='manage_skills.php') echo ' active'; ?>" href="manage_skills.php"><i class="bi bi-lightning"></i> Skills</a>
        <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='manage_posts.php') echo ' active'; ?>" href="manage_posts.php"><i class="bi bi-journal-text"></i> Blog Posts</a>
        <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='view_messages.php') echo ' active'; ?>" href="view_messages.php"><i class="bi bi-envelope"></i> Messages</a>
        <a class="nav-link<?php if(basename($_SERVER['PHP_SELF'])=='settings.php') echo ' active'; ?>" href="settings.php"><i class="bi bi-gear"></i> Settings</a>
        <a class="nav-link" href="../index.php" target="_blank"><i class="bi bi-globe"></i> View Site</a>
        <a class="nav-link" href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </nav>
</div>

<div class="metis-topbar">
    <div class="d-flex align-items-center">
    <img src="../images/admin_logo.jpg" alt="Admin Logo" style="width:32px;height:32px;border-radius:8px;margin-right:12px;">
        <span class="fw-bold" style="color:#232946;letter-spacing:1px;">Admin Dashboard</span>
    </div>
    <div>
        <a href="logout.php" class="btn btn-outline-danger btn-sm"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>
</div>

<div class="metis-content">
<?php
// Display flash messages
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
?>