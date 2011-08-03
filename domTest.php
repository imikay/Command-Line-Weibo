<?php

$html = <<<'dsf'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width" />
<title>应用授权 - 新浪微博</title>
<link type="text/css" href="http://timg.sjs.sinajs.cn/t35/appstyle/opent/css/oauth/oauth.css" rel="stylesheet" />
<script type="text/javascript" src="http://tjs.sjs.sinajs.cn/t3/weibojs/static/suda_s_v851c.js"></script>
<script type="text/javascript">
sinaSSOConfig = new function() {
        this.entry = 'weibo'; 
        this.setDomain = true; 
        this.customLogoutCallBack = function (result) {
        	location.reload();
        };
};

</script>
<script type="text/javascript" src="http://i.sso.sina.com.cn/js/ssologin.js"></script>
<!-- SUDA_CODE_START -->
<script type="text/javascript" > 
	_S_pSt();
</script>

<!-- SUDA_CODE_END -->
<script type="text/javascript">
function canchange()
{
	 sinaSSOController.logout();
}
function submitForm()
{
	if(document.getElementById("regagreementCheckbox").checked){
		document.forms['authZForm'].submit();
	}else{
	}
}
function closeWindow()
{
	var browserName = navigator.appName;
	if (browserName == "Netscape") {
		window.open('','_parent','');  
		window.close();   
	}
	else if (browserName == "Microsoft Internet Explorer") {
		window.opener = self;
		window.open('','_parent','');  
		window.close();
	}
}
</script>
</head>
<body>
<div class="oauth_top">
      <div class="au_cWrap clearFix">
		<div class="logo"><img src="http://timg.sjs.sinajs.cn/t35/appstyle/opent/images/oauth/logo_s.png" alt="" /></div>
		<div class="rt_link">没有微博帐号？&nbsp;<a href="http://service.weibo.com/reg/regindex.php?appsrc=13qxKp&backurl=http%3A%2F%2Fapi.t.sina.com.cn%2Foauth%2Fauthorize%3Foauth_token%3D38ab85c7a47510d9bc69f75486374627%26oauth_callback%3Doob%26from%3D%26with_cookie%3D&diy=" target="_blank" onclick="GB_SUDA._S_uaTrack('tblog_api','13qxKp_reg')">注册</a></div>
		</div>
</div>

<div class="txt_oauth">
		<div class="au_cWrap">
		
			授权 <a href="http://www.source-hub.com" class="fb"  target="_blank">命令行微博</a> &nbsp;访问你的微博帐号，随时享受精彩
		</div>
</div>
<div class="oauth_cont">
	<div class="au_cWrap clearFix">
		<div class="lf">
			<div class="clearFix">

				<div class="msg_txtls"> 将允许应用进行以下操作：
					<ul class="gs_uls">
						<li>获得你的个人信息，好友关系</li><li>分享内容到你的微博</li><li>获得你的评论</li></ul>
				</div>
				<div class="mt_arr"> <img src="http://timg.sjs.sinajs.cn/t35/appstyle/opent/images/oauth/img_arr1.png" alt="" /> </div>
			</div>

			<div class="lt_msg">你可以随时在 <a href="http://weibo.com/setting/connections"  target="_blank ">我的设置</a> 里取消授权。</div>
		</div>
		<div class="rt">
			<div class="clearFix">
				<div class="lf_img"><img src="http://timg.sjs.sinajs.cn/miniblog2style/images/developer/default_50.gif" width="80px" /> </div>
				<div class="des_txt">

					<h3>命令行微博</h3>
					<p>
						
							开发者：imikay<br/>
							共 <span class="gray6">2</span> 人使用该应用
						</p>
				</div>
			</div>

			<form name="authZForm" action="authorize" method="post">
				<input type="hidden" name="action" value="submit"/>
				<input type="hidden" name="regCallback" value="http%3A%2F%2Fapi.t.sina.com.cn%2Foauth%2Fauthorize%3Foauth_token%3D38ab85c7a47510d9bc69f75486374627%26oauth_callback%3Doob%26from%3D%26with_cookie%3D"/>	
				<input type="hidden" name="oauth_token" value="38ab85c7a47510d9bc69f75486374627"/>
				<input type="hidden" name="oauth_callback" value="oob"/>
				<input type="hidden" name="from" value=""/>
				<input type="hidden" name="forcelogin" value=""/>
				<div class="form_wrap clearFix" id ="inputDiv">
						<div class="row_fm">

							<div class="lable_fm">帐号：</div>
							<div class="inp_fm">
								<input class="iptbg" id="userId" name="userId"  tabindex="1" type="text" title="邮箱/会员帐号/手机号" />
							</div>
						</div>
						<div class="row_fm">
							<div class="lable_fm">密码：</div>
							<div class="inp_fm">

								<input class="iptbg" id="passwd" name="passwd" tabindex="2" type="password" title="请输入密码" />
							</div>
						</div>
						</div>
				</form>
		</div>
	</div>
