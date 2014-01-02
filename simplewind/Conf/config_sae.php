<?php
$runtime_config = include "data/conf/config_sae.php";
$thinksdk = include "conf/ThinkSDK_sae.config.php";
$sae = array(
    'DB_TYPE' => 'mysql',
	'DB_DEPLOY_TYPE'=> 1,
	'DB_RW_SEPARATE'=>true,
    'DB_HOST' => SAE_MYSQL_HOST_M,
    'DB_NAME' => SAE_MYSQL_DB,
    'DB_USER' => SAE_MYSQL_USER,
    'DB_PWD' => SAE_MYSQL_PASS,
    'DB_PORT' => SAE_MYSQL_PORT,
    'DB_PREFIX' => 'sp_',
    //密钥
    "AUTHCODE" => 'Q2O2QmjODncBgG6kMQ',
    //cookies
    "COOKIE_PREFIX" => 'U49dZ1_',
	
	'TMPL_PARSE_STRING'=>array(
		'__UPLOAD__'=>file_domain('data').'/upload/',
	)
);
//print_r($runtime_config); die;
return  array_merge($sae, $runtime_config, $thinksdk);
