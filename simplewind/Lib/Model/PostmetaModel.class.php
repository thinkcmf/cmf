<?php
class PostmetaModel extends CommonModel{
	//GUYS meta_key的值定义在这里吧。格式“public static $metakey_+值='值';”记得加“文档注释”，可不能是一般的注释哟
	/**
	 * @var string 
	 *<BR>发表的图片的urls
	 */
	public static $metakey_imgurls='imgurls';
	/**
	 * 缩略图
	 */
	public static $thumbnail='thumbnail';
	/**
	 * 获取某个发表的meta
	 * @param int $post_id 某个发表的post_id
	 * @return array 数组结构<br>
	 * ('post_meta_id'=>'1',<br>
	 * 'the value of mkey 1'=>'the value of value 1',<br>
	 * 'the value of mkey 2'=>'the value of value 2',<br>
	 * ...<br>
	 * 'the value of mkey n'=>'the value of value n',<br>
	 * )
	 */
	function getMetasByPostID($post_id){
		$datas= $this->field('meta_key,meta_value')->where("post_id='$post_id'")->select();
		$formated_metas=array();
		foreach ($datas as $val){
			$formated_metas[$val['meta_key']]=$val['meta_value'];
		}
		
		return $formated_metas;
	}
	
	/**
	 * 添加一个post的meta
	 * @param int $post_id
	 * @param string $meta_key
	 * @param string $meta_value
	 * @param boolean $unique 表示这个值是否惟一
	 */
	function  addMeta($post_id,$meta_key,$meta_value,$unique=true){
		$data['post_id']=$post_id;
		$data['meta_key']=$meta_key;
		$data['meta_value']=$meta_value;
		if($unique){
			$hasMetaData=$this->where("post_id=$post_id and meta_key='$meta_key'")->find();
			dump($hasMetaData);
			if(empty($hasMetaData)){
				return $this->add($data);
			}else{
				$tmpMetaID=$hasMetaData['meta_id'];
				return $this->where("meta_id='$tmpMetaID'")->save($data);
			}
		}else{
			return $this->add($data);
		}
		
	}
	
	function  updateMeta($post_id,$meta_key,$meta_value){
		if($this->where("post_id=$post_id and meta_key='$meta_key'")->count()){
			$data['meta_value']=$meta_value;
			return $this->where("post_id=$post_id and meta_key='$meta_key'")->save($data);
		}else{
			return $this->addMeta($post_id, $meta_key, $meta_value);
		}
	}
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
}