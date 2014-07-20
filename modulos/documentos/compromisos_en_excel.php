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
header("Content-Disposition: attachment; filename=compromisos.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CCompromisoData.php');
require('../../clases/datos/CDocumentoData.php');
require('../../clases/datos/CCompromisoResponsableData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
// Incluimos el archivo de configuracion
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/compromisos-es.php');

$html = new CHtml('');

$comData = new CCompromisoData($db);
$docData = new CDocumentoData($db);
$resData = new CCompromisoResponsableData($db);

$operador = OPERADOR_DEFECTO;

$tipo = COMUNICADO_TIPO_CODIGO;
$tema = ACTA_TEMA_CODIGO;
$fecha_inicio = $_REQUEST['txt_fecha_inicio'];
$fecha_fin = $_REQUEST['txt_fecha_fin'];
//$acta = $_REQUEST['sel_acta'];
$responsable = $_REQUEST['sel_responsable'];
//$subtema = $_REQUEST['sel_subtema'];
$estado = $_REQUEST['sel_estado'];
$consecutivo = $_REQUEST['txt_consecutivo'];
$palabras = $_REQUEST['txt_palabras'];
$criterio_busqueda = $_REQUEST['txt_criterio'];

$criterio = "";
if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
    if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
        if ($criterio == "") {
            $criterio = " (c.com_fecha_limite >= '" . $fecha_inicio . "')";
        } else {
            $criterio .= " and c.com_fecha_limite >= '" . $fecha_inicio . "'";
        }
    } else {
        if ($criterio == "") {
            $criterio = "( c.com_fecha_limite between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        } else {
            $criterio .= " and c.com_fecha_limite between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        }
    }
}
if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
    if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
        if ($criterio == "") {
            $criterio = "( c.com_fecha_limite <= '" . $fecha_fin . "')";
        } else {
            $criterio .= " and c.com_fecha_limite <= '" . $fecha_fin . "')";
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
        if($estado == 1){
            $criterio = " ( c.com_fecha_limite >= '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
        }elseif ($estado == 3) {
            $criterio = " ( c.com_fecha_limite < '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
        }else{
            $criterio .= " c.ces_id = " . $estado;
        }
    else
        if($estado == 1){
            $criterio .= " and ( c.com_fecha_limite >= '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
        }elseif ($estado == 3) {
            $criterio .= " and ( c.com_fecha_limite < '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
        }else{
            $criterio .= " and c.ces_id = " . $estado;
        }

}
if (isset($actividad) && $actividad != -1 && $actividad != '') {
    if ($criterio == "")
        $criterio .= " c.com_actividad like '%" . $actividad . "%'";
    else
        $criterio .= " and c.com_actividad like '%" . $actividad . "%'";
}
if (isset($consecutivo) && $consecutivo != -1 && $consecutivo != '') {
    if ($criterio == "")
        $criterio .= " c.com_consecutivo = '" . $consecutivo . "'";
    else
        $criterio .= " and c.com_consecutivo = '" . $consecutivo . "'";
}
if(isset($palabras) & $palabras!=''){
    $claves = split(" ",$palabras);
    $criterio_temp = "";
    foreach ($claves as $c){
        if ($criterio_temp == "")
            $criterio_temp .= " com_actividad like '%". $c ."%' or com_observaciones like  '%". $c ."%' ";
        else
            $criterio_temp .= " or com_actividad like '%". $c ."%' or com_observaciones like  '%". $c ."%' ";
    }

    if($criterio == "")
        $criterio .= $criterio_temp;
    else
        $criterio .= " and (".$criterio_temp.") ";

}

if ($criterio != "")
    $criterio .= ' and d.ope_id = ' . $operador;
if ($criterio == "")
    $criterio = "1";
$dirOperador = $docData->getDirectorioOperador($operador);
$compromisos = $comData->getCompromisosToExcell($criterio, ' c.com_fecha_limite', $dirOperador);



//echo "<br>".$sql."<br>";
echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '9'><center></center></th></tr>";
echo"<tr><th colspan = '9' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(COMPROMISOS_REPORTE_EXCEL) . "</center></th></tr>";


//titulos
echo "<tr>";

echo "<th>" . $html->traducirTildes(COMPROMISOS_FUENTE) . "</th>
        <th>" . $html->traducirTildes(COMPROMISOS_ACTIVIDAD) . "</th>
	<th>" . $html->traducirTildes(COMPROMISOS_FECHA_ENTREGA) . "</th>
	<th>" . $html->traducirTildes(COMPROMISOS_RESPONSABLE) . "</th>
        <th>" . $html->traducirTildes(COMPROMISOS_CONSECUTIVO) . "</th>
	<th>" . $html->traducirTildes(COMPROMISOS_REFERENCIA) . "</th>
        <th>" . $html->traducirTildes(COMPROMISOS_FECHA_LIMITE) . "</th>
        <th>" . $html->traducirTildes(COMPROMISOS_ESTADO) . "</th>
	<th>" . $html->traducirTildes(COMPROMISOS_OBSERVACIONES) . "</th>";
echo "</tr>";
//datos 
$cont = 0;
$contador = count($compromisos);
//-----------------------------------------------------------------------------------------
$cont = 0;
$elementos = null;
while ($cont < $contador) {
    //$elementos[$cont]['id'] = $compromisos[$cont]['id'];
    $elementos[$cont]['area'] = $compromisos[$cont]['dos_nombre'];
    $elementos[$cont]['actividad'] = $compromisos[$cont]['com_actividad'];
    $elementos[$cont]['fecha_entrega'] = $compromisos[$cont]['com_fecha_entrega'];
    $elementos[$cont]['autor'] = $compromisos[$cont]['doa_nombre'];
    $elementos[$cont]['consecutivo'] = $compromisos[$cont]['com_consecutivo'];
    $elementos[$cont]['referencia'] = $compromisos[$cont]['doc_referencia'];
    $elementos[$cont]['fecha_limite'] = $compromisos[$cont]['com_fecha_limite'];

    //$elementos[$cont]['estado'] = $compromisos[$cont]['ces_nombre'];

    if($compromisos[$cont]['ces_id']==2){
       $elementos[$cont]['estado']=COMPROMISOS_VERDE;
    }
    if($compromisos[$cont]['ces_id']==3){
       $elementos[$cont]['estado']=COMPROMISOS_ROJO;
    }
    if($compromisos[$cont]['ces_id']==1 || $compromisos[$cont]['ces_id']==3){
        $datetime1 = new DateTime("now");
        $datetime2 = new DateTime($compromisos[$cont]['com_fecha_limite']);
        $interval = $datetime1->diff($datetime2);
        $dias = $interval->days+1;
        if(($datetime1 <= $datetime2))
            //$elementos[$cont]['estado']="<img src='templates/img/ico/amarillo.gif'> ".$interval->format('%d días');
            $elementos[$cont]['estado']=COMPROMISOS_AMARILLO." ".$dias;
        else
            $elementos[$cont]['estado']=COMPROMISOS_ROJO." ".$dias;
    }

    $elementos[$cont]['observaciones'] = $compromisos[$cont]['com_observaciones'];
    $cont++;
}
//-----------------------------------------------------------------------------------------

$cont = 0;
$contador = count($compromisos);

while ($cont < $contador) {
    echo "<tr>";
    echo "<td>" . $elementos[$cont]['area'] . "</td>
        <td>" . $elementos[$cont]['actividad'] . "</td>
        <td>" . $elementos[$cont]['fecha_entrega'] . "</td>		
        <td>" . $elementos[$cont]['autor'] . "</td>
        <td>" . $elementos[$cont]['consecutivo'] . "</td>
        <td>" . $elementos[$cont]['referencia'] . "</td>
        <td>" . $elementos[$cont]['fecha_limite'] . "</td>
        <td>" . $elementos[$cont]['estado'] . "</td>
        <td>" . $elementos[$cont]['observaciones'] . "</td>";
    echo "</tr>";
    $cont++;
}
echo "</table>";
?>	
