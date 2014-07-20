/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function validar_add_correspondencia() {
     if (document.getElementById('sel_area_add').value == '-1') {
        mostrarDiv('error_area');
        return false;
    }
    if (document.getElementById('sel_subtema_add').value == '-1') {
        mostrarDiv('error_subtema');
        return false;
    }
    if (document.getElementById('sel_autor_add').value == '-1') {
        mostrarDiv('error_autor');
        return false;
    }
    if (document.getElementById('sel_destinatario_add').value == '-1') {
        mostrarDiv('error_destinatario');
        return false;
    }    
    if (document.getElementById('txt_fecha_radicado_add').value == '') {
        mostrarDiv('error_fecha_radicado');
        return false;
    }    
    if (document.getElementById('num_consecutivo_add').value == '') {
        mostrarDiv('error_consecutivo');
        return false;
    }    
    if (document.getElementById('txt_codigo_referencia').value == '') {
        mostrarDiv('error_codigo_referencia');
        return false;
    }    
    if (document.getElementById('txt_descripcion_add').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }    
       
    if (document.getElementById('file_correspondencia_soporte_add').value == '') {
        mostrarDiv('error_soporte');
        return false;
    }
    
    if (document.getElementById('sel_anexo_add').value == '-1') {
        mostrarDiv('error_anexo');
        return false;
    }
    
    if (document.getElementById('sel_anexo_add').value == '1') {
        if (document.getElementById('file_correspondencia_anexo_add').value == '') {
            mostrarDiv('error_documento_anexo');
            return false;
        }
    }
    
    if (document.getElementById('sel_seguimiento_add').value == '-1') {
        mostrarDiv('error_seguimiento');
        return false;
    }
    if (document.getElementById('sel_seguimiento_add').value == '1') {
        if (document.getElementById('sel_responsable_add').value == '-1') {
            mostrarDiv('error_responsable');
            return false;
        }
    } 
    
    document.getElementById('frm_add_correspondencia').action = '?mod=correspondencia&niv=1&task=saveAdd';
    document.getElementById('frm_add_correspondencia').submit();
}


function validar_edit_correspondencia() {
     if (document.getElementById('sel_area_add').value == '-1') {
        mostrarDiv('error_area');
        return false;
    }    
    if (document.getElementById('sel_subtema_add').value == '-1') {
        mostrarDiv('error_subtema');
        return false;
    }
    if (document.getElementById('sel_autor_add').value == '') {
        mostrarDiv('error_autor');
        return false;
    }
    if (document.getElementById('sel_destinatario_add').value == '') {
        mostrarDiv('error_destinatario');
        return false;
    }
    
    if (document.getElementById('txt_fecha_radicado_add').value == '') {
        mostrarDiv('error_fecha_radicado');
        return false;
    }
    
    if (document.getElementById('num_consecutivo_add').value == '') {
        mostrarDiv('error_consecutivo');
        return false;
    }
    
    if (document.getElementById('txt_codigo_referencia').value == '') {
        mostrarDiv('error_codigo_referencia');
        return false;
    }

    if (document.getElementById('txt_descripcion_add').value == '') {
        mostrarDiv('error_descripcion');
        return false;
    }
    
    
    
   /* if (document.getElementById('file_correspondencia_soporte_add').value == '') {
        mostrarDiv('error_soporte');
        return false;
    }*/
    
    if (document.getElementById('sel_anexo_add').value == '-1') {
        mostrarDiv('error_anexo');
        return false;
    }
    
    if (document.getElementById('sel_seguimiento_add').value == '-1') {
        mostrarDiv('error_seguimiento');
        return false;
    }
    
    if (document.getElementById('sel_seguimiento_add').value == '1') {
        if (document.getElementById('sel_responsable_add').value == '-1') {
            mostrarDiv('error_responsable');
            return false;
        }
    }

    

    document.getElementById('frm_edit_correspondencia').action = '?mod=correspondencia&task=saveEdit';
    document.getElementById('frm_edit_correspondencia').submit();
}

//-----------------------------------------------------------------------------------------
function validar_responder_correspondencia() {
    if (document.getElementById('txt_fecha_respuesta').value == '') {
        mostrarDiv('error_fecha_respuesta');
        return false;
    }
    
    if (document.getElementById('txt_fecha_respuesta').value != '' && 
            document.getElementById('txt_fecha_respuesta').value != '0000-00-00')
    if (document.getElementById('num_consecutivo_respuesta').value == '-1') {
        mostrarDiv('error_consecutivo_respuesta');
        return false;
    }

    

    document.getElementById('frm_responder_correspondencia').action = '?mod=correspondencia&task=saveResponder';
    document.getElementById('frm_responder_correspondencia').submit();
}
//-----------------------------------------------------------------------------------------

function cancelar_busqueda_correspondencia() {
//    document.getElementById('txt_fecha_inicio').value = '';
//    document.getElementById('txt_fecha_fin').value = '';
//    document.getElementById('sel_autor').value = '-1';
//    document.getElementById('sel_subtema').value = '-1';
//    document.getElementById('sel_destinatario').value = '-1';

    document.getElementById('frm_list_correspondencia').action = '?mod=correspondencia&niv=1';
    document.getElementById('frm_list_correspondencia').submit();
}

function exportar_excel_correspondencia() {
    document.getElementById('frm_list_correspondencia').action = 'modulos/documentos/correspondencia_en_excel.php';
    document.getElementById('frm_list_correspondencia').submit();
    document.getElementById('frm_list_correspondencia').action = '';
}

function verAlertasCorrespondencia(){
    document.getElementById('frm_list_correspondencia').action = '?mod=correspondencia&niv=1&task=listAlarmas';
    document.getElementById('frm_list_correspondencia').submit();
}

