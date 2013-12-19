<?php
/**
 * 参    数：
 * 作    者：lht
 * 功    能：结合ThinkSDK完成腾讯,新浪微博,人人等用户的第三方登录
 * 修改日期：2013-12-11
 */

class OauthAction extends Action {
	
	function _initialize() {
	}
	
	//登录地址
	public function login($type = null){
		empty($type) && $this->error('参数错误');

		//加载ThinkOauth类并实例化一个对象
		import("ThinkSDK");
		$sns  = ThinkOauth::getInstance($type);
		
		//die(URL_CALLBACK);
		//跳转到授权页面
		redirect($sns->getRequestCodeURL());
	}
	
	//授权回调地址
	public function callback($type = null, $code = null){
		header('content-type:text/html;charset=UTF-8;');
		(empty($type) || empty($code)) && $this->error('参数错误');
	
		//加载ThinkOauth类并实例化一个对象
		import("ThinkSDK");
		$sns  = ThinkOauth::getInstance($type);
	
		//腾讯微博需传递的额外参数
		$extend = null;
		if($type == 'tencent'){
			$extend = array('openid' => $this->_get('openid'), 'openkey' => $this->_get('openkey'));
		}
	
		//请妥善保管这里获取到的Token信息，方便以后API调用
		//调用方法，实例化SDK对象的时候直接作为构造函数的第二个参数传入
		//如： $qq = ThinkOauth::getInstance('qq', $token);
		$token = $sns->getAccessToken($code , $extend);
		//die($token);
		//获取当前登录用户信息
		if(is_array($token)){
			$user_info = A('Type', 'Event')->$type($token);
			$OMember = M('OauthMember');
			if($rst = $OMember->where("_from='{$type}' and openid='{$token['openid']}' and status=1")->find()){
				//数据库已经有该用户登录信息
				$data=array(
						'last_login_time' => time(),
						'last_login_ip' => get_client_ip(),
						'login_times' => $rst['login_times']+1,
						'access_token' => $token['access_token'],
						'expires_date' => (int)(time()+$token['expires_in']),
				);
				$OMember->where("_from='{$type}' and openid='{$token['openid']}'")->save($data);
				$_SESSION["MEMBER_type"]=$type;
				$_SESSION["MEMBER_id"]=$token['openid'];
				$_SESSION['MEMBER_name']=$rst["_name"];
				$this->success('登录成功！',U("Portal/index/index"));
			}else if($OMember->where("_from='{$type}' and openid='{$token['openid']}' and status=0")->find()){
				$this->error('您可能已经被列入黑名单，请联系网站管理员！',U("Portal/index/index"));
			}else{
				$data = array(
						'_from' => $type,
						'_name' => $user_info['name'],
						'head_img' => $user_info['head'],
						'create_time' => time(),
						'last_login_time' => time(),
						'last_login_ip' => get_client_ip(),
						'login_times' => 1,
						'status' => 1,
						'access_token' => $token['access_token'],
						'expires_date' => (int)(time()+$token['expires_in']),
						'openid' => $token['openid'],
				);
				if($OMember->add($data)){
					$_SESSION["MEMBER_type"]=$type;
					$_SESSION["MEMBER_id"]=$token['openid'];
					$_SESSION['MEMBER_name']=$user_info['name'];
					$this->success('登录成功！',U("Portal/index/index"));
				}else{
					$this->success('用户信息获取失败！',U("Portal/index/index"));
				}
			}
		}else{
			$this->success('登录失败！',U("Portal/index/index"));
		}
	}
}