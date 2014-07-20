function validar_agregar_moneda() {
    if (document.getElementById('txt_descripcion').value == '') {
        mostrarDiv('error_descripcion_moneda');
        return false;
    }

    document.getElementById('frm_agregar_moneda').action = '?mod=moneda&niv=1&task=guardarmoneda';
    document.getElementById('frm_agregar_moneda').submit();
}
function validar_agregar_moneda_remota(form) {
    
 
    if (document.getElementById('txt_descripcion').value == ''){
        mostrarDiv('error_descripcion_moneda');
        return false;
       
    }    
      

    if (form.indexOf('EditarOrden') > -1) {
        id = form.substring(11, form.length);
        document.getElementById('form_agregar_moneda_ordendepago').action = '?mod=ordenesdepago&niv=1&task=EditarOrden&moneda=true&id_element=' + id;
    }
    else {
        document.getElementById('form_agregar_moneda_ordendepago').action = '?mod=ordenesdepago&niv=1&task=' + form + '&moneda=true'

    }
    document.getElementById('form_agregar_moneda_ordendepago').submit();


}
function validar_editar_moneda() {


    if (document.getElementById('txt_descripcion_edit').value == '') {
        mostrarDiv('error_descripcion_moneda');
        return false;
    }

    document.getElementById('frm_editar_moneda').action = '?mod=moneda&niv=1&task=guardaredicion';
    document.getElementById('frm_editar_moneda').submit();
}
function cancelarAccionMoneda(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}

function validar_monedas_excel() {

    document.getElementById('frm_list_monedas').action = 'modulos/financiero/monedas_en_excel.php';
    document.getElementById('frm_list_monedas').submit();
}