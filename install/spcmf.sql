-- phpMyAdmin SQL Dump
-- version 2.10.3
-- http://www.phpmyadmin.net
-- 
-- 主机: localhost
-- 生成日期: 2014 年 01 月 21 日 13:26
-- 服务器版本: 5.5.29
-- PHP 版本: 5.3.10-1ubuntu3.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

-- 
-- 数据库: `spcms`
-- 

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_access`
-- 

CREATE TABLE `sp_access` (
  `role_id` smallint(6) unsigned NOT NULL,
  `g` varchar(20) NOT NULL COMMENT '项目',
  `m` varchar(20) NOT NULL COMMENT '模块',
  `a` varchar(20) NOT NULL COMMENT '方法',
  KEY `groupId` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_ad`
-- 

CREATE TABLE `sp_ad` (
  `ad_id` bigint(20) NOT NULL AUTO_INCREMENT,
  `ad_name` varchar(255) NOT NULL,
  `ad_content` text,
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ad_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_admin_panel`
-- 

CREATE TABLE `sp_admin_panel` (
  `menuid` mediumint(8) unsigned NOT NULL,
  `userid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `name` char(32) DEFAULT NULL,
  `url` char(255) DEFAULT NULL,
  `datetime` int(10) unsigned DEFAULT '0',
  UNIQUE KEY `userid` (`menuid`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_asset`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_commentmeta`
-- 

CREATE TABLE `sp_commentmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `comment_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `comment_id` (`comment_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;



-- 
-- 表的结构 `sp_links`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_members`
-- 

CREATE TABLE `sp_members` (
  `ID` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_login_name` varchar(25) NOT NULL,
  `user_pass` varchar(64) NOT NULL DEFAULT '',
  `user_nickname` varchar(50) NOT NULL,
  `user_pic_assetid` int(8) NOT NULL,
  `sign_words` varchar(200) NOT NULL,
  `user_email` varchar(100) NOT NULL DEFAULT '',
  `last_login_ip` varchar(16) NOT NULL,
  `last_login_time` int(12) NOT NULL,
  `create_time` int(12) NOT NULL,
  `user_activation_key` varchar(60) NOT NULL DEFAULT '',
  `user_status` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID`),
  KEY `user_nicename` (`user_nickname`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_menu`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_nav`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_nav_cat`
-- 

CREATE TABLE `sp_nav_cat` (
  `navcid` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `active` int(1) NOT NULL DEFAULT '1',
  `remark` text,
  PRIMARY KEY (`navcid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_oauth_member`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_options`
-- 

CREATE TABLE `sp_options` (
  `option_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` longtext NOT NULL,
  `autoload` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`option_id`),
  UNIQUE KEY `option_name` (`option_name`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_postmeta`
-- 

CREATE TABLE `sp_postmeta` (
  `meta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`meta_id`),
  KEY `post_id` (`post_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_posts`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_role`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COMMENT='角色信息列表' AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_role_user`
-- 

CREATE TABLE `sp_role_user` (
  `role_id` mediumint(9) unsigned DEFAULT NULL,
  `user_id` char(32) DEFAULT NULL,
  KEY `group_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_slide`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_slide_cat`
-- 

CREATE TABLE `sp_slide_cat` (
  `cid` bigint(20) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(255) NOT NULL,
  `cat_idname` varchar(255) NOT NULL,
  `cat_remark` text,
  `cat_status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`cid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_terms`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_term_relationships`
-- 

CREATE TABLE `sp_term_relationships` (
  `tid` bigint(20) NOT NULL AUTO_INCREMENT,
  `object_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `term_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `listorder` int(10) NOT NULL DEFAULT '0',
  `status` int(2) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tid`),
  KEY `term_taxonomy_id` (`term_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_usermeta`
-- 

CREATE TABLE `sp_usermeta` (
  `umeta_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0',
  `meta_key` varchar(255) DEFAULT NULL,
  `meta_value` longtext,
  PRIMARY KEY (`umeta_id`),
  KEY `user_id` (`user_id`),
  KEY `meta_key` (`meta_key`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

-- 
-- 表的结构 `sp_users`
-- 

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
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

-- --------------------------------------------------------

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
INSERT INTO `sp_menu` VALUES(303, 260, 'Admin', 'Backup', 'index', '', 1, 1, '数据备份', '', '', 0);
INSERT INTO `sp_menu` VALUES(304, 260, 'Admin', 'Backup', 'restore', '', 1, 1, '数据恢复', '', '', 0);