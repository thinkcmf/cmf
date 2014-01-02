<?php


function get_current_admin_id(){
	return $_SESSION['ADMIN_ID'];
}
function sp_password($pw){
	$decor=md5(C('DB_PREFIX'));
	$mi=md5($pw);
	return substr($decor,0,12).$mi.substr($decor,-4,4);
}

function sp_random_string($len = 6) {
	$chars = array(
			"a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
			"l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
			"w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
			"H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
			"S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
			"3", "4", "5", "6", "7", "8", "9"
	);
	$charsLen = count($chars) - 1;
	shuffle($chars);    // 将数组打乱
	$output = "";
	for ($i = 0; $i < $len; $i++) {
		$output .= $chars[mt_rand(0, $charsLen)];
	}
	return $output;
}

/**
 * 清空缓存
 */

function sp_clear_cache(){
		import ( "ORG.Util.Dir" );
		$dirs = array ();
		// runtime/
		$rootdirs = scandir ( RUNTIME_PATH );
		//$noneed_clear=array(".","..","Data");
		$noneed_clear=array(".","..");
		$rootdirs=array_diff($rootdirs, $noneed_clear);
		foreach ( $rootdirs as $dir ) {
			
			if ($dir != "." && $dir != "..") {
				$dir = RUNTIME_PATH . $dir;
				if (is_dir ( $dir )) {
					array_push ( $dirs, $dir );
					$tmprootdirs = scandir ( $dir );
					foreach ( $tmprootdirs as $tdir ) {
						if ($tdir != "." && $tdir != "..") {
							$tdir = $dir . '/' . $tdir;
							if (is_dir ( $tdir )) {
								array_push ( $dirs, $tdir );
							}
						}
					}
				}
			}
		}
		$dirtool=new Dir("");
		foreach ( $dirs as $dir ) {
			$dirtool->del ( $dir );
		}
	
}

/**
 * 保存变量
 */
function sp_save_var($path,$value){
	if(IS_SAE){
		$kv = new SaeKV();
		$ret = $kv->init();
		$kv->delete('DYNAMIC_CONFIG');
		$ret = $kv->set('DYNAMIC_CONFIG', serialize($value));
	}else{
		file_put_contents($path, "<?php\treturn " . var_export($value, true) . ";?>");
	}
}

/**
 * 生成上传附件验证
 * @param $args   参数
 */
function upload_key($args) {
	$auth_key = md5(C("AUTHCODE") . $_SERVER['HTTP_USER_AGENT']);
	$authkey = md5($args . $auth_key);
	return $authkey;
}

/**
 * 生成参数列表,以数组形式返回
 */
function sp_param_lable($tag = ''){
	$param = array();
	$array = explode(';',$tag);
	foreach ($array as $v){
		list($key,$val) = explode(':',trim($v));
		$param[trim($key)] = trim($val);
	}
	return $param;
}


/**
 * 
 */

function get_site_options(){
	$options_obj=new OptionsModel();
	
	$option=$options_obj->where("option_name='site_options'")->find();
	if($option){
		return (array)json_decode($option['option_value']);
	}else{
		return array();
	}
	
}




/**
 * 全局获取验证码图片
 * 生成的是个HTML的img标签
 * @param string $imgparam 
 * 生成图片样式，可以设置
 * code_len=4&font_size=20&width=238&height=50&font_color=#ffffff&background=#000000
 * code_len:字符长度
 * font_size:字体大小
 * width:生成图片宽度
 * heigh:生成图片高度
 * font_color:字体颜色
 * background:图片背景
 * @param string $imgattrs
 * img标签原生属性，除src,onclick之外都可以设置
 * 默认值：style="cursor: pointer;" title="点击获取"
 * @return string
 * 原生html的img标签
 * 注，此函数仅生成img标签，应该配合在表单加入name=verify的input标签
 * 如：<input type="text" name="verify"/>
 */
function sp_verifycode_img($imgparam='code_len=4&font_size=20&width=238&height=50&font_color=&background=',$imgattrs='style="cursor: pointer;" title="点击获取"'){
	$src=U('Api/Checkcode/index',$imgparam);
	$img=<<<hello
<img  src="$src" onclick="this.src='$src&time='+Math.random();" $imgattrs/>
hello;
	return $img;
}

