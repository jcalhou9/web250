<?php
session_start();
?>
<!DOCTYPE html>

<html lang="en">
	<head>
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<link rel="stylesheet" type="text/css" href="styles/default.css">
        <script src="https://lint.page/kit/880bd5.js" crossorigin="anonymous"></script>
		<title>JC Used Cars</title>
	</head>
	<body>
		<header>
			<h1>Jeremy's Used Cars</h1>
		</header>
		<main>
			<h2>Welcome to Jeremy's Used car lot!</h2>
			<section>
				<?php
				include 'scripts/db_config.php';
				
				$vin = $_GET['VIN'] ?? '';
				$sectionView = $_GET['sectionView'] ?? 'add';
				$contentViews = [
					'edit' => 'components/form_edit',
					'add' => 'components/form_enter_car',
					'view' => 'scripts/viewcar',
					'images' => 'components/add_image',
					'delete' => 'scripts/delete_car'
				];
				$loadSectionView = $contentViews[$sectionView] . ".php" ?? $contentViews['add'] . ".php" ;
				include $loadSectionView;
				?>
			</section>

			<?php
			include 'components/view_cars_table.php';
			$mysqli->close();
			?>
		<p><a href="scripts/db_setup.php">Reset Database - USE WITH CAUTION</a> May take a minunte to load.</p>
		</main>
		<footer>
		</footer>
	</body>
</html>
		