<?php
session_start();
require 'config.php';

$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if ($username === '' || $password === '')
{
    header("Location: index.html?error=" . urlencode("Please enter username and password"));
    exit;
}

// Prepare statement to prevent SQL injection
$stmt = $mysqli->prepare("SELECT ID, PASSWORD, PRIVILEGES FROM users WHERE USERNAME = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0)
{
    $stmt->close();
    $mysqli->close();
    header("Location: index.html?error=" . urlencode("User not found"));
    exit;
}

$stmt->bind_result($id, $hashed_password, $privileges);
$stmt->fetch();

if ($password === $hashed_password)
{
    $_SESSION['user_id'] = $id;
    $_SESSION['username'] = $username;
    $_SESSION['privileges'] = $privileges;

    $redirect = $privileges == 1 ? 'admin_dashboard.php' : 'user_dashboard.php';
    header("Location: $redirect");
    exit;
}
else
{
    header("Location: index.html?error=" . urlencode("Invalid password"));
    exit;
}

$stmt->close();
$mysqli->close();

?>