
<?php
require '../includes/db_connect.php';
include 'includes/header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$username = trim($_POST['username']);
	$current_password = $_POST['current_password'];
	$new_password = $_POST['new_password'];
	$confirm_password = $_POST['confirm_password'];

	// Fetch current user
	$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
	$stmt->execute([$_SESSION['user_id']]);
	$user = $stmt->fetch();

	if (!$user || !password_verify($current_password, $user['password'])) {
		$msg = '<div class="alert alert-danger">Current password is incorrect.</div>';
	} else {
		// Update username
		$update_username = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
		$update_username->execute([$username, $user['id']]);

		// Update password if provided
		if (!empty($new_password)) {
			if ($new_password !== $confirm_password) {
				$msg = '<div class="alert alert-danger">New passwords do not match.</div>';
			} else {
				$hashed = password_hash($new_password, PASSWORD_DEFAULT);
				$update_pw = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
				$update_pw->execute([$hashed, $user['id']]);
				$msg = '<div class="alert alert-success">Username and password updated successfully.</div>';
			}
		} else {
			$msg = '<div class="alert alert-success">Username updated successfully.</div>';
		}
	}
}

// Fetch current username
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$current_username = $stmt->fetchColumn();
?>

<div class="container-fluid">
	<div class="row mb-4">
		<div class="col-12 d-flex justify-content-between align-items-center">
			<h1 class="mb-0" style="font-weight:800;letter-spacing:1px;">Settings</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-lg-6 mx-auto">
			<div class="card shadow-sm border-0" style="border-radius:18px;">
				<div class="card-body p-4">
					<?php if ($msg) echo $msg; ?>
					<form method="post" autocomplete="off">
						<div class="mb-3">
							<label for="username" class="form-label">Username</label>
							<input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($current_username); ?>" required>
						</div>
						<div class="mb-3">
							<label for="current_password" class="form-label">Current Password <span class="text-danger">*</span></label>
							<input type="password" class="form-control" name="current_password" required>
						</div>
						<div class="mb-3">
							<label for="new_password" class="form-label">New Password</label>
							<input type="password" class="form-control" name="new_password" minlength="6">
						</div>
						<div class="mb-3">
							<label for="confirm_password" class="form-label">Confirm New Password</label>
							<input type="password" class="form-control" name="confirm_password" minlength="6">
						</div>
						<button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Save Changes</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<?php include 'includes/footer.php'; ?>
