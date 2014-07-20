function cancelarAccionordendepago(form, accion) {
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}
function cancelarAccionoradicionarEditar(form, accion) {
    
     if (document.getElementById('sel_tipo_actividad').value != "")
        document.getElementById('sel_tipo_actividad').value = "-1";
    if (document.getElementById('sel_actividad').value != "")
        document.getElementById('sel_actividad').value = "-1";
       if (document.getElementById('sel_proveedor').value != "")
        document.getElementById('sel_proveedor').value = "-1";
    document.getElementById(form).action = accion;
    document.getElementById(form).submit();
}

function validar_agregar_producto(){
    var letras="qwertyuiopñlkjhgfdsazxcvbnm";
    var texto1 = document.getElementById('txt_cantidad').value;
    var texto2 = document.getElementById('txt_valor').value;
    
    //Verificación de selección en la lista desplegable de tipos
    if(document.getElementById('sel_tipo').value === '-1'){
       mostrarDiv('error_tipo');
       document.getElementById('sel_tipo').focus();
       return false; 
    }
    
    //Verificación de selección en la lista desplegable de paises
    if(document.getElementById('sel_familia').value === '-1'){
       mostrarDiv('error_familia');
       document.getElementById('sel_familia').focus();
       return false; 
    }
    
    if(document.getElementById('txt_descripcion').value==''){
       mostrarDiv('error_descripcion');
       document.getElementById('txt_descripcion').focus();
       return false; 
    }
    
    if(texto1 === ''){
       mostrarDiv('error_cantidad');
       document.getElementById('txt_cantidad').focus();
       return false; 
    }
    
    for(i=0; i<texto1.length; i++){
      if (letras.indexOf(texto1.charAt(i),0)!==-1){
          document.getElementById('txt_cantidad').focus();
          mostrarDiv('error_cantidad');
          return false;
    }}

    if(texto2 === ''){
       mostrarDiv('error_valor');
       document.getElementById('txt_valor').focus();
       return false; 
    }
    
    for(i=0; i<texto2.length; i++){
      if (letras.indexOf(texto2.charAt(i),0)!==-1){
          document.getElementById('txt_valor').focus();
          mostrarDiv('error_valor');
          return false;
    }}

        document.getElementById('frm_agregar_producto').action = '?mod=ordenesdepago&niv=1&task=ConfirmarAgregarProducto';
        document.getElementById('frm_agregar_producto').submit();
}

function validar_editar_producto(){
    window.alert('Entro');
    var letras="qwertyuiopñlkjhgfdsazxcvbnm";
    var texto1 = document.getElementById('txt_cantidad').value;
    var texto2 = document.getElementById('txt_valor').value;
    
    //Verificación de selección en la lista desplegable de tipos
    if(document.getElementById('sel_tipo').value === '-1'){
       mostrarDiv('error_tipo');
       document.getElementById('sel_tipo').focus();
       return false; 
    }
    
    //Verificación de selección en la lista desplegable de paises
    if(document.getElementById('sel_familia').value === '-1'){
       mostrarDiv('error_familia');
       document.getElementById('sel_familia').focus();
       return false; 
    }
    
    if(document.getElementById('txt_descripcion').value==''){
       mostrarDiv('error_descripcion');
       document.getElementById('txt_descripcion').focus();
       return false; 
    }
    
    if(texto1 === ''){
       mostrarDiv('error_cantidad');
       document.getElementById('txt_cantidad').focus();
       return false; 
    }
    
    for(i=0; i<texto1.length; i++){
      if (letras.indexOf(texto1.charAt(i),0)!==-1){
          document.getElementById('txt_cantidad').focus();
          mostrarDiv('error_cantidad');
          return false;
    }}

    if(texto2 === ''){
       mostrarDiv('error_valor');
       document.getElementById('txt_valor').focus();
       return false; 
    }
    
    for(i=0; i<texto2.length; i++){
      if (letras.indexOf(texto2.charAt(i),0)!==-1){
          document.getElementById('txt_valor').focus();
          mostrarDiv('error_valor');
          return false;
    }}

        document.getElementById('frm_editar_producto').action = '?mod=ordenesdepago&niv=1&task=ConfirmarEditarProducto';
        document.getElementById('frm_editar_producto').submit();
}

