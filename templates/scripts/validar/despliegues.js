//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Despliegues
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_despliegue_nombre(){

	if(document.getElementById('txt_despliegue').value==''){
		mostrarDiv('error_despliegue');	
		return false;
	}
	if(document.getElementById('txt_fecha_programada').value=='' || document.getElementById('txt_fecha_programada').value=='0000-00-00'){
		mostrarDiv('error_fecha_programada');	
		return false;
	}
	if(document.getElementById('txt_fecha_produccion').value=='' || document.getElementById('txt_fecha_produccion').value=='0000-00-00'){
		mostrarDiv('error_fecha_produccion');
		return false;
	}
	document.getElementById('frm_add_despliegue').action='?mod=despliegues&niv=1&task=saveAdd';
	document.getElementById('frm_add_despliegue').submit();
}

function validar_edit_despliegue_nombre(){
	if(document.getElementById('txt_despliegue').value==''){
		mostrarDiv('error_despliegue');	
		return false;
	}
	if(document.getElementById('txt_fecha_programada').value=='' || document.getElementById('txt_fecha_programada').value=='0000-00-00'){
		mostrarDiv('error_fecha_programada');	
		return false;
	}
	if(document.getElementById('txt_fecha_produccion').value=='' || document.getElementById('txt_fecha_produccion').value=='0000-00-00'){
		mostrarDiv('error_fecha_produccion');
		return false;
	}
       
	document.getElementById('frm_edit_despliegue').action='?mod=despliegues&niv=1&task=saveEdit';
	document.getElementById('frm_edit_despliegue').submit();
}
function validar_add_despliegue_validacion(){

	if(document.getElementById('sel_despliegue_add').value=='-1'){
		mostrarDiv('error_despliegue');	
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
	if(document.getElementById('sel_articulo_add').value=='-1'){
		mostrarDiv('error_articulo');	
		return false;
	}
	if(document.getElementById('sel_validacion_add').value=='-1'){
		mostrarDiv('error_validacion');	
		return false;
	}

	document.getElementById('frm_add_validacion').action='?mod=despliegues_validacion&niv=1&task=saveAdd';
	document.getElementById('frm_add_validacion').submit();
}
