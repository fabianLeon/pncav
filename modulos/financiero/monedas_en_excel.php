<?php

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte_Monedas.xls");
//$operador = $_REQUEST['sel_operador'];


$host 			= $_REQUEST['txt_host'];
$usuario 		= $_REQUEST['txt_usuario'];
$password 		= $_REQUEST['txt_password'];
$database 		= $_REQUEST['txt_basedatos'];

function conectar($host,$usuario,$password, $database){
	$link = mysql_pconnect($host,$usuario,$password);
	if(!$link){
		echo "Imposible conectar";
		exit;
	}
   mysql_select_db($database,$link);
}
function ejecutarConsulta($sql){
	//echo ("sql:  ".$sql);
	$result=mysql_query($sql);
	if($result)
	  return $result;
}
$sql = "select *from monedas";
//echo "<br>".$sql."<br>";
conectar($host, $usuario,$password,$database);
$r = ejecutarConsulta($sql);
echo "<table border=0>";
//titulos
	echo "<tr>";
	echo "<th></th><th></th><th>REPORTE DE MONEDAS</th>";
	echo "</tr>";
echo "<table border=1>";
	echo "<tr>";
	echo "<th>Descripcion</th>";	
	echo "</tr>";
//datos 
while($w = mysql_fetch_array($r)){
echo "<tr>";
	echo 
	"<td>".$w['Descripcion_Moneda']."</td>
	";
echo "</tr>";
}
echo "</table>";
?>		