function armarReferencia(){
    var fecha = new Date();
    var ano = fecha.getFullYear();

    var cad = "PNCAV-";
    if(document.getElementById('sel_autor_add').value != -1){
        select = document.getElementById('sel_autor_add');
        var str = select.options[select.selectedIndex].text;
        var n = str.indexOf("-"); 
        var res = str.substr(n+1, 4) 
        var cad =  cad + res + "-";
    }
    if(document.getElementById('sel_destinatario_add').value != -1){
        select = document.getElementById('sel_destinatario_add');
        var str = select.options[select.selectedIndex].text;
        var n = str.indexOf("-"); 
        var res = str.substr(n+1, 4) 
        var cad =  cad + res + "-";
    }
    if(document.getElementById('num_consecutivo_add').value!=""){
        var cad =  cad + document.getElementById('num_consecutivo_add').value + "-";
    }
    cad = cad + ano%100;
    
    document.getElementById('txt_codigo_referencia').value = cad;
    
}

function actualizarDestinatario(){
    var select_autores = document.getElementById("sel_autor_add");
    var select_destinatarios = document.getElementById("sel_destinatario_add");
    
    for(i=0;i<select_autores.options.length;i++){
        select_destinatarios.remove(select_autores.options.length-i);
    }
    
    for(i=0;i<select_autores.options.length;i++){
        var option = document.createElement("option");
        option.text = select_autores.options[i].text;
        option.value = select_autores.options[i].value;
        if(option.value != '-1' && i != select_autores.selectedIndex)
            select_destinatarios.options.add(option);
    }
}

function verificarRespuesta(archivo){
    //alert(archivo);
//    var select_respuesta = document.getElementById('num_consecutivo_respuesta_add');
//    for(i=0;i<select_respuesta.options.length;i++){
//        if(select_respuesta.options[i].text==archivo){
//            select_respuesta.selectedIndex = i;
//        }
//    }
    if(document.getElementById('sel_responsable_add').value != -1 ||
       document.getElementById('txt_fecha_respuesta_add').value != "" ||
       document.getElementById('txt_fecha_respuesta_add').value != "0000-00-00"){
        document.getElementById('sel_seguimiento_add').selectedIndex = 1;
    }
    
}

function verificarRespuesta2(archivo){
    //alert(archivo);
    var select_respuesta = document.getElementById('num_consecutivo_respuesta_add');
    for(i=0;i<select_respuesta.options.length;i++){
        if(select_respuesta.options[i].text==archivo){
            select_respuesta.selectedIndex = i;
        }
    }
    
    
}

function actualizaCampos(){
    if(document.getElementById('sel_anexo_add').value == '1'){
        document.getElementById('label_10').style.display='';
        document.getElementById('file_correspondencia_anexo_add').style.display='';
    }else{
        document.getElementById('label_10').style.display='none';
        document.getElementById('file_correspondencia_anexo_add').style.display='none';
        document.getElementById('sel_responsable_add').style.display='none';
    }
    //sel_seguimiento_add
    if(document.getElementById('sel_seguimiento_add').value == '1'){
        document.getElementById('label_12').style.display='';
        document.getElementById('sel_responsable_add').style.display='';
        document.getElementById('label_13').style.display='';
        document.getElementById('txt_fecha_respuesta_add').style.display='';
        document.getElementById('boton_txt_fecha_respuesta_add').style.display='';
        //document.getElementById('label_14').style.display='';
        //document.getElementById('file_correspondencia_respuesta_add').style.display='';
        //document.getElementById('label_15').style.display='';
        //document.getElementById('num_consecutivo_respuesta_add').style.display='';
//        if(document.getElementById('num_consecutivo_respuesta_add').value!=-1){
//            select = document.getElementById('num_consecutivo_respuesta_add');
//            var str = select.options[select.selectedIndex].text;
//            document.getElementById('file_correspondencia_respuesta_add').value = str;
//            var ini = str.indexOf("-")+1;
//            var fin = str.indexOf(".");
//            document.getElementById('consecutivo_correspondencia_respuesta_add').value = str.substring(ini,fin);
//        }else{
//            document.getElementById('file_correspondencia_respuesta_add').value = "";
//            document.getElementById('consecutivo_correspondencia_respuesta_add').value = "";
//        }
        if(validarFechaVencida(document.getElementById('txt_fecha_respuesta_add').value)){
            if(document.getElementById('txt_tiene_documento_respuesta').value != ""){
                document.getElementById('sel_estado_add').value = 2;
            }else{
                if(document.getElementById('txt_requiere_documento_respuesta').value=='si')
                    document.getElementById('sel_estado_add').value = 4; 
                else
                    document.getElementById('sel_estado_add').value = 2;
            }
        }else{
            if(document.getElementById('txt_tiene_documento_respuesta').value != ""){
                document.getElementById('sel_estado_add').value = 2;
            }else{    
                if(document.getElementById('txt_requiere_documento_respuesta').value=='si')
                    document.getElementById('sel_estado_add').value = 3;
                else
                    document.getElementById('sel_estado_add').value = 2;
            }
        }
    }else{
        document.getElementById('label_12').style.display='none';
        document.getElementById('sel_responsable_add').style.display='none';
        document.getElementById('label_13').style.display='none';
        document.getElementById('txt_fecha_respuesta_add').style.display='none';
        document.getElementById('boton_txt_fecha_respuesta_add').style.display='none';
        //document.getElementById('label_14').style.display='none';
        //document.getElementById('file_correspondencia_respuesta_add').style.display='none';
        //document.getElementById('label_15').style.display='none';
        //document.getElementById('num_consecutivo_respuesta_add').style.display='none';//num_consecutivo_respuesta_add
        document.getElementById('sel_estado_add').value = 1;
        
    }
    
    
}

