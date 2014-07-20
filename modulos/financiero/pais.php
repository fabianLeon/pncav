<?php

defined('_VALID_PRY') or die('Restricted access');
$docData = new CPaisData($db);
$task = $_REQUEST['task'];
$operador = $_REQUEST['operador'];
if (empty($task)) {
    $task = 'list';
}
switch ($task) {
    case 'list':

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_PAIS);
        $form->setId('frm_list_paises');
        $form->setMethod('post');
        $form->addInputText('hidden', $id, $name, $size, $maxlength, $value, $class, $events);
        $form->writeForm();

        //Cambio de este archivo
        //Agregación de la tabla de datos al formulario
        $dt = new CHtmlDataTable();
        //Obtención de los datos
        $paises = $docData->obtenerPais();
        $dt->setTitleTable(TITULO_TABLA_PAIS);
        $titulos = array(NOMBRE_PAIS);
        $dt->setDataRows($paises);
        $dt->setTitleRow($titulos);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=editarpais");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=borrarpais");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=agregarpais");
        $dt->setType(1);
        $dt->setPag(1);

        $dt->writeDataTable($niv);
        //

        break;

    //Generación del formulario de creación de paises
    case 'agregarpais':

        $form = new CHtmlForm();
        $form->setTitle(TITULO_AGREGAR_PAIS);
        $form->setId('frm_agregar_pais');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        //Agregación de etiqueta y campo de texto para el nombre del país
        $form->addEtiqueta(NOMBRE_PAIS);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '20', '20', $nombre, '', 'onkeypress="ocultarDiv(\'error_nombre_pais\');"');
        $form->addError('error_nombre_pais', ERROR_NOMBRE_PAIS);
        //
        
        //Agregación de los botones del formulario
        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_agregar_pais();"');
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionPais(\'frm_agregar_pais\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;

    //Generación del formulario de confirmación de ingreso de paises
    case 'guardarpais':

        $nombre = $_REQUEST['txt_nombre'];
        $nuevoPais = $docData->insertarPais('', strtoupper($nombre));
        echo $html->generaAviso($nuevoPais, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;

    //Generación del formulario de confirmación de borrado de paises
    case 'borrarpais':

        $id_delete = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_nombre'];
        $form = new CHtmlForm();
        $form->setId('frm_borrar_pais');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_nombre', 'txt_nombre', '15', '15', $descripcion, '', '');
        $form->writeForm();
        echo $html->generaAdvertencia(MENSAJE_ELIMINAR_PAIS, '?mod=' . $modulo . '&niv=' . $niv .
                '&task=confirmaborrar&id_element=' . $id_delete, "cancelarAccionPais('frm_borrar_pais','?mod=" . $modulo . "&niv=" . $niv . "');");
        break;
    
    //Generación del formulario de confirmación de eliminación de paises
    case 'confirmaborrar':

        $id_delete = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_nombre'];
        $pais = new CPais($id_delete, $descripcion, $docData);
        $pais->cargarPais();
        $id = $pais->getId();
        $eliminar = $pais->eliminarPais($id);
        echo $html->generaAviso($eliminar, "?mod=" . $modulo . "&niv=" . $niv . "&task=list", "cancelarAccionPais('frm_borrar_pais','?mod=" . $modulo . "&niv=" . $niv . "');");


        break;
    
    //Generación del formulario de edición de paises
    case 'editarpais':

        $id_edit = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_nombre'];
        
        //Creación del objeto CPais
        $pais = new CPais($id_edit,'', $docData);
        $pais->cargarPais();
        if (!isset($_REQUEST['txt_nombre_edit']) || $_REQUEST['txt_nombre_edit'] != '')
            $descripcion_edit = $pais->getNombre();
        else
            $descripcion_edit = $_REQUEST['txt_nombre_edit'];
        //
        
        //Generación del formulario
        $form = new CHtmlForm();
        $form->setTitle(TITULO_EDITAR_PAIS);
        $form->setId('frm_editar_pais');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $pais->getId(), '', '');
        
        //Agregación de campos  la edición de nombre
        $form->addEtiqueta(NOMBRE_PAIS);
        $form->addInputText('text', 'txt_nombre_edit', 'txt_nombre_edit', '20', '20', $descripcion_edit, '', 'onkeypress="ocultarDiv(\'error_nombre_pais\');"');
        $form->addError('error_nombre_pais', ERROR_NOMBRE_PAIS);
        //
        
        //Agregación de los botones al formulario
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_editar_pais();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionPais(\'frm_editar_pais\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;

    //Generación del formulario de confirmación de edición de paises    
    case 'guardaredicion':

        $id_edit = $_REQUEST['txt_id'];
        $descripcion_edit = $_REQUEST['txt_nombre_edit'];
        
        $pais = new CPais($id_edit,$descripcion_edit, $docData);
        $pais->cargarPais();
        $edicion = $pais->actualizarPais($id_edit, strtoupper($descripcion_edit));
        echo $html->generaAviso($edicion, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;


    default:
        include('templates/html/under.html');

        break;
}
?>