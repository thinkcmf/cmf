<?php

/**
 */
class TagLibSpadmin extends TagLib {

    /**
     * @var type 
     * 标签定义： 
     *                  attr         属性列表 
     *                  close      标签是否为闭合方式 （0闭合 1不闭合），默认为不闭合 
     *                  alias       标签别名 
     *                  level       标签的嵌套层次（只有不闭合的标签才有嵌套层次）
     * 定义了标签属性后，就需要定义每个标签的解析方法了，
     * 每个标签的解析方法在定义的时候需要添加“_”前缀，
     * 可以传入两个参数，属性字符串和内容字符串（针对非闭合标签）。
     * 必须通过return 返回标签的字符串解析输出，在标签解析类中可以调用模板类的实例。
     */
    protected $tags = array(
        //内容标签
        'content' => array('attr' => 'action,cache,num,page,return,pagetp,pagefun', 'level' => 3),
        //Tags标签
        'tags' => array('attr' => 'action,cache,num,page,return,pagetp,pagefun', 'level' => 3),
        //评论标签
        'comment' => array('attr' => 'action,cache,num,return', 'level' => 3),
        //友情链接标签
        'links' => array('attr' => 'action,cache,num,return', 'level' => 3),
        //推荐位标签
        'position' => array('attr' => 'action,cache,num,return', 'level' => 3),
        //SQL标签
        'get' => array("attr" => 'sql,cache,page,dbsource,return', 'level' => 3),
        //模板标签
        'template' => array("attr" => "file", "close" => 0),
        //后台模板标签
        'admintpl' => array("attr" => "file", "close" => 0),
        'cmstpl' => array("attr" => "file", "close" => 0),
        //Form标签
        'Form' => array("attr" => "function,parameter", "close" => 0),
    );

    /**
     * 模板包含标签 
     * 格式
     * <admintpl file="APP/模块/模板"/>
     * @staticvar array $_admintemplateParseCache
     * @param type $attr 属性字符串
     * @param type $content 标签内容
     * @return array 
     */
    public function _admintpl($attr, $content) {
        static $_admintemplateParseCache = array();
        $cacheIterateId = md5($attr . $content);
        if (isset($_admintemplateParseCache[$cacheIterateId])) {
            return $_admintemplateParseCache[$cacheIterateId];
        }
        //分析Admintemplate标签的标签定义
        $tag = $this->parseXmlAttr($attr, 'admintpl');
        $file = explode("/", $tag['file']);
        $counts = count($file);
        if ($counts < 3) {
            $file_path = DIRECTORY_SEPARATOR . "Admin" .  DIRECTORY_SEPARATOR . $tag['file'];
        } else {
            $file_path = DIRECTORY_SEPARATOR . $file[0] . DIRECTORY_SEPARATOR . "Tpl" . DIRECTORY_SEPARATOR . $file[1] . DIRECTORY_SEPARATOR . $file[2];
        }
        //模板路径
        $TemplatePath =  C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path . C("TMPL_TEMPLATE_SUFFIX");
        //判断模板是否存在
        if (!file_exists_case($TemplatePath)) {
            return false;
        }
        //读取内容
        $tmplContent = file_get_contents($TemplatePath);
        //解析模板内容
        $parseStr = $this->tpl->parse($tmplContent);
        $_admintemplateParseCache[$cacheIterateId] = $parseStr;
        return $_admintemplateParseCache[$cacheIterateId];
    }
    
    public function _cmstpl($attr, $content) {
    	static $_cmstplParseCache = array();
    	$cacheIterateId = md5($attr . $content);
    	if (isset($_cmstplParseCache[$cacheIterateId])) {
    		return $_cmstplParseCache[$cacheIterateId];
    	}
    	//分析template标签的标签定义
    	$tag = $this->parseXmlAttr($attr, 'cmstpl');
    	
    	$path   =  explode(':',$tag['file']);
    	$filename= array_pop($path);
    	
    	// 解析规则为 模板主题:文件名
    	if(!empty($path)) {// 设置模板主题
    		$path = C("CMS_TMPL_PATH")."/".array_pop($path).'/';
    	}else{
    		$path = C("CMS_TMPL_PATH")."/".C("CMS_THEME")."/";
    	}
    	$TemplatePath = $path.$filename.C('TMPL_TEMPLATE_SUFFIX');
    	//判断模板是否存在
    	if (!file_exists_case($TemplatePath)) {
    		//启用默认模板
    		//$TemplatePath = TEMPLATE_PATH . "Default" . DIRECTORY_SEPARATOR . $tag['file'];
    		if (!file_exists_case($TemplatePath)) {
    			return;
    		}
    	}
    	//读取内容
    	$tmplContent = file_get_contents($TemplatePath);
    	//解析模板
    	$parseStr = $this->tpl->parse($tmplContent);
    	$_cmstplParseCache[$cacheIterateId] = $parseStr;
    	return $_cmstplParseCache[$cacheIterateId];
    }

