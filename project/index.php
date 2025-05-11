<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'scripts/auth.php';
}

$view = $_GET['view'] ?? 'login';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Worklog Manager</title>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/layout.css">
    <script src="https://lint.page/kit/880bd5.js" crossorigin="anonymous"></script>
</head>
<body>
<h2>Worklog Manager</h2>
<!-- check login status to determine what to show -->
<?php if (!isset($_SESSION['user_id'])): ?>
    <?php include 'components/auth_forms.php'; ?>
<?php else: ?>
    <div class="welcome_bar">
        <p>Welcome, <?= htmlspecialchars($_SESSION['username']) ?> |
            <a href="scripts/auth.php?logout=true">Logout</a>
        </p>
    </div>
    <?php include 'components/worklog_form.php'; ?>
<?php endif; ?>
</body>
</html>
