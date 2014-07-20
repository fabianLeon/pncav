<?php

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Informe de Utilizaciones.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CIngresosData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/ingresos-es.php');

$html = new CHtml('');
$docData = new CIngresosData($db);
$Years = $docData->ObtenerYears();

for ($i = 0; $i < count($Years); $i++) {
    $arrayear[$i] = $Years[$i]['A_Ingreso'];
}
for ($i = 0; $i < count($arrayear); $i++) {
    $vigencias_Montos = $docData->ObtenerValoresIngresos($arrayear[$i]);
    $utilidades_aprobadas = $docData->ObtenerValoresUtilidades($arrayear[$i]);
    $valor_pendiente_por_utilizaciones = $vigencias_Montos[1] - $utilidades_aprobadas[0];
    $porcentaje_utilizaciones = ($utilidades_aprobadas[1] / $vigencias_Montos[1]) * 100;
    $tabla_utilizaciones[$i] = array(0, $vigencias_Montos[0], $utilidades_aprobadas[1], $utilidades_aprobadas[0], $valor_pendiente_por_utilizaciones, $porcentaje_utilizaciones);
}

echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '8'><center></center></th></tr>";
echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(UTILIZACIONES_A_EXCEL) . "</center></th></tr>";

//titulos
echo "<tr>";

echo "<th>" . $html->traducirTildes(DESCRIPCION_DE_VIGENCIAS) . "</th>
	<th>" . $html->traducirTildes(NUMERO_UTILIZACIONES) . "</th>
	<th>" . $html->traducirTildes(VARLO_TOTAL_UTILIZACIONES) . "</th>
	<th>" . $html->traducirTildes(VALOR_PENDIENTE_UTILIZAR) . "</th>
	<th>" . $html->traducirTildes(PORCENTAJE_UTILIZACIONES) . "</th>";
echo "</tr>";


echo "<tr>";

//datos 
$contador = 0;
$cont = count($tabla_utilizaciones);
while ($contador < $cont) {

    echo "<tr>";
    echo "<td>" . $tabla_utilizaciones[$contador][1] . "</td>	
        <td>" . $tabla_utilizaciones[$contador][2] . "</td>
        <td>" . number_format($tabla_utilizaciones[$contador][3], 2, ',', '.') . "</td>
        <td>" . number_format($tabla_utilizaciones[$contador][4], 2, ',', '.') . "</td>
        <td>" . number_format($tabla_utilizaciones[$contador][5], 5,',','.') . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>