CREATE DATABASE  IF NOT EXISTS `pncav2` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `pncav2`;
-- MySQL dump 10.13  Distrib 5.6.17, for Win32 (x86)
--
-- Host: equipo04    Database: pncav2
-- ------------------------------------------------------
-- Server version	5.5.27

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
-- Table structure for table `festivos_colombia`
--

DROP TABLE IF EXISTS `festivos_colombia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `festivos_colombia` (
  `fes_id` date NOT NULL COMMENT 'fecha de los festivos',
  UNIQUE KEY `UK_FECHA` (`fes_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='contiene los festivos de colombia';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `festivos_colombia`
--

LOCK TABLES `festivos_colombia` WRITE;
/*!40000 ALTER TABLE `festivos_colombia` DISABLE KEYS */;
INSERT INTO `festivos_colombia` VALUES ('2014-01-01'),('2014-01-06'),('2014-03-24'),('2014-04-17'),('2014-04-18'),('2014-05-01'),('2014-06-02'),('2014-06-23'),('2014-06-30'),('2014-08-07'),('2014-08-18'),('2014-10-13'),('2014-11-03'),('2014-11-17'),('2014-12-08'),('2014-12-25');
/*!40000 ALTER TABLE `festivos_colombia` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-18 16:24:26
