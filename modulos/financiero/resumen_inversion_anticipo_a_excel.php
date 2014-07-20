<?php

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Resumen PIA.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CIngresosData.php');
require('../../clases/datos/CActividadData.php');
require('../../clases/datos/COrdenesdepagoData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/resumenRegistroInversio-es.php');

$docData=new COrdenesdepagoData($db);
$html = new CHtml('');
$tabla_invserio_PIA=$docData->ObtenerOrdenesResumenPIA();


echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '8'><center></center></th></tr>";
echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(TITULO_RESUMEN_REGISTRO_INVERSION) . "</center></th></tr>";

//titulos
echo "<tr>";
echo "<th>" . $html->traducirTildes(CAMPO_NOMBRE_PROVEEDOR) . "</th>
      <th>" . $html->traducirTildes(CAMPO_NUMERO_DOCUMENTO) . "</th>
      <th>" . $html->traducirTildes(CAMPO_FECHA_INVERSION) . "</th>
	<th>" . $html->traducirTildes(CAMPO_VALOR_INVERSION) . "</th>";
echo "</tr>";


echo "<tr>";

//datos 
$contador = 0;
$cont = count($tabla_invserio_PIA);
while ($contador < $cont) {

    echo "<tr>";
    echo "<td>" . $tabla_invserio_PIA[$contador]['NProveedor'] . "</td>
        <td>" . $tabla_invserio_PIA[$contador]['FechaOrden']. "</td>
        <td>" . $tabla_invserio_PIA[$contador]['NumFactura'] . "</td>
        <td>" . number_format($tabla_invserio_PIA[$contador]['ValorTotal'], 2, ',', '.') . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>