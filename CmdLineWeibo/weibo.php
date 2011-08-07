<?php
include_once 'config.php';
include_once 'weibooauth.php';
include_once 'session.php';

$config = Config::getInstance();
$config->setParameter('key', '');
$config->setParameter('seret', '');

if (!defined('STDIN'))
{
  define('STDIN', fopen('php://stdin', 'r'));
}

echo 'Your username please: ';

$username = trim(@fread(STDIN, 80));

// Create a user object
$user = new User($username);

// Get auth status
$authStatus = $user->getAuthStatus();

if (!$authStatus)
{
  echo 'Your password please: ';
  
  $password = trim(@fread(STDIN, 80));
  $user->setPassword($password);
  
  $auth = new Auth($user, $config);
  $auth
  
  
}
