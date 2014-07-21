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
-- Table structure for table `encuesta_cuestionario_completo`
--

DROP TABLE IF EXISTS `encuesta_cuestionario_completo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `encuesta_cuestionario_completo` (
  `ecc_id` int(11) NOT NULL COMMENT 'identificador del cuestionario completo',
  `ecc_nombre` varchar(40) NOT NULL COMMENT 'Puede tomar los valores de Correcto o Incorrecto. ',
  PRIMARY KEY (`ecc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `encuesta_cuestionario_completo`
--

LOCK TABLES `encuesta_cuestionario_completo` WRITE;
/*!40000 ALTER TABLE `encuesta_cuestionario_completo` DISABLE KEYS */;
INSERT INTO `encuesta_cuestionario_completo` VALUES (1,'Correcto'),(2,'Incorrecto');
/*!40000 ALTER TABLE `encuesta_cuestionario_completo` ENABLE KEYS */;
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