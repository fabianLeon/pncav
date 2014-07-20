//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaSvaipt Validaciones
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//
function validar_add_prueba(){
	if(document.getElementById('sel_despliegue_add').value=='-1'){
		mostrarDiv('error_despliegue');	
		return false;
	}
	if(document.getElementById('sel_tramite_add').value=='-1'){
		mostrarDiv('error_tramite');	
		return false;
	}
	if(document.getElementById('txt_consecutivo_add').value==''){
		mostrarDiv('error_consecutivo');	
		return false;
	}
	if(document.getElementById('txt_escenario_add').value==''){
		mostrarDiv('error_escenario');	
		return false;
	}
	document.getElementById('frm_add_prueba').action='?mod=validaciones_despliegue_prueba&niv=1&task=saveAdd';
	document.getElementById('frm_add_prueba').submit();
}
function validar_edit_prueba(){
	
	if(document.getElementById('txt_consecutivo_edit').value==''){
		mostrarDiv('error_consecutivo');	
		return false;
	}
	if(document.getElementById('txt_escenario_edit').value==''){
		mostrarDiv('error_escenario');	
		return false;
	}
	document.getElementById('frm_edit_prueba').action='?mod=validaciones_despliegue_prueba&niv=1&task=saveEdit';
	document.getElementById('frm_edit_prueba').submit();
}
function validar_add_incidente(){
	if(document.getElementById('txt_fecha_add').value==''){
		mostrarDiv('error_fecha');	
		return false;
	}
	if(document.getElementById('txt_incidente_add').value==''){
		mostrarDiv('error_incidente');	
		return false;
	}
	if(document.getElementById('sel_estado_add').value=='-1'){
		mostrarDiv('error_estado');	
		return false;
	}
	document.getElementById('frm_add_incidente').action='?mod=validaciones_despliegue_prueba&niv=1&task=saveAddIncidente';
	document.getElementById('frm_add_incidente').submit();
}
function validar_edit_incidente(){

	if(document.getElementById('txt_fecha_edit').value==''){
		mostrarDiv('error_fecha');	
		return false;
	}
	if(document.getElementById('txt_incidente_edit').value==''){
		mostrarDiv('error_incidente');	
		return false;
	}
	if(document.getElementById('sel_estado_edit').value=='-1'){
		mostrarDiv('error_estado');	
		return false;
	}
	document.getElementById('frm_edit_incidente').action='?mod=validaciones_despliegue_prueba&niv=1&task=saveEditIncidente';
	document.getElementById('frm_edit_incidente').submit();
}
function validar_add_trazabilidad(){
	
	if(document.getElementById('txt_observacion_add').value==''){
		mostrarDiv('error_observacion');	
		return false;
	}

	document.getElementById('frm_add_trazabilidad').action='?mod=validaciones_despliegue_prueba&niv=1&task=saveAddTrazabilidad';
	document.getElementById('frm_add_trazabilidad').submit();
}
function validar_edit_trazabilidad(){
	
	if(document.getElementById('txt_observacion_edit').value==''){
		mostrarDiv('error_observacion');	
		return false;
	}

	document.getElementById('frm_edit_trazabilidad').action='?mod=validaciones_despliegue_prueba&niv=1&task=saveEditTrazabilidad';
	document.getElementById('frm_edit_trazabilidad').submit();
}

