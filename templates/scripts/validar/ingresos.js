function Validar_agregar_ingreso(form, accion) {

    if (document.getElementById('ano_ingreso').value == '') {
        mostrarDiv('error_ano');
        return false;
    }


    if (document.getElementById('txt_Monto').value == '' ||  document.getElementById('txt_Monto').value < '0' || !validaFloat(document.getElementById('txt_Monto').value)) {
        mostrarDiv('error_monto');
        return false;
    }
   


    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}
function Validar_editar_ingreso() {


    if (document.getElementById('txt_Monto_edit').value == '' ||  document.getElementById('txt_Monto_edit').value<'0' || !validaFloat(document.getElementById('txt_Monto_edit').value)) {
        mostrarDiv('error_monto');
        return false;
    }

    document.getElementById('frm_editar_ingreso').action = '?mod=ingresos&niv=1&task=GuardarEdicion';
    document.getElementById('frm_editar_ingreso').submit();
}

function cancelarAccionIngreso(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}


function Filtrar_year() {
    document.getElementById('frm_list_resumen_financiero').action = '?mod=ingresos&niv=1';
    document.getElementById('frm_list_resumen_financiero').submit();
}


function exportar_excel_ingresos() {
    document.getElementById('frm_list_ingresos').action = 'modulos/financiero/resumenfinanciero_a_excel.php';
    document.getElementById('frm_list_ingresos').submit();
}

function exportar_egreso_excel() {
    document.getElementById('form_exportar_egresos').action = 'modulos/financiero/egresos_a_excel.php';
    document.getElementById('form_exportar_egresos').submit();
}
function exportar_desembolsos_excel() {
    document.getElementById('form_exportar_desembolsos').action = 'modulos/financiero/desembolsos_a_excel.php';
    document.getElementById('form_exportar_desembolsos').submit();
}
function exportar_utilidades_excel() {
    document.getElementById('form_exportar_utilidades').action = 'modulos/financiero/utilizaciones_a_excel.php';
    document.getElementById('form_exportar_utilidades').submit();
}
function exportar_invsersiones_excel() {
    document.getElementById('form_exportar_inversiones').action = 'modulos/financiero/invseriondelanticipo_a_excel.php';
    document.getElementById('form_exportar_inversiones').submit();
}