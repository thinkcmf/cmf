<?php
class CatogeryAction extends HomeBaseAction{
	
	protected $terms_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->terms_obj = new TermsModel();
	}
	
	function index(){
		$term_id=$_GET['id'];
		
		$term=$this->terms_obj->where("term_id=$term_id")->find();
		$this->assign($term);
		
		$sql="SELECT * FROM _prefix_term_relationships as a LEFT JOIN _prefix_posts  b ON a.object_id = b.ID where a.term_id=$term_id";
		$sql = str_replace ( "_prefix_", C ( 'DB_PREFIX' ), $sql );
		$posts=$this->terms_relationship->query($sql);
		$this->assign("posts",$posts);
		$this->display(sp_tpl("post"));
	}
	
	
}