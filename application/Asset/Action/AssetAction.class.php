<?php

/**
 * 附件上传
 */
class AssetAction extends AdminbaseAction {

    //上传用户
    public $upname;
    //上传用户ID
    public $upuserid;
    //上传模块
    public $module = "Contents";
    //可用模块
    public $module_list = array();
    //上传栏目ID
    public $catid = 0;
    //附件存在物理地址
    public $path = "";
    public $isadmin = false;
    public $groupid;

    function _initialize() {
        //parent::_initialize();
       import('CloudUploadFile');
        //默认图片类型
        $this->imgext = array('jpg', 'gif', 'png', 'bmp', 'jpeg');
        //当前登陆用户名 0 表示游客
        $this->upuserid = 0;
        //附件目录强制/d/file/ 后台设置的附件目录，只对网络地址有效
        $this->path = C("UPLOADFILEPATH");
    }

    /**
     * swfupload 上传 
     * 通过swf上传成功以后回调处理时会调用swfupload_json方法增加cookies！
     */
    public function swfupload() {
        if (IS_POST) {
			
            //filename,filesize,filepath,uploadtime,status,meta,suffix

            //用户ID
            $upuserid = 0;
            //取得栏目ID
            //取得模块名称
            $module = strtolower($this->_post("module"));
			
            //上传处理类
            $config=array(
				'allowExts' => array('jpg','gif','png'),
				'savePath' => './'. C("UPLOADPATH"),
				'maxSize' => 11048576,
				'saveRule' => 'uniqid',
			);
			$upload = new UploadFile($config);
            //如果允许上传的文件类型为空，启用网站配置的 uploadallowext
            //允许上传的文件类型，直接使用网站配置的。20120708
           /*  if ($isadmin) {
                $allowExts = CONFIG_UPLOADALLOWEXT;
            } else {
                $allowExts = CONFIG_QTUPLOADALLOWEXT;
            }

            //设置上传类型
            $upload->allowExts = explode("|", $allowExts);

            //设置上传大小
            if ($isadmin) {
                $upload->maxSize = (int) CONFIG_UPLOADMAXSIZE * 1024; //单位字节
            } else {
                //前台
                $upload->maxSize = (int) CONFIG_QTUPLOADMAXSIZE * 1024; //单位字节
            }
            //图片裁减相关设置，如果开启，将不保留原图
            if ($this->_post("thumb_width") && $this->_post("thumb_height")) {
                $upload->thumb = true;
                $upload->thumbRemoveOrigin = true;
            }
            //是否添加水印  post:watermark_enable 等于1也需要加水印
            if ((int) $this->_post('watermark_enable')) {
                $Callback = array(
                    array("AttachmentsAction", "water"),
                    array(),
                );
            }
            //设置缩略图最大宽度
            $upload->thumbMaxWidth = $this->_post("thumb_width");
            //设置缩略图最大高度
            $upload->thumbMaxHeight = $this->_post("thumb_height"); */

            //上传目录 可以单独写个方法，根据栏目ID生成相对于栏目目录附件

            //开始上传
            if ($upload->upload()) {
                //上传成功
                $info = $upload->getUploadFileInfo();
                //写入附件数据库信息
				echo "1," . C("TMPL_PARSE_STRING.__UPLOAD__").$info[0]['savename'].",".'1,'.$info[0]['name'];
				exit;
            } else {
                //上传失败，返回错误
                exit("0," . $upload->getErrorMsg());
            }
        } else {
            //1,允许上传的文件类型,是否允许从已上传中选择,图片高度,图片高度,是否添加水印1是
            $args = $this->_get('args');
            $authkey = $this->_get('authkey');
            $module = $this->_get("module");
            if($this->module_list[ucwords($module)]){
                $this->module = strtolower($module);
            }
            /* if (empty($args) || upload_key($args) != $authkey) {
                $this->error("配置参数有误！");
            } */
            
            $info = explode(",", $args);
            $this->catid = $this->_get('catid');
            $att_not_used = cookie('att_json');
            if (empty($att_not_used))
                $tab_status = ' class="on"';
            if (!empty($att_not_used))
                $div_status = ' hidden';
           
            //获取临时未处理的图片
            $att = $this->att_not_used();
            //var_dump($att);exit;
           // $this->assign("initupload", initupload($this->module, $this->catid, $args, $this->upuserid, $this->groupid, $this->isadmin));
            //上传格式显示
            $this->assign("file_types", implode(",", explode("|", $info[1])));
            $this->assign("file_size_limit", $this->isadmin ? CONFIG_UPLOADMAXSIZE : CONFIG_QTUPLOADMAXSIZE);
            $this->assign("file_upload_limit", (int) $info[0]);
            $this->assign("att", $att);
            $this->assign("tab_status", $tab_status);
            $this->assign("div_status", $div_status);
            $this->assign("att_not_used", $att_not_used);
            $this->assign("watermark_enable", (int) $info[5]); //是否添加水印
            $group = defined('GROUP_NAME') ? GROUP_NAME . '/' : '';
            $this->display();
        }
    }

