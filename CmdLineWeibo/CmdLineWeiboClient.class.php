<?php
class CmdLineWeiboClient
{
  private $config = null;
  private $session = null;
  private $db   = null;
  private $user = null;  
  private $auth = null;
  private $authStatus = null;
  private $username = '';
  
  public function __construct()
  {    
    $this->session = new Session();
    $this->db = new DB('users');        
    $this->config = Config::getInstance();        
  }
  
  public function init()
  {
    $this->config->setParameter('key', '');
    $this->config->setParameter('secret', '');
  }
  
  public function getUser()
  {
    return $this->user;
  }
  
  public function setUsername($username)
  {
    $this->user->setUsername($username);
    
    return $this;
  }
  
  public function setUserPassword($password)
  {
    $this->user->setPassword($password);
    
    return $this;
  }

  public function getAuthStatus()
  {       
    if (is_null($this->authStatus))
    {
      $this->authStatus = $this->db->count($this->user->getUsername());
    }
    
    return $this->authStatus;
  }
  
  public function auth()
  {
    if ($this->getAuthStatus() == false)
    {
      // Auth the user
      
      
    }
  }
  
  public function tweet($message)
  {
    
  }
  
  public function getOneUpdate()
  {
  }
  
      
}