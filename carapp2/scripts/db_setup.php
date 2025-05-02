<?php
session_start();
//connect to database
include 'db_config.php';

//create database if doesnt exist
$query = "CREATE DATABASE IF NOT EXISTS if0_38352683_vehicles";
if ($mysqli->query("$query")) {
    echo "<p>Database Cars available</P>";
} else {
    echo "Had trouble with this SQL: CREATE DATABASE IF NOT EXISTS if0_38352683_vehicles";
}

// drop the table inventory if it exists
$query = "DROP TABLE IF EXISTS inventory";
if ($mysqli->query($query) === TRUE) {
    echo "Database table 'INVENTORY' dropped</P>";
}else{
    echo "<p>Error: </p>" . $mysqli->error;
}


/* Create table if doesnt exists and doesn't return a resultset */
$query = " CREATE TABLE IF NOT EXISTS inventory 
( VIN varchar(17) PRIMARY KEY, YEAR INT, MAKE varchar(50), MODEL varchar(100), 
TRIM varchar(50), EXT_COLOR varchar (50), INT_COLOR varchar (50), ASKING_PRICE DECIMAL (10,2), 
SALE_PRICE DECIMAL (10,2), PURCHASE_PRICE DECIMAL (10,2), MILEAGE int, TRANSMISSION varchar (50), 
PURCHASE_DATE DATE, SALE_DATE DATE, PRIMARY_IMAGE VARCHAR(250))";

if ($mysqli->query($query) === TRUE) {
    echo "Database table 'INVENTORY' available</P>";
}else{
    echo "<p>Error: </p>" . $mysqli->error;
}

$query = " DROP TABLE IF EXISTS images";
if ($mysqli->query($query) === TRUE) {
    echo "Database table 'IMAGES' dropped</P>";
}else{
    echo "<p>Error: </p>" . $mysqli->error;
}

$query = " CREATE TABLE IF NOT EXISTS images (ID INT PRIMARY KEY NOT NULL AUTO_INCREMENT, VIN varchar(17), IMAGEFILE varchar(250))";
//echo "<p>***********</p>";
//echo $query ;
//echo "<p>***********</p>";
if ($mysqli->query($query) === TRUE) {
    echo "Database table 'IMAGES' created</P>";
} else {
    echo "<p>Error: " . mysqli_error($mysqli);
}

// insert cars from car_data.php into the inventory table
$query3 = "INSERT IGNORE INTO `if0_38352683_vehicles`.`inventory` (`VIN`, `YEAR`, `MAKE`, `MODEL`, `TRIM`, `EXT_COLOR`, `INT_COLOR`, `ASKING_PRICE`, `SALE_PRICE`, `PURCHASE_PRICE`, `MILEAGE`, `TRANSMISSION`, `PURCHASE_DATE`, `SALE_DATE`)
 VALUES ";
include '../components/car_data.php';

if ($mysqli->query($query3) === TRUE) {
    // gets count of cars in the inventory table or sets error to session message
    $totalCars = $mysqli->query("SELECT COUNT(*) AS total FROM `if0_38352683_vehicles`.`inventory`")->fetch_assoc()['total'];
    $_SESSION['message'] = "Database updated. Inventory now has $totalCars vehicles.";
} else {
    $_SESSION['message'] = "Error inserting cars: " . $mysqli->error;
}

$mysqli->close();
header("Location: ../");
exit;
?>