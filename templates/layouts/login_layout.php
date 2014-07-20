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
* Login_layout
*
* @package  templates
* @subpackage layouts
* @author Redcom Ltda
* @version 2013.01.00
* @copyright Ministerio de Transporte
*/

	//no permite el acceso directo
	defined('_VALID_PRY') or die('Restricted access');
	$html = new CHtml(APP_TITLE);
	$html->addEstilo('diseno.css');
	$handle=opendir('./templates/scripts/validar/'); 
	while ($file = readdir($handle)) { 
		if ($file != "." && $file != "..") { 
			//include($file);
			if(substr($file,strlen($file)-3)=='.js'){
				$html->addScript('validar/'.$file);
			}
		} 
	}
	$html->abrirHtml('');
?>
	<div id="div_log">
	
	<table width="500px" align="center" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td class="logi_header"></td>
		</tr>
		<tr>
			
			<td width="40%" id="loginbox">
				<?php
					if (file_exists( $path_modulo )) include( $path_modulo );
					else die('Error al cargar el módulo <b>'.$modulo.'</b>. No existe el archivo <b>'.$conf[$modulo]['archivo'].'</b>');
					echo $html->traducirTildes(MSN_LOGIN)
				?>
			</td>

		</tr>
		<tr>
			<td class="logi_footer"></td>
		</tr>
		
	</table>
	
	</div>
<?php
	$html->cerrarHtml();

?>

