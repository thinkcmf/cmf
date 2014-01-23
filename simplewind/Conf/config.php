<?php
$db = include 'conf/db.php';
$config= include 'conf/config.php';
$runtime_config=include "data/conf/config.php";
$thinksdk=include "conf/ThinkSDK.config.php";
$configs= array(
		
		'APP_AUTOLOAD_PATH' => '', // 自动加载机制的自动搜索路径,注意搜索顺序
		'APP_TAGS_ON' => true, // 系统标签扩展开关
		'THIRD_UDER_ACCESS'		=> false, //第三方用户是否有全部权限，没有则需绑定本地账号
		/* 标签库 */
		'TAGLIB_BUILD_IN' => 'cx,spadmin',
		'APP_GROUP_LIST'        => 'Admin,Portal,Asset,Api,Member,Wx',      // 项目分组设定,多个组之间用逗号分隔,例如'Home,Admin'
	    'APP_GROUP_MODE'        =>  1,  // 分组模式 0 普通分组 1 独立分组
	    'APP_GROUP_PATH'        =>  '../application', // 分组目录 独立分组模式下面有效
 		'TMPL_DETECT_THEME'     => false,       // 自动侦测模板主题
 		'TMPL_TEMPLATE_SUFFIX'  => '.html',     // 默认模板文件后缀
 		'DEFAULT_GROUP'         => 'Portal',  // 默认分组
 		'DEFAULT_MODULE'        => 'Index', // 默认模块名称
 		'DEFAULT_ACTION'        => 'index', // 默认操作名称
		'SP_TMPL_PATH'     		=> 'tpl/',       // 前台模板文件根目录
		'SP_DEFAULT_THEME'		=> 'default',       // 前台模板文件
		'SP_TMPL_ACTION_ERROR' 	=> 'error', // 默认错误跳转对应的模板文件,注：相对于前台模板路径
		'SP_TMPL_ACTION_SUCCESS' 	=> 'success', // 默认成功跳转对应的模板文件,注：相对于前台模板路径
		'SP_ADMIN_TMPL_PATH'    => 'tpl_admin/',       // 各个项目后台模板文件根目录
		'SP_ADMIN_DEFAULT_THEME'=> 'default',       // 各个项目后台模板文件
		'SP_ADMIN_TMPL_ACTION_ERROR' 	=> 'Admin/error.html', // 默认错误跳转对应的模板文件,注：相对于后台模板路径
		'SP_ADMIN_TMPL_ACTION_SUCCESS' 	=> 'Admin/success.html', // 默认成功跳转对应的模板文件,注：相对于后台模板路径
		
	
		/* URL设置 */
 		'URL_CASE_INSENSITIVE'  => true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
 		'URL_MODEL'             => 1,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
 		// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持
 		'URL_PATHINFO_DEPR'     => '/',	// PATHINFO模式下，各参数之间的分割符号
 		'URL_PATHINFO_FETCH'    =>   'ORIG_PATH_INFO,REDIRECT_PATH_INFO,REDIRECT_URL', // 用于兼容判断PATH_INFO 参数的SERVER替代变量列表
 		'URL_HTML_SUFFIX'       => '',  // URL伪静态后缀设置
 		'URL_PARAMS_BIND'       =>  true, // URL变量绑定到Action方法参数
 		'URL_404_REDIRECT'      =>  '', // 404 跳转页面 部署模式有效

		'VAR_PAGE'				=>"p",
		
		/*性能优化*/
		
		'OUTPUT_ENCODE'			=>true,// 页面压缩输出
		
		'TMPL_PARSE_STRING'=>array(
			'/Public/upload'=>'/data/upload',
			'__UPLOAD__' => __ROOT__.'/data/upload/',
		)
);

if(!APP_DEBUG){
	$configs['APP_STATUS']="release";
}

return  array_merge($configs,$config,$db,$runtime_config,$thinksdk);
