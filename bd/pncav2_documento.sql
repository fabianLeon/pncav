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
-- Table structure for table `documento`
--

DROP TABLE IF EXISTS `documento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `documento` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del documento',
  `dti_id` int(2) NOT NULL DEFAULT '0' COMMENT 'identificador del tipo de documento',
  `dot_id` int(3) DEFAULT '0' COMMENT 'identificador del tema del documento',
  `dos_id` int(3) NOT NULL DEFAULT '0' COMMENT 'identificador del subtema del documento',
  `doc_fecha` date NOT NULL COMMENT 'fecha de creacion del documento',
  `doc_descripcion` text NOT NULL COMMENT 'descripcion del documento',
  `doc_archivo` varchar(200) NOT NULL COMMENT 'nombre del documento',
  `doc_version` varchar(15) DEFAULT NULL COMMENT 'informacion de la version del documento',
  `doe_id` int(11) DEFAULT '0' COMMENT 'Identificador del tipo de estado',
  `ope_id` int(11) NOT NULL COMMENT 'Identificador del tipo de estado',
  `doc_anexo` varchar(200) DEFAULT NULL COMMENT 'nombre del anexo',
  `doa_id` int(3) DEFAULT NULL COMMENT 'identificador del autor',
  `doc_fechamax` date DEFAULT NULL COMMENT 'fecha máxima de respuesta',
  `doc_ref_resp` varchar(200) DEFAULT NULL COMMENT 'nombre de documento de respuesta',
  `doc_res_resp` int(3) DEFAULT NULL COMMENT 'id del responsable de dar respuesta.',
  `doc_consecutivo` varchar(7) DEFAULT NULL COMMENT 'consecutivo asignado por el usuario',
  PRIMARY KEY (`doc_id`),
  UNIQUE KEY `UK_DOC_ID_TIPO_ARCHIVO` (`doc_id`,`dti_id`,`doc_archivo`) USING BTREE,
  KEY `FK_DOCUMENTO_TIPO` (`dti_id`),
  KEY `FK_DOCUMENTO_TEMA` (`dot_id`),
  KEY `FK_DOCUMENTO_SUBTEMA` (`dos_id`),
  KEY `FK_DOCUMENTO_ESTADO` (`doe_id`),
  KEY `FK_DOCUMENTO_OPERADOR` (`ope_id`),
  CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`dos_id`) REFERENCES `documento_subtema` (`dos_id`),
  CONSTRAINT `documento_ibfk_3` FOREIGN KEY (`doe_id`) REFERENCES `documento_estado` (`doe_id`),
  CONSTRAINT `fk_documento_documento_tema` FOREIGN KEY (`dot_id`) REFERENCES `documento_tema` (`dot_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_documento_tipo` FOREIGN KEY (`dti_id`) REFERENCES `documento_tipo` (`dti_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_documento_operador` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=657 DEFAULT CHARSET=latin1 COMMENT='Contiene los documentos soporte del proyecto';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documento`
--

