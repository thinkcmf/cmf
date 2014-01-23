<?php

/**
 * 会员中心
 */
class CenterAction extends HomeBaseAction {
	function _initialize(){
		parent::_initialize();
		if(!isset($_SESSION["MEMBER_id"])){
			$this->error('您还没有登录！', U('Member/index/index'));
		}else if($_SESSION["MEMBER_status"] == 2 && C('SP_MEMBER_EMAIL_ACTIVE')=='true'){
			$this->error('您的账号需要激活才能使用', U('Member/index/disable'));
		}
		if(!C('THIRD_UDER_ACCESS') && $_SESSION["MEMBER_type"]!='local'){ //第三方用户拥有低于本地帐户的权限
			$this->error("您需要绑定本地账号才能获取更多权限！", U('Member/index/bang'));
		}else{
			$_SESSION["MEMBER_access"] = 'total';
			if(isset($_SESSION['before_login_url'])){ //登陆前已指定跳转地址
				$goUrl = $_SESSION['before_login_url'];
				unset($_SESSION['before_login_url']);
				$this->success("正在跳转...！", $goUrl);
			}
		}
	}
    //会员中心
	public function index() {
		$memid = $_SESSION["MEMBER_id"];
		$DbPre = C('DB_PREFIX');
		//个人信息
		$user_info = M('Members')->where("ID=".$memid)->find();
		$this->assign('user_info', $user_info);
		//收藏记录
		$sql = 'select b.*
				from '.$DbPre.'topic_collect a
				left join '.$DbPre.'topic b
				using(topic_id)
				where user_id='.$memid
				.' order by a.collect_time';
		$collection = M()->query($sql);
		$this->assign('collect', $collection);
		//账号绑定
		$OauthMember = M('OauthMember');
		$lock['qq'] = $OauthMember->where("status=1 and _from='qq' and lock_to_id=".$memid)->count();
		$lock['sina'] = $OauthMember->where("status=1 and _from='sina' and lock_to_id=".$memid)->count();
		$this->assign('lock', $lock);
		//消息列表
		$this->assign('mesComment', $count1=getMes($memid, 'topic_comment'));
		$this->assign('mesAnswer', $count2=getMes($memid, 'topic_answer'));
		$this->assign('mesCollect', $count3=getMes($memid, 'topic_collect'));
		$this->assign('mesCount', intval($count1 && count($count1))+intval($count2 && count($count2))+intval($count3 && count($count3)));
    	$this->display(':center');
    }
    
    //修改签名
    function changesign(){
    	if(strlen($sign = strip_tags($_POST['sign_'])) > 100){
    		$this->error('签名字数限制100个字符！');
    		exit;
    	};
    	if(M('Members')->where("ID=".$_SESSION["MEMBER_id"])->setField('sign_words',$sign)){
    		$this->success('签名修改成功！');
    	}else{
    		$this->error('签名修改失败！');
    	}
    }
    
    //修改头像
    function changeHead(){
    	import('ORG.Net.UploadFile');
    	$upload = new UploadFile();
    	$upload->maxSize  = 11048576 ;
    	$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');
    	$upload->savePath =  C("UPLOADPATH");
    	$upload->thumb = true;
    	$upload->thumbMaxWidth = "120";
    	$upload->thumbMaxHeight = "120";
    	$upload->thumbRemoveOrigin = true;
    	$upload->saveRule='uniqid';
    	if(!$upload->upload()) {
    		$this->error($upload->getErrorMsg(), U('Member/center/index'));
    	}else{
    		$info =  $upload->getUploadFileInfo();
    		//添加
    		$data = array(
    				'_unique' => uniqid(),
    				'filename' => 'thumb_'.$info[0]['savename'],
    				'filepath' => C("UPLOADPATH"),
    				'uploadtime' => time(),
    				'status' => '1',
    		);
    		$head_url = '/index.php?g=asset&m=download&key='.$data['_unique'];
    		$memdo = M('Members')->where('ID='.$_SESSION["MEMBER_id"])->setField('user_pic_url', $head_url);
    		//dump($head_url);dump($memdo);
    		if(M("Asset")->add($data) && $memdo){
    			$this->success('头像修改成功！');
    		}else{
    			$this->error('头像修改失败！');
    		}
    	}
    }
}
?>
