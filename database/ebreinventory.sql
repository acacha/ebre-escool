-- MySQL dump 10.13  Distrib 5.5.35, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ebreinventory
-- ------------------------------------------------------
-- Server version	5.5.35-0ubuntu0.12.04.2

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
-- Table structure for table `barcode`
--

DROP TABLE IF EXISTS `barcode`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `barcode` (
  `barcodeId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`barcodeId`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barcode`
--

LOCK TABLES `barcode` WRITE;
/*!40000 ALTER TABLE `barcode` DISABLE KEYS */;
INSERT INTO `barcode` VALUES (1,'EAN 13','EAN',NULL,'2013-08-24 17:44:19','2013-08-24 13:46:52',13,0,'n','0000-00-00 00:00:00'),(2,'UPC (12 digit EAN)','UPC',NULL,'2013-08-24 17:45:52','2013-08-24 13:46:44',13,0,'n','0000-00-00 00:00:00'),(3,'ISBN (EAN13)','ISBN',NULL,'2013-08-24 17:47:14','2013-08-24 13:47:27',13,13,'n','0000-00-00 00:00:00'),(4,'Code 39','39',NULL,'2013-08-24 17:47:43','2013-08-24 13:47:59',13,13,'n','0000-00-00 00:00:00'),(5,'Code 128 (a,b,c:autoselect)','128',NULL,'2013-08-24 17:48:27','2013-08-24 13:48:49',13,13,'n','0000-00-00 00:00:00'),(6,'Code 128 B','128B',NULL,'2013-08-24 17:49:00','2013-08-24 13:49:08',13,13,'n','0000-00-00 00:00:00'),(7,'codibarresnou','codibarresnou',NULL,'2013-09-03 09:28:04','2013-09-03 07:30:15',1,1,'n','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `barcode` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `brand`
--

DROP TABLE IF EXISTS `brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `brand` (
  `brandId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`brandId`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `brand`
--

LOCK TABLES `brand` WRITE;
/*!40000 ALTER TABLE `brand` DISABLE KEYS */;
INSERT INTO `brand` VALUES (1,'Sense Marca','Sense Marca',NULL,'2013-09-03 07:32:35','2013-09-03 05:35:43',1,1,'n','0000-00-00 00:00:00'),(10,'a','b',NULL,'2013-09-05 17:26:43','2013-09-05 15:26:53',1,1,'n','0000-00-00 00:00:00'),(5,'Ford','Ford',NULL,'2013-09-03 07:56:53','2013-09-03 05:57:11',1,1,'n','0000-00-00 00:00:00'),(6,'Seat','Seat',NULL,'2013-09-03 07:57:57','2013-09-03 05:58:07',1,1,'n','0000-00-00 00:00:00'),(7,'Fiat','Fiat',NULL,'2013-09-03 08:02:20','2013-09-03 06:02:52',1,1,'n','0000-00-00 00:00:00'),(8,'Hiundai','Hiundai',NULL,'2013-09-03 08:07:28','2013-09-03 06:07:40',1,1,'n','0000-00-00 00:00:00'),(9,'Renault','Renault',NULL,'2013-09-03 08:08:02','2013-09-03 06:08:30',1,1,'n','0000-00-00 00:00:00'),(11,'a','b',NULL,'2013-09-05 17:26:43','2013-09-05 15:26:55',1,1,'n','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ci_sessions`
--

DROP TABLE IF EXISTS `ci_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ci_sessions`
--

LOCK TABLES `ci_sessions` WRITE;
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
INSERT INTO `ci_sessions` VALUES ('5118861763da0b41aaf06cb675056f41','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0',1392484867,'a:25:{s:9:\"user_data\";s:0:\"\";s:6:\"realms\";a:2:{i:0;s:5:\"mysql\";i:1;s:4:\"ldap\";}s:13:\"default_realm\";s:5:\"mysql\";s:16:\"institution_name\";s:21:\"EbreTIC Enginyeria SL\";s:8:\"identity\";s:8:\"sergitur\";s:8:\"username\";s:8:\"sergitur\";s:5:\"email\";s:21:\"sergi.tur@ebretic.com\";s:7:\"user_id\";s:1:\"1\";s:14:\"old_last_login\";s:19:\"2014-01-11 13:48:25\";s:4:\"role\";i:3;s:16:\"current_language\";s:7:\"catalan\";s:27:\"current_organizational_unit\";s:3:\"all\";s:39:\"inventory_object_current_fields_to_show\";a:13:{i:0;s:15:\"quantityInStock\";i:1;s:9:\"shortName\";i:2;s:8:\"publicId\";i:3;s:10:\"externalID\";i:4;s:10:\"materialId\";i:5;s:7:\"brandId\";i:6;s:7:\"modelId\";i:7;s:23:\"mainOrganizationaUnitId\";i:8;s:9:\"entryDate\";i:9;s:11:\"last_update\";i:10;s:16:\"lastupdateUserId\";i:11;s:8:\"location\";i:12;s:8:\"file_url\";}s:37:\"externalIDType_current_fields_to_show\";a:10:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"barcodeId\";i:4;s:9:\"entryDate\";i:5;s:11:\"last_update\";i:6;s:14:\"creationUserId\";i:7;s:16:\"lastupdateUserId\";i:8;s:17:\"markedForDeletion\";i:9;s:21:\"markedForDeletionDate\";}s:42:\"organizational_unit_current_fields_to_show\";a:10:{i:0;s:12:\"externalCode\";i:1;s:4:\"name\";i:2;s:9:\"shortName\";i:3;s:11:\"description\";i:4;s:9:\"entryDate\";i:5;s:11:\"last_update\";i:6;s:14:\"creationUserId\";i:7;s:16:\"lastupdateUserId\";i:8;s:17:\"markedForDeletion\";i:9;s:21:\"markedForDeletionDate\";}s:31:\"location_current_fields_to_show\";a:10:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:14:\"parentLocation\";i:8;s:17:\"markedForDeletion\";i:9;s:21:\"markedForDeletionDate\";}s:31:\"material_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:28:\"brand_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:28:\"model_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:31:\"provider_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:35:\"money_source_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:28:\"users_current_fields_to_show\";a:9:{i:0;s:8:\"username\";i:1;s:5:\"email\";i:2;s:10:\"created_on\";i:3;s:10:\"last_login\";i:4;s:6:\"active\";i:5;s:10:\"first_name\";i:6;s:9:\"last_name\";i:7;s:7:\"company\";i:8;s:5:\"phone\";}s:29:\"groups_current_fields_to_show\";a:2:{i:0;s:4:\"name\";i:1;s:11:\"description\";}s:39:\"user_preferences_current_fields_to_show\";a:4:{i:0;s:6:\"userId\";i:1;s:8:\"language\";i:2;s:5:\"theme\";i:3;s:11:\"last_update\";}s:30:\"barcode_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}}'),('a63d27b83ad97cefcef78ba6368c5eaa','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0',1392567613,'a:26:{s:9:\"user_data\";s:0:\"\";s:6:\"realms\";a:2:{i:0;s:5:\"mysql\";i:1;s:4:\"ldap\";}s:13:\"default_realm\";s:5:\"mysql\";s:16:\"institution_name\";s:21:\"EbreTIC Enginyeria SL\";s:8:\"identity\";s:8:\"sergitur\";s:8:\"username\";s:8:\"sergitur\";s:5:\"email\";s:21:\"sergi.tur@ebretic.com\";s:7:\"user_id\";s:1:\"1\";s:14:\"old_last_login\";s:19:\"2014-02-16 13:34:52\";s:4:\"role\";i:3;s:16:\"current_language\";s:7:\"catalan\";s:27:\"current_organizational_unit\";s:3:\"all\";s:39:\"inventory_object_current_fields_to_show\";a:13:{i:0;s:15:\"quantityInStock\";i:1;s:9:\"shortName\";i:2;s:8:\"publicId\";i:3;s:10:\"externalID\";i:4;s:10:\"materialId\";i:5;s:7:\"brandId\";i:6;s:7:\"modelId\";i:7;s:23:\"mainOrganizationaUnitId\";i:8;s:9:\"entryDate\";i:9;s:11:\"last_update\";i:10;s:16:\"lastupdateUserId\";i:11;s:8:\"location\";i:12;s:8:\"file_url\";}s:37:\"externalIDType_current_fields_to_show\";a:10:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"barcodeId\";i:4;s:9:\"entryDate\";i:5;s:11:\"last_update\";i:6;s:14:\"creationUserId\";i:7;s:16:\"lastupdateUserId\";i:8;s:17:\"markedForDeletion\";i:9;s:21:\"markedForDeletionDate\";}s:42:\"organizational_unit_current_fields_to_show\";a:10:{i:0;s:12:\"externalCode\";i:1;s:4:\"name\";i:2;s:9:\"shortName\";i:3;s:11:\"description\";i:4;s:9:\"entryDate\";i:5;s:11:\"last_update\";i:6;s:14:\"creationUserId\";i:7;s:16:\"lastupdateUserId\";i:8;s:17:\"markedForDeletion\";i:9;s:21:\"markedForDeletionDate\";}s:31:\"location_current_fields_to_show\";a:10:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:14:\"parentLocation\";i:8;s:17:\"markedForDeletion\";i:9;s:21:\"markedForDeletionDate\";}s:31:\"material_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:28:\"brand_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:28:\"model_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:31:\"provider_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:35:\"money_source_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:28:\"users_current_fields_to_show\";a:9:{i:0;s:8:\"username\";i:1;s:5:\"email\";i:2;s:10:\"created_on\";i:3;s:10:\"last_login\";i:4;s:6:\"active\";i:5;s:10:\"first_name\";i:6;s:9:\"last_name\";i:7;s:7:\"company\";i:8;s:5:\"phone\";}s:29:\"groups_current_fields_to_show\";a:2:{i:0;s:4:\"name\";i:1;s:11:\"description\";}s:39:\"user_preferences_current_fields_to_show\";a:4:{i:0;s:6:\"userId\";i:1;s:8:\"language\";i:2;s:5:\"theme\";i:3;s:11:\"last_update\";}s:30:\"barcode_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:17:\"flash:old:message\";s:33:\"<p>Sessió iniciada amb èxit</p>\";}'),('b8eea6fc85cb4f72fb41adab0e1bdb90','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0',1392556618,'a:4:{s:9:\"user_data\";s:0:\"\";s:6:\"realms\";a:2:{i:0;s:5:\"mysql\";i:1;s:4:\"ldap\";}s:13:\"default_realm\";s:5:\"mysql\";s:16:\"institution_name\";s:21:\"EbreTIC Enginyeria SL\";}'),('d770df92b254e245f0f3b33cbc812326','127.0.0.1','Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:26.0) Gecko/20100101 Firefox/26.0',1392554086,'a:25:{s:9:\"user_data\";s:0:\"\";s:6:\"realms\";a:2:{i:0;s:5:\"mysql\";i:1;s:4:\"ldap\";}s:13:\"default_realm\";s:5:\"mysql\";s:16:\"institution_name\";s:21:\"EbreTIC Enginyeria SL\";s:8:\"identity\";s:8:\"sergitur\";s:8:\"username\";s:8:\"sergitur\";s:5:\"email\";s:21:\"sergi.tur@ebretic.com\";s:7:\"user_id\";s:1:\"1\";s:14:\"old_last_login\";s:19:\"2014-02-15 18:22:13\";s:4:\"role\";i:3;s:16:\"current_language\";s:7:\"catalan\";s:27:\"current_organizational_unit\";s:3:\"all\";s:39:\"inventory_object_current_fields_to_show\";a:13:{i:0;s:15:\"quantityInStock\";i:1;s:9:\"shortName\";i:2;s:8:\"publicId\";i:3;s:10:\"externalID\";i:4;s:10:\"materialId\";i:5;s:7:\"brandId\";i:6;s:7:\"modelId\";i:7;s:23:\"mainOrganizationaUnitId\";i:8;s:9:\"entryDate\";i:9;s:11:\"last_update\";i:10;s:16:\"lastupdateUserId\";i:11;s:8:\"location\";i:12;s:8:\"file_url\";}s:37:\"externalIDType_current_fields_to_show\";a:10:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"barcodeId\";i:4;s:9:\"entryDate\";i:5;s:11:\"last_update\";i:6;s:14:\"creationUserId\";i:7;s:16:\"lastupdateUserId\";i:8;s:17:\"markedForDeletion\";i:9;s:21:\"markedForDeletionDate\";}s:42:\"organizational_unit_current_fields_to_show\";a:10:{i:0;s:12:\"externalCode\";i:1;s:4:\"name\";i:2;s:9:\"shortName\";i:3;s:11:\"description\";i:4;s:9:\"entryDate\";i:5;s:11:\"last_update\";i:6;s:14:\"creationUserId\";i:7;s:16:\"lastupdateUserId\";i:8;s:17:\"markedForDeletion\";i:9;s:21:\"markedForDeletionDate\";}s:31:\"location_current_fields_to_show\";a:10:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:14:\"parentLocation\";i:8;s:17:\"markedForDeletion\";i:9;s:21:\"markedForDeletionDate\";}s:31:\"material_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:28:\"brand_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:28:\"model_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:31:\"provider_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:35:\"money_source_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}s:28:\"users_current_fields_to_show\";a:9:{i:0;s:8:\"username\";i:1;s:5:\"email\";i:2;s:10:\"created_on\";i:3;s:10:\"last_login\";i:4;s:6:\"active\";i:5;s:10:\"first_name\";i:6;s:9:\"last_name\";i:7;s:7:\"company\";i:8;s:5:\"phone\";}s:29:\"groups_current_fields_to_show\";a:2:{i:0;s:4:\"name\";i:1;s:11:\"description\";}s:39:\"user_preferences_current_fields_to_show\";a:4:{i:0;s:6:\"userId\";i:1;s:8:\"language\";i:2;s:5:\"theme\";i:3;s:11:\"last_update\";}s:30:\"barcode_current_fields_to_show\";a:9:{i:0;s:4:\"name\";i:1;s:9:\"shortName\";i:2;s:11:\"description\";i:3;s:9:\"entryDate\";i:4;s:11:\"last_update\";i:5;s:14:\"creationUserId\";i:6;s:16:\"lastupdateUserId\";i:7;s:17:\"markedForDeletion\";i:8;s:21:\"markedForDeletionDate\";}}');
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `externalIDType`
--

DROP TABLE IF EXISTS `externalIDType`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `externalIDType` (
  `externalIDTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `barcodeId` int(11) NOT NULL,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`externalIDTypeID`)
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `externalIDType`
--

LOCK TABLES `externalIDType` WRITE;
/*!40000 ALTER TABLE `externalIDType` DISABLE KEYS */;
INSERT INTO `externalIDType` VALUES (1,'Número de sèrie','Número de sèrie','<p>\n	prova</p>\n',2,'2013-08-06 09:48:08','2013-09-02 08:51:55',1,0,'n','0000-00-00 00:00:00'),(2,'Número de sèrie landashop','Num ser landa',NULL,0,'2013-08-24 17:33:20','2013-08-24 13:33:42',13,175,'n','0000-00-00 00:00:00'),(82,'provan','provan',NULL,5,'2013-09-08 17:40:32','2013-09-08 15:40:47',1,1,'n','0000-00-00 00:00:00'),(4,'Número de sèrie UPC','Núm sèrie UPC',NULL,2,'2013-08-24 17:53:41','2013-08-24 13:54:11',13,13,'n','0000-00-00 00:00:00'),(5,'Número de sèrie code 128','Número de sèrie code 128',NULL,5,'2013-08-24 17:54:15','2013-08-24 13:54:36',13,13,'n','0000-00-00 00:00:00'),(6,'Número de sèrie code 39','Número de sèrie code 39',NULL,4,'2013-08-24 17:54:44','2013-08-24 13:55:10',13,13,'n','0000-00-00 00:00:00'),(80,'Adreça IP','Adreça IP',NULL,2,'2013-09-08 16:59:19','2013-09-08 14:59:33',2,2,'n','0000-00-00 00:00:00'),(81,'unmes','unmes',NULL,5,'2013-09-08 17:07:34','2013-09-08 15:07:48',1,1,'n','0000-00-00 00:00:00'),(68,'bbb','bbb',NULL,0,'2013-09-03 06:34:27','2013-09-03 04:34:38',1,1,'n','0000-00-00 00:00:00'),(55,'a','a',NULL,0,'2013-09-02 20:18:18','2013-09-02 18:18:30',1,1,'n','0000-00-00 00:00:00'),(56,'b','b',NULL,0,'2013-09-02 20:20:09','2013-09-02 18:20:17',1,1,'n','0000-00-00 00:00:00'),(57,'caca','caca',NULL,5,'2013-09-02 20:20:48','2013-09-02 18:21:02',1,1,'n','0000-00-00 00:00:00'),(58,'xz','ZXC',NULL,0,'2013-09-02 20:26:29','2013-09-02 18:26:43',1,1,'n','0000-00-00 00:00:00'),(59,'aa','aa',NULL,5,'2013-09-02 20:32:10','2013-09-02 18:32:23',1,1,'n','0000-00-00 00:00:00'),(60,'aaa','aaa',NULL,0,'2013-09-02 20:35:06','2013-09-02 18:35:18',1,1,'n','0000-00-00 00:00:00'),(61,'bbb','bbb',NULL,1,'2013-09-02 20:35:58','2013-09-02 18:36:17',1,1,'n','0000-00-00 00:00:00'),(62,'cccc','cccc',NULL,0,'2013-09-02 20:39:05','2013-09-02 18:39:18',1,1,'n','0000-00-00 00:00:00'),(63,'bb','bb',NULL,0,'2013-09-02 20:41:58','2013-09-02 18:42:10',1,1,'n','0000-00-00 00:00:00'),(64,'caaa','caaa',NULL,0,'2013-09-02 20:43:39','2013-09-02 18:43:51',1,1,'n','0000-00-00 00:00:00'),(65,'caab','caab',NULL,0,'2013-09-02 20:44:59','2013-09-02 18:45:11',1,1,'n','0000-00-00 00:00:00'),(66,'baaaaa','baaaaa',NULL,0,'2013-09-02 20:45:44','2013-09-02 18:45:57',1,1,'n','0000-00-00 00:00:00'),(67,'aaaaa','baaaaa',NULL,0,'2013-09-03 06:34:02','2013-09-03 04:34:14',1,1,'n','0000-00-00 00:00:00'),(83,'dsa324','dsa',NULL,0,'2013-09-08 17:41:59','2013-09-08 15:42:05',2,2,'n','0000-00-00 00:00:00'),(84,'dsa','das',NULL,0,'2013-09-08 18:22:36','2013-09-08 16:22:43',3,3,'n','0000-00-00 00:00:00'),(69,'bbbb','bbbb',NULL,0,'2013-09-03 06:34:50','2013-09-03 04:35:00',1,1,'n','0000-00-00 00:00:00'),(70,'a__','a__',NULL,0,'2013-09-03 06:39:38','2013-09-03 04:39:53',1,1,'n','0000-00-00 00:00:00'),(71,'abca','abca',NULL,0,'2013-09-03 06:42:41','2013-09-03 04:43:08',1,1,'n','0000-00-00 00:00:00'),(72,'_a','_a',NULL,0,'2013-09-03 07:22:36','2013-09-03 05:22:48',1,1,'n','0000-00-00 00:00:00'),(73,'acdc','acdc',NULL,0,'2013-09-03 07:30:41','2013-09-03 05:30:53',1,1,'n','0000-00-00 00:00:00'),(74,'abb','abb',NULL,0,'2013-09-03 07:55:21','2013-09-03 05:55:32',1,1,'n','0000-00-00 00:00:00'),(75,'abc','abc',NULL,0,'2013-09-03 07:55:55','2013-09-03 05:56:05',1,1,'n','0000-00-00 00:00:00'),(76,'idexternnou','idexternnou',NULL,5,'2013-09-03 09:25:29','2013-09-03 07:27:52',1,1,'n','0000-00-00 00:00:00'),(77,'serienmil','serienmil',NULL,7,'2013-09-05 17:43:22','2013-09-05 15:43:43',1,1,'n','0000-00-00 00:00:00'),(78,'sda','das',NULL,0,'2013-09-08 10:31:07','2013-09-08 08:31:23',2,2,'n','0000-00-00 00:00:00'),(79,'Adreça MAC','Adreça MAC',NULL,2,'2013-09-08 13:18:20','2013-09-08 11:21:54',2,2,'n','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `externalIDType` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (1,'admin','Administrator'),(2,'members','General User'),(3,'inventory_admin','Automatic group added as ldap inventory role'),(4,'inventory_organizationalunit','inventory_organizationalunit');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `images`
--

DROP TABLE IF EXISTS `images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `images` (
  `imageId` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_objectId` int(11) DEFAULT NULL,
  `title` varchar(250) NOT NULL,
  `url` varchar(250) DEFAULT NULL,
  `priority` int(11) DEFAULT NULL,
  PRIMARY KEY (`imageId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `images`
--

LOCK TABLES `images` WRITE;
/*!40000 ALTER TABLE `images` DISABLE KEYS */;
INSERT INTO `images` VALUES (1,1,'','3d323-AmpliacionPlantaBaixa.png',NULL);
/*!40000 ALTER TABLE `images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_object`
--

DROP TABLE IF EXISTS `inventory_object`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_object` (
  `inventory_objectId` int(11) NOT NULL AUTO_INCREMENT,
  `publicId` varchar(50) NOT NULL,
  `externalID` varchar(100) NOT NULL,
  `externalIDType` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `materialId` int(11) NOT NULL,
  `brandId` int(11) NOT NULL,
  `modelId` int(11) NOT NULL,
  `entryDate` datetime NOT NULL,
  `manualEntryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `manualLast_update` datetime NOT NULL,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `quantityInStock` smallint(6) NOT NULL,
  `price` double NOT NULL,
  `moneySourceId` int(11) DEFAULT NULL,
  `providerId` int(11) DEFAULT NULL,
  `preservationState` enum('Good','Regular','Bad') NOT NULL DEFAULT 'Good',
  `markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `markedForDeletionDate` datetime NOT NULL,
  `file_url` varchar(250) NOT NULL,
  `mainOrganizationaUnitId` int(11) NOT NULL,
  PRIMARY KEY (`inventory_objectId`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_object`
--

LOCK TABLES `inventory_object` WRITE;
/*!40000 ALTER TABLE `inventory_object` DISABLE KEYS */;
INSERT INTO `inventory_object` VALUES (1,'','1234567890123',5,'a','a',NULL,0,0,0,'2013-08-27 19:18:30','0000-00-00 00:00:00','2013-09-05 17:04:51','0000-00-00 00:00:00',1,37,1,1,0,NULL,NULL,'Good','n','0000-00-00 00:00:00','',0),(23,'','',1,'prova_aramodificatperbegosole','prova_aramodificatperbegosole',NULL,1,1,1,'2013-09-08 10:00:51','0000-00-00 00:00:00','2013-09-08 08:19:22','0000-00-00 00:00:00',1,2,1,1,0,1,1,'Good','n','0000-00-00 00:00:00','',1),(24,'','',1,'provan','provan',NULL,1,1,1,'2013-09-08 10:01:27','0000-00-00 00:00:00','2013-09-08 08:01:46','0000-00-00 00:00:00',1,1,1,1,0,1,1,'Good','n','0000-00-00 00:00:00','',1),(16,'','',1,'asd','sad',NULL,1,0,0,'2013-08-31 13:47:23','0000-00-00 00:00:00','2013-08-31 11:47:33','0000-00-00 00:00:00',1,1,1,1,0,NULL,NULL,'Good','n','0000-00-00 00:00:00','',1),(17,'','',1,'a','b',NULL,1,1,1,'2013-09-03 08:46:28','0000-00-00 00:00:00','2013-09-03 06:47:07','0000-00-00 00:00:00',1,1,1,1,0,1,1,'Good','n','0000-00-00 00:00:00','',1),(18,'dasda','',1,'aaa','bbb',NULL,1,1,1,'2013-09-03 09:22:38','0000-00-00 00:00:00','2013-09-03 07:23:54','0000-00-00 00:00:00',1,1,1,1,0,1,1,'Good','n','0000-00-00 00:00:00','',1),(19,'','',1,'zz','zz',NULL,1,1,1,'2013-09-03 09:24:14','0000-00-00 00:00:00','2013-09-03 07:24:22','0000-00-00 00:00:00',1,1,1,1,0,1,1,'Good','n','0000-00-00 00:00:00','',1),(20,'','',1,'provaaveurequetal','creationuserid',NULL,1,1,1,'2013-09-08 09:26:58','0000-00-00 00:00:00','2013-09-08 07:27:19','0000-00-00 00:00:00',NULL,NULL,1,1,0,1,1,'Good','n','0000-00-00 00:00:00','',1),(21,'','',1,'provacreationuserid','provacreationuserid',NULL,1,1,1,'2013-09-08 09:54:53','0000-00-00 00:00:00','2013-09-08 07:55:38','0000-00-00 00:00:00',1,1,1,1,0,1,1,'Good','n','0000-00-00 00:00:00','',1),(22,'','',1,'provacanviant creationuserid','provacanviant creationuserid_canviatperbegosole',NULL,1,1,1,'2013-09-08 09:57:52','0000-00-00 00:00:00','2013-09-08 08:03:19','0000-00-00 00:00:00',1,235,1,1,0,1,1,'Good','n','0000-00-00 00:00:00','',1);
/*!40000 ALTER TABLE `inventory_object` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inventory_object_organizational_unit`
--

DROP TABLE IF EXISTS `inventory_object_organizational_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inventory_object_organizational_unit` (
  `inventory_objectId` int(11) NOT NULL,
  `organitzational_unitId` int(11) NOT NULL DEFAULT '0',
  `priority` int(11) NOT NULL,
  PRIMARY KEY (`inventory_objectId`,`organitzational_unitId`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inventory_object_organizational_unit`
--

LOCK TABLES `inventory_object_organizational_unit` WRITE;
/*!40000 ALTER TABLE `inventory_object_organizational_unit` DISABLE KEYS */;
/*!40000 ALTER TABLE `inventory_object_organizational_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `locationId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `parentLocation` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`locationId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (1,'GENERAL','GENERAL',NULL,'2013-08-27 19:18:12','2013-08-27 17:18:21',1,1,NULL,'n','0000-00-00 00:00:00'),(2,'Despatx BSF','Despatx BSF',NULL,'2013-09-08 13:12:44','2013-09-08 11:13:01',2,2,1,'n','0000-00-00 00:00:00'),(3,'dsa','asd','<p>\n	ads<br />\n	&nbsp;</p>\n','2013-09-08 13:13:19','2013-09-08 11:13:52',2,2,1,'y','2013-09-09 00:00:00'),(4,'provabaixa','provabaixa','<p>\n	provabaixa</p>\n','2013-09-08 13:17:34','2013-09-08 11:17:49',2,2,1,'y','2013-09-09 00:00:00');
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `login_attempts`
--

DROP TABLE IF EXISTS `login_attempts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `login_attempts`
--

LOCK TABLES `login_attempts` WRITE;
/*!40000 ALTER TABLE `login_attempts` DISABLE KEYS */;
INSERT INTO `login_attempts` VALUES (1,'\0\0','sergi',1392484926);
/*!40000 ALTER TABLE `login_attempts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material`
--

DROP TABLE IF EXISTS `material`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `material` (
  `materialId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `parentMaterialId` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`materialId`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material`
--

LOCK TABLES `material` WRITE;
/*!40000 ALTER TABLE `material` DISABLE KEYS */;
INSERT INTO `material` VALUES (1,'a','b','<p>\n	asdasd</p>\n','2013-08-30 09:51:51','2013-08-30 07:51:59',1,1,NULL,'n','0000-00-00 00:00:00'),(2,'PROVA','PROVA','<p>\n	rqw123</p>\n','2013-08-30 09:52:21','2013-09-02 16:34:14',1,84,1,'n','0000-00-00 00:00:00'),(3,'bb','bb',NULL,'2013-09-03 07:14:24','2013-09-03 05:14:42',1,1,NULL,'n','0000-00-00 00:00:00'),(4,'ccc','ccc',NULL,'2013-09-03 07:15:53','2013-09-03 05:16:05',1,1,NULL,'n','0000-00-00 00:00:00'),(5,'dd','dd',NULL,'2013-09-03 07:23:07','2013-09-03 05:23:16',1,1,NULL,'n','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `material` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model`
--

DROP TABLE IF EXISTS `model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `model` (
  `modelId` int(11) NOT NULL AUTO_INCREMENT,
  `brandId` int(11) DEFAULT NULL,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`modelId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model`
--

LOCK TABLES `model` WRITE;
/*!40000 ALTER TABLE `model` DISABLE KEYS */;
INSERT INTO `model` VALUES (1,1,'Sense model','Sense model',NULL,'2013-09-03 08:21:07','2013-09-03 06:21:24',1,1,'n','0000-00-00 00:00:00'),(2,7,'Panda','Panda',NULL,'2013-09-03 08:21:30','2013-09-03 06:21:42',1,1,'n','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `money_source`
--

DROP TABLE IF EXISTS `money_source`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `money_source` (
  `moneySourceId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`moneySourceId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `money_source`
--

LOCK TABLES `money_source` WRITE;
/*!40000 ALTER TABLE `money_source` DISABLE KEYS */;
INSERT INTO `money_source` VALUES (1,'Sense origen dels diners','Sense origen dels diners',NULL,'2013-09-03 08:44:39','2013-09-03 06:44:57',1,1,'n','0000-00-00 00:00:00'),(2,'a','a',NULL,'2013-09-03 08:45:01','2013-09-03 06:45:11',1,1,'n','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `money_source` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `organizational_unit`
--

DROP TABLE IF EXISTS `organizational_unit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organizational_unit` (
  `organizational_unitId` int(11) NOT NULL AUTO_INCREMENT,
  `externalCode` int(11) NOT NULL,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `location` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`organizational_unitId`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `organizational_unit`
--

LOCK TABLES `organizational_unit` WRITE;
/*!40000 ALTER TABLE `organizational_unit` DISABLE KEYS */;
INSERT INTO `organizational_unit` VALUES (1,0,'a','b',NULL,'2013-08-29 22:08:22','2013-08-29 20:08:33',1,1,NULL,'n','0000-00-00 00:00:00'),(2,0,'b','b',NULL,'2013-09-03 08:40:14','2013-09-03 06:40:28',1,1,NULL,'n','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `organizational_unit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `provider`
--

DROP TABLE IF EXISTS `provider`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `provider` (
  `providerId` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(150) NOT NULL,
  `shortName` varchar(150) NOT NULL,
  `description` text,
  `entryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL,
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`providerId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `provider`
--

LOCK TABLES `provider` WRITE;
/*!40000 ALTER TABLE `provider` DISABLE KEYS */;
INSERT INTO `provider` VALUES (1,'Sense proveïdor','Sense proveïdor','<p>\n	Sense prove&iuml;dor</p>\n','2013-09-03 08:39:30','2013-09-03 06:39:55',1,1,'n','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `provider` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_preferences`
--

DROP TABLE IF EXISTS `user_preferences`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_preferences` (
  `user_preferencesId` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `language` enum('catalan','spanish','english') NOT NULL DEFAULT 'catalan',
  `theme` enum('flexigrid','datatables','twitter-bootstrap') NOT NULL DEFAULT 'flexigrid',
  `dialogforms` enum('n','y') NOT NULL DEFAULT 'n',
  `description` text,
  `entryDate` datetime NOT NULL,
  `manualEntryDate` datetime NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `manualLast_update` datetime NOT NULL,
  `creationUserId` int(11) DEFAULT NULL,
  `lastupdateUserId` int(11) DEFAULT NULL,
  `markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`user_preferencesId`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_preferences`
--

LOCK TABLES `user_preferences` WRITE;
/*!40000 ALTER TABLE `user_preferences` DISABLE KEYS */;
INSERT INTO `user_preferences` VALUES (1,1,'catalan','flexigrid','n',NULL,'2013-08-28 12:14:14','0000-00-00 00:00:00','2013-08-29 18:39:56','0000-00-00 00:00:00',1,5,'n','0000-00-00 00:00:00'),(2,2,'catalan','flexigrid','n',NULL,'2013-09-08 11:47:11','0000-00-00 00:00:00','2013-09-08 10:30:54','0000-00-00 00:00:00',1,2,'n','0000-00-00 00:00:00'),(3,3,'catalan','flexigrid','n',NULL,'2013-09-08 18:21:38','0000-00-00 00:00:00','2013-09-08 16:21:52','0000-00-00 00:00:00',3,3,'n','0000-00-00 00:00:00');
/*!40000 ALTER TABLE `user_preferences` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `mainOrganizationaUnitId` int(11) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_code` varchar(40) DEFAULT NULL,
  `forgotten_password_time` int(11) unsigned DEFAULT NULL,
  `remember_code` varchar(40) DEFAULT NULL,
  `created_on` datetime NOT NULL,
  `last_login` datetime NOT NULL,
  `active` tinyint(1) unsigned DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'\0\0','sergitur','0bd79ace3e2757dcfffb370245e0302d01dae43b',0,NULL,'sergi.tur@ebretic.com',NULL,'4facc977b545e1b5bc651d9239d2bca540f5f2ca',1379173790,NULL,'2013-08-27 19:10:33','2014-02-16 17:20:20',1,'Sergi','Tur Badenas',NULL,'977502496'),(2,'\0\0','begosole','859048d0e44973f7fef2c2b1a160275a4b01fddb',0,NULL,'begosolearagones@gmail.com',NULL,NULL,NULL,NULL,'2013-08-27 20:08:30','2013-09-08 16:38:16',1,'Begonya','Solé Aragonés','ACME','679582467'),(3,'\0\0','limitat','aa19f351d8ccdb3a6aa770eda76b5179c9c7eb94',1,NULL,'sdadasads@asdsd.es',NULL,NULL,NULL,NULL,'2013-09-08 18:15:50','2013-09-08 18:16:03',1,'limitat','limitat',NULL,NULL),(4,'\0\0','pepe','f9cb0e100a394b552249a3a584cae60b273499e4',1,NULL,'begosolearagones1@gmail.com',NULL,NULL,NULL,NULL,'2013-09-15 19:06:54','0000-00-00 00:00:00',1,'pepe','pepe',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users_groups`
--

DROP TABLE IF EXISTS `users_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`),
  CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users_groups`
--

LOCK TABLES `users_groups` WRITE;
/*!40000 ALTER TABLE `users_groups` DISABLE KEYS */;
INSERT INTO `users_groups` VALUES (1,1,3),(3,2,3),(4,3,4),(5,4,1);
/*!40000 ALTER TABLE `users_groups` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-02-17  9:21:33