/**
 * 此方法只能在模板里使用,在action方法里使用会有问题
 * @param string $tplname
 */
function sp_show_comment($tplname="comment.default"){
	$_index = A('Comment/_index');
	echo $_index->showtpl();
}


/**
 * flash上传初始化
 * 初始化swfupload上传中需要的参数
 * @param $module 模块名称
 * @param $catid 栏目id
 * @param $args 传递参数
 * @param $userid 用户id
 * @param $groupid 用户组id 默认游客
 * @param $isadmin 是否为管理员模式
 */
function initupload($module, $catid, $args, $userid, $groupid = '8', $isadmin = false) {
	//检查用户组上传权限
// 	if (!$isadmin) {
// 		$Member_group = F("Member_group");
// 		if ((int) $Member_group[$groupid]['allowattachment'] < 1 || empty($Member_group)) {
// 			return false;
// 		}
// 	}

	$sess_id = time();
	$swf_auth_key = md5(C("AUTHCODE") . $sess_id);

	//同时允许的上传个数, 允许上传的文件类型, 是否允许从已上传中选择, 图片高度, 图片宽度,是否添加水印1是
	$args = explode(',', $args);
	//参数补充完整
	if (empty($args[1])) {
		//如果允许上传的文件类型为空，启用网站配置的 uploadallowext
		if ($isadmin) {
			$args[1] = CONFIG_UPLOADALLOWEXT;
		} else {
			$args[1] = CONFIG_QTUPLOADALLOWEXT;
		}
	}
	//允许上传后缀处理
	$arr_allowext = explode('|', $args[1]);
	foreach ($arr_allowext as $k => $v) {
		$v = '*.' . $v;
		$array[$k] = $v;
	}
	$upload_allowext = implode(';', $array);

	//允许上传大小
	if ($isadmin) {
		$file_size_limit = intval(CONFIG_UPLOADMAXSIZE);
	} else {
		$file_size_limit = intval(CONFIG_QTUPLOADMAXSIZE);
	}
	//上传个数
	$file_upload_limit = intval($args[0]) ? intval($args[0]) : '8';

	$init = 'var swfu = \'\';
	$(document).ready(function(){
		Wind.use("swfupload",GV.DIMAUB+"statics/js/swfupload/handlers.js",function(){
		      swfu = new SWFUpload({
			flash_url:"' . CONFIG_SITEURL . 'statics/js/swfupload/swfupload.swf?"+Math.random(),
			upload_url:"' . CONFIG_SITEURL . 'index.php?m=Attachments&g=Attachment&a=swfupload",
			file_post_name : "Filedata",
			post_params:{
			                        "SWFUPLOADSESSID":"' . $sess_id . '",
			                        "module":"' . $module . '",
			                        "catid":"' . $catid . '",
			                        "uid":"' . $userid . '",
			                        "isadmin":"' . $isadmin . '",
			                        "groupid":"' . $groupid . '",
			                        "thumb_width":"' . intval($args[3]) . '",
			                        "thumb_height":"' . intval($args[4]) . '",
			                        "watermark_enable":"' . (($args[5] == '') ? 1 : intval($args[5])) . '",
			                        "filetype_post":"' . $args[1] . '",
			                        "swf_auth_key":"' . $swf_auth_key . '"
			},
			file_size_limit:"' . $file_size_limit . 'KB",
			file_types:"' . $upload_allowext . '",
			file_types_description:"All Files",
			file_upload_limit:"' . $file_upload_limit . '",
			custom_settings : {progressTarget : "fsUploadProgress",cancelButtonId : "btnCancel"},

			button_image_url: "",
			button_width: 75,
			button_height: 28,
			button_placeholder_id: "buttonPlaceHolder",
			button_text_style: "",
			button_text_top_padding: 3,
			button_text_left_padding: 12,
			button_window_mode: SWFUpload.WINDOW_MODE.TRANSPARENT,
			button_cursor: SWFUpload.CURSOR.HAND,

			file_dialog_start_handler : fileDialogStart,
			file_queued_handler : fileQueued,
			file_queue_error_handler:fileQueueError,
			file_dialog_complete_handler:fileDialogComplete,
			upload_progress_handler:uploadProgress,
			upload_error_handler:uploadError,
			upload_success_handler:uploadSuccess,
			upload_complete_handler:uploadComplete
		      });
		});
	})';
	return $init;
}


