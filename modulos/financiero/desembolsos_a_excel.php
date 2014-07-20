<?php

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Informe_Desembolsos.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CDesembolsoData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/desembolso-es.php');

$html = new CHtml('');
$docData = new CDesembolsoData($db);
$desembolsos = $docData->getDesembolsoFormat('1', 'des_id');

echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '8'><center></center></th></tr>";
echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(TITULO_DESEMBOLSOS).  "</center></th></tr>";

//titulos
echo "<tr>";
echo "<th>" . $html->traducirTildes(CAMPO_NUMERO_DESEMBOLSO) . "</th>
        <th>" . $html->traducirTildes(CAMPO_FECHA) . "</th>
        <th>" . $html->traducirTildes(CAMPO_PORCENTAJE_DESEMBOLSO) . "</th>
        <th>" . $html->traducirTildes(CAMPO_APROBADO) . "</th>
        <th>" . $html->traducirTildes(CAMPO_PORCENTAJE_AMORTIZACION) . "</th>
        <th>" . $html->traducirTildes(CAMPO_AMORTIZACION) . "</th>
        <th>" . $html->traducirTildes(CAMPO_VALOR_NETO) . "</th>
        <th>" . $html->traducirTildes(CAMPO_FECHA_CUMPLIMIENTO) . "</th>
        <th>" . $html->traducirTildes(CAMPO_FECHA_TRAMITE) . "</th>
        <th>" . $html->traducirTildes(CAMPO_FECHA_LIMITE) . "</th>
        <th>" . $html->traducirTildes(CAMPO_FECHA_EFECTIVA) . "</th>
        <th>" . $html->traducirTildes(CAMPO_DESEMBOLSO) . "</th>
        <th>" . $html->traducirTildes(CAMPO_OBSERVACIONES) . "</th>
        <th>" . $html->traducirTildes(CAMPO_ESTADO) . "</th>";
echo "</tr>";



//datos 
$contador = 0;
$cont = count($desembolsos);
while ($contador < $cont) {
    $temp='';
    echo "<tr>";
    $temp="<td>".$desembolsos[$contador]['id']."</td>".
    "<td>".$desembolsos[$contador]['fecha']."</td>".
    "<td>".$desembolsos[$contador]['porcentaje']."</td>".
    "<td>".$desembolsos[$contador]['aprobado']."</td>".
    "<td>".$desembolsos[$contador]['porcentaje_amortizacion']."</td>".
    "<td>".$desembolsos[$contador]['amortizacion']."</td>".
    "<td>".$desembolsos[$contador]['neto']."</td>".
    "<td>".$desembolsos[$contador]['fecha_cumplimiento']."</td>".
    "<td>".$desembolsos[$contador]['fecha_tramite']."</td>".
    "<td>".$desembolsos[$contador]['fecha_limite']."</td>".
    "<td>".$desembolsos[$contador]['fecha_efectiva']."</td>".
    "<td>".$desembolsos[$contador]['efectuado']."</td>".
    "<td>".$desembolsos[$contador]['observaciones']."</td>".
    "<td>".$desembolsos[$contador]['estado']."</td>";
    echo $temp;
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>