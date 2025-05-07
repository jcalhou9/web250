<?php
session_start();
require_once '../database/db_config.php';

function redirectHome() {
    header('Location: ../index.php');
    exit;
}

//redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    redirectHome();
}
$userId = $_SESSION['user_id'];
//cancel edit
if (isset($_POST['cancel_edit'])) {
    unset($_SESSION['edit_log_id'], $_SESSION['old']);
    redirectHome();
}

//add worklog
if (isset($_POST['add_log'])) {
    $logDate = trim($_POST['log_date'] ?? '');
    $timeStarted = trim($_POST['time_started'] ?? '');
    $timeEnded = trim($_POST['time_ended'] ?? '') ?: null;
    $description = trim(substr($_POST['work_description'] ?? '', 0, 1000));
    $notes = trim(substr($_POST['notes'] ?? '', 0, 1000));
    $_SESSION['old'] = $_POST;
    if ($logDate === '' || $timeStarted === '' || $description === '') {
        $_SESSION['error'] = 'Date, start time, and description are required.';
        redirectHome();
    }
    $stmt = $mysqli->prepare("INSERT INTO work_logs (user_id, log_date, time_started, time_ended, work_description, notes)
                              VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('isssss', $userId, $logDate, $timeStarted, $timeEnded, $description, $notes);
    if ($stmt->execute()) {
        unset($_SESSION['old']);
        $_SESSION['success'] = 'Log added successfully.';
    } else {
        $_SESSION['error'] = 'Error adding log.';
    }
    redirectHome();
}

//delete worklog
if (isset($_POST['delete_log'], $_POST['log_id'])) {
    $logId = (int) $_POST['log_id'];
    $stmt = $mysqli->prepare("DELETE FROM work_logs WHERE id = ? AND user_id = ?");
    $stmt->bind_param('ii', $logId, $userId);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Log deleted.';
    } else {
        $_SESSION['error'] = 'Error deleting log.';
    }
    redirectHome();
}

//set edit status with id
if (isset($_POST['edit_log'], $_POST['log_id'])) {
    $_SESSION['edit_log_id'] = (int) $_POST['log_id'];
    unset($_SESSION['old']);
    redirectHome();
}

//update worklog
if (isset($_POST['update_log'], $_POST['log_id'])) {
    $logId = (int) $_POST['log_id'];
    $logDate = trim($_POST['log_date'] ?? '');
    $timeStarted = trim($_POST['time_started'] ?? '');
    $timeEnded = trim($_POST['time_ended'] ?? '') ?: null;
    $description = trim(substr($_POST['work_description'] ?? '', 0, 1000));
    $notes = trim(substr($_POST['notes'] ?? '', 0, 1000));
    $stmt = $mysqli->prepare("UPDATE work_logs
                              SET log_date = ?, time_started = ?, time_ended = ?, work_description = ?, notes = ?
                              WHERE id = ? AND user_id = ?");
    $stmt->bind_param('sssssii', $logDate, $timeStarted, $timeEnded, $description, $notes, $logId, $userId);
    if ($stmt->execute()) {
        unset($_SESSION['edit_log_id'], $_SESSION['old']);
        $_SESSION['success'] = 'Log updated.';
    } else {
        $_SESSION['error'] = 'Error updating log.';
    }
    redirectHome();
}

redirectHome();
