<?php
namespace App;

class Auth
{
    private $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function register($username, $email, $password, $settings = [])
    {
        if ($this->user->findByUsername($username)) {
            throw new \Exception("Username already exists");
        }

        if ($this->user->findByEmail($email)) {
            throw new \Exception("Email already exists");
        }

        $bgColor = $settings['bg_color'] ?? '#ffffff';
        $textColor = $settings['text_color'] ?? '#000000';
        $fontSize = $settings['font_size'] ?? '16px';

        return $this->user->create($username, $email, $password, $bgColor, $textColor, $fontSize);
    }

    public function login($username, $password, $remember = false)
    {
        $user = $this->user->findByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            $this->setUserCookies($user, $remember);

            return $user;
        }

        return false;
    }

    public function setUserCookies($user, $remember = false)
    {
        $expire = $remember ? time() + COOKIE_LIFETIME : 0;

        setcookie('bg_color', $user['bg_color'], $expire, '/');
        setcookie('text_color', $user['text_color'], $expire, '/');
        setcookie('font_size', $user['font_size'], $expire, '/');

        if ($remember) {
            setcookie('user_id', $user['id'], $expire, '/');
            setcookie('user_token', hash('sha256', $user['password']), $expire, '/');
        }
    }

    public function autoLogin()
    {
        if (isset($_COOKIE['user_id']) && isset($_COOKIE['user_token'])) {
            $userId = $_COOKIE['user_id'];
            $userToken = $_COOKIE['user_token'];

            if (!isset($_SESSION['user_id'])) {
                $_SESSION['user_id'] = $userId;
                $this->applyUserSettings();
                return true;
            }
        }
        return false;
    }

    public function applyUserSettings()
    {
        if (isset($_COOKIE['bg_color'])) {
            echo "<style>body { background-color: {$_COOKIE['bg_color']}; }</style>";
        }
        if (isset($_COOKIE['text_color'])) {
            echo "<style>body { color: {$_COOKIE['text_color']}; }</style>";
        }
        if (isset($_COOKIE['font_size'])) {
            echo "<style>body { font-size: {$_COOKIE['font_size']}; }</style>";
        }
    }

    public function isLoggedIn()
    {
        return isset($_SESSION['user_id']);
    }

    public function logout()
    {
        session_destroy();

        setcookie('user_id', '', time() - 3600, '/');
        setcookie('user_token', '', time() - 3600, '/');
        setcookie('bg_color', '', time() - 3600, '/');
        setcookie('text_color', '', time() - 3600, '/');
        setcookie('font_size', '', time() - 3600, '/');
    }
}