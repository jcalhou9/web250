<?php
include('db_config.php');

session_start();
// Capture the values posted to this php program from the text fields in the form
$vin =  trim( $_REQUEST['VIN']);
$year = trim( $_REQUEST['YEAR']);
$make = trim( $_REQUEST['MAKE']);
$model = trim( $_REQUEST['MODEL']);
$price =  $_REQUEST['ASKING_PRICE'];


if (in_array('', [$vin, $make, $model, $price], true)) {
    $_SESSION['message'] = "All fields are required.";
    header("Location: ../index.php?sectionView=edit&VIN=$vin");
    exit;
}

$carEditStatement = $mysqli->prepare(
    "UPDATE inventory
    SET YEAR=?, MAKE=?, MODEL=?, ASKING_PRICE=?
    WHERE VIN=?" 
);
$carEditStatement->bind_param("sssds", $year, $make, $model, $price, $vin);
$carEditStatement->execute();

/* Try to insert the new car into the database */
$_SESSION['message'] = $carEditStatement->affected_rows
    ? "You have successfully updated $year $make $model in the database."
    : "No changes made or VIN: $vin not found.";

$_SESSION['highlightEntry'] = $vin;

$carEditStatement->close();
header("Location: ../index.php?sectionView=edit&VIN=$vin");
exit;
?>