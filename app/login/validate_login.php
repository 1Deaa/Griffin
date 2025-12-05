<?php
session_start();

require '../config.php';

$salt = getenv('SALT');

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '')
{
	header("Location: login.php?error=" . urlencode("Please enter username and password"));
	exit;
}

$stmt = $mysqli->prepare("SELECT ID, PASSWORD, PRIVILEGES FROM users WHERE USERNAME = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0)
{
	$stmt->close();
	$mysqli->close();
	header("Location: login.php?error=" . urlencode("User not found"));
	exit;
}

$stmt->bind_result($id, $stored_hash, $privileges);
$stmt->fetch();

if ($salt !== '')
{
	$password_salted = hash_hmac("sha256", $password, $salt);

	$password_valid = password_verify($password_salted, $stored_hash);
}
else
{
	$password_valid = password_verify($password, $stored_hash);
}

if ($password_valid)
{
	$_SESSION['user_id'] = $id;
	$_SESSION['username'] = $username;
	$_SESSION['privileges'] = $privileges;

	$redirect = ($privileges == 1) ? '/admin/overview' : 'user_dashboard.php';
	header("Location: $redirect");
	exit;
} 
else
{
	header("Location: login.php?error=" . urlencode("Invalid password"));
	exit;
}

$stmt->close();
$mysqli->close();
?>