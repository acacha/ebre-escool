--
-- Host: localhost    Database: skeleton
-- ------------------------------------------------------
-- Server version	5.5.32-0ubuntu0.12.04.1

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
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(80) NOT NULL,
  `mainOrganizationaUnitId` int(11) NOT NULL,
  `salt` varchar(40) DEFAULT NULL,
  `secondary_email` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activation_code` varchar(40) DEFAULT NULL,
  `forgotten_password_realm` varchar(50) NOT NULL,
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `login_attempts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip_address` varbinary(16) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `users_groups` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(11) unsigned NOT NULL,
  `group_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  KEY `fk_users_groups_users1_idx` (`user_id`),
  KEY `fk_users_groups_groups1_idx` (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `user_preferences` (
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Estructura de la taula `organizational_unit`
--

CREATE TABLE IF NOT EXISTS `organizational_unit` (
  `organizational_unit_Id` int(11) NOT NULL AUTO_INCREMENT,
  `organizational_unit_externalCode` int(11) NOT NULL,
  `organizational_unit_name` varchar(150) NOT NULL,
  `organizational_unit_shortName` varchar(150) NOT NULL,
  `organizational_unit_description` text,
  `organizational_unit_parent` int(11) NOT NULL,
  `organizational_unit_entryDate` datetime NOT NULL,
  `organizational_unit_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `organizational_unit_creationUserId` int(11) DEFAULT NULL,
  `organizational_unit_lastupdateUserId` int(11) DEFAULT NULL,
  `organizational_unit_location` int(11) DEFAULT NULL,
  `organizational_unit_markedForDeletion` enum('n','y') NOT NULL,
  `organizational_unit_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`organizational_unit_Id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `location` (
  `location_id` int(11) NOT NULL AUTO_INCREMENT,
  `location_name` varchar(150) NOT NULL,
  `location_shortName` varchar(150) NOT NULL,
  `location_description` text,
  `location_department_id` int(11) NOT NULL,
  `location_organizational_unit_id` int(11) NOT NULL,
  `location_entryDate` datetime NOT NULL,
  `location_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `location_creationUserId` int(11) DEFAULT NULL,
  `location_lastupdateUserId` int(11) DEFAULT NULL,
  `location_parentLocation` int(11) DEFAULT NULL,
  `location_markedForDeletion` enum('n','y') NOT NULL,
  `location_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`location_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Database: `ebre_escool`
--

-- --------------------------------------------------------

--
-- Table structure for table `classroom_group`
--

CREATE TABLE IF NOT EXISTS `classroom_group` (
  `classroom_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `classroom_group_code` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `classroom_group_shortName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `classroom_group_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `classroom_group_course_id` int(11) NOT NULL,
  `classroom_group_description` text COLLATE utf8_unicode_ci NOT NULL,
  `classroom_group_educationalLevelId` varchar(25) COLLATE utf8_unicode_ci NOT NULL,
  `classroom_group_mentorId` varchar(3) COLLATE utf8_unicode_ci DEFAULT NULL,
  `classroom_group_shift` smallint(6) NOT NULL,
  `classroom_group_location_id` int(11) NOT NULL,
  `classroom_group_entryDate` datetime NOT NULL,
  `classroom_group_lastupdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `classroom_group_creationUserId` int(11) DEFAULT NULL,
  `classroom_group_lastupdateUserId` int(11) DEFAULT NULL,
  `classroom_group_parentLocation` int(11) DEFAULT NULL,
  `classroom_group_markedForDeletion` enum('n','y') COLLATE utf8_unicode_ci NOT NULL,
  `classroom_group_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`classroom_group_id`),
  UNIQUE KEY `groupCode` (`classroom_group_code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=56 ;

--
-- Restriccions per la taula `users_groups`
--
ALTER TABLE `users_groups`
  ADD CONSTRAINT `fk_users_groups_groups1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_groups_users1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION;

-- Dump completed on 2013-09-13  7:33:11



-- --------------------------------------------------------

--
-- Estructura de la taula `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `course_id` int(11) NOT NULL AUTO_INCREMENT,
  `course_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `course_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `course_number` int(11) NOT NULL,
  `course_cycle_id` int(11) NOT NULL,
  `course_estudies_id` int(11) NOT NULL,
  `course_entryDate` datetime NOT NULL,
  `course_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `course_creationUserId` int(11) DEFAULT NULL,
  `course_lastupdateUserId` int(11) DEFAULT NULL,
  `course_markedForDeletion` enum('n','y') NOT NULL,
  `course_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`course_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `cycle`
--

CREATE TABLE IF NOT EXISTS `cycle` (
  `cycle_id` int(11) NOT NULL AUTO_INCREMENT,
  `cycle_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `cycle_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `cycle_entryDate` datetime NOT NULL,
  `cycle_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `cycle_creationUserId` int(11) DEFAULT NULL,
  `cycle_lastupdateUserId` int(11) DEFAULT NULL,
  `cycle_markedForDeletion` enum('n','y') NOT NULL,
  `cycle_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`cycle_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `enrollment` (
  `enrollment_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_entryDate` datetime NOT NULL,
  `enrollment_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_creationUserId` int(11) DEFAULT NULL,
  `enrollment_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `enrollment_class_group`
--

CREATE TABLE IF NOT EXISTS `enrollment_class_group` (
  `enrollment_class_group_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_class_group_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_class_group_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_class_group_study_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_class_group_group_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_class_group_entryDate` datetime NOT NULL,
  `enrollment_class_group_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_class_group_creationUserId` int(11) DEFAULT NULL,
  `enrollment_class_group_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_class_group_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_class_group_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_class_group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `enrollment_modules`
--

CREATE TABLE IF NOT EXISTS `enrollment_modules` (
  `enrollment_modules_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_modules_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_study_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_group_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_moduleid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_modules_entryDate` datetime NOT NULL,
  `enrollment_modules_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_modules_creationUserId` int(11) DEFAULT NULL,
  `enrollment_modules_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_modules_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_modules_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_modules_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `enrollment_studies`
--

CREATE TABLE IF NOT EXISTS `enrollment_studies` (
  `enrollment_studies_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_studies_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_studies_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_studies_study_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_studies_entryDate` datetime NOT NULL,
  `enrollment_studies_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_studies_creationUserId` int(11) DEFAULT NULL,
  `enrollment_studies_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_studies_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_studies_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_studies_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `enrollment_submodules`
--

CREATE TABLE IF NOT EXISTS `enrollment_submodules` (
  `enrollment_submodules_id` int(11) NOT NULL AUTO_INCREMENT,
  `enrollment_submodules_periodid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_personid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_study_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_group_id` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_moduleid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_submoduleid` varchar(50) CHARACTER SET utf8 NOT NULL,
  `enrollment_submodules_entryDate` datetime NOT NULL,
  `enrollment_submodules_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `enrollment_submodules_creationUserId` int(11) DEFAULT NULL,
  `enrollment_submodules_lastupdateUserId` int(11) DEFAULT NULL,
  `enrollment_submodules_markedForDeletion` enum('n','y') NOT NULL,
  `enrollment_submodules_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`enrollment_submodules_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



--
-- Estructura de la taula `department`
--

CREATE TABLE IF NOT EXISTS `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `department_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `department_name` varchar(150) CHARACTER SET utf8 NOT NULL,
  `department_head` int(11) NOT NULL,
  `department_parent_department_id` int(11) NOT NULL,
  `department_organizational_unit_id` int(11) NOT NULL,
  `department_location_id` int(11) NOT NULL,
  `department_entryDate` datetime NOT NULL,
  `department_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `department_creationUserId` int(11) DEFAULT NULL,
  `department_lastupdateUserId` int(11) DEFAULT NULL,
  `department_markedForDeletion` enum('n','y') NOT NULL,
  `department_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `studies`
--

CREATE TABLE IF NOT EXISTS `studies` (
  `studies_id` int(11) NOT NULL AUTO_INCREMENT,
  `studies_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `studies_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `studies_entryDate` datetime NOT NULL,
  `studies_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `studies_creationUserId` int(11) DEFAULT NULL,
  `studies_lastupdateUserId` int(11) DEFAULT NULL,
  `studies_markedForDeletion` enum('n','y') NOT NULL,
  `studies_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`studies_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `studies_organizational_unit`
--

CREATE TABLE IF NOT EXISTS `studies_organizational_unit` (
  `studies_organizational_unit_id` int(11) NOT NULL AUTO_INCREMENT,
  `studies_organizational_unit_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `studies_organizational_unit_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `studies_organizational_unit_entryDate` datetime NOT NULL,
  `studies_organizational_unit_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `studies_organizational_unit_creationUserId` int(11) DEFAULT NULL,
  `studies_organizational_unit_lastupdateUserId` int(11) DEFAULT NULL,
  `studies_organizational_unit_markedForDeletion` enum('n','y') NOT NULL,
  `studies_organizational_unit_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`studies_organizational_unit_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- Dump completed on 2013-11-04  9:26:45

-- --------------------------------------------------------

--
-- Estructura de la taula `study_module`
--

CREATE TABLE IF NOT EXISTS `study_module` (
  `study_module_id` int(11) NOT NULL AUTO_INCREMENT,
  `study_module_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `study_module_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `study_module_hoursPerWeek` int(3) NOT NULL,
  `study_module_classroom_group_id` int(11) NOT NULL,
  `study_module_courseid` int(11) NOT NULL,
  `study_module_teacher_id` int(11) NOT NULL,
  `study_module_order` int(11) NOT NULL,
  `study_module_description` text,
  `study_module_initialDate` datetime NOT NULL,
  `study_module_endDate` datetime NOT NULL,
  `study_module_type` enum('Troncal','Alternativa','Optativa') NOT NULL,
  `study_module_subtype` enum('Trimestral','Quadrimestral') NOT NULL,
  `study_module_entryDate` datetime NOT NULL,
  `study_module_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `study_module_creationUserId` int(11) DEFAULT NULL,
  `study_module_lastupdateUserId` int(11) DEFAULT NULL,
  `study_module_markedForDeletion` enum('n','y') NOT NULL,
  `study_module_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`study_module_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
-- --------------------------------------------------------

--
-- Estructura de la taula `study_submodules`
--

CREATE TABLE IF NOT EXISTS `study_submodules` (
  `study_submodules_id` int(11) NOT NULL AUTO_INCREMENT,
  `study_submodules_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `study_submodules_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `study_submodules_study_module_id` int(11) NOT NULL,
  `study_submodules_courseid` int(11) NOT NULL,
  `study_submodules_initialDate` datetime NOT NULL,
  `study_submodules_endDate` datetime NOT NULL,
  `study_submodules_totalHours` int(11) NOT NULL,
  `study_submodules_order` int(11) NOT NULL,
  `study_submodules_description` text,
  `study_submodules_entryDate` datetime NOT NULL,
  `study_submodules_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `study_submodules_creationUserId` int(11) DEFAULT NULL,
  `study_submodules_lastupdateUserId` int(11) DEFAULT NULL,
  `study_submodules_markedForDeletion` enum('n','y') NOT NULL,
  `study_submodules_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`study_submodules_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- Dump completed on 2013-09-13  7:33:11

-- --------------------------------------------------------


--
-- Estructura de la taula `person`
--

CREATE TABLE IF NOT EXISTS `person` (
  `person_id` int(11) NOT NULL AUTO_INCREMENT,
  `person_givenName` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_sn1` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_sn2` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_secondary_email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_official_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_official_id_type` int(11) NOT NULL,
  `person_date_of_birth` date NOT NULL,
  `person_gender` enum('F','M') CHARACTER SET utf8 NOT NULL,
  `person_secondary_official_id` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_secondary_official_id_type` int(11) NOT NULL,
  `person_homePostalAddress` varchar(750) CHARACTER SET utf8 NOT NULL,
  `person_photo` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_locality_id` int(11) NOT NULL,
  `person_telephoneNumber` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_mobile` varchar(255) CHARACTER SET utf8 NOT NULL,
  `person_bank_account_id` int(11) NOT NULL,
  `person_notes` text CHARACTER SET utf8 NOT NULL,
  `person_entryDate` datetime NOT NULL,
  `person_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `person_creationUserId` int(11) DEFAULT NULL,
  `person_lastupdateUserId` int(11) DEFAULT NULL,
  `person_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `person_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`person_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `person_official_id_type` (
  `person_official_id_type_id` int(11) NOT NULL,
  `person_official_id_type_name` varchar(500) NOT NULL,
  `person_official_id_type_shortname` varchar(50) NOT NULL,
  `person_official_id_type_entryDate` datetime NOT NULL,
  `person_official_id_type_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `person_official_id_type_creationUserId` int(11) DEFAULT NULL,
  `person_official_id_type_lastupdateUserId` int(11) DEFAULT NULL,
  `person_official_id_type_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `person_official_id_type_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`person_official_id_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Estructura de la taula `teacher`
--

CREATE TABLE IF NOT EXISTS `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_person_id` int(11) NOT NULL,
  `teacher_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `teacher_department_id` int(11) NOT NULL,
  `teacher_entryDate` datetime NOT NULL,
  `teacher_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `teacher_creationUserId` int(11) DEFAULT NULL,
  `teacher_lastupdateUserId` int(11) DEFAULT NULL,
  `teacher_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `teacher_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=104 ;

--
-- Bolcant dades de la taula `person_official_id_type`
--

INSERT INTO `person_official_id_type` (`person_official_id_type_id`, `person_official_id_type_name`, `person_official_id_type_shortname`, `person_official_id_type_entryDate`, `person_official_id_type_last_update`, `person_official_id_type_creationUserId`, `person_official_id_type_lastupdateUserId`, `person_official_id_type_markedForDeletion`, `person_official_id_type_markedForDeletionDate`) VALUES
(1, 'Document Nacional d''Identitat', 'DNI', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, '', '0000-00-00 00:00:00'),
(2, 'Número d''identificació d''extranger', 'NIE', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, '', '0000-00-00 00:00:00'),
(3, 'Passaport', 'Passaport', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, '', '0000-00-00 00:00:00');

CREATE TABLE IF NOT EXISTS `state` (
  `state_id` int(11) NOT NULL AUTO_INCREMENT,
  `state_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `state_parent_state_id` int(11) NOT NULL,
  `state_parent_state_name` varchar(255) NOT NULL,
  `state_entryDate` datetime NOT NULL,
  `state_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `state_creationUserId` int(11) DEFAULT NULL,
  `state_lastupdateUserId` int(11) DEFAULT NULL,
  `state_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `state_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`state_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

--
-- Bolcant dades de la taula `state`
--

INSERT INTO `state` (`state_id`, `state_name`, `state_parent_state_id`, `state_parent_state_name`, `entryDate`, `last_update`, `creationUserId`, `lastupdateUserId`, `markedForDeletion`, `markedForDeletionDate`) VALUES
(1, 'ARABA/ALAVA', 15, 'PAIS VASCO', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(2, 'ALBACETE', 7, 'CASTILLA-LA MANCHA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(3, 'ALICANTE', 17, 'VALENCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(4, 'ALMERIA', 1, 'ANDALUCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(5, 'AVILA', 8, 'CASTILLA Y LEON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(6, 'BADAJOZ', 10, 'EXTREMADURA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(7, 'ILLES BALEARS', 4, 'ILLES BALEARS', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(8, 'BARCELONA', 9, 'CATALUNYA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(9, 'BURGOS', 8, 'CASTILLA Y LEON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(10, 'CACERES', 10, 'EXTREMADURA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(11, 'CADIZ', 1, 'ANDALUCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(12, 'CASTELLON', 17, 'VALENCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(13, 'CIUDAD REAL', 7, 'CASTILLA-LA M.', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(14, 'CORDOBA', 1, 'ANDALUCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(15, 'A CORUÑA', 11, 'GALICIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(16, 'CUENCA', 7, 'CASTILLA-LA M.', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(17, 'GIRONA', 9, 'CATALUNYA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(18, 'GRANADA', 1, 'ANDALUCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(19, 'GUADALAJARA', 7, 'CASTILLA-LA MANCHA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(20, 'GIPUZKOA', 15, 'PAIS VASCO', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(21, 'HUELVA', 1, 'ANDALUCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(22, 'HUESCA', 2, 'ARAGON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(23, 'JAEN', 1, 'ANDALUCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(24, 'LEON', 8, 'CASTILLA Y LEON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(25, 'LLEIDA', 9, 'CATALUNYA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(26, 'LA RIOJA', 16, 'LA RIOJA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(27, 'LUGO', 11, 'GALICIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(28, 'MADRID', 12, 'MADRID', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(29, 'MALAGA', 1, 'ANDALUCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(30, 'MURCIA', 13, 'MURCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(31, 'NAVARRA', 14, 'NAVARRA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(32, 'OURENSE', 11, 'GALICIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(33, 'ASTURIAS', 3, 'PDO. ASTURIAS', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(34, 'PALENCIA', 8, 'CASTILLA Y LEON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(35, 'LAS PALMAS', 5, 'CANARIAS', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(36, 'PONTEVEDRA', 11, 'GALICIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(37, 'SALAMANCA', 8, 'CASTILLA Y LEON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(38, 'S.C.TENERIFE', 5, 'CANARIAS', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(39, 'CANTABRIA', 6, 'CANTABRIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(40, 'SEGOVIA', 8, 'CASTILLA Y LEON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(41, 'SEVILLA', 1, 'ANDALUCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(42, 'SORIA', 8, 'CASTILLA Y LEON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(43, 'TARRAGONA', 9, 'CATALUNYA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(44, 'TERUEL', 2, 'ARAGON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(45, 'TOLEDO', 7, 'CASTILLA-LA MANCHA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(46, 'VALENCIA', 17, 'VALENCIA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(47, 'VALLADOLID', 8, 'CASTILLA Y LEON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(48, 'BIZKAIA', 15, 'PAIS VASCO', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(49, 'ZAMORA', 8, 'CASTILLA Y LEON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(50, 'ZARAGOZA', 2, 'ARAGON', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(51, 'CEUTA', 18, 'CEUTA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(52, 'MELILLA', 19, 'MELILLA', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00');

--
-- Estructura de la taula `locality`
--

CREATE TABLE IF NOT EXISTS `locality` (
  `locality_id` int(11) NOT NULL AUTO_INCREMENT,
  `locality_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `locality_parent_locality_id` varchar(255) NOT NULL,
  `locality_state_id` int(11) NOT NULL,
  `locality_ine_id` int(11) NOT NULL COMMENT 'Codi Instituto Nacional Estadística',
  `locality_aeat_id` int(11) NOT NULL COMMENT 'Codi segons Hisenda',
  `locality_postal_code` varchar(255) NOT NULL,
  `locality_entryDate` datetime NOT NULL,
  `locality_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  ` ` int(11) DEFAULT NULL,
  `locality_lastupdateUserId` int(11) DEFAULT NULL,
  `locality_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `locality_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`locality_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Bolcant dades de la taula `locality`
--

INSERT INTO `locality` (`locality_id`, `locality_name`, `locality_parent_locality_id`, `locality_state_id`, `locality_ine_id`, `locality_aeat_id`, `locality_postal_code`, `entryDate`, `last_update`, `creationUserId`, `lastupdateUserId`, `markedForDeletion`, `markedForDeletionDate`) VALUES
(1, 'AIGUAMURCIA', 'AIGUAMURCIA', 43, 43001, 43001, '43815', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(2, 'ALBA (L'')', 'AIGUAMURCIA', 43, 43001, 43001, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(3, 'ORDRES (LES)', 'AIGUAMURCIA', 43, 43001, 43001, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(4, 'PLA DE MANLLEU', 'AIGUAMURCIA', 43, 43001, 43001, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(5, 'PLANETA (LA)', 'AIGUAMURCIA', 43, 43001, 43001, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(6, 'POBLES (LES)', 'AIGUAMURCIA', 43, 43001, 43001, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(7, 'SANTES CREUS', 'AIGUAMURCIA', 43, 43001, 43001, '43205', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(8, 'URB DE ELS MANANTIALS', 'AIGUAMURCIA', 43, 43001, 43001, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(9, 'URB MAS D''EN PARES', 'AIGUAMURCIA', 43, 43001, 43001, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(10, 'ALBINYANA', 'ALBINYANA', 43, 43002, 43002, '43716', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(11, 'PECES (LES)', 'ALBINYANA', 43, 43002, 43002, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(12, 'BONATERRA I', 'ALBINYANA', 43, 43002, 43002, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(13, 'BONATERRA II', 'ALBINYANA', 43, 43002, 43002, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(14, 'MASIES DEL TORRENT', 'ALBINYANA', 43, 43002, 43002, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(15, 'MOLI DEL BLANQUILLO', 'ALBINYANA', 43, 43002, 43002, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(16, 'PAPIOLA (LA)', 'ALBINYANA', 43, 43002, 43002, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(17, 'ALBIOL (L'')', 'ALBIOL (L'')', 43, 43003, 43003, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(18, 'BONRETORN', 'ALBIOL (L'')', 43, 43003, 43003, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(19, 'MASIES CATALANES', 'ALBIOL (L'')', 43, 43003, 43003, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(20, 'VILLA SAN FRANCISCO', 'ALBIOL (L'')', 43, 43003, 43003, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(21, 'ALCANAR', 'ALCANAR', 43, 43004, 43004, '43530', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(22, 'ALCANAR-PLATJA', 'ALCANAR', 43, 43004, 43004, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(23, 'CASES D''ALCANAR (LES)', 'ALCANAR', 43, 43004, 43004, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(24, 'SELLETA (LA)', 'ALCANAR', 43, 43004, 43004, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(25, 'ALCOVER', 'ALCOVER', 43, 43005, 43005, '43203', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(26, 'PLANA (LA)', 'ALCOVER', 43, 43005, 43005, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(27, 'CABANA (LA)', 'ALCOVER', 43, 43005, 43005, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(28, 'MASIES CATALANES', 'ALCOVER', 43, 43005, 43005, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(29, 'RESIDENCIAL REMEI', 'ALCOVER', 43, 43005, 43005, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(30, 'SERRADALT', 'ALCOVER', 43, 43005, 43005, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(31, 'BURQUERA (LA)', 'ALCOVER', 43, 43005, 43005, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(32, 'CAMI DELS MUNTANYANTS', 'ALCOVER', 43, 43005, 43005, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(33, 'MAS GASSOL', 'ALCOVER', 43, 43005, 43005, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(34, 'ALDOVER', 'ALDOVER', 43, 43006, 43006, '43591', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(35, 'ALEIXAR (L'')', 'ALEIXAR (L'')', 43, 43007, 43007, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(36, 'ALFARA DE CARLES', 'ALFARA DE CARLES', 43, 43008, 43008, '43528', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(37, 'ALFORJA', 'ALFORJA', 43, 43009, 43009, '43202', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(38, 'BARQUERES', 'ALFORJA', 43, 43009, 43009, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(39, 'GARRIGOTS', 'ALFORJA', 43, 43009, 43009, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(40, 'MAS DE L''ALEU', 'ALFORJA', 43, 43009, 43009, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(41, 'PORTUGAL', 'ALFORJA', 43, 43009, 43009, '43206', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(42, 'SANT ANTONI', 'ALFORJA', 43, 43009, 43009, '43893', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(43, 'SERVIANS', 'ALFORJA', 43, 43009, 43009, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(44, 'ALIO', 'ALIO', 43, 43010, 43010, '43813', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(45, 'ALMOSTER', 'ALMOSTER', 43, 43011, 43011, '43393', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(46, 'PUNTARRONS', 'ALMOSTER', 43, 43011, 43011, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(47, 'PICARANY', 'ALMOSTER', 43, 43011, 43011, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(48, 'CASTELLMOSTER', 'ALMOSTER', 43, 43011, 43011, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(49, 'ALTAFULLA', 'ALTAFULLA', 43, 43012, 43012, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(50, 'BRISES DEL MAR', 'ALTAFULLA', 43, 43012, 43012, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(51, 'AMETLLA DE MAR (L'')', 'AMETLLA DE MAR (L'')', 43, 43013, 43013, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(52, 'AMPOSTA', 'AMPOSTA', 43, 43014, 43014, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(53, 'BALADA', 'AMPOSTA', 43, 43014, 43014, '43879', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(54, 'FAVARET', 'AMPOSTA', 43, 43014, 43014, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(55, 'POBLE NOU DEL DELTA', 'AMPOSTA', 43, 43014, 43014, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(56, 'EUCALIPTUS', 'AMPOSTA', 43, 43014, 43014, '43007', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(57, 'ARBOLI', 'ARBOLI', 43, 43015, 43015, '43202', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(58, 'ARBOĒ (L'')', 'ARBO? (L'')', 43, 43016, 43016, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(59, 'CAN VIES', 'ARBO? (L'')', 43, 43016, 43016, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(60, 'CASETES DE PUIGMOLTO (LES)', 'ARBO? (L'')', 43, 43016, 43016, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(61, 'LLACUNETA (LA)', 'ARBO? (L'')', 43, 43016, 43016, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(62, 'ARGENTERA (L'')', 'ARGENTERA (L'')', 43, 43017, 43017, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(63, 'SORT (LA)', 'ARGENTERA (L'')', 43, 43017, 43017, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(64, 'ARNES', 'ARNES', 43, 43018, 43018, '43597', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(65, 'ASCO', 'ASCO', 43, 43019, 43019, '43791', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(66, 'BANYERES DEL PENEDES', 'BANYERES DEL PENEDES', 43, 43020, 43020, '43711', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(67, 'BARRI DE SAIFORES', 'BANYERES DEL PENEDES', 43, 43020, 43020, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(68, 'MASIES DE SANT MIQUEL', 'BANYERES DEL PENEDES', 43, 43020, 43020, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(69, 'ZONA RESIDENCIAL BOSCOS', 'BANYERES DEL PENEDES', 43, 43020, 43020, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(70, 'URBANITZACIO CASA ROJA', 'BANYERES DEL PENEDES', 43, 43020, 43020, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(71, 'PRIORAT DE BANYERES', 'BANYERES DEL PENEDES', 43, 43020, 43020, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(72, 'BARBERA DE LA CONCA', 'BARBERA DE LA CONCA', 43, 43021, 43021, '43422', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(73, 'OLLERS', 'BARBERA DE LA CONCA', 43, 43021, 43021, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(74, 'BATEA', 'BATEA', 43, 43022, 43022, '43786', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(75, 'BELLMUNT DEL PRIORAT', 'BELLMUNT DEL PRIORAT', 43, 43023, 43023, '43205', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(76, 'BELLVEI', 'BELLVEI', 43, 43024, 43024, '43719', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(77, 'BENIFALLET', 'BENIFALLET', 43, 43025, 43025, '43512', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(78, 'BENISSANET', 'BENISSANET', 43, 43026, 43026, '43747', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(79, 'BISBAL DE FALSET (LA)', 'BISBAL DE FALSET (LA)', 43, 43027, 43027, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(80, 'BISBAL DEL PENEDES (LA)', 'BISBAL DEL PENEDES (LA)', 43, 43028, 43028, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(81, 'CAN GORDEI', 'BISBAL DEL PENEDES (LA)', 43, 43028, 43028, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(82, 'ESPLAI DEL PENEDES (L'')', 'BISBAL DEL PENEDES (LA)', 43, 43028, 43028, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(83, 'MIRALBA (LA)', 'BISBAL DEL PENEDES (LA)', 43, 43028, 43028, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(84, 'ORTIGOS (L'')', 'BISBAL DEL PENEDES (LA)', 43, 43028, 43028, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(85, 'PAPAGAI (EL)', 'BISBAL DEL PENEDES (LA)', 43, 43028, 43028, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(86, 'PINEDA SANTA CRISTINA (LA)', 'BISBAL DEL PENEDES (LA)', 43, 43028, 43028, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(87, 'PRIORAT DE LA BISBAL (EL)', 'BISBAL DEL PENEDES (LA)', 43, 43028, 43028, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(88, 'MASIETA (LA)', 'BISBAL DEL PENEDES (LA)', 43, 43028, 43028, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(89, 'BLANCAFORT', 'BLANCAFORT', 43, 43029, 43029, '43411', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(90, 'BONASTRE', 'BONASTRE', 43, 43030, 43030, '43884', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(91, 'VINYA', 'BONASTRE', 43, 43030, 43030, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(92, 'FONT DE LA GAVATXA (LA)', 'BONASTRE', 43, 43030, 43030, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(93, 'BORGES DEL CAMP (LES)', 'BORGES DEL CAMP (LES)', 43, 43031, 43031, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(94, 'BOT', 'BOT', 43, 43032, 43032, '43785', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(95, 'BOTARELL', 'BOTARELL', 43, 43033, 43033, '43202', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(96, 'COSTES (LES)', 'BOTARELL', 43, 43033, 43033, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(97, 'BRAFIM', 'BRAFIM', 43, 43034, 43034, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(98, 'CABACES', 'CABACES', 43, 43035, 43035, '43373', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(99, 'CABRA DEL CAMP', 'CABRA DEL CAMP', 43, 43036, 43036, '43811', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(100, 'MAS DEL PLATA', 'CABRA DEL CAMP', 43, 43036, 43036, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(101, 'MIRALCAMP-RESIDENCIAL', 'CABRA DEL CAMP', 43, 43036, 43036, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(102, 'CAN RUI', 'CABRA DEL CAMP', 43, 43036, 43036, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(103, 'BELLAMAR', 'CALAFELL', 43, 43037, 43037, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(104, 'CALAFELL', 'CALAFELL', 43, 43037, 43037, '43820', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(105, 'PLATJA DE CALAFELL', 'CALAFELL', 43, 43037, 43037, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(106, 'SEGUR DE CALAFELL', 'CALAFELL', 43, 43037, 43037, '43882', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(107, 'BONANOVA', 'CALAFELL', 43, 43037, 43037, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(108, 'ARDIACA', 'CAMBRILS', 43, 43038, 43038, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(109, 'CAMBRILS', 'CAMBRILS', 43, 43038, 43038, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(110, 'LLOSA (LA)', 'CAMBRILS', 43, 43038, 43038, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(111, 'MAS D''EN BOSCH', 'CAMBRILS', 43, 43038, 43038, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(112, 'PARC SAMA', 'CAMBRILS', 43, 43038, 43038, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(113, 'VILAFORTUNY', 'CAMBRILS', 43, 43038, 43038, '43205', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(114, 'CAPAFONTS', 'CAPAFONTS', 43, 43039, 43040, '43364', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(115, 'CAPĒANES', 'CAP?ANES', 43, 43040, 43041, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(116, 'CASERES', 'CASERES', 43, 43041, 43042, '43787', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(117, 'CASTELLVELL DEL CAMP', 'CASTELLVELL DEL CAMP', 43, 43042, 43043, '43392', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(118, 'PLANES DEL PUIG (LES)', 'CASTELLVELL DEL CAMP', 43, 43042, 43043, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(119, 'PUGETS (ELS)', 'CASTELLVELL DEL CAMP', 43, 43042, 43043, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(120, 'SERRES', 'CASTELLVELL DEL CAMP', 43, 43042, 43043, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(121, 'FLOR DEL CAMP', 'CASTELLVELL DEL CAMP', 43, 43042, 43043, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(122, 'ARBOCERES (LES)', 'CASTELLVELL DEL CAMP', 43, 43042, 43043, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(123, 'CASTELLMOSTER', 'CASTELLVELL DEL CAMP', 43, 43042, 43043, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(124, 'PINAR IV FASE (EL)', 'CASTELLVELL DEL CAMP', 43, 43042, 43043, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(125, 'CATLLAR (EL)', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(126, 'BONAIGUA', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(127, 'BONAIRE', 'CATLLAR (EL)', 43, 43043, 43044, '43202', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(128, 'COLL DE TAPIOLES', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(129, 'CATIVERA (LA)', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(130, 'COCONS (ELS)', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(131, 'ESPLAI TARRAGONI', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(132, 'MAS DE BLANC', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(133, 'MAS DE CARGOL', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(134, 'MAS VILET DELS PINS', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(135, 'MEDOL (EL)', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(136, 'PINALBERT', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(137, 'MANOUS', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(138, 'SANT ROC', 'CATLLAR (EL)', 43, 43043, 43044, '43203', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(139, 'MAS DE COSME', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(140, 'MAS DE GEREMBI', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(141, 'MAS DE PANXE', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(142, 'RESIDENCIAL 5 ESTRELLES', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(143, 'SANTA TECLA', 'CATLLAR (EL)', 43, 43043, 43044, '43003', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(144, 'MASIETA DE SALORT', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(145, 'URBANITZACIO PARC DE LLEVANT', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(146, 'MAS DE MOREGONS', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(147, 'QUADRA (LA)', 'CATLLAR (EL)', 43, 43043, 43044, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(148, 'SENIA (LA)', 'SENIA (LA)', 43, 43044, 43045, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(149, 'PLANS (ELS)', 'SENIA (LA)', 43, 43044, 43045, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(150, 'COLLDEJOU', 'COLLDEJOU', 43, 43045, 43046, '43204', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(151, 'CONESA', 'CONESA', 43, 43046, 43047, '43427', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(152, 'CONSTANTI', 'CONSTANTI', 43, 43047, 43048, '43204', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(153, 'CORBERA D''EBRE', 'CORBERA D''EBRE', 43, 43048, 43049, '43784', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(154, 'ALBARCA', 'CORNUDELLA DE MONTSANT', 43, 43049, 43050, '43360', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(155, 'SIURANA', 'CORNUDELLA DE MONTSANT', 43, 43049, 43050, '43206', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(156, 'CORNUDELLA DE MONTSANT', 'CORNUDELLA DE MONTSANT', 43, 43049, 43050, '43360', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(157, 'CREIXELL', 'CREIXELL', 43, 43050, 43051, '43839', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(158, 'COMA (LA)', 'CREIXELL', 43, 43050, 43051, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(159, 'CREIXELL-MAR', 'CREIXELL', 43, 43050, 43051, '43839', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(160, 'ERES (LES)', 'CREIXELL', 43, 43050, 43051, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(161, 'MARINA DE CREIXELL', 'CREIXELL', 43, 43050, 43051, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(162, 'MASSO (LA)', 'CREIXELL', 43, 43050, 43051, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(163, 'MORISQUES (LES)', 'CREIXELL', 43, 43050, 43051, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(164, 'PLANA (LA)', 'CREIXELL', 43, 43050, 43051, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(165, 'PORT-ROMA', 'CREIXELL', 43, 43050, 43051, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(166, 'RACO DEL CESAR', 'CREIXELL', 43, 43050, 43051, '43839', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(167, 'SINIES (LES)', 'CREIXELL', 43, 43050, 43051, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(168, 'CUNIT', 'CUNIT', 43, 43051, 43052, '43881', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(169, 'XERTA', 'XERTA', 43, 43052, 43053, '43592', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(170, 'DUESAIGUES', 'DUESAIGUES', 43, 43053, 43054, '43202', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(171, 'BALNEARI LES MASIES', 'ESPLUGA DE FRANCOLI (L'')', 43, 43054, 43055, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(172, 'ESPLUGA DE FRANCOLI (L'')', 'ESPLUGA DE FRANCOLI (L'')', 43, 43054, 43055, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(173, 'ESTACIO (L'')', 'ESPLUGA DE FRANCOLI (L'')', 43, 43054, 43055, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(174, 'SANTISSIMA TRINITAT', 'ESPLUGA DE FRANCOLI (L'')', 43, 43054, 43055, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(175, 'FALSET', 'FALSET', 43, 43055, 43056, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(176, 'CAMPOSINES', 'FATARELLA (LA)', 43, 43056, 43057, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(177, 'FATARELLA (LA)', 'FATARELLA (LA)', 43, 43056, 43057, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(178, 'FEBRO (LA)', 'FEBRO (LA)', 43, 43057, 43058, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(179, 'FIGUERA (LA)', 'FIGUERA (LA)', 43, 43058, 43059, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(180, 'FIGUEROLA DEL CAMP', 'FIGUEROLA DEL CAMP', 43, 43059, 43060, '43811', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(181, 'COLONIA FABRICA', 'FLIX', 43, 43060, 43061, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(182, 'COMELLARETS', 'FLIX', 43, 43060, 43061, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(183, 'FLIX', 'FLIX', 43, 43060, 43061, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(184, 'FORES', 'FORES', 43, 43061, 43062, '43425', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(185, 'FREGINALS', 'FREGINALS', 43, 43062, 43063, '43558', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(186, 'GALERA (LA)', 'GALERA (LA)', 43, 43063, 43064, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(187, 'GANDESA', 'GANDESA', 43, 43064, 43065, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(188, 'GARCIA', 'GARCIA', 43, 43065, 43066, '43749', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(189, 'GARIDELLS (ELS)', 'GARIDELLS (ELS)', 43, 43066, 43067, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(190, 'GINESTAR', 'GINESTAR', 43, 43067, 43068, '43748', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(191, 'GODALL', 'GODALL', 43, 43068, 43069, '43516', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(192, 'GRATALLOPS', 'GRATALLOPS', 43, 43069, 43070, '43737', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(193, 'GUIAMETS (ELS)', 'GUIAMETS (ELS)', 43, 43070, 43071, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(194, 'HORTA DE SANT JOAN', 'HORTA DE SANT JOAN', 43, 43071, 43072, '43596', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(195, 'MONCADES', 'HORTA DE SANT JOAN', 43, 43071, 43072, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(196, 'LLOAR (EL)', 'LLOAR (EL)', 43, 43072, 43073, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(197, 'LLORAC', 'LLORAC', 43, 43073, 43074, '43427', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(198, 'ALBIO', 'LLORAC', 43, 43073, 43074, '43427', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(199, 'CIRERA (LA)', 'LLORAC', 43, 43073, 43074, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(200, 'RAURIC', 'LLORAC', 43, 43073, 43074, '43427', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(201, 'LLORENĒ DEL PENEDES', 'LLOREN? DEL PENEDES', 43, 43074, 43075, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(202, 'PRIORAT DE BANYERES', 'LLOREN? DEL PENEDES', 43, 43074, 43075, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(203, 'MARGALEF', 'MARGALEF', 43, 43075, 43076, '43371', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(204, 'COMES (LES)', 'MAR?A', 43, 43076, 43077, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(205, 'MARĒA', 'MAR?A', 43, 43076, 43077, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(206, 'VERINXELL (EL)', 'MAR?A', 43, 43076, 43077, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(207, 'MAS DE BARBERANS', 'MAS DE BARBERANS', 43, 43077, 43078, '43514', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(208, 'MASDENVERGE', 'MASDENVERGE', 43, 43078, 43079, '43878', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(209, 'MASARBONES', 'MASLLOREN?', 43, 43079, 43080, '43718', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(210, 'MASLLORENĒ', 'MASLLOREN?', 43, 43079, 43080, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(211, 'FONT D''EN TALLO', 'MASLLOREN?', 43, 43079, 43080, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(212, 'MASO (LA)', 'MASO (LA)', 43, 43080, 43081, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(213, 'MASPUJOLS', 'MASPUJOLS', 43, 43081, 43082, '43206', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(214, 'ROCABRUNA', 'MASPUJOLS', 43, 43081, 43082, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(215, 'MASROIG (EL)', 'MASROIG (EL)', 43, 43082, 43083, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(216, 'MILA (EL)', 'MILA (EL)', 43, 43083, 43084, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(217, 'MIRAVET', 'MIRAVET', 43, 43084, 43085, '43747', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(218, 'MOLAR (EL)', 'MOLAR (EL)', 43, 43085, 43086, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(219, 'GUARDIA DELS PRATS', 'MONTBLANC', 43, 43086, 43087, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(220, 'LILLA', 'MONTBLANC', 43, 43086, 43087, '43414', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(221, 'MONTBLANC', 'MONTBLANC', 43, 43086, 43087, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(222, 'PINATELL', 'MONTBLANC', 43, 43086, 43087, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(223, 'PRENAFETA', 'MONTBLANC', 43, 43086, 43087, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(224, 'ROJALS', 'MONTBLANC', 43, 43086, 43087, '43415', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(225, 'MONTBRIO DEL CAMP', 'MONTBRIO DEL CAMP', 43, 43088, 43089, '43340', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(226, 'MONTFERRI', 'MONTFERRI', 43, 43089, 43090, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(227, 'VILARDIDA', 'MONTFERRI', 43, 43089, 43090, '43812', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(228, 'AIGUAVIVA', 'MONTMELL (EL)', 43, 43090, 43091, '43714', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(229, 'CANFERRE', 'MONTMELL (EL)', 43, 43090, 43091, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(230, 'JUNCOSA DE MONTMELL', 'MONTMELL (EL)', 43, 43090, 43091, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(231, 'MAS MATEU', 'MONTMELL (EL)', 43, 43090, 43091, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(232, 'URBANITZACIO LA MOIXETA', 'MONTMELL (EL)', 43, 43090, 43091, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(233, 'URBANITZACIO ATALAYA MEDITERRANEA', 'MONTMELL (EL)', 43, 43090, 43091, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(234, 'URBANITZACIO EL MIRADOR DEL PENEDES', 'MONTMELL (EL)', 43, 43090, 43091, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(235, 'URBANITZACIO PINEDAS ALTAS', 'MONTMELL (EL)', 43, 43090, 43091, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(236, 'AIXABIGA (L'')', 'MONT-RAL', 43, 43091, 43092, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(237, 'BOSQUET (EL)', 'MONT-RAL', 43, 43091, 43092, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(238, 'CABRERA (LA)', 'MONT-RAL', 43, 43091, 43092, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(239, 'CADENETA (LA)', 'MONT-RAL', 43, 43091, 43092, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(240, 'FARENA', 'MONT-RAL', 43, 43091, 43092, '43459', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(241, 'MONT-RAL', 'MONT-RAL', 43, 43091, 43092, '43205', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(242, 'MIAMI PLATJA', 'MONT-ROIG DEL CAMP', 43, 43092, 43093, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(243, 'MONT-ROIG DEL CAMP', 'MONT-ROIG DEL CAMP', 43, 43092, 43093, '43300', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(244, 'POBLES (LES)', 'MONT-ROIG DEL CAMP', 43, 43092, 43093, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(245, 'MORA D''EBRE', 'MORA D''EBRE', 43, 43093, 43094, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(246, 'MORA LA NOVA', 'MORA LA NOVA', 43, 43094, 43095, '43770', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(247, 'MORELL (EL)', 'MORELL (EL)', 43, 43095, 43096, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(248, 'MORERA DE MONTSANT (LA)', 'MORERA DE MONTSANT (LA)', 43, 43096, 43097, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(249, 'SCALA-DEI', 'MORERA DE MONTSANT (LA)', 43, 43096, 43097, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(250, 'NOU DE GAIA (LA)', 'NOU DE GAIA (LA)', 43, 43097, 43099, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(251, 'BELLAVISTA', 'NULLES', 43, 43098, 43100, '43202', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(252, 'CASAFORT', 'NULLES', 43, 43098, 43100, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(253, 'NULLES', 'NULLES', 43, 43098, 43100, '43887', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(254, 'PALMA D''EBRE (LA)', 'PALMA D''EBRE (LA)', 43, 43099, 43101, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(255, 'HOSTALETS', 'PALLARESOS (ELS)', 43, 43100, 43102, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(256, 'PALLARESOS (ELS)', 'PALLARESOS (ELS)', 43, 43100, 43102, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(257, 'PALLARESOS PARK', 'PALLARESOS (ELS)', 43, 43100, 43102, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(258, 'JARDINS IMPERI', 'PALLARESOS (ELS)', 43, 43100, 43102, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(259, 'BELLTALL', 'PASSANANT I BELLTALL', 43, 43101, 43103, '43413', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(260, 'FONOLL', 'PASSANANT I BELLTALL', 43, 43101, 43103, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(261, 'GLORIETA', 'PASSANANT I BELLTALL', 43, 43101, 43103, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(262, 'PASSANANT', 'PASSANANT I BELLTALL', 43, 43101, 43103, '43425', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(263, 'POBLA DE FARRAN', 'PASSANANT I BELLTALL', 43, 43101, 43103, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(264, 'SALA (LA)', 'PASSANANT I BELLTALL', 43, 43101, 43103, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(265, 'PAULS', 'PAULS', 43, 43102, 43104, '43593', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(266, 'PERAFORT', 'PERAFORT', 43, 43103, 43105, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(267, 'PUIGDELFI', 'PERAFORT', 43, 43103, 43105, '43155', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(268, 'PERELLO (EL)', 'PERELLO (EL)', 43, 43104, 43106, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(269, 'BIURE DE GAIA', 'PILES (LES)', 43, 43105, 43107, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(270, 'GUIALMONS', 'PILES (LES)', 43, 43105, 43107, '43429', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(271, 'PILES (LES)', 'PILES (LES)', 43, 43105, 43107, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(272, 'SANT GALLARD', 'PILES (LES)', 43, 43105, 43107, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(273, 'PINELL DE BRAI (EL)', 'PINELL DE BRAI (EL)', 43, 43106, 43108, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(274, 'PIRA', 'PIRA', 43, 43107, 43109, '43423', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(275, 'PLA DE SANTA MARIA (EL)', 'PLA DE SANTA MARIA (EL)', 43, 43108, 43110, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(276, 'POBLA DE MAFUMET (LA)', 'POBLA DE MAFUMET (LA)', 43, 43109, 43111, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(277, 'POBLA DE MASSALUCA (LA)', 'POBLA DE MASSALUCA (LA)', 43, 43110, 43112, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(278, 'POBLA DE MONTORNES (LA)', 'POBLA DE MONTORNES (LA)', 43, 43111, 43113, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(279, 'URBANITZACIO CASTELL DE MONTORNES', 'POBLA DE MONTORNES (LA)', 43, 43111, 43113, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(280, 'URBANITZACIO POBLAMAR', 'POBLA DE MONTORNES (LA)', 43, 43111, 43113, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(281, 'FLOR DE ALMENDRO (URBANITZACIO)', 'POBLA DE MONTORNES (LA)', 43, 43111, 43113, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(282, 'URBANITZACIO EIXAMPLE-LLEVANT', 'POBLA DE MONTORNES (LA)', 43, 43111, 43113, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(283, 'POBOLEDA', 'POBOLEDA', 43, 43112, 43114, '43206', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(284, 'PONT D''ARMENTERA (EL)', 'PONT D''ARMENTERA (EL)', 43, 43113, 43115, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(285, 'PORRERA', 'PORRERA', 43, 43114, 43116, '43205', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(286, 'ESTACION (LA)', 'PRADELL DE LA TEIXETA', 43, 43115, 43117, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(287, 'PRADELL', 'PRADELL DE LA TEIXETA', 43, 43115, 43117, '43774', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(288, 'TORRE (LA)', 'PRADELL DE LA TEIXETA', 43, 43115, 43117, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(289, 'PRADES', 'PRADES', 43, 43116, 43118, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(290, 'PRAT DE COMTE', 'PRAT DE COMTE', 43, 43117, 43119, '43595', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(291, 'PLANAS DEL REY', 'PRATDIP', 43, 43118, 43120, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(292, 'PRATDIP', 'PRATDIP', 43, 43118, 43120, '43206', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(293, 'SANTA MARINA', 'PRATDIP', 43, 43118, 43120, '43321', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(294, 'PUIGPELAT', 'PUIGPELAT', 43, 43119, 43121, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(295, 'PARTIDA SANT JOAN DE RUANES', 'PUIGPELAT', 43, 43119, 43121, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(296, 'URBANITZACIO ELS ARCS', 'PUIGPELAT', 43, 43119, 43121, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(297, 'URBANITZACIO LA PLANELLA', 'PUIGPELAT', 43, 43119, 43121, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(298, 'URBANITZACIO LES BOVERES', 'PUIGPELAT', 43, 43119, 43121, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(299, 'URBANITZACIO LA SINIA', 'PUIGPELAT', 43, 43119, 43121, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(300, 'URBANITZACIO PUIGNOU', 'PUIGPELAT', 43, 43119, 43121, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(301, 'ESBLADA', 'QUEROL', 43, 43120, 43122, '43816', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(302, 'QUEROL', 'QUEROL', 43, 43120, 43122, '43816', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(303, 'VALLDOSSERA', 'QUEROL', 43, 43120, 43122, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(304, 'RASQUERA', 'RASQUERA', 43, 43121, 43123, '43513', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(305, 'RENAU', 'RENAU', 43, 43122, 43124, '43886', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(306, 'REUS', 'REUS', 43, 43123, 43125, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(307, 'MAS CARPA', 'REUS', 43, 43123, 43125, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(308, 'PELAYO', 'REUS', 43, 43123, 43125, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(309, 'PINAR (EL)', 'REUS', 43, 43123, 43125, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(310, 'SANT JOAN', 'REUS', 43, 43123, 43125, '43201', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(311, 'SOL I VISTA', 'REUS', 43, 43123, 43125, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(312, 'RIBA (LA)', 'RIBA (LA)', 43, 43124, 43126, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(313, 'HORTASSES (LES)', 'RIBA (LA)', 43, 43124, 43126, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(314, 'RIBA-ROJA D''EBRE', 'RIBA-ROJA D''EBRE', 43, 43125, 43127, '43790', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(315, 'ARDENYA', 'RIERA DE GAIA (LA)', 43, 43126, 43128, '43762', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(316, 'RIERA DE GAIA (LA)', 'RIERA DE GAIA (LA)', 43, 43126, 43128, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(317, 'CASTELLOT (EL)', 'RIERA DE GAIA (LA)', 43, 43126, 43128, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(318, 'CASAS DE VIRGILI', 'RIERA DE GAIA (LA)', 43, 43126, 43128, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(319, 'URBANITZACIO RESIDENCIAL LA RIERA', 'RIERA DE GAIA (LA)', 43, 43126, 43128, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(320, 'RIUDECANYES', 'RIUDECANYES', 43, 43127, 43129, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(321, 'MAR DE RIUDECANYES', 'RIUDECANYES', 43, 43127, 43129, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(322, 'MONTCLAR', 'RIUDECANYES', 43, 43127, 43129, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(323, 'IRLES (LES)', 'RIUDECOLS', 43, 43128, 43130, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(324, 'RIUDECOLS', 'RIUDECOLS', 43, 43128, 43130, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(325, 'VOLTES (LES)', 'RIUDECOLS', 43, 43128, 43130, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(326, 'URBANIZACION RIU-CLUB', 'RIUDECOLS', 43, 43128, 43130, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(327, 'RIUDOMS', 'RIUDOMS', 43, 43129, 43131, '43330', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(328, 'ROCAFORT DE QUERALT', 'ROCAFORT DE QUERALT', 43, 43130, 43132, '43426', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(329, 'RODA DE BARA', 'RODA DE BARA', 43, 43131, 43133, '43883', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(330, 'ZONA COSTERA', 'RODA DE BARA', 43, 43131, 43133, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(331, 'BARAMAR', 'RODA DE BARA', 43, 43131, 43133, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(332, 'EIXAMPLE RESIDENCIAL', 'RODA DE BARA', 43, 43131, 43133, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(333, 'MARTORELLA (LA)', 'RODA DE BARA', 43, 43131, 43133, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(334, 'FRANCASET (EL)', 'RODA DE BARA', 43, 43131, 43133, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(335, 'RODONYA', 'RODONYA', 43, 43132, 43134, '43812', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(336, 'RAVAL DE CRISTO', 'ROQUETES', 43, 43133, 43135, '43529', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(337, 'ROQUETES', 'ROQUETES', 43, 43133, 43135, '43520', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(338, 'ROURELL (EL)', 'ROURELL (EL)', 43, 43134, 43136, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00');
INSERT INTO `locality` (`locality_id`, `locality_name`, `locality_parent_locality_id`, `locality_state_id`, `locality_ine_id`, `locality_aeat_id`, `locality_postal_code`, `entryDate`, `last_update`, `creationUserId`, `lastupdateUserId`, `markedForDeletion`, `markedForDeletionDate`) VALUES
(339, 'SALOMO', 'SALOMO', 43, 43135, 43137, '43885', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(340, 'SALINES DE LA TRINITAT', 'SANT CARLES DE LA RAPITA', 43, 43136, 43138, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(341, 'SANT CARLES DE LA RAPITA', 'SANT CARLES DE LA RAPITA', 43, 43136, 43138, '43540', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(342, 'CARRONYA (LA)', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(343, 'CORNUDELLA', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(344, 'HOSTAL (L'')', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(345, 'LLETGER', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(346, 'PAPIOLET (EL)', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(347, 'SANT JAUME DELS DOMENYS', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '43713', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(348, 'TORREGASSA (LA)', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(349, 'ARQUET (L'')', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(350, 'ARQUETS (ELS)', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(351, 'PAPAGAI (EL)', 'SANT JAUME DELS DOMENYS', 43, 43137, 43139, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(352, 'SANTA BARBARA', 'SANTA BARBARA', 43, 43138, 43140, '43570', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(353, 'AGUILO', 'SANTA COLOMA DE QUERALT', 43, 43139, 43141, '43429', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(354, 'POBLA (LA)', 'SANTA COLOMA DE QUERALT', 43, 43139, 43141, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(355, 'ROQUES (LES)', 'SANTA COLOMA DE QUERALT', 43, 43139, 43141, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(356, 'SANTA COLOMA DE QUERALT', 'SANTA COLOMA DE QUERALT', 43, 43139, 43141, '43420', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(357, 'CAMI MOLINS', 'SANTA OLIVA', 43, 43140, 43142, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(358, 'RESIDENCIAL SANT JORDI', 'SANTA OLIVA', 43, 43140, 43142, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(359, 'SANTA OLIVA', 'SANTA OLIVA', 43, 43140, 43142, '43710', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(360, 'PEDRERES (LES)', 'SANTA OLIVA', 43, 43140, 43142, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(361, 'CARRETERA VENDRELL', 'SANTA OLIVA', 43, 43140, 43142, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(362, 'ARBORNAR (L'')', 'SANTA OLIVA', 43, 43140, 43142, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(363, 'MOLI D''EN SERRA', 'SANTA OLIVA', 43, 43140, 43142, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(364, 'PONTILS', 'PONTILS', 43, 43141, 43143, '43421', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(365, 'SANT MAGI DE ROCAMORA', 'PONTILS', 43, 43141, 43143, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(366, 'SANTA PERPETUA DE GAIA', 'PONTILS', 43, 43141, 43143, '43421', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(367, 'SEGUER', 'PONTILS', 43, 43141, 43143, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(368, 'VALLESPINOSA', 'PONTILS', 43, 43141, 43143, '43428', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(369, 'VILADEPERDIUS', 'PONTILS', 43, 43141, 43143, '43421', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(370, 'VALLDEPERES', 'PONTILS', 43, 43141, 43143, '43421', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(371, 'MONTBRIO DE LA MARCA', 'SARRAL', 43, 43142, 43144, '43425', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(372, 'SARRAL', 'SARRAL', 43, 43142, 43144, '43424', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(373, 'VALLVERD', 'SARRAL', 43, 43142, 43144, '43428', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(374, 'BARRI DE SEGURA', 'SAVALLA DEL COMTAT', 43, 43143, 43145, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(375, 'SAVALLA DEL COMTAT', 'SAVALLA DEL COMTAT', 43, 43143, 43145, '43427', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(376, 'ARGILAGA (L'')', 'SECUITA (LA)', 43, 43144, 43146, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(377, 'GUNYOLES (LES)', 'SECUITA (LA)', 43, 43144, 43146, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(378, 'SANT ROC', 'SECUITA (LA)', 43, 43144, 43146, '43203', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(379, 'SECUITA (LA)', 'SECUITA (LA)', 43, 43144, 43146, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(380, 'VISTABELLA', 'SECUITA (LA)', 43, 43144, 43146, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(381, 'PARET-DELGADA', 'SELVA DEL CAMP (LA)', 43, 43145, 43147, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(382, 'SANT PERE', 'SELVA DEL CAMP (LA)', 43, 43145, 43147, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(383, 'SELVA DEL CAMP (LA)', 'SELVA DEL CAMP (LA)', 43, 43145, 43147, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(384, 'SENAN', 'SENAN', 43, 43146, 43148, '43449', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(385, 'SOLIVELLA', 'SOLIVELLA', 43, 43147, 43149, '43412', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(386, 'BONAVISTA', 'TARRAGONA', 43, 43148, 43900, '43100', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(387, 'CAMPSA', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(388, 'FERRAN', 'TARRAGONA', 43, 43148, 43900, '43008', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(389, 'MONNARS', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(390, 'MONTGONS (ELS)', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(391, 'OLIVA (L'')', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(392, 'PINEDES (LES)', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(393, 'ARRABASSADA I SAVINOSA', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(394, 'SANT PERE I SANT PAU', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(395, 'SANT SALVADOR', 'TARRAGONA', 43, 43148, 43900, '43130', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(396, 'TAMARIT', 'TARRAGONA', 43, 43148, 43900, '43008', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(397, 'TARRAGONA', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(398, 'TORREFORTA', 'TARRAGONA', 43, 43148, 43900, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(399, 'BOSCOS DE TARRAGONA (ELS)', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(400, 'CALA ROMANA', 'TARRAGONA', 43, 43148, 43900, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(401, 'TIVENYS', 'TIVENYS', 43, 43149, 43151, '43511', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(402, 'DARMOS', 'TIVISSA', 43, 43150, 43152, '43746', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(403, 'SERRA D''ALMOS (LA)', 'TIVISSA', 43, 43150, 43152, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(404, 'TIVISSA', 'TIVISSA', 43, 43150, 43152, '43206', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(405, 'LLABERIA', 'TIVISSA', 43, 43150, 43152, '43205', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(406, 'TORRE DE FONTAUBELLA (LA)', 'TORRE DE FONTAUBELLA (LA)', 43, 43151, 43153, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(407, 'TORRE DE L''ESPANYOL (LA)', 'TORRE DE L''ESPANYOL (LA)', 43, 43152, 43154, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(408, 'TORREDEMBARRA', 'TORREDEMBARRA', 43, 43153, 43155, '43830', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(409, 'TORROJA DEL PRIORAT', 'TORROJA DEL PRIORAT', 43, 43154, 43156, '43737', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(410, 'JESUS', 'TORTOSA', 43, 43155, 43157, '43201', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(411, 'BITEM', 'TORTOSA', 43, 43155, 43157, '43510', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(412, 'CAMPREDO', 'TORTOSA', 43, 43155, 43157, '43897', '0000-00-00 00:00:00', '2013-10-19 09:41:16', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(413, 'REGUERS (ELS)', 'TORTOSA', 43, 43155, 43157, '43527', '0000-00-00 00:00:00', '2013-10-19 09:41:42', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(414, 'TORTOSA', 'TORTOSA', 43, 43155, 43157, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(415, 'VINALLOP', 'TORTOSA', 43, 43155, 43157, '43517', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(416, 'CASTELL (EL)', 'ULLDECONA', 43, 43156, 43158, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(417, 'SANT JOAN DEL PAS', 'ULLDECONA', 43, 43156, 43158, '43559', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(418, 'ULLDECONA', 'ULLDECONA', 43, 43156, 43158, '43550', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(419, 'VALENTINS (ELS)', 'ULLDECONA', 43, 43156, 43158, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(420, 'VENTALLES (LES)', 'ULLDECONA', 43, 43156, 43158, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(421, 'MILIANA (LA)', 'ULLDECONA', 43, 43156, 43158, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(422, 'ULLDEMOLINS', 'ULLDEMOLINS', 43, 43157, 43159, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(423, 'VALLCLARA', 'VALLCLARA', 43, 43158, 43160, '43439', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(424, 'VALLFOGONA DE RIUCORB', 'VALLFOGONA DE RIUCORB', 43, 43159, 43161, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(425, 'VALLMOLL', 'VALLMOLL', 43, 43160, 43162, '43144', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(426, 'URBANITZACIO VALLMOLL-PARADIS', 'VALLMOLL', 43, 43160, 43162, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(427, 'FONTSCALDES', 'VALLS', 43, 43161, 43163, '43813', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(428, 'MASMOLETS', 'VALLS', 43, 43161, 43163, '43813', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(429, 'PICAMOIXONS', 'VALLS', 43, 43161, 43163, '43491', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(430, 'VALLS', 'VALLS', 43, 43161, 43163, '43800', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(431, 'HOSPITALET DE L''INFANT (L'')', 'VANDELLOS I L''HOSPITALET DE L''INFANT', 43, 43162, 43164, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(432, 'MASBOQUERA', 'VANDELLOS I L''HOSPITALET DE L''INFANT', 43, 43162, 43164, '43891', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(433, 'MASRIUDOMS', 'VANDELLOS I L''HOSPITALET DE L''INFANT', 43, 43162, 43164, '43891', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(434, 'VANDELLOS', 'VANDELLOS I L''HOSPITALET DE L''INFANT', 43, 43162, 43164, '43206', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(435, 'ALMADRAVA (L'')', 'VANDELLOS I L''HOSPITALET DE L''INFANT', 43, 43162, 43164, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(436, 'BARRI MARITIM DE SANT SALVADOR', 'VENDRELL (EL)', 43, 43163, 43165, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(437, 'BARRI MARITIM DE COMA-RUGA', 'VENDRELL (EL)', 43, 43163, 43165, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(438, 'ESTACIO SANT VICENĒ DE CALDERS', 'VENDRELL (EL)', 43, 43163, 43165, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(439, 'SANT VICENĒ DE CALDERS', 'VENDRELL (EL)', 43, 43163, 43165, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(440, 'SANATORI (EL)', 'VENDRELL (EL)', 43, 43163, 43165, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(441, 'VENDRELL (EL)', 'VENDRELL (EL)', 43, 43163, 43165, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(442, 'BARRI MARITIM DEL FRANCAS', 'VENDRELL (EL)', 43, 43163, 43165, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(443, 'MASOS DE VESPELLA', 'VESPELLA DE GAIA', 43, 43164, 43166, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(444, 'VESPELLA', 'VESPELLA DE GAIA', 43, 43164, 43166, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(445, 'SANT MIQUEL', 'VESPELLA DE GAIA', 43, 43164, 43166, '43201', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(446, 'COMA (LA)', 'VESPELLA DE GAIA', 43, 43164, 43166, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(447, 'VILABELLA', 'VILABELLA', 43, 43165, 43167, '43886', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(448, 'VILALLONGA DEL CAMP', 'VILALLONGA DEL CAMP', 43, 43166, 43168, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(449, 'ARBOCET (L'')', 'VILANOVA D''ESCORNALBOU', 43, 43167, 43169, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(450, 'VILANOVA D''ESCORNALBOU', 'VILANOVA D''ESCORNALBOU', 43, 43167, 43169, '43203', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(451, 'VILANOVA DE PRADES', 'VILANOVA DE PRADES', 43, 43168, 43170, '43439', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(452, 'VILAPLANA', 'VILAPLANA', 43, 43169, 43171, '43380', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(453, 'VILARDIDA', 'VILA-RODONA', 43, 43170, 43172, '43812', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(454, 'VILA-RODONA', 'VILA-RODONA', 43, 43170, 43172, '43814', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(455, 'MAS D''EN BOSC', 'VILA-RODONA', 43, 43170, 43172, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(456, 'PINEDA (LA)', 'VILA-SECA', 43, 43171, 43173, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(457, 'PLANA (LA)', 'VILA-SECA', 43, 43171, 43173, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(458, 'VILA-SECA', 'VILA-SECA', 43, 43171, 43173, '43480', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(459, 'VILAVERD', 'VILAVERD', 43, 43172, 43174, '43490', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(460, 'VILELLA ALTA (LA)', 'VILELLA ALTA (LA)', 43, 43173, 43175, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(461, 'VILELLA BAIXA (LA)', 'VILELLA BAIXA (LA)', 43, 43174, 43176, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(462, 'VILALBA DELS ARCS', 'VILALBA DELS ARCS', 43, 43175, 43177, '43782', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(463, 'VIMBODI I POBLET', 'VIMBODI I POBLET', 43, 43176, 43178, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(464, 'VINEBRE', 'VINEBRE', 43, 43177, 43179, '43206', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(465, 'VINYOLS I ELS ARCS', 'VINYOLS I ELS ARCS', 43, 43178, 43180, '43391', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(466, 'SANT JOAN DELS ARCS', 'VINYOLS I ELS ARCS', 43, 43178, 43180, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(467, 'DELTEBRE', 'DELTEBRE', 43, 43901, 43181, '43006', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(468, 'MUNTELLS (ELS)', 'SANT JAUME D''ENVEJA', 43, 43902, 43182, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(469, 'SANT JAUME D''ENVEJA', 'SANT JAUME D''ENVEJA', 43, 43902, 43182, '43877', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(470, 'BALADA', 'SANT JAUME D''ENVEJA', 43, 43902, 43182, '43879', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(471, 'CAMARLES', 'CAMARLES', 43, 43903, 43183, '43894', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(472, 'LIGALLO DEL GANGUIL', 'CAMARLES', 43, 43903, 43183, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(473, 'LIGALLO DEL ROIG', 'CAMARLES', 43, 43903, 43183, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(474, 'ALDEA (L'')', 'ALDEA (L'')', 43, 43904, 43184, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(475, 'SALOU', 'SALOU', 43, 43905, 43185, '43004', '0000-00-00 00:00:00', '2013-10-19 09:40:21', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(476, 'AMPOLLA (L'')', 'AMPOLLA (L'')', 43, 43906, 43186, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(477, 'CANONJA (LA)', 'CANONJA (LA)', 43, 43907, 43039, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00');

--
-- Estructura de la taula `bank`
--

CREATE TABLE IF NOT EXISTS `bank` (
  `bank_name` varchar(255) NOT NULL,
  `bank_code` varchar(4) NOT NULL,
  `bank_entryDate` datetime NOT NULL,
  `bank_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bank_creationUserId` int(11) DEFAULT NULL,
  `bank_lastupdateUserId` int(11) DEFAULT NULL,
  `bank_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `bank_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`bank_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Bolcant dades de la taula `bank`
--

INSERT INTO `bank` (`bank_name`, `bank_code`, `bank_entryDate`, `bank_last_update`, `bank_creationUserId`, `bank_lastupdateUserId`, `bank_markedForDeletion`, `bank_markedForDeletionDate`) VALUES
('SENSEBANC', '0000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, '', '0000-00-00 00:00:00'),
('BANCO DE DEPOSITOS', '0003', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('ALLFUNDS BANK', '0011', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('DEUTSCHE BANK, S.A.E.', '0019', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO ESPAÑOL DE CREDITO', '0030', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO ETCHEVERRIA', '0031', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('SANTANDER INVESTMENT', '0036', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO GALLEGO', '0046', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO SANTANDER', '0049', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DEPOSITARIO BBVA', '0057', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BNP PARIBAS ESPAÑA', '0058', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DE MADRID', '0059', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCA MARCH', '0061', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BARCLAYS BANK', '0065', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO PASTOR', '0072', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('OPEN BANK', '0073', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO POPULAR ESPAÑOL', '0075', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCA PUEYO', '0078', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DE SABADELL', '0081', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('RENTA 4 BANCO', '0083', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO BANIF', '0086', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DE ALBACETE', '0091', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('RBC INVESTOR SERVICES ESPAÑA', '0094', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('Banco De Vitoria, S.A.', '0100', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, '', '0000-00-00 00:00:00'),
('SOCIETE GENERALE', '0108', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO INDUSTRIAL DE BILBAO', '0113', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DE CASTILLA-LA MANCHA', '0115', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CITIBANK ESPAÑA', '0122', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCOFAR', '0125', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANKINTER', '0128', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BBVA BANCO DE FINANCIACION', '0129', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO CAIXA GERAL', '0130', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO ESPIRITO SANTO SUCURSAL ESPAÑA', '0131', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('NUEVO MICRO BANK', '0133', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('ARESBANK', '0136', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANKOA', '0138', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BNP PARIBAS SECURITIES SERVICES', '0144', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('DEUTSCHE BANK, A.G.', '0145', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BNP PARIBAS SUCURSAL EN ESPAÑA', '0149', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('JPMORGAN CHASE BANK N. ASSOCIATION', '0151', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BARCLAYS BANK, P.L.C.', '0152', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CREDIT AGRICOLE CORPORATE', '0154', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DO BRASIL', '0155', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('THE ROYAL BANK OF SCOTLAND PLC', '0156', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('COMMERZBANK', '0159', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('THE BANK OF TOKYO-MITSUBISHI UFJ LTD', '0160', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('HSBC BANK P.L.C.', '0162', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BNP PARIBAS FORTIS', '0167', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('ING BELGIUM', '0168', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DE LA NACION ARGENTINA', '0169', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO BILBAO VIZCAYA ARGENTARIA', '0182', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO EUROPEO DE FINANZAS', '0184', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DE MEDIOLANUM', '0186', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO ALCALA', '0188', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO BPI', '0190', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('PORTIGON AG SUCURCAL EN ESPAÑA', '0196', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO COOPERATIVO ESPAÑOL', '0198', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('PRIVAT BANK DEGROOF', '0200', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('EBN BANCO DE NEGOCIOS', '0211', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('TARGOBANK', '0216', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('FCE BANK P.L.C.', '0218', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANQUE MAROCAINE COMMERCE EXTERIEUR', '0219', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO FINANTIA SOFINLOC', '0220', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('GENERAL ELECTRIC CAPITAL BANK', '0223', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('SANTANDER CONSUMER FINANCE', '0224', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO CETELEM', '0225', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('UBS BANK', '0226', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('UNOE BANK', '0227', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCOPOPULAR-E', '0229', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('DEXIA SABADELL', '0231', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO INVERSIS', '0232', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('POPULAR BANCA PRIVADA', '0233', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO CAMINOS', '0234', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO PICHINCHA ESPAÑA', '0235', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('LLOYDS BANK INTERNATIONAL', '0236', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJASUR BANCO', '0237', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO POPULAR PASTOR', '0238', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO MARE NOSTRUM', '0487', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO FINANCIERO Y DE AHORROS', '0488', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('INSTITUTO DE CREDITO OFICIAL', '1000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAISSE REGIONALE C.AGR.MUT.SUD.MED', '1451', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('DE LAGE LANDEN INTERNATIONAL B.V.', '1457', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('RABOBANK INTERNATIONAL', '1459', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CREDIT SUISSE AG', '1460', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANQUE PSA FINANCE', '1463', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('ING DIRECT N.V.', '1465', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('HYPOTHEKENBANK FRANKFURT AG', '1467', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO PORTUGUES DE INVESTIMENTO', '1470', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CREDIT AGRICOLE LEASING & FACTORING', '1472', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANQUE PRIVEE EDMOND DE ROTHSCHILD', '1473', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CITIBANK INTERNATIONAL PLC', '1474', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CORTAL CONSORS', '1475', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('NATIXIS SUCURSAL EN ESPAÑA', '1479', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('VOLKSWAGEN BANK GMBH', '1480', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO MAIS', '1481', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('JOHN DEERE BANK', '1482', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANK OF SCOTLAND', '1483', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANK OF AMERICA N.A.', '1485', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('TOYOTA KREDITBANK GMBH', '1487', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('PICTET & CIE (EUROPE)', '1488', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('SELF TRADE BANK', '1490', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('TRIODOS BANK N.V.', '1491', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BNP PARIBAS LEASE GROUP', '1492', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA BANCO DE INVESTIMENTO', '1493', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('INTESA SANPAOLO, S.P.A.', '1494', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('GENEFIM SUCURSAL EN ESPAÑA', '1496', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO ESPIRITO SANTO DE INVESTIMENTO', '1497', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CLAAS FINANCAL SERVICES, S.A.S.', '1499', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('NATIXIS LEASE SUCURSAL EN ESPAÑA', '1500', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('DEUTSCHE PFANDBRIEFBANK, AG', '1501', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('IKB DEUTSCHE INDUSTRIEBANK AG.', '1502', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('HONDA BANK GMBH', '1504', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('EUROPE ARAB BANK PLC', '1505', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('MERRILL LYNCH INTERNATIONAL BANK LTD', '1506', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('RCI BANQUE SUCURSAL EN ESPAÑA', '1508', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO PRIMUS SUCURSAL EN ESPAÑA', '1509', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('SAXO BANK A/S SUCURSAL EN ESPAÑA', '1510', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('ELAVON FINANCIAL SERVICES LTD', '1512', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA GERAL DE DEPOSITOS', '1513', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CNH FINANCIAL SERVICES', '1514', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CITIBANK, N.A. SUCURSAL EN ESPAÑA', '1515', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('J.P. MORGAN INTERNATIONAL BANK LTD', '1516', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('MEDIOBANCA SUCURSAL EN ESPAÑA', '1520', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BINCKBANK NV, SUCURSAL EN ESPAÑA', '1521', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('EFG BANK SUCURSAL EN ESPAÑA', '1522', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('MERCEDES-BENZ BANK AG', '1523', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('UBI BANCA INTERNATIONAL', '1524', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANQUE CHAABI DU MAROC', '1525', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('JCB FINANCE,S.A.S SUCURSAL EN ESPAÑA', '1528', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('MCE BANK GMBH SUCURSAL EN ESPAÑA', '1529', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('SOFINLOC INSTITUIÇAO FINANCEIRA CDTO', '1530', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CREDIT SUISSE INTERNATIONAL', '1531', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BNP PARIBAS FACTOR SUCURSAL ESPAÑA', '1532', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BMW BANK GMBH SUCURSAL EN ESPAÑA', '1533', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('KBL EUROPEAN PRIVATE BANKERS', '1534', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('AKF BANK GMBH & CO KG', '1535', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('OREY FINANCIAL-INSTITUIÇÃO FINANCEIR', '1536', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('LLOYDS TSB BANK PLC SUCURSAL ESPAÑA', '1537', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('INDUSTRIAL &COMMERCIAL BANK OF CHINA', '1538', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BIGBANK AS CONSUMER FINANCE', '1539', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('ATTIJARIWAFA BANK EUROPE', '1541', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('J.P. MORGAN SECURITIES PLC', '1542', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('COFIDIS SUCURSAL EN ESPAÑA', '1543', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('ANDBANK ESPAÑA', '1544', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CREDIT AGRICOLE LUXEMBOURG', '1545', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CNH CAPITAL EUROPE S.A.S.', '1546', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CECABANK', '2000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CATALUNYA BANC', '2013', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('Caja De Burgos', '2018', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, '', '0000-00-00 00:00:00'),
('BANKIA', '2038', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA D''ESTALVIS DE ONTINYENT', '2045', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('LIBERBANK', '2048', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('COLONYA-CAIXA D''ESTALVIS DE POLLENÇA', '2056', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('Caixa Tarragona', '2073', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, '', '0000-00-00 00:00:00'),
('NCG BANCO', '2080', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA PENDES', '2081', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('IBERCAJA BANCO', '2085', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO GRUPO CAJATRES', '2086', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('KUTXABANK', '2095', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA ESPAÑA INV.SALAMANCA SORIA-2096', '2096', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXABANK', '2100', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('UNICAJA BANCO', '2103', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA ESPAÑA INV.SALAMANCA SORIA-2104', '2104', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DE CASTILLA-LA MANCHA', '2105', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('Unnim Banc, S.A', '2107', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DE C.ESPAÑA IN.SALAMANCA SORIA', '2108', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE ALMENDRALEJO', '3001', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL CENTRAL', '3005', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE GIJON', '3007', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE NAVARRA', '3008', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R.DE EXTREMADURA GRUP.COOP.IBERICO', '3009', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE SALAMANCA', '3016', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE SORIA', '3017', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. REGIONAL SAN AGUSTIN', '3018', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. DE UTRERA S. COOP.', '3020', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE GRANADA', '3023', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA DE C. DELS ENGINYERS', '3025', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA DE CREDITO DE PETREL', '3029', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA LABORAL POPULAR', '3035', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL ALTEA', '3045', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJAS RURALES UNIDAS,SDAD.COOP.CDTO.', '3058', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE ASTURIAS', '3059', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R.BURGOS,FUENTEP.,SEGOVIA Y CASTEL', '3060', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE CORDOBA', '3063', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. DE JAEN, BARCELONA Y MADRID', '3067', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL GALEGA', '3070', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJASIETE,CAJA RURAL SDAD.COOP.CDTO.', '3076', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE TERUEL', '3080', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE CASTILLA-LA MANCHA', '3081', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R.DEL MEDITERRANEO,RURALCAJA', '3082', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('IPAR KUTXA RURAL', '3084', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE ZAMORA', '3085', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R.DE BAENA NTRA.SRA.DE GUADALUPE', '3089', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. SAN ROQUE DE ALMENARA COOP.CTO.', '3095', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL DE L''ALCUDIA', '3096', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. NUESTRA SRA. DEL ROSARIO', '3098', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL SANT VICENT FERRER', '3102', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. DE CAÑETE DE LAS TORRES', '3104', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL DE CALLOSA D''EN SARRIA', '3105', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL CATOLICO AGRARIA', '3110', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. LA VALL SAN ISIDRO', '3111', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. SAN JOSE DE BURRIANA', '3112', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. SAN JOSE DE ALCORA COOP.CTO.V.', '3113', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. NUESTRA SRA. MADRE SOL', '3115', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. COMARCAL DE MOTA DEL CUERVO', '3116', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL D''ALGEMESI', '3117', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL TORRENT', '3118', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. SAN JAIME COOP.CTO.V.', '3119', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE CHESTE', '3121', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL DE TURIS', '3123', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE CASAS IBAÑEZ', '3127', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. SAN JOSE DE ALMASSORA', '3130', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. NTRA. SRA. DE LA ESPERANZA', '3134', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. SAN JOSE DE NULES', '3135', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE CASINOS', '3137', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE BETXI', '3138', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE GUISSONA', '3140', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE VILLAMALEA', '3144', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA DE CREDITO COOPERATIVO,S.C.CTO.', '3146', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE ALBAL', '3150', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE VILLAR', '3152', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. DE LA JUNQUERA DE CHILCHES', '3157', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA POPULAR-CAIXA RURAL', '3159', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. SANT JOSEP DE VILAVELLA', '3160', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL BENICARLO', '3162', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R. SAN ISIDRO DE VILAFAMES', '3165', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL LES COVES DE VINROMA', '3166', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL VINAROS COOP.C.V..', '3174', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE CANARIAS', '3177', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DE ALGINET', '3179', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA DE ARQUITECTOS S.COOP.CTO.', '3183', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAIXA RURAL ALBALAT DELS SORELLS', '3186', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CAJA RURAL DEL SUR', '3187', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('CREDIT VALENCIA CAJA RURAL', '3188', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('C.R.DE ALBACETE,CIUDAD REAL Y CUENCA', '3190', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('NUEVA CAJA RURAL DE ARAGON', '3191', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
('BANCO DE ESPAÑA', '9000', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00');

--
-- Estructura de la taula `bank_account`
--

CREATE TABLE IF NOT EXISTS `bank_account` (
  `bank_account_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_account_type_id` int(11) NOT NULL,
  `bank_account_entity_code` varchar(4) CHARACTER SET utf8 NOT NULL,
  `bank_account_office_code` varchar(4) CHARACTER SET utf8 NOT NULL,
  `bank_account_control_digit_code` varchar(2) CHARACTER SET utf8 NOT NULL,
  `bank_account_number` varchar(10) NOT NULL,
  `bank_account_owner_id` int(11),
  `bank_entryDate` datetime NOT NULL,
  `bank_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bank_creationUserId` int(11) DEFAULT NULL,
  `bank_lastupdateUserId` int(11) DEFAULT NULL,
  `bank_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `bank_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`bank_account_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `bank_account_type`
--

CREATE TABLE IF NOT EXISTS `bank_account_type` (
  `bank_account_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `bank_account_type_name` varchar(255) NOT NULL,
  `bank_account_type_entryDate` datetime NOT NULL,
  `bank_account_type_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bank_account_type_creationUserId` int(11) DEFAULT NULL,
  `bank_account_type_lastupdateUserId` int(11) DEFAULT NULL,
  `bank_account_type_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `bank_account_type_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`bank_account_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Bolcant dades de la taula `bank_account_type`
--

INSERT INTO `bank_account_type` (`bank_account_type_id`, `bank_account_type_name`, `entryDate`, `last_update`, `creationUserId`, `lastupdateUserId`, `markedForDeletion`, `markedForDeletionDate`) VALUES
(1, 'Código Cuenta Cliente (CCC)', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(2, 'IBAN', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, NULL, 'n', '0000-00-00 00:00:00');

--
-- Estructura de la taula `bank_office`
--

CREATE TABLE IF NOT EXISTS `bank_office` (
  `bank_office_name` varchar(255) NOT NULL,
  `bank_office_code` varchar(4) NOT NULL,
  `bank_office_bank_id` int(11) NOT NULL,
  `bank_office_entryDate` datetime NOT NULL,
  `bank_office_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `bank_office_creationUserId` int(11) DEFAULT NULL,
  `bank_office_lastupdateUserId` int(11) DEFAULT NULL,
  `bank_office_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `bank_office_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`bank_office_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


--
-- Estructura de la taula `student`
--

CREATE TABLE IF NOT EXISTS `student` (
  `student_id` int(11) NOT NULL AUTO_INCREMENT,
  `student_person_id` int(11) NOT NULL,
  `student_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `student_entryDate` datetime NOT NULL,
  `student_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `student_creationUserId` int(11) DEFAULT NULL,
  `student_lastupdateUserId` int(11) DEFAULT NULL,
  `student_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `student_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`student_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `non_lective_hours`
--

CREATE TABLE IF NOT EXISTS `non_lective_hours` (
  `non_lective_hours_id` int(11) NOT NULL AUTO_INCREMENT,
  `non_lective_hours_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `non_lective_hours_shortname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `non_lective_hours_name` varchar(100) CHARACTER SET utf8 NOT NULL,
  `non_lective_hours_description` text,  
  `non_lective_hours_entryDate` datetime NOT NULL,
  `non_lective_hours_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `non_lective_hours_creationUserId` int(11) DEFAULT NULL,
  `non_lective_hours_lastupdateUserId` int(11) DEFAULT NULL,
  `non_lective_hours_markedForDeletion` enum('n','y') NOT NULL,
  `non_lective_hours_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`non_lective_hours_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de la taula `lesson`     TODO
--

CREATE TABLE IF NOT EXISTS `lesson` (
  `lesson_id` int(11) NOT NULL AUTO_INCREMENT,
  `lesson_periodid` varchar(50) NOT NULL,
  `lesson_code` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `lesson_codi_assignatura` varchar(30) NOT NULL COMMENT 'ESBORRAR',
  `lesson_classroom_group_id` int(11) NOT NULL,
  `lesson_codi_grup` varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'ESBORRAR',
  `lesson_teacher_id` int(11) NOT NULL,
  `lesson_codi_professor` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL COMMENT 'ESBORRAR',
  `lesson_study_module_id` int(11) NOT NULL,
  `lesson_location_id` int(11) NOT NULL,
  `lesson_day` int(5) NOT NULL,
  `lesson_time_slot_id` int(11) NOT NULL,
  `codi_hora` tinyint(2) NOT NULL,
  `lesson_entryDate` datetime NOT NULL,
  `lesson_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `lesson_creationUserId` int(11) DEFAULT NULL,
  `lesson_lastupdateUserId` int(11) DEFAULT NULL,
  `lesson_markedForDeletion` enum('n','y') NOT NULL,
  `lesson_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`lesson_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `non_lective_lessons`
--

CREATE TABLE IF NOT EXISTS `non_lective_lessons` (
  `non_lective_lessons_id` int(11) NOT NULL AUTO_INCREMENT,
  `non_lective_lessons_non_lective_hours_id` int(11) NOT NULL,
  `non_lective_lessons_teacher_id` int(11) NOT NULL,
  `non_lective_lessons_lesson_day` int(5) NOT NULL,
  `non_lective_lessons_time_slot_id` int(11),    
  `non_lective_lessons_entryDate` datetime NOT NULL,
  `non_lective_lessons_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `non_lective_lessons_creationUserId` int(11) DEFAULT NULL,
  `non_lective_lessons_lastupdateUserId` int(11) DEFAULT NULL,
  `non_lective_lessons_markedForDeletion` enum('n','y') NOT NULL,
  `non_lective_lessons_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`non_lective_lessons_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Estructura de la taula `shift`
--

CREATE TABLE IF NOT EXISTS `shift` (
  `shift_id` int(11) NOT NULL AUTO_INCREMENT,
  `shift_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `shift_entryDate` datetime NOT NULL,
  `shift_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `shift_creationUserId` int(11) DEFAULT NULL,
  `shift_lastupdateUserId` int(11) DEFAULT NULL,
  `shift_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `shift_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`shift_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Bolcant dades de la taula `shift`
--

INSERT INTO `shift` (`shift_id`, `shift_name`, `entryDate`, `last_update`, `creationUserId`, `lastupdateUserId`, `markedForDeletion`, `markedForDeletionDate`) VALUES
(1, 'Matí', '0000-00-00 00:00:00', '2014-02-12 11:32:07', NULL, NULL, 'n', '0000-00-00 00:00:00'),
(2, 'Tarda', '0000-00-00 00:00:00', '2014-02-12 11:32:18', NULL, NULL, 'n', '0000-00-00 00:00:00');

---
--- TAULES INVENTORY
---

--
-- Table structure for table `inventory_object`
--

CREATE TABLE IF NOT EXISTS `inventory_object` (
  `inventory_objectId` int(11) NOT NULL AUTO_INCREMENT,
  `inventory_object_publicId` varchar(50) NOT NULL,
  `inventory_object_externalID` varchar(100) NOT NULL,
  `inventory_object_externalID1` varchar(100) NOT NULL,
  `inventory_object_externalID2` varchar(100) NOT NULL,
  `inventory_object_externalIDType` int(11) NOT NULL,
  `inventory_object_externalIDType1` int(11) NOT NULL,
  `inventory_object_externalIDType2` int(11) NOT NULL,
  `inventory_object_name` varchar(150) NOT NULL,
  `inventory_object_shortName` varchar(150) NOT NULL,
  `inventory_object_description` text,
  `inventory_object_parent` int(11),
  `inventory_object_materialId` int(11) NOT NULL,
  `inventory_object_brandId` int(11) NOT NULL,
  `inventory_object_modelId` int(11) NOT NULL,
  `inventory_object_entryDate` datetime NOT NULL,
  `inventory_object_manualEntryDate` datetime NOT NULL,
  `inventory_object_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `inventory_object_manualLast_update` datetime NOT NULL,
  `inventory_object_creationUserId` int(11) DEFAULT NULL,
  `inventory_object_lastupdateUserId` int(11) DEFAULT NULL,
  `inventory_object_location` int(11) DEFAULT NULL,
  `inventory_object_quantityInStock` smallint(6) NOT NULL,
  `inventory_object_price` double NOT NULL,
  `inventory_object_moneySourceId` int(11) DEFAULT NULL,
  `inventory_object_providerId` int(11) DEFAULT NULL,
  `inventory_object_preservationState` enum('Good','Regular','Bad') NOT NULL DEFAULT 'Good',
  `inventory_object_study_id` int(11) NOT NULL,
  `inventory_object_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `inventory_object_markedForDeletionDate` datetime NOT NULL,
  `inventory_object_file_url` varchar(250) NOT NULL,
  `inventory_object_mainOrganizationalUnitId` int(11) NOT NULL,
  PRIMARY KEY (`inventory_objectId`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



--
-- Table structure for table `externalIDType`
--

CREATE TABLE IF NOT EXISTS `externalIDType` (
  `externalIDType_id` int(11) NOT NULL AUTO_INCREMENT,
  `externalIDType_name` varchar(150) NOT NULL,
  `externalIDType_shortName` varchar(150) NOT NULL,
  `externalIDType_description` text,
  `externalIDType_barcodeId` int(11) NOT NULL,
  `externalIDType_entryDate` datetime NOT NULL,
  `externalIDType_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `externalIDType_creationUserId` int(11) DEFAULT NULL,
  `externalIDType_lastupdateUserId` int(11) DEFAULT NULL,
  `externalIDType_markedForDeletion` enum('n','y') NOT NULL,
  `externalIDType_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`externalIDType_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;

--
-- Table structure for table `brand`
--

CREATE TABLE IF NOT EXISTS `brand` (
  `brand_id` int(11) NOT NULL AUTO_INCREMENT,
  `brand_name` varchar(150) NOT NULL,
  `brand_shortName` varchar(150) NOT NULL,
  `brand_description` text,
  `brand_entryDate` datetime NOT NULL,
  `brand_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `brand_creationUserId` int(11) DEFAULT NULL,
  `brand_lastupdateUserId` int(11) DEFAULT NULL,
  `brand_markedForDeletion` enum('n','y') NOT NULL,
  `brand_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`brand_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `model`
--

CREATE TABLE IF NOT EXISTS `model` (
  `model_id` int(11) NOT NULL AUTO_INCREMENT,
  `model_brandId` int(11) DEFAULT NULL,
  `model_name` varchar(150) NOT NULL,
  `model_shortName` varchar(150) NOT NULL,
  `model_description` text,
  `model_entryDate` datetime NOT NULL,
  `model_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `model_creationUserId` int(11) DEFAULT NULL,
  `model_lastupdateUserId` int(11) DEFAULT NULL,
  `model_markedForDeletion` enum('n','y') NOT NULL,
  `model_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`model_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `material`
--

CREATE TABLE IF NOT EXISTS `material` (
  `material_id` int(11) NOT NULL AUTO_INCREMENT,
  `material_internalCode` text,	
  `material_name` varchar(150) NOT NULL,
  `material_shortName` varchar(150) NOT NULL,
  `material_description` text,
  `material_entryDate` datetime NOT NULL,
  `material_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `material_creationUserId` int(11) DEFAULT NULL,
  `material_lastupdateUserId` int(11) DEFAULT NULL,
  `material_parentMaterialId` int(11) DEFAULT NULL,
  `material_markedForDeletion` enum('n','y') NOT NULL,
  `material_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`material_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `provider`
--

CREATE TABLE IF NOT EXISTS `provider` (
  `provider_id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_name` varchar(150) NOT NULL,
  `provider_shortName` varchar(150) NOT NULL,
  `provider_description` text,
  `provider_entryDate` datetime NOT NULL,
  `provider_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `provider_creationUserId` int(11) DEFAULT NULL,
  `provider_lastupdateUserId` int(11) DEFAULT NULL,
  `provider_markedForDeletion` enum('n','y') NOT NULL,
  `provider_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`provider_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `money_source`
--

CREATE TABLE IF NOT EXISTS `moneySource` (
  `moneySource_id` int(11) NOT NULL AUTO_INCREMENT,
  `moneySource_name` varchar(150) NOT NULL,
  `moneySource_shortName` varchar(150) NOT NULL,
  `moneySource_description` text,
  `moneySource_entryDate` datetime NOT NULL,
  `moneySource_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `moneySource_creationUserId` int(11) DEFAULT NULL,
  `moneySource_lastupdateUserId` int(11) DEFAULT NULL,
  `moneySource_markedForDeletion` enum('n','y') NOT NULL,
  `moneySource_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`moneySource_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `barcode`
--

CREATE TABLE IF NOT EXISTS `barcode` (
  `barcode_id` int(11) NOT NULL AUTO_INCREMENT,
  `barcode_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `barcode_shortName` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `barcode_description` text COLLATE utf8_unicode_ci,
  `barcode_entryDate` datetime NOT NULL,
  `barcode_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `barcode_creationUserId` int(11) DEFAULT NULL,
  `barcode_lastupdateUserId` int(11) DEFAULT NULL,
  `barcode_markedForDeletion` enum('n','y') COLLATE utf8_unicode_ci NOT NULL,
  `barcode_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`barcode_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1;


--
-- Table structure for table `teacher`
--

DROP TABLE IF EXISTS `teacher`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `teacher` (
  `teacher_id` int(11) NOT NULL AUTO_INCREMENT,
  `teacher_person_id` int(11) NOT NULL,
  `teacher_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `teacher_entryDate` datetime NOT NULL,
  `teacher_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `teacher_creationUserId` int(11) DEFAULT NULL,
  `teacher_lastupdateUserId` int(11) DEFAULT NULL,
  `teacher_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `teacher_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`teacher_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `employees_id` int(11) NOT NULL AUTO_INCREMENT,
  `employees_person_id` int(11) NOT NULL,
  `employees_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `employees_type_id` int(11) NOT NULL,
  `employees_entryDate` datetime NOT NULL,
  `employees_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `employees_creationUserId` int(11) DEFAULT NULL,
  `employees_lastupdateUserId` int(11) DEFAULT NULL,
  `employees_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `employees_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`employees_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `employees_type`
--

DROP TABLE IF EXISTS `employees_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees_type` (
  `employees_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `employees_type_name` varchar(150) NOT NULL,
  `employees_type_shortName` varchar(150) NOT NULL,
  `employees_type_code` varchar(50) CHARACTER SET utf8 NOT NULL,
  `employees_type_entryDate` datetime NOT NULL,
  `employees_type_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `employees_type_creationUserId` int(11) DEFAULT NULL,
  `employees_type_lastupdateUserId` int(11) DEFAULT NULL,
  `employees_type_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `employees_type_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`employees_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `incident`
--

DROP TABLE IF EXISTS `incident`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident` (
  `incident_id` int(11) NOT NULL AUTO_INCREMENT,
  `incident_student_id` int(11) NOT NULL,
  `incident_time_slot_id` int(11) NOT NULL,
  `incident_day` int(11) NOT NULL,
  `incident_date` date,
  `incident_study_submodule_id` int(11) NOT NULL,
  `incident_type` int(11) NOT NULL,
  `incident_notes` text NOT NULL,
  `incident_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `incident_creationUserId` int(11) DEFAULT NULL,
  `incident_lastupdateUserId` int(11) DEFAULT NULL,
  `incident_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `incident_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`incident_id`),
  UNIQUE KEY `incident_student_id` (`incident_student_id`,`incident_time_slot_id`,`incident_day`,`incident_date`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `incident`
--
DROP TABLE IF EXISTS `incident_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `incident_type` (
  `incident_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `incident_type_name` varchar(150) NOT NULL,
  `incident_type_shortName` varchar(150) NOT NULL,
  `incident_type_description` varchar(255) NOT NULL,
  `incident_type_code` varchar(10) NOT NULL,
  `incident_type_last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `incident_type_creationUserId` int(11) DEFAULT NULL,
  `incident_type_lastupdateUserId` int(11) DEFAULT NULL,
  `incident_type_markedForDeletion` enum('n','y') NOT NULL DEFAULT 'n',
  `incident_type_markedForDeletionDate` datetime NOT NULL,
  PRIMARY KEY (`incident_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



