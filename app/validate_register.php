<?php
session_start();
require 'config.php';

$salt = getenv('SALT');

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');
$confirm = trim($_POST['confirm'] ?? '');

if ($username === '' && $password === '' && $confirm === '')
{
	header("Location: register.html?error=" . urlencode("Please fill in all fields"));
	exit;
}
else if ($username === '')
{
	header("Location: register.html?error=" . urlencode("Please enter a username"));
	exit;
}
else if ($password === '')
{
	header("Location: register.html?error=" . urlencode("Please enter a password"));
	exit;
}
else if ($confirm === '')
{
	header("Location: register.html?error=" . urlencode("Please confirm your password"));
	exit;
}
else if ($password !== $confirm)
{
	header("Location: register.html?error=" . urlencode("Passwords do not match"));
	exit;
}

$check = $mysqli->prepare("SELECT ID FROM users WHERE USERNAME = ?");
$check->bind_param("s", $username);
$check->execute();
$check->store_result();

if ($check->num_rows > 0)
{
	$check->close();
	header("Location: register.html?error=" . urlencode("Username already exists"));
	exit;
}
$check->close();

$password_salted = hash_hmac("sha256", $password, $salt);
$final_hash = password_hash($password_salted, PASSWORD_BCRYPT);
$privileges = 0;

$stmt = $mysqli->prepare("INSERT INTO users (USERNAME, PASSWORD, PRIVILEGES) VALUES (?, ?, ?)");

$stmt->bind_param("ssi", $username, $final_hash, $privileges);

if ($stmt->execute())
{
	$stmt->close();
	$mysqli->close();
	header("Location: index.html?success=" . urlencode("Account created! You may now log in."));
	exit;
}
else
{
	$stmt->close();
	$mysqli->close();
	header("Location: register.html?error=" . urlencode("An error occurred. Try again later."));
	exit;
}

?>