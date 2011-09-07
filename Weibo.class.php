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
    $this->stdin = defined('STDIN') ? STDIN : fopen('php://stdin', 'r');
    
    $this->db     = new DB('users');
    var_dump($this->db);
    $this->config = Config::getInstance(array('key'    => '656326257',
                                              'secret' => 'ca82c8c5a3f0f7b7bd7f3661a3da541a'));                                                       
    $this->executeAuthCommand();                                              
  }
  
  public function run()
  {       
    while (true)
    {       
       // if exists
       echo ">> Choose an action: \n";
       echo join(", \n", array_keys($this->availableCommands));
       
       $this->userCommandInfo = trim(@fread($this->stdin, 80));
       $this->userCommandInfo = array_map('trim', explode(' ', $this->userCommandInfo));
       
       $this->userCommand = array_shift($this->userCommandInfo);
       
       if (!array_key_exists($this->userCommand, $this->availableCommands))
       {
         echo ">> Command does not exists.\n";
         //throw new BadCommandException('Command not eixsts!');
       }
       else if (!method_exists($this, 'execute'.$this->userCommand.'Command'))
       {
          echo ">> This command has not been implemented!\n";
          
          //throw new CommandNotImplementException('This command has not been implemented!');
       }
       else
       {
        call_user_func_array(array($this, 'execute'.$this->userCommand.'Command'), $this->userCommandInfo);
       }
    }
  }
  
  public function executeSendCommand()
  {
    echo "Send a tweet\n";
  }
  
  public function executeReadCommand($number = 10)
  {
    $c = new WeiboClient($this->config->getParameter('key'), 
                          $this->config->getParameter('secret'),                          
                          $this->user->getAccessToken(), 
                          $this->user->getAccessTokenSecret() 
                         );
                          
    $ms = $c->home_timeline(); // done    

    //echo print_r($ms);          
    $tweets = $ms;
    
    $t = array_splice($tweets, 0, $number);
    
    foreach($t as $index => $content)
    {
      printf("[%s]: %s: %s\n\n", $index + 1, $content['user']['name'], $content['text']);      
      
      if (isset($content['retweeted_status']))
      {
        printf("转发微博：%s: %s\n\n", $content['retweeted_status']['user']['name'], $content['retweeted_status']['text']);
      }
    }
  }

  public function executeAuthCommand()
  {
     echo "Command Line Weibo v0.1\n\n";
     
     echo ">> You username please: ";
     
     $this->username = trim(@fread($this->stdin, 80));
     
     // Check username in the db
     $this->user = $this->db->getOneUserByUsername($this->username);
     
     if (!$this->user)
     {
        echo "\nYour password please: ";
        
        $this->password = trim(@fread($this->stdin, 80));
        
        // Auth the user
        $auth = new Auth($this->username, $this->password, $this->config);          
        $accessTokenPair = $auth->getAccessToken();
        
        // Assume that we successfully authenticated the user
        // Create a user 
        $user = new User();
    
        $user->setUsername($this->username);
        $user->setPassword($this->password);
        $user->setAccessToken($accessTokenPair['oauth_token']);
        $user->setAccessTokenSecret($accessTokenPair['oauth_token_secret']);
        
        // Add user into db
        $this->db->addUser($user);
        
        // Persist user into db
        $this->db->save();
        
        $this->user = $user;
     }  
  }  
}
