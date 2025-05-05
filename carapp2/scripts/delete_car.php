<?php
require('db_config.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php?sectionView=login');
    exit;
}

//check if vin is provided
$vin = $_GET['VIN'] ?? '';
if ($vin === '') {
    $_SESSION['message'] = "No VIN provided.";
    header("Location: ../index.php");
    exit;
}

//delete car
$query = "DELETE FROM inventory WHERE VIN = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $vin);
$stmt->execute();

//check if car was deleted
$_SESSION['message'] = $stmt->affected_rows
    ? "The vehicle with VIN $vin has been deleted."
    : "No vehicle with VIN $vin found.";

$stmt->close();
header("Location: index.php");
exit;