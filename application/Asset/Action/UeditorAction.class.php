<?php
class UeditorAction extends Action {
	public function uploadimg(){
		import('CloudUploadFile');
		//上传处理类
		$config=array(
				'allowExts' => array('jpg','gif','png'),
				'savePath' => './'. C("UPLOADPATH"),
				'maxSize' => 11048576,
				'saveRule' => 'uniqid',
			);
		$upload = new UploadFile($config);
		
		$file = $title = $oriName = $state ='0';

		//开始上传
		if ($upload->upload()) {
			//上传成功
			$info = $upload->getUploadFileInfo();
			$title = $oriName = $info[0]['name'];
			$state = 'SUCCESS';
			$file = C("TMPL_PARSE_STRING.__UPLOAD__").$info[0]['savename'];
		} else {
			$state = $upload->getErrorMsg();
		}
		echo "{'url':'" . $file . "','title':'" . $title . "','original':'" . $oriName . "','state':'" . $state . "'}";
	}
	
	public function imageManager(){
		error_reporting(E_ERROR|E_WARNING);
		$path = 'upload'; //最好使用缩略图地址，否则当网速慢时可能会造成严重的延时
		$action = htmlspecialchars($_POST["action"]);
		if($action=="get"){
			$files = $this->getfiles($path);
			if(!$files)return;
			$str = "";
			foreach ($files as $file) {
				$str .= $file."ue_separate_ue";
			}
			echo $str;
		}
	}
	
	//imageManager()用的到
	private function getfiles(){
		if (!is_dir($path)) return;
		
		$handle = opendir($path);
		while (false !== ($file = readdir($handle))) {
			if ($file != '.' && $file != '..') {
				$path2 = $path . '/' . $file;
				if (is_dir($path2)) {
					getfiles($path2, $files);
				} else {
					if (preg_match("/\.(gif|jpeg|jpg|png|bmp)$/i", $file)) {
						$files[] = $path2;
					}
				}
			}
		}return $files;
	}
	
}