<?php

//connect to mysql
include('../scripts/db_connection.php');
//select a database to work with
include('../scripts/db_config.php');

$vin = trim($_POST['VIN']);

if ($_FILES["file"]["error"] > 0) {
  echo "Error: " . $_FILES["file"]["error"] . "<br>";
  } else {
  echo "Upload: " . $_FILES["file"]["name"] . "<br>". "\n";
  echo "Type: " . $_FILES["file"]["type"] . "<br>". "\n";
  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>". "\n";
  echo "VIN: ".$vin."<br>";
  echo "Stored temporarily as: " . $_FILES["file"]["tmp_name"]."<br><BR>". "\n";
  $currentFolder =  getcwd();
  echo "This script is running in: " .$currentFolder."<br>". "\n";
  $targetPath = __DIR__ . "/../images/uploads/";
  echo "The uploaded file will be stored in the folder: ".$targetPath."<br>". "\n";

  $targetPath = $targetPath . basename( $_FILES['file']['name']); 
  $imageName = "../images/uploads/". basename( $_FILES['file']['name']); 
  echo "The full file name of the uploaded file is '". $targetPath."'<br>". "\n";

  echo "The relative name of the file for use in the IMG tag is " . $imageName ."<br><br>". "\n";;

if(move_uploaded_file($_FILES['file']['tmp_name'], $targetPath)) {
    echo "The file ".  basename( $_FILES['file']['name']). " has been uploaded<br>". "\n";
   
    // Create a database entry for this image
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }

  echo 'Connected successfully to mySQL. <BR>'; 
  $fileName =  $_FILES["file"]["name"];
  $query = "INSERT INTO IMAGES (VIN, IMAGEFILE) VALUES ('$vin', '$fileName')";
  echo $query."<br>\n";
  echo  "<a href='add_image.php?VIN=";
  echo $vin;
  echo "'>Add another image for this car </a></p>\n";
/* Try to insert the new car into the database */
if ($result = $mysqli->query($query)) {
       echo "<p>You have successfully entered $targetPath into the database.</P>\n";
       
    } else {
      echo "Error entering $vin into database: " . $mysqli->error."<br>";
    }
    $mysqli->close();
    echo "<img src='$imageName' width='150'><br>";

    } else{
    echo "There was an error uploading the file, please try again!";
    }
  }
  header("Location: ../components/add_image.php?VIN=$vin");
  
?> 