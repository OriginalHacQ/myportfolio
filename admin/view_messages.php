
<?php
require '../includes/db_connect.php';
include 'includes/header.php';
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h1 class="mb-0" style="font-weight:800;letter-spacing:1px;">Contact Messages</h1>
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
                                    <th>Received</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stmt = $pdo->query("SELECT * FROM messages ORDER BY received_at DESC");
                                while ($row = $stmt->fetch()):
                                ?>
                                <tr>
                                    <td><?php echo date('M d, Y H:i', strtotime($row['received_at'])); ?></td>
                                    <td style="font-weight:600;font-size:1.1em;"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-decoration-none"><i class="bi bi-envelope-at"></i> <?php echo htmlspecialchars($row['email']); ?></a></td>
                                    <td><?php echo nl2br(htmlspecialchars($row['message'])); ?></td>
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