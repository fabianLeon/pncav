function validar_agregar_proveedor(){
	
    
        if(document.getElementById('txt_nit_proveedor').value=='' || 
                !validarEntero(document.getElementById('txt_nit_proveedor').value) || 
                document.getElementById('txt_nit_proveedor').value.length>15){
		mostrarDiv('error_nit');	
		return false;
	}
          
	if(document.getElementById('txt_nombre_proveedor').value==''){
                      
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_telefono_proveedor').value=='' ||
                !validarEntero(document.getElementById('txt_telefono_proveedor').value)|| 
                (document.getElementById('txt_telefono_proveedor').value.length < 7)){
		mostrarDiv('error_telefono');	 
		return false;
	}
	if(document.getElementById('sel_pais_proveedor').value=='-1'){
		mostrarDiv('error_pais');	
		return false;
	}
	if(document.getElementById('sel_ciudad_proveedor').value=='-1'){
		mostrarDiv('error_cuidad');	
		return false;
	}
	if(document.getElementById('txt_direccion_proveedor').value==''){
		mostrarDiv('error_direccion');	
		return false;
	}
	if(document.getElementById('txt_nombre_contac_proveedor').value==''){
		mostrarDiv('error_contacprove');	
		return false;
	}
	if(document.getElementById('txt_ApA_contac_proveedor').value==''){
		mostrarDiv('error_contacprove_apellido');	
		return false;
	}
	if(document.getElementById('txt_ApB_contac_proveedor').value==''){
		ocultarDiv('error_oculto');
	}
	if(document.getElementById('txt_tel_contac_proveedor').value=='' || 
                !validarEntero(document.getElementById('txt_tel_contac_proveedor').value)|| 
                (document.getElementById('txt_tel_contac_proveedor').value.length < 6 )){
		mostrarDiv('error_telcontac');	
		return false;
	}	
	if(document.getElementById('txt_emal_proveedor').value=='' || !validarMail(document.getElementById('txt_emal_proveedor').value)){
		mostrarDiv('error_email');	
		return false;
	}	
	document.getElementById('frm_agregar_proveedor').action='?mod=proveedores&niv=1&task=guardarproveedor';
	document.getElementById('frm_agregar_proveedor').submit();
}
function validar_agregar_proveedor_remoto(form){
	
     if(document.getElementById('txt_nit_proveedor').value=='' || 
             !validarEntero(document.getElementById('txt_nit_proveedor').value) || 
             document.getElementById('txt_nit_proveedor').value.length>15){
		mostrarDiv('error_nit');	
		return false;
	}
          
	if(document.getElementById('txt_nombre_proveedor').value==''){
                      
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_telefono_proveedor').value=='' ||
                !validarEntero(document.getElementById('txt_telefono_proveedor').value)|| 
                (document.getElementById('txt_telefono_proveedor').value.length < 7)){
		mostrarDiv('error_telefono');	 
		return false;
	}
        alert('entro');
	if(document.getElementById('sel_pais_proveedor').value=='-1'){
		mostrarDiv('error_pais');	
		return false;
	}
	if(document.getElementById('sel_ciudad_proveedor').value=='-1'){
		mostrarDiv('error_cuidad');	
		return false;
	}
	if(document.getElementById('txt_direccion_proveedor').value==''){
		mostrarDiv('error_direccion');	
		return false;
	}
	if(document.getElementById('txt_nombre_contac_proveedor').value==''){
		mostrarDiv('error_contacprove');	
		return false;
	}
	if(document.getElementById('txt_ApA_contac_proveedor').value==''){
		mostrarDiv('error_contacprove_apellido');	
		return false;
	}
	if(document.getElementById('txt_ApB_contac_proveedor').value==''){
		ocultarDiv('error_oculto');
	}
	if(document.getElementById('txt_tel_contac_proveedor').value=='' || 
                !validarEntero(document.getElementById('txt_tel_contac_proveedor').value)|| 
                (document.getElementById('txt_tel_contac_proveedor').value.length < 6 )){
		mostrarDiv('error_telcontac');	
		return false;
	}	
	if(document.getElementById('txt_emal_proveedor').value=='' || 
                !validarMail(document.getElementById('txt_emal_proveedor').value)){
		mostrarDiv('error_email');	
		return false;
	}	
        if (form.indexOf('EditarOrden') > -1) {
        id = form.substring(11, form.length);
        document.getElementById('form_agregar_proveedor_ordendepago').action = 
                '?mod=ordenesdepago&niv=1&task=EditarOrden&proveedor=true&id_element=' + id;
    }
    else {
        document.getElementById('form_agregar_proveedor_ordendepago').action = 
                '?mod=ordenesdepago&niv=1&task=' + form + '&proveedor=true'

    }
    document.getElementById('form_agregar_proveedor_ordendepago').submit();
}
function validar_editar_proveedor(){
    
        if(document.getElementById('txt_nit_proveedor_edit').value=='' ||
                !validarEntero(document.getElementById('txt_nit_proveedor_edit').value)||  
                document.getElementById('txt_nit_proveedor_edit').value.length>15){
		mostrarDiv('error_nit');	
		return false;
	}
	if(document.getElementById('txt_nombre_proveedor_edit').value==''){
		mostrarDiv('error_nombre');	
		return false;
	}
	if(document.getElementById('txt_telefono_proveedor_edit').value=='' || 
                !validarEntero(document.getElementById('txt_telefono_proveedor_edit').value)|| 
                (document.getElementById('txt_telefono_proveedor_edit').value.length < 7)){
		mostrarDiv('error_telefono');	
		return false;
	}
	if(document.getElementById('sel_pais_proveedor_edit').value=='-1'){
		mostrarDiv('error_pais');	
		return false;
	}
	if(document.getElementById('sel_ciudad_proveedor_edit').value=='-1'){
		mostrarDiv('error_cuidad');	
		return false;
	}
	if(document.getElementById('txt_direccion_proveedor_edit').value==''){
		mostrarDiv('error_direccion');	
		return false;
	}
	if(document.getElementById('txt_nombre_contac_proveedor_edit').value==''){
		mostrarDiv('error_contacprove');	
		return false;
	}
        if(document.getElementById('txt_ApA_contac_proveedor_edit').value==''){
		mostrarDiv('error_contacprove_apellido');	
		return false;
	}
        if(document.getElementById('txt_ApB_contac_proveedor_edit').value==''){
		ocultarDiv('error_oculto');
	}
	if(document.getElementById('txt_tel_contac_proveedor_edit').value=='' || 
                !validarEntero(document.getElementById('txt_tel_contac_proveedor_edit').value)|| 
                (document.getElementById('txt_tel_contac_proveedor_edit').value.length < 7 )){
		mostrarDiv('error_telcontac');	
		return false;
	}	
	if(document.getElementById('txt_emal_proveedor_edit').value=='' || 
                !validarMail(document.getElementById('txt_emal_proveedor_edit').value)){
		mostrarDiv('error_email');	
		return false;
	}	
	document.getElementById('frm_editar_proveedor').action='?mod=proveedores&niv=1&task=guardaredicion';
	document.getElementById('frm_editar_proveedor').submit();
}
function validar_proveedores_excel(){

	document.getElementById('frm_list_proveedores').action='modulos/financiero/proveedores_en_excel.php';
	document.getElementById('frm_list_proveedores').submit();	
}

