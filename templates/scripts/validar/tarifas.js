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

function validar_add_tramites_tarifa(){

	if(document.getElementById('txt_fecha_inicial').value==''){
		mostrarDiv('error_fecha_inicial');	
		return false;
	}
	if(document.getElementById('txt_fecha_final').value==''){
		mostrarDiv('error_fecha_final');
		return false;
	}
	if(document.getElementById('txt_fecha_final').value<=document.getElementById('txt_fecha_inicial').value){
		mostrarDiv('error_fecha_final');
		return false;
	}
	if(document.getElementById('sel_tramite').value==-1){
		mostrarDiv('error_tramite');
		return false;
	}
	if(!validarReal(document.getElementById('txt_monto').value)){
		mostrarDiv('error_monto');
		return false;
	}
	if(document.getElementById('sel_documento').value=='' || document.getElementById('sel_documento').value=='-1'){
		mostrarDiv('error_documento');
		return false;
	}	
	document.getElementById('frm_add_tramite_tarifa').action='?mod=tramites_tarifa&task=saveAdd';
	document.getElementById('frm_add_tramite_tarifa').submit();
}

function validar_edit_tramites_tarifa(){
	if(document.getElementById('txt_fecha_inicial').value==''){
		mostrarDiv('error_fecha_inicial');	
		return false;
	}
	if(document.getElementById('txt_fecha_final').value==''){
		mostrarDiv('error_fecha_final');
		return false;
	}
	if(document.getElementById('txt_fecha_final').value<=document.getElementById('txt_fecha_inicial').value){
		mostrarDiv('error_fecha_final');
		return false;
	}	
	if(document.getElementById('sel_tramite').value==-1){
		mostrarDiv('error_tramite');
		return false;
	}
	if(!validarReal(document.getElementById('txt_monto').value)){
		mostrarDiv('error_monto');
		return false;
	}	
    if(document.getElementById('sel_documento').value=='' || document.getElementById('sel_documento').value=='-1'){
		mostrarDiv('error_documento');
		return false;
	}   
	document.getElementById('frm_edit_tramite_tarifa').action='?mod=tramites_tarifa&task=saveEdit';
	document.getElementById('frm_edit_tramite_tarifa').submit();
}