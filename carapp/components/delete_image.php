<?php

//connect to mysql
include('../scripts/db_connection.php');
//select a database to work with
include('../scripts/db_config.php');

if(isset($_POST['delete'])) {
    $imageId = $_POST['image_id'];
    $vin = $_POST['vin'];

$query = "SELECT ImageFile FROM IMAGES WHERE ID='$imageId'";
$result = $mysqli->query($query);
if ($row = $result->fetch_assoc()) {
    $imageFile = $row['ImageFile'];
    $imagePath = __DIR__ . "/images/uploads/" . $imageFile;

    if (file_exists($imagePath)) {
        unlink($imagePath);
    }

    $deleteQuery = "DELETE FROM IMAGES WHERE ID='$imageId'";
    if ($mysqli->query($deleteQuery)) {
        echo "Image deleted successfully.<br>";
    } else {
        echo "Error deleting image: " . $mysqli->error . "<br>";
    }
}

header("Location: add_image.php?VIN=$vin");
exit();

}
$mysqli->close();
?>