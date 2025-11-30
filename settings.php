<?php
require 'vendor/autoload.php';
require 'config.php';

use App\Auth;
use App\User;

$auth = new Auth();

if (!$auth->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$userModel = new User();
$user = $userModel->findByUsername($_SESSION['username']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bgColor = $_POST['bg_color'] ?? '#ffffff';
    $textColor = $_POST['text_color'] ?? '#000000';
    $fontSize = $_POST['font_size'] ?? '16px';

    if ($userModel->updateSettings($user['id'], $bgColor, $textColor, $fontSize)) {
        $auth->setUserCookies([
            'id' => $user['id'],
            'bg_color' => $bgColor,
            'text_color' => $textColor,
            'font_size' => $fontSize,
            'password' => $user['password']
        ], isset($_COOKIE['user_token']));

        $success = "Settings successfully updated!";
    } else {
        $error = "Error updating settings";
    }
}

$auth->applyUserSettings();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings</title>
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1>Appearance Settings</h1>
        
        <?php if (isset($success)): ?>
            <div style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label>Background Color:</label>
                <input type="color" name="bg_color" value="<?php echo $_COOKIE['bg_color'] ?? '#ffffff'; ?>" style="width: 100px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Text Color:</label>
                <input type="color" name="text_color" value="<?php echo $_COOKIE['text_color'] ?? '#000000'; ?>" style="width: 100px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Font Size:</label>
                <select name="font_size">
                    <option value="14px" <?php echo ($_COOKIE['font_size'] ?? '16px') == '14px' ? 'selected' : ''; ?>>Small</option>
                    <option value="16px" <?php echo ($_COOKIE['font_size'] ?? '16px') == '16px' ? 'selected' : ''; ?>>Medium</option>
                    <option value="18px" <?php echo ($_COOKIE['font_size'] ?? '16px') == '18px' ? 'selected' : ''; ?>>Large</option>
                    <option value="20px" <?php echo ($_COOKIE['font_size'] ?? '16px') == '20px' ? 'selected' : ''; ?>>Extra Large</option>
                </select>
            </div>
            
            <button type="submit">Save Settings</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="dashboard.php">Back to Dashboard</a> |
            <a href="index.php">Home</a>
        </div>
    </div>
</body>
</html>