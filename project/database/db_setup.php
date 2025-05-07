<?php
require_once __DIR__ . '/db_config.php';
$messages = [];

//create database
if ($mysqli->query("CREATE DATABASE IF NOT EXISTS $databaseName")) {
    $messages[] = "Database '$databaseName' created or already exists.";
    $mysqli->select_db($databaseName);
} else {
    exit("<p>Failed to create database '$databaseName': " . $mysqli->error . "</p>");
}

// drop tables if needed:
// $mysqli->query("DROP TABLE IF EXISTS work_logs");
// $mysqli->query("DROP TABLE IF EXISTS users");

//create users table
$createUsers = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL
) ENGINE=InnoDB;
";
if ($mysqli->query($createUsers)) {
    $messages[] = "users table created.";
} else {
    $messages[] = "users table error: " . $mysqli->error;
}

//create worklogs table
$createLogs = "
CREATE TABLE IF NOT EXISTS work_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    log_date DATE NOT NULL,
    time_started TIME NOT NULL,
    time_ended TIME DEFAULT NULL,
    work_description TEXT NOT NULL,
    notes TEXT,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB;
";
if ($mysqli->query($createLogs)) {
    $messages[] = "work_logs table created.";
} else {
    $messages[] = "work_logs table error: " . $mysqli->error;
}

//results messages
foreach ($messages as $message) {
    echo "<p>$message</p>";
}
?>
