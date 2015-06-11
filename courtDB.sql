# Host: localhost  (Version: 5.6.11)
# Date: 2015-06-04 14:23:11
# Generator: MySQL-Front 5.3  (Build 4.214)

/*!40101 SET NAMES latin1 */;

#
# Structure for table "appearances"
#

DROP TABLE IF EXISTS `appearances`;
CREATE TABLE `appearances` (
  `appearid` int(11) NOT NULL AUTO_INCREMENT,
  `ap_suitno` varchar(20) NOT NULL,
  `ap_date` date NOT NULL,
  `ap_lawyer2id` varchar(50) NOT NULL,
  `ap_defendant` varchar(50) NOT NULL,
  `ap_doc1` varchar(10) NOT NULL,
  `ap_dox2` varchar(10) NOT NULL,
  `ap_doc3` varchar(10) NOT NULL,
  `ap_doc4` varchar(10) NOT NULL,
  `ap_doc5` varchar(10) NOT NULL,
  `ap_sms` int(1) DEFAULT NULL,
  PRIMARY KEY (`appearid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "appearances"
#


#
# Structure for table "clains"
#

DROP TABLE IF EXISTS `clains`;
CREATE TABLE `clains` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `cl_suitno` varchar(50) NOT NULL,
  `cl_date` date NOT NULL,
  `cl_plaitiff` varchar(50) NOT NULL,
  `cl_defendant` varchar(50) NOT NULL,
  `cl_lawyer1id` int(11) NOT NULL,
  `cl_casetitle` int(50) NOT NULL,
  `cl_doc1` int(10) DEFAULT NULL,
  `cl_doc2` int(10) DEFAULT NULL,
  `cl_doc3` int(10) DEFAULT NULL,
  `cl_doc4` int(10) DEFAULT NULL,
  `ci_doc5` int(10) DEFAULT NULL,
  `cl_sms` int(1) DEFAULT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "clains"
#


#
# Structure for table "clerk"
#

DROP TABLE IF EXISTS `clerk`;
CREATE TABLE `clerk` (
  `Id` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `Photo` float DEFAULT NULL,
  PRIMARY KEY (`Id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "clerk"
#


#
# Structure for table "client"
#

DROP TABLE IF EXISTS `client`;
CREATE TABLE `client` (
  `client_id` varchar(10) NOT NULL,
  `First_Name` varchar(45) DEFAULT NULL,
  `Surname` varchar(45) DEFAULT NULL,
  `DOB` varchar(8) DEFAULT NULL,
  `Region` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`client_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "client"
#


#
# Structure for table "courts"
#

DROP TABLE IF EXISTS `courts`;
CREATE TABLE `courts` (
  `courtid` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(50) DEFAULT NULL,
  `c_descrition` varchar(50) DEFAULT NULL,
  `c_location` varchar(50) DEFAULT NULL,
  `c_adress` varchar(50) DEFAULT NULL,
  `c_fone` varchar(20) DEFAULT NULL,
  `c_contact` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`courtid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "courts"
#


#
# Structure for table "defences"
#

DROP TABLE IF EXISTS `defences`;
CREATE TABLE `defences` (
  `defid` int(11) NOT NULL AUTO_INCREMENT,
  `d_suitno` varchar(20) NOT NULL,
  `d_date` date NOT NULL,
  `d_sodef` text NOT NULL,
  `d_lawyer2id` int(11) NOT NULL,
  `d_doc1` varchar(10) NOT NULL,
  `d_doc2` varchar(10) NOT NULL,
  `d_doc3` varchar(10) NOT NULL,
  `d_doc4` varchar(10) NOT NULL,
  `d_sms` int(11) DEFAULT NULL,
  PRIMARY KEY (`defid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "defences"
#


#
# Structure for table "judges"
#

DROP TABLE IF EXISTS `judges`;
CREATE TABLE `judges` (
  `j_code` int(11) NOT NULL AUTO_INCREMENT,
  `j_name` varchar(50) NOT NULL,
  `j_address` varchar(50) DEFAULT NULL,
  `j_rank` varchar(50) NOT NULL,
  `j_email` varchar(50) DEFAULT NULL,
  `j_fone` varchar(20) NOT NULL,
  `j_regdate` date DEFAULT NULL,
  PRIMARY KEY (`j_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "judges"
#


#
# Structure for table "lawyers"
#

DROP TABLE IF EXISTS `lawyers`;
CREATE TABLE `lawyers` (
  `lw_id` int(11) NOT NULL AUTO_INCREMENT,
  `lw_name` varchar(50) NOT NULL,
  `lw_address` varchar(50) NOT NULL,
  `lw_email` varchar(50) NOT NULL,
  `lw_fone` varchar(20) NOT NULL,
  `lw_regno` varchar(20) NOT NULL,
  `lw_regdate` date NOT NULL,
  `lw_subdate` date DEFAULT NULL,
  `lw_subexpire` date DEFAULT NULL,
  `lw_photo` varchar(10) NOT NULL,
  PRIMARY KEY (`lw_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "lawyers"
#


#
# Structure for table "registrar"
#

DROP TABLE IF EXISTS `registrar`;
CREATE TABLE `registrar` (
  `r_code` int(11) NOT NULL AUTO_INCREMENT,
  `r_courtid` int(11) NOT NULL,
  `r_name` varchar(50) NOT NULL,
  `r_email` varchar(50) DEFAULT NULL,
  `r_fone` varchar(20) NOT NULL,
  `r_photo` varchar(50) DEFAULT NULL,
  `r_address` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`r_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "registrar"
#


#
# Structure for table "sittings"
#

DROP TABLE IF EXISTS `sittings`;
CREATE TABLE `sittings` (
  `sittingid` int(11) NOT NULL AUTO_INCREMENT,
  `s_suitno` varchar(20) NOT NULL,
  `s_sms` int(1) DEFAULT NULL,
  `s_date&time` date NOT NULL,
  `s_courtid` int(11) NOT NULL,
  `s_judgeid` int(11) NOT NULL,
  `s_lawyer1id` int(11) NOT NULL,
  `s_lawyer2id` int(11) NOT NULL,
  `s_case` text NOT NULL,
  `s_outcome` text,
  `s_nextdate&time` date NOT NULL,
  `s_doc1` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`sittingid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

#
# Data for table "sittings"
#


#
# Procedure "in_judge"
#

DROP PROCEDURE IF EXISTS `in_judge`;
CREATE PROCEDURE `in_judge`(in jname varchar(30), in jaddress varchar(30), in_jregdate date)
BEGIN
insert into judges (j_name, j_address, j_regdate) values (jname, jaddress, jreddate);
END;
