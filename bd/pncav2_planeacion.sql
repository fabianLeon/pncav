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
-- Table structure for table `planeacion`
--

DROP TABLE IF EXISTS `planeacion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `planeacion` (
  `pla_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único de planeación',
  `mun_id` int(10) NOT NULL COMMENT 'Corresponde al identificador unicao de cada uno de Municipios almacenados en la base de datos',
  `eje_id` int(10) NOT NULL COMMENT 'Corresponde al tipo de punto: PVD, KVD, Banda Ancha (BA), Instituciones Públicas (IP) y Wifi (WIFI).',
  `pla_numero_encuestas` int(100) NOT NULL COMMENT 'Corresponde al número de encuestas que se van a realizar a la organización.',
  `pla_fecha_inicio` date NOT NULL,
  `pla_fecha_fin` date NOT NULL,
  `usu_id` int(1) NOT NULL,
  `ees_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pla_id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `planeacion`
--

LOCK TABLES `planeacion` WRITE;
/*!40000 ALTER TABLE `planeacion` DISABLE KEYS */;
INSERT INTO `planeacion` VALUES (1,27006,5,30,'2014-07-08','2014-08-13',92,2),(3,27075,5,25,'2014-07-08','2014-08-13',92,2),(5,27099,5,23,'2014-07-08','2014-08-13',92,2),(7,27372,5,7,'2014-07-08','2014-08-13',92,2),(9,27495,5,18,'2014-07-08','2014-08-13',92,2),(11,27800,5,30,'2014-07-08','2014-08-13',92,2),(12,5873,5,14,'2014-07-08','2014-08-13',92,2),(13,27006,3,4,'2014-07-08','2014-08-13',92,2),(15,27075,3,7,'2014-07-08','2014-08-13',92,2),(17,27099,3,4,'2014-07-08','2014-08-13',92,2),(19,27372,3,4,'2014-07-08','2014-08-13',92,2),(21,27495,3,4,'2014-07-08','2014-08-13',92,2),(23,27800,3,10,'2014-07-08','2014-08-13',92,2),(24,5873,3,6,'2014-07-08','2014-08-13',92,2),(25,27006,2,16,'2014-07-08','2014-08-13',92,2),(27,27075,2,8,'2014-07-08','2014-08-13',92,2),(29,27099,2,19,'2014-07-08','2014-08-13',92,2),(31,27372,2,8,'2014-07-08','2014-08-13',92,2),(33,27495,2,7,'2014-07-08','2014-08-13',92,2),(35,27800,2,13,'2014-07-08','2014-08-13',92,2),(36,5873,2,11,'2014-07-08','2014-08-13',92,2),(37,27006,1,1,'2014-07-08','2014-08-13',92,2),(39,27075,1,1,'2014-07-08','2014-08-13',92,2),(41,27099,1,1,'2014-07-08','2014-08-13',92,2),(43,27372,1,1,'2014-07-08','2014-08-13',92,2),(45,27495,1,1,'2014-07-08','2014-08-13',92,2),(47,27800,1,1,'2014-07-08','2014-08-13',92,2),(48,5873,1,1,'2014-07-08','2014-08-13',92,2);
/*!40000 ALTER TABLE `planeacion` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-18 16:24:29
