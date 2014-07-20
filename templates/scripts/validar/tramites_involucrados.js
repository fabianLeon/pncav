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


function validar_add_tramites_involucrado(){


    if(document.getElementById('sel_departamento').value=='' || document.getElementById('sel_departamento').value==-1){
		mostrarDiv('error_departamento');	
		return false;
	}
	if(document.getElementById('sel_municipio').value=='' || document.getElementById('sel_municipio').value==-1){
		mostrarDiv('error_municipio');	
		return false;
	}

   if(document.getElementById('sel_tipo').value==-1){
		mostrarDiv('error_tipo');
		return false;
	
    }
   if(document.getElementById('sel_involucrado').value==-1){
		mostrarDiv('error_involucrado');
		return false;
	}
	
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
	if(document.getElementById('sel_alcance').value==-1){
		mostrarDiv('error_alcance');
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
	document.getElementById('frm_add_tramite_involucrado').action='?mod=tramites_involucrados&task=saveAdd';
	document.getElementById('frm_add_tramite_involucrado').submit();
    }
function validar_edit_tramites_involucrado(){
    
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
	if(!validarReal(document.getElementById('txt_monto').value)){
		mostrarDiv('error_monto');
		return false;
	
    }   
		
	document.getElementById('frm_edit_tramite_involucrado').action='?mod=tramites_involucrados&task=saveEdit';
	document.getElementById('frm_edit_tramite_involucrado').submit();
}