<?php 
//connect to mysql
include('../db_scripts/db_connection.php');
//select a database to work with
include('../db_scripts/db_config.php');

session_start();
// Capture the values posted to this php program from the text fields
$VIN =  trim( $_REQUEST['VIN']) ;
$Make = trim( $_REQUEST['Make']) ;
$Model = trim( $_REQUEST['Model']) ;
$Price =  $_REQUEST['Asking_price'] ;


//Build a SQL Query using the values from above
$query = "INSERT INTO inventory
  (VIN, Make, Model, ASKING_PRICE)
   VALUES (
   '$VIN', 
   '$Make', 
   '$Model',
    $Price
    )";

/* Try to insert the new car into the database */
$_SESSION['message'] = $mysqli->query($query)
    ? "You have successfully entered $Make $Model into the database."
    : "Error entering $VIN into database: " . $mysqli->error;

$mysqli->close();
header("Location: ../jeremys_used_cars.php");
exit;
?>
