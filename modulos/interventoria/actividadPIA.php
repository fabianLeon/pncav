<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
defined('_VALID_PRY') or die('Restricted access');

$operador = OPERADOR_DEFECTO;
$actData = new CActividadPIAData($db);

$task = $_REQUEST['task'];

if (empty($task)) {
    $task = 'list';
}
switch ($task) {
    /**
     * La variable list, permite hacer la carga la página con la lista de 
     * objetos PLANEACION según los parámetros de entrada.
     */
    case 'list':
        //Variables

        $descripcion = $_REQUEST['txt_descripcion'];
        $monto = $_REQUEST['txt_monto'];
        //-------------------------------criterios---------------------------
        $criterio = "";
        if (isset($descripcion) && $descripcion != "") {
            if ($criterio == "") {
                $criterio = " (act.act_descripcion LIKE '%" . $descripcion . "%')";
            } else {
                $criterio .= " and (act.act_descripcion LIKE '%" . $descripcion . "%')";
            }
        }/*
          if (isset($monto)  && $monto != '') {
          if ($criterio == "") {
          $criterio = " act.act_monto = " . $monto;
          } else {
          $criterio .= " and act.act_monto = " . $monto;
          }
          } */
        if ($criterio == "") {
            $criterio = " 1";
        }
        //-----------------------end criterios-------------

        /*
         * Inicio formulario
         */
        $form = new CHtmlForm();
        $form->setTitle(TABLA_ACTIVIDADES);
        $form->setId('frm_list_actividades');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(ACTIVIDADES_DESCRIPCION);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', 30, 30, $descripcion, '', '');
        /*
          $form->addEtiqueta(ACTIVIDADES_MONTO);
          $form->addInputText('text', 'txt_monto', 'txt_monto', 20, 20, $monto, '', '');
         */
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_actividades();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', ACTIVIDADES_EXPORTAR, 'button', 'onClick=exportar_excel_actividadPIA();');
        

        $form->writeForm();
        //Carga filtro de planeaciones
        $actividades = $actData->getActividadPIA($criterio);
        //Inicio Tabla
        $dt = new CHtmlDataTable();
        $titulos = array(ACTIVIDADES_DESCRIPCION, ACTIVIDADES_MONTO);
        $dt->setDataRows($actividades);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_ACTIVIDADES);

        //OPCIONES DE GESTIÓN
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=delete");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=add");

        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);
        break;
    /*
     * Variable add, agregar una ActividadPIA
     */
    case 'add':
        //Variables

        $descripcion = $_REQUEST['txt_descripcion'];
        $monto = $_REQUEST['txt_monto'];
        /*
         * Inicio formulario
         */
        $form = new CHtmlForm();
        $form->setTitle(TABLA_ACTIVIDADES);
        $form->setId('frm_add_actividades');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(ACTIVIDADES_DESCRIPCION);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', 30, 30, $descripcion, '', 'onChange="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_ACTIVIDADES_DESCRIPCION);

        $form->addEtiqueta(ACTIVIDADES_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', 20, 20, $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_ACTIVIDADES_MONTO);

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=validar_add_actividades();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', BTN_CANCELAR, 'button', 'onClick=cancelarAccion_actividadPIA(\'frm_add_actividades\');');

        $form->writeForm();
        break;
    /*
     * Variable saveAdd, almacena una ActividadPIA
     */
    case 'saveAdd':
        $descripcion = $_REQUEST['txt_descripcion'];
        $monto = $_REQUEST['txt_monto'];

        $actividades = new CActividadPIA('', $actData);
        $actividades->setDescripcion($descripcion);
        $actividades->setMonto($monto);

        $mens = $actividades->saveActividadPIA();
        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");


        break;
/*
     * Variable delete, solicita confirmacion para eliminar una ActividadPIA
     */
    case 'delete':
        $id_act = $_REQUEST['id_element'];
        $form = new CHtmlForm();
        $form->setId('frm_delete_actividades');
        $form->setMethod('post');

        $form->writeForm();
        echo $html->generaAdvertencia(ACTIVIDADES_MSG_BORRADO, '?mod=' . $modulo . '&niv='
                . $niv . '&task=confirmDelete&id_element=' . $id_act, 'onClick=cancelarAccion_actividadPIA_delete(\'frm_delete_actividades\');');


        break;
    /*
     * Variable confirmDelete, elimina una ActividadPIA
     */
    case 'confirmDelete':
        $id_act = $_REQUEST['id_element'];
        $actividades = new CActividadPIA($id_act, $actData);
        $actividades->loadActividadPIA();


        $mens = $actividades->deletActividadPIA();
        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;
    /*
     * Variable edit, presenta el formulario para editar una ActividadPIA
     */
    case 'edit':
        $id_act = $_REQUEST['id_element'];
        
        $actividades = new CActividadPIA($id_act, $actData);
        $actividades->loadActividadPIA();

        $descripcion = $actividades->getDescripcion();
        $monto = $actividades->getMonto();
        /*
         * Inicio formulario
         */
        $form = new CHtmlForm();
        $form->setTitle(TABLA_ACTIVIDADES);
        $form->setId('frm_edit_actividades');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(ACTIVIDADES_DESCRIPCION);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', 30, 30, $descripcion, '', 'onChange="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_ACTIVIDADES_DESCRIPCION);

        $form->addEtiqueta(ACTIVIDADES_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', 20, 20, $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_ACTIVIDADES_MONTO);

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=validar_edit_actividades();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', BTN_CANCELAR, 'button', 'onClick=cancelarAccion_actividadPIA(\'frm_edit_actividades\');');

        $form->addInputText('hidden', 'id_element', 'id_element', '15', '15', $id_act, '', '');

        $form->writeForm();
        break;
    /*
     * Variable saveEdit, actualiza un aactividadPIA
     */
    case 'saveEdit':

        $id_act = $_REQUEST['id_element'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $monto = $_REQUEST['txt_monto'];

        $actividades = new CActividadPIA($id_act, $actData);
        $actividades->setDescripcion($descripcion);
        $actividades->setMonto($monto);

        $mens = $actividades->saveEditActividadPIA();

        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;
    /**
     * Cuando la variable task no esta
     * definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');

        break;
}
?>

