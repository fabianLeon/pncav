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

function validar_add_despliegue(){
	
	if(document.getElementById('sel_despliegue_add').value=='-1'){
		mostrarDiv('error_despliegue');	
		return false;
	}
	if(document.getElementById('sel_alcance_add').value=='-1'){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('sel_tipo_norma_add').value=='-1'){
		mostrarDiv('error_tipo_norma');	
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
	if(document.getElementById('sel_tramite_add').value=='-1'){
		mostrarDiv('error_tramite');	
		return false;
	}
	if(document.getElementById('sel_caso_uso_add').value=='-1'){
		mostrarDiv('error_caso_uso');	
		return false;
	}
	if(document.getElementById('sel_justificacion_add').value=='-1'){
		mostrarDiv('error_justificacion');	
		return false;
	}
	document.getElementById('frm_add_despliegue').action='?mod=validaciones_despliegue&niv=1&task=saveAdd';
	document.getElementById('frm_add_despliegue').submit();
}
function validar_edit_despliegue(){
	
	if(document.getElementById('sel_justificacion_edit').value=='-1'){
		mostrarDiv('error_justificacion');	
		return false;
	}
	document.getElementById('frm_edit_despliegue').action='?mod=validaciones_despliegue&niv=1&task=saveEdit';
	document.getElementById('frm_edit_despliegue').submit();
}

