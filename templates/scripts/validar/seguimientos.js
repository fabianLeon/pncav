//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Seguimientos
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_seguimiento1_hito(){

	if(document.getElementById('sel_alcance').value=='-1'){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('sel_etapa').value=='-1'){
		mostrarDiv('error_etapa');
		return false;
	}
	if(document.getElementById('sel_entregable').value=='-1'){
		mostrarDiv('error_entregable');	
		return false;
	}
	document.getElementById('frm_add_seguimiento1_hito').action='?mod=seguimientos&task=saveAdd';
	document.getElementById('frm_add_seguimiento1_hito').submit();
}

function validar_edit_seguimiento1_hito(){
	if(document.getElementById('sel_alcance').value=='-1'){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('sel_etapa').value=='-1'){
		mostrarDiv('error_etapa');
		return false;
	}
	if(document.getElementById('sel_entregable').value=='-1'){
		mostrarDiv('error_entregable');	
		return false;
	}
	document.getElementById('frm_edit_seguimiento1_hito').action='?mod=seguimientos&task=saveEdit';
	document.getElementById('frm_edit_seguimiento1_hito').submit();
}
function validar_add_seguimiento1_detalle(){


	if(document.getElementById('txt_fecha_programada').value==''){
		mostrarDiv('error_fecha_programada');
		return false;
	}
	if(document.getElementById('sel_estado').value=='-1'){
		mostrarDiv('error_estado');
		return false;
	}
	if(document.getElementById('txt_fecha_estado').value==''){
		mostrarDiv('error_fecha_estado');
		return false;
	}
	document.getElementById('frm_add_seguimiento1_detalle').action='?mod=seguimientos&task=saveAddSeguimiento';
	document.getElementById('frm_add_seguimiento1_detalle').submit();
}

function validar_edit_seguimiento1_detalle(){

	if(document.getElementById('txt_fecha_programada').value==''){
		mostrarDiv('error_fecha_programada');
		return false;
	}
	if(document.getElementById('sel_estado').value=='-1'){
		mostrarDiv('error_estado');
		return false;
	}
	if(document.getElementById('txt_fecha_estado').value==''){
		mostrarDiv('error_fecha_estado');
		return false;
	}
	document.getElementById('frm_edit_seguimiento1_detalle').action='?mod=seguimientos&task=saveEditSeguimiento';
	document.getElementById('frm_edit_seguimiento1_detalle').submit();
}