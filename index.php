<?php

/**
 * 项目入口文件
 * Some rights reserved：www.simplewind.net
 */
if (ini_get('magic_quotes_gpc')) {
	function stripslashesRecursive(array $array){
		foreach ($array as $k => $v) {
			if (is_string($v)){
				$array[$k] = stripslashes($v);
			} else if (is_array($v)){
				$array[$k] = stripslashesRecursive($v);
			}
		}
		return $array;
	}
	$_GET = stripslashesRecursive($_GET);
	$_POST = stripslashesRecursive($_POST);
}

//开启调试模式
define("APP_DEBUG", true);
//网站当前路径
define('SITE_PATH', getcwd());
//项目名称，不可更改
define('APP_NAME', 'simplewind');
//项目路径，不可更改
define('APP_PATH', SITE_PATH . '/simplewind/');
//项目相对路径，不可更改
define('SPAPP_PATH',   'simplewind/');
//
define('SPAPP',   'application/');
//项目资源目录，不可更改
define('SPSTATIC',   'statics/');
//定义缓存存放路径
define("RUNTIME_PATH", SITE_PATH . "/data/runtime/");
//版本号
define("SIMPLEWIND_CMF_VERSION", 'V1.1.2');
//uc client root
define("UC_CLIENT_ROOT", './uc_client/');

if(function_exists('saeAutoLoader') || isset($_SERVER['HTTP_BAE_ENV_APPID'])){
	
}else{
	if(file_exists("install") && !file_exists("install/install.lock")){
		header("Location:./install");
		exit();
	}
}

if(file_exists("./conf/uc_config.php")){
	include './conf/uc_config.php';
}

if(APP_DEBUG){
	error_reporting(E_ALL);
}

//载入框架核心文件
define('THINK_PATH',SPAPP_PATH.'Core/');
define('ENGINE_NAME','cluster');
require THINK_PATH.'ThinkPHP.php';

?>