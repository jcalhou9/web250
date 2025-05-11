<?php
include 'scripts/db_car_info.php';
?>

<form action="scripts/edit_car.php" method="post">
    <h3>Edit Car</h3>
    VIN: <input name="VIN" type="text" value= "<?php echo $VIN ?>" readonly/><br />
    Year: <input name="YEAR" type="number" value= "<?php echo $year ?>" /><br />
    Make: <input name="MAKE" type="text" value= "<?php echo $make ?>" /><br />
    Model: <input name="MODEL" type="text" value= "<?php echo $model ?>" /><br />
    Price: <input name="ASKING_PRICE" type="number" value= "<?php echo $price ?>" /><br />
    <input name="Submit1" type="submit" value="submit" />
    <button type="button" onclick="location.href='index.php'">Close</button>
</form>
