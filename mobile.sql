-- --------------------------------------------------------
-- 主机:                           127.0.0.1
-- 服务器版本:                        5.5.47 - MySQL Community Server (GPL)
-- 服务器操作系统:                      Win32
-- HeidiSQL 版本:                  9.3.0.4984
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 导出 mobile 的数据库结构
CREATE DATABASE IF NOT EXISTS `mobile` /*!40100 DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci */;
USE `mobile`;


-- 导出  表 mobile.banner 结构
CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `href` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `img_url` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `img_url_120x80` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `img_url_350x220` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `on_banner` tinyint(4) NOT NULL,
  `add_time` int(15) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  mobile.banner 的数据：6 rows
DELETE FROM `banner`;
/*!40000 ALTER TABLE `banner` DISABLE KEYS */;
INSERT INTO `banner` (`id`, `title`, `href`, `img_url`, `img_url_120x80`, `img_url_350x220`, `on_banner`, `add_time`) VALUES
	(2, '我的博客！', 'https://gfwboom.com', 'data/images/20160708/img_url/DfOXtIPonq7A6GuKVZja.png', 'data/images/20160708/img_url/../thumb_120x80/thumb_120x80_DfOXtIPonq7A6GuKVZja.png', 'data/images/20160708/img_url/../thumb_350x220/thumb_350x220_DfOXtIPonq7A6GuKVZja.png', 1, 1467971965),
	(3, '测试banner1', './one.php?id=1', 'data/images/20160709/img_url/toGNneSDpafXvUHYcbzE.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_toGNneSDpafXvUHYcbzE.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_toGNneSDpafXvUHYcbzE.jpg', 1, 1468048022),
	(4, '测试banner2', './one.php?id=2', 'data/images/20160709/img_url/jNM2xYDKhr1SCRvyX5b7.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_jNM2xYDKhr1SCRvyX5b7.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_jNM2xYDKhr1SCRvyX5b7.jpg', 1, 1468048008),
	(5, '测试banner3', './one.php?id=3', 'data/images/20160709/img_url/WSOoGazc9sIVdreP4k2N.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_WSOoGazc9sIVdreP4k2N.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_WSOoGazc9sIVdreP4k2N.jpg', 1, 1468047995),
	(6, '测试banner4', './one.php?id=4', 'data/images/20160709/img_url/qjP1vd4nuet0Obi6LYoZ.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_qjP1vd4nuet0Obi6LYoZ.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_qjP1vd4nuet0Obi6LYoZ.jpg', 1, 1468047980),
	(7, '测试banner5', './one.php?id=5', 'data/images/20160709/img_url/QuwoqGjYy23ak1fdrOKh.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_QuwoqGjYy23ak1fdrOKh.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_QuwoqGjYy23ak1fdrOKh.jpg', 1, 1468046339);
/*!40000 ALTER TABLE `banner` ENABLE KEYS */;