/**
 * 10
 * 返回指定id的菜单
 * 同上一类方法，jquery treeview 风格，可伸缩样式
 * @param $myid 表示获得这个ID下的所有子级
 * @param $effected_id 需要生成treeview目录数的id
 * @param $str 末级样式
 * @param $str2 目录级别样式
 * @param $showlevel 直接显示层级数，其余为异步显示，0为全部限制
 * @param $ul_class 内部ul样式 默认空  可增加其他样式如'sub-menu'
 * @param $li_class 内部li样式 默认空  可增加其他样式如'menu-item'
 * @param $style 目录样式 默认 filetree 可增加其他样式如'filetree treeview-famfamfam'
 * @param $dropdown 有子元素时li的class
 * $id="main";
 $effected_id="mainmenu";
 $filetpl="<a href='\$href'><span class='file'>\$label</span></a>";
 $foldertpl="<span class='folder'>\$label</span>";
 $ul_class="" ;
 $li_class="" ;
 $style="filetree";
 $showlevel=6;
 sp_get_menu($id,$effected_id,$filetpl,$foldertpl,$ul_class,$li_class,$style,$showlevel);
 * such as
 * <ul id="example" class="filetree ">
 <li class="hasChildren" id='1'>
 <span class='folder'>test</span>
 <ul>
 <li class="hasChildren" id='4'>
 <span class='folder'>caidan2</span>
 <ul>
 <li class="hasChildren" id='5'>
 <span class='folder'>sss</span>
 <ul>
 <li id='3'><span class='folder'>test2</span></li>
 </ul>
 </li>
 </ul>
 </li>
 </ul>
 </li>
 <li class="hasChildren" id='6'><span class='file'>ss</span></li>
 </ul>
 */
function sp_get_menu($id="main",$effected_id="mainmenu",$filetpl="<span class='file'>\$label</span>",$foldertpl="<span class='folder'>\$label</span>",$ul_class="" ,$li_class="" ,$style="filetree",$showlevel=6,$dropdown='hasChild'){
	$site_nav=F("site_nav_".$id);
	if(empty($site_nav)){
		$nav_obj=new NavModel();
		if($id=="main"){
			$navcat_obj=new NavCatModel();
			$main=$navcat_obj->where("active=1")->find();
			$id=$main['navcid'];
		}
		$navs= $nav_obj->where("cid=$id")->order(array("listorder" => "ASC"))->select();
		foreach ($navs as $key=>$nav){
			$href=$nav['href'];
			$hrefold=$href;
			$href=unserialize(stripslashes($nav['href']));
			if(empty($href)){
				if($hrefold=="home"){
					$href=__ROOT__."/";
				}else{
					$href=$hrefold;
				}
			}else{
				$default_app=strtolower(C("DEFAULT_GROUP"));
				$href=U($href['action'],$href['param']);
				$g=C("VAR_GROUP");
				$href=preg_replace("/\/$default_app\//", "/",$href);
				$href=preg_replace("/$g=$default_app&/", "",$href);
			}
			$nav['href']=$href;
			$navs[$key]=$nav;
		}
		F("site_nav",$navs);
	}
	
	import("Tree");
	$tree = new Tree();
	$tree->init($navs);
	return $tree->get_treeview_menu(0,$effected_id, $filetpl, $foldertpl,  $showlevel,$ul_class,$li_class,  $style,  1, FALSE, $dropdown);

}

/**
 * 11
 * @param string $content
 * @return array
 */
function sp_getcontent_imgs($content){
	import("phpQuery");
	phpQuery::newDocumentHTML($content);
	$pq=pq();
	$imgs=$pq->find("img");
	$imgs_data=array();
	if($imgs->length()){
		foreach ($imgs as $img){
			$img=pq($img);
			$im['src']=$img->attr("src");
			$im['title']=$img->attr("title");
			$im['alt']=$img->attr("alt");
			$imgs_data[]=$im;
		}
	}
	phpQuery::$documents=null;
	return $imgs_data;
}

