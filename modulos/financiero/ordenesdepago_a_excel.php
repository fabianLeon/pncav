<?php

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=ordenesdepago.xls");

error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/COrdenesdepagoData.php');
require('../../clases/datos/CCompromisoResponsableData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/ordenesdepago-es.php');
require('../../lang/es-co/es-co.php');

$html = new CHtml('');


$docData = new COrdenesdepagoData($db);


$tipoactividad = $_REQUEST['sel_tipo_actividad'];
$actividad = $_REQUEST['sel_actividad'];
$proveedor = $_REQUEST['sel_proveedor'];
$CheckAprovado = $_REQUEST['check_estados_1'];
$CheckPagado = $_REQUEST['check_estados_4'];
$CheckPendiente = $_REQUEST['check_estados_3'];
$CheckRechazado = $_REQUEST['check_estados_2'];

if (isset($CheckAprovado) || isset($CheckPagado) || isset($CheckPendiente) || isset($CheckRechazado)) {

    $criterio = "";
    if (isset($tipoactividad) && $tipoactividad > 0 && $tipoactividad != -1) {
        $criterio = "(at.Id_Tipo=" . $tipoactividad . ")";
    }
    if (isset($actividad) && $actividad > 0 && $actividad != -1) {
        $criterio = $criterio . "(a.Id_Actividad=" . $actividad . ")";
    }
  
    if (isset($proveedor) && $proveedor > 0 && $proveedor != -1) {
        $criterio = $criterio . "(p.Id_Prove=" . $proveedor . ")";
    }
    if (isset($moneda) && $moneda > 0 && $moneda != -1) {
        $criterio = $criterio . "(m.Id_Moneda=" . $moneda . ")";
    }
    
    $criterio = explode(')', $criterio);
    $parametro = "";

    if (count($criterio) == 2) {
        $parametro = $criterio[0] . ") and ";
    } else {
        for ($i = 0; $i < count($criterio) - 1; $i++) {
            $parametro = $parametro . " " . $criterio[$i] . ") and ";
        }
    }

    if (isset($CheckAprovado)) {
        $filtroestado = $filtroestado . "Id_estado_Ordenes=1)";
    }
    if (isset($CheckPagado)) {
        $filtroestado = $filtroestado . "Id_estado_Ordenes=4)";
    }
    if (isset($CheckPendiente)) {
        $filtroestado = $filtroestado . "Id_estado_Ordenes=3)";
    }
    if (isset($CheckRechazado)) {
        $filtroestado = $filtroestado . "Id_estado_Ordenes=2)";
    }
    $filtroestado = explode(')', $filtroestado);
    $parametroestado = "";

    if (count($filtroestado) == 2) {
        $parametroestado = "(" . $filtroestado[0] . ")";
    } else {
        for ($i = 0; $i < count($filtroestado) - 1; $i++) {
            $parametroestado = $parametroestado . " " . $filtroestado[$i] . " or";
        }
        $parametroestado = "(" . substr($parametroestado, 0, count($parametroestado) - 4) . ")";
    }
} else if (!isset($CheckAprovado) && !isset($CheckPagado) && !isset($CheckPendiente) && !isset($CheckRechazado)) {

    $criterio = "";
    if (isset($tipoactividad) && $tipoactividad > 0 && $tipoactividad != -1) {
        $criterio = "(at.Id_Tipo=" . $tipoactividad . ")";
    }
    if (isset($actividad) && $actividad > 0 && $actividad != -1) {
        $criterio = $criterio . "(a.Id_Actividad=" . $actividad . ")";
    }
  
    if (isset($proveedor) && $proveedor > 0 && $proveedor != -1) {
        $criterio = $criterio . "(p.Id_Prove=" . $proveedor . ")";
    }
    if (isset($moneda) && $moneda > 0 && $moneda != -1) {
        $criterio = $criterio . "(m.Id_Moneda=" . $moneda . ")";
    }
    
    $criterio = explode(')', $criterio);
    $parametro = "";

    if (count($criterio) == 2) {
        $parametro = $criterio[0] . ")";
    } else {
        for ($i = 0; $i < count($criterio) - 1; $i++) {
            $parametro = $parametro . " " . $criterio[$i] . ") and";
        }
        $parametro = substr($parametro, 0, count($parametro) - 4);
    }
}
$criterio_Final = $parametro . $parametroestado;
$ordenes=$docData->obtenerOrdenesdepago($criterio_Final);




//echo "<br>".$sql."<br>";
echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '8'><center></center></th></tr>";
echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(ORDENES_REPORTE_EXCEL) . "</center></th></tr>";


//titulos
echo "<tr>";

echo "
	<th>" . $html->traducirTildes(REINTEGRO) . "</th>
	<th>" . $html->traducirTildes(NUMERO_ORDEN_PAGO) . "</th>
	<th>" . $html->traducirTildes(FECHA_ORDEN) . "</th>
	<th>" . $html->traducirTildes(ESTADO_ORDEN) . "</th>
        <th>" . $html->traducirTildes(TIPO_ACTIVIDAD_ORDEN) . "</th>
        <th>" . $html->traducirTildes(ACTIVIDAD_ORDEN) . "</th>
        <th>" . $html->traducirTildes(NOMBRE_PROVEEDOR_ORDEN_PAGO) . "</th>
        <th>" . $html->traducirTildes(NUMERO_FACTURA) . "</th>
       	<th>" . $html->traducirTildes(NUMERO_DOCUMENTO_SOPORTE_UT) . "</th>
        <th>" . $html->traducirTildes(MONEDA_ORDEN) . "</th>
        <th>" . $html->traducirTildes(TASA_ORDEN) . "</th>
	<th>" . $html->traducirTildes(VALOR_TOTAL_ORDEN) . "</th>
        <th>" . $html->traducirTildes(FECHA_PAGO_ORDEN) . "</th>
        <th>" . $html->traducirTildes(ARCHIVO_ORDEN) . "</th>
        <th>" . $html->traducirTildes(OBSERVACIONES_ORDEN) . "</th>";
echo "</tr>";
//datos 
$cont = 0;
$conta = count($ordenes);
while ($cont < $conta) {
    echo "<tr>";
    echo
        "<td>".$ordenes[$cont]['tipoReintegro']."</td>
        <td>".$ordenes[$cont]['numerorden'] ."</td>
        <td>".$ordenes[$cont]['fecha']."</td>
        <td>".$ordenes[$cont]['estado']."</td>
        <td>".$ordenes[$cont]['tipoactividad']."</td>
        <td>".$ordenes[$cont]['actividad']."</td>
        <td>".$ordenes[$cont]['proveedor']."</td>
        <td>".$ordenes[$cont]['numerofactura']."</td>
        <td>".$ordenes[$cont]['reintegro']."</td>
        <td>".$ordenes[$cont]['moneda']."</td>
        <td>".$ordenes[$cont]['tasa']."</td>
        <td>".$ordenes[$cont]['valortotal']."</td>
        <td>".$ordenes[$cont]['fechapago']."</td>
        <td>".$ordenes[$cont]['archivo']."</td>
        <td>".$ordenes[$cont]['observaciones']."</td>";
    echo "</tr>";
    $cont++;
}
echo "</table>";
?>	