</div>
<div class="oauth_btn clearFix">
	<div class="au_cWrap">

		<div class="lf_half gray6">
			<input id="regagreementCheckbox" name="regagreementCheckbox" type="checkbox"  class="ipt_cb" checked="checked"  disabled="disabled"/>
			我已阅读<a href="http://login.sina.com.cn/regagreement.html" onclick="GB_SUDA._S_uaTrack('tblog_api','13qxKp_agreement');" target="_blank">新浪网络服务使用协议</a></div>
			<div class="lf_half_r">
				<a id="sub"  onclick="GB_SUDA._S_uaTrack('tblog_api','13qxKp_authorization');submitForm();" class="btn_greenS" ><em>登录并授权</em></a>
				<a class="btn_grayS" onclick="GB_SUDA._S_uaTrack('tblog_api','13qxKp_cancel');closeWindow();"><em>取消</em></a>
			</div>

	</div>
</div>
<script type="text/javascript" src="http://tjs.sjs.sinajs.cn/open/site/js/oauth/input.js"></script>
</body>
</html>

dsf;

$doc = new DOMDocument();
@$doc->loadHTML($html);
//echo $doc->saveHTML();
$domNodeList = $doc->getElementsByTagName('form');
echo $domNodeList->length;
$node = $domNodeList->item(0);
$nodeMap = $node->attributes;
echo $nodeMap->getNamedItem('name')->nodeValue;

$opts = array(
  'http' => array(
    'method' => 'POST',
    'header' => 'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:5.0) Gecko/20100101 Firefox/5.0\r\n',
    'content' => http_build_query(array(
      'action' => 'submit',
      'forcelogin' => '',
      'from' => '',
      'oauth_callback' => 'oob',
      'oauth_token' => '38ab85c7a47510d9bc69f75486374627',
      'userId' => '',
      'passwd' => '',
      
      'regCallback' => 'http://api.t.sina.com.cn/oauth/authorize?
                        oauth_token=38ab85c7a47510d9bc69f75486374627
                        &oauth_callback=oob
                        &from=
                        &with_cookie='         
    )),
    
    'timeout' => 5
  )
);

//$context = stream_context_create($opts);

//$ret = file_get_contents('http://api.t.sina.com.cn/oauth/authorize', false, $context);


$pinHtml = <<<'PIN'
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>应用授权 - 新浪微博</title>
<link type="text/css" href="http://timg.sjs.sinajs.cn/t35/appstyle/opent/css/oauth/oauth.css" rel="stylesheet" />
<script type="text/javascript">
function canchange()
{
        document.forms['authZForm'].from.value='turnuser';
        document.forms['authZForm'].action.value='';
	document.forms['authZForm'].submit();
}
</script>
</head>

<body>
<div class="oauth_top">
	<div class="au_cWrap clearFix">
		<div class="logo"><img src="http://timg.sjs.sinajs.cn/t35/appstyle/opent/images/oauth/logo_s.png" alt="" /></div>

	</div>
</div>
<div class="oauth_cont">
	<div class="au_cWrap clearFix">
		<div class="des_content1">
			<div class="getCodeWrap"> 获取到的授权码：<span class="fb">857498</span> </div>
		</div>
	</div>

</div>
<div class="oauth_btn">
	<div class="au_cWrap gray6"> Copyright&copy; 1996 - 2011 SINA Corporation, All Rights Reserved <a href="">新浪公司</a> 版权所有 </div>
</div>
</body>
</html>  
PIN;

$doc = new DOMDocument();
@$doc->loadHTML($pinHtml);
//echo $doc->saveHTML();
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


