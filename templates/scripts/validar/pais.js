
/**
 * Función que valida la información del país para ser agregado
 * @returns {Boolean}
 */
function validar_agregar_pais() {
    if (document.getElementById('txt_nombre').value == '') {
        mostrarDiv('error_nombre_pais');
        return false;
    }
    
     else if(/^([0-9])*$/.test(document.getElementById('txt_nombre').value)){
        mostrarDiv('error_nombre_pais');
        return false;
    }

    document.getElementById('frm_agregar_pais').action = '?mod=paises&niv=1&task=guardarpais';
    document.getElementById('frm_agregar_pais').submit();
}

/**
 * Función que valida información
 * @param {type} form
 * @returns {Boolean}
 */
function validar_agregar_pais_remota(form) {
    if (document.getElementById('txt_nombre').value == '') {
        mostrarDiv('error_nombre_familia');
        return false;
    }

    if (form.indexOf('EditarOrden') > -1) {
        id = form.substring(11, form.length);
        document.getElementById('form_agregar_pais_ordendepago').action = '?mod=ordenesdepago&niv=1&task=EditarOrden&familia=true&id_element=' + id;
    }
    else {
        document.getElementById('form_agregar_familia_ordendepago').action = '?mod=ordenesdepago&niv=1&task=' + form + '&familia=true'

    }
    document.getElementById('form_agregar_familia_ordendepago').submit();

}

/**
 * Función que valida la información para editar un país
 * @returns {Boolean}
 */
function validar_editar_pais() {


    if (document.getElementById('txt_nombre_edit').value == '') {
        mostrarDiv('error_nombre_pais');
        return false;
    }

    if(/^([0-9])*$/.test(document.getElementById('txt_nombre_edit').value)){
        mostrarDiv('error_nombre_pais');
        return false;
    }
    
    document.getElementById('frm_editar_pais').action = '?mod=paises&niv=1&task=guardaredicion';
    document.getElementById('frm_editar_pais').submit();
}
function cancelarAccionPais(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}
function validar_familias_excel() {

    document.getElementById('frm_list_familias').action = 'modulos/financiero/familias_en_excel.php';
    document.getElementById('frm_list_familias').submit();
}