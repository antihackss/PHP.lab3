<?php
require 'vendor/autoload.php';
require 'config.php';

use App\Auth;

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    $auth->autoLogin();
}

$auth->applyUserSettings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentication System</title>
    <style>
        .container { max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        button { background: #007bff; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; margin-bottom: 10px; }
        .nav { margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <?php if ($auth->isLoggedIn()): ?>
            <div class="nav">
                <h2>Welcome, <?php echo $_SESSION['username']; ?>!</h2>
                <a href="dashboard.php">Dashboard</a> |
                <a href="settings.php">Settings</a> |
                <a href="logout.php">Logout</a>
            </div>
            <p>You have successfully logged into the system.</p>
        <?php else: ?>
            <h1>Authentication System</h1>
            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <h3>Registration</h3>
                    <form action="register.php" method="POST">
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" name="password" required>
                        </div>
                        <h4>Appearance Settings:</h4>
                        <div class="form-group">
                            <label>Background Color:</label>
                            <input type="color" name="bg_color" value="#ffffff">
                        </div>
                        <div class="form-group">
                            <label>Text Color:</label>
                            <input type="color" name="text_color" value="#000000">
                        </div>
                        <div class="form-group">
                            <label>Font Size:</label>
                            <select name="font_size">
                                <option value="14px">Small</option>
                                <option value="16px" selected>Medium</option>
                                <option value="18px">Large</option>
                                <option value="20px">Extra Large</option>
                            </select>
                        </div>
                        <button type="submit">Register</button>
                    </form>
                </div>
                
                <div style="flex: 1;">
                    <h3>Login</h3>
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label>Username:</label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Password:</label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="remember"> Remember me
                            </label>
                        </div>
                        <button type="submit">Login</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>