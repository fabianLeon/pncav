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
-- Table structure for table `documento_tema`
--

DROP TABLE IF EXISTS `documento_tema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_tema` (
  `dot_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del tema',
  `dot_nombre` varchar(45) NOT NULL DEFAULT '' COMMENT 'Nombre del tema',
  `dti_id` int(2) NOT NULL DEFAULT '0' COMMENT 'Id del tipo',
  PRIMARY KEY (`dot_id`),
  KEY `FK_TEMA1_DOCUMENTO_TIPO` (`dti_id`),
  CONSTRAINT `FK_TEMA_DOCUMENTO_TIPO` FOREIGN KEY (`dti_id`) REFERENCES `documento_tipo` (`dti_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1 COMMENT='Contiene los temas de documentos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_tema`
--

LOCK TABLES `documento_tema` WRITE;
/*!40000 ALTER TABLE `documento_tema` DISABLE KEYS */;
INSERT INTO `documento_tema` VALUES (1,'Comunicados',1),(2,'Actas',1),(3,'Compromisos',1),(4,'Financiero',1),(5,'HSEQ',1),(6,'Social',1),(7,'Administrativo',1),(8,'Jurídico',1),(9,'Técnico',1);
/*!40000 ALTER TABLE `documento_tema` ENABLE KEYS */;
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
