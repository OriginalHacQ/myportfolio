
<?php
require '../includes/db_connect.php';
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="mb-0" style="font-weight:800;letter-spacing:1px;">Manage Projects</h1>
            <a href="edit_project.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Add New Project</a>
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
                                    <th>Image</th>
                                    <th>Title</th>
                                    <th>Tech Stack</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->query("SELECT id, title, tech_stack, image_url FROM projects ORDER BY created_at DESC");
                                while ($row = $stmt->fetch()):
                                ?>
                                <tr>
                                    <td><img src="../<?php echo htmlspecialchars($row['image_url']); ?>" alt="" width="80" style="border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.08);"></td>
                                    <td style="font-weight:600;font-size:1.1em;"><?php echo htmlspecialchars($row['title']); ?></td>
                                    <td><span class="badge bg-primary bg-opacity-75" style="font-size:1em;"><?php echo htmlspecialchars($row['tech_stack']); ?></span></td>
                                    <td>
                                        <a href="edit_project.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm"><i class="bi bi-pencil"></i> Edit</a>
                                        <a href="delete_project.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this project?');"><i class="bi bi-trash"></i> Delete</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>