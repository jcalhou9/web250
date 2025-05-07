<div class="auth_forms">
    <!-- determine which form to show -->
    <?php
    $currentView = $_GET['view'] ?? 'login';
    ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="error_message"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if ($currentView === 'signup'): ?>
        <!-- signup Form -->
        <form method="post" action="scripts/auth.php" class="auth_form">
            <h3>Sign Up</h3>
            <label>Username:
                <input type="text" name="signup_username" required
                       value="<?= isset($_SESSION['old']['signup_username']) ? htmlspecialchars($_SESSION['old']['signup_username']) : '' ?>">
            </label>
            <label>Password:
                <input type="password" name="signup_password" required>
            </label>
            <input type="submit" name="signup" value="Sign Up">
        </form>
        <p class="auth_toggle">Already signed up? <a href="?view=login">Log in</a></p>

    <?php else: ?>
        <!-- login Form -->
        <form method="post" action="scripts/auth.php" class="auth_form">
            <h3>Login</h3>
            <label>Username:
                <input type="text" name="login_username" required
                       value="<?= isset($_SESSION['old']['login_username']) ? htmlspecialchars($_SESSION['old']['login_username']) : '' ?>">
            </label>
            <label>Password:
                <input type="password" name="login_password" required>
            </label>
            <input type="submit" name="login" value="Log In">
        </form>
        <p class="auth_toggle">Not signed up yet? <a href="?view=signup">Sign up</a></p>
    <?php endif; ?>

    <?php unset($_SESSION['old']); ?>
</div>
