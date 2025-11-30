<?php
require 'vendor/autoload.php';
require 'config.php';

use App\Auth;

$auth = new Auth();

// Проверка авторизации
if (!$auth->isLoggedIn()) {
    header('Location: index.php');
    exit;
}

// Применение настроек
$auth->applyUserSettings();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Дашборд</title>
</head>
<body>
    <div style="max-width: 800px; margin: 0 auto; padding: 20px;">
        <h1>Дашборд пользователя</h1>
        <p>Добро пожаловать, <?php echo $_SESSION['username']; ?>!</p>
        <p>Это защищенная страница, доступная только авторизованным пользователям.</p>
        
        <div style="margin-top: 20px;">
            <h3>Ваши текущие настройки:</h3>
            <ul>
                <li>Цвет фона: <?php echo $_COOKIE['bg_color'] ?? 'Не установлен'; ?></li>
                <li>Цвет текста: <?php echo $_COOKIE['text_color'] ?? 'Не установлен'; ?></li>
                <li>Размер шрифта: <?php echo $_COOKIE['font_size'] ?? 'Не установлен'; ?></li>
            </ul>
        </div>

        <div style="margin-top: 20px;">
            <a href="settings.php">Изменить настройки</a> |
            <a href="index.php">Главная</a> |
            <a href="logout.php">Выйти</a>
        </div>
    </div>
</body>
</html>