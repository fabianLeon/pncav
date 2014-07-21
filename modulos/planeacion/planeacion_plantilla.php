<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Plantilla_planeacion.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CPlaneacionData.php');
require_once '../../clases/aplicacion/CDataLog.php';
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
// Incluimos el archivo de configuracion
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/planeacion-es.php');

$html = new CHtml('');


$operador = OPERADOR_DEFECTO;

echo "<table width='80%' border='1' align='center'>";
echo "<tr>";
echo "<th>" . $html->traducirTildes(PLANEACION_CODIGO_EJE) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_MUNICIPIO) . "</th>
	<th>" . $html->traducirTildes(PLANEACION_EJE) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_NUMERO_ENCUESTAS) . "</th>        
        <th>" . $html->traducirTildes(PLANEACION_FECHA_INICIO) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_FECHA_FIN) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_USUARIO) ."</th>";
?>