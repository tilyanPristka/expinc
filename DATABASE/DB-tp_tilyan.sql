-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 11, 2015 at 11:00 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tp_tilyan`
--

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_activities`
--

CREATE TABLE `tilyan_activities` (
  `AccID` bigint(100) NOT NULL,
  `LogID` bigint(100) NOT NULL,
  `CoID` int(10) NOT NULL,
  `Activities` text COLLATE latin1_general_ci,
  PRIMARY KEY (`AccID`),
  FULLTEXT KEY `Activities` (`Activities`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tilyan_activities`
--


-- --------------------------------------------------------

--
-- Table structure for table `tilyan_administrator`
--

CREATE TABLE `tilyan_administrator` (
  `AdminID` varchar(32) COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `DateCreated` datetime DEFAULT NULL,
  `LastLogin` datetime DEFAULT NULL,
  `NIP` varchar(80) COLLATE latin1_general_ci DEFAULT NULL,
  `Subdit` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `Telepon` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `Username` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `Password` varchar(64) CHARACTER SET latin1 COLLATE latin1_bin DEFAULT NULL,
  `FullName` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  `Email` varchar(100) COLLATE latin1_general_ci DEFAULT NULL,
  `Status` enum('1','2','3') COLLATE latin1_general_ci DEFAULT NULL,
  `Active` enum('0','1') COLLATE latin1_general_ci DEFAULT NULL,
  `OperatorID` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`AdminID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tilyan_administrator`
--

INSERT INTO `tilyan_administrator` VALUES('b813f0a79277b676eb97e3d5e843974c', '2009-09-02 16:25:31', '2015-11-24 14:51:24', '20051224', 'Owner', '7654321', 'admin', '827ccb0eea8a706c4c34a16891f84e7b', 'administrator', 'administrator@tilyanpristka.id', '1', '1', '');

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_adminlog`
--

CREATE TABLE `tilyan_adminlog` (
  `LogID` int(10) NOT NULL AUTO_INCREMENT,
  `DateModified` datetime DEFAULT NULL,
  `LogDescription` varchar(240) COLLATE latin1_general_ci DEFAULT NULL,
  `LogStatus` enum('0','1') COLLATE latin1_general_ci NOT NULL DEFAULT '0',
  `IPAddress` varchar(150) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`LogID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=345 ;

--
-- Dumping data for table `tilyan_adminlog`
--

INSERT INTO `tilyan_adminlog` VALUES(344, '2015-11-24 14:51:24', 'Login Success. Username = (admin)', '1', '::1');
INSERT INTO `tilyan_adminlog` VALUES(343, '2015-11-24 14:51:18', 'Login Failed. Username = (tpdemo) and Password = (tpdemo)', '0', '::1');
INSERT INTO `tilyan_adminlog` VALUES(342, '2015-11-24 14:51:12', 'Login Failed. Username = (tpdemo) and Password = (tpdemo)', '0', '::1');
INSERT INTO `tilyan_adminlog` VALUES(331, '2015-08-06 00:40:06', 'Login Failed. Username = (tp_demo) and Password = (tp_demo)', '0', '127.0.0.1');
INSERT INTO `tilyan_adminlog` VALUES(332, '2015-11-12 18:24:48', 'Login Failed. Username = (admin) and Password = (adminadmin)', '0', '::1');
INSERT INTO `tilyan_adminlog` VALUES(333, '2015-11-12 18:24:50', 'Login Failed. Username = (admin) and Password = (admin)', '0', '::1');
INSERT INTO `tilyan_adminlog` VALUES(334, '2015-11-12 18:24:52', 'Login Failed. Username = (admin) and Password = ()', '0', '::1');
INSERT INTO `tilyan_adminlog` VALUES(335, '2015-11-12 18:28:06', 'Login Success. Username = (admin)', '1', '::1');
INSERT INTO `tilyan_adminlog` VALUES(336, '2015-11-12 18:29:49', 'Login Success. Username = (admin)', '1', '::1');
INSERT INTO `tilyan_adminlog` VALUES(337, '2015-11-12 18:33:07', 'Login Success. Username = (admin)', '1', '::1');
INSERT INTO `tilyan_adminlog` VALUES(338, '2015-11-12 18:49:02', 'Login Failed. Username = (tpdemo) and Password = (tpdemo)', '0', '::1');
INSERT INTO `tilyan_adminlog` VALUES(339, '2015-11-12 18:49:06', 'Login Success. Username = (admin)', '1', '::1');
INSERT INTO `tilyan_adminlog` VALUES(340, '2015-11-12 18:57:17', 'Login Failed. Username = (tpdemo) and Password = (tpdemo)', '0', '::1');
INSERT INTO `tilyan_adminlog` VALUES(341, '2015-11-24 13:22:57', 'Login Success. Username = (admin)', '1', '::1');

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_adminpermission`
--

CREATE TABLE `tilyan_adminpermission` (
  `AdminPermissionID` int(10) NOT NULL AUTO_INCREMENT,
  `DateModified` datetime DEFAULT NULL,
  `AdminID` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  `PermissionID` tinyint(4) DEFAULT NULL,
  `OperatorID` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`AdminPermissionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=273 ;

--
-- Dumping data for table `tilyan_adminpermission`
--

INSERT INTO `tilyan_adminpermission` VALUES(238, '2009-09-02 16:25:31', 'b813f0a79277b676eb97e3d5e843974c', 12, '');

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_memberlog`
--

CREATE TABLE `tilyan_memberlog` (
  `LogID` bigint(100) NOT NULL AUTO_INCREMENT,
  `CoID` int(10) NOT NULL,
  `LogDate` datetime DEFAULT NULL,
  PRIMARY KEY (`LogID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=68 ;

--
-- Dumping data for table `tilyan_memberlog`
--

INSERT INTO `tilyan_memberlog` VALUES(67, 7, '2010-08-18 12:44:02');

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_members`
--

CREATE TABLE `tilyan_members` (
  `CoID` int(10) NOT NULL AUTO_INCREMENT,
  `CoName` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CoLogo` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CoAddress` text COLLATE latin1_general_ci,
  `CoUser` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CoPass` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `CoFolder` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CoEmail` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CoEnabled` enum('0','1') COLLATE latin1_general_ci DEFAULT NULL,
  `CoNotes` text COLLATE latin1_general_ci,
  `LastLogin` datetime DEFAULT NULL,
  PRIMARY KEY (`CoID`),
  FULLTEXT KEY `CoName` (`CoName`,`CoAddress`,`CoFolder`,`CoNotes`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=22 ;

--
-- Dumping data for table `tilyan_members`
--

INSERT INTO `tilyan_members` VALUES(10, 'PT. Tilyanpristka Demo', 'PT_tP_demo.jpg', 'Jl. Ciomas I No.16\r\nKebayoran Baru\r\nJakarta Selatan\r\n12180', 'tp_demo', 'tp_demo', 'tp_demo', 'tp_demo@tilyanpristka.id', '1', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_membersperson`
--

CREATE TABLE `tilyan_membersperson` (
  `CP_ID` int(10) NOT NULL AUTO_INCREMENT,
  `CoID` int(10) DEFAULT NULL,
  `CP_DateCreated` datetime DEFAULT NULL,
  `CP_LastLogin` datetime DEFAULT NULL,
  `CP_User` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CP_Pass` varchar(25) COLLATE latin1_general_ci DEFAULT NULL,
  `CP_Fullname` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CP_Email` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CP_NickName` varchar(10) COLLATE latin1_general_ci DEFAULT NULL,
  `CP_Enabled` enum('0','1') COLLATE latin1_general_ci DEFAULT NULL,
  `CP_Permission` int(10) DEFAULT NULL,
  PRIMARY KEY (`CP_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=25 ;

--
-- Dumping data for table `tilyan_membersperson`
--

INSERT INTO `tilyan_membersperson` VALUES(11, 10, '2010-08-30 11:34:17', '2015-12-11 22:43:06', 'tpdemo', 'tpdemo', 'Web Support', 'tp_demo@tilyanpristka.id', 'tpd', '1', NULL);
INSERT INTO `tilyan_membersperson` VALUES(16, 10, '2010-10-26 12:04:21', '2012-01-12 17:16:47', 'dataentry', 'dataentry', 'Data Entry', 'dataentry@tilyanpristka.id', 'dte', '1', 1);
INSERT INTO `tilyan_membersperson` VALUES(17, 10, '2010-10-26 12:04:58', '2012-02-10 14:30:28', 'supervisor', 'supervisor', 'Supervisor', 'supervisor@tilyanpristka.id', 'spv', '1', 2);

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_memberspersonlog`
--

CREATE TABLE `tilyan_memberspersonlog` (
  `CP_LogID` bigint(100) NOT NULL AUTO_INCREMENT,
  `CP_ID` int(10) DEFAULT NULL,
  `CoID` int(10) DEFAULT NULL,
  `LogDate` datetime DEFAULT NULL,
  PRIMARY KEY (`CP_LogID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=600 ;

--
-- Dumping data for table `tilyan_memberspersonlog`
--

INSERT INTO `tilyan_memberspersonlog` VALUES(599, 11, 10, '2015-12-11 22:43:06');
INSERT INTO `tilyan_memberspersonlog` VALUES(593, 11, 10, '2015-11-12 18:50:10');
INSERT INTO `tilyan_memberspersonlog` VALUES(594, 11, 10, '2015-11-12 18:51:25');
INSERT INTO `tilyan_memberspersonlog` VALUES(595, 11, 10, '2015-11-12 18:56:16');
INSERT INTO `tilyan_memberspersonlog` VALUES(596, 11, 10, '2015-11-12 18:57:31');
INSERT INTO `tilyan_memberspersonlog` VALUES(597, 11, 10, '2015-11-24 13:33:40');
INSERT INTO `tilyan_memberspersonlog` VALUES(598, 11, 10, '2015-11-24 13:36:19');

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_memberstable`
--

CREATE TABLE `tilyan_memberstable` (
  `CoID` int(10) DEFAULT NULL,
  `TableName` text COLLATE latin1_general_ci
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;

--
-- Dumping data for table `tilyan_memberstable`
--

INSERT INTO `tilyan_memberstable` VALUES(10, 'tilyan_tp_demo_lookup_code2');
INSERT INTO `tilyan_memberstable` VALUES(10, 'tilyan_tp_demo_lookup_code1');
INSERT INTO `tilyan_memberstable` VALUES(10, 'tilyan_tp_demo_document');
INSERT INTO `tilyan_memberstable` VALUES(10, 'tilyan_tp_demo_account');
INSERT INTO `tilyan_memberstable` VALUES(10, 'tilyan_tp_demo_lookup_account');

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_permission`
--

CREATE TABLE `tilyan_permission` (
  `PermissionID` tinyint(4) NOT NULL AUTO_INCREMENT,
  `DateAdded` datetime DEFAULT NULL,
  `PermissionName` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `PermissionValue` varchar(200) COLLATE latin1_general_ci DEFAULT NULL,
  `OperatorID` varchar(32) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`PermissionID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=29 ;

--
-- Dumping data for table `tilyan_permission`
--

INSERT INTO `tilyan_permission` VALUES(12, '2005-05-22 00:00:00', 'members', 'Managing Member List', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_switch`
--

CREATE TABLE `tilyan_switch` (
  `CoFolder` varchar(255) DEFAULT NULL,
  `DocFolder` int(5) DEFAULT NULL,
  `DocNickName` int(5) DEFAULT NULL,
  `DocTime` int(5) DEFAULT NULL,
  UNIQUE KEY `DocFolder` (`DocFolder`,`DocNickName`,`DocTime`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tilyan_switch`
--


-- --------------------------------------------------------

--
-- Table structure for table `tilyan_tp_demo_account`
--

CREATE TABLE `tilyan_tp_demo_account` (
  `TransID` bigint(100) NOT NULL AUTO_INCREMENT,
  `DocID` bigint(100) DEFAULT NULL,
  `AccNo` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `DocCode` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `DocCode2` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `DocCode3` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `AccName` text COLLATE latin1_general_ci,
  `Description` text COLLATE latin1_general_ci,
  `Amount` decimal(65,2) DEFAULT NULL,
  `DRCR` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`TransID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=39 ;

--
-- Dumping data for table `tilyan_tp_demo_account`
--

INSERT INTO `tilyan_tp_demo_account` VALUES(1, 1, '6-311-002', 'tP', NULL, NULL, 'Biaya Materai', 'Biaya materai orang jakarta', 1000000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(2, 4, '4-112', 'PM1', NULL, NULL, 'Pendapatan Bor', 'DP I Dari PT Fiki', 30000000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(3, 5, '6-312-007', 'CMB', 'ACT', NULL, 'Biaya Jilid', 'Jilid proposal project', 160000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(4, 6, '6-314-003', 'CMB', 'ACT', NULL, 'Biaya Perbaikan Ruang Kantor', 'entertainment orang jakarta hotel jatri', 4500000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(5, 6, '5-111-201', 'CMB', 'ACT', NULL, 'Biaya Gaji Honorer', 'bayar outsorcing', 2000000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(6, 7, '5-111-101', 'tP', NULL, NULL, 'Biaya ATK', 'beli kalkulator', 50000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(7, 8, '5-113-302', 'CMB', NULL, NULL, 'Biaya Angkutan Umum', 'Perbaiki Mobil', 250000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(8, 12, '6-212-001', 'tP', '', NULL, 'Biaya Telpon', 'Telpon bulan Nopember 2010', 50000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(9, 12, '6-212-002', 'tP', '', NULL, 'Biaya Fax', 'Fax bulan Nopember 2010', 20000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(13, 17, '6-212-001', NULL, NULL, NULL, 'Biaya Telpon', 'coba', 2000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(12, 17, '5-111-002', NULL, NULL, NULL, 'Biaya Cetak', 'Coba', 5000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(14, 18, '5-111-002', NULL, NULL, NULL, 'Biaya Cetak', 'coba', -5000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(15, 18, '6-212-001', NULL, NULL, NULL, 'Biaya Telpon', 'coba', -2000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(16, 19, '5-111-002', NULL, NULL, NULL, 'Biaya Cetak', 'coba 1', 5000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(17, 14, '6-212-001', NULL, NULL, NULL, 'Biaya Telpon', 'coba 2', 2000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(18, 27, '6-111-010', NULL, NULL, NULL, 'Biaya Gaji Pegawai Tetap', 'TES', 15000000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(19, 29, '6-212-001', NULL, NULL, NULL, 'Biaya Telpon', 'Tes 2', 250000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(20, 29, '6-212-002', NULL, NULL, NULL, 'Biaya Fax', 'T es 3', 100000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(21, 29, '6-315-001', NULL, NULL, NULL, 'Biaya Alat Internet', 'Tes 4', 150000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(22, 29, '6-211', NULL, NULL, NULL, 'Biaya PLN', 'Tes 5', 500000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(23, 30, '4-111', NULL, NULL, NULL, 'Pendapatan Cetak', 'pendapatan batu bara', 20000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(24, 32, '1-011', NULL, NULL, NULL, 'Kas', 'Uang masuk', 1000000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(25, 33, '6-312-002', NULL, NULL, NULL, 'Biaya Cetak', 'Cetak kartu nama', 50000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(26, 35, '6-312-003', NULL, NULL, NULL, 'Biaya Kertas', 'beli kertas', 200000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(27, 35, '6-318', NULL, NULL, NULL, 'Biaya Kebersihan & KeamananLingkungan', 'Satpam', 100000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(28, 36, '6-312-004', NULL, NULL, NULL, 'Biaya Tinta Printer', 'Tinta Printer', 50000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(29, 36, '6-312-001', NULL, NULL, NULL, 'Biaya Photocopy', 'Photo Copy', 50000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(30, 37, '6-212-001', NULL, NULL, NULL, 'Biaya Telpon', 'Telpon bulan Nopember', 150000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(31, 37, '6-211', NULL, NULL, NULL, 'Biaya PLN', 'Listrik Nopember', 200000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(32, 38, '4-111', NULL, NULL, NULL, 'Pendapatan Cetak', 'pendapatan', 200000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(33, 39, '5-111-002', NULL, NULL, NULL, 'Biaya Cetak', 'Ongkos cetak', 150000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(34, 40, '4-111', NULL, NULL, NULL, 'Pendapatan Cetak', 'hjhhjkhjkhj', 50000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(35, 42, '5-112-201', NULL, NULL, NULL, 'Biaya Gaji Honorer', 'ghghgh', 2500000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(36, 43, '6-315-001', NULL, NULL, NULL, 'Biaya Alat Internet', 'Beli modem', 860000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(37, 43, '6-317', NULL, NULL, NULL, 'Biaya Entertainment', 'Cafe makoro', 234000.00, NULL);
INSERT INTO `tilyan_tp_demo_account` VALUES(38, 46, '6-314-003', NULL, NULL, NULL, 'Biaya Perbaikan Ruang Kantor', 'ghfghfghd', 800000.00, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_tp_demo_document`
--

CREATE TABLE `tilyan_tp_demo_document` (
  `DocID` bigint(100) NOT NULL AUTO_INCREMENT,
  `RefDocID` bigint(100) DEFAULT NULL,
  `DocRealDate` date DEFAULT NULL,
  `DocDate` date DEFAULT NULL,
  `DocFullNo` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `DocFolder` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `DocADJ` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `DocType` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `DocInOut` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `DocNickName` varchar(50) COLLATE latin1_general_ci DEFAULT NULL,
  `DocCode` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `DocCode2` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `DocCode3` varchar(5) COLLATE latin1_general_ci DEFAULT NULL,
  `DocYear` int(10) DEFAULT NULL,
  `DocMonth` int(10) DEFAULT NULL,
  `DocTime` varchar(15) COLLATE latin1_general_ci DEFAULT NULL,
  `DocNo` bigint(100) DEFAULT NULL,
  `DocNotes` text COLLATE latin1_general_ci,
  `DocClear` int(10) DEFAULT NULL,
  `DocClearDate` date DEFAULT NULL,
  `DocAdjusted` int(10) DEFAULT NULL,
  `DocPrinted` int(10) DEFAULT NULL,
  PRIMARY KEY (`DocID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=48 ;

--
-- Dumping data for table `tilyan_tp_demo_document`
--

INSERT INTO `tilyan_tp_demo_document` VALUES(1, NULL, NULL, '2010-08-30', 'TP_DEMO.C.O.TPD.tP.2010.08.1407.0001', 'tp_demo', NULL, 'C', 'O', 'tpd', 'tP', NULL, NULL, 2010, 8, '1407', 1, '', 1, NULL, NULL, 2);
INSERT INTO `tilyan_tp_demo_document` VALUES(2, NULL, NULL, '2010-09-21', 'TP_DEMO.C.I.TPD.tP.2010.09', 'tp_demo', NULL, 'C', 'I', 'tpd', 'tP', NULL, NULL, 2010, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(3, NULL, NULL, '2010-09-21', 'TP_DEMO.C.I.TPD.tP.2010.09', 'tp_demo', NULL, 'C', 'I', 'tpd', 'tP', NULL, NULL, 2010, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(4, NULL, NULL, '2010-10-02', 'TP_DEMO.C.I.TPD.PM1.2010.10.1036.0001', 'tp_demo', NULL, 'C', 'I', 'tpd', 'PM1', NULL, NULL, 2010, 10, '1036', 1, '', 1, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(5, NULL, NULL, '2010-10-26', 'TP_DEMO.C.O.DTE.CMB.ACT.2010.10.1215.0002', 'tp_demo', NULL, 'C', 'O', 'dte', 'CMB', 'ACT', NULL, 2010, 10, '1215', 2, '', 1, NULL, NULL, 1);
INSERT INTO `tilyan_tp_demo_document` VALUES(6, NULL, NULL, '2010-10-27', 'TP_DEMO.C.O.DTE.CMB.ACT.2010.10.2203.0003', 'tp_demo', NULL, 'C', 'O', 'dte', 'CMB', 'ACT', NULL, 2010, 10, '2203', 3, 'wooyy salah... bukan di kepala 5...harusnya ini biaya biasa aja, bukan untuk project... rubah ya!!!', 1, NULL, 1, 1);
INSERT INTO `tilyan_tp_demo_document` VALUES(7, NULL, NULL, '2010-11-02', 'TP_DEMO.C.I.DTE.tP.2010.11.1150.0001', 'tp_demo', NULL, 'C', 'I', 'dte', 'tP', '', NULL, 2010, 11, '1150', 1, 'testing dahlia', 0, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(8, NULL, NULL, '2010-11-04', 'TP_DEMO.C.I.DTE.CMB.2010.11.0841.0002', 'tp_demo', NULL, 'C', 'I', 'dte', 'CMB', '', NULL, 2010, 11, '0841', 2, 'Pak, yang 6314002, salah class, diperbaiki!', 1, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(9, 6, NULL, '2010-11-04', 'TP_DEMO.ADJ.C.I.DTE.CMB.2010.11', 'tp_demo', 'ADJ', 'C', 'I', 'dte', 'CMB', 'ACT', NULL, 2010, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(12, NULL, NULL, '2010-12-09', 'TP_DEMO.C.O.TPD.2010.12.1631.0001', 'tp_demo', NULL, 'C', 'O', 'tpd', '', '', NULL, 2010, 12, '1631', 1, 'tes', 1, NULL, 1, 2);
INSERT INTO `tilyan_tp_demo_document` VALUES(13, NULL, NULL, '2010-12-09', 'TP_DEMO.C.O.TPD.2010.12.1731.0002', 'tp_demo', NULL, 'C', 'O', 'tpd', '', '', NULL, 2010, 12, '1731', 2, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(14, NULL, NULL, '2010-12-09', 'TP_DEMO.C.O.TPD.tP.2010.12.1235.0006', 'tp_demo', NULL, 'C', 'O', 'tpd', 'tP', '', NULL, 2010, 12, '1235', 6, '', 1, NULL, NULL, 2);
INSERT INTO `tilyan_tp_demo_document` VALUES(15, NULL, NULL, '2010-12-09', 'TP_DEMO.C.I.TPD.tP.2010.12', 'tp_demo', NULL, 'C', 'I', 'tpd', 'tP', '', NULL, 2010, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(16, 12, NULL, '2010-12-09', 'TP_DEMO.ADJ.C.O.TPD.tP..2010.12', 'tp_demo', 'ADJ', 'C', 'O', 'tpd', 'tP', '', NULL, 2010, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(17, NULL, NULL, '2010-12-10', 'TP_DEMO.C.O.TPD.CMB.2010.12.1159.0003', 'tp_demo', NULL, 'C', 'O', 'tpd', 'CMB', '', NULL, 2010, 12, '1159', 3, '', 1, NULL, 1, 1);
INSERT INTO `tilyan_tp_demo_document` VALUES(18, 17, NULL, '2010-12-10', 'TP_DEMO.ADJ.C.O.TPD.CMB..2010.12.1228.0004', 'tp_demo', 'ADJ', 'C', 'O', 'tpd', 'CMB', '', NULL, 2010, 12, '1228', 4, '', 1, NULL, NULL, 4);
INSERT INTO `tilyan_tp_demo_document` VALUES(19, NULL, NULL, '2010-12-10', 'TP_DEMO.C.O.TPD.CMB.2010.12.1234.0005', 'tp_demo', NULL, 'C', 'O', 'tpd', 'CMB', '', NULL, 2010, 12, '1234', 5, '', 1, NULL, NULL, 1);
INSERT INTO `tilyan_tp_demo_document` VALUES(20, NULL, NULL, '2010-12-10', 'TP_DEMO.C.O.TPD.tP.2010.12', 'tp_demo', NULL, 'C', 'O', 'tpd', 'tP', '', NULL, 2010, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(24, NULL, NULL, '2011-02-07', 'TP_DEMO.C.I.TPD.CMB.2011.02', 'tp_demo', NULL, 'C', 'I', 'tpd', 'CMB', '', NULL, 2011, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(23, NULL, NULL, '2011-02-07', 'TP_DEMO.C.I.TPD.MND.MRK.2011.02.1227.0001', 'tp_demo', NULL, 'C', 'I', 'tpd', 'MND', 'MRK', NULL, 2011, 2, '1227', 1, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(27, NULL, '2011-02-16', '2011-02-16', 'TP_DEMO.C.O.TPD.tP.2011.02.1437.0002', 'tp_demo', NULL, 'C', 'O', 'tpd', 'tP', '', NULL, 2011, 2, '1437', 2, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(28, NULL, '2011-02-24', '2011-02-24', 'TP_DEMO.C.I.TPD.tP.2011.02', 'tp_demo', NULL, 'C', 'I', 'tpd', 'tP', '', NULL, 2011, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(29, NULL, '2011-02-25', '2011-02-25', 'TP_DEMO.C.O.TPD.tP.2011.02.0858.0003', 'tp_demo', NULL, 'C', 'O', 'tpd', 'tP', '', NULL, 2011, 2, '0858', 3, 'rewdft', 0, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(30, NULL, '2011-06-21', '2011-06-21', 'TP_DEMO.B.I.TPD.tP.2011.06.0732.0001', 'tp_demo', NULL, 'B', 'I', 'tpd', 'tP', '', '', 2011, 6, '0732', 1, '', 1, '2011-06-21', NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(32, NULL, '2011-12-23', '2011-12-10', 'TP_DEMO.C.I.TPD.tP.2011.12.1200.0001', 'tp_demo', NULL, 'C', 'I', 'tpd', 'tP', '', '', 2011, 12, '1200', 1, '', 1, '2011-12-23', NULL, 1);
INSERT INTO `tilyan_tp_demo_document` VALUES(33, NULL, '2011-12-23', '2011-12-11', 'TP_DEMO.C.O.TPD.tP.2011.12.1201.0002', 'tp_demo', NULL, 'C', 'O', 'tpd', 'tP', '', '', 2011, 12, '1201', 2, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(35, NULL, '2011-12-23', '2011-12-12', 'TP_DEMO.C.O.TPD.tP.2011.12.1203.0003', 'tp_demo', NULL, 'C', 'O', 'tpd', 'tP', '', '', 2011, 12, '1203', 3, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(36, NULL, '2011-12-23', '2011-12-14', 'TP_DEMO.C.O.TPD.tP.2011.12.1204.0004', 'tp_demo', NULL, 'C', 'O', 'tpd', 'tP', '', '', 2011, 12, '1204', 4, '', 1, '2011-12-23', NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(37, NULL, '2011-12-23', '2011-12-15', 'TP_DEMO.C.O.TPD.tP.2011.12.1206.0005', 'tp_demo', NULL, 'C', 'O', 'tpd', 'tP', '', '', 2011, 12, '1206', 5, '', 1, '2011-12-23', NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(38, NULL, '2011-12-23', '2011-12-09', 'TP_DEMO.B.I.TPD.CMB.2011.12.1209.0006', 'tp_demo', NULL, 'B', 'I', 'tpd', 'CMB', '', '', 2011, 12, '1209', 6, '', 1, '2011-12-23', NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(39, NULL, '2011-12-23', '2011-12-09', 'TP_DEMO.B.O.TPD.CMB.2011.12.1210.0007', 'tp_demo', NULL, 'B', 'O', 'tpd', 'CMB', '', '', 2011, 12, '1210', 7, '', 1, '2011-12-23', NULL, 1);
INSERT INTO `tilyan_tp_demo_document` VALUES(40, NULL, '2011-12-28', '2011-12-26', 'TP_DEMO.C.I.TPD.tP.FIN.2011.12.2125.0008', 'tp_demo', NULL, 'C', 'I', 'tpd', 'tP', 'FIN', '', 2011, 12, '2125', 8, '', 1, '2011-12-28', NULL, 2);
INSERT INTO `tilyan_tp_demo_document` VALUES(42, NULL, '2011-12-28', '2011-12-28', 'TP_DEMO.C.O.DTE.tP.2011.12.2134.0009', 'tp_demo', NULL, 'C', 'O', 'dte', 'tP', '', '', 2011, 12, '2134', 9, 'ini salah, harusnya biaya honor project kemarin', 0, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(43, NULL, '2011-12-29', '2011-12-29', 'TP_DEMO.C.O.DTE.CMN.LOG.2011.12.1500.0010', 'tp_demo', NULL, 'C', 'O', 'dte', 'CMN', 'LOG', '', 2011, 12, '1500', 10, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(44, NULL, '2012-01-03', '2012-01-03', 'TP_DEMO.C.I.TPD.tP.2012.01', 'tp_demo', NULL, 'C', 'I', 'tpd', 'tP', '', '', 2012, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(45, NULL, '2012-01-05', '2012-01-05', 'TP_DEMO.C.I.TPD.tP.2012.01', 'tp_demo', NULL, 'C', 'I', 'tpd', 'tP', '', '', 2012, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_document` VALUES(46, NULL, '2012-01-10', '2012-01-10', 'TP_DEMO.C.O.DTE.CMN.2012.01.1316.0001', 'tp_demo', NULL, 'C', 'O', 'dte', 'CMN', '', '', 2012, 1, '1316', 1, 'dfgdfg', 1, '2012-01-10', NULL, 6);

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_tp_demo_lookup_account`
--

CREATE TABLE `tilyan_tp_demo_lookup_account` (
  `ID` bigint(100) NOT NULL AUTO_INCREMENT,
  `AccNo` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `AccName` text COLLATE latin1_general_ci,
  `Type` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `Status` enum('0','1') COLLATE latin1_general_ci DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=123 ;

--
-- Dumping data for table `tilyan_tp_demo_lookup_account`
--

INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(1, '1011', 'Kas', 'Cash/Bank', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(2, '1012', 'Kas - Produksi', 'Cash/Bank', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(3, '1013', 'Bank - Artha Graha', 'Cash/Bank', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(4, '1111', 'Investasi', 'Account Receivable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(5, '1121', 'Piutang Usaha', 'Account Receivable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(6, '1122', 'Piutang Usaha Lain', 'Account Receivable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(7, '1123', 'Piutang Pemegang Saham', 'Account Receivable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(8, '1129', 'Piutang Tidak Tertagih', 'Account Receivable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(9, '1130', 'Biaya Dibayar Dimuka', 'Other Current Asset', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(10, '1211', 'Komputer', 'Fixed Asset', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(11, '1212', 'Printer', 'Fixed Asset', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(12, '1213', 'Furniture Kantor', 'Fixed Asset', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(13, '1214', 'Peralatan Kantor', 'Fixed Asset', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(14, '1311', 'Akum Penyusutan - Komputer', 'Fixed Asset', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(15, '1312', 'Akum Penyusutan - Printer', 'Fixed Asset', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(16, '1313', 'Akum Penyusutan - Furniture Kantor', 'Fixed Asset', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(17, '1314', 'Akum Penyusutan - Peralatan\rKantor', 'Fixed Asset', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(18, '2111', 'Hutang Usaha', 'Account Payable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(19, '2-112-001', 'Hutang Kepada Pemegang Saham', 'Account Payable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(20, '2113', 'Biaya Yg Masih Harus Dibayar', 'Account Payable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(21, '2114', 'Hutang Atas Pembayaran Oleh\rKaryawan', 'Account Payable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(22, '2115', 'Hutang Ke Percetakan', 'Account Payable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(23, '2116', 'Pendapatan Diterima Dimuka', 'Account Payable', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(24, '310001', 'OPENING BALANCE EQUITY', 'Equity', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(25, '3111', 'Modal', 'Equity', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(26, '3511', 'Prive', 'Equity', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(27, '3999', 'Laba Ditahan', 'Equity', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(28, '410103', 'Sales Term Discount', 'Revenue', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(29, '4111', 'Pendapatan Cetak', 'Revenue', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(30, '4112', 'Pendapatan Disan', 'Revenue', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(31, '4113', 'Pendapatan Photography', 'Revenue', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(32, '5,111,001', 'Biaya Photocopy', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(33, '5,111,002', 'Biaya Cetak', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(34, '5,111,003', 'Biaya Kertas', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(35, '5,111,004', 'Biaya Tinta Printer', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(36, '5,111,005', 'Biaya Jilid', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(37, '5,111,006', 'Biaya Mock Up', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(38, '5,111,101', 'Biaya ATK', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(39, '5,111,102', 'Biaya Materai', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(40, '5,111,103', 'Biaya Peralatan Kantor', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(41, '5,111,201', 'Biaya Gaji Honorer', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(42, '5,111,301', 'Biaya Bensin', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(43, '5,111,302', 'Biaya Angkutan Umum', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(44, '5,111,303', 'Biaya Tol/Parkir', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(45, '5,111,304', 'Biaya Entertainment', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(46, '5,112,001', 'Biaya Photocopy', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(47, '5,112,002', 'Biaya Cetak', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(48, '5,112,003', 'Biaya Kertas', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(49, '5,112,004', 'Biaya Tinta Printer', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(50, '5,112,005', 'Biaya Jilid', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(51, '5,112,006', 'Biaya Mock Up', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(52, '5,112,101', 'Biaya ATK', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(53, '5,112,102', 'Biaya Materai', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(54, '5,112,103', 'Biaya Peralatan Kantor', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(55, '5,112,201', 'Biaya Gaji Honorer', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(56, '5,112,301', 'Biaya Bensin', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(57, '5,112,302', 'Biaya Angkutan Umum', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(58, '5,112,303', 'Biaya Tol/Parkir', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(59, '5,113,001', 'Biaya Photocopy', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(60, '5,113,002', 'Biaya Cetak', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(61, '5,113,003', 'Biaya Kertas', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(62, '5,113,004', 'Biaya Tinta Printer', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(63, '5,113,005', 'Biaya Jilid', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(64, '5,113,006', 'Biaya Mock Up', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(65, '5,113,101', 'Biaya ATK', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(66, '5,113,102', 'Biaya Materai', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(67, '5,113,103', 'Biaya Peralatan Kantor', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(68, '5,113,201', 'Biaya Gaji Honorer - Fotografer', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(69, '5,113,301', 'Biaya Bensin', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(70, '5,113,302', 'Biaya Angkutan Umum', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(71, '5,113,303', 'Biaya Tol/Parkir', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(72, '5211', 'Discount Percetakan', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(73, '5212', 'Discount Disain', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(74, '5213', 'Discount Photography', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(75, '5311', 'Fee Agency', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(76, '5998', 'Biaya Entertainment', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(77, '5999', 'Biaya Lain-lain', 'Cost of Goods Sold', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(78, '6,111,010', 'Biaya Gaji Pegawai Tetap', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(79, '6,111,011', 'Biaya Lembur', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(80, '6,111,050', 'Biaya Pegawai Honorer', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(81, '6,111,060', 'Biaya Bonus', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(82, '6,111,070', 'Biaya THR', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(83, '6,112,001', 'Biaya Jasa Akuntansi', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(84, '6,112,002', 'Biaya Notaris', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(85, '6211', 'Biaya PLN', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(86, '6,212,001', 'Biaya Telpon', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(87, '6,212,002', 'Biaya Fax', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(88, '6,212,003', 'Biaya Voucher HP', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(89, '6213', 'Biaya KABELVISION', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(90, '6,311,001', 'Biaya ATK', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(91, '6,311,002', 'Biaya Materai', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(92, '6,311,003', 'Biaya Peralatan Kantor', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(93, '6,312,001', 'Biaya Photocopy', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(94, '6,312,002', 'Biaya Cetak', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(95, '6,312,003', 'Biaya Kertas', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(96, '6,312,004', 'Biaya Tinta Printer', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(97, '6,312,005', 'Biaya CD Kosong', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(98, '6,312,006', 'Biaya Cetak/Repro Foto', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(99, '6,312,007', 'Biaya Jilid', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(100, '6,313,001', 'Biaya Bensin', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(101, '6,313,002', 'Biaya Parkir/Tol', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(102, '6,313,003', 'Biaya Angkutan Umum', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(103, '6,314,001', 'Biaya Perbaikan Komputer', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(104, '6,314,002', 'Biaya Pemeliharaan/Perbaikan AC', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(105, '6,314,003', 'Biaya Perbaikan Ruang Kantor', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(106, '6,315,001', 'Biaya Alat Internet', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(107, '6,315,002', 'Biaya Alat Komputer Lainnya', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(108, '6316', 'Biaya Konsumsi Dapur', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(109, '6317', 'Biaya Entertainment', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(110, '6318', 'Biaya Kebersihan & Keamanan\rLingkungan', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(111, '6,411,001', 'Biaya Depresiasi - Komputer', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(112, '6,411,002', 'Biaya Depresiasi - Printer', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(113, '6,411,003', 'Biaya Depresiasi - Furniture Kantor', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(114, '6,411,004', 'Biaya Depresiasi - Peralatan Kantor', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(115, '6511', 'Biaya Pra Klien', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(116, '6999', 'Biaya Lain-lain', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(117, '7,111,001', 'Pendapatan Bunga Bank', 'Other Income', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(118, '8,111,001', 'Biaya Bunga Bank', 'Other Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(119, '8,111,002', 'Biaya Administrasi Bank', 'Other Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(120, '910001', 'Realize Gain or Loss', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(121, '9-100-02', 'Unrealize Gain or Loss', 'Expense', '1');
INSERT INTO `tilyan_tp_demo_lookup_account` VALUES(122, '9-111', 'Biaya Lain-lain', 'Other Expense', '1');

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_tp_demo_lookup_code1`
--

CREATE TABLE `tilyan_tp_demo_lookup_code1` (
  `ID` bigint(100) NOT NULL AUTO_INCREMENT,
  `CodeName` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CodeDesc` text COLLATE latin1_general_ci,
  `Status` enum('0','1') COLLATE latin1_general_ci DEFAULT NULL,
  `ContractNo` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `ContractValue` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=4 ;

--
-- Dumping data for table `tilyan_tp_demo_lookup_code1`
--

INSERT INTO `tilyan_tp_demo_lookup_code1` VALUES(1, 'MND', 'Project Bank Mandiri', '1', NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_lookup_code1` VALUES(2, 'CMB', 'Project Bank Niaga CIMB', '1', NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_lookup_code1` VALUES(3, 'CMN', 'Project Commonwealth Bank', '1', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tilyan_tp_demo_lookup_code2`
--

CREATE TABLE `tilyan_tp_demo_lookup_code2` (
  `ID` bigint(100) NOT NULL AUTO_INCREMENT,
  `CodeName` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `CodeDesc` text COLLATE latin1_general_ci,
  `Status` enum('0','1') COLLATE latin1_general_ci DEFAULT NULL,
  `ContractNo` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `ContractValue` varchar(255) COLLATE latin1_general_ci DEFAULT NULL,
  `StartDate` date DEFAULT NULL,
  `EndDate` date DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=7 ;

--
-- Dumping data for table `tilyan_tp_demo_lookup_code2`
--

INSERT INTO `tilyan_tp_demo_lookup_code2` VALUES(1, 'FIN', 'Finance Department', '1', NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_lookup_code2` VALUES(2, 'ACT', 'Accounting Department', '1', NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_lookup_code2` VALUES(3, 'MRK', 'Marketing Department', '1', NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_lookup_code2` VALUES(4, 'SLS', 'Sales Department', '1', NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_lookup_code2` VALUES(5, 'LOG', 'Logistic Department', '1', NULL, NULL, NULL, NULL);
INSERT INTO `tilyan_tp_demo_lookup_code2` VALUES(6, 'PCT', 'Procurement Department', '1', NULL, NULL, NULL, NULL);
