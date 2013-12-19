<?php
class PostAction extends HomeBaseAction{
	
	protected $posts_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->posts_obj = new PostsModel();
	}
	
	function index(){
		$id=$_GET['id'];
		$post=$this->posts_obj->where("ID=$id")->find();
		$this->assign($post);
		$this->display(sp_tpl("post"));
	}
	
	
}