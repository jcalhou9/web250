<?php
session_start();
require 'db_config.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['imageId'], $_POST['VIN'])) {
    $imageId = (int) $_POST['imageId'];
    $vin = trim($_POST['VIN']);
    // get filename from database
    $stmt = $mysqli->prepare("SELECT IMAGEFILE FROM images WHERE ID = ?");
    $stmt->bind_param("i", $imageId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $imageFile = $row['IMAGEFILE'];
        $imagePath = __DIR__ . '/../images/uploads/' . $imageFile;
        //delete file if exists
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        //delete database record
        $deleteStmt = $mysqli->prepare("DELETE FROM images WHERE ID = ?");
        $deleteStmt->bind_param("i", $imageId);
        if ($deleteStmt->execute()) {
            $_SESSION['message'] = "Image deleted successfully.";
        } else {
            $_SESSION['message'] = "Database delete error: " . $deleteStmt->error;
        }
        $deleteStmt->close();
    } else {
        $_SESSION['message'] = "Image not found in database.";
    }
    $stmt->close();
    $mysqli->close();
    //redirect back to edit page
    header("Location: ../index.php?sectionView=edit&VIN=" . urlencode($vin) . "#images");
    exit;
}
$_SESSION['message'] = "Invalid request.";
header("Location: ../index.php");
exit;
