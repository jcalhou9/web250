<?php 
include 'db_config.php';

session_start();
// Capture the values posted to this php program from the text fields
$vin =  trim( $_REQUEST['VIN']);
$year =  trim( $_REQUEST['YEAR']);
$make = trim( $_REQUEST['MAKE']);
$model = trim( $_REQUEST['MODEL']);
$price =  $_REQUEST['ASKING_PRICE'];

if (in_array('', [$vin, $year, $make, $model, $price], true)) {
    $_SESSION['message'] = "All fields are required.";
    header("Location: ../");
    exit;
}

$carInsertStatement = $mysqli->prepare(
    "INSERT IGNORE INTO inventory (VIN, YEAR, MAKE, MODEL, ASKING_PRICE)
    VALUES (?,?,?,?,?)");
$carInsertStatement->bind_param("ssssd", $vin, $year, $make, $model, $price);
$carInsertStatement->execute();

/* Try to insert the new car into the database */
$_SESSION['message'] = ($carInsertStatement->affected_rows)
    ? "You have successfully entered $make $model into the database."
    : "A car with VIN $vin already exists.";

$_SESSION['highlightEntry'] = $vin;

$carInsertStatement->close();
header("Location: ../");
exit;
?>
