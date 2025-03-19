<html>
<head>
<title>Jeremy's Used Cars - Image Upload</title>
</head>
<body background="../images/bg.jpg">
<h1>Jeremy's Used Cars</h1>
<p><a href="../">Return Home</a></p>
<h3>Add Image</h3>
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
	$make = $result_ar['Make'];
    $model = $result_ar['Model'];
    $trim = $result_ar['TRIM'];
    $color = $result_ar['EXT_COLOR'];
    $interior = $result_ar['INT_COLOR'];
    $mileage = $result_ar['MILEAGE']; 
    $transmission = $result_ar['TRANSMISSION']; 
    $price = $result_ar['ASKING_PRICE'];
}
echo "<p>$color $year $make $model <br>VIN: $vin</p>";
echo "<p>Asking Price: $".number_format($price,0) ."</p>";


   
?>

<form action="../scripts/upload_file.php" method="post" enctype="multipart/form-data">
    <label for="file">Filename:</label>
    <input type="file" name="file" id="file"><br>
    <input name="VIN" type="hidden" value= "<?php echo "$vin" ?>" />
    <input type="submit" name="submit" value="Submit">
    </form>
<br/><br/>
<?php
$query = "SELECT * FROM images WHERE VIN='$vin'";
/* Try to query the database */
if ($result = $mysqli->query($query)) {
    while ($result_ar = mysqli_fetch_assoc($result)) {
        $image = $result_ar['ImageFile'];
        $imageId = $result_ar['ID'];
        echo "<div style='display: inline-block; margin: 10px; text-align: center;'>";
        echo "<img src='../images/uploads/$image' width='250'><br>";
        echo "<form action='delete_image.php' method='post'>";
        echo "<input type='hidden' name='image_id' value='$imageId'>";
        echo "<input type='hidden' name='vin' value='$vin'>";
        echo "<input type='submit' name='delete' value='Delete'>";
        echo "</form>";
        echo "</div>";
    }
}
$mysqli->close();
?>
</body>

</html> 