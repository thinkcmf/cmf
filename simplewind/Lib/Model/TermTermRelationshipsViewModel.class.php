<?php
class TermTermRelationshipsViewModel extends ViewModel{
	public $viewFields = array(
			'Terms'=>array('category',"name","description","pid","path","status"),
			'TermRelationships'=>array('object_id',"term_id",'_on'=>'Terms.term_id=TermRelationships.term_id'),
	);
	
	function getRelationships(){
	}
}