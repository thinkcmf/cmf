<?php

/**
 * DOC
 */
class DocumentAction extends HomeBaseAction {
	
    //首页
    public function index() {
    	$this->display();
    }
  	public function course() {
  		$course=sp_sql_posts('cid:4;order:post_date desc;field:post_title,tid;');
  		$this->assign("course",$course);
  		
    	$this->display('course');
    }
	public function content() {
  		$content=sp_sql_post($_GET['id'],'field:post_title,post_content,post_date;');
  		$this->assign("content",$content);
    	$this->display('content');
    }
	public function sidebar() {
		$fun=sp_sql_posts('cid:13;order:listorder asc;field:post_title,object_id;');
		$this->assign("fun",$fun);
	    $this->display('sidebar');
	    }   
}

?>
