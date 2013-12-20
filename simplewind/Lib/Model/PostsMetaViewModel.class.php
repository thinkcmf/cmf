<?php
/**
 * 
 * @author zxxjj
 * 表posts及postmeta的ViewModal
 *
 */
class PostsMetaViewModel extends ViewModel{
	public $viewFields = array(
			'Posts'=>array('ID','post_author'=>'author','post_date'=>'date','post_content'=>'content',
			'post_title'=>'title','post_excerpt'=>'excerpt','post_status'=>'status','comment_status','post_modified'=>
			'modified','post_type'=>'type'),
			'Postmeta'=>array('meta_id','meta_key'=>'mkey','meta_value'=>'value','_on'=>'Postmeta.post_id=Posts.ID'),
	);
	
	
	
}