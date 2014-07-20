<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('_VALID_PRY') or die('Restricted access');
$data = new CExtractoFinancieroInterventoriaData($db);
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
        $form->setTitle(TITULO_LISTAR_EXTRACTO);
        $form->setId('frm_listar_extracto');
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
        $form->addSelect('select', 'sel_cuenta', 'sel_cuenta', $opciones, EXTRACTO_CUENTA, $cuenta, '', 'onChange="ocultarDiv(\'error_cuenta\');"');
        $form->addError('error_cuenta', ERROR_EXTRACTO_CUENTA);
        
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="submit();"');
        //$form->addInputButton('button', 'cancelar', 'cancelar', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_listar_extracto\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        
        $criterio = "";
        if(isset($cuenta) && $cuenta != '-1'){
            $criterio = "e.cfi_id = ".$cuenta;
        }else{
            $criterio = "1";
        }
        
        $extractos = $data->getExtractos($criterio, "efi_anio, efi_mes");
        
        $dt = new CHtmlDataTable();
        $titulos = array(EXTRACTO_CUENTA, EXTRACTO_FECHA,
            EXTRACTO_SALDO_INICIAL, EXTRACTO_SALDO_FINAL, 
            EXTRACTO_RENTABILIDAD, EXTRACTO_OBSERVACIONES, 
            EXTRACTO_DOCUMENTO_SOPORTE, 
            EXTRACTO_ESTADO);
        
        
        $contador = 0;
        $cont = count($extractos);
        $elementos = null;
        $dirOperador = $data->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_EXTRACTOS_SOPORTES . "/" . $dirOperador . "/");
        while ($contador < $cont) {
            $elementos[$contador]['id'] = $extractos[$contador]['id'];
            $elementos[$contador]['cuenta'] = $extractos[$contador]['cuenta_nombre'];
            $elementos[$contador]['fecha'] = $extractos[$contador]['mes']."-".$extractos[$contador]['anio'];
            $elementos[$contador]['saldo_inicial'] = number_format($extractos[$contador]['saldo_inicial'],2);
            
            $elementos[$contador]['saldo_final'] = number_format($extractos[$contador]['saldo_final'],2);
            $elementos[$contador]['rentabilidad'] = number_format($extractos[$contador]['rentabilidad'],2);
            $elementos[$contador]['observaciones'] = $extractos[$contador]['observaciones'];
            $elementos[$contador]['documento_soporte'] = "<a href='".$ruta.$extractos[$contador]['documento_soporte']."'>".$extractos[$contador]['documento_soporte']."</a>";
           
            $temporal_final = $extractos[$contador]['saldo_inicial'] + $extractos[$contador]['incrementos'] - $extractos[$contador]['disminuciones'];
            if(number_format($temporal_final,0) != number_format($extractos[$contador]['saldo_final'],0))
                $elementos[$contador]['estado']="<img src='templates/img/ico/rojo.gif'>";
            else
                $elementos[$contador]['estado']="<img src='templates/img/ico/verde.gif'>";
            $contador++;
        }

        
        
        $dt->setDataRows($elementos);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_EXTRACTO);

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv. "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete&sel_cuenta=".$cuenta);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add");

        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        
        break;
    case 'add':
        $cuenta = $_REQUEST['sel_cuenta'];
        $mes = $_REQUEST['txt_mes'];
        $anio = $_REQUEST['txt_anio'];
        $saldo_anterior = $data->getSaldoFinalByFecha($cuenta, $mes-1, $anio);
        if(isset($saldo_anterior))
            $saldo_inicial = $saldo_anterior;
        else
            $saldo_inicial = 0;
        $incrementos = $_REQUEST['txt_incrementos'];
        $disminuciones = $_REQUEST['txt_disminuciones'];
        $observaciones = $_REQUEST['txt_observaciones'];
        $documento_soporte = $_FILES['file_documento_soporte'];
        //$documento_movimientos = $_FILES['file_documento_movimientos'];

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_AGREGAR_EXTRACTO);
        $form->setId('frm_agregar_extracto');
        $form->setMethod('post');
        $form->setOptions('autoClean', false);

        $cuentas = $data->getCuentas('1', 'cft_id, cfi_nombre');
        $opciones = null;
        if (isset($cuentas)) {
            foreach ($cuentas as $c) {
                $opciones[count($opciones)] = array('value' => $c['id'], 'texto' => $c['nombre']);
            }
        }
        $form->addEtiqueta(EXTRACTO_CUENTA);
        $form->addSelect('select', 'sel_cuenta', 'sel_cuenta', $opciones, EXTRACTO_CUENTA, $cuenta, '', 'onChange="ocultarDiv(\'error_cuenta\');submit();"');
        $form->addError('error_cuenta', ERROR_EXTRACTO_CUENTA);

        $form->addEtiqueta(EXTRACTO_MES);
        $form->addInputDate('date', 'txt_mes', 'txt_mes', $mes, '%m', '22', '22', '', 'onChange="ocultarDiv(\'error_mes\');submit();"');
        $form->addError('error_mes', ERROR_EXTRACTO_MES);

        $form->addEtiqueta(EXTRACTO_ANIO);
        $form->addInputDate('date', 'txt_anio', 'txt_anio', $anio, '%Y', '22', '22', '', 'onChange="ocultarDiv(\'error_anio\');submit();"');
        $form->addError('error_anio', ERROR_EXTRACTO_ANIO);
        
        $form->addEtiqueta(EXTRACTO_SALDO_INICIAL);
        $form->addInputText('text', 'txt_saldo_inicial', 'txt_saldo_inicial', '15', '15', $saldo_inicial, '', 'onClick="ocultarDiv(\'error_saldo_inicial\');"');
        $form->addError('error_saldo_inicial', ERROR_EXTRACTO_SALDO_INICIAL);
        
        $form->addEtiqueta(EXTRACTO_INCREMENTOS);
        $form->addInputText('text', 'txt_incrementos', 'txt_incrementos', '15', '15', $incrementos, '', 'onkeypress="ocultarDiv(\'error_incrementos\');"');
        $form->addError('error_incrementos', ERROR_EXTRACTO_INCREMENTOS);
        
        $form->addEtiqueta(EXTRACTO_DISMINUCIONES);
        $form->addInputText('text', 'txt_disminuciones', 'txt_disminuciones', '15', '15', $disminuciones, '', 'onkeypress="ocultarDiv(\'error_disminuciones\');"');
        $form->addError('error_disminuciones', ERROR_EXTRACTO_DISMINUCIONES);

        $form->addEtiqueta(EXTRACTO_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '60', '6', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_EXTRACTO_OBSERVACIONES);

        $form->addEtiqueta(EXTRACTO_DOCUMENTO_SOPORTE);
        $form->addInputFile('file', 'file_documento_soporte', 'file_documento_soporte', '25', 'file', 'onChange="ocultarDiv(\'error_documento_soporte\');"');
        $form->addError('error_documento_soporte', ERROR_EXTRACTO_DOCUMENTO_SOPORTE);

