<?php

defined('_VALID_PRY') or die('Restricted access');
//no permite el acceso directo
$docData = new COrdenesdepagoData($db);
$baseproducto = new CProductosData($db);
$baseActivida = new CActividadData($db);
$baseFamilia = new CFamiliaData($db);
$baseproveedor = new CProveedorData($db);
$basemoneda = new CMonedaData($db);
//creamos las instancias de las objetos que maneja la gestion de datos
$task = $_REQUEST['task'];
$operador = $_REQUEST['operador'];
if (empty($task))
    $task = 'list';
switch ($task) {

    /**
     * la variable list, permite cargar la pagina con los objetos
     * ordenes de pago de acuerdo a un parametro de entrada denominado
     * filtro o criterio
     */
    case 'list':

        $tipopago = $_REQUEST['sel_tipo_pago'];
        $tipoactividad = $_REQUEST['sel_tipo_actividad'];
        $actividad = $_REQUEST['sel_actividad'];
        $familia = $_REQUEST['sel_familia'];
        $proveedor = $_REQUEST['sel_proveedor'];
        $tipo = $_REQUEST['sel_tipo'];
        $CheckAprovado = $_REQUEST['check_estados_1'];
        $CheckPagado = $_REQUEST['check_estados_4'];
        $CheckPendiente = $_REQUEST['check_estados_3'];
        $CheckRechazado = $_REQUEST['check_estados_2'];



        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_ORDENES);
        $form->setId('frm_list_ordenes');
        $form->setMethod('post');


//obtenemos los datos que vamos a cargar en los select de nuesto formulario

        $tiposActividades = $docData->ObtenerTiposActividades();
        $opcionestipoactividades = null;
        if (isset($tiposActividades)) {
            foreach ($tiposActividades as $t) {
                $opcionestipoactividades[count($opcionestipoactividades)] = array('value' => $t['idactividadestipo'], 'texto' => $t['nombreactividadestipo']);
            }
        }


        $Actividades = $docData->ObtenerActividades($tipoactividad);
        $opcionesactividades = null;
        if (isset($Actividades)) {
            foreach ($Actividades as $t) {
                $opcionesactividades[count($opcionesactividades)] = array('value' => $t['idactividades'], 'texto' => $t['nombreactividades']);
            }
        }



        $familias = $docData->ObtenerFamilias();
        $opcionesfamilias = null;
        if (isset($familias)) {
            foreach ($familias as $t) {
                $opcionesfamilias[count($opcionesfamilias)] = array('value' => $t['idfamilia'], 'texto' => $t['nombrefamilia']);
            }
        }

        $proveedores = $docData->ObtenerProveedores();
        $opcionesproveedores = null;
        if (isset($proveedores)) {
            foreach ($proveedores as $t) {
                $opcionesproveedores[count($opcionesproveedores)] = array('value' => $t['idproveedores'], 'texto' => $t['nombreproveedores']);
            }
        }

        $tipos = $docData->ObtenerTipos();
        $opcionestipos = null;
        if (isset($tipos)) {
            foreach ($tipos as $t) {
                $opcionestipos[count($opcionestipos)] = array('value' => $t['idtipo'], 'texto' => $t['nombretipo']);
            }
        }

        $estados = $docData->ObtenerEstados();
        $opcionesestados = null;
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opcionesestados[count($opcionesestados)] = array('value' => $t['idestado'], 'texto' => $t['nombreestado']);
            }
        }
        
        $opcionestipopago = null;
        $opcionestipopago[count($opcionestipopago)] = array('value' => 1, 'texto'=>PAGO_PROVEEDOR);
        $opcionestipopago[count($opcionestipopago)] = array('value' => 2, 'texto'=>CAMPO_REINTEGRO);
        

//definimos la variable criterio y en base a los filtros la modificamos para generar la consulta
        if (isset($CheckAprovado) || isset($CheckPagado) || isset($CheckPendiente) || isset($CheckRechazado)) {

            $criterio = "";
            if (isset($tipoactividad) && $tipoactividad > 0 && $tipoactividad != -1) {
                $criterio = "(at.Id_Tipo=" . $tipoactividad . ")";
            }
            if (isset($actividad) && $actividad > 0 && $actividad != -1) {
                $criterio = $criterio . "(a.Id_Actividad=" . $actividad . ")";
            }

            if (isset($proveedor) && $proveedor > 0 && $proveedor != -1) {
                $criterio = $criterio . "(p.Id_Prove=" . $proveedor . ")";
            }
            if (isset($moneda) && $moneda > 0 && $moneda != -1) {
                $criterio = $criterio . "(m.Id_Moneda=" . $moneda . ")";
            }

            $criterio = explode(')', $criterio);
            $parametro = "";

            if (count($criterio) == 2) {
                $parametro = $criterio[0] . ") and ";
            } else {
                for ($i = 0; $i < count($criterio) - 1; $i++) {
                    $parametro = $parametro . " " . $criterio[$i] . ") and ";
                }
            }

            if (isset($CheckAprovado)) {
                $filtroestado = $filtroestado . "Id_estado_Ordenes=1)";
            }
            if (isset($CheckPagado)) {
                $filtroestado = $filtroestado . "Id_estado_Ordenes=4)";
            }
            if (isset($CheckPendiente)) {
                $filtroestado = $filtroestado . "Id_estado_Ordenes=3)";
            }
            if (isset($CheckRechazado)) {
                $filtroestado = $filtroestado . "Id_estado_Ordenes=2)";
            }
            $filtroestado = explode(')', $filtroestado);
            $parametroestado = "";

            if (count($filtroestado) == 2) {
                $parametroestado = "(" . $filtroestado[0] . ")";
            } else {
                for ($i = 0; $i < count($filtroestado) - 1; $i++) {
                    $parametroestado = $parametroestado . " " . $filtroestado[$i] . " or";
                }
                $parametroestado = "(" . substr($parametroestado, 0, count($parametroestado) - 4) . ")";
            }
        } else if (!isset($CheckAprovado) && !isset($CheckPagado) && !isset($CheckPendiente) && !isset($CheckRechazado)) {

            $criterio = "";
            if (isset($tipoactividad) && $tipoactividad > 0 && $tipoactividad != -1) {
                $criterio = "(at.Id_Tipo=" . $tipoactividad . ")";
            }
            if (isset($actividad) && $actividad > 0 && $actividad != -1) {
                $criterio = $criterio . "(a.Id_Actividad=" . $actividad . ")";
            }

            if (isset($proveedor) && $proveedor > 0 && $proveedor != -1) {
                $criterio = $criterio . "(p.Id_Prove=" . $proveedor . ")";
            }
            if (isset($moneda) && $moneda > 0 && $moneda != -1) {
                $criterio = $criterio . "(m.Id_Moneda=" . $moneda . ")";
            }

            $criterio = explode(')', $criterio);
            $parametro = "";

            if (count($criterio) == 2) {
                $parametro = $criterio[0] . ")";
            } else {
                for ($i = 0; $i < count($criterio) - 1; $i++) {
                    $parametro = $parametro . " " . $criterio[$i] . ") and";
                }
                $parametro = substr($parametro, 0, count($parametro) - 4);
            }
        }
        $parametroTipoPago = null;
        if($tipopago==1){
            $parametroTipoPago = "cobro_proveedor_reintegro IS NULL";
        }
        else if($tipopago==2){
            $parametroTipoPago = "cobro_proveedor_reintegro IS NOT NULL";
        }
        else{
            $parametroTipoPago = "";
        }
        $criterio_Final = $parametro . $parametroestado;
        if($criterio_Final!='' && $parametroTipoPago!=''){
            $criterio_Final = $criterio_Final." AND ";
        }
        $criterio_Final = $criterio_Final.$parametroTipoPago;
        



        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_ordenes();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', COMPROMISOS_EXPORTAR, 'button', 'onClick=exportar_ordenesdepago_excel();');
        $form->addInputText('hidden', 'txt_criterio', 'txt_criterio', '5', '5', '', '', '');

        $form->addEtiqueta(SELECCINE_TIPO_ACTIVIDAD_ORDEN_FILTRO);
        $form->addSelect('select', 'sel_tipo_actividad', 'sel_tipo_actividad', 
                $opcionestipoactividades, SELECCINE_TIPO_ACTIVIDAD_ORDEN_FILTRO, $tipoactividad, '', '');
        $form->addEtiqueta(SELECCINE_TIPO_PAGO);
        $form->addSelect('select', 'sel_tipo_pago', 'sel_tipo_pago', 
                $opcionestipopago, SELECCINE_TIPO_PAGO, $tipopago, '', '');
        $form->addEtiqueta(SELECCINE_ACTIVIDAD_ORDEN_FILTRO);
        $form->addSelect('select', 'sel_actividad', 'sel_actividad', $opcionesactividades, SELECCINE_ACTIVIDAD_ORDEN_FILTRO, $actividad, '', '');
        $form->addEtiqueta(SELECCINE_PROVEEDOR_ORDEN_FILTRO);
        $form->addSelect('select', 'sel_proveedor', 'sel_proveedor', $opcionesproveedores, SELECCINE_PROVEEDOR_ORDEN_FILTRO, $proveedor, '', '');
        $form->addEtiqueta(SELECCINE_ESTADO_ORDEN_FILTRO);
        $form->addCheckBox('checkbox', 'ck_Aprobado', 'check_estados', $opcionesestados, '', '');

        $form->writeForm();


