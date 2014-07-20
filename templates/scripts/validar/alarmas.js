//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Alarmas
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//
function validar_add_alarma(){
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_alarmas_nombre');	
		return false;
	}
	if(document.getElementById('txt_actividad').value==''){
		mostrarDiv('error_alarmas_actividad');	
		return false;
	}
	if(document.getElementById('sel_usuario').value=='-1'){
		mostrarDiv('error_alarmas_usuario');	
		return false;
	}
	if(document.getElementById('txt_parametro_uno').value==''){
		mostrarDiv('error_alarmas_parametro_uno');	
		return false;
	}
	if(!validarEntero(document.getElementById('txt_parametro_uno').value)){
		mostrarDiv('error_alarmas_parametro_uno');	
		return false;
	}
	if(document.getElementById('txt_parametro_dos').value==''){
		mostrarDiv('error_alarmas_parametro_dos');	
		return false;
	}
	if(!validarEntero(document.getElementById('txt_parametro_dos').value)){
		mostrarDiv('error_alarmas_parametro_dos');	
		return false;
	}
	if(document.getElementById('txt_fecha_limite').value==''){
		mostrarDiv('error_alarmas_fecha_limite');	
		return false;
	}

	document.getElementById('frm_add_alarma').action='?mod=alarmas&niv=1&task=saveAdd';
	document.getElementById('frm_add_alarma').submit();
}

function validar_edit_alarma(){
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_alarmas_nombre');	
		return false;
	}
	if(document.getElementById('txt_actividad').value==''){
		mostrarDiv('error_alarmas_actividad');	
		return false;
	}
	if(document.getElementById('sel_usuario').value=='-1'){
		mostrarDiv('error_alarmas_usuario');	
		return false;
	}
	if(document.getElementById('txt_parametro_uno').value==''){
		mostrarDiv('error_alarmas_parametro_uno');	
		return false;
	}
	if(!validarEntero(document.getElementById('txt_parametro_uno').value)){
		mostrarDiv('error_alarmas_parametro_uno');	
		return false;
	}
	if(document.getElementById('txt_parametro_dos').value==''){
		mostrarDiv('error_alarmas_parametro_dos');	
		return false;
	}
	if(!validarEntero(document.getElementById('txt_parametro_dos').value)){
		mostrarDiv('error_alarmas_parametro_dos');	
		return false;
	}
	if(document.getElementById('txt_fecha_limite').value==''){
		mostrarDiv('error_alarmas_fecha_limite');	
		return false;
	}

	document.getElementById('frm_edit_alarma').action='?mod=alarmas&niv=1&task=saveEdit';
	document.getElementById('frm_edit_alarma').submit();
}
