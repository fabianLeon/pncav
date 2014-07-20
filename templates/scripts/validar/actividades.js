function validar_agregar_actividad() {


    if (document.getElementById('Tipo_actividad').value == '-1') {
        mostrarDiv('error_tipo');
        return false;
    }
    if (document.getElementById('Descrip_actividad').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }

    if (document.getElementById('Monto_actividad').value == '' || document.getElementById('Monto_actividad').value<'0' || !validaFloat(document.getElementById('Monto_actividad').value)) {
        mostrarDiv('error_monto');
        return false;
    }



    document.getElementById('frm_agregar_actividad').action = '?mod=actividades&niv=1&task=GuardarActividad';
    document.getElementById('frm_agregar_actividad').submit();
}
function validar_agregar_actividad_remota(form) {

    if (document.getElementById('Tipo_actividad').value == '-1') {
        mostrarDiv('error_tipo');
        return false;
    }
    if (document.getElementById('Descrip_actividad').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }

    if (document.getElementById('Monto_actividad').value == '' || document.getElementById('Monto_actividad').value<'0' || !validaFloat(document.getElementById('Monto_actividad').value)) {
        mostrarDiv('error_monto');
        return false;
    }
    if (form.indexOf('EditarOrden') > -1) {
        id = form.substring(11, form.length);
        document.getElementById('form_agregar_actividad_ordendepago').action = '?mod=ordenesdepago&niv=1&task=EditarOrden&actividad=true&id_element=' + id;
    }
    else {
        document.getElementById('form_agregar_actividad_ordendepago').action = '?mod=ordenesdepago&niv=1&actividad=true&task=' + form;// + '&actividad=true';

    }
    document.getElementById('form_agregar_actividad_ordendepago').submit();
}



function validar_editar_actividad() {

    if (document.getElementById('Tipo_actividad_edit').value == '-1') {
        mostrarDiv('error_tipo');
        return false;
    }
    if (document.getElementById('Descrip_actividad_edit').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }

    if (document.getElementById('Monto_actividad_edit').value == '' || document.getElementById('Monto_actividad_edit').value<'0' || !validaFloat(document.getElementById('Monto_actividad_edit').value)) {
        mostrarDiv('error_monto');
        return false;
    }



    document.getElementById('frm_editar_actividad').action = '?mod=actividades&niv=1&task=GuardarEdicionActividad';
    document.getElementById('frm_editar_actividad').submit();
}


function cancelarAccionActividad(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}


function exportar_excel_actividades() {
    document.getElementById('frm_list_actividades').action = 'modulos/financiero/actividades_a_excel.php';
    document.getElementById('frm_list_actividades').submit();
}

function consultar_actividades_portipo() {

    if (document.getElementById('Tipo_actividad').value == "") {
        document.getElementById('Tipo_actividad').value = "-1";
    }

    document.getElementById('frm_list_actividades').action = '?mod=actividades&niv=1';
    document.getElementById('frm_list_actividades').submit();
}

