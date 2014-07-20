/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function validar_add_documento_acta() {
    if (document.getElementById('sel_subtema_add').value == '-1') {
        mostrarDiv('error_subtema');
        return false;
    }
    if (document.getElementById('txt_descripcion_add').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }
    if (document.getElementById('txt_consecutivo_add').value == '') {
        mostrarDiv('error_consecutivo');
        return false;
    }
    if (document.getElementById('file_acta_add').value == '') {
        mostrarDiv('error_acta');
        return false;
    }
    if (document.getElementById('txt_fecha_add').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    document.getElementById('frm_add_acta').action = '?mod=actas&niv=1&task=saveAdd';
    document.getElementById('frm_add_acta').submit();
}


function validar_edit_documento_acta() {
    if (document.getElementById('sel_subtema').value == '-1') {
        mostrarDiv('error_subtema');
        return false;
    }
    if (document.getElementById('txt_descripcion').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }
    if (document.getElementById('txt_consecutivo').value == '') {
        mostrarDiv('error_consecutivo');
        return false;
    }
    /*if (document.getElementById('file_acta').value == '') {
        mostrarDiv('error_acta');
        return false;
    }*/
    if (document.getElementById('txt_fecha').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    document.getElementById('frm_edit_documento_acta').action = '?mod=actas&niv=1&task=saveEdit';
    document.getElementById('frm_edit_documento_acta').submit();
}

function consultar_actas() {
    if (document.getElementById('txt_criterio').value == "")
        document.getElementById('txt_criterio').value = "1";
    document.getElementById('frm_list_actas').action = '?mod=actas&niv=1';
    document.getElementById('frm_list_actas').submit();
}

function cancelar_busqueda_actas() {
    document.getElementById('txt_fecha_inicio').value = '';
    document.getElementById('txt_fecha_fin').value = '';
    document.getElementById('sel_subtema').value = '-1';
    document.getElementById('txt_descripcion').value = '';
    document.getElementById('frm_list_actas').action = '?mod=actas&niv=1';
    document.getElementById('frm_list_actas').submit();
}

function exportar_excel_actas() {
    document.getElementById('frm_list_actas').action = 'modulos/documentos/actas_en_excel.php';
    document.getElementById('frm_list_actas').submit();
}