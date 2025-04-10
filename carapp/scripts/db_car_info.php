<?php
$vin = htmlspecialchars($_GET['VIN']);
$query = "SELECT * FROM inventory WHERE VIN='$vin'";
if ($result = $mysqli->query($query)) {
    //  echo "<p>Got the info</p>"; // Don't do anything if successful.
    } else {
     echo "Sorry, a vehicle with VIN of $vin cannot be found " .  $mysqli->error."<br>";
    }
while ($result_ar = mysqli_fetch_assoc($result)) {
 $VIN = $result_ar['VIN'];
 $year = $result_ar['YEAR'];
 $make = $result_ar['MAKE'];
 $model = $result_ar['MODEL'];
 $trim = $result_ar['TRIM'];
 $color = $result_ar['EXT_COLOR'];
 $interior = $result_ar['INT_COLOR'];
 $mileage = $result_ar['MILEAGE'];
 $transmission = $result_ar['TRANSMISSION'];
 $price = $result_ar['ASKING_PRICE'];
}