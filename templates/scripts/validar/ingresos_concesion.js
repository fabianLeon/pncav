//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript IngresosConcesion
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_ingreso_concesion(){

	if(document.getElementById('txt_fecha_ingreso').value==''){
		mostrarDiv('error_fecha_ingreso');	
		return false;
	}
	if(document.getElementById('sel_tramite').value==-1){
		mostrarDiv('error_tramite');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cantidad').value)){
		mostrarDiv('error_cantidad');
		return false;
	}
	if(!validarReal(document.getElementById('sel_tarifa').value)){
		mostrarDiv('error_tarifa');
		return false;
	}	
	if(!validarReal(document.getElementById('txt_cantidad_ajuste').value)){
		mostrarDiv('error_cantidad_ajuste');
		return false;
	}
	if(!validarReal(document.getElementById('txt_monto_ajuste').value)){
		mostrarDiv('error_monto_ajuste');
		return false;
	}
	document.getElementById('frm_add_ingreso_concesion').action='?mod=ingresos_concesion&task=saveAdd';
	document.getElementById('frm_add_ingreso_concesion').submit();
}

function validar_edit_ingreso_concesion(){
	if(document.getElementById('txt_fecha_ingreso').value==''){
		mostrarDiv('error_fecha_ingreso');	
		return false;
	}
	if(document.getElementById('sel_tramite').value==-1){
		mostrarDiv('error_tramite');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cantidad').value)){
		mostrarDiv('error_cantidad');
		return false;
	}	
    if(!validarReal(document.getElementById('sel_tarifa').value)){
		mostrarDiv('error_tarifa');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cantidad_ajuste').value)){
		mostrarDiv('error_cantidad_ajuste');
		return false;
	}
	if(!validarReal(document.getElementById('txt_monto_ajuste').value)){
		mostrarDiv('error_monto_ajuste');
		return false;
	}
	document.getElementById('frm_edit_ingreso_concesion').action='?mod=ingresos_concesion&task=saveEdit';
	document.getElementById('frm_edit_ingreso_concesion').submit();
}
function ingresos_concesion_en_excel(){

	document.getElementById('frm_excel').action='modulos/ingresos/ingresos_concesion_en_excel.php';
	document.getElementById('frm_excel').submit();	
}
function ingresos_compara_en_excel(){

	document.getElementById('frm_excel').action='modulos/ingresos/ingresos_compara_en_excel.php';
	document.getElementById('frm_excel').submit();	
}
function ingresos_concesion_carga_excel(){

	document.getElementById('frm_excel_carga').action='modulos/ingresos/ingresos_concesion_carga_excel.php';
	document.getElementById('frm_excel_carga').submit();	
}