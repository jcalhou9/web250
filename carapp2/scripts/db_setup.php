<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    die("You must be logged in to run this script.");
}
include 'db_config.php';

//initialize session message
$_SESSION['message'] = "DATABASE RESET\n";

//create database if it doesn't exist
$createDatabaseQuery = "CREATE DATABASE IF NOT EXISTS if0_38352683_automobiles";
if ($mysqli->query($createDatabaseQuery)) {
    $_SESSION['message'] .= "Database check/creation\n";
} else {
    $_SESSION['message'] .= "- Database creation failed: " . $mysqli->error . "\n";
}

//drop inventory table
$dropInventoryTableQuery = "DROP TABLE IF EXISTS inventory";
if ($mysqli->query($dropInventoryTableQuery)) {
    $_SESSION['message'] .= "Dropped inventory table\n";
} else {
    $_SESSION['message'] .= "- Error dropping inventory table: " . $mysqli->error . "\n";
}

//create inventory table
$createInventoryTableQuery = "
CREATE TABLE IF NOT EXISTS inventory (
    VIN varchar(17) PRIMARY KEY,
    YEAR INT,
    MAKE varchar(50),
    MODEL varchar(100),
    TRIM varchar(50),
    EXT_COLOR varchar(50),
    INT_COLOR varchar(50),
    ASKING_PRICE DECIMAL(10,2),
    SALE_PRICE DECIMAL(10,2),
    PURCHASE_PRICE DECIMAL(10,2),
    MILEAGE int,
    TRANSMISSION varchar(50),
    PURCHASE_DATE DATE,
    SALE_DATE DATE,
    PRIMARY_IMAGE VARCHAR(250)
)";
if ($mysqli->query($createInventoryTableQuery)) {
    $_SESSION['message'] .= "Created inventory table\n";
} else {
    $_SESSION['message'] .= "- Error creating inventory table: " . $mysqli->error . "\n";
}

//drop images table
$dropImagesTableQuery = "DROP TABLE IF EXISTS images";
if ($mysqli->query($dropImagesTableQuery)) {
    $_SESSION['message'] .= "Dropped images table\n";
} else {
    $_SESSION['message'] .= "- Error dropping images table: " . $mysqli->error . "\n";
}

//create images table
$createImagesTableQuery = "
CREATE TABLE IF NOT EXISTS images (
    ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    VIN varchar(17),
    IMAGEFILE varchar(250)
)";
if ($mysqli->query($createImagesTableQuery)) {
    $_SESSION['message'] .= "Created images table\n";
} else {
    $_SESSION['message'] .= "- Error creating images table: " . $mysqli->error . "\n";
}

//insert inventory data
$insertInventoryDataQuery = "INSERT IGNORE INTO `if0_38352683_automobiles`.`inventory` (`VIN`, `YEAR`, `MAKE`, `MODEL`, `TRIM`, `EXT_COLOR`, `INT_COLOR`, `ASKING_PRICE`, `SALE_PRICE`, `PURCHASE_PRICE`, `MILEAGE`, `TRANSMISSION`, `PURCHASE_DATE`, `SALE_DATE`) VALUES ";
include '../components/car_data.php';

if ($mysqli->query($insertInventoryDataQuery)) {
    $totalCars = $mysqli->query("SELECT COUNT(*) AS total FROM `if0_38352683_automobiles`.`inventory`")->fetch_assoc()['total'];
    $_SESSION['message'] .= "Inserting car data \n$totalCars cars loaded\n";
} else {
    $_SESSION['message'] .= "- Error inserting car data: " . $mysqli->error . "\n";
}

//create users table
$createUsersTableQuery = " 
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    USERNAME VARCHAR(50) NOT NULL UNIQUE,
    PASSWORD VARCHAR(255) NOT NULL,
    first_name VARCHAR(50),
    last_name VARCHAR(50)
)";
if (!$mysqli->query($createUsersTableQuery)) {
    $_SESSION['message'] .= "- Error creating users table: " . $mysqli->error . "\n";
}

$mysqli->close();
header("Location: ../");
exit;
?>
