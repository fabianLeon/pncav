/* 
 * To change this license heasr, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function validar_add_ejecucion(url) {
    
    if (document.getElementById('file_documento_soporte').value == "") {
        mostrarDiv('error_documento_soporte');
        return false;
    }
    if (document.getElementById('txt_fecha').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    if (document.getElementById('txt_cc').value == '-1') {
        mostrarDiv('error_cc');
        return false;
    }
    if (document.getElementById('txt_cc').value == '2') {
        if (document.getElementById('txt_mci').value == '') {
            mostrarDiv('error_mci');
            return false;
        }
    }else if (document.getElementById('txt_cc').value == '1') {
        document.getElementById('txt_mci').value = '';
    }
    if (document.getElementById('txt_rf').value == '-1') {
        mostrarDiv('error_rf');
        return false;
    }
    if (document.getElementById('txt_vi').value == '-1') {
        mostrarDiv('error_vi');
        return false;
    }
    if (document.getElementById('txt_ri').value == '-1') {
        mostrarDiv('error_ri');
        return false;
    }
    if (document.getElementById('txt_ri').value == '2') {
        if (document.getElementById('txt_mei').value == '') {
            mostrarDiv('error_mei');
            return false;
        }
    }
    else if (document.getElementById('txt_ri').value == '1'){
        document.getElementById('txt_mei').value = '';
    }
    if (document.getElementById('txt_usuario').value == '-1') {
        mostrarDiv('error_usuario');
        return false;
    }
    document.getElementById('frm_add_ejecucion').action = '?mod=ejecucion&niv=1&task=saveAdd' + url;
    document.getElementById('frm_add_ejecucion').submit();
}

function motivo_onchange(error, elemento, ocultar_pgr, ocultar_res) {
    ocultarDiv(error);
    if (document.getElementById(elemento).value === '2') {
        mostrarDiv(ocultar_pgr);
        mostrarDiv(ocultar_res);
    } else {
        ocultarDiv(ocultar_pgr);
        ocultarDiv(ocultar_res);
    }
}
function cancelarAccion_ejecucion(form, url) {
    document.getElementById(form).action = '?mod=ejecucion&niv=1&task=list' + url;
    document.getElementById(form).submit();
}
function consultar_ejecucion() {
    document.getElementById('frm_list_ejecucion').action = '?mod=ejecucion&niv=1';
    document.getElementById('frm_list_ejecucion').submit();
}
function exportar_excel_ejecucion() {
    document.getElementById('frm_list_ejecucion').action = 'modulos/ejecucion/ejecucion_en_excel.php';
    document.getElementById('frm_list_ejecucion').submit();
}
function salto_pregunta(url) {
    document.getElementById('frm_encuesta').action = url;
    document.getElementById('frm_encuesta').submit();
}

function validar_edit_ejecucion(url) {
    
    if (document.getElementById('archivo_anterior').value === '') {
        if (document.getElementById('file_documento_soporte').value == "") {
            mostrarDiv('error_documento_soporte');
            return false;
        }
    }
    if (document.getElementById('txt_fecha').value == '') {
        mostrarDiv('error_fecha');
        return false;
    }
    if (document.getElementById('txt_cc').value == '-1') {
        mostrarDiv('error_cc');
        return false;
    }
    if (document.getElementById('txt_cc').value == '2') {
        if (document.getElementById('txt_mci').value == '') {
            mostrarDiv('error_mci');
            return false;
        }
    }else if (document.getElementById('txt_cc').value == '1') {
        document.getElementById('txt_mci').value = '';
    }
    if (document.getElementById('txt_rf').value == '-1') {
        mostrarDiv('error_rf');
        return false;
    }
    if (document.getElementById('txt_vi').value == '-1') {
        mostrarDiv('error_vi');
        return false;
    }
    if (document.getElementById('txt_ri').value == '-1') {
        mostrarDiv('error_ri');
        return false;
    }
    if (document.getElementById('txt_ri').value == '2') {
        if (document.getElementById('txt_mei').value == '') {
            mostrarDiv('error_mei');
            return false;
        }
    }
    else if (document.getElementById('txt_ri').value == '1'){
        document.getElementById('txt_mei').value = '';
    }
    if (document.getElementById('txt_usuario').value == '-1') {
        mostrarDiv('error_usuario');
        return false;
    }
    document.getElementById('frm_edit_ejecucion').action = '?mod=ejecucion&task=saveEdit&niv=1' + url;
    document.getElementById('frm_edit_ejecucion').submit();
}
function volver_pre_list() {
    document.getElementById('frm_list_ejecucion').action = '?mod=ejecucion&niv=1';
    document.getElementById('frm_list_ejecucion').submit();
}
function salto_automatico(url, form) {
    document.getElementById(form).action = url;
    document.getElementById(form).submit();
}
//new model-----------------------------------------------------------------------------
function cambiarVisibilidad() {
    var inicio = parseInt(document.getElementById('hdd_inicio').value);
    var fin = parseInt(document.getElementById('hdd_fin').value);
    for (i = inicio; i <= fin; i++) {
        var sec = 'sec_' + i;
        ocultarDiv(sec);
        //mostrarDiv(sec);
    }
    mostrarDiv('sec_' + parseInt(document.getElementById('hdd_seccion').value));
    /*
    //Numero P31 Individuo
    if (fin < 13) {
        ocultarDiv(120);
        ocultarDiv('prg_' + 120);
        ocultarDiv('res_' + 120);
    }
    //Numero P30 Org
    if (inicio >= 13) {
        ocultarDiv(246);
        ocultarDiv('prg_' + 246);
        ocultarDiv('res_' + 246);
    }*/
}

