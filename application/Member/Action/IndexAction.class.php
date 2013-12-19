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
    				$this->success("登录验证成功！",U("Index/index"));
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
    	if($_SESSION['_verify_']['verify']!=strtolower($verify))
    	{
    		$this->error("验证码错误！");
    	}else if($pass!=$repass){
    		$this->error("两次密码输入不一致！");
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
    			$_SESSION["MEMBER_ID"]=$rst;
    			$_SESSION['MEMBER_name']=$name;
    			$this->success("注册成功！",U("Index/index"));
    		}
    	}
    }
    
    public function logout(){
    	session_destroy();
    	$this->redirect("portal/index/index");
    }
}
?>
