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
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `usuario` (
  `usu_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del usuario para el sistema',
  `per_id` int(11) NOT NULL COMMENT 'Id del perfil',
  `usu_login` varchar(15) NOT NULL COMMENT 'Login del usuario',
  `usu_clave` varchar(100) NOT NULL COMMENT 'Clave del usuario',
  `usu_nombre` varchar(100) NOT NULL COMMENT 'Nombre del usuario',
  `usu_apellido` varchar(100) NOT NULL COMMENT 'Apellido del usurio',
  `usu_documento` varchar(20) NOT NULL DEFAULT '' COMMENT 'Documeno del usuario',
  `usu_telefono` varchar(20) NOT NULL DEFAULT '' COMMENT 'Telefono del usuario',
  `usu_celular` varchar(20) NOT NULL DEFAULT '' COMMENT 'Celular del usuario',
  `usu_correo` varchar(200) NOT NULL DEFAULT '' COMMENT 'Direccion de correo del usuario',
  `usu_estado` int(1) NOT NULL DEFAULT '1' COMMENT 'Estado del usuario en el sistema (1 activo 0 inactivo)',
  `usu_fecha_ultimo_ingreso` date NOT NULL COMMENT 'Fecha de ultimo ingreso al sistema',
  PRIMARY KEY (`usu_id`),
  UNIQUE KEY `UK_LOGIN` (`usu_login`),
  KEY `FK_USUARIO_PERFIL` (`per_id`),
  CONSTRAINT `FK_usuario_perfil` FOREIGN KEY (`per_id`) REFERENCES `perfil` (`per_id`)
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=latin1 COMMENT='Contiene los usuarios';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,1,'admin','21232f297a57a5a743894a0e4a801fc3','Usuario','Administrador','123456','12336655','3158989898','admin@mail.com',1,'2014-07-18'),(64,2,'consulta','5d76beffe761403531a6eb339e0f0231','consulta','consulta','63526847','74563987','3000000000','xxx@redcom.com.co',1,'2014-06-13'),(66,1,'gramirez','3b7523b92474628b33d3b22bcea3c0b4','German','Ramirez','5555432','32145870','3144575984','asi.pncav@serticsas.com.co',1,'2014-07-17'),(68,2,'dclavijo','e3f7132e274902c456b4a4e4be9006da','Diana','Clavijo','11111111','34567890','3111111111','asji.pncav@serticsas.com.co',1,'2014-07-17'),(69,2,'kmontes','98acd9f19739c7ef08cfc5dbe796eb15','Katty','Montes','11111111','34567890','3111111111','dhseq.pncav@serticsas.com',1,'2014-07-15'),(70,1,'grodriguez','e10adc3949ba59abbe56e057f20f883e','GERMAN','RODRIGUEZ','1111111','31445759','3144588798','asi.pncav@serticsas.com.co',1,'2014-04-08'),(71,2,'pdelrio','3b08ef6006dc8490f3b6cc30667fd906','Pedro','Del Rio','12234123','23456764','3111111111','dji.pncav@serticsas.com.co',1,'2014-07-18'),(72,2,'dlezcano','5e3563f3b1f4695326e7b0cf37ffe91d','Donnell','Lezcano','1111112','34567890','3111111111','dpa.pncav@serticsas.com.co',1,'2014-07-18'),(74,5,'damezquita','7684aef1b28cd287bfa263e4a42b2f64','Diana Marcela','Amezquita Chitiva','1026259544','68086502','3143789282','agd.pncav@serticsas.com.co',1,'2014-07-18'),(75,1,'laparicio','9f7c0bdd5f70ce7e7cb9e1c7deadbd41','Lubis ','Aparicio','78453245','34589725','3214567890','dti.pncav@serticsas.com.co',1,'2014-07-18'),(76,2,'gmartinez','acfc96dea96e4e24b8e38ba006745d83','Guillermo','Martinez','245678905','23456795','3145672385','dsi.pncav@serticsas.com.co',1,'2014-06-27'),(77,6,'dlopez','71db5bea921f7137e8a2400573469ceb','Danny','Lopez','789345678','78945673','3003789234','ahseq.pncav@serticsas.com.co',1,'2014-07-18'),(78,6,'wtovar','f1936d7e77b7ce255c2d947ecd8dd6fc','Wilson','Tovar','89234567','45678903','3214567834','hseqa.pncav@serticsas.com.co',1,'2014-07-17'),(79,2,'mgaona','8b409ffe1e9cbad9df9c190af4b1d4fb','Manolo','Gaona','80945683','67834902','3013458723','aji.pncav@serticsas.com.co',1,'2014-07-17'),(80,2,'agomez','403a11c6fae14f6b52fcc5475f58797f','Andres','Gomez','34567890','23467895','3145632890','alts.pncav@serticsas.com.co',1,'2014-07-18'),(81,2,'ldelgado','6e4c7603d1e3113a8c919b9caac291dc','Lorena','Delgado','56890123','78903454','3112370405','asege.pncav@serticsas.com.co',1,'2014-07-18'),(82,2,'mserna','ae9df8722138865ffc98ee26a3868d01','Mauricio','Serna','45678902','56734210','3135643222','artlan.pncav@serticsas.com.co',1,'2014-07-18'),(83,3,'mvelandia','38df4e739d9a88d248694a2ab1cfcee3','Mauricio','Velandia','87904322','45678902','3004567892','asa.pncav@serticsas.com.co',1,'2014-07-14'),(84,3,'llastre','2e221306e8cc73bc443e27d3e023f50a','Lidu','Lastre','523457865','58900214','3004321189','asa1.pncav@serticsas.com.co',1,'2014-07-18'),(85,2,'vgaribello','5aacdf2b2692424b57ef71707527fcd5','Victor','Garibello','345678921','22345678','3113256702','arti.pncav@serticsas.com.co',1,'2014-07-16'),(86,2,'DIRCON','362e08ce58d8d7ae58248281db4674bf','Direccion','Conectividad','234567890','56734521','3001236782','dircon@mintic.gov.co',1,'2014-07-17'),(87,4,'UTANDIRED','3d93d6f32ae9d3afa4f44739e6db7bea','Union temporal Andired','Andired','89032456','84567123','3112567890','ut@anditel.com.co',1,'2014-07-18'),(88,2,'FIDUB','fa9423106d9d901feb51b8e6d5aaa1bf','Fiduciaria','Bogota','34678012','89023456','3142256678','bogota@fiducaria.com.co',1,'2014-04-08'),(89,6,'lmendoza','45aa3251f9e963f7b2e9bbf86a2eb13f','Luz Marina ','Mendoza','56789321','34567890','3124567892','daf.pncav@serticsas.com.co',1,'2014-07-18'),(90,6,'omelo','03021920a5a125e1d795bfa46511e50a','Oscar','Melo','89034568','23445780','3015890234','afa.pncav@serticsas.com.co',1,'2014-07-17'),(91,2,'jrodriguez','8c2ebfd486ace8f01915d78fa8d3bf53','Juan Carlos ','Rodriguez Lopez','79562880','76198105','3132960693','li1.pncav@serticsas.com.co',1,'2014-07-11'),(92,2,'lgomez','613eface325a38fb47121fabbdb4f557','Luis Alejandro','Gomez Rozo','80039877','20005071','3142874394','asa2.pncav@serticsas.com.co',1,'2014-05-16'),(93,2,'hcolobon','a91b17392e4fc0ce38f19d5e439956e2','Hildegard','Colobon','60358304','48080800','3134567893','li2.pncav@serticsas.com.co',1,'2014-07-18'),(94,1,'Sertic S.A.S.','8b4f978328def7f01f5cf2433b471d47','SERTIC','S.A.S','45896741','68598748','3143568952','dti.pncav@serticsas.com.co',1,'2014-07-09'),(95,2,'fromero','1cff0f05de9d181a4f45bb0d18b70592','FABIO','ROMERO','5555555','26587987','3125478974','aoc.pncav@serticsas.com',1,'2014-07-10');
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
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
