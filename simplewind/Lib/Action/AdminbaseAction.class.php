<?php

/**
 * 后台Action
 */
//定义是后台
define('IN_ADMIN', true);

class AdminbaseAction extends AppframeAction {
	
	public function __construct() {
		$admintpl_path=C("SP_ADMIN_TMPL_PATH").C("SP_ADMIN_DEFAULT_THEME")."/";
		C("TMPL_ACTION_SUCCESS",$admintpl_path.C("SP_ADMIN_TMPL_ACTION_SUCCESS"));
		C("TMPL_ACTION_ERROR",$admintpl_path.C("SP_ADMIN_TMPL_ACTION_ERROR"));
		parent::__construct();
		$time=time();
		$this->assign("js_debug",APP_DEBUG?"?v=$time":"");
	}

    function _initialize() {
       parent::_initialize();
    	if(isset($_SESSION['ADMIN_ID'])){
    		$users_obj= D("Users");
    		$id=$_SESSION['ADMIN_ID'];
    		$user=$users_obj->where("ID=$id")->find();
    		if(!$this->check_access($user['role_id'])){
    			$this->error("您没有访问权限！");
    			exit();
    		}
    		$this->assign("admin",$user);
    	}else{
    		//$this->error("您还没有登录！",U("admin/public/login"));
    		if(IS_AJAX){
    			$this->error("您还没有登录！",U("admin/public/login"));
    		}else{
    			header("Location:".U("admin/public/login"));
    			exit();
    		}
    		
    	}
    }

    /**
     * 消息提示
     * @param type $message
     * @param type $jumpUrl
     * @param type $ajax 
     */
    public function success($message = '', $jumpUrl = '', $ajax = false) {
        parent::success($message, $jumpUrl, $ajax);
        $text = "应用：" . GROUP_NAME . ",模块：" . MODULE_NAME . ",方法：" . ACTION_NAME . "<br>提示语：" . $message;
    }

    /**
     * 模板显示
     * @param type $templateFile 指定要调用的模板文件
     * @param type $charset 输出编码
     * @param type $contentType 输出类型
     * @param string $content 输出内容
     * 此方法作用在于实现后台模板直接存放在各自项目目录下。例如Admin项目的后台模板，直接存放在Admin/Tpl/目录下
     */
    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        parent::display($this->parseTemplate($templateFile), $charset, $contentType);
    }
    
    
    /**
     * 自动定位模板文件
     * @access protected
     * @param string $template 模板文件规则
     * @return string
     */
    public function parseTemplate($template='') {
    	$tmpl_path=C("SP_ADMIN_TMPL_PATH");
    	$app_name=APP_NAME==basename(dirname($_SERVER['SCRIPT_FILENAME'])) && ''==__APP__?'':APP_NAME.'/';
    	// 获取当前主题名称
    	$theme      =    C('SP_ADMIN_DEFAULT_THEME');
    	if(is_file($template)) {
    		$group  =   defined('GROUP_NAME')?GROUP_NAME.'/':'';
    		
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

    //扩展方法，当用户没有权限操作，用于记录日志的扩展方法
    public function _ErrorLog() {
        
    }

    /**
     * 初始化后台菜单
     */
    public function initMenu() {
        $Menu = F("Menu");
        if (!$Menu) {
            $Menu=D("Menu")->menu_cache();
        }
        return $Menu;
    }

    /**
     *  排序 排序字段为listorders数组 POST 排序字段为：listorder
     */
    protected function _listorders($model) {
        if (!is_object($model)) {
            return false;
        }
        $pk = $model->getPk(); //获取主键名称
        $ids = $_POST['listorders'];
        foreach ($ids as $key => $r) {
            $data['listorder'] = $r;
            $model->where(array($pk => $key))->save($data);
        }
        return true;
    }

    protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
        import('Page');
        if ($Page_Size == 0) {
            $Page_Size = C("PAGE_LISTROWS");
        }
        if (empty($PageParam)) {
            $PageParam = C("VAR_PAGE");
        }
        $Page = new Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
        $Page->SetPager('Admin', '{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}', array("listlong" => "6", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
        return $Page;
    }

    /**
     * 获取菜单导航
     * @param type $app
     * @param type $model
     * @param type $action
     */
    public static function getMenu() {

        $menuid = (int) $_GET['menuid'];
        $menuid = $menuid ? $menuid : cookie("menuid", "", array("prefix" => ""));
        //cookie("menuid",$menuid);

        $db = D("Menu");
        $info = $db->cache(true, 60)->where(array("id" => $menuid))->getField("id,action,app,model,parentid,data,type,name");
        $find = $db->cache(true, 60)->where(array("parentid" => $menuid, "status" => 1))->getField("id,action,app,model,parentid,data,type,name");

        if ($find) {
            array_unshift($find, $info[$menuid]);
        } else {
            $find = $info;
        }
        foreach ($find as $k => $v) {
            $find[$k]['data'] = $find[$k]['data']."&menuid=$menuid" ;
        }

        return $find;
    }

    /**
     * 当前位置
     * @param $id 菜单id
     */
    final public static function current_pos($id) {
        $menudb = M("Menu");
        $r = $menudb->where(array('id' => $id))->find();
        $str = '';
        if ($r['parentid']) {
            $str = self::current_pos($r['parentid']);
        }
        return $str . $r['name'] . ' > ';
    }
    
    private function check_access($roleid){
    	
    		//如果用户角色是1，则无需判断
    		if($roleid == 1){
    			return true;
    		}
    		$role_obj= D("Role");
    		$role=$role_obj->field("status")->where("id=$roleid")->find();
    		if(!empty($role) && $role['status']==1){
    			$group=GROUP_NAME;
    			$model=MODULE_NAME;
    			$action=ACTION_NAME;
    			if(GROUP_NAME.MODULE_NAME.ACTION_NAME!="AdminIndexindex"){
    				$access_obj = M("Access");
    				$count = $access_obj->where ( "role_id=$roleid and g='$group' and m='$model' and a='$action'")->count();
    				return $count;
    			}else{
    				return true;
    			}
    		}else{
    			return false;
    		}
    		
    		
    		
    }
}

?>
