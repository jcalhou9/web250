<?php
session_start();
include 'db_config.php';
//get vin and file
$vin = trim($_POST['VIN']);
$file = $_FILES["file"];
$originalName = basename($file['name']);
$ext = pathinfo($originalName, PATHINFO_EXTENSION);
//handles dublicate file names
$uniqueName = time() . '_' . preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $originalName);
$fileTmpName = $file['tmp_name'];
$fileError = $file["error"];
if ($fileError > 0) {
    $_SESSION['message'] = "File upload error: $fileError";
} else {
    $targetPath = __DIR__ . "/../images/uploads/" . $uniqueName;
    //move to uploads and saves file record to database
    if (move_uploaded_file($fileTmpName, $targetPath)) {
        $query = "INSERT INTO images (VIN, IMAGEFILE) VALUES (?, ?)";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param("ss", $vin, $uniqueName);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Uploaded and added $fileName successfully.";
        } else {
            $_SESSION['message'] = "DB insert error for image: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Failed to move uploaded file.";
    }
}
header("Location: ../index.php?sectionView=edit&VIN=$vin#images");
exit;