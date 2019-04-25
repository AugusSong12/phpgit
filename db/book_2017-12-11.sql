# ************************************************************
# Sequel Pro SQL dump
# Version 4499
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: 127.0.0.1 (MySQL 5.5.52)
# Database: book
# Generation Time: 2017-12-11 03:06:34 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table acount
# ------------------------------------------------------------

DROP TABLE IF EXISTS `acount`;

CREATE TABLE `acount` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `balance` decimal(15,2) DEFAULT '0.00',
  `lastdt` datetime DEFAULT NULL,
  `type` char(1) DEFAULT 'u' COMMENT 'u:user,c:customer,m:manager',
  `payway` char(1) DEFAULT NULL,
  `bankno` int(50) DEFAULT NULL,
  `idno` varchar(100) DEFAULT NULL,
  `rate` decimal(15,2) DEFAULT '0.00' COMMENT '佣金比例',
  `locked` decimal(15,2) DEFAULT '0.00' COMMENT '保证金',
  `idname` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `acount` WRITE;
/*!40000 ALTER TABLE `acount` DISABLE KEYS */;

INSERT INTO `acount` (`id`, `userid`, `balance`, `lastdt`, `type`, `payway`, `bankno`, `idno`, `rate`, `locked`, `idname`)
VALUES
	(1,0,0.00,NULL,'u',NULL,NULL,'后台账户',0.00,NULL,NULL),
	(2,1,0.00,NULL,'u',NULL,NULL,'测试账号',0.00,0.00,NULL);

/*!40000 ALTER TABLE `acount` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table acountDetail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `acountDetail`;

CREATE TABLE `acountDetail` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `acountid` int(11) DEFAULT NULL,
  `lastbalance` decimal(15,2) DEFAULT NULL,
  `change` decimal(15,2) DEFAULT NULL,
  `ramark` varchar(100) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  `type` char(1) DEFAULT 'i' COMMENT 'i:income,t:提现',
  `pinzhen` varchar(50) DEFAULT NULL,
  `payway` char(1) DEFAULT NULL COMMENT 'a:alipay,w:weixin,b:bank',
  `orderid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `customerid` int(11) DEFAULT NULL,
  `status` char(1) DEFAULT '2' COMMENT '1准备 2成功,3已经结算',
  PRIMARY KEY (`id`),
  KEY `acountid` (`acountid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



# Dump of table customer
# ------------------------------------------------------------

DROP TABLE IF EXISTS `customer`;

CREATE TABLE `customer` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `passwd` varchar(50) NOT NULL DEFAULT '',
  `openid` varchar(50) NOT NULL,
  `alipayid` varchar(50) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  `logintimes` int(11) NOT NULL,
  `createdt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lastlogin` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;

INSERT INTO `customer` (`id`, `name`, `mobile`, `passwd`, `openid`, `alipayid`, `status`, `logintimes`, `createdt`, `lastlogin`)
VALUES
	(1,'','15005819707','e095ea8f0f86f070a9e650ab7bd42ab7','','','1',14,'2017-10-26 13:42:55','2017-12-08 11:31:55');

/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table faverit
# ------------------------------------------------------------

DROP TABLE IF EXISTS `faverit`;

CREATE TABLE `faverit` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `custid` int(11) DEFAULT NULL,
  `userid` int(11) DEFAULT NULL,
  `dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `faverit` WRITE;
/*!40000 ALTER TABLE `faverit` DISABLE KEYS */;

INSERT INTO `faverit` (`id`, `custid`, `userid`, `dt`)
VALUES
	(1,1,1,NULL);

/*!40000 ALTER TABLE `faverit` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table order
# ------------------------------------------------------------

DROP TABLE IF EXISTS `order`;

CREATE TABLE `order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dt` datetime NOT NULL,
  `userid` int(11) NOT NULL,
  `customerid` int(11) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '1未支付 2支付，0取消，4完成',
  `totle` decimal(10,2) NOT NULL,
  `paytype` char(1) NOT NULL,
  `remark` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `order` WRITE;
/*!40000 ALTER TABLE `order` DISABLE KEYS */;

