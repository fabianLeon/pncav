<?php

/**

 */
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=actividades.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CActividadData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/actividades_es.php');
require('../../lang/es-co/actividadPIA-es.php');

$html = new CHtml('');
$docData = new CActividadData($db);
$tipo = $_REQUEST['Tipo_actividad'];
$actividades = $docData->ObtenerActividades($tipo);

echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '8'><center></center></th></tr>";
echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(ACTIVIDADES_REPORTE_EXCEL) . "</center></th></tr>";


//titulos
echo "<tr>";

echo "
	<th>" . $html->traducirTildes(DESCRIPCION_ACTIVIDAD_REPORTE) . "</th>
	<th>" . $html->traducirTildes(MONTO_ACTIVIDAD_REPORTE) . "</th>
	<th>" . $html->traducirTildes(TIPO_ACTIVIDAD_REPORTE) . "</th>";
echo "</tr>";
//datos 
$contador = 0;
$cont = count($actividades);

while ($contador < $cont) {
   
    echo "<tr>";
    echo "<td>" .$actividades[$contador]['descripcion'] . "</td>	
        <td>" . $actividades[$contador]['monto'] . "</td>		
        <td>" . $actividades[$contador]['descripciotipo'] . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>