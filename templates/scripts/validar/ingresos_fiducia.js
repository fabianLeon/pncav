//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Ingresos
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_ingresos_fiducia(){

	if(document.getElementById('txt_fecha_ingreso').value==''){
		mostrarDiv('error_fecha_ingreso');	
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_1').value)){
		mostrarDiv('error_cuenta_1');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_2').value)){
		mostrarDiv('error_cuenta_2');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_3').value)){
		mostrarDiv('error_cuenta_3');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_4').value)){
		mostrarDiv('error_cuenta_4');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_5').value)){
		mostrarDiv('error_cuenta_5');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_6').value)){
		mostrarDiv('error_cuenta_6');
		return false;
	}	
	document.getElementById('frm_add_ingreso_fiducia').action='?mod=ingresos_fiducia&task=saveAdd';
	document.getElementById('frm_add_ingreso_fiducia').submit();
}

function validar_edit_ingresos_fiducia(){
	if(document.getElementById('txt_fecha_ingreso').value==''){
		mostrarDiv('error_fecha_ingreso');	
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_1').value)){
		mostrarDiv('error_cuenta_1');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_2').value)){
		mostrarDiv('error_cuenta_2');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_3').value)){
		mostrarDiv('error_cuenta_3');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_4').value)){
		mostrarDiv('error_cuenta_4');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_5').value)){
		mostrarDiv('error_cuenta_5');
		return false;
	}
	if(!validarReal(document.getElementById('txt_cuenta_6').value)){
		mostrarDiv('error_cuenta_6');
		return false;
	}	
        
	document.getElementById('frm_edit_ingreso_fiducia').action='?mod=ingresos_fiducia&task=saveEdit';
	document.getElementById('frm_edit_ingreso_fiducia').submit();
}
function ingresos_fiducia_en_excel(){

	document.getElementById('frm_excel').action='modulos/ingresos/ingresos_fiducia_en_excel.php';
	document.getElementById('frm_excel').submit();	
}