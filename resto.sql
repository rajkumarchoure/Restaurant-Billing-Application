-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 19, 2019 at 07:23 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `resto`
--

-- --------------------------------------------------------

--
-- Table structure for table `activitylogreport`
--

CREATE TABLE IF NOT EXISTS `activitylogreport` (
  `actid` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `usertype` varchar(50) DEFAULT NULL,
  `module` varchar(100) DEFAULT NULL,
  `submodule` varchar(50) NOT NULL,
  `pagename` varchar(200) DEFAULT NULL,
  `primarykeyid` varchar(50) DEFAULT NULL,
  `tablename` varchar(50) DEFAULT NULL,
  `activitydatetime` datetime DEFAULT NULL,
  `action` varchar(50) DEFAULT NULL,
  `sessionid` int(11) NOT NULL,
  PRIMARY KEY (`actid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `activitylogreport`
--

INSERT INTO `activitylogreport` (`actid`, `userid`, `usertype`, `module`, `submodule`, `pagename`, `primarykeyid`, `tablename`, `activitydatetime`, `action`, `sessionid`) VALUES
(1, 1, 'admin', 'Add Table', 'Table Master', 'master_add_table.php', '0', 'm_table', '2019-07-16 17:07:34', 'insert', 0),
(2, 1, 'admin', 'Add Unit', 'Unit Master', 'master_unit.php', '0', 'm_unit', '2019-07-16 17:07:27', 'insert', 0),
(3, 1, 'admin', 'Add Unit', 'Unit Master', 'master_unit.php', '5', 'm_unit', '2019-07-16 17:07:41', 'deleted', 0),
(4, 1, 'admin', 'Add Unit', 'Unit Master', 'master_unit.php', '0', 'm_unit', '2019-08-09 15:08:52', 'insert', 0),
(5, 1, 'admin', 'Add Table', 'Table Master', 'master_add_table.php', '7', 'm_table', '2019-08-09 15:08:51', 'deleted', 0),
(6, 1, 'admin', 'Add Table', 'Table Master', 'master_add_table.php', '6', 'm_table', '2019-08-09 15:08:03', 'deleted', 0);

-- --------------------------------------------------------

--
-- Table structure for table `bills`
--

CREATE TABLE IF NOT EXISTS `bills` (
  `billid` int(11) NOT NULL AUTO_INCREMENT,
  `billnumber` varchar(100) NOT NULL,
  `billtime` varchar(50) NOT NULL,
  `billdate` date NOT NULL,
  `table_id` int(11) NOT NULL,
  `is_completed` int(11) NOT NULL COMMENT '0=no, yes=1',
  `is_parsal` varchar(10) NOT NULL COMMENT '0=no, yes=1',
  `basic_bill_amt` double NOT NULL,
  `disc_percent` float NOT NULL,
  `disc_rs` float NOT NULL,
  `sgst` float NOT NULL,
  `cgst` float NOT NULL,
  `sercharge` float NOT NULL,
  `net_bill_amt` double NOT NULL,
  `parsal_status` varchar(100) NOT NULL,
  `is_paid` tinyint(4) NOT NULL,
  `rec_amt` double NOT NULL,
  `cash_amt` double NOT NULL,
  `paytm_amt` double NOT NULL,
  `paytm_trans_no` varchar(100) NOT NULL,
  `card_amt` double NOT NULL,
  `zomato` double NOT NULL,
  `swiggy` double NOT NULL,
  `card_trans_number` varchar(100) NOT NULL,
  `paydate` date NOT NULL,
  `paymode` varchar(100) NOT NULL,
  `tran_no` varchar(100) NOT NULL DEFAULT '0',
  `bank_name` varchar(200) NOT NULL,
  `cust_mobile` varchar(10) NOT NULL,
  `cust_name` varchar(100) NOT NULL,
  `remarks` text NOT NULL,
  `is_cancelled` tinyint(4) NOT NULL,
  `cancel_remark` varchar(500) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(50) NOT NULL,
  `lastupdated` datetime NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`billid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `bills`
--

INSERT INTO `bills` (`billid`, `billnumber`, `billtime`, `billdate`, `table_id`, `is_completed`, `is_parsal`, `basic_bill_amt`, `disc_percent`, `disc_rs`, `sgst`, `cgst`, `sercharge`, `net_bill_amt`, `parsal_status`, `is_paid`, `rec_amt`, `cash_amt`, `paytm_amt`, `paytm_trans_no`, `card_amt`, `zomato`, `swiggy`, `card_trans_number`, `paydate`, `paymode`, `tran_no`, `bank_name`, `cust_mobile`, `cust_name`, `remarks`, `is_cancelled`, `cancel_remark`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(1, '00001', '06:02 PM', '2019-07-16', 7, 0, '0', 80, 0, 0, 2.5, 2.5, 0, 84, 'Table Order', 0, 0, 0, 0, '', 0, 0, 0, '', '0000-00-00', '', '0', '', '', '', '', 0, '', 0, '::1', '0000-00-00 00:00:00', '2019-07-16 18:02:06');

-- --------------------------------------------------------

--
-- Table structure for table `bill_details`
--

CREATE TABLE IF NOT EXISTS `bill_details` (
  `billdetailid` int(11) NOT NULL AUTO_INCREMENT,
  `billid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `unitid` int(11) NOT NULL,
  `qty` float NOT NULL,
  `rate` float NOT NULL,
  `table_id` int(11) NOT NULL,
  `isbilled` tinyint(4) NOT NULL,
  `aaa` int(11) NOT NULL,
  `kotid` int(11) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(50) NOT NULL,
  `lastupdated` datetime NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`billdetailid`),
  KEY `billid` (`billid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `bill_details`
--

INSERT INTO `bill_details` (`billdetailid`, `billid`, `productid`, `unitid`, `qty`, `rate`, `table_id`, `isbilled`, `aaa`, `kotid`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(1, 1, 6, 4, 1, 80, 7, 0, 0, 1, 1, '::1', '0000-00-00 00:00:00', '2019-07-16 18:01:11'),
(2, 0, 6, 4, 3, 80, 1, 0, 0, 0, 1, '::1', '0000-00-00 00:00:00', '2019-08-09 15:11:32'),
(3, 0, 7, 4, 2, 120, 1, 0, 0, 0, 1, '::1', '0000-00-00 00:00:00', '2019-08-09 15:11:40');

-- --------------------------------------------------------

--
-- Table structure for table `company_setting`
--

CREATE TABLE IF NOT EXISTS `company_setting` (
  `compid` int(11) NOT NULL AUTO_INCREMENT,
  `comp_name` varchar(100) NOT NULL,
  `gstno` varchar(100) NOT NULL,
  `landlineno` varchar(100) NOT NULL,
  `mobile` varchar(50) NOT NULL,
  `mobile2` varchar(10) NOT NULL,
  `address` text NOT NULL,
  `address2` text NOT NULL,
  `email_id` varchar(100) NOT NULL,
  `email1` varchar(200) NOT NULL,
  `email2` varchar(200) NOT NULL,
  `term_cond` text NOT NULL,
  `ipaddress` varchar(25) NOT NULL,
  `createdate` datetime NOT NULL,
  `lastupdated` datetime NOT NULL,
  PRIMARY KEY (`compid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `company_setting`
--

INSERT INTO `company_setting` (`compid`, `comp_name`, `gstno`, `landlineno`, `mobile`, `mobile2`, `address`, `address2`, `email_id`, `email1`, `email2`, `term_cond`, `ipaddress`, `createdate`, `lastupdated`) VALUES
(1, 'NIT CAFE', 'FHJSD054545', '07714004450', '9770131555', '9871454555', 'Infront of Vidhya Hospital', 'Shanker Nagar, Raipur', 'nipeshp@gmail.com', '', '', '                   ', '192.168.0.3', '0000-00-00 00:00:00', '2019-01-30 16:04:32');

-- --------------------------------------------------------

--
-- Table structure for table `expanse`
--

CREATE TABLE IF NOT EXISTS `expanse` (
  `expanse_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_group_id` int(11) NOT NULL,
  `exp_name` varchar(200) NOT NULL,
  `exp_date` date NOT NULL,
  `exp_amount` float NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(100) NOT NULL,
  `lastupdated` date NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`expanse_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `expanse`
--

INSERT INTO `expanse` (`expanse_id`, `ex_group_id`, `exp_name`, `exp_date`, `exp_amount`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(1, 3, 'lunch', '2017-01-01', 5000, 0, '::1', '2019-01-15', '2017-09-12'),
(2, 4, 'lunch-2', '2017-02-02', 6000, 0, '::1', '2019-01-15', '2017-09-12'),
(3, 2, 'RENT TO SHOP OWNER', '2017-12-11', 5000, 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(7, 2, 'hgjghh', '2019-02-01', 5900, 0, 'fe80::5850:e173:7a4a:7420', '0000-00-00', '2019-01-19');

-- --------------------------------------------------------

--
-- Table structure for table `kot_entry`
--

CREATE TABLE IF NOT EXISTS `kot_entry` (
  `kotid` int(11) NOT NULL AUTO_INCREMENT,
  `table_id` int(11) NOT NULL,
  `kotdate` date NOT NULL,
  `kottime` varchar(10) NOT NULL,
  `billid` int(11) NOT NULL,
  PRIMARY KEY (`kotid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `kot_entry`
--

INSERT INTO `kot_entry` (`kotid`, `table_id`, `kotdate`, `kottime`, `billid`) VALUES
(1, 7, '2019-07-16', '06:01 PM', 1);

-- --------------------------------------------------------

--
-- Table structure for table `loginlogoutreport`
--

CREATE TABLE IF NOT EXISTS `loginlogoutreport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) DEFAULT NULL,
  `usertype` varchar(20) DEFAULT NULL,
  `process` varchar(10) DEFAULT NULL,
  `sessionid` int(11) NOT NULL,
  `loginlogouttime` datetime DEFAULT NULL,
  `createdate` date DEFAULT NULL,
  `ipaddress` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `loginlogoutreport`
--

INSERT INTO `loginlogoutreport` (`id`, `userid`, `usertype`, `process`, `sessionid`, `loginlogouttime`, `createdate`, `ipaddress`) VALUES
(1, 1, 'admin', 'Login', 0, '2019-07-16 17:42:58', '2019-07-16', '::1'),
(2, 1, 'admin', 'Login', 0, '2019-08-09 15:06:54', '2019-08-09', '::1'),
(3, 1, 'admin', 'Login', 0, '2019-08-09 15:07:10', '2019-08-09', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `m_expanse_group`
--

CREATE TABLE IF NOT EXISTS `m_expanse_group` (
  `ex_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) NOT NULL,
  `enable` varchar(20) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(25) NOT NULL,
  `lastupdated` date NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`ex_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `m_expanse_group`
--

INSERT INTO `m_expanse_group` (`ex_group_id`, `group_name`, `enable`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(2, 'MONTH RENT', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(3, 'TELPHONE', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(4, 'OTHER EXP', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07');

-- --------------------------------------------------------

--
-- Table structure for table `m_product`
--

CREATE TABLE IF NOT EXISTS `m_product` (
  `productid` int(11) NOT NULL AUTO_INCREMENT,
  `pcatid` int(11) NOT NULL,
  `prodname` varchar(200) NOT NULL,
  `quantityinbag` float NOT NULL,
  `unitid` int(11) NOT NULL,
  `rate` float NOT NULL,
  `disc` float NOT NULL,
  `imgname` varchar(300) NOT NULL,
  `enable` varchar(20) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(25) NOT NULL,
  `lastupdated` date NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;

--
-- Dumping data for table `m_product`
--

INSERT INTO `m_product` (`productid`, `pcatid`, `prodname`, `quantityinbag`, `unitid`, `rate`, `disc`, `imgname`, `enable`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(6, 9, 'Chowmein', 0, 4, 80, 0, 'DOC1525672287035.3.jpg', 'enable', 0, 'fe80::cb0:6d51:358b:2ed', '2019-01-17', '2018-05-07'),
(7, 9, 'Spring Rolls', 0, 4, 120, 0, 'DOC1525672347564.7.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(8, 9, 'Hakka Noodles', 0, 4, 150, 0, 'DOC1525672392407.3.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(9, 9, 'Chilli Paneer', 0, 4, 110, 0, 'DOC1525672469539.7.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(10, 11, 'Spicy Chicken Masala', 0, 4, 220, 0, 'DOC1525672632840.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(11, 11, 'Chicken Roll', 0, 4, 180, 0, 'DOC1525672744856.4.JPG', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(12, 11, 'Chicken Bharta', 0, 4, 180, 0, 'DOC1525672784013.7.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(13, 11, 'Chicken Stir Fry', 0, 4, 200, 0, 'DOC1525672821771.9.JPG', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(14, 11, 'Chicken Gravy', 0, 4, 280, 0, 'DOC1525672921225.5.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(15, 7, 'Potato chip', 0, 4, 50, 0, 'DOC1525673045817.7.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(16, 7, 'Paneer Tikkas', 0, 4, 80, 0, 'DOC1525673141529.1.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(17, 7, 'Aloo and Dal ki Tikki', 0, 4, 100, 0, 'DOC1525673171468.8.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(18, 7, 'Cheese Balls', 0, 4, 120, 0, 'DOC1525673192481.1.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(19, 6, 'Idli', 0, 4, 50, 0, 'DOC1525673269347.4.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(20, 6, 'Medhu Vada', 0, 4, 50, 0, 'DOC1525673318666.3.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(21, 6, 'Dosa', 0, 4, 80, 0, 'DOC1525673473432.1.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(22, 8, 'Gulab Jamun', 0, 4, 100, 0, 'DOC1525673556690.9.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(23, 8, 'Gajar Ka Halwa', 0, 4, 120, 0, 'DOC1525673593007.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(24, 8, 'Modak', 0, 2, 30, 0, 'DOC1525673616878.3.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '2018-05-07', '2018-05-07'),
(25, 8, 'Kulfi', 0, 2, 30, 0, 'DOC1525673664255.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '2018-05-07', '2018-05-07'),
(26, 10, 'Aloo Gobhi:', 0, 4, 120, 0, 'DOC1525673772319.2.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(27, 10, 'Bhindi Masala:', 0, 4, 100, 0, 'DOC1525673801107.9.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(28, 10, 'Jeera Rice:', 0, 4, 120, 0, 'DOC1525673827455.4.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(29, 10, 'Aloo Matar:', 0, 4, 80, 0, 'DOC1525673858404.1.jpg', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(31, 12, 'pasta con pomodoro', 0, 4, 250, 0, 'DOC1530944579567.4.jpg', 'enable', 0, 'fe80::a5de:ef69:c8d3:b611', '0000-00-00', '2018-07-07'),
(32, 12, 'margherita pizza', 0, 4, 450, 0, 'DOC1530944628878.3.jpg', 'enable', 0, 'fe80::a5de:ef69:c8d3:b611', '0000-00-00', '2018-07-07'),
(33, 7, 'SAMOSA', 0, 4, 25, 0, '', 'enable', 0, '::1', '0000-00-00', '2019-07-08');

-- --------------------------------------------------------

--
-- Table structure for table `m_product_category`
--

CREATE TABLE IF NOT EXISTS `m_product_category` (
  `pcatid` int(11) NOT NULL AUTO_INCREMENT,
  `catname` varchar(150) NOT NULL,
  `status` varchar(20) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(25) NOT NULL,
  `lastupdated` date NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`pcatid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `m_product_category`
--

INSERT INTO `m_product_category` (`pcatid`, `catname`, `status`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(6, 'SOUTH INDIAN', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(7, 'SNACKS', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(8, 'SWEETS', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(9, 'CHINESE', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(10, 'VEG', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(11, 'NON-VAGE', 'enable', 0, 'fe80::f903:8501:b82e:ea96', '0000-00-00', '2018-05-07'),
(12, 'ITALIAN DISH', 'enable', 0, '::1', '2019-07-08', '2018-07-07');

-- --------------------------------------------------------

--
-- Table structure for table `m_session`
--

CREATE TABLE IF NOT EXISTS `m_session` (
  `sessionid` int(11) NOT NULL AUTO_INCREMENT,
  `fromdate` date NOT NULL,
  `todate` date NOT NULL,
  `session_name` varchar(200) NOT NULL,
  `status` int(11) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(25) NOT NULL,
  `lastupdated` date NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`sessionid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `m_session`
--

INSERT INTO `m_session` (`sessionid`, `fromdate`, `todate`, `session_name`, `status`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(2, '2017-04-01', '2018-03-31', '2017-2018', 1, 1, 'fe80::3404:7424:fecf:f3e6', '0000-00-00', '2017-04-05');

-- --------------------------------------------------------

--
-- Table structure for table `m_shop`
--

CREATE TABLE IF NOT EXISTS `m_shop` (
  `shop_id` int(11) NOT NULL AUTO_INCREMENT,
  `shop_name` varchar(100) NOT NULL,
  `telphone` varchar(25) NOT NULL,
  `address` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(100) NOT NULL,
  `lastupdated` date NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`shop_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `m_shop`
--


-- --------------------------------------------------------

--
-- Table structure for table `m_table`
--

CREATE TABLE IF NOT EXISTS `m_table` (
  `table_id` int(11) NOT NULL AUTO_INCREMENT,
  `table_no` varchar(100) NOT NULL,
  `enable` varchar(20) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(25) NOT NULL,
  `lastupdated` date NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`table_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `m_table`
--

INSERT INTO `m_table` (`table_id`, `table_no`, `enable`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(1, 'table1', 'enable', 0, 'fe80::3013:93:4f85:8fba', '0000-00-00', '2017-09-11'),
(2, 'table2', 'enable', 0, 'fe80::3013:93:4f85:8fba', '0000-00-00', '2017-09-11'),
(3, 'table4', 'enable', 0, '192.168.0.7', '0000-00-00', '2017-09-12'),
(4, 'table3', 'enable', 0, '192.168.0.7', '0000-00-00', '2017-09-12'),
(5, 'Table5', 'enable', 0, 'fe80::5850:e173:7a4a:7420', '2019-01-16', '2019-01-14');

-- --------------------------------------------------------

--
-- Table structure for table `m_unit`
--

CREATE TABLE IF NOT EXISTS `m_unit` (
  `unitid` int(11) NOT NULL AUTO_INCREMENT,
  `unit_name` varchar(100) NOT NULL,
  `enable` varchar(20) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(25) NOT NULL,
  `lastupdated` date NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`unitid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `m_unit`
--

INSERT INTO `m_unit` (`unitid`, `unit_name`, `enable`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(2, 'pcs', 'enable', 0, 'fe80::3404:7424:fecf:f3e6', '0000-00-00', '2017-06-13'),
(4, 'plate', 'enable', 0, 'fe80::6493:c651:716c:bda6', '0000-00-00', '2017-06-15'),
(6, 'spoon', 'enable', 0, '::1', '0000-00-00', '2019-07-16'),
(7, 'chair', 'enable', 0, '::1', '0000-00-00', '2019-08-09');

-- --------------------------------------------------------

--
-- Table structure for table `tax_setting`
--

CREATE TABLE IF NOT EXISTS `tax_setting` (
  `tax_id` int(11) NOT NULL AUTO_INCREMENT,
  `tax_name` varchar(100) NOT NULL,
  `tax` float NOT NULL,
  `is_applicable` int(11) NOT NULL COMMENT '0=no, 1=yes',
  `createdby` int(11) NOT NULL,
  `ipaddress` int(11) NOT NULL,
  `lastupdated` date NOT NULL,
  `createdate` date NOT NULL,
  PRIMARY KEY (`tax_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `tax_setting`
--

INSERT INTO `tax_setting` (`tax_id`, `tax_name`, `tax`, `is_applicable`, `createdby`, `ipaddress`, `lastupdated`, `createdate`) VALUES
(10, 'SGST', 2.5, 1, 0, 0, '0000-00-00', '2019-01-15'),
(11, 'CGST', 2.5, 1, 0, 0, '0000-00-00', '2019-01-15'),
(12, 'SERCHARGE', 5, 1, 0, 0, '0000-00-00', '2019-01-15');

-- --------------------------------------------------------

--
-- Table structure for table `tax_setting_new`
--

CREATE TABLE IF NOT EXISTS `tax_setting_new` (
  `taxid` int(11) NOT NULL AUTO_INCREMENT,
  `sgst` float NOT NULL,
  `cgst` float NOT NULL,
  `sercharge` float NOT NULL,
  `is_applicable` int(11) NOT NULL COMMENT '(1=applicable,0=not applicable)',
  PRIMARY KEY (`taxid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `tax_setting_new`
--

INSERT INTO `tax_setting_new` (`taxid`, `sgst`, `cgst`, `sercharge`, `is_applicable`) VALUES
(1, 2.5, 2.5, 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `userid` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(10) NOT NULL,
  `enable` varchar(20) NOT NULL,
  `createdby` int(11) NOT NULL,
  `ipaddress` varchar(30) NOT NULL,
  `createdate` datetime NOT NULL,
  PRIMARY KEY (`userid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `username`, `password`, `usertype`, `enable`, `createdby`, `ipaddress`, `createdate`) VALUES
(1, 'admin', '123', 'admin', 'enable', 1, '::1', '2019-01-15 12:15:59');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
