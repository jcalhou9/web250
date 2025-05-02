<?php
include 'db_config.php';

$vin = trim($_POST['VIN']);
$file = $_FILES["file"];
$fileName = basename($file['name']);
$fileSize = $file['size'] / 1024;
$fileTmpName = $file['tmp_name'];
$fileError = $file["error"];

if ($fileError > 0) {
    echo "Error: $fileError<br>";
} else {
    $targetPath = __DIR__ . "/../images/uploads/" . $fileName;
    $imageName = "../images/uploads/" . $fileName;

    if (move_uploaded_file($fileTmpName, $targetPath)) {
        echo "The file $fileName has been uploaded.<br>";

        $query = "INSERT INTO images (VIN, IMAGEFILE) VALUES (?, ?)";
        if ($imageInsertStatement = $mysqli->prepare($query)) {
            $imageInsertStatement->bind_param("ss", $vin, $fileName);
            if ($imageInsertStatement->execute()) {
                echo "<p>Successfully entered $fileName into the database.</p>";
                echo "<a href='add_image.php?VIN=$vin'>Add another image for this car</a>";
                echo "<br><img src='$imageName'><br>";
            } else {
                echo "Error entering $vin into database: " . $imageInsertStatement->error . "<br>";
            }
            $imageInsertStatement->close();
        } else {
            echo "Failed to prepare the query: " . $mysqli->error . "<br>";
        }

        $mysqli->close();
    } else {
        echo "There was an error uploading the file, please try again!";
    }
}

header("Location: ../index.php?sectionView=images&VIN=$vin");
exit;