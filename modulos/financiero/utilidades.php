<?php

defined('_VALID_PRY') or die('Restricted access');
$docData = new CUtilidadesData($db);
$task = $_REQUEST['task'];
$operador = $_REQUEST['operador'];
if (empty($task))
    $task = 'list';
switch ($task) {

    /**
     * la variable list, permite cargar la pagina con los objetos 
     * utilidades
     */
    case 'list':

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_UTILIDADES);
        $form->setId('frm_list_utilidades');
        $form->setMethod('post');
        $form->addEtiqueta(FILTRO_UTILIDADES);
        $criterio=$_REQUEST['txt_filtro_utilidades'];
        $form->addInputText('text', 'txt_filtro_utilidades', 'txt_filtro_utilidades', '11', '11', $criterio, '', '');
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_utilidades();');
        $form->addInputButton('button'. '', 'ok', 'ok', BOTON_EXPORTAR, 'button', 'onclick="validar_utilidades_excel();"');
       
        $form->writeForm();
        $dt = new CHtmlDataTable();
        $utilidades = $docData->obtenerUtilidadesFormat($criterio);
        $dt->setTitleTable(TITULO_TABLA_UTILIDADES);
        $titulos = array(ID_UTILIZACION,FECHA_COMUNICADO_UTILIDADES,CAMPO_VIGENCIA,DOCUMENTO_SOPORTE_COMUNICADO,PORCENTAJE_UTILIZACION,UTILIZACION_APROBADA,
            FECHA_COMITE_FIDUCIARIO,NUMERO_COMITE_FIDUCIARIO,DOCUMENTNUMERO_COMITE_FIDUCIARIOO_SOPORTE_ACTA,COMENTARIOS_UTILIDADES);
        $dt->setDataRows($utilidades);
        $dt->setTitleRow($titulos);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=EditarUtilidad");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=BorrarUtilidad");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=AgregarUtilidad");
        $dt->setSumColumns(array(6));
        $dt->setFormatRow(array(null,null,null,null,array(2,',','.'),array(2,',','.')));
        $dt->setType(1);
        $dt->setPag(1);
        $dt->writeDataTable($niv);

        break;
    /**
     * la variable AgregarUtilidad, permite cargar el formulario y los datos 
     * de un objeto utilidad
     */
    case 'AgregarUtilidad':
        
        $form = new CHtmlForm();
        $form->setTitle(TITULO_AGREGAR_UTILIDA);
        $form->setId('frm_agregar_utilidad');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        $form->addEtiqueta(ID_UTILIZACION);
        $form->addInputText('text', 'txt_numero', 'txt_numero', '4', '4', $porcentaje_utilidad, '', 'onkeypress="ocultarDiv(\'error_numero_utilizacion\');"');
        $form->addError('error_numero_utilizacion', ERROR_NUMERO_DESEMBOLSO);
        $form->addEtiqueta(FECHA_COMUNICADO_UTILIDADES);
        $form->addInputDate('date', 'txt_fecha_comunicado', 'txt_fecha_comunicado', $fecha, '%Y-%m-%d', '10', '30', '', 'onChange="ocultarDiv(\'error_fecha_comunicado\');"');
        $form->addError('error_fecha_comunicado', ERROR_FECHA_COMUNICADO_UTILIDADES);
        $form->addEtiqueta(CAMPO_VIGENCIA);
        $form->addInputDate('date', 'txt_vigencia', 'txt_vigencia', $vigencia, '%Y', '10', '30', '', 'onChange="ocultarDiv(\'error_fecha_comunicado\');"');
        $form->addError('error_vigencia', ERROR_VIGENCIA_UTILIDADES);
        $form->addEtiqueta(DOCUMENTO_SOPORTE_COMUNICADO);
        $form->addInputFile('file', 'file_utilidades_comunicado', 'file_utilidades_comunicado', '25', 'file', 'onChange="ocultarDiv(\'error_archivo_comunicado\');"');
        $form->addError('error_archivo_comunicado', ERROR_DOCUMENTO_SOPORTE_COMUNICADO);
        $form->addEtiqueta(PORCENTAJE_UTILIZACION);
        $form->addInputText('text', 'txt_porcentaje', 'txt_porcentaje', '6', '6', $porcentaje_utilidad, '', 'onkeypress="ocultarDiv(\'error_porcentaje_utilidad\');"');
        $form->addError('error_porcentaje_utilidad', ERROR_PORCENTAJE_UTILIZACION);
        $form->addEtiqueta(UTILIZACION_APROBADA);
        $form->addInputText('text', 'txt_utilidad_aprobada', 'txt_utilidad_aprobada', '20', '20', $utilidad_aprobada, '', 'onkeypress="ocultarDiv(\'error_utilidad_aprobada\');"');
        $form->addError('error_utilidad_aprobada', ERROR_UTILIZACION_APROBADA);
        $form->addEtiqueta(FECHA_COMITE_FIDUCIARIO);
        $form->addInputDate('date', 'txt_fecha_comite_fiduciario', 'txt_fecha_comite_fiduciario', $fechacomite, '%Y-%m-%d', '10', '30', '', 'onChange="ocultarDiv(\'error_fecha_comite_fiduciario\');"');
        $form->addError('error_fecha_comite_fiduciario', ERROR_FECHA_COMITE_FIDUCIARIO);
        $form->addEtiqueta(NUMERO_COMITE_FIDUCIARIO);
        $form->addInputText('text', 'txt_numero_comite', 'txt_numero_comite', '10', '10', $numerocomite, '', 'onkeypress="ocultarDiv(\'error_numero_comite\');"');
        $form->addError('error_numero_comite', ERROR_NUMERO_COMITE_FIDUCIARIO);
        $form->addEtiqueta(DOCUMENTNUMERO_COMITE_FIDUCIARIOO_SOPORTE_ACTA);
        $form->addInputFile('file', 'file_utilidades_acta', 'file_utilidades_acta', '25', 'file', 'onChange="ocultarDiv(\'error_archivo_acta\');"');
        $form->addError('error_archivo_acta', ERROR_DOCUMENTO_SOPORTE_ACTA);
        $form->addEtiqueta(COMENTARIOS_UTILIDADES);
        $form->addTextArea('textarea', 'txt_comentarios', 'txt_comentarios', '60', '5', $comentarios, '', '');
        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_agregar_utilidad(\'frm_agregar_utilidad\',\'?mod=' . $modulo . '&task=GuardarUtilidad&niv=' . $niv . '\');"');
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionUtilidad(\'frm_agregar_utilidad\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;
    /**
     * la variable GuardarUtilidad, permite cargar la datos de la variable AgregarUtilidad 
     * y agregar a la base de datos el objeto utilidad 
     */
    case 'GuardarUtilidad':
        $id = $_REQUEST['txt_numero'];
        $fecha_comunicado=$_REQUEST['txt_fecha_comunicado'];
        $vigencia = $_REQUEST['txt_vigencia'];
        $archivo_documento=$_FILES['file_utilidades_comunicado'];
        $porcentaje_utilidad=$_REQUEST['txt_porcentaje'];
        $utilidad_aprobada=$_REQUEST['txt_utilidad_aprobada'];
        $fecha_comite=$_REQUEST['txt_fecha_comite_fiduciario'];
        $numerocomite=$_REQUEST['txt_numero_comite'];
        $archivo_acta=$_FILES['file_utilidades_acta'];
        $comentarios=$_REQUEST['txt_comentarios'];
        

                      
        $utilidad = new CUtilidad($id, $fecha_comunicado, $vigencia, $archivo_documento, $porcentaje_utilidad, $utilidad_aprobada, $fecha_comite, $numerocomite, $archivo_acta, $comentarios, $docData);
        $nuevautilidad= $utilidad->guardarutilidad($db);
        echo $html->generaAviso($nuevautilidad, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;
    /**
     * la variable BorrarUtilidad,  cargar los datos del objeto utilidad que se 
     * va a eliminar y los envia a la variable ConfirmarBorrar 
     */
    case 'BorrarUtilidad':

        $id_delete = $_REQUEST['id_element'];
        $form = new CHtmlForm();
        $form->setId('frm_borrar_utilidad');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_descripcion', 'txt_descripcion', '15', '15', $descripcion, '', '');
        $form->writeForm();
        echo $html->generaAdvertencia(MENSAJE_BORRAR_UTILIDAD, '?mod=' . $modulo . '&niv=' . $niv .
                '&task=confirmaborrar&id_element=' . $id_delete, "cancelarAccionFamilia('frm_borrar_utilidad','?mod=" . $modulo . "&niv=" . $niv . "');");
        break;
    /**
     * la variable confirmarborar, permite eliminar el objeto de la base de datos
     */
    case 'confirmaborrar':

        $id_delete = $_REQUEST['id_element'];
        $utilidad=new CUtilidad($id_delete, '', '', '', '', '', '', '', '', $docData);
        $utilidad->CargarUtilidad();
        $id = $utilidad->getId_utilidad();
        $eliminar = $utilidad->eliminarUtilidad($id);
        echo $html->generaAviso($eliminar, "?mod=" . $modulo . "&niv=" . $niv . "&task=list", "cancelarAccionFamilia('frm_borrar_familia','?mod=" . $modulo . "&niv=" . $niv . "');");


        break;
    /**
     * la variable EditarUtilidad, genera un formulario y carga los datos del 
     * objeto utilidad que se va a editar
     */
    case 'EditarUtilidad':

        $id_edit = $_REQUEST['id_element'];
        $utilidad=new CUtilidad($id_edit, '','', '', '', '', '', '', '', '', $docData);
        $utilidad->CargarUtilidad();
        if (!isset($_REQUEST['txt_fecha_comunicado_edit']) || $_REQUEST['txt_fecha_comunicado_edit'] != '')
            $fecha_comunicado_edit = $utilidad->getFecha_comunicado ();
        else
            $fecha_comunicado_edit = $_REQUEST['txt_fecha_comunicado_edit'];
        
        
        if (!isset($_REQUEST['txt_porcentaje_edit']) || $_REQUEST['txt_porcentaje_edit'] != '')
            $porcentaje_utilidad_edit = $utilidad->getPorcentaje_utilizacion ();
        else
            $porcentaje_utilidad_edit = $_REQUEST['txt_porcentaje_edit'];
        
        if (!isset($_REQUEST['txt_vigencia_edit']) || $_REQUEST['txt_vigencia_edit'] != '')
            $vigencia_edit = $utilidad->getVigencia ();
        else
            $vigencia_edit = $_REQUEST['txt_vigencia_edit'];
        
        if (!isset($_REQUEST['txt_utilidad_aprobada_edit']) || $_REQUEST['txt_utilidad_aprobada_edit'] != '')
            $utilidad_aprobada_edit = $utilidad->getUtilizacion_aprobada ();
        else
            $utilidad_aprobada_edit = $_REQUEST['txt_utilidad_aprobada_edit'];
        
        
        if (!isset($_REQUEST['txt_fecha_comite_fiduciario_edit']) || $_REQUEST['txt_fecha_comite_fiduciario_edit'] != '')
            $fecha_comite_edit = $utilidad->getFecha_comite ();
        else
            $fecha_comite_edit = $_REQUEST['txt_fecha_comite_fiduciario_edit'];
        
        
        if (!isset($_REQUEST['txt_numero_comite_edit']) || $_REQUEST['txt_numero_comite_edit'] != '')
            $numerocomite_edit = $utilidad->getNumero_comite ();
        else
            $numerocomite_edit = $_REQUEST['txt_numero_comite_edit'];
        
        
        if (!isset($_REQUEST['txt_comentarios_edit']) || $_REQUEST['txt_comentarios_edit'] != '')
            $comentarios_edit = $utilidad->getComentario();
        else
            $comentarios_edit = $_REQUEST['txt_comentarios_edit'];
        
      
        $form = new CHtmlForm();
        $form->setTitle(TITULO_EDITAR_UTILIDAD);
        $form->setId('frm_editar_utilidad');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $utilidad->getId_utilidad(), '', '');
        $form->addInputText('hidden', 'txt_archivo_acta_anterior', 'txt_archivo_acta_anterior', '15', '15', $utilidad->getArchivo_acta(), '', '');
        $form->addInputText('hidden', 'txt_archivo_documento_anterior', 'txt_archivo_documento_anterior', '15', '15', $utilidad->getArchivo_comunicado(), '', '');
          
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $utilidad->getId_utilidad(), '', '');
        $form->addInputText('hidden', 'txt_fecha_documentos_anterior', 'txt_fecha_documentos_anterior', '15', '15', $utilidad->getFecha_comite(), '', '');
          
        $form->addEtiqueta(ID_UTILIZACION);
        $form->addInputText('text', 'txt_numero_edit', 'txt_numero_edit', '6', '6', $id_edit, '', 'onkeypress="ocultarDiv(\'error_numero_utilizacion\');"');
        $form->addError('error_numero_utilizacion', ERROR_NUMERO_DESEMBOLSO);
        $form->addEtiqueta(FECHA_COMUNICADO_UTILIDADES);
        $form->addInputDate('date', 'txt_fecha_comunicado_edit', 'txt_fecha_comunicado_edit', $fecha_comunicado_edit, '%Y-%m-%d', '10', '30', '', 'onChange="ocultarDiv(\'error_fecha_comunicado\');"');
        $form->addError('error_fecha_comunicado', ERROR_FECHA_COMUNICADO_UTILIDADES);
        $form->addEtiqueta(CAMPO_VIGENCIA);
        $form->addInputDate('date', 'txt_vigencia_edit', 'txt_vigencia_edit', $vigencia_edit, '%Y', '10', '30', '', 'onChange="ocultarDiv(\'error_fecha_comunicado\');"');
        $form->addError('error_vigencia', ERROR_VIGENCIA_UTILIDADES);
        $form->addEtiqueta(DOCUMENTO_SOPORTE_COMUNICADO);
        $form->addInputFile('file', 'file_utilidades_comunicado_edit', 'file_utilidades_comunicado_edit', '25', 'file', 'onChange="ocultarDiv(\'error_archivo_comunicado\');"');
        $form->addError('error_archivo_comunicado', ERROR_DOCUMENTO_SOPORTE_COMUNICADO);
        $form->addEtiqueta(PORCENTAJE_UTILIZACION);
        $form->addInputText('text', 'txt_porcentaje_edit', 'txt_porcentaje_edit', '6', '6', $porcentaje_utilidad_edit, '', 'onkeypress="ocultarDiv(\'error_porcentaje_utilidad\');"');
        $form->addError('error_porcentaje_utilidad', ERROR_PORCENTAJE_UTILIZACION);
        $form->addEtiqueta(UTILIZACION_APROBADA);
        $form->addInputText('text', 'txt_utilidad_aprobada_edit', 'txt_utilidad_aprobada_edit', '20', '20', $utilidad_aprobada_edit, '', 'onkeypress="ocultarDiv(\'error_utilidad_aprobada\');"');
        $form->addError('error_utilidad_aprobada', ERROR_UTILIZACION_APROBADA);
        $form->addEtiqueta(FECHA_COMITE_FIDUCIARIO);
        $form->addInputDate('date', 'txt_fecha_comite_fiduciario_edit', 'txt_fecha_comite_fiduciario_edit', $fecha_comite_edit, '%Y-%m-%d', '10', '30', '', 'onChange="ocultarDiv(\'error_fecha_comite_fiduciario\');"');
        $form->addError('error_fecha_comite_fiduciario', ERROR_FECHA_COMITE_FIDUCIARIO);
        $form->addEtiqueta(NUMERO_COMITE_FIDUCIARIO);
        $form->addInputText('text', 'txt_numero_comite_edit', 'txt_numero_comite_edit', '10', '10', $numerocomite_edit, '', 'onkeypress="ocultarDiv(\'error_numero_comite\');"');
        $form->addError('error_numero_comite', ERROR_NUMERO_COMITE_FIDUCIARIO);
        $form->addEtiqueta(DOCUMENTNUMERO_COMITE_FIDUCIARIOO_SOPORTE_ACTA);
        $form->addInputFile('file', 'file_utilidades_acta_edit', 'file_utilidades_acta_edit', '25', 'file', 'onChange="ocultarDiv(\'error_archivo_acta\');"');
        $form->addError('error_archivo_acta', ERROR_DOCUMENTO_SOPORTE_ACTA);
        $form->addEtiqueta(COMENTARIOS_UTILIDADES);
        $form->addTextArea('textarea', 'txt_comentarios_edit', 'txt_comentarios_edit', '60', '5', $comentarios_edit, '', '');
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_editar_utilidad();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccionFamilia(\'frm_editar_utilidad\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;

    /**
     * la variable guardaredicion, permite guardar los atributos del objeto familia
     * modificados en la base de datos 
     */
    case 'guardaredicion':

        $id_edit = $_REQUEST['txt_id'];
        $id_nuevo = $_REQUEST['txt_numero_edit'];
        $fecha_comunicado_edit=$_REQUEST['txt_fecha_comunicado_edit'];
        $vigencia=$_REQUEST['txt_vigencia_edit'];
        $archivo_documento_edit=$_FILES['file_utilidades_comunicado_edit'];
        $porcentaje_utilidad_edit=$_REQUEST['txt_porcentaje_edit'];
        $utilidad_aprobada_edit=$_REQUEST['txt_utilidad_aprobada_edit'];
        $fecha_comite_edit=$_REQUEST['txt_fecha_comite_fiduciario_edit'];
        $numerocomite_edit=$_REQUEST['txt_numero_comite_edit'];
        $archivo_acta_edit=$_FILES['file_utilidades_acta_edit'];
        $comentarios_edit=$_REQUEST['txt_comentarios_edit'];
        $archivo_anterior_acta=$_REQUEST['txt_archivo_acta_anterior'];
        $archivo_anterior_documento=$_REQUEST['txt_archivo_documento_anterior'];
        $fecha_anterior=$_REQUEST['txt_fecha_documentos_anterior'];
        $num_comite_anterior=$_REQUEST['txt_numero_documentos_anterior'];
       
        
        
        $utilidad=new CUtilidad($id_edit, $fecha_comunicado_edit,$vigencia,$archivo_documento_edit,
                $porcentaje_utilidad_edit, $utilidad_aprobada_edit, $fecha_comite_edit, $numerocomite_edit, 
                $archivo_acta_edit,$comentarios_edit, $docData);
        
        
        $edicion = $utilidad->editarutilidad($archivo_anterior_acta, $archivo_anterior_documento, $fecha_anterior,$id_nuevo, $db);
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
