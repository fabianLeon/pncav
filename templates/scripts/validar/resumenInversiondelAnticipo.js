function exportar_invsersiondelanticipo_excel() {
    document.getElementById('frm_list_resumen_registros_anticipo').action = 'modulos/financiero/resumen_inversion_anticipo_a_excel.php';
    document.getElementById('frm_list_resumen_registros_anticipo').submit();
}