    /**
     * 标签：<Form/>
     * 作用：生成各种表单元素
     * 用法示例：<Form function="date" parameter="name,$valeu"/>
     * 参数说明：
     *          @function		表示所使用的方法名称，方法来源于Form.class.php这个类。
     *          @parameter		所需要传入的参数，支持变量！
     * 
     * @param type $attr
     * @param type $content
     */
    public function _Form($attr, $content) {
        static $_FormParseCache = array();
        $cacheIterateId = md5($attr . $content);
        if (isset($_FormParseCache[$cacheIterateId])) {
            return $_FormParseCache[$cacheIterateId];
        }

        $tag = $this->parseXmlAttr($attr, 'form');
        $function = $tag['function'];
        if (!$function) {
            return false;
        }

        $parameter = explode(",", $tag['parameter']);
        foreach ($parameter as $k => $v) {
            if ($v == "''" || $v == '""') {
                $v = "";
            }
            $parameter[$k] = trim($v);
        }
        $parameter = $this->arr_to_html($parameter);

        $parseStr = "<?php ";
        $parseStr .= " import(\"Form\");";
        $parseStr .= ' echo call_user_func_array(array("Form","' . $function . '"),' . $parameter . ')';
        //$parseStr .= " echo Form::$function(".$tag['parameter'].");\r\n";
        $parseStr .= " ?>";

        $_FormParseCache[$cacheIterateId] = $parseStr;
        return $parseStr;
    }

    /**
     * 标签：<template/>
     * 作用：引入其他模板
     * 用法示例：<template file="Member/footer.php"/>
     * 参数说明：
     *          @file	表示需要应用的模板路径。(这里需要说明的是，只能引入当前主题下的模板文件)
     * 
     * @staticvar array $_templateParseCache
     * @param type $attr 属性字符串
     * @param type $content 标签内容
     * @return array 
     */
    public function _template($attr, $content) {
        static $_templateParseCache = array();
        $cacheIterateId = md5($attr . $content);
        if (isset($_templateParseCache[$cacheIterateId])) {
            return $_templateParseCache[$cacheIterateId];
        }
        //检查CONFIG_THEME是否被定义
        if (!defined("CONFIG_THEME")) {
            return;
        }
        //分析template标签的标签定义
        $tag = $this->parseXmlAttr($attr, 'template');
        $TemplatePath = TEMPLATE_PATH . CONFIG_THEME . DIRECTORY_SEPARATOR . $tag['file'];
        //判断模板是否存在
        if (!file_exists_case($TemplatePath)) {
            //启用默认模板
            $TemplatePath = TEMPLATE_PATH . "Default" . DIRECTORY_SEPARATOR . $tag['file'];
            if (!file_exists_case($TemplatePath)) {
                return;
            }
        }
        //读取内容
        $tmplContent = file_get_contents($TemplatePath);
        //解析模板
        $parseStr = $this->tpl->parse($tmplContent);
        $_templateParseCache[$cacheIterateId] = $parseStr;
        return $_templateParseCache[$cacheIterateId];
    }

