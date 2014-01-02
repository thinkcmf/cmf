<?php

/**
 * 后台首页
 */
class IndexAction extends AdminbaseAction {
	
	
	function _initialize() {
		$users_obj=new UsersModel();
		if(isset($_SESSION['ADMIN_ID'])){
			$id=$_SESSION['ADMIN_ID'];
			$user=$users_obj->where("ID=$id")->find();
			$this->assign("admin",$user);
		}else{
			$this->error("您还没有登录！",U("admin/public/login"));
		}
		 
		$this->initMenu();
	}
    //后台框架首页
    public function index() {
        $this->assign("SUBMENU_CONFIG", json_encode(D("Menu")->menu_json()));
        $this->display();
    }

    

}

?>
