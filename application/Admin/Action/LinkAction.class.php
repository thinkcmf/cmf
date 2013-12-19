<?php
class LinkAction extends AdminbaseAction{
	
	protected $link_obj;
	protected  $targets=array("_blank"=>"新标签页打开");
	
	
	function _initialize() {
		parent::_initialize();
		$this->link_obj = new  LinksModel();
	}
	
	function index(){
		$links=$this->link_obj->order(array("listorder"=>"asc"))->where("link_status!=0")->select();
		$this->assign("links",$links);
		$this->display();
	}
	
	function add(){
		if(IS_POST){
			if ($this->link_obj->create()) {
				if ($this->link_obj->add()) {
					$this->success("添加成功！", U("link/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->link_obj->getError());
			}
	
		}else{
			$this->assign("targets",$this->targets);
			$this->display();
		}
	
	}
	
	function edit(){
		if (IS_POST) {
			if ($this->link_obj->create()) {
				if ($this->link_obj->save()) {
					$this->success("保存成功！");
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->link_obj->getError());
			}
		} else {
			$id=$this->_get("id");
			$link=$this->link_obj->where("link_id=$id")->find();
			$this->assign($link);
			
			$this->assign("targets",$this->targets);
			$this->display();
		}
	}
	
	//排序
	public function listorders() {
		$status = parent::listorders($this->link_obj);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	//删除
	function delete(){
		if(isset($_POST['ids'])){
			
		}else{
			$id = (int) $this->_get("id");
			if ($this->link_obj->delete($id)) {
				$this->success("删除成功！");
			} else {
				$this->error("删除失败！");
			}
		}
	
	}
	
	
}