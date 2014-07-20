//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript obligaciones
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_obligacion_interventoria(){
	if(document.getElementById('sel_componente_add').value=='-1'){
		mostrarDiv('error_componente');
		return false;
	}
	if(document.getElementById('sel_clausula_add').value=='-1'){
		mostrarDiv('error_clausula');
		return false;
	}
	if(document.getElementById('txt_literal_add').value==''){
		mostrarDiv('error_caso_uso');	
		return false;
	}
	if(document.getElementById('txt_descripcion_add').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}	
	
	document.getElementById('frm_add_obligacion_interventoria').action='?mod=obligaciones_interventoria&task=saveAdd';
	document.getElementById('frm_add_obligacion_interventoria').submit();
}

function validar_edit_obligacion_interventoria(){
	if(document.getElementById('sel_componente_edit').value=='-1'){
		mostrarDiv('error_componente');
		return false;
	}
	if(document.getElementById('sel_clausula_edit').value=='-1'){
		mostrarDiv('error_clausula');
		return false;
	}
	if(document.getElementById('txt_literal_edit').value==''){
		mostrarDiv('error_literal');	
		return false;
	}
	if(document.getElementById('txt_descripcion_edit').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}	
	document.getElementById('frm_edit_obligacion_interventoria').action='?mod=obligaciones_interventoria&task=saveEdit';
	document.getElementById('frm_edit_obligacion_interventoria').submit();
}
function validar_add_obligacion_concesion(){
	if(document.getElementById('sel_componente_add').value=='-1'){
		mostrarDiv('error_componente');
		return false;
	}
	if(document.getElementById('sel_clausula_add').value=='-1'){
		mostrarDiv('error_clausula');
		return false;
	}
	if(document.getElementById('txt_literal_add').value==''){
		mostrarDiv('error_caso_uso');	
		return false;
	}
	if(document.getElementById('txt_descripcion_add').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}	
	if(document.getElementById('sel_obligacion_int_add').value=='-1'){
		mostrarDiv('error_obligacion_int');	
		return false;
	}
	if(document.getElementById('sel_periodicidad_add').value=='-1'){
		mostrarDiv('error_periodicidad');	
		return false;
	}
	if(document.getElementById('txt_criterio_add').value==''){
		mostrarDiv('error_criterio');	
		return false;
	}
	
	document.getElementById('frm_add_obligacion_concesion').action='?mod=obligaciones_concesion&task=saveAdd';
	document.getElementById('frm_add_obligacion_concesion').submit();
}

function validar_edit_obligacion_concesion(){
	if(document.getElementById('sel_componente_edit').value=='-1'){
		mostrarDiv('error_componente');
		return false;
	}
	if(document.getElementById('sel_clausula_edit').value=='-1'){
		mostrarDiv('error_clausula');
		return false;
	}
	if(document.getElementById('txt_literal_edit').value==''){
		mostrarDiv('error_literal');	
		return false;
	}
	if(document.getElementById('txt_descripcion_edit').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	if(document.getElementById('sel_obligacion_int_edit').value=='-1'){
		mostrarDiv('error_obligacion_int');	
		return false;
	}
	if(document.getElementById('sel_periodicidad_edit').value=='-1'){
		mostrarDiv('error_periodicidad');	
		return false;
	}
	if(document.getElementById('txt_criterio_edit').value==''){
		mostrarDiv('error_criterio');	
		return false;
	}	
	document.getElementById('frm_edit_obligacion_concesion').action='?mod=obligaciones_concesion&task=saveEdit';
	document.getElementById('frm_edit_obligacion_concesion').submit();
}
function validar_add_obligacion_csr_traza(){

	if(document.getElementById('sel_anio_add').value=='-1'){
		mostrarDiv('error_anio');
		return false;
	}
	if(document.getElementById('sel_mes_add').value=='-1'){
		mostrarDiv('error_mes');
		return false;
	}
	if(document.getElementById('sel_estado_add').value=='-1'){
		mostrarDiv('error_estado');
		return false;
	}
	if(document.getElementById('txt_evidencia_add').value==''){
		mostrarDiv('error_evidencia');	
		return false;
	}
	if(document.getElementById('txt_gestion_add').value==''){
		mostrarDiv('error_gestion');	
		return false;
	}
	if(document.getElementById('txt_recomendacion_add').value==''){
		mostrarDiv('error_recomendacion');	
		return false;
	}	
	document.getElementById('frm_add_obligacion_concesion_traza').action='?mod=obligaciones_concesion&niv=1&task=saveAddObligacionTraza';
	document.getElementById('frm_add_obligacion_concesion_traza').submit();
}
function validar_edit_obligacion_csr_traza(){

	if(document.getElementById('sel_anio_edit').value=='-1'){
		mostrarDiv('error_anio');
		return false;
	}
	if(document.getElementById('sel_mes_edit').value=='-1'){
		mostrarDiv('error_mes');
		return false;
	}
	if(document.getElementById('sel_estado_edit').value=='-1'){
		mostrarDiv('error_estado');
		return false;
	}
	if(document.getElementById('txt_evidencia_edit').value==''){
		mostrarDiv('error_evidencia');	
		return false;
	}
	if(document.getElementById('txt_gestion_edit').value==''){
		mostrarDiv('error_gestion');	
		return false;
	}
	if(document.getElementById('txt_recomendacion_edit').value==''){
		mostrarDiv('error_recomendacion');	
		return false;
	}	
	document.getElementById('frm_edit_obligacion_concesion_traza').action='?mod=obligaciones_concesion&niv=1&task=saveEditObligacionTraza';
	document.getElementById('frm_edit_obligacion_concesion_traza').submit();
}
function obligaciones_en_excel(){

	document.getElementById('frm_excel').action='modulos/obligaciones/obligaciones_en_excel.php';
	document.getElementById('frm_excel').submit();	
}
