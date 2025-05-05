<?php 
session_start();
require 'db_config.php';

//handle logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    unset($_SESSION['cars_per_page']);
    session_destroy();
    header("Location: ../index.php");
    exit;
}

//handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $mysqli->prepare("SELECT id, password, first_name, last_name FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($id, $hashedPassword, $firstName, $lastName);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['first_name'] = $firstName;
        $_SESSION['last_name'] = $lastName;
        $stmt->close();
        header("Location: ../index.php");
        exit;
    } else {
        $_SESSION['login_error'] = "Invalid username or password.";
        $stmt->close();
        header("Location: ../index.php?sectionView=login");
        exit;
    }
}
