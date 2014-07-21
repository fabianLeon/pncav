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
-- Table structure for table `municipio`
--

DROP TABLE IF EXISTS `municipio`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `municipio` (
  `mun_id` varchar(5) NOT NULL DEFAULT '' COMMENT 'Codigo dane del municipio',
  `dep_id` varchar(2) NOT NULL DEFAULT '' COMMENT 'Codigo dane del departamento al que pertenece el municipio',
  `mun_nombre` varchar(100) NOT NULL DEFAULT '' COMMENT 'Nombre del municipio',
  `mun_poblacion` int(11) NOT NULL DEFAULT '0' COMMENT 'Nro de habitantes del municipio segun proyeccion DANE',
  PRIMARY KEY (`mun_id`),
  KEY `FK_MUNICIPIO_DEPARTAMENTO` (`dep_id`),
  CONSTRAINT `FK_MUNICIPIO_DEPARTAMENTO` FOREIGN KEY (`dep_id`) REFERENCES `departamento` (`dep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los municipios por departamento';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `municipio`
--

LOCK TABLES `municipio` WRITE;
/*!40000 ALTER TABLE `municipio` DISABLE KEYS */;
INSERT INTO `municipio` VALUES ('27006','11','Acandí',0),('27025','11','Alto Baudo',0),('27075','11','Bahía Solano',0),('27077','11','Bajo Baudó',0),('27099','11','Bojaya',0),('27250','11','El Litoral del San Juan',0),('27372','11','Juradó',0),('27425','11','Medio Atrato',0),('27495','11','Nuquí',0),('27745','11','Sipí',0),('27800','11','Unguía',0),('50110','6','Barranca de Upía',0),('50226','6','Cumaral',0),('50350','6','La Macarena',0),('50370','6','Uribe',0),('5873','10','Vigía del Fuerte',0),('81220','8','Cravo Norte',0),('85162','9','Monterrey',0),('86573','4','Leguízamo',0),('91001','1','Leticia',0),('91263','1','El Encanto ',0),('91405','1','La Chorrera ',0),('91407','1','La Pedrera ',0),('91430','1','La Victoria ',0),('91460','1','Miriti - Paraná ',0),('91530','1','Puerto Alegría ',0),('91536','1','Puerto Arica ',0),('91540','1','Puerto Nariño',0),('91669','1','Puerto Santander ',0),('91798','1','Tarapacá ',0),('94001','2','Inírida',0),('94343','2','Barranco Minas ',0),('94663','2','Mapiripana ',0),('94883','2','San Felipe ',0),('94884','2','Puerto Colombia ',0),('94885','2','La Guadalupe',0),('94886','2','Cacahual ',0),('94887','2','Pana Pana ',0),('94888','2','Morichal ',0),('95200','3','Miraflores',0),('97001','5','Mitú',0),('97161','5','Caruru',0),('97511','5','Pacoa ',0),('97666','5','Taraira',0),('97777','5','Papunaua ',0),('97889','5','Yavaraté ',0),('99001','7','Puerto Carreño',0);
/*!40000 ALTER TABLE `municipio` ENABLE KEYS */;
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
