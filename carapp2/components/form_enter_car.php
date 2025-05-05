<?php
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?sectionView=login");
    exit;
}
?>
<!-- add car form -->
<form action="scripts/submit_car.php" method="post">
    <h3>Add a Car</h3>
    <div class="carFormGrid">
        <label>VIN: <input type="text" name="VIN" required></label>
        <label>Year: <input type="number" name="YEAR"></label>
        <label>Make: <input type="text" name="MAKE" required></label>
        <label>Model: <input type="text" name="MODEL" required></label>
        <label>Trim: <input type="text" name="TRIM"></label>
        <label>Exterior Color: <input type="text" name="EXT_COLOR"></label>
        <label>Interior Color: <input type="text" name="INT_COLOR"></label>
        <label>Asking Price: <input type="number" name="ASKING_PRICE" required></label>
        <label>Sale Price: <input type="number" name="SALE_PRICE"></label>
        <label>Purchase Price: <input type="number" name="PURCHASE_PRICE"></label>
        <label>Mileage: <input type="number" name="MILEAGE"></label>
        <label>Transmission: <input type="text" name="TRANSMISSION"></label>
        <label>Purchase Date: <input type="date" name="PURCHASE_DATE"></label>
        <label>Sale Date: <input type="date" name="SALE_DATE"></label>
    </div>
    <button type="submit">Submit</button>
    <a href="index.php" class="closeButton" title="Close">&times;</a>
</form>
