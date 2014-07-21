<?php
/**
*Gestion Interventoria - Gestin
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto PNCAV</li>
*</ul>
*/

/**
* Blank_layout
*
* @package  templates
* @subpackage layouts
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$html = new CHtml(APP_TITLE);
	$html->addEstilo('diseno.css');
	$html->addEstilo('calendar/calendar-blue.css');
	$html->addScript('ssm.js');
	$html->addScript('validar.js');
	$html->addScript('calendar/calendar.js');
	$html->addScript('calendar/calendar-es.js');
	$html->addScript('calendar/calendar-setup.js');
	$html->abrirHtml();
?>
<?php include('templates/html/header.html'); ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr class="layout">
			<td width="20"></td>
			<td width="40" class="layout_title" nowrap><?php echo $html->traducirTildes(LAYOUT_FECHA);?></td>
			<td width="250" class="layout" nowrap><?php echo $html->fecha($dias,$meses);?></td>
			<td width="40" class="layout_title" nowrap><?php echo $html->traducirTildes(LAYOUT_HORA);?></td>
			<td width="150" class="layout" nowrap><?php echo date("H:i:s");?></td>
			<td width="40" class="layout_title" nowrap><?php echo $html->traducirTildes(LAYOUT_ACTIVO);?></td>
			<td class="layout" nowrap><?php echo $html->traducirTildes($nombre_usuario);?></td>
			<td width="*"></td>
		</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="20"></td>
	  		<td class="td_white" height="300" width="800">
<?php
	if (file_exists( $path_modulo )) include( $path_modulo );
	else{ 
		?>
		<!--div class="error">Error al cargar el m�dulo <b>'<?php echo $modulo;?>'</b>. No existe el archivo <b>'<?php echo $conf[$modulo]['archivo'];?>'</b></div-->
		<?php
		include('templates/html/under.html');//die('Error al cargar el m�dulo <b>'.$modulo.'</b>. No existe el archivo <b>'.$conf[$modulo]['archivo'].'</b>');
	}
?>
			</td>
			<td class="td_menu">&nbsp;</td>
		</tr>
	</table>
<?php include('templates/html/footer.html'); ?>
<?php
	$html->cerrarHtml();

?>