<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte_Actividad_PIA.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);

require('../../clases/datos/CActividadPIAData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
// Incluimos el archivo de configuracion
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/actividadPIA-es.php');

$html = new CHtml('');
$operador = OPERADOR_DEFECTO;
$actData = new CActividadPIAData($db);



//Variables
$id_act = $_REQUEST['txt_id'];
$descripcion = $_REQUEST['txt_descripcion'];
$monto = $_REQUEST['txt_monto'];


//-------------------------------criterios---------------------------
$criterio = "";
if (isset($descripcion) && $descripcion != "") {
    if ($criterio == "") {
        $criterio = " (act.act_descripcion LIKE '%" . $descripcion . "%')";
    } else {
        $criterio .= " and (act.act_descripcion LIKE '%" . $descripcion . "%')";
    }
}
if (isset($monto) && $monto != '') {
    if ($criterio == "") {
        $criterio = " act.act_monto = " . $monto;
    } else {
        $criterio .= " and act.act_monto = " . $monto;
    }
}
if ($criterio == "") {
    $criterio = " 1";
}



echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '3'><center></center></th></tr>";
echo"<tr><th colspan = '3' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(ACTIVIDADES_REPORTE_EXCEL) . "</center></th></tr>";

//titulos
echo "<tr>";
echo "<th>" . $html->traducirTildes('No') . "</th>
        <th>" . $html->traducirTildes(ACTIVIDADES_DESCRIPCION) . "</th>
	<th>" . $html->traducirTildes(ACTIVIDADES_MONTO) . "</th>";
echo "</tr>";
//datos 
$contador = 0;
$actividades = $actData->getActividadPIA($criterio);
$cont = count($actividades);

while ($contador < $cont) {
    $temp = $contador + 1;
    echo "<tr>";
    echo "<td>" . $temp . "</td>
        <td>" . $actividades[$contador]['descripcion'] . "</td>	
        <td>" . $actividades[$contador]['monto'] . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>
