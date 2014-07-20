/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function consultar_registro_inversion() {
    document.getElementById('frm_list_registro_inversion').action = '?mod=registroInversion&niv=1';
    document.getElementById('frm_list_registro_inversion').submit();
}
function exportar_excel_registro_inversion() {
    document.getElementById('frm_list_registro_inversion').action = 'modulos/interventoria/registroInversion_en_excel.php';
    document.getElementById('frm_list_registro_inversion').submit();
}
function validar_add_registro_inversion() {
    if (document.getElementById('txt_actividad').value == '-1') {
        mostrarDiv('error_actividad');
        return false;
    }
    if (document.getElementById('txt_fecha').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    if (document.getElementById('txt_proveedor').value == '-1') {
        mostrarDiv('error_proveedor');
        return false;
    }
    if (document.getElementById('txt_numero_documento').value == ''||
            !validarEntero(document.getElementById('txt_numero_documento').value)) {
        mostrarDiv('error_numero_documento');
        return false;
    }
    if (document.getElementById('txt_valor').value == ''||
            !validarEntero(document.getElementById('txt_valor').value)) {
        mostrarDiv('error_valor');
        return false;
    }
    if (document.getElementById('txt_observaciones').value == '') {
        mostrarDiv('error_observaciones');
        return false;
    }
    if (document.getElementById('documento_soporte').value == '') {
        mostrarDiv('error_documento_soporte');
        return false;
    }
    
    document.getElementById('frm_add_registro_inversion').action = '?mod=registroInversion&task=saveAdd';
    document.getElementById('frm_add_registro_inversion').submit();
}
function validar_edit_registro_inversion() {
    if (document.getElementById('txt_actividad').value == '-1') {
        mostrarDiv('error_actividad');
        return false;
    }
    if (document.getElementById('txt_fecha').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    if (document.getElementById('txt_proveedor').value == '-1') {
        mostrarDiv('error_proveedor');
        return false;
    }
    if (document.getElementById('txt_numero_documento').value == ''||
            !validarEntero(document.getElementById('txt_numero_documento').value)) {
        mostrarDiv('error_numero_documento');
        return false;
    }
    if (document.getElementById('txt_valor').value == ''||
            !validarEntero(document.getElementById('txt_valor').value)) {
        mostrarDiv('error_valor');
        return false;
    }
    if (document.getElementById('txt_observaciones').value == '') {
        mostrarDiv('error_observaciones');
        return false;
    }
    
    document.getElementById('frm_edit_registro_inversion').action = '?mod=registroInversion&task=saveEdit';
    document.getElementById('frm_edit_registro_inversion').submit();
}
function cancelarAccion_registro_inversion_delete(form){
    document.getElementById(form).action = '?mod=registroInversion&task=list&niv=1';
    document.getElementById(form).submit();
}
function cancelarAccion_registro_inversion(form){
    document.getElementById('txt_actividad').value = '-1'
    document.getElementById('txt_proveedor').value = '-1'
    document.getElementById(form).action = '?mod=registroInversion&task=list&niv=1';
    document.getElementById(form).submit();
}
