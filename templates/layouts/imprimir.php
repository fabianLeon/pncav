<?php
/**
*Gestion Interventoria - Gestin
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto RUNT</li>
*</ul>
*/

/**
* Imprimir
*
* @package  templates
* @subpackage layouts
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/
//no permite el acceso directo
	defined('_VALID_FSW') or die('Restricted access');
$uri = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
?>
<html>
<head>
	<title>Versión para Imprimir</title>
</head>
<style type="text/css">
.imprimir {
	margin: 3%;
	border: 2px solid black;
	padding: 2%;
}
#pie {
	font-size: 8pt;
}
</style>
<body>
<div class="imprimir">
<?php
	if (file_exists( $path_modulo )) include( $path_modulo );
	else die('Error al cargar el módulo <b>'.$modulo.'</b>. No existe el archivo <b>'.$conf[$modulo]['archivo'].'</b>');
?>
<i id="pie">Este artículo se puede encontrar en : <a href="<?php echo $uri?>"><?php echo $uri?></a></i>
</div>
</body>
</html>