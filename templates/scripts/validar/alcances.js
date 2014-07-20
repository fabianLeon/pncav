//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Alcances
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_alcance1(){

	if(document.getElementById('txt_alcance').value==''){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('txt_fecha_registro').value==''){
		mostrarDiv('error_fecha_registro');	
		return false;
	}
	if(document.getElementById('sel_responsable_contratante').value=='-1'){
		mostrarDiv('error_responsable_contratante');
		return false;
	}
	if(document.getElementById('sel_responsable_contratista').value=='-1'){
		mostrarDiv('error_responsable_contratista');
		return false;
	}
    if(document.getElementById('sel_responsable_interventoria').value=='-1'){
		mostrarDiv('error_responsable_interventoria');
		return false;
	}
    if(document.getElementById('sel_estado').value=='-1'){
		mostrarDiv('error_estado');
		return false;
	}

	document.getElementById('frm_add_alcance').action='?mod=alcances&task=saveAdd';
	document.getElementById('frm_add_alcance').submit();
}

function validar_edit_alcance1(){
	if(document.getElementById('txt_alcance').value==''){
		mostrarDiv('error_alcance');	
		return false;
	}
	if(document.getElementById('txt_fecha_registro').value==''){
		mostrarDiv('error_fecha_registro');	
		return false;
	}
	if(document.getElementById('sel_responsable_contratante').value=='-1'){
		mostrarDiv('error_responsable_contratante');
		return false;
	}
	if(document.getElementById('sel_responsable_contratista').value=='-1'){
		mostrarDiv('error_responsable_contratista');
		return false;
	}
    if(document.getElementById('sel_responsable_interventoria').value=='-1'){
		mostrarDiv('error_responsable_interventoria');
		return false;
	}
    if(document.getElementById('sel_estado').value=='-1'){
		mostrarDiv('error_estado');
		return false;
	}
        
	document.getElementById('frm_edit_alcance').action='?mod=alcances&task=saveEdit';
	document.getElementById('frm_edit_alcance').submit();
}