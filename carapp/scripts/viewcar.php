<?php 
include 'scripts/db_car_info.php';
?>

<h3>View Car</h3>
<p><?= $year ?> <?= $make ?> <?= $model ?></p>
<p>Asking Price: <?= $price ?></p>
<p>Exterior Color: <?= $color ?></p>
<p>Interior Color: <?= $interior ?></p>

<?php
$query = "SELECT * FROM images WHERE VIN='$vin'";
/* Try to query the database */
if ($result = $mysqli->query($query)) {
    $images = $result->fetch_all(MYSQLI_ASSOC);

    foreach ($images as $imageData) {
        $image = htmlspecialchars($imageData['IMAGEFILE']);
        $imageId = htmlspecialchars($imageData['ID']);
        ?>
        <figure>
            <img src="images/uploads/<?= $image ?>">
            <form method="GET" action="delete_image.php">
                <input type="hidden" name="image_id" value="<?= $imageId ?>">
                <input type="hidden" name="vin" value="<?= $vin ?>">
            </form>
        </figure>
        <?php
    }
}
?>
<br>
<a href="index.php"><button type="button">Close</button></a><br />