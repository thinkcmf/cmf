<?php
class CommentAction extends AdminbaseAction{
	
	protected $comment_obj;
	protected $posts_obj;
	
	
	function _initialize() {
		parent::_initialize();
		$this->comment_obj = new  CommentsModel();
		$this->posts_obj=new PostsModel();
	}
	
	function index(){
		$join="".C('DB_PREFIX').'posts as b on a.comment_post_ID =b.ID';
		$comments=$this->comment_obj->alias("a")->join($join)->select();
		$this->display();
	}
	
	
	
}