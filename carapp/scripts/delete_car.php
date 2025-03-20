
<?php 
//connect to mysql
include('db_connection.php');
//select a database to work with
include('db_config.php');

session_start();

$vin = $_GET['VIN'];
$query = "DELETE FROM INVENTORY WHERE VIN='$vin'";
echo "$query <BR>";
/* Try to query the database */
$_SESSION['message'] = $mysqli->query($query)
    ? "The vehicle with VIN $vin has been deleted."
    : "Sorry, a vehicle with VIN of $vin cannot be found " . $mysqli->error;

$mysqli->close();
header("Location: ../");
exit; 
?>