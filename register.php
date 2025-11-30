<?php
require 'vendor/autoload.php';
require 'config.php';

use App\Auth;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $auth = new Auth();

    try {
        $settings = [
            'bg_color' => $_POST['bg_color'] ?? '#ffffff',
            'text_color' => $_POST['text_color'] ?? '#000000',
            'font_size' => $_POST['font_size'] ?? '16px'
        ];

        $auth->register(
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
            $settings
        );

        // Автоматический вход после регистрации
        $user = $auth->login($_POST['username'], $_POST['password']);
        if ($user) {
            header('Location: dashboard.php');
            exit;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

header('Location: index.php?' . ($error ? 'error=' . urlencode($error) : ''));
exit;