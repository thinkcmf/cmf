<?php
/**
 * 1
 * 根据广告名称获取广告内容
 * @param string $ad
 * @return 广告内容
 */

function sp_getad($ad){
	$ad_obj=new AdModel();
	$ad=$ad_obj->field("ad_content")->where("ad_name='$ad'")->find();
	return $ad['ad_content'];
}

/**
 * 2
 * 根据幻灯片标识获取所有幻灯片
 * @param string $slide 幻灯片标识
 * @return array;
 */
function sp_getslide($slide){
	$slide_obj=new SlideCatModel();
	$join = "".C('DB_PREFIX').'slide as b on '.C('DB_PREFIX').'slide_cat.cid =b.slide_cid';
	return $slide_obj->join($join)->where("cat_idname='$slide'")->select();

}

/**
 * 3
 * 获取所有友情连接
 * @return array
 */
function sp_getlinks(){
	$links_obj=new LinksModel();
	return  $links_obj->where("link_status=1")->select();
}


/**
 * 4
 * @处理标签函数
 * @以字符串方式传入,通过sp_param_lable函数解析为以下变量
 * ids:调用指定ID的一个或多个数据,如 1,2,3
 * cid:数据所在分类,可调出一个或多个分类数据,如 1,2,3 默认值为全部,在当前分类为:'.$cid.'
 * field:调用post指定字段,如(id,post_title...) 默认全部
 * limit:数据条数,默认值为10,可以指定从第几条开始,如3,8(表示共调用8条,从第3条开始)
 * order:推荐方式(post_date) (desc/asc/rand())
 */
function sp_sql_posts($tag){
	$where=array();
	$tag=sp_param_lable($tag);
	$field = !empty($tag['field']) ? $tag['field'] : '*';
	$limit = !empty($tag['limit']) ? $tag['limit'] : '10';
	$order = !empty($tag['order']) ? $tag['order'] : 'post_date';


	//根据参数生成查询条件
	$where['status'] = array('eq',1);
	$where['post_status'] = array('eq',1);

	if (isset($tag['cid'])) {
		$where['term_id'] = array('in',$tag['cid']);
	}
	
	if (isset($tag['ids'])) {
		$where['object_id'] = array('in',$tag['ids']);
	}


	$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.ID';
	$join2= "".C('DB_PREFIX').'users as c on b.post_author = c.ID';
	$rs=new TermRelationshipsModel();

	$posts=$rs->alias("a")->join($join)->join($join2)->field($field)->where($where)->order($order)->limit($limit)->select();
	return $posts;
}

/**
 * 4
 * @ 处理标签函数
 * @ $tag以字符串方式传入,通过sp_param_lable函数解析为以下变量。例："cid:1,2;order:post_date desc,listorder desc;"
 * ids:调用指定ID的一个或多个数据,如 1,2,3
 * cid:数据所在分类,可调出一个或多个分类数据,如 1,2,3 默认值为全部,在当前分类为:'.$cid.'
 * field:调用post指定字段,如(id,post_title...) 默认全部
 * limit:数据条数,默认值为10,可以指定从第几条开始,如3,8(表示共调用8条,从第3条开始)
 * order:推荐方式(post_date) (desc/asc/rand())
 */

