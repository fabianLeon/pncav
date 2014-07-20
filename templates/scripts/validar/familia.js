function validar_agregar_familia() {
    if (document.getElementById('txt_descripcion').value == '') {
        mostrarDiv('error_descripcion_familia');
        return false;
    }

    document.getElementById('frm_agregar_familia').action = '?mod=familias&niv=1&task=guardarfamilia';
    document.getElementById('frm_agregar_familia').submit();
}

function validar_agregar_familia_remota(form) {
    if (document.getElementById('txt_descripcion').value == '') {
        mostrarDiv('error_descripcion_familia');
        return false;
    }

    if (form.indexOf('EditarOrden') > -1) {
        id = form.substring(11, form.length);
        document.getElementById('form_agregar_familia_ordendepago').action = '?mod=ordenesdepago&niv=1&task=EditarOrden&familia=true&id_element=' + id;
    }
    else {
        document.getElementById('form_agregar_familia_ordendepago').action = '?mod=ordenesdepago&niv=1&task=' + form + '&familia=true'

    }
    document.getElementById('form_agregar_familia_ordendepago').submit();

}
function validar_editar_familia() {


    if (document.getElementById('txt_descripcion_edit').value == '') {
        mostrarDiv('error_descripcion_familia');
        return false;
    }

    document.getElementById('frm_editar_familia').action = '?mod=familias&niv=1&task=guardaredicion';
    document.getElementById('frm_editar_familia').submit();
}
function cancelarAccionFamilia(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}
function validar_familias_excel() {

    document.getElementById('frm_list_familias').action = 'modulos/financiero/familias_en_excel.php';
    document.getElementById('frm_list_familias').submit();
}