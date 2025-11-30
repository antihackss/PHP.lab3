<?php
// Конфигурация базы данных
define('DB_HOST', 'localhost');
define('DB_NAME', 'lab3');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Настройки сессии и cookies
define('SESSION_LIFETIME', 86400); // 24 часа
define('COOKIE_LIFETIME', 2592000); // 30 дней

// Инициализация сессии
session_set_cookie_params(SESSION_LIFETIME);
session_start();