-- MySQL dump 10.16  Distrib 10.3.7-MariaDB, for osx10.13 (x86_64)
--
-- Host: localhost    Database: ph-cartix
-- ------------------------------------------------------
-- Server version	10.3.7-MariaDB

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
-- Table structure for table `cards`
--

DROP TABLE IF EXISTS `cards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(11) unsigned NOT NULL,
  `is_common` int(11) unsigned NOT NULL,
  `tst_create` int(11) unsigned NOT NULL,
  `tst_update` int(11) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `map` varchar(255) NOT NULL,
  `secret` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `cards_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cards_images`
--

DROP TABLE IF EXISTS `cards_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards_images` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_card` int(10) unsigned NOT NULL,
  `id_sort` int(11) NOT NULL,
  `name` varchar(255) DEFAULT '',
  `url` varchar(255) DEFAULT '',
  `file` varchar(255) DEFAULT '',
  `description` text DEFAULT NULL,
  `width` int(10) unsigned NOT NULL,
  `height` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `cards_images_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `cards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cards_objects`
--

DROP TABLE IF EXISTS `cards_objects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards_objects` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_transfer` int(11) unsigned NOT NULL,
  `id_sort` int(11) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `instruction` text NOT NULL,
  `text` text NOT NULL,
  `size` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_card` (`id_transfer`),
  CONSTRAINT `cards_objects_ibfk_1` FOREIGN KEY (`id_transfer`) REFERENCES `cards_transfers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cards_objects_images`
--

DROP TABLE IF EXISTS `cards_objects_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards_objects_images` (
  `id_object` int(11) unsigned NOT NULL,
  `id_image` int(11) unsigned NOT NULL,
  `id_sort` int(11) unsigned NOT NULL,
  `comment` text NOT NULL,
  PRIMARY KEY (`id_object`,`id_image`,`id_sort`),
  KEY `id_image` (`id_image`),
  CONSTRAINT `cards_objects_images_ibfk_1` FOREIGN KEY (`id_object`) REFERENCES `cards_objects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cards_objects_images_ibfk_2` FOREIGN KEY (`id_image`) REFERENCES `cards_images` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cards_subscribes`
--

DROP TABLE IF EXISTS `cards_subscribes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards_subscribes` (
  `id_card` int(11) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_card`,`id_user`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `cards_subscribes_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `cards` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cards_subscribes_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cards_transfers`
--

DROP TABLE IF EXISTS `cards_transfers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards_transfers` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_card` int(11) unsigned NOT NULL,
  `id_sort` int(11) NOT NULL,
  `time` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `instruction` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_card` (`id_card`),
  CONSTRAINT `cards_transfers_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `cards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `cards_viewings`
--

DROP TABLE IF EXISTS `cards_viewings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cards_viewings` (
  `id_card` int(11) unsigned NOT NULL,
  `id_user` int(11) unsigned NOT NULL,
  `timestamp` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id_card`,`id_user`),
  KEY `id_user` (`id_user`),
  CONSTRAINT `cards_viewings_ibfk_1` FOREIGN KEY (`id_card`) REFERENCES `cards` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cards_viewings_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_role` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `surname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `auth` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-10-01 11:20:26
