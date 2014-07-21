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
 * maneja el modulo DOCUMENTAL/Actas_en_excel en union con CDocumento y CDocumentoData
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
header("Content-Disposition: attachment; filename=Reporte_actas.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);

require('../../clases/datos/CDocumentoData.php');
require('../../clases/datos/CActaData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
// Incluimos el archivo de configuracion
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/actas-es.php');

$html = new CHtml('');

$du = new CDocumentoData($db);
$actaData = new CActaData($db);

$operador = OPERADOR_DEFECTO;

$fecha_inicio = $_REQUEST['txt_fecha_inicio'];
$fecha_fin = $_REQUEST['txt_fecha_fin'];
$subtema = $_REQUEST['sel_subtema'];
$descripcion = $_REQUEST['txt_descripcion'];
$criterio_busqueda = $_REQUEST['txt_criterio'];
//-------------------------------criterios---------------------------
$criterio = "";
if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
    if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
        if ($criterio == "") {
            $criterio = " (d.doc_fecha >= '" . $fecha_inicio . "')";
        } else {
            $criterio .= " and d.doc_fecha >= '" . $fecha_inicio . "'";
        }
    } else {
        if ($criterio == "") {
            $criterio = "( d.doc_fecha between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        } else {
            $criterio .= " and d.doc_fecha between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        }
    }
}
if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
    if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
        if ($criterio == "") {
            $criterio = "( d.doc_fecha <= '" . $fecha_fin . "')";
        } else {
            $criterio .= " and d.doc_fecha <= '" . $fecha_fin . "')";
        }
    }
}

if (isset($subtema) && $subtema != -1 && $subtema != '') {
    if ($criterio == "") {
        $criterio = " d.dos_id = " . $subtema;
    } else {
        $criterio .= " and d.dos_id = " . $subtema;
    }
}

if (isset($descripcion) && $descripcion != "") {
    if ($criterio == "") {
        $criterio = " (d.doc_descripcion LIKE '%" . $descripcion .
                "%' or d.doc_archivo LIKE '%" . $descripcion . "%')";
    } else {
        $criterio .= " and (d.doc_descripcion LIKE '%" . $descripcion .
                "%' or d.doc_archivo LIKE '%" . $descripcion . "%')";
    }
}
if ($criterio == "") {
    $criterio = " d.dot_id = " . ID_ACTAS;
}
if ($criterio != "")
    $criterio .= ' and d.ope_id = ' . $operador;
if ($criterio == "" && $criterio_busqueda == "1")
    $criterio = "1";

$dirOperador = $du->getDirectorioOperador($operador);
$actas = $actaData->getActas($criterio, 'asc', $dirOperador);



//echo "<br>".$sql."<br>";
echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '4'><center></center></th></tr>";
echo"<tr><th colspan = '4' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(ACTAS_REPORTE_EXCEL) . "</center></th></tr>";

//titulos
echo "<tr>";
echo "<th>" . $html->traducirTildes(ACTA_SUBTEMA) . "</th>
	<th>" . $html->traducirTildes(ACTA_DESCRIPCION) . "</th>
	<th>" . $html->traducirTildes(ACTA_DOCUMENTO) . "</th>
	<th>" . $html->traducirTildes(ACTA_FECHA) . "</th>";
echo "</tr>";
//datos 
$contador = 0;
$cont = count($actas);

while ($contador < $cont) {
    echo "<tr>";
    echo "<td>" . $actas[$contador]['subtema'] . "</td>	
        <td>" . $actas[$contador]['descripcion'] . "</td>		
        <td>" . $actas[$contador]['nombre'] . "</td>
        <td>" . $actas[$contador]['fecha'] . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>		