function saltar_seccion(url) {
    var num_sec = parseInt(document.getElementById('hdd_seccion').value);
    var fin = parseInt(document.getElementById('hdd_fin').value);
    //cambio seccion
    if (num_sec < fin) {
        document.getElementById('hdd_seccion').value = num_sec + 1;
    }
    document.getElementById('frm_encuestas').action = '?mod=ejecucion&niv=1&task=encuesta&niv=1&id_element=' + url;
    document.getElementById('frm_encuestas').submit();
}
function devolver_seccion() {
    var num_sec = parseInt(document.getElementById('hdd_seccion').value);
    var inicio = parseInt(document.getElementById('hdd_inicio').value);
    var fin = parseInt(document.getElementById('hdd_fin').value);
    if (num_sec > inicio) {
        for (i = inicio; i <= fin; i++) {
            var sec = 'sec_' + i;
            ocultarDiv(sec);
        }
        mostrarDiv('sec_' + (num_sec - 1));
        document.getElementById('hdd_seccion').value = num_sec - 1;
    }
}

function ocultar_preguntas(arreglo_preguntas) {
    arreglo_preguntas = arreglo_preguntas.split("/");
    for (j = 0; j < (arreglo_preguntas.length ); j++) {
        ocultarDiv(arreglo_preguntas[j]);
        ocultarDiv('prg_' + arreglo_preguntas[j]);
        ocultarDiv('res_' + arreglo_preguntas[j]);
    }
    //P16 individuos
    for (i = 60; i <= 65; i++) {
        if (document.getElementById(i).value !== '') {
            for (i = 66; i <= 71; i++) {
                ocultarDiv(i);
                ocultarDiv('prg_' + i);
                ocultarDiv('res_' + i);
            }
        }
    }
}

