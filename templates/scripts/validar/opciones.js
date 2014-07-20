//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Opciones
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_opcion(){
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('sel_nivel').value=='0'){
		if(document.getElementById('txt_variable').value!=''){
			mostrarDiv('error_variable');	
			return false;
		}
		if(document.getElementById('txt_url').value!=''){
			mostrarDiv('error_url');	
			return false;
		}
	}else{
		if(document.getElementById('txt_variable').value==''){
			mostrarDiv('error_variable');	
			return false;
		}
		if(document.getElementById('txt_url').value=='' || !validarUrlOpcion(document.getElementById('txt_url').value)){
			mostrarDiv('error_url');	
			return false;
		}
	}
        
        
	if(document.getElementById('sel_nivel').value=='-1'){
		mostrarDiv('error_nivel');	
		return false;
	}
	if(document.getElementById('txt_orden').value=='' || !validarEntero(document.getElementById('txt_orden').value)){
		mostrarDiv('error_orden');	
		return false;
	}
	document.getElementById('frm_add_opcion').action='?mod=opciones&task=saveAdd';
	document.getElementById('frm_add_opcion').submit();
}

function validar_edit_opcion(){
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('sel_nivel').value=='0'){
		if(document.getElementById('txt_variable').value!=''){
			mostrarDiv('error_variable');	
			return false;
		}
		if(document.getElementById('txt_url').value!=''){
			mostrarDiv('error_url');	
			return false;
		}
	}else{
		if(document.getElementById('txt_variable').value==''){
			mostrarDiv('error_variable');	
			return false;
		}
		if(document.getElementById('txt_url').value=='' || !validarUrlOpcion(document.getElementById('txt_url').value)){
			mostrarDiv('error_url');	
			return false;
		}
	}
	if(document.getElementById('sel_nivel').value=='-1'){
		mostrarDiv('error_nivel');	
		return false;
	}
	if(document.getElementById('txt_orden').value=='' || !validarEntero(document.getElementById('txt_orden').value)){
		mostrarDiv('error_orden');	
		return false;
	}
	document.getElementById('frm_edit_opcion').action='?mod=opciones&task=saveEdit';
	document.getElementById('frm_edit_opcion').submit();
}

