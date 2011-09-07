<?php
class Listner
{
  public function __construct()
  {
    if (!defined('STDIN'))
    {
      define('STDIN', fopen('php://stdin', 'r'));
    }    
  }
  
  public function listenToUserPasswordInput(sfEvent $event)
  {    
     echo 'Please input you password: ';
     
     $password = trim(fread(STDIN, 80));
     $event->setReturnValue($password);
     
     return true;
  }
    
}