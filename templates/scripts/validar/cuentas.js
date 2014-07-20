//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Tablas
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_edit_cuenta_financiero(){
	form = document.getElementById('frm_edit_tablas');
	for(var i = 0; i < form.elements.length; i++){
		if(form.elements[i].type == 'select-one'){
			if(form.elements[i].value == '-1'){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));	
				return false;
			}
		}else{
			if(form.elements[i].value == ''){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));	
				return false;
			}
		}
	}
	document.getElementById('frm_edit_tablas').action='?mod=cuentas&niv=1&task=saveEdit';
	document.getElementById('frm_edit_tablas').submit();
}

function validar_add_cuenta_financiero(){
	form = document.getElementById('frm_add_tablas');
	for(var i = 0; i < form.elements.length; i++){
		if(form.elements[i].type == 'select-one'){
			if(form.elements[i].value == '-1'){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));	
				return false;
			}
		}else{
			if(form.elements[i].value == ''){
				mostrarDiv('error_'+form.elements[i].name.substring(4,100));	
				return false;
			}
		}
	}
	document.getElementById('frm_add_tablas').action='?mod=cuentas&niv=1&task=saveAdd';
	document.getElementById('frm_add_tablas').submit();
}
