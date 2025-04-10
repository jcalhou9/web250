<?php
echo isset($_SESSION['message'])
				? "<p id='sessionMessage'>" . $_SESSION['message'] . "</p>"
				: "<p id='messageSpaceSaver'>Inventory Table</p>";
				unset($_SESSION['message']);
			
			$queryTable = "SELECT * FROM inventory ORDER BY MAKE, MODEL, ASKING_PRICE";
			
			$highlightEntry = $_SESSION['highlightEntry'] ?? null;
			unset($_SESSION['highlightEntry']);
			/* Try to query the database */
			try{
				($result = $mysqli->query($queryTable)); 
				
				// Create the table headers
				echo "<table id='Grid'>\n";
				echo "<tr>";
				echo "<th>Make</th>";
				echo "<th>Model</th>";
				echo "<th>Price</th>";
				echo "<th>Action</th>";
				echo "</tr>\n";
				
				$class ="odd";  // Keep track of whether a row was even or odd, so we can style it later
				
				// Loop through all the rows returned by the query, creating a table row for each
				while ($result_ar = mysqli_fetch_assoc($result)) {
					$rowClass = ($result_ar['VIN'] === $highlightEntry) ? 'highlight' : $class;
					echo "<tr class=\"$rowClass\">";
					echo "<td><a href='index.php?sectionView=view&VIN=".$result_ar['VIN']."'>" . $result_ar['MAKE'] . "</a></td>";
					echo "<td>" . $result_ar['MODEL'] . "</td>";
					echo "<td>" . '$'.number_format($result_ar['ASKING_PRICE'],0) . "</td>";
					echo "<td><a href='index.php?sectionView=edit&VIN=".$result_ar['VIN']."'>Edit</a> | 
					<a href='index.php?sectionView=delete&VIN=".$result_ar['VIN']."'>Delete</a> | 
					<a href='index.php?sectionView=images&VIN=".$result_ar['VIN']."'>Images</a> </td>";
					echo "</tr>\n";
					
					
					// If the last row was even, make the next one odd and vice-versa
					$class = $class=="odd"
						? "even"
						: "odd";
				}
				echo "</table>";
			} catch (mysqli_sql_exception $e){
				echo "<p>Query Error</p>";
			}