function sp_sql_posts_paged($tag,$pagesize=20,$pagetpl='{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}'){
	$where=array();
	$tag=sp_param_lable($tag);
	$field = !empty($tag['field']) ? $tag['field'] : '*';
	$limit = !empty($tag['limit']) ? $tag['limit'] : '10';
	$order = !empty($tag['order']) ? $tag['order'] : 'post_date';


	//根据参数生成查询条件
	$where['status'] = array('eq',1);
	$where['post_status'] = array('eq',1);

	if (isset($tag['cid'])) {
		$where['term_id'] = array('in',$tag['cid']);
	}

	if (isset($tag['ids'])) {
		$where['object_id'] = array('in',$tag['ids']);
	}

	$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.ID';
	$join2= "".C('DB_PREFIX').'users as c on b.post_author = c.ID';
	$rs=new TermRelationshipsModel();
	$totalsize=$rs->alias("a")->join($join)->join($join2)->field($field)->where($where)->count();
	
	import('Page');
	if ($pagesize == 0) {
		$pagesize = 20;
	}
	$PageParam = C("VAR_PAGE");
	$page = new Page($totalsize,$pagesize);
	$page->setLinkWraper("li");
	$page->SetPager('default', $pagetpl, array("listlong" => "6", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
	$posts=$rs->alias("a")->join($join)->join($join2)->field($field)->where($where)->order($order)->limit($page->firstRow . ',' . $page->listRows)->select();

	$content['posts']=$posts;
	$content['page']=$page->show('default');
	return $content;
}



/**
 * 5
 * @param int $tid 分类表下的tid.
 * @param string $tag 
 * @处理标签函数
 * @以字符串方式传入,通过sp_param_lable函数解析为以下变量
 * field:调用post指定字段,如(id,post_title...) 默认全部
 * 如：field:post_title;
 * @return array 返回指定id所有页面
 */
function sp_sql_post($tid,$tag){
	$where=array();
	$tag=sp_param_lable($tag);
	$field = !empty($tag['field']) ? $tag['field'] : '*';


	//根据参数生成查询条件
	$where['status'] = array('eq',1);
	$where['tid'] = array('eq',$tid);


	$join = "".C('DB_PREFIX').'posts as b on a.object_id =b.ID';
	$join2= "".C('DB_PREFIX').'users as c on b.post_author = c.ID';
	$rs=new TermRelationshipsModel();

	$posts=$rs->alias("a")->join($join)->join($join2)->field($field)->where($where)->find();
	return $posts;
}

/**
 * 6
 * @处理标签函数
 * @以字符串方式传入,通过sp_param_lable函数解析为以下变量
 * 返回符合条件的所有页面
 * ids:调用指定ID的一个或多个数据,如 1,2,3
 * field:调用post指定字段,如(id,post_title...) 默认全部
 * limit:数据条数,默认值为10,可以指定从第几条开始,如3,8(表示共调用8条,从第3条开始)
 * order:推荐使用方式(post_date) (desc/asc/rand())
 * 使用：ids:1,2;field:post_date,post_content;limit:10;order:post_date DESC,ID;
 */
function sp_sql_pages($tag){
	$where=array();
	$tag=sp_param_lable($tag);
	$field = !empty($tag['field']) ? $tag['field'] : '*';
	$limit = !empty($tag['limit']) ? $tag['limit'] : '10';
	$order = !empty($tag['order']) ? $tag['order'] : 'post_date';


	//根据参数生成查询条件
	$where['post_status'] = array('eq',1);
	$where['post_type'] = array('eq',2);

	$rs=new PostsModel();

	$posts=$rs->field($field)->where($where)->order($order)->limit($limit)->select();
	return $posts;
}

/**
 * 7
 * @处理标签函数
 * @以字符串方式传入,通过sp_param_lable函数解析为以下变量
 * 返回指定ID=$ID的页面
 */
function sp_sql_page($ID){
	$where=array();
	$where['ID'] = array('eq',$ID);

	$rs=new PostsModel();

	$post=$rs->where($where)->find();
	return $post;
}


/**
 * 8
 * 返回指定分类
 */
function sp_get_term($term_id){
	
	$terms=F('all_terms');
	if(empty($terms)){
		$term_obj=new TermsModel();
		$terms=$term_obj->where("status=1")->select();
		$mterms=array();
		
		foreach ($terms as $t){
			$tid=$t['term_id'];
			$mterms["t$tid"]=$t;
		}
		
		F('all_terms',$mterms);
		return $mterms["t$term_id"];
	}else{
		return $terms["t$term_id"];
	}
}
/**
 * 9
 * @处理标签函数
 * @以字符串方式传入,通过sp_param_lable函数解析为以下变量
 * 返回符合条件的所有分类
 * ids:调用指定ID的一个或多个数据,如 1,2,3
 * field:调用post指定字段,如(id,post_title...) 默认全部
 * limit:数据条数,默认值为10,可以指定从第几条开始,如3,8(表示共调用8条,从第3条开始)
 * order:path (desc/asc/rand())
 * 使用：ids:1,2;field:post_date,post_content;limit:10;order:post_date DESC,ID;
 */
function sp_get_terms($tag){
	
	$where=array();
	$tag=sp_param_lable($tag);
	$field = !empty($tag['field']) ? $tag['field'] : '*';
	$limit = !empty($tag['limit']) ? $tag['limit'] : '10';
	$order = !empty($tag['order']) ? $tag['order'] : 'term_id';
	
	//根据参数生成查询条件
	$where['status'] = array('eq',1);
	
	if (isset($tag['ids'])) {
		$where['term_id'] = array('in',$tag['ids']);
	}
	
	$term_obj=new TermsModel();
	$terms=$term_obj->field($field)->where($where)->order($order)->limit($limit)->select();
	return $terms;
}

//截取n个字符,$stripTags是否剥去html标签
function cutStr($str,$n,$stripTags=true){
	if($stripTags){
		return mb_substr(strip_tags(htmlspecialchars_decode($str)),0,$n,'utf-8');
	}else{
		return mb_substr(htmlspecialchars_decode($str),0,$n,'utf-8');
	}
}


