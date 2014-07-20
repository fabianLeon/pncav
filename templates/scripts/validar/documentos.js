//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Documentos
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//
function validar_add_documento(){
	if(document.getElementById('sel_tipo_add').value=='-1'){
		mostrarDiv('error_tipo');	
		return false;
	}
	if(document.getElementById('sel_tema_add').value=='-1'){
		mostrarDiv('error_tema');	
		return false;
	}
	if(document.getElementById('sel_subtema_add').value=='-1'){
		mostrarDiv('error_subtema');	
		return false;
	}
	if(document.getElementById('txt_fecha_add').value==''){
		mostrarDiv('error_fecha');	
		return false;
	}
	if(document.getElementById('txt_version_add').value==''){
		mostrarDiv('error_version');	
		return false;
	}
	if(document.getElementById('txt_descripcion_add').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	if(document.getElementById('sel_estado_add').value=='-1'){
		mostrarDiv('error_estado');	
		return false;
	}
	if(document.getElementById('file_documento_add').value==''){
		mostrarDiv('error_documento');	
		return false;
	}	
	document.getElementById('frm_add_documento').action='?mod=documentos&niv=1&task=saveAdd';
	document.getElementById('frm_add_documento').submit();
}


function validar_edit_documento(){
	if(document.getElementById('txt_fecha_edit').value==''){
		mostrarDiv('error_fecha');	
		return false;
	}
	if(document.getElementById('txt_version_edit').value==''){
		mostrarDiv('error_version');	
		return false;
	}	
	if(document.getElementById('txt_descripcion_edit').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	if(document.getElementById('sel_estado_edit').value=='-1'){
		mostrarDiv('error_estado');	
		return false;
	}
	document.getElementById('frm_edit_documento').action='?mod=documentos&niv=1&task=saveEdit';
	document.getElementById('frm_edit_documento').submit();
}


function validar_add_equipo(){
	if(document.getElementById('sel_responsable').value=='-1'){
		mostrarDiv('error_responsable');	
		return false;
	}

	if(document.getElementById('txt_controla_alarmas').value!='S' && document.getElementById('txt_controla_alarmas').value!='N'){
		mostrarDiv('error_controla_alarmas');	
		return false;
	}	
	document.getElementById('frm_add_equipo').action='?mod=documentos_equipos&niv=1&task=saveAdd';
	document.getElementById('frm_add_equipo').submit();
}
function actas_en_excel(){

	document.getElementById('frm_excel').action='modulos/documentos/actas_en_excel.php';
	document.getElementById('frm_excel').submit();	
}
function validar_add_articulo(){
	if(document.getElementById('sel_alcance_add').value=='-1'){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('sel_subtema_add').value=='-1'){
		mostrarDiv('error_subtema');	
		return false;
	}
	if(document.getElementById('sel_norma_add').value=='-1'){
		mostrarDiv('error_norma');	
		return false;
	}
	if(document.getElementById('txt_nombre_add').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_descripcion_add').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	document.getElementById('frm_add_articulo').action='?mod=documentos_articulo&niv=1&task=saveAdd';
	document.getElementById('frm_add_articulo').submit();
}
function validar_edit_articulo(){
	if(document.getElementById('txt_nombre_edit').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_descripcion_edit').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	document.getElementById('frm_edit_articulo').action='?mod=documentos_articulo&niv=1&task=saveEdit';
	document.getElementById('frm_edit_articulo').submit();
}
