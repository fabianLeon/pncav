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

function validar_add_validacion(){
	if(document.getElementById('sel_articulo_add').value=='-1'){
		mostrarDiv('error_articulo');	
		return false;
	}
	if(document.getElementById('txt_descripcion_add').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	/*if(document.getElementById('txt_observaciones_add').value==''){
		mostrarDiv('error_observaciones');	
		return false;
	}*/
		
	document.getElementById('frm_add_validacion').action='?mod=validaciones&niv=1&task=saveAdd';
	document.getElementById('frm_add_validacion').submit();
}


function validar_edit_validacion(){
	if(document.getElementById('txt_descripcion_edit').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	/*if(document.getElementById('txt_observaciones_edit').value==''){
		mostrarDiv('error_observaciones');	
		return false;
	}*/
	document.getElementById('frm_edit_validacion').action='?mod=validaciones&niv=1&task=saveEdit';
	document.getElementById('frm_edit_validacion').submit();
}


