<?php
class UserAction extends AdminbaseAction{
	protected $users_obj,$role_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->users_obj = new  UsersModel();
		$this->role_obj=new RoleModel();
	}
	function index(){
		$users=$this->users_obj->where("user_status=1")->select();
		$roles_src=$this->role_obj->select();
		$roles=array();
		foreach ($roles_src as $r){
			$roleid=$r['id'];
			$roles["$roleid"]=$r;
		}
		$this->assign("roles",$roles);
		$this->assign("users",$users);
		$this->display();
	}
	
	
	function add(){
		if(IS_POST){
			if ($this->users_obj->create()) {
				if ($this->users_obj->add()) {
					$this->success("添加成功！", U("user/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->users_obj->getError());
			}
				
		}else{
			$roles=$this->role_obj->where("status=1")->select();
			$this->assign("roles",$roles);
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
		$data['user_status']=0;
		$data['ID']=$id;
		if ($this->users_obj->save($data)) {
			$this->success("删除成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
	
	function userinfo(){
			if (IS_POST) {
				if ($this->users_obj->create()) {
					if ($this->users_obj->save()) {
						$this->success("保存成功！");
					} else {
						$this->error("保存失败！");
					}
				} else {
					$this->error($this->users_obj->getError());
				}
			} else {
				$id=get_current_admin_id();
				$user=$this->users_obj->where("ID='$id'")->find();
				$this->assign($user);
				$this->display();
			}
	}
	
	
	
	
	
}