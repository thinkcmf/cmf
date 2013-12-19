SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
CREATE TABLE `sp_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `g` varchar(20) NOT NULL COMMENT '项目',
  `m` varchar(20) NOT NULL COMMENT '模块',
  `a` varchar(20) NOT NULL COMMENT '方法',
  KEY `groupId` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'password');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'User', 'userinfo');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Panel', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Panel', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'userinfo');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'password');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'site');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Content', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Term', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Term', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Page', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Page', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'clearcache');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slide', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slide', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slidecat', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Ad', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Ad', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Link', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Link', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Content', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Term', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Term', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Page', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Page', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'clearcache');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slide', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slide', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slidecat', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slidecat', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Ad', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Ad', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Link', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Link', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'password');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'User', 'userinfo');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Panel', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Panel', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'userinfo');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'password');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'site');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Content', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Term', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Term', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Page', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Page', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'clearcache');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slide', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slide', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slidecat', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Ad', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Ad', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Link', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Link', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Content', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Term', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Term', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Page', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Page', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'clearcache');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slide', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slide', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slidecat', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slidecat', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Ad', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Ad', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Link', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Link', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'password');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'User', 'userinfo');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Panel', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Panel', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'userinfo');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'password');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'site');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Content', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Term', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Term', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Page', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Page', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'clearcache');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slide', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slide', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slidecat', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Ad', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Ad', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Link', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Link', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Content', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Term', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Term', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Page', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Page', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'clearcache');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slide', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slide', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slidecat', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slidecat', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Ad', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Ad', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Link', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Link', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'password');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'User', 'userinfo');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Panel', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Panel', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'userinfo');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'password');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'site');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'User', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Content', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Term', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Term', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Page', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Page', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Setting', 'clearcache');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slide', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slide', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Slidecat', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Ad', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Ad', 'add');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Link', 'index');
INSERT INTO `sp_access` VALUES (2, 'Admin', 'Link', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Content', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Term', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Term', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Post', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Page', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Page', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Setting', 'clearcache');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slide', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slide', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slidecat', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Slidecat', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Menu', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Ad', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Ad', 'add');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Extension', 'default');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Link', 'index');
INSERT INTO `sp_access` VALUES (3, 'Admin', 'Link', 'add');
CREATE TABLE `sp_ad` (
  `ad_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ad_name` varchar(255) NOT NULL,
  `ad_content` text,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `sp_admin_panel` (
  `menuid` mediumint(8) unsigned NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` char(32) DEFAULT NULL,
  `url` char(255) DEFAULT NULL,
  `datetime` int(10) unsigned DEFAULT '0',
  UNIQUE KEY `userid` (`menuid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `sp_asset` (
  `aid` bigint(20) NOT NULL AUTO_INCREMENT,
  `_unique` varchar(14) NOT NULL,
  `filename` varchar(50) DEFAULT NULL,
  `filesize` int(11) DEFAULT NULL,
  `filepath` varchar(200) NOT NULL,
  `uploadtime` int(11) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `meta` text,
  `suffix` varchar(50) DEFAULT NULL,
  `download_times` int(6) NOT NULL,
  PRIMARY KEY (`aid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
CREATE TABLE `sp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `sp_comments` (
  `comment_ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_post_ID` bigint(20) unsigned NOT NULL DEFAULT '0',
  `comment_author` tinytext NOT NULL,
  `comment_author_email` varchar(100) NOT NULL DEFAULT '',
  `comment_author_url` varchar(200) NOT NULL DEFAULT '',
  `comment_author_IP` varchar(100) NOT NULL DEFAULT '',
  `comment_date` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `comment_content` text NOT NULL,
  `comment_karma` int(11) NOT NULL DEFAULT '0',
  `comment_approved` varchar(20) NOT NULL DEFAULT '1',
  `comment_agent` varchar(255) NOT NULL DEFAULT '',
  `comment_type` varchar(20) NOT NULL DEFAULT '',
  `comment_parent` bigint(20) unsigned NOT NULL DEFAULT '0',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_ID`),
  KEY `comment_post_ID` (`comment_post_ID`),
  KEY `comment_approved_date_gmt` (`comment_approved`),
  KEY `comment_parent` (`comment_parent`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
INSERT INTO `sp_comments` VALUES (1, 1, 'WordPress 先生', '', 'http://wordpress.org/', '', '2013-03-18 16:09:34', '您好，这是一条评论。\n要删除评论，请先登录，然后再查看这篇文章的评论。登录后您可以看到编辑或者删除评论的选项。', 0, '1', '', '', 0, 0);
INSERT INTO `sp_comments` VALUES (2, 4, 'admin', 'zxxjjforever@163.com', '', '127.0.0.1', '2013-03-19 00:56:38', 'wq dad', 0, '1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '', 0, 1);
INSERT INTO `sp_comments` VALUES (3, 4, 'admin', 'zxxjjforever@163.com', '', '127.0.0.1', '2013-03-19 01:19:46', 'sss', 0, '1', 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.17 (KHTML, like Gecko) Chrome/24.0.1312.57 Safari/537.17', '', 0, 1);
CREATE TABLE `sp_links` (
  `link_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `link_url` varchar(255) NOT NULL DEFAULT '',
  `link_name` varchar(255) NOT NULL DEFAULT '',
  `link_image` varchar(255) DEFAULT '',
  `link_target` varchar(25) NOT NULL DEFAULT '_blank',
  `link_description` text NOT NULL,
  `link_status` int(2) NOT NULL DEFAULT '1',
  `link_rating` int(11) NOT NULL DEFAULT '0',
  `link_rel` varchar(255) DEFAULT '',
  `listorder` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`link_id`),
  KEY `link_visible` (`link_status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
INSERT INTO `sp_links` VALUES (1, 'http://www.simplewind.net', '简约·风网络技术工作室', '', '_blank', '', 1, 0, '', 0);
CREATE TABLE `sp_members` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login_name` varchar(25) NOT NULL,
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nickname` varchar(50) NOT NULL,
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `last_login_ip` varchar(16) NOT NULL,
  `last_login_time` int(12) NOT NULL,
  `create_time` int(12) NOT NULL,
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `user_nicename` (`user_nickname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;
CREATE TABLE `sp_menu` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `parentid` smallint(6) unsigned NOT NULL DEFAULT '0',
  `app` char(20) NOT NULL COMMENT '应用名称app',
  `model` char(20) NOT NULL DEFAULT '',
  `action` char(20) NOT NULL DEFAULT '',
  `data` char(50) NOT NULL DEFAULT '',
  `type` tinyint(1) NOT NULL DEFAULT '0',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `name` varchar(50) NOT NULL DEFAULT '',
  `icon` varchar(50) DEFAULT NULL,
  `remark` varchar(255) NOT NULL DEFAULT '',
  `listorder` smallint(6) unsigned NOT NULL DEFAULT '0' COMMENT '排序ID',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parentid` (`parentid`),
  KEY `model` (`model`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=303 ;
INSERT INTO `sp_menu` VALUES (239, 0, 'Admin', 'Panel', 'default', '', 0, 1, '设置', 'cogs', '', 0);
INSERT INTO `sp_menu` VALUES (51, 0, 'Admin', 'Content', 'default', '', 0, 1, '内容管理', 'th', '', 10);
INSERT INTO `sp_menu` VALUES (245, 51, 'Admin', 'Term', 'index', '', 0, 1, '分类管理', '', '', 2);
INSERT INTO `sp_menu` VALUES (299, 260, 'api', 'oauthadmin', 'setting', '', 1, 1, '第三方登录', 'leaf', '', 4);
INSERT INTO `sp_menu` VALUES (252, 239, 'Admin', 'Setting', 'default', '', 0, 1, '个人信息', NULL, '', 0);
INSERT INTO `sp_menu` VALUES (253, 252, 'Admin', 'User', 'userinfo', '', 1, 1, '修改信息', '', '', 0);
INSERT INTO `sp_menu` VALUES (254, 252, 'Admin', 'Setting', 'password', '', 1, 1, '修改密码', NULL, '', 0);
INSERT INTO `sp_menu` VALUES (260, 0, 'Admin', 'Extension', 'default', '', 0, 1, '扩展工具', 'cloud', '', 30);
INSERT INTO `sp_menu` VALUES (262, 260, 'Admin', 'Menu', 'add', '', 1, 1, '幻灯片', '', '', 1);
INSERT INTO `sp_menu` VALUES (264, 262, 'Admin', 'Slide', 'index', '', 1, 1, '幻灯片管理', '', '', 0);
INSERT INTO `sp_menu` VALUES (265, 260, 'Admin', 'ad', 'index', '', 1, 1, '网站广告', '', '', 2);
INSERT INTO `sp_menu` VALUES (268, 262, 'Admin', 'Slidecat', 'index', '', 1, 1, '幻灯片分类', '', '', 0);
INSERT INTO `sp_menu` VALUES (270, 260, 'Admin', 'Link', 'index', '', 0, 1, '友情链接', '', '', 3);
INSERT INTO `sp_menu` VALUES (277, 51, 'Admin', 'Page', 'index', '', 1, 1, '页面管理', '', '', 3);
INSERT INTO `sp_menu` VALUES (301, 300, 'Admin', 'Page', 'recyclebin', '', 1, 1, '页面回收', '', '', 1);
INSERT INTO `sp_menu` VALUES (302, 300, 'Admin', 'Post', 'recyclebin', '', 1, 1, '文章回收', '', '', 0);
INSERT INTO `sp_menu` VALUES (300, 51, 'Admin', 'recycle', 'default', '', 1, 1, '回收站', '', '', 4);
INSERT INTO `sp_menu` VALUES (284, 239, 'Admin', 'setting', 'site', '', 1, 1, '网站信息', '', '', 0);
INSERT INTO `sp_menu` VALUES (285, 51, 'Admin', 'Post', 'index', '', 1, 1, '文章管理', '', '', 1);
INSERT INTO `sp_menu` VALUES (286, 0, 'Member', 'indexadmin', 'default', '', 1, 1, '用户管理', 'group', '', 0);
INSERT INTO `sp_menu` VALUES (287, 289, 'Member', 'indexadmin', 'index', '', 1, 1, '本站用户', 'leaf', '', 0);
INSERT INTO `sp_menu` VALUES (288, 289, 'Api', 'oauthadmin', 'index', '', 1, 1, '第三方用户', 'leaf', '', 0);
INSERT INTO `sp_menu` VALUES (289, 286, 'Member', 'indexadmin', 'default1', '', 1, 1, '用户组', '', '', 0);
INSERT INTO `sp_menu` VALUES (290, 286, 'Member', 'indexadmin', 'default3', '', 1, 1, '管理组', '', '', 0);
INSERT INTO `sp_menu` VALUES (291, 290, 'Admin', 'Rbac', 'index', '', 1, 1, '角色管理', '', '', 0);
INSERT INTO `sp_menu` VALUES (292, 290, 'Admin', 'User', 'index', '', 1, 1, '管理员', '', '', 0);
INSERT INTO `sp_menu` VALUES (293, 0, 'Admin', 'Menu', 'default', '', 1, 1, '菜单管理', 'list', '', 0);
INSERT INTO `sp_menu` VALUES (294, 293, 'Admin', 'Navcat', 'default1', '', 1, 1, '前台菜单', '', '', 0);
INSERT INTO `sp_menu` VALUES (295, 294, 'Admin', 'Nav', 'index', '', 1, 1, '菜单管理', '', '', 0);
INSERT INTO `sp_menu` VALUES (296, 294, 'Admin', 'Navcat', 'index', '', 1, 1, '菜单分类', '', '', 0);
INSERT INTO `sp_menu` VALUES (297, 293, 'Admin', 'Menu', 'index', '', 1, 1, '后台菜单', '', '', 0);
INSERT INTO `sp_menu` VALUES (298, 239, 'Admin', 'setting', 'clearcache', '', 1, 1, '清除缓存', '', '', 0);
CREATE TABLE `sp_nav` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `parentid` int(11) NOT NULL,
  `label` varchar(255) NOT NULL,
  `target` varchar(50) DEFAULT NULL,
  `href` varchar(255) NOT NULL,
  `icon` varchar(255) NOT NULL,
  `status` int(2) NOT NULL DEFAULT '1',
  `listorder` int(6) DEFAULT '0',
  `path` varchar(255) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;
INSERT INTO `sp_nav` VALUES (1, 4, 0, '首页', '', 'index.php', '', 1, 0, '0');
INSERT INTO `sp_nav` VALUES (7, 4, 0, '联系我们', '', 'index.php?m=contact', '', 1, 0, '0');
INSERT INTO `sp_nav` VALUES (8, 4, 0, '前端工具包', '', 'index.php?m=tools&a=icons', '', 1, 0, '0');
INSERT INTO `sp_nav` VALUES (9, 4, 8, '图标工具', '', 'index.php?m=tools&a=icons', '', 1, 0, '0-9');
INSERT INTO `sp_nav` VALUES (10, 4, 8, '样式元素', '', 'index.php?m=tools&a=shortcodes', '', 1, 0, '0');
CREATE TABLE `sp_nav_cat` (
  `navcid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `remark` text,
  PRIMARY KEY (`navcid`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;
INSERT INTO `sp_nav_cat` VALUES (4, '主导航', 1, '主导航');
INSERT INTO `sp_nav_cat` VALUES (5, '左导航', 0, '');
CREATE TABLE `sp_oauth_member` (
  `ID` int(20) NOT NULL AUTO_INCREMENT,
  `_from` varchar(20) NOT NULL,
  `_name` varchar(30) NOT NULL,
  `head_img` varchar(200) NOT NULL,
  `lock_to_id` int(20) NOT NULL,
  `create_time` int(12) NOT NULL,
  `last_login_time` int(12) NOT NULL,
  `last_login_ip` varchar(16) NOT NULL,
  `login_times` int(6) NOT NULL,
  `status` tinyint(2) NOT NULL,
  `access_token` varchar(60) NOT NULL,
  `expires_date` int(12) NOT NULL,
  `openid` varchar(40) NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=31 ;
CREATE TABLE `sp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1134 ;
INSERT INTO `sp_options` VALUES (1133, 'site_options', '{"site_name":"ThinkCMF\\u6f14\\u793a","site_host":"http:\\/\\/demo.thinkcmf.com","site_root":"\\/","site_tpl":"1","site_icp":" xxbua","site_admin_email":"sam_zb@126.com","site_tongji":"<script>var ss=\\"xxx\\";<\\/script>","site_copyright":"","site_seo_title":"ThinkCMF\\u5185\\u5bb9\\u7ba1\\u7406\\u6846\\u67b6","site_seo_keywords":"CMF,CMS,\\u5185\\u5bb9\\u7ba1\\u7406\\u6846\\u67b6","site_seo_description":"ThinkCMF\\u662f\\u7b2c\\u4e00\\u6b3ePHP\\u4e2d\\u6587\\u5185\\u5bb9\\u7ba1\\u7406\\u6846\\u67b6"}', 1);
CREATE TABLE `sp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
CREATE TABLE `sp_posts` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_author` bigint(20) unsigned DEFAULT '0',
  `post_keywords` varchar(150) NOT NULL,
  `post_date` datetime DEFAULT '0000-00-00 00:00:00',
  `post_content` longtext,
  `post_title` text,
  `post_excerpt` text,
  `post_status` int(2) DEFAULT '1',
  `comment_status` int(2) DEFAULT '1',
  `post_modified` datetime DEFAULT '0000-00-00 00:00:00',
  `post_content_filtered` longtext,
  `post_parent` bigint(20) unsigned DEFAULT '0',
  `post_type` int(2) DEFAULT NULL,
  `post_mime_type` varchar(100) DEFAULT '',
  `comment_count` bigint(20) DEFAULT '0',
  `smeta` text,
  PRIMARY KEY (`ID`),
  KEY `type_status_date` (`post_type`,`post_status`,`post_date`,`ID`),
  KEY `post_parent` (`post_parent`),
  KEY `post_author` (`post_author`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=220 ;
INSERT INTO `sp_posts` VALUES (189, 1, '', '2013-11-29 12:37:25', '<p>ThinkCMF使用MVC分层构架：模型（M）、视图（V）、控制器（C），方便不同的用户完成不同的任务。同时支持用户行为管理，只要你愿意你完全可以自定义了个自己的内容框架。</p>', '轻量级PHP框架', '', 1, 1, '2013-11-29 12:33:46', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (190, 1, '', '2013-11-29 12:54:57', '<p>BOOTSTRAP是款优秀的前端快速开发框架。ThinkCMF首发版本将全面支持bootstrap，ThinkCMF不仅创造了第一个中文内容管理框架，还致力于将BOOTSTRAP本土化。</p>', 'BOOTSTRAP框架', '', 1, 1, '2013-11-29 12:51:37', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (191, 1, '', '2013-11-29 13:00:03', '<p>你所看到的是ThinkCMF的默认皮肤，ThinkCMF已为你集成了多个常用的前端开发元素以及后端程序组件，你甚至不要任何编码就能完成一个简单的网站开发。</p>', '开发工具', '', 1, 1, '2013-11-29 12:55:00', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (192, 1, '', '2013-11-29 13:55:59', '<p>Design / Development</p>', '使命1', '', 1, 1, '2013-11-29 13:15:39', NULL, 0, NULL, '', 0, '{"thumb":"\\/data\\/upload\\/\\/529d89ce918f0.jpg"}');
INSERT INTO `sp_posts` VALUES (193, 1, '', '2013-11-29 14:12:02', '<p>Framrwork<br/></p>', '使命1', '', 1, 1, '2013-11-29 14:10:24', NULL, 0, NULL, '', 0, '{"thumb":"\\/data\\/upload\\/\\/529d89e4639e1.jpg"}');
INSERT INTO `sp_posts` VALUES (194, 1, '', '2013-11-29 14:13:29', '<p>Chinese&nbsp;CMF</p>', '使命1', '', 1, 1, '2013-11-29 14:12:06', NULL, 0, NULL, '', 0, '{"thumb":"\\/data\\/upload\\/\\/529d89f352d4b.jpg"}');
INSERT INTO `sp_posts` VALUES (196, 1, '', '2013-11-29 14:23:11', '<p><span left-pos="0|6" right-pos="0|6" space="" class="" style="color: rgb(51, 51, 51); font-family: arial; font-size: 14px; line-height: 22px;  background-color: rgb(255, 255, 255);">Brave</span><span left-pos="6|9" right-pos="6|9" space="0| " class="" style="color: rgb(51, 51, 51); font-family: arial; font-size: 14px; line-height: 22px;  background-color: rgb(255, 255, 255);">&nbsp;and innovation</span></p>', '使命2', '', 1, 1, '2013-11-29 14:22:04', NULL, 0, NULL, '', 0, '{"thumb":"\\/data\\/upload\\/\\/529d8a5a35930.jpg"}');
INSERT INTO `sp_posts` VALUES (197, 1, '', '2013-11-29 14:23:37', '<p>web design</p>', '使命2', '', 1, 1, '2013-11-29 14:23:13', NULL, 0, NULL, '', 0, '{"thumb":"\\/data\\/upload\\/\\/529d8a6d1c8e6.jpg"}');
INSERT INTO `sp_posts` VALUES (198, 1, '', '2013-11-29 14:26:11', '<p><span style="color: rgb(114, 114, 114); font-family: &#39;Open Sans&#39;, Helvetica, Arial, sans-serif; font-size: 12px; font-style: italic; line-height: 24px; text-align: center;  background-color: rgb(255, 255, 255);">Free/Open source</span></p>', '使命2', '', 1, 1, '2013-11-29 14:25:20', NULL, 0, NULL, '', 0, '{"thumb":"\\/data\\/upload\\/\\/529d8a7ce5224.jpg"}');
INSERT INTO `sp_posts` VALUES (199, 1, '', '2013-11-29 14:41:39', '<p>这是个企业使命展示模块，你可以至后台修改此处的文字以及右侧的图片。很酷吧，这一切都是建立在ThinkCMF和Bootstrap上的，还等什么免费的啊。</p>', '企业使命', '', 1, 1, '2013-11-29 14:39:28', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (200, 1, '', '2013-11-29 14:54:25', '<p>这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p>这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p>这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p>', '产品服务一', '', 1, 1, '2013-11-29 14:51:46', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (201, 1, '', '2013-11-29 15:23:54', '<p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。<br/></p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p>', '产品服务二', '', 1, 1, '2013-11-29 15:23:40', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (202, 1, '', '2013-11-29 15:24:11', '<p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。<br/></p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p><br/></p>', '产品服务三', '', 1, 1, '2013-11-29 15:23:56', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (203, 1, '', '2013-11-29 15:24:29', '<p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。<br/></p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p>', '产品服务四', '', 1, 1, '2013-11-29 15:24:13', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (204, 1, '', '2013-11-29 15:25:44', '<p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。<br/></p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p><br/></p>', '产品服务五', '', 1, 1, '2013-11-29 15:24:31', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (205, 1, '', '2013-11-29 15:26:06', '<p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。<br/></p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p>', '产品服务六', '', 1, 1, '2013-11-29 15:25:46', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (206, 1, '', '2013-11-29 15:26:21', '<p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。<br/></p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p><br/></p>', '产品服务七', '', 1, 1, '2013-11-29 15:26:08', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (207, 1, '', '2013-11-29 15:26:32', '<p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。<br/></p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p><br/></p>', '产品服务七', '', 1, 1, '2013-11-29 15:26:23', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (208, 1, '', '2013-11-29 15:26:45', '<p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。<br/></p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p><br/></p>', '产品服务八', '', 1, 1, '2013-11-29 15:26:35', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (209, 1, '', '2013-11-29 15:27:02', '<p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。<br/></p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p><p style="WHITE-SPACE: normal">这里在后台键入你想要展示的产品或服务信息，这里显示的内容是与右侧的图标对应的。右侧的图标你可以根据ThinkCMF提供的图标集成包更换成你自己想要的。</p>', '产品服务九', '', 1, 1, '2013-11-29 15:26:48', NULL, 0, NULL, '', 0, '{"thumb":""}');
INSERT INTO `sp_posts` VALUES (210, 1, '', '2013-11-29 16:12:44', '<p>你可以在后台分类管理中管理企业新闻，你可以在后台分类管理中管理企业新闻，你可以在后台分类管理中管理企业新闻。</p>', '新闻一', '', 1, 1, '2013-11-29 16:11:24', NULL, 0, NULL, '', 0, '{"thumb":"\\/data\\/upload\\/\\/529d8b8b1f21f.jpg"}');
INSERT INTO `sp_posts` VALUES (211, 1, '', '2013-11-29 16:29:32', '<p>你可以在后台分类管理中管理企业新闻，你可以在后台分类管理中管理企业新闻，你可以在后台分类管理中管理企业新闻。</p>', '新闻二', '', 1, 1, '2013-11-29 16:28:57', NULL, 0, NULL, '', 0, '{"thumb":"\\/data\\/upload\\/\\/529d8ba7107ae.jpg"}');
INSERT INTO `sp_posts` VALUES (212, 1, '', '2013-11-29 16:30:03', '<p>你可以在后台分类管理中管理企业新闻，你可以在后台分类管理中管理企业新闻，你可以在后台分类管理中管理企业新闻。</p>', '新闻三', '', 1, 1, '2013-11-29 16:29:34', NULL, 0, NULL, '', 0, '{"thumb":"\\/data\\/upload\\/\\/529d8bb812577.jpg"}');
CREATE TABLE `sp_role` (
  `id` smallint(6) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '角色名称',
  `pid` smallint(6) DEFAULT NULL COMMENT '父角色ID',
  `status` tinyint(1) unsigned DEFAULT NULL COMMENT '状态',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `create_time` int(11) unsigned NOT NULL COMMENT '创建时间',
  `update_time` int(11) unsigned NOT NULL COMMENT '更新时间',
  `listorder` int(3) NOT NULL DEFAULT '0' COMMENT '排序字段',
  PRIMARY KEY (`id`),
  KEY `parentId` (`pid`),
  KEY `status` (`status`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色信息列表' AUTO_INCREMENT=5 ;
INSERT INTO `sp_role` VALUES (1, '超级管理员', NULL, 1, '拥有网站最高管理员权限！', 1329633709, 1329633709, 0);
INSERT INTO `sp_role` VALUES (2, '站点管理员', NULL, 1, '站点管理员', 1329633722, 1330155227, 0);
INSERT INTO `sp_role` VALUES (3, '发布人员', NULL, 1, '发布人员', 1329633733, 1329637001, 0);
CREATE TABLE `sp_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
CREATE TABLE `sp_slide` (
  `slide_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `slide_cid` bigint(20) NOT NULL,
  `slide_name` varchar(255) NOT NULL,
  `slide_pic` varchar(255) DEFAULT NULL,
  `slide_url` varchar(255) DEFAULT NULL,
  `slide_des` varchar(255) DEFAULT NULL,
  `slide_content` text,
  `slide_status` int(2) NOT NULL DEFAULT '1',
  `listorder` int(10) DEFAULT '0',
  PRIMARY KEY (`slide_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;
INSERT INTO `sp_slide` VALUES (1, 1, '1', '/data/upload//529e73521e649.jpg', '1111', '描述', '幻灯片内容', 1, 3);
INSERT INTO `sp_slide` VALUES (2, 1, '2', '/data/upload//529e7368ce93f.jpg', '', '描述2', '幻灯片内容2', 1, 2);
CREATE TABLE `sp_slide_cat` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_idname` varchar(255) NOT NULL,
  `cat_remark` text,
  `cat_status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
INSERT INTO `sp_slide_cat` VALUES (1, '首页头部幻灯片', 'index_top', '首页头部幻灯片', 1);
CREATE TABLE `sp_terms` (
  `term_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(200) DEFAULT '',
  `slug` varchar(200) DEFAULT '',
  `taxonomy` varchar(32) DEFAULT '',
  `description` longtext,
  `parent` bigint(20) unsigned DEFAULT '0',
  `count` bigint(20) DEFAULT '0',
  `path` varchar(500) DEFAULT NULL,
  `seo_title` varchar(500) DEFAULT NULL,
  `seo_keywords` varchar(500) DEFAULT NULL,
  `seo_description` varchar(500) DEFAULT NULL,
  `list_tpl` varchar(50) DEFAULT NULL,
  `one_tpl` varchar(50) DEFAULT NULL,
  `listorder` int(5) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`term_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;
INSERT INTO `sp_terms` VALUES (1, '公司简介', '', 'article', '', 0, 0, '0-1', '', '', '', 'list_default', 'one_default', 0, 1);
INSERT INTO `sp_terms` VALUES (6, '企业使命Left', '', 'article', '', 0, 0, '0-6', '', '', '', 'list_default', 'one_default', 0, 1);
INSERT INTO `sp_terms` VALUES (7, '产品与服务', '', 'article', '', 0, 0, '0-7', '', '', '', 'list_default', 'one_default', 0, 1);
INSERT INTO `sp_terms` VALUES (4, '企业使命一', '', 'article', '', 0, 0, '0-4', '', '', '', 'list_default', 'one_default', 0, 1);
INSERT INTO `sp_terms` VALUES (5, '企业使命二', '', 'article', '', 0, 0, '0-5', '', '', '', 'list_default', 'one_default', 0, 1);
INSERT INTO `sp_terms` VALUES (8, '企业新闻', '', 'article', '', 0, 0, '0-8', '', '', '', 'list_default', 'one_default', 0, 1);
CREATE TABLE `sp_term_relationships` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `listorder` int(10) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tid`),
  KEY `term_taxonomy_id` (`term_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=65 ;
INSERT INTO `sp_term_relationships` VALUES (41, 194, 4, 3, 1);
INSERT INTO `sp_term_relationships` VALUES (40, 193, 4, 2, 1);
INSERT INTO `sp_term_relationships` VALUES (39, 192, 4, 1, 1);
INSERT INTO `sp_term_relationships` VALUES (38, 191, 1, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (37, 190, 1, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (36, 189, 1, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (46, 199, 6, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (43, 196, 5, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (44, 197, 5, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (45, 198, 5, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (47, 200, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (48, 201, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (49, 202, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (50, 203, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (51, 204, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (52, 205, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (53, 206, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (54, 207, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (55, 208, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (56, 209, 7, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (57, 210, 8, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (58, 211, 8, 0, 1);
INSERT INTO `sp_term_relationships` VALUES (59, 212, 8, 0, 1);

CREATE TABLE `sp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE `sp_users` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login` varchar(60) NOT NULL DEFAULT '',
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nicename` varchar(50) NOT NULL DEFAULT '',
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `user_url` varchar(100) NOT NULL DEFAULT '',
  `last_login_ip` varchar(16) NOT NULL,
  `last_login_time` datetime NOT NULL,
  `create_time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  `display_name` varchar(250) NOT NULL DEFAULT '',
  `role_id` smallint(6) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  KEY `user_login_key` (`user_login`),
  KEY `user_nicename` (`user_nicename`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;