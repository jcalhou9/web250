<?php
require_once __DIR__ . '/../database/db_config.php';
session_start();

function redirectHome() {
    header('Location: ../index.php');
    exit;
}

//logout
if (isset($_GET['logout'])) {
    session_destroy();
    redirectHome();
}

//signup
if (isset($_POST['signup'])) {
    $username = trim($_POST['signup_username'] ?? '');
    $password = trim($_POST['signup_password'] ?? '');
    $_SESSION['old'] = $_POST;

    if ($username === '' || $password === '') {
        $_SESSION['error'] = 'Please fill out both username and password to sign up.';
        redirectHome();
    }
    $stmt = $mysqli->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = 'That username is already taken.';
        redirectHome();
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $mysqli->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
    $stmt->bind_param('ss', $username, $hash);
    if ($stmt->execute()) {
        unset($_SESSION['old']);
        $_SESSION['user_id'] = $stmt->insert_id;
        $_SESSION['username'] = $username;
        redirectHome();
    } else {
        $_SESSION['error'] = 'Signup failed. Please try again later.';
        redirectHome();
    }
}

//login
if (isset($_POST['login'])) {
    $username = trim($_POST['login_username'] ?? '');
    $password = trim($_POST['login_password'] ?? '');
    $_SESSION['old'] = $_POST;
    if ($username === '' || $password === '') {
        $_SESSION['error'] = 'Please enter both username and password to log in.';
        redirectHome();
    }
    $stmt = $mysqli->prepare("SELECT id, password_hash FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($userId, $hash);
        $stmt->fetch();
        if (password_verify($password, $hash)) {
            unset($_SESSION['old']);
            $_SESSION['user_id'] = $userId;
            $_SESSION['username'] = $username;
            redirectHome();
        } else {
            $_SESSION['error'] = 'Incorrect password. Please try again.';
            redirectHome();
        }
    } else {
        $_SESSION['error'] = 'Username not found.';
        redirectHome();
    }
}