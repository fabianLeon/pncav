<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte_Registro_Inversion.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);

require('../../clases/datos/CRegistroInversionData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
// Incluimos el archivo de configuracion
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/registroInversion-es.php');

$html = new CHtml('');
$operador = OPERADOR_DEFECTO;
$rinData = new CRegistroInversionData($db);

$fecha_inicio = $_REQUEST['txt_fecha_inicio'];
$fecha_fin = $_REQUEST['txt_fecha_fin'];
$actividad = $_REQUEST['txt_actividad'];
$proveedor = $_REQUEST['txt_proveedor'];
//-------------------------------criterios---------------------------
$criterio = "";
if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
    if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
        if ($criterio == "") {
            $criterio = " (rin.rin_fecha >= '" . $fecha_inicio . "')";
        } else {
            $criterio .= " and rin.rin_fecha >= '" . $fecha_inicio . "'";
        }
    } else {
        if ($criterio == "") {
            $criterio = "( rin.rin_fecha between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        } else {
            $criterio .= " and rin.rin_fecha between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        }
    }
}
if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
    if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
        if ($criterio == "") {
            $criterio = "( rin.rin_fecha <= '" . $fecha_fin . "')";
        } else {
            $criterio .= " and rin.rin_fecha <= '" . $fecha_fin . "')";
        }
    }
}
if (isset($actividad) && $actividad != -1 && $actividad != '') {
    if ($criterio == "") {
        $criterio = "  rin.act_id = " . $actividad;
    } else {
        $criterio .= " and rin.act_id = " . $actividad;
    }
}
if (isset($proveedor) && $proveedor != -1 && $proveedor != '') {
    if ($criterio == "") {
        $criterio = " rin.id_prove = " . $proveedor;
    } else {
        $criterio .= " and rin.id_prove = " . $proveedor;
    }
}
if ($criterio == "") {
    $criterio = "1";
}

echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '8'><center></center></th></tr>";
echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(REGISTRO_INVERSION_REPORTE_EXCEL) . "</center></th></tr>";
            
//titulos
echo "<tr>";
echo "<th>" . $html->traducirTildes('No') . "</th>
        <th>" . $html->traducirTildes(REGISTRO_INVERSION_ACTIVIDAD) . "</th>
        <th>" . $html->traducirTildes(REGISTRO_INVERSION_FECHA) . "</th>
        <th>" . $html->traducirTildes(REGISTRO_INVERSION_PROVEEDOR) . "</th>
        <th>" . $html->traducirTildes(REGISTRO_INVERSION_NUMERO_DOCUMENTO) . "</th>
        <th>" . $html->traducirTildes(REGISTRO_INVERSION_VALOR) . "</th>
        <th>" . $html->traducirTildes(REGISTRO_INVERSION_OBSERVACIONES) . "</th>
        <th>" . $html->traducirTildes(REGISTRO_INVERSION_DOCUMENTO_SOPORTE) . "</th>";
echo "</tr>";


//datos 
$contador = 0;
$registroInversion = $rinData->getRegistroInversion($criterio);
$cont = count($registroInversion);

while ($contador < $cont) {
    $temp = $contador + 1;
    echo "<tr>";
    echo "<td>" . $temp . "</td>
        <td>" . $registroInversion[$contador]['actividad'] . "</td>
        <td>" . $registroInversion[$contador]['fecha'] . "</td>
        <td>" . $registroInversion[$contador]['proveedor'] . "</td>
        <td>" . $registroInversion[$contador]['numero_documento'] . "</td>
        <td>" . $registroInversion[$contador]['valor'] . "</td>
        <td>" . $registroInversion[$contador]['observaciones'] . "</td>
        <td>" . $registroInversion[$contador]['documento_soporte'] . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>