LOCK TABLES `documento` WRITE;
/*!40000 ALTER TABLE `documento` DISABLE KEYS */;
INSERT INTO `documento` VALUES (2,1,2,8,'2014-01-07','Acta N°1 Mesa de trabajo ','Reunión N 1_ Metas Apropiación.pdf','1',1,1,NULL,0,NULL,NULL,NULL,''),(4,1,2,8,'2014-02-25','Acta N° 3 Mesa de trabajo','Reunion N 3 Estudios de campo.pdf','3',1,1,NULL,0,NULL,NULL,NULL,''),(5,1,2,8,'2014-03-20','Acta N° 4 Mesa de trabajo','Reunion N 4 Documentos de planeación.pdf','4',1,1,NULL,0,NULL,NULL,NULL,''),(6,1,2,8,'2014-03-28','Acta N° 5 Mesa de trabajo','Reunion N 5 Mobiliario.pdf','5',1,1,NULL,0,NULL,NULL,NULL,''),(7,1,2,8,'2014-04-02','Acta N° 6 Mesa de trabajo','Reunion N 6 Preparacion comité Fiduciario.pdf','6',1,1,NULL,0,NULL,NULL,NULL,''),(8,1,2,8,'2014-04-07','Acta N° 7 Mesa de trabajo','Reunion N 7 Documentos soporte de Ordenes de pago.pdf','7',1,1,NULL,0,NULL,NULL,NULL,''),(9,1,2,8,'2014-04-10','Acta N° 8 Mesa de trabajo','Reunion N 8 Beneficiarios.pdf','8',1,1,NULL,0,NULL,NULL,NULL,''),(10,1,2,10,'2014-01-22','Acta N° 1 Seguimiento Interventoria-Revision de entregables de la interventoria y contratista','Acta No.1 Seguimiento Sertic.pdf','1',1,1,NULL,0,NULL,NULL,NULL,''),(11,1,2,10,'2014-01-28','Acta N° 2 Seguimiento Interventoria, Reunion financiera','Acta 2 Reunión financiera.pdf','2',1,1,NULL,0,NULL,NULL,NULL,''),(12,1,2,10,'2014-02-17','Acta N° 3 Presentacion Informe mensual de interventoria N° 1','Acta N° 3 Informe Mensual No 1 Enero.pdf','3',1,1,NULL,0,NULL,NULL,NULL,''),(13,1,2,10,'2014-02-19','Acta N° 4 Aprobación de Estructura de Sistema de Información de la Interventoría','Acta N 4-Sistema de Información.pdf','4',1,1,NULL,0,NULL,NULL,NULL,''),(14,1,2,10,'2014-02-20','Acta N° 5 Revisar y validar los web services','Acta  N° 5 Revisar y validar Web services.pdf','5',1,1,NULL,0,NULL,NULL,NULL,''),(15,1,2,9,'2014-01-28','Acta N° 2 Reunión de seguimiento entre el operador, la interventoria y el MinTic','Reunión N 2. Seguimiento ANDIRED.pdf','2',1,1,NULL,0,NULL,NULL,NULL,''),(16,1,2,9,'2014-03-20','Acta N° 8 Definicion de gastos administrativos y operativos','Acta 8-Reunión Financiera-20-mar-2014.pdf','8',1,1,NULL,0,NULL,NULL,NULL,''),(17,1,2,8,'2014-04-22','Acta N° 9 Mesa de trabajo','Reunion N 9 Beneficiarios.pdf','9',1,1,NULL,0,NULL,NULL,NULL,''),(18,1,2,7,'2014-01-02','Acta de entrega por cambio de supervisor','ACTA ENTREGA POR CAMBIO DE SUPERVISOR.pdf','0',1,1,NULL,0,NULL,NULL,NULL,''),(19,1,2,9,'2014-01-16','Acta N° 1 Presentacion de la empresa ANDIRED, Presentacion equipo del proyecto.','Acta 1 Andired 16Enero2014.pdf','1',1,1,NULL,0,NULL,NULL,NULL,''),(20,1,2,8,'2014-05-29','Acta N 10 Mesa de trabajo Juridico- Social- HSEQ','Reunion N 10 Juridico-social-HSEQ.pdf','10',1,1,NULL,0,NULL,NULL,NULL,''),(21,1,2,8,'2014-05-14','Acta N° 12 Mesa de Trabajo Plan de transmision y plan de pruebas.','Reunion N 12 Plan de transmision y plan de pruebas.pdf','12',1,1,NULL,0,NULL,NULL,NULL,''),(22,1,2,8,'2014-05-15','Acta N° 14 Mesa de Trabajo- Documentos de planeacion.','Reunion N 14 Documentos de planeacion.pdf','14',1,1,NULL,0,NULL,NULL,NULL,''),(23,1,2,8,'2014-05-16','Acta N° 15 Mesa de trabajo Pruebas y estudios de campo.','Reunion N 15 Pruebas y estudios de campo.pdf','15',1,1,NULL,0,NULL,NULL,NULL,''),(24,1,2,7,'2014-02-07','Acta N 1 Comite directivo','Acta Comité Directivo No  1-7-feb-2014.pdf','1',1,1,NULL,0,NULL,NULL,NULL,''),(25,1,2,7,'2014-03-17','Acta N° 2 Comite directivo.','Acta 2 Comité Directivo CAV - Marzo 17-2014.pdf','2',1,1,NULL,0,NULL,NULL,NULL,''),(26,1,2,7,'2014-04-29','Acta Comite directivo N° 3','Acta 3 Comité Directivo CAV - Abril 23-2014.pdf','3',1,1,NULL,0,NULL,NULL,NULL,''),(27,1,2,10,'2014-03-19','Acta N° 6 Seguimiento a la interventoria.','Acta N° 6 Seguimiento Interventoria.pdf','6',1,1,NULL,0,NULL,NULL,NULL,''),(29,1,2,9,'2014-02-03','Acta N° 4 Seguimiento al contratista UTANDIRED','Acta N° 4 Seguimiento al contratista.pdf','4',1,1,NULL,0,NULL,NULL,NULL,''),(30,1,2,9,'2014-05-07','Acta N° 5 Seguimiento al contratista UTANDIRED','Acta n° 5 Seguimiento al contratista.pdf','5',1,1,NULL,0,NULL,NULL,NULL,''),(31,1,2,9,'2014-02-14','Acta N° 6 Seguimiento al contratisa UTANDIRED','Acta N° 6 Seguimiento al contratista.pdf','6',1,1,NULL,0,NULL,NULL,NULL,''),(32,1,2,9,'2014-05-07','Acta N° 9 Comite operativo 1','Acta N° 9 comite operativo 1.pdf','9',1,1,NULL,0,NULL,NULL,NULL,''),(33,1,2,8,'2014-05-23','Acta N° 19 Mesa de trabajo-Seguimiento a los web services del operador.','Reunion N 19 Seguimiento a los web services del operador.pdf','19',1,1,NULL,0,NULL,NULL,NULL,''),(34,1,2,9,'2014-03-05','Presentacion hoja de ruta metodologia de consulta previa y definicion de los pasos a seguir dentro del proceso ante MinInterior','Acta 7-Consulta previa-5-marzo-2014.pdf','7',1,1,NULL,0,NULL,NULL,NULL,''),(35,1,2,7,'2014-05-29','Realizar elComité Directivo No4. del Proyecto Nacional de Conectividad de Alta Velocidad','Acta 4 Comité Directivo CAV - Mayo 29-2014.pdf','4',1,1,NULL,0,NULL,NULL,NULL,''),(36,1,2,8,'2014-02-10','Acta N° 2 Mesa de trabajo, Proceso de donacion para KVD Y PVD','Reunión 2- Mesa de trabajo Donación.pdf','2',1,1,NULL,0,NULL,NULL,NULL,''),(37,1,2,8,'2014-05-23','Acta N° 20- Mesa de Trabajo Observaciones al DGP y al EDIA','Reunion N 20 OBSERVACIONES DGP Y EDIA.pdf','20',1,1,NULL,0,NULL,NULL,NULL,''),(38,1,2,8,'2014-05-27','Acta N 21 Mesa de trabajo-Validación de ubicación de Bases de las Fuerzas Militares, respecto a los posibles sitios donde se instalarían las Torres que pertenecen a la red de Transporte del Proyecto Nacional de Conectividad de Alta Velocidad - PNCAV','Reunion N 21 Fuerzas Militares J8.pdf','21',1,1,NULL,0,NULL,NULL,NULL,''),(39,1,2,8,'2014-05-30','Acta N 22 Mesa de trabajo-Realizar la tercer Mesa de Trabajo de la Ruta Metodológica de Indicadores','Reunion N 22 may30-14 Ruta Metodol. de Indicadores.pdf','22',1,1,NULL,0,NULL,NULL,NULL,''),(40,1,2,8,'2014-05-19','Acta N 18- Mesa de trabajo-aclaración de observaciones a los documentos de los Web Services','Reunion N 18 Observaciones documentos Web Services.pdf','18',1,1,NULL,0,NULL,NULL,NULL,''),(42,1,2,10,'2014-03-24','Acta N° 7- Presentación Informe mensual de  Interventoría No. 3','Reunión N 7_ Informe Mensual N 3.pdf','7',1,1,NULL,0,NULL,NULL,NULL,''),(43,1,2,10,'2014-05-13','Acta N° 8-1.	Presentación Informe Mensual de Interventoría No 4.','Reunión N 8  Informe Mensual No  4.pdf','8',1,1,NULL,0,NULL,NULL,NULL,''),(44,1,2,8,'2014-06-05','Acta N° 23 -Mesa de trabajo- Presentar el avance del Plan de Apropiación en TIC, entregable para el 27 de junio de 2014','Reunion N 23 Plan de Apropiación.pdf','23',1,1,NULL,0,NULL,NULL,NULL,''),(45,1,2,8,'2014-06-05','Acta N° 26 - Mesa de trabajo-Presentar el avance del Plan de Comunicaciones, entregable para el 27 de junio de 2014','Reunion N 26 Plan de comunicaciones.pdf','26',1,1,NULL,0,NULL,NULL,NULL,''),(46,1,2,8,'2014-06-10','Acta N° 36 Mesa de trabajo-	Revisar el plan de desarrollo Web Services de la unión temporal Andired.','Reunion N 36 Avance desarrollo de web services.pdf','36',1,1,NULL,0,NULL,NULL,NULL,''),(47,1,2,8,'2014-05-16','Acta N° 17- Mesa de trabajo- Plan de comunicaciones y plan de apropiacion','Reunion N 17 plan de comunicacion y de apropiacion.pdf','17',1,1,NULL,0,NULL,NULL,NULL,''),(48,1,2,8,'2014-06-06','Acta N° 29- Mesa de trabajo- Informe de visita a Sitios','Reunion N 29 Informe de visita a sitios.pdf','29',1,1,NULL,0,NULL,NULL,NULL,''),(49,1,2,8,'2014-06-06','Acta N° 30- Mesa de trabajo- Indicadores de la metodologia de seguimiento y avance del proyecto.','Reunion N 30 Indicadores metodologia de seguimiento y avance.pdf','30',1,1,NULL,0,NULL,NULL,NULL,''),(50,1,2,8,'2014-06-06','Acta N° 28- Mesa de trabajo- Avance plan de marketing y comercialización.','Reunion N 28 Plan de marketing y comercializacion.pdf','28',1,1,NULL,0,NULL,NULL,NULL,''),(51,1,2,8,'2014-06-10','Acta N° 35-Mesa de trabajo-Informe detallado de ingenieria logistica y gestion','Reunion N 35 Informe detallado de ingenieria logistica y gestion.pdf','35',1,1,NULL,0,NULL,NULL,NULL,''),(52,1,2,8,'2014-06-06','Acta N° 33- Mesa de trabajo- Plan de operacion y mantenimiento','Reunion N 33 Plan de operacion y mantenimiento.pdf','33',1,1,NULL,0,NULL,NULL,NULL,''),(53,1,2,10,'2014-06-11','Acta N° 9- seguimiento a la interventoria- Presentacion del informe mensual N° 5 de interventoria','Acta No. 9 Presentacion Informe 5 de interventoria.pdf','9',1,1,NULL,0,NULL,NULL,NULL,''),(55,1,2,8,'2014-05-15','Acta N° 13- Mesa de trabajo- Plan de instalacion, plan de operacion y mantenimiento, plan de integracion.','Reunion N 13 Consolidacion documentos de planeacion.pdf','13',1,1,NULL,0,NULL,NULL,NULL,''),(56,1,2,8,'2014-06-13','Acta N° 38- Mesa de trabajo- Avance del plan de comunicaciones.','Reunion N 38 Avance plan de comunicaciones.pdf','38',1,1,NULL,0,NULL,NULL,NULL,''),(60,1,2,9,'2014-06-11','Acta N° 10- seguimiento al contratista-Estado de actividades al 31 de mayo de 2014','Reunion N 10 Comite seguimiento a 31 de mayo de 2014.pdf','10',1,1,NULL,0,NULL,NULL,NULL,''),(61,1,2,8,'2014-06-06','Acta N° 34- Mesa de trabajo- Plan de  Instalacion y plan de integracion.','Reunion N 34 Plan de instalacion y plan de integracion.pdf','34',1,1,NULL,0,NULL,NULL,NULL,''),(62,1,2,8,'2014-06-18','Revision del plan de instalacion y plan de integracion de la UTANDIRED','Reunion N 40 Revision plan de instalacion e integracion.pdf','40',1,1,NULL,0,NULL,NULL,NULL,''),(63,1,2,8,'2014-06-20','Acta N° 42- Mesa de trabajo revision plan de desarrollo de web services.','Reunion N 42 Plan de desarrollo web services.pdf','42',1,1,NULL,0,NULL,NULL,NULL,''),(64,1,2,8,'2014-06-20','Acta N° 41 Mesa de trabajo- Revision informe detallado de ingenieria, logistica y gestion- plan de pruebas y puesta en servicio','Reunion N 41 Informe ingenieria- plan de pruebas y puesta en servicio.pdf','41',1,1,NULL,0,NULL,NULL,NULL,''),(65,1,2,8,'2014-06-26','Acta N° 45- Mesa de Trabajo-Revision informe de ingenieria logistica y gestion y plan de tansmision, pruebas y puesta en servicio.','Reunion N 45 Revision Informe de ingenieria y plan de transmision.pdf','45',1,1,NULL,0,NULL,NULL,NULL,''),(66,1,2,8,'2014-06-25','Acta N° 44 - Mesa de trabajo- Informe detallado de ingenieria logistica y gestion','Reunion N 44 Avance informe de ingenieria logistica y gestion.pdf','44',1,1,NULL,0,NULL,NULL,NULL,''),(67,1,2,8,'2014-05-16','Acta N° 16-Mesa de trabajo Revisión de Riesgos ambientales y calidad como preparacion a la entrega de los planes de la meta 2.','Reunion N 16 Riesgos ambiental y calidad.pdf','16',1,1,NULL,0,NULL,NULL,NULL,''),(68,1,2,8,'2014-06-24','Acta N° 43- Mesa de trabajo Plan de comunicaciones','Reunion N 43 Plan de comunicaciones.pdf','43',1,1,NULL,0,NULL,NULL,NULL,''),(69,1,2,8,'2014-06-18','Acta N° 39- Mesa de trabajo Revisión del avance correspondiente al plan de operacion y mantenimiento.','Reunion N 39 Plan de operacion y mantenimiento.pdf','39',1,1,NULL,0,NULL,NULL,NULL,''),(70,1,2,8,'2014-06-12','Acta N° 37- Mesa de trabajo Revision planes calidad-ambiental y riesgos.','Reunion N 37 Planes calidad-ambiental-riesgos.pdf','37',1,1,NULL,0,NULL,NULL,NULL,''),(71,1,2,7,'2014-06-19','Acta N° 5 Comite directivo PNCAV','Acta 5-Comité Directivo-19-junio-2014.pdf','5',1,1,NULL,0,NULL,NULL,NULL,''),(641,1,2,83,'2014-06-25','Acta n° 1 Comite fiduciario','Acta N° 1 Comite fiduciario.pdf','1',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(644,1,2,8,'2014-07-14','Acta N° 49 Mesa de trabajo revision de compromisos y seguimiento PINES','REUNION N 49 PINES 14-JUL-14.pdf','49',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(645,1,2,8,'2014-06-06','Acta N° 32 Mesa de trabajo Plan de Ingenieria- sistema de informacion','Reunion N 32 Plan de ingeniera- sistema de informacion.pdf','32',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(646,1,2,8,'2014-07-03','Acta N° 47 Mesa de trabajo sseguimiento Pines','Reunion N 47 PINES.pdf','47',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(647,1,2,10,'2014-07-16','Acta n° 10 Informe de Interventoria N° 6','Acta de Reunión N 10  de INTV - Informe Mensual No  6.pdf','10',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(648,1,2,9,'2014-06-13','Acta N° 11 Concepto Documento general de planeacion','Reunión N 11   Alcance KVD.pdf','11',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(649,1,2,9,'2014-07-16','Acta N° 12 Presentacion Informe N° 6 del contratista','Reunion N 12 Presentacion Informe  n° 6 UT.pdf','12',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(650,1,2,8,'2014-07-01','Acta N° 46 Mesa de trabajo plan de choque validacion del EDIA','Reunion N 46 Plan de choque validacion del EDIA.pdf','46',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(651,1,2,8,'2014-06-18','Acta N° 39 A Mesa de trabajo- propuesta plan de apropiacion','Reunion N 39A PROPUESTA  DE PLAN DE APROPIACIÓN..pdf','39 A',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(652,1,2,8,'2014-07-10','Acta N° 48 Mesa de Trabajo- Revision de Observaciones HSEQ Informes mensuales de UTANDIRED','Reunion N 48 Observaciones HSEQ- Informes UT.pdf','48',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(653,1,2,11,'2014-07-17','Correo 17 Julio 2014- Monica Lozano','Correo 17 Julio 2014-Monica Lozano.pdf','1',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(654,1,2,8,'2014-06-05','Acta N° 24 Mesa de trabajo Plan de gestion de riesgos','Reunion N 24 Plan de riesgos.pdf','24',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(655,1,2,8,'2014-06-05','Acta N° 25 Mesa de trabajo Plan de gestion ambiental','Reunion N 25 Plan de Gestion ambiental.pdf','25',1,1,NULL,NULL,NULL,NULL,NULL,NULL),(656,1,2,8,'2014-06-05','Acta N° 27 Mesa trabajo Plan de Gestión de aseguramiento de la calidad','Reunion N 27 Revision Plan de calidad.pdf','27',1,1,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `documento` ENABLE KEYS */;
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