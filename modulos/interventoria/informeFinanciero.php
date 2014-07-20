<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


defined('_VALID_PRY') or die('Restricted access');
$niv = $_REQUEST['niv'];
$operador = OPERADOR_DEFECTO;
$ifiData = new CInformeFinancieroData($db);

$task = $_REQUEST['task'];

if (empty($task)) {
    $task = 'list';
}
switch ($task) {
    /**
     * La variable list, permite hacer la carga la página con la lista de 
     * objetos inventarioActividades según los parámetros de entrada.
     */
    case 'list':
        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        $fecha_fin = $_REQUEST['txt_fecha_fin'];
        $numero_factura = $_REQUEST['txt_numero_factura'];
        $numero_radicado_ministerio = $_REQUEST['txt_numero_radicado_ministerio'];
        
        //-------------------------------criterios---------------------------
        $criterio = "";
        if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
            if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (ifi_fecha_factura >= '" . $fecha_inicio . "')";
                } else {
                    $criterio .= " and ifi_fecha_factura >= '" . $fecha_inicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = "( ifi_fecha_factura between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                } else {
                    $criterio .= " and ifi_fecha_factura between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                }
            }
        }
        if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
            if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( ifi_fecha_factura <= '" . $fecha_fin . "')";
                } else {
                    $criterio .= " and ifi_fecha_factura <= '" . $fecha_fin . "')";
                }
            }
        }
        if (isset($numero_factura) && $numero_factura != '') {
            if ($criterio == "") {
                $criterio = "  ifi_numero_factura LIKE '" . $numero_factura. "%'";
            } else {
                $criterio .= " and ifi_numero_factura LIKE '" . $numero_factura."%'";
            }
        }
        if (isset($numero_radicado_ministerio) && $numero_radicado_ministerio != '') {
            if ($criterio == "") {
                $criterio = " ifi_numero_radicado_ministerio LIKE '" . $numero_radicado_ministerio."%'";
            } else {
                $criterio .= " and ifi_numero_radicado_ministerio LIKE '" . $numero_radicado_ministerio."%'";
            }
        }
        if ($criterio == "") {
            $criterio = "1";
        }
        /*
         * Inicio formulario
         */
        $form = new CHtmlForm();
        $form->setTitle(TABLA_INFORME_FINANCIERO);
        $form->setId('frm_list_informe_financiero');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(INFORME_FINANCIERO_FECHA_INICIO);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', '');

        $form->addEtiqueta(INFORME_FINANCIERO_FECHA_FIN);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', '');

        $form->addEtiqueta(INFORME_FINANCIERO_NUMERO_FACTURA);
        $form->addInputText('text', 'txt_numero_factura', 'txt_numero_factura', 15, 15, $numero_factura, '', '');

        $form->addEtiqueta(INFORME_FINANCIERO_NUMERO_RADICADO_MINISTERIO);
        $form->addInputText('text', 'txt_numero_radicado_ministerio', 'txt_numero_radicado_ministerio', 15, 15, $numero_radicado_ministerio, '', '');

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_informe_financiero();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', INFORME_FINANCIERO_EXPORTAR, 'button', 'onClick=exportar_excel_informe_financiero();');

        $form->writeForm();


        $dataRows = $ifiData->getInformeFinanciero($criterio);
        //Inicio Tabla
        $dt = new CHtmlDataTable();
        $titulos = array(INFORME_FINANCIERO_NUMERO_FACTURA, INFORME_FINANCIERO_FECHA_FACTURA, INFORME_FINANCIERO_NUMERO_RADICADO_MINISTERIO,
            INFORME_FINANCIERO_DOCUMENTO_SOPORTE, INFORME_FINANCIERO_DESCRIPCION, INFORME_FINANCIERO_VALOR_FACTURA, INFORME_FINANCIERO_AMORTIZACION,
            INFORME_FINANCIERO_SALDO_PENDIENTE_AA, INFORME_FINANCIERO_OBSERVACIONES, INFORME_FINANCIERO_SALDO_CONTRATO);
        $dt->setDataRows($dataRows);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_INFORME_FINANCIERO);

        //OPCIONES DE GESTIÓN
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add");
        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        break;

    /*
     * Variable add, agregar un informe financiero
     */
    case 'add':

        $numero_factura = $_REQUEST['txt_numero_factura'];
        $fecha_factura = $_REQUEST['txt_fecha'];
        $numero_radicado_ministerio = $_REQUEST['txt_numero_radicado_ministerio'];
        $documento_soporte = $_FILES['documento_soporte'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $valor_factura = $_REQUEST['txt_valor_factura'];
        $amortizacion = $_REQUEST['txt_amortizacion'];
        $observaciones = $_REQUEST['txt_observaciones'];

        /*
         * Inicio formulario
         */
        $form = new CHtmlForm();
        $form->setTitle(TABLA_INFORME_FINANCIERO);
        $form->setId('frm_add_informe_financiero');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(INFORME_FINANCIERO_NUMERO_FACTURA);
        $form->addInputText('text', 'txt_numero_factura', 'txt_numero_factura', 15, 15, $numero_factura, '', 'onChange="ocultarDiv(\'error_numero_factura\');"');
        $form->addError('error_numero_factura', ERROR_INFORME_FINANCIERO_NUMERO_FACTURA);

        $form->addEtiqueta(INFORME_FINANCIERO_FECHA_FACTURA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha_factura, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha_factura\');"');
        $form->addError('error_fecha_factura', ERROR_INFORME_FINANCIERO_FECHA_FACTURA);

        $form->addEtiqueta(INFORME_FINANCIERO_NUMERO_RADICADO_MINISTERIO);
        $form->addInputText('text', 'txt_numero_radicado_ministerio', 'txt_numero_radicado_ministerio', 15, 15, $numero_radicado_ministerio, '', 'onChange="ocultarDiv(\'error_numero_radicado_ministerio\');"');
        $form->addError('error_numero_radicado_ministerio', ERROR_INFORME_FINANCIERO_NUMERO_RADICADO_MINISTERIO);

        $form->addEtiqueta(INFORME_FINANCIERO_DOCUMENTO_SOPORTE);
        $form->addInputFile('file', 'documento_soporte', 'documento_soporte', '25', 'file', 'onChange="ocultarDiv(\'error_documento_soporte\');"');
        $form->addError('error_documento_soporte', ERROR_INFORME_FINANCIERO_DOCUMENTO_SOPORTE);

        $form->addEtiqueta(INFORME_FINANCIERO_DESCRIPCION);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', 30, 200, $descripcion, '', 'onChange="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_INFORME_FINANCIERO_DESCRIPCION);

        $form->addEtiqueta(INFORME_FINANCIERO_VALOR_FACTURA);
        $form->addInputText('text', 'txt_valor_factura', 'txt_valor_factura', 15, 15, $valor_factura, '', 'onChange="ocultarDiv(\'error_valor_factura\');"');
        $form->addError('error_valor_factura', ERROR_INFORME_FINANCIERO_VALOR_FACTURA);
        
        $form->addEtiqueta(INFORME_FINANCIERO_AMORTIZACION);
        $form->addInputText('text', 'txt_amortizacion', 'txt_amortizacion', 15, 15, $amortizacion, '', 'onChange="ocultarDiv(\'error_amortizacion\');"');
        $form->addError('error_amortizacion', ERROR_INFORME_FINANCIERO_AMORTIZACION);

        $form->addEtiqueta(INFORME_FINANCIERO_OBSERVACIONES);
        $form->addInputText('text', 'txt_observaciones', 'txt_observaciones', 30, 200, $observaciones, '', 'onChange="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_INFORME_FINANCIERO_OBSERVACIONES);

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=validar_add_informe_financiero();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', BTN_CANCELAR, 'button', 'onClick=cancelarAccion_informe_financiero(\'frm_add_informe_financiero\')');

        $form->writeForm();
        break;
    case 'saveAdd':
        $numero_factura = $_REQUEST['txt_numero_factura'];
        $fecha_factura = $_REQUEST['txt_fecha'];
        $numero_radicado_ministerio = $_REQUEST['txt_numero_radicado_ministerio'];
        $documento_soporte = $_FILES['documento_soporte'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $valor_factura = $_REQUEST['txt_valor_factura'];
        $amortizacion = $_REQUEST['txt_amortizacion'];
        $observaciones = $_REQUEST['txt_observaciones'];
        
        $informeFinanciero = new CInformeFinanciero('', $ifiData);
        $informeFinanciero->setNumero_factura($numero_factura);
        $informeFinanciero->setFecha_factura($fecha_factura);
        $informeFinanciero->setNumero_radicado_ministerio($numero_radicado_ministerio);
        $informeFinanciero->setDocumento_soporte($documento_soporte);
        $informeFinanciero->setDescripcion($descripcion);
        $informeFinanciero->setValor_factura($valor_factura);
        $informeFinanciero->setAmortizacion($amortizacion);
        $informeFinanciero->setObservaciones($observaciones);

        $mens = $informeFinanciero->saveInformeFinanciero($documento_soporte);
        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=1&task=list");
        break;
    
    case 'delete':
        $id_ifi = $_REQUEST['id_element'];
        $form = new CHtmlForm();
        $form->setId('frm_delete_informe_financiero');
        $form->setMethod('post');
        $form->writeForm();
        echo $html->generaAdvertencia(INFORME_FINANCIERO_MSG_BORRADO, '?mod=' . $modulo . '&niv='
                . $niv . '&task=confirmDelete&id_element=' . $id_ifi, 'onClick=cancelarAccion_informe_financiero_delete(\'frm_delete_informe_financiero\');');


        break;
    case 'confirmDelete':
        $id_ifi = $_REQUEST['id_element'];
        $informeFinanciero = new CInformeFinanciero($id_ifi, $ifiData);
        $informeFinanciero->loadInformeFinanciero();
        $mens = $informeFinanciero->deletInformeFinanciero($informeFinanciero->documento_soporte);
        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=1&task=list");

        break;
    case 'edit':
        $id_ifi = $_REQUEST['id_element'];
        
        $informeFinanciero = new CInformeFinanciero($id_ifi, $ifiData);
        $informeFinanciero->loadInformeFinanciero();
        
        $numero_factura=$informeFinanciero->getNumero_factura();
        $fecha_factura=$informeFinanciero->getFecha_factura();
        $numero_radicado_ministerio=$informeFinanciero->getNumero_radicado_ministerio();
        $documento_soporte_anterior=$informeFinanciero->getDocumento_soporte();
        $descripcion=$informeFinanciero->getDescripcion();
        $valor_factura=$informeFinanciero->getValor_factura();
        $amortizacion=$informeFinanciero->getAmortizacion();
        $observaciones=$informeFinanciero->getObservaciones();
        
        /*
         * Inicio formulario
         */
        $form = new CHtmlForm();
        $form->setTitle(TABLA_INFORME_FINANCIERO);
        $form->setId('frm_edit_informe_financiero');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(INFORME_FINANCIERO_NUMERO_FACTURA);
        $form->addInputText('text', 'txt_numero_factura', 'txt_numero_factura', 15, 15, $numero_factura, '', 'onChange="ocultarDiv(\'error_numero_factura\');"');
        $form->addError('error_numero_factura', ERROR_INFORME_FINANCIERO_NUMERO_FACTURA);

        $form->addEtiqueta(INFORME_FINANCIERO_FECHA_FACTURA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha_factura, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha_factura\');"');
        $form->addError('error_fecha_factura', ERROR_INFORME_FINANCIERO_FECHA_FACTURA);

        $form->addEtiqueta(INFORME_FINANCIERO_NUMERO_RADICADO_MINISTERIO);
        $form->addInputText('text', 'txt_numero_radicado_ministerio', 'txt_numero_radicado_ministerio', 15, 15, $numero_radicado_ministerio, '', 'onChange="ocultarDiv(\'error_numero_radicado_ministerio\');"');
        $form->addError('error_numero_radicado_ministerio', ERROR_INFORME_FINANCIERO_NUMERO_RADICADO_MINISTERIO);

        $form->addEtiqueta(INFORME_FINANCIERO_DOCUMENTO_SOPORTE);
        $form->addInputFile('file', 'documento_soporte', 'documento_soporte', '25', 'file', 'onChange="ocultarDiv(\'error_documento_soporte\');"');
        $form->addError('error_documento_soporte', ERROR_INFORME_FINANCIERO_DOCUMENTO_SOPORTE);

        $form->addEtiqueta(INFORME_FINANCIERO_DESCRIPCION);
        $form->addInputText('text', 'txt_descripcion', 'txt_descripcion', 30, 200, $descripcion, '', 'onChange="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_INFORME_FINANCIERO_DESCRIPCION);

        $form->addEtiqueta(INFORME_FINANCIERO_VALOR_FACTURA);
        $form->addInputText('text', 'txt_valor_factura', 'txt_valor_factura', 15, 15, $valor_factura, '', 'onChange="ocultarDiv(\'error_valor_factura\');"');
        $form->addError('error_valor_factura', ERROR_INFORME_FINANCIERO_VALOR_FACTURA);
        
        $form->addEtiqueta(INFORME_FINANCIERO_AMORTIZACION);
        $form->addInputText('text', 'txt_amortizacion', 'txt_amortizacion', 15, 15, $amortizacion, '', 'onChange="ocultarDiv(\'error_amortizacion\');"');
        $form->addError('error_amortizacion', ERROR_INFORME_FINANCIERO_AMORTIZACION);

        $form->addEtiqueta(INFORME_FINANCIERO_OBSERVACIONES);
        $form->addInputText('text', 'txt_observaciones', 'txt_observaciones', 30, 200, $observaciones, '', 'onChange="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_INFORME_FINANCIERO_OBSERVACIONES);

        $form->addInputText('hidden', 'id_element', 'id_element', '15', '15', $id_ifi, '', '');
        $form->addInputText('hidden', 'documento_soporte_anterior', 'documento_soporte_anterior', '15', '15', $documento_soporte_anterior, '', '');
        
        
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=validar_edit_informe_financiero();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', BTN_CANCELAR, 'button', 'onClick=cancelarAccion_informe_financiero(\'frm_edit_informe_financiero\');');

        $form->writeForm();
        
        break;
        /*
         * Almacenar los datos obtenidos del formulario de la variable edit
         */
    case 'saveEdit':
        $id_ifi = $_REQUEST['id_element'];
        $numero_factura = $_REQUEST['txt_numero_factura'];
        $fecha_factura = $_REQUEST['txt_fecha'];
        $numero_radicado_ministerio = $_REQUEST['txt_numero_radicado_ministerio'];
        $documento_soporte = $_FILES['documento_soporte'];
        $descripcion = $_REQUEST['txt_descripcion'];
        $valor_factura = $_REQUEST['txt_valor_factura'];
        $amortizacion = $_REQUEST['txt_amortizacion'];
        $observaciones = $_REQUEST['txt_observaciones'];
        
        $documento_soporte_anterior = $_REQUEST['documento_soporte_anterior'];
        
        $informeFinanciero = new CInformeFinanciero($id_ifi, $ifiData);
        $informeFinanciero->setNumero_factura($numero_factura);
        $informeFinanciero->setFecha_factura($fecha_factura);
        $informeFinanciero->setNumero_radicado_ministerio($numero_radicado_ministerio);
        $informeFinanciero->setDocumento_soporte($documento_soporte_anterior);
        $informeFinanciero->setDescripcion($descripcion);
        $informeFinanciero->setValor_factura($valor_factura);
        $informeFinanciero->setAmortizacion($amortizacion);
        $informeFinanciero->setObservaciones($observaciones);
        
        $mens = $informeFinanciero->saveEditInformeFinanciero($documento_soporte,$documento_soporte_anterior);
        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=1&task=list");
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