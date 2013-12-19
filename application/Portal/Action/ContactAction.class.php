<?php
/**
 * 联系我们
 */
class ContactAction extends HomeBaseAction {
    public function index() {
    	$contact=sp_sql_page(3);
    	$this->assign("contact",$contact);
    	$this->display(":contact");
    }   
}
?>
