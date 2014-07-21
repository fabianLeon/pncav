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
-- Table structure for table `instrumento_pregunta_opcion`
--

DROP TABLE IF EXISTS `instrumento_pregunta_opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `instrumento_pregunta_opcion` (
  `ipo_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la opcion',
  `ipr_id` int(11) NOT NULL COMMENT 'id de la pregunta',
  `ipo_valor` int(11) NOT NULL COMMENT 'valor asociado a la opción',
  `ipo_texto` varchar(150) NOT NULL COMMENT 'texto de la opción',
  PRIMARY KEY (`ipo_id`),
  KEY `ipr_id` (`ipr_id`)
) ENGINE=InnoDB AUTO_INCREMENT=329 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `instrumento_pregunta_opcion`
--

LOCK TABLES `instrumento_pregunta_opcion` WRITE;
/*!40000 ALTER TABLE `instrumento_pregunta_opcion` DISABLE KEYS */;
INSERT INTO `instrumento_pregunta_opcion` VALUES (1,7,1,'Cabecera'),(2,7,2,'Centro'),(3,7,3,'Rural disperso'),(4,10,1,'Femenino'),(5,10,2,'Masculino'),(6,12,1,'Si'),(7,12,2,'No'),(8,15,1,'Si'),(9,15,2,'No'),(10,16,1,'Si'),(11,16,2,'No'),(12,17,1,'Si'),(13,17,2,'No'),(14,18,1,'Si'),(15,18,2,'No'),(16,18,3,'No sabe lo que es'),(17,18,99,'No contesta'),(18,19,1,'Si'),(19,19,2,'No'),(20,19,99,'No contesta'),(21,20,1,'Si'),(22,20,2,'No'),(23,20,99,'No contesta'),(24,21,1,'Si'),(25,21,2,'No'),(26,21,3,'No sabe lo que es'),(27,21,99,'No contesta'),(28,22,1,'Portátil'),(29,22,2,'De escritorio'),(30,22,3,'Tableta/Teléfono móvil'),(31,22,99,'No contesta'),(32,23,1,'Si'),(33,23,2,'No'),(34,23,99,'No contesta'),(35,47,0,'Varias veces al día'),(36,47,0,'Una vez al día'),(37,47,0,'De una o dos veces a la'),(38,47,0,'De tres o más veces por semana'),(39,47,0,'Cada semana'),(40,47,0,'Varias veces al mes'),(41,47,0,'Casi Nunca'),(42,47,0,'Nunca'),(43,48,0,'Excelente'),(44,48,0,'Bueno'),(45,48,0,'Regular'),(46,48,0,'Malo'),(47,48,0,'Muy malo'),(48,49,1,'Banda Angosta'),(49,49,2,'Banda Ancha Fija'),(50,49,3,'Banda Ancha Móvil'),(51,49,98,'No sabe'),(52,49,99,'No contesta'),(53,50,1,'Si'),(54,50,2,'No'),(55,50,99,'No contesta'),(56,81,1,'Si'),(57,81,2,'No'),(58,81,99,'No contesta'),(59,82,1,'Si'),(60,82,2,'No'),(61,82,99,'No contesta'),(62,83,1,'Primaria'),(63,83,2,'Secundaria'),(64,83,3,'Técnica'),(65,83,4,'Tecnológica'),(66,83,5,'Universidad'),(67,83,6,'Ninguna'),(68,83,99,'No contesta'),(69,84,1,'Empleado'),(70,84,2,'Desempleado'),(71,84,3,'Trabajador Independiente'),(72,84,4,'Trabajador Informal'),(73,84,99,'No contesta'),(74,85,1,'Fuerza Pública'),(75,85,2,'Profesionales universitarios'),(76,85,3,'Técnicos, tecnólogos y asistentes'),(77,85,4,'Empleados de oficina'),(78,85,5,'Agricultores, ganaderos, forestales y pesqueros'),(79,85,6,'Empresarios'),(80,85,7,'Comerciantes, operarios, artesanos y trabajadores de la industria manufactureras, de la construcción y la minería'),(81,85,8,'Trabajadores no calificados'),(82,85,9,'Pensionado'),(83,85,10,'Estudiante'),(84,85,11,'Gestor TIC'),(85,85,12,'Labores de Hogar/Ama de Casa'),(86,85,13,'Miembro de Junta de Acción Comunal'),(87,85,14,'Miembro de organismo de socorro (bomberos, defensa civil, otros)'),(88,85,15,'Empleado domestico'),(89,85,16,'Reciclador'),(90,85,99,'No contesta'),(91,114,1,'Menos de 200.000'),(92,114,2,'De 200.001 a 400.000'),(93,114,3,'De 400.001 a 700.000'),(94,114,4,'De 700.001 a 1.000.000'),(95,114,5,'Más de 1.000.000'),(96,115,1,'Cero'),(97,115,2,'Menos de 10.000'),(98,115,3,'De 10.001 a 20.000'),(99,115,4,'De 20.001 a 40.000'),(100,115,5,'Más de 40.000'),(101,116,1,'Si'),(102,116,2,'No'),(103,116,99,'No contesta'),(104,117,1,'Menos de 10.000'),(105,117,2,'De 10.001 a 20.000'),(106,117,3,'De 20.001 a 40.000'),(107,117,4,'Más de 40.000'),(108,124,0,'Lunes'),(109,124,0,'Martes'),(110,124,0,'Miércoles'),(111,124,0,'Jueves'),(112,124,0,'Viernes'),(113,124,0,'Sábado'),(114,124,0,'Domingo'),(115,124,0,'Cualquier día'),(116,125,0,'La mañana (8-12)'),(117,125,0,'Medio día (1-2)'),(118,125,0,'Tarde (2-6)'),(119,125,0,'Noche (6-8)'),(120,128,1,'No lo habla en absoluto'),(121,128,2,'Lo habla muy poco'),(122,128,3,'Lo habla más o menos bien'),(123,128,4,'Lo habla con fluidez'),(124,128,5,'Es su idioma materno'),(125,128,98,'No Sabe'),(126,128,99,'No Contesta'),(127,129,1,'No lo habla en absoluto'),(128,129,2,'Lo habla muy poco'),(129,129,3,'Lo habla más o menos bien'),(130,129,4,'Lo habla con fluidez'),(131,129,5,'Es su idioma materno'),(132,129,98,'No Sabe'),(133,129,99,'No Contesta'),(134,132,1,'Si'),(135,132,2,'No'),(136,133,1,'Si'),(137,133,2,'No'),(138,134,1,'Si'),(139,134,2,'No'),(140,135,1,'Si'),(141,135,2,'No'),(142,136,1,'Si'),(143,136,2,'No'),(144,141,1,'Muy buena'),(145,141,2,'Buena'),(146,141,3,'Regular'),(147,141,4,'Mala'),(148,141,5,'Muy mala'),(149,142,1,'Si'),(150,142,2,'No'),(151,143,1,'Si'),(152,143,2,'No'),(153,144,1,'Si'),(154,144,2,'No'),(155,145,1,'Si'),(156,145,2,'No'),(157,146,1,'Si'),(158,146,2,'No'),(159,147,1,'Si'),(160,147,2,'No'),(161,148,1,'Si'),(162,148,2,'No'),(163,149,1,'Si'),(164,149,2,'No'),(165,150,1,'Si'),(166,150,2,'No'),(167,151,1,'Si'),(168,151,2,'No'),(169,152,1,'Si'),(170,152,2,'No'),(181,165,1,'Cabecera'),(182,165,2,'Centro'),(183,165,3,'Rural disperso'),(184,171,1,'Femenino'),(185,171,2,'Masculino'),(186,172,1,'Público'),(187,172,2,'Privado'),(188,172,3,'Social'),(189,172,4,'Instituciones Regionales'),(190,173,0,'Educación\r\n'),(191,173,0,'Salud'),(192,173,0,'Seguridad (Fuerzas Militares y Policía Nacional)'),(193,173,0,'Biblioteca\r\n'),(194,173,0,'Juzgados'),(195,173,0,'Alcaldía'),(196,176,1,'Básica Primaria'),(197,176,2,'Básica Secundaria'),(198,176,3,'Media'),(199,176,4,'Superior'),(200,178,1,'Si'),(201,178,2,'No'),(202,178,98,'No Sabe'),(203,180,1,'Hospital'),(204,180,2,'Clínica'),(205,180,3,'Centro de Salud '),(206,180,4,'Puesto de Salud '),(207,181,1,'Nivel I'),(208,181,2,'Nivel II'),(209,181,3,'Nivel III'),(210,182,1,'Ejercito'),(211,182,2,'Armada'),(212,182,3,'Fuerza Aérea'),(213,182,4,'Policía Nacional'),(214,183,1,'Primario (Agricultura, ganadería, pesca, minería, producción energética)'),(215,183,2,'Secundario (Industria, construcción, manufactura)'),(216,183,3,'Terciario (Comercio, bancos, educación, cultura, servicios)'),(217,184,1,'1-9 personas '),(218,184,2,'10-49 personas'),(219,184,3,'50-249 personas'),(220,184,4,'250 ó más personas'),(221,185,1,'Parques Naturales Nacionales - PNN'),(222,185,2,'Resguardo Indígena'),(223,186,1,'Si'),(224,186,2,'No'),(225,186,3,'No Sabe'),(226,186,4,'No contesta'),(227,188,1,'Si'),(228,188,2,'No'),(229,188,98,'No Sabe'),(230,188,99,'No contesta'),(231,195,1,'Si'),(232,195,2,'No'),(233,195,98,'No Sabe'),(234,200,1,'Si'),(235,200,2,'No'),(236,200,98,'No Sabe'),(237,200,99,'No contesta'),(238,201,1,'Portátil'),(239,201,2,'De escritorio\r\n'),(240,201,3,'Tableta'),(241,201,99,'No Contesta'),(242,216,1,'Banda Angosta '),(243,216,2,'Banda Ancha Fija'),(244,216,3,'Banda Ancha Móvil'),(245,216,98,'No Sabe'),(246,216,99,'No Contesta'),(247,217,0,'Excelente'),(248,217,0,'Bueno'),(249,217,0,'Regular'),(250,217,0,'Malo'),(251,217,0,'Muy Malo'),(252,225,1,'Si'),(253,225,2,'No'),(254,225,98,'No Sabe'),(255,225,99,'No contesta'),(256,226,1,'Si'),(257,226,2,'No'),(258,226,98,'No Sabe'),(259,226,99,'No contesta'),(260,227,1,'Si'),(261,227,2,'No'),(262,227,98,'No Sabe'),(263,227,99,'No contesta'),(264,250,0,'Lunes'),(265,250,0,'Martes'),(266,250,0,'Miércoles'),(267,250,0,'Jueves'),(268,250,0,'Viernes'),(269,250,0,'Sábado'),(270,250,0,'Domingo'),(271,250,0,'Cualquier día'),(277,251,0,'La mañana (8-12) '),(278,251,0,'Medio día (1-2) '),(279,251,0,'Tarde (2-6) '),(280,251,0,'Noche (6-8) '),(281,254,1,'No lo habla en absoluto\r\n'),(282,254,2,'Lo habla muy poco\r\n'),(283,254,3,'Lo habla  más o menos bien\r\n'),(284,254,4,'Lo habla con fluidez\r\n'),(285,254,5,'Es su idioma materno\r\n'),(286,254,98,'No Sabe'),(287,254,99,'No Contesta'),(288,255,1,'No lo habla en absoluto\r\n'),(289,255,2,'Lo habla muy poco\r\n'),(290,255,3,'Lo habla  más o menos bien\r\n'),(291,255,4,'Lo habla con fluidez\r\n'),(292,255,5,'Es su idioma materno\r\n'),(293,255,98,'No Sabe'),(294,254,99,'No Contesta'),(295,258,0,'Si'),(296,258,0,'No'),(297,259,0,'Si'),(298,259,0,'No'),(299,260,0,'Si'),(300,260,0,'No'),(301,261,0,'Si'),(302,261,0,'No'),(303,262,0,'Si'),(304,262,0,'No'),(305,267,1,'Muy Buena'),(306,267,2,'Buena'),(307,267,3,'Regular'),(308,267,4,'Mala'),(309,267,5,'Muy mala'),(320,117,0,'Cero'),(321,137,1,'Si'),(322,137,2,'No'),(323,139,1,'Si'),(324,139,2,'No'),(325,263,1,'Si'),(326,263,2,'No'),(327,265,1,'Si'),(328,265,2,'No');
/*!40000 ALTER TABLE `instrumento_pregunta_opcion` ENABLE KEYS */;
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
