//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Perfiles
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_perfil(){
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	document.getElementById('frm_add_perfil').action='?mod=perfiles&task=saveAdd';
	document.getElementById('frm_add_perfil').submit();
}

function validar_edit_perfil(){
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	document.getElementById('frm_edit_perfil').action='?mod=perfiles&task=saveEdit';
	document.getElementById('frm_edit_perfil').submit();
}
function validar_edit_options(){
	document.getElementById('frm_edit_options').action='?mod=perfiles&niv=1&task=saveOptions';
	document.getElementById('frm_edit_options').submit();
}
