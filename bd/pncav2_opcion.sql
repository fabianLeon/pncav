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
-- Table structure for table `opcion`
--

DROP TABLE IF EXISTS `opcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `opcion` (
  `opc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la opcion',
  `opc_nombre` varchar(60) DEFAULT '' COMMENT 'Nombre de la opcion',
  `opc_variable` varchar(50) DEFAULT NULL COMMENT 'Variable que se controla para la ejecucion de la accion asociada a la opcion',
  `opc_url` varchar(250) NOT NULL COMMENT 'URL de la opcion',
  `opn_id` int(1) NOT NULL DEFAULT '0' COMMENT 'Nivel de la opcion',
  `opc_padre_id` int(11) NOT NULL DEFAULT '0' COMMENT 'Id de la opcion padre',
  `opc_orden` int(10) NOT NULL DEFAULT '0' COMMENT 'Orden de la opcion',
  `layout` varchar(60) DEFAULT '' COMMENT 'Layout asociado a la opcion',
  `ope_id` int(11) DEFAULT NULL COMMENT 'Id del operador',
  PRIMARY KEY (`opc_id`),
  KEY `FK_OPCION_NIVEL` (`opn_id`),
  CONSTRAINT `FK_opcion_nivel` FOREIGN KEY (`opn_id`) REFERENCES `opcion_nivel` (`opn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1 COMMENT='Contiene las opciones para crear el menu';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `opcion`
--

LOCK TABLES `opcion` WRITE;
/*!40000 ALTER TABLE `opcion` DISABLE KEYS */;
INSERT INTO `opcion` VALUES (1,'PRINCIPAL','','',0,0,100000,'',1),(2,'DOCUMENTAL','','',0,0,200000,'',1),(3,'SEGURIDAD','','',0,0,900000,'',1),(4,'Inicio','home','home.php',1,1,101000,'',1),(5,'Tablas Basicas','tablas','tablas/tablas.php',1,3,901000,'',1),(6,'Usuarios','usuarios','usuarios/usuarios.php',1,3,902000,'',1),(7,'Perfiles','perfiles','perfiles/perfiles.php',1,3,903000,'',1),(8,'Opciones','opciones','opciones/opciones.php',1,3,904000,'',1),(9,'Cambiar Clave','usuarios&task=editClave','usuarios/usuarios.php',1,3,908000,'',1),(10,'Cerrar Sesion','cerrar','cerrar.php',1,3,909000,'login_layout.php',1),(31,'Manuales','manuales','manuales/manuales.php',1,1,102000,'',1),(66,'Actas','actas','documentos/actas.php',1,2,202000,'',1),(67,'Comunicados','correspondencia','documentos/correspondencia.php',1,2,201000,'',1),(68,'Compromisos','compromisos','documentos/compromisos.php',1,2,204000,'',1),(82,'Recomendaciones','recomendaciones','documentos/recomendaciones.php',1,2,205000,'',1),(92,'Resumen PIA','resumenPIA','financiero/resumenPlanInversionAnticipo.php',1,69,401400,'',1),(93,'Extractos Int.','extractosInt','interventoria/extractos.php',1,83,505000,'',1),(94,'Rendimientos Int.','rendimientosInt','interventoria/rendimientos.php',1,83,506000,'',1),(97,'SOCIAL',NULL,'',0,0,300000,'',1),(98,'Planeación','planeacion','planeacion/planeacion.php',1,97,301000,'',1),(99,'Ejecución','ejecucion','ejecucion/ejecucion.php',1,2,302000,'',1);
/*!40000 ALTER TABLE `opcion` ENABLE KEYS */;
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
