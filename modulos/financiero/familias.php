<?php

defined('_VALID_PRY') or die('Restricted access');
$docData = new CFamiliaData($db);
$task = $_REQUEST['task'];
$operador = $_REQUEST['operador'];
if (empty($task))
    $task = 'list';
switch ($task) {

    /**
     * la variable list, permite cargar la pagina con los objetos 
     * familias
     */
    case 'list':

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_FAMILIAS);
        $form->setId('frm_list_familias');
        $form->setMethod('post');
        $form->options['autoClean']=false;
        $form->addInputText('hidden', 'txt_host', 'txt_host', '45', '20', $db->host, '', '');
        $form->addInputText('hidden', 'txt_usuario', 'txt_usuario', '45', '20', $db->usuario, '', '');
        $form->addInputText('hidden', 'txt_contrasena', 'txt_password', '45', '20', $db->password, '', '');
        $form->addInputText('hidden', 'txt_basedatos', 'txt_basedatos', '45', '20', $db->database, '', '');
        $form->addInputButton('button' . '', 'ok', 'ok', BOTON_EXPORTAR, 'button', 'onclick="validar_familias_excel();"');
        $form->writeForm();

        $dt = new CHtmlDataTable();
        $familias = $docData->obtenerfamilias();
        $dt->setTitleTable(TABLA_TITULO_FAMILIAS);
        $titulos = array(DESCRIPCION_FAMILIA);
        $dt->setDataRows($familias);
        $dt->setTitleRow($titulos);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=editarfamilia");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=borrarfamilia");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=Agregarfamilia");
        $dt->setType(1);
        $dt->setPag(1);

        $dt->writeDataTable($niv);

        break;
    /**
     * la variable Agregarfamilia, permite cargar el formulario y los datos 
     * de un objeto familia
     */
    case 'Agregarfamilia':

        $form = new CHtmlForm();
        $form->setTitle(TITULO_AGREGAR_FAMILIA);
        $form->setId('frm_agregar_familia');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addEtiqueta(DESCRIPCION_FAMILIA);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', '40', '40', $descripcion, '', 'onkeypress="ocultarDiv(\'error_descripcion_familia\');"');
        $form->addError('error_descripcion_familia', ERROR_DESCRIPCION_FAMILIA);
        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_agregar_familia();"');
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionFamilia(\'frm_agregar_familia\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;
    /**
     * la variable guardarfamilia, permite cargar la datos de la variable Agregarfamilia 
     * y agregar a la base de datos el objeto familia 
     */
    case 'guardarfamilia':

        $descripcion = $_REQUEST['txt_descripcion'];
        $nuevafamilia = $docData->insertarfamilia('', $descripcion);
        echo $html->generaAviso($nuevafamilia, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;
    /**
     * la variable familia,  cargar los datos del objeto familia que se 
     * va a eliminar y los envia a la variable ConfirmarBorrar 
     */
    case 'borrarfamilia':

        $id_delete = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $form = new CHtmlForm();
        $form->setId('frm_borrar_familia');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_descripcion', 'txt_descripcion', '15', '15', $descripcion, '', '');
        $form->writeForm();
        echo $html->generaAdvertencia(MENSAJE_BORRAR_FAMILIA, '?mod=' . $modulo . '&niv=' . $niv .
                '&task=confirmaborrar&id_element=' . $id_delete, "cancelarAccionFamilia('frm_borrar_familia','?mod=" . $modulo . "&niv=" . $niv . "');");
        break;
    /**
     * la variable confirmarborar, permite eliminar el objeto de la base de datos
     */
    case 'confirmaborrar':

        $id_delete = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $familia = new CFamilia($id_delete, $descripcion, $docData);
        $familia->cargarfamilia();
        $id = $familia->getId();
        $eliminar = $familia->eliminarfamilia($id);
        echo $html->generaAviso($eliminar, "?mod=" . $modulo . "&niv=" . $niv . "&task=list", "cancelarAccionFamilia('frm_borrar_familia','?mod=" . $modulo . "&niv=" . $niv . "');");


        break;
    /**
     * la variable editarfamilia, genera un formulario y carga los datos del 
     * objeto familia que se va a editar
     */
    case 'editarfamilia':

        $id_edit = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $familia = new CFamilia($id_edit, '', $docData);
        $familia->cargarfamilia();
        if (!isset($_REQUEST['txt_descripcion_edit']) || $_REQUEST['txt_descripcion_edit'] != '')
            $descripcion_edit = $familia->getDescripcion();
        else
            $descripcion_edit = $_REQUEST['txt_descripcion_edit'];
        $form = new CHtmlForm();
        $form->setTitle(TITULO_EDITAR_FAMILIA);
        $form->setId('frm_editar_familia');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $familia->getId(), '', '');
        $form->addEtiqueta(DESCRIPCION_FAMILIA);
        $form->addInputText('text', 'txt_descripcion_edit', 'txt_descripcion_edit', '40', '40', $descripcion_edit, '', 'onkeypress="ocultarDiv(\'error_descripcion_familia\');"');
        $form->addError('error_descripcion_familia', ERROR_DESCRIPCION_FAMILIA);
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_editar_familia();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionFamilia(\'frm_editar_familia\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;

    /**
     * la variable guardaredicion, permite guardar los atributos del objeto familia
     * modificados en la base de datos 
     */
    case 'guardaredicion':

        $id_edit = $_REQUEST['txt_id'];
        $descripcion_edit = $_REQUEST['txt_descripcion_edit'];

        $familia = new CFamilia($id_edit, $descripcion_edit, $docData);
        $familia->cargarfamilia();
        $edicion = $familia->actualizafamilias($id_edit, $descripcion_edit);
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