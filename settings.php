<?php
require 'vendor/autoload.php';
require 'config.php';

use App\Auth;
use App\User;

$auth = new Auth();

// Проверка авторизации
if (!$auth->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$userModel = new User();
$user = $userModel->findByUsername($_SESSION['username']);

// Обновление настроек
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bgColor = $_POST['bg_color'] ?? '#ffffff';
    $textColor = $_POST['text_color'] ?? '#000000';
    $fontSize = $_POST['font_size'] ?? '16px';

    if ($userModel->updateSettings($user['id'], $bgColor, $textColor, $fontSize)) {
        // Обновляем cookies
        $auth->setUserCookies([
            'id' => $user['id'],
            'bg_color' => $bgColor,
            'text_color' => $textColor,
            'font_size' => $fontSize,
            'password' => $user['password'] // Для токена
        ], isset($_COOKIE['user_token']));

        $success = "Настройки успешно обновлены!";
    } else {
        $error = "Ошибка при обновлении настроек";
    }
}

$auth->applyUserSettings();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Настройки</title>
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1>Настройки оформления</h1>
        
        <?php if (isset($success)): ?>
            <div style="color: green; margin-bottom: 15px;"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div style="color: red; margin-bottom: 15px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST">
            <div style="margin-bottom: 15px;">
                <label>Цвет фона:</label>
                <input type="color" name="bg_color" value="<?php echo $_COOKIE['bg_color'] ?? '#ffffff'; ?>" style="width: 100px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Цвет текста:</label>
                <input type="color" name="text_color" value="<?php echo $_COOKIE['text_color'] ?? '#000000'; ?>" style="width: 100px;">
            </div>
            
            <div style="margin-bottom: 15px;">
                <label>Размер шрифта:</label>
                <select name="font_size">
                    <option value="14px" <?php echo ($_COOKIE['font_size'] ?? '16px') == '14px' ? 'selected' : ''; ?>>Маленький</option>
                    <option value="16px" <?php echo ($_COOKIE['font_size'] ?? '16px') == '16px' ? 'selected' : ''; ?>>Средний</option>
                    <option value="18px" <?php echo ($_COOKIE['font_size'] ?? '16px') == '18px' ? 'selected' : ''; ?>>Большой</option>
                    <option value="20px" <?php echo ($_COOKIE['font_size'] ?? '16px') == '20px' ? 'selected' : ''; ?>>Очень большой</option>
                </select>
            </div>
            
            <button type="submit">Сохранить настройки</button>
        </form>

        <div style="margin-top: 20px;">
            <a href="dashboard.php">Назад в дашборд</a> |
            <a href="index.php">Главная</a>
        </div>
    </div>
</body>
</html>