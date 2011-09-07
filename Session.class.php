<?php
class Session
{
  private $namespace = 'default';
  
  public function __construct()
  {
    session_start();        
  }
  
  public function set($key, $value, $namespace = 'default')
  {
    $_SESSION[$namespace][$key] = $value;
    
    return $this;
  }
  
  public function get($key, $namespace = 'default')
  {
    if (!array_key_exists($_SESSION[$namespace][$key]))
    {
      return null;
    }
    
    return $_SESSION[$namespace][$key];
  }    
}