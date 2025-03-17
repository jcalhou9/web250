<?php
//connect to mysql
include('../db_scripts/db_connection.php');
//select a database to work with
include('../db_scripts/db_config.php');

session_start();
// Capture the values posted to this php program from the text fields in the form
$VIN = $_REQUEST['VIN'] ;
$Make = $_REQUEST['Make'] ;
$Model = $_REQUEST['Model'] ;
$Price = $_REQUEST['Asking_Price'] ;

//Build a SQL Query using the values from above
$query = "UPDATE inventory SET 
Make='$Make', 
Model='$Model', 
ASKING_PRICE='$Price'
WHERE VIN='$VIN'"; 

// Print the query to the browser so you can see it
// echo ($query. "<br>");

/* Try to insert the new car into the database */
$_SESSION['message'] = $mysqli->query($query)
    ? "You have successfully updated $Make $Model in the database."
    : "Error updating $VIN in database: " . $mysqli->error;

$mysqli->close();
header("Location: ../jeremys_used_cars.php");
exit;
?>