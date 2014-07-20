<?php

/**

 */
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=ingresos.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CIngresosData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/ingresos-es.php');

$html = new CHtml('');
$docData = new CIngresosData($db);
$ingresos = $docData->Obteneringresos();

echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '8'><center></center></th></tr>";
echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(INGRESOS_EXCEL) . "</center></th></tr>";


//titulos
echo "<tr>";

echo "<th>" . $html->traducirTildes(AnO_INGRESO_TIPO) . "</th>
      <th>" . $html->traducirTildes(MONTO_INGRESO_B) . "</th>";
echo "</tr>";
//datos 
$contador = 0;
$cont = count($ingresos);

while ($contador < $cont) {
   
    echo "<tr>";
    echo "<td>" .$ingresos[$contador]['res_vigen'] . "</td>	
        <td>" . $ingresos[$contador]['motoo'] . "</td> ";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>