# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: localhost (MySQL 5.6.35)
# Database: tp5
# Generation Time: 2017-08-15 13:41:06 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
# Dump of database tax
# ------------------------------------------------------------
drop DATABASE if  EXISTS `tax`;
CREATE DATABASE if NOT EXISTS `tax`;

USE `tax`;

# Dump of table tax_company
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_company`;

CREATE TABLE `tax_company` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '公司主键',
  `name` VARCHAR(100) DEFAULT NULL COMMENT '名称',
  `introduce` TEXT DEFAULT NULL COMMENT '公司介绍',
  `C_500` SMALLINT DEFAULT 0 COMMENT '中国500强',
  `W_500` SMALLINT DEFAULT 0 COMMENT '世界500强	',
  `CL_500` SMALLINT DEFAULT 0 COMMENT '中国上市500强',
  `T_100` TINYINT DEFAULT 0 COMMENT '跨国100强	',
  `NEEQ_rank` INT DEFAULT 0 COMMENT '新三板排名',
  `businessareas` VARCHAR(100)	DEFAULT NULL COMMENT '主营地区',
  `businessmodel` VARCHAR(50) DEFAULT NULL COMMENT '经营模式',
  `companystate`	VARCHAR(50) DEFAULT NULL COMMENT '企业状态',
  `maincustomer`	VARCHAR(50) DEFAULT NULL COMMENT '主要客户群',
  `businessscope`	VARCHAR(50) DEFAULT NULL COMMENT '经营范围',
	`maintrade`VARCHAR(50) DEFAULT NULL COMMENT '主营行业',
  `mainproduct`VARCHAR(50) DEFAULT NULL COMMENT '主营产品',
	`valueofexport`VARCHAR(50) DEFAULT NULL COMMENT '年营出口额',
	`brandname`VARCHAR(50) DEFAULT NULL COMMENT '品牌名称',
	`bankaccount`VARCHAR(50) DEFAULT NULL COMMENT '银行帐号',
	`factoryarea`VARCHAR(50) DEFAULT NULL COMMENT '厂房面积',
  `recentlyinspection`VARCHAR(30) DEFAULT NULL COMMENT '最近年检时间',
  `legalperson`VARCHAR(50) DEFAULT NULL COMMENT '企业法人',
	`registryauthority`VARCHAR(50) DEFAULT NULL COMMENT '登记机关',
	`registeredfund`VARCHAR(50) DEFAULT NULL COMMENT '注册资金',
	`turnover`VARCHAR(50) DEFAULT NULL COMMENT '年营业额',
	`companytype`VARCHAR(30) DEFAULT NULL COMMENT '企业类型',
 	`valueofimport`VARCHAR(50) DEFAULT NULL COMMENT '年营进口额',
	`productionpurchase`VARCHAR(50) DEFAULT NULL COMMENT '采购产品',
	`monthlyoutput`VARCHAR(50) DEFAULT NULL COMMENT '月产量',
	`operatingperiod`VARCHAR(20) DEFAULT NULL COMMENT '经营期限',
	`employeenumber`VARCHAR(40) DEFAULT NULL COMMENT '员工人数',
	`qualitycontrol`VARCHAR(20) DEFAULT NULL COMMENT '质量控制',
	`offerOEM`CHAR(4) DEFAULT NULL COMMENT '是否提供OEM',
  `depositbank`VARCHAR(50) DEFAULT NULL COMMENT '开户银行',
  `accountholder`VARCHAR(50) DEFAULT NULL COMMENT '开户人	',
	`establishedtime`VARCHAR(30) DEFAULT NULL COMMENT '成立时间',
  `companyemail`VARCHAR(50) DEFAULT NULL COMMENT '公司邮箱',
  `companypostcode` VARCHAR(20) DEFAULT NULL COMMENT '公司邮编',
  `companyphone` VARCHAR(30) DEFAULT NULL COMMENT '公司电话',
  `companyfax` VARCHAR(30) DEFAULT NULL COMMENT '公司传真',
  `companywebsite` VARCHAR(100) DEFAULT NULL COMMENT '公司网站',
  `administrativeareas`	VARCHAR(100) DEFAULT NULL COMMENT '行政区域',
  `companyareas`	VARCHAR(100) DEFAULT NULL COMMENT '公司地址',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table tax_theme_1
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_theme_1`;

