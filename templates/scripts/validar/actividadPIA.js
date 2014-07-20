/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function consultar_actividades() {
    document.getElementById('frm_list_actividades').action = '?mod=actividadPIA&niv=1';
    document.getElementById('frm_list_actividades').submit();
}
function exportar_excel_actividadPIA() {
    document.getElementById('frm_list_actividades').action = 'modulos/interventoria/actividadPIA_en_excel.php';
    document.getElementById('frm_list_actividades').submit();
}

function validar_add_actividades() {
    if (document.getElementById('txt_descripcion').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }
    if (document.getElementById('txt_monto').value == ''||
            !validarEntero(document.getElementById('txt_monto').value)) {
        mostrarDiv('error_monto');
        return false;
    }
    document.getElementById('frm_add_actividades').action = '?mod=actividadPIA&niv=1&task=saveAdd';
    document.getElementById('frm_add_actividades').submit();
}
function validar_edit_actividades() {
    if (document.getElementById('txt_descripcion').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }
    if (document.getElementById('txt_monto').value == ''||
            !validarEntero(document.getElementById('txt_monto').value)) {
        mostrarDiv('error_monto');
        return false;
    }
    document.getElementById('frm_edit_actividades').action = '?mod=actividadPIA&niv=1&task=saveEdit';
    document.getElementById('frm_edit_actividades').submit();
}


function cancelarAccion_actividadPIA(form) {
    document.getElementById('txt_descripcion').value='';
    document.getElementById(form).action = '?mod=actividadPIA&niv=1';
    document.getElementById(form).submit();
}

function cancelarAccion_actividadPIA_delete(form) {
    
    document.getElementById(form).action = '?mod=actividadPIA&niv=1';
    document.getElementById(form).submit();
}