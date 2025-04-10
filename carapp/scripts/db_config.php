<?php
$isLocalhost = in_array($_SERVER['SERVER_NAME'], ['localhost','127.0.0.1']);

$serverName = $isLocalhost ? 'localhost' : 'xxxxxxx';
$username = $isLocalhost ? 'root' : 'xxxxx';
$password = $isLocalhost ? '' : 'xxxxx';
$databaseName = 'if0_38352683_vehicles';

$mysqli = new mysqli($serverName, $username, $password);

if ($mysqli->connect_error) {
    exit('<p>Connection failed: ' . $mysqli->connect_error . '</p>');
}

//select a database to work with
try {
    $mysqli->select_db("if0_38352683_vehicles");
    // printf('Cars database selected ');
} catch (mysqli_sql_exception $e){
    echo "<p>Database not found</p>";
}


?>