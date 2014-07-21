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
-- Table structure for table `perfil_x_opcion`
--

DROP TABLE IF EXISTS `perfil_x_opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `perfil_x_opcion` (
  `per_id` int(11) NOT NULL COMMENT 'Id del perfil',
  `opc_id` int(11) NOT NULL COMMENT 'Id de la opcion',
  `pxo_nivel` int(1) NOT NULL COMMENT 'Nivel de acceso a la opcion',
  PRIMARY KEY (`per_id`,`opc_id`),
  KEY `FK_PERFIL_OPCION_PERFIL` (`per_id`),
  KEY `FK_PERFIL_OPCION_OPCION` (`opc_id`),
  CONSTRAINT `perfil_x_opcion_ibfk_1` FOREIGN KEY (`per_id`) REFERENCES `perfil` (`per_id`),
  CONSTRAINT `perfil_x_opcion_ibfk_2` FOREIGN KEY (`opc_id`) REFERENCES `opcion` (`opc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene la relacion perfil vs opcion';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `perfil_x_opcion`
--

LOCK TABLES `perfil_x_opcion` WRITE;
/*!40000 ALTER TABLE `perfil_x_opcion` DISABLE KEYS */;
INSERT INTO `perfil_x_opcion` VALUES (1,1,1),(1,2,2),(1,3,1),(1,4,1),(1,5,1),(1,6,1),(1,7,1),(1,8,1),(1,9,1),(1,10,1),(1,31,1),(1,66,1),(1,67,1),(1,68,1),(1,82,1),(1,97,2),(1,98,1),(1,99,1),(2,1,2),(2,2,2),(2,3,2),(2,4,2),(2,9,2),(2,10,2),(2,31,2),(2,66,2),(2,67,2),(2,68,2),(2,82,2),(3,1,2),(3,2,2),(3,3,1),(3,4,2),(3,9,1),(3,10,1),(3,66,1),(3,67,1),(3,68,1),(3,82,1),(3,97,2),(3,98,1),(4,2,2),(4,3,2),(4,10,2),(4,66,2),(4,67,2),(4,68,2),(4,82,2),(5,1,1),(5,2,1),(5,3,1),(5,4,2),(5,5,2),(5,6,1),(5,7,1),(5,8,2),(5,9,1),(5,10,1),(5,66,1),(5,67,1),(5,68,1),(5,82,1),(6,1,2),(6,2,1),(6,3,2),(6,4,1),(6,5,1),(6,9,1),(6,10,1),(6,66,1),(6,67,1),(6,68,1),(6,82,1);
/*!40000 ALTER TABLE `perfil_x_opcion` ENABLE KEYS */;
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
