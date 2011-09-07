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
    $this->eventDispatcher = new sfEventDispatcher();
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
      $this->authStatus = $this->db->getOneUserByUsername($this->username);
    }
    
    return !is_null($this->authStatus);
  }
  
  // First public interface
  public function auth()
  {
    if ($this->getAuthStatus() == false)
    {
      // Trigger the password event
      $event = new sfEvent($this, 'user.password_input', array());
      $this->eventDispatcher->connect('user.password_input', array(new Listner, 'listenToUserPasswordInput'));
      
      $e = $this->eventDispatcher->notify($event);
      $this->password = $e->getReturnValue();
      
      // Auth the user
      $accessToken = new Auth($this->username, $this->password, $this->config);
      
      // Create a user 
      $user = new User();
      
      $user->setUsername($this->username);
      $user->setPassword($this->password);
      $user->setAccessToken($accessToken['access_token']);
      $user->setAccessTokenSecret($accessToken['access_token_secret']);
      
      $this->addUser($user);
    }
    else
    {
      echo 'Already authed!';
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