//creamos el formulario y la tabla de datos con los titulos y el resultado de la consulta
        $dt = new CHtmlDataTable();
        $ordenesdepago = $docData->obtenerOrdenesdepago($criterio_Final);
        $dt->setTitleTable(TABLA_TITULO_ORDENES);


        $titulos = array(REINTEGRO, NUMERO_ORDEN_PAGO, FECHA_ORDEN, ESTADO_ORDEN, TIPO_ACTIVIDAD_ORDEN, 
            ACTIVIDAD_ORDEN, NOMBRE_PROVEEDOR_ORDEN_PAGO, NUMERO_FACTURA, NUMERO_DOCUMENTO_SOPORTE_UT, MONEDA_ORDEN, TASA_ORDEN,
            VALOR_TOTAL_ORDEN,FECHA_PAGO_ORDEN, ARCHIVO_ORDEN, OBSERVACIONES_ORDEN);
        $dt->setDataRows($ordenesdepago);
        $dt->setTitleRow($titulos);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=EditarOrden");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=BorrarOrden");
        $dt->setSeeLink("?mod=" . $modulo . "&niv=" . $niv . "&task=VerOrden");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=Agregarorden&bandera=true");
        $dt->setFormatRow(array(null,null, null, null, null, null, null, null, null, null, array(2, ',', '.'),array(2, ',', '.')));
        $dt->setSumColumns(array(12));
        $dt->setType(1);
        $dt->setPag(1);
        $dt->writeDataTable($niv);


        break;

    case 'VerOrden':
        $id = $_REQUEST['id_element'];
        $listaProductos = $baseproducto->consultarProductosByOrden($id);

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle("Detalle Productos");
        $form->setId('frm_ver_productos');
        $form->setMethod('post');
        $form->options['autoClean'] = false;
        $form->writeForm();


        $dt = new CHtmlDataTable();

        $dt->setTitleTable("Tabla de Productos");


        $titulos = array(TIPO_ACTIVIDAD_REPORTE, FAMILIA_ORDEN, CANTIDAD_ORDEN, DESP_TAREA, VALORUNITARIO_ORDEN, VALOR_TOTAL_ORDEN);
        $dt->setDataRows($listaProductos);
        $dt->setTitleRow($titulos);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=EditarProducto&txt_orden=$id");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=EliminarProducto&txt_orden=$id");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=AgregarProducto&txt_orden=$id");
        $dt->setSumColumns(array(6));
        $dt->setFormatRow(array(null, null, null, null, array(2, ',', '.'), array(2, ',', '.')));
        $dt->setType(1);
        $dt->setPag(1);
        $dt->writeDataTable($niv);

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setId('frm_ver_productos1');
        $form->setMethod('post');
        $form->options['autoClean'] = false;
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionordendepago(\'frm_ver_productos\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();

        break;

    case 'AgregarProducto':
        $orden = $_REQUEST['txt_orden'];

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle("Nuevo Producto");
        $form->setId('frm_agregar_producto');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_orden', 'txt_orden', '15', '15', $orden, '', '');

        $tipos = array(array('value' => 1, 'texto' => 'Bien'), array('value' => 2, 'texto' => 'Servicio'));
        $form->addEtiqueta(TIPO_ACTIVIDAD_REPORTE);
        $form->addSelect('select', 'sel_tipo', 'sel_tipo', $tipos, '', '', '', 'onchange="ocultarDiv(\'error_tipo\');"');
        $form->addError('error_tipo', "Ingrese un tipo de Producto");

        $familias = $baseFamilia->ObtenerFamilias();
        $opcionesfamilias = null;
        if (isset($familias)) {
            foreach ($familias as $t) {
                $opcionesfamilias [count($opcionesfamilias)] = array('value' => $t[0], 'texto' => $t[1]);
            }
        }
        $form->addEtiqueta(FAMILIA_ORDEN);
        $form->addSelect('select', 'sel_familia', 'sel_familia', $opcionesfamilias, '', '', '', 'onchange="ocultarDiv(\'error_familia\');"');
        $form->addError('error_familia', ERROR_FAMILIA);

        $form->addEtiqueta(DESCRIPCION_ACTIVIDAD_REPORTE);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', 60, 60, '', '', 'onkeypress="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_DESCRIPCION_FAMILIA);

        $form->addEtiqueta(CANTIDAD_ORDEN);
        $form->addInputText('text', 'txt_cantidad', 'txt_cantidad', 60, 60, '', '', 'onkeypress="ocultarDiv(\'error_cantidad\');"');
        $form->addError('error_cantidad', ERROR_CANTIDAD);

        $form->addEtiqueta(VALORUNITARIO_ORDEN);
        $form->addInputText('text', 'txt_valor', 'txt_valor', 60, 60, '', '', 'onkeypress="ocultarDiv(\'error_valor\');"');
        $form->addError('error_valor', ERROR_VALOR_UNITARIO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_agregar_producto();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionordendepago(\'frm_agregar_producto\',\'?mod=' . $modulo . '&task=VerOrden&niv=' . $niv . "&id_element=$orden" . '\');"');

        $form->writeForm();
        break;

    case 'ConfirmarAgregarProducto':

        $orden = $_REQUEST['txt_orden'];
        $tipo = $_REQUEST['sel_tipo'];
        $familia = $_REQUEST['sel_familia'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $cantidad = $_REQUEST['txt_cantidad'];
        $valor = $_REQUEST['txt_valor'];
        $produ = new CProductos($orden, $tipo, $familia, $descripcion, $cantidad, $valor);

        $m = $baseproducto->insertarProducto($produ);

        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=VerOrden" . "&id_element=$orden");
        break;

    case 'EditarProducto':
        $orden = $_REQUEST['txt_orden'];
        $id = $_REQUEST['id_element'];
        $producto = $baseproducto->consultarProductoById($id);

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle("Editar Producto");
        $form->setId('frm_editar_producto');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_orden', 'txt_orden', '15', '15', $orden, '', '');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '10', '10', $id, '', '');

        $tipos = array(array('value' => 1, 'texto' => 'Bien'), array('value' => 2, 'texto' => 'Servicio'));
        $form->addEtiqueta(TIPO_ACTIVIDAD_REPORTE);
        $form->addSelect('select', 'sel_tipo', 'sel_tipo', $tipos, '', $producto['tipo'], '', 'onchange="ocultarDiv(\'error_tipo\');"');
        $form->addError('error_tipo', "Ingrese un tipo de Producto");

        $familias = $baseFamilia->ObtenerFamilias();
        $opcionesfamilias = null;
        if (isset($familias)) {
            foreach ($familias as $t) {
                $opcionesfamilias [count($opcionesfamilias)] = array('value' => $t[0], 'texto' => $t[1]);
            }
        }
        $form->addEtiqueta(FAMILIA_ORDEN);
        $form->addSelect('select', 'sel_familia', 'sel_familia', $opcionesfamilias, '', $producto['familia'], '', 'onchange="ocultarDiv(\'error_familia\');"');
        $form->addError('error_familia', ERROR_FAMILIA);

        $form->addEtiqueta(DESCRIPCION_ACTIVIDAD_REPORTE);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', 100, 100, $producto['descripcion'], '', 'onkeypress="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_DESCRIPCION_FAMILIA);

        $form->addEtiqueta(CANTIDAD_ORDEN);
        $form->addInputText('text', 'txt_cantidad', 'txt_cantidad', 60, 60, $producto['cantidad'], '', 'onkeypress="ocultarDiv(\'error_cantidad\');"');
        $form->addError('error_cantidad', ERROR_CANTIDAD);

        $form->addEtiqueta(VALORUNITARIO_ORDEN);
        $form->addInputText('text', 'txt_valor', 'txt_valor', 15, 15, $producto['valor'], '', 'onkeypress="ocultarDiv(\'error_valor\');"');
        $form->addError('error_valor', ERROR_VALOR_UNITARIO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_editar_producto();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionordendepago(\'frm_editar_producto\',\'?mod=' . $modulo . '&task=VerOrden&niv=' . $niv . "&id_element=$orden" . '\');"');

        $form->writeForm();
        break;

    case 'ConfirmarEditarProducto':
        $orden = $_REQUEST['txt_orden'];
        $id = $_REQUEST['txt_id'];
        $tipo = $_REQUEST['sel_tipo'];
        $familia = $_REQUEST['sel_familia'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $cantidad = $_REQUEST['txt_cantidad'];
        $valor = $_REQUEST['txt_valor'];

        $m = $baseproducto->editarProducto($id, $tipo, $familia, $descripcion, $cantidad, $valor);

        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=VerOrden" . "&id_element=$orden");
        break;

    case 'EliminarProducto':
        $id = $_REQUEST['id_element'];
        $orden = $_REQUEST['txt_orden'];
        $m = $baseproducto->eliminarById($id);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=VerOrden" . "&id_element=$orden");
        break;



    /**
     * la variable Agregar orden, permite cargar el formulario y los datos
     * de un objeto ordene de pago
     */
    case 'Agregarorden':
//obtenemos los datos de los formulario fadein y luego los agregamos en base a una variable recibida


        if (isset($_REQUEST['actividad'])){
            if($_REQUEST['Descrip_actividad']!=''){
                $tipo = $_REQUEST['Tipo_actividad'];
                $descripcion = $_REQUEST['Descrip_actividad'];
                $monto = $_REQUEST['Monto_actividad'];
                $nuevaactividad = $baseActivida->insertaractividad('', $descripcion, $monto, $tipo);
            }
        }

        if (isset($_REQUEST['moneda'])) {
            if($_REQUEST['txt_descripcion_moneda']!=''){
                $descripcion = $_REQUEST['txt_descripcion_moneda'];
                $nuevamoneda = $basemoneda->insertarMoneda('', $descripcion);
            }
        }
        if (isset($_REQUEST['productos'])) {
            $productos = $_REQUEST['productos'];
        }
        if (isset($_REQUEST['proveedor'])){
            if($_REQUEST['txt_nit_proveedor']!=''){
                $nit = $_REQUEST['txt_nit_proveedor'];
                $nombre = $_REQUEST['txt_nombre_proveedor'];
                $telefono = $_REQUEST['txt_telefono_proveedor'];
                $pais = $_REQUEST['txt_pais_proveedor'];
                $ciudad = $_REQUEST['txt_ciudad_proveedor'];
                $direccion = $_REQUEST['txt_direccion_proveedor'];
                $contactoprove = $_REQUEST['txt_nombre_contac_proveedor'];
                $contactoproveA = $_REQUEST['txt_ApA_contac_proveedor'];
                $contactoproveB = $_REQUEST['txt_ApB_contac_proveedor'];
                $telcontac = $_REQUEST['txt_tel_contac_proveedor'];
                $email = $_REQUEST['txt_emal_proveedor'];

                $Nuevoproveedor = $baseproveedor->insertarproveedor($id, $nit, $nombre,
                        $telefono, $pais, $ciudad, $direccion, $contactoprove, $contactoproveA, $contactoproveB, $telcontac, $email);
            }
        }


        $reintegro = $_REQUEST['sel_reintegro'];
        if($reintegro ==2)
        $numero_proveedor = $_REQUEST['txt_reintegro'];
        $estado = $_REQUEST['sel_estado'];
        $tipoactividad = $_REQUEST['sel_tipo_actividad'];
        $actividad = $_REQUEST['sel_actividad'];
        $proveedor = $_REQUEST['sel_proveedor'];
        $moneda = $_REQUEST['sel_moneda'];
        $numerordendepago = $_REQUEST['txt_numero_ordendepago'];
        $fechaorden = $_REQUEST['fecha_orden'];
        $numerofactura = $_REQUEST['txt_numero_factura'];
        if ($moneda == 1) {
            $tasaorden = 1;
        } else {
            $tasaorden = $_REQUEST['txt_tasa'];
        }
        $valortotal = $_REQUEST['txt_valor_total_orden'];
        $fechapagoorden = $_REQUEST['fecha_pago_orden'];
        $observacionesorden = $_REQUEST['txt_observaciones'];
        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_AGREGAR_ORDEN);
        $form->setId('frm_agregar_orden');
        $form->setMethod('post');

//similar a la variable list cargamos los datos de los campos select
        $tiposActividades = $docData->ObtenerTiposActividades();
        $opcionestipoactividades = null;
        if (isset($tiposActividades)) {
            foreach ($tiposActividades as $t) {
                $opcionestipoactividades[count($opcionestipoactividades)] = array('value' => $t['idactividadestipo'], 'texto' => $t['nombreactividadestipo']);
            }
        }

        $Actividades = $docData->ObtenerActividades($tipoactividad);
        $opcionesactividades = null;
        if (isset($Actividades)) {
            foreach ($Actividades as $t) {
                $opcionesactividades[count($opcionesactividades)] = array('value' => $t['idactividades'], 'texto' => $t['nombreactividades']);
            }
        }


        $proveedores = $docData->ObtenerProveedores();
        $opcionesproveedores = null;
        if (isset($proveedores)) {
            foreach ($proveedores as $t) {
                $opcionesproveedores[count($opcionesproveedores)] = array('value' => $t['idproveedores'], 'texto' => $t['nombreproveedores']);
            }
        }


        $estados = $docData->ObtenerEstados();
        $opcionesestados = null;
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opcionesestados[count($opcionesestados)] = array('value' => $t['idestado'], 'texto' => $t['nombreestado']);
            }
        }
        $monedas = $docData->ObtenerMonedas();
        $opcionesmonedas = null;
        if (isset($monedas)) {
            foreach ($monedas as $t) {
                $opcionesmonedas[count($opcionesmonedas)] = array('value' => $t['idmoneda'], 'texto' => $t['nombremoneda']);
            }
        }
        $opcionesReintegro=null;
        $opcionesReintegro[count($opcionesReintegro)] = array('value' => 1, 'texto' => PAGO_PROVEEDOR);
        $opcionesReintegro[count($opcionesReintegro)] = array('value' => 2, 'texto' => CAMPO_REINTEGRO);
        if (isset($_REQUEST['bandera'])){
            
        }
        $ventana = new CHtmlVentanas();
        $ventana->createventanadesplegable('producto', 'producto', '');
        $form->addEtiqueta(SELECCION_REINTEGRO_ORDEN);
        $form->addSelect('select', 'sel_reintegro', 'sel_reintegro', $opcionesReintegro, SELECCION_REINTEGRO_ORDEN, $reintegro, '', 'onChange=submit();');
        $form->addError('error_sel_reintegro', ERROR_SEL_REINTEGRO);
       
        if ($reintegro == 2) {
            $form->addEtiqueta(NUMERO_CUENTA_COBRO);
            $form->addInputText('text', 'txt_reintegro', 'txt_reintegro', '10', '10', $numero_proveedor, '', 'onkeypress="ocultarDiv(\'error_tasa\');"');
            $form->addError('error_proveedor', ERROR_PROVEEDOR);
        }
        
        $form->addEtiqueta(SELECCINE_ESTADO_ORDEN_FILTRO);
        $form->addSelect('select', 'sel_estado', 'sel_estado', $opcionesestados, SELECCINE_ESTADO_ORDEN_FILTRO, $estado, '', 'onChange=submit();');
        $form->addError('error_sel_estado', ERROR_SEL_ESTADO);
        
        $form->addEtiqueta(SELECCINE_ACTIVIDAD);
        $form->addSelect('select', 'sel_tipo_actividad', 'sel_tipo_actividad', $opcionestipoactividades, SELECCINE_TIPO_ACTIVIDAD_ORDEN_FILTRO, $tipoactividad, '', 'onChange=submit();');
        $form->addError('error_sel_tipo_actividad', ERROR_SEL_TIPO_ACTIVIDAD);

//llamamos la funcion createventanadesplegable para crear una ventana de tipo fadein
        $ventana->createventanadesplegable('actividad', 'actividad', 'Agregarorden');
        $form->addEtiqueta(SELECCINE_ACTIVIDAD_ORDEN_FILTRO);
//el link de la ventana se lo pasamos como atributo al elemento en el cual quedara adjunto
        $form->addSelectLink('selectlink', 'sel_actividad', 'sel_actividad', $opcionesactividades, SELECCINE_TIPO_ACTIVIDAD_ORDEN_FILTRO, $actividad, '', '', '<a href="#" id="openactividad"><img src="templates/img/ico/agregar.gif"/></a>');
        $form->addError('error_sel_actividad', ERROR_SEL_TIPO_ACTIVIDAD);


        $ventana->createventanadesplegable('proveedor', 'proveedor', 'Agregarorden');
        $form->addEtiqueta(SELECCINE_PROVEEDOR_ORDEN_FILTRO);
        $form->addSelectLink('selectlink', 'sel_proveedor', 'sel_proveedor', $opcionesproveedores, SELECCINE_PROVEEDOR_ORDEN_FILTRO, $proveedor, '', '', '<a href="#" id="openproveedor"><img src="templates/img/ico/agregar.gif"/></a>');
        $form->addError('error_sel_proveedor', ERROR_SEL_PROVEEDOR);

        $ventana->createventanadesplegable('moneda', 'moneda', 'Agregarorden');
        $form->addEtiqueta(SELECCINE_MONEDA);
        $form->addSelectLink('selectlink', 'sel_moneda', 'sel_moneda', $opcionesmonedas, SELECCINE_MONEDA, $moneda, '', 'onChange=submit();', '<a href="#" id="openmoneda"><img src="templates/img/ico/agregar.gif"/></a>');
        $form->addError('error_sel_moneda', ERROR_SEL_MONEDA);
        if ($moneda != 1 && $moneda > 0) {
            $form->addEtiqueta(TASA_ORDEN);
            $form->addInputText('text', 'txt_tasa', 'txt_tasa', '10', '10', $tasaorden, '', 'onkeypress="ocultarDiv(\'error_tasa\');"');
            $form->addError('error_tasa', ERROR_TASA);
        }

        $form->addEtiqueta(NUMERO_ORDEN_PAGO);
        $form->addInputText('text', 'txt_numero_ordendepago', 'txt_numero_ordendepago', '15', '15', $numerordendepago, '', 'onkeypress="ocultarDiv(\'error_numero_ordendepago\');"');
        $form->addError('error_numero_ordendepago', ERROR_NUMERO_ORDEN_PAGO);
        $form->addEtiqueta(FECHA_ORDEN);
        $form->addInputDate('date', 'fecha_orden', 'fecha_orden', $fechaorden, '%Y-%m-%d', '22', '22', '', 'onChange="ocultarDiv(\'error_fecha_orden\');"');
        $form->addError('error_fecha_orden', ERROR_FECHA_ORDEN);
        
         if($reintegro==2){
            $form->addEtiqueta(NUMERO_PROVEEDOR);
        }else{
            $form->addEtiqueta(NUMERO_FACTURA);
        }
        $form->addInputText('text', 'txt_numero_factura', 'txt_numero_factura', '15', '15', $numerofactura, '', 'onkeypress="ocultarDiv(\'error_numero_factura\');"');
        $form->addError('error_numero_factura', ERROR_NUMERO_FACTURA);
        
        $form->addEtiqueta(VALOR_TOTAL_ORDEN);
        $form->addInputText('text', 'txt_valor_total_orden', 'txt_valor_total_orden', '10', '10', $valortotal, '', 'onkeypress="ocultarDiv(\'error_valor_total\');"');
        $form->addError('error_valor_total', ERROR_VALOR_TOTAL);

        if ($estado == 4) {
            $form->addEtiqueta(FECHA_PAGO_ORDEN);
            $form->addInputDate('date', 'fecha_pago_orden', 'fecha_pago_orden', $fechapagoorden, '%Y-%m-%d', '22', '22', '', 'onChange="ocultarDiv(\'error_fecha_pago_orden\');"');
            $form->addError('error_fecha_pago_orden', ERROR_FECHA_PAGO_ORDEN);
        }

        
        $form->addEtiqueta(OBSERVACIONES_ORDEN);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '50', '4', $observacionesorden, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addInputText('hidden', 'txt_productos', 'txt_productos', '40', '40', $productos, '', '');
        $form->addError('error_observaciones', ERROR_OBSERVACIONES);
        $form->addEtiqueta(ARCHIVO_ORDEN);
        $form->addInputFile('file', 'file_orden_add', 'file_orden_add', '25', 'file', 'onChange="ocultarDiv(\'error_orden\');"');
        $form->addError('error_archivo', ERROR_ORDEN_ARCHIVO);


        $form->addBotonFormulario('BotonFormulario', 'openproducto', 'openproducto', 'hidden', '', '');
        $form->addInputButton('button', 'ok', 'ok', BTN_ADELANTE, 'button', 'onclick="validar_agregar_ordendepago();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionoradicionarEditar(\'frm_agregar_orden\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');

        $form->writeForm();

        break;

        /**
     * la variable GuardarOrden, permite cargar la datos de la variable AgregarOrden
     * y agregar a la base de datos el objeto ordenes de pago
     */
    case 'GuardarOrden':

        $reintegro = $_REQUEST['sel_reintegro'];
        if($reintegro != 2){
            $numero_proveedor = 'null';
        }else{
            $numero_proveedor = $_REQUEST['txt_reintegro'];
        }
        $tipoactividad = $_REQUEST['sel_tipo_actividad'];
        $actividad = $_REQUEST['sel_actividad'];
        $proveedor = $_REQUEST['sel_proveedor'];
        $estado = $_REQUEST['sel_estado'];
        $numerordendepago = $_REQUEST['txt_numero_ordendepago'];
        $fechaorden = $_REQUEST['fecha_orden'];
        $numerofactura = $_REQUEST['txt_numero_factura'];

        $moneda = $_REQUEST['sel_moneda'];
        if ($moneda != 1) {
            $tasaorden = $_REQUEST['txt_tasa'];
        } else {
            $tasaorden = 1;
        }
        $valortotal = $_REQUEST['txt_valor_total_orden'];
        $fechapagoorden = $_REQUEST['fecha_pago_orden'];
        $observacionesorden = $_REQUEST['txt_observaciones'];
        $archivo = $_FILES['file_orden_add'];
        
        $ordenesdepago = new COrdenesdepago('', $tipoactividad, $actividad, $numerordendepago, $fechaorden, $numerofactura, $proveedor, $moneda, $tasaorden, $valortotal, $estado, $fechapagoorden, $observacionesorden, $numero_proveedor, $archivo, $docData);
        $m = $ordenesdepago->GuardarOrden();
        $orden = $docData->database->getMaxValue('ordenesdepago', 'Id_Orden_Pago');
        if ($m == ORDEN_DE_PAGO_AGREGADA_EXITO_DOCUMENTO || $m == ORDEN_DE_PAGO_AGREGADA_EXITO) {
            if (isset($_REQUEST['txt_productos'])) {
                $array = explode(';', $_REQUEST['txt_productos']);
                foreach ($array as $productos) {
                    $producto = explode(',', $productos);
                    $produ = new CProductos($orden, $producto[0], $producto[1], $producto[2], $producto[3], $producto[4]);
                    $baseproducto->insertarProducto($produ);
                }
            }
        }
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;
    /**
     * la variable BorrarOrden,  cargar los datos del objeto orden de pago que se
     * va a eliminar y los envia a la variable ConfirmarBorrar
     */
    case 'BorrarOrden':


        $id_delete = $_REQUEST['id_element'];
        $tipoactividad = $_REQUEST['sel_tipo_actividad'];
        $actividad = $_REQUEST['sel_actividad'];
        $proveedor = $_REQUEST['sel_proveedor'];
        $estado = $_REQUEST['sel_estado'];
        $numerordendepago = $_REQUEST['txt_numero_ordendepago'];
        $fechaorden = $_REQUEST['fecha_orden'];
        $numerofactura = $_REQUEST['txt_numero_factura'];
        $moneda = $_REQUEST['sel_moneda'];
        $valortotal = $_REQUEST['txt_valor_total_orden'];
        $fechapagoorden_add = $_REQUEST['fecha_pago_orden'];
        $observacionesorden = $_REQUEST['txt_observaciones'];

        $form = new CHtmlForm();
        $form->setId('frm_borrar_orden');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_formulario', 'txt_formulario', '15', '15', '', '', '');
        echo $html->generaAdvertencia(ORDEN_ADVERTENCIA_BORRAR, '?mod=' . $modulo . '&niv=' . $niv . '&task=Confirmaborrar&id_element=' . $id_delete, "cancelarAccionordendepago('frm_borrar_orden','?mod=" . $modulo . "&niv=" . $niv . "');");
        $form->writeForm();

        break;
    /**
     * la variable Confirmarborar, permite eliminar el objeto de la base de datos
     */
    case 'Confirmaborrar':

        $id_delete = $_REQUEST['id_element'];
        $ordenesdepago = new COrdenesdepago($id_delete, '', '', '', '', '', '', '', '', '', '', '', '', '','', $docData);
        $ordenesdepago->cargarordendepago();
        $id = $ordenesdepago->getId_ordenedepago();
        $archivo = $ordenesdepago->getArchivo_Orden();
        $fecha = $ordenesdepago->getFecha_ordenedepago();
        $m = $ordenesdepago->deleteOrden($id, $archivo, $fecha);
        $baseproducto->eliminarByOrden($id);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;
    /**
     * la variable Editarorden, genera un formulario y carga los datos del
     * objeto orden de pago que se va a editar
     */
    case 'EditarOrden':


//obtenemos los datos de los formulario fadein y luego los agregamos en base a una variable recibida
        if (isset($_REQUEST['actividad'])) {
            $tipo = $_REQUEST['Tipo_actividad'];
            $descripcion = $_REQUEST['Descrip_actividad'];
            $monto = $_REQUEST['Monto_actividad'];
            $nuevaactividad = $baseActivida->insertaractividad('', $descripcion, $monto, $tipo);
        }

        if (isset($_REQUEST['familia'])) {
            $descripcion = $_REQUEST['txt_descripcion'];
            $nuevafamilia = $baseFamilia->insertarfamilia('', $descripcion);
        }
        if (isset($_REQUEST['moneda'])) {
            $descripcion = $_REQUEST['txt_descripcion'];
            $nuevamoneda = $basemoneda->insertarMoneda('', $descripcion);
        }
        if (isset($_REQUEST['proveedor'])) {
            $nit = $_REQUEST['txt_nit_proveedor'];
            $nombre = $_REQUEST['txt_nombre_proveedor'];
            $telefono = $_REQUEST['txt_telefono_proveedor'];
            $pais = $_REQUEST['txt_pais_proveedor'];
            $ciudad = $_REQUEST['txt_ciudad_proveedor'];
            $direccion = $_REQUEST['txt_direccion_proveedor'];
            $contactoprove = $_REQUEST['txt_nombre_contac_proveedor'];
            $contactoproveA = $_REQUEST['txt_ApA_contac_proveedor'];
            $contactoproveB = $_REQUEST['txt_ApB_contac_proveedor'];
            $telcontac = $_REQUEST['txt_tel_contac_proveedor'];
            $email = $_REQUEST['txt_emal_proveedor'];

            $Nuevoproveedor = $baseproveedor->insertarproveedor($id, $nit, $nombre, $telefono, $pais, $ciudad, $direccion, $contactoprove, $contactoproveA, $contactoproveB, $telcontac, $email);
        }

        
        $id_edit = $_REQUEST['id_element'];
        $tipoactividad = $_REQUEST['sel_tipo_actividad'];
        $actividad = $_REQUEST['sel_actividad'];

        $proveedor = $_REQUEST['sel_proveedor'];

        $estado = $_REQUEST['sel_estado'];
        $numerordendepago = $_REQUEST['txt_numero_ordendepago'];
        $fechaorden = $_REQUEST['fecha_orden'];
        $numerofactura = $_REQUEST['txt_numero_factura'];

        $moneda = $_REQUEST['sel_moneda'];
        if ($moneda != 1) {
            $tasaorden = $_REQUEST['txt_tasa'];
        } else {
            $tasaorden = 1;
        }
        $valortotal = $_REQUEST['txt_valor_total_orden'];
        $fechapagoorden = $_REQUEST['fecha_pago_orden'];
        $observacionesorden = $_REQUEST['txt_observaciones'];



        $ordenesdepago = new COrdenesdepago($id_edit, '', '', '', '', '', '', '', '', '', '', '', '', '','', $docData);
        $ordenesdepago->cargarordendepago();
        if(isset($_REQUEST['txt_reintegro_edit'])){
            $numero_proveedor_edit=$_REQUEST['txt_reintegro_edit'];
        }

        if(isset($_REQUEST['sel_reintegro_edit'])){
            $reintegro_edit = $_REQUEST['sel_reintegro_edit'];
        }else{
            if($ordenesdepago->getCuenta_cobro()!=null){
                if($ordenesdepago->getCuenta_cobro()=='null'){
                    $reintegro_edit = 1;
                    $numero_proveedor_edit = null;
                }else{
                    $reintegro_edit = 2;
                    $numero_proveedor_edit = $ordenesdepago->getCuenta_cobro();
                }
                $reintegro_edit = 2;
                $numero_proveedor_edit = $ordenesdepago->getCuenta_cobro();
            }else{
                $reintegro_edit = 1;
                $numero_proveedor_edit = null;
            }
        }
            
        if (!isset($_REQUEST['sel_tipo_actividad_edit']) || $_REQUEST['sel_tipo_actividad_edit'] <= 0)
            $tipo_actividad_edit = $ordenesdepago->getTipodeactividad_ordenedepago();
        else
            $tipo_actividad_edit = $_REQUEST['sel_tipo_actividad_edit'];



        if (!isset($_REQUEST['sel_actividad_edit']) || $_REQUEST['sel_actividad_edit'] <= 0)
            $actividad_edit = $ordenesdepago->getActividad_ordenedepago();
        else
            $actividad_edit = $_REQUEST['sel_actividad_edit'];



        if (!isset($_REQUEST['sel_proveedor_edit']) || $_REQUEST['sel_proveedor_edit'] <= 0)
            $proveedor_edit = $ordenesdepago->getProveedor_ordenedepago();
        else
            $proveedor_edit = $_REQUEST['sel_proveedor_edit'];



        if (!isset($_REQUEST['sel_estado_edit']) || $_REQUEST['sel_estado_edit'] <= 0) {
            $estado_edit = $ordenesdepago->getEstado_ordenedepago();
        } else {
            $estado_edit = $_REQUEST['sel_estado_edit'];
        }


        if (!isset($_REQUEST['txt_numero_ordendepago_edit']))
            $numerordendepago_edit = $ordenesdepago->getNumero_ordenedepago();
        else
            $numerordendepago_edit = $_REQUEST['txt_numero_ordendepago_edit'];


        if (!isset($_REQUEST['fecha_orden_edit']))
            $fechaorden_edit = $ordenesdepago->getFecha_ordenedepago();
        else
            $fechaorden_edit = $_REQUEST['fecha_orden_edit'];


        if (!isset($_REQUEST['txt_numero_factura_edit']))
            $numerofactura_edit = $ordenesdepago->getNumerofactura_ordenedepago();
        else
            $numerofactura_edit = $_REQUEST['txt_numero_factura_edit'];




        if (!isset($_REQUEST['sel_moneda_edit']) || $_REQUEST['sel_moneda_edit'] <= 0)
            $moneda_edit = $ordenesdepago->getMoneda_ordenedepago();
        else
            $moneda_edit = $_REQUEST['sel_moneda_edit'];


        if (!isset($_REQUEST['txt_tasa_edit']))
            $tasaorden_edit = $ordenesdepago->getTasa_ordenedepago();
        else
            $tasaorden_edit = $_REQUEST['txt_tasa_edit'];


        if (!isset($_REQUEST['txt_valor_total_orden_edit']))
            $valortotal_edit = $ordenesdepago->getValortotal_ordenedepago();
        else
            $valortotal_edit = $_REQUEST['txt_valor_total_orden_edit'];


        if (!isset($_REQUEST['fecha_pago_orden_edit']))
            $fechapagoorden_edit = $ordenesdepago->getFechapago_ordenedepago();
        else
            $fechapagoorden_edit = $_REQUEST['fecha_pago_orden_edit'];


        if (!isset($_REQUEST['txt_observaciones_edit']))
            $observacionesorden_edit = $ordenesdepago->getObservaciones();
        else
            $observacionesorden_edit = $_REQUEST['txt_observaciones_edit'];

        $archivo_anterior = $ordenesdepago->getArchivo_Orden();

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_EDITAR_ORDEN);
        $form->setId('frm_editar_orden');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $ordenesdepago->getId_ordenedepago(), '', '');
        $form->addInputText('hidden', 'txt_archivo_anterior', 'txt_archivo_anterior', '15', '15', $ordenesdepago->getArchivo_Orden(), '', '');
        $form->addInputText('hidden', 'txt_fecha_anterior', 'txt_fecha_anterior', '15', '15', $ordenesdepago->getFecha_ordenedepago(), '', '');

        $tiposActividades = $docData->ObtenerTiposActividades();
        $opcionestipoactividades = null;
        if (isset($tiposActividades)) {
            foreach ($tiposActividades as $t) {
                $opcionestipoactividades[count($opcionestipoactividades)] = array('value' => $t['idactividadestipo'], 'texto' => $t['nombreactividadestipo']);
            }
        }

        $Actividades = $docData->ObtenerActividades($tipoactividad);
        $opcionesactividades = null;
        if (isset($Actividades)) {
            foreach ($Actividades as $t) {
                $opcionesactividades[count($opcionesactividades)] = array('value' => $t['idactividades'], 'texto' => $t['nombreactividades']);
            }
        }

        $proveedores = $docData->ObtenerProveedores();
        $opcionesproveedores = null;
        if (isset($proveedores)) {
            foreach ($proveedores as $t) {
                $opcionesproveedores[count($opcionesproveedores)] = array('value' => $t['idproveedores'], 'texto' => $t['nombreproveedores']);
            }
        }


        $estados = $docData->ObtenerEstados();
        $opcionesestados = null;
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opcionesestados[count($opcionesestados)] = array('value' => $t['idestado'], 'texto' => $t['nombreestado']);
            }
        }
        $monedas = $docData->ObtenerMonedas();
        $opcionesmonedas = null;
        if (isset($monedas)) {
            foreach ($monedas as $t) {
                $opcionesmonedas[count($opcionesmonedas)] = array('value' => $t['idmoneda'], 'texto' => $t['nombremoneda']);
            }
        }

        $ventana = new CHtmlVentanas();
        $opcionesReintegro=null;
        $opcionesReintegro[count($opcionesReintegro)] = array('value' => 1, 'texto' => ORDEN_DE_PAGO);
        $opcionesReintegro[count($opcionesReintegro)] = array('value' => 2, 'texto' => CAMPO_REINTEGRO);
        
        $form->addEtiqueta(SELECCION_REINTEGRO_ORDEN);
        $form->addSelect('select', 'sel_reintegro_edit', 'sel_reintegro_edit', $opcionesReintegro, SELECCION_REINTEGRO_ORDEN, $reintegro_edit, '', 'onChange=submit();');
        $form->addError('error_sel_reintegro', ERROR_SEL_REINTEGRO);
        
        if ($reintegro_edit == 2) {
            $form->addEtiqueta(NUMERO_CUENTA_COBRO);
            $form->addInputText('text', 'txt_reintegro_edit', 'txt_reintegro_edit', '10', '10', $numero_proveedor_edit, '', 'onkeypress="ocultarDiv(\'error_tasa\');"');
            $form->addError('error_proveedor', ERROR_PROVEEDOR);
        }
        
        $form->addEtiqueta(SELECCINE_ESTADO_ORDEN_FILTRO);
        $form->addSelect('select', 'sel_estado_edit', 'sel_estado_edit', $opcionesestados, SELECCINE_ESTADO_ORDEN_FILTRO, $estado_edit, '', 'onChange=submit();');
        $form->addError('error_sel_estado', ERROR_SEL_ESTADO);
        
        $form->addEtiqueta(SELECCINE_ACTIVIDAD);
        $form->addSelect('select', 'sel_tipo_actividad_edit', 'sel_tipo_actividad_edit', $opcionestipoactividades, SELECCINE_TIPO_ACTIVIDAD_ORDEN_FILTRO, $tipo_actividad_edit, '', 'onChange=submit();');
        $form->addError('error_sel_tipo_actividad', ERROR_SEL_TIPO_ACTIVIDAD);
        
        $ventana->createventanadesplegable('actividad', 'actividad', 'EditarOrden' . $id_edit);
        
        $form->addEtiqueta(SELECCINE_ACTIVIDAD_ORDEN_FILTRO);
        $form->addSelectLink('selectlink', 'sel_actividad_edit', 'sel_actividad_edit', $opcionesactividades, SELECCINE_TIPO_ACTIVIDAD_ORDEN_FILTRO, $actividad_edit, '', 'onChange=submit();', '<a href="#" id="openactividad"><img src="templates/img/ico/agregar.gif"/></a>');
        $form->addError('error_sel_actividad', ERROR_SEL_TIPO_ACTIVIDAD);

        $ventana->createventanadesplegable('proveedor', 'proveedor', 'EditarOrden' . $id_edit);
        $form->addEtiqueta(SELECCINE_PROVEEDOR_ORDEN_FILTRO);
        $form->addSelectLink('selectlink', 'sel_proveedor_edit', 'sel_proveedor_edit', $opcionesproveedores, SELECCINE_PROVEEDOR_ORDEN_FILTRO, $proveedor_edit, '', '', '<a href="#" id="openproveedor"><img src="templates/img/ico/agregar.gif"/></a>');
        $form->addError('error_sel_proveedor', ERROR_SEL_PROVEEDOR);

        $ventana->createventanadesplegable('moneda', 'moneda', 'EditarOrden' . $id_edit);
        $form->addEtiqueta(SELECCINE_MONEDA);
        $form->addSelectLink('selectlink', 'sel_moneda_edit', 'sel_moneda_edit', $opcionesmonedas, SELECCINE_MONEDA, $moneda_edit, '', 'onChange=submit();', '<a href="#" id="openmoneda"><img src="templates/img/ico/agregar.gif"/></a>');
        $form->addError('error_sel_moneda', ERROR_SEL_MONEDA);
        if ($moneda_edit != 1 && $moneda_edit > 0) {
            $form->addEtiqueta(TASA_ORDEN);
            $form->addInputText('text', 'txt_tasa_edit', 'txt_tasa_edit', '10', '10', $tasaorden_edit, '', 'onkeypress="ocultarDiv(\'error_tasa\');"');
            $form->addError('error_tasa', ERROR_TASA);
        }


        $form->addEtiqueta(NUMERO_ORDEN_PAGO);
        $form->addInputText('text', 'txt_numero_ordendepago_edit', 'txt_numero_ordendepago_edit', '15', '15', $numerordendepago_edit, '', 'onkeypress="ocultarDiv(\'error_numero_ordendepago\');"');
        $form->addError('error_numero_ordendepago', ERROR_NUMERO_ORDEN_PAGO);
        $form->addEtiqueta(FECHA_ORDEN);
        $form->addInputDate('date', 'fecha_orden_edit', 'fecha_orden_edit', $fechaorden_edit, '%Y-%m-%d', '22', '22', '', 'onChange="ocultarDiv(\'error_fecha_orden\');"');
        $form->addError('error_fecha_orden', ERROR_FECHA_ORDEN);
        
        if($reintegro_edit==2){
            $form->addEtiqueta(NUMERO_PROVEEDOR);
        }else{
            $form->addEtiqueta(NUMERO_FACTURA);
        }
        $form->addInputText('text', 'txt_numero_factura_edit', 'txt_numero_factura_edit', '15', '15', $numerofactura_edit, '', 'onkeypress="ocultarDiv(\'error_numero_factura\');"');
        $form->addError('error_numero_factura', ERROR_NUMERO_FACTURA);

        $form->addEtiqueta(VALOR_TOTAL_ORDEN);
        $form->addInputText('text', 'txt_valor_total_orden_edit', 'txt_valor_total_orden_edit', '10', '10', $valortotal_edit, '', 'onkeypress="ocultarDiv(\'error_valor_total\');"');
        $form->addError('error_valor_total', ERROR_VALOR_TOTAL);

        if ($estado_edit == 4) {
            $form->addEtiqueta(FECHA_PAGO_ORDEN);
            $form->addInputDate('date', 'fecha_pago_orden_edit', 'fecha_pago_orden_edit', $fechapagoorden_edit, '%Y-%m-%d', '22', '22', '', 'onChange="ocultarDiv(\'error_fecha_pago_orden\');"');
            $form->addError('error_fecha_pago_orden', ERROR_FECHA_PAGO_ORDEN);
        }


        $form->addEtiqueta(OBSERVACIONES_ORDEN);
        $form->addTextArea('textarea', 'txt_observaciones_edit', 'txt_observaciones_edit', '50', '4', $observacionesorden_edit, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_OBSERVACIONES);
        $form->addEtiqueta(ARCHIVO_ORDEN);
        $form->addInputFile('file', 'file_orden_edit', 'file_orden_edit', '25', 'file', 'onChange="ocultarDiv(\'error_archivo\');"');
        $form->addError('error_archivo', ERROR_ORDEN_ARCHIVO);




        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_editar_ordendepago();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionordendepago(\'frm_editar_orden\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');

        $form->writeForm();
        break;
    /**
     * la variable Guardaredicion, permite guardar los atributos del objeto orden de pago
     * modificados en la base de datos
     */
    case 'Guardaredicion':
        $id_edit = $_REQUEST['txt_id'];
        $reintegro_edit = $_REQUEST['sel_reintegro_edit'];
        if($reintegro_edit != 2){
            $numero_proveedor_edit = 'null';
        }else{
            $numero_proveedor_edit = $_REQUEST['txt_reintegro_edit'];
        }
        $tipo_actividad_edit = $_REQUEST['sel_tipo_actividad_edit'];
        $actividad_edit = $_REQUEST['sel_actividad_edit'];
        $proveedor_edit = $_REQUEST['sel_proveedor_edit'];

        $estado_edit = $_REQUEST['sel_estado_edit'];
        $numerordendepago_edit = $_REQUEST['txt_numero_ordendepago_edit'];
        $fechaorden_edit = $_REQUEST['fecha_orden_edit'];
        $numerofactura_edit = $_REQUEST['txt_numero_factura_edit'];
        $moneda_edit = $_REQUEST['sel_moneda_edit'];
        if ($moneda_edit != 1) {
            $tasaorden_edit = $_REQUEST['txt_tasa_edit'];
        } else {
            $tasaorden_edit = 1;
        }
        $valortotal_edit = $_REQUEST['txt_valor_total_orden_edit'];
        $fechapagoorden_edit = $_REQUEST['fecha_pago_orden_edit'];
        $observacionesorden_edit = $_REQUEST['txt_observaciones_edit'];
        $archivo_anterior = $_REQUEST['txt_archivo_anterior'];
        $fecha_anterior_orden = $_REQUEST['txt_fecha_anterior'];
        $archivo = $_FILES['file_orden_edit'];

        $ordenesdepago = new COrdenesdepago($id_edit, $tipo_actividad_edit, $actividad_edit,
                $numerordendepago_edit, $fechaorden_edit, $numerofactura_edit, $proveedor_edit, 
                $moneda_edit, $tasaorden_edit, $valortotal_edit, $estado_edit, $fechapagoorden_edit, 
                $observacionesorden_edit, $numero_proveedor_edit, $archivo, $docData);
        $m = $ordenesdepago->guardarEdicionOrden($archivo_anterior, $fecha_anterior_orden);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");



        break;

    /**
     * la variable default genera un mesaje que indica que el modulo esta en construccion
     */
    default:
        include('templates/html/under.html');

        break;
}
?>
