<?php
require 'vendor/autoload.php';
require 'config.php';

use App\Auth;

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$auth->applyUserSettings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <h1>User Dashboard</h1>
        <p>Welcome, <?php echo $_SESSION['username']; ?>!</p>
        <p>This is a protected page accessible only to authorized users.</p>
        
        <div style="margin-top: 20px;">
            <h3>Your Current Settings:</h3>
            <ul>
                <li>Background Color: <?php echo $_COOKIE['bg_color'] ?? 'Not set'; ?></li>
                <li>Text Color: <?php echo $_COOKIE['text_color'] ?? 'Not set'; ?></li>
                <li>Font Size: <?php echo $_COOKIE['font_size'] ?? 'Not set'; ?></li>
            </ul>
        </div>

        <div style="margin-top: 20px;">
            <a href="settings.php">Change Settings</a> |
            <a href="index.php">Home</a> |
            <a href="logout.php">Logout</a>
        </div>
    </div>
</body>
</html>