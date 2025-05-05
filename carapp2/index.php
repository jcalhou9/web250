<?php
session_start();
if (isset($_SESSION['highlightPage'])) {
    $page = $_SESSION['highlightPage'];
    unset($_SESSION['highlightPage']);
    header("Location: index.php?page=$page");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<link rel="stylesheet" type="text/css" href="styles/navigation.css">
		<link rel="stylesheet" type="text/css" href="styles/layout.css">
		<link rel="stylesheet" type="text/css" href="styles/forms_tables.css">
		<link rel="stylesheet" type="text/css" href="styles/car_grid.css">
		<title>Jubilant Cheetah Used Cars</title>
	</head>
	<body>
		<header>
			<h1>Jubilant Cheetah's Used Cars</h1>
			<?php if (isset($_SESSION['user_id'])): ?>
				<div class="welcomeUser">
					Welcome, <?= htmlspecialchars(trim($_SESSION['first_name'] . ' ' . ($_SESSION['last_name'] ?? ''))) ?>
				</div>
			<?php endif; ?>
			<nav>
				<a href="index.php">View Cars</a>
				<?php if (isset($_SESSION['user_id'])): ?>
					<a href="index.php?sectionView=add">Add Car</a>
					<a href="scripts/db_setup.php" onclick="return confirm('This will destroy and reset the database! Continue?')">Reset Database</a>
					<a href="scripts/auth.php?action=logout">Logout</a>
				<?php else: ?>
					<a href="index.php?sectionView=login">Login</a>
				<?php endif; ?>
			</nav>
		</header>
		<main>
			<h2>Welcome to Jubilant Cheetah's Used car lot!</h2>
			<?php
			include 'scripts/db_config.php';
			$vin = $_GET['VIN'] ?? '';
			$sectionView = $_GET['sectionView'] ?? 'view';
			$protectedViews = ['add', 'edit', 'delete', 'images'];
			if (in_array($sectionView, $protectedViews) && !isset($_SESSION['user_id'])) {
				$_SESSION['message'] = 'You must be logged in to access this section.';
				header('Location: index.php?sectionView=login');
				exit;
			}
			$contentViews = [
				'login' => 'components/form_login',
				'edit' => 'components/form_edit',
				'add' => 'components/form_enter_car',
				'view' => 'scripts/viewcar',
				'images' => 'components/add_image',
				'delete' => 'scripts/delete_car'
			];
			$loadSectionView = $contentViews[$sectionView] . ".php" ?? $contentViews['add'] . ".php" ;
			ob_start();
			include $loadSectionView;
			$sectionContent = trim(ob_get_clean());
			if (!empty($sectionContent)) {
				echo "<section>$sectionContent</section>";
			}
			if ($sectionView !== 'login') {
				include 'components/view_cars_table.php';
			}
			$mysqli->close();
			?>
		</main>
	</body>
</html>
		