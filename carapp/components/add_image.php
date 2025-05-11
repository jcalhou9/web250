<?php 
include 'scripts/db_car_info.php';
echo "<p>$year $make $model <br>VIN: $vin</p>";

$query = "SELECT * FROM images WHERE VIN='$vin'";
/* Try to query the database */
if ($result = $mysqli->query($query)) {
    while ($result_ar = mysqli_fetch_assoc($result)) {
        $image = $result_ar['IMAGEFILE'];
        $imageId = $result_ar['ID'];
        ?>
        <figure>
            <img src='images/uploads/<?=$image ?>'>
            <form action='scripts/delete_image.php' method='post'>
                <input type='hidden' name='image_id' value=<?= $imageId ?>>
                <input type='hidden' name='VIN' value=<?= $vin ?>>
                <input type='submit' name='delete' value='Delete'>
            </form>
        </figure>
        <?php
    }
}
?>
<form action="scripts/upload_file.php" method="post" enctype="multipart/form-data">
    <br/>
    <label for="file">Filename:</label>
    <input type="file" name="file" id="file"><br>
    <input name="VIN" type="hidden" value= "<?= $vin ?>" /><br/>
    <input type="submit" name="submit" value="Submit">
    <button type="button" onclick="location.href='index.php'">Close</button>
</form>