-- 导出  表 mobile.category 结构
CREATE TABLE IF NOT EXISTS `category` (
  `cat_id` int(11) NOT NULL AUTO_INCREMENT,
  `cat_name` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `intro` varchar(100) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `parent_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cat_id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  mobile.category 的数据：10 rows
DELETE FROM `category`;
/*!40000 ALTER TABLE `category` DISABLE KEYS */;
INSERT INTO `category` (`cat_id`, `cat_name`, `intro`, `parent_id`) VALUES
	(1, '所有栏目', '所有栏目', 0),
	(2, '栏目1', '栏目1', 1),
	(3, '栏目2', '栏目2', 1),
	(4, '栏目3', '栏目3', 1),
	(7, '子栏目1', '子栏目1', 3),
	(8, '子栏目2', '子栏目2', 3),
	(9, '子栏目1', '子栏目1', 4),
	(10, '子栏目2', '子栏目2', 4),
	(11, '子栏目1', '子栏目1', 2),
	(12, '子栏目2', '子栏目2', 2);
/*!40000 ALTER TABLE `category` ENABLE KEYS */;


-- 导出  表 mobile.info 结构
CREATE TABLE IF NOT EXISTS `info` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
  `cat_id` smallint(11) NOT NULL DEFAULT '0',
  `access_amount` int(10) NOT NULL DEFAULT '0',
  `info1` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `info2` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `info3` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `info4` varchar(30) COLLATE utf8_unicode_ci DEFAULT NULL,
  `img_url` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `img_url_120x80` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `img_url_350x220` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `details` text COLLATE utf8_unicode_ci NOT NULL,
  `add_time` int(10) NOT NULL,
  `is_new` tinyint(4) DEFAULT NULL,
  `is_on_sale` tinyint(4) NOT NULL,
  `is_best` tinyint(4) NOT NULL,
  `is_hot` tinyint(4) NOT NULL,
  `is_delete` tinyint(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  mobile.info 的数据：33 rows
DELETE FROM `info`;
/*!40000 ALTER TABLE `info` DISABLE KEYS */;
INSERT INTO `info` (`id`, `name`, `cat_id`, `access_amount`, `info1`, `info2`, `info3`, `info4`, `img_url`, `img_url_120x80`, `img_url_350x220`, `details`, `add_time`, `is_new`, `is_on_sale`, `is_best`, `is_hot`, `is_delete`) VALUES
	(1, '111111111111', 11, 12, '11111111', '11111111111', '11111111111', '1111111111111', 'data/images/20160709/img_url/QC3ZSWAMebhBwHt78NKJ.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_QC3ZSWAMebhBwHt78NKJ.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_QC3ZSWAMebhBwHt78NKJ.jpg', '<p><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641227.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641237.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641249.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641260.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641266.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641274.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641291.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641298.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641304.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641310.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641325.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641316.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641336.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/><img src="https://gfwboom.com/mall/data/upload/image/20160508/1462641356.jpg" style="margin: 0px; padding: 0px; border: none; list-style-type: none; color: rgb(153, 153, 153); font-family: Arial, 宋体, Verdana; font-size: 12px; line-height: 18px; white-space: normal; background-color: rgb(255, 255, 255);"/></p>', 1468130244, 1, 1, 1, 1, 0),
	(2, '222222222', 12, 5, '22222222222222', '22222222222222', '22222222222222', '222222222', 'data/images/20160709/img_url/xAO0y21WZ7KGMPhfUHi4.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_xAO0y21WZ7KGMPhfUHi4.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_xAO0y21WZ7KGMPhfUHi4.jpg', '<p>222222222222222222222222222222</p>', 1468046308, 0, 1, 1, 1, 0),
	(3, '333333333333333333', 7, 3, '33333333333333333333', '33333333333', '33333333333333333', '3333333333', 'data/images/20160709/img_url/qaf1u3e9GUdALB6HncCv.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_qaf1u3e9GUdALB6HncCv.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_qaf1u3e9GUdALB6HncCv.jpg', '<p>333333333333333333333333333333333333</p>', 1468048075, 0, 1, 1, 1, 0),
	(4, '44444444444', 8, 5, '44444444444', '444444444444', '4444444444444', '4444444444444', 'data/images/20160709/img_url/gqCp6vm140U9Qx3TBRzY.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_gqCp6vm140U9Qx3TBRzY.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_gqCp6vm140U9Qx3TBRzY.jpg', '<p>444444444444444444444444</p>', 1468005193, 1, 1, 1, 0, 0),
	(5, '55555555555555555', 9, 2, '55555555555555', '555555555555555', '555555555', '55555555555', 'data/images/20160709/img_url/gdsYFRKQXbMnzcZy0J9V.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_gdsYFRKQXbMnzcZy0J9V.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_gdsYFRKQXbMnzcZy0J9V.jpg', '<p>5555555555555555555555555555555</p>', 1468046231, 0, 1, 0, 1, 0),
	(6, '6666666666', 10, 0, '666666666', '66666666666', '66666666666', '66666666', 'data/images/20160708/img_url/DdGZj0U2N4O5raokB1qy.png', 'data/images/20160708/img_url/../thumb_120x80/thumb_120x80_DdGZj0U2N4O5raokB1qy.png', 'data/images/20160708/img_url/../thumb_350x220/thumb_350x220_DdGZj0U2N4O5raokB1qy.png', '<p>666666666666666666666666</p>', 1467976329, 0, 1, 1, 0, 0),
	(7, '12312hhh', 11, 0, '123123', '13', '1313213', '213213', 'data/images/20160709/img_url/WZxJi3uoqyDsESbe2GB6.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_WZxJi3uoqyDsESbe2GB6.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_WZxJi3uoqyDsESbe2GB6.jpg', '<p>12321313131</p>', 1468004842, 1, 1, 0, 0, 0),
	(8, '77777777777', 11, 1, '7777777', '777777777', '7777777777777', '777777777777', 'data/images/20160709/img_url/ocUpPLvx8myS7rH6DusQ.png', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_ocUpPLvx8myS7rH6DusQ.png', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_ocUpPLvx8myS7rH6DusQ.png', '<p>7777777777777777777777777777777777777</p>', 1468045089, 0, 1, 1, 1, 0),
	(9, '88888888888888888', 12, 11, '88888888888', '88888888888888', '88888888888888', '88888888888888', 'data/images/20160709/img_url/4cektQVaY76AWswICru9.png', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_4cektQVaY76AWswICru9.png', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_4cektQVaY76AWswICru9.png', '<p>888888888888</p>', 1468045121, 1, 1, 1, 0, 0),
	(10, '99999999999999', 7, 1, '999999999999', '99999999999999', '999999999999', '999999999999999', 'data/images/20160709/img_url/HdETrOF7jb6wXfMekvUy.png', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_HdETrOF7jb6wXfMekvUy.png', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_HdETrOF7jb6wXfMekvUy.png', '<p>9999999999999999999999999999</p>', 1468045143, 0, 1, 1, 1, 0),
	(11, '101010100101010', 9, 0, '1010101010101010', '10101010101010101010', '1010101010101010', '1010101010101010', 'data/images/20160709/img_url/Dby6xukX0s1mz2Kaf3I8.png', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_Dby6xukX0s1mz2Kaf3I8.png', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_Dby6xukX0s1mz2Kaf3I8.png', '<p>1010101010101010</p>', 1468045174, 1, 1, 1, 0, 0),
	(12, '111111111111111', 9, 2, '111111111111', '111111111111', '111111111111', '111111111111', 'data/images/20160709/img_url/QEhY2wqe8FHR6dx0aC4G.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_QEhY2wqe8FHR6dx0aC4G.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_QEhY2wqe8FHR6dx0aC4G.jpg', '<p>11111111111111111111111111111112</p>', 1468074899, 1, 1, 1, 0, 0),
	(13, '121212121212121212', 10, 1, '121212121212', '121212121212', '12121212121', '121212121212121212', 'data/images/20160709/img_url/KzNgXPr9IUk4Mn5uoFJQ.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_KzNgXPr9IUk4Mn5uoFJQ.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_KzNgXPr9IUk4Mn5uoFJQ.jpg', '<p>121212121212121212</p>', 1468045518, 1, 1, 1, 1, 0),
	(14, '1313131313131', 11, 2, '313131313', '13131313', '131313131', '31313131313', 'data/images/20160709/img_url/Pm6yrI2NHp4gKMQfhTY9.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_Pm6yrI2NHp4gKMQfhTY9.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_Pm6yrI2NHp4gKMQfhTY9.jpg', '<p>13131313131313131313</p>', 1468045548, 1, 1, 1, 0, 0),
	(15, '1414141414666', 11, 3, '1414141414', '1414141414', '141414141', '4141414141414', 'data/images/20160710/img_url/wacogxRUVz896f0kemus.jpg', 'data/images/20160710/img_url/../thumb_120x80/thumb_120x80_wacogxRUVz896f0kemus.jpg', 'data/images/20160710/img_url/../thumb_350x220/thumb_350x220_wacogxRUVz896f0kemus.jpg', '<p>141414141414141414</p>', 1468117706, 1, 1, 1, 0, 0),
	(16, '15151515151', 11, 1, '151515151515', '1515151515151515', '151515151', '5151515151515', 'data/images/20160709/img_url/G0ARIZaL5kDHc6NpFT8X.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_G0ARIZaL5kDHc6NpFT8X.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_G0ARIZaL5kDHc6NpFT8X.jpg', '<p>15515151515151515</p>', 1468045594, 1, 1, 1, 0, 0),
	(17, '16161616161', 11, 2, '616161616', '1616161616', '161616161', '6161616161616', 'data/images/20160709/img_url/buVU5cxGaPyEjIvWOQmz.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_buVU5cxGaPyEjIvWOQmz.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_buVU5cxGaPyEjIvWOQmz.jpg', '<p>16161616161616161616</p>', 1468045615, 1, 1, 1, 0, 0),
	(18, '177117717171717', 11, 0, '17171717117177', '17171171771717171', '717771717171717', '171771777771777', 'data/images/20160709/img_url/CGtNWLMq2b5SA3Iahemc.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_CGtNWLMq2b5SA3Iahemc.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_CGtNWLMq2b5SA3Iahemc.jpg', '<p>1717171717171717171717171717171717</p>', 1468046166, 1, 1, 1, 0, 0),
	(19, '1818181818181818', 11, 0, '181818', '181818', '18181818', '181881181818', 'data/images/20160709/img_url/0Dv1s6n5EHXKzwcbyVT7.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_0Dv1s6n5EHXKzwcbyVT7.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_0Dv1s6n5EHXKzwcbyVT7.jpg', '<p>181818181818181818181181111</p>', 1468046134, 1, 1, 0, 1, 0),
	(20, '1919191919911919', 11, 0, '1919919191', '919191919', '191919', '91991191', 'data/images/20160709/img_url/YtmDrzOvkyIPbnZfqduR.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_YtmDrzOvkyIPbnZfqduR.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_YtmDrzOvkyIPbnZfqduR.jpg', '<p>191919191919919119</p>', 1468046104, 1, 1, 0, 0, 0),
	(21, '2020022020', 12, 1, '0220200', '202020202', '2202002020', '20222022020', 'data/images/20160709/img_url/q9s01TtOra2dxMRbJENc.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_q9s01TtOra2dxMRbJENc.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_q9s01TtOra2dxMRbJENc.jpg', '<p>2020202020202020</p>', 1468046069, 0, 1, 0, 1, 0),
	(22, '212121212121', 12, 0, '2121212', '12121212', '212121212', '121212121212', 'data/images/20160709/img_url/RaiJbQjh2r0g1peFEOAV.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_RaiJbQjh2r0g1peFEOAV.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_RaiJbQjh2r0g1peFEOAV.jpg', '<p>21212121212121212121</p>', 1468046051, 0, 0, 1, 1, 1),
	(23, '2222222222222', 12, 0, '222222222222', '22222222222222', '222222222222', '22222222222222222', 'data/images/20160709/img_url/zpWiFPeq6h9JX8CbtA0f.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_zpWiFPeq6h9JX8CbtA0f.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_zpWiFPeq6h9JX8CbtA0f.jpg', '<p>2222222222222222222222222</p>', 1468073281, 1, 1, 1, 0, 0),
	(24, '2323232323', 12, 4, '23232323', '2323232323', '232323232', '32323232323', 'data/images/20160709/img_url/2vNBgkiCrzpKuso6Fn1j.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_2vNBgkiCrzpKuso6Fn1j.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_2vNBgkiCrzpKuso6Fn1j.jpg', '<p>2323232323232323232323</p>', 1468073311, 1, 1, 1, 0, 0),
	(25, '24242424242424111', 12, 0, '24242424242411', '2424242424', '2424242424', '242424242424', 'data/images/20160709/img_url/Gau1N9CqY7mp0oPybMeW.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_Gau1N9CqY7mp0oPybMeW.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_Gau1N9CqY7mp0oPybMeW.jpg', '<p>242424242424242424242424242424</p>', 1468117672, 1, 1, 1, 0, 0),
	(26, '24242424242424', 8, 0, '24242424242', '424242424', '242424242', '4242424242424', 'data/images/20160709/img_url/FY8fvpS9Miec4u2bVWKz.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_FY8fvpS9Miec4u2bVWKz.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_FY8fvpS9Miec4u2bVWKz.jpg', '<p>2424242424242424</p>', 1468073837, 1, 1, 1, 0, 0),
	(27, '25252525252', 9, 0, '5252525252', '52525', '25252525', '252525', 'data/images/20160709/img_url/Ghc9JTbS5IWmYD2VjgXy.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_Ghc9JTbS5IWmYD2VjgXy.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_Ghc9JTbS5IWmYD2VjgXy.jpg', '<p>25252525252525<br/></p>', 1468076214, 1, 1, 1, 0, 0),
	(28, '5555555123123', 9, 2, '55555555555555', '555555555555555', '555555555', '55555555555', 'data/images/20160709/img_url/ng4xIZbtRH9h85U1ekws.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_ng4xIZbtRH9h85U1ekws.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_ng4xIZbtRH9h85U1ekws.jpg', '<p>5555555555555555555555555555555</p>', 1468076528, 0, 1, 1, 1, 0),
	(29, '23123123', 11, 0, '123123', '13', '1313213', '213213', 'data/images/20160709/img_url/7VT2p81JMverkzsfSiQY.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_7VT2p81JMverkzsfSiQY.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_7VT2p81JMverkzsfSiQY.jpg', '<p>12321313131</p>', 1468076547, 1, 1, 1, 0, 0),
	(30, '1111115325', 9, 0, '111111111111', '111111111111', '111111111111', '111111111111', 'data/images/20160709/img_url/QEhY2wqe8FHR6dx0aC4G.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_QEhY2wqe8FHR6dx0aC4G.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_QEhY2wqe8FHR6dx0aC4G.jpg', '<p>11111111111111111111111111111112</p>', 1468074899, 1, 1, 0, 0, 0),
	(31, '141414141435235', 11, 0, '1414141414', '1414141414', '141414141', '4141414141414', 'data/images/20160710/img_url/qcdbJpEuKBAOoY1ye3S2.png', 'data/images/20160710/img_url/../thumb_120x80/thumb_120x80_qcdbJpEuKBAOoY1ye3S2.png', 'data/images/20160710/img_url/../thumb_350x220/thumb_350x220_qcdbJpEuKBAOoY1ye3S2.png', '<p>141414141414141414</p>', 1468117659, 1, 1, 0, 0, 0),
	(32, '177117717176546', 11, 0, '17171717117177', '17171171771717171', '717771717171717', '171771777771777', 'data/images/20160709/img_url/CGtNWLMq2b5SA3Iahemc.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_CGtNWLMq2b5SA3Iahemc.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_CGtNWLMq2b5SA3Iahemc.jpg', '<p>1717171717171717171717171717171717</p>', 1468046166, 1, 1, 0, 0, 0),
	(33, '181818181818181', 11, 2, '181818', '181818', '18181818', '181881181818', 'data/images/20160709/img_url/ibJg4Idp2a5HeNG1kmrB.jpg', 'data/images/20160709/img_url/../thumb_120x80/thumb_120x80_ibJg4Idp2a5HeNG1kmrB.jpg', 'data/images/20160709/img_url/../thumb_350x220/thumb_350x220_ibJg4Idp2a5HeNG1kmrB.jpg', '<p>181818181818181818181181111</p>', 1468076571, 1, 1, 0, 1, 0);
/*!40000 ALTER TABLE `info` ENABLE KEYS */;


-- 导出  表 mobile.user 结构
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `email` varchar(40) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `password` char(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `regtime` int(10) unsigned NOT NULL DEFAULT '0',
  `lastlogin` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- 正在导出表  mobile.user 的数据：1 rows
DELETE FROM `user`;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `username`, `email`, `password`, `regtime`, `lastlogin`) VALUES
	(1, 'admin', 'maizhenying09@gmail.com', '25f9e794323b453885f5181f1b624d0b', 1467165370, 1468117412);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