function validar_agregar_ordendepago(form, action) {
    
    if(document.getElementById('sel_reintegro').value == -1){
        mostrarDiv('error_sel_reintegro');
        return false;
    }

    if(document.getElementById('sel_reintegro').value == 2){
            if(document.getElementById('txt_reintegro').value == ''){
                mostrarDiv('error_proveedor');
                document.getElementById('txt_reintegro').focus();
                return false;
            }
        }

    if (document.getElementById('sel_estado').value == '-1') {
        mostrarDiv('error_sel_estado');
        return false;
    }

    if (document.getElementById('sel_estado').value == '1' || document.getElementById('sel_estado').value == '4') {

        if (document.getElementById('sel_tipo_actividad').value == '-1') {
            mostrarDiv('error_sel_tipo_actividad');
            return false;
        }

        if (document.getElementById('sel_actividad').value == '-1') {

            mostrarDiv('error_sel_actividad');
            return false;
        }

        if (document.getElementById('sel_proveedor').value == '-1') {
            mostrarDiv('error_sel_proveedor');
            return false;
        }

        if (document.getElementById('sel_moneda').value == '-1') {
            mostrarDiv('error_sel_moneda');
            return false;
        }

        if (document.getElementById('sel_moneda').value != '1' && document.getElementById('txt_tasa').value == '') {
            mostrarDiv('error_tasa');
            return false;
        }
        if (document.getElementById('txt_numero_ordendepago').value == '' ) {
            mostrarDiv('error_numero_ordendepago');
            return false;
        }


        if (document.getElementById('fecha_orden').value == '') {
            mostrarDiv('error_fecha_orden');
            return false;
        }
        if (document.getElementById('txt_numero_factura').value == '' ) {
            mostrarDiv('error_numero_factura');
            return false;
        }



        if (document.getElementById('txt_valor_total_orden').value === '' || !validarEntero(document.getElementById('txt_valor_total_orden').value) || !validarRealMayor(document.getElementById('txt_valor_total_orden').value,0)) {
            mostrarDiv('error_valor_total');
            return false;
        }
        if (document.getElementById('sel_estado').value == '4') {
            if (document.getElementById('fecha_pago_orden').value == '') {
                mostrarDiv('error_fecha_pago_orden');
                return false;
            }
        }

//        if (document.getElementById('txt_observaciones').value == '') {
//            mostrarDiv('error_observaciones');
//            return false;
//        }
        if (document.getElementById('file_orden_add').value == '') {
            mostrarDiv('error_archivo');
            return false;
        }

        if (document.getElementById('sel_moneda').value != '1') {
            cambiacoma('txt_tasa');
        }
        
        if (document.getElementById('txt_valor_total_orden').value === '' || !validarEntero(document.getElementById('txt_valor_total_orden').value) || !validarRealMayor(document.getElementById('txt_valor_total_orden').value,0)) {
            mostrarDiv('error_valor_total');
            return false;
        }

        document.getElementById('openproducto').click();
    }


    if (document.getElementById('sel_estado').value == '3' || document.getElementById('sel_estado').value == '2') {

        if (document.getElementById('sel_estado').value == '-1') {
            mostrarDiv('error_sel_estado');
            return false;
        }
        if (document.getElementById('sel_tipo_actividad').value == '-1') {
            mostrarDiv('error_sel_tipo_actividad');
            return false;
        }

        if (document.getElementById('sel_actividad').value == '-1') {

            mostrarDiv('error_sel_actividad');
            return false;
        }

        if (document.getElementById('sel_proveedor').value == '-1') {
            mostrarDiv('error_sel_proveedor');
            return false;
        }


       if (document.getElementById('sel_moneda').value == '-1') {
            mostrarDiv('error_sel_moneda');
            return false;
        }


        if (document.getElementById('sel_moneda').value != '1') {
            if (document.getElementById('txt_tasa').value == '') {
                mostrarDiv('error_tasa');
                return false;
            }
        }
        if (document.getElementById('fecha_orden').value == '') {
            mostrarDiv('error_fecha_orden');
            return false;
        }
        
        
        if (document.getElementById('sel_moneda').value != '1') {
            cambiacoma('txt_tasa');
        }

        if (document.getElementById('txt_valor_total_orden').value == '' || !validarEntero(document.getElementById('txt_valor_total_orden').value) || ! validarRealMayor(document.getElementById('txt_valor_total_orden').value,0)) {
            mostrarDiv('error_valor_total');
            return false;
        }


        document.getElementById('openproducto').click();
    }
}

