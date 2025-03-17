<?php
/**
 * Joy of PHP sample code
 * Demonstrates how to modify an existing database table.
 */

//connect to mysql
include('db_connection.php');
//select a database to work with
include('db_config.php');

$query = "ALTER TABLE `inventory` ADD `Primary_Image` VARCHAR(250) NULL AFTER `SALE_DATE`";
echo "<p>***********</p>";
echo $query ;
echo "<p>***********</p>";
if ($mysqli->query($query) === TRUE) 
{
    echo "Database table 'INVENTORY' modified</P>";
}
else
{
    echo "<p>Error: </p>" . $mysqli->error."<br>";;
}
$mysqli->close();
echo "<br><br><a href='index.html'>Home</a>";
?>