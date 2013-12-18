<?php

/**
 * 项目入口文件
 * Some rights reserved：www.simplewind.net
 */
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
//项目资源目录，不可更改
define('SPSTATIC',   'statics/');
//定义缓存存放路径
define("RUNTIME_PATH", SITE_PATH . "/data/runtime/");
//版本号
define("SIMPLEWIND_CMF_VERSION", '20131111');

//大小写忽略处理
/* foreach (array("g", "m") as $v) {
    if (isset($_GET[$v])) {
        $_GET[$v] = ucwords($_GET[$v]);
    }
} */
if (!file_exists('install/install.lock')) {
    header("Location: install/");
    exit;
}

//载入框架核心文件
require SPAPP_PATH.'/Core/ThinkPHP.php';
?>