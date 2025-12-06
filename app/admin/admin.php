<?php
/* SESSION START */

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
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<!-- META DATA -->
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<link href="/admin/admin.css" rel="stylesheet"/>
	<link href="/media/griffin-logo-transparent.png" rel="icon" type="image/png"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
	<!-- TITLE -->
	<?php
		$current_page = $_SERVER['REQUEST_URI'];

		$titles = [
		'/admin/overview/' => 'Overview',
		'/admin/users/' => 'Users',
		'/admin/overview' => 'Overview',
		'/admin/users' => 'Users'
		];

		$page_title = $titles[$current_page] ?? 'Dashboard';
	?>
	<title>Griffin - Admin <?= $page_title ?></title>
</head>
<body>
	<!-- NAV BAR -->
	<nav class="navbar">
		<div class="navbar-left"><a href="/">Griffin Panel</a></div>
		<div class="navbar-right">
			<div class="username-box"><?=$username?></div>
			<form method="POST" action="/logout" class="logout-form">
   				<button type="submit"><i class="fas fa-sign-out-alt"></i></button>
			</form>
		</div>
	</nav>
	<!-- SIDE BAR -->
		<?php
				$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
				$path = rtrim($path, '/');
				if ($path === '') { $path = '/';}
				if ($path === '/admin') {$path = '/admin/overview';}
			?>

			<aside class="sidebar">
				<ul class="sidebar-menu">

					<li class="sidebar-item <?= ($path === '/admin/overview' ? 'active' : '') ?>">
						<a href="/admin/overview/" class="sidebar-link">
							<i class="fas fa-chart-line"></i>
							<span>Overview</span>
						</a>
					</li>

					<li class="sidebar-item <?= ($path === '/admin/users' ? 'active' : '') ?>">
						<a href="/admin/users/" class="sidebar-link">
							<i class="fas fa-users"></i>
							<span>Users</span>
						</a>
					</li>

				</ul>
			</aside>
	<!-- MAIN CONTENT -->
	<main class="main-content">
	<!-- OVERVIEW -->
	<?php
		switch ($path)
		{
			case '/admin/overview':
	?>
				<h1>Overview</h1>
	<?php
				break;

			case '/admin/users':
	?>
	<!-- USERS -->
				<h1>Users</h1>
				<div class="table-responsive">
				<table class="users-table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Username</th>
							<th>Privileges</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
	<?php
						require '../config.php';
						$users = [];
						$result = $mysqli->query("SELECT ID, USERNAME, PRIVILEGES FROM users ORDER BY ID ASC");
						if ($result)
						{
							while ($row = $result->fetch_assoc())
							{
								$users[] = [
									'id' => $row['ID'],
									'username' => $row['USERNAME'],
									'privileges' => $row['PRIVILEGES']
								];
							}
							$result->free();
						}
						else
						{
							echo "<tr><td colspan='4'>Error fetching users: " . $mysqli->error . "</td></tr>";
						}
						foreach ($users as $user)
						{
	?>
							<tr>
								<td><?= htmlspecialchars($user['id']) ?></td>
								<td><?= htmlspecialchars($user['username']) ?></td>
								<td><?= $user['privileges'] == 1 ? 'Admin' : 'User' ?></td>
								<td>
									<a href="/admin/users/delete.php?id=<?= $user['id'] ?>" onclick="return confirm('Are you sure?')"><i class="fas fa-xmark"></i></a>
								</td>
							</tr>
	<?php
						}
	?>
					</tbody>
				</table>
				</div>
	<?php
				break;
		}
	?>
	</main>
</body>
</html>