<?php

//connect to mysql
include('db_connection.php');
//select a database to work with
include('db_config.php');

if(isset($_POST['delete'])) {
    $imageId = $_POST['image_id'];
    $vin = $_POST['VIN'];

$query = "SELECT IMAGEFILE FROM images WHERE ID='$imageId'";
$result = $mysqli->query($query);
if ($row = $result->fetch_assoc()) {
    $imageFile = $row['IMAGEFILE'];
    $imagePath = __DIR__ . "/images/uploads/" . $imageFile;

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    $deleteQuery = "DELETE FROM images WHERE ID='$imageId'";
    if ($mysqli->query($deleteQuery)) {
        echo "Image deleted successfully.<br>";
    } else {
        echo "Error deleting image: " . $mysqli->error . "<br>";
    }
}

header("Location: ../components/add_image.php?VIN=$vin");
exit();

}
$mysqli->close();
?>