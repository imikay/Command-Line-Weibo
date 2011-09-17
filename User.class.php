<?php
class User
{
  private $username;
  private $password;
  private $accessToken;
  private $accessTokenSecret;
  
  public function __construct($username = '', 
                              $password = '', 
                              $accessToken = '',
                              $accessTokenSecret = '')
  {
    $this->username = trim($username);
    $this->password = trim($password);
    $this->accessToken = trim($accessToken);
    $this->accessTokenSecret = trim($accessTokenSecret);
  }    
   
  public function getUsername()
  {
    return $this->username;
  }
  
  public function getPassword()
  {
    return $this->password;
  }
  
  public function setUsername($username)
  {
    $this->username = trim($username);
    
    return $this;
  }
  
  public function setPassword($password)
  {
    $this->password = trim($password);
    
    return $this;
  }
  
  public function getAccessToken()
  {
    return $this->accessToken;
  }
  
  public function getAccessTokenSecret()
  {
    return $this->accessTokenSecret;
  }
  
  public function setAccessToken($accessToken)
  {
    $this->accessToken = trim($accessToken);
  }
  
  public function setAccessTokenSecret($accessTokenSecret)
  {
    $this->accessTokenSecret = trim($accessTokenSecret);
  }
}