    /**
     * 加载图片库 
     */
    public function album_load() {
        if (!$this->isadmin) {
            $this->error("没有权限查看！");
        }
        $where = array();
        $db = M("Attachment");
        $filename = $this->_get("filename");
        $args = $this->_get("args");
        $args = explode(",", $args);
        empty($filename) ? "" : $where['filename'] = array('like', '%' . $filename . '%');
        $uploadtime = $this->_get("uploadtime");
        if (!empty($uploadtime)) {
            $start_uploadtime = strtotime($uploadtime . ' 00:00:00');
            $stop_uploadtime = strtotime($uploadtime . ' 23:59:59');
            $where['_string'] = 'uploadtime >= ' . $start_uploadtime . ' AND uploadtime <= ' . $stop_uploadtime . '';
        }
        //强制只是图片类型
        $where['isimage'] = array("eq", 1);

        $count = $db->where($where)->count();
        //启用分页
        $page = $this->page($count, 12);
        $data = $db->where($where)->order(array("uploadtime" => "DESC"))->limit($page->firstRow . ',' . $page->listRows)->select();
        foreach ($data as $k => $v) {
            $data[$k]['filepath'] = CONFIG_SITEFILEURL . $data[$k]['filepath'];
        }

        //var_dump($data);exit;
        $this->assign("Page", $page->show('Admin'));
        $this->assign("data", $data);
        $this->assign("file_upload_limit", $args[0]);
        unset($db);
        $group = defined('GROUP_NAME') ? GROUP_NAME . '/' : '';
        $this->display();
    }

