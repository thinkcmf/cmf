<?php

/**
 * 别名定义
 */
return array(
	    //邮件
	    'PHPMailer' => LIB_PATH.'Util/class.phpmailer.php',
	    //Pclzip
	    'Pclzip' => LIB_PATH.'Util/Pclzip.class.php',
	    //UploadFile
	    "UploadFile" => LIB_PATH.'Util/UploadFile.class.php',
		"CloudUploadFile" => LIB_PATH.'Util/CloudUploadFile.class.php',
	    //文件操作类 Dir
	    "Dir" => LIB_PATH.'Util/Dir.class.php',
	    //树
	    "Tree" => LIB_PATH.'Util/Tree.class.php',
			//树
		"PathTree" => LIB_PATH.'Util/PathTree.class.php',
		"Input" => LIB_PATH.'Util/Input.class.php',
	    //Url地址
	    "Url" => LIB_PATH.'Util/Url.class.php',
		
		"Curl" => LIB_PATH.'Util/Curl.class.php',
	    
	    //评论处理类
	    "Comment" => APP_PATH.C("APP_GROUP_PATH")."/Comments/Util/Comment.class.php",
	
	    //分页类
	    "Page" => LIB_PATH.'Util/Page.class.php',
	    "phpQuery"=>LIB_PATH.'Extend/phpQuery/phpQuery.php',
		"ThinkSDK"=>LIB_PATH.'Extend/ThinkSDK/ThinkOauth.class.php',
	
		//标签库
		"TagLibSpadmin"=>LIB_PATH.'Taglib/TagLibSpadmin.class.php',
		//Hook
		"Hook"=>LIB_PATH.'Util/Hook.class.php',
		//PHPZip
		"phpzip"=>LIB_PATH.'Util/phpzip.php',
);
?>
