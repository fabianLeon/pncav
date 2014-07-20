//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaSvaipt Involucrados
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_involucrado(){
	if(document.getElementById('sel_tipo_add').value=='' || document.getElementById('sel_tipo_add').value==-1){
		mostrarDiv('error_tipo');	
		return false;
	}
	if(document.getElementById('txt_codigo_add').value=='' || !validarEntero(document.getElementById('txt_codigo_add').value)){
		mostrarDiv('error_codigo');	
		return false;
	}
	if(document.getElementById('txt_nombre_add').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}	
	if(document.getElementById('sel_departamento_add').value=='' || document.getElementById('sel_departamento_add').value==-1){
		mostrarDiv('error_departamento');	
		return false;
	}
	if(document.getElementById('sel_municipio_add').value=='' || document.getElementById('sel_municipio_add').value==-1){
		mostrarDiv('error_municipio');	
		return false;
	}
	if(document.getElementById('txt_direccion_add').value==''){
		mostrarDiv('error_direccion');	
		return false;
	}
	if(document.getElementById('sel_canal_ppal_add').value=='' || document.getElementById('sel_canal_ppal_add').value==-1){
		mostrarDiv('error_canal_ppal');	
		return false;
	}
	if(document.getElementById('sel_canal_bkp_add').value=='' || document.getElementById('sel_canal_bkp_add').value==-1){
		mostrarDiv('error_canal_bkp');	
		return false;
	}
	if(document.getElementById('sel_medio_add').value=='' || document.getElementById('sel_medio_add').value==-1){
		mostrarDiv('error_medio');	
		return false;
	}
	if(document.getElementById('sel_proveedor_add').value=='' || document.getElementById('sel_proveedor_add').value==-1){
		mostrarDiv('error_proveedor');	
		return false;
	}
	if(document.getElementById('sel_conectividad_add').value=='' || document.getElementById('sel_conectividad_add').value==-1){
		mostrarDiv('error_conectividad');	
		return false;
	}
	if(document.getElementById('txt_fecha_ingreso_add').value=='' || document.getElementById('txt_fecha_ingreso_add').value=='0000-00-00'){
		mostrarDiv('error_fecha_ingreso');	
		return false;
	}
	if(document.getElementById('txt_tramites_add').value=='' || !validarEntero(document.getElementById('txt_tramites_add').value)){
		mostrarDiv('error_tramites');	
		return false;
	}
	if(document.getElementById('txt_estado_add').value!='A' && document.getElementById('txt_estado_add').value!='I'){
		mostrarDiv('error_estado');	
		return false;
	}
		
	document.getElementById('frm_add_involucrado').action='?mod=involucrados&niv=1&task=saveAdd';
	document.getElementById('frm_add_involucrado').submit();
}


