<!DOCTYPE html>

<html lang="en">
	<head>
		<meta content="en-us" http-equiv="Content-Language" />
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<title>JC Used Cars</title>
		<style>
			body{
				font-family: Tahoma, Arial, sans-serif;
				max-width: 900px;
				margin: 0 auto;
				width: 90%;
			}

			h1, h2, header, footer{
				text-align: center;
			}
		</style>
	</head>

	<body>
		<header>
			<img style="float: left;" alt="Used Cars" height="120" src="images/usedcars.jpg" width="184" />
			<h1>JC Used Cars</h1>
			<p>The companion web site that goes with the <a href="index.html">Joy 
				of PHP</a> Book</p>
			<hr />
		</header>

		<main>
			<h2>Welcome to JC Used car lot!</h2>
			<p><a href="components/form_enter_car.htm">Add a Car</a></p>
			<p><a href="components/view_car_add_image.php">Add Images to Cars</a></p>
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
			if ($result = $mysqli->query($query)) {
			// Don't do anything if successful.
			} else {
				echo "Error getting cars from the database: " . $mysqli->error."<br>";
			}

			// Create the table headers
			echo "<table id='Grid' style='width: 80%'>\n";
			echo "<tr>";
			echo "<th style='width: 50px'>Make</th>";
			echo "<th style='width: 50px'>Model</th>";
			echo "<th style='width: 50px'>Asking Price</th>";
			echo "<th style='width: 50px'>Action</th>";
			echo "</tr>\n";

			$class ="odd";  // Keep track of whether a row was even or odd, so we can style it later

			// Loop through all the rows returned by the query, creating a table row for each
			while ($result_ar = mysqli_fetch_assoc($result)) {
				echo "<tr class=\"$class\">";
				echo "<td><a href='scripts/viewcar.php?VIN=".$result_ar['VIN']."'>" . $result_ar['Make'] . "</a></td>";
				echo "<td>" . $result_ar['Model'] . "</td>";
				echo "<td>" . $result_ar['ASKING_PRICE'] . "</td>";
				echo "<td><a href='components/form_edit.php?VIN=".$result_ar['VIN']."'>Edit</a> 
						<a href='scripts/delete_car.php?VIN=".$result_ar['VIN']."'>Delete</a></td>";
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
			$mysqli->close();
			?>

		</main>
		<footer>
		</footer>
	</body>

	

</html>
