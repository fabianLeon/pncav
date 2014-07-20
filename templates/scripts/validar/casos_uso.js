//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript casos_uso
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_caso(){
	if(document.getElementById('sel_alcance').value=='-1'){
		mostrarDiv('error_alcance');
		return false;
	}
	if(document.getElementById('txt_caso_uso').value==''){
		mostrarDiv('error_caso_uso');	
		return false;
	}
	if(document.getElementById('txt_descripcion').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}	
	if(document.getElementById('sel_estado').value=='-1'){
		mostrarDiv('error_estado');
		return false;
	}	
	document.getElementById('frm_add_caso_uso').action='?mod=casos_uso&task=saveAdd';
	document.getElementById('frm_add_caso_uso').submit();
}

function validar_edit_caso(){
	if(document.getElementById('sel_alcance').value=='-1'){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('txt_caso_uso').value==''){
		mostrarDiv('error_caso_uso');		
		return false;
	}
	if(document.getElementById('txt_descripcion').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}	
	if(document.getElementById('sel_estado').value=='-1'){
		mostrarDiv('error_estado');
		return false;
	}		
	document.getElementById('frm_edit_caso_uso').action='?mod=casos_uso&task=saveEdit';
	document.getElementById('frm_edit_caso_uso').submit();
}
function validar_add_caso_uso_soporte(){
	
	if(document.getElementById('txt_version_add').value=='' || !validarReal(document.getElementById('txt_version_add').value)){
		mostrarDiv('error_version');	
		return false;
	}
	if(document.getElementById('txt_descripcion_add').value==''){
		mostrarDiv('error_descripcion');	
		return false;
	}
	if(document.getElementById('file_archivo').value==''){
		mostrarDiv('error_archivo');	
		return false;
	}
	
	document.getElementById('frm_add_caso_uso_soporte').action='?mod=casos_uso&niv=1&task=saveAddSoporte';
	document.getElementById('frm_add_caso_uso_soporte').submit();
}

function casos_uso_en_excel(){

	document.getElementById('frm_excel').action='modulos/casos_uso/casos_uso_en_excel.php';
	document.getElementById('frm_excel').submit();	
}