function validar_editar_ordendepago() {



    if (document.getElementById('sel_estado_edit').value == '1' || document.getElementById('sel_estado_edit').value == '4') {

        if (document.getElementById('sel_tipo_actividad_edit').value == '-1') {
            mostrarDiv('error_sel_tipo_actividad');
            return false;
        }

        if (document.getElementById('sel_actividad_edit').value == '-1') {

            mostrarDiv('error_sel_actividad');
            return false;
        }

        if (document.getElementById('sel_proveedor_edit').value == '-1') {
            mostrarDiv('error_sel_proveedor');
            return false;
        }


        if (document.getElementById('txt_numero_ordendepago_edit').value == '' ) {
            mostrarDiv('error_valor_total');
            return false;
        }

        if (document.getElementById('fecha_orden_edit').value == '') {
            mostrarDiv('error_fecha_orden');
            return false;
        }

        if (document.getElementById('txt_numero_factura_edit').value == '') {
            mostrarDiv('error_numero_factura');
            return false;
        }



        if (document.getElementById('sel_moneda_edit').value == '-1') {
            mostrarDiv('error_sel_moneda');
            return false;
        }


        if (document.getElementById('sel_moneda_edit').value != '1' && document.getElementById('txt_tasa_edit').value == '') {
            mostrarDiv('error_tasa');
            return false;

        }

        if (document.getElementById('txt_valor_total_orden_edit').value == '' || !validarEntero(document.getElementById('txt_valor_total_orden_edit').value) || ! validarRealMayor(document.getElementById('txt_valor_total_orden_edit').value,0)) {
            mostrarDiv('error_valor_unitario');
            return false;
        }


        if (document.getElementById('sel_estado_edit').value == '4') {
            if (document.getElementById('fecha_pago_orden_edit').value == '') {
                mostrarDiv('error_fecha_pago_orden');
                return false;
            }
        }

        if (document.getElementById('txt_observaciones_edit').value == '') {
            mostrarDiv('error_observaciones');
            return false;
        }
//        if (document.getElementById('file_orden_edit').value == '') {
//            mostrarDiv('error_archivo');
//            return false;
//        }
        if (document.getElementById('sel_moneda_edit').value != '1') {

            cambiacoma('txt_tasa_edit');
        }
        
        if (document.getElementById('txt_valor_total_orden_edit').value === '' || !validarEntero(document.getElementById('txt_valor_total_orden_edit').value) || !validarRealMayor(document.getElementById('txt_valor_total_orden_edit').value,0)) {
            mostrarDiv('error_valor_total');
            return false;
        }


    }
    else if (document.getElementById('sel_estado_edit').value == '3' || document.getElementById('sel_estado_edit').value == '2') {


        if (document.getElementById('sel_estado_edit').value == '-1') {
            mostrarDiv('error_sel_estado');
            return false;
        }

        if (document.getElementById('sel_tipo_actividad_edit').value == '-1') {
            mostrarDiv('error_sel_tipo_actividad');
            return false;
        }

        if (document.getElementById('sel_actividad_edit').value == '-1') {

            mostrarDiv('error_sel_actividad');
            return false;
        }

        if (document.getElementById('sel_proveedor_edit').value == '-1') {
            mostrarDiv('error_sel_proveedor');
            return false;
        }

        if (document.getElementById('sel_moneda_edit').value == '-1') {
            mostrarDiv('error_sel_moneda');
            return false;
        }
        if (document.getElementById('sel_moneda_edit').value != '1') {
            if (document.getElementById('txt_tasa_edit').value == '') {
                mostrarDiv('error_tasa');
                return false;
            }
        }

        if (document.getElementById('fecha_orden_edit').value == '') {
            mostrarDiv('error_fecha_orden');
            return false;
        }
         if (document.getElementById('sel_moneda_edit').value != '1') {

            cambiacoma('txt_tasa_edit');
        }
        if (document.getElementById('txt_valor_total_orden_edit').value == '' || !validarEntero(document.getElementById('txt_valor_total_orden_edit').value) || ! validarRealMayor(document.getElementById('txt_valor_total_orden_edit').value,0)) {
            mostrarDiv('error_valor_total');
            return false;
        }

    }
    document.getElementById('frm_editar_orden').action = '?mod=ordenesdepago&niv=1&task=Guardaredicion';
    document.getElementById('frm_editar_orden').submit();
}

