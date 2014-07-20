<?php

/**
 * 
 *
 * <ul>
 * <li> Redcom Ltda <www.redcom.com.co></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */
/**
 * Modulo Documental
 * maneja el modulo DOCUMENTAL/Alarmas_en_excel en union con CDocumento y CDocumentoData
 *
 * @see CDocumento
 * @see CDocumentoData
 *
 * @package  modulos
 * @subpackage documental
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=recomendaciones.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CRecomendacionesData.php');
require('../../clases/datos/CDocumentoData.php');
require('../../clases/datos/CRecomendacionesResponsableData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
// Incluimos el archivo de configuracion
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/recomendaciones-es.php');

$html = new CHtml('');

$comData = new CRecomendacionesData($db);
$docData = new CDocumentoData($db);
$resData = new CRecomendacionesResponsableData($db);

$operador = OPERADOR_DEFECTO;

$tipo = COMUNICADO_TIPO_CODIGO;
$tema = ACTA_TEMA_CODIGO;
if (isset($_REQUEST['sel_subtema']) && $_REQUEST['sel_subtema'] != '') 
    $subtema = $_REQUEST['sel_subtema'];
if (isset($_REQUEST['sel_responsable']) && $_REQUEST['sel_responsable'] != '') 
    $responsable = $_REQUEST['sel_responsable'];
if (isset($_REQUEST['txt_actividad']) && $_REQUEST['txt_actividad'] != '') 
    $actividad = $_REQUEST['txt_actividad'];
if (isset($_REQUEST['txt_fecha_inicio']) && $_REQUEST['txt_fecha_inicio'] != '') 
    $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
if (isset($_REQUEST['txt_fecha_fin']) && $_REQUEST['txt_fecha_fin'] != '')     
    $fecha_fin = $_REQUEST['txt_fecha_fin'];        
if (isset($_REQUEST['sel_estado']) && $_REQUEST['sel_estado'] != '') 
    $estado = $_REQUEST['sel_estado'];


$criterio = "";
if (isset($subtema) && $subtema != -1 && $subtema != "") {
    if ($criterio == '')
        $criterio = " c.doc_id = " . $subtema;
    else
        $criterio .= " and c.doc_id = " . $subtema;;
}
 if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
    if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
        if ($criterio == "") {
            $criterio = " (c.com_fecha_entrega >= '" . $fecha_inicio . "')";
        } else {
            $criterio .= " and c.com_fecha_entrega >= '" . $fecha_inicio . "'";
        }
    } else {
        if ($criterio == "") {
            $criterio = "( c.com_fecha_entrega between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        } else {
            $criterio .= " and c.com_fecha_entrega between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        }
    }
}
if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
    if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
        if ($criterio == "") {
            $criterio = "( c.com_fecha_entrega <= '" . $fecha_fin . "')";
        } else {
            $criterio .= " and c.com_fecha_entrega <= '" . $fecha_fin . "')";
        }
    }
}
if (isset($responsable) && $responsable != -1 && $responsable != "") {
    if ($criterio == '')
        $criterio = " cr.usu_id = " . $responsable;
    else
        $criterio .= " and cr.usu_id = " . $responsable;
}
if (isset($estado) && $estado != -1 && $estado != '') {
    if ($criterio == "")
        $criterio .= " c.ces_id = " . $estado;
    else
        $criterio .= " and c.ces_id = " . $estado;
}
if (isset($actividad) && $actividad != -1 && $actividad != '') {
    if ($criterio == "")
        $criterio .= " c.com_actividad like '%" . $actividad . "%'";
    else
        $criterio .= " and c.com_actividad like '%" . $actividad . "%'";
}

if($criterio == "")
    $criterio = "1";


$dirOperador = $docData->getDirectorioOperador($operador);
$compromisos = $comData->getCompromisosToExcell($criterio, ' c.com_fecha_limite', $dirOperador);



//echo "<br>".$sql."<br>";
echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '6'><center></center></th></tr>";
echo"<tr><th colspan = '6' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(RECOMENDACIONES_REPORTE_EXCEL) . "</center></th></tr>";


//titulos
echo "<tr>";

echo "<th>" . $html->traducirTildes(RECOMENDACIONES_FUENTE) . "</th>
        <th>" . $html->traducirTildes(RECOMENDACIONES_RESPONSABLE) . "</th>
        <th>" . $html->traducirTildes(RECOMENDACIONES_ACTIVIDAD) . "</th>
	<th>" . $html->traducirTildes(RECOMENDACIONES_FECHA_ENTREGA) . "</th>
        <th>" . $html->traducirTildes(RECOMENDACIONES_ESTADO) . "</th>
	<th>" . $html->traducirTildes(RECOMENDACIONES_OBSERVACIONES) . "</th>";
echo "</tr>";
//datos 
$contador = 0;
$cont = count($compromisos);
while ($contador < $cont) {
    echo "<tr>";
    echo "<td>" . $compromisos[$contador]['dos_nombre'] . "</td>
        <td>" . $compromisos[$contador]['doa_nombre'] . "</td>
        <td>" . $compromisos[$contador]['com_actividad'] . "</td>
        <td>" . $compromisos[$contador]['com_fecha_entrega'] . "</td>		
        <td>" . $compromisos[$contador]['ces_nombre'] . "</td>
        <td>" . $compromisos[$contador]['com_observaciones'] . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>	