    /**
     * 内容标签
     * 标签：<content></content>
     * 作用：内容模型相关标签，可调用栏目，列表等常用信息
     * 用法示例：<content action="lists" catid="$catid"  order="id DESC" num="4" page="$page"> .. HTML ..</content>
     * 参数说明：
     * 	基本参数
     * 		@action		调用方法（必填）
     * 		@page		当前分页号，默认$page，当传入该参数表示启用分页，一个页面只允许有一个page，多个标签使用多个page会造成不可预知的问题。
     * 		@num		每次返回数据量
     * 		@catid		栏目id（必填），列表页，内容页可以使用 $catid 获取当前栏目。
     * 	公用参数：
     * 		@cache		数据缓存时间，单位秒
     * 		@pagefun	分页函数，默认page()
     * 		@pagetp		分页模板
     * 		@return		返回值变量名称，默认data
     * 	#当action为lists时，调用栏目列表标签
     * 	#用法示例：<content action="lists" catid="$catid"  order="id DESC" num="4" page="$page"> .. HTML ..</content>
     * 	独有参数：
     * 		@order		排序，例如“id DESC”
     * 		@where		sql语句的where部分 例如：thumb`!='' AND `status`=99（当有该参数时，thumb，catid参数失效）
     * 		@thumb		是否仅必须缩略图，1为调用带缩略图的
     * 		@moreinfo	是否调用副表数据 1为是
     * 	#当action为hits时，调用排行榜
     * 	#用法示例：<content action="hits" catid="$catid"  order="weekviews DESC" num="10"> .. HTML ..</content>
     * 	独有参数：
     * 		@order		排序，例如“weekviews DESC”
     * 		@day		调用多少天内的排行
     * 	#当action为relation时，调用相关文章
     * 	#用法示例：<content action="relation" relation="$relation" catid="$catid"  order="id DESC" num="5" keywords="$keywords"> .. HTML ..</content>
     * 	独有参数：
     * 		@nid		排除id 一般是 $id，排除当前文章
     * 		@keywords	内容页面取值：$keywords，也就是关键字
     * 		@relation		内容页取值$relation，当有$relation时keywords参数失效
     * 	#当action为category时，调用栏目列表
     * 	#用法示例：<content action="category" catid="$catid"  order="listorder ASC" > .. HTML ..</content>
     * 	独有参数：
     * 		@order		排序，例如“id DESC”
     * 
     * +----------------------------------------------------------
     * @access public
      +----------------------------------------------------------
     * @param string $attr 标签属性
     * @param string $content  标签内容
      +----------------------------------------------------------
     * @return string|void
      +----------------------------------------------------------
     */
    public function _content($attr, $content) {
        static $content_iterateParseCache = array();
        //如果已经解析过，则直接返回变量值
        $cacheIterateId = md5($attr . $content);
        if (isset($content_iterateParseCache[$cacheIterateId]))
            return $content_iterateParseCache[$cacheIterateId];
        //分析content标签的标签定义
        $tag = $this->parseXmlAttr($attr, 'content');
        /* 属性列表 */
        $num = (int) $tag['num']; //每页显示总数
        $page = (int) $tag['page']; //当前分页
        $pagefun = empty($tag['pagefun']) ? "page" : $tag['pagefun']; //分页函数，默认page
        $return = empty($tag['return']) ? "data" : $tag['return']; //数据返回变量
        $action = $tag['action']; //方法
        $pagetp = $tag['pagetp']; //分页模板

        $parseStr = '<?php';
        $parseStr .= ' $content_tag = TagLib("Content");';
        //如果有传入$page参数，则启用分页。
        if (isset($tag['page'])) {
            $tag = array_merge($tag, array(
                "count" => '$count',
                "limit" => '$_page_->firstRow.",".$_page_->listRows'
            ));
            $parseStr .= ' $count = $content_tag->count(' . self::arr_to_html($tag) . ');';
            $parseStr .= ' $_GET[C("VAR_PAGE")] = $page;';
            $parseStr .= ' $pagetp = "' . $pagetp . '";';
            $parseStr .= ' $_page_ = ' . $pagefun . '($count ,' . $num . ',$page,6,C("VAR_PAGE"),"",true,$pagetp);';
            //使用常量来保存总分页数，有个缺陷，如果不使用跳转的方式生成，会出现生成下一个栏目的时候无法对该常量进行重新赋值，使用跳转生成下一个栏目则没有这个问题！
            $parseStr .= ' if (!defined("PAGES")){define("PAGES", $_page_->Total_Pages);}';
            //_PAGES_ 用于解决上述所说的问题，这样可以根据$_GET["_PAGES_"] 来判断要生成多少页了
            $parseStr .= ' $_GET["_PAGES_"] = $_page_->Total_Pages;';
            $parseStr .= ' $pages = $_page_->show("default");';
            $parseStr .= ' $pagesize = ' . $num . ';';
            $parseStr .= ' $offset = ($page - 1) * $pagesize;';
        }
        $parseStr .= ' if(method_exists($content_tag, "' . $action . '")){';
        $parseStr .= ' $' . $return . ' = $content_tag->' . $action . '(' . self::arr_to_html($tag) . ');';
        $parseStr .= ' }';

        $parseStr .= ' ?>';
        $parseStr .= $this->tpl->parse($content);
        $content_iterateParseCache[$cacheIterateId] = $parseStr;
        return $parseStr;
    }

