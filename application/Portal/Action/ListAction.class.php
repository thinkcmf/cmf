<?php

/**
 * 文章列表
*/
class ListAction extends HomeBaseAction {

	//文章内页
	public function index() {
		$term=sp_get_term($_GET['id']);
		$tplname=$term["list_tpl"];
    	$theme=C("DEFAULT_THEME");
    	
    	$themepath=SPAPP_PATH.C("APP_GROUP_PATH")."/".GROUP_NAME."/".C("DEFAULT_V_LAYER")."/".$theme."/";
    	$tplpath=$themepath.$tplname.C("TMPL_TEMPLATE_SUFFIX");
    	
    	$defaultpl=$themepath."list".C("TMPL_TEMPLATE_SUFFIX");
    	
    	if(file_exists($tplpath)){
    		
    	}else if(file_exists($defaultpl)){
    		$tplname="list";
    	}else{
    		$tplname="404";
    	}
    	
    	$this->display(":$tplname");
	}
}
?>
