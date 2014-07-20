

/**
 * Función que verifica la información de
 * @param {type} form
 * @returns {Boolean}
 */
function validar_agregar_ciudad(){
    
    //Verificación de selección en la lista desplegable de paises
    if(document.getElementById('sel_pais').value == '-1'){
       mostrarDiv('error_pais');
       return false; 
    }
    
    //Verificación de campo de texto nombre de ciudad
    else if(document.getElementById('txt_nombre').value == ''){
       mostrarDiv('error_nombre_ciudad');
       return false; 
    }
    
    else if(/^([0-9])*$/.test(document.getElementById('txt_nombre').value)){
        mostrarDiv('error_nombre_ciudad');
        return false;
    }
    
    document.getElementById('frm_agregar_ciudad').action = '?mod=ciudades&niv=1&task=guardarciudad';
    document.getElementById('frm_agregar_ciudad').submit();
    
}

/**
 * Función que valida la información de la edición de registros de ciudades
 * @returns {Boolean}
 */
function validar_editar_ciudad() {

    //Verificación de selección en la lista desplegable de paises
    if(document.getElementById('sel_pais_edit').value == '-1'){
       mostrarDiv('error_pais');
       return false; 
    }
    
    //Verificación de campo de texto nombre de ciudad
    if(document.getElementById('txt_nombre_edit').value == ''){
       mostrarDiv('error_nombre_ciudad');
       return false; 
    }
    
    if(/^([0-9])*$/.test(document.getElementById('txt_nombre_edit').value)){
        mostrarDiv('error_nombre_ciudad');
        return false;
    }
    
    document.getElementById('frm_editar_ciudad').action = '?mod=ciudades&niv=1&task=guardaredicion';
    document.getElementById('frm_editar_ciudad').submit();
}

function cancelarAccionCiudad(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}

