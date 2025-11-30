<?php
require 'vendor/autoload.php';
require 'config.php';

use App\Auth;

$auth = new Auth();
$auth->logout();

header('Location: index.php');
exit;