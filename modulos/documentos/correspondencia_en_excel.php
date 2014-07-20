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
header("Content-Disposition: attachment; filename=comunicados.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CCorrespondenciaData.php');
require('../../clases/datos/CDocumentoData.php');

require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
// Incluimos el archivo de configuracion
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/correspondencia-es.php');

$html = new CHtml('');

$comData = new CCorrespondenciaData($db);
$docData = new CDocumentoData($db);


$operador = OPERADOR_DEFECTO;

$tipo = 1;
$area = $_REQUEST['sel_area'];
$referencia = $_REQUEST['txt_referencia'];
$operador = OPERADOR_DEFECTO;


$fecha_inicio = $_REQUEST['txt_fecha_inicio'];
$fecha_fin = $_REQUEST['txt_fecha_fin'];
$autor = $_REQUEST['sel_autor'];
//$subtema = $_REQUEST['sel_subtema'];
$destinatario = $_REQUEST['sel_destinatario'];
$codigo_referencia = $_REQUEST['txt_codigo_referencia_add'];
$palabras = $_REQUEST['txt_palabras'];

$criterio = "";
//-------------------------------criterios---------------------------
        if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
            if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (d.doc_fecha_radicado >= '" . $fecha_inicio . "')";
                } else {
                    $criterio .= " and d.doc_fecha_radicado >= '" . $fecha_inicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = " (d.doc_fecha_radicado between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                } else {
                    $criterio .= " and d.doc_fecha_radicado between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                }
            }
        }
        if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
            if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( d.doc_fecha_radicado <= '" . $fecha_fin . "')";
                } else {
                    $criterio .= " and d.doc_fecha_radicado <= '" . $fecha_fin . "')";
                }
            }
        }
        if (isset($autor) && $autor != -1 && $autor != '') {
            if ($criterio == "") {
                $criterio = " d.doa_id_autor = " . $autor;
            } else {
                $criterio .= " and d.doa_id_autor = " . $autor;
            }
        }

        //////////////////////////////
        if (isset($area) && $area != -1 && $area != '') {
            if ($criterio == "") {
                $criterio = " d.dot_id = " . $area;
            } else {
                $criterio .= " and d.dot_id = " . $area;
            }
        }
        //////////////////////////////////////////////
        if (isset($subtema) && $subtema != -1 && $subtema != '') {
            if ($criterio == "") {
                $criterio = " d.dos_id = " . $subtema;
            } else {
                $criterio .= " and d.dos_id = " . $subtema;
            }
        }
        
        if (isset($destinatario) && $destinatario != -1 && $destinatario != '') {
            if ($criterio == "") {
                $criterio = " d.doa_id_dest = " . $destinatario;
            } else {
                $criterio .= " and d.doa_id_dest = " . $destinatario;
            }
        }
        
        if (isset($codigo_referencia) && $codigo_referencia != '') {
            if ($criterio == "") {
                $criterio = " d.doc_codigo_ref = '" . $codigo_referencia. "'";
            } else {
                $criterio .= " and d.doc_codigo_ref = " . $codigo_referencia. "'";
            }
        }
        //-----------------------------------------------------------
        if(isset($palabras) & $palabras!=''){
            $claves = split(" ",$palabras);
            $criterio_temp = "";
            foreach ($claves as $c){
                if ($criterio_temp == "")
                    $criterio_temp .= " d.doc_descripcion like '%". $c ."%' ";
                else
                    $criterio_temp .= " or d.doc_descripcion like '%". $c ."%' ";
            }

            if($criterio == "")
                $criterio .= $criterio_temp;
            else
                $criterio .= " and (".$criterio_temp.") ";

        }
        //------------------------------------------------------------

        if ($criterio == "") {
            $criterio = " d.ope_id = " . CORRESPONDECIA_OPERADOR . " and d.dot_id > 3 ";
        }
        //////---------------------------------------------------
if ($criterio == "")
    $criterio = "1";
$dirOperador = $docData->getDirectorioOperador($operador);
$correspondencia = $comData->getCorrespondencia($criterio, 'doc_fecha_radicado');




//echo "<br>".$sql."<br>";
echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '12'><center></center></th></tr>";
echo"<tr><th colspan = '12' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(COMUNICADOS_REPORTE_EXCEL) . "</center></th></tr>";


//titulos
echo "<tr>";


echo "
        <th>" . $html->traducirTildes(CORRESPONDENCIA_AREA) . "</th>
	<th>" . $html->traducirTildes(CORRESPONDENCIA_SUBTEMA) . "</th>
	<th>" . $html->traducirTildes(CORRESPONDENCIA_AUTOR) . "</th>
        <th>" . $html->traducirTildes(CORRESPONDENCIA_DESTINATARIO) . "</th>
        <th>" . $html->traducirTildes(CORRESPONDENCIA_RESPONSABLE_RESPUESTA) . "</th>
        <th>" . $html->traducirTildes(CORRESPONDENCIA_DESCRIPCION) . "</th>
        <th>" . $html->traducirTildes(CORRESPONDENCIA_DOCUMENTO) . "</th>
        <th>" . $html->traducirTildes(CORRESPONDENCIA_ANEXOS) . "</th>
        <th>" . $html->traducirTildes(CORRESPONDENCIA_FECHA_RADICADO) . "</th>
        <th>" . $html->traducirTildes(CORRESPONDENCIA_FECHA_RESPUESTA) . "</th>
        <th>" . $html->traducirTildes(CORRESPONDECIA_CODIGO_REFERENCIA) . "</th>
        <th>" . $html->traducirTildes(CORRESPONDENCIA_REFERENCIA_RESPUESTA) . "</th>";
        //<th>" . $html->traducirTildes(CORRESPONDENCIA_ESTADO) . "</th>
echo "</tr>";
//datos 
$contador = 0;
$cont = count($correspondencia);
while ($contador < $cont) {
    echo "<tr>";
    echo "<td>" . $correspondencia[$contador]['area'] . "</td>
        <td>" . $correspondencia[$contador]['subtema'] . "</td>	
        <td>" . $correspondencia[$contador]['autor'] . "</td>		
        <td>" . $correspondencia[$contador]['destinatario'] . "</td>
        <td>" . $correspondencia[$contador]['responsableR'] . "</td>
        <td>" . $correspondencia[$contador]['descripcion'] . "</td>
        <td>" . $correspondencia[$contador]['soporte'] . "</td>
        <td>" . $correspondencia[$contador]['anexo'] . "</td>
        <td>" . $correspondencia[$contador]['fecha'] . "</td>
        <td>" . $correspondencia[$contador]['fechamax'] . "</td>
        <td>" . $correspondencia[$contador]['codigor'] . "</td>
        <td>" . $correspondencia[$contador]['referencia'] . "</td>";
    //   <td>" . $correspondencia[$contador]['estado'] . "</td>
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>	