    /**
     * 评论标签
     * 标签：<comment></comment>
     * 作用：评论标签
     * 用法示例：<comment action="get_comment" catid="$catid" id="$id"> .. HTML ..</comment>
     * 参数说明：
     * 	基本参数
     * 		@action		调用方法（必填）
     * 		@catid		栏目id（必填），列表页，内容页可以使用 $catid 获取当前栏目。
     * 	公用参数：
     * 		@cache		数据缓存时间，单位秒
     * 		@return		返回值变量名称，默认data
     * 	#当action为get_comment时，获取评论总数
     * 	#用法示例：<comment action="get_comment" catid="$catid" id="$id"> .. HTML ..</comment>
     * 	独有参数：
     * 		@id				信息ID
     * 	#当action为lists时，获取评论数据列表
     * 	#用法示例：<comment action="lists" catid="$catid" id="$id"> .. HTML ..</comment>
     * 	独有参数：
     * 		@id		信息ID
     * 		@hot		排序方式｛0：最新｝
     * 		@date		时间格式 Y-m-d H:i:s A
      +----------------------------------------------------------
     * @param string $attr 标签属性
     * @param string $content  标签内容
     */
    public function _comment($attr, $content) {
        static $_comment_iterateParseCache = array();
        //如果已经解析过，则直接返回变量值
        $cacheIterateId = md5($attr . $content);
        if (isset($_comment_iterateParseCache[$cacheIterateId]))
            return $_comment_iterateParseCache[$cacheIterateId];
        $tag = $this->parseXmlAttr($attr, 'comment');
        /* 属性列表 */
        $num = (int) $tag['num']; //每页显示总数
        $return = empty($tag['return']) ? "data" : $tag['return']; //数据返回变量
        $action = $tag['action']; //方法

        $parseStr = '<?php';
        $parseStr .= ' $comment_tag = TagLib("Comment");';
        $parseStr .= ' if(method_exists($comment_tag, "' . $action . '")){';
        $parseStr .= ' $' . $return . ' = $comment_tag->' . $action . '(' . self::arr_to_html($tag) . ');';
        $parseStr .= ' }';
        $parseStr .= ' ?>';
        $parseStr .= $this->tpl->parse($content);
        $_comment_iterateParseCache[$cacheIterateId] = $parseStr;
        return $parseStr;
    }

