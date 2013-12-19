<?php
/**
 * 参    数：
 * 作    者：lht
 * 功    能：OAth2.0协议下第三方登录数据报表
 * 修改日期：2013-12-13
 */

class OauthadminAction extends AdminbaseAction {
	
	//用户列表
	function index(){
		$rst = M('OauthMember')->where("status=1")->select();
		$this->assign('lists', $rst);
		//dump($rst);die;
		$this->display();
	}
	
	//删除用户
	function delete(){
		$id=intval($_GET['id']);
		if ($id) {
			$rst = M("OauthMember")->where("status=1 and ID=$id")->setField('status','0');
			if ($rst) {
				$this->success("保存成功！", U("oauthadmin/index"));
			} else {
				$this->error('会员删除失败！');
			}
		} else {
			$this->error('数据传入失败！');
		}
	}
	
	//设置
	function setting(){
		$oauth_config_file="conf/ThinkSDK.config.php";
		if($_POST){
			$h='$_SERVER["HTTP_HOST"]';
			extract($_POST);
			$con =  <<<OAUTH
<?php
define('URL_CALLBACK', 'http://'.$h.'/index.php?g=api&m=oauth&a=callback&type=');
return array(
	'THINK_SDK_QQ' => array(
		'APP_KEY'    => '$qq_key',
		'APP_SECRET' => '$qq_sec',
		'CALLBACK'   => URL_CALLBACK . 'qq',
	),
	'THINK_SDK_SINA' => array(
		'APP_KEY'    => '$sina_key', 
		'APP_SECRET' => '$sina_sec',
		'CALLBACK'   => URL_CALLBACK . 'sina',
	),
);
?>
OAUTH;
			
			$fp = fopen($oauth_config_file, 'wb');
			chmod($oauth_config_file, 0777);
			$result	= fwrite($fp, trim($con));
			@fclose($fp);
			if($result) $this->success("更新成功！");
			else $this->error("更新失败！");
			exit;
		}
		$this->display();
	}
}