//        $form->addEtiqueta(EXTRACTO_DOCUMENTO_MOVIMIENTOS);
//        $form->addInputFile('file', 'file_documento_movimientos', 'file_documento_movimientos', '25', 'file', 'onChange="ocultarDiv(\'error_documento_movimientos\');"');
//        $form->addError('error_documento_movimientos', ERROR_EXTRACTO_DOCUMENTO_MOVIMIENTOS);

        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_add_extracto_interventoria(\'frm_agregar_extracto\');"');
        $form->addInputButton('button', 'cancelar', 'cancelar', BOTON_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_agregar_extracto\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();

        break;

    case 'saveAdd':
        $cuenta = $_REQUEST['sel_cuenta'];
        $mes = $_REQUEST['txt_mes'];
        $anio = $_REQUEST['txt_anio'];
        $saldo_inicial = $_REQUEST['txt_saldo_inicial'];
        $incrementos = $_REQUEST['txt_incrementos'];
        $disminuciones = $_REQUEST['txt_disminuciones'];
        $observaciones = $_REQUEST['txt_observaciones'];
        $documento_soporte = $_FILES['file_documento_soporte'];
        //$documento_movimientos = $_FILES['file_documento_movimientos'];

        $extracto = new CExtractoFinancieroInterventoria('',$data);
        $extracto->cuenta = $cuenta;
        $extracto->mes = $mes;
        $extracto->anio = $anio;
        $extracto->saldo_inicial = $saldo_inicial;
        $extracto->incrementos = $incrementos;
        $extracto->disminuciones = $disminuciones;
        $extracto->observaciones = $observaciones;
        $extracto->documento_soporte = $documento_soporte;
        //$extracto->documento_movimientos = $documento_movimientos;

        $m = $extracto->saveExtracto();
        
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;
    
    case 'edit':
        $id_edit = $_REQUEST['id_element'];
        $extracto = new CExtractoFinancieroInterventoria($id_edit,$data);
        $extracto->loadExtracto();
        
        if(isset($_REQUEST['sel_cuenta']) && $_REQUEST['sel_cuenta']!= -1)
            $cuenta = $_REQUEST['sel_cuenta'];
        else
            $cuenta = $extracto->cuenta;
        
        if(isset($_REQUEST['txt_mes']) && $_REQUEST['txt_mes']!= "")
            $mes = $_REQUEST['txt_mes'];
        else
            $mes = $extracto->mes;
        
        if(isset($_REQUEST['txt_anio']) && $_REQUEST['txt_anio']!= "")
            $anio = $_REQUEST['txt_anio'];
        else
            $anio = $extracto->anio;
        $saldo_anterior = $data->getSaldoFinalByFecha($cuenta, $mes-1, $anio);
        $saldo_inicial = $saldo_anterior;
        
        if(!isset($saldo_inicial))
            $saldo_inicial=$extracto->saldo_inicial;
        
        if(isset($_REQUEST['txt_incrementos']) && $_REQUEST['txt_incrementos']!= "")
            $incrementos = $_REQUEST['txt_incrementos'];
        else
            $incrementos = $extracto->incrementos;
        
        if(isset($_REQUEST['txt_disminuciones']) && $_REQUEST['txt_disminuciones']!= "")
            $disminuciones = $_REQUEST['txt_disminuciones'];
        else
            $disminuciones = $extracto->disminuciones;
        
        if(isset($_REQUEST['txt_observaciones']) && $_REQUEST['txt_observaciones']!= "")
            $observaciones = $_REQUEST['txt_observaciones'];
        else
            $observaciones = $extracto->observaciones;
        
        $documento_soporte = $_FILES['file_documento_soporte'];
        $documento_movimientos = $_FILES['file_documento_movimientos'];

        $form = new CHtmlForm();
        $form->setClassEtiquetas('td_label');
        $form->setTitle(TITULO_EDITAR_EXTRACTO);
        $form->setId('frm_editar_extracto');
        $form->setMethod('post');
        $form->setOptions('autoClean', false);
        
       
        $cuentas = $data->getCuentas('1', 'cft_id, cfi_nombre');
        $opciones = null;
        if (isset($cuentas)) {
            foreach ($cuentas as $c) {
                $opciones[count($opciones)] = array('value' => $c['id'], 'texto' => $c['nombre']);
            }
        }
        $form->addEtiqueta(EXTRACTO_CUENTA);
        $form->addSelect('select', 'sel_cuenta', 'sel_cuenta', $opciones, EXTRACTO_CUENTA, $cuenta, '', 'onChange="ocultarDiv(\'error_cuenta\');submit();"');
        $form->addError('error_cuenta', ERROR_EXTRACTO_CUENTA);

        $form->addEtiqueta(EXTRACTO_MES);
        $form->addInputDate('date', 'txt_mes', 'txt_mes', $mes, '%m', '22', '22', '', 'onChange="ocultarDiv(\'error_mes\');submit();"');
        $form->addError('error_mes', ERROR_EXTRACTO_MES);

        $form->addEtiqueta(EXTRACTO_ANIO);
        $form->addInputDate('date', 'txt_anio', 'txt_anio', $anio, '%Y', '22', '22', '', 'onChange="ocultarDiv(\'error_anio\');submit();"');
        $form->addError('error_anio', ERROR_EXTRACTO_ANIO);

        
        
        $form->addEtiqueta(EXTRACTO_SALDO_INICIAL);
        $form->addInputText('text', 'txt_saldo_inicial', 'txt_saldo_inicial', '15', '15', $saldo_inicial, '', 'onClick="ocultarDiv(\'error_saldo_inicial\');"onkeypress="ocultarDiv(\'error_saldo_inicial\');"');
        $form->addError('error_saldo_inicial', ERROR_EXTRACTO_SALDO_INICIAL);

        $form->addEtiqueta(EXTRACTO_INCREMENTOS);
        $form->addInputText('text', 'txt_incrementos', 'txt_incrementos', '15', '15', $incrementos, '', 'onkeypress="ocultarDiv(\'error_saldo_inicial\');"');
        $form->addError('error_incrementos', ERROR_EXTRACTO_INCREMENTOS);
        
        $form->addEtiqueta(EXTRACTO_DISMINUCIONES);
        $form->addInputText('text', 'txt_disminuciones', 'txt_disminuciones', '15', '15', $disminuciones, '', 'onkeypress="ocultarDiv(\'error_disminuciones\');"');
        $form->addError('error_disminuciones', ERROR_EXTRACTO_DISMINUCIONES);
        //$form->addEtiqueta(EXTRACTO_SALDO_FINAL);
        //$form->addEtiqueta(EXTRACTO_RENTABILIDAD);

        $form->addEtiqueta(EXTRACTO_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '60', '6', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_EXTRACTO_OBSERVACIONES);

        $form->addEtiqueta(EXTRACTO_DOCUMENTO_SOPORTE);
        $form->addInputFile('file', 'file_documento_soporte', 'file_documento_soporte', '25', 'file', 'onChange="ocultarDiv(\'error_documento_soporte\');"');
        $form->addError('error_documento_soporte', ERROR_EXTRACTO_DOCUMENTO_SOPORTE);

//        $form->addEtiqueta(EXTRACTO_DOCUMENTO_MOVIMIENTOS);
//        $form->addInputFile('file', 'file_documento_movimientos', 'file_documento_movimientos', '25', 'file', 'onChange="ocultarDiv(\'error_documento_movimientos\');"');
//        $form->addError('error_documento_movimientos', ERROR_EXTRACTO_DOCUMENTO_MOVIMIENTOS);

        $form->addInputDate('hidden', 'txt_id', 'txt_id', $id_edit, '15', '15',  '', '', '');
        
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_extracto_interventoria(\'frm_editar_extracto\');"');
        $form->addInputButton('button', 'cancelar', 'cancelar', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_editar_extracto\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();

        break;
        
    case 'saveEdit':
        $id_edit = $_REQUEST['txt_id'];
        $cuenta = $_REQUEST['sel_cuenta'];
        $mes = $_REQUEST['txt_mes'];
        $anio = $_REQUEST['txt_anio'];
        $saldo_inicial = $_REQUEST['txt_saldo_inicial'];
        $incrementos = $_REQUEST['txt_incrementos'];
        $disminuciones = $_REQUEST['txt_disminuciones'];
        $observaciones = $_REQUEST['txt_observaciones'];
        $documento_soporte = $_FILES['file_documento_soporte'];
        $documento_movimientos = $_FILES['file_documento_movimientos'];

        $extracto = new CExtractoFinancieroInterventoria($id_edit,$data);
        $extracto->cuenta = $cuenta;
        $extracto->mes = $mes;
        $extracto->anio = $anio;
        $extracto->saldo_inicial = $saldo_inicial;
        $extracto->incrementos = $incrementos;
        $extracto->disminuciones = $disminuciones;
        $extracto->observaciones = $observaciones;
        $extracto->documento_soporte = $documento_soporte;
        //$extracto->documento_movimientos = $documento_movimientos;

        $m = $extracto->updateExtracto();
        
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;
    case 'delete':
        $cuenta = $_REQUEST['sel_cuenta'];
        $id_delete = $_REQUEST['id_element'];
        
        $form = new CHtmlForm();
        $form->setId('frm_delete_extracto');
        $form->setMethod('post');
        $form->writeForm();

        
        echo $html->generaAdvertencia(EXTRACTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $niv . '&task=confirmDelete&sel_cuenta='.$cuenta.'&id_element=' . $id_delete, 
                "cancelarAccion('frm_delete_extracto','?mod=" . $modulo . "&niv=" . $niv. "&sel_cuenta=".$cuenta."');");
      
        break;
    /**
     * la variable confirmDelete, permite eliminar el objeto Correspondencia de la base de datos
     * 
     */
    case 'confirmDelete':
        $cuenta = $_REQUEST['sel_cuenta'];
        $id_delete = $_REQUEST['id_element'];
        
        $m = $data->deleteExtracto($id_delete);   
        if($m){
            $msg = EXTRACTO_BORRADO;
        }else{
            $msg = ERROR_EXTRACTO_BORRADO;
        }
                
        echo $html->generaAviso($msg, "?mod=" . $modulo . "&niv=" . $niv . "&sel_cuenta=".$cuenta."&task=list");
        
        break;

}