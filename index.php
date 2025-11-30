<?php
require 'vendor/autoload.php';
require 'config.php';

use App\Auth;

$auth = new Auth();

// Автоматическая авторизация через cookies
if (!$auth->isLoggedIn()) {
    $auth->autoLogin();
}

// Применение настроек пользователя
$auth->applyUserSettings();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система авторизации</title>
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
                <h2>Добро пожаловать, <?php echo $_SESSION['username']; ?>!</h2>
                <a href="dashboard.php">Дашборд</a> |
                <a href="settings.php">Настройки</a> |
                <a href="logout.php">Выйти</a>
            </div>
            <p>Вы успешно авторизованы в системе.</p>
        <?php else: ?>
            <h1>Система авторизации</h1>
            <div style="display: flex; gap: 20px;">
                <div style="flex: 1;">
                    <h3>Регистрация</h3>
                    <form action="register.php" method="POST">
                        <div class="form-group">
                            <label>Имя пользователя:</label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Email:</label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>Пароль:</label>
                            <input type="password" name="password" required>
                        </div>
                        <h4>Настройки оформления:</h4>
                        <div class="form-group">
                            <label>Цвет фона:</label>
                            <input type="color" name="bg_color" value="#ffffff">
                        </div>
                        <div class="form-group">
                            <label>Цвет текста:</label>
                            <input type="color" name="text_color" value="#000000">
                        </div>
                        <div class="form-group">
                            <label>Размер шрифта:</label>
                            <select name="font_size">
                                <option value="14px">Маленький</option>
                                <option value="16px" selected>Средний</option>
                                <option value="18px">Большой</option>
                                <option value="20px">Очень большой</option>
                            </select>
                        </div>
                        <button type="submit">Зарегистрироваться</button>
                    </form>
                </div>
                
                <div style="flex: 1;">
                    <h3>Авторизация</h3>
                    <form action="login.php" method="POST">
                        <div class="form-group">
                            <label>Имя пользователя:</label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="form-group">
                            <label>Пароль:</label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="form-group">
                            <label>
                                <input type="checkbox" name="remember"> Запомнить меня
                            </label>
                        </div>
                        <button type="submit">Войти</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>