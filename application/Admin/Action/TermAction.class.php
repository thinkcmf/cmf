<?php
class TermAction extends AdminbaseAction {
	
	protected $terms_obj;
	
	protected $taxonomys=array("article"=>"文章","picture"=>"图片");
	function _initialize() {
		parent::_initialize();
		$this->terms_obj = new TermsModel();
		$this->assign("taxonomys",$this->taxonomys);
	}
	function index(){
		$result = $this->terms_obj->order(array("listorder"=>"asc"))->select();
		
       /*  $tree = new PathTree();
        $tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        $tree->nbsp = '---';
       	$tree->init($result);
       	$tree=$tree->get_tree();
       	$this->assign("terms",$tree); */
		$tree = new Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("term/add", array("parent" => $r['term_id'])) . '">添加子类</a> | <a href="' . U("term/edit", array("id" => $r['term_id'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("term/delete", array("id" => $r['term_id'])) . '">删除</a> ';
			$r['visit'] = "<a href='#'>访问</a>";
			$r['taxonomys'] = $this->taxonomys[$r['taxonomy']];
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$array[] = $r;
		}
		
		$tree->init($array);
		$str = "<tr>
				<td align='center'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input'></td>
				<td align='center'>\$id</td>
				<td >\$spacer\$name</td>
    			<td align='center'>\$taxonomys</td>
				<!--<td align='center'>\$visit</td>-->
				<td align='center'>\$str_manage</td>
				</tr>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
		$this->display();
        //$this->display();
	}
	
	
	function add(){
	
	 if (IS_POST) {
            if ($this->terms_obj->create()) {
                if ($this->terms_obj->add()) {
                    $this->success("新增成功！",U("term/index"));
                } else {
                    $this->error("新增失败！");
                }
            } else {
                $this->error($this->terms_obj->getError());
            }
        } else {
        	$parentid = (int) $this->_get("parent");
        	$tree = new PathTree();
        	$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
        	$tree->nbsp = '---';
        	$result = $this->terms_obj->order(array("path"=>"asc"))->select();
        	$tree->init($result);
        	$tree=$tree->get_tree();
        	$this->assign("terms",$tree);
        	$this->assign("parent",$parentid);
            $this->display();
        }
	}
	
	function edit(){
		if (IS_POST) {
			if ($this->terms_obj->create()) {
				if ($this->terms_obj->save()!==false) {
					$this->success("修改成功！");
				} else {
					$this->error("修改失败！");
				}
			} else {
				$this->error($this->terms_obj->getError());
			}
		} else {
			$tree = new PathTree();
			$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
			$tree->nbsp = '---';
			$result = $this->terms_obj->order(array("path"=>"asc"))->select();
			$tree->init($result);
			$tree=$tree->get_tree();
			
			$id = (int) $this->_get("id");
			$data=$this->terms_obj->where(array("term_id" => $id))->find();
			$this->assign("terms",$tree);
			$this->assign("data",$data);
			$this->display();
		}
	}
	
	//排序
	public function listorders() {
		$status = parent::listorders($this->terms_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	/**
	 *  删除
	 */
	public function delete() {
		$id = (int) $this->_get("id");
		$count = $this->terms_obj->where(array("parent" => $id))->count();
		if ($count > 0) {
			$this->error("该菜单下还有子类，无法删除！");
		}
		if ($this->terms_obj->delete($id)) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
	public function show(){
		$result = $this->terms_obj->order(array("listorder"=>"asc"))->select();
		$tree = new Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['id']=$r['term_id'];
			$r['parentid']=$r['parent'];
			$name=$r['name'];
			$url=U('post/lists',array('term'=>$r['term_id']));
			$r['name']="<a class='term_link' href='$url' >$name</a>";
			$array[$r['term_id']] = $r;
		}
		$str = "<tr>
				<td >\$spacer\$name</td>
				</tr>";
		$tree->init($array);
		
		$categorys = $tree->get_tree(0, $str);;
			
		$this->assign("categorys", $categorys);
		$this->display();
		
	}
}