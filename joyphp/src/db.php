<?php
$mysqli = new mysqli('sql212.infinityfree.com', 'if0_38352683', 'Projectsite11', 'if0_38352683_Cars') //('localhost', 'root', '', 'Cars' ); //if0_38352683_Cars	if0_38352683	(Your vPanel Password)	sql212.infinityfree.com
/* check connection */
if (mysqli_connect_errno()) { 
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
printf('connected to cars')
//select a database to work with
$mysqli->select_db("Cars");
 
?>