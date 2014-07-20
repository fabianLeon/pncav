//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Recursos
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_recurso(){

	if(document.getElementById('txt_nombre_add').value==''){
		mostrarDiv('error_nombre_add');	
		return false;
	}
	
	if(document.getElementById('txt_apellido').value==''){
		mostrarDiv('error_apellido');	
		return false;
	}
	if(document.getElementById('sel_criterio1').value=='-1'){
		mostrarDiv('error_criterio1');	
		return false;
	}
	if(document.getElementById('sel_criterio2').value=='-1'){
		mostrarDiv('error_criterio2');	
		return false;
	}
	if(document.getElementById('sel_criterio3').value=='-1'){
		mostrarDiv('error_criterio3');	
		return false;
	}
	if(document.getElementById('sel_criterio4').value=='-1'){
		mostrarDiv('error_criterio4');	
		return false;
	}
	if(document.getElementById('sel_criterio5').value=='-1'){
		mostrarDiv('error_criterio5');	
		return false;
	}

	if(document.getElementById('sel_criterio7').value=='-1'){
		mostrarDiv('error_criterio7');	
		return false;
	}
	if(document.getElementById('sel_criterio8').value=='-1'){
		mostrarDiv('error_criterio8');	
		return false;
	}
	if(document.getElementById('sel_criterio9').value=='-1'){
		mostrarDiv('error_criterio9');	
		return false;
	}
	if(document.getElementById('sel_criterio10').value=='-1'){
		mostrarDiv('error_criterio10');	
		return false;
	}
	if(document.getElementById('sel_equipo_add').value=='2' && document.getElementById('sel_criterio6').value=='-1'){
		mostrarDiv('error_criterio6');	
		return false;
	}	
	if(document.getElementById('sel_estado_add').value=='-1'){
		mostrarDiv('error_equipo');	
		return false;
	}
	if(document.getElementById('sel_estado_add').value=='4' && (document.getElementById('txt_fecha_estado_add').value=='' || document.getElementById('txt_fecha_estado_add').value=='0000-00-00')){
		mostrarDiv('error_estado');	
		return false;
	}
		
	document.getElementById('frm_add_recurso').action='?mod=recursos&niv=1&task=saveAdd';
	document.getElementById('frm_add_recurso').submit();
}


function validar_edit_recurso(){

	if(document.getElementById('txt_nombre_add').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_apellido').value==''){
		mostrarDiv('error_apellido');	
		return false;
	}
	if(document.getElementById('sel_criterio1').value=='-1'){
		mostrarDiv('error_criterio1');	
		return false;
	}
	if(document.getElementById('sel_criterio2').value=='-1'){
		mostrarDiv('error_criterio2');	
		return false;
	}
	if(document.getElementById('sel_criterio3').value=='-1'){
		mostrarDiv('error_criterio3');	
		return false;
	}
	if(document.getElementById('sel_criterio4').value=='-1'){
		mostrarDiv('error_criterio4');	
		return false;
	}
	if(document.getElementById('sel_criterio5').value=='-1'){
		mostrarDiv('error_criterio5');	
		return false;
	}

	if(document.getElementById('sel_criterio7').value=='-1'){
		mostrarDiv('error_criterio7');	
		return false;
	}
	if(document.getElementById('sel_criterio8').value=='-1'){
		mostrarDiv('error_criterio8');	
		return false;
	}
	if(document.getElementById('sel_criterio9').value=='-1'){
		mostrarDiv('error_criterio9');	
		return false;
	}
	if(document.getElementById('sel_criterio10').value=='-1'){
		mostrarDiv('error_criterio10');	
		return false;
	}
	if(document.getElementById('sel_equipo_add').value=='2' && document.getElementById('sel_criterio6').value=='-1'){
		mostrarDiv('error_criterio6');	
		return false;
	}	
	if(document.getElementById('sel_estado_add').value=='-1'){
		mostrarDiv('error_estado');	
		return false;
	}
	if(document.getElementById('sel_estado_add').value=='4' && (document.getElementById('txt_fecha_estado_add').value=='' || document.getElementById('txt_fecha_estado_add').value=='0000-00-00')){
		mostrarDiv('error_fecha');	
		return false;
	}
	document.getElementById('frm_edit_recurso').action='?mod=recursos&niv=1&task=saveEdit';
	document.getElementById('frm_edit_recurso').submit();
}

function validar_add_soporte_r1(){
	if(document.getElementById('sel_tipo_soporte').value=='-1'){
		mostrarDiv('error_tipo_soporte');	
		return false;
	}
	if(document.getElementById('file_documento').value==''){
		mostrarDiv('error_documento');	
		return false;
	}
	
	document.getElementById('frm_add_soporte_r1').action='?mod=recursos&niv=1&task=saveAddSoporte';
	document.getElementById('frm_add_soporte_r1').submit();
}

function recursos_en_excel(){
	document.getElementById('frm_excel1recursos').action='modulos/recursos/recursos_en_excel.php';
	document.getElementById('frm_excel1recursos').submit();	
}