    /**
     * 图片在线裁减，保存图片 
     */
    public function crop_upload() {
        if ($this->upuserid <= 0 || !$this->isadmin) {
            $this->error("没有权限！");
        }
        $Prefix = "thumb_"; //默认裁减图片前缀
        if (isset($GLOBALS["HTTP_RAW_POST_DATA"])) {
            $pic = $GLOBALS["HTTP_RAW_POST_DATA"];
            if (isset($_GET['width']) && !empty($_GET['width'])) {
                $width = intval($_GET['width']);
            }
            if (isset($_GET['height']) && !empty($_GET['height'])) {
                $height = intval($_GET['height']);
            }
            if (isset($_GET['file']) && !empty($_GET['file'])) {
                if (is_image($_GET['file']) == false)
                    exit();
                $file = $_GET['file'];
                $basename = basename($file);
                if (strpos($basename, $Prefix) !== false) {
                    $file_arr = explode('_', $basename);
                    $basename = array_pop($file_arr);
                }
                $new_file = $Prefix . $width . '_' . $height . '_' . $basename;
                //栏目ID
                $this->catid = intval($_GET['catid']);
                $Attachment = service("Attachment", array("module" => $this->module, "catid" => $this->catid));
                //附件存放路径
                $file_path = $Attachment->FilePath();
                //附件访问目录地址，支持http开头
                $filepath = $this->Config['sitefileurl'];
                //存放地址，不包含附件目录
                $servaname = str_replace($this->path, "", $file_path);
                //附件HTTP地址
                $filehttp = $filepath . $this->module . "/" . $servaname;
                //附件原始名称
                $filename = basename($_GET['file']);

                //附件保存后的名称
                $filesavename = str_replace(array("\\", "/"), "", $new_file);

                //上传文件的后缀类型
                $fileextension = fileext($_GET['file']);
                //设置为缩图
                $this->isthumb = 1;

                //保存图片
                file_put_contents($file_path . "/" . $new_file, $pic);
                //FTP远程附件
                if ((int) $this->Config['ftpstatus']) {
                    $imgpth = $file_path . "/" . $new_file;
                    import('Util.Ftp', APP_PATH . 'Lib');
                    $this->Ftp = new Ftp();
                    $this->Ftp->connect($this->Config['ftphost'], $this->Config['ftpuser'], $this->Config['ftppassword'], $this->Config['ftpport'], $this->Config['ftppasv'], $this->Config['ftpssl'], $this->Config['ftptimeout']);
                    $remote = $this->Config['ftpuppat'] . str_replace(SITE_PATH . "/", "", $imgpth);
                    $this->Ftp->put($remote, $imgpth);
                    unlink($imgpth);
                    $this->Ftp->close();
                }

                $infos = array(
                    "filepath" => $filepath,
                    "servaname" => $servaname,
                    "filehttp" => $filehttp,
                    "filename" => $filename,
                    "filesize" => filesize($file_path . "/" . $new_file),
                    "fileextension" => $fileextension,
                    "filesavename" => $filesavename,
                    "filehash" => md5($file_path . "/" . $new_file)
                );
            } else {

                return false;
            }
            echo $filepath . $servaname . "/" . $filesavename;
            exit;
        }
    }

    /**
     * 显示附件下的缩图
     */
    public function pullic_showthumbs() {
        $aid = $this->_get("aid");
        $info = M("Attachment")->where(array('aid' => $aid))->find();
        if ($info) {
            $infos = glob(dirname($this->path . $info['filepath']) . '/thumb_*' . basename($info['filepath']));
            foreach ($infos as $n => $thumb) {
                $thumbs[$n]['thumb_url'] = str_replace($this->path, CONFIG_SITEFILEURL, $thumb);
                $thumbinfo = explode('_', basename($thumb));
                $thumbs[$n]['thumb_filepath'] = $thumb;
                $thumbs[$n]['width'] = $thumbinfo[1];
                $thumbs[$n]['height'] = $thumbinfo[2];
            }
        }

        $show_header = 1;
        $this->assign("show_header", $show_header);
        $this->assign("thumbs", $thumbs);
        $group = defined('GROUP_NAME') ? GROUP_NAME . '/' : '';
        $this->display();
    }

    /**
     * 删除附件缩图 
     */
    public function pullic_delthumbs() {
        $filepath = urldecode($this->_get("filepath"));
        $reslut = @unlink($filepath);
        if ($reslut)
            exit('1');
        exit('0');
    }

    /**
     * 设置upload上传的json格式cookie 
     */
    protected function upload_json($aid, $src, $filename) {
        return service("Attachment")->upload_json($aid, $src, $filename);
    }

    /**
     * 设置swfupload上传的json格式cookie 
     */
    public function swfupload_json() {
        $arr = array();
        $arr['aid'] = intval($_GET['aid']);
        $arr['src'] = trim($_GET['src']);
        $arr['filename'] = urlencode($_GET['filename']);
        return $this->upload_json($arr['aid'], $arr['src'], $arr['filename']);
    }

