<?php 
//connect to mysql
include('db_connection.php');
//select a database to work with
include('db_config.php');

session_start();
// Capture the values posted to this php program from the text fields
$vin =  trim( $_REQUEST['VIN']) ;
$make = trim( $_REQUEST['MAKE']) ;
$model = trim( $_REQUEST['MODEL']) ;
$price =  $_REQUEST['ASKING_PRICE'] ;


//Build a SQL Query using the values from above
$query = "INSERT INTO INVENTORY
  (VIN, MAKE, MODEL, ASKING_PRICE)
   VALUES (
   '$vin', 
   '$make', 
   '$model',
    $price
    )";

/* Try to insert the new car into the database */
$_SESSION['message'] = $mysqli->query($query)
    ? "You have successfully entered $make $model into the database."
    : "Error entering $vin into database: " . $mysqli->error;

$mysqli->close();
header("Location: ../");
exit;
?>