    /**
     * Tags标签
     * 标签：<tags></tags>
     * 作用：Tags标签
     * 用法示例：<tags action="lists" tag="$tag" num="4" page="$page" order="id DESC"> .. HTML ..</tags>
     * 参数说明：
     * 	基本参数
     * 		@action		调用方法（必填）
     * 		@page		当前分页号，默认$page，当传入该参数表示启用分页，一个页面只允许有一个page，多个标签使用多个page会造成不可预知的问题。
     * 		@num		每次返回数据量
     * 	公用参数：
     * 		@cache		数据缓存时间，单位秒
     * 		@return		返回值变量名称，默认data
     * 		@pagefun                      分页函数，默认page()
     * 		@pagetp		分页模板
     * 	#当action为lists时，获取tag标签列表
     * 	#用法示例：<tags action="lists" tag="$tag" num="4" page="$page" order="id DESC"> .. HTML ..</tags>
     * 	独有参数：
     * 		@tag	标签名，例如：厦门
     * 		@tagid	标签id
     * 		@order	排序
     * 		@num	每次返回数据量
     * 	#当action为top时，获取tag标签列表
     * 	#用法示例：<tags action="top"  num="4"  order="id DESC"> .. HTML ..</tags>
     * 	独有参数：
     * 		@num	每次返回数据量
     * 		@order	排序例如 hits DESC
      +----------------------------------------------------------
     * @param string $attr 标签属性
     * @param string $content  标签内容
     */
    public function _tags($attr, $content) {
        static $_tags_iterateParseCache = array();
        //如果已经解析过，则直接返回变量值
        $cacheIterateId = md5($attr . $content);
        if (isset($_tags_iterateParseCache[$cacheIterateId]))
            return $_tags_iterateParseCache[$cacheIterateId];
        $tag = $this->parseXmlAttr($attr, 'tags');
        /* 属性列表 */
        $num = (int) $tag['num']; //每页显示总数
        $page = (int) $tag['page']; //当前分页
        $pagefun = empty($tag['pagefun']) ? "page" : $tag['pagefun']; //分页函数，默认page
        $return = empty($tag['return']) ? "data" : $tag['return']; //数据返回变量
        $action = $tag['action']; //方法
        $pagetp = $tag['pagetp']; //分页模板

        $parseStr = '<?php';
        $parseStr .= ' $Tags_tag = TagLib("Tags");';
        //如果有传入$page参数，则启用分页。
        if (isset($tag['page'])) {
            $tag = array_merge($tag, array(
                "count" => '$count',
                'limit' => '$_page_->firstRow.",".$_page_->listRows'
            ));
            $parseStr .= ' $count = $Tags_tag->count(' . self::arr_to_html($tag) . ');';
            $parseStr .= ' $_GET[C("VAR_PAGE")] = $page;';
            $parseStr .= ' $pagetp = "' . $pagetp . '";';
            $parseStr .= ' $_page_ = ' . $pagefun . '($count ,' . $num . ',$page,6,C("VAR_PAGE"),"",true,$pagetp);';
            //使用常量来保存总分页数，有个缺陷，如果不使用跳转的方式生成，会出现生成下一个栏目的时候无法对该常量进行重新赋值，使用跳转生成下一个栏目则没有这个问题！
            $parseStr .= ' if (!defined("PAGES")){define("PAGES", $_page_->Total_Pages);}';
            //_PAGES_ 用于解决上述所说的问题，这样可以根据$_GET["_PAGES_"] 来判断要生成多少页了
            $parseStr .= ' $_GET["_PAGES_"] = $_page_->Total_Pages;';
            $parseStr .= ' $pages = $_page_->show("default");';
            $parseStr .= ' $pagesize = ' . $num . ';';
            $parseStr .= ' $offset = ($page - 1) * $pagesize;';
        }
        $parseStr .= ' if(method_exists($Tags_tag, "' . $action . '")){';
        $parseStr .= '     $' . $return . ' = $Tags_tag->' . $action . '(' . self::arr_to_html($tag) . ');';
        $parseStr .= ' };';

        $parseStr .= ' ?>';
        $parseStr .= $this->tpl->parse($content);
        $_tags_iterateParseCache[$cacheIterateId] = $parseStr;
        return $parseStr;
    }

    /**
     * 友情链接标签
     * 标签：<links></links>
     * 作用：友情链接标签
     * 用法示例：<links action="type_list" termsid="1" id="1"> .. HTML ..</links>
     * 参数说明：
     * 	公用参数：
     * 		@cache		数据缓存时间，单位秒
     * 		@return		返回值变量名称，默认data
     * 	#当action为type_list时，获取tag标签列表
     * 	#用法示例：<links action="type_list" termsid="1" id="1"> .. HTML ..</links>
     * 	独有参数：
     * 		@order		排序方式
     * 		@termsid		分类ID
     * 		@id		链接ID
     * 
      +----------------------------------------------------------
     * @param string $attr 标签属性
     * @param string $content  标签内容
     */
    public function _links($attr, $content) {
        static $_links_iterateParseCache = array();
        //如果已经解析过，则直接返回变量值
        $cacheIterateId = md5($attr . $content);
        if (isset($_links_iterateParseCache[$cacheIterateId]))
            return $_links_iterateParseCache[$cacheIterateId];
        $tag = $this->parseXmlAttr($attr, 'links');
        /* 属性列表 */
        $return = empty($tag['return']) ? "data" : $tag['return']; //数据返回变量
        $action = $tag['action']; //方法

        $parseStr = '<?php';
        $parseStr .= ' $links_tag = TagLib("Links");';
        $parseStr .= ' if(method_exists($links_tag, "' . $action . '")){';
        $parseStr .= '     $' . $return . ' = $links_tag->' . $action . '(' . self::arr_to_html($tag) . ');';
        $parseStr .= ' };';
        $parseStr .= ' ?>';
        $parseStr .= $this->tpl->parse($content);
        $_links_iterateParseCache[$cacheIterateId] = $parseStr;
        return $parseStr;
    }

