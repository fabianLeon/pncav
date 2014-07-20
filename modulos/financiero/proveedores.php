<?php

defined('_VALID_PRY') or die('Restricted access');
$docData = new CProveedorData($db);
$task = $_REQUEST['task'];
$operador = $_REQUEST['operador'];
if (empty($task))
    $task = 'list';
switch ($task) {

    /**
     * la variable list, permite cargar la pagina con los objetos 
     * proveedores
     */
    case 'list':


        $criterio = $_REQUEST['txt_filtro_proveedor'];
        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TABLA_PROVEEDORES);
        $form->setId('frm_list_proveedores');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addEtiqueta(FILTRO_PROVEEDOR);
        $form->addInputText('text', 'txt_filtro_proveedor', 'txt_filtro_proveedor', '11', '11', $criterio, '', '');
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_proveedores();');
        $form->addInputButton('button' . '', 'ok', 'ok', BOTON_EXPORTAR, 'button', 'onclick="validar_proveedores_excel();"');
        $form->writeForm();

        $dt = new CHtmlDataTable();
        $proveedores = $docData->obtenerproveedores($criterio);
        $dt->setTitleTable(TABLA_TITULO_PROVEEDORES);
        $titulos = array(NIT_PROVEEDOR, NOMBRE_PROVEEDOR, TEL_PROVEEDOR, UBICACION_PROVEEDOR, NOMBRE_CONTACTO_PROVEEDOR, TELEFONO_CONTACTO_PROVEEDOR, EMAIL_PROVEEDOR);
        $dt->setDataRows($proveedores);
        $dt->setTitleRow($titulos);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=editarproveedor");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=borrarproveedor");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=AgregarProveedor");
        $dt->setType(1);
        $dt->setPag(1);

        $dt->writeDataTable($niv);

        break;
    /**
     * la variable AgregarProveedor, permite cargar el formulario y los datos 
     * de un objeto proveedor
     */
    case 'AgregarProveedor':



        $nit = $_REQUEST['txt_nit_proveedor'];
        $nombre = $_REQUEST['txt_nombre_proveedor'];
        $telefono = $_REQUEST['txt_telefono_proveedor'];
        $pais = $_REQUEST['sel_pais_proveedor'];
        $ciudad = $_REQUEST['sel_ciudad_proveedor'];
        $direccion = $_REQUEST['txt_direccion_proveedor'];
        $contactoprove = $_REQUEST['txt_nombre_contac_proveedor'];
        $contactoproveA = $_REQUEST['txt_ApA_contac_proveedor'];
        $contactoproveB = $_REQUEST['txt_ApB_contac_proveedor'];
        $telcontac = $_REQUEST['txt_tel_contac_proveedor'];
        $email = $_REQUEST['txt_emal_proveedor'];

        $paises = $docData->ObtenerPaises();
        $opcionespais = null;
        if (isset($paises)) {
            foreach ($paises as $t) {
                $opcionespais[count($opcionespais)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $ciudades = $docData->ObtenerCiudades($pais);
        $opcionesciudades = null;
        if (isset($ciudades)) {
            foreach ($ciudades as $t) {
                $opcionesciudades[count($opcionesciudades)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form = new CHtmlForm();
        $form->setTitle(TITULO_AGREGAR_PROVEEDORES);
        $form->setId('frm_agregar_proveedor');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addEtiqueta(NIT_PROVEEDOR);
        $form->addInputText('text', 'txt_nit_proveedor', 'txt_nit_proveedor', '11', '11', $nit, '', 'onkeypress="ocultarDiv(\'error_nit\');"');
        $form->addError('error_nit', ERROR_NIT_PROVEEDOR);
        $form->addEtiqueta(NOMBRE_PROVEEDOR);
        $form->addInputText('text', 'txt_nombre_proveedor', 'txt_nombre_proveedor', '60', '60', $nombre, '', 'onkeypress="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_NOMBRE_PROVEEDOR);
        $form->addEtiqueta(TEL_PROVEEDOR);
        $form->addInputText('text', 'txt_telefono_proveedor', 'txt_telefono_proveedor', '12', '12', $telefono, '', 'onkeypress="ocultarDiv(\'error_telefono\');"');
        $form->addError('error_telefono', ERROR_TELEFONO_PROVEEDOR);

        $form->addEtiqueta(PAIS_PROVEEDOR);
        $form->addSelect('select', 'sel_pais_proveedor', 'sel_pais_proveedor', $opcionespais, 'Seleccione', $pais, '', 'onChange=submit();');
        //$form->addInputText('text', 'txt_pais_proveedor', 'txt_pais_proveedor', '30', '30', $pais, '', 'onkeypress="ocultarDiv(\'error_pais\');"');
        $form->addError('error_pais', ERROR_PAIS_PROVEEDOR);

        $form->addEtiqueta(CIUDAD_PROVEEDOR);
        $form->addSelect('select', 'sel_ciudad_proveedor', 'sel_ciudad_proveedor', $opcionesciudades, 'Seleccione', $ciudad, '', 'onChange=submit();');
        // $form->addInputText('text', 'txt_ciudad_proveedor', 'txt_ciudad_proveedor', '30', '30', $ciudad, '', 'onkeypress="ocultarDiv(\'error_cuidad\');"');
        $form->addError('error_cuidad', ERROR_CIUDAD_PROVEEDOR);

        $form->addEtiqueta(DIRECCION_PROVEEDOR);
        $form->addInputText('text', 'txt_direccion_proveedor', 'txt_direccion_proveedor', '40', '40', $direccion, '', 'onkeypress="ocultarDiv(\'error_direccion\');"');
        $form->addError('error_direccion', ERROR_DIRECCION_PROVEEDOR);
        $form->addEtiqueta(NOMBRE_CONTACTO_PROVEEDOR);
        $form->addInputText('text', 'txt_nombre_contac_proveedor', 'txt_nombre_contac_proveedor', '30', '30', $contactoprove, '', 'onkeypress="ocultarDiv(\'error_contacprove\');"');
        $form->addError('error_contacprove', ERROR_NOMBRE_CONTAC_PROVEEDOR);
        $form->addEtiqueta(APELLIDO_CONTACTO_PROVEEDOR);
        $form->addInputText('text', 'txt_ApA_contac_proveedor', 'txt_ApA_contac_proveedor', '30', '30', $contactoproveA, '', 'onkeypress="ocultarDiv(\'error_contacprove_apellido\');"');

        $form->addError('error_contacprove_apellido', ERROR_TEL_APELLIDO_PROVEEDOR);
        $form->addEtiqueta(APELLIDOB_CONTACTO_PROVEEDOR);
        $form->addInputText('text', 'txt_ApB_contac_proveedor', 'txt_ApB_contac_proveedor', '30', '30', $contactoproveB, '', '');
        $form->addError('error_oculto', '');
        $form->addEtiqueta(TELEFONO_CONTACTO_PROVEEDOR);
        $form->addInputText('text', 'txt_tel_contac_proveedor', 'txt_tel_contac_proveedor', '12', '12', $telcontac, '', 'onkeypress="ocultarDiv(\'error_telcontac\');"');
        $form->addError('error_telcontac', ERROR_TEL_CONTAC_PROVEEDOR);
        $form->addEtiqueta(EMAIL_PROVEEDOR);
        $form->addInputText('text', 'txt_emal_proveedor', 'txt_emal_proveedor', '50', '50', $email, '', 'onkeypress="ocultarDiv(\'error_email\');"');
        $form->addError('error_email', ERROR_EMAIL_PROVEEDOR);

        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_agregar_proveedor();"');
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionProveedoor(\'frm_agregar_proveedor\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');


        $form->writeForm();
        break;
    /**
     * la variable guardarproveedor, permite cargar los datos de la variable AgregarProveedor 
     * y agregar a la base de datos el objeto proveedor 
     */
    case 'guardarproveedor':

        $nit = $_REQUEST['txt_nit_proveedor'];
        $nombre = $_REQUEST['txt_nombre_proveedor'];
        $telefono = $_REQUEST['txt_telefono_proveedor'];
        $pais = $_REQUEST['sel_pais_proveedor'];
        $ciudad = $_REQUEST['sel_ciudad_proveedor'];
        $direccion = $_REQUEST['txt_direccion_proveedor'];
        $contactoprove = $_REQUEST['txt_nombre_contac_proveedor'];
        $contactoproveA = $_REQUEST['txt_ApA_contac_proveedor'];
        $contactoproveB = $_REQUEST['txt_ApB_contac_proveedor'];
        $telcontac = $_REQUEST['txt_tel_contac_proveedor'];
        $email = $_REQUEST['txt_emal_proveedor'];


        $Nuevoproveedor = $docData->insertarproveedor($id, $nit, $nombre, $telefono, $pais, $ciudad, $direccion, $contactoprove, $contactoproveA, $contactoproveB, $telcontac, $email);
        echo $html->generaAviso($Nuevoproveedor, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;
    /**
     * la variable borrarproveedor,  cargar los datos del objeto proveedor que se 
     * va a eliminar y los envia a la variable ConfirmarBorrar 
     */
    case 'borrarproveedor':

        $id_delete = $_REQUEST['id_element'];
        $nit = $_REQUEST['txt_nit_proveedor'];
        $nombre = $_REQUEST['txt_nombre_proveedor'];
        $telefono = $_REQUEST['txt_telefono_proveedor'];
        $pais = $_REQUEST['sel_pais_proveedor'];
        $ciudad = $_REQUEST['sel_ciudad_proveedor'];
        $direccion = $_REQUEST['txt_direccion_proveedor'];
        $contactoprove = $_REQUEST['txt_nombre_contac_proveedor'];
        $contactoproveA = $_REQUEST['txt_ApA_contac_proveedor'];
        $contactoproveB = $_REQUEST['txt_ApB_contac_proveedor'];
        $telcontac = $_REQUEST['txt_tel_contac_proveedor'];
        $email = $_REQUEST['txt_emal_proveedor'];


        $form = new CHtmlForm();
        $form->setId('frm_borrar_proveedor');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_nit_proveedor', 'txt_nit_proveedor', '15', '15', $nit, '', '');
        $form->addInputText('hidden', 'txt_nombre_proveedor', 'txt_nombre_proveedor', '15', '15', $nombre, '', '');
        $form->addInputText('hidden', 'txt_telefono_proveedor', 'txt_telefono_proveedor', '15', '15', $telefono, '', '');
        $form->addInputText('hidden', 'sel_pais_proveedor', 'sel_pais_proveedor', '15', '15', $pais, '', '');
        $form->addInputText('hidden', 'sel_ciudad_proveedor', 'sel_ciudad_proveedor', '15', '15', $ciudad, '', '');
        $form->addInputText('hidden', 'txt_direccion_proveedor', 'txt_direccion_proveedor', '15', '15', $direccion, '', '');
        $form->addInputText('hidden', 'txt_nombre_contac_proveedor', 'txt_nombre_contac_proveedor', '15', '15', $contactoprove, '', '');
        $form->addInputText('hidden', 'txt_ApA_contac_proveedor', 'txt_ApA_contac_proveedor', '15', '15', $contactoproveA, '', '');
        $form->addInputText('hidden', 'txt_ApB_contac_proveedor', 'txt_ApB_contac_proveedor', '15', '15', $contactoproveB, '', '');
        $form->addInputText('hidden', 'txt_tel_contac_proveedor', 'txt_tel_contac_proveedor', '15', '15', $telcontac, '', '');
        $form->addInputText('hidden', 'txt_emal_proveedor', 'txt_emal_proveedor', '15', '15', $email, '', '');
        $form->writeForm();
        echo $html->generaAdvertencia(MENSAJE_BORRAR_PROVEEDOR, '?mod=' . $modulo . '&niv=' . $niv .
                '&task=confirmaborrar&id_element=' . $id_delete . '&txt_nit_proveedor=' . $nit . '&txt_nombre_proveedor=' . $nombre . '&txt_telefono_proveedor=' . $telefono .
                '&txt_pais_proveedor=' . $pais . '&txt_ciudad_proveedor=' . $ciudad . '&txt_direccion_proveedor=' . $direccion . '&txt_nombre_contac_proveedor=' . $contactoprove . '&txt_ApA_contac_proveedor=' . $contactoproveA . '&txt_ApB_contac_proveedor=' . $contactoproveB .
                '&txt_tel_contac_proveedor=' . $telcontac . '&txt_emal_proveedor=' . $email, "cancelarAccionProveedoor('frm_borrar_proveedor','?mod=" . $modulo . "&niv=" . $niv . "');");
        break;
    /**
     * la variable confirmarborar, permite eliminar el objeto de la base de datos
     */
    case 'confirmaborrar':

        $id_delete = $_REQUEST['id_element'];
        $nit = $_REQUEST['txt_nit_proveedor'];
        $nombre = $_REQUEST['txt_nombre_proveedor'];
        $telefono = $_REQUEST['txt_telefono_proveedor'];
        $pais = $_REQUEST['sel_pais_proveedor'];
        $ciudad = $_REQUEST['sel_ciudad_proveedor'];
        $direccion = $_REQUEST['txt_direccion_proveedor'];
        $contactoprove = $_REQUEST['txt_nombre_contac_proveedor'];
        $contactoproveA = $_REQUEST['txt_ApA_contac_proveedor'];
        $contactoproveB = $_REQUEST['txt_ApB_contac_proveedor'];
        $telcontac = $_REQUEST['txt_tel_contac_proveedor'];
        $email = $_REQUEST['txt_emal_proveedor'];

        $proveedor = new CProveedor($id_delete, '', '', '', '', '', '', '', '', '', '', '', $docData);
        $proveedor->cargarproveedor();
        $id = $proveedor->getid();
        $eliminar = $proveedor->eliminarproveedor($id);
        echo $html->generaAviso($eliminar, "?mod=" . $modulo . "&niv=" . $niv . "&task=list", "cancelarAccion('frm_borrar_proveedor','?mod=" . $modulo . "&niv=" . $niv . "');");


        break;
    /**
     * la variable editarproveedor, genera un formulario y carga los datos del 
     * objeto proveedor que se va a editar
     */
    case 'editarproveedor':
        $id_edit = $_REQUEST['id_element'];
        
        $proveedor = new CProveedor($id_edit, '', '', '', '', '', '', '', '', '', '', '', $docData);
        $proveedor->cargarproveedor();

        if (!isset($_REQUEST['txt_nit_proveedor_edit']) )
            $nit_edit = $proveedor->getNit();
        else
            $nit_edit = $_REQUEST['txt_nit_proveedor_edit'];


        if (!isset($_REQUEST['txt_nombre_proveedor_edit']) )
            $nombre_edit = $proveedor->getNombreProveedor();
        else
            $nombre_edit = $_REQUEST['txt_nombre_proveedor_edit'];


        if (!isset($_REQUEST['txt_telefono_proveedor_edit']) )
            $telefono_edit = $proveedor->getTelefonoProveedor();
        else
            $telefono_edit = $_REQUEST['txt_telefono_proveedor_edit'];


        if (!isset($_REQUEST['sel_pais_proveedor_edit']) || $_REQUEST['sel_pais_proveedor_edit'] <= 0)
            $pais_edit = $proveedor->getPaisProveedor();
        else
            $pais_edit = $_REQUEST['sel_pais_proveedor_edit'];


        if (!isset($_REQUEST['sel_ciudad_proveedor_edit']) || $_REQUEST['sel_ciudad_proveedor_edit'] <= 0)
            $ciudad_edit = $proveedor->getCiudadProveedor();
        
        else
            $ciudad_edit = $_REQUEST['sel_ciudad_proveedor_edit'];


        if (!isset($_REQUEST['txt_direccion_proveedor_edit']) )
            $direccion_edit = $proveedor->getDireccion();
        else
            $direccion_edit = $_REQUEST['txt_direccion_proveedor_edit'];


        if (!isset($_REQUEST['txt_nombre_contac_proveedor_edit']) )
            $contactoprove_edit = $proveedor->getNombredelContacto();
        else
            $contactoprove_edit = $_REQUEST['txt_nombre_contac_proveedor_edit'];

        if (!isset($_REQUEST['txt_ApA_contac_proveedor_edit']))
            $contactoproveA_edit = $proveedor->getapellidoA();
        else
            $contactoproveA_edit = $_REQUEST['txt_ApA_contac_proveedor_edit'];

        if (!isset($_REQUEST['txt_ApB_contac_proveedor_edit']) )
            $contactoproveB_edit = $proveedor->getapellidoB();
        else
            $contactoproveB_edit = $_REQUEST['txt_ApB_contac_proveedor_edit'];


        if (!isset($_REQUEST['txt_tel_contac_proveedor_edit']) )
            $telcontac_edit = $proveedor->getTelefonodelCotacto();
        else
            $telcontac_edit = $_REQUEST['txt_tel_contac_proveedor_edit'];


        if (!isset($_REQUEST['txt_emal_proveedor_edit']) )
            $email_edit = $proveedor->getemail();
        else
            $email_edit = $_REQUEST['txt_emal_proveedor_edit'];


        $form = new CHtmlForm();
        $form->setTitle(TITULO_EDITAR_PROVEEDOR);
        $form->setId('frm_editar_proveedor');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $proveedor->getid(), '', '');
        
        $paises = $docData->ObtenerPaises();
        $opcionespais = null;
        if (isset($paises)) {
            foreach ($paises as $t) {
                $opcionespais[count($opcionespais)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $ciudades = $docData->ObtenerCiudades($pais_edit);
        $opcionesciudades = null;
        if (isset($ciudades)) {
            foreach ($ciudades as $t) {
                $opcionesciudades[count($opcionesciudades)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }



        $form->addEtiqueta(NIT_PROVEEDOR);
        $form->addInputText('text', 'txt_nit_proveedor_edit', 'txt_nit_proveedor_edit', '11', '11', $nit_edit, '', 'onkeypress="ocultarDiv(\'error_nit\');"');
        $form->addError('error_nit', ERROR_NIT_PROVEEDOR);
        $form->addEtiqueta(NOMBRE_PROVEEDOR);
        $form->addInputText('text', 'txt_nombre_proveedor_edit', 'txt_nombre_proveedor_edit', '60', '60', $nombre_edit, '', 'onkeypress="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_NOMBRE_PROVEEDOR);
        $form->addEtiqueta(TEL_PROVEEDOR);
        $form->addInputText('text', 'txt_telefono_proveedor_edit', 'txt_telefono_proveedor_edit', '12', '12', $telefono_edit, '', 'onkeypress="ocultarDiv(\'error_telefono\');"');
        $form->addError('error_telefono', ERROR_TELEFONO_PROVEEDOR);

        $form->addEtiqueta(PAIS_PROVEEDOR);
        $form->addSelect('select', 'sel_pais_proveedor_edit', 'sel_pais_proveedor_edit', $opcionespais, 'Seleccione', $pais_edit, '', 'onChange=submit();');
        //$form->addInputText('text', 'txt_pais_proveedor', 'txt_pais_proveedor', '30', '30', $pais, '', 'onkeypress="ocultarDiv(\'error_pais\');"');
        $form->addError('error_pais', ERROR_PAIS_PROVEEDOR);

        $form->addEtiqueta(CIUDAD_PROVEEDOR);
        $form->addSelect('select', 'sel_ciudad_proveedor_edit', 'sel_ciudad_proveedor_edit', $opcionesciudades, 'Seleccione', $ciudad_edit, '', 'onChange=submit();');
        // $form->addInputText('text', 'txt_ciudad_proveedor', 'txt_ciudad_proveedor', '30', '30', $ciudad, '', 'onkeypress="ocultarDiv(\'error_cuidad\');"');
        $form->addError('error_cuidad', ERROR_CIUDAD_PROVEEDOR);


        $form->addEtiqueta(DIRECCION_PROVEEDOR);
        $form->addInputText('text', 'txt_direccion_proveedor_edit', 'txt_direccion_proveedor_edit', '40', '40', $direccion_edit, '', 'onkeypress="ocultarDiv(\'error_direccion\');"');
        $form->addError('error_direccion', ERROR_DIRECCION_PROVEEDOR);
        $form->addEtiqueta(NOMBRE_CONTACTO_PROVEEDOR);
        $form->addInputText('text', 'txt_nombre_contac_proveedor_edit', 'txt_nombre_contac_proveedor_edit', '30', '30', $contactoprove_edit, '', 'onkeypress="ocultarDiv(\'error_contacprove\');"');
        $form->addError('error_contacprove', ERROR_NOMBRE_CONTAC_PROVEEDOR);
        $form->addEtiqueta(APELLIDO_CONTACTO_PROVEEDOR);
        $form->addInputText('text', 'txt_ApA_contac_proveedor_edit', 'txt_ApA_contac_proveedor_edit', '30', '30', $contactoproveA_edit, '', 'onkeypress="ocultarDiv(\'error_contacprove_apellido\');"');
        $form->addError('error_contacprove_apellido', ERROR_APELLIDO_CONTAC_PROVEEDOR);
        $form->addEtiqueta(APELLIDOB_CONTACTO_PROVEEDOR);
        $form->addInputText('text', 'txt_ApB_contac_proveedor_edit', 'txt_ApB_contac_proveedor_edit', '30', '30', $contactoproveB_edit, '', 'onkeypress="ocultarDiv(\'error_oculto\');"');
        $form->addError('error_oculto', '');
        $form->addEtiqueta(TELEFONO_CONTACTO_PROVEEDOR);
        $form->addInputText('text', 'txt_tel_contac_proveedor_edit', 'txt_tel_contac_proveedor_edit', '12', '12', $telcontac_edit, '', 'onkeypress="ocultarDiv(\'error_telcontac\');"');
        $form->addError('error_telcontac', ERROR_TEL_CONTAC_PROVEEDOR);
        $form->addEtiqueta(EMAIL_PROVEEDOR);
        $form->addInputText('text', 'txt_emal_proveedor_edit', 'txt_emal_proveedor_edit', '70', '70', $email_edit, '', 'onkeypress="ocultarDiv(\'error_email\');"');
        $form->addError('error_email', ERROR_EMAIL_PROVEEDOR);


        $form->addInputText('hidden', 'txt_nit_proveedor', 'txt_nit_proveedor', '15', '15', $nit, '', '');
        $form->addInputText('hidden', 'txt_nombre_proveedor', 'txt_nombre_proveedor', '15', '15', $nombre, '', '');
        $form->addInputText('hidden', 'txt_telefono_proveedor', 'txt_telefono_proveedor', '15', '15', $telefono, '', '');
        $form->addInputText('hidden', 'txt_pais_proveedor', 'txt_pais_proveedor', '15', '15', $pais, '', '');
        $form->addInputText('hidden', 'txt_ciudad_proveedor', 'txt_ciudad_proveedor', '15', '15', $ciudad, '', '');
        $form->addInputText('hidden', 'txt_direccion_proveedor', 'txt_direccion_proveedor', '15', '15', $direccion, '', '');
        $form->addInputText('hidden', 'txt_nombre_contac_proveedor', 'txt_nombre_contac_proveedor', '15', '15', $contactoprove, '', '');
        $form->addInputText('hidden', 'txt_ApA_contac_proveedor', 'txt_ApA_contac_proveedor', '15', '15', $telcontac, '', '');
        $form->addInputText('hidden', 'txt_ApB_contac_proveedor', 'txt_ApB_contac_proveedor', '15', '15', $contactoproveA, '', '');
        $form->addInputText('hidden', 'txt_tel_contac_proveedor', 'txt_tel_contac_proveedor', '15', '15', $contactoproveB, '', '');
        $form->addInputText('hidden', 'txt_emal_proveedor', 'txt_emal_proveedor', '15', '15', $email, '', '');


        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_editar_proveedor();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionProveedoor(\'frm_editar_proveedor\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;
    /**
     * la variable guardaredicion, permite guardar los atributos del objeto proveedor
     * modificados en la base de datos 
     */
    case 'guardaredicion':

        $id_edit = $_REQUEST['txt_id'];
        $nit_edit = $_REQUEST['txt_nit_proveedor_edit'];
        $nombre_edit = $_REQUEST['txt_nombre_proveedor_edit'];
        $telefono_edit = $_REQUEST['txt_telefono_proveedor_edit'];
        $pais_edit = $_REQUEST['sel_pais_proveedor_edit'];
        $ciudad_edit = $_REQUEST['sel_ciudad_proveedor_edit'];
        $direccion_edit = $_REQUEST['txt_direccion_proveedor_edit'];
        $contactoprove_edit = $_REQUEST['txt_nombre_contac_proveedor_edit'];
        $contactoproveA_edit = $_REQUEST['txt_ApA_contac_proveedor_edit'];
        $contactoproveB_edit = $_REQUEST['txt_ApB_contac_proveedor_edit'];
        $telcontac_edit = $_REQUEST['txt_tel_contac_proveedor_edit'];
        $email_edit = $_REQUEST['txt_emal_proveedor_edit'];

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


        $proveedor = new CProveedor($id_edit, $nit_edit, $nombre_edit, $telefono_edit, $pais_edit, $ciudad_edit, $direccion_edit, $contactoprove_edit, $contactoproveA_edit, $contactoproveB_edit, $telcontac_edit, $email_edit, $docData);
        $proveedor->cargarproveedor();
        $edicion = $proveedor->actualizarproveedor($id_edit, $nit_edit, $nombre_edit, $telefono_edit, $pais_edit, $ciudad_edit, $direccion_edit, $contactoprove_edit, $contactoproveA_edit, $contactoproveB_edit, $telcontac_edit, $email_edit);
        echo $html->generaAviso($edicion, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;


    /**
     * la variable default genera un mesaje que indica que el modulo esta en construccion
     */
    default:
        include('templates/html/under.html');

        break;
}
?>