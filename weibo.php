<?php
include_once( 'config.php' );
include_once( 'weibooauth.php' );

if (!defined('STDIN'))
{
  define('STDIN', fopen('php://stdin', 'r'));
}

session_start();

if (file_exists('session'))
{
  $contents = file_get_contents('session');
}

if (strlen($contents))
{
  $_SESSION = unserialize($contents);
  
  $c = new WeiboClient( WB_AKEY , 
                      WB_SKEY , 
                      $_SESSION['last_key']['oauth_token'] , 
                      $_SESSION['last_key']['oauth_token_secret']  );
                      
$ms  = $c->home_timeline(); // done
$me = $c->verify_credentials();

echo print_r($ms);

return;
}


$o = new WeiboOAuth( WB_AKEY , WB_SKEY  );

$keys = $o->getRequestToken();
$_SESSION['keys'] = $keys;

$aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , 'oob');
//echo $aurl, "\n";
$re = @file_get_contents($aurl);

$doc = new DOMDocument();
@$doc->loadHTML($re);
//echo $doc->saveHTML();
$domNodeList = $doc->getElementsByTagName('form');

echo $domNodeList->length;
$node = $domNodeList->item(0);
$nodeMap = $node->attributes;
echo $nodeMap->getNamedItem('name')->nodeValue;

if ($nodeMap->getNamedItem('name')->nodeValue == 'authZForm')
{
  echo "\n";
  echo 'Input your email: ';  
  $email = trim(fread(STDIN, 80));
  echo "\n";
  echo 'Input your password: ';
  $passwd = trim(fread(STDIN, 80));   
  
  $opts = array(
  'http' => array(
    'method' => 'POST',
    'header' => 'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0\r\n',
    'content' => http_build_query(array(
      'action' => 'submit',
      'forcelogin' => '',
      'from' => '',
      'oauth_callback' => 'oob',
      'oauth_token' => $_SESSION['keys']['oauth_token'],
      'userId' => $email,
      'passwd' => $passwd,
      
      'regCallback' => 'http://api.t.sina.com.cn/oauth/authorize?
                        oauth_token='.$_SESSION['keys']['oauth_token']
                        .'&oauth_callback=oob
                        &from=
                        &with_cookie='         
    )),
    
    'timeout' => 5
  )
);

  $context = stream_context_create($opts);

  $ret = file_get_contents('http://api.t.sina.com.cn/oauth/authorize', false, $context);
}
else
{
  $ret = file_get_contents('http://api.t.sina.com.cn/oauth/authorize?oauth_token='.$_SESSION['keys']['oauth_token'].'&oauth_callback=oob');
}

$doc = new DOMDocument();
@$doc->loadHTML($ret);

$domNodeList = $doc->getElementsByTagName('span');

if (!$domNodeList->length)
{
  return;
}

$node = $domNodeList->item(0);
$pin = trim($node->textContent);

if (empty($pin))
{
  return;
}

echo $pin;
                                   

$o = new WeiboOAuth( WB_AKEY , WB_SKEY , $_SESSION['keys']['oauth_token'] , 
                                      $_SESSION['keys']['oauth_token_secret']  );

$last_key = $o->getAccessToken($pin) ;

$_SESSION['last_key'] = $last_key;

$saveResult = file_put_contents('session', serialize($_SESSION));

$c = new WeiboClient( WB_AKEY , 
                      WB_SKEY , 
                      $_SESSION['last_key']['oauth_token'] , 
                      $_SESSION['last_key']['oauth_token_secret']  );
                      
$ms  = $c->home_timeline(); // done
$me = $c->verify_credentials();

echo print_r($ms);
