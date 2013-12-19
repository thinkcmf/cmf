<?php
class AdAction extends AdminbaseAction{
	protected $ad_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->ad_obj = new  AdModel();
	}
	function index(){
		$ads=$this->ad_obj->where("status!=0")->select();
		$this->assign("ads",$ads);
		$this->display();
	}
	
	
	function add(){
		if(IS_POST){
			if ($this->ad_obj->create()) {
				if ($this->ad_obj->add()) {
					$this->success("添加成功！", U("ad/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->ad_obj->getError());
			}
				
		}else{
			$this->display();
		}
	
	}
	
	
	function edit(){
		if (IS_POST) {
			if ($this->ad_obj->create()) {
				if ($this->ad_obj->save()) {
					$this->success("保存成功！", U("ad/index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->ad_obj->getError());
			}
		} else {
			$id=$this->_get("id");
			$ad=$this->ad_obj->where("ad_id=$id")->find();
			$this->assign($ad);
			$this->display();
		}
	}
	
	/**
	 *  删除
	 */
	function delete(){
		$id = (int) $this->_get("id");
		$data['status']=0;
		$data['ad_id']=$id;
		if ($this->ad_obj->save($data)) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
	
	
	
	
}