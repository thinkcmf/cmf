<?php

/**
 */
class PublicAction extends AdminbaseAction {

    function _initialize() {
    }

    //后台登陆界面
    public function login() {
        $this->display();
    }
    
    public function logout(){
    	unset($_SESSION['ADMIN_ID']);
    	$this->redirect("public/login");
    }
    
    public function dologin(){
    	$name = $_POST['username'];
    	$pass = $_POST['password'];
    	$verrify = $_POST['verify'];
    	//验证码
    	if($_SESSION['_verify_']['verify']!=strtolower($_POST['verify']))
    	{
    		$this->error("验证码错误！");//error方法暂不能用
    	}else{
    		$user = new UsersModel();
    		$result = $user->getUserByName($name);
    		if($result != null)
    		{
    			if($result['user_pass'] == sp_password($pass))
    			{
    				//登入成功页面跳转
    				$_SESSION["ADMIN_ID"]=$result["ID"];
    				$_SESSION['name']=$result["user_login"];
    				session("roleid",$result['role_id']);
    				$result['last_login_ip']=get_client_ip();
    				$result['last_login_time']=date("Y-m-d H:i:s");
    				$user->save($result);
    				$this->success("登录验证成功！",U("Index/index"));
    			}else{
    				$this->error("密码错误！");
    			}
    		}else{
    			$this->error("用户名不存在！");
    		}
    	}
    }

    public function verifycode() {
    	import("Util.Checkcode", LIB_PATH);
    	$checkcode = new Checkcode();
    	if (isset($_GET['code_len']) && intval($_GET['code_len']))
    		$checkcode->code_len = intval($_GET['code_len']);
    	if ($checkcode->code_len > 8 || $checkcode->code_len < 2) {
    		$checkcode->code_len = 4;
    	}
    	//强制验证码不得小于4位
    	if($checkcode->code_len < 4){
    		$checkcode->code_len = 4;
    	}
    	if (isset($_GET['font_size']) && intval($_GET['font_size']))
    		$checkcode->font_size = intval($_GET['font_size']);
    	if (isset($_GET['width']) && intval($_GET['width']))
    		$checkcode->width = intval($_GET['width']);
    	if ($checkcode->width <= 0) {
    		$checkcode->width = 130;
    	}
    	if (isset($_GET['height']) && intval($_GET['height']))
    		$checkcode->height = intval($_GET['height']);
    	if ($checkcode->height <= 0) {
    		$checkcode->height = 50;
    	}
    	if (isset($_GET['font_color']) && trim(urldecode($_GET['font_color'])) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($_GET['font_color']))))
    		$checkcode->font_color = trim(urldecode($_GET['font_color']));
    	if (isset($_GET['background']) && trim(urldecode($_GET['background'])) && preg_match('/(^#[a-z0-9]{6}$)/im', trim(urldecode($_GET['background']))))
    		$checkcode->background = trim(urldecode($_GET['background']));
    	$checkcode->doimage();
    
    	//验证码类型
    	$type = $this->_get("type");
    	$type = $type?strtolower($type):"verify";
    	$verify = session("_verify_");
    	if(empty($verify)){
    		$verify = array();
    	}
    	$verify[$type] = $checkcode->get_code();
    	session("_verify_",$verify);
    }
    

}

?>
