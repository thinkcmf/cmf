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
    				$_SESSION["MEMBER_status"]=$result["user_status"];
    				$_SESSION["MEMBER_type"]='local';
    				$_SESSION["MEMBER_id"]=$result["ID"];
    				$_SESSION['MEMBER_name']=$result["user_login_name"];
    				session("roleid", $result['role_id']);
    				//写入此次登录信息
    				$data = array(
    						'last_login_time' => time(),
    						'last_login_ip' => get_client_ip(),
    				);
    				M('Members')->where("ID=".$result["ID"])->save($data);
    				$this->success("登录验证成功！", U("Member/center/index"));
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
    		$where['user_login_name']=$name;
    		$where['user_email']=$email;
    		$where['_logic'] = 'OR';
    		$result = M('Members')->where($where)->count();
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
    					'user_status' => '2',
    			);
    			$rst = M('Members')->add($data);
    			//登入成功页面跳转
    			$_SESSION["MEMBER_type"]='local';
    			$_SESSION["MEMBER_id"]=$rst;
    			$_SESSION['MEMBER_name']=$name;
    			$_SESSION['MEMBER_status']='2';
    			//发送激活邮件
    			self::_send_to_active();
    			$this->success("注册成功！",U("Member/center/index"));
    		}
    	}
    }
    
    //绑定本地账号
    function bang(){
    	$this->display(":bang");
    }
    
    //提交 绑定本地账号
    function dobang(){
    	extract($_POST);
    	//用户名需过滤的字符的正则
    	$stripChar = '?<*.>\'\"';
    	if(!isset($_SESSION["MEMBER_id"]))
    	{
    		$this->error("登录后才能绑定本地帐户！");
    	}else if($pass!=$repass){
    		$this->error("两次密码输入不一致！");
    	}else if(preg_match('/['.$stripChar.']/is', $name)==1){
    		$this->error('用户名中包含'.$stripChar.'等非法字符！');
    	}else if(strlen($pass) < 5 || strlen($pass) > 12){
    		$this->error("密码长度至少5位，最多12位！");
    	}else{
    		$where['user_login_name']=$name;
    		$where['user_email']=$email;
    		$where['_logic'] = 'OR';
    		$result = M('Members')->where($where)->count();
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
    			if(M('Members')->where('ID='.$_SESSION["MEMBER_id"])->save($data)){
    				$_SESSION["MEMBER_type"] = 'local';
    				$this->success("绑定本地帐户成功！", U("Member/center/index"));
    			}else 
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
    				if ($r!=false) {
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
    
    //账号激活页
    function disable(){
    	if(!isset($_SESSION["MEMBER_id"])){
    		$this->error('您还没有登录', U('Member/index/index'));
    	}else if($_SESSION["MEMBER_status"] != 2){
    		$this->error('您的账号不需要激活');
    	}
    	if($_GET['control'] == 'sendmail'){
    		$rst = self::_send_to_active();
    		if($rst){
    			$this->ajaxReturn(1, '邮件发送成功！', 1);
    		}else{
    			$this->ajaxReturn(2, '邮件发送失败！', 0);
    		}
    	}else{
    		$addr = M('Members')->where('ID='.$_SESSION["MEMBER_id"])->getField('user_email');
    		$addr_arr = split('@', $addr);
    		//注册邮箱的登录地址
    		$mail_login_addr = 'http://mail.'.$addr_arr[1];
    		$this->assign('goto', $mail_login_addr);
    		$this->display(":disable");
    	}
    }
    
    //发送邮件
    private function _send_to_active(){
    	$option = M('Options')->where(array('option_name'=>'member_email_active'))->find();
    	if(!$option){
    		$this->error('网站未配置账号激活信息，请联系网站管理员');
    	}
    	$options = json_decode($option['option_value'], true);
    	//邮件标题
    	$title = $options['title'];
    	$rst = M('Members')->where("ID=".$_SESSION['MEMBER_id'])->find();
    	$data = array(
    			'uid' => $_SESSION['MEMBER_id'],
    			'type'=> 'active',
    	);
    	$data['hash'] = sha1($data['uid'].$rst['create_time']);
    	//生成激活链接
    	$url = U('Member/Index/active',$data, true, false, true);
    	//邮件内容
    	$template = $options['template'];
    	$content = str_replace(array('http://#link#','#username#'), array($url,$rst['user_login_name']),$template);
    	return SendMail($rst['user_email'], $title, $content);
    }
    
    //账号激活处理
    function active(){
    	$uid = intval($_GET['uid']);
    	$hash = $_GET['hash'];
    	$line = M('Members')->where("ID=".$uid)->find();
    	if(sha1($uid.$line['create_time']) != $hash){
    		$this->error('激活链接无效！');
    	}
    	if($line['user_status']==1){
    		$this->error('您的账户不需要激活！');
    	}else if($line['user_status']==2){
    		$rst = M('Members')->where("ID=".$uid)->setField('user_status',1);
    		if($rst){
    			$_SESSION['MEMBER_status']='1';
    			$this->success('账号激活成功', U("Member/center/index"));
    		}else{
    			$this->error('未知错误，请联系网站管理员！');
    		}
    	}else{
    		$this->error('账户不存在！');
    	}
    }
}
?>
