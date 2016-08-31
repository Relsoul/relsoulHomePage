-- phpMyAdmin SQL Dump
-- version phpStudy 2014
-- http://www.phpmyadmin.net
--
-- 主机: localhost
-- 生成日期: 2016 年 08 月 31 日 16:41
-- 服务器版本: 5.7.14
-- PHP 版本: 5.6.24

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- 数据库: `homestead`
--

-- --------------------------------------------------------

--
-- 表的结构 `home_exp`
--

CREATE TABLE IF NOT EXISTS `home_exp` (
  `exp_id` int(11) NOT NULL AUTO_INCREMENT,
  `exp_name` char(100) NOT NULL,
  `exp_content` text NOT NULL,
  `exp_start_time` char(150) NOT NULL DEFAULT '2010 6月',
  `exp_end_time` char(150) NOT NULL DEFAULT '2010 9月',
  `exp_img` char(150) NOT NULL DEFAULT '""',
  `updated_at` int(11) DEFAULT '0',
  `created_at` int(11) DEFAULT '0',
  PRIMARY KEY (`exp_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=42 ;

--
-- 转存表中的数据 `home_exp`
--

INSERT INTO `home_exp` (`exp_id`, `exp_name`, `exp_content`, `exp_start_time`, `exp_end_time`, `exp_img`, `updated_at`, `created_at`) VALUES
(5, '网易微专业', '参加了网易微专业第一期培训班,并且获得优秀证书.  ', '2015-4-1', '2015-6-30', '', 1464953433, 0),
(32, '前端', 'es6,angualrJS,nodejs,vue.js,electron,mysql,mongodb,express.php. ', '2015-03-01', '至今', '', 1465132336, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
