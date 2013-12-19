<?php
class PageAction extends AdminbaseAction {
	protected $posts_obj;
	function _initialize() {
		parent::_initialize();
		$this->posts_obj = new PostsModel();
	}
	function index(){
		
		$where_ands=array("post_type=2 and post_status=1");
		$fields=array(
				'start_time'=> array("field"=>"post_date","operator"=>">"),
				'end_time'  => array("field"=>"post_date","operator"=>"<"),
				'keyword'  => array("field"=>"post_title","operator"=>"like"),
		);
		if(IS_POST){
				
			foreach ($fields as $param =>$val){
				if (isset($_POST[$param]) && !empty($_POST[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_POST[$param];
					$_GET[$param]=$get;
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}else{
			foreach ($fields as $param =>$val){
				if (isset($_GET[$param]) && !empty($_GET[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_GET[$param];
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}
		
		$where= join(" and ", $where_ands);
		
		$count=$this->posts_obj->where($where)->count();
		$page = $this->page($count, 20);
		
		$posts=$this->posts_obj->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		
		$this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$_GET);
		$this->assign("posts",$posts);
		$this->display();
	}
	
	function recyclebin(){
		$where_ands=array("post_type=2 and post_status=0");
		$fields=array(
				'start_time'=> array("field"=>"post_date","operator"=>">"),
				'end_time'  => array("field"=>"post_date","operator"=>"<"),
				'keyword'  => array("field"=>"post_title","operator"=>"like"),
		);
		if(IS_POST){
		
			foreach ($fields as $param =>$val){
				if (isset($_POST[$param]) && !empty($_POST[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_POST[$param];
					$_GET[$param]=$get;
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}else{
			foreach ($fields as $param =>$val){
				if (isset($_GET[$param]) && !empty($_GET[$param])) {
					$operator=$val['operator'];
					$field   =$val['field'];
					$get=$_GET[$param];
					if($operator=="like"){
						$get="%$get%";
					}
					array_push($where_ands, "$field $operator '$get'");
				}
			}
		}
		
		$where= join(" and ", $where_ands);
		
		$count=$this->posts_obj->where($where)->count();
		$page = $this->page($count, 20);
		
		$posts=$this->posts_obj->where($where)->limit($page->firstRow . ',' . $page->listRows)->select();
		
		$this->assign("Page", $page->show('Admin'));
		$this->assign("formget",$_GET);
		$this->assign("posts",$posts);
		$this->display();
	}
	
	function add(){
	
	 	if (IS_POST) {
	 	$_POST['post']['post_date']=date("Y-m-d H:i:s",time());
	 	$_POST['post']['smeta']=json_encode($_POST['smeta']);
            $result=$this->posts_obj->add($_POST['post']);
                if ($result) {
                    $this->success("新增成功！");
                } else {
                    $this->error("新增失败！");
                }
           
        } else {
        	$this->assign("author","1");
            $this->display();
        }
	}
	
	public function edit(){
		$terms_obj=new TermsModel();
		
		if (IS_POST) {
			$_POST['post']['smeta']=json_encode($_POST['smeta']);
			$result=$this->posts_obj->save($_POST['post']);
			if ($result) {
				//
				$this->success("保存成功！");
				//$this->success(json_encode($_POST['meta']));
			} else {
				$this->error("保存失败！");
			}
			 
		} else {
			$term_id = (int) $this->_get("term");
			$id=(int) $this->_get("id");
			$term=$terms_obj->where("term_id=$term_id")->find();
			$post=$this->posts_obj->where("ID=$id")->find();
			$this->assign("post",$post);
			$this->assign("smeta",(array)json_decode($post['smeta']));
			
			$this->assign("author","1");
			$this->assign("term",$term);
			$this->display();
		}
		}
	
	//排序
	public function listorders() {
		$status = parent::listorders($this->terms_relationship);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	public function lists(){
	$terms_obj=new TermsModel();
	$term_id = (int) $this->_get("term");
	$term=$terms_obj->where("term_id=$term_id")->find();
	$this->assign("term",$term);
	 
	$sql="SELECT * FROM _prefix_term_relationships as a LEFT JOIN _prefix_posts  b ON a.object_id = b.ID where a.term_id=$term_id";
	$sql = str_replace ( "_prefix_", C ( 'DB_PREFIX' ), $sql );
	$posts=$this->terms_relationship->query($sql);
	$this->assign("posts",$posts);
	$this->display();
	 	
        	
	}
	
	function delete(){
		
		
		if(isset($_POST['ids'])){
			$ids = implode(",", $_POST['ids']);
			$data=array("post_status"=>"0");
			if ($this->posts_obj->where("ID in ($ids)")->save($data)) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}else{
			if(isset($_GET['id'])){
				$id = (int) $this->_get("id");
				$data=array("ID"=>$id,"post_status"=>"0");
				if ($this->posts_obj->save($data)) {
					$this->success("删除成功！");
				} else {
					$this->error("删除失败！");
				}
			}
		}
	}
	
	function restore(){
		if(isset($_GET['id'])){
			$id = (int) $this->_get("id");
			$data=array("ID"=>$id,"post_status"=>"1");
			if ($this->posts_obj->save($data)) {
				$this->success("还原成功！");
			} else {
				$this->error("还原失败！");
			}
		}
	}
	
	function clean(){
		if(isset($_GET['id'])){
			$id = (int) $this->_get("id");
			if ($this->posts_obj->delete($id)) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}
	
	
	
}