function saltar_pregunta_onChange(idPregunta, arreglo_saltos, tipo) {
    arreglo_saltos = arreglo_saltos.split("/");
    var id_salto;
    var maxPregunta = arreglo_saltos[1];
    if (tipo === '2') {
        for (j = 0; j < arreglo_saltos.length; j += 2) {
            if (document.getElementById(idPregunta).value === arreglo_saltos[j]) {
                id_salto = parseInt(arreglo_saltos[j + 1]);
            }
            if (arreglo_saltos[j - 1] < arreglo_saltos[j + 1]) {
                maxPregunta = arreglo_saltos[j + 1];
            }
        }
    }
    else if (tipo === '3') {
        var verifica = false;
        for (j = 0; j <arreglo_saltos.length; j += 2) {
            if (document.getElementById(idPregunta).value === arreglo_saltos[j] && document.getElementById('hdd_checked_' + idPregunta).value !== 'checked') {
                id_salto = parseInt(arreglo_saltos[j + 1]);
                document.getElementById('hdd_checked_' + idPregunta).value = 'checked';
                verifica = true;
            }
            if (j > 0) {
                if (arreglo_saltos[j - 1] < arreglo_saltos[j + 1]) {
                    maxPregunta = arreglo_saltos[j + 1];
                }
            }
        }
        if (verifica === false) {
            document.getElementById('hdd_checked_' + idPregunta).value = '';
        }
    }
    else if (tipo === '1') {
        var verifica = false;
        if (document.getElementById(idPregunta).value !== '' && document.getElementById('hdd_checked_'+idPregunta).value !== 'checked') {
            id_salto = parseInt(arreglo_saltos[1]);
            document.getElementById('hdd_checked_'+idPregunta).value = 'checked';
            verifica = true;
        }
        if (verifica === false) {
            document.getElementById('hdd_checked_'+idPregunta).value = '';
        }
    }
    else if (tipo === '5') {
        if (document.getElementById(idPregunta).value !== '') {
            id_salto = parseInt(arreglo_saltos[1]);
        }
    }
    var id = parseInt(idPregunta);
    //Caso especial pregunta P16 individuos
    if (60 <= id && id <= 65) {
        maxPregunta = 72;
        for (i = 60; i <= 65; i++) {
            if (document.getElementById(i).value !== '') {
                id_salto = 72;
            }
        }
        id = 65;
    }

    if (id < maxPregunta) {
        //mostrar las del valor anterior
        for (i = (id + 1); i <= maxPregunta; i++) {
            mostrarDiv(i);
            mostrarDiv('prg_' + i);
            mostrarDiv('res_' + i);
        }
    } else {
        for (i = maxPregunta; i <= id; i++) {
            mostrarDiv(i);
            mostrarDiv('prg_' + i);
            mostrarDiv('res_' + i);
        }
    }

    if (id < id_salto) {
        //ocultar las del nuevo valor
        var h = (id + 1);
        while (h < id_salto) {
            ocultarDiv(h);
            ocultarDiv('prg_' + h);
            ocultarDiv('res_' + h);
            h++;
        }
    } else if (id > id_salto) {
        //ocultar las del nuevo valor
        var h = (id - 1);
        while (h > id_salto) {
            ocultarDiv(h);
            ocultarDiv('prg_' + h);
            ocultarDiv('res_' + h);
            h--;
        }
    }
}
function save_seccion(url) {
    //Pregunta Desarrollo de la encuesta obligatoria
    var num_sec = parseInt(document.getElementById('hdd_seccion').value);
    if (num_sec === 8) {
        if (document.getElementById('141').value == '-1') {
            mostrarDiv('error_pregunta_141');
            return false;
        }
    }
    if (num_sec === 25) {
        if (document.getElementById('267').value == '-1') {
            mostrarDiv('error_pregunta_267');
            return false;
        }
    }
    if (num_sec === 15) {
        if ((parseInt(document.getElementById('170').value)) <= 0 || (parseInt(document.getElementById('170').value)) > 99) {
            mostrarDiv('error_pregunta_170');
            return false;
        }
    }

    document.getElementById('frm_encuesta').action = '?mod=ejecucion&task=saveEncuesta&niv=1&id_element=' + url;
    document.getElementById('frm_encuesta').submit();

}
function importar_excel_ejecucion(form,url){
    document.getElementById(form).action = '?mod=ejecucion&task=carga&niv=1&id_element=' + url;
    document.getElementById(form).submit();
}
function validar_carga_ejecucion(url){
    if (document.getElementById('file_documento_carga').value == '') {
        mostrarDiv('error_documento_carga');
        return false;
    }
    document.getElementById('frm_carga_ejecucion').action = '?mod=ejecucion&task=saveCarga&niv=1&id_element=' + url;
    document.getElementById('frm_carga_ejecucion').submit();
}
function exportar_plantilla_planeacion() {
    document.getElementById('frm_carga_ejecucion').action = 'modulos/ejecucion/ejecucion_plantilla.php';
    document.getElementById('frm_carga_ejecucion').submit();
}

