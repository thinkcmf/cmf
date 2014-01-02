<?php
//定义回调URL通用的URL
defined('OAUTH_URL_CALLBACK') or define('OAUTH_URL_CALLBACK', 'http://'.$_SERVER['HTTP_HOST'].'/index.php?g=api&m=oauth&a=callback&type=');

return array(
	//腾讯QQ登录配置
	'THINK_SDK_QQ' => array(
		'APP_KEY'    => '100574684',
		'APP_SECRET' => '9612c3963591e2c3f30b1fe1165ebe4c',
		'CALLBACK'   => OAUTH_URL_CALLBACK . 'qq',
	),
	//腾讯微博配置
	'THINK_SDK_TENCENT' => array(
		'APP_KEY'    => '', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '', //应用注册成功后分配的KEY
		'CALLBACK'   => OAUTH_URL_CALLBACK . 'tencent',
	),
	//新浪微博配置
	'THINK_SDK_SINA' => array(
		'APP_KEY'    => '2263638685', //应用注册成功后分配的 APP ID
		'APP_SECRET' => '744accef57ba34be3a80edf13963d290', //应用注册成功后分配的KEY
		'CALLBACK'   => OAUTH_URL_CALLBACK . 'sina',
	),
);