<?php
class SettingAction extends AdminbaseAction {
	
	
	protected $options_obj;
	
	function _initialize() {
		parent::_initialize();
		$this->options_obj = new OptionsModel();
	}
	function  index(){
		
	}
	
	function site(){
		if (IS_POST) {
			$where=array();
			if(isset($_POST['option_id'])){
				$where=array("eq"=>$_POST['option_id']);
			}
			$home_config_file="./data/conf/config.php";
			if(file_exists($home_config_file)){
				$home_configs=include $home_config_file;
			}else {
				$home_configs=array();
			}
			
			$home_configs["SP_DEFAULT_THEME"]=$_POST['options']['site_tpl'];
			
			sp_save_var($home_config_file, $home_configs);
			
			F("site_options",get_site_options());
			
			$data['option_name']="site_options";
			$data['option_value']=json_encode($_POST['options']);
			$r=$this->options_obj->where($where)->add($data,array(),true);
			if ($r) {
				$this->success("保存成功！");
			} else {
				$this->error("保存失败！");
			}      
        } else {
        	$option=$this->options_obj->where("option_name='site_options'")->find();
        	$tpls=scandir(C("SP_TMPL_PATH"));
        	$noneed=array(".","..",".svn");
        	$tpls=array_diff($tpls, $noneed);
        	
        	$this->assign("templates",$tpls);
        	if($option){
        		$this->assign((array)json_decode($option['option_value']));
        		$this->assign("option_id",$option['option_id']);
        	}
            $this->display();
        }
	}
	
	
	function password(){
	if (IS_POST) {
			$user_obj=new UsersModel();
			$uid=get_current_admin_id();
			
			$admin=$user_obj->where("ID=$uid")->find();
			$old_password=$_POST['old_password'];
			$password=$_POST['password'];
			if(sp_password($old_password)==$admin['user_pass']){
				if($admin['user_pass']==sp_password($password)){
					$this->error("新密码不能和原始密码相同！");
				}else{
					
					$data['user_pass']=sp_password($password);
					$data['ID']=$uid;
					$r=$user_obj->save($data);
					if ($r) {
						$this->success("修改成功！");
					} else {
						$this->error("修改失败！");
					}
					
				}
				
			}else{
				$this->error("原始密码不正确！");
			}
        } else {
            $this->display();
        }
	}
	
	//清除缓存
	function clearcache(){
			
		sp_clear_cache();
		$this->display();
	}	
	
	
}