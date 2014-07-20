<?php

defined('_VALID_PRY') or die('Restricted access');
//creamos las instancias de las objetos que maneja la gestion de dato
$docData = new CActividadData($db);
$task = $_REQUEST['task'];
$operador = $_REQUEST['operador'];
if (empty($task))
    $task = 'list';
switch ($task) {

    /**
     * la variable list, permite cargar la pagina con los objetos 
     * actividades
     */
    case 'list':

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_ACTIVIDADES);
        $form->setId('frm_list_actividades');
        $form->setMethod('post');
        $form->options['autoClean']=false;
        
        $tipos = $docData->ObtenerTipos('Id_Tipo');
        $opciones = null;
        if (isset($tipos)) {
            foreach ($tipos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $tipo = $_REQUEST['Tipo_actividad'];

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_actividades_portipo();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', COMPROMISOS_EXPORTAR, 'button', 'onClick=exportar_excel_actividades();');
        $form->addInputText('hidden', 'txt_criterio', 'txt_criterio', '5', '5', '', '', '');



        $form->addEtiqueta(SELECCINE_ACTIVIDAD_FILTRO);
        $form->addSelect('select', 'Tipo_actividad', 'Tipo_actividad', $opciones, SELECCINE_ACTIVIDAD, $tipo, '', '');
        $form->writeForm();

        $dt = new CHtmlDataTable();
        $actividades = $docData->ObtenerActividades($tipo);

        $dt->setTitleTable(TITULO_TABLA_ACTIVIDADES);
        $titulos = array(TITULO_DESCRIPCION_ACTIVIDADES, TITULO_MONTO_ACTIVIDADES, TITULO_TIPO_ACTIVIDADES);
        $dt->setDataRows($actividades);
        $dt->setTitleRow($titulos);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=EditarActividad");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=BorrarActividad");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=AgregarActividad");
        $dt->setFormatRow(array(null,array(2,",","."),null));
        $dt->setSumColumns(array(2));
        $dt->setType(1);
        $dt->setPag(1);
        $dt->writeDataTable($niv);


        break;
    /**
     * la variable AgregarActividad, permite cargar el formulario y los datos 
     * de un objeto actividad
     */
    case 'AgregarActividad':

        $tipo = $_REQUEST['Tipo_actividad'];
        $descripcion = $_REQUEST['Descrip_actividad'];
        $monto = $_REQUEST['Monto_actividad'];
        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_AGREGAR_ACTIVIDAD);
        $form->setId('frm_agregar_actividad');
        $form->setMethod('post');

        $tipos = $docData->ObtenerTipos('Id_Tipo');
        $opciones = null;
        if (isset($tipos)) {
            foreach ($tipos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(SELECCINE_ACTIVIDAD);
        $form->addSelect('select', 'Tipo_actividad', 'Tipo_actividad', $opciones, SELECCINE_ACTIVIDAD, $tipo, '', '');
        $form->addError('error_tipo', ERROR_TIPO);
        $form->addEtiqueta(DESCRIPCION_ACTIVIDAD);
        $form->addInputText('text', 'Descrip_actividad', 'Descrip_actividad', '100', '100', $descripcion, '', 'onkeypress="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_DESCRIPCION);
        $form->addEtiqueta(MONTO_ACTIVIDAD);
        $form->addInputText('text', 'Monto_actividad', 'Monto_actividad', '35', '35', $monto, '', 'onkeypress="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_MONTO);


        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_agregar_actividad();"');
        $form->addInputButton('button', 'cancelar', 'cancelar', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionActividad(\'frm_agregar_actividad\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;
    /**
     * la variable GuardarActividad, permite cargar la datos de la variable AgregarOrden 
     * y agregar a la base de datos el objeto actividad 
     */
    case 'GuardarActividad':
        $tipo = $_REQUEST['Tipo_actividad'];
        $descripcion = $_REQUEST['Descrip_actividad'];
        $monto = $_REQUEST['Monto_actividad'];
        $nuevaactividad = $docData->insertaractividad('', $descripcion, $monto, $tipo);
        echo $html->generaAviso($nuevaactividad, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;
    /**
     * la variable BorrarActividad,  cargar los datos del objeto actividad que se 
     * va a eliminar y los envia a la variable ConfirmarBorrar 
     */
    case 'BorrarActividad':

        $id_delete = $_REQUEST['id_element'];
        $tipo = $_REQUEST['Tipo_actividad'];
        $descripcion = $_REQUEST['Descrip_actividad'];
        $monto = $_REQUEST['Monto_actividad'];
        $form = new CHtmlForm();
        $form->setId('frm_borrar_actividad');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_tipo', 'txt_tipo', '15', '15', $tipo, '', '');
        $form->writeForm();
        echo $html->generaAdvertencia(MENSAJE_BORRAR_ACTIVIDAD, '?mod=' . $modulo . '&niv=' . $niv .
                '&task=ConfirmaBorrar&id_element=' . $id_delete, "cancelarAccionActividad('frm_borrar_actividad','?mod=" . $modulo . "&niv=" . $niv . "');");

        break;
    
    /**
     * la variable Confirmarborar, permite eliminar el objeto de la base de datos
     */
    case 'ConfirmaBorrar':
        $id_delete = $_REQUEST['id_element'];
        $tipo = $_REQUEST['Tipo_actividad'];
        $descripcion = $_REQUEST['Descrip_actividad'];
        $monto = $_REQUEST['Monto_actividad'];
        $actividad = new CActividad($id_delete, '', '', '', $docData);
        $actividad->CargarActividad();
        $id = $actividad->getId_actividad();
        $eliminar = $actividad->EliminarActividad($id);
        echo $html->generaAviso($eliminar, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");


        break;
    /**
     * la variable EditarActividad, genera un formulario y carga los datos del 
     * objeto actividad que se va a editar
     */
    case 'EditarActividad':
        $id_edit = $_REQUEST['id_element'];
        $tipo = $_REQUEST['Tipo_actividad'];
        $descripcion = $_REQUEST['Descrip_actividad'];
        $monto = $_REQUEST['Monto_actividad'];

        $actividad = new CActividad($id_edit, '', '', '', $docData);
        $actividad->CargarActividad();

        if (!isset($_REQUEST['Tipo_actividad_edit']) || $_REQUEST['Tipo_actividad_edit'] <= 0)
            $tipo_edit = $actividad->getId_tipo();
        else
            $tipo_edit = $_REQUEST['Tipo_actividad_edit'];


        if (!isset($_REQUEST['Descrip_actividad_edit']) || $_REQUEST['Descrip_actividad_edit'] != '')
            $descripcion_edit = $actividad->getDesp_actividad();
        else
            $descripcion_edit = $_REQUEST['Descrip_actividad_edit'];


        if (!isset($_REQUEST['Monto_actividad_edit']) || $_REQUEST['Monto_actividad_edit'] != '')
            $monto_edit = $actividad->getMonto_actividad();
        else
            $monto_edit = $_REQUEST['Monto_actividad_edit'];


        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_EDITAR_ACTIVIDAD);
        $form->setId('frm_editar_actividad');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $actividad->getId_actividad(), '', '');

        $tipos = $docData->ObtenerTipos('Id_Tipo');
        $opciones = null;
        if (isset($tipos)) {
            foreach ($tipos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(SELECCINE_ACTIVIDAD);
        $form->addSelect('select', 'Tipo_actividad_edit', 'Tipo_actividad_edit', $opciones, SELECCINE_ACTIVIDAD, $tipo_edit, '', '');
        $form->addError('error_tipo', ERROR_TIPO);
        $form->addEtiqueta(DESCRIPCION_ACTIVIDAD);
        $form->addInputText('text', 'Descrip_actividad_edit', 'Descrip_actividad_edit', '100', '100', $descripcion_edit, '', 'onkeypress="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_DESCRIPCION);
        $form->addEtiqueta(MONTO_ACTIVIDAD);
        $form->addInputText('text', 'Monto_actividad_edit', 'Monto_actividad_edit', '35', '35', $monto_edit, '', 'onkeypress="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_MONTO);


        $form->addInputButton('button', 'ok', 'ok', BOTON_EDITAR, 'button', 'onclick="validar_editar_actividad();"');
        $form->addInputButton('button', 'cancelar', 'cancelar', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionActividad(\'frm_editar_actividad\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();



        break;
        
    /**
     * la variable GuardarEdicionActividad, permite guardar los atributos del objeto actividad
     * modificados en la base de datos 
     */
    case 'GuardarEdicionActividad':

        $id_edit = $_REQUEST['txt_id'];
        $tipo_edit = $_REQUEST['Tipo_actividad_edit'];
        $descripcion_edit = $_REQUEST['Descrip_actividad_edit'];
        $monto_edit = $_REQUEST['Monto_actividad_edit'];
        $actividad = new CActividad($id_edit, $descripcion_edit, $monto_edit, $tipo_edit, $docData);
        $actividad->CargarActividad();
        $actualiza = $actividad->actualizarActividad($id_edit, $descripcion_edit, $monto_edit, $tipo_edit);
        echo $html->generaAviso($actualiza, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;
    
   /**
     * la variable default genera un mesaje que indica que el modulo esta en construccion
     */
    default:
        include('templates/html/under.html');
        break;
}
?>