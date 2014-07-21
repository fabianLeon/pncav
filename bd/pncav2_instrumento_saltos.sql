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
-- Table structure for table `instrumento_saltos`
--

DROP TABLE IF EXISTS `instrumento_saltos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instrumento_saltos` (
  `ipr_id` int(11) NOT NULL COMMENT 'Identificador de la pregunta',
  `ipo_id` int(11) NOT NULL COMMENT 'Identificador de la respuesta a la pregunta',
  `ipr_id_salta` int(11) NOT NULL COMMENT 'Identificador de la pregunta a la cual se salta',
  PRIMARY KEY (`ipr_id`,`ipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instrumento_saltos`
--

LOCK TABLES `instrumento_saltos` WRITE;
/*!40000 ALTER TABLE `instrumento_saltos` DISABLE KEYS */;
INSERT INTO `instrumento_saltos` VALUES (18,14,20),(18,16,23),(21,25,59),(21,26,50),(22,28,24),(22,29,24),(22,30,24),(49,48,81),(49,49,81),(49,50,81),(49,51,81),(49,52,81),(50,54,66),(59,0,72),(119,1,120),(137,322,139),(139,324,141),(153,1,141),(173,190,176),(173,191,180),(173,192,182),(173,193,186),(173,194,186),(173,195,186),(174,1,183),(175,1,185),(178,201,186),(178,202,186),(181,207,186),(181,208,186),(181,209,186),(182,210,186),(182,211,186),(182,212,186),(182,213,186),(184,217,186),(184,218,186),(184,219,186),(184,220,186),(185,221,186),(185,222,186),(188,228,225),(195,232,200),(195,233,200),(200,235,218),(263,326,265),(265,328,267),(279,1,267);
/*!40000 ALTER TABLE `instrumento_saltos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-18 16:24:27
