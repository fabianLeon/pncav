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
* carga la ventana la vista inicial del sistema
*
* @package  modulos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/
//no permite el acceso directo
    defined('_VALID_PRY') or die('Restricted access to this option');

	$fecha = date("Y-m-d");
	$du->updateUserFecha($id_usuario,$fecha);
        
        
?>


<table width="100%">
	<tr>
		<td class="td_center">
			<img src="./templates/img/logos_inicio.png">
		</td>
	</tr>
</table>