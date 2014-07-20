<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('_VALID_PRY') or die('Restricted access');
$data = new CRendimientoFinancieroData($db);
$task = $_REQUEST['task'];
//$operador = $_REQUEST['operador'];
if (empty($task)) {
    $task = 'list';
}
switch ($task) {
    case 'list':
        $cuenta = $_REQUEST['sel_cuenta'];
        
        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_LISTAR_RENDIMIENTOS);
        $form->setId('frm_listar_rendimientos');
        $form->setMethod('post');
        //$form->setOptions('autoClean', false);

        $cuentas = $data->getCuentas('1', 'cft_id, cfi_nombre');
        $opciones = null;
        if (isset($cuentas)) {
            foreach ($cuentas as $c) {
                $opciones[count($opciones)] = array('value' => $c['id'], 'texto' => $c['nombre']);
            }
        }
        $form->addEtiqueta(EXTRACTO_CUENTA);
        $form->addSelect('select', 'sel_cuenta', 'sel_cuenta', $opciones, RENDIMIENTOS_CUENTA, $cuenta, '', 'onChange="ocultarDiv(\'error_cuenta\');"');
        $form->addError('error_cuenta', ERROR_RENDIMIENTOS_CUENTA);
        
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="submit();"');
        //$form->addInputButton('button', 'cancelar', 'cancelar', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_listar_rendimientos\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        
        $criterio = "";
        if(isset($cuenta) && $cuenta != '-1'){
            $criterio = "r.cfi_id = ".$cuenta;
        }else{
            $criterio = "1";
        }
        
        $rendimientos = $data->getRendimientos($criterio, "rfi_anio, rfi_mes");
        
        $dt = new CHtmlDataTable();
        $titulos = array(RENDIMIENTOS_CUENTA, RENDIMIENTOS_FECHA,
            RENDIMIENTOS_RENDIMIENTO_FINANCIERO,
            RENDIMIENTOS_DESCUENTOS, RENDIMIENTOS_RENDIMIENTO_CONSIGNADO,
            RENDIMIENTOS_RENDIMIENTO_ACUMULADO, RENDIMIENTOS_RENTABILIDAD_TASA, 
            RENDIMIENTOS_FECHA_CONSIGNACION, RENDIMIENTOS_VALOR_FIDUCIARIA,            
            RENDIMIENTOS_ESTADO, RENDIMIENTOS_OBSERVACIONES,
            RENDIMIENTOS_COMPROBANTE_CONSIGNACION, RENDIMIENTOS_COMPROBANTE_EMISION);
        
        $contador = 0;
        $cont = count($rendimientos);
        $elementos = null;
        $dirOperador = $data->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_RENDIMIENTOS_SOPORTES . "/" . $dirOperador . "/");
        while ($contador < $cont) {
            $elementos[$contador]['id'] = $rendimientos[$contador]['id'];
            $elementos[$contador]['cuenta_nombre'] = $rendimientos[$contador]['cuenta_nombre'];
            $elementos[$contador]['fecha'] = $rendimientos[$contador]['mes']."-".$rendimientos[$contador]['anio'];
            $elementos[$contador]['rendimiento_financiero'] = number_format($rendimientos[$contador]['rendimiento_financiero'],2);
            $elementos[$contador]['descuentos'] = number_format($rendimientos[$contador]['descuentos'],2);
            $elementos[$contador]['rendimiento_consignado'] = number_format($rendimientos[$contador]['rendimiento_consignado'],2);
            $elementos[$contador]['rendimiento_acumulado'] = number_format($rendimientos[$contador]['rendimiento_acumulado'],2);
            $elementos[$contador]['rentabilidad_tasa'] = number_format($rendimientos[$contador]['rentabilidad_tasa'],2);
            $elementos[$contador]['fecha_consignacion'] = $rendimientos[$contador]['fecha_consignacion'];
            $elementos[$contador]['valor_fiduciaria'] = number_format($rendimientos[$contador]['valor_fiduciaria'],2);
            $elementos[$contador]['estado_nombre'] = $rendimientos[$contador]['estado_nombre'];
            $elementos[$contador]['observaciones'] = $rendimientos[$contador]['observaciones'];
            $elementos[$contador]['comprobante_consignacion'] = "<a href='".$ruta.$rendimientos[$contador]['comprobante_consignacion']."'>".$rendimientos[$contador]['comprobante_consignacion']."</a>";
            $elementos[$contador]['comprobante_emision'] = "<a href='".$ruta.$rendimientos[$contador]['comprobante_emision']."'>".$rendimientos[$contador]['comprobante_emision']."</a>";
            $contador++;
        }

        
        
        $dt->setDataRows($elementos);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_RENDIMIENTOS);

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv. "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete&sel_cuenta=".$cuenta);
        //$dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add");

        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        
        break;
    case 'add':
        $cuenta = $_REQUEST['sel_cuenta'];
        $mes = $_REQUEST['txt_mes'];
        $anio = $_REQUEST['txt_anio'];
        $saldo = $data->getSaldoFinalByFecha($cuenta, $mes, $anio);
        $rendimiento_financiero = $saldo;
        $descuentos = $_REQUEST['txt_descuentos'];
        $rendimiento_consignado = $saldo - $descuentos;
        $saldo_acumulado = $data->getSaldoConsignadoByFecha($cuenta, $mes, $anio);
        $rendimiento_acumulado = $saldo_acumulado;
        $rentabilidad_tasa = $_REQUEST['txt_rentabilidad_tasa'];
        $fecha_consignacion = $_REQUEST['txt_fecha_consignacion'];
        $comprobante_consignacion = $_FILES['file_comprobante_consignacion'];
        $comprobante_emision = $_FILES['file_comprobante_emision'];
        $valor_fiduciaria = $_REQUEST['txt_valor_fiduciaria'];
        $estado = $_REQUEST['sel_estado'];
        $observaciones = $_REQUEST['txt_observaciones'];

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_AGREGAR_RENDIMIENTOS);
        $form->setId('frm_agregar_rendimientos');
        $form->setMethod('post');
        $form->setOptions('autoClean', false);

        $cuentas = $data->getCuentas('1', 'cft_id, cfi_nombre');
        $opciones = null;
        if (isset($cuentas)) {
            foreach ($cuentas as $c) {
                $opciones[count($opciones)] = array('value' => $c['id'], 'texto' => $c['nombre']);
            }
        }
        $form->addEtiqueta(RENDIMIENTOS_CUENTA);
        $form->addSelect('select', 'sel_cuenta', 'sel_cuenta', $opciones, EXTRACTO_CUENTA, $cuenta, '', 'onChange="ocultarDiv(\'error_cuenta\');submit();"');
        $form->addError('error_cuenta', ERROR_EXTRACTO_CUENTA);

        $form->addEtiqueta(RENDIMIENTOS_MES);
        $form->addInputDate('date', 'txt_mes', 'txt_mes', $mes, '%m', '22', '22', '', 'onChange="ocultarDiv(\'error_mes\');submit();"');
        $form->addError('error_mes', ERROR_EXTRACTO_MES);

        $form->addEtiqueta(RENDIMIENTOS_ANIO);
        $form->addInputDate('date', 'txt_anio', 'txt_anio', $anio, '%Y', '22', '22', '', 'onChange="ocultarDiv(\'error_anio\');submit();"');
        $form->addError('error_anio', ERROR_EXTRACTO_ANIO);

        $form->addEtiqueta(RENDIMIENTOS_RENDIMIENTO_FINANCIERO);
        $form->addInputText('text', 'txt_rendimiento_financiero', 'txt_rendimiento_financiero', '15', '15', $rendimiento_financiero, '', 'onkeypress="ocultarDiv(\'error_rendimiento_financiero\');"');
        $form->addError('error_rendimiento_financiero', ERROR_RENDIMIENTOS_RENDIMIENTO_FINANCIERO);
        
        $form->addEtiqueta(RENDIMIENTOS_DESCUENTOS);
        $form->addInputText('text', 'txt_descuentos', 'txt_descuentos', '15', '15', $descuentos, '', 'onkeypress="ocultarDiv(\'error_descuentos\');" onChange="submit();"');
        $form->addError('error_descuentos', ERROR_RENDIMIENTOS_DESCUENTOS);

        $form->addEtiqueta(RENDIMIENTOS_RENDIMIENTO_CONSIGNADO);
        $form->addInputText('text', 'txt_rendimiento_consignado', 'txt_rendimiento_consignado', '15', '15', $rendimiento_consignado, '', 'onkeypress="ocultarDiv(\'error_rendimiento_consignado\');"');
        $form->addError('error_rendimiento_consignado', ERROR_RENDIMIENTOS_RENDIMIENTO_CONSIGNADO);

        $form->addEtiqueta(RENDIMIENTOS_RENDIMIENTO_ACUMULADO);
        $form->addInputText('text', 'txt_rendimiento_acumulado', 'txt_rendimiento_acumulado', '15', '15', $rendimiento_acumulado, '', 'onkeypress="ocultarDiv(\'error_rendimiento_acumulado\');"');
        $form->addError('error_rendimiento_acumulado', ERROR_RENDIMIENTOS_RENDIMIENTO_ACUMULADO);
        
        $form->addEtiqueta(RENDIMIENTOS_RENTABILIDAD_TASA);
        $form->addInputText('text', 'txt_rentabilidad_tasa', 'txt_rentabilidad_tasa', '15', '15', $rentabilidad_tasa, '', 'onkeypress="ocultarDiv(\'error_rentabilidad_tasa\');"');
        $form->addError('error_rentabilidad_tasa', ERROR_RENDIMIENTOS_RENTABILIDAD_TASA);
        
        $form->addEtiqueta(RENDIMIENTOS_FECHA_CONSIGNACION);
        $form->addInputDate('date', 'txt_fecha_consignacion', 'txt_fecha_consignacion', $fecha_consignacion, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_consignacion\');"');
        $form->addError('error_fecha_consignacion', ERROR_RENDIMIENTOS_FECHA_CONSIGNACION);
       
        $form->addEtiqueta(RENDIMIENTOS_COMPROBANTE_CONSIGNACION);
        $form->addInputFile('file', 'file_comprobante_consignacion', 'file_comprobante_consignacion', '25', 'file', 'onChange="ocultarDiv(\'error_comprobante_consignacion\');"');
        $form->addError('error_comprobante_consignacion', ERROR_RENDIMIENTOS_COMPROBANTE_CONSIGNACION);

        $form->addEtiqueta(RENDIMIENTOS_COMPROBANTE_EMISION);
        $form->addInputFile('file', 'file_comprobante_emision', 'file_comprobante_emision', '25', 'file', 'onChange="ocultarDiv(\'error_comprobante_emision\');"');
        $form->addError('error_comprobante_emision', ERROR_RENDIMIENTOS_COMPROBANTE_EMISION);

        $form->addEtiqueta(RENDIMIENTOS_VALOR_FIDUCIARIA);
        $form->addInputText('text', 'txt_valor_fiduciaria', 'txt_valor_fiduciaria', '15', '15', $valor_fiduciaria, '', 'onkeypress="ocultarDiv(\'error_valor_fiduciaria\');"');
        $form->addError('error_valor_fiduciaria', ERROR_RENDIMIENTOS_VALOR_FIDUCIARIA);

        $estados = $data->getEstados('1', 'erf_id');
        $opciones = null;
        if (isset($estados)) {
            foreach ($estados as $c) {
                $opciones[count($opciones)] = array('value' => $c['id'], 'texto' => $c['nombre']);
            }
        }
        $form->addEtiqueta(RENDIMIENTOS_ESTADO);
        $form->addSelect('select', 'sel_estado', 'sel_estado', $opciones, RENDIMIENTOS_ESTADO, $estado, '', 'onChange="ocultarDiv(\'error_estado\');"');
        $form->addError('error_estado', ERROR_RENDIMIENTOS_ESTADO);

        $form->addEtiqueta(RENDIMIENTOS_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '60', '6', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_RENDIMIENTOS_OBSERVACIONES);

        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_add_remdimiento(\'frm_agregar_rendimientos\');"');
        $form->addInputButton('button', 'cancelar', 'cancelar', BOTON_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_agregar_rendimientos\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();

        break;

    case 'saveAdd':
        $cuenta = $_REQUEST['sel_cuenta'];
        $mes = $_REQUEST['txt_mes'];
        $anio = $_REQUEST['txt_anio'];
        $rendimiento_financiero = $_REQUEST['txt_rendimiento_financiero'];
        $descuentos = $_REQUEST['txt_descuentos'];
        $rendimiento_consignado = $_REQUEST['txt_rendimiento_consignado'];
        $rendimiento_acumulado = $_REQUEST['txt_rendimiento_acumulado'];
        $rentabilidad_tasa = $_REQUEST['txt_rentabilidad_tasa'];
        $fecha_consignacion = $_REQUEST['txt_fecha_consignacion'];
        $comprobante_consignacion = $_FILES['file_comprobante_consignacion'];
        $comprobante_emision = $_FILES['file_comprobante_emision'];
        $valor_fiduciaria = $_REQUEST['txt_valor_fiduciaria'];
        $estado = $_REQUEST['sel_estado'];
        $observaciones = $_REQUEST['txt_observaciones'];

        $rendimiento = new CRendimientoFinanciero('',$data);
        $rendimiento->cuenta = $cuenta;
        $rendimiento->mes = $mes;
        $rendimiento->anio = $anio;
        $rendimiento->rendimiento_financiero = $rendimiento_financiero;
        $rendimiento->descuentos = $descuentos;
        $rendimiento->rendimiento_consignado = $rendimiento_consignado;
        $rendimiento->rendimiento_acumulado = $rendimiento_acumulado;
        $rendimiento->rentabilidad_tasa = $rentabilidad_tasa;
        $rendimiento->fecha_consignacion = $fecha_consignacion;
        $rendimiento->comprobante_consignacion = $comprobante_consignacion;
        $rendimiento->comprobante_emision = $comprobante_emision;
        $rendimiento->valor_fiduciaria = $valor_fiduciaria;
        $rendimiento->estado = $estado;
        $rendimiento->observaciones = $observaciones;

        $m = $rendimiento->saveRendimiento();
        
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;
    
    case 'edit':
        $id_edit = $_REQUEST['id_element'];
        $rendimiento = new CRendimientoFinanciero($id_edit,$data);
        $rendimiento->loadRendimiento();
        
        if(isset($_REQUEST['sel_cuenta']) && $_REQUEST['sel_cuenta']!=-1)
            $cuenta = $_REQUEST['sel_cuenta'];
        else
            $cuenta = $rendimiento->cuenta;
        if(isset($_REQUEST['txt_mes']) && $_REQUEST['txt_mes']!="0000-00-00")
            $mes = $_REQUEST['txt_mes'];
        else
            $mes = $rendimiento->mes;
        if(isset($_REQUEST['txt_anio']) && $_REQUEST['txt_anio']!="0000-00-00")
            $anio = $_REQUEST['txt_anio'];
        else
            $anio = $rendimiento->anio;
        if(isset($_REQUEST['txt_anio']))
            $rendimiento_financiero = $_REQUEST['txt_rendimiento_financiero'];
        else
            $rendimiento_financiero = $rendimiento->rendimiento_financiero;
        if(isset($_REQUEST['txt_descuentos']))
            $descuentos = $_REQUEST['txt_descuentos'];
        else
            $descuentos = $rendimiento->descuentos;
        
        $rendimiento_consignado = $rendimiento_financiero - $descuentos;
        $saldo_acumulado = $data->getSaldoConsignadoByFecha($cuenta, $mes, $anio);
        $rendimiento_acumulado = $saldo_acumulado;
        
//        if(isset($_REQUEST['txt_rendimiento_consignado']))
//            $rendimiento_consignado = $_REQUEST['txt_rendimiento_consignado'];
//        else
//            $rendimiento_consignado = $rendimiento->rendimiento_consignado;
//        if(isset($_REQUEST['txt_rendimiento_acumulado']))
//            $rendimiento_acumulado = $_REQUEST['txt_rendimiento_acumulado'];
//        else
//            $rendimiento_acumulado = $rendimiento->rendimiento_acumulado;
        if(isset($_REQUEST['txt_rentabilidad_tasa']))
            $rentabilidad_tasa = $_REQUEST['txt_rentabilidad_tasa'];
        else
            $rentabilidad_tasa = $rendimiento->rentabilidad_tasa;
        if(isset($_REQUEST['txt_fecha_consignacion']) && $_REQUEST['txt_fecha_consignacion']!="0000-00-00")
            $fecha_consignacion = $_REQUEST['txt_fecha_consignacion'];
        else
            $fecha_consignacion = $rendimiento->fecha_consignacion;
        if(isset($_REQUEST['txt_valor_fiduciaria']))
            $valor_fiduciaria = $_REQUEST['txt_valor_fiduciaria'];
        else
            $valor_fiduciaria = $rendimiento->valor_fiduciaria;
        if(isset($_REQUEST['sel_estado']) && $_REQUEST['sel_estado']!=-1)
            $estado = $_REQUEST['sel_estado'];
        else
            $estado = $rendimiento->estado;
        if(isset($_REQUEST['txt_observaciones']))
            $observaciones = $_REQUEST['txt_observaciones'];
        else
            $observaciones = $rendimiento->observaciones;
        
        $comprobante_consignacion = $_FILES['file_comprobante_consignacion'];
        $comprobante_emision = $_FILES['file_comprobante_emision'];
        
        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_EDITAR_RENDIMIENTOS);
        $form->setId('frm_editar_rendimientos');
        $form->setMethod('post');
        $form->setOptions('autoClean', false);
        
       
        $cuentas = $data->getCuentas('1', 'cft_id, cfi_nombre');
        $opciones = null;
        if (isset($cuentas)) {
            foreach ($cuentas as $c) {
                $opciones[count($opciones)] = array('value' => $c['id'], 'texto' => $c['nombre']);
            }
        }
        $form->addEtiqueta(RENDIMIENTOS_CUENTA);
        $form->addSelect('select', 'sel_cuenta', 'sel_cuenta', $opciones, EXTRACTO_CUENTA, $cuenta, '', 'onfocus="this.blur(); return false;"');
        $form->addError('error_cuenta', ERROR_EXTRACTO_CUENTA);

        $form->addEtiqueta(RENDIMIENTOS_MES);
        $form->addInputDate('date', 'txt_mes', 'txt_mes', $mes, '%m', '22', '22', '', 'onfocus="this.blur(); return false;"');
        $form->addError('error_mes', ERROR_EXTRACTO_MES);

        $form->addEtiqueta(RENDIMIENTOS_ANIO);
        $form->addInputDate('date', 'txt_anio', 'txt_anio', $anio, '%Y', '22', '22', '', 'onfocus="this.blur(); return false;"');
        $form->addError('error_anio', ERROR_EXTRACTO_ANIO);

        $form->addEtiqueta(RENDIMIENTOS_RENDIMIENTO_FINANCIERO);
        $form->addInputText('text', 'txt_rendimiento_financiero', 'txt_rendimiento_financiero', '15', '15', $rendimiento_financiero, '', 'onfocus="this.blur(); return false;"');
        $form->addError('error_rendimiento_financiero', ERROR_RENDIMIENTOS_RENDIMIENTO_FINANCIERO);
        
        $form->addEtiqueta(RENDIMIENTOS_DESCUENTOS);
        $form->addInputText('text', 'txt_descuentos', 'txt_descuentos', '15', '15', $descuentos, '', 'onkeypress="ocultarDiv(\'error_descuentos\');" onChange="submit();"');
        $form->addError('error_descuentos', ERROR_RENDIMIENTOS_DESCUENTOS);

        $form->addEtiqueta(RENDIMIENTOS_RENDIMIENTO_CONSIGNADO);
        $form->addInputText('text', 'txt_rendimiento_consignado', 'txt_rendimiento_consignado', '15', '15', $rendimiento_consignado, '', 'onfocus="this.blur(); return false;"');
        $form->addError('error_rendimiento_consignado', ERROR_RENDIMIENTOS_RENDIMIENTO_CONSIGNADO);

        $form->addEtiqueta(RENDIMIENTOS_RENDIMIENTO_ACUMULADO);
        $form->addInputText('text', 'txt_rendimiento_acumulado', 'txt_rendimiento_acumulado', '15', '15', $rendimiento_acumulado, '', 'onfocus="this.blur(); return false;"');
        $form->addError('error_rendimiento_acumulado', ERROR_RENDIMIENTOS_RENDIMIENTO_ACUMULADO);
        
        $form->addEtiqueta(RENDIMIENTOS_RENTABILIDAD_TASA);
        $form->addInputText('text', 'txt_rentabilidad_tasa', 'txt_rentabilidad_tasa', '15', '15', $rentabilidad_tasa, '', 'onfocus="this.blur(); return false;"');
        $form->addError('error_rentabilidad_tasa', ERROR_RENDIMIENTOS_RENTABILIDAD_TASA);
        
        $form->addEtiqueta(RENDIMIENTOS_FECHA_CONSIGNACION);
        $form->addInputDate('date', 'txt_fecha_consignacion', 'txt_fecha_consignacion', $fecha_consignacion, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_consignacion\');"');
        $form->addError('error_fecha_consignacion', ERROR_RENDIMIENTOS_FECHA_CONSIGNACION);
       
        $form->addEtiqueta(RENDIMIENTOS_COMPROBANTE_CONSIGNACION);
        $form->addInputFile('file', 'file_comprobante_consignacion', 'file_comprobante_consignacion', '25', 'file', 'onChange="ocultarDiv(\'error_comprobante_consignacion\');"');
        $form->addError('error_comprobante_consignacion', ERROR_RENDIMIENTOS_COMPROBANTE_CONSIGNACION);

        $form->addEtiqueta(RENDIMIENTOS_COMPROBANTE_EMISION);
        $form->addInputFile('file', 'file_comprobante_emision', 'file_comprobante_emision', '25', 'file', 'onChange="ocultarDiv(\'error_comprobante_emision\');"');
        $form->addError('error_comprobante_emision', ERROR_RENDIMIENTOS_COMPROBANTE_EMISION);

        $form->addEtiqueta(RENDIMIENTOS_VALOR_FIDUCIARIA);
        $form->addInputText('text', 'txt_valor_fiduciaria', 'txt_valor_fiduciaria', '15', '15', $valor_fiduciaria, '', 'onkeypress="ocultarDiv(\'error_valor_fiduciaria\');"');
        $form->addError('error_valor_fiduciaria', ERROR_RENDIMIENTOS_VALOR_FIDUCIARIA);

        $estados = $data->getEstados('1', 'erf_id');
        $opciones = null;
        if (isset($estados)) {
            foreach ($estados as $c) {
                $opciones[count($opciones)] = array('value' => $c['id'], 'texto' => $c['nombre']);
            }
        }
        $form->addEtiqueta(RENDIMIENTOS_ESTADO);
        $form->addSelect('select', 'sel_estado', 'sel_estado', $opciones, RENDIMIENTOS_ESTADO, $estado, '', 'onChange="ocultarDiv(\'error_estado\');"');
        $form->addError('error_estado', ERROR_RENDIMIENTOS_ESTADO);

        $form->addEtiqueta(RENDIMIENTOS_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '60', '6', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_RENDIMIENTOS_OBSERVACIONES);
        
        $form->addInputDate('hidden', 'txt_id', 'txt_id', $id_edit, '15', '15',  '', '', '');
        
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_rendimientos(\'frm_editar_rendimientos\');"');
        $form->addInputButton('button', 'cancelar', 'cancelar', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_editar_rendimientos\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();

        break;
        
    case 'saveEdit':
        $id_edit = $_REQUEST['txt_id'];
        $cuenta = $_REQUEST['sel_cuenta'];
        $mes = $_REQUEST['txt_mes'];
        $anio = $_REQUEST['txt_anio'];
        $rendimiento_financiero = $_REQUEST['txt_rendimiento_financiero'];
        $descuentos = $_REQUEST['txt_descuentos'];
        $rendimiento_consignado = $_REQUEST['txt_rendimiento_consignado'];
        $rendimiento_acumulado = $_REQUEST['txt_rendimiento_acumulado'];
        $rentabilidad_tasa = $_REQUEST['txt_rentabilidad_tasa'];
        $fecha_consignacion = $_REQUEST['txt_fecha_consignacion'];
        $comprobante_consignacion = $_FILES['file_comprobante_consignacion'];
        $comprobante_emision = $_FILES['file_comprobante_emision'];
        $valor_fiduciaria = $_REQUEST['txt_valor_fiduciaria'];
        $estado = $_REQUEST['sel_estado'];
        $observaciones = $_REQUEST['txt_observaciones'];

        $rendimiento = new CRendimientoFinanciero($id_edit,$data);
        $rendimiento->cuenta = $cuenta;
        $rendimiento->mes = $mes;
        $rendimiento->anio = $anio;
        $rendimiento->rendimiento_financiero = $rendimiento_financiero;
        $rendimiento->descuentos = $descuentos;
        $rendimiento->rendimiento_consignado = $rendimiento_consignado;
        $rendimiento->rendimiento_acumulado = $rendimiento_acumulado;
        $rendimiento->rentabilidad_tasa = $rentabilidad_tasa;
        $rendimiento->fecha_consignacion = $fecha_consignacion;
        $rendimiento->comprobante_consignacion = $comprobante_consignacion;
        $rendimiento->comprobante_emision = $comprobante_emision;
        $rendimiento->valor_fiduciaria = $valor_fiduciaria;
        $rendimiento->estado = $estado;
        $rendimiento->observaciones = $observaciones;

        

        $m = $rendimiento->updateRendimiento();
        
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;
    case 'delete':
        $cuenta = $_REQUEST['sel_cuenta'];
        $id_delete = $_REQUEST['id_element'];
        
        $form = new CHtmlForm();
        $form->setId('frm_delete_rendimiento');
        $form->setMethod('post');
        $form->writeForm();

        
        echo $html->generaAdvertencia(RENDIMIENTOS_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $niv . '&task=confirmDelete&sel_cuenta='.$cuenta.'&id_element=' . $id_delete, 
                "cancelarAccion('frm_delete_rendimiento','?mod=" . $modulo . "&niv=" . $niv. "&sel_cuenta=".$cuenta."');");
      
        break;
    /**
     * la variable confirmDelete, permite eliminar el objeto Correspondencia de la base de datos
     * 
     */
    case 'confirmDelete':
        $cuenta = $_REQUEST['sel_cuenta'];
        $id_delete = $_REQUEST['id_element'];
        
        $m = $data->deleteRendimiento($id_delete);   
        if($m){
            $msg = RENDIMIENTOS_BORRADO;
        }else{
            $msg = ERROR_RENDIMIENTOS_BORRADO;
        }
                
        echo $html->generaAviso($msg, "?mod=" . $modulo . "&niv=" . $niv . "&sel_cuenta=".$cuenta."&task=list");
        
        break;

}