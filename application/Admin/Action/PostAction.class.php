<?php
class PostAction extends AdminbaseAction {
	protected $posts_obj;
	protected $terms_relationship;
	protected $terms_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->posts_obj = new PostsModel();
		$this->terms_obj = new TermsModel();
		$this->terms_relationship=new TermRelationshipsModel();
	}
	function index(){
		$this->lists();
		$this->getTree();
		$this->display();
	}
	
	function add(){
		$this->getTree();
	$terms_obj=new TermsModel();
	
	 if (IS_POST) {
	 	$_POST['post']['post_date']=date("Y-m-d H:i:s",time());
	 	$_POST['post']['smeta']=json_encode($_POST['smeta']);
            $result=$this->posts_obj->add($_POST['post']);
                if ($result) {
                    //
                    $_POST['term']['object_id']=$result;
                    $result=$this->terms_relationship->add($_POST['term']);
                    if ($result) {
                    	$this->success("新增成功！");
                    }else{
                    	$this->error("归类失败！");
                    }
                } else {
                    $this->error("新增失败！");
                }
           
        } else {
        	$term_id = (int) $this->_get("term");
        	$term=$terms_obj->where("term_id=$term_id")->find();
        	$this->assign("author","1");
        	$this->assign("term",$term);
            $this->display();
        }
	}
	
	public function edit(){
		header("file-type:text/html;charset=utf-8;");
		$terms_obj=new TermsModel();
		
		if (IS_POST) {
			$_POST['post']['smeta']=json_encode($_POST['smeta']);
			$result=$this->posts_obj->save($_POST['post']);
			//echo($this->posts_obj->getLastSql());die;
			if ($result) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}
		} else {
			$id=(int) $this->_get("id");
			$term_id = (int) $this->_get("term");
			if(empty($term_id)){
				$term_id = D('TermRelationships')->getTermidByObject($id);
			}
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
	
	public function lists($status=1){
		$terms_obj=new TermsModel();
		$term_id =intval($_REQUEST["term"]);
		$term=$terms_obj->where("term_id=$term_id")->find();
		$this->assign("term",$term);
		
		$where_ands=empty($term_id)?array("a.status=$status"):array("a.term_id = $term_id and a.status=$status");
		
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
			
			
		$count=$this->terms_relationship
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.ID")
		->where($where)
		->count();
			
		$page = $this->page($count, 20);
			
			
		$posts=$this->terms_relationship
		->alias("a")
		->join(C ( 'DB_PREFIX' )."posts b ON a.object_id = b.ID")
		->where($where)
		->limit($page->firstRow . ',' . $page->listRows)
		->order("a.listorder ASC")->select();
			
		$this->assign("Page", $page->show('Admin'));
		$this->assign("current_page",$page->GetCurrentPage());
		$this->assign("formget",$_GET);
		$this->assign("posts",$posts);
	}
	
	private function getTree(){
		$term_id=$_REQUEST['term'];
		$result = $this->terms_obj->order(array("listorder"=>"asc"))->select();
		
		$tree = new Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("term/add", array("parent" => $r['term_id'])) . '">添加子类</a> | <a href="' . U("term/edit", array("id" => $r['term_id'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("term/delete", array("id" => $r['term_id'])) . '">删除</a> ';
			$r['visit'] = "<a href='#'>访问</a>";
			$r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$r['selected']=$term_id==$r['term_id']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
	
	function delete(){
		if(isset($_GET['tid'])){
			$tid = (int) $this->_get("tid");
			$data['status']=0;
			if ($this->terms_relationship->where("tid=$tid")->save($data)) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
		if(isset($_POST['ids'])){
			$tids=join(",",$_POST['ids']);
			$data['status']=0;
			if ($this->terms_relationship->where("tid in ($tids)")->save($data)) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	}
	
	function check(){
		if(isset($_POST['ids']) && $_GET["check"]){
			$data["post_status"]=1;
			
			$tids=join(",",$_POST['ids']);
			$objectids=$this->terms_relationship->field("object_id")->where("tid in ($tids)")->select();
			$IDs=array();
			foreach ($objectids as $id){
				$IDs[]=$id["object_id"];
			}
			$IDs=join(",", $IDs);
			if ( $this->posts_obj->where("ID in ($IDs)")->save($data)) {
				$this->success("取消审核成功！");
			} else {
				$this->error("取消审核失败！");
			}
		}
		if(isset($_POST['ids']) && $_GET["uncheck"]){
			
			$data["post_status"]=0;
			$tids=join(",",$_POST['ids']);
			$objectids=$this->terms_relationship->field("object_id")->where("tid in ($tids)")->select();
			$IDs=array();
			foreach ($objectids as $id){
				$IDs[]=$id["object_id"];
			}
			$IDs=join(",", $IDs);
			if ( $this->posts_obj->where("ID in ($IDs)")->save($data)) {
				$this->success("取消审核成功！");
			} else {
				$this->error("取消审核失败！");
			}
		}
	}
	
	
	function move(){
		if(IS_POST){
			if(isset($_GET['ids']) && isset($_POST['term_id'])){
				$tids=$_GET['ids'];
				if ( $this->terms_relationship->where("tid in ($tids)")->save($_POST)) {
					$this->success("移动成功！");
				} else {
					$this->error("移动失败！");
				}
			}
		}else{
			$terms_obj=new TermsModel();
			$parentid = (int) $this->_get("parent");
			$tree = new PathTree();
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '---';
			$result =$terms_obj->order(array("path"=>"asc"))->select();
			$tree->init($result);
			$tree=$tree->get_tree();
			$this->assign("terms",$tree);
			
			$this->display();
		}
	}
	
	function recyclebin(){
		$this->lists(0);
		$this->getTree();
		$this->display();
	}
	
	function clean(){
		if(isset($_POST['ids'])){
			$ids = implode(",", $_POST['ids']);
			$tids= implode(",", array_keys($_POST['ids']));
			$data=array("post_status"=>"0");
			$status=$this->terms_relationship->where("tid in ($tids)")->delete();
			if($status){
				$status=$this->posts_obj->where("ID in ($ids)")->delete();
			}
			
			if ($status) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}else{
			if(isset($_GET['id'])){
				$id = (int) $this->_get("id");
				$tid = (int) $this->_get("tid");
				$status=$this->terms_relationship->where("tid = $tid")->delete();
				if($status){
					$status=$this->posts_obj->where("ID=$id")->delete();
				}
				if ($status) {
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
			$data=array("tid"=>$id,"status"=>"1");
			if ($this->terms_relationship->save($data)) {
				$this->success("还原成功！");
			} else {
				$this->error("还原失败！");
			}
		}
	}
	
	
	
}