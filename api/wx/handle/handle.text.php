<?php

global $postObj;

include_once HANDLE_DIR.'db.class.php';
include_once HANDLE_DIR.'tools.class.php';

//实例化数据库类并连接数据库
$db = new DB;
$db->open();

//用户消息
$data1 = array(
	'from' => $postObj->FromUserName,
	'to'	=> $postObj->ToUserName,
	'content' => trim($postObj->Content),
	'time'=> $postObj->CreateTime,
	'message_id' => $postObj->MsgId,
);
//消息存入数据库
$db->insert('wx_message_text', $data1);

//获取默认回复
$default_key = 'ANSWER_DEFAULT_'.round(rand(1,4));
$contentStr = $db->get_field("wx_config","_key='$default_key'","_value");

if(mb_substr($data1['content'], 0, 2, 'utf-8')=='天气'){ //天气查询
	$contentStr = getWeather($data1['content'], false);
}else if(mb_substr($data1['content'], 0, 2, 'utf-8')=='快递'){ //快递查询
	$contentStr = doGetKuaiDi($data1['content']);
}else if($db->count('wx_answer', "_key='{$data1['content']}'")>0){
	$contentStr = $db->get_field("wx_answer", "_key='{$data1['content']}'", "_value");
}else{//机器人查询
	$str = $data1['content'];
	$sql = "CONCAT(key1,key2,key3)<>'' and INSTR('$str',key1) and INSTR('$str',key2) and INSTR('$str',key3)  
			or (CONCAT(key1,key2,key3)='' and question='$str')";
	$answerStrThird =  $db->get_field("wx_answer_robot", $sql, "answer");
	if( $answerStrThird ){
		$contentStr = $answerStrThird;
	}
}

exit(Tools::answer_text($postObj->ToUserName, $data1['from'], $contentStr));