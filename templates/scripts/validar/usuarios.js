//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Usuarios
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//
function validar_add_user(){
	if(document.getElementById('txt_login').value==''){
		mostrarDiv('error_login');	
		return false;
	}
	
	if(document.getElementById('txt_password').value==''){
		mostrarDiv('error_password');	
		return false;
	}
	
	if(document.getElementById('sel_perfil').value=='-1'){
		mostrarDiv('error_perfil');	
		return false;
	}
	
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_apellido').value==''){
		mostrarDiv('error_apellido');	
		return false;
	}
	if(document.getElementById('txt_documento').value==''){
		mostrarDiv('error_documento');	
		return false;
	}
	if(document.getElementById('txt_telefono').value=='' || !validarTelefono(document.getElementById('txt_telefono').value)){
		mostrarDiv('error_telefono');	
		return false;
	}
	if(document.getElementById('txt_celular').value=='' || !validarCelular(document.getElementById('txt_celular').value)){
		mostrarDiv('error_celular');	
		return false;
	}
	if(document.getElementById('txt_correo').value=='' || !validarMail(document.getElementById('txt_correo').value)){
		mostrarDiv('error_correo');	
		return false;
	}
	
	document.getElementById('frm_add_user').action='?mod=usuarios&niv=1&task=saveAdd';
	document.getElementById('frm_add_user').submit();
}


function validar_edit_user(){
	if(document.getElementById('txt_login').value==''){
		mostrarDiv('error_login');	
		return false;
	}
	if(document.getElementById('sel_perfil').value=='-1'){
		mostrarDiv('error_perfil');	
		return false;
	}
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_apellido').value==''){
		mostrarDiv('error_apellido');	
		return false;
	}
	if(document.getElementById('txt_documento').value==''){
		mostrarDiv('error_documento');	
		return false;
	}
	if(document.getElementById('txt_telefono').value=='' || !validarTelefono(document.getElementById('txt_telefono').value)){
		mostrarDiv('error_telefono');	
		return false;
	}
	if(document.getElementById('txt_celular').value=='' || !validarCelular(document.getElementById('txt_celular').value)){
		mostrarDiv('error_celular');	
		return false;
	}
	if(document.getElementById('txt_correo').value=='' || !validarMail(document.getElementById('txt_correo').value)){
		mostrarDiv('error_correo');	
		return false;
	}
	
	document.getElementById('frm_edit_user').action='?mod=usuarios&niv=1&task=saveEdit';
	document.getElementById('frm_edit_user').submit();
}

function validar_login(){
	if(document.getElementById('txt_login_session').value=='' || !validarLogin(document.getElementById('txt_login_session').value)){
		mostrarDiv('error_login');	
		return false;
	}
	if(document.getElementById('txt_password_session').value=='' || !validarLogin(document.getElementById('txt_password_session').value)){
		mostrarDiv('error_password');	
		return false;
	}
	if(document.getElementById('txt_estado').value=='Inactivo'){
		mostrarDiv('error_password');	
		return false;
	}
	document.getElementById('frm_login').action='?mod=home';
	document.getElementById('frm_login').submit();
}

function validar_cambiar_clave(){	
	if(document.getElementById('txt_password').value==''){
		mostrarDiv('error_password');	
		return false;
	}	
	if(document.getElementById('txt_nuevo_password').value==''){
		mostrarDiv('error_nuevo_password');	
		return false;
	}
	document.getElementById('frm_cambiar_clave').action='?mod=usuarios&niv=1&task=saveEditClave';
	document.getElementById('frm_cambiar_clave').submit();
}
