<?php
class HomeBaseAction extends AppframeAction {
	
	function _initialize() {
		
		parent::_initialize();
		
		//site_options
		$site_options=F("site_options");
		if(empty($site_options)){
			$site_options=get_site_options();
			F("site_options",$site_options);
			$this->assign($site_options);
		}else{
			$this->assign($site_options);
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
	public function display($templateFile='',$charset='',$contentType='',$content='') {
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
		if(is_file($template)) {
			$group  =   defined('GROUP_NAME')?GROUP_NAME.'/':'';
			$theme  =   C('SP_DEFAULT_THEME');
			// 获取当前主题的模版路径
			if(1==C('APP_GROUP_MODE')){ // 独立分组模式
				define('THEME_PATH',   dirname(BASE_LIB_PATH).'/'.$group.basename($tmpl_path).'/'.$theme."/");
				define('APP_TMPL_PATH',__ROOT__.'/'.$app_name.C('APP_GROUP_PATH').'/'.$group.basename($tmpl_path).'/'.$theme."/");
			}else{
				define('THEME_PATH',   $tmpl_path.$group.$theme."/");
				define('APP_TMPL_PATH',__ROOT__.'/'.$app_name.basename($tmpl_path).'/'.$group.$theme."/");
			}
			return $template;
		}
		$depr       =   C('TMPL_FILE_DEPR');
		$template   =   str_replace(':', $depr, $template);
		// 获取当前主题名称
		$theme      =    C('SP_DEFAULT_THEME');
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
		return THEME_PATH.$group.$template.C('TMPL_TEMPLATE_SUFFIX');
	}
}