function consultar_ordenes() {

   
    if (document.getElementById('sel_actividad').value == "")
        document.getElementById('sel_actividad').value = "-1";
    if (document.getElementById('sel_proveedor').value == "")
        document.getElementById('sel_proveedor').value = "-1";
   


    document.getElementById('frm_list_ordenes').action = '?mod=ordenesdepago&niv=1';
    document.getElementById('frm_list_ordenes').submit();
}

function cambiacoma(id)
{
    document.getElementById(id).value = document.getElementById(id).value.replace(',', '.');
}
function exportar_ordenesdepago_excel() {

    document.getElementById('frm_list_ordenes').action = 'modulos/financiero/ordenesdepago_a_excel.php';
    document.getElementById('frm_list_ordenes').submit();
}

function deshabilitar_campos(){
    document.getElementById("sel_estado").disabled=true;
    document.getElementById("sel_tipo_actividad").disabled=true;
    document.getElementById("sel_actividad").disabled=true;
    document.getElementById("sel_proveedor").disabled=true;
    document.getElementById("sel_moneda").disabled=true;
    document.getElementById("txt_numero_ordendepago").disabled=true;
    document.getElementById("fecha_orden").disabled=true;
    document.getElementById("txt_numero_factura").disabled=true;
    document.getElementById("txt_valor_total_orden").disabled=true;
    document.getElementById("txt_observaciones").disabled=true;
    document.getElementById("file_orden_add").disabled=true;
    
    document.getElementById('frm_list_ordenes').action = '?mod=ordenesdepago&niv=1&task=Agregarorden';
    document.getElementById('frm_list_ordenes').submit();
}
function Habilitar_campos(){
    document.getElementById("sel_estado").disabled=false;
    document.getElementById("sel_tipo_actividad").disabled=false;
    document.getElementById("sel_actividad").disabled=false;
    document.getElementById("sel_proveedor").disabled=false;
    document.getElementById("sel_moneda").disabled=false;
    document.getElementById("txt_numero_ordendepago").disabled=false;
    document.getElementById("fecha_orden").disabled=false;
    document.getElementById("txt_numero_factura").disabled=false;
    document.getElementById("txt_valor_total_orden").disabled=false;
    document.getElementById("txt_observaciones").disabled=false;
    document.getElementById("file_orden_add").disabled=false;
}
function validarRealMayor(num, l1) {
    if (/^(?:\+|-)?\d+\.?\d*$/.test(num)) {
        if (parseFloat(num) > parseFloat(l1) ) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}