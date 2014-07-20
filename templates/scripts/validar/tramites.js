//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Tramites
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_tramite(){
	if(document.getElementById('sel_alcance_add').value=='-1'){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('txt_nombre_add').value==''){
		mostrarDiv('error_nombre');
		return false;
	}
	
	if(document.getElementById('sel_tipo_pago_add').value=='-1'){
		mostrarDiv('error_tipo_pago');	
		return false;
	}

	document.getElementById('frm_add_tramite').action='?mod=tramites&task=saveAdd';
	document.getElementById('frm_add_tramite').submit();
}

function validar_edit_tramite(){
	if(document.getElementById('sel_alcance_edit').value=='-1'){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('txt_nombre_edit').value==''){
		mostrarDiv('error_nombre');
		return false;
	}
    if(document.getElementById('sel_tipo_pago_edit').value=='-1'){
		mostrarDiv('error_tipo_pago');	
		return false;
	}
	
	
	document.getElementById('frm_edit_tramite').action='?mod=tramites&task=saveEdit';
	document.getElementById('frm_edit_tramite').submit();
}