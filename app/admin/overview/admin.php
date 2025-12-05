<?php
session_start();

if (isset($_SESSION['user_id']))
{
    if ($_SESSION['privileges'] != 1)
    {
        header("Location: ../../");
        exit;
    }
}
else
{
    header("Location: ../../login/");
    exit;
}
$username = $_SESSION['username'] ?? 'Guest';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
</head>
<body>

<div class="admin-nav">
    <div class="logo">Griffin Panel</div>

    <div class="right">
        <span>Welcome, <?php echo htmlspecialchars($username); ?></span>
        <a href="../../logout">Logout</a>
    </div>
</div>

</body>
</html>