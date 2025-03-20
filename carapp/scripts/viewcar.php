<html>
<head>
<title>Jeremy's Used Cars</title>
</head>

<body background="../images/bg.jpg">

<h1>Jeremy's Used Cars</h1>
<p><a href="../">Return Home</a></p>
<?php 

//connect to mysql
include('../scripts/db_connection.php');
//select a database to work with
include('../scripts/db_config.php');

$vin = $_GET['VIN'];
$query = "SELECT * FROM INVENTORY WHERE VIN='$vin'";
/* Try to query the database */
if ($result = $mysqli->query($query)) {
   // Don't do anything if successful.
}
else
{
    echo "Sorry, a vehicle with VIN of $vin cannot be found " . $mysqli->error."<br>";
}
// Loop through all the rows returned by the query, creating a table row for each
while ($result_ar = mysqli_fetch_assoc($result)) {
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
echo "<h3>$year $make $model </h3>";
echo "<p>Asking Price: $price </p>";
echo "<p>Exterior Color: $color </p>";
echo "<p>Interior Color: $interior </p>";

$query = "SELECT * FROM IMAGES WHERE VIN='$vin'";
/* Try to query the database */
if ($result = $mysqli->query($query)) {
    $images = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($images as $imageData) {
        $image = htmlspecialchars($imageData['IMAGEFILE']);
        $imageId = htmlspecialchars($imageData['ID']);
        ?>
        <div style="display: inline-block; margin: 10px; text-align: center;">
            <img src="../images/uploads/<?= $image ?>" width="250"><br>
            <form method="GET" action="delete_image.php">
                <input type="hidden" name="image_id" value="<?= $imageId ?>">
                <input type="hidden" name="vin" value="<?= htmlspecialchars($vin) ?>">
            </form>
        </div>
        <?php
    }
}

$mysqli->close();
   
?>

</body>

</html>