    /**
     * 推荐位标签
     * 标签：<position></position>
     * 作用：推荐位标签
     * 用法示例：<position action="position" posid="1"> .. HTML ..</position>
     * 参数说明：
     * 	公用参数：
     * 		@cache		数据缓存时间，单位秒
     * 		@return		返回值变量名称，默认data
     * 	#当action为position时，获取推荐位
     * 	独有参数：
     * 		@posid		推荐位ID(必填)
     * 		@catid		调用栏目ID
     * 		@thumb		是否仅必须缩略图
     * 		@order		排序例如
     * 		@num		每次返回数据量
     * 
      +----------------------------------------------------------
     * @param string $attr 标签属性
     * @param string $content  标签内容
     */
    public function _position($attr, $content) {
        static $_position_iterateParseCache = array();
        //如果已经解析过，则直接返回变量值
        $cacheIterateId = md5($attr . $content);
        if (isset($_position_iterateParseCache[$cacheIterateId]))
            return $_position_iterateParseCache[$cacheIterateId];
        $tag = $this->parseXmlAttr($attr, 'position');
        /* 属性列表 */
        $return = empty($tag['return']) ? "data" : $tag['return']; //数据返回变量
        $action = $tag['action']; //方法

        $parseStr = '<?php';
        $parseStr .= ' $Position_tag = TagLib("Position");';
        $parseStr .= ' if(method_exists($Position_tag, "' . $action . '")){';
        $parseStr .= '     $' . $return . ' = $Position_tag->' . $action . '(' . self::arr_to_html($tag) . ');';
        $parseStr .= ' };';
        $parseStr .= ' ?>';
        $parseStr .= $this->tpl->parse($content);
        $_position_iterateParseCache[$cacheIterateId] = $parseStr;
        return $parseStr;
    }

