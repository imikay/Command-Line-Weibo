<?php
class Auth
{  
  private $username;
  private $password;
  private $config;
  private $requestTokenPair = array();
  private $accessTokenPair  = array();
  
  public function __construct($username, $password, Config $config)
  {
    $this->username = trim($username);
    $this->password = trim($password);
    
    $this->config = $config;
  }
  
  public function getAccessToken()
  {
    $auth = new WeiboOAuth($this->config->getParameter('key'), 
                           $this->config->getParameter('secret'));

    $this->requestTokenPair = $auth->getRequestToken();
           
    $aurl = $auth->getAuthorizeURL($this->requestTokenPair['oauth_token'], false, 'oob');
    //echo $aurl, "\n";
    $re = @file_get_contents($aurl);

    $doc = new DOMDocument();
    @$doc->loadHTML($re);
    //echo $doc->saveHTML();
    $domNodeList = $doc->getElementsByTagName('form');

    $node = $domNodeList->item(0);
    $nodeMap = $node->attributes;

    if ($nodeMap->getNamedItem('name')->nodeValue == 'authZForm')
    {     
      $opts = array(
      'http' => array(
        'method' => 'POST',
        'header' => 'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0\r\n'
                   /* .'Content-type: application/x-www-form-urlencoded\r\n' */,
        'content' => http_build_query(array(
          'action' => 'submit',
          'forcelogin' => '',
          'from' => '',
          'oauth_callback' => 'oob',
          'oauth_token' => $this->requestTokenPair['oauth_token'],
          'userId' => $this->username,
          'passwd' => $this->password,
          
          'regCallback' => 'http://api.t.sina.com.cn/oauth/authorize?
                            oauth_token='.$this->requestTokenPair['oauth_token']
                            .'&oauth_callback=oob
                            &from=
                            &with_cookie='         
        )),
        
        'timeout' => 5
      )
    );

      $context = stream_context_create($opts);

      $ret = @file_get_contents('http://api.t.sina.com.cn/oauth/authorize', false, $context);
    }
    else
    {
      $ret = @file_get_contents('http://api.t.sina.com.cn/oauth/authorize?oauth_token='.$this->requestTokenPair['oauth_token'].'&oauth_callback=oob');
    }

                                          
    $o = new WeiboOAuth( $this->config->getParameter('key'), 
                         $this->config->getParameter('secret'), 
                         $this->requestTokenPair['oauth_token'], 
                         $this->requestTokenPair['oauth_token_secret']);

    $this->accessTokenPair = $o->getAccessToken($this->getPIN($ret));       
    
    return $this->accessTokenPair;
  }
  
  private function getPIN($html)
  {
    $doc = new DOMDocument();
    @$doc->loadHTML($html);

    $domNodeList = $doc->getElementsByTagName('span');

    if (!$domNodeList->length)
    {
      return null;
    }

    $node = $domNodeList->item(0);
    $pin = trim($node->textContent);

    if (empty($pin))
    {
      return null;
    }

    return $pin;    
  }
}