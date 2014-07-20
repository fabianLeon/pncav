function consultar_utilidades() {
    document.getElementById('frm_list_utilidades').action = '?mod=utilizaciones&niv=1';
    document.getElementById('frm_list_utilidades').submit();
}
function validar_utilidades_excel() {
    document.getElementById('frm_list_utilidades').action = 'modulos/financiero/utilidades_en_excel.php';
    document.getElementById('frm_list_utilidades').submit();
}



function validar_agregar_utilidad(form, accion) {

    if (document.getElementById('txt_numero').value == '') {
        mostrarDiv('error_numero_utilizacion');
        return false;
    }

    if (document.getElementById('txt_fecha_comunicado').value == '') {
        mostrarDiv('error_fecha_comunicado');
        return false;
    }
    if (document.getElementById('txt_vigencia').value == '') {
        mostrarDiv('error_vigencia');
        return false;
    }
    if (document.getElementById('file_utilidades_comunicado').value == '') {
        mostrarDiv('error_archivo_comunicado');
        return false;
    }

    if (document.getElementById('txt_porcentaje').value == '') {
        mostrarDiv('error_porcentaje_utilidad');
        return false;
    }
    if (document.getElementById('txt_utilidad_aprobada').value == '' || document.getElementById('txt_utilidad_aprobada').value<'0' || !validaFloat(document.getElementById('txt_utilidad_aprobada').value)) {
        mostrarDiv('error_utilidad_aprobada');
        return false;
    }
    if (document.getElementById('txt_fecha_comite_fiduciario').value == '') {
        mostrarDiv('error_fecha_comite_fiduciario');
        return false;
    }
    var fecha1 =document.getElementById('txt_fecha_comite_fiduciario').value;
    var fecha2 =document.getElementById('txt_fecha_comunicado').value;
    
    if(fecha2>fecha1){
        mostrarDiv('error_fecha_comite_fiduciario');
        return false;
    }

    if (document.getElementById('txt_numero_comite').value == '' || !validarEntero(document.getElementById('txt_numero_comite').value)) {
        mostrarDiv('error_numero_comite');
        return false;
    }

    if (document.getElementById('file_utilidades_acta').value == '') {
        mostrarDiv('error_archivo_acta');
        return false;
    }
    if (document.getElementById('txt_comentarios').value == '') {
        ocultarDiv('error_numero_comite');
    }

    cambiacoma('txt_porcentaje');
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();

}
function validar_editar_utilidad() {

    if (document.getElementById('txt_numero_edit').value == '') {
        mostrarDiv('error_numero_utilizacion');
        return false;
    }
    if (document.getElementById('txt_fecha_comunicado_edit').value == '') {
        mostrarDiv('error_fecha_comunicado');
        return false;
    }
    if (document.getElementById('txt_vigencia_edit').value == '') {
        mostrarDiv('error_fecha_comunicado');
        return false;
    }
    if (document.getElementById('file_utilidades_comunicado_edit').value == '') {
        ocultarDiv('error_archivo_comunicado');
    }

    if (document.getElementById('txt_porcentaje_edit').value == '') {
        mostrarDiv('error_porcentaje_utilidad');
        return false;
    }
    if (document.getElementById('txt_utilidad_aprobada_edit').value == '' || document.getElementById('txt_utilidad_aprobada_edit').value<'0' || !validaFloat(document.getElementById('txt_utilidad_aprobada_edit').value)) {
        mostrarDiv('error_utilidad_aprobada');
        return false;
    }
    if (document.getElementById('txt_fecha_comite_fiduciario_edit').value == '') {
        mostrarDiv('error_fecha_comite_fiduciario');
        return false;
    }

    if (document.getElementById('txt_numero_comite_edit').value == '' || !validarEntero(document.getElementById('txt_numero_comite_edit').value)) {
        mostrarDiv('error_numero_comite');
        return false;
    }

    if (document.getElementById('file_utilidades_acta_edit').value == '') {
        ocultarDiv('error_archivo_acta');


    }
    if (document.getElementById('txt_comentarios_edit').value == '') {
        ocultarDiv('error_numero_comite');
    }

    cambiacoma('txt_porcentaje_edit');
    document.getElementById('frm_editar_utilidad').action = '?mod=utilizaciones&niv=1&task=guardaredicion';
    document.getElementById('frm_editar_utilidad').submit();

}

function cancelarAccionUtilidad(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}

function cambiacoma(id)
{
    document.getElementById(id).value = document.getElementById(id).value.replace(',', '.');
}