    /**
     * 标签：<get></get>
     * 作用：特殊标签，SQL查询标签
     * 用法示例：<get sql="SELECT * FROM shuipfcms_article  WHERE status=99 ORDER BY inputtime DESC" page="$page" num="5"> .. HTML ..</get>
     * 参数说明：
     * 	@sql		SQL语句，强烈建议只用于select类型语句，其他SQL有严重安全威胁，同时不建议直接在SQL语句中使用外部变量，如:$_GET,$_POST等。
     * 	@page		当前分页号，默认$page，当传入该参数表示启用分页，一个页面只允许有一个page，多个标签使用多个page会造成不可预知的问题。
     * 	@num		每次返回数据量
     * 	@cache		数据缓存时间，单位秒
     * 	@return		返回值变量名称，默认data
     * 	@pagefun	                    分页函数，默认page()
     * 	@pagetp		分页模板
     * 
     * +----------------------------------------------------------
     * @param type $attr
     * @param type $content 
     */
    public function _get($attr, $content) {
        static $_get_iterateParseCache = array();
        //如果已经解析过，则直接返回变量值
        $cacheIterateId = md5($attr . $content);
        if (isset($_get_iterateParseCache[$cacheIterateId]))
            return $_get_iterateParseCache[$cacheIterateId];
        $tag = $this->parseXmlAttr($attr, 'get');
        $sql = $tag['sql'];
        $page = (int) $tag['page']; //当前分页
        $cache = (int) $tag['cache'];
        $pagefun = empty($tag['pagefun']) ? "page" : $tag['pagefun']; //分页函数，默认page
        $pagetp = $tag['pagetp']; //分页模板
        $num = isset($tag['num']) && intval($tag['num']) > 0 ? intval($tag['num']) : 20; //每页显示总数
        $return = empty($tag['return']) ? "data" : $tag['return']; //数据返回变量
        $tag['sql'] = str_replace(array("think_", "shuipfcms_"), C("DB_PREFIX"), strtolower($tag['sql']));

        //删除，插入不执行！这样处理感觉有点鲁莽了，，，-__,-!
        if (strpos($tag['sql'], "delete") || strpos($tag['sql'], "insert")) {
            return;
        }

        $str = ' <?php ';
        //如果配置了数据源
        if ($datas['dbsource']) {
            
        } else {
            $str .= ' $get_db = M();';
        }
        //有启用分页
        if (isset($tag['page'])) {
            //分析SQL语句
            if ($sql = preg_replace('/select([^from].*)from/i', "SELECT COUNT(*) as count FROM ", $tag['sql'])) {
                $str .= ' if(' . $cache . ' && $data = S( md5("' . $tag['sql'] . $cache . '".$page) ) ){ ';
                $str .= ' $pagetp = "' . $pagetp . '";';
                $str .= ' $_GET[C("VAR_PAGE")] = $page;';
                $str .= ' $_page_ = ' . $pagefun . '($data["count"] ,' . $num . ',$page,6,C("VAR_PAGE"),"",true,$pagetp);';
                //使用常量来保存总分页数，有个缺陷，如果不使用跳转的方式生成，会出现生成下一个栏目的时候无法对该常量进行重新赋值，使用跳转生成下一个栏目则没有这个问题！
                $str .= ' if (!defined("PAGES")){define("PAGES", $_page_->Total_Pages);}';
                //_PAGES_ 用于解决上述所说的问题，这样可以根据$_GET["_PAGES_"] 来判断要生成多少页了
                $str .= ' $_GET["_PAGES_"] = $_page_->Total_Pages;';
                $str .= ' $pages = $_page_->show("default");';
                $str .= ' $pagesize = ' . $num . ';';
                $str .= ' $offset = ($page - 1) * $pagesize;';
                $str .= ' $' . $return . '= $data["data"];';
                $str .= ' }else{ ';
                //取得信息总数
                $str .= ' $count = $get_db->query("' . $sql . '");';
                $str .= ' $count = $count[0]["count"]; ';
                $str .= ' $_GET[C("VAR_PAGE")] = $page;';
                //分页模板
                $str .= ' $pagetp = "' . $pagetp . '";';
                $str .= ' $_page_ = ' . $pagefun . '($count ,' . $num . ',$page,6,C("VAR_PAGE"),"",true,$pagetp);';
                //使用常量来保存总分页数，有个缺陷，如果不使用跳转的方式生成，会出现生成下一个栏目的时候无法对该常量进行重新赋值，使用跳转生成下一个栏目则没有这个问题！
                $str .= ' if (!defined("PAGES")){define("PAGES", $_page_->Total_Pages);}';
                //_PAGES_ 用于解决上述所说的问题，这样可以根据$_GET["_PAGES_"] 来判断要生成多少页了
                $str .= ' $_GET["_PAGES_"] = $_page_->Total_Pages;';
                $str .= ' $pages = $_page_->show("default");';
                $str .= ' $pagesize = ' . $num . ';';
                $str .= ' $offset = ($page - 1) * $pagesize;';
                $str .= ' $' . $return . '=$get_db->query("' . $tag['sql'] . ' LIMIT ".$_page_->firstRow.",".$_page_->listRows." ");';
                $str .= ' if(' . $cache . '){ S( md5("' . $tag['sql'] . $cache . '".$page)  ,array("count"=>$count,"data"=>$' . $return . '),' . $cache . '); }; ';
                $str .= ' } ';
            }
        } else {
            $str .= ' if(' . $cache . ' && $data = S( md5("' . $tag['sql'] . $cache . '") ) ){ ';
            $str .= ' $' . $return . '=$data;';
            $str .= ' }else{ ';
            $str .= ' $' . $return . '=$get_db->query("' . $tag['sql'] . ' LIMIT ' . $num . ' ");';
            $str .= ' if(' . $cache . '){ S( md5("' . $tag['sql'] . $cache . '")  ,$' . $return . ',' . $cache . '); }; ';
            $str .= ' } ';
        }
        $str .= '  ?>';
        $str .= $this->tpl->parse($content);
        $_get_iterateParseCache[$cacheIterateId] = $str;
        return $str;
    }

    /**
     * 转换数据为HTML代码
     * @param array $data 数组
     */
    private static function arr_to_html($data) {
        if (is_array($data)) {
            $str = 'array(';
            foreach ($data as $key => $val) {
                if (is_array($val)) {
                    $str .= "'$key'=>" . self::arr_to_html($val) . ",";
                } else {
                    if (strpos($val, '$') === 0) {
                        $str .= "'$key'=>$val,";
                    } else {
                        $str .= "'$key'=>'" . new_addslashes($val) . "',";
                    }
                }
            }
            return $str . ')';
        }
        return false;
    }

}

?>
