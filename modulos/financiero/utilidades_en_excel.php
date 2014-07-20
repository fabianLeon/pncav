<?php


header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte_Utilidades.xls");
error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CUtilidadesData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/utilizaciones-es.php');


$html = new CHtml('');
$docData= new CUtilidadesData($db);
$criterio=$_REQUEST['txt_filtro_utilidades'];
$utilidades = $docData->obtenerUtilidades($criterio);
 
echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '8'><center></center></th></tr>";
echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(UTILIDADES_A_EXCEL) . "</center></th></tr>";


//titulos
echo "<tr>";

echo "
        <th>" . $html->traducirTildes(ID_UTILIZACION) . "</th>
	<th>" . $html->traducirTildes(FECHA_COMUNICADO_UTILIDADES) . "</th>
	<th>" . $html->traducirTildes(DOCUMENTO_SOPORTE_COMUNICADO) . "</th>
	<th>" . $html->traducirTildes(PORCENTAJE_UTILIZACION) . "</th>
	<th>" . $html->traducirTildes(UTILIZACION_APROBADA) . "</th>
	<th>" . $html->traducirTildes(FECHA_COMITE_FIDUCIARIO) . "</th>
	<th>" . $html->traducirTildes(NUMERO_COMITE_FIDUCIARIO) . "</th>
	<th>" . $html->traducirTildes(DOCUMENTNUMERO_COMITE_FIDUCIARIOO_SOPORTE_ACTA) . "</th>
	<th>" . $html->traducirTildes(COMENTARIOS_UTILIDADES) . "</th>";
echo "</tr>";
//datos 
$contador = 0;
$cont = count($utilidades);

while ($contador < $cont) {
   
    echo "<tr>";
    echo"<td>". $utilidades[$contador]['id'] . "</td>	
        <td>" . $utilidades[$contador]['fecha_Comuni'] . "</td>	
        <td>" . $utilidades[$contador]['doc_comuni'] . "</td>		
        <td>" . $utilidades[$contador]['porcentaje'] . "</td>		
        <td>" . $utilidades[$contador]['util_aprobada'] . "</td>		
        <td>" . $utilidades[$contador]['fecha_comi_fidu'] . "</td>		
        <td>" . $utilidades[$contador]['numero_comi_fidu'] . "</td>		
        <td>" . $utilidades[$contador]['doc_acta'] . "</td>		
        <td>" . $utilidades[$contador]['comentarios'] . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>	