INSERT INTO `order` (`id`, `dt`, `userid`, `customerid`, `status`, `totle`, `paytype`, `remark`)
VALUES
	(1,'2017-11-06 10:54:29',1,1,'',0.00,'a',''),
	(2,'2017-11-06 10:55:10',1,1,'',0.00,'a',''),
	(3,'2017-11-06 10:56:23',1,1,'',0.00,'a',''),
	(4,'2017-11-06 10:58:53',1,1,'',1200.00,'a',''),
	(5,'2017-11-06 11:01:00',1,1,'',1200.00,'a',''),
	(6,'2017-11-06 11:01:16',1,1,'',1200.00,'a',''),
	(7,'2017-11-06 11:17:27',1,1,'1',1200.00,'w',''),
	(8,'2017-11-06 11:23:17',1,1,'1',1200.00,'w',''),
	(9,'2017-11-06 11:24:03',1,1,'1',1200.00,'w',''),
	(10,'2017-11-08 16:23:38',1,1,'1',60.00,'a',''),
	(11,'2017-11-13 11:13:50',1,1,'1',40.00,'a',''),
	(12,'2017-11-14 11:14:03',1,1,'1',60.00,'a',''),
	(13,'2017-11-14 12:15:41',1,1,'1',60.00,'a',''),
	(14,'2017-11-16 16:22:39',1,1,'1',0.00,'',''),
	(15,'2017-11-16 16:23:15',1,1,'1',0.00,'',''),
	(16,'2017-11-24 09:55:51',1,0,'1',1800.00,'a',''),
	(17,'2017-12-06 15:14:27',1,1,'1',1200.00,'a',''),
	(18,'2017-12-11 10:09:46',1,1,'1',600.00,'a','');

/*!40000 ALTER TABLE `order` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table orderdetail
# ------------------------------------------------------------

DROP TABLE IF EXISTS `orderdetail`;

CREATE TABLE `orderdetail` (
  `orderid` int(11) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serviceid` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `num` int(11) NOT NULL,
  `begintime` datetime NOT NULL,
  `endtime` datetime NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `orderid` (`orderid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `orderdetail` WRITE;
/*!40000 ALTER TABLE `orderdetail` DISABLE KEYS */;

