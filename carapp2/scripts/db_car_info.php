<?php
include 'db_config.php';
$vin = $_GET['VIN'] ?? null;

//default values
$year = $make = $model = $color = $interior = $price = $trim = $salePrice = $purchasePrice = $mileage = $transmission = $purchaseDate = $saleDate = $primaryImage = '';
$carFound = false;

//query for car details if vin is set
if ($vin) {
    $stmt = $mysqli->prepare("SELECT * FROM inventory WHERE VIN = ?");
    $stmt->bind_param("s", $vin);
    $stmt->execute();
    $result = $stmt->get_result();
    //if car is found get details
    if ($car = $result->fetch_assoc()) {
        $year = $car['YEAR'];
        $make = $car['MAKE'];
        $model = $car['MODEL'];
        $trim = $car['TRIM'];
        $price = $car['ASKING_PRICE'];
        $salePrice = $car['SALE_PRICE'];
        $purchasePrice = $car['PURCHASE_PRICE'];
        $mileage = $car['MILEAGE'];
        $transmission = $car['TRANSMISSION'];
        $purchaseDate = $car['PURCHASE_DATE'];
        $saleDate = $car['SALE_DATE'];
        $color = $car['EXT_COLOR'];
        $interior = $car['INT_COLOR'];
        $primaryImage = $car['PRIMARY_IMAGE'];
        $carFound = true;
    }

    $stmt->close();
}
?>