CREATE TABLE `tax_theme_1` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` VARCHAR(100) DEFAULT NULL COMMENT '名称',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dump of table tax_theme_2
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_theme_2`;

CREATE TABLE `tax_theme_2` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `t1_id` INT unsigned NOT NULL COMMENT '外键，以及主题',
  `name` VARCHAR(100) DEFAULT NULL COMMENT '名称',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  FOREIGN KEY (t1_id) REFERENCES tax_theme_1(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table tax_theme_3
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_theme_3`;

CREATE TABLE `tax_theme_3` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `t2_id` INT unsigned NOT NULL COMMENT '外键，二级主题',
  `name` VARCHAR(100) DEFAULT NULL COMMENT '名称',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  FOREIGN KEY (t2_id) REFERENCES tax_theme_2(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table tax_user_admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_user_admin`;

CREATE TABLE `tax_user_admin` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `username` VARCHAR(50) DEFAULT NULL COMMENT '账号',
  `pass` VARCHAR(50) DEFAULT NULL COMMENT '密码',
  `roleid` TINYINT DEFAULT NULL COMMENT '角色',
  `remark` VARCHAR(50) DEFAULT NULL COMMENT '备注',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭；3->禁用',
  `logintime` INT DEFAULT NULL COMMENT '登陆时间',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  FOREIGN KEY (roleid) REFERENCES tax_role_admin(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# ------------------------------------------------------------
# Dump of table tax_role_admin

DROP TABLE IF EXISTS `tax_role_admin`;

CREATE TABLE `tax_role_admin` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` VARCHAR(50) DEFAULT NULL COMMENT '角色名',
  `remark` VARCHAR(50) DEFAULT NULL COMMENT '备注',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table tax_action_admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_action_admin`;

CREATE TABLE `tax_action_admin` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` VARCHAR(50) DEFAULT NULL COMMENT '操作名称',
  `tag` VARCHAR(50) DEFAULT NULL COMMENT '备注',
  `pid` VARCHAR(4) DEFAULT NULL COMMENT '父节点',
  `pids` VARCHAR(10) DEFAULT NULL COMMENT '父子节点关系',
  `level` TINYINT DEFAULT NULL COMMENT '层次',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table tax_role_action_admin
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_role_action_admin`;

CREATE TABLE `tax_role_action_admin` (
  `roleid` INT unsigned NOT NULL COMMENT '外键,角色id',
  `actionid` INT DEFAULT NULL COMMENT '外键,操作id',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`roleid`, `actionid`),
  FOREIGN KEY (roleid) REFERENCES tax_role_admin(id),
  FOREIGN KEY (actionid) REFERENCES tax_action_admin(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table tax_website_type
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_website_type`;

CREATE TABLE `tax_website_type` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` VARCHAR(100) DEFAULT NULL COMMENT '类型名',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table tax_website
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_website`;

CREATE TABLE `tax_website` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `type_id` INT DEFAULT NULL COMMENT '外键，类型',
  `name` VARCHAR(100) DEFAULT NULL COMMENT '名称',
  `url` VARCHAR(100) DEFAULT NULL COMMENT '网址',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  FOREIGN KEY (type_id) REFERENCES tax_website_type(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table tax_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_log`;

CREATE TABLE `tax_log` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `name` VARCHAR(100) DEFAULT NULL COMMENT '名称',
  `action_id` INT DEFAULT NULL COMMENT '外键，操作对象',
  `actiontime` INT DEFAULT NULL COMMENT '操作时间',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  FOREIGN KEY (action_id) REFERENCES tax_action_admin(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table tax_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_data`;

CREATE TABLE `tax_data` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `c_id` INT unsigned NOT NULL COMMENT '外键，公司',
  `theme_3_id` INT unsigned NOT NULL  COMMENT '外键，三级主题',
   `websitetype_id` TINYINT DEFAULT NULL COMMENT '外键，网站类型',
  `task_id` INT DEFAULT NULL COMMENT '任务编号',
  `title` varchar(100) COMMENT '标题',
  `content` text COMMENT '内容',
  `table` text COMMENT '表格',
  `event` TEXT DEFAULT NULL COMMENT '事件',
  `website` VARCHAR(100) DEFAULT NULL COMMENT '网址',
  `snapshoot` VARCHAR(100) DEFAULT NULL COMMENT '快照',
  `time` INT DEFAULT NULL COMMENT '时间',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  FOREIGN KEY (c_id) REFERENCES tax_company(id),
  FOREIGN KEY (theme_3_id) REFERENCES tax_theme_3(id),
  FOREIGN KEY (websitetype_id) REFERENCES tax_website_type(id),
   FOREIGN KEY (task_id) REFERENCES tax_task(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table tax_inform
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_inform`;

CREATE TABLE `tax_inform` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `detail` VARCHAR(100) DEFAULT NULL COMMENT '通知详情',
  `operation` VARCHAR(50) DEFAULT NULL COMMENT '操作',
  `priority` TINYINT DEFAULT NULL COMMENT '优先级',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table tax_inform_user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_inform_user`;

CREATE TABLE `tax_inform_user` (
  `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `inform_id` INT unsigned NOT NULL COMMENT '外键，通知',
  `user_id` INT unsigned NOT NULL  COMMENT '外键，用户',
  `solution` TINYINT DEFAULT NULL COMMENT '是否处理：1->是；2->否',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`),
  FOREIGN KEY (inform_id) REFERENCES tax_inform(id),
  FOREIGN KEY (user_id) REFERENCES tax_user_admin(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dump of table tax_task
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_task`;

CREATE TABLE `tax_task` (
   `id` INT unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
    `loop` INT DEFAULT NULL COMMENT '循环周期',
   `begintime` INT DEFAULT NULL COMMENT '开始时间',
   `endtime` INT DEFAULT NULL COMMENT '结束时间',
   `task_num` INT DEFAULT NULL COMMENT '任务量',
   `quantity_complete` INT DEFAULT NULL COMMENT '已完成数量',
   `time_predict` INT DEFAULT NULL COMMENT '预计耗时',
   `taskstatus` TINYINT DEFAULT NULL COMMENT '任务状态：0->正常；1->中断；2->结束',
   `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
   `createtime` INT DEFAULT NULL COMMENT '创建时间',
   `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

# Dump of table tax_tag
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_tag`;

CREATE TABLE `tax_tag` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键',
  `title` varchar(100) DEFAULT NULL COMMENT '标题',
  `section` varchar(50) DEFAULT NULL COMMENT '版块',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` int(11) DEFAULT NULL COMMENT '创建时间',
  `updatetime` int(11) DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


# Dump of table tax_task_website
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_task_website`;

CREATE TABLE `tax_task_website` (
  `task_id` INT DEFAULT NULL COMMENT '外键,任务id',
  `website_id` INT DEFAULT NULL COMMENT '外键,网站id',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`website_id`, `task_id`),
  FOREIGN KEY (website_id) REFERENCES tax_website(id),
  FOREIGN KEY (task_id) REFERENCES tax_task(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table tax_role_task_theme
# ------------------------------------------------------------

DROP TABLE IF EXISTS `tax_task_theme`;

CREATE TABLE `tax_task_theme` (
  `task_id` INT DEFAULT NULL COMMENT '外键,任务id',
  `theme_3_id` INT DEFAULT NULL COMMENT '外键,三级主题id',
  `status` TINYINT DEFAULT NULL COMMENT '状态：1->启用；2->关闭',
  `createtime` INT DEFAULT NULL COMMENT '创建时间',
  `updatetime` INT DEFAULT NULL COMMENT '更新时间',
  PRIMARY KEY (`task_id`, `theme_3_id`),
  FOREIGN KEY (task_id) REFERENCES tax_task(id),
  FOREIGN KEY (theme_3_id) REFERENCES tax_theme_3(id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
