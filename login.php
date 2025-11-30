<?php
require 'vendor/autoload.php';
require 'config.php';

use App\Auth;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth();

    $user = $auth->login(
        $_POST['username'],
        $_POST['password'],
        isset($_POST['remember'])
    );

    if ($user) {
        header('Location: dashboard.php');
        exit;
    } else {
        $error = "Неверное имя пользователя или пароль";
    }
}

header('Location: index.php?' . ($error ? 'error=' . urlencode($error) : ''));
exit;