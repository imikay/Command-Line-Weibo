<?php
class Weibo
{
  private $availableCommands = array(
    'Send' => 'Send a tweet',
    'Read' => 'Read your stream'    
  );
  
  private $stdin;
  private $username;
  private $password;
  private $userCommand;
  private $db;
  private $config;
  private $auth = null;
  private $user;
  
  public function __construct()
  {             
    $this->stdin = defined('STDIN') ? STDIN : fopen('php://stdin', 'r')
    
    $this->db     = new DB('users');
    $this->config = new Config(array('key'    => '',
                                     'secret' => ''));          
    
        
  }
  
  public function run()
  {
    while (true)
    {
       echo "Command Line Weibo v0.1\n";
       
       echo ">> You username please: \n";
       
       $this->username = trim(@fread($this->stdin, 80));
       
       // Check username in the db
       $this->user = $this->db->getOneUserByUsername($this->username);
       
       if (!$this->user)
       {
          echo "Your password please: \n";
          
          $this->password = trim(@fread($this->stdin, 80));
          
          // Auth the user
          $auth = new Auth($this->username, $this->password, $this->config);
          $accessTokenPair = $auth->getAccessToken();
          
          // Assume that we successfully authenticated the user
          // Create a user 
          $user = new User();
      
          $user->setUsername($this->username);
          $user->setPassword($this->password);
          $user->setAccessToken($accessTokenPair['access_token']);
          $user->setAccessTokenSecret($accessTokenPair['access_token_secret']);
          
          // Add user into db
          $this->db->addUser($user);
          
          // Persist user into db
          $this->db->save();
          
          $this->user = $user;
       }
       
       // if exists
       echo ">> Choose an action: \n";
       echo join(", \n", array_keys($this->availableCommands));
       
       $this->userCommand = trim(@fread($this->stdin, 80));
       
       if (!array_key_exists($this->userCommand, $this->availableCommands))
       {
         throw new BadCommandException('Command not eixsts!');
       }
       
       if (!method_exists($this, 'execute'.$this->userCommand))
       {
          throw new CommandNotImplement('This command has not been implemented!');
       }
       
       $this->
    }
  }
  
  public function executeSend()
  {
    
  }
  
  public function executeRead($number = 10)
  {
    
  }  
}