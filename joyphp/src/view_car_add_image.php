<html>
<head>
    <meta charset="utf-8">
    <title>Jeremy's Used Cars</title>
    <link rel="stylesheet" type="text/css" href="styles/view_car_add_image_style.css">
</head> 
<body background="site_images/bg.jpg">
<h1>Jeremy's Used Cars</h1>
<h3>Current Inventory</h3>
 <div class="auto-style1">
 <?php

//connect to mysql
include('db_scripts/db_connection.php');
//select a database to work with
include('db_scripts/db_config.php');

$query = "SELECT * FROM inventory";
/* Try to query the database */
if ($result = $mysqli->query($query)) {
   // Don't do anything if successful.
}
else
{
    echo "Error getting cars from the database: " . $mysqli->error."<br>";
}

// Create the table headers
echo "<table id='Grid' ><tr>";
echo "<th style='width: 15px'>Make</th>";
echo "<th style='width: 30px'>Model</th>";
echo "<th style='width: 50px'>Action</th>";
echo "</tr>\n";

$class ="odd";  // Keep track of whether a row was even or odd, so we can style it later

// Loop through all the rows returned by the query, creating a table row for each
while ($result_ar = mysqli_fetch_assoc($result)) {
    echo "<tr class=\"$class\">";
    echo "<td><a href='view_cars.php?VIN=".$result_ar['VIN']."'>" . $result_ar['Make'] . "</a></td>";
    echo "<td>" . $result_ar['Model'] . "</td>";
   echo "<td><a href='add_image.php?VIN=".$result_ar['VIN']."'>Add Image</a> </td>";
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
include 'footer.php'
?>

 </body>
 
</html>