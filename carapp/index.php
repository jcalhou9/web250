<!DOCTYPE html>

<html lang="en">
	<head>
		<meta content="en-us" http-equiv="Content-Language" />
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<link rel="stylesheet" type="text/css" href="styles/default.css">
		<title>JC Used Cars</title>
	</head>

	<body>
		<header>
			<img alt="Used Cars" height="120" src="images/usedcars.jpg" width="184" />
			<h1>Jeremy's Used Cars</h1>
			<p>Work in progress</p>
			<hr />
		</header>

		<main>
			<h2>Welcome to Jeremy's Used car lot!</h2>
			<p><a href="components/form_enter_car.htm">Add a Car</a></p>
			<p><a href="scripts/db_setup.php">Reset Database - USE WITH CAUTION</a></p>

			<?php
			//connect to mysql
			include('scripts/db_connection.php');
			//select a database to work with
			include('scripts/db_config.php');

			session_start();
			if (isset($_SESSION['message'])) {
				echo "<p style='background: yellow; text-align: center;'>" . $_SESSION['message'] . "</p>";
				unset($_SESSION['message']);
			}	

			$query = "SELECT * FROM inventory";
			/* Try to query the database */
			try{
				($result = $mysqli->query($query)); 
				
				// Create the table headers
				echo "<table id='Grid'>\n";
				echo "<tr>";
				echo "<th>Make</th>";
				echo "<th>Model</th>";
				echo "<th>Asking Price</th>";
				echo "<th>Action</th>";
				echo "</tr>\n";

				$class ="odd";  // Keep track of whether a row was even or odd, so we can style it later

				// Loop through all the rows returned by the query, creating a table row for each
				while ($result_ar = mysqli_fetch_assoc($result)) {
					echo "<tr class=\"$class\">";
					echo "<td><a href='scripts/viewcar.php?VIN=".$result_ar['VIN']."'>" . $result_ar['MAKE'] . "</a></td>";
					echo "<td>" . $result_ar['MODEL'] . "</td>";
					echo "<td>" . '$'.number_format($result_ar['ASKING_PRICE'],0) . "</td>";
					echo "<td><a href='components/form_edit.php?VIN=".$result_ar['VIN']."'>Edit</a> | 
							<a href='scripts/delete_car.php?VIN=".$result_ar['VIN']."'>Delete</a> | 
							<a href='components/add_image.php?VIN=".$result_ar['VIN']."'>Edit Images</a> </td>";
					echo "</tr>\n";
				
				// If the last row was even, make the next one odd and vice-versa
					if ($class=="odd"){
						$class="even";
					}
					else
					{
						$class="odd";
					}
				}
				echo "</table>";
			} catch (mysqli_sql_exception $e){
				echo "<p>Query Error</p>";
			}
			$mysqli->close();
			?>

		</main>
		<footer>
		</footer>
	</body>

	

</html>