function validar_edit_involucrado(){
	if(document.getElementById('sel_tipo_edit').value=='' || document.getElementById('sel_tipo_edit').value==-1){
		mostrarDiv('error_tipo');	
		return false;
	}
	if(document.getElementById('txt_codigo_edit').value=='' || !validarEntero(document.getElementById('txt_codigo_edit').value)){
		mostrarDiv('error_codigo');	
		return false;
	}
	if(document.getElementById('txt_nombre_edit').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}	
	if(document.getElementById('sel_departamento_edit').value=='' || document.getElementById('sel_departamento_edit').value==-1){
		mostrarDiv('error_departamento');	
		return false;
	}
	if(document.getElementById('sel_municipio_edit').value=='' || document.getElementById('sel_municipio_edit').value==-1){
		mostrarDiv('error_municipio');	
		return false;
	}
	if(document.getElementById('txt_direccion_edit').value==''){
		mostrarDiv('error_direccion');	
		return false;
	}
	if(document.getElementById('sel_canal_ppal_edit').value=='' || document.getElementById('sel_canal_ppal_edit').value==-1){
		mostrarDiv('error_canal_ppal');	
		return false;
	}
	if(document.getElementById('sel_canal_bkp_edit').value=='' || document.getElementById('sel_canal_bkp_edit').value==-1){
		mostrarDiv('error_canal_bkp');	
		return false;
	}
	if(document.getElementById('sel_medio_edit').value=='' || document.getElementById('sel_medio_edit').value==-1){
		mostrarDiv('error_medio');	
		return false;
	}
	if(document.getElementById('sel_proveedor_edit').value=='' || document.getElementById('sel_proveedor_edit').value==-1){
		mostrarDiv('error_proveedor');	
		return false;
	}
	if(document.getElementById('sel_conectividad_edit').value=='' || document.getElementById('sel_conectividad_edit').value==-1){
		mostrarDiv('error_conectividad');	
		return false;
	}
	if(document.getElementById('txt_fecha_ingreso_edit').value=='' || document.getElementById('txt_fecha_ingreso_edit').value=='0000-00-00'){
		mostrarDiv('error_fecha_ingreso');	
		return false;
	}
	if(document.getElementById('txt_tramites_edit').value=='' || !validarEntero(document.getElementById('txt_tramites_edit').value)){
		mostrarDiv('error_tramites');	
		return false;
	}
	if(document.getElementById('txt_estado_edit').value!='A' && document.getElementById('txt_estado_edit').value!='I'){
		mostrarDiv('error_estado');	
		return false;
	}
	document.getElementById('frm_edit_involucrado').action='?mod=involucrados&niv=1&task=saveEdit';
	document.getElementById('frm_edit_involucrado').submit();
}
function validar_add_involucrado_telefono(){
	
	if(document.getElementById('txt_cuenta').value=='' && document.getElementById('txt_telefono').value=='' && 
		document.getElementById('txt_extension').value=='' && document.getElementById('txt_celular').value==''){
		mostrarDiv('error_cuenta');	
		mostrarDiv('error_telefono');
		mostrarDiv('error_extension');
		mostrarDiv('error_celular');
		return false;
	}
	if(document.getElementById('txt_cuenta').value!='' && !validarEntero(document.getElementById('txt_cuenta').value)){
		mostrarDiv('error_cuenta');	
		return false;
	}
	if(document.getElementById('txt_telefono').value!='' && !validarTelefono(document.getElementById('txt_telefono').value)){
		mostrarDiv('error_telefono');	
		return false;
	}
	if(document.getElementById('txt_extension').value!='' && !validarEntero(document.getElementById('txt_extension').value)){
		mostrarDiv('error_extension');	
		return false;
	}
	if(document.getElementById('txt_celular').value!='' && !validarCelular(document.getElementById('txt_celular').value)){
		mostrarDiv('error_celular');	
		return false;
	}
	document.getElementById('frm_add_involucrado_telefono').action='?mod=involucrados&niv=1&task=saveAddTelefono';
	document.getElementById('frm_add_involucrado_telefono').submit();
}
function validar_edit_involucrado_telefono(){
	
	if(document.getElementById('txt_cuenta').value=='' && document.getElementById('txt_telefono').value=='' && 
		document.getElementById('txt_extension').value=='' && document.getElementById('txt_celular').value==''){
		mostrarDiv('error_cuenta');	
		mostrarDiv('error_telefono');
		mostrarDiv('error_extension');
		mostrarDiv('error_celular');
		return false;
	}
	if(document.getElementById('txt_cuenta').value!='' && !validarEntero(document.getElementById('txt_cuenta').value)){
		mostrarDiv('error_cuenta');	
		return false;
	}
	if(document.getElementById('txt_telefono').value!='' && !validarTelefono(document.getElementById('txt_telefono').value)){
		mostrarDiv('error_telefono');	
		return false;
	}
	if(document.getElementById('txt_extension').value!='' && !validarEntero(document.getElementById('txt_extension').value)){
		mostrarDiv('error_extension');	
		return false;
	}
	if(document.getElementById('txt_celular').value!='' && !validarCelular(document.getElementById('txt_celular').value)){
		mostrarDiv('error_celular');	
		return false;
	}
	document.getElementById('frm_edit_involucrado_telefono').action='?mod=involucrados&niv=1&task=saveEditTelefono';
	document.getElementById('frm_edit_involucrado_telefono').submit();
}
function validar_add_involucrado_contacto(){
	
	if(document.getElementById('txt_nombre').value=='' && document.getElementById('txt_correo').value=='' ){
		mostrarDiv('error_nombre');	
		mostrarDiv('error_correo');
		return false;
	}
	if(document.getElementById('txt_correo').value!='' && !validarMail(document.getElementById('txt_correo').value)){
		mostrarDiv('error_correo');	
		return false;
	}
	
	document.getElementById('frm_add_involucrado_contacto').action='?mod=involucrados&niv=1&task=saveAddContacto';
	document.getElementById('frm_add_involucrado_contacto').submit();
}
function validar_edit_involucrado_contacto(){
	
	if(document.getElementById('txt_nombre').value=='' && document.getElementById('txt_correo').value=='' ){
		mostrarDiv('error_nombre');	
		mostrarDiv('error_correo');
		return false;
	}
	if(document.getElementById('txt_correo').value!='' && !validarMail(document.getElementById('txt_correo').value)){
		mostrarDiv('error_correo');	
		return false;
	}
	document.getElementById('frm_edit_involucrado_contacto').action='?mod=involucrados&niv=1&task=saveEditContacto';
	document.getElementById('frm_edit_involucrado_contacto').submit();
}
function validar_add_involucrado_visita(){
	
	if(document.getElementById('txt_fecha').value=='' || document.getElementById('txt_fecha').value=='0000-00-00'){
		mostrarDiv('error_fecha');	
		return false;
	}
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_correo').value=='' || !validarMail(document.getElementById('txt_correo').value)){
		mostrarDiv('error_correo');	
		return false;
	}
	
	document.getElementById('frm_add_involucrado_visita').action='?mod=involucrados_visita&niv=1&task=saveAddVisita';
	document.getElementById('frm_add_involucrado_visita').submit();
}
function validar_edit_involucrado_visita(){
	
	if(document.getElementById('txt_fecha').value=='' || document.getElementById('txt_fecha').value=='0000-00-00'){
		mostrarDiv('error_fecha');	
		return false;
	}
	if(document.getElementById('txt_nombre').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_correo').value=='' || !validarMail(document.getElementById('txt_correo').value)){
		mostrarDiv('error_correo');	
		return false;
	}
	document.getElementById('frm_edit_involucrado_visita').action='?mod=involucrados_visita&niv=1&task=saveEditVisita';
	document.getElementById('frm_edit_involucrado_visita').submit();
}
function validar_add_involucrado_soporte(){
	
	if(document.getElementById('sel_tipo_add').value=='' || document.getElementById('sel_tipo_add').value=='-1'){
		mostrarDiv('error_tipo');	
		return false;
	}
	if(document.getElementById('file_archivo').value==''){
		mostrarDiv('error_archivo');	
		return false;
	}
	
	document.getElementById('frm_add_involucrado_soporte').action='?mod=involucrados_visita&niv=1&task=saveAddSoporte';
	document.getElementById('frm_add_involucrado_soporte').submit();
}
function validar_add_estado_involucrado(){
	
	if(document.getElementById('txt_fecha').value=='' || document.getElementById('txt_fecha').value=='0000-00-00'){
		mostrarDiv('error_fecha');	
		return false;
	}
	if(document.getElementById('txt_estado').value!='A' && document.getElementById('txt_estado').value!='I'){
		mostrarDiv('error_estado');	
		return false;
	}
	if(document.getElementById('txt_capacidad_1').value=='' || !validarEntero(document.getElementById('txt_capacidad_1').value)){
		mostrarDiv('error_capacidad_1');	
		return false;
	}
	if(document.getElementById('txt_fecha_comunicado').value=='' || document.getElementById('txt_fecha_comunicado').value=='0000-00-00'){
		mostrarDiv('error_fecha_comunicado');	
		return false;
	}
	if(document.getElementById('sel_comunicado').value=='' || document.getElementById('sel_comunicado').value=='-1'){
		mostrarDiv('error_comunicado');	
		return false;
	}
	document.getElementById('frm_add').action='?mod=involucrados_estado&niv=1&task=saveAdd';
	document.getElementById('frm_add').submit();
}
function crc_en_excel(){

	document.getElementById('frm_excel').action='modulos/involucrados/involucrados_estado_en_excel.php';
	document.getElementById('frm_excel').submit();	
}