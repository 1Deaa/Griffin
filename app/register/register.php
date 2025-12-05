<?php
session_start();
if (isset($_SESSION['username']))
{
	$redirect = ($_SESSION['privileges'] == 1) ? '/admin/overview/admin.php' : 'user_dashboard.php';
	header("Location: $redirect");
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Griffin Register</title>
	<link href="../media/griffin-logo-transparent.png" rel="icon" type="image/png">
	<link href="register.css" rel="stylesheet">
</head>
<body>
	<h1 class="page-title">Create an Account</h1>
	<div class="auth-card">
		<div class="logo-section">
			<img src="../media/griffin-logo-transparent.png" alt="Main-Logo">
		</div>
		<div class="form-section">
			<div class="input-group">
				<label>Username</label>
				<input type="text" id="username">
			</div>
			<div class="input-group">
				<label>Password</label>
				<input type="password" id="password">
			</div>
			<div class="input-group">
				<label>Confirm Password</label>
				<input type="password" id="confirm-password">
			</div>
			<div id="error-msg" class="error-text" style="display:none;"></div>
			<button type="button" id="register-btn">Register</button>
			<p class="login-inline">Already have an account? <a href="../login/">Login here</a>.</p>
			<a href="../"><button type="button" id="go-back">Back</button></a>
		</div>
	</div>
	<p class="copyright">© 2025 - 2026 Griffin Software</p>
	<script src="register.js"></script>
</body>
</html>