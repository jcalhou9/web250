<?php
//connect to mysql
include('db_connection.php');
//select a database to work with
include('db_config.php');

session_start();
// Capture the values posted to this php program from the text fields in the form
$vin = $_REQUEST['VIN'] ;
$make = $_REQUEST['MAKE'] ;
$model = $_REQUEST['MODEL'] ;
$price = $_REQUEST['ASKING_PRICE'] ;

//Build a SQL Query using the values from above
$query = "UPDATE INVENTORY SET 
MAKE='$make', 
MODEL='$model', 
ASKING_PRICE='$price'
WHERE VIN='$vin'"; 

// Print the query to the browser so you can see it
// echo ($query. "<br>");

/* Try to insert the new car into the database */
$_SESSION['message'] = $mysqli->query($query)
    ? "You have successfully updated $make $model in the database."
    : "Error updating $vin in database: " . $mysqli->error;

$mysqli->close();
header("Location: ../");
exit;
?>