function limpiar_campos(){
    document.getElementById('txt_nit_proveedor').value="";
    document.getElementById('txt_nombre_proveedor').value="";
    document.getElementById('txt_telefono_proveedor').value="";
    document.getElementById('txt_pais_proveedor').value="";
    document.getElementById('txt_ciudad_proveedor').value="";
    document.getElementById('txt_direccion_proveedor').value="";
    document.getElementById('txt_nombre_contac_proveedor').value="";
    document.getElementById('txt_ApA_contac_proveedor').value="";
    document.getElementById('txt_ApB_contac_proveedor').value="";
    document.getElementById('txt_tel_contac_proveedor').value="";
    document.getElementById('txt_emal_proveedor').value="";
    document.getElementById('txt_nit_proveedor').focus();
    document.getElementById('frm_agregar_proveedor').submit();
    
    
     
}
function limpiar_campos_editar(){
    document.getElementById('txt_nit_proveedor_edit').value="";
    document.getElementById('txt_nombre_proveedor_edit').value="";
    document.getElementById('txt_telefono_proveedor_edit').value="";
    document.getElementById('txt_pais_proveedor_edit').value="";
    document.getElementById('txt_ciudad_proveedor_edit').value="";
    document.getElementById('txt_direccion_proveedor_edit').value="";
    document.getElementById('txt_nombre_contac_proveedor_edit').value="";
    document.getElementById('txt_ApA_contac_proveedor_edit').value="";
    document.getElementById('txt_ApB_contac_proveedor_edit').value="";
    document.getElementById('txt_tel_contac_proveedor_edit').value="";
    document.getElementById('txt_emal_proveedor_edit').value="";
    document.getElementById('txt_nit_proveedor_edit').focus();
    document.getElementById('frm_editar_proveedor').submit();
       
    }
    
    function cancelarAccionProveedoor(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}
function consultar_proveedores() {

      document.getElementById('frm_list_proveedores').action = '?mod=proveedores&niv=1';
    document.getElementById('frm_list_proveedores').submit();
}
