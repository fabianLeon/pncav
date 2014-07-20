/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function consultar_informe_financiero() {
    document.getElementById('frm_list_informe_financiero').action = '?mod=informeFinanciero&niv=1';
    document.getElementById('frm_list_informe_financiero').submit();
}
function exportar_excel_informe_financiero() {
    document.getElementById('frm_list_informe_financiero').action = 'modulos/interventoria/informeFinanciero_en_excel.php';
    document.getElementById('frm_list_informe_financiero').submit();
}
function cancelarAccion_informe_financiero_delete(form) {
    document.getElementById(form).action = '?mod=informeFinanciero&niv=1';
    document.getElementById(form).submit();
}
function cancelarAccion_informe_financiero(form) {
    document.getElementById('txt_numero_factura').value='';
    document.getElementById('txt_numero_radicado_ministerio').value='';
    document.getElementById(form).action = '?mod=informeFinanciero&niv=1';
    document.getElementById(form).submit();
}

function validar_add_informe_financiero() {
    if (document.getElementById('txt_numero_factura').value === '') {
        mostrarDiv('error_numero_factura');
        return false;
    }
    if (document.getElementById('txt_fecha').value === '') {
        mostrarDiv('error_fecha_factura');
        return false;
    }
    if (document.getElementById('txt_numero_radicado_ministerio').value == '') {
        mostrarDiv('error_numero_radicado_ministerio');
        return false;
    }
    if (document.getElementById('documento_soporte').value == '') {
        mostrarDiv('error_documento_soporte');
        return false;
    }
    
    if (document.getElementById('txt_descripcion').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }
    if (document.getElementById('txt_valor_factura').value == ''||
            !validarEntero(document.getElementById('txt_valor_factura').value)) {
        mostrarDiv('error_valor_factura');
        return false;
    }
    if (document.getElementById('txt_amortizacion').value == ''||
            !validarEntero(document.getElementById('txt_amortizacion').value)) {
        mostrarDiv('error_amortizacion');
        return false;
    }
    if (document.getElementById('txt_observaciones').value == '') {
        mostrarDiv('error_observaciones');
        return false;
    }
    document.getElementById('frm_add_informe_financiero').action = '?mod=informeFinanciero&task=saveAdd';
    document.getElementById('frm_add_informe_financiero').submit();
}
function validar_edit_informe_financiero() {
    if (document.getElementById('txt_numero_factura').value == '') {
        mostrarDiv('error_numero_factura');
        return false;
    }
    if (document.getElementById('txt_fecha').value == '') {
        mostrarDiv('error_fecha_factura');
        return false;
    }
    if (document.getElementById('txt_numero_radicado_ministerio').value == '') {
        mostrarDiv('error_numero_radicado_ministerio');
        return false;
    }
        
    if (document.getElementById('txt_descripcion').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }
    if (document.getElementById('txt_valor_factura').value == ''||
            !validarEntero(document.getElementById('txt_valor_factura').value)) {
        mostrarDiv('error_valor_factura');
        return false;
    }
    if (document.getElementById('txt_amortizacion').value == ''||
            !validarEntero(document.getElementById('txt_amortizacion').value)) {
        mostrarDiv('error_amortizacion');
        return false;
    }
    if (document.getElementById('txt_observaciones').value == '') {
        mostrarDiv('error_observaciones');
        return false;
    }
    document.getElementById('frm_edit_informe_financiero').action = '?mod=informeFinanciero&task=saveEdit';
    document.getElementById('frm_edit_informe_financiero').submit();
}