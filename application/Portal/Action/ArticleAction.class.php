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
    	$this->assign($article);
    	$this->assign("smeta",$smeta);
    	$this->assign("term",$term);
    	
    	$tplname=$term["one_tpl"];
    	$tplname=sp_get_apphome_tpl($tplname, "article");
    	$this->display(":$tplname");
    }   
}
?>
