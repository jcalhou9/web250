<?php  
include 'scripts/db_car_info.php';
$page = $_GET['page'] ?? 1;
?>

<?php if ($vin && $year !== 'N/A'): ?>
    <h3>View Car</h3>

    <?php
    //show fields only if they are not empty or null
    function showField($label, $value) {
        $suppress = ['', '0', 0, '0.00', '0000-00-00', null];
        if (!in_array($value, $suppress, true)) {
            echo "<div class='fieldPair'><strong>$label:</strong> <span>" . htmlspecialchars($value) . "</span></div>";
        }
    }

    //load image to scroller
    $query = "SELECT IMAGEFILE FROM images WHERE VIN = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("s", $vin);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0): ?>
        <!-- bandaid to center image if only one image exists -->
        <div class="imageScroller <?= $result->num_rows === 1 ? 'singleImage' : '' ?>">
            <?php while ($img = $result->fetch_assoc()):
                $file = htmlspecialchars($img['IMAGEFILE']);
                $path = "images/uploads/$file";
                if (!file_exists($path)) $path = "images/default.jpg";
            ?>
                <figure>
                    <img src="<?= $path ?>" alt="Car image">
                </figure>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <!-- default image if no images exist -->
        <div class="imageScroller singleImage">
            <figure>
                <img src="images/default.jpg" alt="No image available">
            </figure>
        </div>
    <?php endif;
    $stmt->close();
    ?>

    <!-- car details layout -->
    <div class="carDetailsGrid">
        <?php
        showField('Year', $year);
        showField('Make', $make);
        showField('Model', $model);
        showField('Trim', $trim);
        showField('Exterior Color', $color);
        showField('Interior Color', $interior);
        showField('Asking Price', $price);
        showField('Sale Price', $salePrice);
        showField('Purchase Price', $purchasePrice);
        showField('Mileage', $mileage);
        showField('Transmission', $transmission);
        showField('Purchase Date', $purchaseDate);
        showField('Sale Date', $saleDate);
        ?>
    </div>
    <!-- return to previous page -->
    <a href="index.php?page=<?= $page ?>" class="closeButton" title="Close">&times;</a>
<?php endif; ?>
