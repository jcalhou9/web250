<?php
session_start();
require 'db_config.php';
//form input
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
    if (in_array('', [$vin, $make, $model, $askingPrice], true)) {
        $_SESSION['message'] = "VIN, Make, Model, and Asking Price are required.";
        header("Location: ../index.php?sectionView=add");
        exit;
    }
    try {
        //prepare insert statement
        $stmt = $mysqli->prepare(
            "INSERT INTO inventory 
            (VIN, YEAR, MAKE, MODEL, TRIM, EXT_COLOR, INT_COLOR, ASKING_PRICE, SALE_PRICE, PURCHASE_PRICE, MILEAGE, TRANSMISSION, PURCHASE_DATE, SALE_DATE)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );
        //bind inputs to statement
        $stmt->bind_param(
            "sissssssddisss",
            $vin, $year, $make, $model, $trim, $extColor, $intColor,
            $askingPrice, $salePrice, $purchasePrice, $mileage, $transmission,
            $purchaseDate, $saleDate
        );
        $stmt->execute();

        //locate vin position in inventory
        $query = "SELECT VIN FROM inventory ORDER BY MAKE, MODEL, ASKING_PRICE";
        $result = $mysqli->query($query);
        $position = 0;
        while ($row = $result->fetch_assoc()) {
            $position++;
            if ($row['VIN'] === $vin) break;
        }
        $_SESSION['highlightEntry'] = $vin;
        $_SESSION['highlightPage'] = ceil($position / ($_SESSION['carsPerPage'] ?? 25));
        $_SESSION['message'] = "Car added successfully.";
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {
            $_SESSION['message'] = "A car with VIN $vin already exists.";
        } else {
            $_SESSION['message'] = "Database error: " . $e->getMessage();
        }
    }

    header("Location: ../index.php?page=$pageNumber#highlightedCar");
    exit;
}
