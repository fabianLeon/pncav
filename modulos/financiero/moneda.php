<?php

defined('_VALID_PRY') or die('Restricted access');
$docData = new CMonedaData($db);
$task = $_REQUEST['task'];
$operador = $_REQUEST['operador'];
if (empty($task))
    $task = 'list';
switch ($task) {

    /**
     * la variable list, permite cargar la pagina con los objetos 
     * monedas
     */
    case 'list':


        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_MONEDA);
        $form->setId('frm_list_monedas');
        $form->setMethod('post');
        $form->options['autoClean']=false;
        $form->addInputText('hidden', 'txt_host', 'txt_host', '45', '20', $db->host, '', '');
        $form->addInputText('hidden', 'txt_usuario', 'txt_usuario', '45', '20', $db->usuario, '', '');
        $form->addInputText('hidden', 'txt_contrasena', 'txt_password', '45', '20', $db->password, '', '');
        $form->addInputText('hidden', 'txt_basedatos', 'txt_basedatos', '45', '20', $db->database, '', '');
        $form->addInputButton('button' . '', 'ok', 'ok', BOTON_EXPORTAR, 'button', 'onclick="validar_monedas_excel();"');
        $form->writeForm();

        $dt = new CHtmlDataTable();
        $monedas = $docData->obtenerMonedas();
        $dt->setTitleTable(TABLA_TITULO_MONEDAS);
        $titulos = array(DESCRIPCION_MONEDA);
        $dt->setDataRows($monedas);
        $dt->setTitleRow($titulos);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=editarmoneda");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=borrarMoneda");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=AgregaMoneda");
        $dt->setType(1);
        $dt->setPag(1);
       

        $dt->writeDataTable($niv);

        break;
    /**
     * la variable AgregarMoneda, permite cargar el formulario y los datos 
     * de un objeto moneda
     */
    case 'AgregaMoneda':

        $form = new CHtmlForm();
        $form->setTitle(TITULO_AGREGAR_MONEDA);
        $form->setId('frm_agregar_moneda');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addEtiqueta(DESCRIPCION_MONEDA);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', '20', '20', $descripcion, '', 'onkeypress="ocultarDiv(\'error_descripcion_moneda\');"');
        $form->addError('error_descripcion_moneda', ERROR_DESCRIPCION_MONEDA);
        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_agregar_moneda();"');
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionMoneda(\'frm_agregar_moneda\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;
    /**
     * la variable guardarmoneda, permite cargar los datos de la variable AgregarMoneda 
     * y agregar a la base de datos el objeto moneda 
     */
    case 'guardarmoneda':

        $descripcion = $_REQUEST['txt_descripcion'];
        $nuevamoneda = $docData->insertarMoneda('', $descripcion);
        echo $html->generaAviso($nuevamoneda, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;

    /**
     * la variable borrarMoneda  cargar los datos del objeto moneda que se 
     * va a eliminar y los envia a la variable ConfirmarBorrar 
     */
    case 'borrarMoneda':

        $id_delete = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $form = new CHtmlForm();
        $form->setId('frm_borrar_moneda');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_descripcion', 'txt_descripcion', '15', '15', $descripcion, '', '');
        $form->writeForm();
        echo $html->generaAdvertencia(MENSAJE_BORRAR_MONEDA, '?mod=' . $modulo . '&niv=' . $niv .
                '&task=confirmaborrar&id_element=' . $id_delete, "cancelarAccionMoneda('frm_borrar_moneda','?mod=" . $modulo . "&niv=" . $niv . "');");
        break;
    /**
     * la variable Confirmarborar, permite eliminar el objeto de la base de datos
     */
    case 'confirmaborrar':

        $id_delete = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $moneda = new CMoneda($id_delete, $descripcion, $docData);
        $moneda->cargarmoneda();
        $id = $moneda->getId();
        $eliminar = $moneda->eliminarmoneda($id);
        echo $html->generaAviso($eliminar, "?mod=" . $modulo . "&niv=" . $niv . "&task=list", "cancelarAccionMoneda('frm_borrar_moneda','?mod=" . $modulo . "&niv=" . $niv . "');");


        break;
    /**
     * la variable editarmoneda, genera un formulario y carga los datos del 
     * objeto moneda que se va a editar
     */
    case 'editarmoneda':

        $id_edit = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $moneda = new CMoneda($id_edit, '', $docData);
        $moneda->cargarmoneda();

        if (!isset($_REQUEST['txt_descripcion_edit']) || $_REQUEST['txt_descripcion_edit'] != '')
            $descripcion_edit = $moneda->getDescripcion();
        else
            $descripcion_edit = $_REQUEST['txt_descripcion_edit'];

        $form = new CHtmlForm();
        $form->setTitle(TITULO_EDITAR_MONEDA);
        $form->setId('frm_editar_moneda');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $moneda->getId(), '', '');
        $form->addEtiqueta(DESCRIPCION_MONEDA);
        $form->addInputText('text', 'txt_descripcion_edit', 'txt_descripcion_edit', '20', '20', $descripcion_edit, '', 'onkeypress="ocultarDiv(\'error_descripcion_moneda\');"');
        $form->addError('error_descripcion_moneda', ERROR_DESCRIPCION_MONEDA);
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_editar_moneda();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionFamilia(\'frm_editar_moneda\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;
    /**
     * la variable guardaredicion, permite guardar los atributos del objeto moneda
     * modificados en la base de datos 
     */
    case 'guardaredicion':

        $id_edit = $_REQUEST['txt_id'];
        $descripcion_edit = $_REQUEST['txt_descripcion_edit'];

        $moneda = new CMoneda($id_edit, $descripcion_edit, $docData);
        $moneda->cargarmoneda();
        $edicion = $moneda->actualizamoneda($id_edit, $descripcion_edit);
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