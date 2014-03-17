<?php
class HomeBaseAction extends AppframeAction {
	
	public function __construct() {
		$this->set_action_success_error_tpl();
		C("TMPL_FILE_DEPR","/");
		parent::__construct();
	}
	
	function _initialize() {
		parent::_initialize();
		$site_options=get_site_options();
		$this->assign($site_options);
		$ucenter_syn=C("UCENTER_ENABLED");
		if($ucenter_syn){
			if(!isset($_SESSION["MEMBER_id"])){
				if(!empty($_COOKIE['thinkcmf_auth'])  && $_COOKIE['thinkcmf_auth']!="logout"){
					$thinkcmf_auth=sp_authcode($_COOKIE['thinkcmf_auth'],"DECODE");
					$thinkcmf_auth=explode("\t", $thinkcmf_auth);
					$auth_username=$thinkcmf_auth[1];
					$members_obj=M('Members');
					$where['user_login_name']=$auth_username;
					$member=$members_obj->where($where)->find();
					if(!empty($member)){
						$is_login=true;
						$_SESSION["MEMBER_type"]='local';
						$_SESSION["MEMBER_id"]=$member['ID'];
						$_SESSION['MEMBER_name']=$auth_username;
						$_SESSION['MEMBER_status']=$member['user_status'];
					}
				}
			}else{
			}
		}
		
	}		
	
	/**
	 * 加载模板和页面输出 可以返回输出内容
	 * @access public
	 * @param string $templateFile 模板文件名
	 * @param string $charset 模板输出字符集
	 * @param string $contentType 输出类型
	 * @param string $content 模板输出内容
	 * @return mixed
	 */
	public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
		//echo $this->parseTemplate($templateFile);
		parent::display($this->parseTemplate($templateFile), $charset, $contentType);
	}
	
	/**
	 * 自动定位模板文件
	 * @access protected
	 * @param string $template 模板文件规则
	 * @return string
	 */
	public function parseTemplate($template='') {
		$tmpl_path=C("SP_TMPL_PATH");
		$app_name=APP_NAME==basename(dirname($_SERVER['SCRIPT_FILENAME'])) && ''==__APP__?'':APP_NAME.'/';
		
		// 获取当前主题名称
		$theme      =    C('SP_DEFAULT_THEME');
		if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
			$t = C('VAR_TEMPLATE');
			if (isset($_GET[$t])){
				$theme = $_GET[$t];
			}elseif(cookie('think_template')){
				$theme = cookie('think_template');
			}
			if(!file_exists($tmpl_path."/".$theme)){
				$theme  =   C('SP_DEFAULT_THEME');
			}
			cookie('think_template',$theme,864000);
		}
		
		if(is_file($template)) {
			$group  =   defined('GROUP_NAME')?GROUP_NAME.'/':'';
			
			// 获取当前主题的模版路径
			if(1==C('APP_GROUP_MODE')){ // 独立分组模式
				//define('THEME_PATH',   dirname(BASE_LIB_PATH).'/'.$group.basename($tmpl_path).'/'.$theme."/");
				//define('APP_TMPL_PATH',__ROOT__.'/'.$app_name.C('APP_GROUP_PATH').'/'.$group.basename($tmpl_path).'/'.$theme."/");
				define('THEME_PATH',   $tmpl_path.$theme."/");
				define('APP_TMPL_PATH',__ROOT__.'/'.basename($tmpl_path).'/'.$theme."/");
			}else{
				//define('THEME_PATH',   $tmpl_path.$group.$theme."/");
				//define('APP_TMPL_PATH',__ROOT__.'/'.$app_name.basename($tmpl_path).'/'.$group.$theme."/");
				define('THEME_PATH',   $tmpl_path.$theme."/");
				define('APP_TMPL_PATH',__ROOT__.'/'.$app_name.basename($tmpl_path).'/'.$theme."/");
			}
			return $template;
		}
		$depr       =   C('TMPL_FILE_DEPR');
		$template   =   str_replace(':', $depr, $template);
		
		// 获取当前模版分组
		$group      =   defined('GROUP_NAME')?GROUP_NAME.'/':'';
		//$group      =   '';
		if(defined('GROUP_NAME') && strpos($template,'@')){ // 跨分组调用模版文件
			list($group,$template)  =   explode('@',$template);
			$group  .=   '/';
		}
		// 获取当前主题的模版路径
		if(1==C('APP_GROUP_MODE')){ // 独立分组模式
			/* define('THEME_PATH',   $tmpl_path.$group.$theme."/");
			define('APP_TMPL_PATH',__ROOT__.'/'.basename($tmpl_path).'/'.$group.$theme."/"); */
			define('THEME_PATH',   $tmpl_path.$theme."/");
			define('APP_TMPL_PATH',__ROOT__.'/'.basename($tmpl_path).'/'.$theme."/");
		}else{
			/* define('THEME_PATH',   $tmpl_path.$group.$theme."/");
			define('APP_TMPL_PATH',__ROOT__.'/'.$app_name.basename($tmpl_path).'/'.$group.$theme."/"); */
			define('THEME_PATH',   $tmpl_path.$theme."/");
			define('APP_TMPL_PATH',__ROOT__.'/'.$app_name.basename($tmpl_path).'/'.$theme."/");
		}
		// 分析模板文件规则
		if('' == $template) {
			// 如果模板文件名为空 按照默认规则定位
			$template = MODULE_NAME . $depr . ACTION_NAME;
		}elseif(false === strpos($template, '/')){
			$template = MODULE_NAME . $depr . $template;
		}
		$templateFile=THEME_PATH.$group.$template.C('TMPL_TEMPLATE_SUFFIX');
		if(!is_file($templateFile))
			throw_exception(L('_TEMPLATE_NOT_EXIST_').'['.$templateFile.']');
		return $templateFile;
	}
	
	
	private function set_action_success_error_tpl(){
		$theme      =    C('SP_DEFAULT_THEME');
		if(C('TMPL_DETECT_THEME')) {// 自动侦测模板主题
			if(cookie('think_template')){
				$theme = cookie('think_template');
			}
		}
		$tpl_path=C("SP_TMPL_PATH").$theme."/";
		$defaultjump=THINK_PATH.'Tpl/dispatch_jump.tpl';
		$action_success=$tpl_path.C("SP_TMPL_ACTION_SUCCESS").C("TMPL_TEMPLATE_SUFFIX");
		$action_error=$tpl_path.C("SP_TMPL_ACTION_ERROR").C("TMPL_TEMPLATE_SUFFIX");
		if(file_exists($action_success)){
			C("TMPL_ACTION_SUCCESS",$action_success);
		}else{
			C("TMPL_ACTION_SUCCESS",$defaultjump);
		}
		
		if(file_exists($action_error)){
			C("TMPL_ACTION_ERROR",$action_error);
		}else{
			C("TMPL_ACTION_ERROR",$defaultjump);
		}
	}
	
	
}