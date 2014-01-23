<?php
/**
 * 下载页
 */
class DownloadAction extends HomeBaseAction {
	
    //首页
	public function index() {
		if (empty($_GET['name'])||empty($_GET['version'])){
			$post=sp_sql_posts('cid:11,12;field:term_id,post_title,post_date,post_content,post_excerpt;order:post_date desc');
			$this->assign('post',$post);
			$this->display(":download");
		}else{
			header('Content-type: text/html;charset=UTF-8');
			$datetime = date('Y-m-d H:i:s');
			$ip=$_SERVER["REMOTE_ADDR"];
			$name=$_GET['name'];
			$version=$_GET['version'];
			$packdate=$_GET['packdate'];
			$pefurl= $_SERVER["HTTP_REFERER"];//获取完整的来路URL
			
			$data = array(
					'ip' 	=> $ip,
					'pefurl'=> $pefurl,
					'version' => $version,
					'packdate' => $packdate,
					'datetime'=> $datetime,
			);
			M('Download')->add($data);
			$downurl="http://iservice-thinkcmf.stor.sinaapp.com/".$name."_".$version."_".$packdate.".zip";
			header("Location:".$downurl);
		}
    }   
}
?>