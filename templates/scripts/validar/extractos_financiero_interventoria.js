/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function validar_add_extracto_interventoria(form){
    if(document.getElementById('sel_cuenta').value == '-1'){
       mostrarDiv('error_cuenta');
       return false; 
    }
    if(document.getElementById('txt_mes').value == "" || 
       document.getElementById('txt_mes').value == "0000-00-00" ){
       mostrarDiv('error_mes');
       return false;
    }
    if(document.getElementById('txt_anio').value == "" || 
       document.getElementById('txt_anio').value == "0000-00-00" ){
       mostrarDiv('error_anio');
       return false;
    }
    if(document.getElementById('txt_saldo_inicial').value == "" ||
       !validarReal(document.getElementById('txt_saldo_inicial').value)){
       mostrarDiv('error_saldo_inicial');
       return false;
    }
    if(document.getElementById('txt_incrementos').value == "" ||
       !validarReal(document.getElementById('txt_incrementos').value)){
       mostrarDiv('error_incrementos');
       return false;
    }
    if(document.getElementById('txt_disminuciones').value == "" ||
       !validarReal(document.getElementById('txt_disminuciones').value)){
       mostrarDiv('error_disminuciones');
       return false;
    }
    if(document.getElementById('txt_observaciones').value == ""){
       mostrarDiv('error_observaciones');
       return false;  
    }
    if(document.getElementById('file_documento_soporte').value == ""){
       mostrarDiv('error_documento_soporte');
       return false;  
    }
//    if(document.getElementById('file_documento_movimientos').value == ""){
//       mostrarDiv('error_documento_movimientos');
//       return false;  
//    }
    
    document.getElementById(form).action='?mod=extractosInt&niv=1&task=saveAdd';
    document.getElementById(form).submit();
}

function validar_edit_extracto_interventoria(form){
    if(document.getElementById('sel_cuenta').value == '-1'){
       mostrarDiv('error_cuenta');
       return false; 
    }
    if(document.getElementById('txt_mes').value == "" || 
       document.getElementById('txt_mes').value == "0000-00-00" ){
       mostrarDiv('error_mes');
       return false;
    }
    if(document.getElementById('txt_anio').value == "" || 
       document.getElementById('txt_anio').value == "0000-00-00" ){
       mostrarDiv('error_anio');
       return false;
    }
    if(document.getElementById('txt_saldo_inicial').value == "" ||
       !validarReal(document.getElementById('txt_saldo_inicial').value)){
       mostrarDiv('error_saldo_inicial');
       return false;
    }
    if(document.getElementById('txt_incrementos').value == "" ||
       !validarReal(document.getElementById('txt_incrementos').value)){
       mostrarDiv('error_incrementos');
       return false;
    }
    if(document.getElementById('txt_disminuciones').value == "" ||
       !validarReal(document.getElementById('txt_disminuciones').value)){
       mostrarDiv('error_disminuciones');
       return false;
    }
    if(document.getElementById('txt_observaciones').value == ""){
       mostrarDiv('error_observaciones');
       return false;  
    }
    if(document.getElementById('file_documento_soporte').value == ""){
       mostrarDiv('error_documento_soporte');
       return false;  
    }
//    if(document.getElementById('file_documento_movimientos').value == ""){
//       mostrarDiv('error_documento_movimientos');
//       return false;  
//    }
    
    document.getElementById(form).action='?mod=extractosInt&niv=1&task=saveEdit';
    document.getElementById(form).submit();
}