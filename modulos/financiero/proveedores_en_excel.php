<?php


header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte_proveedores.xls");
error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
require('../../clases/datos/CProveedorData.php');
require('../../clases/datos/CData.php');
require('../../clases/interfaz/CHtml.php');
include('../../config/conf.php');
include('../../config/constantes.php');
require('../../lang/es-co/proveedores-es.php');


$html = new CHtml('');
$docData= new CProveedorData($db);
$criterio=$_REQUEST['txt_filtro_proveedor'];
$proveedores = $docData->obtenerproveedores($criterio);
 
echo "<table width='80%' border='0' align='center'>";
//encabezado
echo"<tr><th colspan = '8'><center></center></th></tr>";
echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(PROVEEDORES_EXEL) . "</center></th></tr>";


//titulos
echo "<tr>";

echo "
	<th>" . $html->traducirTildes(NIT_PROVEEDOR) . "</th>
	<th>" . $html->traducirTildes(NOMBRE_PROVEEDOR) . "</th>
	<th>" . $html->traducirTildes(TEL_PROVEEDOR) . "</th>
	<th>" . $html->traducirTildes(UBICACION_PROVEEDOR) . "</th>
	<th>" . $html->traducirTildes(NOMBRE_CONTACTO_PROVEEDOR) . "</th>
	<th>" . $html->traducirTildes(TELEFONO_CONTACTO_PROVEEDOR) . "</th>
	<th>" . $html->traducirTildes(EMAIL_PROVEEDOR) . "</th>";
echo "</tr>";
//datos 
$contador = 0;
$cont = count($proveedores);

while ($contador < $cont) {
   
    echo "<tr>";
    echo "<td>" .$proveedores[$contador][1] . "</td>	
        <td>" . $proveedores[$contador][2] . "</td>		
        <td>" . $proveedores[$contador][3] . "</td>		
        <td>" . $proveedores[$contador][4] . "</td>		
        <td>" . $proveedores[$contador][5] . "</td>		
        <td>" . $proveedores[$contador][6] . "</td>		
        <td>" . $proveedores[$contador][7] . "</td>";
    echo "</tr>";
    $contador++;
}
echo "</table>";
?>	