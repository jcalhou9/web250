<?php
require 'scripts/db_config.php';
$error = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>

<h2>Login</h2>

<?php if ($error): ?>
    <div id="sessionMessage"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" action="scripts/auth.php">
    <label>Username:<br><input type="text" name="username" required></label><br>
    <label>Password:<br><input type="password" name="password" required></label><br>
    <button type="submit">Login</button>
</form>

<p><a href="index.php">Continue without logging in</a></p>
