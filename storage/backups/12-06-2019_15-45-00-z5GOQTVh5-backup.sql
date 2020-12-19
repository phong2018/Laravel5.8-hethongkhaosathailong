-- mysqldump-php https://github.com/ifsnop/mysqldump-php
--
-- Host: localhost	Database: 201906hoso1cua
-- ------------------------------------------------------
-- Server version 	5.6.37
-- Date: Wed, 12 Jun 2019 15:45:00 +0700

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `assign`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assign` (
  `ID_Assign` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Employee` int(11) NOT NULL,
  `ID_Procedure` int(11) NOT NULL,
  `duration` int(11) NOT NULL DEFAULT '0',
  `active` int(11) NOT NULL,
  `assign_6` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assign_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assign_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assign_9` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `assign_10` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Assign`),
  KEY `ID_Employee` (`ID_Employee`),
  KEY `ID_Procedure` (`ID_Procedure`),
  CONSTRAINT `Assign_ibfk_2` FOREIGN KEY (`ID_Procedure`) REFERENCES `procedure` (`ID_Procedure`),
  CONSTRAINT `assign_ibfk_1` FOREIGN KEY (`ID_Employee`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=221 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assign`
--

LOCK TABLES `assign` WRITE;
/*!40000 ALTER TABLE `assign` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `assign` VALUES (18,13,26,0,1,NULL,NULL,NULL,NULL,NULL),(41,2,2,0,1,NULL,NULL,NULL,NULL,NULL),(42,3,2,0,1,NULL,NULL,NULL,NULL,NULL),(43,4,2,0,1,NULL,NULL,NULL,NULL,NULL),(44,5,2,0,1,NULL,NULL,NULL,NULL,NULL),(45,6,2,0,1,NULL,NULL,NULL,NULL,NULL),(46,7,2,0,1,NULL,NULL,NULL,NULL,NULL),(47,8,2,0,1,NULL,NULL,NULL,NULL,NULL),(48,13,2,0,1,NULL,NULL,NULL,NULL,NULL),(49,14,2,0,1,NULL,NULL,NULL,NULL,NULL),(50,15,2,0,1,NULL,NULL,NULL,NULL,NULL),(51,2,5,0,1,NULL,NULL,NULL,NULL,NULL),(52,3,5,0,1,NULL,NULL,NULL,NULL,NULL),(53,4,5,0,1,NULL,NULL,NULL,NULL,NULL),(54,5,5,0,1,NULL,NULL,NULL,NULL,NULL),(55,6,5,0,1,NULL,NULL,NULL,NULL,NULL),(56,7,5,0,1,NULL,NULL,NULL,NULL,NULL),(57,8,5,0,1,NULL,NULL,NULL,NULL,NULL),(58,13,5,0,1,NULL,NULL,NULL,NULL,NULL),(59,14,5,0,1,NULL,NULL,NULL,NULL,NULL),(60,15,5,0,1,NULL,NULL,NULL,NULL,NULL),(61,2,14,0,1,NULL,NULL,NULL,NULL,NULL),(62,3,14,0,1,NULL,NULL,NULL,NULL,NULL),(63,4,14,0,1,NULL,NULL,NULL,NULL,NULL),(64,5,14,0,1,NULL,NULL,NULL,NULL,NULL),(65,6,14,0,1,NULL,NULL,NULL,NULL,NULL),(66,7,14,0,1,NULL,NULL,NULL,NULL,NULL),(67,8,14,0,1,NULL,NULL,NULL,NULL,NULL),(68,13,14,0,1,NULL,NULL,NULL,NULL,NULL),(69,14,14,0,1,NULL,NULL,NULL,NULL,NULL),(70,15,14,0,1,NULL,NULL,NULL,NULL,NULL),(71,2,15,0,1,NULL,NULL,NULL,NULL,NULL),(72,3,15,0,1,NULL,NULL,NULL,NULL,NULL),(73,4,15,0,1,NULL,NULL,NULL,NULL,NULL),(74,5,15,0,1,NULL,NULL,NULL,NULL,NULL),(75,6,15,0,1,NULL,NULL,NULL,NULL,NULL),(76,7,15,0,1,NULL,NULL,NULL,NULL,NULL),(77,8,15,0,1,NULL,NULL,NULL,NULL,NULL),(78,13,15,0,1,NULL,NULL,NULL,NULL,NULL),(79,14,15,0,1,NULL,NULL,NULL,NULL,NULL),(80,15,15,0,1,NULL,NULL,NULL,NULL,NULL),(81,2,17,0,1,NULL,NULL,NULL,NULL,NULL),(82,3,17,0,1,NULL,NULL,NULL,NULL,NULL),(83,4,17,0,1,NULL,NULL,NULL,NULL,NULL),(84,5,17,0,1,NULL,NULL,NULL,NULL,NULL),(85,6,17,0,1,NULL,NULL,NULL,NULL,NULL),(86,7,17,0,1,NULL,NULL,NULL,NULL,NULL),(87,8,17,0,1,NULL,NULL,NULL,NULL,NULL),(88,13,17,0,1,NULL,NULL,NULL,NULL,NULL),(89,14,17,0,1,NULL,NULL,NULL,NULL,NULL),(90,15,17,0,1,NULL,NULL,NULL,NULL,NULL),(91,2,19,0,1,NULL,NULL,NULL,NULL,NULL),(92,3,19,0,1,NULL,NULL,NULL,NULL,NULL),(93,4,19,0,1,NULL,NULL,NULL,NULL,NULL),(94,5,19,0,1,NULL,NULL,NULL,NULL,NULL),(95,6,19,0,1,NULL,NULL,NULL,NULL,NULL),(96,7,19,0,1,NULL,NULL,NULL,NULL,NULL),(97,8,19,0,1,NULL,NULL,NULL,NULL,NULL),(98,13,19,0,1,NULL,NULL,NULL,NULL,NULL),(99,14,19,0,1,NULL,NULL,NULL,NULL,NULL),(100,15,19,0,1,NULL,NULL,NULL,NULL,NULL),(101,2,20,0,1,NULL,NULL,NULL,NULL,NULL),(102,3,20,0,1,NULL,NULL,NULL,NULL,NULL),(103,4,20,0,1,NULL,NULL,NULL,NULL,NULL),(104,5,20,0,1,NULL,NULL,NULL,NULL,NULL),(105,6,20,0,1,NULL,NULL,NULL,NULL,NULL),(106,7,20,0,1,NULL,NULL,NULL,NULL,NULL),(107,8,20,0,1,NULL,NULL,NULL,NULL,NULL),(108,13,20,0,1,NULL,NULL,NULL,NULL,NULL),(109,14,20,0,1,NULL,NULL,NULL,NULL,NULL),(110,15,20,0,1,NULL,NULL,NULL,NULL,NULL),(111,2,21,0,1,NULL,NULL,NULL,NULL,NULL),(112,3,21,0,1,NULL,NULL,NULL,NULL,NULL),(113,4,21,0,1,NULL,NULL,NULL,NULL,NULL),(114,5,21,0,1,NULL,NULL,NULL,NULL,NULL),(115,6,21,0,1,NULL,NULL,NULL,NULL,NULL),(116,7,21,0,1,NULL,NULL,NULL,NULL,NULL),(117,8,21,0,1,NULL,NULL,NULL,NULL,NULL),(118,13,21,0,1,NULL,NULL,NULL,NULL,NULL),(119,14,21,0,1,NULL,NULL,NULL,NULL,NULL),(120,15,21,0,1,NULL,NULL,NULL,NULL,NULL),(168,2,32,0,1,NULL,NULL,NULL,NULL,NULL),(169,3,32,0,1,NULL,NULL,NULL,NULL,NULL),(170,4,32,0,1,NULL,NULL,NULL,NULL,NULL),(171,15,32,0,1,NULL,NULL,NULL,NULL,NULL),(172,16,32,0,1,NULL,NULL,NULL,NULL,NULL),(173,17,32,0,1,NULL,NULL,NULL,NULL,NULL),(174,2,22,0,1,NULL,NULL,NULL,NULL,NULL),(175,3,22,0,1,NULL,NULL,NULL,NULL,NULL),(176,4,22,0,1,NULL,NULL,NULL,NULL,NULL),(177,5,22,0,1,NULL,NULL,NULL,NULL,NULL),(178,6,22,0,1,NULL,NULL,NULL,NULL,NULL),(179,7,22,0,1,NULL,NULL,NULL,NULL,NULL),(180,8,22,0,1,NULL,NULL,NULL,NULL,NULL),(181,13,22,0,1,NULL,NULL,NULL,NULL,NULL),(182,14,22,0,1,NULL,NULL,NULL,NULL,NULL),(183,15,22,0,1,NULL,NULL,NULL,NULL,NULL),(194,4,33,0,1,NULL,NULL,NULL,NULL,NULL),(195,15,33,0,1,NULL,NULL,NULL,NULL,NULL),(196,18,33,0,1,NULL,NULL,NULL,NULL,NULL),(204,3,34,0,1,NULL,NULL,NULL,NULL,NULL),(205,5,34,0,1,NULL,NULL,NULL,NULL,NULL),(206,15,34,0,1,NULL,NULL,NULL,NULL,NULL),(207,18,34,0,1,NULL,NULL,NULL,NULL,NULL),(208,2,1,0,1,NULL,NULL,NULL,NULL,NULL),(209,3,1,0,1,NULL,NULL,NULL,NULL,NULL),(210,4,1,0,1,NULL,NULL,NULL,NULL,NULL),(211,5,1,0,1,NULL,NULL,NULL,NULL,NULL),(212,6,1,0,1,NULL,NULL,NULL,NULL,NULL),(213,7,1,0,1,NULL,NULL,NULL,NULL,NULL),(214,8,1,0,1,NULL,NULL,NULL,NULL,NULL),(215,13,1,0,1,NULL,NULL,NULL,NULL,NULL),(216,14,1,0,1,NULL,NULL,NULL,NULL,NULL),(217,15,1,0,1,NULL,NULL,NULL,NULL,NULL),(218,18,1,0,1,NULL,NULL,NULL,NULL,NULL),(219,2,35,0,1,NULL,NULL,NULL,NULL,NULL),(220,3,35,0,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `assign` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `assign` with 117 row(s)
--

--

-- Dumped table `backup` with 2 row(s)
--

--
-- Table structure for table `dossier`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dossier` (
  `ID_Dossier` int(11) NOT NULL AUTO_INCREMENT,
  `Ma_Hoso` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dossier_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `dossier_owner` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `owner_address` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `owner_email` varchar(110) COLLATE utf8_unicode_ci DEFAULT NULL,
  `owner_phone` int(10) DEFAULT NULL,
  `owner_zalo_id` int(15) DEFAULT NULL,
  `time_received` datetime NOT NULL,
  `time_return` datetime NOT NULL,
  `ID_Procedure` int(11) NOT NULL,
  `id_sector` int(11) NOT NULL DEFAULT '0',
  `id_create` int(11) NOT NULL DEFAULT '0',
  `id_stepcurrent` int(11) DEFAULT '0',
  `is_actived` int(11) NOT NULL DEFAULT '1',
  `history_file` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_11` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_12` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_13` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_14` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_15` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_16` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_17` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_18` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_19` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `dossier_20` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Dossier`),
  UNIQUE KEY `Ma_Hoso` (`Ma_Hoso`),
  KEY `ID_Procedure` (`ID_Procedure`),
  KEY `id_stepcurrent` (`id_stepcurrent`),
  CONSTRAINT `Dossier_ibfk_1` FOREIGN KEY (`ID_Procedure`) REFERENCES `procedure` (`ID_Procedure`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dossier`
--

LOCK TABLES `dossier` WRITE;
/*!40000 ALTER TABLE `dossier` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dossier` VALUES (122,'1559307952001','Đăng ký khai sinh thông thường','Lê Giang Phong','thạnh phú','phong2018@gmail.com',971793662,1231313,'2019-05-31 00:00:00','2019-06-05 00:00:00',1,1,5,6,1,'storage/history/2019/5/31/1559307952001-Dossier-sTmgLFV3h.txt',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(123,'1559358742123','Cấp sửa đổi, bổ sung Giấy xác nhận đăng ký sản xuất rượu thủ công đẻ bán cho doanh nghiệp có giấy phép sản xuất rượu để chế biến lại','phong111','dia chi1','email1@gmail.com',99999,22222,'2019-06-01 00:00:00','2019-06-11 00:00:00',32,19,15,6,1,'storage/history/2019/6/1/1559358742123-Dossier-xOCnwckxS.txt',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(124,'1559440923124','Giải quyết tố cáo','phong2-6-1','dia chi- phong2-6-1','phong2018@gmail.com',99999,11111,'2019-06-02 00:00:00','2019-06-07 00:00:00',22,6,5,1,1,'storage/history/2019/6/2/1559440923124-Dossier-Ui5P3RIHp.txt',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(125,'1560074763125','Đăng ký khai sinh thông thường cho con tui','Nguyễn Văn Tèo','111 đường không tên P11 Q19','teo@gmail.com',123456789,123456789,'2019-06-09 00:00:00','2019-06-13 00:00:00',1,1,18,4,1,'storage/history/2019/6/9/1560074763125-Dossier-kdae3LtEu.txt',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(126,'1560213654126','Đăng ký kết hôn lần đầu cho ông Tèo','Nguyễn Văn Tèo','12 đường 17, phường 18, Quận 19','teo@gmail.com',23,1,'2019-06-11 00:00:00','2019-06-13 00:00:00',34,1,18,3,1,'storage/history/2019/6/11/1560213654126-Dossier-4XdXNdmc0.txt',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(127,'1560266351127','Đăng ký khai sinh thông thường','phong1','dia chi1','phong2018@gmail.com',1111,111111,'2019-06-11 00:00:00','2019-06-16 00:00:00',1,1,5,2,1,'storage/history/2019/6/11/1560266351127-Dossier-sJCKfDsCu.txt',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dossier` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dossier` with 6 row(s)
--

--
-- Table structure for table `dossier_process`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dossier_process` (
  `ID_Process` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Dossier` int(11) NOT NULL,
  `ID_Step` int(11) NOT NULL,
  `ID_Assign` int(11) NOT NULL,
  `ID_thongbao` int(11) NOT NULL,
  `id_create` int(11) NOT NULL DEFAULT '0',
  `process_note` text COLLATE utf8_unicode_ci,
  `time_received` datetime NOT NULL,
  `time_return` datetime NOT NULL,
  `time_create` datetime NOT NULL,
  `process_description` text COLLATE utf8_unicode_ci,
  `process_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `process_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `process_9` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `process_10` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `process_11` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Process`),
  KEY `ID_Dossier` (`ID_Dossier`),
  KEY `ID_Assign` (`ID_Assign`),
  KEY `ID_thongbao` (`ID_thongbao`),
  KEY `ID_Step` (`ID_Step`),
  KEY `id_create` (`id_create`),
  CONSTRAINT `Dossier_Process_ibfk_1` FOREIGN KEY (`ID_Dossier`) REFERENCES `dossier` (`ID_Dossier`),
  CONSTRAINT `Dossier_Process_ibfk_2` FOREIGN KEY (`ID_Assign`) REFERENCES `users` (`id`),
  CONSTRAINT `Dossier_Process_ibfk_3` FOREIGN KEY (`ID_Step`) REFERENCES `list_step` (`ID_Step`),
  CONSTRAINT `Dossier_Process_ibfk_4` FOREIGN KEY (`id_create`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=237 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dossier_process`
--

LOCK TABLES `dossier_process` WRITE;
/*!40000 ALTER TABLE `dossier_process` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `dossier_process` VALUES (210,122,1,5,0,5,NULL,'2019-05-31 20:05:52','2019-05-31 20:05:52','2019-05-31 20:05:52',NULL,NULL,NULL,NULL,NULL,NULL),(211,123,1,16,0,16,NULL,'2019-06-01 10:12:22','2019-06-01 10:12:22','2019-06-01 10:12:22',NULL,NULL,NULL,NULL,NULL,NULL),(212,123,2,17,0,17,NULL,'2019-06-01 10:15:51','2019-06-01 10:15:51','2019-06-01 10:15:51',NULL,NULL,NULL,NULL,NULL,NULL),(213,123,3,3,0,17,'us2 duyệt','2019-06-01 10:16:57','2019-06-01 10:16:57','2019-06-01 10:16:57',NULL,NULL,NULL,NULL,NULL,NULL),(214,123,4,16,0,16,NULL,'2019-06-01 10:17:38','2019-06-01 10:17:38','2019-06-01 10:17:38',NULL,NULL,NULL,NULL,NULL,NULL),(215,123,6,16,0,16,NULL,'2019-06-01 10:18:15','2019-06-01 10:18:15','2019-06-01 10:18:15',NULL,NULL,NULL,NULL,NULL,NULL),(216,124,1,5,0,5,NULL,'2019-06-02 09:02:03','2019-06-02 09:02:03','2019-06-02 09:02:03',NULL,NULL,NULL,NULL,NULL,NULL),(217,122,6,5,0,5,NULL,'2019-06-03 21:09:40','2019-06-03 21:09:40','2019-06-03 21:09:40',NULL,NULL,NULL,NULL,NULL,NULL),(218,125,1,6,0,18,NULL,'2019-06-09 17:06:03','2019-06-09 17:06:03','2019-06-09 17:06:03',NULL,NULL,NULL,NULL,NULL,NULL),(219,126,1,18,5,18,'Chưa có ghi chú nào 123','2019-06-11 07:40:54','2019-06-11 07:40:54','2019-06-11 07:40:54',NULL,NULL,NULL,NULL,NULL,NULL),(220,125,3,2,0,6,'Chưa cần ghi chú nào','2019-06-11 07:48:26','2019-06-11 07:48:26','2019-06-11 07:48:26',NULL,NULL,NULL,NULL,NULL,NULL),(221,126,2,5,0,5,'Hồ sơ OK','2019-06-11 07:50:04','2019-06-11 07:50:04','2019-06-11 07:50:04',NULL,NULL,NULL,NULL,NULL,NULL),(222,125,4,6,0,2,'Ký rồi','2019-06-11 07:56:09','2019-06-11 07:56:09','2019-06-11 07:56:09',NULL,NULL,NULL,NULL,NULL,NULL),(223,126,1,5,0,5,NULL,'2019-06-11 22:09:55','2019-06-11 22:09:55','2019-06-11 22:09:55',NULL,NULL,NULL,NULL,NULL,NULL),(224,126,1,5,0,5,NULL,'2019-06-11 22:12:03','2019-06-11 22:12:03','2019-06-11 22:12:03',NULL,NULL,NULL,NULL,NULL,NULL),(225,126,1,5,0,5,NULL,'2019-06-11 22:13:22','2019-06-11 22:13:22','2019-06-11 22:13:22',NULL,NULL,NULL,NULL,NULL,NULL),(226,126,1,5,0,5,NULL,'2019-06-11 22:14:10','2019-06-11 22:14:10','2019-06-11 22:14:10',NULL,NULL,NULL,NULL,NULL,NULL),(227,126,1,5,0,5,NULL,'2019-06-11 22:15:16','2019-06-11 22:15:16','2019-06-11 22:15:16',NULL,NULL,NULL,NULL,NULL,NULL),(228,126,2,5,0,5,NULL,'2019-06-11 22:16:15','2019-06-11 22:16:15','2019-06-11 22:16:15',NULL,NULL,NULL,NULL,NULL,NULL),(229,126,2,5,0,5,NULL,'2019-06-11 22:17:28','2019-06-11 22:17:28','2019-06-11 22:17:28',NULL,NULL,NULL,NULL,NULL,NULL),(230,126,3,5,0,5,NULL,'2019-06-11 22:18:36','2019-06-11 22:18:36','2019-06-11 22:18:36',NULL,NULL,NULL,NULL,NULL,NULL),(231,127,1,5,0,5,'111','2019-06-11 22:19:11','2019-06-11 22:19:11','2019-06-11 22:19:11',NULL,NULL,NULL,NULL,NULL,NULL),(232,127,2,5,0,5,NULL,'2019-06-11 22:19:37','2019-06-11 22:19:37','2019-06-11 22:19:37',NULL,NULL,NULL,NULL,NULL,NULL),(233,127,6,5,0,5,NULL,'2019-06-11 22:28:39','2019-06-11 22:28:39','2019-06-11 22:28:39',NULL,NULL,NULL,NULL,NULL,NULL),(234,127,4,5,0,5,NULL,'2019-06-11 22:29:51','2019-06-11 22:29:51','2019-06-11 22:29:51',NULL,NULL,NULL,NULL,NULL,NULL),(235,127,9,5,0,5,NULL,'2019-06-11 22:31:33','2019-06-11 22:31:33','2019-06-11 22:31:33',NULL,NULL,NULL,NULL,NULL,NULL),(236,127,2,5,0,5,NULL,'2019-06-11 22:32:21','2019-06-11 22:32:21','2019-06-11 22:32:21',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `dossier_process` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `dossier_process` with 27 row(s)
--

--
-- Table structure for table `history`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `history` (
  `id_history` int(11) NOT NULL AUTO_INCREMENT,
  `tabletd` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_tabletd` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `content` text COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_history`)
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `history`
--

LOCK TABLES `history` WRITE;
/*!40000 ALTER TABLE `history` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `history` VALUES (58,'dossier_process',161,15,'giám sát 1 TẠO quy trình. Mã quy trình=161. Quy trình: Nhận Hồ Sơ; user4 (1cua-tư pháp); ; Gửi mail: 1; Gửi sms: 1; ','2019-05-29 09:06:40','2019-05-29 09:06:40'),(59,'dossier',100,15,'giám sát 1 TẠO hồ sơ có Mã hồ sơ=1559096054100. Hồ sơ: Đăng ký khai sinh thông thường; phong1; dia chi1; ; ; ; 2019-05-29; 2019-05-29; ','2019-05-29 09:14:14','2019-05-29 09:14:14'),(60,'dossier_process',162,15,'giám sát 1 TẠO quy trình. Mã quy trình=162. Quy trình: Nhận Hồ Sơ; user4 (1cua-tư pháp); ; Gửi mail: 1; Gửi sms: 1; ','2019-05-29 09:14:14','2019-05-29 09:14:14'),(61,'dossier',101,15,'giám sát 1 TẠO hồ sơ có Mã hồ sơ=1559096441101. Hồ sơ: Đăng ký khai sinh thông thường; phong1; dia chi1; ; ; ; 2019-05-29; 2019-05-29; ','2019-05-29 09:20:41','2019-05-29 09:20:41'),(62,'dossier_process',163,15,'giám sát 1 TẠO quy trình. Mã quy trình=163. Quy trình: Nhận Hồ Sơ; user4 (1cua-tư pháp); ; Gửi mail: 1; Gửi sms: 1; ','2019-05-29 09:20:41','2019-05-29 09:20:41'),(63,'dossier',102,5,'user4 (1cua-tư pháp) TẠO hồ sơ có Mã hồ sơ=1559102811102. Hồ sơ: Đăng ký khai sinh quá hạn; phong1; dia chi1; phong2018@gmail.com; 099999; 099999; 2019-05-29; 2019-05-29; ','2019-05-29 11:06:51','2019-05-29 11:06:51'),(64,'dossier_process',166,5,'user4 (1cua-tư pháp) TẠO quy trình. Mã quy trình=166. Quy trình: Nhận Hồ Sơ; user4 (1cua-tư pháp); ; Gửi mail: 1; Gửi sms: ; ','2019-05-29 11:06:51','2019-05-29 11:06:51'),(65,'dossier',103,5,'user4 (1cua-tư pháp) TẠO hồ sơ có Mã hồ sơ=1559114162103. Hồ sơ: Đăng ký khai sinh cho trẻ em bị bỏ rơi; Lê Giang Phong; tổ 8, ấp 5 thạnh phú, vĩnh cửu, đồng nai; phong2018@gmail.com; 0971793662; 097793662; 2019-05-29; 2019-05-31; ','2019-05-29 14:16:02','2019-05-29 14:16:02'),(66,'dossier_process',172,5,'user4 (1cua-tư pháp) TẠO quy trình. Mã quy trình=172. Quy trình: Nhận Hồ Sơ; user4 (1cua-tư pháp); ; Gửi mail: 1; Gửi sms: 1; ','2019-05-29 14:16:02','2019-05-29 14:16:02'),(67,'dossier',104,5,'user4 (1cua-tư pháp) TẠO hồ sơ có Mã hồ sơ=1559114760001. Hồ sơ: Đăng ký khai sinh cho con ngoài giá thú có người nhận là cha; Lê Giang Phong1; Đồng Nai; phong2018@gmail.com; 0971793662; 099999; 2019-05-29; 2019-05-31; ','2019-05-29 14:26:00','2019-05-29 14:26:00'),(68,'dossier_process',174,5,'user4 (1cua-tư pháp) TẠO quy trình. Mã quy trình=174. Quy trình: Nhận Hồ Sơ; user4 (1cua-tư pháp); ; Gửi mail: 1; Gửi sms: 1; ','2019-05-29 14:26:00','2019-05-29 14:26:00'),(69,'dossier',104,15,'giám sát 1 XÓA hồ sơ có Mã hồ sơ=1559114760001','2019-05-29 14:40:36','2019-05-29 14:40:36'),(70,'dossier',105,5,'user4 (1cua-tư pháp) TẠO hồ sơ có Mã hồ sơ=1559176211105. Hồ sơ: Đăng ký khai sinh cho trẻ em bị bỏ rơi; phong1; dia chi1; phong2018@gmail.com; 099999; 1111; 2019-05-30; 2019-05-30; ','2019-05-30 07:30:11','2019-05-30 07:30:11'),(71,'dossier_process',181,5,'user4 (1cua-tư pháp) TẠO quy trình. Mã quy trình=181. Quy trình: Nhận Hồ Sơ; user4 (1cua-tư pháp); ; Gửi mail: 1; Gửi sms: ; ','2019-05-30 07:30:11','2019-05-30 07:30:11');
/*!40000 ALTER TABLE `history` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `history` with 14 row(s)
--

--
-- Table structure for table `list_step`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `list_step` (
  `ID_Step` int(11) NOT NULL AUTO_INCREMENT,
  `step_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `step_note` varchar(500) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `is_actived` int(11) NOT NULL DEFAULT '0',
  `sort_order` int(11) NOT NULL DEFAULT '0',
  `execution_time` int(11) DEFAULT '0',
  `out_ofdate` int(11) NOT NULL DEFAULT '0',
  `step_4` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `step_5` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `step_6` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `step_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `step_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Step`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `list_step`
--

LOCK TABLES `list_step` WRITE;
/*!40000 ALTER TABLE `list_step` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `list_step` VALUES (1,'Nhận Hồ Sơ','Nhân viên nhận hồ sơ (Nhân viên nhận hồ sơ và chưa chuyển cho bộ phận xử lý)',0,0,2,1,'1','1','1','1','1'),(2,'Đang Xử Lý','Đang Xử Lý (Chuyển hồ sơ các bộ phận đang xử lý)',0,0,0,1,'1','1','1','1','1'),(3,'Lãnh Đạo Duyệt','Lãnh Đạo Duyệt (Chuyển hồ sơ Lãnh đạo Ký)',0,0,0,1,'1','1','1','1','1'),(4,'Chờ trả Kết Quả','Chờ Trả Kết quả (Chuyển hồ sơ lại cho nhân viên tiếp nhận, chờ người dân đến nhận hồ sơ)',0,0,0,0,'1','1','1','1','1'),(6,'Hoàn Thành','Hoàn thành (Người dân đã nhận hồ sơ)',0,0,0,0,'1','1','1','1','1'),(9,'Trả Hồ Sơ để Bổ Sung','Hồ sơ bị lỗi, đã chuyển lại cho nhân viên tiếp nhận, chờ người dân đến để trả Hồ Sơ để Bổ Sung',0,0,0,0,'1','1','1','1','1'),(10,'Hồ sơ Lỗi','Người dân đã nhận hồ sơ bị lỗi về để bổ sung',0,0,0,0,'1','1','1','1','1'),(11,'Sửa thông tin hồ sơ','Quy trình sửa thông tin hồ sơ dành cho Giám sát',0,0,1,0,'1','1','1','1','1'),(12,'Xóa hồ sơ không hợp lệ','Xóa hồ sơ khỏi hệ thống',0,0,1,0,'1','1','1','1','1');
/*!40000 ALTER TABLE `list_step` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `list_step` with 9 row(s)
--

--
-- Table structure for table `menu`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `ID_Menu` int(11) NOT NULL AUTO_INCREMENT,
  `menu_name` varchar(110) COLLATE utf8_unicode_ci NOT NULL,
  `menu_note` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `menu_active` tinyint(1) NOT NULL,
  `menu_position` int(11) NOT NULL,
  `menu_parent` int(11) NOT NULL DEFAULT '0',
  `menu_order` int(11) NOT NULL DEFAULT '0',
  `menu_level` int(11) NOT NULL DEFAULT '1',
  `menu_route` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `menu_show` int(11) NOT NULL DEFAULT '0',
  `menu_6` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_9` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menu_10` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Menu`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `menu` VALUES (23,'Quyền Sửa Hồ Sơ','Menu link Quyền Sửa Hồ Sơ',1,1,0,250,1,'admin/dossier/{dossier}/edit; admin/dossier/{dossier};',0,'1','1','1','1','1'),(24,'Quyền Xóa Hồ Sơ','Menu Link Quyền Xóa Hồ Sơ',1,1,0,250,1,'admin/dossier/delete/{dossier};',0,'1','1','1','1','1'),(25,'Quyền thêm Hồ Sơ','Quyền Thêm Hồ Sơ',1,1,0,250,1,'admin/dossier/create;',0,'1','1','1','1','1'),(52,'Tất Cả Hồ Sơ','Menu Thư mục Tất cả hồ sơ',1,1,0,48,1,'admin/dossier;',1,'1','1','1','1','1'),(53,'Nhận Hồ Sơ','Menu Link Nhận Hồ Sơ',1,1,61,50,2,'admin/dossier/dossierstep/1;',1,'1','1','1','1','1'),(54,'Hồ Sơ Đang Xử Lý','Menu Link Hồ Sơ Đang Xử Lý',1,1,61,51,2,'admin/dossier/dossierstep/2;',1,'1','1','1','1','1'),(55,'Lãnh Đạo Duyệt','Menu Link Lãnh Đạo Duyệt',1,1,61,52,2,'admin/dossier/dossierstep/3;',1,'1','1','1','1','1'),(56,'Chờ trả Kết Quả','Menu Link Chờ trả Kết Quả',1,1,61,53,2,'admin/dossier/dossierstep/4;',1,'1','1','1','1','1'),(57,'Hoàn Thành','Menu Link Hoàn Thành',1,1,61,54,2,'admin/dossier/dossierstep/6;',1,'1','1','1','1','1'),(58,'Trả Hồ Sơ để Bổ Sung','Menu Link Trả Hồ Sơ để Bổ Sung',1,1,61,55,2,'admin/dossier/dossierstep/9;',1,'1','1','1','1','1'),(59,'Hồ sơ Lỗi','Menu Link Hồ sơ Lỗi',1,1,61,56,2,'admin/dossier/dossierstep/10;',1,'1','1','1','1','1'),(61,'Xử Lý Hồ Sơ','Thư Mục Hồ Sơ',1,1,0,49,1,'',1,'1','1','1','1','1'),(63,'Quyền Xem Hồ sơ theo Từng Quy trình cụ thể','Quyền Xem Hồ sơ theo Từng Quy trình cụ thể (vd: Nhận hồ sơ, đang xử lý, lãnh đạo duyệt...)',1,1,0,250,1,'admin/dossier/dossierstep/{step};',0,'1','1','1','1','1'),(64,'Quyền Thêm Quy Trình Cho Hồ sơ','Quyền thêm quy trình cho hồ sơ',1,1,0,250,1,'admin/dossier/createprocess/{dossier}; admin/dossier/storeprocess/{dossier};',0,'1','1','1','1','1'),(65,'Hồ Sơ Quá Hạn','Menu Link  Hồ Sơ Quá Hạn',1,1,61,49,2,'admin/dossier/c/quahan;',1,'1','1','1','1','1'),(66,'Thống Kê Hồ Sơ','Thống Kê Hồ Sơ - Dành cho Lãnh đạo phường - Vai trò Giám Sát',1,1,0,50,1,'admin/dossier/c/thongke;',1,'1','1','1','1','1'),(70,'Hồ Sơ Bị Xóa','Hồ Sơ Bị Xóa do Admin quản lý',1,1,0,49,1,'admin/dossier/c/hosobixoa;',1,'1','1','1','1','1'),(72,'Thông tin tài khoản','Thông tin tài khoản',1,1,0,51,1,'admin/user/c/manageinfo;',1,'1','1','1','1','1'),(73,'Nhật ký hoạt động','Nhật ký hoạt động',1,1,0,52,1,'admin/setting/nhatky; admin/setting/nhatky/download/{dossier};',1,'1','1','1','1','1');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `menu` with 19 row(s)
--

--
-- Table structure for table `menu_role`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu_role` (
  `ID_Menurole` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Menu` int(11) NOT NULL,
  `ID_Role` int(11) NOT NULL,
  `menurole_actived` tinyint(1) NOT NULL,
  `menurole_4` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menurole_5` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menurole_6` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menurole_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `menurole_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Menurole`),
  KEY `ID_Menu` (`ID_Menu`),
  KEY `ID_Role` (`ID_Role`),
  CONSTRAINT `Menu_Role_ibfk_1` FOREIGN KEY (`ID_Menu`) REFERENCES `menu` (`ID_Menu`),
  CONSTRAINT `Menu_Role_ibfk_2` FOREIGN KEY (`ID_Role`) REFERENCES `role` (`ID_Role`)
) ENGINE=InnoDB AUTO_INCREMENT=873 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu_role`
--

LOCK TABLES `menu_role` WRITE;
/*!40000 ALTER TABLE `menu_role` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `menu_role` VALUES (800,70,1,1,NULL,NULL,NULL,NULL,NULL),(801,73,1,1,NULL,NULL,NULL,NULL,NULL),(803,52,4,1,NULL,NULL,NULL,NULL,NULL),(804,61,4,1,NULL,NULL,NULL,NULL,NULL),(805,66,4,1,NULL,NULL,NULL,NULL,NULL),(806,72,4,1,NULL,NULL,NULL,NULL,NULL),(807,73,4,1,NULL,NULL,NULL,NULL,NULL),(808,65,4,1,NULL,NULL,NULL,NULL,NULL),(809,53,4,1,NULL,NULL,NULL,NULL,NULL),(810,54,4,1,NULL,NULL,NULL,NULL,NULL),(811,55,4,1,NULL,NULL,NULL,NULL,NULL),(812,56,4,1,NULL,NULL,NULL,NULL,NULL),(813,57,4,1,NULL,NULL,NULL,NULL,NULL),(814,58,4,1,NULL,NULL,NULL,NULL,NULL),(815,59,4,1,NULL,NULL,NULL,NULL,NULL),(818,25,4,1,NULL,NULL,NULL,NULL,NULL),(819,63,4,1,NULL,NULL,NULL,NULL,NULL),(820,64,4,1,NULL,NULL,NULL,NULL,NULL),(821,52,2,1,NULL,NULL,NULL,NULL,NULL),(822,61,2,1,NULL,NULL,NULL,NULL,NULL),(823,66,2,1,NULL,NULL,NULL,NULL,NULL),(824,72,2,1,NULL,NULL,NULL,NULL,NULL),(825,73,2,1,NULL,NULL,NULL,NULL,NULL),(826,65,2,1,NULL,NULL,NULL,NULL,NULL),(827,53,2,1,NULL,NULL,NULL,NULL,NULL),(828,54,2,1,NULL,NULL,NULL,NULL,NULL),(829,55,2,1,NULL,NULL,NULL,NULL,NULL),(830,56,2,1,NULL,NULL,NULL,NULL,NULL),(831,57,2,1,NULL,NULL,NULL,NULL,NULL),(832,58,2,1,NULL,NULL,NULL,NULL,NULL),(833,59,2,1,NULL,NULL,NULL,NULL,NULL),(836,23,2,1,NULL,NULL,NULL,NULL,NULL),(837,24,2,1,NULL,NULL,NULL,NULL,NULL),(838,25,2,1,NULL,NULL,NULL,NULL,NULL),(839,63,2,1,NULL,NULL,NULL,NULL,NULL),(857,52,3,1,NULL,NULL,NULL,NULL,NULL),(858,61,3,1,NULL,NULL,NULL,NULL,NULL),(859,72,3,1,NULL,NULL,NULL,NULL,NULL),(860,65,3,1,NULL,NULL,NULL,NULL,NULL),(861,53,3,1,NULL,NULL,NULL,NULL,NULL),(862,54,3,1,NULL,NULL,NULL,NULL,NULL),(863,55,3,1,NULL,NULL,NULL,NULL,NULL),(864,56,3,1,NULL,NULL,NULL,NULL,NULL),(865,57,3,1,NULL,NULL,NULL,NULL,NULL),(866,58,3,1,NULL,NULL,NULL,NULL,NULL),(867,59,3,1,NULL,NULL,NULL,NULL,NULL),(870,25,3,1,NULL,NULL,NULL,NULL,NULL),(871,63,3,1,NULL,NULL,NULL,NULL,NULL),(872,64,3,1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `menu_role` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `menu_role` with 49 row(s)
--

--
-- Table structure for table `position`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `position` (
  `ID_Pos` int(11) NOT NULL AUTO_INCREMENT,
  `pos_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `pos_note` int(11) NOT NULL,
  `pos_short` varchar(110) COLLATE utf8_unicode_ci NOT NULL,
  `is_actived` int(11) NOT NULL DEFAULT '0',
  `pos_4` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pos_5` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pos_6` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pos_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pos_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Pos`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `position`
--

LOCK TABLES `position` WRITE;
/*!40000 ALTER TABLE `position` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `position` VALUES (1,'Chủ Tịch Phường',1,'Chủ Tịch Phường',0,'null','null','null','null','null'),(2,'Phó Chủ Tịch Phường',1,'Phó Chủ Tịch Phường',0,'null','null','null','null','null'),(6,'Nhân Viên/ Chuyên Viên',1,'Nhân Viên/ Chuyên Viên',0,'null','null','null','null','null'),(7,'Tổ trưởng phụ trách lĩnh vực',1,'Tổ trưởng',0,'null','null','null','null','null');
/*!40000 ALTER TABLE `position` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `position` with 4 row(s)
--

--
-- Table structure for table `procedure`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `procedure` (
  `ID_Procedure` int(11) NOT NULL AUTO_INCREMENT,
  `procedure_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `ID_Sector` int(11) NOT NULL,
  `procedure_active` int(11) NOT NULL,
  `execution_time` int(11) DEFAULT '0',
  `procedure_5` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `procedure_6` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `procedure_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `procedure_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `procedure_9` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Procedure`),
  KEY `ID_Sector` (`ID_Sector`),
  CONSTRAINT `Procedure_ibfk_1` FOREIGN KEY (`ID_Sector`) REFERENCES `sector` (`ID_Sector`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `procedure`
--

LOCK TABLES `procedure` WRITE;
/*!40000 ALTER TABLE `procedure` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `procedure` VALUES (1,'Đăng ký khai sinh thông thường',1,1,5,'1','1','1','1','1'),(2,'Đăng ký khai sinh cho trẻ em bị bỏ rơi',1,1,0,'1','1','1','1','1'),(5,'Đăng ký khai sinh quá hạn',1,1,2,'1','1','1','1','1'),(14,'Đăng Ký Khai Tử',1,1,0,'1','1','1','1','1'),(15,'Đăng ký khai sinh cho con ngoài giá thú có người nhận là cha',1,1,0,'1','1','1','1','1'),(17,'Đăng ký khai sinh, khai tử cho trẻ chết sơ sinh',1,1,0,'1','1','1','1','1'),(19,'Đăng ký khai tử quá hạn',1,1,0,'1','1','1','1','1'),(20,'Đăng ký việc nhận con',1,1,0,'1','1','1','1','1'),(21,'Giải quyết khiếu nại lần đầu',6,1,0,'1','1','1','1','1'),(22,'Giải quyết tố cáo',6,1,5,'1','1','1','1','1'),(23,'Thành lập nhóm trẻ, lớp mẫu giáo độc lập tư thục',7,1,0,'1','1','1','1','1'),(24,'Sát nhập, chia tách nhóm trẻ, lớp mẫu giáo độc lập tư thục',7,1,0,'1','1','1','1','1'),(25,'Giải thể hoạt động nhóm trẻ, lớp mẫu giáo độc lập tư thục',7,1,0,'1','1','1','1','1'),(26,'Xác nhận đơn vay vốn ngân hàng chính sách xã hội cho thân nhân liệt sỹ',12,1,0,'1','1','1','1','1'),(27,'Xác nhận đơn đề nghị giải quyết chế độ người có công nuôi dưỡng liệt sỹ',1,1,0,'1','1','1','1','1'),(28,'Xác nhận đơn đề nghị giải quyết chế độ tuất cho thân nhân người có công với cách mạng',12,1,0,'1','1','1','1','1'),(29,'Xác nhận đơn đề nghị chứng nhận người có công với cách mạng',12,1,0,'1','1','1','1','1'),(30,'Hòa giải tranh chấp đất đai',14,1,0,'1','1','1','1','1'),(31,'fffff',1,1,NULL,'1','1','1','1','1'),(32,'Cấp sửa đổi, bổ sung Giấy xác nhận đăng ký sản xuất rượu thủ công đẻ bán cho doanh nghiệp có giấy phép sản xuất rượu để chế biến lại',19,1,10,'1','1','1','1','1'),(33,'Cấp số nhà cho Hộ gia đình',20,1,3,'1','1','1','1','1'),(34,'Đăng ký kết hôn lần đầu',1,1,2,'1','1','1','1','1'),(35,'sdfasdfdf',1,1,1,'1','1','1','1','1');
/*!40000 ALTER TABLE `procedure` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `procedure` with 23 row(s)
--

--
-- Table structure for table `role`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `role` (
  `ID_Role` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `role_active` int(11) NOT NULL,
  `role_4` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_5` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_6` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `role_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Role`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role`
--

LOCK TABLES `role` WRITE;
/*!40000 ALTER TABLE `role` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `role` VALUES (1,'Quản Trị',1,NULL,NULL,NULL,NULL,NULL),(2,'Giám Sát',1,NULL,NULL,NULL,NULL,NULL),(3,'Nhân Viên',1,NULL,NULL,NULL,NULL,NULL),(4,'Lãnh đạo Phường',1,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `role` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `role` with 4 row(s)
--

--
-- Table structure for table `sector`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sector` (
  `ID_Sector` int(11) NOT NULL AUTO_INCREMENT,
  `sector_name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `sector_active` int(11) NOT NULL,
  `sector_4` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sector_5` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sector_6` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sector_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sector_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Sector`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sector`
--

LOCK TABLES `sector` WRITE;
/*!40000 ALTER TABLE `sector` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `sector` VALUES (1,'TƯ PHÁP',1,'1','1','1','1','1'),(6,'THANH TRA',1,'1','1','1','1','1'),(7,'GIÁO DỤC - ĐÀO TẠO',1,'1','1','1','1','1'),(12,'LAO ĐỘNG THƯƠNG BINH & XÃ HỘI',1,'1','1','1','1','1'),(14,'ĐỊA CHÍNH - TÀI NGUYÊN MÔI TRƯỜNG',1,'1','1','1','1','1'),(15,'TÀI CHÍNH',1,'1','1','1','1','1'),(16,'VĂN HÓA - THÔNG TIN',1,'1','1','1','1','1'),(17,'NỘI VỤ',1,'1','1','1','1','1'),(19,'CÔNG THƯƠNG',1,'1','1','1','1','1'),(20,'XÂY DỰNG',1,'1','1','1','1','1');
/*!40000 ALTER TABLE `sector` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `sector` with 10 row(s)
--

--
-- Table structure for table `setting`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `setting` (
  `setting_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `key` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `value` text COLLATE utf8_unicode_ci,
  `serialized` tinyint(1) NOT NULL,
  PRIMARY KEY (`setting_id`),
  KEY `key` (`key`)
) ENGINE=InnoDB AUTO_INCREMENT=3113 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `setting`
--

LOCK TABLES `setting` WRITE;
/*!40000 ALTER TABLE `setting` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `setting` VALUES (3083,'config','config_meta_title','Quản lý hồ sơ UBND Phường Linh Trung',0),(3084,'config','config_logo','/avatars/configlogo1',0),(3085,'config','config_tencoquan','Ủy ban nhân dân Phường Linh Trung',0),(3086,'config','config_diachi','1262 Kha Vạn Cân, Phường Linh Trung, Thủ Đức, Hồ Chí Minh',0),(3087,'config','config_sodienthoai','028 3896 6594',0),(3088,'config','config_emailcoquan','linhtrung.thuduc@tphcm.gov.vn',0),(3089,'config','config_meta_description','Hồ sơ 1 cửa phục vụ quản lý công việc tại Phường',0),(3090,'config','config_dossier_limit','10',0),(3091,'config','config_bacode_symbology','qr',0),(3092,'config','config_barcode-width','100',0),(3093,'config','config_barcode-height','100',0),(3094,'config','config_barcode-padding','1',0),(3095,'config','config_temp_guiemail','10',0),(3096,'config','config_temp_guisms','11',0),(3097,'config','config_temp_biennhanhoso','12',0),(3098,'config','config_temp_chuyenhoso','13',0),(3099,'config','config_mail_protocol','smtp',0),(3100,'config','config_mail_parameter',NULL,0),(3101,'config','config_mail_smtp_hostname','smtp.gmail.com',0),(3102,'config','config_mail_smtp_username','nhakhoahoc.net@gmail.com',0),(3103,'config','config_mail_smtp_password','kzfimgzsaklzkwdb',0),(3104,'config','config_mail_smtp_port','587',0),(3105,'config','config_mail_encryption','tls',0),(3106,'config','config_mail_smtp_timeout','5',0),(3107,'config','config_sms_provider','esms.vn',0),(3108,'config','config_esmsvn_api_key','4E3E517F46E713FEC2F8AD8BE2D9D2',0),(3109,'config','config_esmsvn_secret_key','6C93319C7985AE7B2250B9042C10D6',0),(3110,'config','config_maintenance','0',0),(3111,'config','config_radiotimebackup','hourlyAt',0),(3112,'config','config_backup_time','hourlyAt,17,',0);
/*!40000 ALTER TABLE `setting` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `setting` with 30 row(s)
--

--
-- Table structure for table `task_appointed`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `task_appointed` (
  `ID_Task` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Dossier` int(11) NOT NULL,
  `ID_Staff` int(11) NOT NULL,
  `ID_Manager` int(11) DEFAULT NULL,
  `id_nguoithem` int(11) NOT NULL DEFAULT '0',
  `isAutoAppointed` tinyint(1) DEFAULT NULL,
  `viewed_notice` int(11) NOT NULL DEFAULT '0',
  `appointed_time` datetime NOT NULL,
  `task_7` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `task_8` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `task_9` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `task_10` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `task_11` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`ID_Task`),
  KEY `ID_Staff` (`ID_Staff`),
  KEY `ID_Dossier` (`ID_Dossier`),
  CONSTRAINT `Task_Appointed_ibfk_2` FOREIGN KEY (`ID_Dossier`) REFERENCES `dossier` (`ID_Dossier`),
  CONSTRAINT `task_appointed_ibfk_1` FOREIGN KEY (`ID_Staff`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=190 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `task_appointed`
--

LOCK TABLES `task_appointed` WRITE;
/*!40000 ALTER TABLE `task_appointed` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `task_appointed` VALUES (178,122,5,NULL,5,NULL,1,'2019-05-31 20:05:52',NULL,NULL,NULL,NULL,NULL),(179,123,16,NULL,16,NULL,1,'2019-06-01 10:12:22',NULL,NULL,NULL,NULL,NULL),(180,123,17,NULL,16,NULL,1,'2019-06-01 10:13:25',NULL,NULL,NULL,NULL,NULL),(181,123,15,NULL,16,NULL,0,'2019-06-01 10:14:02',NULL,NULL,NULL,NULL,NULL),(182,123,3,NULL,17,NULL,0,'2019-06-01 10:16:57',NULL,NULL,NULL,NULL,NULL),(183,124,5,NULL,5,NULL,1,'2019-06-02 09:02:03',NULL,NULL,NULL,NULL,NULL),(184,125,18,NULL,18,NULL,0,'2019-06-09 17:06:03',NULL,NULL,NULL,NULL,NULL),(185,125,6,NULL,18,NULL,0,'2019-06-09 17:06:03',NULL,NULL,NULL,NULL,NULL),(186,126,18,NULL,18,NULL,1,'2019-06-11 07:40:54',NULL,NULL,NULL,NULL,NULL),(187,126,5,NULL,18,NULL,1,'2019-06-11 07:40:54',NULL,NULL,NULL,NULL,NULL),(188,125,2,NULL,6,NULL,0,'2019-06-11 07:48:27',NULL,NULL,NULL,NULL,NULL),(189,127,5,NULL,5,NULL,1,'2019-06-11 22:19:11',NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `task_appointed` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `task_appointed` with 12 row(s)
--

--
-- Table structure for table `template`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `template` (
  `id_template` int(11) NOT NULL AUTO_INCREMENT,
  `temp_name` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temp_note` text COLLATE utf8_unicode_ci,
  `temp_path` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temp_bladeview` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `temp_order` int(11) DEFAULT '0',
  `temp_parameter` text COLLATE utf8_unicode_ci,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id_template`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `template`
--

LOCK TABLES `template` WRITE;
/*!40000 ALTER TABLE `template` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `template` VALUES (10,'Mẫu gửi Email khi nhận hồ sơ','Mẫu gửi Email nhận HS','/views/admin/temp/temp10.blade.php','admin.temp.temp10',NULL,'{{$BarCode}} {{$MaHoSo}} {{$TenHoSo}} {{$ChuHoSo}} {{$DiaChiChuHoSo}} {{$EmailChuHoSo}} {{$DienThoaiChuHoSo}} {{$ZaloChuHoSo}} {{$NgayNhanHoSo}} {{$NgayTraHoSo}} {{$TenCoQuan}} {{$DiaChiCoQuan}} {{$DienThoaiCoQuan}} {{$EmailCoQuan}} {{$MoTaCoQuan}}','2019-06-01 10:31:50','2019-06-11 22:32:08'),(11,'Mẫu gửi tin nhắn khi nhận hồ sơ','Mẫu gửi tin nhắn nhận HS','/views/admin/temp/temp11.blade.php','admin.temp.temp11',NULL,'{{$BarCode}} {{$MaHoSo}} {{$TenHoSo}} {{$ChuHoSo}} {{$DiaChiChuHoSo}} {{$EmailChuHoSo}} {{$DienThoaiChuHoSo}} {{$ZaloChuHoSo}} {{$NgayNhanHoSo}} {{$NgayTraHoSo}} {{$TenCoQuan}} {{$DiaChiCoQuan}} {{$DienThoaiCoQuan}} {{$EmailCoQuan}} {{$MoTaCoQuan}}','2019-06-01 10:32:47','2019-06-11 07:11:01'),(12,'Mẫu biên nhận hồ sơ','Mẫu biên nhận hồ sơ','/views/admin/temp/temp12.blade.php','admin.temp.temp12',NULL,'{{$BarCode}} {{$MaHoSo}} {{$TenHoSo}} {{$ChuHoSo}} {{$DiaChiChuHoSo}} {{$EmailChuHoSo}} {{$DienThoaiChuHoSo}} {{$ZaloChuHoSo}} {{$NgayNhanHoSo}} {{$NgayTraHoSo}} {{$TenCoQuan}} {{$DiaChiCoQuan}} {{$DienThoaiCoQuan}} {{$EmailCoQuan}} {{$MoTaCoQuan}}','2019-06-01 10:33:10','2019-06-09 17:13:50'),(13,'Mẫu chuyển Hồ Sơ','Mẫu chuyển Hồ Sơ','/views/admin/temp/temp13.blade.php','admin.temp.temp13',NULL,'{{$BarCode}} {{$MaHoSo}} {{$TenHoSo}} {{$ChuHoSo}} {{$DiaChiChuHoSo}} {{$EmailChuHoSo}} {{$DienThoaiChuHoSo}} {{$ZaloChuHoSo}} {{$NgayNhanHoSo}} {{$NgayTraHoSo}} {{$TenCoQuan}} {{$DiaChiCoQuan}} {{$DienThoaiCoQuan}} {{$EmailCoQuan}} {{$MoTaCoQuan}}','2019-06-01 10:33:48','2019-06-02 10:56:11');
/*!40000 ALTER TABLE `template` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `template` with 4 row(s)
--

--
-- Table structure for table `users`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ID_Staff` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `DoB` datetime NOT NULL,
  `sex` int(11) NOT NULL,
  `phone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zalo_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `avatar` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `ID_Position` int(11) NOT NULL,
  `ID_Role` int(11) NOT NULL,
  `isActived` int(11) NOT NULL DEFAULT '1',
  `user_level` int(11) NOT NULL DEFAULT '3',
  `user_15` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_16` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_17` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_18` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `user_19` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `remember_token` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `ID_Role` (`ID_Role`),
  KEY `ID_Position` (`ID_Position`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`ID_Role`) REFERENCES `role` (`ID_Role`),
  CONSTRAINT `users_ibfk_2` FOREIGN KEY (`ID_Position`) REFERENCES `position` (`ID_Pos`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
SET autocommit=0;
INSERT INTO `users` VALUES (1,'LTR-13021970','admin@gmail.com','$2y$10$mzWuyxUdsrfVyvj5a718MuN3klzV.3fkhEnD9Q0Bl2iiUan9rVpeW','Admin','1970-02-13 00:00:00',1,'0904585845','0904585845','156 Nhật Tảo, phường 8, quận 10, TPHCM','/avatars/1Chrysanthemum.jpg',6,1,1,1,'','','','','','SB7u8vKChsb7t11I5rRmkV0uJz8lIC1jPNCrHnRap2eSKaBKoxJ31M26Zgq3'),(2,'mnv1562019u1','user1@gmail.com','$2y$10$Isnrvi0WQzr6w/DY1bOSvu36IDOOzdNtI3P0wYlDAWzHwl6wAVQFC','Trần Quốc Hưng','1991-07-25 00:00:00',1,'909509109','0909239139','157 nhật tảo','/avatars/1heoquey.jpg',1,4,1,2,'','','','','',NULL),(3,'mnv156u2157','user2@gmail.com','$2y$10$M6c2qzm6GaHvWdg/ts.f5O1SI1QBW9CdwsKqHLid.t8P.ze3a1j8e','user hai-phó chủ tịch','1990-10-30 00:00:00',1,'909520170','0986532172','157 nhật nhật tảo','/avatars/3Chrysanthemum.jpg',2,4,1,2,'','','','','',NULL),(4,'mnv156u3157','user3@gmail.com','$2y$10$zWRl0LntgT9mfWixvJMQpuosCGAnyuyrpPbGDj39IIo7leqeC4aKS','user ba-phó chủ tịch','1990-08-29 00:00:00',1,'956236246','0986256254','090 nhật tảo','/storage/avatars/4TTCH3VOGCUM001 (6).JPG',2,4,1,2,'','','','','','hrebkL74sLkbwOYvvIGVHe83Cq3cw4lwHI4mMU39aJVjd2ECqkBG6drqJa6o'),(5,'mnv156u4157111','user4@gmail.com','$2y$10$b941kCAFPp8J3PIxfOVkyeaVnUh.KWARWan1f2vVbH2y5eWFCIqN.','user4 (1cua-tư pháp)','1985-06-29 00:00:00',0,'963234259','0964267257','156 nhật tảo tảo','/avatars/5heoquey.jpg',6,3,1,4,'','','','','','DNXlXOd6UfpFv5r68hNoW9IREslg3NpC7jEk8MAL0izuC6Y1FO4b1tTFJisb'),(6,'nhanvien00001','user5@gmail.com','$2y$10$qEoV9wtpLD4Jk01YqnpNOuFA.RtEA6aqf/9XbL.0W.guk9.oQiO4m','user5 (tư pháp)','1999-04-03 00:00:00',1,'9999','09999','Đồng Nai','/storage/avatars/6Koala.jpg',6,3,1,4,'','','','','','lwYByzN2rXMRy4xRhFtuI2HhChtIw0qsovnLNB8Kaf8FF9Z8C0DFTsabe1nG'),(7,'user6','user6@gmail.com','$2y$10$IK4xAGmv8b3PN8FwayoKve5w58uz/ZPKtIr6psoFJ6HpKd.VXIE42','user6 (THANH TRA)','1990-01-01 00:00:00',1,'9999','09999','197, Phạm Văn Thuận, Biên Hòa, Đồng Nai','$request->avatar',6,3,1,4,'','','','','',NULL),(8,'user4','user7@gmail.com','$2y$10$ytZRvNks/5ZxeHjVsT/qLuXpdSCoNriO6/c8zwJIkqq3VFqB81ymK','user7 (GIÁO DỤC - ĐÀO TẠO)','2014-05-02 00:00:00',1,'9999','09999','197, Phạm Văn Thuận, Biên Hòa, Đồng Nai','$request->avatar',6,3,1,4,'','','','','','uFMEglAz6ryjL6ajqoGX9XR5KCqVpzRQjNQ0xQIzKWBJeZW2bMN40OR8gcV0'),(13,'user8','user8@gmail.com','$2y$10$iOzvmGFjWCoj6lUpGoO4Bu7uktGVPUhPRRoRPMbpkJi8LYEYHaoZ.','user8 (LAO ĐỘNG THƯƠNG BINH & XÃ HỘI)','1990-01-11 00:00:00',0,'1111','1111','197, Phạm Văn Thuận, Biên Hòa, Đồng Nai','$request->avatar',6,3,1,4,'','','','','',NULL),(14,'aaa','user9@gmail.com','$2y$10$fCPZz8T8MRJHKXE3E7XVQOb6ixGHNSIGiLzHarULCaWV8zLgc46MO','user9 (LAO ĐỘNG THƯƠNG BINH & XÃ HỘI)','2019-05-09 00:00:00',1,'99','099','197, Phạm Văn Thuận, Biên Hòa, Đồng Nai','$request->avatar',6,3,1,4,'','','','','',NULL),(15,'giam sát','giamsat1@gmail.com','$2y$10$X4XpdnNVFwKJn9RJBw50hejU5oWSvvasVCqkwkyX.0ASl/iYLCk..','giám sát 1','2019-05-01 00:00:00',1,'9999','09999','197, Phạm Văn Thuận, Biên Hòa, Đồng Nai','/storage/avatars/15TTCH3VOGCUM006 (3).JPG',6,2,1,3,'','','','','',NULL),(16,'us11','us11@gmail.com','$2y$10$Tac/UTGGc.WizoTcSXUkLuV1jl9BMuXWi/CdLYqdEy25voMrdc4jy','us11-công thưuong','2019-06-08 00:00:00',1,'99999999999','890','197, Phạm Văn Thuận, Biên Hòa, Đồng Nai','/avatars/1Jellyfish.jpg',6,3,1,4,'','','','','',NULL),(17,'us12','us12@gmail','$2y$10$1Goq87eHxzWMqDRa0e62eePc7wGzQhNwNgDHloQKT7KUsuR3PzN6.','us12-xử lý công thương','2019-06-07 00:00:00',1,'67777777777777777','11144444444444444444','197, Phạm Văn Thuận, Biên Hòa, Đồng Nai','/avatars/1Tulips.jpg',6,3,1,4,'','','','','',NULL),(18,'123456','user13@gmail.com','$2y$10$xeRwrzyIqbY/MT851JNjYuiRrKrqUTu9bLjf.ODY3vL52fQz1rMRe','nhân viên 13','2003-02-01 00:00:00',0,'123456789','123456789','111 đường không tên','/avatars/18heoquey.jpg',6,3,1,4,'','','','','',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
COMMIT;

-- Dumped table `users` with 14 row(s)
--

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on: Wed, 12 Jun 2019 15:45:00 +0700
