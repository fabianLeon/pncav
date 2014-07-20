<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Informes_Financieros.xls");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
header("Pragma: public");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);

require('../../clases/datos/CInformeFinancieroData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
// Incluimos el archivo de configuracion
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/informeFinanciero-es.php');

$html = new CHtml('');
$operador = OPERADOR_DEFECTO;
$ifiData = new CInformeFinancieroData($db);
//Variables
$fecha_inicio = $_REQUEST['txt_fecha_inicio'];
$fecha_fin = $_REQUEST['txt_fecha_fin'];
$numero_factura = $_REQUEST['txt_numero_factura'];
$numero_radicado_ministerio = $_REQUEST['txt_numero_radicado_ministerio'];
//-------------------------------criterios---------------------------
$criterio = "";
if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
    if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
        if ($criterio == "") {
            $criterio = " (ifi_fecha_factura >= '" . $fecha_inicio . "')";
        } else {
            $criterio .= " and ifi_fecha_factura >= '" . $fecha_inicio . "'";
        }
    } else {
        if ($criterio == "") {
            $criterio = "( ifi_fecha_factura between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        } else {
            $criterio .= " and ifi_fecha_factura between '" . $fecha_inicio .
                    "' and '" . $fecha_fin . "')";
            ;
        }
    }
}
if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
    if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
        if ($criterio == "") {
            $criterio = "( ifi_fecha_factura <= '" . $fecha_fin . "')";
        } else {
            $criterio .= " and ifi_fecha_factura <= '" . $fecha_fin . "')";
        }
    }
}
if (isset($numero_factura) && $numero_factura != '') {
    if ($criterio == "") {
        $criterio = "  ifi_numero_factura = " . $numero_factura;
    } else {
        $criterio .= " and ifi_numero_factura = " . $numero_factura;
    }
}
if (isset($numero_radicado_ministerio) && $numero_radicado_ministerio != '') {
    if ($criterio == "") {
        $criterio = " ifi_numero_radicado_ministerio = " . $numero_radicado_ministerio;
    } else {
        $criterio .= " and ifi_numero_radicado_ministerio = " . $numero_radicado_ministerio;
    }
}
if ($criterio == "") {
    $criterio = "1";
}

echo "<table width='80%' border='1' align='center'>";
//encabezado
echo"<tr><th colspan = '11'><center></center></th></tr>";
echo"<tr><th colspan = '11' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(INFORME_FINANCIERO_REPORTE_EXCEL) . "</center></th></tr>";

//titulos
echo "<tr>";
echo "<th>" . $html->traducirTildes('No') . "</th>
        <th>" . $html->traducirTildes(INFORME_FINANCIERO_NUMERO_FACTURA) . "</th>
        <th>" . $html->traducirTildes(INFORME_FINANCIERO_FECHA_FACTURA) . "</th>
        <th>" . $html->traducirTildes(INFORME_FINANCIERO_NUMERO_RADICADO_MINISTERIO) . "</th>
        <th>" . $html->traducirTildes(INFORME_FINANCIERO_DOCUMENTO_SOPORTE) . "</th>
        <th>" . $html->traducirTildes(INFORME_FINANCIERO_DESCRIPCION) . "</th>
        <th>" . $html->traducirTildes(INFORME_FINANCIERO_VALOR_FACTURA) . "</th>
        <th>" . $html->traducirTildes(INFORME_FINANCIERO_AMORTIZACION) . "</th>
        <th>" . $html->traducirTildes(INFORME_FINANCIERO_SALDO_PENDIENTE_AA) . "</th>
        <th>" . $html->traducirTildes(INFORME_FINANCIERO_OBSERVACIONES) . "</th>
	<th>" . $html->traducirTildes(INFORME_FINANCIERO_SALDO_CONTRATO) . "</th>";
echo "</tr>";


//datos 
$contador = 0;
$informeFinanciero = $ifiData->getInformeFinanciero($criterio);
$cont = count($informeFinanciero);

while ($contador < $cont) {
    $temp = $contador + 1;
    echo "<tr>";
    echo "<td>" . $temp . "</td>
        <td>" . $informeFinanciero[$contador]['numero_factura'] . "</td>
        <td>" . $informeFinanciero[$contador]['fecha_factura'] . "</td>
        <td>" . $informeFinanciero[$contador]['numero_radicado_ministerio'] . "</td>
        <td>" . $informeFinanciero[$contador]['documento_soporte'] . "</td>
        <td>" . $informeFinanciero[$contador]['descripcion'] . "</td>
        <td>" . $informeFinanciero[$contador]['valor_factura'] . "</td>
        <td>" . $informeFinanciero[$contador]['amortizacion'] . "</td>
        <td>" . $informeFinanciero[$contador]['saldo_pendiente_AA'] . "</td>
        <td>" . $informeFinanciero[$contador]['observaciones'] . "</td>
        <td>" . $informeFinanciero[$contador]['saldo_contrato'] . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>