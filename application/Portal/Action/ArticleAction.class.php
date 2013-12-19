<?php

/**
 * 文章内页
 */
class ArticleAction extends HomeBaseAction {
    //文章内页
    public function index() {
    	$article=sp_sql_post($_GET['id'],'');
    	$termid=$article['term_id'];
    	$term_obj=new TermsModel();
    	$term=$term_obj->where("term_id='$termid'")->find();
    	$smeta=json_decode($article[smeta],true);
    	$this->assign("article",$article);
    	$this->assign("smeta",$smeta);
    	$this->assign("term",$term);
    	
    	$tplname=$term["one_tpl"];
    	$theme=C("SP_DEFAULT_THEME");
    	
    	//$themepath=SPAPP_PATH.C("APP_GROUP_PATH")."/".GROUP_NAME."/".C("DEFAULT_V_LAYER")."/".$theme."/";
    	$themepath=C("SP_TMPL_PATH").$theme."/".GROUP_NAME."/";
    	$tplpath=$themepath.$tplname.C("TMPL_TEMPLATE_SUFFIX");
    	
    	$defaultpl=$themepath."article".C("TMPL_TEMPLATE_SUFFIX");
    	
    	if(file_exists($tplpath)){
    		
    	}else if(file_exists($defaultpl)){
    		$tplname="article";
    	}else{
    		$tplname="404";
    	}
    	
    	$this->display(":$tplname");
    }   
}
?>
