//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Riesgos
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_riesgo1(){
	
	if(document.getElementById('sel_alcance_add').value=='-1'){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('txt_descripcion').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	if(document.getElementById('txt_estrategia').value==''){
		mostrarDiv('error_estrategia');	
		return false;
	}
	if(document.getElementById('txt_fecha_deteccion_add').value==''){
		mostrarDiv('error_fecha_deteccion');	
		return false;
	}
	if(document.getElementById('sel_impacto').value=='-1'){
		mostrarDiv('error_impacto');	
		return false;
	}
	if(document.getElementById('sel_probabilidad').value=='-1'){
		mostrarDiv('error_probabilidad');	
		return false;
	}
	if(document.getElementById('sel_estado_add').value=='-1'){
		mostrarDiv('error_estado_add');	
		return false;
	}	
	document.getElementById('frm_add_riesgo1').action='?mod=riesgos&niv=1&task=saveAdd';
	document.getElementById('frm_add_riesgo1').submit();
}


function validar_edit_riesgo1(){
	if(document.getElementById('sel_alcance_edit').value=='-1'){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('txt_descripcion').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	if(document.getElementById('txt_estrategia').value==''){
		mostrarDiv('error_estrategia');	
		return false;
	}
	if(document.getElementById('txt_fecha_deteccion').value==''){
		mostrarDiv('error_fecha_deteccion');	
		return false;
	}
	if(document.getElementById('sel_estado_edit').value=='-1'){
		mostrarDiv('error_estado');	
		return false;
	}	
	
	document.getElementById('frm_edit_riesgo1').action='?mod=riesgos&niv=1&task=saveEdit';
	document.getElementById('frm_edit_riesgo1').submit();
}

function validar_add_accion1(){
	
	if(document.getElementById('txt_accion').value==''){
		mostrarDiv('error_accion');	
		return false;
	}
	if(document.getElementById('sel_responsable').value=='-1'){
		mostrarDiv('error_responsable');	
		return false;
	}
	if(document.getElementById('txt_fecha_accion').value==''){
		mostrarDiv('error_fecha_accion');	
		return false;
	}
	if(document.getElementById('id_riesgo').value==''){
		mostrarDiv('error_estado');	
		return false;
	}
	if(document.getElementById('sel_impacto').value=='-1'){
		mostrarDiv('error_impacto');	
		return false;
	}
	if(document.getElementById('sel_probabilidad').value=='-1'){
		mostrarDiv('error_probabilidad');	
		return false;
	}
	document.getElementById('frm_add_accion1').action='?mod=riesgos&niv=1&task=saveAddAccion';
	document.getElementById('frm_add_accion1').submit();
}

function validar_edit_accion1(){
	
	if(document.getElementById('txt_accion').value==''){
		mostrarDiv('error_accion');	
		return false;
	}
	if(document.getElementById('sel_responsable').value=='-1'){
		mostrarDiv('error_responsable');	
		return false;
	}
	if(document.getElementById('txt_fecha_accion').value==''){
		mostrarDiv('error_fecha_accion');	
		return false;
	}
	if(document.getElementById('id_riesgo').value==''){
		mostrarDiv('error_estado');	
		return false;
	}
	
	document.getElementById('frm_edit_accion1').action='?mod=riesgos&niv=1&task=saveEditAccion';
	document.getElementById('frm_edit_accion1').submit();
}

function validar_add_rresponsable1(){
	
	if(document.getElementById('sel_responsable_add').value==''){
		mostrarDiv('error_responsable');	
		return false;
	}
	if(document.getElementById('id_riesgo').value==''){
		mostrarDiv('error_responsable');	
		return false;
	}
	
	document.getElementById('frm_add_rresponsable1').action='?mod=riesgos&niv=1&task=saveAddResponsable';
	document.getElementById('frm_add_rresponsable1').submit();
}

function validar_edit_rresponsable1(){
	document.getElementById('frm_edit_rresponsable1').action='?mod=riesgos&niv=1&task=saveResponsables';
	document.getElementById('frm_edit_rresponsable1').submit();
}

function riesgos_en_excel(){

	document.getElementById('frm_excel_riesgos').action='modulos/riesgos/riesgos_en_excel.php';
	document.getElementById('frm_excel_riesgos').submit();	
}