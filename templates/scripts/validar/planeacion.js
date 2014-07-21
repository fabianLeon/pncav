/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validar_add_planeacion() {
    if (document.getElementById('txt_region').value == '-1') {
        mostrarDiv('error_region');
        return false;
    }
    if (document.getElementById('txt_departamento').value == '-1') {
        mostrarDiv('error_departamento');
        return false;
    }
    if (document.getElementById('txt_municipio').value == '-1') {
        mostrarDiv('error_municipio');
        return false;
    }
    if (document.getElementById('txt_eje').value == '-1') {
        mostrarDiv('error_eje');
        return false;
    }
    if (document.getElementById('txt_numero_encuestas').value == '' ||
            !validarEntero(document.getElementById('txt_numero_encuestas').value)) {
        mostrarDiv('error_numero_encuestas');
        return false;
    }
    if (document.getElementById('txt_fecha_inicio').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    if (document.getElementById('txt_fecha_fin').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    if (document.getElementById('txt_usuario').value == '-1') {
        mostrarDiv('error_usuario');
        return false;
    }
    document.getElementById('frm_add_planeacion').action = '?mod=planeacion&niv=1&task=saveAdd';
    document.getElementById('frm_add_planeacion').submit();
}

function consultar_planeacion() {
    if (document.getElementById('txt_criterio').value == "") {
        document.getElementById('txt_criterio').value = "1";
    }
    document.getElementById('frm_list_planeacion').action = '?mod=planeacion&niv=1';
    document.getElementById('frm_list_planeacion').submit();
}
function exportar_excel_planeacion() {
    document.getElementById('frm_list_planeacion').action = 'modulos/planeacion/planeacion_en_excel.php';
    document.getElementById('frm_list_planeacion').submit();
}
function exportar_plantilla_planeacion() {
    document.getElementById('frm_carga_planeacion').action = 'modulos/planeacion/planeacion_plantilla.php';
    document.getElementById('frm_carga_planeacion').submit();
}

function cancelar_busqueda_planeacion() {
    document.getElementById('txt_region').value = '-1';
    document.getElementById('txt_departamento').value = '-1';
    document.getElementById('txt_municipio').value = '-1';
    document.getElementById('txt_eje').value = '-1';
    document.getElementById('txt_fecha_inicio').value = '';
    document.getElementById('txt_fecha_fin').value = '';
    document.getElementById('txt_usuario').value = '-1';
    document.getElementById('frm_list_planeacion').action = '?mod=planeacion&task=list&niv=1';
    document.getElementById('frm_list_planeacion').submit();
}
function cancelarAccion_planeacion(form) {
    document.getElementById('txt_region').value = '-1';
    document.getElementById('txt_departamento').value = '-1';
    document.getElementById('txt_municipio').value = '-1';
    document.getElementById('txt_eje').value = '-1';
    document.getElementById('txt_fecha_inicio').value = '';
    document.getElementById('txt_fecha_fin').value = '';
    document.getElementById('txt_usuario').value = '-1';
    document.getElementById(form).action = '?mod=planeacion&task=list&niv=1';
    document.getElementById(form).submit();
}
function cancelarAccion_planeacion_carga(form) {
    document.getElementById(form).action = '?mod=planeacion&task=list&niv=1';
    document.getElementById(form).submit();

}
function validar_edit_planeacion() {
    if (document.getElementById('txt_region').value == '-1') {
        mostrarDiv('error_region');
        return false;
    }
    if (document.getElementById('txt_departamento').value == '-1') {
        mostrarDiv('error_departamento');
        return false;
    }
    if (document.getElementById('txt_municipio').value == '-1') {
        mostrarDiv('error_municipio');
        return false;
    }
    if (document.getElementById('txt_eje').value == '-1') {
        mostrarDiv('error_eje');
        return false;
    }
    if (document.getElementById('txt_numero_encuestas').value == '' ||
            !validarEntero(document.getElementById('txt_numero_encuestas').value)) {
        mostrarDiv('error_numero_encuestas');
        return false;
    }
    if (document.getElementById('txt_fecha_inicio').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    if (document.getElementById('txt_fecha_fin').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    if (document.getElementById('txt_usuario').value == '-1') {
        mostrarDiv('error_usuario');
        return false;
    }
    document.getElementById('frm_edit_planeacion').action = '?mod=planeacion&task=saveEdit&niv=1';
    document.getElementById('frm_edit_planeacion').submit();
}

function ir_a_carga_masiva(){
    document.getElementById('frm_add_planeacion').action = '?mod=planeacion&task=carga&niv=1';
    document.getElementById('frm_add_planeacion').submit();
}

function validar_carga_planeacion(){
    if (document.getElementById('file_documento_carga').value == '') {
        mostrarDiv('error_documento_carga');
        return false;
    }
    document.getElementById('frm_carga_planeacion').action = '?mod=planeacion&task=saveCarga&niv=1';
    document.getElementById('frm_carga_planeacion').submit();
}