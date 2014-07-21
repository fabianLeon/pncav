-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 22-07-2014 a las 01:31:18
-- Versión del servidor: 5.6.16
-- Versión de PHP: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `pncav2`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades`
--

CREATE TABLE IF NOT EXISTS `actividades` (
  `Id_Actividad` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Indica el Identificador del objeto actividad',
  `Descripcion_Actividad` varchar(100) NOT NULL COMMENT 'Corresponde a la descripción de la actividad ',
  `Monto_Actividad` bigint(20) NOT NULL COMMENT 'Corresponde al monto de la actividad',
  `Id_Tipo` int(2) NOT NULL COMMENT 'Indica el identificador del tipo de la actividad ',
  PRIMARY KEY (`Id_Actividad`),
  KEY `Id_Tipo` (`Id_Tipo`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividades_tipo`
--

CREATE TABLE IF NOT EXISTS `actividades_tipo` (
  `Id_Tipo` int(2) NOT NULL AUTO_INCREMENT,
  `Descripcion_Tipo` varchar(70) NOT NULL,
  PRIMARY KEY (`Id_Tipo`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `actividades_tipo`
--

INSERT INTO `actividades_tipo` (`Id_Tipo`, `Descripcion_Tipo`) VALUES
(1, ' Plan de Integración: Suministros e Instalaciones (P.I.S.I.)'),
(2, 'Plan de Inversión del Anticipo (P.I.A.)');

--
-- Disparadores `actividades_tipo`
--
DROP TRIGGER IF EXISTS `prevent_delete_PIA`;
DELIMITER //
CREATE TRIGGER `prevent_delete_PIA` BEFORE DELETE ON `actividades_tipo`
 FOR EACH ROW BEGIN 
IF (OLD.Id_Tipo=2) THEN
   CALL raise_application_error(-20101,'No puede borrar este registro');
   END IF;
END
//
DELIMITER ;
DROP TRIGGER IF EXISTS `prevent_update_PIA`;
DELIMITER //
CREATE TRIGGER `prevent_update_PIA` BEFORE UPDATE ON `actividades_tipo`
 FOR EACH ROW BEGIN
IF (OLD.Id_Tipo = 2) THEN 
	CALL raise_application_error(-20102,'El registro no debe ser eliminado');
    END IF;
END
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ciudad`
--

CREATE TABLE IF NOT EXISTS `ciudad` (
  `Id_Ciudad` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador interno único de ciudad',
  `Id_Pais` int(11) NOT NULL COMMENT 'Identificador del país al que pertenece la ciudad',
  `Nombre_Ciudad` varchar(20) NOT NULL COMMENT 'Nombre de la ciudad',
  PRIMARY KEY (`Id_Ciudad`),
  UNIQUE KEY `Nombre_Ciudad` (`Nombre_Ciudad`),
  KEY `Id_Pais` (`Id_Pais`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Tabla para almacenar las ciudades usadas dentro del sistema' AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compromiso`
--

CREATE TABLE IF NOT EXISTS `compromiso` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del compromiso',
  `com_actividad` text NOT NULL COMMENT 'Actividad que debe ejecutar',
  `doc_id` int(11) NOT NULL COMMENT 'Id del documento que generó el compromiso',
  `com_fecha_limite` date NOT NULL COMMENT 'Fecha limite de cumplimiento del compromiso',
  `com_fecha_entrega` date NOT NULL COMMENT 'Fecha real de cumplimiento del compromiso',
  `ces_id` int(1) NOT NULL COMMENT 'Id del estado del compromiso',
  `com_observaciones` text NOT NULL COMMENT 'Observaciones del compromiso',
  `ope_id` int(2) NOT NULL COMMENT 'Id del operador responsable del compromiso',
  `com_consecutivo` int(11) NOT NULL,
  PRIMARY KEY (`com_id`),
  KEY `FK_COMPROMISO1_TIPO_ESTADO` (`ces_id`),
  KEY `FK_COMPROMISO1_DOCUMENTO` (`doc_id`),
  KEY `fk_compromiso_operador_idx` (`ope_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los compromisos de las reuniones' AUTO_INCREMENT=1250 ;

--
-- Volcado de datos para la tabla `compromiso`
--

INSERT INTO `compromiso` (`com_id`, `com_actividad`, `doc_id`, `com_fecha_limite`, `com_fecha_entrega`, `ces_id`, `com_observaciones`, `ope_id`, `com_consecutivo`) VALUES
(1, 'Revisión de Instrumentos para la Estudio del desarrollo de Impacto y Apropiación\r\nObjetivos  y metas– a quien se le debe apuntar. Investigación de\r\nTablade contenido del Plan de Apropiación', 2, '2014-02-17', '2014-01-07', 2, 'No tiene Observaciones', 1, 1),
(2, 'Objetivos  y metas de Apropiación ', 2, '2014-04-25', '2014-01-07', 2, 'Programadas reuniones de trabajo', 1, 1),
(3, 'Tablade contenido del Plan de Apropiación', 2, '2014-02-17', '2014-01-07', 2, 'No tiene observaciones.', 1, 1),
(6, 'Remitir la totalidad de formatos de Estudios de Campo debidamente ajustados', 4, '2014-03-04', '2014-02-25', 2, 'No tiene Observaciones', 1, 3),
(7, 'Remitir matriz de recopilación de información de los Estudios de Campo', 4, '2014-03-04', '2014-02-25', 2, 'No tiene Observaciones', 1, 3),
(8, 'Remitir listado de registro fotográfico mínimo a presentar con los Estudios de Campo', 4, '2014-03-04', '2014-02-25', 2, 'No tiene observaciones', 1, 3),
(9, 'Presentar el Documento de Planeación en el plazo contractualmente establecido.', 5, '2014-03-27', '2014-03-20', 2, 'No tiene observaciones', 1, 4),
(10, 'Entregar listado de las 235 públicas, PVD’s, Base de Instituciones Educativas potenciales para instalación.', 5, '2014-03-27', '2014-03-20', 2, 'No tiene observaciones', 1, 4),
(11, 'Generar anexo del Plan de Permisos y Licencias contempladas', 5, '2014-04-03', '2014-03-20', 2, 'No tiene observaciones', 1, 4),
(12, 'Cronograma de Estudios de Campo', 5, '2014-04-03', '2014-03-20', 2, 'No tiene observaciones', 1, 4),
(13, 'Requerimientos mínimos requeridos por la Unión Temporal, para poder realizar la instalación en los Beneficiarios', 5, '2014-04-03', '2014-03-20', 2, 'No tiene Observaciones', 1, 4),
(14, 'Programar Visita a KVD Piloto del Contratista luego de validación de los ajustes al manual', 6, '2014-04-04', '2014-03-28', 2, 'No tiene observaciones', 1, 5),
(15, 'Envío de especificaciones de KVD Fase II a la Interventoría', 6, '2014-03-31', '2014-03-28', 2, 'No tiene observaciones', 1, 5),
(16, 'Envío de las observaciones al Manual de KVD', 6, '2014-04-04', '2014-03-28', 2, 'No tiene observaciones', 1, 5),
(17, 'Envío de las observaciones al Manual de PVD y PVD+', 6, '2014-03-28', '2014-03-28', 2, 'No tiene observaciones', 1, 5),
(18, 'Confirmación de fecha para la realización del Comité Fiduciario  ', 7, '2014-04-04', '2014-04-02', 2, 'No tiene Observaciones', 1, 6),
(19, 'Borrador del acta de Comité Fiduciario No. 1', 7, '2014-04-04', '2014-04-02', 2, 'No tiene Observaciones', 1, 6),
(20, 'Envío de Minuta a Otrosí Contrato Fiducia', 7, '2014-04-02', '2014-04-02', 2, 'No tiene observaciones', 1, 6),
(21, 'Ajuste a las minutas del Contrato de Mandato y Reglamento Fiduciario (basado en el Contrato de Fiducia)', 7, '2014-04-07', '2014-04-02', 2, 'No tiene observaciones', 1, 6),
(22, 'Envío modelo de Acta de transferencia de Bienes al Patrimonio Autónomo', 7, '2014-04-04', '2014-04-02', 2, 'No tiene observaciones', 1, 6),
(23, 'Envío procedimiento de donación', 7, '2014-04-07', '2014-04-02', 2, 'No tiene observaciones', 1, 6),
(24, 'Envío modelo de Acta de transferencia de Bienes al Patrimonio Autónomo', 8, '2014-04-08', '2014-04-07', 2, 'No tiene observaciones', 1, 7),
(25, 'Determinar si se requiere aportar tres cotizaciones cuando el proveedor es uno de los integrantes de la UTAR.', 8, '2014-04-10', '2014-04-07', 2, 'Trabajo en reunión Financiera del 30-04-14, no es de Carácter obligatorio', 1, 7),
(26, 'Aportar el documento donde el Representante Legal otorgue la facultad al Gerente del Proyecto-PNCAVla firmar  de los recibos a satisfacción de servicios y/o bienes', 8, '2014-04-21', '2014-04-07', 1, 'El compromiso se cierra a partir de la entrega de las ordenes pago. La fecha registrada es una fecha tentativa.', 1, 7),
(27, 'Envió del documento modelo del Compromiso Anticorrupción elaborado por el MINTIC', 8, '2014-04-08', '2014-04-07', 2, 'Enviado mediante correo electronico el 8 de Abril de 2014', 1, 7),
(28, 'Entrega de borrador de certificación de levantamiento de Información para Estudios de Campo.', 9, '2014-04-14', '2014-04-10', 2, 'No tiene Observaciones', 1, 8),
(29, 'Cruce de base de datos entregada por la Dirección de Conectividad con la base levantada en campo por la UT Andired en el Estudio DIA.', 9, '2014-04-21', '2014-04-10', 2, 'Realiizado por el MINTIC.', 1, 8),
(30, 'Envío cronograma de Estudio de Campo', 9, '2014-04-15', '2014-04-10', 1, 'No tiene Observaciones', 1, 8),
(31, 'Propuesta contenido del plan de Visitas a Sitios (Nodos, torres)', 9, '2014-04-15', '2014-04-10', 1, 'No tiene observaciones', 1, 8),
(32, 'Reunión financiera – Desembolsos y Utilizaciones ', 10, '2014-01-28', '2014-01-22', 2, 'No tiene observaciones', 1, 1),
(33, 'Reunión de seguimiento de Operador', 10, '2014-01-27', '2014-01-22', 2, 'No tiene observaciones', 1, 1),
(34, 'Propuesta de informe ejecutivo', 10, '2014-01-30', '2014-01-22', 2, 'No tiene observaciones', 1, 1),
(35, 'Reunión definición Indicadores de seguimiento del proyecto.', 10, '2014-02-04', '2014-01-22', 2, 'definido en la Metodología de seguimiento y evaluación del avance.', 1, 1),
(36, 'Modificación al contrato para eliminar los porcentajes, sólo dejar valores en los desembolsos y utilizaciones.', 11, '2014-01-28', '2014-02-28', 2, 'El compromiso se encuentra en tramite, no registra una fecha exacta', 1, 2),
(37, 'Actualizar el Informe Mensual y el ejecutivo.', 12, '2014-02-24', '2014-02-17', 2, 'No tiene observaciones', 1, 3),
(38, 'Cronograma de entrada en producción por módulo', 13, '2014-02-28', '2014-02-19', 2, 'No tiene observaciones', 1, 4),
(39, 'Comparar las tipologias del sistema de calidad de la interventoria contra las del sistema de informacion de PVDs y KVDs y generar los documentos aprobados.', 14, '2014-02-28', '2014-02-20', 2, 'No tiene observaciones', 1, 5),
(40, 'Enviar tipologias de PQR y presentacion del sistema de informacion del operador', 14, '2014-02-21', '2014-02-20', 2, 'No tiene observaciones', 1, 5),
(41, 'Enviar al interventor los diseños de web services de instituciones publicas', 14, '2014-02-21', '2014-02-20', 2, 'No tiene observaciones', 1, 5),
(42, 'Modulo documental ', 13, '2014-03-07', '2014-02-19', 1, 'El plazo maximo para cumplir con el compromiso es la primera semana de marzo de 2014.', 1, 4),
(43, 'Anexo caracterizacion', 15, '2014-01-29', '2014-01-28', 2, 'No tiene observaciones', 1, 2),
(44, 'Socializacion estrategias metodologicas', 15, '2014-02-03', '2014-01-28', 2, 'No tiene observaciones', 1, 2),
(45, 'Definición de catalogación de Rural y Urbano.', 17, '2014-04-28', '2014-04-22', 1, 'No tiene Observaciones', 1, 9),
(46, 'Crirterios de Elegibilidad de CPE', 17, '2014-04-22', '2014-04-22', 2, 'No tiene observaciones', 1, 9),
(47, 'Borrador de Carta de presentación para Potenciales beneficiarios (KVD e IP)', 17, '2014-04-28', '2014-04-22', 2, 'remitida la carta al Operador para ser presentada en campo', 1, 9),
(48, 'Incluir en los formatos de Estudios de Campo de KVD los criterios de elegibilidad de CPE', 17, '2014-04-25', '2014-04-22', 1, 'No tiene observaciones', 1, 9),
(49, 'Sustentación de metas de cada indicador de apropiación (densidad de población, infraestructura, horario de KVD)', 17, '2014-05-12', '2014-04-22', 2, 'Para la reunion del 20 de Mayo', 1, 9),
(50, 'Duración de las fases sustentadas con el Anexo Técnico.', 17, '2014-05-12', '2014-04-22', 1, 'No tiene observaciones', 1, 9),
(51, 'Revisión sobre las condiciones de servicio de los 596 Kioscos adicionales', 19, '2014-01-20', '2014-01-16', 2, 'No tiene observaciones', 1, 1),
(52, 'Datos de la radicacion ante el Min Interior de los 175 puntos donde instalaran torres, fueron entregadas las coordenadas.', 19, '2014-01-17', '2014-01-16', 2, 'No tiene observaciones', 1, 1),
(53, 'Revision de la capacidad de transporte al cabo de los 5 años. Ver adenda 2', 19, '2014-01-24', '2014-01-16', 2, 'No tiene observaciones', 1, 1),
(54, 'Consulta ante el Min Interior del avance de la radicacion de ANDIRED', 19, '2014-01-21', '2014-01-16', 2, 'No tiene observaciones', 1, 1),
(55, 'Licencia Ambiental-presentacion del proyecto ante la ANLA y formalizar el contacto-para verificar si requiere de un permiso ambiental.', 19, '2014-01-24', '2014-01-16', 2, 'No tiene observaciones', 1, 1),
(56, 'Reunion fuerzas militares- ANIDRED- miercoles o jueves de la semana del 20 de enero, confirmar agenda.', 19, '2014-01-17', '2014-01-16', 2, 'No tiene observaciones', 1, 1),
(57, 'Suministro de informacion de contacto de los gestores TIC', 19, '2014-01-16', '2014-01-16', 2, 'No tiene observaciones', 1, 1),
(58, 'Cronograma de visitas de campo-apoyo en la definicion de sitios', 19, '2014-01-31', '2014-01-16', 2, 'No tiene observaciones', 1, 1),
(59, 'Listado de sitios del proyecto Kioscos', 19, '2014-01-17', '2014-01-16', 2, 'No tiene observaciones.', 1, 1),
(60, 'Enviar los anexos requeridos para el tema de Consulta Previa respecto al informe del mes de marzo de 2014.\r\n', 20, '2014-05-05', '2014-04-29', 2, 'No tiene observaciones', 1, 10),
(61, 'Enviar respuesta a las observaciones frente al tema Ambiental relacionado con el informe del mes de marzo de 2014.\r\n', 20, '2014-05-05', '2014-04-29', 2, 'No tiene observaciones', 1, 10),
(62, 'Informar sobre los resultados de la reunión del 29 de abril adelantada con el Ministerio del Interior\r\n', 20, '2014-05-05', '2014-04-29', 2, 'No tiene observaciones', 1, 10),
(63, 'Realizar un cuadro por ejes temáticos (Reuniones Institucionales, Trámites, Fases/Etapas), los cuales  incluirán dentro del informe mensual presentado por la UT Andired. \r\n', 20, '2014-05-08', '2014-04-29', 2, 'No tiene observaciones.', 1, 10),
(64, 'Reunión de avance del Informe detallado de Ingeniería Logística, Plan de Transmisión y  Plan de Pruebas y puesta en servicio', 21, '2014-05-28', '2014-05-14', 1, 'se tienen programadas reuniones de avance hasta el 27 de junio de 2014', 1, 12),
(65, 'Reunión de avance delos Planes de Desarrollo de Web Services y Sistemas de Información.', 22, '2014-05-29', '2014-05-16', 1, ' se tienen programadas reuniones de avance hasta el 27 de junio de 2014', 1, 14),
(66, 'Ajustar el ambiente dispuesto para pruebas con la funcionalidad que implementa los formatos aprobados para los estudios de campo. ', 23, '2014-05-19', '2014-05-16', 1, 'No tiene observaciiones', 1, 15),
(67, 'Nueva convocatoria para pruebas funcionales para la aplicación de estudios de campo ', 23, '2014-05-20', '2014-05-16', 1, 'No tiene observaciones.', 1, 15),
(68, 'Reglamento del Comité Directivo', 24, '2014-03-17', '2014-02-07', 2, 'Compromiso para la proxima reunion de comite directivo', 1, 1),
(69, 'Oficialización implementación KVDs adicionales', 24, '2014-02-11', '2014-02-07', 2, 'No tiene observaciones.', 1, 1),
(70, 'Entrega primer grupo de Web Services', 24, '2014-02-12', '2014-02-07', 2, 'No tiene observaciones.', 1, 1),
(71, 'Entrega segundo grupo de Web Services', 24, '2014-05-02', '2014-02-07', 2, 'Comunicado PNCAV-DIRCON-OPER-044-14', 1, 1),
(72, 'Metodología de Seguimiento de Evaluación y Avance del Proyecto', 24, '2014-02-21', '2014-02-07', 2, 'para aprobación en el Comité Directivo No. 4', 1, 1),
(73, 'Entrega Agente de Monitoreo', 24, '2014-06-02', '2014-02-07', 3, 'Compromiso para Junio de 2014.', 1, 1),
(75, 'Mesa de trabajo definición de Metodología de Evaluación y seguimiento al avance del Proyecto', 25, '2014-03-21', '2014-03-17', 2, 'No tiene observaciones.', 1, 2),
(76, 'Aprobación Metodología de Evaluación y seguimiento al avance del Proyecto', 25, '2014-04-29', '2014-03-17', 1, 'Compromiso para el Comite directivo N° 3', 1, 2),
(78, 'Entrega Agente de Monitoreo', 25, '2014-06-02', '2014-03-17', 1, 'Compromiso para Junio de 2014', 1, 2),
(79, 'Coordinar reunión entre el Contratista y las Fuerzas Militares', 25, '2014-02-21', '2014-03-17', 3, 'No tiene observaciones.', 1, 2),
(80, 'Metodología de Donación', 25, '2014-04-29', '2014-03-17', 1, 'Compromiso para comite directivo N° 3', 1, 2),
(81, 'Entrega de Plan de Licencias y Permisos', 25, '2014-04-03', '2014-03-17', 1, 'No tiene observaciones', 1, 2),
(82, 'Realizar las modificaciones al Contrato de Fiducia, Contrato de Mandato y Reglamento de Comité Fiduciario.', 25, '2014-04-29', '2014-03-17', 1, 'Mediante  comité fiduicario No.1  del 25 de junio de 2014 se aprobó el Reglamento fiduciario  y minuta de otrosi al contrato de Fiducia, queda pendiente: \r\nForma del Otrosi  y Entrega del contarto de Mandato firmado', 1, 2),
(83, 'Radicación de solicitud de Licencia Ambienta en Pana pana', 25, '2014-03-31', '2014-03-17', 1, 'No tiene observaciones.', 1, 2),
(84, 'Envío metodología de seguimiento y evaluación de avance', 26, '2014-05-02', '2014-04-29', 1, 'No tiene observaciones.', 1, 3),
(85, 'Revisión de los intereses moratorios por el giro extemporáneo de los 32.996 pesos correspondientes a intereses del mes de febrero de 2014. ', 26, '2014-05-09', '2014-04-29', 2, 'No tiene observaciones.', 1, 3),
(86, 'Programar reunión con las Fuerzas Militares', 26, '2014-05-16', '2014-04-29', 2, 'Realizada el viernes 16 de mayo de 2014.', 1, 3),
(87, 'reunión con el director de la Fiducia para solicitar mejora en los procesos.', 26, '2014-05-16', '2014-04-29', 1, 'No tiene observaciones.', 1, 3),
(88, 'Cambio de Representante Legal de la UT', 26, '2014-05-05', '2014-04-29', 2, 'No tiene observaciones.', 1, 3),
(91, 'Entrega de Logos para la impresión de las cartillas de la Encuesta', 29, '2014-02-03', '2014-02-03', 2, 'No tiene observaciones', 1, 4),
(92, 'Reunión de avance de Estudio de Desarrollo, Impacto y Apropiación.', 29, '2014-02-28', '2014-02-03', 2, 'No tiene observaciones', 1, 4),
(93, 'Incluir la pregunta “Se ve estudiando de forma Virtual??? en la Actualización del Estudio de Desarrollo, impacto y apropiación.', 29, '2014-02-03', '2014-02-03', 2, 'En constante actualizacion', 1, 4),
(94, 'Organizar la documentación visual por cada municipio y/o ANM', 29, '2014-02-03', '2014-02-03', 1, 'Entrega de la informacion.', 1, 4),
(95, 'Entrega de información para el desarrollo de web Service – Plan de desarrollo del Web Service', 30, '2014-05-15', '2014-02-07', 1, 'No tiene observaciones.', 1, 5),
(96, 'Manejo Contable del Patrimonio Autónomo.', 31, '2014-02-18', '2014-02-14', 2, 'No tiene observaciones.', 1, 6),
(97, 'Borrador contrato de Donación', 31, '2014-02-18', '2014-02-14', 2, 'No tiene observaciones.', 1, 6),
(98, 'Envío Flujograma para revisión.', 31, '2014-02-18', '2014-02-14', 1, 'No tiene observaciones.', 1, 6),
(99, 'Identificar en cada municipio quien es el donatario autorizado para firmar el acto de donación', 31, '2014-02-14', '2014-02-14', 1, 'Compromiso- Estudios de campo.', 1, 6),
(100, 'Conocer qué cargo de cada tipo de beneficiario (IE, Salud, Policía, etc) quien está autorizado para firmar el acta de recibo de los equipos a donar, mientras se protocoliza la donación.', 31, '2014-02-14', '2014-02-14', 1, 'Compromiso- Estudios de campo.', 1, 6),
(101, 'Propuesta para cambio del tiempo para la donación en los 953 KVD', 31, '2014-02-28', '2014-02-14', 2, 'No tiene observaciones.', 1, 6),
(102, 'Envío acta respuesta de la Dirección de Industria de Comunicaciones del Ministerio TIC', 32, '2014-05-08', '2014-05-07', 1, 'No tiene observaciones.', 1, 9),
(103, 'Matriz de trámites de identificación de tramites a realizar  (consultas previas, licencias permisos, entre otros) junto con el avance', 32, '2014-05-13', '2014-05-07', 1, 'No tiene observaciones.', 1, 9),
(104, 'Revisión de cronograma propuesto vs la matriz de trámites. Depende del ítem anterior.', 32, '2014-05-16', '2014-05-07', 1, 'No tiene observaciones', 1, 9),
(105, 'Envio ruta critica actualizada. Presentar rutas de acuerdo con las metas intermedias', 32, '2014-05-13', '2014-05-07', 1, 'No tiene observaciones.', 1, 9),
(106, 'Propuesta de alcance de contenido de Visita a Sitios.', 32, '2014-05-09', '2014-05-07', 3, 'deben incluirse la totalidad de los estudios de campo de centros problados de todos los municipios.\r\n', 1, 9),
(111, 'Sistema de informacion para control de obligaciones contractuales de las 3 partes.', 27, '2014-05-30', '2014-03-19', 1, 'Esta herramienta esta en desarrollo', 1, 6),
(112, 'Definicion de insumos para las metas de apropiacion: Licitacion Mintic, linea base, oportunidad para definir las metas VS Crono de instalacion y plan de apropiacion del contratista.', 27, '2014-05-06', '2014-03-19', 2, 'Programadas 3 reuniones de definición de indicadores.', 1, 6),
(113, 'Plan de calidad -reunion observaciones Conika', 27, '2014-04-15', '2014-03-19', 1, 'Reunion realizada y radicada la version actualizada', 1, 6),
(114, 'Planeacion estrategica PVD-Reunion interventoria revisa anexos y propone actividades y cronograma', 27, '2014-04-09', '2014-03-19', 1, 'No tiene observaciones', 1, 6),
(115, 'Definitivo procedimiento de Donación.', 27, '2014-04-07', '2014-03-19', 1, 'No tiene observaciones.', 1, 6),
(116, 'Metodologia de evaluación y seguimiento indicadores en el sistema de informacion.', 27, '2014-06-13', '2014-03-19', 1, 'Se incluyo el modulo para el desarrollo.', 1, 6),
(117, 'Programar reunion para revisar la version mas actualizada del manual de imagen y mobiliario de las estrategias PVD,PVD+ Y KVD', 27, '2014-04-28', '2014-03-19', 2, 'No tiene observaciones.', 1, 6),
(118, 'La direccion de conectividad construira un check list para la verificacion del informe de la interventoria y emitir concepto de cumplimiento o de observaciones al mismo', 27, '2014-05-15', '2014-03-19', 2, 'remitido con el informe No. 4 de abril.', 1, 6),
(119, 'Se solicita a la interventoria verificar los indicadores de calidad y niveles de servicio para las estrategias de PVD, PVD+, Instituciones publicas, zonas Wifi definidos y no definidos en los documentos contractuales, con el fin de evidenciar las precisiones que se deben dar al mismo', 27, '2014-06-13', '2014-03-19', 1, 'No tiene observaciones.', 1, 6),
(120, 'Comparar los indicadores de las estrategias con respecto a los indicadores de la red, con el fin de que haya coherencia entre los mismo.', 27, '2014-06-13', '2014-03-19', 1, 'No tiene observaciones.', 1, 6),
(121, 'Remitir a la Interventoría la versión final de los Web Services (Red de Transporte, Wifi, Instituciones Públicas, y actualización KVD), mediante correo electrónico.', 33, '2014-05-26', '2014-05-23', 2, 'No tiene observaciones', 1, 19),
(122, 'Rvisión de las versiones finales de los Web Services a entregar la Dirección de Conectividad.', 33, '2014-05-27', '2014-05-23', 2, 'No tiene observaciones', 1, 19),
(123, 'Realizar la entrega de los Web Services (Red de Transporte, Wifi, Instituciones Públicas, y actualización KVD) a la UT Andired, mediante comunicado', 33, '2014-05-28', '2014-05-23', 2, 'No tiene observaciones', 1, 19),
(124, 'Consulta al interiror del ministerio TIC como presentar el proyecto a la comision intersectorial de infraestructura en el marco del CONPES PINES 3762 Proyectos de interes nacional estrategicos', 34, '2014-03-08', '2014-03-05', 2, 'No tiene observaciones', 1, 0),
(125, 'Cronograma de consulta previa teniendo en cuenta las fechas metas de Enero 2015 y Agosto del 2015 para el grupo A', 34, '2014-03-08', '2014-03-05', 1, 'No tiene observaciones.', 1, 7),
(126, 'Consolidado de informacion faltante por parte del MinInterior', 34, '2014-03-08', '2014-03-05', 1, 'No tiene observaciones.', 1, 7),
(127, 'Solicitud de reunion con MinInterior lo antes posible', 34, '2014-03-06', '2014-03-05', 2, 'No tiene observaciones.', 1, 7),
(128, 'Revisión cronograma de actividades PVD y PVD+', 35, '2014-06-03', '2014-05-29', 1, 'No tiene observaciones.', 1, 4),
(129, 'Envío a la UT Andired metodologías de la Interventoría aprobadas por el MINTIC', 35, '2014-06-06', '2014-05-29', 1, 'Sin observaciones.', 1, 4),
(130, 'Envío documento de Incoder', 35, '2014-06-06', '2014-05-29', 1, 'No tiene observaciones', 1, 4),
(131, 'Se requiere conocer el procedimiento detallado del proceso de escrituración, con las actividades de todos los involucrados entre ellos el patrimonio autónomo, el contratista y el ente territorial - flujograma', 36, '2014-02-14', '2014-02-10', 1, 'No tiene observaciones', 1, 2),
(132, 'Radicar observaciones finales del Documento General de Planeación', 37, '2014-05-23', '2014-05-23', 2, 'No tiene observaciones', 1, 20),
(133, 'Radicar observaciones finales del E.D.I.A', 37, '2014-05-23', '2014-05-23', 2, 'No tiene observaciones', 1, 20),
(134, 'Suscribir Acuerdo de Confidencialidad', 38, '2014-06-07', '2014-05-27', 1, 'Ademas de la Unión temporal Andired como responsable de este compromiso, tambien es responsable el Sargento Blanco de las Fuerzas Militares.', 1, 21),
(135, 'Remitir la Información consolidada de las Bases donde estarían\r\nproyectados los puntos de la UT Andired', 38, '2014-06-13', '2014-05-27', 1, 'El responsable de este compromiso son las fuerzas militares de colombia', 1, 21),
(136, 'Solicitar las Coordenadas de manera Formal', 38, '2014-06-09', '2014-05-27', 1, 'No tiene observaciones', 1, 21),
(137, 'Estudiar posibilidad de remitir estudios de sitio realizado entre las\r\nfuerzas armadas y Motorola.', 38, '2014-06-09', '2014-05-27', 1, 'El responsable de este compromiso, son las fuerzas militares.', 1, 21),
(138, 'Remitir Documento de Indicadores de Apropiación', 39, '2014-06-13', '2014-05-30', 1, 'No tiene observaciones', 1, 22),
(139, 'Reunión de Consolidación de Observaciones al Documento de Indicadores presentado por la UT.', 39, '2014-06-17', '2014-05-30', 2, 'Se realizó la reunión el 17 de junio de 2014\r\n', 1, 22),
(140, 'Reunión de verificación de documento de Indicadores', 39, '2014-06-18', '2014-05-30', 2, 'Se realizó la reunión el 18 de junio\r\n', 1, 22),
(141, 'Entrega de los documentos  de Web Services (KVD, PVD e Instituciones Públicas actualizados ', 40, '2014-05-22', '2014-05-19', 1, 'No tiene observaciones', 1, 18),
(142, 'Enviar propuesta de variables para los Web Services de WIFI y de Municipios ', 40, '2014-05-22', '2014-05-19', 1, 'No tiene observaciones.', 1, 18),
(143, 'Se programa mesa de trabajo Web Services', 40, '2014-05-23', '2014-05-19', 1, 'No tiene observaciones.', 1, 18),
(144, 'Envío cuadro de Compromisos actualizado a las partes', 43, '2014-05-14', '2014-05-13', 1, 'No tiene observaciones.', 1, 8),
(145, 'Envío cuadro de tareas internas', 43, '2014-05-14', '2014-05-13', 1, 'No tiene observaciones', 1, 8),
(146, 'Remitir la Tabla de Contenido del Plan de Apropiación indicando\r\navance', 44, '2014-06-10', '2014-06-05', 1, 'No tiene observaciones', 1, 23),
(147, 'Envío documento de Plan de apropiación actualizado con su tabla de\r\ncontenido que evidencia el avance del mismo', 44, '2014-06-13', '2014-06-05', 1, 'No tiene observaciones', 1, 23),
(148, 'Reunión sobre el contenido de los capítulos finalizados (verde)\r\npresentado por la UT.', 44, '2014-06-18', '2014-06-05', 2, 'Se realizó la reunión el 18 de junio\r\n', 1, 23),
(149, 'Reunión de verificación delPlan de Apropiación UT', 44, '2014-06-18', '2014-06-05', 1, 'No tiene observaciones.', 1, 23),
(150, 'Remitir el avance del ConceptoCreativo', 45, '2014-06-11', '2014-06-05', 2, 'No tiene observaciones', 1, 26),
(151, 'Entrega del Proceso de Uso de Marca de MINTIC y Vive Digital para Conexiones Digitales (Hogares)', 45, '2014-06-11', '2014-06-05', 1, 'No tiene observaciones', 1, 26),
(152, 'Reunión para validar el avance del Plan Comunicaciones con la inclusión del Concepto Creativo', 45, '2014-06-13', '2014-06-05', 2, 'No tiene observaciones.', 1, 26),
(153, 'Entrega del avance del Plan de Comunicaciones', 45, '2014-06-18', '2014-06-05', 2, 'No tiene observaciones.', 1, 26),
(154, 'Reunión de verificación del avance del Plan de Comunicaciones', 45, '2014-06-23', '2014-06-05', 2, 'No tiene observaciones.', 1, 26),
(155, 'Envió de documentos ajustados', 46, '2014-06-13', '2014-06-10', 1, 'No tiene observaciones', 1, 36),
(156, 'Envió de revisión final del documento', 46, '2014-06-20', '2014-06-10', 1, 'No tiene observaciones', 1, 36),
(157, 'Envió de la retroalimentación a informe final.', 46, '2014-06-25', '2014-06-10', 1, 'No tiene observaciones', 1, 36),
(158, 'Remitir el Contenido Conciliado del Plan de Apropiación ', 47, '2014-05-18', '2014-05-16', 2, 'La Interventoría envió a la UT Andired, la propuesta de Contenido del Plan de Apropiación por correo electrónico el 18 de mayo \r\n', 1, 17),
(159, 'Reunión de verificación sobre el avance del Plan de Apropiación', 47, '2014-06-05', '2014-05-16', 2, 'La reunión se realizó el jueves 5 de junio a las 8:00 am\r\n', 1, 17),
(160, 'Reunión de verificación sobre el avance del Plan de Comunicaciones', 47, '2014-06-05', '2014-05-16', 2, 'La reunión se realizó el jueves 5 de junio a las 10:00 am\r\n', 1, 17),
(161, 'Remitir documento de avance del Informe de Visitas a Sitios', 48, '2014-06-13', '2014-06-06', 1, 'No tiene observaciones', 1, 29),
(162, 'Envío primer borrador final delInforme de Visita a Sitios', 48, '2014-06-20', '2014-06-06', 1, 'No tiene observaciones', 1, 29),
(163, 'Retroalimentación de Observaciones del Informe de Visitas a Sitios.', 48, '2014-06-24', '2014-06-06', 1, 'No tiene observaciones', 1, 29),
(164, 'Remitir documento diligenciado para conciliación y evaluación', 49, '2014-06-10', '2014-06-06', 1, 'No tiene observaciones', 1, 30),
(165, 'Realizar evaluación de los Indicadores del mes de Mayo de 2014', 49, '2014-06-11', '2014-06-06', 1, 'No tiene observaciones', 1, 30),
(166, 'Presentar resultados de Indicadores del Mes de Mayo de 2014', 49, '2014-06-13', '2014-06-06', 1, 'No tiene observaciones', 1, 30),
(167, 'Remitir avance del Contenido del Plan de Marketing y Comercialización', 50, '2014-06-13', '2014-06-06', 1, 'No tiene observaciones', 1, 28),
(168, 'Envío primer borrador final delPlan de Marketing y Comercialización con sus respectivos anexos', 50, '2014-06-20', '2014-06-06', 1, 'No tiene observaciones', 1, 28),
(169, 'Retroalimentación de Observaciones del Plan.', 50, '2014-06-24', '2014-06-06', 1, 'No tiene observaciones', 1, 28),
(170, 'Radicación del Plan de Marketing y Comercialización', 50, '2014-06-27', '2014-06-06', 1, 'No tiene observaciones', 1, 28),
(171, 'Entregar avance del informe logístico  con referente a las oportunidades de mejora.', 51, '2014-06-17', '2014-06-10', 2, 'El compromiso se cierra el 10 de Julio de 2014, con la entrega de la informacion solicitada', 1, 35),
(172, 'Presentar nuevo avance con el detalle de todos los temas cubiertos en la reunión incluyendo Cronogramas de Mantenimiento ', 52, '2014-06-13', '2014-06-06', 1, 'No tiene observaciones', 1, 33),
(173, 'Envió de revisión final del documento', 52, '2014-06-20', '2014-06-06', 1, 'No tiene observaciones', 1, 33),
(174, 'Envió de la retroalimentación a informe final.', 52, '2014-06-24', '2014-06-06', 1, 'No tiene observaciones', 1, 33),
(182, 'Presentación del Avance del Plan de Operación y Mantenimiento, Plan de Instalación y Plan de Integración.', 55, '2014-06-05', '2014-05-15', 1, 'No tiene observaciones', 1, 13),
(183, 'Entrega del tercer avance del plan de comunicaciones', 56, '2014-06-19', '2014-06-13', 2, 'No tiene observaciones', 1, 38),
(184, 'Consultar las pautas en espacios gratuitos en television comunitaria', 56, '2014-06-24', '2014-06-13', 1, 'No tiene observaciones', 1, 38),
(185, 'Reunion de verificacion del avance del plan de comunicaciones', 56, '2014-06-24', '2014-06-13', 2, 'No tiene observaciones', 1, 38),
(186, 'Evío comunicacion al Mininterior solicitando acompañamiento para la consecucion de los datos de contacto pendiente de la respuesta a la consulta previa solicitada por el contratista', 60, '2014-06-13', '2014-06-11', 1, 'No tiene observaciones.', 1, 10),
(187, 'Entrega de listado de municipios para el primer 30% y las torres y el estado de los tramites de cada una de ellas.', 60, '2014-06-13', '2014-06-11', 1, 'No tiene observaciones', 1, 10),
(188, 'Simulacion de los elementos y actividades a ejecutar', 60, '2014-06-20', '2014-06-11', 1, 'No tiene observaciones', 1, 10),
(189, 'Entrega de estudios de campo para revisión de la interventoria', 60, '2014-06-13', '2014-06-11', 1, 'No tiene observaciones', 1, 10),
(190, 'Envio listado de beneficiarios depurado', 60, '2014-06-13', '2014-06-11', 2, 'No tiene observaciones', 1, 10),
(191, 'Envió de documentos ajustados', 61, '2014-06-13', '2014-06-06', 1, 'No tiene observaciones', 1, 34),
(192, 'Reunion de revision al informe enviado', 61, '2014-06-17', '2014-06-06', 1, 'No Tiene observaciones', 1, 34),
(193, 'Envío de documentos ajustados', 61, '2014-06-20', '2014-06-06', 1, 'No tiene observaciones', 1, 34),
(194, 'Reunion de revision al informe enviado', 61, '2014-06-24', '2014-06-06', 1, 'No tiene observaciones', 1, 34),
(195, 'Envio de documentos ajustados', 62, '2014-06-20', '2014-06-18', 1, 'No tiene observaciones', 1, 40),
(196, 'Reunion de revision al informe enviado', 62, '2014-06-24', '2014-06-18', 1, 'No tiene observaciones', 1, 40),
(197, 'Envio de los puertos que utiliza el aplicativo SIMONTIC', 63, '2014-06-24', '2014-06-20', 1, 'No tiene observaciones.', 1, 42),
(198, 'Envio documento final de plan de desarrollo y web services', 63, '2014-06-25', '2014-06-20', 1, 'No tiene observaciones', 1, 42),
(199, 'Envio de documentos ajustados', 64, '2014-06-24', '2014-06-20', 1, 'No tiene observaciones', 1, 41),
(200, 'Reunion de revision al informe enviado', 64, '2014-06-25', '2014-06-20', 1, 'No tiene observaciones', 1, 41),
(201, 'Entrega final del informe logisitico', 66, '2014-06-27', '2014-06-25', 2, 'El compromiso se cierra con la entrega de los planes mediante comunicado PNCAV-UTAR-SRT-095-14, radicado el 27 de Junio de 2014', 1, 44),
(202, 'Actualizar Matriz de Riesgos segun las particularidades del proyecto.', 67, '2014-05-23', '2014-05-16', 1, 'No tiene observaciones', 1, 16),
(203, 'Incluir los riesgos de HSEQ de proyecto en la matriz como unidades especificas/ categorias', 67, '2014-05-23', '2014-05-16', 1, 'No tiene observaciones', 1, 16),
(204, 'Incluir en el capitulo de politicas lo concerniente a roles y responsabilidades cronograma etc', 67, '2014-05-23', '2014-05-16', 1, 'No tiene observaciones', 1, 16),
(205, 'Presentar documento detallado-estructura plan de gestion de riesgos', 67, '2014-06-05', '2014-05-16', 1, 'No tiene observaciones', 1, 16),
(206, 'Enviar los ajustes solicitados respecto del documento plan de gestion ambiental actual', 67, '2014-05-23', '2014-05-16', 1, 'No tiene observaciones', 1, 16),
(207, 'Programar la siguiente reunion', 67, '2014-05-20', '2014-05-16', 2, 'No tiene observaciones.', 1, 16),
(208, 'Incluir en un solo plan de gestion lo de calidad y HS y enviar los avances', 67, '2014-05-23', '2014-05-16', 1, 'No tiene observaciones', 1, 16),
(209, 'Consultar  las pautas en espacios gratuitos en television comunitaria', 68, '2014-06-25', '2014-06-24', 1, 'No tiene observaciones', 1, 43),
(210, 'Entrega del plan de difusión para revisión por parte del MINTIC antes de ser entregado', 68, '2014-06-26', '2014-06-24', 1, 'No tiene observaciones', 1, 43),
(211, 'Entrega del plan de comunicaciones', 68, '2014-06-27', '2014-06-26', 2, 'No tiene observaciones', 1, 43),
(212, 'Enviar el plan de operacion y mantenimiento actualizado con su respectivo cronograma para revision', 69, '2014-06-20', '2014-06-18', 1, 'No tiene observaciones', 1, 39),
(213, 'Reunion de revision plan de operacion y mantenimiento antes de la entrega final', 69, '2014-06-25', '2014-06-18', 1, 'No tiene observaciones', 1, 39),
(214, 'Envío de documentos con  avances ( Matriz de cuadro de normatividad programa de residuos)', 70, '2014-06-13', '2014-06-12', 2, 'No tiene observaciones', 1, 37),
(215, 'Incluir consideraciones para Choco y para los sitios que son los primeros en plan de instalación', 70, '2014-06-19', '2014-06-12', 1, 'No tiene observaciones.', 1, 37),
(216, 'Incluir en un cronograma las fechas desde las cuales deben empezar a hacer tramites en cada Zona, considerando como hito los tiempos de instalacion.', 70, '2014-06-27', '2014-06-12', 1, 'No tiene observaciones.', 1, 37),
(217, 'Incluir el plan de Gestión ambiental lo pertinente para campamentos', 70, '2014-06-19', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(218, 'Enviar a la interventoria la metodologia o procedimiento para analisis de riesgos de SST', 70, '2014-06-17', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(219, 'Actualizar datos de formatos de inspecciones', 70, '2014-06-19', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(220, 'Enviar indicadores de cumplimiento representativos: PNC, auditorias, capacitaciones, vacunación', 70, '2014-06-17', '2014-06-12', 1, 'No tiene observaciones.', 1, 37),
(221, 'Incluir en informes mensuales el cuadro de indicadores de incidentalidad', 70, '2014-07-01', '2014-06-12', 1, 'La fecha limite del compromiso esta dispuesta a partir del informe de Junio.', 1, 37),
(222, 'Enviar los formatos, procedimientos y demas que ha actualizado en materia de HSEQ', 70, '2014-06-13', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(223, 'Revisar el tema de cunplimiento de coordinador de trabajo en alturas ( Personal y certificación)', 70, '2014-06-19', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(224, 'Entrega de procedimiento de mantenimiento a equipos ( Instrumentos de medicion y equipos de actividades constructivas y laborales)', 70, '2014-06-17', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(225, 'Envio de procedimientos y documentos en los que avance del plan HSEQ', 70, '2014-06-17', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(226, 'Revisar como puede hacer la descripcion en el documento de modo tal que en todas las áreas se subdividan parecido ( estandarizar)', 70, '2014-06-17', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(227, 'Aclarar la valoracion/cuantificacion de los riesgos.', 70, '2014-06-17', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(228, 'Definir los protocolos de riesgos', 70, '2014-06-17', '2014-06-12', 1, 'No tiene observaciones', 1, 37),
(229, 'Revisar alternativas para la contratación del personal para la protocolizacion de consultas previas', 71, '2014-06-30', '2014-06-19', 1, 'No tiene observaciones', 1, 5),
(1212, 'Presentar matriz de licencias y permisos ajustada de acuerdo a los solicitado por el comite  de PINES ( Incluyendo priorizacion por metas volantes y especificando la fecha final requerida)', 644, '2014-07-15', '2014-07-14', 1, 'No tiene observaciones', 1, 49),
(1213, 'Programacion revision de web services', 645, '2014-06-10', '2014-06-06', 1, 'No tiene observaciones', 1, 32),
(1214, 'Envio de documentos ajustados', 645, '2014-06-13', '2014-06-06', 1, 'No tiene observaciones.', 1, 32),
(1215, 'Envio de revision final del documento', 645, '2014-06-20', '2014-06-06', 1, 'No tiene observaciones', 1, 32),
(1216, 'Envio de documentos ajustados', 645, '2014-06-25', '2014-06-06', 1, 'No tiene observaciones', 1, 32),
(1218, 'Envio de la retroalimentacion del informe final', 645, '2014-06-25', '2014-06-06', 1, 'No tiene observaciones', 1, 32),
(1219, 'Presentar cuadro diligenciado con las actividades', 646, '2014-07-09', '2014-07-03', 1, 'No tiene observaciones', 1, 47),
(1220, 'Retroalimentacion del comite Fiduciario', 646, '2014-07-03', '2014-07-03', 1, 'El compromiso se cumplira en la proxima reunion del comite fiduciario', 1, 47),
(1221, 'Extender periodicamente a la interventoria las actividades de apropiacion que se adelanten anterior a su ejecucipn', 650, '2014-07-01', '2014-07-01', 1, 'El compromiso se ejecutara periodicamente.', 1, 46),
(1222, 'Entrega de la base de datos con la tabulacion de las encuestas aplicadas en campo, en el estudio DIA', 650, '2014-07-30', '2014-07-01', 1, 'No tiene observaciones', 1, 46),
(1223, 'Entrega de una primera versión del plan de apropiacion', 651, '2014-06-23', '2014-06-18', 1, 'Esta compromiso corresponde al acta N° 39 A - propuesta Plan de apropiacion', 1, 39),
(1224, 'Ajuste y corrección del informe del mes de Abril', 652, '2014-07-14', '2014-07-10', 1, 'No tiene observaciones', 1, 48),
(1225, 'Ajuste y corrección del informen del mes de mayo', 652, '2014-07-14', '2014-07-10', 1, 'No tiene observaciones', 1, 48),
(1226, 'Revisar de nuevo el manual de imagen y mobiliario de KVD y generar observaciones para socializarlas', 653, '2014-07-25', '2014-07-17', 1, 'No tiene observaciones', 1, 1),
(1227, 'Teniendo en cuenta un manual para el adminstrador de PVD que tiene la interventoria, está realizara la respctiva revision y las modificaciones necesarias para que se aplique al proyecto para luego ser socializado', 653, '2014-07-25', '2014-07-17', 1, 'No tiene observaciones', 1, 1),
(1228, 'Verificar si se realizó o se va a realizar una actualización al manual de imagen y mobiliario de PVD Y PVD+', 653, '2014-07-25', '2014-07-17', 1, 'No tiene observaciones', 1, 1),
(1229, 'Verificar si el proyecto de PVD, en cualquiera de sus fases, maneja un manual para el administrador del punto', 653, '2014-07-25', '2014-07-17', 1, 'No tiene observaciones', 1, 1),
(1230, 'Incluir las definiciones para impacto, probabilidad y vulnerabilidad los cuales debe permitir valoracion cuantitativa y determinada a partir de condiciones conocidas', 654, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 24),
(1231, 'Considerar la vulenerabilidad en el cuadro de analisis de riesgos', 654, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 24),
(1232, 'Considerar la periodicidad con que se analizaran, reevaluraran, actualizaran y presentaran los riesgos', 654, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 24),
(1233, 'Realizar mas entrevistas ( lluvia de ideas) con las diferentes áreas con el fin de avanzar con el diligenciamiento de la matriz de riesgos.', 654, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 24),
(1234, 'Enviar paulatinamente avances sobre las matrices y presentar avances sobre el documento general', 654, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 24),
(1235, 'Cambiar al documento el titulo plan de manejo ambiental PMA por el de plan de gestion ambiental', 655, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 25),
(1236, 'Resumir en tablas las resoluciones y documentos legales ambientales de acuerdo con los ejes o tipos de red o infraestructura y definiendo a que parte del proyecto aplica cada ley o resolucion', 655, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 25),
(1237, 'Cambiar el termino torres por red de transporte y tener en cuenta las demas tipologias de red de acceso a internet, red de terceros y red de acceso o de beneficiarios', 655, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 25),
(1238, 'Pasar todo lo de calidad y de SST al plan de gestion y aseguramiento de la calidad', 655, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 25),
(1239, 'Las metas definidas en el ítem 7.2 deben ser cuantificables', 655, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 25),
(1240, 'Detallar para cada Instalacione el área de influencia directa e indirecta', 655, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 25),
(1241, 'Definir bien los nombres de los sitios en el item llamado Diagnostico', 655, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 25),
(1242, 'Eliminar la teoria y escribir lo aplicable con base en la estrategia del proyecto ( Como se hará la actividad en el proyecto)', 655, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 25),
(1243, 'Envíar los documentos que se vayan generando para revision previa de la interventoria y presentar avances sobre el documento plan de gestion ambiental en la proxima reunion', 655, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 25),
(1244, 'Cambiar el nombre actual del plan por plan de gestion de aseguramiento de calidad', 656, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 27),
(1245, 'Crear formatos e informar a la interventoria y enviar sobre estos los registros de actividades que se han desarrollado con cada informe mensual', 656, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 27),
(1246, 'Entrega de procedimientos documentados que exigen las normas ISO 9001, ISO 14001, y los SST', 656, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 27),
(1247, 'Enviar listados maestros de documentos y registros para identificar si cumple la estructura de acuerdo con el proyecto', 656, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 27),
(1248, 'Incluir en el plan de gestión de aseguramiento de la calidad todo lo relacionado con SST', 656, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 27),
(1249, 'Aplicar lineamientos de la version 2008 de la ISO 9001, esto es reemplazar el termino clientes por partes interesadas y considerar capacitaciones y entrenamiento específicos por cargo y funciones ( ej se debe nombrar coordinador de trabajo en alturas)', 656, '2014-06-12', '2014-06-05', 1, 'No tiene observaciones', 1, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compromiso_estado`
--

CREATE TABLE IF NOT EXISTS `compromiso_estado` (
  `ces_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado del compromiso',
  `ces_nombre` varchar(30) NOT NULL COMMENT 'Nombre del estado del compromiso',
  PRIMARY KEY (`ces_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los estados de los compromisos' AUTO_INCREMENT=4 ;

--
-- Volcado de datos para la tabla `compromiso_estado`
--

INSERT INTO `compromiso_estado` (`ces_id`, `ces_nombre`) VALUES
(1, 'Abierto'),
(2, 'Cerrado'),
(3, 'Sin respuesta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `compromiso_responsable`
--

CREATE TABLE IF NOT EXISTS `compromiso_responsable` (
  `cor_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del responsable',
  `com_id` int(11) NOT NULL COMMENT 'Id del compromiso',
  `usu_id` int(11) NOT NULL COMMENT 'Id del usuario responsable de este compromiso',
  PRIMARY KEY (`cor_id`),
  KEY `FK_COMPROMISO_COMPROMISO` (`com_id`),
  KEY `FK_COMPROMISO_USUARIO` (`usu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los responsables de los compromisos' AUTO_INCREMENT=319 ;

--
-- Volcado de datos para la tabla `compromiso_responsable`
--

INSERT INTO `compromiso_responsable` (`cor_id`, `com_id`, `usu_id`) VALUES
(1, 1, 94),
(3, 3, 94),
(6, 6, 87),
(7, 7, 87),
(8, 8, 87),
(9, 9, 87),
(10, 10, 86),
(11, 11, 87),
(12, 12, 87),
(13, 13, 87),
(14, 14, 94),
(15, 15, 86),
(16, 16, 94),
(17, 17, 94),
(18, 18, 86),
(19, 19, 88),
(20, 20, 86),
(21, 21, 88),
(22, 22, 87),
(23, 23, 94),
(24, 24, 87),
(25, 25, 94),
(26, 25, 86),
(27, 26, 87),
(28, 27, 94),
(29, 28, 87),
(30, 29, 87),
(31, 30, 87),
(32, 31, 87),
(33, 32, 86),
(34, 32, 94),
(35, 33, 86),
(36, 33, 94),
(37, 33, 87),
(38, 34, 94),
(39, 35, 94),
(40, 35, 86),
(41, 36, 86),
(42, 39, 94),
(43, 40, 86),
(44, 41, 86),
(45, 38, 94),
(46, 42, 94),
(47, 37, 94),
(48, 43, 86),
(49, 44, 87),
(50, 45, 86),
(51, 45, 94),
(52, 45, 87),
(53, 46, 86),
(54, 47, 86),
(55, 47, 94),
(56, 48, 87),
(57, 49, 86),
(58, 49, 87),
(59, 50, 87),
(60, 51, 86),
(61, 51, 87),
(62, 51, 94),
(63, 52, 87),
(64, 53, 87),
(65, 54, 86),
(66, 55, 87),
(67, 56, 86),
(68, 57, 86),
(69, 58, 86),
(70, 60, 87),
(71, 61, 87),
(72, 62, 87),
(73, 63, 87),
(74, 64, 86),
(75, 64, 94),
(76, 64, 87),
(77, 65, 86),
(78, 65, 94),
(79, 65, 87),
(80, 66, 87),
(81, 67, 87),
(82, 67, 94),
(83, 59, 86),
(85, 69, 87),
(86, 70, 86),
(87, 71, 86),
(88, 72, 86),
(89, 72, 87),
(90, 73, 86),
(91, 75, 86),
(92, 75, 94),
(93, 75, 87),
(95, 78, 86),
(96, 79, 86),
(97, 80, 94),
(98, 81, 87),
(99, 82, 87),
(100, 82, 86),
(101, 83, 87),
(102, 84, 94),
(103, 85, 94),
(104, 85, 86),
(105, 87, 87),
(106, 88, 87),
(109, 2, 86),
(110, 91, 86),
(111, 92, 86),
(112, 93, 87),
(113, 94, 87),
(114, 96, 87),
(115, 97, 87),
(116, 98, 94),
(117, 99, 87),
(118, 100, 87),
(119, 101, 87),
(120, 102, 87),
(121, 103, 87),
(122, 104, 94),
(123, 105, 87),
(124, 106, 86),
(125, 106, 94),
(126, 76, 94),
(127, 86, 86),
(128, 68, 94),
(129, 106, 87),
(130, 111, 94),
(131, 112, 94),
(132, 112, 86),
(133, 113, 94),
(134, 114, 94),
(135, 115, 94),
(136, 116, 94),
(137, 117, 94),
(138, 118, 86),
(139, 119, 94),
(140, 120, 94),
(141, 121, 86),
(142, 122, 86),
(143, 123, 86),
(144, 124, 86),
(145, 125, 87),
(146, 126, 87),
(147, 127, 86),
(148, 128, 86),
(149, 129, 94),
(150, 130, 87),
(151, 132, 94),
(152, 133, 94),
(153, 134, 87),
(154, 131, 86),
(155, 131, 94),
(156, 131, 87),
(157, 136, 87),
(158, 138, 87),
(159, 139, 86),
(160, 139, 94),
(161, 140, 86),
(162, 140, 94),
(163, 140, 87),
(164, 141, 86),
(165, 142, 94),
(166, 143, 86),
(167, 143, 94),
(168, 144, 94),
(169, 145, 86),
(170, 146, 87),
(171, 147, 87),
(172, 148, 86),
(173, 148, 94),
(174, 149, 86),
(175, 149, 94),
(176, 149, 87),
(177, 150, 87),
(178, 151, 86),
(179, 152, 87),
(180, 153, 87),
(181, 154, 86),
(182, 154, 94),
(183, 154, 87),
(184, 155, 87),
(185, 156, 87),
(186, 157, 94),
(187, 158, 94),
(188, 159, 86),
(189, 159, 94),
(190, 159, 87),
(191, 160, 86),
(192, 160, 94),
(193, 160, 87),
(194, 161, 87),
(195, 162, 87),
(196, 163, 94),
(197, 163, 86),
(198, 164, 87),
(199, 165, 86),
(200, 165, 94),
(201, 166, 86),
(202, 166, 94),
(203, 166, 87),
(204, 167, 87),
(205, 168, 87),
(206, 169, 94),
(207, 169, 86),
(208, 170, 87),
(209, 171, 87),
(210, 172, 87),
(211, 173, 87),
(212, 174, 94),
(213, 174, 86),
(219, 182, 87),
(220, 183, 87),
(221, 184, 86),
(222, 185, 86),
(223, 185, 94),
(224, 185, 94),
(225, 186, 87),
(226, 187, 87),
(227, 188, 87),
(228, 189, 87),
(229, 190, 94),
(230, 191, 87),
(231, 192, 87),
(232, 192, 94),
(233, 193, 87),
(234, 194, 87),
(235, 194, 94),
(236, 195, 87),
(237, 196, 87),
(238, 196, 94),
(239, 197, 86),
(240, 198, 87),
(241, 199, 87),
(242, 200, 86),
(243, 200, 94),
(244, 200, 87),
(245, 201, 87),
(246, 202, 87),
(247, 203, 87),
(248, 204, 87),
(249, 205, 87),
(250, 206, 87),
(251, 207, 94),
(252, 208, 87),
(253, 209, 86),
(254, 210, 87),
(255, 211, 87),
(256, 212, 87),
(257, 213, 94),
(258, 214, 87),
(259, 215, 87),
(260, 216, 87),
(261, 217, 87),
(262, 218, 87),
(263, 219, 87),
(264, 220, 87),
(265, 221, 87),
(266, 222, 87),
(267, 223, 87),
(268, 224, 87),
(269, 225, 87),
(270, 226, 87),
(271, 227, 87),
(272, 228, 87),
(273, 229, 86),
(274, 229, 94),
(275, 229, 87),
(278, 1212, 87),
(280, 1213, 94),
(281, 1213, 86),
(282, 1213, 87),
(283, 1214, 87),
(284, 1215, 87),
(285, 1216, 94),
(287, 1218, 94),
(288, 1219, 87),
(289, 1220, 86),
(290, 1221, 87),
(291, 1222, 87),
(292, 1223, 87),
(293, 1224, 87),
(294, 1225, 87),
(295, 1226, 94),
(296, 1227, 94),
(297, 1228, 86),
(298, 1229, 86),
(299, 1230, 87),
(300, 1231, 87),
(301, 1232, 87),
(302, 1233, 87),
(303, 1234, 87),
(304, 1235, 87),
(305, 1236, 87),
(306, 1237, 87),
(307, 1238, 87),
(308, 1239, 87),
(309, 1240, 87),
(310, 1241, 87),
(311, 1242, 87),
(312, 1243, 87),
(313, 1244, 87),
(314, 1245, 87),
(315, 1246, 87),
(316, 1247, 87),
(317, 1248, 87),
(318, 1249, 87);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_financiero`
--

CREATE TABLE IF NOT EXISTS `cuentas_financiero` (
  `cfi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la cuenta',
  `cfi_numero` int(15) NOT NULL COMMENT 'numero de la cuenta',
  `cfi_nombre` varchar(50) NOT NULL COMMENT 'nombre de la cuenta',
  `cft_id` int(11) NOT NULL COMMENT 'tipo cuenta',
  PRIMARY KEY (`cfi_id`),
  KEY `fk_cuentas_tipo` (`cft_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='cuentas del módulo financiero' AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cuentas_financiero_tipo`
--

CREATE TABLE IF NOT EXISTS `cuentas_financiero_tipo` (
  `cft_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del tipo de cuenta',
  `cft_nombre` varchar(30) NOT NULL COMMENT 'nombre del tipo de cuenta',
  PRIMARY KEY (`cft_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `cuentas_financiero_tipo`
--

INSERT INTO `cuentas_financiero_tipo` (`cft_id`, `cft_nombre`) VALUES
(1, 'Cartera colectiva'),
(2, 'Cuentas asociadas');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento`
--

CREATE TABLE IF NOT EXISTS `departamento` (
  `dep_id` varchar(2) NOT NULL DEFAULT '' COMMENT 'codigo dane del departamento',
  `dep_nombre` varchar(60) NOT NULL DEFAULT '' COMMENT 'nombre del departamento',
  `ope_id` int(1) NOT NULL,
  `der_id` int(1) NOT NULL COMMENT 'Id de la region',
  PRIMARY KEY (`dep_id`),
  KEY `FK_OPERADOR` (`ope_id`),
  KEY `FK_REGION` (`der_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='contiene los departamentos';

--
-- Volcado de datos para la tabla `departamento`
--

INSERT INTO `departamento` (`dep_id`, `dep_nombre`, `ope_id`, `der_id`) VALUES
('1', 'Amazonas', 1, 1),
('10', 'Antioquia', 1, 3),
('11', 'Choco', 1, 4),
('2', 'Guanía', 1, 1),
('3', 'Guaviare', 1, 1),
('4', 'Putumayo', 1, 1),
('5', 'Vaupés', 1, 1),
('6', 'Meta', 1, 2),
('7', 'Vichada', 1, 2),
('8', 'Arauca', 1, 2),
('9', 'Casanare', 1, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `departamento_region`
--

CREATE TABLE IF NOT EXISTS `departamento_region` (
  `der_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador de la region',
  `der_nombre` varchar(25) NOT NULL COMMENT 'Nombre de la region',
  PRIMARY KEY (`der_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='contiene las regiones' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `departamento_region`
--

INSERT INTO `departamento_region` (`der_id`, `der_nombre`) VALUES
(1, 'Amazonia'),
(2, 'Orinoquia'),
(3, 'Andina'),
(4, 'Pacifica');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `desembolso`
--

CREATE TABLE IF NOT EXISTS `desembolso` (
  `des_id` varchar(15) NOT NULL COMMENT 'Identificado único de desembolso',
  `des_fecha` date NOT NULL COMMENT 'Fecha de concepto de desembolso',
  `des_ano_vigencia` int(4) NOT NULL,
  `des_documento` varchar(400) DEFAULT NULL COMMENT 'Nombre del documento soporte del desembolso',
  `des_condiciones` varchar(400) DEFAULT NULL COMMENT 'Nombre del archivo de condiciones del desembolso',
  `des_porcentaje` double NOT NULL COMMENT 'porcentaje de desembolso',
  `des_aprobado` double NOT NULL COMMENT 'Cantidad de desembolso aprovado',
  `des_porcentaje_amortizacion` double NOT NULL COMMENT 'Porcentaje de amortización',
  `des_amortizacion` double NOT NULL COMMENT 'Cantidad de amortización',
  `des_fecha_cumplimiento` date NOT NULL COMMENT 'Fecha de cumplimiento',
  `des_fecha_tramite` date NOT NULL COMMENT 'Fecha de trámite',
  `des_fecha_efectiva` date NOT NULL COMMENT 'Fecha efectiva del desembolso',
  `des_fecha_limite` date NOT NULL COMMENT 'Fecha límite de desembolso',
  `des_efectuado` double NOT NULL COMMENT 'Total efectuado',
  `des_observaciones` varchar(500) NOT NULL COMMENT 'Observaciones del desembolso',
  PRIMARY KEY (`des_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Tabla para almacenar la información de los desembolsos';

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento`
--

CREATE TABLE IF NOT EXISTS `documento` (
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
  KEY `FK_DOCUMENTO_OPERADOR` (`ope_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los documentos soporte del proyecto' AUTO_INCREMENT=657 ;

--
-- Volcado de datos para la tabla `documento`
--

INSERT INTO `documento` (`doc_id`, `dti_id`, `dot_id`, `dos_id`, `doc_fecha`, `doc_descripcion`, `doc_archivo`, `doc_version`, `doe_id`, `ope_id`, `doc_anexo`, `doa_id`, `doc_fechamax`, `doc_ref_resp`, `doc_res_resp`, `doc_consecutivo`) VALUES
(2, 1, 2, 8, '2014-01-07', 'Acta N°1 Mesa de trabajo ', 'Reunión N 1_ Metas Apropiación.pdf', '1', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(4, 1, 2, 8, '2014-02-25', 'Acta N° 3 Mesa de trabajo', 'Reunion N 3 Estudios de campo.pdf', '3', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(5, 1, 2, 8, '2014-03-20', 'Acta N° 4 Mesa de trabajo', 'Reunion N 4 Documentos de planeación.pdf', '4', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(6, 1, 2, 8, '2014-03-28', 'Acta N° 5 Mesa de trabajo', 'Reunion N 5 Mobiliario.pdf', '5', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(7, 1, 2, 8, '2014-04-02', 'Acta N° 6 Mesa de trabajo', 'Reunion N 6 Preparacion comité Fiduciario.pdf', '6', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(8, 1, 2, 8, '2014-04-07', 'Acta N° 7 Mesa de trabajo', 'Reunion N 7 Documentos soporte de Ordenes de pago.pdf', '7', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(9, 1, 2, 8, '2014-04-10', 'Acta N° 8 Mesa de trabajo', 'Reunion N 8 Beneficiarios.pdf', '8', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(10, 1, 2, 10, '2014-01-22', 'Acta N° 1 Seguimiento Interventoria-Revision de entregables de la interventoria y contratista', 'Acta No.1 Seguimiento Sertic.pdf', '1', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(11, 1, 2, 10, '2014-01-28', 'Acta N° 2 Seguimiento Interventoria, Reunion financiera', 'Acta 2 Reunión financiera.pdf', '2', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(12, 1, 2, 10, '2014-02-17', 'Acta N° 3 Presentacion Informe mensual de interventoria N° 1', 'Acta N° 3 Informe Mensual No 1 Enero.pdf', '3', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(13, 1, 2, 10, '2014-02-19', 'Acta N° 4 Aprobación de Estructura de Sistema de Información de la Interventoría', 'Acta N 4-Sistema de Información.pdf', '4', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(14, 1, 2, 10, '2014-02-20', 'Acta N° 5 Revisar y validar los web services', 'Acta  N° 5 Revisar y validar Web services.pdf', '5', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(15, 1, 2, 9, '2014-01-28', 'Acta N° 2 Reunión de seguimiento entre el operador, la interventoria y el MinTic', 'Reunión N 2. Seguimiento ANDIRED.pdf', '2', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(16, 1, 2, 9, '2014-03-20', 'Acta N° 8 Definicion de gastos administrativos y operativos', 'Acta 8-Reunión Financiera-20-mar-2014.pdf', '8', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(17, 1, 2, 8, '2014-04-22', 'Acta N° 9 Mesa de trabajo', 'Reunion N 9 Beneficiarios.pdf', '9', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(18, 1, 2, 7, '2014-01-02', 'Acta de entrega por cambio de supervisor', 'ACTA ENTREGA POR CAMBIO DE SUPERVISOR.pdf', '0', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(19, 1, 2, 9, '2014-01-16', 'Acta N° 1 Presentacion de la empresa ANDIRED, Presentacion equipo del proyecto.', 'Acta 1 Andired 16Enero2014.pdf', '1', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(20, 1, 2, 8, '2014-05-29', 'Acta N 10 Mesa de trabajo Juridico- Social- HSEQ', 'Reunion N 10 Juridico-social-HSEQ.pdf', '10', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(21, 1, 2, 8, '2014-05-14', 'Acta N° 12 Mesa de Trabajo Plan de transmision y plan de pruebas.', 'Reunion N 12 Plan de transmision y plan de pruebas.pdf', '12', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(22, 1, 2, 8, '2014-05-15', 'Acta N° 14 Mesa de Trabajo- Documentos de planeacion.', 'Reunion N 14 Documentos de planeacion.pdf', '14', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(23, 1, 2, 8, '2014-05-16', 'Acta N° 15 Mesa de trabajo Pruebas y estudios de campo.', 'Reunion N 15 Pruebas y estudios de campo.pdf', '15', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(24, 1, 2, 7, '2014-02-07', 'Acta N 1 Comite directivo', 'Acta Comité Directivo No  1-7-feb-2014.pdf', '1', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(25, 1, 2, 7, '2014-03-17', 'Acta N° 2 Comite directivo.', 'Acta 2 Comité Directivo CAV - Marzo 17-2014.pdf', '2', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(26, 1, 2, 7, '2014-04-29', 'Acta Comite directivo N° 3', 'Acta 3 Comité Directivo CAV - Abril 23-2014.pdf', '3', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(27, 1, 2, 10, '2014-03-19', 'Acta N° 6 Seguimiento a la interventoria.', 'Acta N° 6 Seguimiento Interventoria.pdf', '6', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(29, 1, 2, 9, '2014-02-03', 'Acta N° 4 Seguimiento al contratista UTANDIRED', 'Acta N° 4 Seguimiento al contratista.pdf', '4', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(30, 1, 2, 9, '2014-05-07', 'Acta N° 5 Seguimiento al contratista UTANDIRED', 'Acta n° 5 Seguimiento al contratista.pdf', '5', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(31, 1, 2, 9, '2014-02-14', 'Acta N° 6 Seguimiento al contratisa UTANDIRED', 'Acta N° 6 Seguimiento al contratista.pdf', '6', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(32, 1, 2, 9, '2014-05-07', 'Acta N° 9 Comite operativo 1', 'Acta N° 9 comite operativo 1.pdf', '9', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(33, 1, 2, 8, '2014-05-23', 'Acta N° 19 Mesa de trabajo-Seguimiento a los web services del operador.', 'Reunion N 19 Seguimiento a los web services del operador.pdf', '19', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(34, 1, 2, 9, '2014-03-05', 'Presentacion hoja de ruta metodologia de consulta previa y definicion de los pasos a seguir dentro del proceso ante MinInterior', 'Acta 7-Consulta previa-5-marzo-2014.pdf', '7', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(35, 1, 2, 7, '2014-05-29', 'Realizar elComité Directivo No4. del Proyecto Nacional de Conectividad de Alta Velocidad', 'Acta 4 Comité Directivo CAV - Mayo 29-2014.pdf', '4', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(36, 1, 2, 8, '2014-02-10', 'Acta N° 2 Mesa de trabajo, Proceso de donacion para KVD Y PVD', 'Reunión 2- Mesa de trabajo Donación.pdf', '2', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(37, 1, 2, 8, '2014-05-23', 'Acta N° 20- Mesa de Trabajo Observaciones al DGP y al EDIA', 'Reunion N 20 OBSERVACIONES DGP Y EDIA.pdf', '20', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(38, 1, 2, 8, '2014-05-27', 'Acta N 21 Mesa de trabajo-Validación de ubicación de Bases de las Fuerzas Militares, respecto a los posibles sitios donde se instalarían las Torres que pertenecen a la red de Transporte del Proyecto Nacional de Conectividad de Alta Velocidad - PNCAV', 'Reunion N 21 Fuerzas Militares J8.pdf', '21', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(39, 1, 2, 8, '2014-05-30', 'Acta N 22 Mesa de trabajo-Realizar la tercer Mesa de Trabajo de la Ruta Metodológica de Indicadores', 'Reunion N 22 may30-14 Ruta Metodol. de Indicadores.pdf', '22', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(40, 1, 2, 8, '2014-05-19', 'Acta N 18- Mesa de trabajo-aclaración de observaciones a los documentos de los Web Services', 'Reunion N 18 Observaciones documentos Web Services.pdf', '18', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(42, 1, 2, 10, '2014-03-24', 'Acta N° 7- Presentación Informe mensual de  Interventoría No. 3', 'Reunión N 7_ Informe Mensual N 3.pdf', '7', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(43, 1, 2, 10, '2014-05-13', 'Acta N° 8-1.	Presentación Informe Mensual de Interventoría No 4.', 'Reunión N 8  Informe Mensual No  4.pdf', '8', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(44, 1, 2, 8, '2014-06-05', 'Acta N° 23 -Mesa de trabajo- Presentar el avance del Plan de Apropiación en TIC, entregable para el 27 de junio de 2014', 'Reunion N 23 Plan de Apropiación.pdf', '23', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(45, 1, 2, 8, '2014-06-05', 'Acta N° 26 - Mesa de trabajo-Presentar el avance del Plan de Comunicaciones, entregable para el 27 de junio de 2014', 'Reunion N 26 Plan de comunicaciones.pdf', '26', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(46, 1, 2, 8, '2014-06-10', 'Acta N° 36 Mesa de trabajo-	Revisar el plan de desarrollo Web Services de la unión temporal Andired.', 'Reunion N 36 Avance desarrollo de web services.pdf', '36', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(47, 1, 2, 8, '2014-05-16', 'Acta N° 17- Mesa de trabajo- Plan de comunicaciones y plan de apropiacion', 'Reunion N 17 plan de comunicacion y de apropiacion.pdf', '17', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(48, 1, 2, 8, '2014-06-06', 'Acta N° 29- Mesa de trabajo- Informe de visita a Sitios', 'Reunion N 29 Informe de visita a sitios.pdf', '29', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(49, 1, 2, 8, '2014-06-06', 'Acta N° 30- Mesa de trabajo- Indicadores de la metodologia de seguimiento y avance del proyecto.', 'Reunion N 30 Indicadores metodologia de seguimiento y avance.pdf', '30', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(50, 1, 2, 8, '2014-06-06', 'Acta N° 28- Mesa de trabajo- Avance plan de marketing y comercialización.', 'Reunion N 28 Plan de marketing y comercializacion.pdf', '28', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(51, 1, 2, 8, '2014-06-10', 'Acta N° 35-Mesa de trabajo-Informe detallado de ingenieria logistica y gestion', 'Reunion N 35 Informe detallado de ingenieria logistica y gestion.pdf', '35', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(52, 1, 2, 8, '2014-06-06', 'Acta N° 33- Mesa de trabajo- Plan de operacion y mantenimiento', 'Reunion N 33 Plan de operacion y mantenimiento.pdf', '33', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(53, 1, 2, 10, '2014-06-11', 'Acta N° 9- seguimiento a la interventoria- Presentacion del informe mensual N° 5 de interventoria', 'Acta No. 9 Presentacion Informe 5 de interventoria.pdf', '9', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(55, 1, 2, 8, '2014-05-15', 'Acta N° 13- Mesa de trabajo- Plan de instalacion, plan de operacion y mantenimiento, plan de integracion.', 'Reunion N 13 Consolidacion documentos de planeacion.pdf', '13', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(56, 1, 2, 8, '2014-06-13', 'Acta N° 38- Mesa de trabajo- Avance del plan de comunicaciones.', 'Reunion N 38 Avance plan de comunicaciones.pdf', '38', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(60, 1, 2, 9, '2014-06-11', 'Acta N° 10- seguimiento al contratista-Estado de actividades al 31 de mayo de 2014', 'Reunion N 10 Comite seguimiento a 31 de mayo de 2014.pdf', '10', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(61, 1, 2, 8, '2014-06-06', 'Acta N° 34- Mesa de trabajo- Plan de  Instalacion y plan de integracion.', 'Reunion N 34 Plan de instalacion y plan de integracion.pdf', '34', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(62, 1, 2, 8, '2014-06-18', 'Revision del plan de instalacion y plan de integracion de la UTANDIRED', 'Reunion N 40 Revision plan de instalacion e integracion.pdf', '40', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(63, 1, 2, 8, '2014-06-20', 'Acta N° 42- Mesa de trabajo revision plan de desarrollo de web services.', 'Reunion N 42 Plan de desarrollo web services.pdf', '42', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(64, 1, 2, 8, '2014-06-20', 'Acta N° 41 Mesa de trabajo- Revision informe detallado de ingenieria, logistica y gestion- plan de pruebas y puesta en servicio', 'Reunion N 41 Informe ingenieria- plan de pruebas y puesta en servicio.pdf', '41', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(65, 1, 2, 8, '2014-06-26', 'Acta N° 45- Mesa de Trabajo-Revision informe de ingenieria logistica y gestion y plan de tansmision, pruebas y puesta en servicio.', 'Reunion N 45 Revision Informe de ingenieria y plan de transmision.pdf', '45', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(66, 1, 2, 8, '2014-06-25', 'Acta N° 44 - Mesa de trabajo- Informe detallado de ingenieria logistica y gestion', 'Reunion N 44 Avance informe de ingenieria logistica y gestion.pdf', '44', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(67, 1, 2, 8, '2014-05-16', 'Acta N° 16-Mesa de trabajo Revisión de Riesgos ambientales y calidad como preparacion a la entrega de los planes de la meta 2.', 'Reunion N 16 Riesgos ambiental y calidad.pdf', '16', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(68, 1, 2, 8, '2014-06-24', 'Acta N° 43- Mesa de trabajo Plan de comunicaciones', 'Reunion N 43 Plan de comunicaciones.pdf', '43', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(69, 1, 2, 8, '2014-06-18', 'Acta N° 39- Mesa de trabajo Revisión del avance correspondiente al plan de operacion y mantenimiento.', 'Reunion N 39 Plan de operacion y mantenimiento.pdf', '39', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(70, 1, 2, 8, '2014-06-12', 'Acta N° 37- Mesa de trabajo Revision planes calidad-ambiental y riesgos.', 'Reunion N 37 Planes calidad-ambiental-riesgos.pdf', '37', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(71, 1, 2, 7, '2014-06-19', 'Acta N° 5 Comite directivo PNCAV', 'Acta 5-Comité Directivo-19-junio-2014.pdf', '5', 1, 1, NULL, 0, NULL, NULL, NULL, ''),
(641, 1, 2, 83, '2014-06-25', 'Acta n° 1 Comite fiduciario', 'Acta N° 1 Comite fiduciario.pdf', '1', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(644, 1, 2, 8, '2014-07-14', 'Acta N° 49 Mesa de trabajo revision de compromisos y seguimiento PINES', 'REUNION N 49 PINES 14-JUL-14.pdf', '49', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(645, 1, 2, 8, '2014-06-06', 'Acta N° 32 Mesa de trabajo Plan de Ingenieria- sistema de informacion', 'Reunion N 32 Plan de ingeniera- sistema de informacion.pdf', '32', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(646, 1, 2, 8, '2014-07-03', 'Acta N° 47 Mesa de trabajo sseguimiento Pines', 'Reunion N 47 PINES.pdf', '47', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(647, 1, 2, 10, '2014-07-16', 'Acta n° 10 Informe de Interventoria N° 6', 'Acta de Reunión N 10  de INTV - Informe Mensual No  6.pdf', '10', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(648, 1, 2, 9, '2014-06-13', 'Acta N° 11 Concepto Documento general de planeacion', 'Reunión N 11   Alcance KVD.pdf', '11', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(649, 1, 2, 9, '2014-07-16', 'Acta N° 12 Presentacion Informe N° 6 del contratista', 'Reunion N 12 Presentacion Informe  n° 6 UT.pdf', '12', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(650, 1, 2, 8, '2014-07-01', 'Acta N° 46 Mesa de trabajo plan de choque validacion del EDIA', 'Reunion N 46 Plan de choque validacion del EDIA.pdf', '46', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(651, 1, 2, 8, '2014-06-18', 'Acta N° 39 A Mesa de trabajo- propuesta plan de apropiacion', 'Reunion N 39A PROPUESTA  DE PLAN DE APROPIACIÓN..pdf', '39 A', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(652, 1, 2, 8, '2014-07-10', 'Acta N° 48 Mesa de Trabajo- Revision de Observaciones HSEQ Informes mensuales de UTANDIRED', 'Reunion N 48 Observaciones HSEQ- Informes UT.pdf', '48', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(653, 1, 2, 11, '2014-07-17', 'Correo 17 Julio 2014- Monica Lozano', 'Correo 17 Julio 2014-Monica Lozano.pdf', '1', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(654, 1, 2, 8, '2014-06-05', 'Acta N° 24 Mesa de trabajo Plan de gestion de riesgos', 'Reunion N 24 Plan de riesgos.pdf', '24', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(655, 1, 2, 8, '2014-06-05', 'Acta N° 25 Mesa de trabajo Plan de gestion ambiental', 'Reunion N 25 Plan de Gestion ambiental.pdf', '25', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL),
(656, 1, 2, 8, '2014-06-05', 'Acta N° 27 Mesa trabajo Plan de Gestión de aseguramiento de la calidad', 'Reunion N 27 Revision Plan de calidad.pdf', '27', 1, 1, NULL, NULL, NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_actor`
--

CREATE TABLE IF NOT EXISTS `documento_actor` (
  `doa_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del actor',
  `doa_nombre` varchar(60) NOT NULL DEFAULT '' COMMENT 'Nombre del actor',
  `doa_sigla` varchar(6) NOT NULL DEFAULT '' COMMENT 'Sigla del actor',
  `ope_id` int(11) NOT NULL COMMENT 'Id del operador',
  `dta_id` int(11) NOT NULL COMMENT 'Id del tipo de actor',
  PRIMARY KEY (`doa_id`),
  KEY `FK_OPERADOR` (`ope_id`),
  KEY `FK_DOCUMENTO_TIPO_ACTOR` (`dta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los actores responsables de documentos' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `documento_actor`
--

INSERT INTO `documento_actor` (`doa_id`, `doa_nombre`, `doa_sigla`, `ope_id`, `dta_id`) VALUES
(1, 'Dirección de Conectividad', 'DCO', 1, 1),
(2, 'Fiduciaria Bogotá', 'FIDU', 1, 1),
(3, 'SERTIC', 'SRT', 1, 1),
(4, 'Unión Temporal Andired', 'UTAR', 1, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_comunicado`
--

CREATE TABLE IF NOT EXISTS `documento_comunicado` (
  `doc_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del comunicado',
  `dti_id` int(2) NOT NULL DEFAULT '0' COMMENT 'identificador del tipo de comunicado',
  `dot_id` int(3) DEFAULT '0' COMMENT 'identificador del tema del comunicado',
  `dos_id` int(3) NOT NULL DEFAULT '0' COMMENT 'identificador del subtema del comunicado',
  `doa_id_autor` int(3) NOT NULL DEFAULT '0' COMMENT 'identificador del autor del comunicado',
  `doa_id_dest` int(3) NOT NULL DEFAULT '0' COMMENT 'identificador del destinatario del comunicado',
  `doc_fecha_radicado` date NOT NULL DEFAULT '0000-00-00' COMMENT 'fecha de radicado del comunicado',
  `doc_referencia` varchar(30) DEFAULT NULL COMMENT 'referencia del comunicado',
  `doc_descripcion` text COMMENT 'descripcion del comunicado',
  `doc_archivo` varchar(200) DEFAULT NULL COMMENT 'nombre del comunicado',
  `usu_id` int(11) DEFAULT '1' COMMENT 'responsable del comunicado y respuesta sobre este',
  `doc_fecha_respuesta` date DEFAULT NULL COMMENT 'fecha de respuesta al comunicado si esta es requerida',
  `doc_anexo` varchar(100) DEFAULT '2' COMMENT 'documento anexo',
  `doc_codigo_ref` varchar(50) DEFAULT NULL COMMENT 'Codigo referencia',
  `doc_fecha_respondido` date DEFAULT '0000-00-00' COMMENT 'Fecha en la que se repondel el comunicado',
  `doc_referencia_respondido` varchar(150) DEFAULT NULL COMMENT 'referencia con la que se reponde el comunicado',
  `doe_id` int(11) DEFAULT NULL,
  `ope_id` int(11) NOT NULL COMMENT 'Identificador del tipo de estado',
  PRIMARY KEY (`doc_id`),
  UNIQUE KEY `UK_DOC_ID_TIPO_ARCHIVO` (`doc_id`,`dti_id`,`doc_archivo`),
  KEY `FK_TIPO` (`dti_id`),
  KEY `FK_TEMA` (`dot_id`),
  KEY `FK_SUBTEMA` (`dos_id`),
  KEY `FK_AUTOR` (`doa_id_autor`),
  KEY `FK_DESTINATARIO` (`doa_id_dest`),
  KEY `FK_OPERADOR` (`ope_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT AUTO_INCREMENT=414 ;

--
-- Volcado de datos para la tabla `documento_comunicado`
--

INSERT INTO `documento_comunicado` (`doc_id`, `dti_id`, `dot_id`, `dos_id`, `doa_id_autor`, `doa_id_dest`, `doc_fecha_radicado`, `doc_referencia`, `doc_descripcion`, `doc_archivo`, `usu_id`, `doc_fecha_respuesta`, `doc_anexo`, `doc_codigo_ref`, `doc_fecha_respondido`, `doc_referencia_respondido`, `doe_id`, `ope_id`) VALUES
(26, 1, 8, 51, 3, 1, '2014-01-10', '', 'Solicitud de información contratista adjuditcatario licitación pública 009 de 2013\r\n', 'PNCAV-SRT-DCO-0001-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0001-14', '0000-00-00', NULL, 1, 1),
(31, 1, 7, 43, 3, 1, '2014-01-14', 'PNCAV-DIRCON-INTV-015-14', 'Entrega de Hojas de vida\r\n', 'PNCAV-SRT-DCO-0002-14.pdf', 86, '2014-01-21', 'PNCAV-SRT-DCO-0002-14 Anexo.zip', 'PNCAV-SRT-DCO-0002-14', '0000-00-00', 'PNCAV-DIRCON-INTV-015-14.PDF', 2, 1),
(32, 1, 8, 50, 3, 1, '2014-01-31', '', 'Revisión de la solicitud de modificación del contrato de aporte N° 875 de 2013\r\n', 'PNCAV-SRT-DCO-0004-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0004-14', '0000-00-00', NULL, 1, 1),
(37, 1, 9, 67, 3, 4, '2014-01-31', 'PNCAV-UTAR-SRT-007-14', 'Observaciones a los formatos de estudio de campo\r\n', 'PNCAV-SRT-UTAR-0002-14 Observaciones Estudios de campo.pdf', 87, '2014-02-07', NULL, 'PNCAV-SRT-UTAR-0002-14', '0000-00-00', 'PNCAV-UTAR-SRT-007-14 Ajustes estudios de campo.PDF', 2, 1),
(38, 1, 9, 67, 4, 3, '2014-02-11', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-0002-14 Observaciones formatos estudios de campo\r\n', 'PNCAV-UTAR-SRT-007-14 Ajustes estudios de campo.PDF', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-007-14', '0000-00-00', NULL, 1, 1),
(39, 1, 8, 52, 3, 4, '2014-01-27', 'PNCAV-UTAR-SRT-004-14', 'Respuesta comunicado PNCAV-UTAR-SRT-0001-14, contrato de mandato y reglamento de comité fiduciario.\r\n', 'PNCAV-SRT-DCO-0003-14.pdf', 87, '2014-02-03', NULL, 'PNCAV-SRT-DCO-0003-14', '0000-00-00', 'PNCAV-UTAR-SRT-004-14-Contrato de fiducia.pdf', 2, 1),
(40, 1, 8, 52, 4, 3, '2014-02-03', 'PNCAV-SRT-UTAR-0005-14', 'Respuesta a comunicado PNCAV-SRT-DCO-0003-14\r\n', 'PNCAV-UTAR-SRT-004-14-Contrato de fiducia.pdf', 71, '2014-02-10', NULL, 'PNCAV-UTAR-SRT-004-14', '0000-00-00', 'PNCAV-SRT-UTAR-0005-14.pdf', 2, 1),
(42, 1, 5, 33, 3, 1, '2014-02-04', 'PNCAV-DIRCON-INTV-017-14', 'Entrega versión N° 1 del plan de calidad de la interventoría\r\n', 'PNCAV-SRT-DCO-0005-14.pdf', 86, '2014-02-11', 'PNCAV-SRT-DCO-0005-14 Anexo.zip', 'PNCAV-SRT-DCO-0005-14', '0000-00-00', 'PNCAV-DIRCON-INTV-017-14.pdf', 2, 1),
(43, 1, 5, 33, 1, 3, '2014-02-26', 'PNCAV-SRT-DCO-0015-14', 'Observaciones Versión 1 del plan de calidad de la interventoria\r\n', 'PNCAV-DIRCON-INTV-017-14.pdf', 69, '2014-03-05', NULL, 'PNCAV-DIRCON-INTV-017-14', NULL, 'PNCAV-SRT-DCO-0015-14.pdf', 2, 1),
(44, 1, 5, 33, 3, 1, '2014-03-03', 'PNCAV-DIRCON-INTV-026-14', 'Versión N° 1 plan de calidad de la Interventoría al PNCAV\r\n', 'PNCAV-SRT-DCO-0015-14.pdf', 86, '2014-03-10', '', 'PNCAV-SRT-DCO-0015-14', '0000-00-00', 'PNCAV-DIRCON-INTV-026-14.pdf', 2, 1),
(45, 1, 7, 45, 3, 1, '2014-02-11', 'PNCAV-DIRCON-INTV-023-14', 'Entrega informe Mensual N° 1 de Interventoría correspondiente al mes de Enero de 2014\r\n', 'PNCAV-SRT-DCO-0006-14.pdf', 86, '2014-02-25', 'PNCAV-SRT-DCO-0006-14 Anexo.zip', 'PNCAV-SRT-DCO-0006-14', '0000-00-00', 'PNCAV-DRCON-INTV-023-14.pdf', 2, 1),
(47, 1, 7, 45, 1, 3, '2014-03-13', '', 'Aprobación del informe N° 1 Interventoria del mes de Enero\r\n', 'PNCAV-DRCON-INTV-023-14.pdf', NULL, '0000-00-00', '', 'PNCAV-DIRCON-INTV-023-14', '0000-00-00', '', 2, 1),
(48, 1, 4, 19, 3, 4, '2014-02-06', 'PNCAV-UTAR-SRT-0009-14', 'Observaciones Plan de Inversión del Anticipo-contrato de Aporte N° 875 de 2013\r\n', 'PNCAV-SRT-UTAR-0004-14.pdf', 87, '2014-02-13', '', 'PNCAV-SRT-UTAR-0004-14', '0000-00-00', 'PNCAV-UTAR-SRT-009-14 Plan de Inversión del anticipo.PDF', 2, 1),
(49, 1, 4, 19, 4, 3, '2014-02-14', 'PNCAV-SRT-UTAR-0010-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-0004-14 Plan de inversion del anticipo.\r\n', 'PNCAV-UTAR-SRT-009-14 Plan de Inversión del anticipo.PDF', 89, '2014-02-21', '', 'PNCAV-UTAR-SRT-0009-14', '0000-00-00', 'PNCAV-SRT-UTAR-0010-14.pdf', 2, 1),
(50, 1, 4, 19, 3, 4, '2014-02-24', '', 'Observaciones Plan de Inversión del Anticipo  Respuesta a comunicado PNCAV-UTAR-SRT-009-14\r\n', 'PNCAV-SRT-UTAR-0010-14.pdf', NULL, '0000-00-00', '', 'PNCAV-SRT-UTAR-0010-14', '0000-00-00', NULL, 2, 1),
(51, 1, 7, 49, 2, 4, '2014-02-03', '', 'Fidecomiso UT ANDIRED-3-1-40730 PNCAV-Presentación Analista de Negocios\n', 'PNCAV-FIDU-UTAR-002-14.pdf', 87, '0000-00-00', '', 'PNCAV-FIDU-UTAR-002-14', '0000-00-00', '', 1, 1),
(52, 1, 4, 20, 2, 4, '2014-02-04', '', 'Fidecomiso unión temporal Andired 3-1-40730 PNCAV-Informe Mensual 1 De ENERO A 31 DE ENERO DE 2014\r\n', 'PNCAV-FIDU-UTAR-004-14.pdf', NULL, '0000-00-00', '', 'PNCAV-FIDU-UTAR-004-14', '0000-00-00', NULL, 2, 1),
(53, 1, 4, 20, 3, 4, '2014-02-12', 'PNCAV-UTAR-SRT-008-14', 'Observaciones informe de fiducia periodo Enero de 2014\r\n', 'PNCAV-SRT-UTAR-0007-14.pdf', 87, '2014-02-19', '', 'PNCAV-SRT-UTAR-0007-14', '0000-00-00', 'PNCAV-UTAR-SRT-008-14 Informe fiducia Enero 2014.PDF', 2, 1),
(54, 1, 4, 20, 4, 3, '2014-02-14', '', 'Respuesta a comunicado PNCAV-SRT UTADR-0007-14 Informe de fiducia Enero de 2014\r\n', 'PNCAV-UTAR-SRT-008-14 Informe fiducia Enero 2014.PDF', NULL, '0000-00-00', '', 'PNCAV-UTAR-SRT-008-14', '0000-00-00', NULL, 2, 1),
(55, 1, 9, 67, 4, 3, '2014-01-22', 'PNCAV-SRT-UTAR-0002-14', 'Contrato de aporte N° 00875\r\nEstudios de campo.', 'PNCAV-UTAR-SRT-002-14.pdf', 87, '2014-01-29', NULL, 'PNCAV-UTAR-SRT-0002-14', '0000-00-00', 'PNCAV-SRT-UTAR-0002-14 Observaciones Estudios de campo.pdf', 2, 1),
(56, 1, 7, 49, 4, 2, '2014-02-05', '', 'Fidecomiso U.T ANDIRED 3-1-40730\nAutorización Confirmación Telefonica\n', 'PNCAV-UTAR-FIDU-0006-14.pdf', 88, '0000-00-00', '', 'PNCAV-UTAR-FIDU-006-14', '0000-00-00', '', 1, 1),
(57, 1, 8, 61, 4, 3, '2014-02-05', 'PNCAV-SRT-DCO-0011-14', 'Contrato de aporte N° 00875\nPolizas\n', 'PNCAV-UTAR-SRT-005-14 Remision de polizas.pdf', 71, '2014-02-12', '', 'PNCAV-UT-SRT-000-14', '2014-02-24', 'PNCAV-SRT-DCO-0011-14.pdf', 2, 1),
(58, 1, 8, 55, 3, 1, '2014-02-24', '', 'Concepto sobre las polizas constituidas por UT ANDIRED para el contrato de aporte\r\n', 'PNCAV-SRT-DCO-0011-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0011-14', '0000-00-00', NULL, 1, 1),
(59, 1, 7, 49, 4, 3, '2014-01-28', '', 'Contrato de aporte N° 00875\r\nComunicaciones Proyecto Unión Temporal Andired\r\n', 'PNCAV-UTAR-SRT-003-14.pdf', NULL, '0000-00-00', '', 'PNCAV-UTAR-SRT-003-14', '0000-00-00', '', 2, 1),
(60, 1, 8, 51, 4, 2, '2014-01-23', '', 'Contrato de aporte n° 00875, Contrato de Interventoría 000882\r\n', 'PNCAV-UTAR-FIDU-004-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-FIDU-004-14', '0000-00-00', NULL, 1, 1),
(61, 1, 4, 23, 4, 2, '2014-01-23', '', 'Procedimiento consignacion y legalización de rendimientos generados\r\n', 'PNCAV-UTAR-FIDU-0005-14.pdf', NULL, '0000-00-00', '', 'PNCAV-UTAR-FIDU-005-14', '0000-00-00', NULL, 2, 1),
(62, 1, 8, 53, 4, 3, '2014-01-20', '', 'Reglamento del comité fiduciario y contrato de mandato\r\n', 'PNCAV-UTAR-SRT-001-14-Remisión contraro de madato.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-001-14', '0000-00-00', NULL, 1, 1),
(63, 1, 7, 49, 4, 2, '2014-02-07', '', 'Fidecomiso UT ANDIRED-3-1-40730 PNCAV- Designación del supervisor\nAutorización Confirmación Telefonica\n', 'PNCAV-UTAR-FIDU-0007-14.pdf', 88, '0000-00-00', '', 'PNCAV-UTAR-FIDU-007-14', '0000-00-00', '', 1, 1),
(64, 1, 7, 45, 4, 3, '2014-02-07', 'PNCAV-UTAR-SRT-008-14', 'Informe de seguimiento Mensual\r\n', 'PNCAV-UTAR-SRT-006-14-Informe de Mensual N° 1.pdf', 75, '2014-02-14', '', 'PNCAV-UTAR-SRT-006-14', '0000-00-00', 'PNCAV-UTAR-SRT-008-14 Informe fiducia Enero 2014.PDF', 2, 1),
(65, 1, 7, 45, 3, 4, '2014-02-24', 'PNCAV-UTAR-SRT-019-14', 'Observaciones al Informe 1 de Enero  de 2014 del Contratista Unión Temporal Andired.\r\n', 'PNCAV-SRT-UTAR-0008-14.pdf', 87, '2014-03-03', '', 'PNCAV-SRT-UTAR-008-14', '0000-00-00', 'PNCAV-UTAR-SRT-019-14.pdf', 2, 1),
(66, 1, 7, 45, 4, 3, '2014-03-17', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-008-14Informe mensual contratista unión temporal Andired N° 1 Observaciones\r\n', 'PNCAV-UTAR-SRT-019-14.pdf', NULL, '0000-00-00', '', 'PNCAV-UTAR-SRT-019-14', '0000-00-00', '', 2, 1),
(67, 1, 7, 45, 3, 1, '2014-03-10', 'PNCAV-DIRCON-INTV-034-14', 'Entrega informe Mensual N° 2 de Interventoría correspondiente al mes de Febrero de 2014\r\n', 'PNCAV-SRT-DCO-0017-14.pdf', 86, '2014-03-25', '', 'PNCAV-SRT-DCO-0017-14', '0000-00-00', 'PNCAV-DIRCON-INTV-034-14.pdf', 2, 1),
(69, 1, 7, 45, 3, 4, '2014-03-21', 'PNCAV-UTAR-SRT-022-14', 'Verificación del Informe Mensual No. 1 de la Unión Temporal Andired\r\n', 'PNCAV-SRT-UTAR-0016-14.pdf', 87, '2014-03-28', '', 'PNCAV-SRT-UTAR-0016-14', '0000-00-00', 'PNCAV-UTAR-SRT-022-14.pdf', 2, 1),
(70, 1, 7, 45, 4, 3, '2014-03-26', 'PNCAV-SRT-UTAR-0019-14', 'Informes mensuales del contratista UT ANDIRED, correspondientes al mes de Enero y Febrero de 2014\r\n', 'PNCAV-UTAR-SRT-022-14.pdf', 75, '2014-04-02', '', 'PNCAV-UTAR-SRT-022-14', '0000-00-00', 'PNCAV-SRT-UTAR-0019-14.pdf', 2, 1),
(71, 1, 7, 45, 3, 4, '2014-04-02', '', 'Observaciones a los informes mensuales de enero y febrero de 2014 del contratista UT ANDIRED\r\n', 'PNCAV-SRT-UTAR-0019-14.pdf', NULL, '0000-00-00', '', 'PNCAV-SRT-UTAR-0019-14', '0000-00-00', '', 2, 1),
(72, 1, 7, 45, 4, 1, '2014-04-07', '', 'Entrega informe de seguimiento marzo 2014 ( solicitud de plazo de entrega)\r\n', 'PNCAV-UTAR-DIRCON-008-14.pdf', NULL, '0000-00-00', '', 'PNCAV-UTAR-DIRCON-008-14', '0000-00-00', '', 2, 1),
(73, 1, 7, 45, 3, 1, '2014-04-07', 'PNCAV-DIRCON-OPER-033-14', 'Recomendación sobre solicitud realizada por la UT Andired, respecto a la entrega del Informe mensual de Marzo de 2014.\r\n', 'PNCAV-SRT-DCO-0022-14.pdf', 86, '2014-04-14', '', 'PNCAV-SRT-DCO-0022-14', '0000-00-00', 'PNCAV-DIRCON-OPER-033-14.pdf', 2, 1),
(74, 1, 7, 45, 1, 4, '2014-04-09', '', 'Entrega informe de seguimiento marzo UTANDIRED\r\n', 'PNCAV-DIRCON-OPER-033-14.pdf', NULL, '0000-00-00', '', 'PNCAV-DIRCON-OPER-033-14', '0000-00-00', '', 2, 1),
(75, 1, 7, 45, 1, 3, '2014-04-10', '', 'Aprobacion del informe N° 2 de la interventoria del mes de febrero de 2014\r\n', 'PNCAV-DIRCON-INTV-034-14.pdf', NULL, '0000-00-00', '', 'PNCAV-DIRCON-INTV-034-14', '0000-00-00', '', 2, 1),
(76, 1, 7, 45, 4, 3, '2014-04-10', 'Observaciones email', 'Informe de seguimiento Mensual del contratista del mes de Enero de 2014\r\n', 'PNCAV-UTAR-SRT-030-14.pdf', 75, '2014-04-21', '', 'PNCAV-UTAR-SRT-0030-14', '0000-00-00', 'Observaciones Informes 1,2 Y 3 UTANDIRED.pdf', 2, 1),
(77, 1, 5, 33, 1, 3, '2014-03-20', 'PNCAV-SRT-DCO-0020-14', 'Observaciones a la Versión No.2 del Plan de Calidad de la Interventoria\r\n(Respuesta a comunicado PNCAV-SRT-DCO-0015-14)', 'PNCAV-DIRCON-INTV-026-14.pdf', 69, '2014-03-27', '', 'PNCAV-DIRCON-INTV-026-14', '0000-00-00', 'PNCAV-SRT-DCO-0020-14.pdf', 2, 1),
(78, 1, 5, 33, 3, 1, '2014-03-31', 'PNCAV-SRT-DCO-0045-14', 'Respuesta comunicado PNCAV-DIRCON-INTV-026-14. Entrega de ajustes plan de calidad de la interventoria al PNCAV para aprobacion en versión 1\r\n', 'PNCAV-SRT-DCO-0020-14.pdf', 86, '2014-04-07', '', 'PNCAV-SRT-DCO-0020-14', '0000-00-00', 'PNCAV-SRT-DCO-0045-14.pdf', 2, 1),
(79, 1, 8, 52, 3, 4, '2014-02-12', 'PNCAV-UTAR-SRT-010-14', ' Respuesta a comunicado PNCAV-UTAR-SRT-0004-14 Minuta del contrato del mandato y reglamento de comité fiduciario\r\n', 'PNCAV-SRT-UTAR-0005-14.pdf', 87, '2014-02-19', NULL, 'PNCAV-SRT-UTAR-0005-14', '0000-00-00', 'PNCAV-UTAR-SRT-010-14.PDF', 2, 1),
(80, 1, 8, 50, 4, 1, '2014-02-12', '', 'Contrato de Aporte 000875\r\nAclaración Alcance de kioscos Adicionales\r\n', 'PNCAV-UTAR-DIRCON-004-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-DIRCON-004-14', '0000-00-00', NULL, 1, 1),
(81, 1, 8, 52, 4, 3, '2014-02-18', 'PNCAV-SRT-UTAR-0009-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-0005-14\r\nMinuta del contrato del mandato y reglamento del comite fiduciario', 'PNCAV-UTAR-SRT-010-14.PDF', 71, '2014-02-25', NULL, 'PNCAV-UTAR-SRT-010-14', '0000-00-00', 'PNCAV-SRT-UTAR-0009-14.pdf', 2, 1),
(82, 1, 8, 50, 3, 1, '2014-02-24', 'PNCAV-DIRCON-INTV-016-14', 'Comunicación Unión Temporal ANDIRED del 31 de enero de 2014 PNCAV-UTAR-DIRCON-004-14 sobre " Aclaración Alcance Kioscos Vive Digital Adicionales".\r\n', 'PNCAV-SRT-DCO-0012-14.pdf', 86, '2014-03-03', NULL, 'PNCAV-SRT-DCO-0012-14', '0000-00-00', 'PNCAV-DIRCON-INTV-016-14.pdf', 2, 1),
(83, 1, 8, 52, 3, 4, '2014-02-24', 'PNCAV-UTAR-SRT-014-14', 'Respuesta comunicado PNCAV-UTAR-SRT-010-14, Contrato de Mandato y Reglamento de Comité Fiduciario.\r\n', 'PNCAV-SRT-UTAR-0009-14.pdf', 87, '2014-02-24', NULL, 'PNCAV-SRT-UTAR-0009-14', '0000-00-00', 'PNCAV-UTAR-SRT-014-14.pdf', 2, 1),
(84, 1, 8, 52, 4, 3, '2014-02-27', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-0009-14\r\nContrato de mandato y reglamento del comite fiduciario', 'PNCAV-UTAR-SRT-014-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-014-14', '0000-00-00', NULL, 1, 1),
(85, 1, 8, 61, 1, 3, '2014-02-26', 'PNCAV-SRT-DCO-0012-14', 'Radicado N° 590633 del 12/02/2014\nAclaracion alcande de Kioscos Adicionales', 'PNCAV-DIRCON-INTV-016-14.pdf', 71, '2014-03-05', '', 'PNCAV-DIRCON-INTV-016-14', '2014-02-24', 'PNCAV-SRT-DCO-0012-14.pdf', 2, 1),
(86, 1, 8, 52, 3, 1, '2014-02-24', '', 'Observaciones al Contrato de Fiducia Mercantil de Administración de pagos No 3-1-40730.\r\n', 'PNCAV-SRT-DCO-0010-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-000-14', '0000-00-00', NULL, 1, 1),
(87, 1, 8, 61, 4, 3, '2014-02-26', '', 'Comunicaciones EXTMI130050200 y EXTMI140002948 Radicadas al ministerio del interior\n', 'PNCAV-UTAR-SRT-012-14 Grupos etnicos.pdf', 71, '0000-00-00', '', 'PNCAV-UTAR-SRT-0012-14', '0000-00-00', '', 1, 1),
(88, 1, 6, 36, 4, 3, '2014-02-26', '', 'Contrato de aporte 000875\r\nInforme de Actividades\r\n', 'PNCAV-UTAR-SRT-013-14 Informe de actividades.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-0013-14', '0000-00-00', NULL, 1, 1),
(89, 1, 8, 50, 4, 3, '2014-02-28', 'PNCAV-SRT-UTAR-0011-14', 'Contrato de aporte 000875\r\nAcuerdo de confidencialidad\r\n', 'PNCAV-UTAR-SRT-015-14.pdf', 71, '2014-03-07', NULL, 'PNCAV-UTAR-SRT-0015-14', '0000-00-00', 'PNCAV-SRT-UTAR-0011-14.pdf', 2, 1),
(90, 1, 8, 50, 3, 4, '2014-03-05', '', 'Respuesta a Comunicado PNCAV-UTAR-015-14 Acuerdo de confidencialidad\r\n', 'PNCAV-SRT-UTAR-0011-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0011-14', '0000-00-00', NULL, 1, 1),
(91, 1, 8, 61, 4, 3, '2014-03-07', 'PNCAV-SRT-DCO-0021-14', 'Contrato de Aporte 000875 Certificados Parafiscales\n', 'PNCAV-UTAR-SRT-016-14 Parafiscales.pdf', 71, '2014-03-14', '', 'PNCAV-UT-SRT-000-14', '2014-03-31', 'PNCAV-SRT-DCO-0021-14 Parafiscales.pdf', 2, 1),
(92, 1, 8, 50, 3, 1, '2014-03-31', '', 'Respuesta a comunicado PNCAV-UTAR-SRT-021-14. Concepto Aportes a Seguridad Social y Parafiscales del periodo enero y febrero 2014 – Ley 789 de 2002, art. 50.\r\n', 'PNCAV-SRT-DCO-0021-14 Parafiscales.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0021-14', '0000-00-00', NULL, 1, 1),
(93, 1, 8, 50, 4, 3, '2014-03-26', 'PNCAV-SRT-DCO-0021-14', 'Remisión de certificados parafiscales del mes de Febrero de 2014\r\n', 'PNCAV-UTAR-SRT-021-14.pdf', 71, '2014-04-02', NULL, 'PNCAV-UTAR-SRT-021-14', '0000-00-00', 'PNCAV-SRT-DCO-0021-14 Parafiscales.pdf', 2, 1),
(94, 1, 8, 50, 3, 1, '2014-03-13', '', 'Observaciones Acta de Inicio del Contrato de Aporte No. 00875.\r\n', 'PNCAV-SRT-DCO-0018-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0018-14', '0000-00-00', NULL, 1, 1),
(95, 1, 8, 58, 3, 4, '2014-03-20', 'PNCAV-UTAR-SRT-023-14', 'Reporte de avance trámites de consultas previas. PNCAV\r\n', 'PNCAV-SRT-UTAR-0015-14.pdf', 87, '2014-03-27', NULL, 'PNCAV-SRT-UTAR-0015-14', '0000-00-00', 'PNCAV-UTAR-SRT-023-14.pdf', 2, 1),
(96, 1, 8, 58, 4, 3, '2014-03-27', 'PNCAV-SRT-UTAR-0021-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-0015-14 Consultas previas\r\n', 'PNCAV-UTAR-SRT-023-14.pdf', 71, '2014-04-03', NULL, 'PNCAV-UTAR-SRT-023-14', '0000-00-00', 'PNCAV-SRT-UTAR-0021-14.pdf', 2, 1),
(97, 1, 8, 58, 3, 4, '2014-04-03', 'PNCAV-UTAR-SRT-032-14', 'Revisión del Reporte de Avance Trámites de Consultas Previas - PNCAV-UTAR-SRT-023-14.\r\n', 'PNCAV-SRT-UTAR-0021-14.pdf', 87, '2014-04-10', NULL, 'PNCAV-SRT-UTAR-0021-14', '0000-00-00', 'PNCAV-UTAR-SRT-032-14.pdf', 2, 1),
(98, 1, 8, 58, 4, 3, '2014-04-10', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-0021-14 Consultas previas\r\n', 'PNCAV-UTAR-SRT-032-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-032-14', '0000-00-00', NULL, 1, 1),
(99, 1, 8, 57, 4, 1, '2014-04-07', '', 'Contrato de donacion de equipos KVD\r\n', 'PNCAV-UTAR-DIRCON-009-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-DIRCON-009-14', '0000-00-00', NULL, 1, 1),
(100, 1, 8, 61, 4, 2, '2014-03-19', '', 'Remsion de CD con la copia del contrato de aporte N° 000875\n', 'PNCAV-UTAR-FIDU-008-14.pdf', 88, '0000-00-00', '', 'PNCAV-UTAR-FIDU-008-14', '0000-00-00', '', 1, 1),
(101, 1, 4, 24, 3, 4, '2014-02-12', 'PNCAV-UTAR-SRT-011-14', 'Solicitud de condiciones de manejo Contable, finanicero y tributario del patrimonio autonomo N° 3-1-4730\r\n', 'PNCAV-SRT-UTAR-0006-14.pdf', 87, '2014-02-19', '', 'PNCAV-SRT-UTAR-0006-14', '0000-00-00', 'PNCAV-UTAR-SRT-011-14.PDF', 2, 1),
(102, 1, 4, 29, 4, 3, '2014-02-18', '', 'Respuesta comunicado PNCAV-SRT-UTAR-0006-14\r\nManejo contable,financiero y tributario', 'PNCAV-UTAR-SRT-011-14.PDF', NULL, '0000-00-00', '', 'PNCAV-UTAR-SRT-011-14', '0000-00-00', NULL, 2, 1),
(103, 1, 4, 29, 2, 3, '2014-02-19', 'PNCAV-SRT-FIDU-0001-14', 'Fidecomiso PA 3-1-40730 Proyecto Nacional de alta conectividad\r\nTarjetas de firmas\r\n', 'PNCAV-FIDU-INTV-005-14.PDF', 89, '2014-02-26', '', 'PNCAV-FIDU-INTV-005-14', '0000-00-00', 'PNCAV-SRT-FIDU-0001-14.pdf', 2, 1),
(104, 1, 4, 29, 3, 2, '2014-02-26', '', 'entrega de tarjetas de firmas del  Proyecto Nacional de alta velocidad 3-1 -40730, respuesta comunicado PNCAV-FIDU-INTV-005-14\n', 'PNCAV-SRT-FIDU-0001-14.pdf', 88, '0000-00-00', '', 'PNCAV-SRT-FIDU-0001-14', '0000-00-00', '', 1, 1),
(105, 1, 4, 20, 2, 4, '2014-03-05', '', 'Informe mensual de fiducia correspondiente al mes de febrero de 2014\r\n', 'PNCAV-FIDU-UTAR-006-14.pdf', NULL, '0000-00-00', '', 'PNCAV-FIDU-UTAR-006-14', '0000-00-00', NULL, 2, 1),
(106, 1, 4, 20, 3, 4, '2014-03-14', 'PNCAV-FIDU-UTAR-013-14', 'Observaciones informe de fiducia periodo Febrero de 2014\r\n', 'PNCAV-SRT-UTAR-0012-14.pdf', 87, '2014-03-28', '', 'PNCAV-SRT-UTAR-0012-14', '0000-00-00', 'PNCAV-FIDU-UTAR-013-14.pdf', 2, 1),
(107, 1, 4, 27, 4, 3, '2014-03-07', 'PNCAV-SRT-UTAR-0013-14', 'Contrato de Aporte 000875 Remisión orden de pago N° 1\r\n', 'PNCAV-UTAR-SRT-017-14 Orden de Pago.pdf', 89, '2014-03-14', '', 'PNCAV-UTAR-SRT-017-14', '0000-00-00', 'PNCAV-SRT-UTAR-0013-14.pdf', 2, 1),
(108, 1, 4, 27, 4, 3, '2014-03-10', 'PNCAV-SRT-UTAR-0013-14', 'Contrato de Aporte 000875 Remisión orden de pago N° 2\r\n', 'PNCAV-UTAR-SRT-018-14 Orden de pago.pdf', 89, '2014-03-17', '', 'PNCAV-UTAR-SRT-018-14', '0000-00-00', 'PNCAV-SRT-UTAR-0013-14.pdf', 2, 1),
(109, 1, 4, 27, 3, 4, '2014-03-14', '', 'Devolución de Órdenes de Operación  314073407-1, y 314073407-2, Comunicados PNCAV-UTAR-SRT-017-14, PNCAV-UTAR-SRT-018-14\r\n', 'PNCAV-SRT-UTAR-0013-14.pdf', NULL, '0000-00-00', '', 'PNCAV-SRT-UTAR-0013-14', '0000-00-00', NULL, 2, 1),
(110, 1, 4, 19, 4, 1, '2014-01-13', '', 'Respuesta a comunicado PNCAV-UTAR-DIRCON-004-13 Desembolso del anticipo\r\n', 'PNCAV-UTAR-DIRCON-002-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-DIRCON-002-14', '0000-00-00', NULL, 1, 1),
(111, 1, 4, 17, 4, 1, '2014-01-13', '', 'Licitacion N° FTIC-LP-09-2013 Desembolso del anticipo\r\n', 'PNCAV-UTAR-DIRCON-004-13.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-DIRCON-004-13', '0000-00-00', NULL, 1, 1),
(112, 1, 4, 20, 2, 3, '2014-03-11', '', 'Alcance al comunicado PNCAV-FIDU-004-14(Informe fiduciario enero 2014) Aclarando las observaciones realizadas por la interventoria en el comunicado PNCAV-SRT-UTAR-0007-14\r\n', 'PNCAV-FIDU-UTAR-007-14.pdf', NULL, '0000-00-00', '', 'PNCAV-FIDU-UTAR-007-14', '0000-00-00', NULL, 2, 1),
(113, 1, 4, 20, 1, 3, '2014-03-12', 'PNCAV-UTAR-SRT-0027-14', 'Revisión del informe financiero mes de Febrero Fidecomiso UT ANDIRED-3-1-407030 PNCAV\r\n', 'PNCAV-DIRCON-INTV-025-14.pdf', 89, '2014-03-19', '', 'PNCAV-DIRCON-INTV-025-14', '0000-00-00', 'PNCAV-UTAR-SRT-027-14.pdf', 2, 1),
(114, 1, 4, 29, 2, 1, '2014-03-13', '', 'Delegacion comité fiduciario\r\n', 'PNCAV-FIDU-DIRCON-009-14.pdf', NULL, '0000-00-00', '', 'PNCAV-FIDU-DIRCON-009-14', '0000-00-00', NULL, 2, 1),
(115, 1, 4, 20, 3, 4, '2014-03-20', '', 'Concepto sobre Informe Fiduciario correspondiente al mes de enero de 2014 \r\n', 'PNCAV-SRT-UTAR-0014-14.pdf', NULL, '0000-00-00', '', 'PNCAV-SRT-UTAR-0014-14', '0000-00-00', NULL, 2, 1),
(116, 1, 4, 23, 2, 1, '2014-03-20', '', 'Fidecomiso PA 3-1-40730 Proyecto Nacional de alta conectividad-Rendimientos financieros febrero de 2014\r\n', 'PNCAV-FIDU-DIRCON-012-14.pdf', NULL, '0000-00-00', '', 'PNCAV-FIDU-DIRCON-012-14', '0000-00-00', NULL, 2, 1),
(117, 1, 4, 20, 2, 4, '2014-03-21', '', 'Respuesta a observaciones informe fiduciario de febrero de 2014\r\n', 'PNCAV-FIDU-UTAR-013-14.pdf', NULL, '0000-00-00', '', 'PNCAV-FIDU-UTAR-013-14', '0000-00-00', NULL, 2, 1),
(118, 1, 4, 20, 3, 4, '2014-03-27', 'PNCAV-UTAR-SRT-0027-14', 'Informe Fiduciario de febrero de 2014, respuesta a comunicado  PNCAV-FIDU-UTAR-013-14.\r\n', 'PNCAV-SRT-UTAR-0018-14.pdf', 87, '2014-04-03', '', 'PNCAV-SRT-UTAR-0018-14', '0000-00-00', 'PNCAV-UTAR-SRT-027-14.pdf', 2, 1),
(119, 1, 4, 20, 4, 3, '2014-04-03', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-018-14 Remisión de copia de consignación y copia comunicado PNCAV-UTAR-DIRCON-007-14\r\n', 'PNCAV-UTAR-SRT-027-14.pdf', NULL, '0000-00-00', '', 'PNCAV-UTAR-SRT-0027-14', '0000-00-00', NULL, 2, 1),
(120, 1, 4, 20, 2, 4, '2014-04-03', '', 'Informe mensual del mes de Marzo de 2014\r\n', 'PNCAV-FIDU-UTAR-014-14.pdf', NULL, '0000-00-00', '', 'PNCAV-FIDU-UTAR-014-14', '0000-00-00', NULL, 2, 1),
(121, 1, 4, 29, 2, 4, '2014-04-04', '', 'Rendicion trimestral enero -Marzo 2014\r\n', 'PNCAV-FIDU-UTAR-015-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-FIDU-UTAR-015-14', '0000-00-00', NULL, 2, 1),
(122, 1, 4, 29, 4, 1, '2014-04-09', '', 'Delegados comité fiduciario\n', 'PNCAV-UTAR-DIRCON-010-14.pdf', 86, '0000-00-00', '', 'PNCAV-UTAR-DIRCON-010-14', '0000-00-00', '', 1, 1),
(123, 1, 5, 33, 3, 1, '2014-02-24', 'PNCAV-SRT-DCO-0049-14', 'Remisión encuesta percepción del cliente corre al 31 de diciembre de 2013 al 28 de febrero de 2014-primer bimestre 2014\r\n', 'PNCAV-SRT-DCO-0009-14.pdf', 86, '2014-03-03', 'PNCAV-SRT-DCO-0009-14 Anexo.zip', 'PNCAV-SRT-DCO-0009-14', '0000-00-00', 'PNCAV-SRT-DCO-0049-14.pdf', 2, 1),
(124, 1, 7, 43, 3, 1, '2014-02-26', 'PNCAV-DIRCON-INTV-019-14', 'Cambio asesor experto en redes y telecomunicaciones\r\n', 'PNCAV-SRT-DCO-0013-14.pdf', 86, '2014-03-05', 'PNCAV-SRT-DCO-0013-14 Anexo.zip', 'PNCAV-SRT-DCO-0013-14', '0000-00-00', 'PNCAV-DIRCON-INTV-019-14.pdf', 2, 1),
(125, 1, 7, 43, 1, 3, '2014-03-31', '', 'Aprobacion cambios en el equipo de trabajo de la Interventoria\r\n', 'PNCAV-DIRCON-INTV-019-14.pdf', NULL, '0000-00-00', '', 'PNCAV-DIRCON-INTV-019-14', '0000-00-00', '', 2, 1),
(126, 1, 7, 42, 3, 1, '2014-02-18', '', 'Solicitud de información para el procedimiento y directrices para la entrega de documentos\r\n', 'PNCAV-SRT-DCO-0007-14.pdf', 86, '2014-02-25', '', 'PNCAV-SRT-DCO-0007-14', '0000-00-00', '', 4, 1),
(127, 1, 7, 43, 1, 3, '2014-02-18', '', 'Contrato de Interventoria n° 882 de 2013\r\nAprobacion de personal\r\n', 'PNCAV-DIRCON-INTV-015-14.PDF', NULL, '0000-00-00', NULL, 'PNCAV-DIRCON-INTV-015-14', '0000-00-00', NULL, 1, 1),
(128, 1, 7, 43, 3, 1, '2014-02-19', 'PNCAV-DIRCON-INTV-019-14', 'Cambios en el equipo de trabajo de la Interventoría PNCAV\r\n', 'PNCAV-SRT-DCO-0008-14.pdf', 86, '2014-02-26', 'PNCAV-SRT-DCO-0008-14 Anexo.zip', 'PNCAV-SRT-DCO-0008-14', '0000-00-00', 'PNCAV-DIRCON-INTV-019-14.pdf', 2, 1),
(129, 1, 7, 43, 3, 1, '2014-03-03', 'PNCAV-DIRCON-INTV-019-14', 'Cambio equipo de trabajo asistente Juridico\r\n', 'PNCAV-SRT-DCO-0014-14.pdf', 86, '2014-03-10', '', 'PNCAV-SRT-DCO-0014-14', '0000-00-00', 'PNCAV-DIRCON-INTV-019-14.pdf', 2, 1),
(130, 1, 9, 79, 1, 4, '2014-03-12', '', 'Primer entrega web services\r\n', 'PNCAV-DIRCON-OPER-022-13.pdf', NULL, '0000-00-00', NULL, 'PNCAV-DIRCON-OPER-022-14', '0000-00-00', NULL, 1, 1),
(131, 1, 6, 39, 1, 4, '2014-03-10', '', 'Plan de comunicaciones\r\n', 'PNCAV-DIRCON-OPER-024-13.pdf', NULL, '0000-00-00', NULL, 'PNCAV-DIRCON-OPER-024-14', '0000-00-00', NULL, 1, 1),
(132, 1, 9, 67, 3, 4, '2014-03-25', 'PNCAV-UTAR-SRT-025-14', 'Verificacion de ajustes a formatos de estudio de campo , respuesta a comunicado PNCAV-UTAR-SRT-020-14\r\n', 'PNCAV-SRT-UTAR-0017-14.pdf', 87, '2014-04-01', NULL, 'PNCAV-SRT-UTAR-0017-14', '0000-00-00', 'PNCAV-UTAR-SRT-025-14.pdf', 2, 1),
(133, 1, 9, 67, 4, 3, '2014-03-17', 'PNCAV-SRT-UTAR-0017-14', 'Remsión de formatos de estudios de campo con correcciones sugeridas en la reunion del 7 de marzo de 2014\r\n', 'PNCAV-UTAR-SRT-020-14.pdf', 72, '2014-03-24', NULL, 'PNCAV-UTAR-SRT-020-14', '0000-00-00', 'PNCAV-SRT-UTAR-0017-14.pdf', 2, 1),
(134, 1, 9, 67, 4, 3, '2014-03-27', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-0017-14 Estudios de campo\r\n', 'PNCAV-UTAR-SRT-024-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-0024-14', '0000-00-00', NULL, 1, 1),
(135, 1, 9, 67, 4, 3, '2014-03-28', 'PNCAV-SRT-UTAR-0020-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-0017-14 Estudios de campo\r\n', 'PNCAV-UTAR-SRT-025-14.pdf', 72, '2014-04-04', NULL, 'PNCAV-UTAR-SRT-025-14', '0000-00-00', 'PNCAV-SRT-UTAR-0020-14.pdf', 2, 1),
(136, 1, 9, 67, 3, 4, '2014-04-03', '', 'Verificación de Ajustes a Formatos de Estudio de Campo – PNCAV-UTAR-SRT-025-14\r\n', 'PNCAV-SRT-UTAR-0020-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0020-14', '0000-00-00', NULL, 1, 1),
(137, 1, 9, 67, 4, 3, '2014-04-08', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-0020-14 Estudios de campo\r\n', 'PNCAV-UTAR-SRT-029-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-0029-14', '0000-00-00', NULL, 1, 1),
(138, 1, 9, 82, 4, 1, '2014-03-27', '', 'Entrega de documento general de planeación y estudio de desarrollo impacto y apropiación\n', 'PNCAV-UTAR-DIRCON-006-14.pdf', 86, '0000-00-00', '', 'PNCAV-UTAR-DIRCON-006-14', '0000-00-00', '', 1, 1),
(139, 1, 9, 79, 3, 4, '2014-04-07', '', 'Avance desarrollo Primera entrega Web Services\r\n', 'PNCAV-SRT-UTAR-0022-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-022-14', '0000-00-00', NULL, 1, 1),
(140, 1, 9, 63, 3, 4, '2014-04-07', 'PNCAV-UTAR-SRT-028-14', 'Asignación de espectro radioeléctrico\r\n', 'PNCAV-SRT-UTAR-0023-14.pdf', 87, '2014-04-14', NULL, 'PNCAV-SRT-UTAR-0023-14', '0000-00-00', 'PNCAV-UTAR-SRT-028-14.pdf', 2, 1),
(141, 1, 9, 63, 4, 3, '2014-04-08', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-0023-14 Plan de transmision asignacion espectro radioelectrico\r\n', 'PNCAV-UTAR-SRT-028-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-028-14', '0000-00-00', NULL, 1, 1),
(142, 1, 7, 43, 3, 1, '2014-03-10', 'PNCAV-DIRCON-INTV-031-14', 'Presentacion asesor experto en obras civiles\r\n', 'PNCAV-SRT-DCO-0016-14.pdf', 86, '2014-03-17', '', 'PNCAV-SRT-DCO-0016-14', '0000-00-00', 'PNCAV-DIRCON-INTV-031-14.pdf', 2, 1),
(143, 1, 7, 43, 1, 3, '2014-04-03', '', 'Aprobacion Hoja de vida Asesor experto en obras civiles\r\n', 'PNCAV-DIRCON-INTV-031-14.pdf', NULL, '0000-00-00', '', 'PNCAV-DIRCON-INTV-031-14', '0000-00-00', '', 2, 1),
(144, 1, 7, 42, 4, 3, '2014-04-01', '', 'Remisión de actas de comité directivo 1 y 2 para firma y posterior devolución de copia\r\n', 'PNCAV-UTAR-SRT-026-14.pdf', NULL, '0000-00-00', '', 'PNCAV-UTAR-SRT-026-14', '0000-00-00', '', 2, 1),
(145, 1, 4, 29, 2, 4, '2014-03-11', '', 'Solicitud de documentos de acuerdo a la clausula octava obligaciones del fidecomitente\n', 'PNCAV-FIDU-UTAR-008-14.pdf', 87, '0000-00-00', '', 'PNCAV-FIDU-UTAR-008-14', '0000-00-00', '', 1, 1),
(146, 1, 4, 29, 4, 2, '2014-03-19', '', 'Respuesta a comunicado PNCAV-FIDU-UTAR-008-14 Solicitud de documentos\n', 'PNCAV-UTAR-FIDU-008-14.pdf', 88, '0000-00-00', '', 'PNCAV-UTAR-FIDU-008-14', '0000-00-00', '', 1, 1),
(147, 1, 6, 38, 3, 1, '2014-03-31', 'RTA correo Electronico', 'Entrega Metodologíapara el levantamiento dela Línea Base del PNCAV\r\n', 'PNCAV-SRT-DCO-0019-14.pdf', 86, '2014-04-07', NULL, 'PNCAV-SRT-DCO-0019-14', '0000-00-00', 'Observaciones Metodologia Linea Base.pdf', 2, 1),
(148, 1, 4, 20, 3, 4, '2014-04-10', 'PNCAV-UTAR-SRT-037-14', 'Observaciones al informe de fiducia periodo Marzo de 2014\r\n', 'PNCAV-SRT-UTAR-0025-14.pdf', 87, '2014-04-21', NULL, 'PNCAV-SRT-UTAR-0025-14', '0000-00-00', 'PNCAV-UTAR-SRT-037-14.pdf', 2, 1),
(149, 1, 4, 20, 3, 4, '2014-04-10', 'PNCAV-UTAR-SRT-036-14', 'Observaciones informe de fiducia trimestre N° 1 corte enero-marzo de 2014\r\n', 'PNCAV-SRT-UTAR-0024-14.pdf', 87, '2014-04-21', NULL, 'PNCAV-SRT-UTAR-0024-14', '0000-00-00', 'PNCAV-UTAR-SRT-036-14.pdf', 2, 1),
(151, 1, 7, 45, 4, 3, '2014-04-14', 'Observaciones email', 'Informe de seguimiento mensual del contratista UTANDIRED correspondiente al mes de Febrero de 2014', 'PNCAV-UTAR-SRT-031-14.pdf', 75, '2014-04-23', '', 'PNCAV-UTAR-SRT-031-14', '0000-00-00', 'Observaciones Informes 1,2 Y 3 UTANDIRED.pdf', 2, 1),
(152, 1, 7, 45, 4, 3, '2014-04-14', '', 'Informe de seguimiento Mensual del contratista correspondiente al mes de Marzo.', 'PNCAV-UTAR-SRT-033-14.pdf', NULL, '0000-00-00', '', 'PNCAV-UTAR-SRT-033-14', '0000-00-00', '', 2, 1),
(153, 1, 4, 17, 4, 1, '2014-01-29', '', 'Desembolso Anticipo', 'PNCAV-UTAR-DIRCON-003-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-DIRCON-003-14', '0000-00-00', NULL, 1, 1),
(154, 1, 4, 29, 2, 4, '2014-04-15', '', 'Aclaracion porcentaje rentabilidad del mes de Febrero de 2014', 'PNCAV-FIDU-UTAR-017-14.pdf', 87, '0000-00-00', '', 'PNCAV-FIDU-UTAR-017-14', '0000-00-00', '', 1, 1),
(155, 1, 8, 50, 3, 4, '2014-04-15', '', 'Verificación de Aportes a Seguridad Social y Parafiscales – Ley 789 de 2002, art. 50.\r\n', 'PNCAV-SRT-UTAR-0026-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0026-14', '0000-00-00', NULL, 1, 1),
(157, 1, 4, 20, 4, 3, '2014-04-21', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-0027-14 Informe de Fiducia Febrero de 2014', 'PNCAV-UTAR-SRT-034-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-034-14', '0000-00-00', NULL, 2, 1),
(159, 1, 4, 20, 3, 4, '2014-04-15', 'PNCAV-UTAR-SRT-034-14', 'Observaciones informe de fiducia febrero de 2014.', 'PNCAV-SRT-UTAR-0027-14.pdf', 87, '2014-04-24', NULL, 'PNCAV-SRT-UTAR-0027-14', '0000-00-00', 'PNCAV-UTAR-SRT-034-14.pdf', 2, 1),
(160, 1, 9, 67, 3, 4, '2014-04-21', 'PNCAV-SRT-UTAR-0042-14', 'Solicitud de Cumplimiento de los Compromisos Adquiridos en el Acta No. 8 de la Mesa de Trabajo del 10 de abril de 2014.\r\n', 'PNCAV-SRT-UTAR-0029-14.pdf', 87, '2014-04-28', NULL, 'PNCAV-SRT-UTAR-0029-14', '0000-00-00', 'PNCAV-SRT-UTAR-0042-14.pdf', 2, 1),
(161, 1, 9, 67, 3, 4, '2014-04-21', '', 'Verificación de Ajustes a Formatos de Estudio de Campo PNCAV-UTAR-SRT-0029-14\r\n', 'PNCAV-SRT-UTAR-0028-14.pdf', 87, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0028-14', '0000-00-00', NULL, 1, 1),
(162, 1, 9, 67, 3, 1, '2014-04-21', 'PNCAV-DCO-OPER-035-14', 'Entrega Formatos Verificados de Estudios de Campo al Proyecto PNCAV para aprobación\r\n', 'PNCAV-SRT-DCO-0024-14.pdf', 86, '2014-04-28', NULL, 'PNCAV-SRT-DCO-0024-14', '0000-00-00', 'PNCAV-DIRCON-OPER-035-14.pdf', 2, 1),
(165, 1, 8, 50, 4, 3, '2014-04-22', 'PNCAV-SRT-UTAR-0037-14', 'Contrato de aporte 000875 Parafiscales marzo de 2014', 'PNCAV-UTAR-SRT-035-14.pdf', 71, '2014-04-29', NULL, 'PNCAV-UTAR-SRT-035-14', '0000-00-00', 'PNCAV-SRT-UTAR-0037-14.pdf', 2, 1),
(166, 1, 4, 29, 2, 1, '2014-04-23', 'PNCAV-SRT-DCO-0047-14', 'Rendimientos financieros marzo de 2014\n', 'PNCAV-FIDU-DIRCON-020-14.pdf', 86, '2014-04-30', '', 'PNCAV-FIDU-DIRCON-020-14', '2014-05-30', 'PNCAV-SRT-DCO-0047-14.pdf', 2, 1),
(167, 1, 4, 20, 2, 4, '2014-04-23', '', 'Respuesta a observaciones PNCAV-SRT-UTAR-0024-14 Informe fiduciario trimestre enero-marzo de 2014\r\n', 'PNCAV-FIDU-UTAR-019-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-FIDU-UTAR-019-14', '0000-00-00', NULL, 2, 1),
(168, 1, 4, 20, 2, 4, '2014-04-23', '', 'Respuesta a observaciones PNCAV-SRT-UTAR-0025-14 Informe fiduciario del mes de marzo de 2014\r\n', 'PNCAV-FIDU-UTAR-018-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-FIDU-UTAR-018-14', '0000-00-00', NULL, 2, 1),
(169, 1, 4, 20, 4, 3, '2014-04-23', 'PNCAV-SRT-UTAR-0034-14', 'Respuesta PNCAV-SRT-UTAR-025-14 Informe fiduciario', 'PNCAV-UTAR-SRT-037-14.pdf', 89, '2014-04-30', NULL, 'PNCAV-UTAR-SRT-037-14', '0000-00-00', 'PNCAV-SRT-UTAR-0034-14.pdf', 2, 1),
(170, 1, 4, 20, 4, 3, '2014-04-23', 'PNCAV-SRT-UTAR-0033-14', 'Respuesta comunicado PNCAV-UTAR-SRT-024-14 Informe fiduciario', 'PNCAV-UTAR-SRT-036-14.pdf', 89, '2014-04-30', NULL, 'PNCAV-UTAR-SRT-036-14', '0000-00-00', 'PNCAV-SRT-UTAR-0033-14.pdf', 2, 1),
(171, 1, 4, 29, 3, 1, '2014-04-23', '', 'Concepto de rendimientos financieros febrero de 2014.', 'PNCAV-SRT-DCO-0030-14.pdf', 86, '0000-00-00', '', 'PNCAV-SRT-DCO-0030-14', '0000-00-00', '', 1, 1),
(172, 1, 4, 20, 3, 4, '2014-04-23', '', 'Concepto Informe fiduciario del mes de Febrero de 2014', 'PNCAV-SRT-UTAR-0030-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0030-14', '0000-00-00', NULL, 2, 1),
(173, 1, 7, 45, 3, 1, '2014-04-11', 'PNCAV-DIRCON-INTV-036-14', 'Entrega informe Mensual N° 3 de interventoria correspondiente al mes de marzo de 2014', 'PNCAV-SRT-DCO-0023-14.pdf', 86, '2014-04-29', '', 'PNCAV-SRT-DCO-0023-14', '0000-00-00', 'PNCAV-DIRCON-INTV-036-14.pdf', 2, 1),
(174, 1, 9, 67, 1, 4, '2014-04-25', '', 'Aprobacion formatos esudios de campo-contrato de aporte N° 875 de 2013', 'PNCAV-DIRCON-OPER-035-14.pdf', 72, '0000-00-00', NULL, 'PNCAV-DCO-OPER-035-14', '0000-00-00', NULL, 1, 1),
(175, 1, 9, 79, 3, 1, '2014-04-25', 'RTA correo Electronico 5mayo', 'Informe avance sistema de información y web service de la interventoria, enero a marzo de 2014.', 'PNCAV-SRT-DCO-0031-14.pdf', 86, '2014-05-05', NULL, 'PNCAV-SRT-DCO-0031-14', '0000-00-00', 'Respuesta a comunicado PNCAV-SRT-DCO-0031-14.pdf', 2, 1),
(176, 1, 8, 50, 3, 1, '2014-04-24', 'PNCAV-DIRCON-OPER-037-14', 'Donación de Kioscos vive digital-KVD', 'PNCAV-SRT-DCO-0029-14.pdf', 86, '2014-05-02', NULL, 'PNCAV-SRT-DCO-0029-14', '0000-00-00', 'PNCAV-DIRCON-OPER-037-14.pdf', 2, 1),
(177, 1, 8, 52, 3, 1, '2014-04-28', '', 'Delegación SERTIC S.A.S al comite fiduciario del contrato fiduciario N° 3-1-40730', 'PNCAV-SRT-DCO-0032-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0032-14', '0000-00-00', NULL, 1, 1),
(178, 1, 9, 62, 3, 4, '2014-04-28', 'PNCAV-UTAR-SRT-047-14', 'Observaciones al documento general de planeacion.', 'PNCAV-SRT-UTAR-0031-14.pdf', 87, '2014-05-13', NULL, 'PNCAV-SRT-UTAR-0031-14', '0000-00-00', 'PNCAV-UTAR-SRT-047-14.pdf', 2, 1),
(179, 1, 6, 36, 3, 4, '2014-04-28', 'PNCAV-UTAR-SRT-046-14', 'Observaciones a los estudios de desarrollo impacto y apropiacion.', 'PNCAV-SRT-UTAR-0032-14.pdf', 87, '2014-05-13', NULL, 'PNCAV-SRT-UTAR-0032-14', '0000-00-00', 'PNCAV-UTAR-SRT-046-14.pdf', 2, 1),
(180, 1, 6, 41, 4, 1, '2014-03-27', '', 'Entrega de documento general de planeacion y estudio de desarrollo impacto y apropiacion.', 'PNCAV-UTAR-DIRCON-006-14.pdf', 86, '0000-00-00', '', 'PNCAV-UTAR-DIRCON-006-14', '0000-00-00', '', 1, 1),
(181, 1, 4, 19, 4, 3, '2014-04-29', 'PNCAV-SRT-UTAR-0039-14', 'Plan de inversión del anticipo  (Actualización)Anexo CD', 'PNCAV-UTAR-SRT-038-14.pdf', 89, '2014-05-07', NULL, 'PNCAV-UTAR-SRT-038-14', '0000-00-00', 'PNCAV-SRT-UTAR-0039-14.pdf', 2, 1),
(182, 1, 8, 61, 3, 1, '2014-04-30', '', 'Delegacion SERTIC S.A.S al comite directivo del PNCAV', 'PNCAV-SRT-DCO-0033-14.pdf', 86, '0000-00-00', '', 'PNCAV-SRT-DCO-0033-14', '0000-00-00', '', 1, 1),
(183, 1, 7, 45, 1, 3, '2014-05-05', 'PNCAV-SRT-DCO-0037-14', 'Observaciones del informe N° 3 del mes de marzo de 2014-contrato de interventoria N° 882 de 2013. ( Anexo 1 Folio)', 'PNCAV-DIRCON-INTV-036-14.pdf', 75, '2014-05-19', '', 'PNCAV-DIRCON-INTV-036-14', '0000-00-00', 'PNCAV-SRT-DCO-0037-14.pdf', 2, 1),
(184, 1, 8, 61, 4, 1, '2014-05-02', '', 'Cambio representante legal y gerente de Proyecto. Extracto de Acta de Junta directiva N° 5', 'PNCAV-UTAR-DIRCON-011-14.pdf', 86, '0000-00-00', '', 'PNCAV-UTAR-DIRCON-011-14', '0000-00-00', '', 1, 1),
(185, 1, 4, 20, 3, 4, '2014-04-30', 'PNCAV-UTAR-SRT-042-14', 'Observaciones informe de fiducia trimestral Enero- Marzo de 2014- Respuesta comunicado PNCAV-UTAR-SRT-036-14', 'PNCAV-SRT-UTAR-0033-14.pdf', 87, '2014-05-08', NULL, 'PNCAV-SRT-UTAR-0033-14', '0000-00-00', 'PNCAV-UTAR-SRT-042-14.pdf', 2, 1),
(186, 1, 4, 20, 3, 4, '2014-04-30', 'PNCAV-UTAR-SRT-043-14', 'Observaciones informe de fiducia periodo Marzo de 2014. Respuesta a comunicado PNCAV-UTAR-SRT-037-14.', 'PNCAV-SRT-UTAR-0034-14.pdf', 87, '2014-05-08', NULL, 'PNCAV-SRT-UTAR-0034-14', '0000-00-00', 'PNCAV-UTAR-SRT-043-14.pdf', 2, 1),
(187, 1, 4, 24, 3, 4, '2014-04-30', '', 'Cumplimiento de obligaciones del comite fiduciario- comite fiduciario trimestral', 'PNCAV-SRT-UTAR-0035-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0035-14', '0000-00-00', NULL, 2, 1),
(188, 1, 8, 61, 3, 4, '2014-04-30', 'PNCAV-UTAR-SRT-040-14', 'Solicitud listado licencias y permisos ambientales.', 'PNCAV-SRT-UTAR-0036-14.pdf', 87, '2014-05-08', NULL, 'PNCAV-SRT-UTAR-0036-14', '0000-00-00', 'PNCAV-UTAR-SRT-040-14.pdf', 2, 1),
(189, 1, 6, 38, 1, 3, '2014-04-14', 'PNCAV-SRT-DCO-0043-14', 'Observaciones metodologia Linea Base', 'Observaciones Metodologia Linea Base.pdf', 84, '2014-04-21', NULL, 'Email linea base', '0000-00-00', 'PNCAV-SRT-DCO-0043-14.pdf', 2, 1),
(190, 1, 8, 50, 3, 4, '2014-05-02', 'PNCAV-UTAR-SRT-039-14', 'Respuesta comunicado PNCAV-UTAR-SRT-035-14 Verificacion de aportes a seguridad social y parafiscales.', 'PNCAV-SRT-UTAR-0037-14.pdf', 87, '2014-05-06', NULL, 'PNCAV-SRT-UTAR-0037-14', '0000-00-00', 'PNCAV-UTAR-SRT-039-14.pdf', 2, 1),
(191, 1, 8, 50, 3, 1, '2014-05-02', '', 'Concepto aportes a seguridad social y parafiscales periodo marzo 2014-ley 789 de 2002 art 50', 'PNCAV-SRT-DCO-0034-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0034-14', '0000-00-00', NULL, 1, 1),
(192, 1, 8, 50, 4, 3, '2014-05-06', '', 'Respuesta comunicacion PNCAV-SRT-UTAR-0037-14 Parafiscales', 'PNCAV-UTAR-SRT-039-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-039-14', '0000-00-00', NULL, 1, 1),
(193, 1, 4, 20, 2, 4, '2014-05-07', 'PNCAV-SRT-UTAR-0046-14', 'Informe fiduciario Mensual del mes de Abril de 2014.', 'PNCAV-FIDU-UTAR-021-14.pdf', 87, '2014-05-14', NULL, 'PNCAV-FIDU-UTAR-021-14', '0000-00-00', 'PNCAV-SRT-UTAR-0046-14.pdf', 2, 1),
(194, 1, 4, 20, 2, 4, '2014-05-07', '', 'Respuesta a observaciones PNCAV-SRT-UTAR-0033-14 informe fiduciario trimestre enero-Marzo de 2014', 'PNCAV-FIDU-UTAR-022-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-FIDU-UTAR-0022-14', '0000-00-00', NULL, 2, 1),
(195, 1, 4, 20, 2, 4, '2014-05-07', '', 'Respuesta observaciones PNCAV-SRT-UTAR-0034-14 Informe Fiduciario del Mes de Marzo de 2014', 'PNCAV-FIDU-UTAR-023-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-FIDU-UTAR-023-14', '0000-00-00', NULL, 2, 1),
(196, 1, 9, 63, 3, 4, '2014-05-07', 'PNCAV-UTAR-SRT-045-14', 'Seguimiento al proceso de asignacion de espectro radioelectrico.', 'PNCAV-SRT-UTAR-0038-14.pdf', 87, '2014-05-14', NULL, 'PNCAV-SRT-UTAR-0038-14', '0000-00-00', 'PNCAV-UTAR-SRT-045-14.pdf', 2, 1),
(197, 1, 8, 61, 4, 3, '2014-05-08', 'PNCAV-SRT-UTAR-0045-14', 'Respuesta comunicado PNCAV-SRT-UTAR-0036-14 Listado de licencias y permisos ambientales. Anexo CD', 'PNCAV-UTAR-SRT-040-14.pdf', 71, '2014-05-15', NULL, 'PNCAV-UTAR-SRT-040-14', '0000-00-00', 'PNCAV-SRT-UTAR-0045-14.pdf', 2, 1),
(198, 1, 7, 45, 4, 3, '2014-05-08', 'PNCAV-SRT-UTAR-0047-14', 'Informe mensual de seguimiento UTANDIRED mes de Abril de 2014. Anexo CD', 'PNCAV-UTAR-SRT-041-14.pdf', 75, '2014-05-23', '', 'PNCAV-UTAR-SRT-041-14', '0000-00-00', 'PNCAV-SRT-UTAR-0047-14.pdf', 2, 1),
(199, 1, 4, 20, 4, 3, '2014-05-08', 'PNCAV-SRT-UTAR-0044-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-033-14 Financiero Informe fiduciario trimestral.', 'PNCAV-UTAR-SRT-042-14.pdf', 89, '2014-05-15', NULL, 'PNCAV-UTAR-SRT-042-14', '0000-00-00', 'PNCAV-SRT-UTAR-0044-14.pdf', 2, 1),
(200, 1, 4, 20, 4, 3, '2014-05-09', 'PNCAV-SRT-UTAR-0044-14', 'Respuesta comunicado PNCAV-SRT-UTAR-034-14 Informe fiduciario del mes de Marzo.', 'PNCAV-UTAR-SRT-043-14.pdf', 89, '2014-05-16', NULL, 'PNCAV-UTAR-SRT-043-14', '0000-00-00', 'PNCAV-SRT-UTAR-0044-14.pdf', 2, 1),
(201, 1, 4, 20, 4, 2, '2014-05-09', '', 'Informes Fiduciarios Mensual y Trimestral.', 'PNCAV-UTAR-FIDU-010-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-FIDU-010-14', '0000-00-00', NULL, 2, 1),
(202, 1, 4, 19, 3, 4, '2014-05-09', 'PNCAV-UTAR-SRT-061-14', 'Observaciones a modificacion del plan de inversion del anticipo. Respuesta a comunicado PNCAV-UTAR-SRT-038-14', 'PNCAV-SRT-UTAR-0039-14.pdf', 87, '2014-05-16', NULL, 'PNCAV-SRT-UTAR-0039-14', '0000-00-00', 'PNCAV-UTAR-SRT-061-14.pdf', 2, 1),
(203, 1, 6, 41, 1, 3, '2014-05-27', '', 'Entregables tercer mes de ejecución del contrato. Anexos CD', 'PNCAV-DIRCON-OPER-029-13.pdf', 83, '0000-00-00', '', 'PNCAV-DIRCON-OPER-029-13', '0000-00-00', '', 1, 1),
(204, 1, 7, 49, 3, 4, '2014-04-24', '', 'Observaciones a los informes 1,2 y 3 del Contratista Union temporal Andired', 'Observaciones Informes 1,2 Y 3 UTANDIRED.pdf', 87, '0000-00-00', '', 'Observaciones email', '0000-00-00', '', 1, 1),
(205, 1, 7, 45, 4, 3, '2014-05-12', 'PNCAV-SRT-UTAR-0047-14', 'Informe de seguimiento UTANDIRED Mes de abril de 2014-faltante consultas previas. Anexo CD', 'PNCAV-UTAR-SRT-044-14.pdf', 75, '2014-05-15', '', 'PNCAV-UTAR-SRT-044-14', '0000-00-00', 'PNCAV-SRT-UTAR-0047-14.pdf', 2, 1),
(206, 1, 8, 57, 1, 4, '2014-05-14', '', 'Respuesta contrato de donacion de equipos KVD', 'PNCAV-DIRCON-OPER-037-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-DIRCON-OPER-037-14', '0000-00-00', NULL, 1, 1),
(207, 1, 9, 63, 4, 3, '2014-05-13', 'PNCAV-SRT-UTAR-0052-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-0038-14 Transmision de datos proceso de asigancion del espectro radioelectrico', 'PNCAV-UTAR-SRT-045-14.pdf', 72, '2014-05-20', NULL, 'PNCAV-UTAR-SRT-045-14', '0000-00-00', 'PNCAV-SRT-UTAR-0052-14.pdf', 2, 1),
(208, 1, 9, 62, 4, 3, '2014-05-13', 'PNCAV-SRT-UTAR-0049-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-0031-14 Documento general de planeacion. Anexo CD', 'PNCAV-UTAR-SRT-047-14.pdf', 72, '2014-05-23', NULL, 'PNCAV-UTAR-SRT-047-14', '0000-00-00', 'PNCAV-SRT-UTAR-0049-14.pdf', 2, 1),
(209, 1, 6, 36, 4, 3, '2014-05-13', 'PNCAV-SRT-UTAR-0050-14', 'Respuesta comunicado PNCAV-SRT-UTAR-0032-14 Ajustes de desarrollo impacto y apropiacion. Anexo Disco duro Portatil.', 'PNCAV-UTAR-SRT-046-14.pdf', 84, '2014-05-23', NULL, 'PNCAV-UTAR-SRT-046-14', '0000-00-00', 'PNCAV-SRT-UTAR-0050-14.pdf', 2, 1),
(210, 1, 8, 55, 3, 4, '2014-05-13', 'PNCAV-UTAR-SRT-058-14', 'Contrato de aporte N° 875 de 2013 seguro con todo riesgo ALLRisk', 'PNCAV-SRT-UTAR-0040-14.pdf', 87, '2014-05-20', NULL, 'PNCAV-SRT-UTAR-0040-14', '0000-00-00', 'PNCAV-UTAR-SRT-058-14.pdf', 2, 1),
(211, 1, 7, 45, 3, 1, '2014-05-13', 'PNCAV-DIRCON-INTV-042-14', 'Entrega informe Mensual N° 4 de Interventoria, Correspondiente al mes de Abril de 2014', 'PNCAV-SRT-DCO-0035-14.pdf', 86, '2014-05-27', '', 'PNCAV-SRT-DCO-0035-14', '0000-00-00', 'PNCAV-DIRCON-INTV-042-14.pdf', 2, 1),
(212, 1, 4, 20, 1, 3, '2014-05-14', 'PNCAV-SRT-DCO-0042-14', 'Revision informe financiero mes de Abril fidecomiso UT ANDIRED- 3-1-40730', 'PNCAV-DIRCON-INTV-039-14.pdf', 89, '2014-05-21', NULL, 'PNCAV-DIRCON-INTV-039-14', '0000-00-00', 'PNCAV-SRT-DCO-0042-14.pdf', 2, 1),
(213, 1, 9, 62, 4, 3, '2014-05-14', 'PNCAV-SRT-UTAR-0049-14', 'Documento General de Planeación-Anexo 10 cronograma plan de Instalaciones.', 'PNCAV-UTAR-SRT-048-14.pdf', 72, '2014-05-23', NULL, 'PNCAV-UTAR-SRT-048-14', '0000-00-00', 'PNCAV-SRT-UTAR-0049-14.pdf', 2, 1),
(214, 1, 4, 29, 4, 2, '2014-05-14', 'PNCAV-FIDU-UTAR-030-14', 'Respuesta comunicado PNCAV-SRT-UTAR-0034-14 Rendimientos Financieros.', 'PNCAV-UTAR-FIDU-011-14.pdf', 88, '2014-05-21', '', 'PNCAV-UTAR-FIDU-011-14', '2014-06-06', 'PNCAV-FIDU-UTAR-030-14.pdf', 2, 1),
(215, 1, 4, 22, 3, 4, '2014-05-14', 'PNCAV-UTAR-SRT-057-14', 'Solicitud estados financieros con corte 31 de diciembre de 2013 certificados y dictaminados.', 'PNCAV-SRT-UTAR-0041-14.pdf', 87, '2014-05-21', NULL, 'PNCAV-SRT-UTAR-0041-14', '0000-00-00', 'PNCAV-UTAR-SRT-057-14.pdf', 2, 1),
(216, 1, 9, 67, 3, 4, '2014-05-14', 'PNCAV-UTAR-SRT-060-14', 'Reiteracion solicitud realizada en el comunicado PNCAV-SRT-UTAR-0029-14- Cronograma estudios de campo.', 'PNCAV-SRT-UTAR-0042-14.pdf', 87, '2014-05-22', NULL, 'PNCAV-SRT-UTAR-0042-14', '0000-00-00', 'PNCAV-UTAR-SRT-060-14.pdf', 2, 1),
(217, 1, 6, 36, 3, 4, '2014-05-14', '', 'Devolucion Disco Duro Externo.', 'PNCAV-SRT-UTAR-0043-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0043-14', '0000-00-00', NULL, 1, 1),
(218, 1, 9, 80, 3, 1, '2014-05-14', '', 'Alcance modificatorio del comunicado PNCAV-SRT-DCO-0031-14- Informe avance sistema de informacion y web services de la interventoría, enero a marzo de 2014', 'PNCAV-SRT-DCO-0036-14.pdf', 86, '2014-05-22', NULL, 'PNCAV-SRT-DCO-0036-14', '0000-00-00', '', 4, 1),
(219, 1, 9, 79, 1, 3, '2014-05-15', 'PNCAV-SRT-DCO-0044-14', 'Solicitud de Construccion y verificacion de documentos Web service PNCAV. Anexo CD', 'PNCAV-DIRCON-INTV-038-14.pdf', 76, '2014-05-22', NULL, 'PNCAV-DIRCON-INTV-038-14', '0000-00-00', 'PNCAV-SRT-DCO-0044-14.pdf', 2, 1),
(220, 1, 7, 45, 3, 1, '2014-05-15', 'PNCAV-DIRCON-INTV-040-14', 'Respuesta a comunicado PNCAV-DIRCON-INTV-036-14 Ajustes informe mensual N° 3 de Interventoria, Correspondiente al mes de Marzo de 2014', 'PNCAV-SRT-DCO-0037-14.pdf', 86, '2014-05-22', '', 'PNCAV-SRT-DCO-0037-14', '0000-00-00', 'PNCAV-DIRCON-INTV-040-14.pdf', 2, 1),
(221, 1, 7, 43, 3, 1, '2014-05-16', 'PNCAV-DIRCON-INTV-050-14', 'Cambio Equipo de trabajo Interventoria', 'PNCAV-SRT-DCO-0038-14.pdf', 86, '2014-05-23', '', 'PNCAV-SRT-DCO-0038-14', NULL, 'PNCAV-DIRCON-INTV-050-14.pdf', 2, 1),
(222, 1, 4, 20, 3, 4, '2014-05-15', 'PNCAV-UTAR-SRT-053-14', 'Observaciones informe de fiducia periodo Marzo de 2014 y trimestral enero-marzo 2014.Respuesta a los comunicados PNCAV-UTAR-SRT-042-14 Y PNCAV-UTAR-SRT-043-14', 'PNCAV-SRT-UTAR-0044-14.pdf', 87, '2014-05-22', NULL, 'PNCAV-SRT-UTAR-0044-14', '0000-00-00', 'PNCAV-UTAR-SRT-053-14.pdf', 2, 1),
(223, 1, 7, 45, 4, 3, '2014-05-16', 'PNCAV-DIRCON-OPER-052-14', 'Informes mensuales de seguimiento de Enero , Febrero y Marzo de la UTANDIRED. Anexo CD', 'PNCAV-UTAR-SRT-049-14.pdf', 75, '2014-05-23', '', 'PNCAV-UTAR-SRT-049-14', NULL, 'PNCAV-DIRCON-OPER-052-14.pdf', 2, 1),
(224, 1, 4, 20, 3, 4, '2014-05-19', 'PNCAV-UTAR-SRT-056-14', 'Observaciones informe de Fiducia periodo abril de 2014.', 'PNCAV-SRT-UTAR-0046-14.pdf', 87, '2014-05-26', NULL, 'PNCAV-SRT-UTAR-0046-14', '0000-00-00', 'PNCAV-UTAR-SRT-056-14.pdf', 2, 1),
(225, 1, 8, 61, 3, 4, '2014-05-19', 'PNCAV-UTAR-SRT-054-14', 'Respuesta a comunicado PNCAV-UTAR-SRT-040-14 Diligenciamiento cuadro de licencias y permisos ambientales.', 'PNCAV-SRT-UTAR-0045-14.pdf', 87, '2014-05-22', '', 'PNCAV-SRT-UTAR-0045-14', '2014-05-23', 'PNCAV-UTAR-SRT-054-14.pdf', 2, 1),
(226, 1, 8, 50, 4, 3, '2014-05-20', 'PNCAV-SRT-DCO-0040-14', 'Parafiscales Mes de Abril de 2014.', 'PNCAV-UTAR-SRT-050-14.pdf', 71, '2014-05-27', NULL, 'PNCAV-UTAR-SRT-050-14', '0000-00-00', 'PNCAV-SRT-DCO-0040-14.pdf', 2, 1),
(227, 1, 7, 45, 1, 3, '2014-05-20', '', 'Aprobacion informe mensual N° 3', 'PNCAV-DIRCON-INTV-040-14.pdf', NULL, '0000-00-00', '', 'PNCAV-DIRCON-INTV-040-14', '0000-00-00', NULL, 2, 1),
(228, 1, 7, 45, 4, 3, '2014-05-20', 'PNCAV-DIRCON-OPER-052-14', 'Respuesta comunicado PNCAV-UTAR-SRT-049-14 Informes mensuales de seguimiento Febrero y Marzo', 'PNCAV-UTAR-SRT-051-14.pdf', 75, '2014-05-27', '', 'PNCAV-UTAR-SRT-051-14', NULL, 'PNCAV-DIRCON-OPER-052-14.pdf', 2, 1),
(229, 1, 7, 45, 4, 3, '2014-05-21', 'PNCAV-DIRCON-OPER-052-14', 'Informe mensual de seguimiento del mes de Marzo de 2014.', 'PNCAV-UTAR-SRT-052-14.pdf', 75, '2014-05-28', '', 'PNCAV-UTAR-SRT-052-14', NULL, 'PNCAV-DIRCON-OPER-052-14.pdf', 2, 1),
(230, 1, 7, 45, 3, 4, '2014-05-20', 'PNCAV-UTAR-SRT-062-14', 'Observaciones al informe de Abril de 2014 del contratista Union temporal Andired.', 'PNCAV-SRT-UTAR-0047-14.pdf', 87, '2014-05-27', '', 'PNCAV-SRT-UTAR-0047-14', '0000-00-00', 'PNCAV-UTAR-SRT-062-14.pdf', 2, 1),
(231, 1, 4, 20, 4, 3, '2014-05-22', 'PNCAV-SRT-UTAR-0055-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-044-14 Informe Fiduciario', 'PNCAV-UTAR-SRT-053-14.pdf', 89, '2014-05-29', NULL, 'PNCAV-UTAR-SRT-053-14', '0000-00-00', 'PNCAV-SRT-UTAR-0055-14.pdf', 2, 1),
(232, 1, 9, 67, 1, 4, '2014-05-23', '', 'Radicado 607274 Entrega de cronograma estudios de campo.', 'PNCAV-DIRCON-OPER-043-14.pdf', 72, '0000-00-00', NULL, 'PNCAV-DIRCON-OPER-043-14', '0000-00-00', NULL, 1, 1),
(233, 1, 5, 34, 3, 4, '2014-05-23', 'PNCAV-SRT-UTAR-0061-14', 'Solicitud de requisitos en HSEQ-Normatividad legal HSEQ.', 'PNCAV-SRT-UTAR-0048-14.pdf', 87, '2014-05-30', '', 'PNCAV-SRT-UTAR-0048-14', '0000-00-00', 'PNCAV-SRT-UTAR-0061-14.pdf', 2, 1),
(234, 1, 4, 20, 4, 3, '2014-05-23', 'PNCAV-SRT-UTAR-0058-14', 'Respuesta comunicado PNCAV-UTAR-SRT-056-14 Informe fiduciario mes de abril.', 'PNCAV-UTAR-SRT-056-14.pdf', 89, '2014-05-30', NULL, 'PNCAV-UTAR-SRT-056-14', '0000-00-00', 'PNCAV-SRT-UTAR-0058-14.pdf', 2, 1),
(235, 1, 9, 67, 4, 3, '2014-05-23', 'PNCAV-SRT-UTAR-0057-14', 'Contrato de aorte N° 000875 Estudios de campo.', 'PNCAV-UTAR-SRT-055-14.pdf', 72, '2014-05-30', NULL, 'PNCAV-UTAR-SRT-055-14', '0000-00-00', 'PNCAV-SRT-UTAR-0057-14.pdf', 2, 1),
(236, 1, 8, 61, 4, 3, '2014-05-23', 'PNCAV-SRT-UTAR-0049-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-0045-14 Licencias y permisos ambientales.', 'PNCAV-UTAR-SRT-054-14.pdf', 71, '2014-05-30', '', 'PNCAV-UTAR-SRT-054-14', '2014-05-23', 'PNCAV-SRT-UTAR-0049-14.pdf', 2, 1);
INSERT INTO `documento_comunicado` (`doc_id`, `dti_id`, `dot_id`, `dos_id`, `doa_id_autor`, `doa_id_dest`, `doc_fecha_radicado`, `doc_referencia`, `doc_descripcion`, `doc_archivo`, `usu_id`, `doc_fecha_respuesta`, `doc_anexo`, `doc_codigo_ref`, `doc_fecha_respondido`, `doc_referencia_respondido`, `doe_id`, `ope_id`) VALUES
(237, 1, 4, 20, 2, 4, '2014-05-26', '', 'Informes Mensual y trimestral', 'PNCAV-FIDU-UTAR-028-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-FIDU-UTAR-028-14', '0000-00-00', NULL, 2, 1),
(238, 1, 4, 19, 3, 1, '2014-05-26', '', 'Concepto de viabilidad del uso de recursos del anticipo sobre el pago de gastos bancarios', 'PNCAV-SRT-DCO-0041-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0041-14', '0000-00-00', NULL, 2, 1),
(239, 1, 4, 22, 4, 3, '2014-05-26', 'PNCAV-SRT-UTAR-0062-14', 'Respuesta comunicado PNCAV-SRT-UTAR-0041-14 Capacidad financiera.', 'PNCAV-UTAR-SRT-057-14.pdf', 89, '2014-06-03', NULL, 'PNCAV-UTAR-SRT-057-14', '0000-00-00', 'PNCAV-SRT-UTAR-0062-14.pdf', 2, 1),
(240, 1, 8, 55, 4, 3, '2014-05-26', 'PNCAV-SRT-UTAR-0056-14', 'Contrato de aporte-Respuesta comunicado PNCAV-SRT-UTAR-0040-14 - Poliza All Risk', 'PNCAV-UTAR-SRT-058-14.pdf', 71, '2014-06-03', NULL, 'PNCAV-UTAR-SRT-058-14', '0000-00-00', 'PNCAV-SRT-UTAR-0056-14.pdf', 2, 1),
(242, 1, 8, 50, 3, 1, '2014-05-26', '', 'Respuesta comunicado PNCAV-UTAR-SRT-050-14. Concepto Aportes Parafiscales periodo Abril 2014 Ley 789 de 2002 art 50- Aportes salud Mayo 2014 Decreto 2236 de 1999', 'PNCAV-SRT-DCO-0040-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0040-14', '0000-00-00', NULL, 1, 1),
(243, 1, 7, 45, 3, 1, '2014-05-26', '', 'Concepto revision informes mensuales de Enero, Febrero y Marzo de 2014 UTANDIRED', 'PNCAV-SRT-DCO-0039-14.pdf', NULL, '0000-00-00', '', 'PNCAV-SRT-DCO-0039-14', '0000-00-00', NULL, 2, 1),
(246, 1, 9, 82, 4, 3, '2014-05-26', '', 'Remisión RFI', 'PNCAV-UTAR-SRT-059-14.pdf', 72, '0000-00-00', '', 'PNCAV-UTAR-SRT-059-14', '0000-00-00', '', 1, 1),
(247, 1, 9, 67, 4, 3, '2014-05-27', 'PNCAV-SRT-UTAR-0057-14', 'Respuesta a comunicados PNCAV-SRT-UTAR-0029-14, PNCAV-SRT-UTAR-0042-14, PNCAV-DIRCON-OPER-043-14 ESTUDIOS DE CAMPO.', 'PNCAV-UTAR-SRT-060-14.pdf', 72, '2014-06-04', NULL, 'PNCAV-UTAR-SRT-060-14', '0000-00-00', 'PNCAV-SRT-UTAR-0057-14.pdf', 2, 1),
(248, 1, 9, 62, 3, 4, '2014-05-23', 'PNCAV-UTAR-SRT-065-14', 'Observaciones al documento general de planeacion version 2', 'PNCAV-SRT-UTAR-0049-14.pdf', 87, '2014-05-30', NULL, 'PNCAV-SRT-UTAR-0049-14', '0000-00-00', 'PNCAV-UTAR-SRT-065-14.pdf', 2, 1),
(249, 1, 6, 36, 3, 4, '2014-05-23', 'PNCAV-UTAR-SRT-064-14', 'Respuesta comunicado PNCAV-UTAR-SRT-046-14 Observaciones estudio desarrollo impacto y apropiacion.', 'PNCAV-SRT-UTAR-0050-14.pdf', 87, '2014-05-30', NULL, 'PNCAV-SRT-UTAR-0050-14', '0000-00-00', 'PNCAV-UTAR-SRT-064-14.pdf', 2, 1),
(250, 1, 4, 29, 2, 1, '2014-05-28', '', 'Rendimientos Financieros Abril de 2014.', 'PNCAV-FIDU-DIRCON-025-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-FIDU-DIRCON-025-14', '0000-00-00', NULL, 2, 1),
(251, 1, 4, 19, 4, 3, '2014-05-29', 'PNCAV-SRT-DCO-0046-14', 'Plan de inversion del anticipo-Actualizacion.', 'PNCAV-UTAR-SRT-061-14.pdf', 89, '2014-06-06', NULL, 'PNCAV-UTAR-SRT-061-14', '0000-00-00', 'PNCAV-SRT-DCO-0046-14.pdf', 2, 1),
(252, 1, 7, 45, 1, 3, '2014-05-29', 'PNCAV-SRT-DCO-0052-14', 'Observaciones del informe N° 4 del mes de Abril de 2014. Contrato de Interventoria N° 882 de 2013', 'PNCAV-DIRCON-INTV-042-14.pdf', 75, '2014-06-09', '', 'PNCAV-DIRCON-INTV-042-14', '0000-00-00', 'PNCAV-SRT-DCO-0052-14.pdf', 2, 1),
(253, 1, 9, 80, 1, 3, '2014-05-05', 'PNCAV-SRT-DCO-0036-14', 'Respuesta a comunicado PNCAV-SRT-DCO-0031-Informe avance sistema de informacion web services de la interventoria.Respuesta mediante correo Electronico', 'Respuesta a comunicado PNCAV-SRT-DCO-0031-14.pdf', 76, '2014-05-12', NULL, 'Email sistema informacion', '0000-00-00', 'PNCAV-SRT-DCO-0036-14.pdf', 2, 1),
(254, 1, 9, 67, 3, 4, '2014-05-29', 'PNCAV-SRT-UTAR-0083-14', 'Hallazgos identificados en Unguía Choco- Estudios de campo', 'PNCAV-SRT-UTAR-0051-14.pdf', 87, '2014-06-06', NULL, 'PNCAV-SRT-UTAR-0051-14', NULL, 'PNCAV-SRT-UTAR-0083-14.pdf', 2, 1),
(255, 1, 9, 63, 3, 4, '2014-05-29', 'PNCAV-UTAR-SRT-063-14', 'Asignacion de espectro radioelectrico.', 'PNCAV-SRT-UTAR-0052-14.pdf', 87, '2014-06-06', NULL, 'PNCAV-SRT-UTAR-0052-14', '0000-00-00', 'PNCAV-UTAR-SRT-063-14.pdf', 2, 1),
(256, 1, 6, 36, 3, 4, '2014-05-29', 'PNCAV-UTAR-SRT-066-14', 'Informe validacion de los estudios de desarrollo impacto y apropiacion.', 'PNCAV-SRT-UTAR-0053-14.pdf', 87, '2014-06-06', NULL, 'PNCAV-SRT-UTAR-0053-14', '0000-00-00', 'PNCAV-UTAR-SRT-066-14.pdf', 2, 1),
(257, 1, 9, 79, 3, 1, '2014-05-29', '', 'Respuesta a comunicado PNCAV-DIRCON-INTV-038-14 Solicitud de construccion y verificacion de documentos de web services PNCAV', 'PNCAV-SRT-DCO-0044-14.pdf', 76, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0044-14', '0000-00-00', NULL, 1, 1),
(258, 1, 5, 33, 3, 1, '2014-05-29', 'PNCAV-DIRCON-INTV-047-14', 'Alcance comunicado PNCAV-SRT-DCO-0020-14- Entrega metodo formal de Interventoria actualizado-plan de calidad', 'PNCAV-SRT-DCO-0045-14.pdf', 86, '2014-06-06', '', 'PNCAV-SRT-DCO-0045-14', '0000-00-00', 'PNCAV-DIRCON-INTV-047-14.pdf', 2, 1),
(259, 1, 4, 20, 3, 1, '2014-05-29', '', 'Respuesta comunicado PNCAV-DIRCON-INTV-039-14 Observaciones de fiducia abril de 2014', 'PNCAV-SRT-DCO-0042-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0042-14', '0000-00-00', NULL, 2, 1),
(260, 1, 6, 38, 3, 1, '2014-05-29', 'PNCAV-DIRCON-INTV-051-14', 'Alcance al comunicado PNCAV-SRT-DCO-0019-14-Metodologia levantamiento de la linea base del PNCAV', 'PNCAV-SRT-DCO-0043-14.pdf', 86, '2014-06-06', NULL, 'PNCAV-SRT-DCO-0043-14', '0000-00-00', 'PNCAV-DIRCON-INTV-051-14 - Aprob Metodología Linea Base.pdf', 2, 1),
(261, 1, 9, 63, 4, 3, '2014-06-03', 'PNCAV-SRT-DCO-0057-14', 'Respuesta a comumicado PNCAV-SRT-UTAR-052-14-Transminsion de datos- proceso de asignacion del espectro radioelectrico.', 'PNCAV-UTAR-SRT-063-14.pdf', 72, '2014-06-10', NULL, 'PNCAV-UTAR-SRT-063-14', '0000-00-00', 'PNCAV-SRT-DCO-0057-14.pdf', 2, 1),
(262, 1, 5, 33, 3, 1, '2014-05-30', 'PNCAV-DIRCON-INTV-065-14', 'Remision segunda encuesta de percepecion del cliente correspondiente al trimestre comprendido entre el 1 de marzo y el 31 de mayo de 2014', 'PNCAV-SRT-DCO-0050-14.pdf', 86, '2014-06-09', '', 'PNCAV-SRT-DCO-0050-14', '0000-00-00', 'PNCAV-DIRCON-INTV-065-14.pdf', 2, 1),
(263, 1, 5, 33, 3, 1, '2014-05-30', 'PNCAV-DIRCON-INTV-065-14', 'Alcance comunicado PNCAV-SRT-DCO-009-14 Encuesta de percepcion del cliente correspondiente al periodo 31 de Diciembre de 2013 al 28 de febrero de 2014', 'PNCAV-SRT-DCO-0049-14.pdf', 86, '2014-06-09', '', 'PNCAV-SRT-DCO-0049-14', '0000-00-00', 'PNCAV-DIRCON-INTV-065-14.pdf', 2, 1),
(264, 1, 4, 19, 3, 1, '2014-05-30', 'PNCAV-DIRCON-INTV-060-14', 'Solicitud modificacion plan de inversion de anticipo contrato 00882 de 2013', 'PNCAV-SRT-DCO-0048-14.pdf', 86, '2014-06-10', NULL, 'PNCAV-SRT-DCO-0048-14', '0000-00-00', 'PNCAV-DIRCON-INTV-060-14.pdf', 2, 1),
(265, 1, 8, 55, 3, 4, '2014-05-30', 'PNCAV-UTAR-SRT-070-14', 'Seguro contra todo riesgo ALLRisk- Contrato de aporte 00875 de 2013.', 'PNCAV-SRT-UTAR-0056-14.pdf', 87, '2014-06-09', NULL, 'PNCAV-SRT-UTAR-0056-14', '0000-00-00', 'PNCAV-UTAR-SRT-070-14.pdf', 2, 1),
(266, 1, 4, 20, 3, 4, '2014-05-30', '', 'Respuesta a comunicado PNCAV-UTAR-SRT-053-14- Concepto sobre informe fiduciario correspondiente al trimestre enero -marzo de 2014-', 'PNCAV-SRT-UTAR-0055-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0055-14', '0000-00-00', NULL, 2, 1),
(267, 1, 4, 20, 3, 4, '2014-05-30', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-0053-14 Informe fiduciario correspondiente al mes de marzo de 2014.', 'PNCAV-SRT-UTAR-0054-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0054-14', '0000-00-00', NULL, 2, 1),
(268, 1, 4, 20, 3, 1, '2014-05-30', '', 'Respuesta a comunicado PNCAV-FIDU-DIRCON-020-14 Liquidacion y traslado de rendimientos marzo de 2014.', 'PNCAV-SRT-DCO-0047-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0047-14', '0000-00-00', NULL, 2, 1),
(269, 1, 4, 19, 3, 1, '2014-05-30', '', 'Respuesta comunicado PNCAV-UTAR-SRT-061-14 Concepto modificacion plan de inversion del anticipo.', 'PNCAV-SRT-DCO-0046-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0046-14', '0000-00-00', NULL, 1, 1),
(270, 1, 7, 45, 4, 3, '2014-05-30', 'PNCAV-SRT-UTAR-0063-14', 'Respuesta a comunicado PNCAV-SRT-UTAR.0047-14 Ajustes informe Mensual del mes de Abril.', 'PNCAV-UTAR-SRT-062-14.pdf', 75, '2014-06-11', '', 'PNCAV-UTAR-SRT-062-14', '0000-00-00', 'PNCAV-SRT-UTAR-0063-14.pdf', 2, 1),
(271, 1, 9, 62, 4, 3, '2014-05-30', 'PNCAV-SRT-DCO-0055-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-049-14 Documento general de planeación.', 'PNCAV-UTAR-SRT-065-14.pdf', 72, '2014-06-11', NULL, 'PNCAV-UTAR-SRT-065-14', '0000-00-00', 'PNCAV-SRT-DCO-0055-14.pdf', 2, 1),
(272, 1, 6, 36, 4, 3, '2014-05-30', 'PNCAV-SRT-DCO-0054-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-050-14 Ajustes estudio de desarrollo impacto y apropiacion.', 'PNCAV-UTAR-SRT-064-14.pdf', 84, '2014-06-11', NULL, 'PNCAV-UTAR-SRT-064-14', '0000-00-00', 'PNCAV-SRT-DCO-0054-14.pdf', 2, 1),
(273, 1, 7, 43, 3, 1, '2014-06-03', '', 'Cambios equipo de trabajo de la interventoria.', 'PNCAV-SRT-DCO-0051-14.pdf', 86, '2014-06-10', '', 'PNCAV-SRT-DCO-0051-14', '0000-00-00', '', 4, 1),
(274, 1, 5, 33, 1, 3, '2014-06-04', '', 'Aprobacion plan de calidad y metodologias del metodo formal de interventoria- contrato 882 de 2013', 'PNCAV-DIRCON-INTV-047-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-DIRCON-INTV-047-14', '0000-00-00', NULL, 1, 1),
(275, 1, 5, 33, 1, 3, '2014-06-04', '', 'Seguimiento Plan de calidad Versión 3', 'PNCAV-DIRCON-INTV-046-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-DIRCON-INTV-046-14', '0000-00-00', NULL, 1, 1),
(276, 1, 9, 79, 1, 4, '2014-06-04', '', 'Segunda entrega de Web services.', 'PNCAV-DIRCON-OPER-044-14.pdf', 76, '0000-00-00', NULL, 'PNCAV-DIRCON-OPER-044-14', '0000-00-00', NULL, 1, 1),
(277, 1, 9, 67, 3, 4, '2014-06-04', 'PNCAV-UTAR-SRT-095-14', 'Respuesta comunicados PNCAV-UTAR-SRT-060-24 Y PNCAV-UTAR-SRT-055-14- Cronograma de realización de estudios de campo y caso alto Baudó- Choco.', 'PNCAV-SRT-UTAR-0057-14.pdf', 87, '2014-06-11', NULL, 'PNCAV-SRT-UTAR-0057-14', NULL, 'PNCAV-UTAR-SRT-095-14.pdf', 2, 1),
(278, 1, 4, 29, 2, 4, '2014-06-06', '', 'Respuesta comunicado PNCAV-UTAR-FIDU-011-14-Certificados de los fidecomitentes.', 'PNCAV-FIDU-UTAR-030-14.pdf', 87, '0000-00-00', '', 'PNCAV-FIDU-UTAR-030-14', '0000-00-00', '', 1, 1),
(279, 1, 4, 20, 2, 4, '2014-06-06', 'PNCAV-SRT-UTAR-0066-14', 'Informe Fiduciario Mensual del Mes de Mayo de 2014', 'PNCAV-FIDU-UTAR-029-14.pdf', 87, '2014-06-13', NULL, 'PNCAV-FIDU-UTAR-029-14', '0000-00-00', 'PNCAV-SRT-UTAR-0066-14.pdf', 2, 1),
(280, 1, 6, 36, 4, 3, '2014-06-06', 'PNCAV-SRT-UTAR-0064-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-053-14-Informe de validación de los estudios de desarrollo impacto y apropiacion. ( Anexo CD)', 'PNCAV-UTAR-SRT-066-14.pdf', 84, '2014-06-13', NULL, 'PNCAV-UTAR-SRT-066-14', '0000-00-00', 'PNCAV-SRT-UTAR-0064-14.pdf', 2, 1),
(281, 1, 4, 20, 3, 4, '2014-06-05', 'PNCAV-UTAR-SRT-073-14', 'Observaciones a la respuesta del comunicado PNCAV-UTAR-SRT-056-14, Informes de fiducia periodo abril de 2014.', 'PNCAV-SRT-UTAR-0058-14.pdf', 87, '2014-06-12', NULL, 'PNCAV-SRT-UTAR-0058-14', '0000-00-00', 'PNCAV-UTAR-SRT-073-14.pdf', 2, 1),
(282, 1, 6, 36, 3, 4, '2014-06-06', '', 'Devolución disco duro externo-Estudio de desarrollo, impacto y apropiación.', 'PNCAV-SRT-UTAR-0059-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0059-14', '0000-00-00', NULL, 1, 1),
(283, 1, 7, 45, 3, 1, '2014-06-06', 'PNCAV-DIRCON-INTV-058-14', 'Rta Comunicado PNCAV-DIRCON-INTV-042-14 Ajustes informe Mensual N° 4 de interventoria correspondiente al mes de abril de 2014.', 'PNCAV-SRT-DCO-0052-14.pdf', 86, '2014-06-13', '', 'PNCAV-SRT-DCO-0052-14', '0000-00-00', 'PNCAV-DIRCON-INTV-058-14.pdf', 2, 1),
(284, 1, 4, 25, 3, 1, '2014-06-06', 'PNCAV-DIRCON-INTV-062-14', 'Soportes de ejecucion de anticipo de contrato de Interventoria N° 00882 de 2013.', 'PNCAV-SRT-DCO-0053-14.pdf', 86, '2014-06-13', NULL, 'PNCAV-SRT-DCO-0053-14', '0000-00-00', 'PNCAV-DIRCON-INTV-062-14.pdf', 2, 1),
(285, 1, 5, 33, 3, 4, '2014-06-06', 'PNCAV-UTAR-SRT-075-14', 'Envío metodologías de verificacion de la Interventoria.', 'PNCAV-SRT-UTAR-0060-14.pdf', 87, '2014-06-13', '', 'PNCAV-SRT-UTAR-0060-14', '0000-00-00', 'PNCAV-UTAR-SRT-075-14.pdf', 2, 1),
(286, 1, 5, 34, 3, 4, '2014-06-09', 'PNCAV-UTAR-SRT-072-14', 'Alcance al comunicado PNCAV-SRT-UTAR-0048-14- Requerimientos HSEQ-Normatividad legal', 'PNCAV-SRT-UTAR-0061-14.pdf', 87, '2014-06-13', '', 'PNCAV-SRT-UTAR-0061-14', '0000-00-00', 'PNCAV-UTAR-SRT-072-14.pdf', 2, 1),
(287, 1, 7, 45, 4, 3, '2014-06-09', 'PNCAV-SRT-UTAR-0069-14', 'Informe Mensual de seguimiento, correspondiente al mes de Mayo de 2014, del contratista UNION TEMPORAL ANDIRED.', 'PNCAV-UTAR-SRT-068-14.pdf', 75, '2014-06-24', '', 'PNCAV-UTAR-SRT-068-14', '0000-00-00', 'PNCAV-SRT-UTAR-0069-14.pdf', 2, 1),
(288, 1, 9, 62, 4, 3, '2014-06-09', 'PNCAV-SRT-DCO-0055-14', 'Observaciones al documento general de planeación.', 'PNCAV-UTAR-SRT-067-14.pdf', 72, '2014-06-16', NULL, 'PNCAV-UTAR-SRT-067-14', '0000-00-00', 'PNCAV-SRT-DCO-0055-14.pdf', 2, 1),
(289, 1, 8, 55, 4, 3, '2014-06-10', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-056-14 Polizas.', 'PNCAV-UTAR-SRT-070-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-070-14', '0000-00-00', NULL, 1, 1),
(290, 1, 9, 62, 3, 1, '2014-06-09', '', 'Respuesta a comunicado PNCAV-UTAR-SRT-065 Y PNCAV-UTAR-SRT-067-14- Concepto documento general de planeacion.', 'PNCAV-SRT-DCO-0055-14.pdf', 86, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0055-14', '0000-00-00', NULL, 1, 1),
(291, 1, 6, 36, 3, 1, '2014-06-09', 'PNCAV-DIRCON-OPER-057-14', 'Respuesta a comunicados PNCAV-UTAR-SRT-064-14 Concepto estudios de desarrollo impacto y apropiacion.', 'PNCAV-SRT-DCO-0054-14.pdf', 86, '2014-06-16', NULL, 'PNCAV-SRT-DCO-0054-14', '0000-00-00', 'PNCAV-DIRCON-OPER-057-14.pdf', 2, 1),
(292, 1, 7, 45, 3, 1, '2014-06-10', 'PNCAV-DIRCON-INTV-063-14', 'Entrega Informe Mensual N° 5 de Interventoria, correspondiente al mes de Mayo de 2014.', 'PNCAV-SRT-DCO-0056-14.pdf', 86, '2014-06-24', '', 'PNCAV-SRT-DCO-0056-14', '0000-00-00', 'PNCAV-DIRCON-INTV-063-14.pdf', 2, 1),
(293, 1, 4, 20, 1, 3, '2014-06-11', 'PNCAV-SRT-DCO-0058-14', 'Revision informe financiero mes de Mayo 2014.', 'PNCAV-DIRCON-INTV-056-14.pdf', 89, '2014-06-18', NULL, 'PNCAV-DIRCON-INTV-056-14', '0000-00-00', 'PNCAV-SRT-DCO-0058-14.pdf', 2, 1),
(294, 1, 4, 27, 4, 3, '2014-06-11', 'Orden de pago 3 Observaciones', 'Remision orden de pago No. 3', 'PNCAV-UTAR-SRT-071-14.pdf', 89, '2014-06-18', NULL, 'PNCAV-UTAR-SRT-071-14', '0000-00-00', 'Observaciones Orden de pago N° 3.pdf', 2, 1),
(295, 1, 4, 22, 3, 4, '2014-06-11', 'PNCAV-SRT-UTAR-0068-14', 'Respuesta a comunicado PNCAV-UTAR-SRT-0057-14 Observaciones a los estados financieros con corte 31 de diciembre de 2013- certificados y dictaminados', 'PNCAV-SRT-UTAR-0062-14.pdf', 87, '2014-06-18', NULL, 'PNCAV-SRT-UTAR-0062-14', '0000-00-00', 'PNCAV-SRT-UTAR-0068-14.pdf', 2, 1),
(296, 1, 9, 63, 3, 1, '2014-06-11', '', 'Respuesta a comunicado PNCAV-UTAR-SRT-063-14 Seguimiento a cronograma de la resoluecion de asignacion de espectro electromagnetico', 'PNCAV-SRT-DCO-0057-14.pdf', 86, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0057-14', '0000-00-00', NULL, 1, 1),
(297, 1, 7, 45, 3, 4, '2014-06-12', 'PNCAV-UTAR-SRT-077-14', 'Respuesta a comunicado PNCAV-UTAR-SRT-062-14- Observaciones al informe mensual de seguimiento N° 4 Correspondiente a Abril de 2014 del contratista Union Temporal', 'PNCAV-SRT-UTAR-0063-14.pdf', 87, '2014-06-19', '', 'PNCAV-SRT-UTAR-0063-14', '0000-00-00', 'PNCAV-UTAR-SRT-077-14.pdf', 2, 1),
(298, 1, 6, 38, 1, 3, '2014-06-13', '', 'Aprobacion Metodologia para levantamiento de la linea base del PNCAV', 'PNCAV-DIRCON-INTV-051-14 - Aprob Metodología Linea Base.pdf', NULL, '0000-00-00', NULL, 'PNCAV-DIRCON-INTV-051-14', '0000-00-00', NULL, 1, 1),
(299, 1, 4, 29, 4, 2, '2014-06-13', '', 'Respuesta a comunicado PNCAV-FIDU-UTAR-030-14- Certificados de ingresos y retencion en la fuente de ICA y RETEICA', 'PNCAV-UTAR-FIDU-012-14.pdf', 88, '0000-00-00', '', 'PNCAV-UTAR-FIDU-012-14', '0000-00-00', '', 1, 1),
(300, 1, 4, 20, 4, 3, '2014-06-13', 'PNCAV-SRT-UTAR-0071-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-058-14- Financiero Informe fiduciario del mes de abril/14', 'PNCAV-UTAR-SRT-073-14.pdf', 89, '2014-06-20', NULL, 'PNCAV-UTAR-SRT-073-14', '0000-00-00', 'PNCAV-SRT-UTAR-0071-14.pdf', 2, 1),
(301, 1, 5, 34, 4, 3, '2014-06-13', 'PNCAV-SRT-UTAR-0073-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-0048-14 Y PNCAV-SRT-UTAR-0061-14 Normatividad legal HSEQ', 'PNCAV-UTAR-SRT-072-14.pdf', 69, '2014-06-20', '', 'PNCAV-UTAR-SRT-072-14', '0000-00-00', 'PNCAV-SRT-UTAR-0073-14.pdf', 2, 1),
(303, 1, 9, 62, 4, 3, '2014-06-13', 'PNCAV-SRT-DCO-0059-14', 'Respuesta a comunicado PNCAV-SRT-DCO-0055-14 Documento general de planeacion', 'PNCAV-UTAR-SRT-074-14.pdf', 72, '2014-06-20', NULL, 'PNCAV-UTAR-SRT-074-14', '0000-00-00', 'PNCAV-SRT-DCO-0059-14.pdf', 2, 1),
(304, 1, 6, 36, 3, 4, '2014-06-13', 'PNCAV-UTAR-SRT-084-14', 'Respuesta a comunicado PNCAV-UTAR-SRT-066-14 Observaciones al informe visita en campo de los estudios de desarrollo impacto y apropiacion', 'PNCAV-SRT-UTAR-0064-14.pdf', 87, '2014-06-20', NULL, 'PNCAV-SRT-UTAR-0064-14', '0000-00-00', 'PNCAV-UTAR-SRT-084-14.pdf', 2, 1),
(305, 1, 6, 36, 1, 4, '2014-06-16', '', 'Aprobacion estudio de desarrollo impacto y apropiacion.', 'PNCAV-DIRCON-OPER-057-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-DIRCON-OPER-057-14', '0000-00-00', NULL, 1, 1),
(306, 1, 4, 27, 4, 3, '2014-06-16', '', 'Comunicado PNCAV-UTAR-SRT-071-14 Remisión cuenta de cobro orden de pago No 3', 'PNCAV-UTAR-SRT-076-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-076-14', '0000-00-00', NULL, 2, 1),
(307, 1, 5, 33, 4, 3, '2014-06-16', 'PNCAV-SRT-UTAR-0074-14', 'Respuesta a comunciado PNCAV-SRT-UTAR-0060-14 Plan de calidad HSEQ', 'PNCAV-UTAR-SRT-075-14.pdf', 69, '2014-06-23', '', 'PNCAV-UTAR-SRT-075-14', '0000-00-00', 'PNCAV-SRT-UTAR-0074-14.pdf', 2, 1),
(308, 1, 4, 20, 3, 1, '2014-06-16', '', 'Respuesta a comunicado PNCAV-DIRCON-INTV-056-14 Observaciones informe de Fiducia mayo de 2014 por el FONTIC', 'PNCAV-SRT-DCO-0058-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0058-14', '0000-00-00', NULL, 2, 1),
(309, 1, 4, 20, 3, 4, '2014-06-16', 'PNCAV-UTAR-SRT-086-14', 'Respuesta a comunicado PNCAV-FIDU-UTAR-029-14 Observaciones informe de Fiducia periodo mayo de 2014.', 'PNCAV-SRT-UTAR-0066-14.pdf', 87, '2014-06-24', NULL, 'PNCAV-SRT-UTAR-0066-14', '0000-00-00', 'PNCAV-UTAR-SRT-086-14.pdf', 2, 1),
(310, 1, 5, 31, 3, 4, '2014-06-16', 'PNCAV-UTAR-SRT-078-14', 'Solicitud copia comunicado enviado a PNN con radicado 2014-460003737-2 y radicacion de solicitud de licencia ante el ANLA', 'PNCAV-SRT-UTAR-0065-14.pdf', 87, '2014-06-23', '', 'PNCAV-SRT-UTAR-0065-14', '0000-00-00', 'PNCAV-UTAR-SRT-078-14.pdf', 2, 1),
(311, 1, 8, 61, 4, 1, '2014-06-17', '', 'Respuesta a comunicado PNCAV-DIRCON-OPER-049-14 Documentos trazabilidad consultas previas y temas ambientales PNCAV', 'PNCAV-UTAR-DIRCON-013-14.pdf', 86, '0000-00-00', '', 'PNCAV-UTAR-DIRCON-013-14', '0000-00-00', '', 1, 1),
(312, 1, 7, 45, 4, 3, '2014-06-17', 'PNCAV-SRT-UTAR-0070-14', 'Respuesta a comunciado PNCAV-SRT-UTAR-0063-14 Ajustes Informe mensual correspondiente al mes de Abril de 2014', 'PNCAV-UTAR-SRT-077-14.pdf', 75, '2014-06-24', '', 'PNCAV-UTAR-SRT-077-14', '0000-00-00', 'PNCAV-SRT-UTAR-0070-14.pdf', 2, 1),
(313, 1, 4, 20, 4, 3, '2014-06-18', 'Observaciones Ordenes de pago', 'Remisión ordenes de pago 1 y 2-  Estudio Desarrollo impacto y Apropiación.', 'PNCAV-UTAR-SRT-080-14.pdf', 89, '2014-06-25', NULL, 'PNCAV-UTAR-SRT-080-14', '0000-00-00', 'Observaciones Ordenes de pago 1 y 2.pdf', 2, 1),
(314, 1, 8, 50, 4, 3, '2014-06-18', 'PNCAV-SRT-DCO-0061-14', 'Parafiscales mes de Mayo de 2014.', 'PNCAV-UTAR-SRT-079-14.pdf', 71, '2014-06-25', NULL, 'PNCAV-UTAR-SRT-079-14', '0000-00-00', 'PNCAV-SRT-DCO-0061-14.pdf', 2, 1),
(315, 1, 8, 61, 4, 3, '2014-06-18', 'PNCAV-SRT-UTAR-0082-14', 'Respuesta a comunicado PNCAV-SRT-UTAR-0065-14 Permisos y licencias ambientales', 'PNCAV-UTAR-SRT-078-14.pdf', 71, '2014-06-25', NULL, 'PNCAV-UTAR-SRT-078-14', NULL, 'PNCAV-SRT-UTAR-0082-14.pdf', 2, 1),
(316, 1, 6, 41, 3, 4, '2014-06-17', 'PNCAV-UTAR-SRT-095-14', 'Respuesta a comunicado PNCAV-DIRCON-OPER-029-13 Seguimiento portal cautivo y vallas informativas', 'PNCAV-SRT-UTAR-0067-14.pdf', 87, '2014-06-24', '', 'PNCAV-SRT-UTAR-0067-14', NULL, 'PNCAV-UTAR-SRT-095-14.pdf', 2, 1),
(317, 1, 4, 27, 4, 3, '2014-06-19', 'PNCAV-SRT-UTAR-0072-14', 'Remision orden de pago N° 4 Estudio de impacto y apropiacion y Orden de pago N° 5 Estudio de impacto y apropiacion', 'PNCAV-UTAR-SRT-082-14.pdf', 89, '2014-06-26', NULL, 'PNCAV-UTAR-SRT-082-14', '0000-00-00', 'PNCAV-SRT-UTAR-0072-14.pdf', 2, 1),
(318, 1, 7, 42, 4, 3, '2014-06-19', '', 'Remision para firma de Acta N° 11 seguimiento al operador', 'PNCAV-UTAR-SRT-081-14.pdf', 75, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-081-14', '0000-00-00', NULL, 1, 1),
(319, 1, 4, 29, 4, 1, '2014-06-19', '', 'Comprobante de ingreso N° 682', 'PNCAV-UTAR-DIRCON-014-14.pdf', 86, '0000-00-00', '', 'PNCAV-UTAR-DIRCON-014-14', '0000-00-00', '', 1, 1),
(320, 1, 4, 22, 3, 4, '2014-06-19', 'PNCAV-UTAR-SRT-087-14', 'Alcance al comunicado PNCAV-SRT-UTAR-0062-14 Observaciones a los estados financieros con corte 31 de diciembre de 2013 certificados y dictaminados.', 'PNCAV-SRT-UTAR-0068-14.pdf', 87, '2014-06-24', NULL, 'PNCAV-SRT-UTAR-0068-14', '0000-00-00', 'PNCAV-UTAR-SRT-087-14.pdf', 2, 1),
(321, 1, 4, 27, 4, 3, '2014-06-20', 'Orden de pago 3 Observaciones', 'Alcance a comunicado PNCAV-UTAR-SRT-071-14 Remision orden de pago N° 3', 'PNCAV-UTAR-SRT-085-14.pdf', 89, '2014-07-01', NULL, 'PNCAV-UTAR-SRT-085-14', '0000-00-00', 'Observaciones Orden de pago N° 3.pdf', 2, 1),
(322, 1, 6, 36, 4, 3, '2014-06-20', '', 'Respuesta a comunicado PNCAV-SRT-UTAR-064-14 Informe de validacion de los estudios de desarrollo impacto y apropiacion.', 'PNCAV-UTAR-SRT-084-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-084-14', '0000-00-00', NULL, 1, 1),
(323, 1, 7, 45, 1, 3, '2014-06-24', '', 'Aprobacion del informe N° 4 de Interventoria del mes de Abril de 2014.', 'PNCAV-DIRCON-INTV-058-14.pdf', 75, '0000-00-00', NULL, 'PNCAV-DIRCON-INTV-058-14', '0000-00-00', NULL, 1, 1),
(324, 1, 4, 22, 2, 1, '2014-06-24', '', 'Rendimientos financieros Mayo de 2014.', 'PNCAV-FIDU-DIRCON-031-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-FIDU-DIRCON-031-14', '0000-00-00', NULL, 1, 1),
(325, 1, 4, 27, 4, 3, '2014-06-20', 'Observaciones Ordenes de pago', 'Remision orden  de pago N° 6 por concepto de Estudios de campo y Orden de pago N° 7 por concepto de consultas previas.', 'PNCAV-UTAR-SRT-083-14.pdf', 89, '2014-07-01', NULL, 'PNCAV-UTAR-SRT-083-14', '0000-00-00', 'Observaciones Ordenes de pago 6 y 7.pdf', 2, 1),
(326, 1, 7, 45, 3, 4, '2014-06-24', 'PNCAV-UTAR-SRT-097-14', 'Rta comunicado PNCAV-UTAR-SRT-068-14 Observaciones al informe mensual de seguimiento N° 5 correspondiente al mes de mayo de la UTANDIRED', 'PNCAV-SRT-UTAR-0069-14.pdf', 87, '2014-07-02', '', 'PNCAV-SRT-UTAR-0069-14', '0000-00-00', 'PNCAV-UTAR-SRT-097-14.pdf', 2, 1),
(327, 1, 9, 62, 3, 1, '2014-06-24', '', 'RTA Comunicado PNCAV-UTAR-SRT-074-14 Concepto documento general de planeación.', 'PNCAV-SRT-DCO-0059-14.pdf', 86, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0059-14', '0000-00-00', NULL, 1, 1),
(328, 1, 4, 20, 4, 3, '2014-06-24', 'PNCAV-SRT-UTAR-0075-14', 'Rta comunicado PNCAV-SRT-UTAR-066-14 Financiero -informe fiduciario', 'PNCAV-UTAR-SRT-086-14.pdf', 89, '2014-07-02', NULL, 'PNCAV-UTAR-SRT-086-14', NULL, 'PNCAV-SRT-UTAR-0075-14.pdf', 2, 1),
(329, 1, 4, 22, 4, 3, '2014-06-24', 'PNCAV-SRT-UTAR-0081-14', 'Rta comunicado PNCAV-SRT-UTAR-0062-14 Y PNCAV-SRT-UTAR-0068-14 Capacidad financiera.', 'PNCAV-UTAR-SRT-087-14.pdf', 89, '2014-07-02', NULL, 'PNCAV-UTAR-SRT-087-14', NULL, 'PNCAV-SRT-UTAR-0081-14.pdf', 2, 1),
(330, 1, 7, 42, 4, 3, '2014-06-24', '', 'Remision para firma- Acta de comite directivo N° 5', 'PNCAV-UTAR-SRT-088-14.pdf', 75, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-088-14', '0000-00-00', NULL, 1, 1),
(331, 1, 4, 27, 4, 3, '2014-06-24', 'Observaciones Orden de pago 8', 'Remision orden de pago N° 8 por concepto de consultas previas.', 'PNCAV-UTAR-SRT-089-14.pdf', 89, '2014-07-02', NULL, 'PNCAV-UTAR-SRT-089-14', NULL, 'Observaciones orden de pago N° 8.pdf', 2, 1),
(332, 1, 4, 19, 1, 3, '2014-06-25', '', 'Solicitud modificacion plan de inversion del anticipo.', 'PNCAV-DIRCON-INTV-060-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-DIRCON-INTV-060-14', '0000-00-00', NULL, 1, 1),
(333, 1, 4, 19, 1, 3, '2014-06-26', 'PNCAV-SRT-DCO-0063', 'Soportes Ejecucion del anticipo', 'PNCAV-DIRCON-INTV-062-14.pdf', 89, '2014-07-04', NULL, 'PNCAV-DIRCON-INTV-062-14', '0000-00-00', 'PNCAV-SRT-DCO-0063-14.pdf', 2, 1),
(334, 1, 7, 45, 4, 3, '2014-06-26', 'PNCAV-SRT-UTAR-0079-14', 'Rta comunicado PNCAV-UTAR-SRT-077-14 Ajustes informe mensual de seguimiento del mes de Abril de 2014.', 'PNCAV-UTAR-SRT-090-14.pdf', 75, '2014-07-04', '', 'PNCAV-UTAR-SRT-090-14', '0000-00-00', 'PNCAV-SRT-UTAR-0079-14.pdf', 2, 1),
(335, 1, 7, 42, 4, 3, '2014-06-25', '', 'Remision Acta de reunion de seguimiento N° 10 para respectivas firmas.', 'PNCAV-UTAR-SRT-091-14.pdf', 75, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-091-14', '0000-00-00', NULL, 1, 1),
(336, 1, 4, 27, 4, 3, '2014-06-26', 'Observaciones Orden de pago 9', 'Remision orden de pago N° 9- Diseño de la red.', 'PNCAV-UTAR-SRT-093-14.pdf', 89, '2014-07-04', NULL, 'PNCAV-UTAR-SRT-093-14', '0000-00-00', 'Observaciones Orden de pago N° 9.pdf', 2, 1),
(337, 1, 7, 45, 4, 3, '2014-06-26', '', 'RTA a comunicado PNCAV-SRT-UTAR-0070-14 Emision de Observaciones al informe de abril mediante comunicado PNCAV-UTAR-SRT-090-14', 'PNCAV-UTAR-SRT-092-14.pdf', 75, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-092-14', '0000-00-00', NULL, 1, 1),
(338, 1, 8, 52, 3, 1, '2014-06-25', '', 'Delegacion SERTIC S.A.S al comite fiduciario del contrato fiduciario N° 3-1 40730', 'PNCAV-SRT-DCO-0062-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0062-14', '0000-00-00', NULL, 1, 1),
(339, 1, 4, 29, 3, 1, '2014-06-25', '', 'Rta a comunicado PNCAV-FIDU-DIRCON-025-14 Liquidacion y traslado de rendimientos abril de 2014- Contrato de aporte N° 875 de 2013', 'PNCAV-SRT-DCO-0060-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0060-14', '0000-00-00', NULL, 1, 1),
(340, 1, 7, 45, 3, 4, '2014-06-25', 'PNCAV-UTAR-SRT-090-14', 'Rta a comunicado PNCAV-UTAR-SRT-077-14 Obaservaciones al informe mensual de seguimiento N° 4 correspondiente a a abril de 2014', 'PNCAV-SRT-UTAR-0070-14.pdf', 87, '2014-07-03', '', 'PNCAV-SRT-UTAR-0070-14', '0000-00-00', 'PNCAV-UTAR-SRT-090-14.pdf', 2, 1),
(341, 1, 8, 50, 3, 1, '2014-06-25', '', 'Rta comunicado PNCAV-UTAR-SRT-079-14 Concepto aportes a seguridad social y parafiscales periodo  Mayo 2014- y aportes de salud Junio de 2014.', 'PNCAV-SRT-DCO-0061-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-DCO-0061-14', '0000-00-00', NULL, 1, 1),
(342, 1, 4, 20, 3, 4, '2014-06-25', '', 'Rta a comunicado PNCAV-UTAR-SRT-073-14 Concepto informe fiduciario correspondiente al mes de abril de 2014.', 'PNCAV-SRT-UTAR-0071-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0071-14', '0000-00-00', NULL, 1, 1),
(343, 1, 4, 27, 4, 3, '2014-06-26', '', 'Alcance al comunicado PNCAV-UTAR-SRT-083-14 Orden de pago N° 6', 'PNCAV-UTAR-SRT-094-14.pdf', 89, '2014-07-04', NULL, 'PNCAV-UTAR-SRT-094-14', '0000-00-00', '', 4, 1),
(344, 1, 9, 82, 4, 3, '2014-06-27', '', 'Entrega de planes- Meta 2', 'PNCAV-UTAR-SRT-095-14.pdf', 75, '2014-07-28', '', 'PNCAV-UTAR-SRT-095-14', '0000-00-00', '', 3, 1),
(345, 1, 4, 25, 3, 1, '2014-06-27', '', 'Rta comunicado PNCAV-DIRCON-INTV-062-14 Soportes de ejecucion de anticipo contrato de Interventoria.', 'PNCAV-SRT-DCO-0063-14.pdf', 86, '2014-07-07', NULL, 'PNCAV-SRT-DCO-0063', '0000-00-00', '', 4, 1),
(346, 1, 4, 27, 3, 4, '2014-06-27', '', 'Rta comunicado PNCAV-UTAR-SRT-082-14 Devolucion de ordenes de operacion 314073407-4 Y 314073407-5', 'PNCAV-SRT-UTAR-0072-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0072-14', '0000-00-00', NULL, 1, 1),
(347, 1, 5, 35, 3, 4, '2014-06-27', 'PNCAV-UTAR-SRT-100-14', 'Rta comunicado PNCAV-UTAR-SRT-0072-14 Solicitud de informacion de cumplimiento de seguridad industrial y seguridad en el trabajo.', 'PNCAV-SRT-UTAR-0073-14.pdf', 87, '2014-07-07', '', 'PNCAV-SRT-UTAR-0073-14', '0000-00-00', 'PNCAV-UTAR-SRT-100-14.pdf', 2, 1),
(348, 1, 7, 45, 1, 3, '2014-07-01', 'PNCAV-SRT-DCO-0065-14', 'Observaciones del informe de interventoria  N° 5 del mes de mayo de 2014', 'PNCAV-DIRCON-INTV-063-14.pdf', 75, '2014-07-08', '', 'PNCAV-DIRCON-INTV-063-14', '0000-00-00', 'PNCAV-SRT-UTAR-0065-14.pdf', 2, 1),
(349, 1, 4, 27, 4, 3, '2014-07-01', 'Observaciones Orden de pago 10', 'Remisión orden de pago N° 10-Diseño de red.', 'PNCAV-UTAR-SRT-096-14.pdf', 89, '2014-07-08', NULL, 'PNCAV-UTAR-SRT-096-14', NULL, 'Observaciones orden de pago N°  10.pdf', 2, 1),
(350, 1, 5, 33, 1, 3, '2014-07-02', '', 'Remisión Encuesta de Percepción del cliente', 'PNCAV-DIRCON-INTV-065-14.pdf', NULL, '0000-00-00', '', 'PNCAV-DIRCON-INTV-065-14', '0000-00-00', '', 2, 1),
(351, 1, 4, 27, 3, 4, '2014-07-02', '', 'Observaciones Ordenes de pago 6 y 7', 'Observaciones Ordenes de pago 6 y 7.pdf', 87, '2014-07-04', NULL, 'Email ordenes 6 y 7', '0000-00-00', '', 4, 1),
(352, 1, 4, 27, 3, 4, '2014-07-01', 'PNCAV-UTAR-SRT-099-14', 'Observaciones Ordenes de pago 1 y 2.', 'Observaciones Ordenes de pago 1 y 2.pdf', 87, '2014-07-09', NULL, 'email', '0000-00-00', 'PNCAV-UTAR-SRT-099-14.pdf', 2, 1),
(353, 1, 4, 27, 3, 4, '2014-07-02', '', 'Observaciones Orden de pago N° 3', 'Observaciones Orden de pago N° 3.pdf', 87, '2014-07-09', NULL, 'Email Orden 3', '0000-00-00', '', 4, 1),
(354, 1, 9, 82, 1, 4, '2014-07-10', '', 'Entrega del agente monitoreo de la Dirección de Conectividad.', 'PNCAV-DIRCON-OPER-066-14.pdf', 87, '0000-00-00', '', 'PNCAV-DIRCON-OPER-066-14', '0000-00-00', '', 1, 1),
(355, 1, 4, 20, 2, 4, '2014-07-04', 'PNCAV-SRT-UTAR-0087-14', 'Rendicion trimestral Abril-Junio de 2014.', 'PNCAV-FIDU-UTAR-034-14.pdf', 89, '2014-07-11', NULL, 'PNCAV-FIDU-UTAR-0034-14', NULL, 'PNCAV-SRT-UTAR-0087-14.pdf', 2, 1),
(356, 1, 4, 20, 2, 4, '2014-07-04', 'PNCAV-SRT-UTAR-0085-14', 'Informe mensual del mes de Junio de 2014', 'PNCAV-FIDU-UTAR-033-14.pdf', 89, '2014-07-11', NULL, 'PNCAV-FIDU-UTAR-033-14', NULL, 'PNCAV-SRT-UTAR-0085-14.pdf', 2, 1),
(357, 1, 4, 29, 3, 1, '2014-07-03', '', 'Rta comunicado PNCAV-FIDU-DIRCON-031-14 Liquidacion y traslado de rendimientos mayo de 2014- Contrato de aporte N° 00875 de 2013', 'PNCAV-SRT-DCO-0064-14.pdf', 86, '0000-00-00', '', 'PNCAV-SRT-DCO-0064-14', '0000-00-00', '', 1, 1),
(358, 1, 4, 20, 3, 4, '2014-07-02', '', 'Concepto informe fiduciario correspondiente al mes de mayo de 2014', 'PNCAV-SRT-UTAR-0075-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0075-14', '0000-00-00', NULL, 1, 1),
(359, 1, 5, 33, 3, 4, '2014-07-03', '', 'Rta a comunicado PNCAV-UTAR-SRT-075-14 Metodologias de trabajo de la interventoria', 'PNCAV-SRT-UTAR-0074-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0074-14', '0000-00-00', NULL, 1, 1),
(360, 1, 7, 45, 4, 3, '2014-07-07', 'PNCAV-SRT-UTAR-0086-14', 'Rta comunicado PNCAV-SRT-UTAR-0069-14 Ajustes informe mensual de seguimiento correspondiente al mes de mayo de 2014.', 'PNCAV-UTAR-SRT-097-14.pdf', 72, '2014-07-14', NULL, 'PNCAV-UTAR-SRT-097-14', NULL, 'PNCAV-SRT-UTAR-0086-14.pdf', 2, 1),
(361, 1, 4, 29, 3, 4, '2014-07-04', 'PNCAV-UTAR-SRT-101-14', 'Solicitud cuantificacion plan de integracion suministros e instalacion.', 'PNCAV-SRT-UTAR-0077-14.pdf', 87, '2014-07-11', '', 'PNCAV-SRT-UTAR-0077-14', NULL, 'PNCAV-UTAR-SRT-101-14.pdf', 2, 1),
(362, 1, 7, 45, 4, 3, '2014-07-07', '', 'Informe Mensual del contratista correspondiente al mes de Junio de 2014', 'PNCAV-UTAR-SRT-098-14.pdf', 72, '2014-07-23', NULL, 'PNCAV-UTAR-SRT-098-14', '0000-00-00', '', 3, 1),
(363, 1, 9, 82, 3, 4, '2014-07-07', 'PNCAV-UTAR-SRT-112-14', 'Asignacion espectro radioelectrico', 'PNCAV-SRT-UTAR-0076-14.pdf', 87, '2014-07-14', '', 'PNCAV-SRT-UTAR-0076-14', NULL, 'PNCAV-UTAR-SRT-112-14.pdf', 2, 1),
(364, 1, 9, 82, 3, 4, '2014-07-07', 'PNCAV-UTAR-SRT-108-14', 'Solicitud de usuario y constraseña de ingreso a la aplicacion que contiene los estudios de campo.', 'PNCAV-SRT-UTAR-0078-14.pdf', 87, '2014-07-14', '', 'PNCAV-SRT-UTAR-0078-14', NULL, 'PNCAV-UTAR-SRT-108-14.pdf', 2, 1),
(365, 1, 7, 45, 3, 4, '2014-07-07', 'PNCAV-UTAR-SRT-107-14', 'Rta comunicado PNCAV-UTAR-SRT-077-14 Observaciones al informe mensual de seguimiento N° 4 correspondiente a abril de 2014 de la Union temporal Andired', 'PNCAV-SRT-UTAR-0079-14.pdf', 87, '2014-07-14', '', 'PNCAV-SRT-UTAR-0079-14', NULL, 'PNCAV-UTAR-SRT-107-14.pdf', 2, 1),
(366, 1, 7, 45, 3, 1, '2014-07-07', '', 'Rta comunicado PNCAV-DIRCON-INTV-036-14 Ajustes informe mensual N° 5 de Interventoria correspondiente al mes de mayo de 2014', 'PNCAV-SRT-UTAR-0065-14.pdf', 86, '2014-07-14', '', 'PNCAV-SRT-DCO-0065-14', '0000-00-00', '', 3, 1),
(368, 1, 5, 35, 4, 3, '2014-07-08', '', 'Rta comunicado PNCAV-SRT-UTAR-0073-14 Solicitud de informacion de cumplimiento de seguridad industrial y seguridad en el trabajo', 'PNCAV-UTAR-SRT-100-14.pdf', 69, '2014-07-15', '', 'PNCAV-UTAR-SRT-100-14', '0000-00-00', '', 3, 1),
(369, 1, 4, 27, 4, 3, '2014-07-08', 'PNCAV-UTAR-SRT-102-14', 'Rta comunicado PNCAV-UTAR-SRT-080-14 Observaciones en referencia al entregable correspondiente a las ordenes de pago 1 y 2 Sociedad Colombiana de Consultoria', 'PNCAV-UTAR-SRT-099-14.pdf', 89, '2014-07-15', NULL, 'PNCAV-UTAR-SRT-099-14', NULL, 'PNCAV-UTAR-SRT-102-14.pdf', 2, 1),
(371, 1, 4, 20, 2, 4, '2014-07-10', '', 'Alcance al informe fiduciario del mes de Abril-Junio de 2014', 'PNCAV-FIDU-UTAR-035-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-FIDU-UTAR-035-14', '0000-00-00', NULL, 1, 1),
(372, 1, 6, 39, 3, 1, '2014-07-09', '', 'Entrega opciones de diseño del portal cautivo', 'PNCAV-SRT-DCO-0066-14.pdf', 86, '2014-07-16', 'PNCAV-SRT-DCO-0066-14 ANEXO.zip', 'PNCAV-SRT-DCO-0066-14', '0000-00-00', '', 4, 1),
(373, 1, 7, 45, 3, 1, '2014-07-10', 'PNCAV-SRT-DCO-0067-14', 'Entrega  informe Mensual N° 6 de Interventoria correspondiente al mes de Junio de 2014', 'PNCAV-SRT-DCO-0067-14.pdf', 86, '2014-07-21', 'PNCAV-SRT-DCO-0067-14 Anexo.zip', 'PNCAV-SRT-DCO-0067-14', '0000-00-00', NULL, 3, 1),
(374, 1, 4, 29, 4, 3, '2014-07-10', 'PNCAV-SRT-UTAR-0084-14', 'Alcance al comunicado PNCAV-SRT-UTAR-0077-14 Cuantificacion al plan de integracion.', 'PNCAV-UTAR-SRT-101-14.pdf', 89, '2014-07-17', NULL, 'PNCAV-UTAR-SRT-101-14', NULL, 'PNCAV-SRT-UTAR-0084-14.pdf', 2, 1),
(375, 1, 4, 27, 4, 3, '2014-07-10', NULL, 'Observaciones a las ordenes de pago 1 y 2 - sociedad colombiana de consultoria', 'PNCAV-UTAR-SRT-102-14.pdf', 89, '2014-07-17', NULL, 'PNCAV-UTAR-SRT-102-14', NULL, NULL, 1, 1),
(382, 1, 5, 34, 3, 4, '2014-07-11', NULL, 'Alcance comunicado PNCAV-SRT-UTAR-0073-14 Solicitud de informacion de cumplimiento de seguridad industrial y seguridad en el trabajo.', 'PNCAV-SRT-UTAR-0080-14.pdf', NULL, '0000-00-00', NULL, 'PNCAV-SRT-UTAR-0080-14', '0000-00-00', NULL, 1, 1),
(383, 1, 4, 27, 4, 3, '2014-07-14', NULL, 'Alcance comunicado PNCAV-UTAR-SRT-093-14 Observaciones del area juridica en referencia al entregable correspondiente a orden de pago N° 9', 'PNCAV-UTAR-SRT-103-14.pdf', 89, '2014-07-21', NULL, 'PNCAV-UTAR-SRT-103-14', NULL, NULL, 3, 1),
(384, 1, 4, 27, 4, 3, '2014-07-14', NULL, 'Remision orden de pago N° 4- Estudio de impacto y apropiacion', 'PNCAV-UTAR-SRT-104-14.pdf', 89, '2014-07-21', NULL, 'PNCAV-UTAR-SRT-104-14', NULL, NULL, 3, 1),
(385, 1, 5, 34, 4, 3, '2014-07-14', NULL, 'Alcance comunicado PNCAV-SRT-UTAR-0080-14 Solicitud de informacion de cumplimiento de seguridad industrial y seguridad en el trabajo.', 'PNCAV-UTAR-SRT-105-14.pdf', 69, NULL, NULL, 'PNCAV-UTAR-SRT-105-14', NULL, NULL, 1, 1),
(386, 1, 4, 27, 4, 3, '2014-07-14', NULL, 'Alcance comunicado PNCAV-UTAR-SRT-096-14 Observaciones del area Juridica en referencia al entregable correspondiente a orden de pago N° 10', 'PNCAV-UTAR-SRT-106-14.pdf', 89, '2014-07-21', NULL, 'PNCAV-UTAR-SRT-106-14', NULL, NULL, 3, 1),
(387, 1, 7, 45, 4, 3, '2014-07-14', NULL, 'Rta comunicado PNCAV-SRT-UTAR-0079-14 Ajustes informe mensual de seguimiento correspondiente al mes de abril de 2014.', 'PNCAV-UTAR-SRT-107-14.pdf', 75, '2014-07-21', 'I ABRIL.rar', 'PNCAV-UTAR-SRT-107-14', NULL, NULL, 3, 1),
(388, 1, 4, 22, 3, 4, '2014-07-14', NULL, 'Rta comunicado PNCAV-UTAR-SRT-0087-14 Observaciones a los estados financieros con corte 31 de diciembre de 2013 certificados y dictaminados', 'PNCAV-SRT-UTAR-0081-14.pdf', 87, '2014-07-21', NULL, 'PNCAV-SRT-UTAR-0081-14', NULL, NULL, 3, 1),
(389, 1, 7, 43, 3, 1, '2014-07-15', NULL, 'Cambio equipo de trabajo Interventoria.', 'PNCAV-SRT-DCO-0068-14.pdf', 86, '2014-07-22', 'PNCAV-SRT-DCO-0068-14 ANEXO.zip', 'PNCAV-SRT-DCO-0068-14', NULL, NULL, 3, 1),
(390, 1, 9, 67, 4, 3, '2014-07-15', NULL, 'Rta comunicado PNCAV-SRT-UTAR-0078-14 Estudios de campo-usuario y contraseña validacion estudios de campo', 'PNCAV-UTAR-SRT-108-14.pdf', 72, '0000-00-00', NULL, 'PNCAV-UTAR-SRT-108-14', '0000-00-00', NULL, 1, 1),
(391, 1, 4, 27, 4, 3, '2014-07-15', NULL, 'Remision Orden de pago N° 5- Estudio de impacto y apropiación', 'PNCAV-UTAR-SRT-109-14.pdf', 89, '2014-07-22', NULL, 'PNCAV-UTAR-SRT-109-14', NULL, NULL, 3, 1),
(392, 1, 4, 27, 4, 3, '2014-07-15', NULL, 'Alcance a comunicacion PNCAV-UTAR-SRT-099-14 Observaciones en referencia al entregable correspondiente a las ordenes de pago N° 1 y 2- Sociedad colombiana de consultoria', 'PNCAV-UTAR-SRT-110-14.pdf', 89, '2014-07-22', NULL, 'PNCAV-UTAR-SRT-110-14', NULL, NULL, 3, 1),
(393, 1, 8, 61, 3, 4, '2014-07-15', 'PNCAV-UTAR-SRT-115-14', 'Rta comunicado PNCAV-UTAR-SRT-078-14 Licencias y permisos ambientales', 'PNCAV-SRT-UTAR-0082-14.pdf', 87, '2014-07-22', NULL, 'PNCAV-SRT-UTAR-0082-14', NULL, 'PNCAV-UTAR-SRT-115-14.pdf', 2, 1),
(394, 1, 7, 45, 3, 4, '2014-07-15', NULL, 'Rta comunicado PNCAV-SRT-UTAR-051-14  Hallazgos identificados Unguia Choco- Informes mensuales', 'PNCAV-SRT-UTAR-0083-14.pdf', 87, '2014-07-17', NULL, 'PNCAV-SRT-UTAR-0083-14', NULL, NULL, 3, 1),
(395, 1, 4, 29, 3, 4, '2014-07-15', NULL, 'Rta comunicado PNCAV-UTAR-SRT-101-14 Plazo para la cuantificacion del plan de integracion suministros e instalacion', 'PNCAV-SRT-UTAR-0084-14.pdf', 87, '2014-07-25', NULL, 'PNCAV-SRT-UTAR-0084-14', '0000-00-00', NULL, 3, 1),
(396, 1, 4, 20, 3, 4, '2014-07-15', NULL, 'Alcance al comunicado PNCAV-FIDU-UTAR-033-14 Observaciones informe de Fiducia Junio de 2014', 'PNCAV-SRT-UTAR-0085-14.pdf', 87, '2014-07-22', NULL, 'PNCAV-SRT-UTAR-0085-14', NULL, NULL, 3, 1),
(397, 1, 8, 53, 4, 3, '2014-07-16', NULL, 'Remision contrato de Mandato', 'PNCAV-UTAR-SRT-111-14.pdf', 71, NULL, NULL, 'PNCAV-UTAR-SRT-111-14', NULL, NULL, 1, 1),
(398, 1, 9, 63, 4, 3, '2014-07-16', NULL, 'Rta comunicado PNCAV-SRT-UTAR-0076-14 Plan de transmision', 'PNCAV-UTAR-SRT-112-14.pdf', 72, '2014-07-23', NULL, 'PNCAV-UTAR-SRT-112-14', NULL, NULL, 3, 1),
(399, 1, 7, 45, 4, 3, '2014-07-16', NULL, 'Ajustes informe mensual de seguimiento del contratista, correspondiente al mes de Abril de 2014.', 'PNCAV-UTAR-SRT-113-14.pdf', 75, '2014-07-23', 'SOPORTES COMUNICACIÓN PNCAV-UTAR-SRT-113-14.rar', 'PNCAV-UTAR-SRT-113-14', NULL, NULL, 3, 1),
(400, 1, 7, 45, 1, 4, '2014-06-12', NULL, 'Aprobacion informes mensuales de seguimiento del Contratista UTANDIRED de Enero, Febrero y Marzo.', 'PNCAV-DIRCON-OPER-052-14.pdf', 75, NULL, NULL, 'PNCAV-DIRCON-OPER-052-14', NULL, NULL, 1, 1),
(401, 1, 7, 43, 1, 3, '2014-07-17', NULL, 'Certificación de cumplimiento del equipo de Trabajo', 'PNCAV-DIRCON-INTV-068-14.pdf', 75, '0000-00-00', NULL, 'PNCAV-DIRCON-INTV-068-14', '0000-00-00', NULL, 1, 1),
(402, 1, 4, 20, 3, 4, '2014-07-16', NULL, 'Alcance comunicado PNCAV-FIDU-UTAR-034-14 Observaciones informe de fiducia segundo trimestre de 2014', 'PNCAV-SRT-UTAR-0087-14.pdf', 87, '2014-07-23', NULL, 'PNCAV-SRT-UTAR-0087-14', NULL, NULL, 3, 1),
(404, 1, 4, 27, 3, 4, '2014-07-07', NULL, 'Observaciones Orden de pago N° 10 Diseño de red', 'Observaciones orden de pago N°  10.pdf', 87, '2014-07-09', 'Formato Consolidado de Observaciones Orden de Pago No  10.xlsx', 'Observaciones Orden de pago 10', NULL, NULL, 4, 1),
(405, 1, 4, 27, 3, 4, '2014-07-03', NULL, 'Observacion orden de pago N° 9 Diseño de red', 'Observaciones Orden de pago N° 9.pdf', 87, '2014-07-07', 'PNCAV-M23-F02 Formato Consolidado de Observaciones Orden de Pago No  9..xlsx', 'Observaciones Orden de pago 9', NULL, NULL, 4, 1),
(406, 1, 4, 27, 3, 4, '2014-07-02', NULL, 'Observaciones Orden de pago N° 8', 'Observaciones orden de pago N° 8.pdf', 87, '2014-07-04', 'Formato Consolidado de Observaciones Orden de Pago No  8.xlsx', 'Observaciones Orden de pago 8', NULL, NULL, 4, 1),
(407, 1, 7, 45, 3, 4, '2014-07-17', NULL, 'Rta comunicado PNCAV-UTAR-SRT-097-14 Observaciones a la segunda entrega del informe mensual de seguimiento N° 5 correspondiente a mayo de 2014 del contratista Union temporal Andired.', 'PNCAV-SRT-UTAR-0086-14.pdf', 87, '2014-07-24', 'Formato M23-F01 y F02.xlsx', 'PNCAV-SRT-UTAR-0086-14', NULL, NULL, 3, 1),
(408, 1, 7, 43, 1, 3, '2014-07-18', NULL, 'Rta comunicado PNCAV-SRT-DCO-0038-14 Aprobacion Equipo de trabajo Interventoria', 'PNCAV-DIRCON-INTV-050-14.pdf', 75, NULL, NULL, 'PNCAV-DIRCON-INTV-050-14', NULL, NULL, 1, 1),
(409, 1, 9, 82, 1, 4, '2014-07-18', NULL, 'Instituciones educativas no elegibles en el proyecto de KVD Fase 2 en el departamento de Vaupes', 'PNCAV-DIRCON-OPER-069-14.pdf', 72, NULL, NULL, 'PNCAV-DIRCON-OPER-069-14', NULL, NULL, 1, 1),
(410, 1, 8, 58, 1, 4, '2014-07-18', NULL, 'Remision comunicacion OFI14-000027050-DPC-2500 del Ministerio del interior', 'PNCAV-DIRCON-OPER-072-14.pdf', 71, NULL, NULL, 'PNCAV-DIRCON-OPER-072-14', NULL, NULL, 1, 1),
(411, 1, 4, 29, 1, 2, '2014-07-18', NULL, 'Remision de autorizacion para modificacion del contrato de Fiducia', 'PNCAV-DIRCON-FIDU-071-14.pdf', 89, NULL, NULL, 'PNCAV-DIRCON-FIDU-071-14', NULL, NULL, 1, 1),
(412, 1, 8, 61, 4, 3, '2014-07-18', NULL, 'Parafiscales Mes de Junio de 2014.', 'PNCAV-UTAR-SRT-114-14.pdf', 71, '2014-07-25', NULL, 'PNCAV-UTAR-SRT-114-14', '0000-00-00', NULL, 3, 1),
(413, 1, 8, 61, 4, 3, '2014-07-18', NULL, 'Rta comunicado PNCAV-SRT-UTAR-0082-14 Licencias y permisos ambientales', 'PNCAV-UTAR-SRT-115-14.pdf', 71, '2014-07-25', NULL, 'PNCAV-UTAR-SRT-115-14', NULL, NULL, 3, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_estado`
--

CREATE TABLE IF NOT EXISTS `documento_estado` (
  `doe_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado de los documentos',
  `doe_nombre` varchar(50) NOT NULL COMMENT 'Nombre del estado de los documentos',
  PRIMARY KEY (`doe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los estados de los documentos' AUTO_INCREMENT=5 ;

--
-- Volcado de datos para la tabla `documento_estado`
--

INSERT INTO `documento_estado` (`doe_id`, `doe_nombre`) VALUES
(1, 'No requiere'),
(2, 'Ya se respondió'),
(3, 'Está en términos'),
(4, 'No se respondió');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_subtema`
--

CREATE TABLE IF NOT EXISTS `documento_subtema` (
  `dos_id` int(3) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del subtema',
  `dot_id` int(2) NOT NULL DEFAULT '0' COMMENT 'Id del tema del documento',
  `dos_nombre` varchar(45) NOT NULL DEFAULT '' COMMENT 'Nombre del subtema',
  PRIMARY KEY (`dos_id`),
  KEY `FK_SUBTEMA1_documento_TEMA` (`dot_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los subtemas de documentos' AUTO_INCREMENT=84 ;

--
-- Volcado de datos para la tabla `documento_subtema`
--

INSERT INTO `documento_subtema` (`dos_id`, `dot_id`, `dos_nombre`) VALUES
(1, 1, 'Administrativa'),
(2, 1, 'Fianaciera'),
(3, 1, 'HSEQ'),
(4, 1, 'Jurídica'),
(5, 1, 'Social'),
(6, 1, 'Técnica'),
(7, 2, 'Comite directivo'),
(8, 2, 'Mesa de trabajo'),
(9, 2, 'Seguimiento al contratista'),
(10, 2, 'Seguimiento interventoria'),
(11, 2, 'Solicitudes'),
(12, 3, 'Comite directivo'),
(13, 3, 'Mesa de trabajo'),
(14, 3, 'Seguimiento al contratista'),
(15, 3, 'Seguimiento interventoria'),
(16, 3, 'Solicitudes'),
(17, 4, 'Desembolsos'),
(18, 4, 'Utilizaciones'),
(19, 4, 'Anticipo'),
(20, 4, 'Informe Fiduciario'),
(21, 4, 'Informe del Uso del Anticipo'),
(22, 4, 'Capacidad Financiera'),
(23, 4, 'Traslado de Rendimientos'),
(24, 4, 'Patrimonio Autónomo'),
(25, 4, 'Anticipo Interventoria'),
(26, 4, 'Traslado de Rendimientos Interventoria'),
(27, 4, 'Ordenes de Pago'),
(28, 4, 'Facturación Interventoría'),
(29, 4, 'Otros'),
(30, 5, 'Plan de Manejo Ambiental (PMA)'),
(31, 5, 'Permisos y Licencias Ambientales'),
(32, 5, 'Gestión de Riesgos'),
(33, 5, 'Plan de Calidad'),
(34, 5, 'Normatividad Legal HSEQ'),
(35, 5, 'Otros'),
(36, 6, 'Apropiación'),
(37, 6, 'Nivel de satisfacción al usuario'),
(38, 6, 'Línea base'),
(39, 6, 'Plan de Comunicaciones'),
(40, 6, 'Estrategia de capacitaciones.'),
(41, 6, 'Otros'),
(42, 7, 'Gestión documental'),
(43, 7, 'Equipo de trabajo Interventoria'),
(44, 7, 'Cronogramas'),
(45, 7, 'Informes mensuales'),
(46, 7, 'Red de transporte'),
(47, 7, 'Inventarios'),
(48, 7, 'logistico'),
(49, 7, 'Otros'),
(50, 8, 'Contrato de Aporte'),
(51, 8, 'Contrato Interventoría'),
(52, 8, 'Contrato de Fiducia'),
(53, 8, 'Contrato de Mandato'),
(54, 8, 'Terminación / Liquidación'),
(55, 8, 'Pólizas'),
(56, 8, 'Contratos con Proveedores'),
(57, 8, 'Contrato de Donación'),
(58, 8, 'Consultas Previas'),
(59, 8, 'Suspensiones'),
(60, 8, 'Convenios'),
(61, 8, 'Otros'),
(62, 9, 'Documento General de Planeación'),
(63, 9, 'Plan de Transmisión'),
(64, 9, 'Informe Detallado de Ingeniería, Logística y '),
(65, 9, 'Plan de Pruebas y Puesta en Servicio'),
(66, 9, 'Plan de Operación y Mantenimiento'),
(67, 9, 'Estudios de Campo'),
(68, 9, 'Instalaciones'),
(69, 9, 'Indicadores de Nivel de Servicio'),
(70, 9, 'Mantenimientos'),
(71, 9, 'Cambios'),
(72, 9, 'Traslados'),
(73, 9, 'Recibos Locativos'),
(74, 9, 'Visitas de Calidad'),
(75, 9, 'NOC'),
(76, 9, 'Sistema de Gestión y Monitoreo'),
(77, 9, 'Informes especiales'),
(78, 9, 'PQRs'),
(79, 9, 'Webservices'),
(80, 9, 'Sistemas de Información'),
(81, 3, 'Otros'),
(82, 9, 'Otros'),
(83, 2, 'Comite Fiduciario');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_tema`
--

CREATE TABLE IF NOT EXISTS `documento_tema` (
  `dot_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del tema',
  `dot_nombre` varchar(45) NOT NULL DEFAULT '' COMMENT 'Nombre del tema',
  `dti_id` int(2) NOT NULL DEFAULT '0' COMMENT 'Id del tipo',
  PRIMARY KEY (`dot_id`),
  KEY `FK_TEMA1_DOCUMENTO_TIPO` (`dti_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los temas de documentos' AUTO_INCREMENT=10 ;

--
-- Volcado de datos para la tabla `documento_tema`
--

INSERT INTO `documento_tema` (`dot_id`, `dot_nombre`, `dti_id`) VALUES
(1, 'Comunicados', 1),
(2, 'Actas', 1),
(3, 'Compromisos', 1),
(4, 'Financiero', 1),
(5, 'HSEQ', 1),
(6, 'Social', 1),
(7, 'Administrativo', 1),
(8, 'Jurídico', 1),
(9, 'Técnico', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_tipo`
--

CREATE TABLE IF NOT EXISTS `documento_tipo` (
  `dti_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del tipo',
  `dti_nombre` varchar(45) NOT NULL DEFAULT '' COMMENT 'Nombre del tipo de documento',
  `dti_estado` varchar(1) NOT NULL COMMENT 'Indica si el tipo de documento maneja estado (si o no)',
  `dti_responsable` varchar(1) NOT NULL COMMENT 'Indica si el tipo de documento maneja responsable (si o no)',
  PRIMARY KEY (`dti_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los tipos de documentos' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `documento_tipo`
--

INSERT INTO `documento_tipo` (`dti_id`, `dti_nombre`, `dti_estado`, `dti_responsable`) VALUES
(1, 'DOCUMENTAL', '1', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `documento_tipo_actor`
--

CREATE TABLE IF NOT EXISTS `documento_tipo_actor` (
  `dta_id` int(2) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del tipo de actor',
  `dta_nombre` varchar(50) NOT NULL COMMENT 'Nombre del tipo de actor',
  PRIMARY KEY (`dta_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los tipos de actores' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `documento_tipo_actor`
--

INSERT INTO `documento_tipo_actor` (`dta_id`, `dta_nombre`) VALUES
(1, 'Responsable');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `eje`
--

CREATE TABLE IF NOT EXISTS `eje` (
  `eje_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador unico del tipo de punto',
  `eje_nombre` varchar(45) NOT NULL COMMENT 'Corresponde al nombre del tipo de punto',
  `ins_id` int(11) NOT NULL COMMENT 'identificador unico del tipo de encuesta o encuestado',
  PRIMARY KEY (`eje_id`,`ins_id`),
  KEY `fk_Eje_Instrumento1_idx` (`ins_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Volcado de datos para la tabla `eje`
--

INSERT INTO `eje` (`eje_id`, `eje_nombre`, `ins_id`) VALUES
(1, 'PVD', 2),
(2, 'KVD', 2),
(3, 'IP', 2),
(4, 'WIFI', 1),
(5, 'BA', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta`
--

CREATE TABLE IF NOT EXISTS `encuesta` (
  `enc_id` int(11) NOT NULL AUTO_INCREMENT,
  `enc_consecutivo` int(11) NOT NULL,
  `pla_id` int(11) NOT NULL,
  `enc_documento_soporte` varchar(40) DEFAULT NULL,
  `enc_fecha` date DEFAULT NULL,
  `ecc_id` int(11) DEFAULT NULL COMMENT 'Puede tomar los valores de Correcto o Incorrecto',
  `enc_motivo_cuestionario_incorrecto` varchar(500) DEFAULT NULL,
  `erf_id` int(11) DEFAULT NULL COMMENT 'Puede tomar los valores de Valido o Anulado',
  `evi_id` int(11) DEFAULT NULL COMMENT 'Puede tomar los valores de No Inspeccionada, Inspección Telefónica o Inspección Personal.',
  `eri_id` int(11) DEFAULT NULL COMMENT 'Puede tomar los valores de Encuesta Correcta o Encuesta Incorrecta.',
  `enc_motivo_encuesta_incorrecta` varchar(500) DEFAULT NULL,
  `usu_id` int(11) DEFAULT NULL COMMENT 'Identificador del usuario',
  `ees_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`enc_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=578 ;

--
-- Volcado de datos para la tabla `encuesta`
--

INSERT INTO `encuesta` (`enc_id`, `enc_consecutivo`, `pla_id`, `enc_documento_soporte`, `enc_fecha`, `ecc_id`, `enc_motivo_cuestionario_incorrecto`, `erf_id`, `evi_id`, `eri_id`, `enc_motivo_encuesta_incorrecta`, `usu_id`, `ees_id`) VALUES
(1, 27006001, 1, 'Act4_PMO_German_Ramirez.pdf ', '2014-07-18', 1, NULL, 1, 1, 1, NULL, 80, 1),
(2, 27006002, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(3, 27006003, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(4, 27006004, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(5, 27006005, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(6, 27006006, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(7, 27006007, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(8, 27006008, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(9, 27006009, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(10, 27006010, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(11, 27006011, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(12, 27006012, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(13, 27006013, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(14, 27006014, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(15, 27006015, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(16, 27006016, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(17, 27006017, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(18, 27006018, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(19, 27006019, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(20, 27006020, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(21, 27006021, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(22, 27006022, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(23, 27006023, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(24, 27006024, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(25, 27006025, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(26, 27006026, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(27, 27006027, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(28, 27006028, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(29, 27006029, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(30, 27006030, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(31, 27025001, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(32, 27025002, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(33, 27025003, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(34, 27025004, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(35, 27025005, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(36, 27025006, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(37, 27025007, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(38, 27025008, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(39, 27025009, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(40, 27025010, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(41, 27025011, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(42, 27025012, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(43, 27025013, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(44, 27025014, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(45, 27025015, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(46, 27025016, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(47, 27025017, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(48, 27025018, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(49, 27025019, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(50, 27025020, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(51, 27025021, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(52, 27025022, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(53, 27025023, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(54, 27025024, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(55, 27025025, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(56, 27025026, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(57, 27025027, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(58, 27025028, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(59, 27025029, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(60, 27025030, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(61, 27025031, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(62, 27025032, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(63, 27025033, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(64, 27025034, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(65, 27025035, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(66, 27025036, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(67, 27025037, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(68, 27025038, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(69, 27025039, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(70, 27025040, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(71, 27025041, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(72, 27025042, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(73, 27025043, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(74, 27025044, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(75, 27025045, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(76, 27025046, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(77, 27025047, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(78, 27025048, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(79, 27025049, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(80, 27025050, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(81, 27025051, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(82, 27025052, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(83, 27025053, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(84, 27025054, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(85, 27025055, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(86, 27025056, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(87, 27025057, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(88, 27025058, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(89, 27025059, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(90, 27025060, 2, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(91, 27075001, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(92, 27075002, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(93, 27075003, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(94, 27075004, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(95, 27075005, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(96, 27075006, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(97, 27075007, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(98, 27075008, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(99, 27075009, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(100, 27075010, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(101, 27075011, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(102, 27075012, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(103, 27075013, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(104, 27075014, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(105, 27075015, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(106, 27075016, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(107, 27075017, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(108, 27075018, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(109, 27075019, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(110, 27075020, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(111, 27075021, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(112, 27075022, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(113, 27075023, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(114, 27075024, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(115, 27075025, 3, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(116, 27077001, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(117, 27077002, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(118, 27077003, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(119, 27077004, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(120, 27077005, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(121, 27077006, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(122, 27077007, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(123, 27077008, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(124, 27077009, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(125, 27077010, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(126, 27077011, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(127, 27077012, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(128, 27077013, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(129, 27077014, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(130, 27077015, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(131, 27077016, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(132, 27077017, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(133, 27077018, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(134, 27077019, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(135, 27077020, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(136, 27077021, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(137, 27077022, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(138, 27077023, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(139, 27077024, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(140, 27077025, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(141, 27077026, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(142, 27077027, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(143, 27077028, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(144, 27077029, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(145, 27077030, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(146, 27077031, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(147, 27077032, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(148, 27077033, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(149, 27077034, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(150, 27077035, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(151, 27077036, 4, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(152, 27099001, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(153, 27099002, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(154, 27099003, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(155, 27099004, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(156, 27099005, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(157, 27099006, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(158, 27099007, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(159, 27099008, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(160, 27099009, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(161, 27099010, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(162, 27099011, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(163, 27099012, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(164, 27099013, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(165, 27099014, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(166, 27099015, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(167, 27099016, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(168, 27099017, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(169, 27099018, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(170, 27099019, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(171, 27099020, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(172, 27099021, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(173, 27099022, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(174, 27099023, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(175, 27250001, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(176, 27250002, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(177, 27250003, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(178, 27250004, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(179, 27250005, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(180, 27250006, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(181, 27250007, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(182, 27250008, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(183, 27250009, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(184, 27250010, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(185, 27250011, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(186, 27250012, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(187, 27250013, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(188, 27250014, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(189, 27250015, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(190, 27250016, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(191, 27250017, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(192, 27250018, 6, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(193, 27372001, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(194, 27372002, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(195, 27372003, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(196, 27372004, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(197, 27372005, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(198, 27372006, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(199, 27372007, 7, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(200, 27425001, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(201, 27425002, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(202, 27425003, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(203, 27425004, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(204, 27425005, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(205, 27425006, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(206, 27425007, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(207, 27425008, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(208, 27425009, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(209, 27425010, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(210, 27425011, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(211, 27425012, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(212, 27425013, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(213, 27425014, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(214, 27425015, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(215, 27425016, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(216, 27425017, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(217, 27425018, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(218, 27425019, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(219, 27425020, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(220, 27425021, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(221, 27425022, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(222, 27425023, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(223, 27425024, 8, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(224, 27495001, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(225, 27495002, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(226, 27495003, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(227, 27495004, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(228, 27495005, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(229, 27495006, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(230, 27495007, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(231, 27495008, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(232, 27495009, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(233, 27495010, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(234, 27495011, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(235, 27495012, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(236, 27495013, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(237, 27495014, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(238, 27495015, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(239, 27495016, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(240, 27495017, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(241, 27495018, 9, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(242, 27745001, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(243, 27745002, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(244, 27745003, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(245, 27745004, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(246, 27745005, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(247, 27745006, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(248, 27745007, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(249, 27745008, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(250, 27745009, 10, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(251, 27800001, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(252, 27800002, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(253, 27800003, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(254, 27800004, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(255, 27800005, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(256, 27800006, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(257, 27800007, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(258, 27800008, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(259, 27800009, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(260, 27800010, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(261, 27800011, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(262, 27800012, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(263, 27800013, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(264, 27800014, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(265, 27800015, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(266, 27800016, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(267, 27800017, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(268, 27800018, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(269, 27800019, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(270, 27800020, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(271, 27800021, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(272, 27800022, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(273, 27800023, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(274, 27800024, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(275, 27800025, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(276, 27800026, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(277, 27800027, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(278, 27800028, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(279, 27800029, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(280, 27800030, 11, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(281, 5873001, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(282, 5873002, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(283, 5873003, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(284, 5873004, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(285, 5873005, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(286, 5873006, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(287, 5873007, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(288, 5873008, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(289, 5873009, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(290, 5873010, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(291, 5873011, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(292, 5873012, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(293, 5873013, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(294, 5873014, 12, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(295, 27006031, 13, 'Act4_PMO_German_Ramirez.pdf ', '2014-07-01', 1, NULL, 2, 2, 1, NULL, 77, 1),
(296, 27006032, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(297, 27006033, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(298, 27006034, 13, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(299, 27025061, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(300, 27025062, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(301, 27025063, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(302, 27025064, 14, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(303, 27075026, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(304, 27075027, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(305, 27075028, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(306, 27075029, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(307, 27075030, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(308, 27075031, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(309, 27075032, 15, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(310, 27077037, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(311, 27077038, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(312, 27077039, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(313, 27077040, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(314, 27077041, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(315, 27077042, 16, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(316, 27099024, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(317, 27099025, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(318, 27099026, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(319, 27099027, 17, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(320, 27250019, 18, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(321, 27372008, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(322, 27372009, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(323, 27372010, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(324, 27372011, 19, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(325, 27425025, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(326, 27425026, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(327, 27425027, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(328, 27425028, 20, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(329, 27495019, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(330, 27495020, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(331, 27495021, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(332, 27495022, 21, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(333, 27745010, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(334, 27745011, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(335, 27745012, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(336, 27745013, 22, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(337, 27800031, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(338, 27800032, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(339, 27800033, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(340, 27800034, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(341, 27800035, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(342, 27800036, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(343, 27800037, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(344, 27800038, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(345, 27800039, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(346, 27800040, 23, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(347, 5873015, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(348, 5873016, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(349, 5873017, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(350, 5873018, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(351, 5873019, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(352, 5873020, 24, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(353, 27006035, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(354, 27006036, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(355, 27006037, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(356, 27006038, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(357, 27006039, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(358, 27006040, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(359, 27006041, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(360, 27006042, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(361, 27006043, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(362, 27006044, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(363, 27006045, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(364, 27006046, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(365, 27006047, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(366, 27006048, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(367, 27006049, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(368, 27006050, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(369, 27025065, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(370, 27025066, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(371, 27025067, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(372, 27025068, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(373, 27025069, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(374, 27025070, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(375, 27025071, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(376, 27025072, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(377, 27025073, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(378, 27025074, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(379, 27025075, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(380, 27025076, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(381, 27025077, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(382, 27025078, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(383, 27025079, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(384, 27025080, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(385, 27025081, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(386, 27025082, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(387, 27025083, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(388, 27025084, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(389, 27025085, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(390, 27025086, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(391, 27025087, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(392, 27025088, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(393, 27025089, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(394, 27025090, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(395, 27025091, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(396, 27025092, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(397, 27025093, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(398, 27025094, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(399, 27025095, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(400, 27025096, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(401, 27025097, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(402, 27025098, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(403, 27025099, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(404, 27025100, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(405, 27025101, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(406, 27025102, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(407, 27025103, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(408, 27025104, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(409, 27025105, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(410, 27025106, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(411, 27025107, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(412, 27025108, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(413, 27025109, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(414, 27025110, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(415, 27025111, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(416, 27025112, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(417, 27025113, 26, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(418, 27075033, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(419, 27075034, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(420, 27075035, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(421, 27075036, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(422, 27075037, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(423, 27075038, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(424, 27075039, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(425, 27075040, 27, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(426, 27077043, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(427, 27077044, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(428, 27077045, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(429, 27077046, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(430, 27077047, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(431, 27077048, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(432, 27077049, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(433, 27077050, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(434, 27077051, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(435, 27077052, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(436, 27077053, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(437, 27077054, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(438, 27077055, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(439, 27077056, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(440, 27077057, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(441, 27077058, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(442, 27077059, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(443, 27077060, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(444, 27077061, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(445, 27077062, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(446, 27077063, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(447, 27077064, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(448, 27077065, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(449, 27077066, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(450, 27077067, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(451, 27077068, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(452, 27077069, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(453, 27077070, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(454, 27077071, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(455, 27077072, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(456, 27077073, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(457, 27077074, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(458, 27077075, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(459, 27077076, 28, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(460, 27099028, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(461, 27099029, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(462, 27099030, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(463, 27099031, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(464, 27099032, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(465, 27099033, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(466, 27099034, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(467, 27099035, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(468, 27099036, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(469, 27099037, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(470, 27099038, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(471, 27099039, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(472, 27099040, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(473, 27099041, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(474, 27099042, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(475, 27099043, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(476, 27099044, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(477, 27099045, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(478, 27099046, 29, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(479, 27250020, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(480, 27250021, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(481, 27250022, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(482, 27250023, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(483, 27250024, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(484, 27250025, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(485, 27250026, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(486, 27250027, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(487, 27250028, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(488, 27250029, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(489, 27250030, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(490, 27250031, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(491, 27250032, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(492, 27250033, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(493, 27250034, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(494, 27250035, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(495, 27250036, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(496, 27250037, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(497, 27250038, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(498, 27250039, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(499, 27250040, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(500, 27250041, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(501, 27250042, 30, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(502, 27372012, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(503, 27372013, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(504, 27372014, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(505, 27372015, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(506, 27372016, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(507, 27372017, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(508, 27372018, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(509, 27372019, 31, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(510, 27425029, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(511, 27425030, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(512, 27425031, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(513, 27425032, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(514, 27425033, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(515, 27425034, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(516, 27425035, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(517, 27425036, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(518, 27425037, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(519, 27425038, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(520, 27425039, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(521, 27425040, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(522, 27425041, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(523, 27425042, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(524, 27425043, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(525, 27425044, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(526, 27425045, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(527, 27425046, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(528, 27425047, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(529, 27425048, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(530, 27425049, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(531, 27425050, 32, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(532, 27495023, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(533, 27495024, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(534, 27495025, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(535, 27495026, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(536, 27495027, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(537, 27495028, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(538, 27495029, 33, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(539, 27745014, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(540, 27745015, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(541, 27745016, 34, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(542, 27800041, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(543, 27800042, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(544, 27800043, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(545, 27800044, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(546, 27800045, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(547, 27800046, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(548, 27800047, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(549, 27800048, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(550, 27800049, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(551, 27800050, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(552, 27800051, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(553, 27800052, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(554, 27800053, 35, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(555, 5873021, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(556, 5873022, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(557, 5873023, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(558, 5873024, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(559, 5873025, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(560, 5873026, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(561, 5873027, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(562, 5873028, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(563, 5873029, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(564, 5873030, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(565, 5873031, 36, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(566, 27006051, 37, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(567, 27025114, 38, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(568, 27075041, 39, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(569, 27077077, 40, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(570, 27099047, 41, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(571, 27250043, 42, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(572, 27372020, 43, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(573, 27425051, 44, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(574, 27495030, 45, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(575, 27745017, 46, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(576, 27800054, 47, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2),
(577, 5873032, 48, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta_cuestionario_completo`
--

CREATE TABLE IF NOT EXISTS `encuesta_cuestionario_completo` (
  `ecc_id` int(11) NOT NULL COMMENT 'identificador del cuestionario completo',
  `ecc_nombre` varchar(40) NOT NULL COMMENT 'Puede tomar los valores de Correcto o Incorrecto. ',
  PRIMARY KEY (`ecc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encuesta_cuestionario_completo`
--

INSERT INTO `encuesta_cuestionario_completo` (`ecc_id`, `ecc_nombre`) VALUES
(1, 'Correcto'),
(2, 'Incorrecto');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta_estado`
--

CREATE TABLE IF NOT EXISTS `encuesta_estado` (
  `ees_id` int(11) NOT NULL,
  `ees_nombre` varchar(45) NOT NULL,
  PRIMARY KEY (`ees_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encuesta_estado`
--

INSERT INTO `encuesta_estado` (`ees_id`, `ees_nombre`) VALUES
(1, 'Completo'),
(2, 'En terminos'),
(3, 'Vencido');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta_resultado_final`
--

CREATE TABLE IF NOT EXISTS `encuesta_resultado_final` (
  `erf_id` int(11) NOT NULL COMMENT 'Identificador del resultado final de la encuesta',
  `erf_nombre` varchar(40) NOT NULL COMMENT 'Puede tomar los valores de Valido o Anulado. ',
  PRIMARY KEY (`erf_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encuesta_resultado_final`
--

INSERT INTO `encuesta_resultado_final` (`erf_id`, `erf_nombre`) VALUES
(1, 'Valido'),
(2, 'Anulado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta_resultado_inspeccion`
--

CREATE TABLE IF NOT EXISTS `encuesta_resultado_inspeccion` (
  `eri_id` int(11) NOT NULL COMMENT 'Identificador de resultado de inspeccion',
  `eri_nombre` varchar(40) NOT NULL COMMENT 'Puede tomar los valores de Encuesta Correcta o Encuesta Incorrecta',
  PRIMARY KEY (`eri_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encuesta_resultado_inspeccion`
--

INSERT INTO `encuesta_resultado_inspeccion` (`eri_id`, `eri_nombre`) VALUES
(1, 'Encuesta Correcta'),
(2, 'Encuesta Incorrecta');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `encuesta_validar_inspeccion`
--

CREATE TABLE IF NOT EXISTS `encuesta_validar_inspeccion` (
  `evi_id` int(11) NOT NULL COMMENT 'identificador de validar inspeccion',
  `evi_nombre` varchar(40) NOT NULL COMMENT 'Puede tomar los valores de No Inspeccionada, Inspección Telefónica o Inspección Personal',
  PRIMARY KEY (`evi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `encuesta_validar_inspeccion`
--

INSERT INTO `encuesta_validar_inspeccion` (`evi_id`, `evi_nombre`) VALUES
(1, 'No inspeccionado'),
(2, 'Inspección telefónica'),
(3, 'Inspección Personal');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `extracto_financiero`
--

CREATE TABLE IF NOT EXISTS `extracto_financiero` (
  `efi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id único del extracto',
  `cfi_id` int(11) NOT NULL COMMENT 'id de la cuenta a la que pertenece el extracto',
  `efi_mes` int(2) NOT NULL COMMENT 'mes del extracto',
  `efi_anio` int(4) NOT NULL COMMENT 'año del extracto',
  `efi_saldo_inicial` double NOT NULL COMMENT 'saldo inicial del extracto',
  `efi_incrementos` double NOT NULL COMMENT 'incrementos del extracto según fiduciara',
  `efi_disminuciones` double NOT NULL COMMENT 'disminuciones del extracto según fiduciara',
  `efi_saldo_final` double NOT NULL COMMENT 'saldo final del extracto',
  `efi_rentabilidad` float NOT NULL COMMENT 'rentabilidad calculada para el extracto',
  `efi_observaciones` text NOT NULL COMMENT 'observaciones realizadas al extracto',
  `efi_documento_soporte` varchar(256) NOT NULL COMMENT 'archivo de soporte del extracto',
  `efi_documento_movimientos` varchar(256) NOT NULL COMMENT 'hoja de calculo con los movimientos asociados al extracto',
  PRIMARY KEY (`efi_id`),
  KEY `fk_extracto_cuenta` (`cfi_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tabla de extractos financieros' AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `extracto_financiero_int`
--

CREATE TABLE IF NOT EXISTS `extracto_financiero_int` (
  `efi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id único del extracto',
  `cfi_id` int(11) NOT NULL COMMENT 'id de la cuenta a la que pertenece el extracto',
  `efi_mes` int(2) NOT NULL COMMENT 'mes del extracto',
  `efi_anio` int(4) NOT NULL COMMENT 'año del extracto',
  `efi_saldo_inicial` double NOT NULL COMMENT 'saldo inicial del extracto',
  `efi_incrementos` double NOT NULL COMMENT 'incrementos del extracto según fiduciara',
  `efi_disminuciones` double NOT NULL COMMENT 'disminuciones del extracto según fiduciara',
  `efi_saldo_final` double NOT NULL COMMENT 'saldo final del extracto',
  `efi_rentabilidad` float NOT NULL COMMENT 'rentabilidad calculada para el extracto',
  `efi_observaciones` text NOT NULL COMMENT 'observaciones realizadas al extracto',
  `efi_documento_soporte` varchar(256) NOT NULL COMMENT 'archivo de soporte del extracto',
  `efi_documento_movimientos` varchar(256) NOT NULL COMMENT 'hoja de calculo con los movimientos asociados al extracto',
  PRIMARY KEY (`efi_id`),
  KEY `fk_extracto_cuenta` (`cfi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `familias`
--

CREATE TABLE IF NOT EXISTS `familias` (
  `Id_Familia` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion_Familia` varchar(40) NOT NULL,
  PRIMARY KEY (`Id_Familia`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `informe_financiero`
--

CREATE TABLE IF NOT EXISTS `informe_financiero` (
  `ifi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador unico e incrementarl de informe',
  `ifi_numero_factura` varchar(15) NOT NULL COMMENT 'Numero identificador unico de la factura a ingresar.',
  `ifi_fecha_factura` date NOT NULL COMMENT 'Fecha registrada en la factura.',
  `ifi_numero_radicado_ministerio` varchar(15) NOT NULL COMMENT 'Número asignado en un radicado por el ministerio.',
  `ifi_documento_soporte` varchar(40) NOT NULL COMMENT 'Comunicado, documento digital que soporta la factura.',
  `ifi_descripcion` varchar(200) NOT NULL COMMENT 'Una pequeña descripcion de la factura',
  `ifi_valor_factura` int(15) NOT NULL COMMENT 'Valor o costo total que aparece en la factura.',
  `ifi_amortizacion` int(15) NOT NULL,
  `ifi_saldo_pendiente_AA` int(15) NOT NULL COMMENT 'Es la suma de todas las actividades menos la amortizacion',
  `ifi_observaciones` varchar(200) DEFAULT NULL COMMENT 'Observaciones sobre la factura',
  `ifi_saldo_contrato` int(15) NOT NULL COMMENT 'Es el resultado del Saldo del contrato menos el valor de la factura',
  PRIMARY KEY (`ifi_id`),
  UNIQUE KEY `ifi_numero_factura` (`ifi_numero_factura`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ingresos`
--

CREATE TABLE IF NOT EXISTS `ingresos` (
  `Id_Ingreso` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Este campo corresponde al identificador de los ingresos y sera su llave primaria',
  `A_Ingreso` year(4) NOT NULL COMMENT 'Este campo indica el año en que el ingreso fue recibido',
  `Monto_Ingreso` bigint(20) NOT NULL COMMENT 'Corresponde al monto de ingreso registrado',
  `Tipo_Ingreso` varchar(8) NOT NULL COMMENT 'Este campo indica el tipo de ingreso, las opciones son vigencia y adicion',
  PRIMARY KEY (`Id_Ingreso`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento`
--

CREATE TABLE IF NOT EXISTS `instrumento` (
  `ins_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del instrumento de encuesta',
  `ins_nombre` varchar(30) NOT NULL COMMENT 'nombre del instrumento de encuesta',
  `iti_id` int(11) NOT NULL COMMENT 'id del tipo de instrumento',
  PRIMARY KEY (`ins_id`),
  KEY `FK_TIPO` (`iti_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='instrumentos de encuentas' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `instrumento`
--

INSERT INTO `instrumento` (`ins_id`, `ins_nombre`, `iti_id`) VALUES
(1, 'individuo', 1),
(2, 'organización', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento_pregunta`
--

CREATE TABLE IF NOT EXISTS `instrumento_pregunta` (
  `ipr_id` int(11) NOT NULL AUTO_INCREMENT,
  `ipr_nombre` varchar(5) NOT NULL,
  `ipr_texto` varchar(400) NOT NULL,
  `ipt_id` int(11) NOT NULL,
  `ise_id` int(11) NOT NULL,
  `ipr_padre` int(11) NOT NULL,
  `ipr_hijos` int(11) NOT NULL,
  `ipr_orden` int(11) NOT NULL,
  `ipr_descripcion` varchar(150) NOT NULL COMMENT 'texto explicativo de la pregunta',
  PRIMARY KEY (`ipr_id`),
  KEY `ipt_id` (`ipt_id`,`ise_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=285 ;

--
-- Volcado de datos para la tabla `instrumento_pregunta`
--

INSERT INTO `instrumento_pregunta` (`ipr_id`, `ipr_nombre`, `ipr_texto`, `ipt_id`, `ise_id`, `ipr_padre`, `ipr_hijos`, `ipr_orden`, `ipr_descripcion`) VALUES
(1, '1', 'No. Cuestionario', 4, 1, 0, 0, 1, ''),
(2, '2', 'Fecha de la entrevista', 7, 1, 0, 0, 2, ''),
(3, '3', 'Región', 4, 2, 0, 0, 3, ''),
(4, '4', 'Departamento', 4, 2, 0, 0, 4, ''),
(5, '5', 'Municipio o ANM', 4, 2, 0, 0, 5, ''),
(6, '6', 'Barrio o Corregimiento', 4, 2, 0, 0, 6, ''),
(7, '7', 'Zona', 2, 2, 0, 0, 7, ''),
(8, '8', 'Nombre del encuestado', 4, 3, 0, 0, 8, ''),
(9, '9', 'Edad', 5, 3, 0, 0, 9, ''),
(10, '10', 'Genero', 2, 3, 0, 0, 10, ''),
(11, '11', '¿Cuántas personas conforman el hogar?', 5, 3, 0, 0, 11, ''),
(12, '12', 'Composición del Hogar', 2, 3, 0, 0, 12, 'Con niño/as menores de edad'),
(13, '13', 'Indique el estrato al que pertenece', 5, 3, 0, 0, 13, ''),
(14, 'P1.', '¿Su hogar cuenta con?', 6, 4, 0, 1, 14, ''),
(15, '', 'Televisor', 2, 4, 14, 0, 15, ''),
(16, '', 'Linea Telefónica Fija', 2, 4, 14, 0, 16, ''),
(17, 'P2', '¿Tiene usted o algún miembro de este hogar un teléfono celular móvil?', 2, 4, 0, 0, 17, ''),
(18, 'P3', '¿En su hogar hay un computador?', 2, 4, 0, 0, 18, ''),
(19, 'P4', '¿En los últimos 12 meses ha usado un computador?', 2, 4, 0, 0, 19, ''),
(20, 'P5', '¿Su hogar cuenta con servicio a internet?', 2, 4, 0, 0, 20, ''),
(21, 'P6', '¿Podrías decirme si has usado Internet (Cualquier uso "www, e-mail,chat,etc.")?', 2, 4, 0, 0, 21, ''),
(22, 'P7', '¿A través de qué equipo accede habitualmente a Internet?', 3, 4, 0, 0, 22, ''),
(23, 'P8', '¿Está interesado/a en conocer que es un computador y para que sirve?', 2, 4, 0, 0, 23, ''),
(24, 'P9', '¿Podría decirme, dónde usó Internet en los últimos 12 meses?', 6, 4, 0, 1, 24, 'Máximo 3, siendo 1 el más importante y 3 el menos relevante.'),
(25, '', 'En tu casa', 5, 4, 24, 0, 25, ''),
(26, '', 'En casa de otra persona', 5, 4, 24, 0, 26, ''),
(27, '', 'En el trabajo', 5, 4, 24, 0, 27, ''),
(28, '', 'En un establecimiento educativo (colegio, universidad, biblioteca, etc.)', 5, 4, 24, 0, 28, ''),
(29, '', 'En un establecimiento comunitario', 5, 4, 24, 0, 29, ''),
(30, '', 'En Café Internet', 5, 4, 24, 0, 30, ''),
(31, '', 'No ha usado Internet en los últimos 12 meses', 5, 4, 24, 0, 31, ''),
(32, '', 'Desde cualquier sitios con mi portátil/tableta/teléfono móvil', 5, 4, 24, 0, 32, ''),
(33, 'P10', '¿Para cuál de las siguientes actividades usó Internet en los últimos 12 meses?', 6, 4, 0, 1, 33, 'Máximo 3, siendo 1 el más importante y 3 el menos relevante.'),
(34, '', 'Realizar gestiones bancarias', 5, 4, 33, 0, 34, ''),
(35, '', 'Comprar algún producto o servicios', 5, 4, 33, 0, 35, ''),
(36, '', 'Para formación y/o capacitación/ Búsqueda de información', 5, 4, 33, 0, 36, ''),
(37, '', 'Para consultas académicas', 5, 4, 33, 0, 37, ''),
(38, '', 'Obtención de información sobre Gobierno en Línea', 5, 4, 33, 0, 38, ''),
(39, '', 'Descarga de música, video, películas, juegos, software', 5, 4, 33, 0, 39, ''),
(40, '', 'Envío y recepción de correos electrónicos', 5, 4, 33, 0, 40, ''),
(41, '', 'Redes sociales (facebook, twitter, tuenti...)', 5, 4, 33, 0, 41, ''),
(42, '', 'Llamadas telefónicas a través del Protocolo de Internet', 5, 4, 33, 0, 42, ''),
(43, '', 'Buscar empleo', 5, 4, 33, 0, 43, ''),
(44, '', 'Navegar por Internet sin objetivo concreto', 5, 4, 33, 0, 44, ''),
(45, '', 'Organizaciones gubernamentales', 5, 4, 33, 0, 45, ''),
(46, '', 'Otro ¿Cuál?', 4, 4, 33, 0, 46, ''),
(47, 'P11', '¿Con que frecuencia usas Internet?', 2, 4, 0, 0, 47, ''),
(48, 'P12', '¿La calidad del servicio actual de Internet es ?', 2, 4, 0, 0, 48, ''),
(49, 'P13', '¿Qué tipo de servicio de acceso a Internet usa para conectarse en casa?', 2, 5, 0, 0, 49, ''),
(50, 'P14', '¿Está interesado/a en conocer qué es la Internet y como se usa? ', 2, 5, 0, 0, 50, ''),
(51, 'P15', 'Y ¿Su interés es por qué?', 6, 5, 0, 1, 51, 'Máximo 3, siendo 1 el más importante y 3 el menos relevante.'),
(52, '', 'Escuchó hablar sobre Internet', 5, 5, 51, 0, 52, ''),
(53, '', 'Porque los amigos/as lo usan', 5, 5, 51, 0, 53, ''),
(54, '', 'Por entretenimiento', 5, 5, 51, 0, 54, ''),
(55, '', 'Para comunicarse', 5, 5, 51, 0, 55, ''),
(56, '', 'Para estar informado', 5, 5, 51, 0, 56, ''),
(57, '', 'Por planes de negocios', 5, 5, 51, 0, 57, ''),
(58, '', 'Otro uso, ¿Cuál?', 4, 5, 51, 0, 58, ''),
(59, 'P16', '¿Cuál es la razón principal por la que no lo usa? ', 6, 5, 0, 1, 59, 'Máximo 3, siendo 1 el más importante y 3 el menos relevante.'),
(60, '', 'No te gusta', 5, 5, 59, 0, 60, ''),
(61, '', 'No sabes utilizarlo', 5, 5, 59, 0, 61, ''),
(62, '', 'No tienes fácil acceso', 5, 5, 59, 0, 62, ''),
(63, '', 'No tienes computador', 5, 5, 59, 0, 63, ''),
(64, '', 'Es un servicio caro', 5, 5, 59, 0, 64, ''),
(65, '', 'Se pierde mucho tiempo', 5, 5, 59, 0, 65, ''),
(66, 'P17', '¿Por qué cree que no está interesado en conocer la Internet?', 6, 5, 0, 1, 66, 'Máximo 3, siendo 1 el más importante y 3 el menos relevante.'),
(67, '', 'Su uso es complejo', 5, 5, 66, 0, 67, ''),
(68, '', 'Hay que viajar a otro lugar para conocerlo', 5, 5, 66, 0, 68, ''),
(69, '', 'No le han explicado lo que es', 5, 5, 66, 0, 69, ''),
(70, '', 'La gente pierde su identidad y sus valores tradicionales', 5, 5, 66, 0, 70, ''),
(71, '', 'Se pierde los valores familiares', 5, 5, 66, 0, 71, ''),
(72, 'P18', '¿ Considera que con el uso de la Internet se puede?', 6, 5, 0, 1, 72, 'Máximo 3, siendo 1 el más importante y 3 el menos relevante.'),
(73, '', 'Acceder a mucha información y contenidos variados', 5, 5, 72, 0, 73, ''),
(74, '', 'Tener una buena fuente educativa', 5, 5, 72, 0, 74, ''),
(75, '', 'Generar interés y motivación', 5, 5, 72, 0, 75, ''),
(76, '', 'Generar contacto con las nuevas tecnologías', 5, 5, 72, 0, 76, ''),
(77, '', 'Conectar con el mundo', 5, 5, 72, 0, 77, ''),
(78, '', 'Hacer fácilmente nuevas amistades', 5, 5, 72, 0, 78, ''),
(79, '', 'Relacionar más con familia y amigos', 5, 5, 72, 0, 79, ''),
(80, '', 'Facilitar las actividades cotidianas', 5, 5, 72, 0, 80, ''),
(81, 'P19', 'Y ¿Considera que es necesario recibir capacitación sobre el manejo de la Internet y sus aplicaciones?', 2, 5, 0, 0, 81, ''),
(82, 'P20', '¿Tiene conocimiento si en el Municipio o Corregimiento, se han adelantado programas en temas relacionados TIC?', 2, 5, 0, 0, 82, ''),
(83, 'P21', ' ¿Podría indicar cuál es su nivel máximo de escolaridad alcanzado?', 2, 6, 0, 0, 83, ''),
(84, 'P22', '¿Podría decirme cuál es su situación laboral?', 2, 6, 0, 0, 84, ''),
(85, 'P23', '¿Cuál es su ocupación actual?', 2, 6, 0, 0, 85, ''),
(86, 'P24', '¿Usted y su familia pertenece algunos de los siguientes grupos étnicos?', 6, 6, 0, 1, 86, ''),
(87, '', 'Grupos Indígenas', 1, 6, 86, 1, 87, ''),
(88, '', '¿Cuál grupo?', 4, 6, 87, 0, 88, ''),
(89, '', '¿Dialecto que habla?', 4, 6, 87, 0, 89, ''),
(90, '', 'Grupos Afrocolombiano', 1, 6, 86, 1, 90, ''),
(91, '', '¿Cuál grupo?', 4, 6, 90, 0, 91, ''),
(92, '', '¿Dialecto que habla?', 4, 6, 90, 0, 92, ''),
(93, '', 'ROM', 1, 6, 86, 0, 93, ''),
(94, '', 'Mestizo', 1, 6, 86, 0, 94, ''),
(95, '', 'Raizales y Palenqueros', 1, 6, 86, 0, 95, ''),
(96, '', 'Otro, ¿cuál?', 4, 6, 86, 0, 96, ''),
(97, '', 'No Sabe', 1, 6, 86, 0, 97, ''),
(98, '', 'No Contesta', 1, 6, 86, 0, 98, ''),
(99, 'P25', '¿El acceso a electricidad de la vivienda es por medio? ', 6, 6, 0, 1, 99, ''),
(100, '', 'Sistema eléctrico', 1, 6, 99, 0, 100, ''),
(101, '', 'Planta eléctrica', 1, 6, 99, 0, 101, ''),
(102, '', 'Celda Solar', 1, 6, 99, 0, 102, ''),
(103, '', 'Bioenergía', 1, 6, 99, 0, 103, ''),
(104, '', 'Ninguno / No existe', 1, 6, 99, 0, 104, ''),
(105, '', 'Otro uso, ¿Cuál?', 4, 6, 99, 0, 105, ''),
(106, 'P26', '¿Cuáles son las problemáticas sociales más comunes en la zona?', 6, 6, 0, 1, 106, 'Máximo 3, siendo 1 el más importante y 3 el menos relevante.'),
(107, '', 'Delincuencia común', 5, 6, 106, 0, 107, ''),
(108, '', 'Desempleo', 5, 6, 106, 0, 108, ''),
(109, '', 'Desplazamiento forzado', 5, 6, 106, 0, 109, ''),
(110, '', 'Embarazo en adolescentes', 5, 6, 106, 0, 110, ''),
(111, '', 'Falta de oportunidades Educativas', 5, 6, 106, 0, 111, ''),
(112, '', 'Problemas de orden público', 5, 6, 106, 0, 112, ''),
(113, '', 'Alto costo de vida', 5, 6, 106, 0, 113, ''),
(114, 'P27', '¿Su ingreso mensual es?', 2, 6, 0, 0, 114, ''),
(115, 'P28', '¿Cuánto de su salario lo utiliza para servicio de Internet? ', 2, 6, 0, 0, 115, ''),
(116, 'P29', '¿Estaría dispuesto a pagar por un mejor servicio de Internet? ', 2, 6, 0, 0, 116, ''),
(117, 'P30', '¿Cuánto pagaría por el servicio de Internet? ', 2, 6, 0, 0, 117, ''),
(118, 'P31', '¿Le importaría darme su número de teléfono?', 6, 7, 0, 1, 118, '(ENTREVISTADOR/A: EXPLICAR QUE ES PARA QUE SERTIC PUEDA HACER UNA POSIBLE COMPROBACIÓN TELEFONICA DE QUE LA ENTREVISTA HA SIDO REALIZADA)'),
(119, '', 'Tiene teléfono y da número', 1, 7, 118, 1, 119, ''),
(120, '', 'Número', 5, 7, 119, 0, 120, ''),
(121, '', 'No tiene teléfono', 1, 7, 118, 0, 121, ''),
(122, '', 'Tiene teléfono y no da número', 1, 7, 118, 0, 122, ''),
(123, '', 'No Contesta', 1, 7, 118, 0, 123, ''),
(124, 'P32', '¿Día de la semana que se realiza la encuesta?', 2, 7, 0, 0, 124, ''),
(125, 'P33', '¿Hora de la realización de la encuesta?', 2, 7, 0, 0, 125, ''),
(126, 'P34', '¿Cómo definirías tu manejo del español?', 6, 7, 0, 1, 126, 'APLICA PARA LAS PERSONAS QUE HABLAN OTRO IDIOMA O LENGUA'),
(127, 'P34a', '(A RELLENAR POR EL/LA ENCUESTADOR/A)', 6, 7, 126, 1, 127, 'Independientemente de lo que haya contestado esta persona en cuanto a la pertenencia de un grupo étnico. ¿cómo definiría su manejo del español?'),
(128, 'P34b', 'Encuestado/a', 2, 7, 127, 0, 128, ''),
(129, 'P34c', 'Encuestador/a', 2, 7, 127, 0, 129, ''),
(130, 'P35', 'DILIGENCIAR POR EL/LA ENCUESTADOR/A.', 6, 8, 0, 1, 130, ''),
(131, 'P35a', 'De acuerdo con la encuesta, valore', 6, 8, 130, 1, 131, ''),
(132, '', 'Se ha realizado la encuesta en presencia de terceras personas', 2, 8, 131, 0, 132, ''),
(133, '', '(La persona encuestada) ha expresado su deseo de abandonar la encuesta', 2, 8, 131, 0, 133, ''),
(134, '', '(La persona encuestada)  se ha sentido incomoda o molesta por los temas de la encuesta', 2, 8, 131, 0, 134, ''),
(135, '', '(La persona encuestada) ha  tenido prisa por acabar la encuesta', 2, 8, 131, 0, 135, ''),
(136, 'P36', '¿Han intervenido activamente terceras personas en el desarrollo de la encuesta?', 2, 8, 0, 0, 136, ''),
(137, 'P37', '¿Ha habido alguna pregunta concreta que provocara incomodidad? ', 2, 8, 0, 0, 137, ' '),
(138, '', 'Anotar el/los numero/s de', 4, 8, 137, 0, 138, ''),
(139, 'P38', '¿Ha habido alguna pregunta concreta que la persona encuestada tuviera dificultades en comprender o que tuviera que ser explicada?', 2, 8, 0, 1, 139, ' '),
(140, '', 'Anotar el/los numero/s de', 4, 8, 141, 0, 140, ''),
(141, 'P39', 'Desarrollo de la encuesta', 2, 8, 0, 1, 141, ''),
(142, '', 'Número de orden de la encuesta', 1, 9, 0, 0, 142, ''),
(143, '', 'Dificultad de acceso al Municipio o Corregimiento', 1, 9, 0, 0, 143, ''),
(144, '', 'Dificultad de acceso a Corregimiento o Vereda', 1, 9, 0, 0, 144, ''),
(145, '', 'Dificultad de acceso a la vivienda ', 1, 9, 0, 0, 145, ''),
(146, '', ' Viviendas en las que no hay nadie ', 1, 9, 0, 0, 146, ''),
(147, '', 'Viviendas en las que se niegan a recibir ninguna explicación', 1, 9, 0, 0, 147, ''),
(148, '', 'Negativas de hombre a realizar la entrevista', 1, 9, 0, 0, 148, ''),
(149, '', 'Negativas de mujeres a realizar la entrevista', 1, 9, 0, 0, 149, ''),
(150, '', 'Contacto fallido por no ser una vivienda (oficina, consultorios)', 1, 9, 0, 0, 150, ''),
(151, '', 'Vivienda de grupos étnicos que no hablan el idioma español', 1, 9, 0, 0, 151, ''),
(152, '', 'La persona de contacto no estaba en la vivienda', 1, 9, 0, 0, 152, ''),
(153, '', 'Ninguna', 1, 9, 0, 0, 153, ''),
(154, 'E1', 'Duración de la entrevista en minutos', 5, 10, 0, 0, 154, ''),
(155, 'E2', 'Observaciones', 4, 11, 0, 0, 155, ''),
(159, '1', 'No. Cuestionario', 4, 13, 0, 0, 1, ''),
(160, '2', 'Fecha de la entrevista', 7, 13, 0, 0, 2, ''),
(161, '3', 'Región', 4, 14, 0, 0, 3, ''),
(162, '4', 'Departamento', 4, 14, 0, 0, 4, ''),
(163, '5', 'Municipio o ANM', 4, 14, 0, 0, 5, ''),
(164, '6', 'Barrio o Vereda', 4, 14, 0, 0, 6, ''),
(165, '7', 'Zona', 2, 14, 0, 0, 7, ''),
(166, '8', 'Nombre de la institución', 4, 15, 0, 0, 8, ''),
(167, '9', 'Nombre del encuestado', 4, 15, 0, 0, 9, ''),
(168, '10', 'Cargo que ocupa dentro de la Organización', 4, 15, 0, 0, 10, ''),
(169, '11', 'No. de Documento', 4, 15, 0, 0, 11, ''),
(170, '12', 'Edad', 5, 15, 0, 0, 12, ''),
(171, '13', 'Genero', 2, 15, 0, 0, 13, ''),
(172, 'P1', 'Tipo de Organización:', 2, 16, 0, 1, 14, ''),
(173, 'P1a', 'Establecimiento', 2, 16, 172, 0, 15, ''),
(174, 'P1b', 'Unidad Productiva', 1, 16, 172, 0, 16, ''),
(175, 'P1c', 'Instituciones Regionales', 1, 16, 172, 0, 17, ''),
(176, 'P2', 'Nivel de clasificación de la Institución Educativa', 3, 17, 0, 0, 18, 'Puede tener más de una respuesta'),
(177, 'P3', '¿Cuántos alumnos hay en la institución?', 5, 17, 0, 0, 19, ''),
(178, 'P4', '¿La institución cuenta con computador(es) para uso de los estudiantes?', 2, 17, 0, 0, 20, ''),
(179, 'P5', '¿Cuántos computadores son por alumnos?', 5, 17, 0, 0, 21, ''),
(180, 'P6', 'Característica de la Institución de Salud', 2, 18, 0, 0, 22, ''),
(181, 'P7', 'Nivel de Atención', 2, 18, 0, 0, 23, ''),
(182, 'P8', 'Estructura del Establecimiento de Seguridad ', 2, 19, 0, 0, 24, ''),
(183, 'P9', 'Sector de la Unidad Productiva', 2, 20, 0, 0, 25, ''),
(184, 'P10', 'Tamaño de la organización', 2, 20, 0, 0, 26, '(En términos de personas empleadas)'),
(185, 'P11', 'Tipo de institución regional', 2, 21, 0, 0, 27, ''),
(186, 'P12', '¿La organización cuenta con servicio telefónico fijo de su propiedad?\r\n', 2, 22, 0, 0, 28, ''),
(187, 'P13', '¿Cuántos funcionarios hay en la institución?', 5, 22, 0, 0, 29, ''),
(188, 'P14', '¿La institución cuenta con computador(es)?', 2, 22, 0, 0, 30, ''),
(189, 'P15', ' ¿Para cuál de las siguientes actividades usó el computador el establecimiento?', 6, 22, 0, 1, 31, ''),
(190, '', 'Microsoft Office (Word, Excel, PowerPoint)', 1, 22, 189, 0, 32, ''),
(191, '', 'Editor de Imágene', 1, 22, 189, 0, 33, ''),
(192, '', 'Capacitación', 1, 22, 189, 0, 34, ''),
(193, '', 'Otro uso, ¿Cuál? ', 4, 22, 189, 0, 35, ''),
(194, 'P16', '¿Cuantos computadores tiene la institución?', 5, 22, 0, 0, 36, ''),
(195, 'P17', '¿La institución reemplaza los equipos de cómputo?', 2, 22, 0, 0, 37, ''),
(196, 'P18', '¿Con que frecuencia reemplazan los equipos de cómputo?', 6, 22, 0, 1, 38, ''),
(197, '', 'Valor en meses', 5, 22, 196, 0, 39, ''),
(198, '', 'No Sabe', 1, 22, 196, 0, 40, ''),
(199, '', 'No Contesta', 1, 22, 196, 0, 41, ''),
(200, 'P19', '¿En la Institución hay acceso a Internet?\r\n', 2, 22, 0, 0, 42, ''),
(201, 'P20', '¿A través de qué equipo (s) accede habitualmente a Internet? ', 2, 22, 0, 0, 43, ''),
(202, 'P21', 'Para cual de las siguientes actividades utilizó Internet la institución?', 6, 22, 0, 1, 44, 'Máximo 3, siendo 1 el más importante y 3 el menos relevante.'),
(203, '', 'Envío o recepción de correo electrónico\r\n', 5, 22, 202, 0, 45, ''),
(204, '', 'Llamadas telefónicas a través del Protocolo de Internet', 5, 22, 202, 0, 46, ''),
(205, '', 'Publicación de información o de mensajes instantáneos', 5, 22, 202, 0, 47, ''),
(206, '', 'Transacción bancaria', 5, 22, 202, 0, 48, ''),
(207, '', '', 6, 22, 202, 0, 49, ''),
(208, '', 'Historias clínicas electrónicas', 5, 22, 202, 0, 50, ''),
(209, '', 'Obtención de información sobre bienes o servicios', 5, 22, 202, 0, 51, ''),
(210, '', 'Obtención de información sobre Gobierno en Línea', 5, 22, 202, 0, 52, ''),
(211, '', 'Obtención de información sobre organizaciones gubernamentales en general', 5, 22, 202, 0, 53, ''),
(212, '', 'Capacitación del personal', 5, 22, 202, 0, 54, ''),
(213, '', 'Servicio al cliente', 5, 22, 202, 0, 55, ''),
(214, '', 'Recepción de quejas y reclamos\r\n', 5, 22, 202, 0, 56, ''),
(215, '', 'Citas por Internet', 5, 22, 202, 0, 57, ''),
(216, 'P22', '¿Qué tipo de servicio de acceso a Internet usa para conectarse en la Organización?', 2, 22, 0, 0, 58, ''),
(217, 'P23', '¿La calidad del servicio actual de internet es?', 2, 22, 0, 0, 59, ''),
(218, 'P24', '¿Cuál es la razón por la que no tiene acceso a Internet la institución?', 6, 22, 0, 1, 60, 'Máximo 3, siendo 1 el más importante y 3 el menos relevante.'),
(219, '', 'No tienes fácil acceso', 5, 22, 218, 0, 61, ''),
(220, '', 'Es un servicio caro', 5, 22, 218, 0, 62, ''),
(221, '', 'Su uso es complejo', 5, 22, 218, 0, 63, ''),
(222, '', 'No sabe utilizarlo', 5, 22, 218, 0, 64, ''),
(223, '', 'No tienes computador', 5, 22, 218, 0, 65, ''),
(224, '', 'No le interesa', 5, 22, 218, 0, 66, ''),
(225, 'P25', '¿La institución está interesada en tener Internet?', 2, 22, 0, 0, 67, ''),
(226, 'P26', '¿Los funcionarios de la Institución han recibido capacitación en TIC en los últimos 12 meses?', 2, 22, 0, 0, 68, ''),
(227, 'P27', '¿La Institución tiene programas de capacitación en TIC?\r\n', 2, 22, 0, 0, 69, ''),
(228, 'P28', ' Indique las tres (3) poblaciones más relevantes a  las cuales \nla Institución brinda atención, siendo 1 la más importante y 3 la menos relevante.', 6, 23, 0, 1, 70, ''),
(229, '', 'En situación de discapacidad', 5, 23, 228, 0, 71, ''),
(230, '', 'En situación de desplazamiento', 5, 23, 228, 0, 72, ''),
(231, '', 'Habitantes de calle', 5, 23, 228, 0, 73, ''),
(232, '', 'Privados de la libertad\r\n', 5, 23, 228, 0, 74, ''),
(233, '', 'Ejercicio de la prostitución', 5, 23, 228, 0, 75, ''),
(234, '', 'Sectores LGBTI\r\n', 5, 23, 228, 0, 76, ''),
(235, '', 'Grupo Étnico', 5, 23, 228, 0, 77, ''),
(236, '', 'Otro ¿Cuál?', 4, 23, 228, 0, 78, ''),
(237, 'P29', '¿El acceso a electricidad de la institución es por medio?', 6, 23, 0, 1, 79, ''),
(238, '', 'Sistema eléctrico público', 1, 23, 237, 0, 80, ''),
(239, '', 'Planta eléctrica propia', 1, 23, 237, 0, 81, ''),
(240, '', 'Celda Solar', 1, 23, 237, 0, 82, ''),
(241, '', 'Bioenergía\r\n', 1, 23, 237, 0, 83, ''),
(242, '', 'Ninguno / No existe', 1, 23, 237, 0, 84, ''),
(243, '', 'Otro uso, ¿Cuál?', 4, 23, 237, 0, 85, ''),
(244, 'P30', '¿Le importaría darme su número de teléfono? ', 6, 24, 0, 1, 86, '(ENTREVISTADOR/A: EXPLICAR QUE ES PARA QUE SERTIC PUEDA HACER UNA\r\nPOSIBLE COMPROBACIÓN TELEFONICA DE QUE LA ENTREVISTA HA SIDO REALIZADA)'),
(245, '', 'Tiene teléfono y da número', 1, 24, 244, 0, 87, ''),
(246, '', 'Número:', 5, 24, 244, 0, 88, ''),
(247, '', 'No tiene teléfono', 1, 24, 244, 0, 89, ''),
(248, '', 'Tiene teléfono y no da número', 1, 24, 244, 0, 90, ''),
(249, '', 'No Contesta', 1, 24, 244, 0, 91, ''),
(250, 'P31', '¿Día de la semana que se realiza la encuesta?', 2, 24, 0, 0, 92, ''),
(251, 'P32', '¿Hora de la realización de la encuesta?', 2, 24, 0, 0, 93, ''),
(252, 'P33', '¿Cómo definirías tu manejo del español?', 6, 24, 0, 1, 94, 'APLICA PARA LAS PERSONAS QUE HABLAN\r\nOTRO IDIOMA  O LENGUA'),
(253, 'P33a', '(A RELLENAR POR EL/LA ENCUESTADOR/A)\r\n', 6, 24, 252, 1, 95, 'Independientemente de lo que haya contestado esta persona en cuanto a la pertenencia de un grupo étnico. ¿cómo definiría su manejo del español?'),
(254, 'P33b', 'Encuestado/a', 2, 24, 253, 0, 96, ''),
(255, 'P33c', 'Encuestador/a', 2, 24, 253, 0, 97, ''),
(256, 'P34', 'DILIGENCIAR POR EL/LA ENCUESTADOR/A. ', 6, 25, 0, 1, 98, ''),
(257, 'P34a', 'De acuerdo con la encuesta, valore', 6, 25, 256, 1, 99, ''),
(258, '', 'Se ha realizado la encuesta en presencia de terceras personas', 2, 25, 257, 0, 100, ''),
(259, '', '(La persona encuestada) ha expresado su deseo de abandonar la encuesta ', 2, 25, 257, 0, 101, ''),
(260, '', ' (La persona encuestada)  se ha sentido incomoda o molesta por los temas de la encuesta', 2, 25, 257, 0, 102, ''),
(261, '', '(La persona encuestada) ha  tenido prisa por acabar la encuesta', 2, 25, 257, 0, 103, ''),
(262, 'P35', '¿Han intervenido activamente terceras personas en el desarrollo de la\r\nencuesta?', 2, 25, 0, 0, 104, ''),
(263, 'P36', ' ¿Ha habido alguna pregunta concreta que provocara incomodidad?', 2, 25, 0, 0, 105, ''),
(264, '', 'Anotar el/los numero/s de', 4, 25, 263, 0, 106, ''),
(265, 'P37', '¿Ha habido alguna pregunta concreta que la persona encuestada tuviera dificultades en comprender o que tuviera que ser explicada?', 2, 25, 0, 0, 107, ''),
(266, '', 'Anotar el/los numero/s de', 4, 25, 265, 0, 108, ''),
(267, 'P38', 'Desarrollo de la encuesta', 2, 25, 0, 0, 109, ''),
(268, '', 'Número de orden de la encuesta', 1, 26, 0, 0, 110, ''),
(269, '', 'Dificultad de acceso al Municipio o Corregimiento', 1, 26, 0, 0, 111, ''),
(270, '', 'Dificultad de acceso a Corregimiento o Vereda', 1, 26, 0, 0, 112, ''),
(271, '', 'Dificultad de acceso a la vivienda', 1, 26, 0, 0, 113, ''),
(272, '', 'Viviendas en las que no hay nadie', 1, 26, 0, 0, 114, ''),
(273, '', 'Viviendas en las que se niegan a recibir ninguna explicación', 1, 26, 0, 0, 115, ''),
(274, '', 'Negativas de hombre a realizar la entrevista', 1, 26, 0, 0, 116, ''),
(275, '', 'Negativas de mujeres a realizar la entrevista ', 1, 26, 0, 0, 117, ''),
(276, '', '2Contacto fallido por no ser una vivienda (oficina, consultorios', 1, 26, 0, 0, 118, ''),
(277, '', 'Vivienda de grupos étnicos que no hablan el idioma español', 1, 26, 0, 0, 119, ''),
(278, '', 'La persona de contacto no estaba en la vivienda', 1, 26, 0, 0, 120, ''),
(279, '', 'Ninguna', 1, 26, 0, 0, 121, ''),
(280, 'E1', 'Duración de la entrevista en minutos:', 5, 27, 0, 0, 122, ''),
(281, 'E2', 'Observaciones', 4, 28, 0, 0, 123, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento_pregunta_opcion`
--

CREATE TABLE IF NOT EXISTS `instrumento_pregunta_opcion` (
  `ipo_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la opcion',
  `ipr_id` int(11) NOT NULL COMMENT 'id de la pregunta',
  `ipo_valor` int(11) NOT NULL COMMENT 'valor asociado a la opción',
  `ipo_texto` varchar(150) NOT NULL COMMENT 'texto de la opción',
  PRIMARY KEY (`ipo_id`),
  KEY `ipr_id` (`ipr_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=329 ;

--
-- Volcado de datos para la tabla `instrumento_pregunta_opcion`
--

INSERT INTO `instrumento_pregunta_opcion` (`ipo_id`, `ipr_id`, `ipo_valor`, `ipo_texto`) VALUES
(1, 7, 1, 'Cabecera'),
(2, 7, 2, 'Centro'),
(3, 7, 3, 'Rural disperso'),
(4, 10, 1, 'Femenino'),
(5, 10, 2, 'Masculino'),
(6, 12, 1, 'Si'),
(7, 12, 2, 'No'),
(8, 15, 1, 'Si'),
(9, 15, 2, 'No'),
(10, 16, 1, 'Si'),
(11, 16, 2, 'No'),
(12, 17, 1, 'Si'),
(13, 17, 2, 'No'),
(14, 18, 1, 'Si'),
(15, 18, 2, 'No'),
(16, 18, 3, 'No sabe lo que es'),
(17, 18, 99, 'No contesta'),
(18, 19, 1, 'Si'),
(19, 19, 2, 'No'),
(20, 19, 99, 'No contesta'),
(21, 20, 1, 'Si'),
(22, 20, 2, 'No'),
(23, 20, 99, 'No contesta'),
(24, 21, 1, 'Si'),
(25, 21, 2, 'No'),
(26, 21, 3, 'No sabe lo que es'),
(27, 21, 99, 'No contesta'),
(28, 22, 1, 'Portátil'),
(29, 22, 2, 'De escritorio'),
(30, 22, 3, 'Tableta/Teléfono móvil'),
(31, 22, 99, 'No contesta'),
(32, 23, 1, 'Si'),
(33, 23, 2, 'No'),
(34, 23, 99, 'No contesta'),
(35, 47, 0, 'Varias veces al día'),
(36, 47, 0, 'Una vez al día'),
(37, 47, 0, 'De una o dos veces a la'),
(38, 47, 0, 'De tres o más veces por semana'),
(39, 47, 0, 'Cada semana'),
(40, 47, 0, 'Varias veces al mes'),
(41, 47, 0, 'Casi Nunca'),
(42, 47, 0, 'Nunca'),
(43, 48, 0, 'Excelente'),
(44, 48, 0, 'Bueno'),
(45, 48, 0, 'Regular'),
(46, 48, 0, 'Malo'),
(47, 48, 0, 'Muy malo'),
(48, 49, 1, 'Banda Angosta'),
(49, 49, 2, 'Banda Ancha Fija'),
(50, 49, 3, 'Banda Ancha Móvil'),
(51, 49, 98, 'No sabe'),
(52, 49, 99, 'No contesta'),
(53, 50, 1, 'Si'),
(54, 50, 2, 'No'),
(55, 50, 99, 'No contesta'),
(56, 81, 1, 'Si'),
(57, 81, 2, 'No'),
(58, 81, 99, 'No contesta'),
(59, 82, 1, 'Si'),
(60, 82, 2, 'No'),
(61, 82, 99, 'No contesta'),
(62, 83, 1, 'Primaria'),
(63, 83, 2, 'Secundaria'),
(64, 83, 3, 'Técnica'),
(65, 83, 4, 'Tecnológica'),
(66, 83, 5, 'Universidad'),
(67, 83, 6, 'Ninguna'),
(68, 83, 99, 'No contesta'),
(69, 84, 1, 'Empleado'),
(70, 84, 2, 'Desempleado'),
(71, 84, 3, 'Trabajador Independiente'),
(72, 84, 4, 'Trabajador Informal'),
(73, 84, 99, 'No contesta'),
(74, 85, 1, 'Fuerza Pública'),
(75, 85, 2, 'Profesionales universitarios'),
(76, 85, 3, 'Técnicos, tecnólogos y asistentes'),
(77, 85, 4, 'Empleados de oficina'),
(78, 85, 5, 'Agricultores, ganaderos, forestales y pesqueros'),
(79, 85, 6, 'Empresarios'),
(80, 85, 7, 'Comerciantes, operarios, artesanos y trabajadores de la industria manufactureras, de la construcción y la minería'),
(81, 85, 8, 'Trabajadores no calificados'),
(82, 85, 9, 'Pensionado'),
(83, 85, 10, 'Estudiante'),
(84, 85, 11, 'Gestor TIC'),
(85, 85, 12, 'Labores de Hogar/Ama de Casa'),
(86, 85, 13, 'Miembro de Junta de Acción Comunal'),
(87, 85, 14, 'Miembro de organismo de socorro (bomberos, defensa civil, otros)'),
(88, 85, 15, 'Empleado domestico'),
(89, 85, 16, 'Reciclador'),
(90, 85, 99, 'No contesta'),
(91, 114, 1, 'Menos de 200.000'),
(92, 114, 2, 'De 200.001 a 400.000'),
(93, 114, 3, 'De 400.001 a 700.000'),
(94, 114, 4, 'De 700.001 a 1.000.000'),
(95, 114, 5, 'Más de 1.000.000'),
(96, 115, 1, 'Cero'),
(97, 115, 2, 'Menos de 10.000'),
(98, 115, 3, 'De 10.001 a 20.000'),
(99, 115, 4, 'De 20.001 a 40.000'),
(100, 115, 5, 'Más de 40.000'),
(101, 116, 1, 'Si'),
(102, 116, 2, 'No'),
(103, 116, 99, 'No contesta'),
(104, 117, 1, 'Menos de 10.000'),
(105, 117, 2, 'De 10.001 a 20.000'),
(106, 117, 3, 'De 20.001 a 40.000'),
(107, 117, 4, 'Más de 40.000'),
(108, 124, 0, 'Lunes'),
(109, 124, 0, 'Martes'),
(110, 124, 0, 'Miércoles'),
(111, 124, 0, 'Jueves'),
(112, 124, 0, 'Viernes'),
(113, 124, 0, 'Sábado'),
(114, 124, 0, 'Domingo'),
(115, 124, 0, 'Cualquier día'),
(116, 125, 0, 'La mañana (8-12)'),
(117, 125, 0, 'Medio día (1-2)'),
(118, 125, 0, 'Tarde (2-6)'),
(119, 125, 0, 'Noche (6-8)'),
(120, 128, 1, 'No lo habla en absoluto'),
(121, 128, 2, 'Lo habla muy poco'),
(122, 128, 3, 'Lo habla más o menos bien'),
(123, 128, 4, 'Lo habla con fluidez'),
(124, 128, 5, 'Es su idioma materno'),
(125, 128, 98, 'No Sabe'),
(126, 128, 99, 'No Contesta'),
(127, 129, 1, 'No lo habla en absoluto'),
(128, 129, 2, 'Lo habla muy poco'),
(129, 129, 3, 'Lo habla más o menos bien'),
(130, 129, 4, 'Lo habla con fluidez'),
(131, 129, 5, 'Es su idioma materno'),
(132, 129, 98, 'No Sabe'),
(133, 129, 99, 'No Contesta'),
(134, 132, 1, 'Si'),
(135, 132, 2, 'No'),
(136, 133, 1, 'Si'),
(137, 133, 2, 'No'),
(138, 134, 1, 'Si'),
(139, 134, 2, 'No'),
(140, 135, 1, 'Si'),
(141, 135, 2, 'No'),
(142, 136, 1, 'Si'),
(143, 136, 2, 'No'),
(144, 141, 1, 'Muy buena'),
(145, 141, 2, 'Buena'),
(146, 141, 3, 'Regular'),
(147, 141, 4, 'Mala'),
(148, 141, 5, 'Muy mala'),
(149, 142, 1, 'Si'),
(150, 142, 2, 'No'),
(151, 143, 1, 'Si'),
(152, 143, 2, 'No'),
(153, 144, 1, 'Si'),
(154, 144, 2, 'No'),
(155, 145, 1, 'Si'),
(156, 145, 2, 'No'),
(157, 146, 1, 'Si'),
(158, 146, 2, 'No'),
(159, 147, 1, 'Si'),
(160, 147, 2, 'No'),
(161, 148, 1, 'Si'),
(162, 148, 2, 'No'),
(163, 149, 1, 'Si'),
(164, 149, 2, 'No'),
(165, 150, 1, 'Si'),
(166, 150, 2, 'No'),
(167, 151, 1, 'Si'),
(168, 151, 2, 'No'),
(169, 152, 1, 'Si'),
(170, 152, 2, 'No'),
(181, 165, 1, 'Cabecera'),
(182, 165, 2, 'Centro'),
(183, 165, 3, 'Rural disperso'),
(184, 171, 1, 'Femenino'),
(185, 171, 2, 'Masculino'),
(186, 172, 1, 'Público'),
(187, 172, 2, 'Privado'),
(188, 172, 3, 'Social'),
(189, 172, 4, 'Instituciones Regionales'),
(190, 173, 0, 'Educación\r\n'),
(191, 173, 0, 'Salud'),
(192, 173, 0, 'Seguridad (Fuerzas Militares y Policía Nacional)'),
(193, 173, 0, 'Biblioteca\r\n'),
(194, 173, 0, 'Juzgados'),
(195, 173, 0, 'Alcaldía'),
(196, 176, 1, 'Básica Primaria'),
(197, 176, 2, 'Básica Secundaria'),
(198, 176, 3, 'Media'),
(199, 176, 4, 'Superior'),
(200, 178, 1, 'Si'),
(201, 178, 2, 'No'),
(202, 178, 98, 'No Sabe'),
(203, 180, 1, 'Hospital'),
(204, 180, 2, 'Clínica'),
(205, 180, 3, 'Centro de Salud '),
(206, 180, 4, 'Puesto de Salud '),
(207, 181, 1, 'Nivel I'),
(208, 181, 2, 'Nivel II'),
(209, 181, 3, 'Nivel III'),
(210, 182, 1, 'Ejercito'),
(211, 182, 2, 'Armada'),
(212, 182, 3, 'Fuerza Aérea'),
(213, 182, 4, 'Policía Nacional'),
(214, 183, 1, 'Primario (Agricultura, ganadería, pesca, minería, producción energética)'),
(215, 183, 2, 'Secundario (Industria, construcción, manufactura)'),
(216, 183, 3, 'Terciario (Comercio, bancos, educación, cultura, servicios)'),
(217, 184, 1, '1-9 personas '),
(218, 184, 2, '10-49 personas'),
(219, 184, 3, '50-249 personas'),
(220, 184, 4, '250 ó más personas'),
(221, 185, 1, 'Parques Naturales Nacionales - PNN'),
(222, 185, 2, 'Resguardo Indígena'),
(223, 186, 1, 'Si'),
(224, 186, 2, 'No'),
(225, 186, 3, 'No Sabe'),
(226, 186, 4, 'No contesta'),
(227, 188, 1, 'Si'),
(228, 188, 2, 'No'),
(229, 188, 98, 'No Sabe'),
(230, 188, 99, 'No contesta'),
(231, 195, 1, 'Si'),
(232, 195, 2, 'No'),
(233, 195, 98, 'No Sabe'),
(234, 200, 1, 'Si'),
(235, 200, 2, 'No'),
(236, 200, 98, 'No Sabe'),
(237, 200, 99, 'No contesta'),
(238, 201, 1, 'Portátil'),
(239, 201, 2, 'De escritorio\r\n'),
(240, 201, 3, 'Tableta'),
(241, 201, 99, 'No Contesta'),
(242, 216, 1, 'Banda Angosta '),
(243, 216, 2, 'Banda Ancha Fija'),
(244, 216, 3, 'Banda Ancha Móvil'),
(245, 216, 98, 'No Sabe'),
(246, 216, 99, 'No Contesta'),
(247, 217, 0, 'Excelente'),
(248, 217, 0, 'Bueno'),
(249, 217, 0, 'Regular'),
(250, 217, 0, 'Malo'),
(251, 217, 0, 'Muy Malo'),
(252, 225, 1, 'Si'),
(253, 225, 2, 'No'),
(254, 225, 98, 'No Sabe'),
(255, 225, 99, 'No contesta'),
(256, 226, 1, 'Si'),
(257, 226, 2, 'No'),
(258, 226, 98, 'No Sabe'),
(259, 226, 99, 'No contesta'),
(260, 227, 1, 'Si'),
(261, 227, 2, 'No'),
(262, 227, 98, 'No Sabe'),
(263, 227, 99, 'No contesta'),
(264, 250, 0, 'Lunes'),
(265, 250, 0, 'Martes'),
(266, 250, 0, 'Miércoles'),
(267, 250, 0, 'Jueves'),
(268, 250, 0, 'Viernes'),
(269, 250, 0, 'Sábado'),
(270, 250, 0, 'Domingo'),
(271, 250, 0, 'Cualquier día'),
(277, 251, 0, 'La mañana (8-12) '),
(278, 251, 0, 'Medio día (1-2) '),
(279, 251, 0, 'Tarde (2-6) '),
(280, 251, 0, 'Noche (6-8) '),
(281, 254, 1, 'No lo habla en absoluto\r\n'),
(282, 254, 2, 'Lo habla muy poco\r\n'),
(283, 254, 3, 'Lo habla  más o menos bien\r\n'),
(284, 254, 4, 'Lo habla con fluidez\r\n'),
(285, 254, 5, 'Es su idioma materno\r\n'),
(286, 254, 98, 'No Sabe'),
(287, 254, 99, 'No Contesta'),
(288, 255, 1, 'No lo habla en absoluto\r\n'),
(289, 255, 2, 'Lo habla muy poco\r\n'),
(290, 255, 3, 'Lo habla  más o menos bien\r\n'),
(291, 255, 4, 'Lo habla con fluidez\r\n'),
(292, 255, 5, 'Es su idioma materno\r\n'),
(293, 255, 98, 'No Sabe'),
(294, 254, 99, 'No Contesta'),
(295, 258, 0, 'Si'),
(296, 258, 0, 'No'),
(297, 259, 0, 'Si'),
(298, 259, 0, 'No'),
(299, 260, 0, 'Si'),
(300, 260, 0, 'No'),
(301, 261, 0, 'Si'),
(302, 261, 0, 'No'),
(303, 262, 0, 'Si'),
(304, 262, 0, 'No'),
(305, 267, 1, 'Muy Buena'),
(306, 267, 2, 'Buena'),
(307, 267, 3, 'Regular'),
(308, 267, 4, 'Mala'),
(309, 267, 5, 'Muy mala'),
(320, 117, 0, 'Cero'),
(321, 137, 1, 'Si'),
(322, 137, 2, 'No'),
(323, 139, 1, 'Si'),
(324, 139, 2, 'No'),
(325, 263, 1, 'Si'),
(326, 263, 2, 'No'),
(327, 265, 1, 'Si'),
(328, 265, 2, 'No');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento_pregunta_tipo`
--

CREATE TABLE IF NOT EXISTS `instrumento_pregunta_tipo` (
  `ipt_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del tipo de pregunta',
  `ipt_nombre` varchar(30) NOT NULL COMMENT 'nombre del tipo de pregunta',
  PRIMARY KEY (`ipt_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `instrumento_pregunta_tipo`
--

INSERT INTO `instrumento_pregunta_tipo` (`ipt_id`, `ipt_nombre`) VALUES
(1, 'booleana'),
(2, 'única respuesta'),
(3, 'múltiple respuesta'),
(4, 'texto'),
(5, 'numérica'),
(6, 'padre'),
(7, 'fecha');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento_respuestas`
--

CREATE TABLE IF NOT EXISTS `instrumento_respuestas` (
  `enc_id` int(11) NOT NULL COMMENT 'identificador del Tipo de encuesta',
  `ipr_id` int(11) NOT NULL COMMENT 'identificador de la pregunta',
  `ire_valor` varchar(400) DEFAULT NULL,
  PRIMARY KEY (`enc_id`,`ipr_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `instrumento_respuestas`
--

INSERT INTO `instrumento_respuestas` (`enc_id`, `ipr_id`, `ire_valor`) VALUES
(295, 159, ''),
(295, 160, ''),
(295, 161, ''),
(295, 162, ''),
(295, 163, ''),
(295, 164, ''),
(295, 165, '-1'),
(295, 166, ''),
(295, 167, ''),
(295, 168, ''),
(295, 169, ''),
(295, 170, '50'),
(295, 171, '184'),
(295, 172, '-1'),
(295, 173, '-1'),
(295, 174, ''),
(295, 175, ''),
(295, 176, '////'),
(295, 177, ''),
(295, 178, '-1'),
(295, 179, ''),
(295, 180, '-1'),
(295, 181, '-1'),
(295, 182, '-1'),
(295, 183, '-1'),
(295, 184, '-1'),
(295, 185, '-1'),
(295, 186, '-1'),
(295, 187, ''),
(295, 188, '-1'),
(295, 189, ''),
(295, 190, ''),
(295, 191, ''),
(295, 192, ''),
(295, 193, ''),
(295, 194, ''),
(295, 195, '-1'),
(295, 196, ''),
(295, 197, ''),
(295, 198, ''),
(295, 199, ''),
(295, 200, '-1'),
(295, 201, '-1'),
(295, 202, ''),
(295, 203, ''),
(295, 204, ''),
(295, 205, ''),
(295, 206, ''),
(295, 207, ''),
(295, 208, ''),
(295, 209, ''),
(295, 210, ''),
(295, 211, ''),
(295, 212, ''),
(295, 213, ''),
(295, 214, ''),
(295, 215, ''),
(295, 216, '-1'),
(295, 217, '-1'),
(295, 218, ''),
(295, 219, ''),
(295, 220, ''),
(295, 221, ''),
(295, 222, ''),
(295, 223, ''),
(295, 224, ''),
(295, 225, '-1'),
(295, 226, '-1'),
(295, 227, '-1'),
(295, 228, ''),
(295, 229, ''),
(295, 230, ''),
(295, 231, ''),
(295, 232, ''),
(295, 233, ''),
(295, 234, ''),
(295, 235, ''),
(295, 236, ''),
(295, 237, ''),
(295, 238, ''),
(295, 239, ''),
(295, 240, ''),
(295, 241, ''),
(295, 242, ''),
(295, 243, ''),
(295, 244, ''),
(295, 245, ''),
(295, 246, ''),
(295, 247, ''),
(295, 248, ''),
(295, 249, ''),
(295, 250, '-1'),
(295, 251, '-1'),
(295, 252, ''),
(295, 253, ''),
(295, 254, '-1'),
(295, 255, '-1'),
(295, 256, ''),
(295, 257, ''),
(295, 258, '-1'),
(295, 259, '-1'),
(295, 260, '-1'),
(295, 261, '-1'),
(295, 262, '-1'),
(295, 263, '-1'),
(295, 264, ''),
(295, 265, '-1'),
(295, 266, ''),
(295, 267, '-1'),
(295, 268, ''),
(295, 269, ''),
(295, 270, ''),
(295, 271, ''),
(295, 272, ''),
(295, 273, ''),
(295, 274, ''),
(295, 275, ''),
(295, 276, ''),
(295, 277, ''),
(295, 278, ''),
(295, 279, ''),
(295, 280, ''),
(295, 281, NULL),
(2202, 1, ''),
(2202, 2, ''),
(2202, 3, ''),
(2202, 4, ''),
(2202, 5, ''),
(2202, 6, ''),
(2202, 7, '-1'),
(2202, 8, ''),
(2202, 9, ''),
(2202, 10, '-1'),
(2202, 11, ''),
(2202, 12, '-1'),
(2202, 13, ''),
(2202, 14, ''),
(2202, 15, '-1'),
(2202, 16, '-1'),
(2202, 17, '-1'),
(2202, 18, '-1'),
(2202, 19, '-1'),
(2202, 20, '-1'),
(2202, 21, '-1'),
(2202, 22, '////'),
(2202, 23, '-1'),
(2202, 24, ''),
(2202, 25, ''),
(2202, 26, ''),
(2202, 27, ''),
(2202, 28, ''),
(2202, 29, ''),
(2202, 30, ''),
(2202, 31, ''),
(2202, 32, ''),
(2202, 33, ''),
(2202, 34, ''),
(2202, 35, ''),
(2202, 36, ''),
(2202, 37, ''),
(2202, 38, ''),
(2202, 39, ''),
(2202, 40, ''),
(2202, 41, ''),
(2202, 42, ''),
(2202, 43, ''),
(2202, 44, ''),
(2202, 45, ''),
(2202, 46, ''),
(2202, 47, '-1'),
(2202, 48, '-1'),
(2202, 49, '-1'),
(2202, 50, '-1'),
(2202, 51, ''),
(2202, 52, ''),
(2202, 53, ''),
(2202, 54, ''),
(2202, 55, ''),
(2202, 56, ''),
(2202, 57, ''),
(2202, 58, ''),
(2202, 59, ''),
(2202, 60, ''),
(2202, 61, ''),
(2202, 62, ''),
(2202, 63, ''),
(2202, 64, ''),
(2202, 65, ''),
(2202, 66, ''),
(2202, 67, ''),
(2202, 68, ''),
(2202, 69, ''),
(2202, 70, ''),
(2202, 71, ''),
(2202, 72, ''),
(2202, 73, ''),
(2202, 74, ''),
(2202, 75, ''),
(2202, 76, ''),
(2202, 77, ''),
(2202, 78, ''),
(2202, 79, ''),
(2202, 80, ''),
(2202, 81, '-1'),
(2202, 82, '-1'),
(2202, 83, '-1'),
(2202, 84, '-1'),
(2202, 85, '-1'),
(2202, 86, ''),
(2202, 87, ''),
(2202, 88, ''),
(2202, 89, ''),
(2202, 90, ''),
(2202, 91, ''),
(2202, 92, ''),
(2202, 93, ''),
(2202, 94, ''),
(2202, 95, ''),
(2202, 96, ''),
(2202, 97, ''),
(2202, 98, ''),
(2202, 99, ''),
(2202, 100, ''),
(2202, 101, ''),
(2202, 102, ''),
(2202, 103, ''),
(2202, 104, ''),
(2202, 105, ''),
(2202, 106, ''),
(2202, 107, ''),
(2202, 108, ''),
(2202, 109, ''),
(2202, 110, ''),
(2202, 111, ''),
(2202, 112, ''),
(2202, 113, ''),
(2202, 114, '-1'),
(2202, 115, '-1'),
(2202, 116, '-1'),
(2202, 117, '-1'),
(2202, 118, ''),
(2202, 119, ''),
(2202, 120, ''),
(2202, 121, ''),
(2202, 122, ''),
(2202, 123, ''),
(2202, 124, '-1'),
(2202, 125, '-1'),
(2202, 126, ''),
(2202, 127, ''),
(2202, 128, '-1'),
(2202, 129, '-1'),
(2202, 130, ''),
(2202, 131, ''),
(2202, 132, '-1'),
(2202, 133, '-1'),
(2202, 134, '-1'),
(2202, 135, '-1'),
(2202, 136, '-1'),
(2202, 137, '-1'),
(2202, 138, ''),
(2202, 139, '-1'),
(2202, 140, ''),
(2202, 141, '-1'),
(2202, 142, ''),
(2202, 143, ''),
(2202, 144, ''),
(2202, 145, ''),
(2202, 146, ''),
(2202, 147, ''),
(2202, 148, ''),
(2202, 149, ''),
(2202, 150, ''),
(2202, 151, ''),
(2202, 152, ''),
(2202, 153, ''),
(2202, 154, ''),
(2202, 155, ''),
(2207, 159, ''),
(2207, 160, ''),
(2207, 161, ''),
(2207, 162, ''),
(2207, 163, ''),
(2207, 164, ''),
(2207, 165, '-1'),
(2207, 166, ''),
(2207, 167, ''),
(2207, 168, ''),
(2207, 169, ''),
(2207, 170, ''),
(2207, 171, '-1'),
(2207, 172, '-1'),
(2207, 173, '-1'),
(2207, 174, ''),
(2207, 175, ''),
(2207, 176, '////'),
(2207, 177, ''),
(2207, 178, '200'),
(2207, 179, ''),
(2207, 180, '-1'),
(2207, 181, '-1'),
(2207, 182, '-1'),
(2207, 183, '-1'),
(2207, 184, '-1'),
(2207, 185, '-1'),
(2207, 186, '-1'),
(2207, 187, ''),
(2207, 188, '-1'),
(2207, 189, ''),
(2207, 190, ''),
(2207, 191, ''),
(2207, 192, ''),
(2207, 193, ''),
(2207, 194, ''),
(2207, 195, '-1'),
(2207, 196, ''),
(2207, 197, ''),
(2207, 198, ''),
(2207, 199, ''),
(2207, 200, '-1'),
(2207, 201, '-1'),
(2207, 202, ''),
(2207, 203, ''),
(2207, 204, ''),
(2207, 205, ''),
(2207, 206, ''),
(2207, 207, ''),
(2207, 208, ''),
(2207, 209, ''),
(2207, 210, ''),
(2207, 211, ''),
(2207, 212, ''),
(2207, 213, ''),
(2207, 214, ''),
(2207, 215, ''),
(2207, 216, '-1'),
(2207, 217, '-1'),
(2207, 218, ''),
(2207, 219, ''),
(2207, 220, ''),
(2207, 221, ''),
(2207, 222, ''),
(2207, 223, ''),
(2207, 224, ''),
(2207, 225, '-1'),
(2207, 226, '-1'),
(2207, 227, '-1'),
(2207, 228, ''),
(2207, 229, ''),
(2207, 230, ''),
(2207, 231, ''),
(2207, 232, ''),
(2207, 233, ''),
(2207, 234, ''),
(2207, 235, ''),
(2207, 236, ''),
(2207, 237, ''),
(2207, 238, ''),
(2207, 239, ''),
(2207, 240, ''),
(2207, 241, ''),
(2207, 242, ''),
(2207, 243, ''),
(2207, 244, ''),
(2207, 245, ''),
(2207, 246, ''),
(2207, 247, ''),
(2207, 248, ''),
(2207, 249, ''),
(2207, 250, '-1'),
(2207, 251, '-1'),
(2207, 252, ''),
(2207, 253, ''),
(2207, 254, '-1'),
(2207, 255, '-1'),
(2207, 256, ''),
(2207, 257, ''),
(2207, 258, '-1'),
(2207, 259, '-1'),
(2207, 260, '-1'),
(2207, 261, '-1'),
(2207, 262, '-1'),
(2207, 263, '-1'),
(2207, 264, ''),
(2207, 265, '-1'),
(2207, 266, ''),
(2207, 267, '305'),
(2207, 268, ''),
(2207, 269, ''),
(2207, 270, ''),
(2207, 271, ''),
(2207, 272, ''),
(2207, 273, ''),
(2207, 274, ''),
(2207, 275, ''),
(2207, 276, ''),
(2207, 277, ''),
(2207, 278, ''),
(2207, 279, '1'),
(2207, 280, '-1'),
(2207, 281, '-1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento_saltos`
--

CREATE TABLE IF NOT EXISTS `instrumento_saltos` (
  `ipr_id` int(11) NOT NULL COMMENT 'Identificador de la pregunta',
  `ipo_id` int(11) NOT NULL COMMENT 'Identificador de la respuesta a la pregunta',
  `ipr_id_salta` int(11) NOT NULL COMMENT 'Identificador de la pregunta a la cual se salta',
  PRIMARY KEY (`ipr_id`,`ipo_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `instrumento_saltos`
--

INSERT INTO `instrumento_saltos` (`ipr_id`, `ipo_id`, `ipr_id_salta`) VALUES
(18, 14, 20),
(18, 16, 23),
(21, 25, 59),
(21, 26, 50),
(22, 28, 24),
(22, 29, 24),
(22, 30, 24),
(49, 48, 81),
(49, 49, 81),
(49, 50, 81),
(49, 51, 81),
(49, 52, 81),
(50, 54, 66),
(59, 0, 72),
(119, 1, 120),
(137, 322, 139),
(139, 324, 141),
(153, 1, 141),
(173, 190, 176),
(173, 191, 180),
(173, 192, 182),
(173, 193, 186),
(173, 194, 186),
(173, 195, 186),
(174, 1, 183),
(175, 1, 185),
(178, 201, 186),
(178, 202, 186),
(181, 207, 186),
(181, 208, 186),
(181, 209, 186),
(182, 210, 186),
(182, 211, 186),
(182, 212, 186),
(182, 213, 186),
(184, 217, 186),
(184, 218, 186),
(184, 219, 186),
(184, 220, 186),
(185, 221, 186),
(185, 222, 186),
(188, 228, 225),
(195, 232, 200),
(195, 233, 200),
(200, 235, 218),
(263, 326, 265),
(265, 328, 267),
(279, 1, 267);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento_seccion`
--

CREATE TABLE IF NOT EXISTS `instrumento_seccion` (
  `ise_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id de la sección',
  `ise_nombre` varchar(100) NOT NULL COMMENT 'nombre de la sección',
  `ise_numero` varchar(10) NOT NULL COMMENT 'número de la sección',
  `ise_orden` int(11) NOT NULL COMMENT 'orden de carga de la sección',
  `ins_id` int(11) NOT NULL COMMENT 'id del instrumento al  que pertenece',
  PRIMARY KEY (`ise_id`),
  KEY `ins_id` (`ins_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Secciones de los instrumentos de las encuestas' AUTO_INCREMENT=30 ;

--
-- Volcado de datos para la tabla `instrumento_seccion`
--

INSERT INTO `instrumento_seccion` (`ise_id`, `ise_nombre`, `ise_numero`, `ise_orden`, `ins_id`) VALUES
(1, 'DATOS ENCUESTA', '0.', 1, 1),
(2, 'IDENTIFICACIÓN', 'I.', 2, 1),
(3, 'DATOS GENERALES DEL ENCUESTADO', 'II.', 3, 1),
(4, 'ACCESO Y USO DE LAS TIC', 'III.', 4, 1),
(5, 'INTERESES EN LAS TIC', 'IV.', 5, 1),
(6, 'CARACTERISTICAS SOCIODEMOGRÁFICAS', 'V.', 6, 1),
(7, 'DATOS DE COMUNICACIÓN PARA VERIFICACIÓN', 'VI.', 7, 1),
(8, 'VALORACIÓN DE LA ENCUESTA A CARGO DEL ENTREVISTADOR', 'VII.', 8, 1),
(9, 'INCIDENCIAS DE LA ENCUESTA', 'VIII.', 9, 1),
(10, 'ENCUESTAS REALIZADAS', 'IX.', 10, 1),
(11, 'OBSERVACIONES', 'X.', 11, 1),
(13, 'DATOS ENCUESTA', '0.', 1, 2),
(14, 'IDENTIFICACIÓN', 'I.', 2, 2),
(15, 'DATOS GENERALES DEL ENCUESTADO', 'II.', 3, 2),
(16, 'CARACTERISTICA DE LA ORGANIZACIÓN', 'III.', 4, 2),
(17, 'INSTITUCIÓN EDUCATIVA', 'IV.', 5, 2),
(18, 'INSTITUCIÓN DE LA SALUD', 'V.', 6, 2),
(19, 'ESTABLECIMIENTO DE SEGURIDAD', '', 7, 2),
(20, 'UNIDAD PRODUCTIVA', 'VI.', 8, 2),
(21, 'INSTITUCION REGIONAL', 'VII.', 9, 2),
(22, 'ACCESO Y USO DE LAS TIC EN LA ORGANIZACIÓN', 'VIII.', 10, 2),
(23, 'OTRA INFORMACIÓN', 'IX.', 11, 2),
(24, 'DATOS DE COMUNICACIÓN PARA VERIFICACIÓN', 'X.', 12, 2),
(25, 'VALORACIÓN DE LA ENCUESTA A CARGO DEL ENTREVISTADOR', 'XI.', 13, 2),
(26, 'INCIENCIAS DE LA ENCUESTA', 'XII.', 14, 2),
(27, 'ENCUESTAS REALIZADAS', 'XIII.', 15, 2),
(28, 'OBSERVACIONES', 'XIV.', 16, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `instrumento_tipo`
--

CREATE TABLE IF NOT EXISTS `instrumento_tipo` (
  `iti_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del tipo de instrumento',
  `iti_nombre` varchar(60) NOT NULL COMMENT 'nombre del tipo de instrumento',
  PRIMARY KEY (`iti_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='tipos de instrumento para asociarlos a un módulo' AUTO_INCREMENT=2 ;

--
-- Volcado de datos para la tabla `instrumento_tipo`
--

INSERT INTO `instrumento_tipo` (`iti_id`, `iti_nombre`) VALUES
(1, 'Social');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `monedas`
--

CREATE TABLE IF NOT EXISTS `monedas` (
  `Id_Moneda` int(11) NOT NULL AUTO_INCREMENT,
  `Descripcion_Moneda` varchar(30) NOT NULL,
  PRIMARY KEY (`Id_Moneda`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Volcado de datos para la tabla `monedas`
--

INSERT INTO `monedas` (`Id_Moneda`, `Descripcion_Moneda`) VALUES
(1, 'Pesos'),
(2, 'Bolivares'),
(4, 'Dolares'),
(5, 'Yenes'),
(6, 'Rupias');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `municipio`
--

CREATE TABLE IF NOT EXISTS `municipio` (
  `mun_id` varchar(5) NOT NULL DEFAULT '' COMMENT 'Codigo dane del municipio',
  `dep_id` varchar(2) NOT NULL DEFAULT '' COMMENT 'Codigo dane del departamento al que pertenece el municipio',
  `mun_nombre` varchar(100) NOT NULL DEFAULT '' COMMENT 'Nombre del municipio',
  `mun_poblacion` int(11) NOT NULL DEFAULT '0' COMMENT 'Nro de habitantes del municipio segun proyeccion DANE',
  PRIMARY KEY (`mun_id`),
  KEY `FK_MUNICIPIO_DEPARTAMENTO` (`dep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los municipios por departamento';

--
-- Volcado de datos para la tabla `municipio`
--

INSERT INTO `municipio` (`mun_id`, `dep_id`, `mun_nombre`, `mun_poblacion`) VALUES
('27006', '11', 'Acandí', 0),
('27025', '11', 'Alto Baudo', 0),
('27075', '11', 'Bahía Solano', 0),
('27077', '11', 'Bajo Baudó', 0),
('27099', '11', 'Bojaya', 0),
('27250', '11', 'El Litoral del San Juan', 0),
('27372', '11', 'Juradó', 0),
('27425', '11', 'Medio Atrato', 0),
('27495', '11', 'Nuquí', 0),
('27745', '11', 'Sipí', 0),
('27800', '11', 'Unguía', 0),
('50110', '6', 'Barranca de Upía', 0),
('50226', '6', 'Cumaral', 0),
('50350', '6', 'La Macarena', 0),
('50370', '6', 'Uribe', 0),
('5873', '10', 'Vigía del Fuerte', 0),
('81220', '8', 'Cravo Norte', 0),
('85162', '9', 'Monterrey', 0),
('86573', '4', 'Leguízamo', 0),
('91001', '1', 'Leticia', 0),
('91263', '1', 'El Encanto ', 0),
('91405', '1', 'La Chorrera ', 0),
('91407', '1', 'La Pedrera ', 0),
('91430', '1', 'La Victoria ', 0),
('91460', '1', 'Miriti - Paraná ', 0),
('91530', '1', 'Puerto Alegría ', 0),
('91536', '1', 'Puerto Arica ', 0),
('91540', '1', 'Puerto Nariño', 0),
('91669', '1', 'Puerto Santander ', 0),
('91798', '1', 'Tarapacá ', 0),
('94001', '2', 'Inírida', 0),
('94343', '2', 'Barranco Minas ', 0),
('94663', '2', 'Mapiripana ', 0),
('94883', '2', 'San Felipe ', 0),
('94884', '2', 'Puerto Colombia ', 0),
('94885', '2', 'La Guadalupe', 0),
('94886', '2', 'Cacahual ', 0),
('94887', '2', 'Pana Pana ', 0),
('94888', '2', 'Morichal ', 0),
('95200', '3', 'Miraflores', 0),
('97001', '5', 'Mitú', 0),
('97161', '5', 'Caruru', 0),
('97511', '5', 'Pacoa ', 0),
('97666', '5', 'Taraira', 0),
('97777', '5', 'Papunaua ', 0),
('97889', '5', 'Yavaraté ', 0),
('99001', '7', 'Puerto Carreño', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion`
--

CREATE TABLE IF NOT EXISTS `opcion` (
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
  KEY `FK_OPCION_NIVEL` (`opn_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene las opciones para crear el menu' AUTO_INCREMENT=100 ;

--
-- Volcado de datos para la tabla `opcion`
--

INSERT INTO `opcion` (`opc_id`, `opc_nombre`, `opc_variable`, `opc_url`, `opn_id`, `opc_padre_id`, `opc_orden`, `layout`, `ope_id`) VALUES
(1, 'PRINCIPAL', '', '', 0, 0, 100000, '', 1),
(2, 'DOCUMENTAL', '', '', 0, 0, 200000, '', 1),
(3, 'SEGURIDAD', '', '', 0, 0, 900000, '', 1),
(4, 'Inicio', 'home', 'home.php', 1, 1, 101000, '', 1),
(5, 'Tablas Basicas', 'tablas', 'tablas/tablas.php', 1, 3, 901000, '', 1),
(6, 'Usuarios', 'usuarios', 'usuarios/usuarios.php', 1, 3, 902000, '', 1),
(7, 'Perfiles', 'perfiles', 'perfiles/perfiles.php', 1, 3, 903000, '', 1),
(8, 'Opciones', 'opciones', 'opciones/opciones.php', 1, 3, 904000, '', 1),
(9, 'Cambiar Clave', 'usuarios&task=editClave', 'usuarios/usuarios.php', 1, 3, 908000, '', 1),
(10, 'Cerrar Sesion', 'cerrar', 'cerrar.php', 1, 3, 909000, 'login_layout.php', 1),
(31, 'Manuales', 'manuales', 'manuales/manuales.php', 1, 1, 102000, '', 1),
(66, 'Actas', 'actas', 'documentos/actas.php', 1, 2, 202000, '', 1),
(67, 'Comunicados', 'correspondencia', 'documentos/correspondencia.php', 1, 2, 201000, '', 1),
(68, 'Compromisos', 'compromisos', 'documentos/compromisos.php', 1, 2, 204000, '', 1),
(82, 'Recomendaciones', 'recomendaciones', 'documentos/recomendaciones.php', 1, 2, 205000, '', 1),
(92, 'Resumen PIA', 'resumenPIA', 'financiero/resumenPlanInversionAnticipo.php', 1, 69, 401400, '', 1),
(93, 'Extractos Int.', 'extractosInt', 'interventoria/extractos.php', 1, 83, 505000, '', 1),
(94, 'Rendimientos Int.', 'rendimientosInt', 'interventoria/rendimientos.php', 1, 83, 506000, '', 1),
(97, 'SOCIAL', NULL, '', 0, 0, 300000, '', 1),
(98, 'Planeación', 'planeacion', 'planeacion/planeacion.php', 1, 97, 301000, '', 1),
(99, 'Ejecución', 'ejecucion', 'ejecucion/ejecucion.php', 1, 2, 302000, '', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `opcion_nivel`
--

CREATE TABLE IF NOT EXISTS `opcion_nivel` (
  `opn_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del nivel',
  `opn_nombre` varchar(25) NOT NULL COMMENT 'Nombre del nivel',
  PRIMARY KEY (`opn_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los niveles de las opciones' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `opcion_nivel`
--

INSERT INTO `opcion_nivel` (`opn_id`, `opn_nombre`) VALUES
(0, 'encabezado'),
(1, 'modulo'),
(2, 'opcion del modulo');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `operador`
--

CREATE TABLE IF NOT EXISTS `operador` (
  `ope_id` int(11) NOT NULL COMMENT 'Identificador del operador',
  `ope_nombre` varchar(50) NOT NULL COMMENT 'Nombre del operador',
  `ope_sigla` varchar(20) NOT NULL COMMENT 'Sigla del operador',
  `ope_contrato_no` varchar(45) DEFAULT NULL COMMENT 'Nro de contrato del operador',
  `ope_contrato_valor` decimal(19,2) DEFAULT NULL COMMENT 'Valor del contrato del operador',
  PRIMARY KEY (`ope_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene los operadores que forman parte del contrato';

--
-- Volcado de datos para la tabla `operador`
--

INSERT INTO `operador` (`ope_id`, `ope_nombre`, `ope_sigla`, `ope_contrato_no`, `ope_contrato_valor`) VALUES
(1, 'OPERADOR', 'OPR', '1', '1.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `ordenesdepago`
--

CREATE TABLE IF NOT EXISTS `ordenesdepago` (
  `Id_Orden_Pago` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Correspondel al Id de la orden de pago.',
  `Id_Tipo_Actividad` int(2) NOT NULL COMMENT 'Corresponde al Id del tipo de actividad de la tabla actividades_tipo',
  `Id_Actividad` int(11) NOT NULL COMMENT 'Corresponde al Id de la actividad de la tabla actividades.',
  `Numero_Orden_Pago` varchar(10) NOT NULL COMMENT 'Indica el numero de la orden de pago.',
  `Fecha_Orden_Pago` date NOT NULL COMMENT 'Corresponde a la fecha en que se ingresa la orden de pago',
  `Numero_Factura` varchar(10) NOT NULL COMMENT 'Indica el numero de la factura de la orden de pago',
  `Id_Proveedor` int(11) NOT NULL COMMENT 'Corresponde al Id del provedor de la tabla de proveedores',
  `Id_Moneda_Orden` int(1) NOT NULL COMMENT 'Corresponde al Id de la moneda de la tabla monedas',
  `Tasa_Orden` float NOT NULL COMMENT 'Indica la Tasa de la moneda',
  `valor_total` bigint(15) NOT NULL COMMENT 'Correponde al valor total de la orden de pago',
  `Id_Estado_Orden` int(11) NOT NULL COMMENT 'Indica el Id del estado de la tabla estados_ordenes',
  `Fecha_Pago_Orden` date DEFAULT NULL COMMENT 'Corresponde a la fecha de pago ingresada por el usuario si esta estado es pagado si no se deja pendiente',
  `Observaciones_Orden` varchar(500) DEFAULT NULL COMMENT 'Corresponde a las observaciones que el usuario desee ingresar respecto a la orden de pago',
  `Archivo_Orden` varchar(400) DEFAULT NULL COMMENT 'Hace referencia al nombre del archivo almacenado',
  `cobro_proveedor_reintegro` varchar(10) DEFAULT NULL COMMENT 'Campo que guardará los Números de cuenta de cobro del proveesor',
  PRIMARY KEY (`Id_Orden_Pago`),
  KEY `Id_Tipo_Actividad` (`Id_Tipo_Actividad`),
  KEY `Id_Actividad` (`Id_Actividad`),
  KEY `Id_Proveedor` (`Id_Proveedor`),
  KEY `Id_Moneda_Orden` (`Id_Moneda_Orden`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pais`
--

CREATE TABLE IF NOT EXISTS `pais` (
  `Id_Pais` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador único interno de cada país',
  `Nombre_Pais` varchar(20) NOT NULL COMMENT 'Nombre de cada país',
  PRIMARY KEY (`Id_Pais`),
  UNIQUE KEY `Nombre_Pais` (`Nombre_Pais`),
  UNIQUE KEY `Nombre_Pais_2` (`Nombre_Pais`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Esta tabla guarda los paises que serán registrados en el sistema' AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil`
--

CREATE TABLE IF NOT EXISTS `perfil` (
  `per_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del perfil',
  `per_nombre` varchar(50) NOT NULL COMMENT 'Nombre del perfil',
  PRIMARY KEY (`per_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los perfiles de acceso al sistema' AUTO_INCREMENT=7 ;

--
-- Volcado de datos para la tabla `perfil`
--

INSERT INTO `perfil` (`per_id`, `per_nombre`) VALUES
(1, 'Administrador'),
(2, 'Consulta'),
(3, 'SOCIAL'),
(4, 'ANDIRED'),
(5, 'DOCUMENTAL'),
(6, 'Financiero');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `perfil_x_opcion`
--

CREATE TABLE IF NOT EXISTS `perfil_x_opcion` (
  `per_id` int(11) NOT NULL COMMENT 'Id del perfil',
  `opc_id` int(11) NOT NULL COMMENT 'Id de la opcion',
  `pxo_nivel` int(1) NOT NULL COMMENT 'Nivel de acceso a la opcion',
  PRIMARY KEY (`per_id`,`opc_id`),
  KEY `FK_PERFIL_OPCION_PERFIL` (`per_id`),
  KEY `FK_PERFIL_OPCION_OPCION` (`opc_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Contiene la relacion perfil vs opcion';

--
-- Volcado de datos para la tabla `perfil_x_opcion`
--

INSERT INTO `perfil_x_opcion` (`per_id`, `opc_id`, `pxo_nivel`) VALUES
(1, 1, 1),
(1, 2, 2),
(1, 3, 1),
(1, 4, 1),
(1, 5, 1),
(1, 6, 1),
(1, 7, 1),
(1, 8, 1),
(1, 9, 1),
(1, 10, 1),
(1, 31, 1),
(1, 66, 1),
(1, 67, 1),
(1, 68, 1),
(1, 82, 1),
(1, 97, 2),
(1, 98, 1),
(1, 99, 1),
(2, 1, 2),
(2, 2, 2),
(2, 3, 2),
(2, 4, 2),
(2, 9, 2),
(2, 10, 2),
(2, 31, 2),
(2, 66, 2),
(2, 67, 2),
(2, 68, 2),
(2, 82, 2),
(3, 1, 2),
(3, 2, 2),
(3, 3, 1),
(3, 4, 2),
(3, 9, 1),
(3, 10, 1),
(3, 66, 1),
(3, 67, 1),
(3, 68, 1),
(3, 82, 1),
(3, 97, 2),
(3, 98, 1),
(4, 2, 2),
(4, 3, 2),
(4, 10, 2),
(4, 66, 2),
(4, 67, 2),
(4, 68, 2),
(4, 82, 2),
(5, 1, 1),
(5, 2, 1),
(5, 3, 1),
(5, 4, 2),
(5, 5, 2),
(5, 6, 1),
(5, 7, 1),
(5, 8, 2),
(5, 9, 1),
(5, 10, 1),
(5, 66, 1),
(5, 67, 1),
(5, 68, 1),
(5, 82, 1),
(6, 1, 2),
(6, 2, 1),
(6, 3, 2),
(6, 4, 1),
(6, 5, 1),
(6, 9, 1),
(6, 10, 1),
(6, 66, 1),
(6, 67, 1),
(6, 68, 1),
(6, 82, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `planeacion`
--

CREATE TABLE IF NOT EXISTS `planeacion` (
  `pla_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'identificador único de planeación',
  `mun_id` int(10) NOT NULL COMMENT 'Corresponde al identificador unicao de cada uno de Municipios almacenados en la base de datos',
  `eje_id` int(10) NOT NULL COMMENT 'Corresponde al tipo de punto: PVD, KVD, Banda Ancha (BA), Instituciones Públicas (IP) y Wifi (WIFI).',
  `pla_numero_encuestas` int(100) NOT NULL COMMENT 'Corresponde al número de encuestas que se van a realizar a la organización.',
  `pla_fecha_inicio` date NOT NULL,
  `pla_fecha_fin` date NOT NULL,
  `usu_id` int(1) NOT NULL,
  `ees_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`pla_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Volcado de datos para la tabla `planeacion`
--

INSERT INTO `planeacion` (`pla_id`, `mun_id`, `eje_id`, `pla_numero_encuestas`, `pla_fecha_inicio`, `pla_fecha_fin`, `usu_id`, `ees_id`) VALUES
(1, 27006, 5, 30, '2014-07-08', '2014-08-13', 92, 2),
(3, 27075, 5, 25, '2014-07-08', '2014-08-13', 92, 2),
(5, 27099, 5, 23, '2014-07-08', '2014-08-13', 92, 2),
(7, 27372, 5, 7, '2014-07-08', '2014-08-13', 92, 2),
(9, 27495, 5, 18, '2014-07-08', '2014-08-13', 92, 2),
(11, 27800, 5, 30, '2014-07-08', '2014-08-13', 92, 2),
(12, 5873, 5, 14, '2014-07-08', '2014-08-13', 92, 2),
(13, 27006, 3, 4, '2014-07-08', '2014-08-13', 92, 2),
(15, 27075, 3, 7, '2014-07-08', '2014-08-13', 92, 2),
(17, 27099, 3, 4, '2014-07-08', '2014-08-13', 92, 2),
(19, 27372, 3, 4, '2014-07-08', '2014-08-13', 92, 2),
(21, 27495, 3, 4, '2014-07-08', '2014-08-13', 92, 2),
(23, 27800, 3, 10, '2014-07-08', '2014-08-13', 92, 2),
(24, 5873, 3, 6, '2014-07-08', '2014-08-13', 92, 2),
(25, 27006, 2, 16, '2014-07-08', '2014-08-13', 92, 2),
(27, 27075, 2, 8, '2014-07-08', '2014-08-13', 92, 2),
(29, 27099, 2, 19, '2014-07-08', '2014-08-13', 92, 2),
(31, 27372, 2, 8, '2014-07-08', '2014-08-13', 92, 2),
(33, 27495, 2, 7, '2014-07-08', '2014-08-13', 92, 2),
(35, 27800, 2, 13, '2014-07-08', '2014-08-13', 92, 2),
(36, 5873, 2, 11, '2014-07-08', '2014-08-13', 92, 2),
(37, 27006, 1, 1, '2014-07-08', '2014-08-13', 92, 2),
(39, 27075, 1, 1, '2014-07-08', '2014-08-13', 92, 2),
(41, 27099, 1, 1, '2014-07-08', '2014-08-13', 92, 2),
(43, 27372, 1, 1, '2014-07-08', '2014-08-13', 92, 2),
(45, 27495, 1, 1, '2014-07-08', '2014-08-13', 92, 2),
(47, 27800, 1, 1, '2014-07-08', '2014-08-13', 92, 2),
(48, 5873, 1, 1, '2014-07-08', '2014-08-13', 92, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE IF NOT EXISTS `proveedores` (
  `Id_Prove` int(11) NOT NULL AUTO_INCREMENT,
  `Nit_Prove` varchar(11) NOT NULL,
  `Nombre_Prove` varchar(60) NOT NULL,
  `Telefono_Prove` varchar(10) NOT NULL,
  `Pais_Prove` int(11) NOT NULL,
  `Ciudad_Prove` int(11) NOT NULL,
  `Direcc_Prove` varchar(30) NOT NULL,
  `Nom_Contac_Prove` varchar(30) NOT NULL,
  `ApellA_Contac` varchar(25) NOT NULL,
  `ApellB_Contac` varchar(25) NOT NULL,
  `Tel_Contac_Prove` varchar(10) NOT NULL,
  `Email_Prove` varchar(40) NOT NULL,
  PRIMARY KEY (`Id_Prove`),
  UNIQUE KEY `Nit_Prove` (`Nit_Prove`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendaciones`
--

CREATE TABLE IF NOT EXISTS `recomendaciones` (
  `com_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del compromiso',
  `com_actividad` text NOT NULL COMMENT 'Actividad que debe ejecutar',
  `doc_id` int(11) DEFAULT NULL COMMENT 'Id del documento que generó el compromiso',
  `com_fecha_limite` date DEFAULT NULL COMMENT 'Fecha limite de cumplimiento del compromiso',
  `com_fecha_entrega` date DEFAULT NULL COMMENT 'Fecha real de cumplimiento del compromiso',
  `ces_id` int(1) NOT NULL COMMENT 'Id del estado del compromiso',
  `com_observaciones` text NOT NULL COMMENT 'Observaciones del compromiso',
  `ope_id` int(2) DEFAULT NULL COMMENT 'Id del operador responsable del compromiso',
  `com_consecutivo` int(11) DEFAULT NULL,
  PRIMARY KEY (`com_id`),
  KEY `FK_COMPROMISO1_TIPO_ESTADO` (`ces_id`),
  KEY `FK_COMPROMISO1_DOCUMENTO` (`doc_id`),
  KEY `fk_compromiso_operador_idx` (`ope_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `recomendaciones`
--

INSERT INTO `recomendaciones` (`com_id`, `com_actividad`, `doc_id`, `com_fecha_limite`, `com_fecha_entrega`, `ces_id`, `com_observaciones`, `ope_id`, `com_consecutivo`) VALUES
(2, 'Esta es una recomendación suprema mente larga y extensa!', 7, NULL, '2014-07-14', 1, 'Esta es una observación que no tiene sentido que la escriba o la mencione', 1, NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendaciones_estado`
--

CREATE TABLE IF NOT EXISTS `recomendaciones_estado` (
  `ces_id` int(1) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del estado del compromiso',
  `ces_nombre` varchar(30) NOT NULL COMMENT 'Nombre del estado del compromiso',
  PRIMARY KEY (`ces_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los estados de los compromisos' AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `recomendaciones_estado`
--

INSERT INTO `recomendaciones_estado` (`ces_id`, `ces_nombre`) VALUES
(1, 'Abierto'),
(2, 'Cerrado');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recomendaciones_responsable`
--

CREATE TABLE IF NOT EXISTS `recomendaciones_responsable` (
  `cor_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Identificador del responsable',
  `com_id` int(11) NOT NULL COMMENT 'Id del compromiso',
  `usu_id` int(11) NOT NULL COMMENT 'Id del usuario responsable de este compromiso',
  PRIMARY KEY (`cor_id`),
  KEY `FK_COMPROMISO_COMPROMISO` (`com_id`),
  KEY `FK_COMPROMISO_USUARIO` (`usu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Volcado de datos para la tabla `recomendaciones_responsable`
--

INSERT INTO `recomendaciones_responsable` (`cor_id`, `com_id`, `usu_id`) VALUES
(2, 2, 80);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rendimiento_financiero`
--

CREATE TABLE IF NOT EXISTS `rendimiento_financiero` (
  `rfi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del rendimiento financiero',
  `cfi_id` int(11) NOT NULL COMMENT 'cuenta del rendimiento',
  `rfi_mes` int(11) NOT NULL COMMENT 'mes del rendimiento financiero',
  `rfi_anio` int(11) NOT NULL COMMENT 'año del rendimiento financiero',
  `rfi_rendimiento_financiero` double NOT NULL COMMENT 'plata del rendimiento financiero',
  `rfi_descuentos` double NOT NULL COMMENT 'descuentos sobre el rendimiento fiduciario',
  `rfi_rendimiento_consignado` double NOT NULL COMMENT 'rendimiento financiero menos descuentos',
  `rfi_rendimiento_acumulado` double NOT NULL COMMENT 'rendimiento acumulado en meses anteriores',
  `rfi_rentabilidad_tasa` float NOT NULL COMMENT 'tasa de rentabilidad del rendimiento financiero',
  `rfi_fecha_consignacion` date NOT NULL COMMENT 'fecha de consignación',
  `rfi_comprobante_consignacion` varchar(250) NOT NULL COMMENT 'documento soporte de consignación',
  `rfi_comprobante_emision` varchar(250) NOT NULL COMMENT 'documento soporte emisión FONTIC',
  `rfi_valor_fiduciaria` double NOT NULL COMMENT 'valor enviado por la fiduciaria',
  `erf_id` int(11) NOT NULL COMMENT 'id del estado del rendimiento',
  `rfi_observaciones` text NOT NULL COMMENT 'observaciones del rendimiento financiero',
  PRIMARY KEY (`rfi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rendimiento_financiero_int`
--

CREATE TABLE IF NOT EXISTS `rendimiento_financiero_int` (
  `rfi_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'id del rendimiento financiero',
  `cfi_id` int(11) NOT NULL COMMENT 'cuenta del rendimiento',
  `rfi_mes` int(11) NOT NULL COMMENT 'mes del rendimiento financiero',
  `rfi_anio` int(11) NOT NULL COMMENT 'año del rendimiento financiero',
  `rfi_rendimiento_financiero` double NOT NULL COMMENT 'plata del rendimiento financiero',
  `rfi_descuentos` double NOT NULL COMMENT 'descuentos sobre el rendimiento fiduciario',
  `rfi_rendimiento_consignado` double NOT NULL COMMENT 'rendimiento financiero menos descuentos',
  `rfi_rendimiento_acumulado` double NOT NULL COMMENT 'rendimiento acumulado en meses anteriores',
  `rfi_rentabilidad_tasa` float NOT NULL COMMENT 'tasa de rentabilidad del rendimiento financiero',
  `rfi_fecha_consignacion` date NOT NULL COMMENT 'fecha de consignación',
  `rfi_comprobante_consignacion` varchar(250) NOT NULL COMMENT 'documento soporte de consignación',
  `rfi_comprobante_emision` varchar(250) NOT NULL COMMENT 'documento soporte emisión FONTIC',
  `rfi_valor_fiduciaria` double NOT NULL COMMENT 'valor enviado por la fiduciaria',
  `erf_id` int(11) NOT NULL COMMENT 'id del estado del rendimiento',
  `rfi_observaciones` text NOT NULL COMMENT 'observaciones del rendimiento financiero',
  PRIMARY KEY (`rfi_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
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
  KEY `FK_USUARIO_PERFIL` (`per_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 COMMENT='Contiene los usuarios' AUTO_INCREMENT=96 ;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`usu_id`, `per_id`, `usu_login`, `usu_clave`, `usu_nombre`, `usu_apellido`, `usu_documento`, `usu_telefono`, `usu_celular`, `usu_correo`, `usu_estado`, `usu_fecha_ultimo_ingreso`) VALUES
(1, 1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Usuario', 'Administrador', '123456', '12336655', '3158989898', 'admin@mail.com', 1, '2014-07-21'),
(64, 2, 'consulta', '5d76beffe761403531a6eb339e0f0231', 'consulta', 'consulta', '63526847', '74563987', '3000000000', 'xxx@redcom.com.co', 1, '2014-06-13'),
(66, 1, 'gramirez', '3b7523b92474628b33d3b22bcea3c0b4', 'German', 'Ramirez', '5555432', '32145870', '3144575984', 'asi.pncav@serticsas.com.co', 1, '2014-07-17'),
(68, 2, 'dclavijo', 'e3f7132e274902c456b4a4e4be9006da', 'Diana', 'Clavijo', '11111111', '34567890', '3111111111', 'asji.pncav@serticsas.com.co', 1, '2014-07-17'),
(69, 2, 'kmontes', '98acd9f19739c7ef08cfc5dbe796eb15', 'Katty', 'Montes', '11111111', '34567890', '3111111111', 'dhseq.pncav@serticsas.com', 1, '2014-07-15'),
(70, 1, 'grodriguez', 'e10adc3949ba59abbe56e057f20f883e', 'GERMAN', 'RODRIGUEZ', '1111111', '31445759', '3144588798', 'asi.pncav@serticsas.com.co', 1, '2014-04-08'),
(71, 2, 'pdelrio', '3b08ef6006dc8490f3b6cc30667fd906', 'Pedro', 'Del Rio', '12234123', '23456764', '3111111111', 'dji.pncav@serticsas.com.co', 1, '2014-07-18'),
(72, 2, 'dlezcano', '5e3563f3b1f4695326e7b0cf37ffe91d', 'Donnell', 'Lezcano', '1111112', '34567890', '3111111111', 'dpa.pncav@serticsas.com.co', 1, '2014-07-18'),
(74, 5, 'damezquita', '7684aef1b28cd287bfa263e4a42b2f64', 'Diana Marcela', 'Amezquita Chitiva', '1026259544', '68086502', '3143789282', 'agd.pncav@serticsas.com.co', 1, '2014-07-18'),
(75, 1, 'laparicio', '9f7c0bdd5f70ce7e7cb9e1c7deadbd41', 'Lubis ', 'Aparicio', '78453245', '34589725', '3214567890', 'dti.pncav@serticsas.com.co', 1, '2014-07-18'),
(76, 2, 'gmartinez', 'acfc96dea96e4e24b8e38ba006745d83', 'Guillermo', 'Martinez', '245678905', '23456795', '3145672385', 'dsi.pncav@serticsas.com.co', 1, '2014-06-27'),
(77, 6, 'dlopez', '71db5bea921f7137e8a2400573469ceb', 'Danny', 'Lopez', '789345678', '78945673', '3003789234', 'ahseq.pncav@serticsas.com.co', 1, '2014-07-18'),
(78, 6, 'wtovar', 'f1936d7e77b7ce255c2d947ecd8dd6fc', 'Wilson', 'Tovar', '89234567', '45678903', '3214567834', 'hseqa.pncav@serticsas.com.co', 1, '2014-07-17'),
(79, 2, 'mgaona', '8b409ffe1e9cbad9df9c190af4b1d4fb', 'Manolo', 'Gaona', '80945683', '67834902', '3013458723', 'aji.pncav@serticsas.com.co', 1, '2014-07-17'),
(80, 2, 'agomez', '403a11c6fae14f6b52fcc5475f58797f', 'Andres', 'Gomez', '34567890', '23467895', '3145632890', 'alts.pncav@serticsas.com.co', 1, '2014-07-18'),
(81, 2, 'ldelgado', '6e4c7603d1e3113a8c919b9caac291dc', 'Lorena', 'Delgado', '56890123', '78903454', '3112370405', 'asege.pncav@serticsas.com.co', 1, '2014-07-18'),
(82, 2, 'mserna', 'ae9df8722138865ffc98ee26a3868d01', 'Mauricio', 'Serna', '45678902', '56734210', '3135643222', 'artlan.pncav@serticsas.com.co', 1, '2014-07-18'),
(83, 3, 'mvelandia', '38df4e739d9a88d248694a2ab1cfcee3', 'Mauricio', 'Velandia', '87904322', '45678902', '3004567892', 'asa.pncav@serticsas.com.co', 1, '2014-07-14'),
(84, 3, 'llastre', '2e221306e8cc73bc443e27d3e023f50a', 'Lidu', 'Lastre', '523457865', '58900214', '3004321189', 'asa1.pncav@serticsas.com.co', 1, '2014-07-18'),
(85, 2, 'vgaribello', '5aacdf2b2692424b57ef71707527fcd5', 'Victor', 'Garibello', '345678921', '22345678', '3113256702', 'arti.pncav@serticsas.com.co', 1, '2014-07-16'),
(86, 2, 'DIRCON', '362e08ce58d8d7ae58248281db4674bf', 'Direccion', 'Conectividad', '234567890', '56734521', '3001236782', 'dircon@mintic.gov.co', 1, '2014-07-17'),
(87, 4, 'UTANDIRED', '3d93d6f32ae9d3afa4f44739e6db7bea', 'Union temporal Andired', 'Andired', '89032456', '84567123', '3112567890', 'ut@anditel.com.co', 1, '2014-07-18'),
(88, 2, 'FIDUB', 'fa9423106d9d901feb51b8e6d5aaa1bf', 'Fiduciaria', 'Bogota', '34678012', '89023456', '3142256678', 'bogota@fiducaria.com.co', 1, '2014-04-08'),
(89, 6, 'lmendoza', '45aa3251f9e963f7b2e9bbf86a2eb13f', 'Luz Marina ', 'Mendoza', '56789321', '34567890', '3124567892', 'daf.pncav@serticsas.com.co', 1, '2014-07-18'),
(90, 6, 'omelo', '03021920a5a125e1d795bfa46511e50a', 'Oscar', 'Melo', '89034568', '23445780', '3015890234', 'afa.pncav@serticsas.com.co', 1, '2014-07-17'),
(91, 2, 'jrodriguez', '8c2ebfd486ace8f01915d78fa8d3bf53', 'Juan Carlos ', 'Rodriguez Lopez', '79562880', '76198105', '3132960693', 'li1.pncav@serticsas.com.co', 1, '2014-07-11'),
(92, 2, 'lgomez', '613eface325a38fb47121fabbdb4f557', 'Luis Alejandro', 'Gomez Rozo', '80039877', '20005071', '3142874394', 'asa2.pncav@serticsas.com.co', 1, '2014-05-16'),
(93, 2, 'hcolobon', 'a91b17392e4fc0ce38f19d5e439956e2', 'Hildegard', 'Colobon', '60358304', '48080800', '3134567893', 'li2.pncav@serticsas.com.co', 1, '2014-07-18'),
(94, 1, 'Sertic S.A.S.', '8b4f978328def7f01f5cf2433b471d47', 'SERTIC', 'S.A.S', '45896741', '68598748', '3143568952', 'dti.pncav@serticsas.com.co', 1, '2014-07-09'),
(95, 2, 'fromero', '1cff0f05de9d181a4f45bb0d18b70592', 'FABIO', 'ROMERO', '5555555', '26587987', '3125478974', 'aoc.pncav@serticsas.com', 1, '2014-07-10');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `utilidades`
--

CREATE TABLE IF NOT EXISTS `utilidades` (
  `id_utilidad` varchar(11) NOT NULL COMMENT 'Corresponde al Id unico de cada una de las utilidades',
  `fecha_comuni` date NOT NULL COMMENT 'Corresponde a la fecha del comunicado',
  `ano_vigencia` int(4) NOT NULL,
  `doc_soporte_comuni` varchar(50) NOT NULL COMMENT 'Hace referencia al documento soporte del comunicado',
  `porcen_utiliacion` float(5,2) NOT NULL COMMENT 'Indica el porcentaje de utilizacion aprobado',
  `uti_aprobada` bigint(20) NOT NULL COMMENT 'Indica la utilidad aprobada',
  `fecha_comi_fidu` date NOT NULL COMMENT 'Corresponde a la fecha de comite fiduciario',
  `num_comi_fidu` bigint(10) NOT NULL COMMENT 'Indica el numero del comité fiduciario',
  `doc_soporte_act` varchar(400) NOT NULL COMMENT 'Hace referencia al documento soporte acta',
  `comen_utilidades` varchar(400) NOT NULL COMMENT 'Corresponde a los comentarios del comunicado',
  PRIMARY KEY (`id_utilidad`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_ibfk_1` FOREIGN KEY (`Id_Tipo`) REFERENCES `actividades_tipo` (`Id_Tipo`);

--
-- Filtros para la tabla `compromiso`
--
ALTER TABLE `compromiso`
  ADD CONSTRAINT `fk_compromiso_compromiso_estado` FOREIGN KEY (`ces_id`) REFERENCES `compromiso_estado` (`ces_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compromiso_documento` FOREIGN KEY (`doc_id`) REFERENCES `documento` (`doc_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_compromiso_operador` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `compromiso_responsable`
--
ALTER TABLE `compromiso_responsable`
  ADD CONSTRAINT `fk_compromiso_responsable_compromiso` FOREIGN KEY (`com_id`) REFERENCES `compromiso` (`com_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_compromiso_responsable_usuario` FOREIGN KEY (`usu_id`) REFERENCES `usuario` (`usu_id`);

--
-- Filtros para la tabla `cuentas_financiero`
--
ALTER TABLE `cuentas_financiero`
  ADD CONSTRAINT `fk_cuentas_tipo` FOREIGN KEY (`cft_id`) REFERENCES `cuentas_financiero_tipo` (`cft_id`);

--
-- Filtros para la tabla `departamento`
--
ALTER TABLE `departamento`
  ADD CONSTRAINT `departamento_ibfk_1` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`),
  ADD CONSTRAINT `departamento_ibfk_2` FOREIGN KEY (`der_id`) REFERENCES `departamento_region` (`der_id`);

--
-- Filtros para la tabla `documento`
--
ALTER TABLE `documento`
  ADD CONSTRAINT `documento_ibfk_2` FOREIGN KEY (`dos_id`) REFERENCES `documento_subtema` (`dos_id`),
  ADD CONSTRAINT `documento_ibfk_3` FOREIGN KEY (`doe_id`) REFERENCES `documento_estado` (`doe_id`),
  ADD CONSTRAINT `fk_documento_documento_tema` FOREIGN KEY (`dot_id`) REFERENCES `documento_tema` (`dot_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_documento_tipo` FOREIGN KEY (`dti_id`) REFERENCES `documento_tipo` (`dti_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_documento_operador` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `documento_actor`
--
ALTER TABLE `documento_actor`
  ADD CONSTRAINT `documento_actor_ibfk_1` FOREIGN KEY (`ope_id`) REFERENCES `operador` (`ope_id`),
  ADD CONSTRAINT `documento_actor_ibfk_2` FOREIGN KEY (`dta_id`) REFERENCES `documento_tipo_actor` (`dta_id`);

--
-- Filtros para la tabla `documento_comunicado`
--
ALTER TABLE `documento_comunicado`
  ADD CONSTRAINT `documento_comunicado_ibfk_1` FOREIGN KEY (`dti_id`) REFERENCES `documento_tipo` (`dti_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_2` FOREIGN KEY (`dot_id`) REFERENCES `documento_tema` (`dot_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_3` FOREIGN KEY (`dos_id`) REFERENCES `documento_subtema` (`dos_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_4` FOREIGN KEY (`doa_id_autor`) REFERENCES `documento_actor` (`doa_id`),
  ADD CONSTRAINT `documento_comunicado_ibfk_5` FOREIGN KEY (`doa_id_dest`) REFERENCES `documento_actor` (`doa_id`);

--
-- Filtros para la tabla `documento_subtema`
--
ALTER TABLE `documento_subtema`
  ADD CONSTRAINT `FK_SUBTEMA_DOCUMENTO_TEMA` FOREIGN KEY (`dot_id`) REFERENCES `documento_tema` (`dot_id`);

--
-- Filtros para la tabla `documento_tema`
--
ALTER TABLE `documento_tema`
  ADD CONSTRAINT `FK_TEMA_DOCUMENTO_TIPO` FOREIGN KEY (`dti_id`) REFERENCES `documento_tipo` (`dti_id`);

--
-- Filtros para la tabla `eje`
--
ALTER TABLE `eje`
  ADD CONSTRAINT `fk_Eje_Instrumento1` FOREIGN KEY (`ins_id`) REFERENCES `instrumento` (`ins_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `extracto_financiero`
--
ALTER TABLE `extracto_financiero`
  ADD CONSTRAINT `fk_extracto_cuenta` FOREIGN KEY (`cfi_id`) REFERENCES `cuentas_financiero` (`cfi_id`);

--
-- Filtros para la tabla `instrumento`
--
ALTER TABLE `instrumento`
  ADD CONSTRAINT `FK_INSTRUMENTO_TIPO` FOREIGN KEY (`iti_id`) REFERENCES `instrumento_tipo` (`iti_id`);

--
-- Filtros para la tabla `instrumento_seccion`
--
ALTER TABLE `instrumento_seccion`
  ADD CONSTRAINT `FK_INSTRUMENTO_SECCION` FOREIGN KEY (`ins_id`) REFERENCES `instrumento` (`ins_id`);

--
-- Filtros para la tabla `municipio`
--
ALTER TABLE `municipio`
  ADD CONSTRAINT `FK_MUNICIPIO_DEPARTAMENTO` FOREIGN KEY (`dep_id`) REFERENCES `departamento` (`dep_id`);

--
-- Filtros para la tabla `opcion`
--
ALTER TABLE `opcion`
  ADD CONSTRAINT `FK_opcion_nivel` FOREIGN KEY (`opn_id`) REFERENCES `opcion_nivel` (`opn_id`);

--
-- Filtros para la tabla `ordenesdepago`
--
ALTER TABLE `ordenesdepago`
  ADD CONSTRAINT `ordenesdepago_ibfk_1` FOREIGN KEY (`Id_Tipo_Actividad`) REFERENCES `actividades_tipo` (`Id_Tipo`),
  ADD CONSTRAINT `ordenesdepago_ibfk_2` FOREIGN KEY (`Id_Actividad`) REFERENCES `actividades` (`Id_Actividad`),
  ADD CONSTRAINT `ordenesdepago_ibfk_3` FOREIGN KEY (`Id_Proveedor`) REFERENCES `proveedores` (`Id_Prove`),
  ADD CONSTRAINT `ordenesdepago_ibfk_4` FOREIGN KEY (`Id_Moneda_Orden`) REFERENCES `monedas` (`Id_Moneda`);

--
-- Filtros para la tabla `perfil_x_opcion`
--
ALTER TABLE `perfil_x_opcion`
  ADD CONSTRAINT `perfil_x_opcion_ibfk_1` FOREIGN KEY (`per_id`) REFERENCES `perfil` (`per_id`),
  ADD CONSTRAINT `perfil_x_opcion_ibfk_2` FOREIGN KEY (`opc_id`) REFERENCES `opcion` (`opc_id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `FK_usuario_perfil` FOREIGN KEY (`per_id`) REFERENCES `perfil` (`per_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
