<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'lab3');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Session and cookies settings
define('SESSION_LIFETIME', 86400); // 24 hours
define('COOKIE_LIFETIME', 2592000); // 30 days

// Session initialization
session_set_cookie_params(SESSION_LIFETIME);
session_start();