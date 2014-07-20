//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Comunicados
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//
function validar_add_comunicado(){
	if(document.getElementById('sel_subtema_add').value=='-1'){
		mostrarDiv('error_subtema');	
		return false;
	}
	if(document.getElementById('sel_autor_add').value=='-1'){
		mostrarDiv('error_autor');	
		return false;
	}
	if(document.getElementById('sel_destinatario_add').value=='-1'){
		mostrarDiv('error_destinatario');	
		return false;
	}
	if(document.getElementById('txt_fecha_radicacion_add').value==''){
		mostrarDiv('error_fecha_radicacion');	
		return false;
	}
	if(document.getElementById('txt_referencia_add').value==''){
		mostrarDiv('error_referencia');	
		return false;
	}
	if(document.getElementById('sel_responsable_add').value=='' || document.getElementById('sel_responsable_add').value==-1){
		mostrarDiv('error_responsable');	
		return false;
	}		
	if(document.getElementById('sel_alarma_add').value=='' || document.getElementById('sel_alarma_add').value==-1){
		mostrarDiv('error_alarma');	
		return false;
	}	
	if(document.getElementById('sel_alarma_add').value==1 && ( document.getElementById('txt_fecha_respuesta_add').value=='' || document.getElementById('txt_fecha_respuesta_add').value=='0000-00-00')){
		mostrarDiv('error_fecha_respuesta');	
		return false;
	}			

	if(document.getElementById('txt_descripcion_add').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	if(document.getElementById('file_comunicado_add').value==''){
		mostrarDiv('error_comunicado');	
		return false;
	}
	
	document.getElementById('frm_add_comunicado').action='?mod=comunicados&niv=1&task=saveAdd';
	document.getElementById('frm_add_comunicado').submit();
}


function validar_edit_comunicado(){
	if(document.getElementById('sel_subtema_edit').value=='-1'){
		mostrarDiv('error_subtema');	
		return false;
	}
	if(document.getElementById('sel_autor_edit').value=='-1'){
		mostrarDiv('error_autor');	
		return false;
	}
	if(document.getElementById('sel_destinatario_edit').value=='-1'){
		mostrarDiv('error_destinatario');	
		return false;
	}
	if(document.getElementById('txt_fecha_radicacion_edit').value==''){
		mostrarDiv('error_fecha_radicacion');	
		return false;
	}
	if(document.getElementById('txt_referencia_edit').value==''){
		mostrarDiv('error_referencia');	
		return false;
	}
	if(document.getElementById('sel_responsable_edit').value=='' || document.getElementById('sel_responsable_edit').value==-1){
		mostrarDiv('error_responsable');	
		return false;
	}		
	if(document.getElementById('sel_alarma_edit').value=='' || document.getElementById('sel_alarma_edit').value==-1){
		mostrarDiv('error_alarma');	
		return false;
	}	
	if(document.getElementById('sel_alarma_edit').value=='1' && ( document.getElementById('txt_fecha_respuesta_edit').value=='' || document.getElementById('txt_fecha_respuesta_edit').value=='0000-00-00')){
		mostrarDiv('error_fecha_respuesta');	
		return false;
	}

	if(document.getElementById('txt_descripcion_edit').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	document.getElementById('frm_edit_comunicado').action='?mod=comunicados&niv=1&task=saveEdit';
	document.getElementById('frm_edit_comunicado').submit();
}

function validar_edit_alarma_comunicado(){
	
	if(document.getElementById('txt_fecha_respondido').value=='' || document.getElementById('txt_fecha_respondido').value=="0000-00-00"){
		mostrarDiv('error_fecha_respondido');	
		return false;
	}		

	if(document.getElementById('sel_referencia_respondido').value=='' || document.getElementById('sel_referencia_respondido').value==-1){
		mostrarDiv('error_referencia_respondido');	
		return false;
	}		

	document.getElementById('frm_edit_alarma').action='?mod=comunicados&niv=1&task=saveEditAlarma';
	document.getElementById('frm_edit_alarma').submit();
}

function comunicados_en_excel(){

	document.getElementById('frm_excel').action='modulos/documentos/comunicados_en_excel.php';
	document.getElementById('frm_excel').submit();	
}


