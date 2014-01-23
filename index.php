<?php

/**
 * 项目入口文件
 * Some rights reserved：www.simplewind.net
 */
//开启调试模式
define("APP_DEBUG", false);
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
define("SIMPLEWIND_CMF_VERSION", 'V1.0.4 20140121');

//大小写忽略处理
/* foreach (array("g", "m") as $v) {
    if (isset($_GET[$v])) {
        $_GET[$v] = ucwords($_GET[$v]);
    }
} */

//载入框架核心文件
define('THINK_PATH',SPAPP_PATH.'Core/');
define('ENGINE_NAME','cluster');
require THINK_PATH.'ThinkPHP.php';

?>