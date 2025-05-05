<?php
include 'scripts/db_car_info.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php?sectionView=login');
    exit;
}
//defaults values
$vin = $vin ?? '';
$year = $year ?? '';
$make = $make ?? '';
$model = $model ?? '';
$trim = $trim ?? '';
$extColor = $color ?? '';
$intColor = $interior ?? '';
$price = is_numeric($price) ? $price : '';
$salePrice = $salePrice ?? '';
$purchasePrice = $purchasePrice ?? '';
$mileage = $mileage ?? '';
$transmission = $transmission ?? '';
$purchaseDate = $purchaseDate ?? '';
$saleDate = $saleDate ?? '';
?>
<!-- image container for styling -->
<div id="images">
    <h3>Manage Images</h3>
    <!-- image query for selected vin -->
    <?php
    $imageQuery = $mysqli->prepare("SELECT ID, IMAGEFILE FROM images WHERE VIN = ?");
    $imageQuery->bind_param("s", $vin);
    $imageQuery->execute();
    $imageResult = $imageQuery->get_result();
    //display images if any exist
    if ($imageResult->num_rows > 0): ?>
        <!-- bandaid to center image if only one image exists -->
        <div class="imageScroller <?= $imageResult->num_rows === 1 ? 'singleImage' : '' ?>">
            <?php while ($img = $imageResult->fetch_assoc()):
                $imagePath = "images/uploads/" . htmlspecialchars($img['IMAGEFILE']);
                if (!file_exists($imagePath)) $imagePath = "images/default.jpg";
            ?>
                <figure class="imageCard">
                    <img src="<?= $imagePath ?>" alt="Car Image" class="uploadedImage">
                    <form action="scripts/delete_image.php#images" method="post">
                        <input type="hidden" name="imageId" value="<?= $img['ID'] ?>">
                        <input type="hidden" name="VIN" value="<?= htmlspecialchars($vin) ?>">
                        <button type="submit" name="delete" class="deleteBtn">Delete</button>
                    </form>
                </figure>
            <?php endwhile; ?>
        </div>
    <!-- message if no images exist -->
    <?php else: ?>
        <p>No images yet.</p>
    <?php endif; ?>
    <hr>
    <h4>Add New Image</h4>
    <!-- image upload form -->
    <form action="scripts/upload_file.php#images" method="post" enctype="multipart/form-data">
        <input type="hidden" name="VIN" value="<?= htmlspecialchars($vin) ?>">
        <input type="file" name="file" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>
</div>
<hr>
<!-- edit car form -->
<form action="scripts/edit_car.php" method="post">
    <h3>Edit Car</h3>
    <div class="carFormGrid">
        <label>VIN:<input name="VIN" type="text" value="<?= htmlspecialchars($vin) ?>" readonly /></label>
        <label>Year:<input name="YEAR" type="number" value="<?= htmlspecialchars($year) ?>" /></label>
        <label>Make:<input name="MAKE" type="text" value="<?= htmlspecialchars($make) ?>" /></label>
        <label>Model:<input name="MODEL" type="text" value="<?= htmlspecialchars($model) ?>" /></label>
        <label>Trim:<input name="TRIM" type="text" value="<?= htmlspecialchars($trim) ?>" /></label>
        <label>Exterior Color:<input name="EXT_COLOR" type="text" value="<?= htmlspecialchars($extColor) ?>" /></label>
        <label>Interior Color:<input name="INT_COLOR" type="text" value="<?= htmlspecialchars($intColor) ?>" /></label>
        <label>Asking Price:<input name="ASKING_PRICE" type="number" value="<?= htmlspecialchars($price) ?>" /></label>
        <label>Sale Price:<input name="SALE_PRICE" type="number" value="<?= htmlspecialchars($salePrice) ?>" /></label>
        <label>Purchase Price:<input name="PURCHASE_PRICE" type="number" value="<?= htmlspecialchars($purchasePrice) ?>" /></label>
        <label>Mileage:<input name="MILEAGE" type="number" value="<?= htmlspecialchars($mileage) ?>" /></label>
        <label>Transmission:<input name="TRANSMISSION" type="text" value="<?= htmlspecialchars($transmission) ?>" /></label>
        <label>Purchase Date:<input name="PURCHASE_DATE" type="date" value="<?= htmlspecialchars($purchaseDate) ?>" /></label>
        <label>Sale Date:<input name="SALE_DATE" type="date" value="<?= htmlspecialchars($saleDate) ?>" /></label>
    </div>
    <button type="submit">Submit</button>
    <a href="index.php" class="closeButton" title="Close">&times;</a>
</form>