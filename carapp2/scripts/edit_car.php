<?php
session_start();
include('db_config.php');

//form input
$vin = trim($_POST['VIN']);
$year = trim($_POST['YEAR']);
$make = trim($_POST['MAKE']);
$model = trim($_POST['MODEL']);
$trim = trim($_POST['TRIM']);
$extColor = trim($_POST['EXT_COLOR']);
$intColor = trim($_POST['INT_COLOR']);
$askingPrice = trim($_POST['ASKING_PRICE']);
$salePrice = trim($_POST['SALE_PRICE']);
$purchasePrice = trim($_POST['PURCHASE_PRICE']);
$mileage = trim($_POST['MILEAGE']);
$transmission = trim($_POST['TRANSMISSION']);
$purchaseDate = trim($_POST['PURCHASE_DATE']);
$saleDate = trim($_POST['SALE_DATE']);

//required fields
$requiredFields = [$vin, $make, $model, $askingPrice];
if (in_array('', $requiredFields, true)) {
    $_SESSION['message'] = "VIN, Make, Model, and Asking Price are required.";
    header("Location: ../index.php?sectionView=edit&VIN=$vin");
    exit;
}

//prepare update statement
$carEditStatement = $mysqli->prepare(
    "UPDATE inventory SET 
        YEAR = ?, MAKE = ?, MODEL = ?, TRIM = ?, EXT_COLOR = ?, INT_COLOR = ?, 
        ASKING_PRICE = ?, SALE_PRICE = ?, PURCHASE_PRICE = ?, MILEAGE = ?, TRANSMISSION = ?, 
        PURCHASE_DATE = ?, SALE_DATE = ?, PRIMARY_IMAGE = ?
     WHERE VIN = ?"
);
//bind imputs to statement
$carEditStatement->bind_param(
    "issssssddisssss",
    $year, $make, $model, $trim, $extColor, $intColor,
    $askingPrice, $salePrice, $purchasePrice, $mileage, $transmission,
    $purchaseDate, $saleDate, $primaryImage, $vin
);
$carEditStatement->execute();
//update message
$_SESSION['message'] = $carEditStatement->affected_rows
    ? "Successfully updated $year $make $model."
    : "No changes made or VIN $vin not found.";
//highlight the updated car
$_SESSION['highlightEntry'] = $vin;

//locate vin position in inventory
$query = "SELECT VIN FROM inventory ORDER BY MAKE, MODEL, ASKING_PRICE";
$result = $mysqli->query($query);
$position = 0;
while ($row = $result->fetch_assoc()) {
    $position++;
    if ($row['VIN'] === $vin) break;
}
//find the page number
$limit = $_SESSION['carsPerPage'] ?? 25;
$_SESSION['highlightPage'] = ceil($position / $limit);

//redirect to affected page
$carEditStatement->close();
header("Location: ../index.php?page=$pageNumber#highlightedCar");
exit;
?>
