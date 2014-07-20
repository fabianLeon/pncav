/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function validar_agregar_desembolso(){
    
    var numeros="0123456789";
    var letras ="abcdefghyjklmnñopqrstuvwxyzABCDEFGHYJKLMNÑOPQRSTUVWXYZ";
    
    var texto1 = document.getElementById('txt_numero').value;
    var texto2 = document.getElementById('txt_porcentaje').value;
    var texto3 = document.getElementById('txt_aprobado').value;
    var texto4 = document.getElementById('txt_porcentaje_amortizacion').value;
    var texto5 = document.getElementById('txt_amortizacion').value;
    var texto6 = document.getElementById('txt_desembolso').value;
    var texto7 = document.getElementById('file_soporte').value;
    var texto8 = document.getElementById('file_condiciones').value;
    
    var fecha1 = new Date(document.getElementById('date_fecha').value);
    var fecha2 = new Date(document.getElementById('date_fecha_cumplimiento').value);
    var fecha3 = new Date(document.getElementById('date_fecha_tramite').value);
    var fecha4 = new Date(document.getElementById('date_fecha_limite').value);
    var fecha5 = new Date(document.getElementById('date_fecha_efectiva').value);
    
     //
    if(texto1==''){
       mostrarDiv('error_numero');
       document.getElementById('txt_numero').focus();
       return false;
    }

    if(texto7==''){
       mostrarDiv('error_soporte');
       document.getElementById('file_soporte').focus();
       return false;
    }
    
    if(texto8==''){
       mostrarDiv('error_condiciones');
       document.getElementById('file_condiciones').focus();
       return false;
    }
    //
    if(texto2==''){
       mostrarDiv('error_porcentaje');
       document.getElementById('txt_porcentaje').focus();
       return false;
    }
    for(i=0; i<texto2.length; i++){
      if (letras.indexOf(texto2.charAt(i),0)!=-1){
          document.getElementById('txt_porcentaje').focus();
          mostrarDiv('error_porcentaje');
          return false;
    }}
    //
    
    //
    if(texto3==''){
       mostrarDiv('error_aprobado');
       document.getElementById('txt_aprovado').focus();
       return false;
    }
    for(i=0; i<texto3.length; i++){
      if (letras.indexOf(texto3.charAt(i),0)!=-1){
          document.getElementById('txt_aprovado').focus();
          mostrarDiv('error_aprobado');
          return false;
    }}
    //
    
    //
    if(texto4==''){
       mostrarDiv('error_porcentaje_amortizacion');
       document.getElementById('txt_porcentaje_amortizacion').focus();
       return false;
    }
    for(i=0; i<texto4.length; i++){
      if (letras.indexOf(texto4.charAt(i),0)!=-1){
          mostrarDiv('error_porcentaje_amortizacion');
          document.getElementById('txt_porcentaje_amortizacion').focus();
          return false;
    }}
    //
    
    //
    if(texto5==''){
       mostrarDiv('error_amortizacion');
       document.getElementById('txt_amortizacion').focus();
       return false;
    }
    for(i=0; i<texto5.length; i++){
      if (letras.indexOf(texto5.charAt(i),0)!=-1){
          document.getElementById('txt_amortizacion').focus();
          mostrarDiv('error_amortizacion');
          return false;
    }}
    //
    ocultarDiv('error_fecha_cumplimiento');
    ocultarDiv('error_fecha_tramite');
    ocultarDiv('error_fecha_limite');
    ocultarDiv('error_fecha_efectiva');
    
    if(fecha2>fecha1){
        mostrarDiv('error_fecha_cumplimiento');
        document.getElementById('date_fecha_cumplimiento').focus();
        return false;
    }
    if(fecha3<fecha1){
        mostrarDiv('error_fecha_tramite');
        document.getElementById('date_fecha_tramite').focus();
        return false;
    }
    if(fecha4<fecha1){
        mostrarDiv('error_fecha_limite');
        document.getElementById('date_fecha_limite').focus();
        return false;
    }  
    if(fecha5<fecha1){
        mostrarDiv('error_fecha_efectiva');
        document.getElementById('date_fecha_efectiva').focus();
        return false;
    }
    
    //
    if(texto6==''){
       mostrarDiv('error_desembolso');
       document.getElementById('txt_desembolso').focus();
       return false;
    }
    for(i=0; i<texto6.length; i++){
      if (letras.indexOf(texto6.charAt(i),0)!=-1){
          document.getElementById('txt_desembolso').focus();
          mostrarDiv('error_desembolso');
          return false;
    }}
    //
    
    //
    
    
      
      
    document.getElementById('frm_agregar_desembolso').action = '?mod=desembolso&niv=1&task=guardarDesembolso';
    document.getElementById('frm_agregar_desembolso').submit();
    
}

