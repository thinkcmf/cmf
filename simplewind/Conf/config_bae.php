<?php
$bae_mc=new BaeMemcache();
$runtime_config=$bae_mc->get("THINKCMF_DYNAMIC_CONFIG");
$runtime_config=$runtime_config? unserialize($runtime_config) : array();


//BAE下固定mysql配置
$bae = array(
    'DB_TYPE' => 'mysql',
	'DB_DEPLOY_TYPE'=> 1,
	'DB_RW_SEPARATE'=>true,
    'DB_HOST'=> HTTP_BAE_ENV_ADDR_SQL_IP, // 服务器地址
	'DB_NAME'=> '',        // 数据库名,填写你创建的数据库
	'DB_USER'=> HTTP_BAE_ENV_AK,    // 用户名
	'DB_PWD'=> HTTP_BAE_ENV_SK,         // 密码
	'DB_PORT'=> HTTP_BAE_ENV_ADDR_SQL_PORT,        // 端口
	
	'TMPL_PARSE_STRING'=>array(
		'__UPLOAD__'=>file_domain('data').'/upload/'
	)
);

return  array_merge($bae, $runtime_config);