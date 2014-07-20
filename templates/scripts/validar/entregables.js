//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Entregables
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_entregable(){
	if(document.getElementById('sel_etapa').value=='-1'){
		mostrarDiv('error_especie');
		return false;
	}
	if(document.getElementById('txt_entregable').value==''){
		mostrarDiv('error_entregable');	
		return false;
	}
	document.getElementById('frm_add_entregable').action='?mod=entregables&task=saveAdd';
	document.getElementById('frm_add_entregable').submit();
}

function validar_edit_entregable(){
	if(document.getElementById('sel_etapa').value=='-1'){
		mostrarDiv('error_especie');	
		return false;
	}
	if(document.getElementById('txt_entregable').value==''){
		mostrarDiv('error_entregable');		
		return false;
	}
	document.getElementById('frm_edit').action='?mod=entregables&task=saveEdit';
	document.getElementById('frm_edit').submit();
}