function validar_editar_desembolso(){
    
    var numeros="0123456789";
    var letras ="abcdefghyjklmnñopqrstuvwxyzABCDEFGHYJKLMNÑOPQRSTUVWXYZ";
    
    var texto1 = document.getElementById('txt_numero_edit').value;
    var texto2 = document.getElementById('txt_porcentaje_edit').value;
    var texto3 = document.getElementById('txt_aprobado_edit').value;
    var texto4 = document.getElementById('txt_porcentaje_amortizacion_edit').value;
    var texto5 = document.getElementById('txt_amortizacion_edit').value;
    var texto6 = document.getElementById('txt_desembolso_edit').value;
    
    var fecha1 = new Date(document.getElementById('date_fecha_edit').value);
    var fecha2 = new Date(document.getElementById('date_fecha_cumplimiento_edit').value);
    var fecha3 = new Date(document.getElementById('date_fecha_tramite_edit').value);
    var fecha4 = new Date(document.getElementById('date_fecha_limite_edit').value);
    var fecha5 = new Date(document.getElementById('date_fecha_efectiva_edit').value);
    
     //
    if(texto1==''){
       mostrarDiv('error_numero');
       return false;
    }
    //
    
    //
    if(texto2==''){
       mostrarDiv('error_porcentaje');
       return false;
    }
    for(i=0; i<texto2.length; i++){
      if (letras.indexOf(texto2.charAt(i),0)!=-1){
          mostrarDiv('error_porcentaje');
          return false;
    }}
    //
    
    //
    if(texto3==''){
       mostrarDiv('error_aprobado');
       return false;
    }
    for(i=0; i<texto3.length; i++){
      if (letras.indexOf(texto3.charAt(i),0)!=-1){
          mostrarDiv('error_aprobado');
          return false;
    }}
    //
    
    //
    if(texto4==''){
       mostrarDiv('error_porcentaje_amortizacion');
       return false;
    }
    for(i=0; i<texto4.length; i++){
      if (letras.indexOf(texto4.charAt(i),0)!=-1){
          mostrarDiv('error_porcentaje_amortizacion');
          return false;
    }}
    //
    
    //
    if(texto5==''){
       mostrarDiv('error_amortizacion');
       return false;
    }
    for(i=0; i<texto5.length; i++){
      if (letras.indexOf(texto5.charAt(i),0)!=-1){
          mostrarDiv('error_amortizacion');
          return false;
    }}
    //
    
    //
    if(texto6==''){
       mostrarDiv('error_desembolso');
       return false;
    }
    for(i=0; i<texto6.length; i++){
      if (letras.indexOf(texto6.charAt(i),0)!=-1){
          mostrarDiv('error_desembolso');
          return false;
    }}
    //
    
    //
    ocultarDiv('error_fecha_cumplimiento');
    ocultarDiv('error_fecha_tramite');
    ocultarDiv('error_fecha_limite');
    ocultarDiv('error_fecha_efectiva');
    
    if(fecha2>fecha1){
        mostrarDiv('error_fecha_cumplimiento');
        return false;
    }
    if(fecha3<fecha1){
        mostrarDiv('error_fecha_tramite');
        return false;
    }
    if(fecha4<fecha1){
        mostrarDiv('error_fecha_limite');
        return false;
    }  
    if(fecha5<fecha1){
        mostrarDiv('error_fecha_efectiva');
        return false;
    }  
      
    document.getElementById('frm_editar_desembolso').action = '?mod=desembolso&niv=1&task=saveEdit';
    document.getElementById('frm_editar_desembolso').submit();
    
}

function cancelarAccionDesembolso(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}

function exportar_archivo_excel_desembolso(){
    document.getElementById('frm_list_desembolso').action = 'modulos/financiero/desembolsos_a_excel.php';
    document.getElementById('frm_list_desembolso').submit();
}