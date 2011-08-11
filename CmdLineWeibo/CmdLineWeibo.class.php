<?php
class CmdLineWeibo
{
  private $config = null;
  private $session = null;
  private $db   = null;
  private $user = null;  
  private $auth = null;
  private $authStatus = null;
  private $username = '';
  
  // We start it with a username
  public function __construct($username = '')
  {    
    $this->session = new Session();
    $this->db = new DB('users');        
    $this->config = Config::getInstance();        
    $this->username = $username;
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
  
  // First public interface
  public function auth()
  {
    if ($this->getAuthStatus() == false)
    {
      // Auth the user
      
      
    }
    else
    {
      
    }
  }
  
  public function tweet($message)
  {
    
  }
  
  public function getOneUpdate()
  {
  }
  
  public function saveUser()
  {
    $this->db->addUser($this->user)->save();
  }
  
      
}