/*
 * 作用：写入新消息
 * 参数：$from	发送者id
 * 		$to		消息接受者id
 * 		$content  消息内容
 * 		$targetid 相应数据表中的id的值
 * 		$mestype可选值：topic_comment(话题评论)、topic_answer(话题回复)、topic_collect(话题收藏)、topic_love(喜欢)
 */
function insertMes($from, $to, $content, $targetid, $mestype){
	$data = array(
			'mes_from'	=> $from,
			'mes_to'	=> $to,
			'mes_content' => $content,
			'post_time'	=> time(),
			'target_id'	=> $targetid,
			'mes_type'	=> $mestype,
			'mes_status'=> '2', //未读
	);
	return M('Message')->add($data);
}

/*
 * 作用：查看用户消息
 * 参数：$uid	查询用户id
 * 		$status		消息接受者id
 * 		$mestype可选值：topic_comment(话题评论)、topic_answer(话题回复)、topic_collect(话题收藏)、topic_love(喜欢)
 * 注意：查询时仅限于members,message,topic三张表，因此只能查询三张表中的信息
 */
function getMes($uid, $type, $status=2){
	$DbPre = C('DB_PREFIX');
	$topic_comment = M()->query('select a.*,b.user_login_name,b.ID,c.topic_id,c.topic_cid,c.title
    								from '.$DbPre.'message a
    								left join '.$DbPre.'members b
    								on a.mes_from=b.ID
    								left join '.$DbPre.'topic c
    								on a.target_id=c.topic_id
    								where a.mes_status='.$status.' and mes_type=\''.$type.'\' and a.mes_to='.$uid
									.' order by a.post_time desc');
	return $topic_comment;
}

//获取站内消息数量
function getMesNum(){
	if(!isset($_SESSION["MEMBER_id"])) return;
	return M('Message')->where('mes_status=2 and mes_to='.$_SESSION["MEMBER_id"])->count();
}
/**
 * 
 * @param unknown_type $navcatname
 * @param unknown_type $datas
 * @param unknown_type $navrule
 * @return string
 */
function sp_get_nav4admin($navcatname,$datas,$navrule){
	$nav['name']=$navcatname;
	$nav['urlrule']=$navrule;
	foreach($datas as $t){
		$urlrule=array();
		$group=strtolower(GROUP_NAME)==strtolower(C("DEFAULT_GROUP"))?"":GROUP_NAME."/";
		$action=$group.$navrule['action'];
		$urlrule['action']=GROUP_NAME."/".$navrule['action'];
		$urlrule['param']=array();
		if(isset($navrule['param'])){
			foreach ($navrule['param'] as $key=>$val){
				$urlrule['param'][$key]=$t[$val];
			}
		}
		
		$nav['items'][]=array(
				"label"=>$t[$navrule['label']],
				"url"=>U($action,$urlrule['param']),
				"rule"=>serialize($urlrule)
		);
	}
	return json_encode($nav);
}

function sp_get_apphome_tpl($tplname,$default_tplname,$default_theme=""){
	$theme      =    C('SP_DEFAULT_THEME');
	if(C('TMPL_DETECT_THEME')){// 自动侦测模板主题
		$t = C('VAR_TEMPLATE');
		if (isset($_GET[$t])){
			$theme = $_GET[$t];
		}elseif(cookie('think_template')){
			$theme = cookie('think_template');
		}
	}
	$theme=empty($default_theme)?$theme:$default_theme;
	$themepath=C("SP_TMPL_PATH").$theme."/".GROUP_NAME."/";
	$tplpath=$themepath.$tplname.C("TMPL_TEMPLATE_SUFFIX");
	$defaultpl=$themepath.$default_tplname.C("TMPL_TEMPLATE_SUFFIX");
	if(file_exists($tplpath)){
	}else if(file_exists($defaultpl)){
		$tplname=$default_tplname;
	}else{
		$tplname="404";
	}
	return $tplname;
}

//面包屑导航
function sp_bread_nav($nav_id){
	$navTable = M('Nav');
	$path = $navTable->where("id=$nav_id")->getField('path');
	if(!$path) return array();
	$path = str_replace('-',',',$path);
	$bread_path = $navTable->where("id in ($path)")->order('id')->select();
	return $bread_path;
}