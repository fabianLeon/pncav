//
// 
//
// <ul>
// <li> Redcom Ltda <www.redcom.com.co></li>
// <li> Proyecto PNCAV</li>
// </ul>
//

//
// JavaScript Compromisos
//
// @package  templates
// @subpackage scripts
// @author Redcom Ltda
// @version 2013.01.00
// @copyright Ministerio de Transporte
//

function validar_add_recomendaciones() {
    if (document.getElementById('sel_subtema_add').value == '-1') {
        mostrarDiv('error_subtema');
        return false;
    }
    if (document.getElementById('sel_responsable_add').value == '-1') {
        mostrarDiv('error_responsable');
        return false;
    }
    if (document.getElementById('txt_actividad').value == '') {
        mostrarDiv('error_actividad');
        return false;
    }
//    if (document.getElementById('txt_consecutivo').value == '') {
//        mostrarDiv('error_consecutivo');
//        return false;
//    }
    
//    if (document.getElementById('sel_referencia').value == '-1') {
//        mostrarDiv('error_referencia');
//        return false;
//    }
    if (document.getElementById('txt_fecha_entrega').value == '' || document.getElementById('txt_fecha_entrega').value == '0000-00-00') {
        mostrarDiv('error_fecha_entrega');
        return false;
    }
//    if (document.getElementById('txt_fecha_limite_add').value == '' || document.getElementById('txt_fecha_limite_add').value == '0000-00-00') {
//        mostrarDiv('error_fecha_limite');
//        return false;
//    }
    if (document.getElementById('sel_estado_add').value == '-1') {
        mostrarDiv('error_estado');
        return false;
    }
    if (document.getElementById('txt_observaciones').value == '') {
        mostrarDiv('error_observaciones');
        return false;
    }

    document.getElementById('frm_add_recomendaciones').action = '?mod=recomendaciones&niv=1&task=saveAdd';
    document.getElementById('frm_add_recomendaciones').submit();
}



function validar_edit_recomendaciones() {
    if (document.getElementById('sel_subtema_edit').value == '-1') {
        mostrarDiv('error_subtema');
        return false;
    }
    
    if (document.getElementById('txt_actividad_edit').value == '') {
        mostrarDiv('error_actividad');
        return false;
    }
//    if (document.getElementById('txt_consecutivo_edit').value == '') {
//        mostrarDiv('error_consecutivo');
//        return false;
//    }
//    if (document.getElementById('sel_subtema_edit').value == '-1') {
//        mostrarDiv('error_subtema');
//        return false;
//    }
//    if (document.getElementById('sel_referencia_edit').value == '-1') {
//        mostrarDiv('error_referencia');
//        return false;
//    }
    if (document.getElementById('txt_fecha_entrega_edit').value == '' || document.getElementById('txt_fecha_entrega_edit').value == '0000-00-00') {
        mostrarDiv('error_fecha_entrega');
        return false;
    }
//    if (document.getElementById('txt_fecha_limite_edit').value == '' || document.getElementById('txt_fecha_limite_edit').value == '0000-00-00') {
//        mostrarDiv('error_fecha_limite');
//        return false;
//    }
    if (document.getElementById('sel_estado_edit').value == '-1') {
        mostrarDiv('error_estado');
        return false;
    }
    if (document.getElementById('txt_observaciones_edit').value == '') {
        mostrarDiv('error_observaciones');
        return false;
    }
    
    document.getElementById('frm_edit_recomendaciones').action = '?mod=recomendaciones&niv=1&task=saveEdit';
    document.getElementById('frm_edit_recomendaciones').submit();
}

function validar_add_responsable_recomendaciones() {

    if (document.getElementById('sel_responsable_add').value == '-1') {
        mostrarDiv('error_responsable');
        return false;
    }

    document.getElementById('frm_add_responsable').action = '?mod=recomendaciones&niv=1&task=saveAddResponsable';
    document.getElementById('frm_add_responsable').submit();
}

function validar_edit_responsable() {
    document.getElementById('frm_edit_responsable').action = '?mod=recomendaciones&niv=1&task=saveResponsables';
    document.getElementById('frm_edit_responsable').submit();
}
function compromisos_en_excel() {

    document.getElementById('frm_excel').action = 'modulos/documentos/compromisos_en_excel.php';
    document.getElementById('frm_excel').submit();
}

function consultar_recomendaciones() {

    if (document.getElementById('txt_criterio').value == "")
        document.getElementById('txt_criterio').value = "1";
    document.getElementById('frm_list_recomendaciones').action = '?mod=recomendaciones&niv=1';
    document.getElementById('frm_list_recomendaciones').submit();
}

function cancelar_busqueda_recomendaciones() {
    document.getElementById('txt_fecha_inicio').value = '';
    document.getElementById('txt_fecha_fin').value = '';
    document.getElementById('sel_responsable').value = '-1';
    document.getElementById('sel_estado').value = '-1';
    document.getElementById('txt_actividad').value = '';
    document.getElementById('txt_criterio').value = '';
    document.getElementById('frm_list_recomendaciones').action = '?mod=recomendaciones&niv=1';
    document.getElementById('frm_list_recomendaciones').submit();
}

function exportar_excel_recomendaciones() {
    document.getElementById('frm_list_recomendaciones').action = 'modulos/documentos/recomendaciones_en_excel.php';
    document.getElementById('frm_list_recomendaciones').submit();
}