    /**
     * 删除swfupload上传的json格式cookie 
     */
    public function swfupload_json_del() {
        $arr['aid'] = intval($_GET['aid']);
        $arr['src'] = trim($_GET['src']);
        $arr['filename'] = urlencode($_GET['filename']);
        $json_str = json_encode($arr);
        $att_arr_exist = cookie('att_json');
        cookie('att_json', NULL);
        $att_arr_exist = str_replace(array($json_str, '||||'), array('', '||'), $att_arr_exist);
        $att_arr_exist = preg_replace('/^\|\|||\|\|$/i', '', $att_arr_exist);
        cookie('att_json', $att_arr_exist);
    }

    /**
     * 获取临时未处理的图片 
     */
    protected function att_not_used() {
        $db = M("Attachment");
        //获取临时未处理文件列表
        // 水平凡 修复如果cookie里面有加反斜杠，去除
        $att_json = Input::getVar(cookie('att_json'));
        if ($att_json) {
            if ($att_json) {
                $att_cookie_arr = explode('||', $att_json);
            }
            foreach ($att_cookie_arr as $_att_c)
                $att[] = json_decode($_att_c, true);
            if (is_array($att) && !empty($att)) {
                foreach ($att as $n => $v) {
                    $ext = fileext($v['src']);
                    if (in_array($ext, array('jpg', 'gif', 'png', 'bmp', 'jpeg'))) {
                        $att[$n]['fileimg'] = $v['src'];
                        $att[$n]['width'] = '80';
                        $att[$n]['filename'] = urldecode($v['filename']);
                    } else {
                        $att[$n]['fileimg'] = file_icon($v['src']);
                        $att[$n]['width'] = '64';
                        $att[$n]['filename'] = urldecode($v['filename']);
                    }
                    $this->cookie_att .= '|' . $v['src'];
                }
            }
        }
        unset($db);
        return $att;
    }

    protected function page($Total_Size = 1, $Page_Size = 0, $Current_Page = 1, $listRows = 6, $PageParam = '', $PageLink = '', $Static = FALSE) {
        import('Util.Page', APP_PATH . 'Lib');
        if ($Page_Size == 0) {
            $Page_Size = C("PAGE_LISTROWS");
        }
        if (empty($PageParam)) {
            $PageParam = C("VAR_PAGE");
        }
        $Page = new Page($Total_Size, $Page_Size, $Current_Page, $listRows, $PageParam, $PageLink, $Static);
        $Page->SetPager('Admin', '共有{recordcount}条信息&nbsp;{pageindex}/{pagecount}&nbsp;{first}{prev}&nbsp;{liststart}{list}{listend}&nbsp;{next}{last}', array("listlong" => "6", "first" => "首页", "last" => "尾页", "prev" => "上一页", "next" => "下一页", "list" => "*", "disabledclass" => ""));
        return $Page;
    }

    /**
     * 用于图片附件上传加水印回调方法
     * @param type $_this
     * @param type $fileInfo
     * @param type $params 
     */
    public static function water($_this, $fileInfo, $params) {

        import("Image");
        //水印文件
        $water = SITE_PATH . CONFIG_WATERMARKIMG;
        //水印位置
        $waterPos = (int) CONFIG_WATERMARKPOS;
        //水印透明度
        $alpha = (int) CONFIG_WATERMARKPCT;
        //jpg图片质量
        $quality = (int) CONFIG_WATERMARKQUALITY;

        foreach ($fileInfo as $file) {
            //原图文件
            $source = $file['savepath'] . $file['savename'];
            //图像信息
            $sInfo = Image::getImageInfo($source);
            //如果图片小于系统设置，不进行水印添加
            if ($sInfo["width"] < (int) CONFIG_WATERMARKMINWIDTH || $sInfo['height'] < (int) CONFIG_WATERMARKMINHEIGHT) {
                continue;
            }
            Image::water($source, $water, $source, $alpha, $waterPos, $quality);
        }
    }

}

?>
