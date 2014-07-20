//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaSvaipt Inventarios
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//


function validar_add_involucrado_equipo(){
	
	if(document.getElementById('sel_equipo').value=='' || document.getElementById('sel_equipo').value=='-1'){
		mostrarDiv('error_equipo');	
		return false;
	}
	if(document.getElementById('sel_marca').value=='' || document.getElementById('sel_marca').value=='-1'){
		mostrarDiv('error_marca');	
		return false;
	}	
	if(document.getElementById('txt_modelo').value==''){
		mostrarDiv('error_modelo');	
		return false;
	}
	if(document.getElementById('txt_serie').value==''){
		mostrarDiv('error_serie');	
		return false;
	}
	if(document.getElementById('txt_placa').value=='' || !validarEntero(document.getElementById('txt_placa').value)){
		mostrarDiv('error_placa');	
		return false;
	}	
	if(document.getElementById('txt_fecha_compra').value=='' || document.getElementById('txt_fecha_compra').value=='0000-00-00'){
		mostrarDiv('error_fecha');	
		return false;
	}
	if(document.getElementById('sel_estado').value=='' || document.getElementById('sel_estado').value=='-1'){
		mostrarDiv('error_estado');	
		return false;
	}	
	
	document.getElementById('frm_add_involucrado_equipo').action='?mod=involucrados_inventario&niv=1&task=saveAddEquipo';
	document.getElementById('frm_add_involucrado_equipo').submit();
}
function validar_edit_involucrado_equipo(){
	
	if(document.getElementById('sel_equipo').value=='' || document.getElementById('sel_equipo').value=='-1'){
		mostrarDiv('error_equipo');	
		return false;
	}
	if(document.getElementById('sel_marca').value=='' || document.getElementById('sel_marca').value=='-1'){
		mostrarDiv('error_marca');	
		return false;
	}	
	if(document.getElementById('txt_modelo').value==''){
		mostrarDiv('error_modelo');	
		return false;
	}
	if(document.getElementById('txt_serie').value==''){
		mostrarDiv('error_serir');	
		return false;
	}
	if(document.getElementById('txt_placa').value=='' || !validarEntero(document.getElementById('txt_placa').value)){
		mostrarDiv('error_placa');	
		return false;
	}	
	if(document.getElementById('txt_fecha_compra').value=='' || document.getElementById('txt_fecha_compra').value=='0000-00-00'){
		mostrarDiv('error_fecha');	
		return false;
	}
	if(document.getElementById('sel_estado').value=='' || document.getElementById('sel_estado').value=='-1'){
		mostrarDiv('error_estado');	
		return false;
	}	
	
	document.getElementById('frm_edit_involucrado_equipo').action='?mod=involucrados_inventario&niv=1&task=saveEditEquipo';
	document.getElementById('frm_edit_involucrado_equipo').submit();
}
function validar_add_inventario_soporte(){
	
	if(document.getElementById('sel_tipo_add').value=='' || document.getElementById('sel_tipo_add').value=='-1'){
		mostrarDiv('error_tipo');	
		return false;
	}
	if(document.getElementById('file_archivo').value==''){
		mostrarDiv('error_archivo');	
		return false;
	}
	
	document.getElementById('frm_add_inventario_soporte').action='?mod=involucrados_inventario&niv=1&task=saveAddSoporte';
	document.getElementById('frm_add_inventario_soporte').submit();
}
function involucrados_inventario_en_excel(){

	document.getElementById('frm_excel').action='modulos/involucrados/involucrados_inventario_en_excel.php';
	document.getElementById('frm_excel').submit();	
}
