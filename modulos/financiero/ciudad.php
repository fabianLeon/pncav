<?php

defined('_VALID_PRY') or die('Restricted access');
$docData = new CCiudadData($db);
$task = $_REQUEST['task'];
$operador = $_REQUEST['operador'];
if (empty($task)) {
    $task = 'list';
}
switch ($task) {
    case 'list':
        
        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_CIUDAD);
        $form->setId('frm_list_ciudades');
        $form->setMethod('post');
        $form->addInputText('hidden', $id, $name, $size, $maxlength, $value, $class, $events);
        $form->writeForm();

        //Agregación de la tabla de datos al formulario
        $dt = new CHtmlDataTable();
        //Obtención de los datos
        $ciudades = $docData->obtenerCiudades();
        $dt->setTitleTable(TITULO_TABLA_CIUDAD);
        $titulos = array(NOMBRE_PAIS, NOMBRE_CIUDAD);
        $dt->setDataRows($ciudades);
        $dt->setTitleRow($titulos);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=editarciudad");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=borrarciudad");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=agregarciudad");
        $dt->setType(1);
        $dt->setPag(1);

        $dt->writeDataTable($niv);
        //
        break;

    //Generación del formulario de agregación de ciudad
    case 'agregarciudad':

        $form = new CHtmlForm();
        $form->setTitle(TITULO_AGREGAR_PAIS);
        $form->setId('frm_agregar_ciudad');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        $data = new CPaisData($db);
        //Obtención de los datos de paises por medio de el objeto $data
        $paises = $data->obtenerPais();
        $opciones = null;
        if (isset($paises)) {
            foreach ($paises as $c) {
                $opciones[count($opciones)] = array('value' => $c[0], 'texto' => $c[1]);
            }
        }
        //Agregación de una lista desplegable con los nombre de los paises al formulario
        $form->addEtiqueta(NOMBRE_PAIS);
        $form->addSelect('select', 'sel_pais', 'sel_pais', $opciones, NOMBRE_PAIS, $pais, '', 'onChange="ocultarDiv(\'error_pais\');"');
        $form->addError('error_pais', ERROR_SELECCION_PAIS);
        
        //Agregación de los campos de ingreso de información para el nombre de la ciudad
        $form->addEtiqueta(NOMBRE_CIUDAD);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '20', '20', $nombre, '', 'onkeypress="ocultarDiv(\'error_nombre_ciudad\');"');
        $form->addError('error_nombre_ciudad', ERROR_NOMBRE_CIUDAD);
        
        //Agregación de los botones al formulario
        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_agregar_ciudad();"');
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionCiudad(\'frm_agregar_ciudad\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;
        
    //Generación de la verificación de creación de ciudad
    case 'guardarciudad':

        $nombre = $_REQUEST['txt_nombre'];
        $pais = $_REQUEST['sel_pais'];
        $nuevoPais = $docData->insertarCiudad('', $pais, strtoupper($nombre));
        echo $html->generaAviso($nuevoPais, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;
    
    //Generación de confirmación de eliminación de ciudad
    case 'borrarciudad':

        $id_delete = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_nombre'];
        $form = new CHtmlForm();
        $form->setId('frm_borrar_ciudad');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_nombre', 'txt_nombre', '15', '15', $descripcion, '', '');
        $form->writeForm();
        echo $html->generaAdvertencia(MENSAJE_ELIMINAR_CIUDAD, '?mod=' . $modulo . '&niv=' . $niv .
                '&task=confirmaborrar&id_element=' . $id_delete, "cancelarAccionCiudad('frm_borrar_ciudad','?mod=" . $modulo . "&niv=" . $niv . "');");
        break;
    
    //Confirmación de eliminación de ciudad
    case 'confirmaborrar':

        $id_delete = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_nombre'];
        $ciudad = new CCiudad($id_delete, $pais, $descripcion, $docData);
        $ciudad->cargarCiudad();
        $id = $ciudad->getId();
        $eliminar = $ciudad->eliminarCiudad($id);
        echo $html->generaAviso($eliminar, "?mod=" . $modulo . "&niv=" . $niv . "&task=list", "cancelarAccionCiudad('frm_borrar_ciudad','?mod=" . $modulo . "&niv=" . $niv . "');");

        break;
    
    //Generación de formulario de edición de ciudad
    case 'editarciudad':

        $id_edit = $_REQUEST['id_element'];
        $nombre = $_REQUEST['txt_nombre'];
        $pais = $_REQUEST['sel_pais'];
        $ciudad = new CCiudad($id_edit,$pais,$nombre, $docData);
        $ciudad->cargarCiudad();
        /* @var $_REQUEST Array */
        if (!isset($_REQUEST['txt_nombre_edit']) || $_REQUEST['txt_nombre_edit'] != '') {
            $descripcion_edit = $ciudad->getNombre();
        } else {
            $descripcion_edit = $_REQUEST['txt_nombre_edit'];
        }
        
        $form = new CHtmlForm();
        $form->setTitle(TITULO_EDITAR_CIUDAD);
        $form->setId('frm_editar_ciudad');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $ciudad->getId(), '', '');
        $data = new CPaisData($db);
        //Obtención de los datos de paises por medio de el objeto $data
        $paises = $data->obtenerPais();
        $opciones = null;
        if (isset($paises)) {
            foreach ($paises as $c) {
                $opciones[count($opciones)] = array('value' => $c[0], 'texto' => $c[1]);
            }
        }
        //Agregación de una lista desplegable con los nombre de los paises al formulario
        $form->addEtiqueta(NOMBRE_PAIS);
        
        $form->addSelect('select', 'sel_pais_edit', 'sel_pais_edit', $opciones, NOMBRE_PAIS, $pais, '', 'onChange="ocultarDiv(\'error_pais\');"');
        $form->addError('error_pais', ERROR_SELECCION_PAIS);
        
        //Agregación de campos para la edición del nombre de la ciudad
        $form->addEtiqueta(NOMBRE_CIUDAD);
        $form->addInputText('text', 'txt_nombre_edit', 'txt_nombre_edit', '20', '20', $descripcion_edit, '', 'onkeypress="ocultarDiv(\'error_nombre_ciudad\');"');
        $form->addError('error_nombre_ciudad', ERROR_NOMBRE_CIUDAD);
        
        
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_editar_ciudad();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionCiudad(\'frm_editar_ciudad\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;

    case 'guardaredicion':

        $id_edit = $_REQUEST['txt_id'];
        $nombre_edit = $_REQUEST['txt_nombre_edit'];
        $pais = $_REQUEST['sel_pais_edit'];
        $ciudad = new CCiudad($id_edit,$pais,  $nombre_edit, $docData);
        $ciudad->cargarCiudad();
        $edicion = $ciudad->actualizarCiudad($id_edit, $pais, strtoupper($nombre_edit));
        echo $html->generaAviso($edicion, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;


    default:
        include('templates/html/under.html');

        break;
}