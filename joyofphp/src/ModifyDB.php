<?php
/**
 * Joy of PHP sample code
 * Demonstrates how to modify an existing database table.
 */
include 'db.php';

   if (!$mysqli) { 
      die("Could not connect: ".$mysqli->error."<br>"); 
  } 
  echo 'Connected successfully to mySQL. <BR>'; 
  
//select a database to work with
$mysqli->select_db("if0_38352683_cars");
   Echo ("Selected the if0_38352683_cars database<br>");

$query = "ALTER TABLE `inventory` ADD IF NOT EXISTS `Primary_Image` VARCHAR(250) NULL AFTER `SALE_DATE`";
echo "<p>***********</p>";
echo $query ;
echo "<p>***********</p>";
if ($mysqli->query($query) === TRUE) 
{
    echo "Database table 'INVENTORY' modified</P>";
}

$mysqli->close();
echo "<br><br><a href='index.php'>Home</a>";
?>