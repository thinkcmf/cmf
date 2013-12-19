<?php

/**
 * 会员注册登录
 */
class IndexadminAction extends AdminbaseAction {
    function index(){
    	$lists = M("Members")->where("user_status=1")->select();
    	$this->assign('lists', $lists);
    	$this->display(":index");
    }
    
    function delete(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = M("Members")->where("user_status=1 and ID=$id")->setField('user_status','0');
    		if ($rst) {
    			$this->success("保存成功！", U("indexadmin/index"));
    		} else {
    			$this->error('会员删除失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    	
    }
}
?>
