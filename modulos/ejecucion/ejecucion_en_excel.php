<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte_ejecucion.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);

require('../../clases/datos/CEjecucionData.php');
require('../../clases/datos/CPlaneacionData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
// Incluimos el archivo de configuracion
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/planeacion-es.php');
require('../../lang/es-co/ejecucion-es.php');

$html = new CHtml('');

$ejeData = new CEjecucionData($db);
$planData = new CPlaneacionData($db);
$operador = OPERADOR_DEFECTO;



$pla_id = $_REQUEST['txt_pla_id'];
$region = $_REQUEST['txt_region'];
$departamento = $_REQUEST['txt_departamento'];
$municipio = $_REQUEST['txt_municipio'];
$estado = $_REQUEST['txt_estado'];
$consecutivo_encuesta = $_REQUEST['txt_consecutivo_encuesta'];
$eje = $_REQUEST['txt_eje'];
$criterio = $_REQUEST['txt_criterio'];
//-------------------------------criterios---------------------------
$criterio = "";

if (isset($pla_id) && $pla_id != "") {
    if ($criterio == "") {
        $criterio = " (p.pla_id LIKE '%" . $pla_id . "%')";
    } else {
        $criterio .= " and (p.pla_id LIKE '%" . $pla_id . "%')";
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
if (isset($estado) && $estado != -1 && $estado != '') {
    if ($criterio == "") {
        $criterio = " p.ees_id = " . $estado;
    } else {
        $criterio .= " and p.ees_id = " . $estado;
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


echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '12'><center></center></th></tr>";
echo"<tr><th colspan = '12' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(EJECUCION_REPORTE_EXCEL) . "</center></th></tr>";

//titulos
echo "<tr>";
echo "<th>" . $html->traducirTildes('No') . "</th>
	<th>" . $html->traducirTildes(PLANEACION_REGION) . "</th>
	<th>" . $html->traducirTildes(PLANEACION_DEPARTAMENTO) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_MUNICIPIO) . "</th>    
        <th>" . $html->traducirTildes(PLANEACION_EJE) . "</th>  
        <th>" . $html->traducirTildes(PLANEACION_NUMERO_ENCUESTAS) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_TIPO_ENCUESTADO) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_FECHA_INICIO) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_FECHA_FIN) . "</th>
        <th>" . $html->traducirTildes(PLANEACION_USUARIO) . "</th>
        <th>" . $html->traducirTildes(EJECUCION_ESTADO) . "</th>            
        <th>" . $html->traducirTildes(EJECUCION_PORCENTAJE) . "</th>";
echo "</tr>";
//datos 
$contador = 0;
$ejecuciones = $planData->getPlaneacionVerEjecucion($criterio,true);
$cont = count($ejecuciones);

while ($contador < $cont) {
    $temp = $contador + 1;
    echo "<tr>";
    echo "<td>" . $temp . "</td>	
        <td>" . $ejecuciones[$contador]['der_nombre'] . "</td>		
        <td>" . $ejecuciones[$contador]['dep_nombre'] . "</td>
        <td>" . $ejecuciones[$contador]['mun_nombre'] . "</td>
        <td>" . $ejecuciones[$contador]['eje_nombre'] . "</td>
        <td>" . $ejecuciones[$contador]['numero_encuestas'] . "</td>
        <td>" . $ejecuciones[$contador]['ins_nombre'] . "</td>
        <td>" . $ejecuciones[$contador]['pla_fecha_inicio'] . "</td>
        <td>" . $ejecuciones[$contador]['pla_fecha_fin'] . "</td>
        <td>" . $ejecuciones[$contador]['usu_nombre'] . "</td>
        <td>" . $ejecuciones[$contador]['ees_nombre'] . "</td>
        <td>" . $html->traducirTildes($ejecuciones[$contador]['porcentaje_ejecucion']) . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";


//Inicio tabla resumen
$resumen_ejecucion = $ejeData->getResumenEjecucion($criterio, true);
echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '2'><center></center></th></tr>";
echo"<tr><th colspan = '2' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(EJECUCION_RESUMEN_REPORTE_EXCEL) . "</center></th></tr>";

//Filas
echo "<tr>";
echo "<th>" . $html->traducirTildes(EJECUCION_N_PVD) . "</td>		
        <td>" . $resumen_ejecucion[0] . "</th>";
echo "</tr>";
echo "<tr>";
echo "<th>" . $html->traducirTildes(EJECUCION_N_KVD) . "</td>		
        <td>" . $resumen_ejecucion[1] . "</th>";
echo "</tr>";
echo "<tr>";
echo "<th>" . $html->traducirTildes(EJECUCION_N_IP) . "</td>		
        <td>" . $resumen_ejecucion[2] . "</th>";
echo "</tr>";
echo "<tr>";
echo "<th>" . $html->traducirTildes(EJECUCUION_N_BA) . "</td>		
        <td>" . $resumen_ejecucion[3] . "</th>";
echo "</tr>";
echo "<tr>";
echo "<th>" . $html->traducirTildes(EJECUCION_N_WIFI) . "</td>		
        <td>" . $resumen_ejecucion[4] . "</th>";
echo "</tr>";
echo "<th>" . $html->traducirTildes(EJECUCION_PORCENTAJE) . "</td>		
        <td>" . $resumen_ejecucion[5] . "</th>";
echo "</tr>";
echo "</table>";
?>