INSERT INTO `orderdetail` (`orderid`, `id`, `serviceid`, `price`, `num`, `begintime`, `endtime`, `name`)
VALUES
	(0,1,2,600.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(0,2,2,600.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(0,3,2,600.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(0,4,2,600.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(0,5,2,600.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(0,6,2,600.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(5,7,2,600.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(5,8,2,600.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(6,9,2,600.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(6,10,2,600.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(7,11,2,600.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(7,12,2,600.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(8,13,2,600.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(8,14,2,600.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(9,15,2,600.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(9,16,2,600.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(10,17,3,20.00,1,'2017-12-09 12:15:00','2017-12-09 13:15:00',NULL),
	(10,18,3,20.00,1,'2017-12-09 13:15:00','2017-12-09 14:15:00',NULL),
	(10,19,3,20.00,1,'2017-12-09 15:15:00','2017-12-09 16:15:00',NULL),
	(11,20,3,20.00,1,'2017-11-09 14:15:00','2017-11-09 15:15:00',NULL),
	(11,21,3,20.00,1,'2017-11-09 15:15:00','2017-11-09 16:15:00',NULL),
	(12,22,3,20.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(12,23,3,20.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(12,24,3,20.00,1,'2017-11-02 12:15:00','2017-11-02 13:15:00',NULL),
	(13,25,3,20.00,1,'2017-11-02 10:15:00','2017-11-02 11:15:00',NULL),
	(13,26,3,20.00,1,'2017-11-02 11:15:00','2017-11-02 12:15:00',NULL),
	(13,27,3,20.00,1,'2017-11-02 12:15:00','2017-11-02 13:15:00',NULL),
	(15,28,2,0.00,1,'2017-11-16 00:00:00','2017-11-17 00:00:00',NULL),
	(16,29,2,600.00,1,'2017-11-23 16:15:00','2017-11-23 17:15:00',NULL),
	(16,30,2,600.00,1,'2017-11-23 17:15:00','2017-11-23 18:15:00',NULL),
	(16,31,2,600.00,1,'2017-11-23 18:15:00','2017-11-23 19:15:00',NULL),
	(17,32,2,600.00,1,'2017-12-15 12:15:00','2017-12-15 13:15:00',NULL),
	(17,33,2,600.00,1,'2017-12-15 13:15:00','2017-12-15 14:15:00',NULL),
	(18,34,2,600.00,1,'2017-12-28 00:00:00','2017-12-28 00:00:00',NULL);

/*!40000 ALTER TABLE `orderdetail` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table service
# ------------------------------------------------------------

DROP TABLE IF EXISTS `service`;

CREATE TABLE `service` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `price` decimal(14,2) NOT NULL,
  `num` int(11) NOT NULL DEFAULT '1',
  `unit` int(11) NOT NULL,
  `begin1` time NOT NULL,
  `end1` time NOT NULL,
  `begin2` time DEFAULT NULL,
  `end2` time DEFAULT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  `viewtimes` int(11) NOT NULL DEFAULT '0',
  `userid` int(11) NOT NULL,
  `stopweekday` varchar(200) DEFAULT '',
  `vicationstart` date DEFAULT NULL,
  `pic` varchar(200) NOT NULL,
  `vicationstop` date DEFAULT NULL,
  `intevm` int(11) DEFAULT '10',
  `sales` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;

INSERT INTO `service` (`id`, `name`, `price`, `num`, `unit`, `begin1`, `end1`, `begin2`, `end2`, `status`, `viewtimes`, `userid`, `stopweekday`, `vicationstart`, `pic`, `vicationstop`, `intevm`, `sales`)
VALUES
	(1,'商户',100.00,1,60,'10:15:00','10:15:00','10:15:00','10:15:00','1',2,1,'',NULL,'',NULL,0,NULL),
	(2,'ashusausha',600.00,1,60,'10:15:00','22:15:00','10:15:00','10:15:00','2',1,1,'2,5','2017-01-01','','2017-10-01',0,NULL),
	(3,'wqd',20.00,1,60,'10:15:00','22:15:00','10:15:00','10:15:00','0',0,1,'','1970-01-01','pic/service/962112_DSC00497.jpg','1970-01-01',0,NULL),
	(4,'企业用户',34.00,1,60,'10:15:00','22:15:00','10:15:00','10:15:00','1',0,1,'',NULL,'',NULL,0,NULL),
	(5,'商户',123.00,1,60,'10:45:00','22:45:00','02:30:00','02:30:00','1',0,1,'4,5','0000-00-00','',NULL,60,NULL),
	(6,'市场数据管理-殷与龙',34.00,1,60,'10:45:00','22:45:00',NULL,NULL,'1',0,1,'2,4','1970-01-01','','1970-01-01',120,NULL),
	(7,'商户',123.00,1,60,'10:45:00','22:45:00',NULL,NULL,'1',0,1,'4,5','1970-01-01','','1970-01-01',60,NULL),
	(8,'陈国龙财务订单权限',122.00,1,60,'11:00:00','23:00:00',NULL,NULL,'1',0,1,'4,5','1970-01-01','','1970-01-01',0,NULL),
	(9,'测试',121.00,1,60,'11:00:00','23:00:00',NULL,NULL,'1',0,1,'','1970-01-01','','1970-01-01',0,NULL),
	(10,'测试',121.00,1,60,'11:00:00','23:00:00',NULL,NULL,'1',0,1,'','2017-10-16','','2017-10-16',0,NULL),
	(11,'测试',121.00,1,60,'11:00:00','23:00:00',NULL,NULL,'1',0,1,'','2017-10-16','','2017-10-16',0,NULL),
	(12,'测试',121.00,1,60,'11:00:00','23:00:00',NULL,NULL,'1',0,1,'','2017-10-16','','2017-10-16',0,NULL),
	(13,'测试',121.00,1,60,'11:00:00','23:00:00',NULL,NULL,'1',0,1,'','2017-10-16','','2017-10-16',0,NULL),
	(14,'测试',121.00,1,60,'11:00:00','23:00:00',NULL,NULL,'1',3,1,'','2017-10-16','','2017-10-16',0,NULL),
	(15,'测试',121.00,1,60,'11:00:00','23:00:00',NULL,NULL,'1',0,1,'','2017-10-16','','2017-10-16',0,NULL),
	(16,'',0.00,1,60,'13:45:00','13:45:00',NULL,NULL,'1',0,1,'','2017-10-18','','2017-10-18',30,NULL);

/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table serviceprice
# ------------------------------------------------------------

DROP TABLE IF EXISTS `serviceprice`;

CREATE TABLE `serviceprice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serviceid` int(100) NOT NULL,
  `price` decimal(14,2) NOT NULL,
  `begin1` time NOT NULL,
  `end1` time NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  `stopweekday` varchar(200) DEFAULT '',
  `vicationstart` date DEFAULT NULL,
  `vicationstop` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `serviceprice` WRITE;
/*!40000 ALTER TABLE `serviceprice` DISABLE KEYS */;

INSERT INTO `serviceprice` (`id`, `serviceid`, `price`, `begin1`, `end1`, `status`, `stopweekday`, `vicationstart`, `vicationstop`)
VALUES
	(2,2,1000.00,'08:00:00','08:00:00','1','6,7','2018-01-01','2018-01-03');

/*!40000 ALTER TABLE `serviceprice` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table servicepic
# ------------------------------------------------------------

DROP TABLE IF EXISTS `servicepic`;

CREATE TABLE `servicepic` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `serviceid` int(11) DEFAULT NULL,
  `picname` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `sid` (`serviceid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `servicepic` WRITE;
/*!40000 ALTER TABLE `servicepic` DISABLE KEYS */;

INSERT INTO `servicepic` (`id`, `serviceid`, `picname`)
VALUES
	(1,1,'pic/service/DSC00438.jpg_844843'),
	(2,1,'pic/service/DSC00438.jpg_844843'),
	(3,1,'pic/service/DSC00438.jpg_844843'),
	(4,1,'pic/service/DSC00438.jpg_844843'),
	(5,1,'pic/service/DSC00438.jpg_844843'),
	(6,1,'pic/service/DSC00438.jpg_844843'),
	(7,1,'pic/service/DSC00438.jpg_844843'),
	(8,1,'pic/service/DSC00438.jpg_844843'),
	(9,1,'pic/service/844843_DSC00438.jpg'),
	(10,2,'pic/service/248015_nm_meitu_1.jpg'),
	(11,2,'pic/service/248015_nm_meitu_1.jpg');

/*!40000 ALTER TABLE `servicepic` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table servicereview
# ------------------------------------------------------------

DROP TABLE IF EXISTS `servicereview`;

CREATE TABLE `servicereview` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serviceid` int(11) NOT NULL,
  `customerid` int(11) NOT NULL,
  `star` tinyint(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `coments` varchar(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table user
# ------------------------------------------------------------

DROP TABLE IF EXISTS `user`;

CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `into` varchar(300) NOT NULL,
  `pic` varchar(200) NOT NULL,
  `username` varchar(20) NOT NULL,
  `passwd` varchar(50) NOT NULL,
  `type` varchar(20) NOT NULL,
  `mobile` varchar(20) NOT NULL,
  `weixin` varchar(100) NOT NULL,
  `sectkey` varchar(200) NOT NULL,
  `secret` varchar(200) NOT NULL,
  `status` char(1) NOT NULL DEFAULT '1',
  `logintimes` int(11) NOT NULL DEFAULT '1',
  `remark` varchar(500) NOT NULL,
  `sales` varchar(200) DEFAULT NULL,
  `regdt` datetime DEFAULT NULL,
  `lastlogin` datetime DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `service_tel` varchar(50) DEFAULT NULL,
  `uptodate` datetime DEFAULT NULL COMMENT '到期时间',
  `ispublic` char(1) DEFAULT '1' COMMENT '是否可以被搜索到',
  `backpic` varchar(200) DEFAULT NULL,
  `licensepic` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mobile` (`mobile`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;

INSERT INTO `user` (`id`, `name`, `into`, `pic`, `username`, `passwd`, `type`, `mobile`, `weixin`, `sectkey`, `secret`, `status`, `logintimes`, `remark`, `sales`, `regdt`, `lastlogin`, `address`, `service_tel`, `uptodate`, `ispublic`, `backpic`, `licensepic`)
VALUES
	(1,'商家A','                                                                                          没有介绍可以么？\r\n                    \r\n                    \r\n                    \r\n                    ','pic/user/248015_nm_meitu_1.jpg','老家大院','3447f525dccc3ffa02db1a66ca44fa87','5','15888830701','','','','1',12,'',NULL,'2017-10-11 15:10:31','2017-12-08 11:43:10','滨江区滨文路639号','15888830701',NULL,NULL,NULL,NULL),
	(0,'admin','','','','3447f525dccc3ffa02db1a66ca44fa87','','admin','','','','1',4,'',NULL,NULL,'2017-11-24 15:32:04',NULL,NULL,NULL,'1',NULL,NULL),
	(3,'','','','','','','','','','','1',1,'',NULL,NULL,NULL,NULL,NULL,NULL,'1',NULL,NULL);

/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table usertype
# ------------------------------------------------------------

DROP TABLE IF EXISTS `usertype`;

CREATE TABLE `usertype` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) DEFAULT NULL,
  `servicenum` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;

INSERT INTO `usertype` (`id`, `name`, `servicenum`)
VALUES
	(1,'场地空间',0),
	(2,'一对一服务',0),
	(3,'特殊资源服务',0),
	(4,'体育场馆',0),
	(5,'会议室',2),
	(6,'农家乐',0),
	(7,'名宿',0),
	(8,'家教',0),
	(9,'医生',0),
	(10,'律师',0),
	(11,'私人影院',1);

/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;



/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
