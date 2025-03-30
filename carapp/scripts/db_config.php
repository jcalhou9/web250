 <?php
//select a database to work with
try {
    $mysqli->select_db("if0_38352683_vehicles");
    // printf('Cars database selected ');
} catch (mysqli_sql_exception $e){
    echo "<p>Database not found</p>";
}

?>