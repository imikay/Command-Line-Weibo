<?php
class DB
{  
  private $path;
  private $data;
  
  public function __construct($path)
  {
    $this->path = $path;
    $this->data = unserialize(@file_get_contents($this->path));    
  }
  
  public function getOneUserByUsername($username)
  {
    $cleanedUsername = trim($username);
    
    if (!$this->data || !array_key_exists($cleanedUsername, $this->data))
    {
      return null;
    }
    
    $userData = $this->data[$cleanedUsername];    
    
    return new User($cleanedUsername, 
                    $userData['password'], 
                    $userData['access_token'], 
                    $userData['access_token_secret']);
  }
  
  public function addUser(User $user)
  {
    $this->data[$user->getUsername()] = array(
      'password' => $user->getPassword(),
      'access_token' => $user->getAccessToken(),
      'access_token_secret' => $user->getAccessTokenSecret()
    );
    
    return $this;
  }
    
  public function save()
  {
    $retValue = file_put_contents($this->path, serialize($this->data));
    
    if ($retValue === false)
    {
      throw new DBException('Save failed');
    }
    
    return $retValue;
  }
}