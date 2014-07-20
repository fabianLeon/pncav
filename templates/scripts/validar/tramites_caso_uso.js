//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaSvaipt Validaciones
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_caso_uso(){
	
	if(document.getElementById('sel_caso_uso_add').value=='-1'){
		mostrarDiv('error_caso_uso');	
		return false;
	}	
	document.getElementById('frm_add_caso_uso').action='?mod=tramites_caso_uso&niv=1&task=saveAddCasoUso';
	document.getElementById('frm_add_caso_uso').submit();
}

