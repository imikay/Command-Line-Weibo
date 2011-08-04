<?php
include_once 'config.php';
include_once 'weibooauth.php';
include_once 'session.php';

if (!defined('STDIN'))
{
  define('STDIN', fopen('php://stdin', 'r'));
}

echo 'Your username please: ';

$username = @fread(STDIN, 80);

// Create a user object
$user = new User($username);

// Get auth status
$authStatus = $user->getAuthStatus();

if (!$authStatus)
{
  
}
