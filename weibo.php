<?php
if (!defined('STDIN'))
{
  define('STDIN', fopen('php://stdin', 'r'));
}

/* echo "Hello, what is your name: \n";

while($strName = fread(STDIN, 80))
{
  if (trim($strName) == 'exit' || trim($strName) == 'quit')
  {
    break;
  }
  
  echo '>> ', $strName, "\n";
} */

session_start();
//if( isset($_SESSION['last_key']) ) header("Location: weibolist.php");
include_once( 'config.php' );
include_once( 'weibooauth.php' );



$o = new WeiboOAuth( WB_AKEY , WB_SKEY  );

$keys = $o->getRequestToken();
$_SESSION['keys'] = $keys;

$aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false , 'oob');
echo $aurl, "\n";

$o = new WeiboOAuth( WB_AKEY , WB_SKEY , $_SESSION['keys']['oauth_token'] , 
                                      $_SESSION['keys']['oauth_token_secret']  );

echo 'Input the PIN: ';

$pin = fread(STDIN, 10);
                                    
echo trim($pin), "\n";                                      
$last_key = $o->getAccessToken(trim($pin)) ;

$_SESSION['last_key'] = $last_key;

$c = new WeiboClient( WB_AKEY , 
                      WB_SKEY , 
                      $_SESSION['last_key']['oauth_token'] , 
                      $_SESSION['last_key']['oauth_token_secret']  );
                      
$ms  = $c->home_timeline(); // done
$me = $c->verify_credentials();

echo print_r($ms);
