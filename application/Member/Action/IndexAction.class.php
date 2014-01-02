<?php

/**
 * 会员注册登录
 */
class IndexAction extends HomeBaseAction {
    //登录
	public function index() {
    	$this->display(":login");
    }
    
    //登录验证
    function dologin(){
    	extract($_POST);
    	if($_SESSION['_verify_']['verify']!=strtolower($verify))
    	{
    		$this->error("验证码错误！");
    	}else{
    		$result = M('Members')->where("user_login_name='$name'")->find();
    		if($result != null)
    		{
    			if($result['user_pass'] == sp_password($passwd))
    			{
    				//登入成功页面跳转
    				$_SESSION["MEMBER_type"]='local';
    				$_SESSION["MEMBER_id"]=$result["ID"];
    				$_SESSION['MEMBER_name']=$result["user_login_name"];
    				session("roleid",$result['role_id']);
    				//写入此次登录信息
    				$data = array(
    						'last_login_time' => time(),
    						'last_login_ip' => get_client_ip(),
    				);
    				M('Members')->where("ID=".$result["ID"])->save($data);
    				$this->success("登录验证成功！",U("Member/center/index"));
    			}else{
    				$this->error("密码错误！");
    			}
    		}else{
    			$this->error("用户名不存在！");
    		}
    	}    	
    }
    
    //注册
    public function register() {
    	$this->display(":register");
    }
    
    //注册验证
    function doregister(){
    	extract($_POST);
    	//用户名需过滤的字符的正则
    	$stripChar = '?<*.>\'';
    	if($_SESSION['_verify_']['verify']!=strtolower($verify))
    	{
    		$this->error("验证码错误！");
    	}else if(preg_match('/['.$stripChar.']/is', $name)==1){
    		$this->error('用户名中包含'.$stripChar.'等非法字符！');
    	}else if($pass!=$repass){
    		$this->error("两次密码输入不一致！");
    	}else if(strlen($pass) < 5 || strlen($pass) > 12){
    		$this->error("密码长度至少5位，最多12位！");
    	}else  if (ereg("/^[a-z]([a-z0-9]*[-_\.]?[a-z0-9]+)*@([a-z0-9]*[-_]?[a-z0-9]+)+[\.][a-z]{2,3}([\.][a-z]{2})?$/i;",$email)){
    		$this->error("邮箱格式不正确！");
    	}else{
    		$result = M('Members')->where("user_login_name='$name' or user_email='$email'")->count();
    		if($result){
    			$this->error("用户名或者该邮箱已经存在！");
    		}else{
    			$data=array(
    					'user_login_name' => $name,
    					'user_email' => $email,
    					'user_pass' => sp_password($pass),
    					'last_login_ip' => get_client_ip(),
    					'create_time' => time(),
    					'last_login_time' => time(),
    					'user_status' => '1',
    			);
    			$rst = M('Members')->add($data);
    			//登入成功页面跳转
    			$_SESSION["MEMBER_type"]='local';
    			$_SESSION["MEMBER_id"]=$rst;
    			$_SESSION['MEMBER_name']=$name;
    			$this->success("注册成功！",U("Member/center/index"));
    		}
    	}
    }
    
    //绑定本地账号
    function bang(){
    	extract($_POST);
    	if(!isset($_SESSION["MEMBER_id"]))
    	{
    		$this->error("登录后才能绑定本地帐户！");
    	}else if($pass!=$repass){
    		$this->error("两次密码输入不一致！");
    	}else if(strlen($pass) < 5 || strlen($pass) > 12){
    		$this->error("密码长度至少5位，最多12位！");
    	}else{
    		$result = M('Members')->where("user_login_name='$name' or user_email='$email'")->count();
    		if($result){
    			$this->error("用户名或者该邮箱已经存在！");
    		}else{
    			$data=array(
    					'user_login_name' => $name,
    					'user_email' => $email,
    					'user_pass' => sp_password($pass),
    					'last_login_ip' => get_client_ip(),
    					'create_time' => time(),
    					'last_login_time' => time(),
    					'user_status' => '1',
    			);
    			if(M('Members')->where('ID='.$_SESSION["MEMBER_id"])->save($data))
    				$this->success("绑定本地帐户成功！");
    			else 
    				$this->error("绑定本地帐户失败！");
    		}
    	}
    }
    
    //退出
    public function logout(){
    	session_destroy();
    	$this->redirect("portal/index/index");
    }
    
    //修改密码
    function changepass(){
    	if (IS_POST) {
    		if($_POST['pass'] != $_POST['repass']){
    			$this->error("两次密码输入不一致！");
    			exit();
    		}
    		if(strlen($_POST['pass']) < 5 || strlen($_POST['pass']) > 12){
    			$this->error("密码长度至少5位，最多12位！");
    			exit();
    		}
    		$mem = M('Members');
    		$uid = $_SESSION["MEMBER_id"];
    			
    		$user_info=$mem->where("ID=$uid")->find();
    		$old_password=$_POST['inipass'];
    		$password=$_POST['pass'];
    		if(sp_password($old_password)==$user_info['user_pass']){
    			if($user_info['user_pass']==sp_password($password)){
    				$this->error("新密码不能和原密码相同！");
    			}else{
    				$data['user_pass']=sp_password($password);
    				$data['ID']=$uid;
    				$r=$mem->save($data);
    				if ($r) {
    					$this->success("修改成功！");
    				} else {
    					$this->error("修改失败！");
    				}
    					
    			}
    		}else{
    			$this->error("原密码不正确！");
    		}
    	} else {
    		$this->error('提交数据为空！');
    	}
    }
}
?>
