<?php


$serverName = 'sql212.infinityfree.com';
$username = 'if0_38352683';
$password = 'Projectsite11';
$databaseName = 'if0_38352683_CARS';


// $serverName = 'localhost';
// $username = 'root';
// $password = '';
// $databaseName = 'if0_38352683_CARS';

$mysqli = new mysqli($serverName, $username, $password);
/* check connection */
try {
    if (mysqli_connect_errno()) { 
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
} catch (mysqli_sql_exception $e) {
    echo "<p>Connection error</p>";
}
// printf('Connected to cars database ');
?>