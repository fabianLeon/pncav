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
-- Table structure for table `documento_actor`
--

DROP TABLE IF EXISTS `documento_actor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_actor` (
  `doa_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del actor',
  `doa_nombre` varchar(60) NOT NULL DEFAULT '' COMMENT 'Nombre del actor',
  `doa_sigla` varchar(6) NOT NULL DEFAULT '' COMMENT 'Sigla del actor',
  `ope_id` int(11) NOT NULL COMMENT 'Id del operador',
  `dta_id` int(11) NOT NULL COMMENT 'Id del tipo de actor',
  PRIMARY KEY (`doa_id`),
  KEY `FK_OPERADOR` (`ope_id`),
  KEY `FK_DOCUMENTO_TIPO_ACTOR` (`dta_id`),
  CONSTRAINT `documento_actor_ibfk_1` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`),
  CONSTRAINT `documento_actor_ibfk_2` FOREIGN KEY (`dta_id`) REFERENCES `documento_tipo_actor` (`dta_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1 COMMENT='Contiene los actores responsables de documentos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_actor`
--

LOCK TABLES `documento_actor` WRITE;
/*!40000 ALTER TABLE `documento_actor` DISABLE KEYS */;
INSERT INTO `documento_actor` VALUES (1,'Dirección de Conectividad','DCO',1,1),(2,'Fiduciaria Bogotá','FIDU',1,1),(3,'SERTIC','SRT',1,1),(4,'Unión Temporal Andired','UTAR',1,1);
/*!40000 ALTER TABLE `documento_actor` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-18 16:24:28
