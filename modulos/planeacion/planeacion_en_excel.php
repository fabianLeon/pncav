<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte_planeacion.xls");

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

$planData = new CPlaneacionData($db);

$operador = OPERADOR_DEFECTO;



//Variables
$codigo_eje = $_REQUEST['txt_codigo_eje'];
$region = $_REQUEST['txt_region'];
$departamento = $_REQUEST['txt_departamento'];
$municipio = $_REQUEST['txt_municipio'];
$eje = $_REQUEST['txt_eje'];
$criterio = $_REQUEST['txt_criterio'];
$numero_encuestas = $_REQUEST['txt_numero_encuestas'];
$fecha_inicio = $_REQUEST['txt_fecha_inicio'];
$fecha_fin = $_REQUEST['txt_fecha_fin'];
$usuario = $_REQUEST['txt_usuario'];
//-------------------------------criterios---------------------------
$criterio = "";
if (isset($usuario) && $usuario != -1 && $usuario != '') {
    if ($criterio == "") {
        $criterio = " p.usu_id = " . $usuario;
    } else {
        $criterio .= " and p.usu_id = " . $usuario;
    }
}
if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {

    if ($criterio == "") {
        $criterio = " (p.pla_fecha_inicio = '" . $fecha_inicio . "')";
    } else {
        $criterio .= " and p.pla_fecha_inicio = '" . $fecha_inicio . "'";
    }
}

if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
    if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
        if ($criterio == "") {
            $criterio = "( p.pla_fecha_fin = '" . $fecha_fin . "')";
        } else {
            $criterio .= " and p.pla_fecha_fin = '" . $fecha_fin . "')";
        }
    }
}
if (isset($codigo_eje) && $codigo_eje != "") {
    if ($criterio == "") {
        $criterio = " (p.pla_codigo_eje LIKE '%" . $codigo_eje . "%')";
    } else {
        $criterio .= " and (d.doc_descripcion LIKE '%" . $codigo_eje . "%')";
    }
}
if (isset($region) && $region != -1 && $region != '') {
    if ($criterio == "") {
        $criterio = " d.der_id = " . $region;
    } else {
        $criterio .= " and d.der_id = " . $region;
    }
}
if (isset($departamento) && $departamento != -1 && $departamento != '') {
    if ($criterio == "") {
        $criterio = " d.dep_id = " . $departamento;
    } else {
        $criterio .= " and d.dep_id = " . $departamento;
    }
}
if (isset($municipio) && $municipio != -1 && $municipio != '') {
    if ($criterio == "") {
        $criterio = " p.mun_id = " . $municipio;
    } else {
        $criterio .= " and p.mun_id = " . $municipio;
    }
}
if (isset($eje) && $eje != -1 && $eje != '') {
    if ($criterio == "") {
        $criterio = " p.eje_id = " . $eje;
    } else {
        $criterio .= " and p.eje_id = " . $eje;
    }
}
if ($criterio == "") {
    $criterio = " 1";
}

$planeaciones = $planData->getPlaneacion($criterio, 'pla_id');

echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '9'><center></center></th></tr>";
echo"<tr><th colspan = '9' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(PLANEACION_REPORTE_EXCEL) . "</center></th></tr>";

//titulos
echo "<tr>";
echo "<th>" . $html->traducirTildes(PLANEACION_CODIGO_EJE) . "</th>
	<th>" . $html->traducirTildes(PLANEACION_DEPARTAMENTO) . "</th>
	<th>" . $html->traducirTildes(PLANEACION_MUNICIPIO) . "</th>
	<th>" . $html->traducirTildes(PLANEACION_EJE) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_NUMERO_ENCUESTAS) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_TIPO_ENCUESTADO) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_FECHA_INICIO) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_FECHA_FIN) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_USUARIO) . "</th>";
echo "</tr>";
//datos 
$contador = 0;
$cont = count($planeaciones);

while ($contador < $cont) {
    echo "<tr>";
    echo "<td>" . $planeaciones[$contador]['codigo_eje'] . "</td>	
        <td>" . $planeaciones[$contador]['dep_nombre'] . "</td>		
        <td>" . $planeaciones[$contador]['mun_nombre'] . "</td>
        <td>" . $planeaciones[$contador]['eje_nombre'] . "</td>
        <td>" . $planeaciones[$contador]['numero_encuestas'] . "</td>
        <td>" . $planeaciones[$contador]['ten_nombre'] . "</td>
        <td>" . $planeaciones[$contador]['pla_fecha_inicio'] . "</td>
        <td>" . $planeaciones[$contador]['pla_fecha_fin'] . "</td>        
        <td>" . $planeaciones[$contador]['usu_nombre'] . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";


//Inicio tabla resumen
$resumen_planeacion = $planData->getResumen($criterio);
echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '2'><center></center></th></tr>";
echo"<tr><th colspan = '2' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(PLANEACION_RESUMEN_REPORTE_EXCEL) . "</center></th></tr>";

//Filas
echo "<tr>";
echo "<th>" . $html->traducirTildes(PLANEACION_PVD) . "</td>		
        <td>" . $resumen_planeacion[0] . "</th>";
echo "</tr>";
echo "<tr>";
echo "<th>" . $html->traducirTildes(PLANEACION_KVD) . "</td>		
        <td>" . $resumen_planeacion[1] . "</th>";
echo "</tr>";
echo "<tr>";
echo "<th>" . $html->traducirTildes(PLANEACION_IP) . "</td>		
        <td>" . $resumen_planeacion[2] . "</th>";
echo "</tr>";
echo "<tr>";
echo "<th>" . $html->traducirTildes(PLANEACION_BA) . "</td>		
        <td>" . $resumen_planeacion[3] . "</th>";
echo "</tr>";
echo "<tr>";
echo "<th>" . $html->traducirTildes(PLANEACION_WIFI) . "</td>		
        <td>" . $resumen_planeacion[4] . "</th>";
echo "</tr>";
echo "<th>" . $html->traducirTildes(PLANEACION_TOTAL_ENCUESTAS) . "</td>		
        <td>" . $resumen_planeacion[5] . "</th>";
echo "</tr>";
echo "</table>";
?>
