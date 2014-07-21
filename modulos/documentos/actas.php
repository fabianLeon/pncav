<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte_actas.xls");
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');

$du = new CDocumentoData($db);
$actaData = new CActaData($db);

$operador = OPERADOR_DEFECTO;

$task = $_REQUEST['task'];

if (empty($task))
    $task = 'list';

switch ($task) {
    /**
     * la variable list, permite hacer la carga la página con la lista de 
     * objetos DOCUMENTO ACTA según los parámetros de entrada
     */
    case 'list':
        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        $fecha_fin = $_REQUEST['txt_fecha_fin'];
        $subtema = $_REQUEST['sel_subtema'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $criterio_busqueda = $_REQUEST['txt_criterio'];
        //-------------------------------criterios---------------------------
        $criterio = "";
        if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
            if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (d.doc_fecha >= '" . $fecha_inicio . "')";
                } else {
                    $criterio .= " and d.doc_fecha >= '" . $fecha_inicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = "( d.doc_fecha between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                } else {
                    $criterio .= " and d.doc_fecha between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                }
            }
        }
        if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
            if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( d.doc_fecha <= '" . $fecha_fin . "')";
                } else {
                    $criterio .= " and d.doc_fecha <= '" . $fecha_fin . "')";
                }
            }
        }

        if (isset($subtema) && $subtema != -1 && $subtema != '') {
            if ($criterio == "") {
                $criterio = " d.dos_id = " . $subtema;
            } else {
                $criterio .= " and d.dos_id = " . $subtema;
            }
        }

        if (isset($descripcion) && $descripcion != "") {
            if ($criterio == "") {
                $criterio = " (d.doc_descripcion LIKE '%" . $descripcion .
                        "%' or d.doc_archivo LIKE '%" . $descripcion . "%')";
            } else {
                $criterio .= " and (d.doc_descripcion LIKE '%" . $descripcion .
                        "%' or d.doc_archivo LIKE '%" . $descripcion . "%')";
            }
        }
        if ($criterio == ""){
            $criterio=" d.dot_id = ". ID_ACTAS;
        }
       
        //-----------------------end criterios-------------

        /*
         * Inicio formulario
         */
        $form = new CHtmlForm();
        $form->setTitle(TABLA_ACTAS);
        $form->setId('frm_list_actas');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addEtiqueta(ACTA_FECHA_INICIO_BUSCAR);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', 'onChange="submit();"');

        $form->addEtiqueta(ACTA_FECHA_FIN_BUSCAR);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', 'onChange="submit();"');

        $form->addEtiqueta(ACTA_SUBTEMA);
        /*
         * Consultar los subtemas almacenados
         */
        $cont=0;
        $opciones = null;
        

        $subtemas = $du->getSubtemas('dot_id = ' . ID_ACTAS, 'dos_nombre');
        $cont++;
        if (isset($subtemas)) {
            foreach ($subtemas as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form->addSelect('select', 'sel_subtema', 'sel_subtema', $opciones, 
                ACTA_SUBTEMA, $subtema, '', 'onChange="submit();"');

        $form->addEtiqueta(ACTA_DESCRIPCION);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', 50, 100, $descripcion, '', 'onChange="submit();"');
        
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_actas();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', COMPROMISOS_EXPORTAR, 'button', 'onClick=exportar_excel_actas();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', BTN_CANCELAR, 'button', 'onClick=cancelar_busqueda_actas();');
        
        $form->addInputText('hidden', 'txt_criterio', 'txt_criterio', '5', '5', '', '', '');
        
        $form->writeForm();

        if ($criterio != "")
            $criterio .= ' and d.ope_id = ' . $operador;
        if ($criterio == "" && $criterio_busqueda == "1")
            $criterio = "1";
        //Inicio tabla
	
        //$a=$acta->getActas($criterio, "asc", "1");
        $dirOperador = $du->getDirectorioOperador($operador);
        $actas = $actaData->getActas($criterio,'asc', $dirOperador);
        $dt = new CHtmlDataTableAlignable();
        $titulos = array(ACTA_SUBTEMA, ACTA_DESCRIPCION, ACTA_DOCUMENTO, ACTA_FECHA);
        $dt->setDataRows($actas);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_ACTAS);

        //$dt->setSeeLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=see");
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=delete");

        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=add");

        $dt->setType(1);
       
        $pag_crit = "task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin.
                    "&sel_subtema=".$subtema."&txt_descripcion=".$descripcion;
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);


        break;
        /*
         * la variable add, permite Agregar un acta.
         */
    case 'add':
        $subtema_add = $_REQUEST['sel_subtema_add'];
        $fecha_add = $_REQUEST['txt_fecha_add'];
        $descripcion_add = $_REQUEST['txt_descripcion_add'];
        $consecutivo_add = $_REQUEST['txt_consecutivo_add'];
        $archivo = $_FILES['file_acta_add'];

        $form = new CHtmlForm();

        $form->setTitle(ACTA_ADD);
        $form->setId('frm_add_acta');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $cont=0;
        $opciones = null;

        $subtemas = $du->getSubtemas('dot_id = ' . ID_ACTAS, 'dos_nombre');
        $cont++;
        if (isset($subtemas)) {
            foreach ($subtemas as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form->addEtiqueta(ACTA_SUBTEMA);
        $form->addSelect('select', 'sel_subtema_add', 'sel_subtema_add', $opciones, ACTA_SUBTEMA, $subtema_add, '', 'onChange="ocultarDiv(\'error_subtema\');"');
        $form->addError('error_subtema', ERROR_DOCUMENTO_SUBTEMA);


        $form->addEtiqueta(ACTA_DESCRIPCION);
        $form->addInputText('text', 'txt_descripcion_add', 'txt_descripcion_add', 50, 100,$descripcion_add, '', 'onChange="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_DOCUMENTO_DESCRIPCION);

        $form->addEtiqueta(ACTA_CONSECUTIVO);
        $form->addInputText('text', 'txt_consecutivo_add', 'txt_consecutivo_add', 15, 15,$consecutivo_add, '', 'onChange="ocultarDiv(\'error_consecutivo\');"');
        $form->addError('error_consecutivo', ERROR_DOCUMENTO_CONSECUTIVO);

        $form->addEtiqueta(ACTA_DOCUMENTO);
        $form->addInputFile('file', 'file_acta_add', 'file_acta_add', '25', 'file', 'onChange="ocultarDiv(\'error_acta\');"');
        $form->addError('error_acta', ERROR_DOCUMENTO_ARCHIVO);

        $form->addEtiqueta(ACTA_FECHA);
        $form->addInputDate('date', 'txt_fecha_add', 'txt_fecha_add', $fecha_add, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_DOCUMENTO_FECHA);
        
        
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_documento_acta();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_acta\',\'?mod='
                . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        break;
    /**
     * la variable saveAdd, permite almacenar el objeto 
     * DOCUMENTO en la base de datos, ver la clase CDocumentoData
     */
    case 'saveAdd':
        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];

        $fecha_fin = $_REQUEST['txt_fecha_fin'];

        $subtema = $_REQUEST['sel_subtema'];
        $tabla = "documento_tema as t, documento_subtema as s";
        $campo = "dot_nombre";
        $predicado = " s.dos_id =".$subtema." and s.dot_id= t.dot_id";
        $tema= $db->recuperarCampo($tabla, $campo, $predicado);
        
       
        $descripcion = $_REQUEST['txt_descripcion'];
        

        $subtema_add = $_REQUEST['sel_subtema_add'];
        $fecha_add = $_REQUEST['txt_fecha_add'];
        $descripcion_add = $_REQUEST['txt_descripcion_add'];
        $consecutivo_add = $_REQUEST['txt_consecutivo_add'];
        $archivo = $_FILES['file_acta_add'];
        
        $documento = new CDocumento('',$du);
       
        $documento->setTipo(TIPO_ACTA);
        $documento->setTema(ID_ACTAS);
        $documento->setSubtema($subtema_add);
        $documento->setFecha($fecha_add);
        $documento->setDescripcion($descripcion_add);
        $documento->setArchivo($archivo);
        $documento->setVersion($consecutivo_add);
        $documento->setEstado('1');//no requiere
        $documento->setOperador($operador);
        
        $m = $documento->saveNewDocumento($archivo);

        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&txt_fecha_inicio=" . $fecha_inicio . "&txt_fecha_fin=" . $fecha_fin . "&sel_tipo=" . $tipo . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_estado=" . $estado . "&txt_descripcion=" . $descripcion . "&operador=" . $operador);

        break;
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        $fecha_fin = $_REQUEST['txt_fecha_fin'];
        $tipo = $_REQUEST['sel_tipo'];
        $tema = $_REQUEST['sel_tema'];
        $subtema = $_REQUEST['sel_subtema'];
        $estado = $_REQUEST['sel_estado'];
        $descripcion = $_REQUEST['txt_descripcion'];
        //$operador = $_REQUEST['txt_operador'];

        $form = new CHtmlForm();
        $form->setId('frm_delet_documento');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_fecha_inicio', 'txt_fecha_inicio', '15', '15', $fecha_inicio, '', '');
        $form->addInputText('hidden', 'txt_fecha_fin', 'txt_fecha_fin', '15', '15', $fecha_fin, '', '');
        $form->addInputText('hidden', 'sel_tipo', 'sel_tipo', '15', '15', $tipo, '', '');
        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', $estado, '', '');
        $form->addInputText('hidden', 'txt_descripcion', 'txt_descripcion', '15', '15', $descripcion, '', '');

        $form->writeForm();
        echo $html->generaAdvertencia(DOCUMENTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $niv . '&task=confirmDelete&id_element=' . $id_delete . '&txt_fecha_inicio=' . $fecha_inicio . '&txt_fecha_fin=' . $fecha_fin . '&sel_tipo=' . $tipo . '&sel_tema=' . $tema . '&sel_subtema=' . $subtema . '&sel_estado=' . $estado . '&txt_descripcion=' . $descripcion . '&operador=' . $operador, "cancelarAccion('frm_delet_documento','?mod=" . $modulo . "&niv=" . $niv . "&txt_fecha_inicio=" . $fecha_inicio . "&txt_fecha_fin=" . $fecha_fin . "&sel_tipo=" . $tipo . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_estado=" . $estado . "&txt_descripcion=" . $descripcion . "&operador=" . $operador . "');");

        break;
    /**
     * la variable confirmDelete, permite eliminar el objeto DOCUMENTO de la base de datos, ver la clase CDocumentoData
     */
    case 'confirmDelete':
        
        $id_delete = $_REQUEST['id_element'];
        $documento = new CDocumento($id_delete, $du);

        $documento->loadDocumento();

        $archivo = $documento->getArchivo();

        $m = $documento->deleteDocumento($archivo);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list" );
        break;
    /**
     * Edit permite hacer la carga del objeto DOCUMENTO 
     * y espera confirmacion de edicion, ver la clase CDocumento
     */
    case 'edit':
        $id_edit = $_REQUEST['id_element'];
        $documento = new CDocumento($id_edit, $du);
        $documento->loadDocumento();

        
        if (!isset($_REQUEST['sel_subtema_edit']) || $_REQUEST['sel_subtema_edit'] <= 0)
            $subtema = $documento->getSubtema();
        else
            $subtema = $_REQUEST['sel_subtema_edit'];
        if (!isset($_REQUEST['txt_fecha_edit']) || $_REQUEST['txt_fecha_edit'] != '')
            $fecha = $documento->getFecha();
        
        
        
        $descripcion = $documento->getDescripcion();
        
        $consecutivo = $documento->getVersion();

        $archivo_anterior = $documento->getArchivo();
        
        $form = new CHtmlForm();
        $form->setTitle(EDITAR_ACTA);

        $form->setId('frm_edit_documento_acta');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $subtemas = $du->getSubtemas('dot_id = '. ID_ACTAS, 'dos_nombre');
        $opciones = null;
        if (isset($subtemas)) {
            foreach ($subtemas as $s) {
                $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
            }
        }

        $form->addEtiqueta(ACTA_SUBTEMA);
        $form->addSelect('select', 'sel_subtema', 'sel_subtema', $opciones, DOCUMENTO_SUBTEMA, $subtema, '', 'onChange="ocultarDiv(\'error_subtema\');"');
        $form->addError('error_subtema', ERROR_DOCUMENTO_SUBTEMA);

        $form->addEtiqueta(ACTA_DESCRIPCION);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', 50, 100, $descripcion, '', 'onChange="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_DOCUMENTO_DESCRIPCION);

        $form->addEtiqueta(ACTA_CONSECUTIVO);
        $form->addInputText('text', 'txt_consecutivo', 'txt_consecutivo', 15, 15,$consecutivo, '', 'onChange="ocultarDiv(\'error_consecutivo\');"');
        $form->addError('error_consecutivo', ERROR_DOCUMENTO_CONSECUTIVO);

        $form->addEtiqueta(ACTA_DOCUMENTO);
        $form->addInputFile('file', 'file_acta', 'file_acta', '25', 'file', 'onChange="ocultarDiv(\'error_acta\');"');
        $form->addError('error_acta', ERROR_DOCUMENTO_ARCHIVO);
        
        $form->addEtiqueta(ACTA_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_DOCUMENTO_FECHA);

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $documento->getId(), '', '');
        $form->addInputText('hidden', 'archivo_anterior', 'archivo_anterior', '15', '15', $archivo_anterior, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_documento_acta();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_documento_acta\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '&txt_fecha_inicio=' . $fecha_inicio . '&txt_fecha_fin=' . $fecha_fin . '&sel_tipo=' . $tipo . '&sel_tema=' . $tema . '&sel_subtema=' . $subtema . '&sel_estado=' . $estado . '&txt_descripcion=' . $descripcion . '&operador=' . $operador . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveEdit, permite actualizar el objeto DOCUMENTO 
     * en la base de datos, ver la clase CDocumentoData
     */
    case 'saveEdit':
        $id_edit = $_REQUEST['txt_id'];
        $fecha = $_REQUEST['txt_fecha'];
        $subtema = $_REQUEST['sel_subtema'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $consecutivo = $_REQUEST['txt_consecutivo'];

        $archivo_anterior = $_REQUEST['archivo_anterior'];
        
        $archivo = $_FILES['file_acta'];

        $documento = new Cdocumento($id_edit, $du);
        $documento->loadDocumento();

        $documento->setSubtema($subtema);
        $documento->setFecha($fecha);
        $documento->setDescripcion($descripcion);
        $documento->setVersion($consecutivo);

        //echo "archivo a borrar:".$archivo_anterior;
        $m = $documento->saveEditDocumento($archivo, $archivo_anterior);

        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&txt_fecha_inicio=" . $fecha_inicio . "&txt_fecha_fin=" . $fecha_fin . "&sel_tipo=" . $tipo . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_estado=" . $estado . "&txt_descripcion=" . $descripcion . "&operador=" . $operador);

        break;
    /**
     * la variable see, permite hacer la carga del objeto OPCION 
     * para ver sus variables, ver la clase COpcion
     */
    case 'see':
        $id_edit = $_REQUEST['id_element'];
        $documento = new CDocumento($id_edit, $du);
        $documento->loadDocumento();
        echo $documento->getFecha();
        $row_acta = array($documento->getFecha(), $documento->getSubtema() ,$documento->getDescripcion(), 
            $documento->getArchivo());
        
        //Inicio tabla
        $dt = new CHtmlDataTable();
        $titulos = array(ACTA_FECHA, ACTA_SUBTEMA, ACTA_DESCRIPCION, ACTA_DOCUMENTO);
        $dt->setDataRows($row_acta);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_ACTAS);

        $dt->setType(2);

        $dt->writeDataTable($niv);
        echo $html->generaScriptLink("cancelarAccion('frm_see_acta','?mod=" . $modulo . "&niv=" . $nivel . "')");

        
        $form = new CHtmlForm();
        $form->setId('frm_see_acta');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $documento->getId(), '', '');
        $form->writeForm();

        break;
    /**
    /**
     * en caso de que la variable task no este definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');

        break;
}
?>
