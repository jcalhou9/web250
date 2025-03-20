 <?php
$mysqli = new mysqli($serverName = 'sql212.infinityfree.com',
$username = 'if0_38352683', $password = 'xxxxxxxxxxx', $databaseName = 'if0_38352683_cars');
/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//select a database to work with
$mysqli->select_db("if0_38352683_cars");
 
?>