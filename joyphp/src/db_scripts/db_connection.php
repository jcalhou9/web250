<?php


// $serverName = 'sql212.infinityfree.com';
// $username = 'if0_38352683';
// $password = 'Projectsite11';
// $databaseName = 'if0_38352683_Cars';


$serverName = 'localhost';
$username = 'root';
$password = '';
$databaseName = 'if0_38352683_Cars';

$mysqli = new mysqli($serverName, $username, $password);
/* check connection */
if (mysqli_connect_errno()) { 
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
// printf('Connected to cars database ');
?>