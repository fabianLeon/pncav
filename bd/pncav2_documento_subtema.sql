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
-- Table structure for table `documento_subtema`
--

DROP TABLE IF EXISTS `documento_subtema`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento_subtema` (
  `dos_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del subtema',
  `dot_id` int(2) NOT NULL DEFAULT '0' COMMENT 'Id del tema del documento',
  `dos_nombre` varchar(45) NOT NULL DEFAULT '' COMMENT 'Nombre del subtema',
  PRIMARY KEY (`dos_id`),
  KEY `FK_SUBTEMA1_documento_TEMA` (`dot_id`),
  CONSTRAINT `FK_SUBTEMA_DOCUMENTO_TEMA` FOREIGN KEY (`dot_id`) REFERENCES `documento_tema` (`dot_id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1 COMMENT='Contiene los subtemas de documentos';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento_subtema`
--

LOCK TABLES `documento_subtema` WRITE;
/*!40000 ALTER TABLE `documento_subtema` DISABLE KEYS */;
INSERT INTO `documento_subtema` VALUES (1,1,'Administrativa'),(2,1,'Fianaciera'),(3,1,'HSEQ'),(4,1,'Jurídica'),(5,1,'Social'),(6,1,'Técnica'),(7,2,'Comite directivo'),(8,2,'Mesa de trabajo'),(9,2,'Seguimiento al contratista'),(10,2,'Seguimiento interventoria'),(11,2,'Solicitudes'),(12,3,'Comite directivo'),(13,3,'Mesa de trabajo'),(14,3,'Seguimiento al contratista'),(15,3,'Seguimiento interventoria'),(16,3,'Solicitudes'),(17,4,'Desembolsos'),(18,4,'Utilizaciones'),(19,4,'Anticipo'),(20,4,'Informe Fiduciario'),(21,4,'Informe del Uso del Anticipo'),(22,4,'Capacidad Financiera'),(23,4,'Traslado de Rendimientos'),(24,4,'Patrimonio Autónomo'),(25,4,'Anticipo Interventoria'),(26,4,'Traslado de Rendimientos Interventoria'),(27,4,'Ordenes de Pago'),(28,4,'Facturación Interventoría'),(29,4,'Otros'),(30,5,'Plan de Manejo Ambiental (PMA)'),(31,5,'Permisos y Licencias Ambientales'),(32,5,'Gestión de Riesgos'),(33,5,'Plan de Calidad'),(34,5,'Normatividad Legal HSEQ'),(35,5,'Otros'),(36,6,'Apropiación'),(37,6,'Nivel de satisfacción al usuario'),(38,6,'Línea base'),(39,6,'Plan de Comunicaciones'),(40,6,'Estrategia de capacitaciones.'),(41,6,'Otros'),(42,7,'Gestión documental'),(43,7,'Equipo de trabajo Interventoria'),(44,7,'Cronogramas'),(45,7,'Informes mensuales'),(46,7,'Red de transporte'),(47,7,'Inventarios'),(48,7,'logistico'),(49,7,'Otros'),(50,8,'Contrato de Aporte'),(51,8,'Contrato Interventoría'),(52,8,'Contrato de Fiducia'),(53,8,'Contrato de Mandato'),(54,8,'Terminación / Liquidación'),(55,8,'Pólizas'),(56,8,'Contratos con Proveedores'),(57,8,'Contrato de Donación'),(58,8,'Consultas Previas'),(59,8,'Suspensiones'),(60,8,'Convenios'),(61,8,'Otros'),(62,9,'Documento General de Planeación'),(63,9,'Plan de Transmisión'),(64,9,'Informe Detallado de Ingeniería, Logística y '),(65,9,'Plan de Pruebas y Puesta en Servicio'),(66,9,'Plan de Operación y Mantenimiento'),(67,9,'Estudios de Campo'),(68,9,'Instalaciones'),(69,9,'Indicadores de Nivel de Servicio'),(70,9,'Mantenimientos'),(71,9,'Cambios'),(72,9,'Traslados'),(73,9,'Recibos Locativos'),(74,9,'Visitas de Calidad'),(75,9,'NOC'),(76,9,'Sistema de Gestión y Monitoreo'),(77,9,'Informes especiales'),(78,9,'PQRs'),(79,9,'Webservices'),(80,9,'Sistemas de Información'),(81,3,'Otros'),(82,9,'Otros'),(83,2,'Comite Fiduciario');
/*!40000 ALTER TABLE `documento_subtema` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2014-07-18 16:24:25
