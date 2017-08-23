#2014.2.17
CREATE TABLE IF NOT EXISTS `moneylog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `domain` varchar(255) DEFAULT NULL COMMENT 'ÓòÃû',
  `type` varchar(32) NOT NULL COMMENT '·ÖÀà£¬³äÖµ»¹ÊÇÏû·Ñ',
  `create_time` datetime NOT NULL,
  `money` int(11) NOT NULL COMMENT '½ð¶î',
  `mem` varchar(255) NOT NULL COMMENT '±¸×¢',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`,`domain`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '²ú¿ÚÐòÁÐ',
  `name` varchar(255) NOT NULL COMMENT '²úÆ·Ãû³Æ',
  `create_time` datetime NOT NULL COMMENT '´´½¨Ê±¼ä',
  `price` int(11) NOT NULL COMMENT '²úÆ·¼Û¸ñ',
  `description` text COMMENT '²úÆ·ÃèÊö',
  `server` varchar(64) NOT NULL,
  `rrl` varchar(255) DEFAULT NULL,
  `flags` int(6) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `server` (`server`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `setting` (
  `name` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE  `domain` ADD  `pid` INT( 6 ) NULL AFTER  `custom_ns`;
ALTER TABLE  `domain` ADD  `pid_expire_time` DATETIME NULL AFTER  `pid`;
#2014.3.7
ALTER TABLE  `server` ADD  `passwd` VARCHAR( 255 ) NULL AFTER  `name`;
CREATE TABLE IF NOT EXISTS `allowserver` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `server` varchar(64) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE  `ns_ip_pool` ADD  `remark` VARCHAR( 255 ) NULL AFTER  `expire_time`;
--
-- ±íµÄ½á¹¹ `blog`
--

CREATE TABLE IF NOT EXISTS `blog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- ×ª´æ±íÖÐµÄÊý¾Ý `blog`
--

INSERT INTO `blog` (`id`, `title`, `link`) VALUES
(2, 'Ê²Ã´ÊÇ×Ô¶¨Òå½âÎö£¿', 'http://blog.dnsdun.com/?p=22'),
(3, 'dns¶ÜÔõÃ´ÉèÖÃÓòÃû½âÎö£¿', 'http://blog.dnsdun.com/?p=24'),
(4, 'DNS¶ÜÐÂÔö¼Ó¡°²Ù×÷ÈÕÖ¾¡±¹¦ÄÜ', 'http://blog.dnsdun.com/?p=31'),
(5, 'Ê²Ã´ÊÇQPS', 'http://blog.dnsdun.com/?p=17'),
(6, '¹úÄÚ»¥ÁªÍø¸ùÓò³öÏÖÖØ´ó¹ÊÕÏ', 'http://blog.dnsdun.com/?p=12');
ALTER TABLE  `server` ADD  `group_view` VARCHAR( 255 ) NULL AFTER  `ip_count` ,
ADD  `pid` INT( 6 ) NOT NULL DEFAULT  '0' AFTER  `group_view`;
ALTER TABLE  `product` ADD  `groupview` VARCHAR( 128 ) NULL AFTER  `flags`;
ALTER TABLE  `server` ADD  `remark` TEXT NULL AFTER  `pid`;
ALTER TABLE  `server` ADD  `soa` VARCHAR( 255 ) NULL AFTER  `group_view`;
ALTER TABLE  `domain` ADD  `pid_price` INT( 11 ) NOT NULL DEFAULT  '0' AFTER  `pid_expire_time` ,
ALTER TABLE  `domain`  ADD  `admin_remark` VARCHAR( 255 ) NULL AFTER  `pid_price`;
ALTER TABLE  `domain` ADD  `auto_renew` TINYINT NOT NULL DEFAULT  '1' AFTER  `admin_remark`;
ALTER TABLE  `users` ADD  `admin_remark` VARCHAR( 255 ) NULL AFTER  `soa_email`;
--
--Ìí¼ÓË÷Òý
--
ALTER TABLE `domain` ADD INDEX ( `uid` , `pid_expire_time` ) ;
ALTER TABLE  `record` ADD INDEX (  `domain` ,  `value` ) ;

CREATE TABLE IF NOT EXISTS `operatelog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `source` varchar(64) NOT NULL,
  `log_level` tinyint(4) NOT NULL DEFAULT '0',
  `operate_time` datetime NOT NULL,
  `mem` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `source` (`source`,`operate_time`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--2014.3.30
--
-- ±íµÄ½á¹¹ `domaingroup`
--

CREATE TABLE IF NOT EXISTS `domaingroup` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `gid` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uid` (`uid`,`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE  `domain` ADD  `gid` TINYINT NOT NULL DEFAULT  '0' AFTER  `uid`;
ALTER TABLE  `domain` ADD INDEX (  `uid` ,  `gid` ) ;

ALTER TABLE  `ns_ip_pool` ADD  `name` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `id`;
ALTER TABLE  `ns_ip_pool` ADD  `skey` VARCHAR( 255 ) NULL DEFAULT NULL AFTER  `name`;
--
--2014-05-08--
--
ALTER TABLE  `domain` ADD INDEX (  `created_on` );

--
-- ±íµÄ½á¹¹ `domaintld` 2014-05-23
--

CREATE TABLE IF NOT EXISTS `domaintld` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tld` varchar(128) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'com.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'net.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'org.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'ac.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'bj.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'sh.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'tj.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'cq.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'he.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'sx.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'nm.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'ln.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'jl.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'hl.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'js.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'zj.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'ah.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'fj.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'jx.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'sd.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'ha.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'hb.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'hn.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'gd.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'gx.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'hi.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'sc.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'gz.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'yn.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'xz.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'sh.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'gs.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'qh.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'nx.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'xj.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'tw.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'hk.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'com.tw',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'net.tw',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'mo.cn',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'org.tw',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'com.hk',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'net.hk',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'org.hk',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'cn.com',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'cn.net',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'cn.org',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'com.ru',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'com.au',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'net.ru',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'net.au',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'com.de',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'com.co',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'com.kg',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'com.es',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'net.in',  '1');
INSERT INTO  `domaintld` (`id` ,`tld` ,`status`) VALUES (NULL ,  'in.net',  '1');
--
-- 05.26
--
ALTER TABLE  `users` ADD  `divided` TINYINT( 4 ) NOT NULL DEFAULT  '0' AFTER  `proxy`;
ALTER TABLE  `users` CHANGE  `proxy`  `proxy` INT( 11 ) NOT NULL DEFAULT  '0';
ALTER TABLE  `users` ADD INDEX (  `proxy` );
--
-- 06-09
--
ALTER TABLE `users` ADD `ns3_id` INT( 8 ) NOT NULL DEFAULT '0' AFTER `ns2_id` ,
ADD `ns4_id` INT( 8 ) NOT NULL DEFAULT '0' AFTER `ns3_id` ;
ALTER TABLE `domain` ADD `ns3` INT( 11 ) NOT NULL DEFAULT '0' AFTER `ns2` ,
ADD `ns4` INT( 11 ) NOT NULL DEFAULT '0' AFTER `ns3` ;
--
-- ±íµÄ½á¹¹ `promostr`
--

CREATE TABLE IF NOT EXISTS `promostr` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `batch` int(6) NOT NULL,
  `keystr` varchar(255) NOT NULL COMMENT 'ÓÅ»ÝÂë×Ö·û´®',
  `price` int(11) NOT NULL,
  `server` varchar(32) NOT NULL COMMENT 'serverÃû³Æ',
  `expire_time` datetime NOT NULL COMMENT '¹ýÆÚÊ±¼ä',
  `use_time` datetime DEFAULT NULL COMMENT 'Ê¹ÓÃÊ±¼ä',
  `use_uid` int(11) NOT NULL DEFAULT '0',
  `use_domain` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '×´Ì¬,¿É¿ØÖÆÊÇ·ñÆôÓÃ',
  PRIMARY KEY (`id`),
  UNIQUE KEY `batch` (`batch`,`keystr`,`server`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- ±íµÄ½á¹¹ `notice`
--

CREATE TABLE IF NOT EXISTS `notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `domain` varchar(255) NOT NULL DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `body` text NOT NULL,
  `createtime` datetime NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
ALTER TABLE `server` ADD `allow_buy_pid` VARCHAR( 255 ) NOT NULL DEFAULT '0' AFTER `pid` ;


-- 2014-06-23
-- ±íµÄ½á¹¹ `proxysetting`
--

CREATE TABLE IF NOT EXISTS `proxysetting` (
  `server` varchar(64) NOT NULL,
  `name` varchar(255) NOT NULL,
  `value` text,
  PRIMARY KEY (`server`,`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
--
-- ±íµÄ½á¹¹ `attack`
--

CREATE TABLE IF NOT EXISTS `attack` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL,
  `unlocktime` datetime NOT NULL,
  `time_val` int(6) NOT NULL DEFAULT '0',
  `createtime` datetime NOT NULL,
  `server` varchar(64) NOT NULL,
  `noattackcount` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `domain` (`domain`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
--
-- ±íµÄ½á¹¹ `blockns`
--

CREATE TABLE IF NOT EXISTS `blockns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ns` varchar(255) NOT NULL,
  `server` varchar(64) NOT NULL DEFAULT '0',
  `usedomain` varchar(255) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '0',
  `recordid` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ns` (`ns`,`server`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

ALTER TABLE `product` ADD `blockns` TINYINT( 4 ) NOT NULL DEFAULT '0' AFTER `status` ;
ALTER TABLE `moneylog` ADD `remark` VARCHAR( 255 ) NULL AFTER `mem` ;
ALTER TABLE `server` ADD `email` VARCHAR( 255 ) NULL AFTER `remark` ;
--
--06-30
--
ALTER TABLE `ns` ADD `proxy_uid` INT( 11 ) NOT NULL DEFAULT '0' AFTER `auto_flag`;
ALTER TABLE `domain` ADD `blockns_id` INT( 11 ) NOT NULL DEFAULT '0' AFTER `auto_renew` ;
ALTER TABLE `moneylog` ADD `remark` VARCHAR( 255 ) NOT NULL DEFAULT '0' AFTER `mem` ;

--
--07-07
--
ALTER TABLE `ns` ADD INDEX ( `proxy_uid` ) ;
ALTER TABLE `attack` ADD remark varchar(255) null;
ALTER TABLE `promostr` ADD paystatus TINYINT( 4 ) NOT NULL DEFAULT '0';
ALTER TABLE `admins` ADD `action_list` text default 0;

--
--创建时间 2014-9-4
--
--
-- Table structure for table `proxyrecord`
--
CREATE TABLE IF NOT EXISTS `proxyrecord` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT '客户uid',
  `domain` varchar(255) NOT NULL COMMENT '购买产品域名',
  `money` int(11) NOT NULL COMMENT '消费金额',
  `proxy_money` int(11) NOT NULL,
  `proxy_uid` int(11) NOT NULL COMMENT '代理uid',
  `status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态',
  `mem` varchar(255) DEFAULT NULL COMMENT '备注',
  `admin` varchar(64) NOT NULL COMMENT '管理员',
  `enter_time` datetime DEFAULT NULL COMMENT '分成确认时间',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  `proxy_divided` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `proxy_uid` (`proxy_uid`),
  KEY `uid` (`uid`),
  KEY `status` (`status`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=135 ;

--
--创建时间2014-9-16
--
ALTER TABLE `product` ADD product_order TINYINT( 4 ) NOT NULL DEFAULT '0';
ALTER TABLE `product` ADD INDEX `product_order`(`product_order`);
--
--创建时间2014-9-17
--
ALTER TABLE `proxyrecord` ADD remark VARCHAR(255) NULL DEFAULT 'NULL';

--创建2014-9-20 新版

ALTER TABLE `view`  DROP `forward`;
ALTER TABLE `record` DROP INDEX `domain` ,ADD INDEX `domain` ( `domain` , `name` , `view` , `t` , `remark` ) ;
ALTER TABLE `domain`  DROP `forward`;
CREATE TABLE IF NOT EXISTS `sync_log2` (
  `server` varchar(16) NOT NULL,
  `domain` varchar(255) DEFAULT NULL,
  `serial` bigint(20) NOT NULL,
  `op_slave` tinyint(4) DEFAULT '0',
  `op` int(11) NOT NULL,
  `op_body` longtext NOT NULL,
  `op_ip` varchar(255) NOT NULL,
  `op_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`server`,`serial`),
  KEY `domain` (`domain`,`op_slave`,`op_time`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `domain` ADD `cdn_id` INT NOT NULL DEFAULT '0' AFTER `old_zsk` ;

--创建时间
--2014-10-30
ALTER TABLE `record` ADD cb_domain_id INT( 11 ) NOT NULL DEFAULT '0';

--2014-11-18
ALTER TABLE `view` ADD `flag` INT( 11 ) NOT NULL DEFAULT '0' AFTER `server` ;

--
-- Table structure for table `cdn_admins`
--2014-11-8

CREATE TABLE IF NOT EXISTS `cdn_admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) DEFAULT NULL COMMENT 'cdn站点名称',
  `passwd` varchar(255) DEFAULT NULL COMMENT '密码',
  `salt` varchar(255) NOT NULL COMMENT '盐',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

--
-- Table structure for table `cdn_log`
--2014-11-8

CREATE TABLE IF NOT EXISTS `cdn_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) NOT NULL COMMENT '用户域名',
  `cb_domain` varchar(255) NOT NULL COMMENT 'cdn产品域名',
  `cdn_pid` int(11) NOT NULL COMMENT 'cdn产品id',
  `create_time` datetime NOT NULL COMMENT '记录创建时间',
  `money` int(11) NOT NULL COMMENT '消费金额',
  `type` tinyint(4) NOT NULL COMMENT '记录类型',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='6' AUTO_INCREMENT=275 ;

--
-- Table structure for table `cdn_product`
--2014-11-8

CREATE TABLE IF NOT EXISTS `cdn_product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cb_uid` int(11) NOT NULL COMMENT 'cdn用户id',
  `name` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'cdn产品名称',
  `price` int(11) NOT NULL COMMENT '价格',
  `cb_domain` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'cdnbest的域名',
  `cb_key` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'cdn产品秘钥',
  `cb_pid` int(11) NOT NULL COMMENT 'cdnbest产品id',
  `audit` tinyint(4) NOT NULL COMMENT '产品是否审核',
  `cb_bs` varchar(255) CHARACTER SET utf8 NOT NULL,
  `cb_host` varchar(255) CHARACTER SET utf8 NOT NULL COMMENT 'cdn产品ip',
  PRIMARY KEY (`id`),
  KEY `uid` (`cb_uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

--
-- Table structure for table `cdn_refund_log`
--2014-11-8

CREATE TABLE IF NOT EXISTS `cdn_refund_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'dnsdun用户id',
  `cb_domain` varchar(255) NOT NULL COMMENT '产品域名',
  `money` int(11) NOT NULL COMMENT '退款金额',
  `status` tinyint(4) NOT NULL COMMENT '退款受理状态',
  `create_time` datetime NOT NULL COMMENT '创建时间',
  `remark` varchar(255) DEFAULT NULL COMMENT '受理备注',
  `update_time` datetime NOT NULL COMMENT '受理时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

--
-- Table structure for table `cdn_site`
--2014-11-8

CREATE TABLE IF NOT EXISTS `cdn_site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'dnsdun uid',
  `domain` varchar(255) CHARACTER SET utf8 DEFAULT NULL COMMENT 'cdn站点名称',
  `pid` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '站点状态',
  `add_time` datetime NOT NULL,
  `update_time` datetime NOT NULL,
  `expire_time` datetime DEFAULT NULL COMMENT '过期时间',
  `month` tinyint(4) NOT NULL COMMENT '产品购买时长',

  PRIMARY KEY (`id`),
  KEY `uid` (`uid`),
  KEY `pid` (`pid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=410 ;
--2014-11-26
ALTER TABLE `users` ADD `openid` VARCHAR( 32 ) NULL AFTER `admin_remark`;
--2014-12-04
ALTER TABLE `users` ADD `sms` TINYINT( 4 ) NOT NULL DEFAULT '0' AFTER `tel` ;
--2014-12-8
ALTER TABLE `cdn_product` ADD `uid` INT(11) NOT NULL DEFAULT '0' ;
--2014-12-9
ALTER TABLE `users` ADD `scan_time` DATETIME NOT NULL ;
--2014-12-11
ALTER TABLE `domain` ADD `setting_flags` INT( 8 ) NOT NULL DEFAULT '1' AFTER `flags`;
2014/12/11


--2014-12-17
--删除字段
ALTER TABLE `cdn_product` DROP COLUMN price;
ALTER TABLE `cdn_site` DROP COLUMN expire_time;
ALTER TABLE `cdn_site` DROP COLUMN month;
--
-- Table structure for table `cdn_product_view`
--

CREATE TABLE IF NOT EXISTS `cdn_product_view` (
  `cpid` int(11) NOT NULL COMMENT 'cdn_product表id',
  `server` varchar(255) DEFAULT NULL,
  `cp_switch` tinyint(4) NOT NULL COMMENT '产品开关1开0关',
  PRIMARY KEY (`cpid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2014-12-18
-- Table structure for table `domain_reserved`
--

CREATE TABLE IF NOT EXISTS `domain_reserved` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `domain` varchar(255) DEFAULT NULL COMMENT '预留域名',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--2014-12-19
ALTER TABLE `monitor` ADD `notice_flags` INT( 11 ) NOT NULL DEFAULT '0' COMMENT '监控通知类型' AFTER `server` 
--2014-12-24
ALTER TABLE `users` ADD `flags` INT NOT NULL DEFAULT 1;
ALTER TABLE `cdn_product` ADD `cb_host` varchar(255) NULL COMMENT 'cdn产品ip'

--2014-12-25
ALTER TABLE `domain` ADD `cdn_status` TINYINT NOT NULL DEFAULT '2' COMMENT 'cdn站点状态' AFTER `cdn_domain` 

--2014-12-31
ALTER TABLE `users` ADD `free_message` INT( 6 ) NOT NULL DEFAULT '0' AFTER `flags` ;

--2015-1-15
ALTER TABLE `users` ADD `api_ips` VARCHAR( 255 ) NULL DEFAULT NULL COMMENT 'api允许ip' AFTER `api_key` ;
--2015-01-06
ALTER TABLE `moneylog` ADD `server` VARCHAR( 32 ) NULL AFTER `status`;
ALTER TABLE `moneylog` ADD INDEX ( `server` );

--2015-2-27
ALTER TABLE `domain` ADD `local_register` TINYINT NOT NULL DEFAULT '0' COMMENT '默认外部注册,1本地注册' AFTER `parent_domain`

--域名注册表
--2015-2-28
--
-- Table structure for table `domain_register_agent`
--

CREATE TABLE IF NOT EXISTS `domain_register_agent` (
  `agent_name` varchar(255) NOT NULL DEFAULT '' COMMENT '代理商名称',
  `agent_account` varchar(255) NOT NULL COMMENT '代理账号',
  `agent_passw` varchar(255) DEFAULT NULL COMMENT '代理密码',
  `agent_key` varchar(255) DEFAULT NULL COMMENT '代理秘钥',
  `agent_http` varchar(255) NOT NULL COMMENT '代理接口地址',
  `encode` varchar(100) DEFAULT NULL COMMENT '编码设置',
  PRIMARY KEY (`agent_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='域名注册代理设置';

--
-- Table structure for table `domain_register_log`
--

CREATE TABLE IF NOT EXISTS `domain_register_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `operation_uid` int(11) NOT NULL COMMENT '操作者id',
  `hold_uid` int(11) NOT NULL COMMENT '持有者id',
  `domain` varchar(255) NOT NULL COMMENT '域名',
  `remark` varchar(255) DEFAULT NULL COMMENT '备注',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT '状态',
  `log_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='域名注册操作冲突log' AUTO_INCREMENT=1 ;

--
-- Table structure for table `domain_register_user`
--

CREATE TABLE IF NOT EXISTS `domain_register_user` (
  `uid` int(11) NOT NULL COMMENT 'dnsdun用户id',
  `user_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '用户类型0个人1企业',
  `enterprise` varchar(255) NOT NULL COMMENT '域名所有者企业或个人',
  `enterprise_en` varchar(255) NOT NULL COMMENT '域名所有者企业或个人英文名称',
  `contacts` varchar(255) NOT NULL COMMENT '联系人中文名',
  `contacts_en` varchar(255) NOT NULL COMMENT '联系人英文名称',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `countries_region` varchar(255) NOT NULL COMMENT '国家地区',
  `province` varchar(255) NOT NULL COMMENT '省份',
  `city` varchar(255) NOT NULL COMMENT '城市',
  `city_en` varchar(255) NOT NULL COMMENT '城市英文名称',
  `address` varchar(500) NOT NULL COMMENT '通信地址',
  `address_en` varchar(500) NOT NULL COMMENT '通信英文地址',
  `zip_code` varchar(100) NOT NULL COMMENT '邮政编码',
  `phone` varchar(100) NOT NULL COMMENT '移动电话或座机',
  `fax0` varchar(100) DEFAULT NULL COMMENT '传真国家码',
  `fax1` varchar(100) DEFAULT NULL COMMENT '传真区号',
  `fax2` varchar(100) DEFAULT NULL COMMENT '传真号码',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户注册域名资料';

--
-- Table structure for table `domain_shift_to`
--

CREATE TABLE IF NOT EXISTS `domain_shift_to` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL COMMENT 'dnsdun用户id',
  `name` varchar(255) NOT NULL COMMENT '转入域名',
  `passw` varchar(255) NOT NULL COMMENT '转入密码',
  `shift_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '域名转入状态0正在转入1转入成功',
  `agent_name` varchar(255) DEFAULT NULL COMMENT '域名转入代理商名称',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='域名转入申请' AUTO_INCREMENT=18 ;

--
-- Table structure for table `domain_suffix`
--

CREATE TABLE IF NOT EXISTS `domain_suffix` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `suffix` varchar(100) DEFAULT NULL COMMENT '域名后缀名称',
  `preferential_price` int(11) NOT NULL DEFAULT '0' COMMENT '域名优惠价格',
  `first_price` int(11) NOT NULL DEFAULT '0' COMMENT '域名首次购买价格',
  `renewal_price` int(11) NOT NULL DEFAULT '0' COMMENT '域名续费价格',
  `entrust_price` int(11) NOT NULL DEFAULT '0' COMMENT '域名转入,委托管理价格',
  PRIMARY KEY (`id`),
  UNIQUE KEY `suffix` (`suffix`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='域名后缀管理' AUTO_INCREMENT=27 ;

--
-- Table structure for table `manage_register_domain`
--

CREATE TABLE IF NOT EXISTS `manage_register_domain` (
  `uid` int(11) NOT NULL COMMENT 'dnsdun用户id',
  `name` varchar(255) NOT NULL COMMENT '域名名称',
  `create_time` datetime NOT NULL COMMENT '域名创建时间',
  `renewal_time` datetime NOT NULL COMMENT '续费时间',
  `status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0注册成功1等待审核',
  `dns_status` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0dns未修改1默认2自定义',
  `agent_name` varchar(255) NOT NULL COMMENT '代理商名称',
  `dns1` varchar(255) NOT NULL,
  `dns2` varchar(255) NOT NULL,
  PRIMARY KEY (`name`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='域名注册管理表';

--
--2015-3-4
--
INSERT INTO `manage_register_domain` (`uid`, `name`, `create_time`, `renewal_time`, `status`, `dns_status`, `agent_name`, `dns1`, `dns2`) VALUES
(10024, '朱德朝.com', '2015-01-22 09:07:54', '2016-01-22 09:07:54', 0, 0, 'xinnet', '', ''),
(1239, 'cdnbest.xyz', '2015-03-04 09:07:54', '2016-03-04 09:07:54', 0, 0, 'xinnet', '', '');

--2015-3-6
ALTER TABLE `cdn_log` DROP `type` ;
ALTER TABLE `cdn_log` DROP `money` ;

--2015-3-10
ALTER TABLE `domain_suffix` DROP `id` ;
ALTER TABLE `domain_suffix` CHANGE `suffix` `suffix` VARCHAR( 100 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '域名后缀名称'
ALTER TABLE `domain_suffix` ADD `suffix_type` TINYINT NOT NULL DEFAULT '0' COMMENT '1英文域名,2中文域名' AFTER `entrust_price` 
ALTER TABLE `domain_suffix` ADD PRIMARY KEY ( `suffix` , `suffix_type` ) 




ALTER TABLE `record` ADD `cdn_id` VARCHAR( 64 ) NULL DEFAULT NULL ;

--2015-3-19
ALTER TABLE `manage_register_domain` CHANGE `status` `status` TINYINT( 4 ) NOT NULL DEFAULT '0' COMMENT '0注册成功1等待审核2转入域名'
--2015-5-28
ALTER TABLE `cdn_product` ADD `flow_price` INT NOT NULL AFTER `cb_host` ,
ADD `flow` INT NOT NULL AFTER `flow_price` 
--2015-5-28
ALTER TABLE `domain` ADD `cdn_flow_limit` INT NOT NULL AFTER `passwd` ,
ADD `cdn_flow_sum` INT NOT NULL AFTER `cdn_flow_limit` 


alter table `cloudproduct` drop descibe 
alter table `cloudproduct` add `mem` text  NULL,
--2015-6-5
ALTER TABLE `container` ADD `auto_renew` INT NOT NULL DEFAULT '0' AFTER `mem` 


ALTER TABLE `container_product` ADD `core` TINYINT( 4 ) NOT NULL DEFAULT '0' AFTER `cpu` 

ALTER TABLE `container` ADD `custom_image` tinyint(1) NOT NULL DEFAULT '0' AFTER `mirro`,

ALTER TABLE `container` ADD INDEX ( `uid` , `id` ) 

CREATE TABLE `custom_image` (
 `id` int(11) NOT NULL AUTO_INCREMENT,
 `uid` int(11) NOT NULL,
 `name` varchar(128) NOT NULL,
 `mem` text NOT NULL,
 `cmd` text NOT NULL,
 PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8



ALTER TABLE `container` CHANGE `auto_renew` `auto_renew` INT( 11 ) NOT NULL DEFAULT '1'


ALTER TABLE `admins` ADD `panel` VARCHAR( 255 ) NULL AFTER `name` 

ALTER TABLE `admins` ADD `salt` VARCHAR( 32 ) NULL AFTER `name` 


ALTER TABLE `custom_image` ADD INDEX ( `uid` ) 
--2015-6-23
ALTER TABLE `promostr` ADD `ctype` INT NOT NULL DEFAULT '0' AFTER `paystatus` 
--2015-6-25
ALTER TABLE `promostr` ADD `mem` TEXT NOT NULL AFTER `ctype` 

