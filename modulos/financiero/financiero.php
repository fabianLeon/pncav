<?php

/**
 * Redcom Ltda 
 */
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');
$desData = new CDesembolsoData($db);
$vigData = new CVigenciaData($db);
$facData = new CFacturaData($db);
$invData = new CInversionData($db);
$rubData = new CRubroData($db);
$renData = new CRendimientosData($db);
$cncData = new CConceptoData($db);
$extData = new CExtractoData($db);
$cnlData = new CConciliacionData($db);
$utiData = new CUtilizacionData($db);
$modData = new CModalidadData($db);
$ordData = new COrdenesData($db);
$operadorData = new COperadorData($db);


$task = $_REQUEST['task'];

$operador = $_REQUEST['operador'];
$Ooperador = new COperador($operador, '', '', $operadorData);
$Ooperador->loadOperador();

$anticipo = $facData->getAnticipo('vir_anticipo="S" and ope_id=' . $operador, 'vir_id');
$anio_anticipo = $anticipo['anio'];
$vig = $vigData->getTotalVigencias(' ope_id=' . $operador);
$contrato['valor'] = $vig['monto'];


if (empty($task))
    $task = 'listBalance';

switch ($task) {
    case 'listBalance':

        $Ooperador = new COperador($operador, '', '', $operadorData);
        $Ooperador->loadOperador();
        $total_vigencias = $vigData->getTotalVigencias('vir_anio>' . $anio_anticipo . ' and ope_id=' . $operador);
        $dt = new CHtmlDataTable();
        $dt->setTitleTable(TABLA_CONTRATO . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setType(2);

        $dt->writeDataTable($nivel);

        $dt = new CHtmlDataTable();
        $ingresos = $vigData->getIngresos(' ope_id=' . $operador, 'vir_anio');
        for ($d = 0; $d < count($ingresos); $d++) {
            $ingresos[$d]['monto'] = number_format($ingresos[$d]['monto'], 2, ',', '.');
        }
        $ingresos[$d]['id'] = $d + 100;
        $ingresos[$d]['anio'] = TOTAL_CONTRATO_VIGENCIAS;
        $ingresos[$d]['monto'] = number_format($total_vigencias['monto'], 2, ',', '.');

        $dt = new CHtmlDataTable();
        $titulos = array(VIGENCIA_DESCRIPCION, VIGENCIA_MONTO_INGRESO);
        $dt->setDataRows($ingresos);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_INGRESOS . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        $dt->setType(1);

        $dt->writeDataTable($nivel);
        $dt = new CHtmlDataTable();

        $egresos = $vigData->getEgresos(' ope_id=' . $operador, 'vir_anio');
        $ejecutado = 0;
        $porejecutar = 0;
        for ($d = 0; $d < count($egresos); $d++) {
            $egresos[$d]['monto'] = number_format($egresos[$d]['monto'], 2, ',', '.');
            $ejecutado = $ejecutado + $egresos[$d]['ejecutado'];
            $porejecutar = $porejecutar + $egresos[$d]['porejecutar'];
            $egresos[$d]['ejecutado'] = number_format($egresos[$d]['ejecutado'], 2, ',', '.');
            $egresos[$d]['porejecutar'] = number_format($egresos[$d]['porejecutar'], 2, ',', '.');
        }
        $egresos[$d]['id'] = $d + 100;
        $egresos[$d]['anio'] = TOTAL_CONTRATO_VIGENCIAS;
        $egresos[$d]['monto'] = number_format($total_vigencias['monto'], 2, ',', '.');
        $egresos[$d]['ejecutado'] = number_format($ejecutado, 2, ',', '.');
        $egresos[$d]['porejecutar'] = number_format($porejecutar, 2, ',', '.');
        $dt = new CHtmlDataTable();
        $titulos = array(VIGENCIA_DESCRIPCION, VIGENCIA_MONTO_EGRESO, VIGENCIA_EJECUTADO, VIGENCIA_POREJECUTAR);
        $dt->setDataRows($egresos);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_EGRESOS . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    // ----------------           Informe Financiero    --------------------------------------------
    case 'listEjecucion':

        $Ooperador = new COperador($operador, '', '', $operadorData);
        $Ooperador->loadOperador();
        $anticipo = $facData->getAnticipo('vir_anticipo="S" and ope_id=' . $operador, 'vir_id');
        $dt = new CHtmlDataTable();
        $dt->setTitleTable(TABLA_CONTRATO . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        $dt->setType(2);

        $dt->writeDataTable($nivel);

        $facturas = $facData->getResumenFactura(' ope_id=' . $operador, 'fac_id', $contrato['valor'], $anticipo['valor'], $Ooperador->getSiglas());
        for ($d = 0; $d < count($facturas); $d++) {
            $facturas[$d]['factura'] = number_format($facturas[$d]['factura'], 2, ',', '.');
            $facturas[$d]['monto'] = number_format($facturas[$d]['monto'], 2, ',', '.');
            $facturas[$d]['amortiza'] = number_format($facturas[$d]['amortiza'], 2, ',', '.');
            $facturas[$d]['saldo'] = number_format($facturas[$d]['saldo'], 2, ',', '.');
            $facturas[$d]['saldo_anticipo'] = number_format($facturas[$d]['saldo_anticipo'], 2, ',', '.');
        }
        $dt = new CHtmlDataTable();
        $titulos = array(EJECUCION_NUMERO, EJECUCION_FECHA, EJECUCION_DESCRIPCION, EJECUCION_VALOR, EJECUCION_SALDO, EJECUCION_VALOR_TOTAL, EJECUCION_AMORTIZA, EJECUCION_SALDO_ANTICIPO, EJECUCION_OBSERVACIONES, EJECUCION_DOCUMENTO);
        $dt->setDataRows($facturas);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_EJECUCION . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setSeeLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=seeEjecucion" . '&operador=' . $operador);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editEjecucion" . '&operador=' . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteEjecucion" . '&operador=' . $operador);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addEjecucion" . '&operador=' . $operador);

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addEjecucion':
        $descripcion = $_POST['txt_descripcion'];
        $fecha = $_POST['txt_fecha'];
        $proveedor = $_POST['txt_proveedor'];
        $documento_proveedor = $_POST['txt_documento_proveedor'];
        $monto = $_POST['txt_monto'];
        $numero = $_POST['txt_numero'];
        $amortiza = $_POST['txt_amortiza'];
        $observaciones = $_POST['txt_observaciones'];

        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_EJECUCION);

        $form->setId('frm_add_ejecucion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_anio', 'txt_anio', '50', '50', $contrato['id'], '', '');
        $form->addInputText('hidden', 'txt_monto_contrato', 'txt_monto_contrato', '30', '30', $contrato['monto'], '', '');
        $form->addInputText('hidden', 'operador', 'operador', '30', '30', $operador, '', '');

        $form->addEtiqueta(EJECUCION_DESCRIPCION);
        $form->addTextArea('textarea', 'txt_descripcion', 'txt_descripcion', '50', '1', $descripcion, '', 'onkeypress="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_EJECUCION_DESCRIPCION);

        $form->addEtiqueta(EJECUCION_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_EJECUCION_FECHA);

        $form->addEtiqueta(EJECUCION_NUMERO);
        $form->addInputText('text', 'txt_numero', 'txt_numero', '16', '16', $numero, '', 'onChange="ocultarDiv(\'error_numero\');"');
        $form->addError('error_numero', ERROR_EJECUCION_NUMERO);

        $form->addEtiqueta(EJECUCION_PROVEEDOR);
        $form->addInputText('text', 'txt_proveedor', 'txt_proveedor', '50', '50', $proveedor, '', 'onChange="ocultarDiv(\'error_proveedor\');"');
        $form->addError('error_proveedor', ERROR_EJECUCION_PROVEEDOR);

        $form->addEtiqueta(EJECUCION_DOCUMENTO_PROVEEDOR);
        $form->addInputText('text', 'txt_documento_proveedor', 'txt_documento_proveedor', '20', '20', $documento_proveedor, '', 'onkeypress="ocultarDiv(\'error_documento_proveedor\');"');
        $form->addError('error_documento_proveedor', ERROR_EJECUCION_DOCUMENTO_PROVEEDOR);

        $form->addEtiqueta(EJECUCION_VALOR);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_EJECUCION_VALOR);

        $form->addEtiqueta(EJECUCION_AMORTIZA);
        $form->addInputText('text', 'txt_amortiza', 'txt_amortiza', '20', '20', $amortiza, '', 'onChange="ocultarDiv(\'error_amortiza\');"');
        $form->addError('error_amortiza', ERROR_EJECUCION_AMORTIZA);

        $form->addEtiqueta(EJECUCION_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '50', '5', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observacion\');"');
        $form->addError('error_observacion', ERROR_EJECUCION_OBSERVACIONES);

        $form->addEtiqueta(EJECUCION_DOCUMENTO);
        $form->addInputFile('file', 'file_documento', 'file_documento', '50', 'file', 'onChange="ocultarDiv(\'error_documento\');"');
        $form->addError('error_documento', EJECUCION_DOCUMENTO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_ejecucion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_ejecucion\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listEjecucion&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveAddEjecucion':

        $descripcion = $_POST['txt_descripcion'];
        $fecha = $_POST['txt_fecha'];
        $proveedor = $_POST['txt_proveedor'];
        $documento_proveedor = $_POST['txt_documento_proveedor'];
        $monto = $_POST['txt_monto'];
        $numero = $_POST['txt_numero'];
        $amortiza = $_POST['txt_amortiza'];
        $observaciones = $_POST['txt_observaciones'];
        $documento = $_FILES['file_documento'];

        $Ooperador = new COperador($operador, '', '', $operadorData);
        $Ooperador->loadOperador();
        $factura = new CFactura($id, $descripcion, $fecha, $proveedor, $documento_proveedor, $monto, $amortiza, $numero, $observaciones, '', $operador, $facData);

        $m = $factura->saveNewFactura($documento, $Ooperador->getSiglas());

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listEjecucion&operador=' . $operador);

        break;


    case 'editEjecucion':
        $id_edit = $_REQUEST['id_element'];
        $factura = new CFactura($id_edit, '', '', '', '', '', '', '', '', '', $operador, $facData);
        $factura->loadFactura();



        if (!isset($_POST['txt_descripcion']))
            $descripcion = $factura->getDescripcion();
        else
            $descripcion = $_REQUEST['txt_descripcion'];
        if (!isset($_POST['txt_fecha']))
            $fecha = $factura->getFecha();
        else
            $fecha = $_REQUEST['txt_fecha'];
        if (!isset($_POST['txt_proveedor']))
            $proveedor = $factura->getProveedor();
        else
            $proveedor = $_REQUEST['txt_proveedor'];
        if (!isset($_POST['txt_documento_proveedor']))
            $documento_proveedor = $factura->getDocumentoProveedor();
        else
            $documento_proveedor = $_REQUEST['txt_documento_proveedor'];
        if (!isset($_POST['txt_monto']))
            $monto = $factura->getMonto();
        else
            $monto = $_REQUEST['txt_monto'];
        if (!isset($_POST['txt_numero']))
            $numero = $factura->getNumero();
        else
            $numero = $_REQUEST['txt_numero'];
        if (!isset($_POST['txt_amortiza']))
            $amortiza = $factura->getAmortiza();
        else
            $amortiza = $_REQUEST['txt_amortiza'];
        if (!isset($_POST['txt_observaciones']))
            $observaciones = $factura->getObservaciones();
        else
            $observaciones = $_REQUEST['txt_observaciones'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_EJECUCION);

        $form->setId('frm_edit_ejecucion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_anio', 'txt_anio', '15', '15', $contrato['id'], '', '');
        $form->addInputText('hidden', 'txt_monto_contrato', 'txt_monto_contrato', '30', '30', $contrato['monto'], '', '');
        $form->addInputText('hidden', 'operador', 'operador', '30', '30', $operador, '', '');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');

        $form->addEtiqueta(EJECUCION_DESCRIPCION);
        $form->addTextArea('textarea', 'txt_descripcion', 'txt_descripcion', '50', '1', $descripcion, '', 'onkeypress="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_EJECUCION_DESCRIPCION);

        $form->addEtiqueta(EJECUCION_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_EJECUCION_FECHA);

        $form->addEtiqueta(EJECUCION_NUMERO);
        $form->addInputText('text', 'txt_numero', 'txt_numero', '16', '16', $numero, '', 'onChange="ocultarDiv(\'error_numero\');"');
        $form->addError('error_numero', ERROR_EJECUCION_NUMERO);

        $form->addEtiqueta(EJECUCION_PROVEEDOR);
        $form->addInputText('text', 'txt_proveedor', 'txt_proveedor', '50', '50', $proveedor, '', 'onChange="ocultarDiv(\'error_proveedor\');"');
        $form->addError('error_proveedor', ERROR_EJECUCION_PROVEEDOR);

        $form->addEtiqueta(EJECUCION_DOCUMENTO_PROVEEDOR);
        $form->addInputText('text', 'txt_documento_proveedor', 'txt_documento_proveedor', '20', '20', $documento_proveedor, '', 'onkeypress="ocultarDiv(\'error_documento_proveedor\');"');
        $form->addError('error_documento_proveedor', ERROR_EJECUCION_DOCUMENTO_PROVEEDOR);

        $form->addEtiqueta(EJECUCION_VALOR);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_EJECUCION_VALOR);

        $form->addEtiqueta(EJECUCION_AMORTIZA);
        $form->addInputText('text', 'txt_amortiza', 'txt_amortiza', '20', '20', $amortiza, '', 'onChange="ocultarDiv(\'error_amortiza\');"');
        $form->addError('error_amortiza', ERROR_EJECUCION_AMORTIZA);

        $form->addEtiqueta(EJECUCION_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '50', '5', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observacion\');"');
        $form->addError('error_observacion', ERROR_EJECUCION_OBSERVACIONES);

        $form->addEtiqueta(EJECUCION_DOCUMENTO);
        $form->addInputFile('file', 'file_documento', 'file_documento', '50', 'file', 'onChange="ocultarDiv(\'error_documento\');"');
        $form->addError('error_documento', EJECUCION_DOCUMENTO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_ejecucion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_ejecucion\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listEjecucion&operador=' . $operador . '\');"');

        $form->writeForm();
        break;


    case 'saveEditEjecucion':
        $id_edit = $_POST['txt_id'];
        $descripcion = $_POST['txt_descripcion'];
        $fecha = $_POST['txt_fecha'];
        $proveedor = $_POST['txt_proveedor'];
        $documento_proveedor = $_POST['txt_documento_proveedor'];
        $monto = $_POST['txt_monto'];
        $numero = $_POST['txt_numero'];
        $amortiza = $_POST['txt_amortiza'];
        $observaciones = $_POST['txt_observaciones'];
        $documento = $_FILES['file_documento'];
        $factura = new CFactura($id_edit, $descripcion, $fecha, $proveedor, $documento_proveedor, $monto, $amortiza, $numero, $observaciones, '', $operador, $facData);
        $m = $factura->saveEditFactura($documento, $Ooperador->getSiglas());
        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listEjecucion&operador=' . $operador);

        break;

    case 'seeEjecucion':
        $id_edit = $_REQUEST['id_element'];
        $factura = new CFactura($id_edit, '', '', '', '', '', '', '', '', '', $operador, $facData);
        $factura->loadSeeFactura($Ooperador->getSiglas());
        $dt = new CHtmlDataTable();
        $titulos = array(EJECUCION_DESCRIPCION,
            EJECUCION_FECHA,
            EJECUCION_NUMERO,
            EJECUCION_PROVEEDOR,
            EJECUCION_DOCUMENTO_PROVEEDOR,
            EJECUCION_VALOR,
            EJECUCION_AMORTIZA,
            EJECUCION_OBSERVACIONES,
            EJECUCION_DOCUMENTO);
        $row_anticipo = array($factura->getDescripcion(),
            $factura->getFecha(),
            $factura->getNumero(),
            $factura->getProveedor(),
            $factura->getDocumentoProveedor(),
            number_format($factura->getMonto(), 2, ",", "."),
            number_format($factura->getAmortiza(), 2, ",", "."),
            $factura->getObservaciones(),
            $factura->getDocumento());

        $dt->setDataRows($row_anticipo);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_EJECUCION . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setType(2);

        $dt->writeDataTable($nivel);

        $ht = new CHtmlTable();
        $ht->abrirTabla(0, 0, 0, '');
        $ht->abrirFila();
        $ht->abrirCelda('10%', 1, '');
        echo $html->generaScriptLink("cancelarAccion('frm_see_ejecucion','?mod=" . $modulo . "&niv=" . $nivel . "&task=listEjecucion&operador=" . $operador . "')");
        $ht->cerrarCelda();
        $ht->cerrarFila();
        $ht->cerrarTabla();
        $form = new CHtmlForm();
        $form->setId('frm_see_ejecucion');
        $form->setMethod('post');
        $form->addInputText('hidden', 'id_element', 'id_element', '15', '15', $factura->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        break;

    case 'deleteEjecucion':
        $id_delete = $_REQUEST['id_element'];
        $factura = new CFactura($id_delete, '', '', '', '', '', '', '', '', '', $operador, $facData);
        $factura->loadFactura();

        $form = new CHtmlForm();
        $form->setId('frm_delete_ejecucion');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $factura->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(EJECUCION_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteEjecucion&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_ejecucion','?mod=" . $modulo . "&niv=" . $nivel . "&task=listEjecucion&operador=" . $operador . "')");
        break;

    case 'confirmDeleteEjecucion':
        $id_edit = $_REQUEST['id_element'];
        $factura = new CFactura($id_edit, '', '', '', '', '', '', '', '', '', $operador, $facData);
        $factura->loadFactura();

        $m = $factura->deleteEjecucion();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listEjecucion&operador=' . $operador);

        break;

    // ----------------           Informe Inversion    --------------------------------------------
    case 'listInversion':

        $year = $_POST['sel_year'];
        $month = $_POST['sel_month'];

        $criterio = " f.ope_id = " . $operador;

        if (isset($year) && $year != -1) {
            $criterio = $criterio . " and year(inv_fecha) = " . $year . " ";
            if (isset($month) && $month != -1)
                $criterio .= " and month(inv_fecha) = " . $month . " ";
        }
        $form = new CHtmlForm();
        $form->setTitle(RESUMEN_EJECUTIVO);

        $form->setId('frm_resumen_ejecucion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');


        $years = $invData->getYearsInversion($operador);
        $opciones = null;
        if (isset($years)) {
            foreach ($years as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(EJECUCION_YEAR);
        $form->addSelect('select', 'sel_year', 'sel_year', $opciones, INVERSION_YEAR, $year, '', 'onChange=document.getElementById(\'sel_month\').value=-1;submit();');
        $form->addError('error_year', '');

        $months = $invData->getMonthsInversion($year, $operador);
        $opciones = null;
        if (isset($months)) {
            foreach ($months as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $meses[$t['nombre'] - 1]);
            }
        }
        $form->addEtiqueta(EJECUCION_MONTH);
        $form->addSelect('select', 'sel_month', 'sel_month', $opciones, EJECUCION_MONTH, $month, '', 'onChange=submit();');
        $form->addError('error_month', '');
        $form->writeForm();

        //echo ("<br>criterio:".$criterio);

        $dt = new CHtmlDataTable();
        $dt->setTitleTable(TABLA_CONTRATO . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        $dt->setType(2);

        $dt->writeDataTable($nivel);

        $inversions = $invData->getResumenInversion($criterio);
        for ($d = 0; $d < count($inversions); $d++) {
            $inversions[$d]['monto'] = number_format($inversions[$d]['monto'], 2, ',', '.');
        }
        $dt = new CHtmlDataTable();
        $titulos = array(INVERSION_RUBRO, INVERSION_PROVEEDOR, INVERSION_DOCUMENTO_PROVEEDOR, INVERSION_FECHA, INVERSION_VALOR, INVERSION_OBSERVACIONES);
        $dt->setDataRows($inversions);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_INVERSION . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setSeeLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=seeInversion" . "&operador=" . $operador);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editInversion" . "&operador=" . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteInversion" . "&operador=" . $operador);

        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addInversion" . "&operador=" . $operador);

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addInversion':


        $rubro = $_POST['sel_rubro'];
        $fecha = $_POST['txt_fecha'];
        $proveedor = $_POST['txt_proveedor'];
        $documento_proveedor = $_POST['txt_documento_proveedor'];
        $monto = $_POST['txt_monto'];
        $observaciones = $_POST['txt_observaciones'];

        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_INVERSION);

        $form->setId('frm_add_inversion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_anio', 'txt_anio', '50', '50', $contrato['id'], '', '');
        $form->addInputText('hidden', 'txt_monto_contrato', 'txt_monto_contrato', '30', '30', $contrato['monto'], '', '');
        $form->addInputText('hidden', 'operador', 'operador', '30', '30', $operador, '', '');

        $rubros = $invData->getRubros(' ope_id=' . $operador, 'rub_nombre');
        $opciones = null;
        if (isset($rubros)) {
            foreach ($rubros as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form->addEtiqueta(INVERSION_RUBRO);
        $form->addSelect('select', 'sel_rubro', 'sel_rubro', $opciones, INVERSION_RUBRO, $rubro, '', 'onChange=submit();');
        $form->addError('error_rubro', ERROR_INVERSION_RUBRO);

        $form->addEtiqueta(INVERSION_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_INVERSION_FECHA);

        $form->addEtiqueta(INVERSION_PROVEEDOR);
        $form->addInputText('text', 'txt_proveedor', 'txt_proveedor', '50', '50', $proveedor, '', 'onChange="ocultarDiv(\'error_proveedor\');"');
        $form->addError('error_proveedor', ERROR_INVERSION_PROVEEDOR);

        $form->addEtiqueta(INVERSION_DOCUMENTO_PROVEEDOR);
        $form->addInputText('text', 'txt_documento_proveedor', 'txt_documento_proveedor', '50', '50', $documento_proveedor, '', 'onkeypress="ocultarDiv(\'error_documento_proveedor\');"');
        $form->addError('error_documento_proveedor', ERROR_INVERSION_DOCUMENTO_PROVEEDOR);

        $form->addEtiqueta(INVERSION_VALOR);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_INVERSION_VALOR);

        $form->addEtiqueta(INVERSION_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '50', '5', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observacion\');"');
        $form->addError('error_observacion', ERROR_INVERSION_OBSERVACIONES);

        $form->addEtiqueta(EJECUCION_DOCUMENTO);
        $form->addInputFile('file', 'file_documento', 'file_documento', '200', 'file', 'onChange="ocultarDiv(\'error_documento\');"');
        $form->addError('error_documento', EJECUCION_DOCUMENTO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_inversion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_inversion\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listInversion&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveAddInversion':

        $rubro = $_POST['sel_rubro'];
        $fecha = $_POST['txt_fecha'];
        $proveedor = $_POST['txt_proveedor'];
        $documento_proveedor = $_POST['txt_documento_proveedor'];
        $monto = $_POST['txt_monto'];
        $observaciones = $_POST['txt_observaciones'];
        $documento = $_FILES['file_documento'];

        $inversion = new CInversion($id, $rubro, $fecha, $proveedor, $documento_proveedor, $monto, $observaciones, '', $operador, $invData);

        $m = $inversion->saveNewInversion($documento, $Ooperador->getSiglas());

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listInversion&operador=' . $operador);

        break;

    case 'editInversion':
        $id_edit = $_REQUEST['id_element'];
        $inversion = new CInversion($id_edit, '', '', '', '', '', '', '', $operador, $invData);
        $inversion->loadInversion();



        if (!isset($_POST['sel_rubro']))
            $rubro = $inversion->getRubro();
        else
            $rubro = $_REQUEST['sel_rubro'];
        if (!isset($_POST['txt_fecha']))
            $fecha = $inversion->getFecha();
        else
            $fecha = $_REQUEST['txt_fecha'];
        if (!isset($_POST['txt_proveedor']))
            $proveedor = $inversion->getProveedor();
        else
            $proveedor = $_REQUEST['txt_proveedor'];
        if (!isset($_POST['txt_documento_proveedor']))
            $documento_proveedor = $inversion->getDocumentoProveedor();
        else
            $documento_proveedor = $_REQUEST['txt_documento_proveedor'];
        if (!isset($_POST['txt_monto']))
            $monto = $inversion->getMonto();
        else
            $monto = $_REQUEST['txt_monto'];
        if (!isset($_POST['txt_observaciones']))
            $observaciones = $inversion->getObservaciones();
        else
            $observaciones = $_REQUEST['txt_observaciones'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_INVERSION);

        $form->setId('frm_edit_inversion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_anio', 'txt_anio', '15', '15', $contrato['id'], '', '');
        $form->addInputText('hidden', 'txt_monto_contrato', 'txt_monto_contrato', '30', '30', $contrato['monto'], '', '');
        $form->addInputText('hidden', 'operador', 'operador', '30', '30', $operador, '', '');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');

        $rubros = $invData->getRubros(' ope_id=' . $operador, 'rub_nombre');
        $opciones = null;
        if (isset($rubros)) {
            foreach ($rubros as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form->addEtiqueta(INVERSION_RUBRO);
        $form->addSelect('select', 'sel_rubro', 'sel_rubro', $opciones, INVERSION_RUBRO, $rubro, '', 'onChange=submit();');
        $form->addError('error_rubro', ERROR_INVERSION_RUBRO);

        $form->addEtiqueta(INVERSION_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_INVERSION_FECHA);

        $form->addEtiqueta(INVERSION_PROVEEDOR);
        $form->addInputText('text', 'txt_proveedor', 'txt_proveedor', '50', '50', $proveedor, '', 'onChange="ocultarDiv(\'error_proveedor\');"');
        $form->addError('error_proveedor', ERROR_INVERSION_PROVEEDOR);

        $form->addEtiqueta(INVERSION_DOCUMENTO_PROVEEDOR);
        $form->addInputText('text', 'txt_documento_proveedor', 'txt_documento_proveedor', '50', '50', $documento_proveedor, '', 'onkeypress="ocultarDiv(\'error_documento_proveedor\');"');
        $form->addError('error_documento_proveedor', ERROR_INVERSION_DOCUMENTO_PROVEEDOR);

        $form->addEtiqueta(INVERSION_VALOR);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_INVERSION_VALOR);

        $form->addEtiqueta(INVERSION_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '50', '5', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observacion\');"');
        $form->addError('error_observacion', ERROR_INVERSION_OBSERVACIONES);

        $form->addEtiqueta(EJECUCION_DOCUMENTO);
        $form->addInputFile('file', 'file_documento', 'file_documento', '200', 'file', 'onChange="ocultarDiv(\'error_documento\');"');
        $form->addError('error_documento', EJECUCION_DOCUMENTO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_inversion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_inversion\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listInversion&operador=' . $operador . '\');"');

        $form->writeForm();
        break;


    case 'saveEditInversion':
        $id_edit = $_POST['txt_id'];


        $rubro = $_POST['sel_rubro'];
        $fecha = $_POST['txt_fecha'];
        $proveedor = $_POST['txt_proveedor'];
        $documento_proveedor = $_POST['txt_documento_proveedor'];
        $monto = $_POST['txt_monto'];
        $observaciones = $_POST['txt_observaciones'];
        $documento = $_FILES['file_documento'];
        $inversion = new CInversion($id_edit, $rubro, $fecha, $proveedor, $documento_proveedor, $monto, $observaciones, '', $operador, $invData);

        $m = $inversion->saveEditInversion($documento, $Ooperador->getSiglas());

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listInversion&operador=' . $operador);

        break;

    case 'seeInversion':
        $id_edit = $_REQUEST['id_element'];
        $inversion = new CInversion($id_edit, '', '', '', '', '', '', '', $operador, $invData);
        $inversion->loadSeeInversion($Ooperador->getSiglas());
        $dt = new CHtmlDataTable();
        $titulos = array(INVERSION_DESCRIPCION,
            INVERSION_FECHA,
            INVERSION_PROVEEDOR,
            INVERSION_DOCUMENTO_PROVEEDOR,
            INVERSION_VALOR,
            INVERSION_OBSERVACIONES,
            INVERSION_SOPORTE);
        $row_anticipo = array($inversion->getRubro(),
            $inversion->getFecha(),
            $inversion->getProveedor(),
            $inversion->getDocumentoProveedor(),
            number_format($inversion->getMonto(), 2, ",", "."),
            $inversion->getObservaciones(),
            $inversion->getDocumento());

        $dt->setDataRows($row_anticipo);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_INVERSION . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setType(2);

        $dt->writeDataTable($nivel);

        $ht = new CHtmlTable();
        $ht->abrirTabla(0, 0, 0, '');
        $ht->abrirFila();
        $ht->abrirCelda('10%', 1, '');
        echo $html->generaScriptLink("cancelarAccion('frm_see_inversion','?mod=" . $modulo . "&niv=" . $nivel . "&task=listInversion&operador=" . $operador . "')");
        $ht->cerrarCelda();
        $ht->cerrarFila();
        $ht->cerrarTabla();
        $form = new CHtmlForm();
        $form->setId('frm_see_inversion');
        $form->setMethod('post');
        $form->addInputText('hidden', 'id_element', 'id_element', '15', '15', $inversion->getId(), '', '');
        $form->writeForm();

        break;

    case 'deleteInversion':
        $id_delete = $_REQUEST['id_element'];

        $form = new CHtmlForm();
        $form->setId('frm_delete_inversion');
        $form->setMethod('post');
        $form->writeForm();

        echo $html->generaAdvertencia(INVERSION_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteInversion&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_inversion','?mod=" . $modulo . "&niv=" . $nivel . "&task=listInversion&operador=" . $operador . "')");
        break;

    case 'confirmDeleteInversion':
        $id_delete = $_REQUEST['id_element'];
        $inversion = new CInversion($id_delete, '', '', '', '', '', '', '', $operador, $invData);
        $inversion->loadInversion();
        $archivo_anterior = $inversion->getDocumento();

        $m = $inversion->deleteInversion($archivo_anterior);

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listInversion&operador=' . $operador);

        break;

    case 'resumenInversion':
        $form = new CHtmlForm();
        $form->setTitle(RESUMEN_EJECUTIVO_PERIODO);

        $form->setId('frm_resumen_ejecucion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $criterio = ' r.ope_id=' . $operador;
        $rubros = $invData->getResumen($criterio);
        $suma_final_saldo = 0;
        $suma_final_valor = 0;
        $suma_inversion = 0;
        if (isset($rubros)) {
            foreach ($rubros as $t) {
                $inversiones = $invData->getInversiones('f.rub_id = ' . $t['id'] . ' and r.ope_id=' . $operador, 'r.rub_nombre');

                if ($t['periodo'] != 0) {

                    $dt = new CHtmlDataTable();
                    $dt->setTitleTable($t['rubro']);
                    $dt->setType(1);

                    $titulos = array(INVERSION_PROVEEDOR,
                        INVERSION_DOCUMENTO_PROVEEDOR,
                        INVERSION_FECHA,
                        INVERSION_VALOR_UTILIZADO);
                    $cont = 0;
                    $row_f = null;
                    $suma_valor = 0;
                    $monto_inicial = $invData->getMontoRubro(' rub_id=' . $t['id'] . ' and ope_id=' . $operador);
                    $row_f[$cont]['id'] = $cont;
                    $row_f[$cont]['proveedor'] = '';
                    $row_f[$cont]['documento'] = '';
                    $row_f[$cont]['fecha'] = "<span class='total'>" . INICIO_INVERSION . "</span>";
                    $row_f[$cont]['monto'] = "<span class='total'>" . number_format($monto_inicial, 2, ',', '.') . "</span>";
                    $suma_inversion += $monto_inicial;
                    $cont++;

                    if (isset($inversiones)) {
                        foreach ($inversiones as $f) {
                            $row_f[$cont]['id'] = $f['id'];
                            $row_f[$cont]['proveedor'] = $f['proveedor'];
                            $row_f[$cont]['documento'] = $f['documento'];
                            $row_f[$cont]['fecha'] = $f['fecha'];
                            $row_f[$cont]['monto'] = number_format($f['monto'], 2, ',', '.');
                            $suma_valor += $f['monto'];
                            $cont++;
                        }
                    }
                    $row_f[$cont]['id'] = $cont + 999; //para que lo agregue al final
                    $row_f[$cont]['proveedor'] = "<span class='total'>" . TOTAL_UTILIZADO_INVERSION . "</span>";
                    $saldo = $monto_inicial - $suma_valor;
                    $suma_final_valor += $suma_valor;
                    $suma_final_saldo += $saldo;
                    $row_f[$cont]['documento'] = "<span class='total'>" . number_format($suma_valor, 2, ',', '.') . "</span>";
                    $row_f[$cont]['fecha'] = "<span class='total'>" . SALDO_INVERSION . "</span>";
                    $row_f[$cont]['monto'] = "<span class='total'>" . number_format($saldo, 2, ',', '.') . "</span>";

                    $dt->setDataRows($row_f);
                    $dt->setTitleRow($titulos);

                    $dt->writeDataTable($nivel);
                }
            }
        }
        //-------------------  Resumen por rubro ---------
        $rubros = $invData->getCuadroResumen($operador);
        if (isset($rubros)) {
            $form = new CHtmlForm();
            $dt->setTitleTable(INVERSION_CUADRO_RESUMEN);
            $form->setId('frm_resumen_cuadro');
            $form->setMethod('post');
            $form->setClassEtiquetas('td_label');

            $titulos = array(INVERSION_ACTIVIDAD,
                INVERSION_VALOR_ACTIVIDAD,
                INVERSION_VALOR_EJECUTADO,
                INVERSION_VALOR_POR_EJECUTAR,
                INVERSION_PORC_EJECUTADO,
                INVERSION_PORC_POR_EJECUTAR);
            $cont = 0;
            $row_f = null;
            $suma_valor = 0;
            $cont++;

            if (isset($rubros)) {
                foreach ($rubros as $f) {
                    $row_f[$cont]['id'] = $f['id'];
                    $row_f[$cont]['rubro'] = $f['rubro'];
                    $row_f[$cont]['vigente'] = number_format($f['vigente'], 2, ',', '.');
                    $row_f[$cont]['acumulado'] = number_format($f['acumulado'], 2, ',', '.');
                    $row_f[$cont]['diferencia'] = number_format($f['diferencia'], 2, ',', '.');
                    $row_f[$cont]['por_acumulado'] = number_format($f['por_acumulado'], 2, ',', '.');
                    $row_f[$cont]['por_diferencia'] = number_format($f['por_diferencia'], 2, ',', '.');
                    $cont++;
                }
            }
            $dt->setTitleTable(INVERSION_CUADRO_RESUMEN);
            $dt->setDataRows($row_f);
            $dt->setTitleRow($titulos);
            $dt->writeDataTable($nivel);
        }
        // --------------------  Total  -----------------------
        $dt = new CHtmlDataTable();
        $dt->setTitleTable(strtoupper(TOTAL_EJECUCION));
        $dt->setType(1);

        $titulos = array('', '', '', '', '', '', '', '', '', '');
        $cont = 0;
        $row_f = null;
        $row_f[0]['id'] = $cont + 1000; //para que lo agregue al final
        $row_f[0]['referencia1'] = "" . TOTAL_PLAN_INVERSION . "";
        $row_f[0]['monto1'] = "<span class='total'>" . number_format($suma_inversion, 2, ',', '.') . "</span>";
        $row_f[0]['referencia2'] = "" . TOTAL_UTILIZADO_INVERSION . "";
        $row_f[0]['monto2'] = "<span class='total'>" . number_format($suma_final_valor, 2, ',', '.') . "</span>";
        $row_f[0]['referencia3'] = "% " . TOTAL_UTILIZADO_INVERSION . "";
        $row_f[0]['monto3'] = "<span class='total'>" . number_format($suma_final_valor / $suma_inversion * 100, 2, ',', '.') . "%</span>";
        $row_f[0]['referencia4'] = "" . SALDO_INVERSION . "";
        $row_f[0]['monto4'] = "<span class='total'>" . number_format($suma_final_saldo, 2, ',', '.') . "</span>";
        $row_f[0]['referencia5'] = "% " . SALDO_INVERSION . "";
        $row_f[0]['monto5'] = "<span class='total'>" . number_format($suma_final_saldo / $suma_inversion * 100, 2, ',', '.') . "%</span>";
        $dt->setDataRows($row_f);
        $dt->setTitleRow($titulos);

        $dt->writeDataTable($nivel);
        if (isset($rubros))
            $html->generaChartLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=chartInversion&operador=" . $operador);
        break;
    case 'chartInversion':

        $rubros = $invData->getCuadroResumen($operador);
        $chart = new PieChart(600, 300);

        $chart->addPoint(new Point($rubros[0]['rubro'] . ' ($' . number_format($rubros[0]['acumulado'], 2, ',', '.') . ')', number_format($rubros[0]['por_acumulado'], 2, ',', '.')));
        $chart->addPoint(new Point($rubros[1]['rubro'] . ' ($' . number_format($rubros[1]['acumulado'], 2, ',', '.') . ')', number_format($rubros[1]['por_acumulado'], 2, ',', '.')));
        $chart->addPoint(new Point($rubros[2]['rubro'] . ' ($' . number_format($rubros[2]['acumulado'], 2, ',', '.') . ')', number_format($rubros[2]['por_acumulado'], 2, ',', '.')));
        //$chart->addPoint(new Point($rubros[3]['rubro'],number_format($rubros[3]['por_acumulado'],2,',','.')));

        $chart->setTitle(TABLA_INVERSION . ' - ' . $Ooperador->getContratoNo());
        $chart->render(TABLA_INVERSION . $Ooperador->getContratoNo() . '.png');

        $html->generaImagen(TABLA_INVERSION, TABLA_INVERSION . $Ooperador->getContratoNo() . '.png', 'chart', 600, 300);

        break;
    // ----------------           Actividades del plan de inversion    --------------------------------------------
    case 'listRubro':
        $criterio = " ope_id=" . $operador;

        $rubros = $rubData->getRubros($criterio, 'rub_nombre');
        for ($d = 0; $d < count($rubros); $d++) {
            $rubros[$d]['monto'] = number_format($rubros[$d]['monto'], 2, ',', '.');
        }
        $dt = new CHtmlDataTable();
        $titulos = array(RUBRO_NOMBRE, RUBRO_MONTO);
        $dt->setDataRows($rubros);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_RUBROS . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editRubro" . "&operador=" . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteRubro" . "&operador=" . $operador);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addRubro" . "&operador=" . $operador);

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addRubro':
        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_RUBRO);

        $form->setId('frm_add_rubro');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(RUBRO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_RUBRO_NOMBRE);

        $form->addEtiqueta(RUBRO_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_RUBRO_MONTO);

        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_rubro();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_rubro\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubro&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveAddRubro':
        $nombre = $_POST['txt_nombre'];
        $monto = $_POST['txt_monto'];

        $rubro = new CRubro($id, $nombre, $monto, $rubData);
        $rubro->setOperador($operador);

        $m = $rubro->saveNewRubro();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubro&operador=' . $operador);

        break;

    case 'editRubro':
        $id_edit = $_REQUEST['id_element'];
        $rubro = new CRubro($id_edit, '', '', $rubData);
        $rubro->loadRubro();

        if (!isset($_POST['txt_nombre']))
            $nombre = $rubro->getNombre();
        else
            $nombre = $_REQUEST['txt_nombre'];
        if (!isset($_POST['txt_monto']))
            $monto = $rubro->getMonto();
        else
            $monto = $_REQUEST['txt_monto'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_RUBRO);

        $form->setId('frm_edit_rubro');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addEtiqueta(RUBRO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_RUBRO_NOMBRE);

        $form->addEtiqueta(RUBRO_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_RUBRO_MONTO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_rubro();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_rubro\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubro&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveEditRubro':
        $id_edit = $_POST['txt_id'];

        $nombre = $_POST['txt_nombre'];
        $monto = $_POST['txt_monto'];

        $rubro = new CRubro($id_edit, $nombre, $monto, $rubData);

        $m = $rubro->saveEditRubro();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubro&operador=' . $operador);

        break;

    case 'deleteRubro':
        $id_delete = $_REQUEST['id_element'];
        $rubro = new CRubro($id_delete, '', '', $rubData);
        $rubro->loadRubro();

        $form = new CHtmlForm();
        $form->setId('frm_delete_rubro');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $rubro->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->writeForm();

        echo $html->generaAdvertencia(RUBRO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteRubro&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_rubro','?mod=" . $modulo . "&niv=" . $nivel . "&task=listRubro&operador=" . $operador . "')");
        break;

    case 'confirmDeleteRubro':
        $id_edit = $_REQUEST['id_element'];
        $rubro = new CRubro($id_edit, '', '', $rubData);
        $rubro->loadRubro();

        $m = $rubro->deleteRubro();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubro&operador=' . $operador);

        break;
    // ----------------           Actividades del plan de compras    --------------------------------------------
    case 'listRubroOP':
        $criterio = "1";

        $rubros = $rubData->getRubrosOP($operador, $criterio, 'rub_nombre');
        for ($d = 0; $d < count($rubros); $d++) {
            $rubros[$d]['monto'] = number_format($rubros[$d]['monto'], 2, ',', '.');
        }
        $dt = new CHtmlDataTable();
        $titulos = array(RUBRO_NOMBRE, RUBRO_MONTO);
        $dt->setDataRows($rubros);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_RUBROS_OP . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editRubroOP" . "&operador=" . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteRubroOP" . "&operador=" . $operador);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addRubroOP" . "&operador=" . $operador);

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addRubroOP':
        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_RUBRO);

        $form->setId('frm_add_rubro');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(RUBRO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_RUBRO_NOMBRE);

        $form->addEtiqueta(RUBRO_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_RUBRO_MONTO);

        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_rubro_OP();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_rubro\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubroOP&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveAddRubroOP':
        $nombre = $_POST['txt_nombre'];
        $monto = $_POST['txt_monto'];

        $rubro = new CRubro($id, $nombre, $monto, $rubData);

        $m = $rubro->saveNewRubroOP($operador);

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubroOP&operador=' . $operador);

        break;

    case 'editRubroOP':
        $id_edit = $_REQUEST['id_element'];
        $rubro = new CRubro($id_edit, '', '', $rubData);
        $rubro->loadRubroOP();

        if (!isset($_POST['txt_nombre']))
            $nombre = $rubro->getNombre();
        else
            $nombre = $_REQUEST['txt_nombre'];
        if (!isset($_POST['txt_monto']))
            $monto = $rubro->getMonto();
        else
            $monto = $_REQUEST['txt_monto'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_RUBRO);

        $form->setId('frm_edit_rubro');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');

        $form->addEtiqueta(RUBRO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_RUBRO_NOMBRE);

        $form->addEtiqueta(RUBRO_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_RUBRO_MONTO);

        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_rubro_OP();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_rubro\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubroOP&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveEditRubroOP':
        $id_edit = $_POST['txt_id'];

        $nombre = $_POST['txt_nombre'];
        $monto = $_POST['txt_monto'];

        $rubro = new CRubro($id_edit, $nombre, $monto, $rubData);

        $m = $rubro->saveEditRubroOP();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubroOP&operador=' . $operador);

        break;

    case 'deleteRubroOP':
        $id_delete = $_REQUEST['id_element'];
        $rubro = new CRubro($id_delete, '', '', $rubData);
        $rubro->loadRubroOP();

        $form = new CHtmlForm();
        $form->setId('frm_delete_rubro');
        $form->setMethod('post');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $rubro->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->writeForm();

        echo $html->generaAdvertencia(RUBRO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteRubroOP&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_rubro','?mod=" . $modulo . "&niv=" . $nivel . "&task=listRubroOP&operador=" . $operador . "')");
        break;

    case 'confirmDeleteRubroOP':
        $id_edit = $_REQUEST['id_element'];
        $rubro = new CRubro($id_edit, '', '', $rubData);
        $rubro->loadRubroOP();

        $m = $rubro->deleteRubroOP();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listRubroOP&operador=' . $operador);

        break;
    // ----------------           Conceptos del Plan de Inversion   --------------------------------------------
    case 'listConcepto':
        $criterio = "1";

        $conceptos = $cncData->getConceptos($criterio, 'cnc_nombre');

        $dt = new CHtmlDataTable();
        $titulos = array(CONCEPTO_NOMBRE);
        $dt->setDataRows($conceptos);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_CONCEPTOS . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editConcepto");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteConcepto");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addConcepto");

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addConcepto':
        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_CONCEPTO);

        $form->setId('frm_add_concepto');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(CONCEPTO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_CONCEPTO_NOMBRE);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_concepto();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_concepto\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listConcepto\');"');

        $form->writeForm();
        break;

    case 'saveAddConcepto':
        $nombre = $_POST['txt_nombre'];

        $concepto = new CConcepto($id, $nombre, $cncData);

        $m = $concepto->saveNewConcepto();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listConcepto');

        break;

    case 'editConcepto':
        $id_edit = $_REQUEST['id_element'];
        $concepto = new CConcepto($id_edit, '', $cncData);
        $concepto->loadConcepto();

        if (!isset($_POST['txt_nombre']))
            $nombre = $concepto->getNombre();
        else
            $nombre = $_REQUEST['txt_nombre'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_CONCEPTO);

        $form->setId('frm_edit_concepto');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');

        $form->addEtiqueta(CONCEPTO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_CONCEPTO_NOMBRE);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_concepto();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_concepto\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listConcepto\');"');

        $form->writeForm();
        break;

    case 'saveEditConcepto':
        $id_edit = $_POST['txt_id'];

        $nombre = $_POST['txt_nombre'];

        $concepto = new CConcepto($id_edit, $nombre, $cncData);

        $m = $concepto->saveEditConcepto();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listConcepto');

        break;

    case 'deleteConcepto':
        $id_delete = $_REQUEST['id_element'];
        $concepto = new CConcepto($id_delete, '', $cncData);
        $concepto->loadConcepto();

        $form = new CHtmlForm();
        $form->setId('frm_delete_concepto');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $concepto->getId(), '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(CONCEPTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteConcepto&id_element=' . $id_delete, "cancelarAccion('frm_delete_concepto','?mod=" . $modulo . "&niv=" . $nivel . "&task=listConcepto')");
        break;

    case 'confirmDeleteConcepto':
        $id_edit = $_REQUEST['id_element'];
        $concepto = new CConcepto($id_edit, '', $cncData);
        $concepto->loadConcepto();

        $m = $concepto->deleteConcepto();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listConcepto');

        break;
    // ----------------           Conceptos  del Plan de Compras  --------------------------------------------
    case 'listConceptoOP':
        $criterio = "1";

        $conceptos = $cncData->getConceptosOP($operador, $criterio, 'cnc_nombre');

        $dt = new CHtmlDataTable();
        $titulos = array(CONCEPTO_NOMBRE);
        $dt->setDataRows($conceptos);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_CONCEPTOS_OP . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editConceptoOP" . "&operador=" . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteConceptoOP" . "&operador=" . $operador);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addConceptoOP" . "&operador=" . $operador);

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addConceptoOP':
        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_CONCEPTO);

        $form->setId('frm_add_concepto');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(CONCEPTO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_CONCEPTO_NOMBRE);

        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_concepto_OP();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_concepto\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listConceptoOP&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveAddConceptoOP':
        $nombre = $_POST['txt_nombre'];

        $concepto = new CConcepto($id, $nombre, $cncData);

        $m = $concepto->saveNewConceptoOP($operador);

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listConceptoOP&operador=' . $operador);

        break;

    case 'editConceptoOP':
        $id_edit = $_REQUEST['id_element'];
        $concepto = new CConcepto($id_edit, '', $cncData);
        $concepto->loadConceptoOP();

        if (!isset($_POST['txt_nombre']))
            $nombre = $concepto->getNombre();
        else
            $nombre = $_REQUEST['txt_nombre'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_CONCEPTO);

        $form->setId('frm_edit_concepto');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');

        $form->addEtiqueta(CONCEPTO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_CONCEPTO_NOMBRE);

        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_concepto_OP();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_concepto\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listConceptoOP&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveEditConceptoOP':
        $id_edit = $_POST['txt_id'];

        $nombre = $_POST['txt_nombre'];

        $concepto = new CConcepto($id_edit, $nombre, $cncData);

        $m = $concepto->saveEditConceptoOP();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listConceptoOP&operador=' . $operador);

        break;

    case 'deleteConceptoOP':
        $id_delete = $_REQUEST['id_element'];
        $concepto = new CConcepto($id_delete, '', $cncData);
        $concepto->loadConceptoOP();

        $form = new CHtmlForm();
        $form->setId('frm_delete_concepto');
        $form->setMethod('post');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $concepto->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->writeForm();

        echo $html->generaAdvertencia(CONCEPTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteConceptoOP&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_concepto','?mod=" . $modulo . "&niv=" . $nivel . "&task=listConceptoOP&operador=" . $operador . "')");
        break;

    case 'confirmDeleteConceptoOP':
        $id_edit = $_REQUEST['id_element'];
        $concepto = new CConcepto($id_edit, '', $cncData);
        $concepto->loadConceptoOP();

        $m = $concepto->deleteConceptoOP();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listConceptoOP&operador=' . $operador);

        break;
    // ----------------           Modalidades  del Plan de Compras  --------------------------------------------
    case 'listModalidadOP':
        $criterio = "1";

        $modalidades = $modData->getModalidadesOP($operador, $criterio, 'mod_nombre');

        $dt = new CHtmlDataTable();
        $titulos = array(MODALIDAD_NOMBRE);
        $dt->setDataRows($modalidades);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_MODALIDAD_OP . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editModalidadOP" . "&operador=" . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteModalidadOP" . "&operador=" . $operador);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addModalidadOP" . "&operador=" . $operador);

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addModalidadOP':
        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_MODALIDAD);

        $form->setId('frm_add_modalidad');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(MODALIDAD_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_MODALIDAD_NOMBRE);

        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_modalidad_OP();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_modalidad\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listModalidadOP&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveAddModalidadOP':
        $nombre = $_POST['txt_nombre'];

        $modalidad = new CModalidad($id, $nombre, $modData);

        $m = $modalidad->saveNewModalidadOP($operador);

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listModalidadOP&operador=' . $operador);

        break;

    case 'editModalidadOP':
        $id_edit = $_REQUEST['id_element'];
        $modalidad = new CModalidad($id_edit, '', $modData);
        $modalidad->loadModalidadOP();

        if (!isset($_POST['txt_nombre']))
            $nombre = $modalidad->getNombre();
        else
            $nombre = $_REQUEST['txt_nombre'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_MODALIDAD);

        $form->setId('frm_edit_modalidad');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');

        $form->addEtiqueta(MODALIDAD_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '50', '50', $nombre, '', 'onChange="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_MODALIDAD_NOMBRE);

        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_modalidad_OP();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_modalidad\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listModalidadOP&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveEditModalidadOP':
        $id_edit = $_POST['txt_id'];

        $nombre = $_POST['txt_nombre'];

        $modalidad = new CModalidad($id_edit, $nombre, $modData);

        $m = $modalidad->saveEditModalidadOP();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listModalidadOP&operador=' . $operador);

        break;

    case 'deleteModalidadOP':
        $id_delete = $_REQUEST['id_element'];
        $modalidad = new CModalidad($id_delete, '', $modData);
        $modalidad->loadModalidadOP();

        $form = new CHtmlForm();
        $form->setId('frm_delete_modalidad');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $modalidad->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(MODALIDAD_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteModalidadOP&id_element=' . $id_delete . "&operador=" . $operador, "cancelarAccion('frm_delete_modalidad','?mod=" . $modulo . "&niv=" . $nivel . "&task=listModalidadOP&operador=" . $operador . "')");
        break;

    case 'confirmDeleteModalidadOP':
        $id_edit = $_REQUEST['id_element'];
        $modalidad = new CModalidad($id_edit, '', $modData);
        $modalidad->loadModalidadOP();

        $m = $modalidad->deleteModalidadOP();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listModalidadOP&operador=' . $operador);

        break;
    // ----------------           Extractos    --------------------------------------------
    case 'listExtracto':
        $criterio = " ope_id=" . $operador;

        $extractos = $extData->getExtractos($criterio, 'ext_anio', $Ooperador->getSiglas());

        for ($d = 0; $d < count($extractos); $d++) {
            $extractos[$d]['monto'] = number_format($extractos[$d]['monto'], 2, ',', '.');
        }

        $dt = new CHtmlDataTable();
        $titulos = array(EXTRACTO_ANIO, EXTRACTO_MES, EXTRACTO_MONTO, EXTRACTO_DOCUMENTO);
        $dt->setDataRows($extractos);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_EXTRACTOS . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editExtracto" . "&operador=" . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteExtracto" . "&operador=" . $operador);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addExtracto" . "&operador=" . $operador);

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addExtracto':
        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_EXTRACTO);

        $form->setId('frm_add_extracto');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(EXTRACTO_ANIO);
        $form->addInputText('text', 'txt_anio', 'txt_anio', '4', '4', $anio, '', 'onChange="ocultarDiv(\'error_anio\');"');
        $form->addError('error_anio', ERROR_EXTRACTO_ANIO);

        $form->addEtiqueta(EXTRACTO_MES);
        $form->addInputText('text', 'txt_mes', 'txt_mes', '2', '2', $mes, '', 'onChange="ocultarDiv(\'error_mes\');"');
        $form->addError('error_mes', ERROR_EXTRACTO_MES);

        $form->addEtiqueta(EXTRACTO_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_EXTRACTO_MONTO);

        $form->addEtiqueta(EJECUCION_DOCUMENTO);
        $form->addInputFile('file', 'file_documento', 'file_documento', '50', 'file', 'onChange="ocultarDiv(\'error_documento\');"');
        $form->addError('error_documento', EJECUCION_DOCUMENTO);

        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_extracto();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_extracto\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listExtracto&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveAddExtracto':
        $anio = $_POST['txt_anio'];
        $mes = $_POST['txt_mes'];
        $monto = $_POST['txt_monto'];
        $documento = $_FILES['file_documento'];

        $extracto = new CExtracto($id, $anio, $mes, $monto, '', $extData);
        $extracto->setOperador($operador);

        $m = $extracto->saveNewExtracto($documento, $Ooperador->getSiglas());

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listExtracto&operador=' . $operador);

        break;

    case 'editExtracto':
        $id_edit = $_REQUEST['id_element'];
        $extracto = new CExtracto($id_edit, '', '', '', '', $extData);
        $extracto->loadExtracto();

        if (!isset($_POST['txt_anio']))
            $anio = $extracto->getAnio();
        else
            $anio = $_REQUEST['txt_anio'];
        if (!isset($_POST['txt_mes']))
            $mes = $extracto->getMes();
        else
            $mes = $_REQUEST['txt_mes'];
        if (!isset($_POST['txt_monto']))
            $monto = $extracto->getMonto();
        else
            $monto = $_REQUEST['txt_monto'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_EXTRACTO);

        $form->setId('frm_edit_extracto');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addEtiqueta(EXTRACTO_ANIO);
        $form->addInputText('text', 'txt_anio', 'txt_anio', '50', '50', $anio, '', 'onChange="ocultarDiv(\'error_anio\');"');
        $form->addError('error_anio', ERROR_EXTRACTO_ANIO);

        $form->addEtiqueta(EXTRACTO_MES);
        $form->addInputText('text', 'txt_mes', 'txt_mes', '2', '2', $mes, '', 'onChange="ocultarDiv(\'error_mes\');"');
        $form->addError('error_mes', ERROR_EXTRACTO_MES);

        $form->addEtiqueta(EXTRACTO_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_EXTRACTO_MONTO);

        $form->addEtiqueta(EJECUCION_DOCUMENTO);
        $form->addInputFile('file', 'file_documento', 'file_documento', '50', 'file', 'onChange="ocultarDiv(\'error_documento\');"');
        $form->addError('error_documento', EJECUCION_DOCUMENTO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_extracto();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_extracto\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listExtracto&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveEditExtracto':
        $id_edit = $_POST['txt_id'];

        $anio = $_POST['txt_anio'];
        $mes = $_POST['txt_mes'];
        $monto = $_POST['txt_monto'];
        $documento = $_FILES['file_documento'];

        $extracto = new CExtracto($id_edit, $anio, $mes, $monto, $documento, $extData);
        $m = $extracto->saveEditExtracto($documento, $Ooperador->getSiglas());

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listExtracto&operador=' . $operador);

        break;

    case 'deleteExtracto':
        $id_delete = $_REQUEST['id_element'];
        $extracto = new CExtracto($id_delete, '', '', '', '', $extData);
        $extracto->loadExtracto();

        $form = new CHtmlForm();
        $form->setId('frm_delete_extracto');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $extracto->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(EXTRACTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteExtracto&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_extracto','?mod=" . $modulo . "&niv=" . $nivel . "&task=listExtracto&operador=" . $operador . "')");
        break;

    case 'confirmDeleteExtracto':
        $id_delete = $_REQUEST['id_element'];
        $extracto = new CExtracto($id_delete, '', '', '', '', $extData);
        $extracto->loadExtracto();

        $m = $extracto->deleteExtracto();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listExtracto&operador=' . $operador);

        break;

    // ----------------           Informe Conciliacion    --------------------------------------------
    case 'listConciliacion':

        $year = $_POST['sel_year'];
        $month = $_POST['sel_month'];
        $concepto = $_POST['sel_concepto'];

        $criterio = " f.ope_id=" . $operador;

        if (isset($year) && $year != -1) {
            $criterio = $criterio . " and  year(cnl_fecha) = " . $year . " ";
            if (isset($month) && $month != -1)
                $criterio .= " and month(cnl_fecha) = " . $month . " ";
        }
        if (isset($concepto) && $concepto != -1)
            $criterio .= " and f.cnc_id = " . $concepto . " ";
        $form = new CHtmlForm();
        $form->setTitle(RESUMEN_EJECUTIVO_CONCILIACION);

        $form->setId('frm_resumen_conciliacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');


        $years = $cnlData->getYearsConciliacion($operador);
        $opciones = null;
        if (isset($years)) {
            foreach ($years as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(EJECUCION_YEAR);
        $form->addSelect('select', 'sel_year', 'sel_year', $opciones, CONCILIACION_YEAR, $year, '', 'onChange=document.getElementById(\'sel_month\').value=-1;submit();');
        $form->addError('error_year', '');

        $months = $cnlData->getMonthsConciliacion($year, $operador);
        $opciones = null;
        if (isset($months)) {
            foreach ($months as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $meses[$t['nombre'] - 1]);
            }
        }
        $form->addEtiqueta(EJECUCION_MONTH);
        $form->addSelect('select', 'sel_month', 'sel_month', $opciones, EJECUCION_MONTH, $month, '', 'onChange=submit();');
        $form->addError('error_month', '');

        $conceptos = $cnlData->getConceptos(' ope_id =' . $operador, 'cnc_nombre');
        $opciones = null;
        if (isset($conceptos)) {
            foreach ($conceptos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(EJECUCION_CONCEPTO);
        $form->addSelect('select', 'sel_concepto', 'sel_concepto', $opciones, EJECUCION_CONCEPTO, $concepto, '', 'onChange=submit();');
        $form->addError('error_concepto', '');
        $form->writeForm();

        //echo ("<br>criterio:".$criterio);

        $dt = new CHtmlDataTable();
        $dt->setTitleTable(TABLA_CONTRATO . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        $dt->setType(2);

        $dt->writeDataTable($nivel);

        $conciliaciones = $cnlData->getResumenConciliacion($criterio);
        for ($d = 0; $d < count($conciliaciones); $d++) {
            $conciliaciones[$d]['monto'] = number_format($conciliaciones[$d]['monto'], 2, ',', '.');
        }
        $dt = new CHtmlDataTable();
        $titulos = array(CONCILIACION_CONCEPTO, CONCILIACION_FECHA, CONCILIACION_MONTO, CONCILIACION_OBSERVACIONES);
        $dt->setDataRows($conciliaciones);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_CONCILIACION . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editConciliacion" . "&operador=" . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteConciliacion" . "&operador=" . $operador);

        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addConciliacion" . "&operador=" . $operador);

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addConciliacion':

        $rubro = $_POST['sel_concepto'];
        $fecha = $_POST['txt_fecha'];
        $proveedor = $_POST['txt_proveedor'];
        $documento_proveedor = $_POST['txt_documento_proveedor'];
        $monto = $_POST['txt_monto'];
        $observaciones = $_POST['txt_observaciones'];

        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_CONCILIACION);

        $form->setId('frm_add_conciliacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_anio', 'txt_anio', '50', '50', $contrato['id'], '', '');
        $form->addInputText('hidden', 'txt_monto_contrato', 'txt_monto_contrato', '30', '30', $contrato['monto'], '', '');
        $form->addInputText('hidden', 'operador', 'operador', '30', '30', $operador, '', '');

        $rubros = $cnlData->getConceptos(' ope_id=' . $operador, 'cnc_nombre');
        $opciones = null;
        if (isset($rubros)) {
            foreach ($rubros as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form->addEtiqueta(CONCILIACION_CONCEPTO);
        $form->addSelect('select', 'sel_concepto', 'sel_concepto', $opciones, CONCILIACION_CONCEPTO, $rubro, '', 'onChange=submit();');
        $form->addError('error_rubro', ERROR_CONCILIACION_CONCEPTO);

        $form->addEtiqueta(CONCILIACION_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_CONCILIACION_FECHA);

        $form->addEtiqueta(CONCILIACION_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_CONCILIACION_MONTO);

        $form->addEtiqueta(CONCILIACION_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '50', '5', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observacion\');"');
        $form->addError('error_observacion', ERROR_CONCILIACION_OBSERVACIONES);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_conciliacion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_conciliacion\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listConciliacion&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveAddConciliacion':

        $concepto = $_POST['sel_concepto'];
        $fecha = $_POST['txt_fecha'];
        $monto = $_POST['txt_monto'];
        $observaciones = $_POST['txt_observaciones'];

        $conciliacion = new CConciliacion($id, $concepto, $fecha, $monto, $observaciones, $cnlData);
        $conciliacion->setOperador($operador);

        $m = $conciliacion->saveNewConciliacion();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listConciliacion&operador=' . $operador);

        break;

    case 'editConciliacion':
        $id_edit = $_REQUEST['id_element'];
        $conciliacion = new CConciliacion($id_edit, '', '', '', '', $cnlData);
        $conciliacion->loadConciliacion();



        if (!isset($_POST['sel_concepto']))
            $concepto = $conciliacion->getConcepto();
        else
            $concepto = $_REQUEST['sel_concepto'];
        if (!isset($_POST['txt_fecha']))
            $fecha = $conciliacion->getFecha();
        else
            $fecha = $_REQUEST['txt_fecha'];
        if (!isset($_POST['txt_monto']))
            $monto = $conciliacion->getMonto();
        else
            $monto = $_REQUEST['txt_monto'];
        if (!isset($_POST['txt_observaciones']))
            $observaciones = $conciliacion->getObservaciones();
        else
            $observaciones = $_REQUEST['txt_observaciones'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_CONCILIACION);

        $form->setId('frm_edit_conciliacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_anio', 'txt_anio', '15', '15', $contrato['id'], '', '');
        $form->addInputText('hidden', 'txt_monto_contrato', 'txt_monto_contrato', '30', '30', $contrato['monto'], '', '');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $rubros = $cnlData->getConceptos(' ope_id=' . $operador, 'cnc_nombre');
        $opciones = null;
        if (isset($rubros)) {
            foreach ($rubros as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form->addEtiqueta(CONCILIACION_CONCEPTO);
        $form->addSelect('select', 'sel_concepto', 'sel_concepto', $opciones, CONCILIACION_CONCEPTO, $concepto, '', 'onChange=submit();');
        $form->addError('error_concepto', ERROR_CONCILIACION_CONCEPTO);

        $form->addEtiqueta(CONCILIACION_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_CONCILIACION_FECHA);

        $form->addEtiqueta(CONCILIACION_MONTO);
        $form->addInputText('text', 'txt_monto', 'txt_monto', '20', '20', $monto, '', 'onChange="ocultarDiv(\'error_monto\');"');
        $form->addError('error_monto', ERROR_CONCILIACION_MONTO);

        $form->addEtiqueta(CONCILIACION_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '50', '5', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observacion\');"');
        $form->addError('error_observacion', ERROR_CONCILIACION_OBSERVACIONES);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_conciliacion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_conciliacion\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listConciliacion&operador=' . $operador . '\');"');

        $form->writeForm();
        break;


    case 'saveEditConciliacion':
        $id_edit = $_POST['txt_id'];


        $concepto = $_POST['sel_concepto'];
        $fecha = $_POST['txt_fecha'];
        $monto = $_POST['txt_monto'];
        $observaciones = $_POST['txt_observaciones'];

        $conciliacion = new CConciliacion($id_edit, $concepto, $fecha, $monto, $observaciones, $cnlData);

        $m = $conciliacion->saveEditConciliacion();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listConciliacion&operador=' . $operador);

        break;

    case 'deleteConciliacion':
        $id_delete = $_REQUEST['id_element'];
        $conciliacion = new CConciliacion($id_delete, '', '', '', '', $cnlData);
        $conciliacion->loadConciliacion();

        $form = new CHtmlForm();
        $form->setId('frm_delete_conciliacion');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $conciliacion->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(CONCILIACION_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteConciliacion&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_conciliacion','?mod=" . $modulo . "&niv=" . $nivel . "&task=listConciliacion&operador=" . $operador . "')");
        break;

    case 'confirmDeleteConciliacion':
        $id_delete = $_REQUEST['id_element'];
        $conciliacion = new CConciliacion($id_delete, '', '', '', '', $cnlData);
        $conciliacion->loadConciliacion();

        $m = $conciliacion->deleteConciliacion();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listConciliacion&operador=' . $operador);

        break;

    case 'resumenConciliacion':

        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        $fecha_fin = $_REQUEST['txt_fecha_fin'];

        $criterio = "f.ope_id=" . $operador;
        $criterio_fac = "";

        if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
            if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (f.cnl_fecha >= '" . $fecha_inicio . "')";
                    $criterio_fac = " (f.fac_fecha >= '" . $fecha_inicio . "')";
                } else {
                    $criterio .= " and f.cnl_fecha >= '" . $fecha_inicio . "'";
                    $criterio_fac .= " and f.fac_fecha >= '" . $fecha_inicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = "( f.cnl_fecha between '" . $fecha_inicio . "' and '" . $fecha_fin . "')";
                    $criterio_fac = "( f.fac_fecha between '" . $fecha_inicio . "' and '" . $fecha_fin . "')";
                    $year = date("Y", strtotime($fecha_fin));
                    $month = date("m", strtotime($fecha_fin));
                } else {
                    $criterio .= " and f.cnl_fecha between '" . $fecha_inicio . "' and '" . $fecha_fin . "')";
                    $criterio_fac .= " and f.fac_fecha between '" . $fecha_inicio . "' and '" . $fecha_fin . "')";
                    $year = date("Y", strtotime($fecha_fin));
                    $month = date("m", strtotime($fecha_fin));
                }
            }
        }
        if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
            if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( cnl_fecha <= '" . $fecha_fin . "')";
                    $criterio_fac = "( fac_fecha <= '" . $fecha_fin . "')";
                } else {
                    $criterio .= " cnl_fecha <= '" . $fecha_fin . "')";
                    $criterio_fac .= " fac_fecha <= '" . $fecha_fin . "')";
                }
            }
        }
        //echo ("<br>criterio:".$criterio);
        $form = new CHtmlForm();
        $form->setTitle(RESUMEN_CONCILIACION);

        $form->setId('frm_resumen_conciliacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');


        $form->addEtiqueta(CONCILIACION_FECHA_INICIAL);
        $form->addInputDate('date', 'ftxt_fecha_creacion', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', '');
        $form->addError('error_fecha_inicio', '');


        $form->addEtiqueta(CONCILIACION_FECHA_FINAL);
        $form->addInputDate('date', 'ftxt_fecha_radicacion', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', 'onChange=submit();');
        $form->addError('error_fecha_fin', '');
        $form->writeForm();

        $dt = new CHtmlDataTable();
        $dt->setTitleTable(TABLA_CONTRATO . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        $dt->setType(2);

        $dt->writeDataTable($nivel);

        $conceptos = $cnlData->getResumen($criterio);
        $dt = new CHtmlDataTable();
        $dt->setTitleTable($t['concepto']);
        $dt->setType(1);
        $titulos = array(CONCILIACION_CONCEPTO, CONCILIACION_MONTO);

        $cont = 0;
        $cont++;

        if (isset($conceptos)) {
            foreach ($conceptos as $t) {
                $row_f[$cont]['id'] = $t['id'];
                $row_f[$cont]['concepto'] = $t['concepto'];
                $row_f[$cont]['acumulado'] = number_format($t['acumulado'], 2, ',', '.');
                $cont++;
            }
        }

        $dt->setDataRows($row_f);
        $dt->setTitleRow($titulos);
        $dt->writeDataTable($nivel);

        $dt = new CHtmlDataTable();
        $dt->setTitleTable(strtoupper(TOTAL_EJECUCION));
        $dt->setType(1);

        $titulos = array('', '', '', '', '', '');
        $cont = 0;
        $row_f = null;

        if ($criterio != null) {
            $anticipo = $cnlData->getAnticipo('vir_anticipo="S" and ope_id=' . $operador, $criterio_fac);
            $extracto = $extData->getExtractosByMes($year, $month, $operador);
            $desembolso = $cnlData->getDesembolsos($year, $month, $operador);
            $utilizacion = $cnlData->getTotalConciliacion($year, $month, $operador);

            $row_f[0]['id'] = 1;
            $row_f[0]['referencia2'] = "" . ANTICIPO_CONCILIACION . "";
            $row_f[0]['monto2'] = "<span class='total'>" . number_format($anticipo['monto'], 2, ',', '.') . "</span>";

            $row_f[1]['id'] = 2;
            $row_f[1]['referencia2'] = "" . AMORTIZACION_CONCILIACION . "";
            $row_f[1]['monto2'] = "<span class='total'>" . number_format($anticipo['ejecutado'], 2, ',', '.') . "</span>";

            $row_f[2]['id'] = 3;
            $row_f[2]['referencia2'] = "" . ANTICIPO_PENDIENTE_CONCILIACION . "";
            $row_f[2]['monto2'] = "<span class='total'>" . number_format(($anticipo['monto'] - $anticipo['ejecutado']), 2, ',', '.') . "</span>";

            $row_f[3]['id'] = 4;
            $row_f[3]['referencia2'] = "" . SALDO_EXTRACTO . "";
            $row_f[3]['monto2'] = "<span class='total'>" . number_format($extracto['monto'], 2, ',', '.') . "</span>";

            $row_f[4]['id'] = 5;
            $row_f[4]['referencia2'] = "" . DESEMBOLSOS . "";
            $row_f[4]['monto2'] = "<span class='total'>" . number_format($desembolso, 2, ',', '.') . "</span>";

            $row_f[5]['id'] = 6;
            $row_f[5]['referencia2'] = "" . DIFERENCIA . "";
            $row_f[5]['monto2'] = "<span class='total'>" . number_format(($anticipo['monto'] - $anticipo['ejecutado']) - $extracto['monto'], 2, ',', '.') . "</span>";

            $dt->setDataRows($row_f);
            $dt->setTitleRow($titulos);

            $dt->setDataRows($row_f);
            $dt->setTitleRow($titulos);


            $dt->writeDataTable($nivel);
        }
        break;
    // ----------------           Desembolsos    --------------------------------------------

    case 'listDesembolso':
        // --------------------  Resumen  -----------------------
        $dt = new CHtmlDataTable();
        $dt->setTitleTable('Resumen Desembolsos ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        $dt->setType(1);

        $valor_contrato = $desData->getTotalVigencias('vigencia_recursos', 'vir_anio<>' . $anio_anticipo . ' and ope_id=' . $operador);
        $valor_desembolso = $desData->getTotalDesembolso('ope_id=' . $operador);
        $titulos = array('', '', '', '', '', '');
        $cont = 0;
        $row_f = null;
        $row_f[0]['id'] = $cont + 1000; //para que lo agregue al final
        $row_f[0]['referencia1'] = "Valor del Contrato";
        $row_f[0]['monto1'] = "<span class='total'>" . number_format($valor_contrato, 2, ',', '.') . "</span>";
        $row_f[0]['referencia2'] = "Total Desembolsos";
        $row_f[0]['monto2'] = "<span class='total'>" . number_format($valor_desembolso, 2, ',', '.') . "</span>";
        $row_f[0]['referencia3'] = "Saldo por Desembolsar";
        $diferencia = $valor_contrato - $valor_desembolso;
        $row_f[0]['monto3'] = "<span class='total'>" . number_format($diferencia, 2, ',', '.') . "</span>";

        $dt->setDataRows($row_f);
        $dt->setTitleRow($titulos);

        $dt->writeDataTable($nivel);   //datos para la tabla de Desembolso por contrato
        $desembolsos = $desData->getDesembolso(' ope_id=' . $operador, 'des_id');
        $dt = new CHtmlDataTable();
        $titulos = array(DESEMBOLSO_FECHA, DESEMBOLSO_CONDICION, DESEMBOLSO_PORCENTAJE, DESEMBOLSO_APROBADO, DESEMBOLSO_FECHACM,
            DESEMBOLSO_FECHATD, DESEMBOLSO_FECHAC, DESEMBOLSO_FECHALD, DESEMBOLSO_EFECTUADO, DESEMBOLSO_ACUMULADO);
        $dt->setDataRows($desembolsos);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_DESEMBOLSOS . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        //Comandos que crean vinculos para crear, editar y eliminar desembolso
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addDesembolso" . "&operador=" . $operador);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editDesembolso" . "&operador=" . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteDesembolso" . "&operador=" . $operador);
        $dt->setType(1);
        $dt->writeDataTable($nivel);

        break;

    case 'addDesembolso':

        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_DESEMBOLSO);

        $form->setId('frm_add_desembolso');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(DESEMBOLSO_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_DESEMBOLSO_FECHA);

        $form->addEtiqueta(DESEMBOLSO_CONDICION);
        $form->addTextArea('text', 'txt_condicion', 'txt_condicion', '30', '30', $condicion, '', 'onkeypress="ocultarDiv(\'error_condicion\');"');
        $form->addError('error_condicion', ERROR_DESEMBOLSO_CONDICION);

        $form->addEtiqueta(DESEMBOLSO_PORCENTAJE);
        $form->addInputText('text', 'txt_porcentaje', 'txt_porcentaje', '5', '5', $porcentaje, '', 'onChange="ocultarDiv(\'error_porcentaje\');"');
        $form->addError('error_porcentaje', ERROR_DESEMBOLSO_PORCENTAJE);

        $form->addEtiqueta(DESEMBOLSO_APROBADO);
        $form->addTextArea('text', 'txt_aprobado', 'txt_aprobado', '16', '16', $aprobado, '', 'onkeypress="ocultarDiv(\'error_aprobado\');"');
        $form->addError('error_aprobado', ERROR_DESEMBOLSO_APROBADO);

        $form->addEtiqueta(DESEMBOLSO_FECHACM);
        $form->addInputDate('date', 'txt_fechacm', 'txt_fechacm', $fecha_cumplimiento, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fechacm\');"');
        $form->addError('error_fechacm', ERROR_DESEMBOLSO_FECHACM);

        $form->addEtiqueta(DESEMBOLSO_FECHATD);
        $form->addInputDate('date', 'txt_fechatd', 'txt_fechatd', $fecha_tramite, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fechatd\');"');
        $form->addError('error_fechatd', ERROR_DESEMBOLSO_FECHATD);

        $form->addEtiqueta(DESEMBOLSO_FECHAC);
        $form->addInputDate('date', 'txt_fechac', 'txt_fechac', $fecha_certificacion, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fechac\');"');
        $form->addError('error_fechac', ERROR_DESEMBOLSO_FECHAC);

        $form->addEtiqueta(DESEMBOLSO_FECHALD);
        $form->addInputDate('date', 'txt_fechald', 'txt_fechald', $fecha_limite, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fechald\');"');
        $form->addError('error_fechald', ERROR_DESEMBOLSO_FECHALD);

        $form->addEtiqueta(DESEMBOLSO_EFECTUADO);
        $form->addTextArea('text', 'txt_efectuado', 'txt_efectuado', '16', '16', $efectuado, '', 'onkeypress="ocultarDiv(\'error_efectuado\');"');
        $form->addError('error_efectuado', ERROR_DESEMBOLSO_EFECTUADO);

        $valor_contrato = $desData->getTotalVigencias('vigencia1_recursos', 'vir_anio<>' . $anio_anticipo);
        $valor_desembolso = $desData->getTotalDesembolso('ope_id=' . $operador);
        $total_desembolso = $valor_desembolso + $efectuado;
        $form->addInputText('hidden', 'txt_valor_contrato', 'txt_valor_contrato', '20', '20', $valor_contrato, '', '');
        $form->addInputText('hidden', 'txt_total_desembolso', 'txt_total_desembolso', '20', '20', $total_desembolso, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '20', '20', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_desembolso();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_desembolso\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listDesembolso&operador=' . $operador . '\');"');

        $form->writeForm();

        break;

    case 'saveAddDesembolso':

        $fecha = $_POST['txt_fecha'];
        $condicion = $_POST['txt_condicion'];
        $porcentaje = $_POST['txt_porcentaje'];
        $aprobado = $_POST['txt_aprobado'];
        $fecha_cumplimiento = $_POST['txt_fechacm'];
        $fecha_tramite = $_POST['txt_fechatd'];
        $fecha_certificacion = $_POST['txt_fechac'];
        $fecha_limite = $_POST['txt_fechald'];
        $efectuado = $_POST['txt_efectuado'];

        $desembolso = new CDesembolso($id, $operador, $fecha, $condicion, $porcentaje, $aprobado, $fecha_cumplimiento, $fecha_tramite, $fecha_certificacion, $fecha_limite, $efectuado, $desData);

        $m = $desembolso->saveNewDesembolso();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listDesembolso&operador=' . $operador);

        break;

    case 'editDesembolso':

        $id_edit = $_REQUEST['id_element'];
        $desembolso = new CDesembolso($id_edit, $operador, '', '', '', '', '', '', '', '', '', $desData);
        $desembolso->loadDesembolso();

        if (!isset($_POST['txt_fecha']))
            $fecha = $desembolso->getFecha();
        else
            $fecha = $_REQUEST['txt_fecha'];
        if (!isset($_POST['txt_condicion']))
            $condicion = $desembolso->getCondicion();
        else
            $condicion = $_REQUEST['txt_condicion'];
        if (!isset($_POST['txt_porcentaje']))
            $porcentaje = $desembolso->getPorcentaje();
        else
            $porcentaje = $_REQUEST['txt_porcentaje'];
        if (!isset($_POST['txt_aprobado']))
            $aprobado = $desembolso->getAprobado();
        else
            $aprobado = $_REQUEST['txt_aprobado'];
        if (!isset($_POST['txt_fechacm']))
            $fecha_cumplimiento = $desembolso->getFechaCumplimiento();
        else
            $fecha_cumplimiento = $_REQUEST['txt_fechacm'];
        if (!isset($_POST['txt_fechatd']))
            $fecha_tramite = $desembolso->getFechaTramite();
        else
            $fecha_tramite = $_REQUEST['txt_fechatd'];
        if (!isset($_POST['txt_fechac']))
            $fecha_certificacion = $desembolso->getFechaCertificacion();
        else
            $fecha_certificacion = $_REQUEST['txt_fechac'];
        if (!isset($_POST['txt_fechald']))
            $fecha_limite = $desembolso->getFechaLimite();
        else
            $fecha_limite = $_REQUEST['txt_fechald'];
        if (!isset($_POST['txt_efectuado']))
            $efectuado = $desembolso->getEfectuado();
        else
            $efectuado = $_REQUEST['txt_efectuado'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_DESEMBOLSO);

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');

        $form->setId('frm_edit_desembolso');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(DESEMBOLSO_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_DESEMBOLSO_FECHA);

        $form->addEtiqueta(DESEMBOLSO_CONDICION);
        $form->addTextArea('text', 'txt_condicion', 'txt_condicion', '30', '30', $condicion, '', 'onkeypress="ocultarDiv(\'error_condicion\');"');
        $form->addError('error_condicion', ERROR_DESEMBOLSO_CONDICION);

        $form->addEtiqueta(DESEMBOLSO_PORCENTAJE);
        $form->addInputText('text', 'txt_porcentaje', 'txt_porcentaje', '5', '5', $porcentaje, '', 'onChange="ocultarDiv(\'error_porcentaje\');"');
        $form->addError('error_porcentaje', ERROR_DESEMBOLSO_PORCENTAJE);

        $form->addEtiqueta(DESEMBOLSO_APROBADO);
        $form->addTextArea('text', 'txt_aprobado', 'txt_aprobado', '16', '16', $aprobado, '', 'onkeypress="ocultarDiv(\'error_aprobado\');"');
        $form->addError('error_aprobado', ERROR_DESEMBOLSO_APROBADO);

        $form->addEtiqueta(DESEMBOLSO_FECHACM);
        $form->addInputDate('date', 'txt_fechacm', 'txt_fechacm', $fecha_cumplimiento, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fechacm\');"');
        $form->addError('error_fechacm', ERROR_DESEMBOLSO_FECHACM);

        $form->addEtiqueta(DESEMBOLSO_FECHATD);
        $form->addInputDate('date', 'txt_fechatd', 'txt_fechatd', $fecha_tramite, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fechatd\');"');
        $form->addError('error_fechatd', ERROR_DESEMBOLSO_FECHATD);

        $form->addEtiqueta(DESEMBOLSO_FECHAC);
        $form->addInputDate('date', 'txt_fechac', 'txt_fechac', $fecha_certificacion, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fechac\');"');
        $form->addError('error_fechac', ERROR_DESEMBOLSO_FECHAC);

        $form->addEtiqueta(DESEMBOLSO_FECHALD);
        $form->addInputDate('date', 'txt_fechald', 'txt_fechald', $fecha_limite, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fechald\');"');
        $form->addError('error_fechald', ERROR_DESEMBOLSO_FECHALD);

        $form->addEtiqueta(DESEMBOLSO_EFECTUADO);
        $form->addTextArea('text', 'txt_efectuado', 'txt_efectuado', '16', '16', $efectuado, '', 'onkeypress="ocultarDiv(\'error_efectuado\');"');
        $form->addError('error_efectuado', ERROR_DESEMBOLSO_EFECTUADO);

        $valor_contrato = $desData->getTotalVigencias('vigencia_recursos', 'vir_anio<>' . $anio_anticipo . ' and ope_id=' . $operador);
        $valor_desembolso = $desData->getTotalDesembolso('ope_id=' . $operador);
        $total_desembolso = $valor_desembolso - $desembolso->getEfectuado();

        $form->addInputText('hidden', 'txt_valor_contrato', 'txt_valor_contrato', '20', '20', $valor_contrato, '', '');
        $form->addInputText('hidden', 'txt_total_desembolso', 'txt_total_desembolso', '20', '20', $total_desembolso, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '20', '20', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_desembolso();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_desembolso\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listDesembolso&operador=' . $operador . '\');"');

        $form->writeForm();

        break;

    case 'saveEditDesembolso':

        $id_edit = $_POST['txt_id'];
        $fecha = $_POST['txt_fecha'];
        $condicion = $_POST['txt_condicion'];
        $porcentaje = $_POST['txt_porcentaje'];
        $aprobado = $_POST['txt_aprobado'];
        $fecha_cumplimiento = $_POST['txt_fechacm'];
        $fecha_tramite = $_POST['txt_fechatd'];
        $fecha_certificacion = $_POST['txt_fechac'];
        $fecha_limite = $_POST['txt_fechald'];
        $efectuado = $_POST['txt_efectuado'];

        $desembolso = new CDesembolso($id_edit, $operador, $fecha, $condicion, $porcentaje, $aprobado, $fecha_cumplimiento, $fecha_tramite, $fecha_certificacion, $fecha_limite, $efectuado, $desData);

        $m = $desembolso->saveEditDesembolso();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listDesembolso&operador=' . $operador);

        break;

    case 'deleteDesembolso':
        $id_delete = $_REQUEST['id_element'];
        $desembolso = new CDesembolso($id_delete, $operador, '', '', '', '', '', '', '', '', '', $desData);
        $desembolso->loadDesembolso();

        $form = new CHtmlForm();
        $form->setId('frm_delete_desembolso');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $desembolso->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(RENDIMIENTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteDesembolso&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_desembolso','?mod=" . $modulo . "&niv=" . $nivel . "&task=listDesembolso&operador=" . $operador . "')");
        break;

    case 'confirmDeleteDesembolso':
        $id_delete = $_REQUEST['id_element'];
        $desembolso = new CDesembolso($id_delete, $operador, '', '', '', '', '', '', '', '', '', $desData);
        $desembolso->loadDesembolso();

        $m = $desembolso->deleteDesembolso();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listDesembolso&operador=' . $operador);

        break;

    // ----------------           Utilizaciones    --------------------------------------------

    case 'listUtilizacion':
        // --------------------  Resumen  -----------------------
        $dt = new CHtmlDataTable();
        $dt->setTitleTable('Resumen Utilizaciones ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        $dt->setType(1);

        $valor_contrato = $desData->getTotalVigencias('vigencia_recursos', 'vir_anio<>' . $anio_anticipo . ' and ope_id=' . $operador);
        $valor_desembolso = $desData->getTotalDesembolso('ope_id=' . $operador);
        $valor_utilizacion = $utiData->getTotalUtilizacion('ope_id=' . $operador);
        $titulos = array('', '', '', '', '', '');
        $cont = 0;
        $row_f = null;
        $row_f[0]['id'] = $cont + 1000; //para que lo agregue al final
        $row_f[0]['referencia1'] = "Valor del Contrato";
        $row_f[0]['monto1'] = "<span class='total'>" . number_format($valor_contrato, 2, ',', '.') . "</span>";
        $row_f[0]['referencia2'] = "Total Desembolsos";
        $row_f[0]['monto2'] = "<span class='total'>" . number_format($valor_desembolso, 2, ',', '.') . "</span>";
        $row_f[0]['referencia3'] = "Total Utilizaciones";
        $row_f[0]['monto3'] = "<span class='total'>" . number_format($valor_utilizacion, 2, ',', '.') . "</span>";
        $row_f[0]['referencia4'] = "Saldo por Utilizar";
        $diferencia = $valor_desembolso - $valor_utilizacion;
        $row_f[0]['monto4'] = "<span class='total'>" . number_format($diferencia, 2, ',', '.') . "</span>";

        $dt->setDataRows($row_f);
        $dt->setTitleRow($titulos);

        $dt->writeDataTable($nivel);   //datos para la tabla de Utilizacion por contrato
        $utilizacions = $utiData->getUtilizacion('ope_id=' . $operador, 'uti_id');
        $dt = new CHtmlDataTable();
        $titulos = array(UTILIZACION_FECHA, UTILIZACION_CONDICION, UTILIZACION_APROBADO, UTILIZACION_ACUMULADO, UTILIZACION_AUTORIZACION,
            UTILIZACION_COMUNICADO, UTILIZACION_COMENTARIOS);
        $dt->setDataRows($utilizacions);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_UTILIZACIONES . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        //Comandos que crean vinculos para crear, editar y eliminar utilizacion
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addUtilizacion" . '&operador=' . $operador);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editUtilizacion" . '&operador=' . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteUtilizacion" . '&operador=' . $operador);
        $dt->setType(1);
        $dt->writeDataTable($nivel);

        break;

    case 'addUtilizacion':

        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_UTILIZACION);

        $form->setId('frm_add_utilizacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(UTILIZACION_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_UTILIZACION_FECHA);

        $form->addEtiqueta(UTILIZACION_CONDICION);
        $form->addTextArea('text', 'txt_condicion', 'txt_condicion', '30', '30', $condicion, '', 'onkeypress="ocultarDiv(\'error_condicion\');"');
        $form->addError('error_condicion', ERROR_UTILIZACION_CONDICION);

        $form->addEtiqueta(UTILIZACION_APROBADO);
        $form->addTextArea('text', 'txt_aprobado', 'txt_aprobado', '16', '1', $aprobado, '', 'onkeypress="ocultarDiv(\'error_aprobado\');"');
        $form->addError('error_aprobado', ERROR_UTILIZACION_APROBADO);

        $form->addEtiqueta(UTILIZACION_AUTORIZACION);
        $form->addTextArea('text', 'txt_autorizacion', 'txt_autorizacion', '30', '1', $autorizacion, '', 'onkeypress="ocultarDiv(\'error_autorizacion\');"');
        $form->addError('error_autorizacion', ERROR_UTILIZACION_AUTORIZACION);

        $form->addEtiqueta(UTILIZACION_COMUNICADO);
        $form->addTextArea('text', 'txt_comunicado', 'txt_comunicado', '30', '1', $comunicado, '', 'onkeypress="ocultarDiv(\'error_comunicado\');"');
        $form->addError('error_comunicado', ERROR_UTILIZACION_COMUNICADO);

        $form->addEtiqueta(UTILIZACION_COMENTARIOS);
        $form->addTextArea('textarea', 'txt_comentarios', 'txt_comentarios', '50', '4', $comentarios, '', 'onkeypress="ocultarDiv(\'error_comentarios\');"');
        $form->addError('error_comentarios', ERROR_UTILIZACION_COMENTARIOS);

        $valor_desembolso = $desData->getTotalDesembolso('ope_id=' . $operador);
        $valor_utilizacion = $utiData->getTotalUtilizacion('ope_id=' . $operador);

        $total_utilizacion = $valor_utilizacion + $aprobado;
        $form->addInputText('hidden', 'txt_total_desembolso', 'txt_total_desembolso', '20', '20', $valor_desembolso, '', '');
        $form->addInputText('hidden', 'txt_total_utilizacion', 'txt_total_utilizacion', '20', '20', $total_utilizacion, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '20', '20', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_utilizacion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_utilizacion\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listUtilizacion&operador=' . $operador . '\');"');

        $form->writeForm();

        break;

    case 'saveAddUtilizacion':

        $fecha = $_POST['txt_fecha'];
        $condicion = $_POST['txt_condicion'];
        $aprobado = $_POST['txt_aprobado'];
        $autorizacion = $_POST['txt_autorizacion'];
        $comunicado = $_POST['txt_comunicado'];
        $comentarios = $_POST['txt_comentarios'];

        $utilizacion = new CUtilizacion($id, $operador, $fecha, $condicion, $aprobado, $autorizacion, $comunicado, $comentarios, $utiData);

        $m = $utilizacion->saveNewUtilizacion();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listUtilizacion&operador=' . $operador);

        break;

    case 'editUtilizacion':

        $id_edit = $_REQUEST['id_element'];
        $utilizacion = new CUtilizacion($id_edit, '', '', '', '', '', '', '', $utiData);
        $utilizacion->loadUtilizacion();

        if (!isset($_POST['txt_fecha']))
            $fecha = $utilizacion->getFecha();
        else
            $fecha = $_REQUEST['txt_fecha'];
        if (!isset($_POST['txt_condicion']))
            $condicion = $utilizacion->getCondicion();
        else
            $condicion = $_REQUEST['txt_condicion'];
        if (!isset($_POST['txt_aprobado']))
            $aprobado = $utilizacion->getAprobado();
        else
            $aprobado = $_REQUEST['txt_aprobado'];
        if (!isset($_POST['txt_autorizacion']))
            $autorizacion = $utilizacion->getAutorizacion();
        else
            $autorizacion = $_REQUEST['txt_autorizacion'];
        if (!isset($_POST['txt_comunicado']))
            $comunicado = $utilizacion->getComunicado();
        else
            $comunicado = $_REQUEST['txt_comunicado'];
        if (!isset($_POST['txt_comentarios']))
            $comentarios = $utilizacion->getComentarios();
        else
            $comentarios = $_REQUEST['txt_comentarios'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_UTILIZACION);

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->setId('frm_edit_utilizacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(UTILIZACION_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_UTILIZACION_FECHA);

        $form->addEtiqueta(UTILIZACION_CONDICION);
        $form->addTextArea('text', 'txt_condicion', 'txt_condicion', '30', '30', $condicion, '', 'onkeypress="ocultarDiv(\'error_condicion\');"');
        $form->addError('error_condicion', ERROR_UTILIZACION_CONDICION);

        $form->addEtiqueta(UTILIZACION_APROBADO);
        $form->addTextArea('text', 'txt_aprobado', 'txt_aprobado', '16', '16', $aprobado, '', 'onkeypress="ocultarDiv(\'error_aprobado\');"');
        $form->addError('error_aprobado', ERROR_UTILIZACION_APROBADO);

        $form->addEtiqueta(UTILIZACION_AUTORIZACION);
        $form->addTextArea('text', 'txt_autorizacion', 'txt_autorizacion', '30', '30', $autorizacion, '', 'onkeypress="ocultarDiv(\'error_autorizacion\');"');
        $form->addError('error_autorizacion', ERROR_UTILIZACION_AUTORIZACION);

        $form->addEtiqueta(UTILIZACION_COMUNICADO);
        $form->addTextArea('text', 'txt_comunicado', 'txt_comunicado', '30', '30', $comunicado, '', 'onkeypress="ocultarDiv(\'error_comunicado\');"');
        $form->addError('error_comunicado', ERROR_UTILIZACION_COMUNICADO);

        $form->addEtiqueta(UTILIZACION_COMENTARIOS);
        $form->addTextArea('text', 'txt_comentarios', 'txt_comentarios', '60', '3', $comentarios, '', 'onkeypress="ocultarDiv(\'error_comentarios\');"');
        $form->addError('error_comentarios', ERROR_UTILIZACION_COMENTARIOS);

        $valor_desembolso = $desData->getTotalDesembolso('ope_id=' . $operador);
        $valor_utilizacion = $utiData->getTotalUtilizacion('ope_id=' . $operador);
        $total_utilizacion = $valor_utilizacion - $utilizacion->getAprobado();

        $form->addInputText('hidden', 'txt_total_desembolso', 'txt_total_desembolso', '20', '20', $valor_desembolso, '', '');
        $form->addInputText('hidden', 'txt_total_utilizacion', 'txt_total_utilizacion', '20', '20', $total_utilizacion, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_utilizacion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_utilizacion\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listUtilizacion&operador=' . $operador . '\');"');

        $form->writeForm();

        break;

    case 'saveEditUtilizacion':

        $id_edit = $_POST['txt_id'];
        $fecha = $_POST['txt_fecha'];
        $condicion = $_POST['txt_condicion'];
        $aprobado = $_POST['txt_aprobado'];
        $autorizacion = $_POST['txt_autorizacion'];
        $comunicado = $_POST['txt_comunicado'];
        $comentarios = $_POST['txt_comentarios'];

        $utilizacion = new CUtilizacion($id_edit, $operador, $fecha, $condicion, $aprobado, $autorizacion, $comunicado, $comentarios, $utiData);

        $m = $utilizacion->saveEditUtilizacion();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listUtilizacion&operador=' . $operador);

        break;

    case 'deleteUtilizacion':
        $id_delete = $_REQUEST['id_element'];
        $utilizacion = new CUtilizacion($id_delete, '', '', '', '', '', '', '', $utiData);
        $utilizacion->loadUtilizacion();

        $form = new CHtmlForm();
        $form->setId('frm_delete_utilizacion');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $utilizacion->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(RENDIMIENTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteUtilizacion&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_utilizacion','?mod=" . $modulo . "&niv=" . $nivel . "&task=listUtilizacion&operador=" . $operador . "')");
        break;

    case 'confirmDeleteUtilizacion':
        $id_delete = $_REQUEST['id_element'];
        $utilizacion = new CUtilizacion($id_delete, '', '', '', '', '', '', '', $utiData);
        $utilizacion->loadUtilizacion();

        $m = $utilizacion->deleteUtilizacion();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listUtilizacion&operador=' . $operador);

        break;
    // ----------------           Ordenes de Pago    --------------------------------------------

    case 'listOrden':
        // --------------------  Resumen  -----------------------
        $dt = new CHtmlDataTable();
        $dt->setTitleTable('Resumen Ordenes ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        $dt->setType(1);

        $valor_contrato = $desData->getTotalVigencias('vigencia_recursos', 'vir_anio<>' . $anio_anticipo . ' and ope_id=' . $operador);
        $valor_desembolso = $desData->getTotalDesembolso('ope_id=' . $operador);
        $valor_utilizacion = $utiData->getTotalUtilizacion('ope_id=' . $operador);
        $valor_orden = $ordData->getTotalOrden('ope_id=' . $operador);
        $titulos = array('', '', '', '', '', '', '', '', '', '');
        $cont = 0;
        $row_f = null;
        $row_f[0]['id'] = $cont + 1000; //para que lo agregue al final
        $row_f[0]['referencia1'] = "Valor del <br>Contrato";
        $row_f[0]['monto1'] = "<span class='total'>" . number_format($valor_contrato, 2, ',', '.') . "</span>";
        $row_f[0]['referencia2'] = "Total <br>Desembolsos";
        $row_f[0]['monto2'] = "<span class='total'>" . number_format($valor_desembolso, 2, ',', '.') . "</span>";
        $row_f[0]['referencia3'] = "Total <br>Utilizaciones";
        $row_f[0]['monto3'] = "<span class='total'>" . number_format($valor_utilizacion, 2, ',', '.') . "</span>";
        $row_f[0]['referencia4'] = "Total <br>Ordenes";
        $row_f[0]['monto4'] = "<span class='total'>" . number_format($valor_orden, 2, ',', '.') . "</span>";
        $row_f[0]['referencia5'] = "Saldo por Ejecutar";
        $diferencia = $valor_utilizacion - $valor_orden;
        $row_f[0]['monto5'] = "<span class='total'>" . number_format($diferencia, 2, ',', '.') . "</span>";

        $dt->setDataRows($row_f);
        $dt->setTitleRow($titulos);

        $dt->writeDataTable($nivel);   //datos para la tabla de Orden por contrato
        $utilizaciones = $ordData->getOrden('o.ope_id=' . $operador, 'ord_id');
        $dt = new CHtmlDataTable();
        $titulos = array(ORDEN_FECHA, ORDEN_NUMERO, ORDEN_ACTIVIDAD, ORDEN_CONCEPTO, ORDEN_MODALIDAD,
            ORDEN_TASA, ORDEN_VALOR_DOLARES, ORDEN_VALOR_PESOS, ORDEN_ACUMULADO);
        $dt->setDataRows($utilizaciones);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_ORDENES . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());
        //Comandos que crean vinculos para crear, editar y eliminar utilizacion
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addOrden" . '&operador=' . $operador);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editOrden" . '&operador=' . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteOrden" . '&operador=' . $operador);
        $dt->setType(1);
        $dt->writeDataTable($nivel);

        break;

    case 'addOrden':

        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_ORDEN);

        $form->setId('frm_add_orden');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(ORDEN_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_ORDEN_FECHA);

        $form->addEtiqueta(ORDEN_NUMERO);
        $form->addInputText('text', 'txt_numero', 'txt_numero', '10', '10', $numero, '', 'onkeypress="ocultarDiv(\'error_numero\');"');
        $form->addError('error_numero', ERROR_ORDEN_NUMERO);


        $actividades = $ordData->getRubros($operador);
        $opciones = null;
        if (isset($actividades)) {
            foreach ($actividades as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(ORDEN_ACTIVIDAD);
        $form->addSelect('select', 'sel_actividad', 'sel_actividad', $opciones, ORDEN_ACTIVIDAD, $actividad, '', 'onkeypress="ocultarDiv(\'error_actividad\');"');
        $form->addError('error_actividad', ERROR_ORDEN_ACTIVIDAD);

        $conceptos = $ordData->getConceptos($operador);
        $opciones = null;
        if (isset($conceptos)) {
            foreach ($conceptos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(ORDEN_CONCEPTO);
        $form->addSelect('select', 'sel_concepto', 'sel_concepto', $opciones, ORDEN_CONCEPTO, $concepto, '', 'onkeypress="ocultarDiv(\'error_concepto\');"');
        $form->addError('error_concepto', ERROR_ORDEN_CONCEPTO);

        $modalidades = $ordData->getModalidades($operador);
        $opciones = null;
        if (isset($modalidades)) {
            foreach ($modalidades as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(ORDEN_MODALIDAD);
        $form->addSelect('select', 'sel_modalidad', 'sel_modalidad', $opciones, ORDEN_MODALIDAD, $modalidad, '', 'onkeypress="ocultarDiv(\'error_modalidad\');"');
        $form->addError('error_modalidad', ERROR_ORDEN_MODALIDAD);

        $form->addEtiqueta(ORDEN_TASA);
        $form->addInputText('text', 'txt_tasa', 'txt_tasa', '6', '6', $tasa, '', 'onkeypress="ocultarDiv(\'error_tasa\');"');
        $form->addError('error_tasa', ERROR_ORDEN_TASA);

        $form->addEtiqueta(ORDEN_VALOR_DOLARES);
        $form->addInputText('text', 'txt_dolares', 'txt_dolares', '15', '15', $dolares, '', 'onkeypress="ocultarDiv(\'error_dolares\');"');
        $form->addError('error_dolares', ERROR_ORDEN_VALOR_DOLARES);

        $form->addEtiqueta(ORDEN_VALOR_PESOS);
        $form->addInputText('text', 'txt_pesos', 'txt_pesos', '15', '15', $pesos, '', 'onkeypress="ocultarDiv(\'error_pesos\');"');
        $form->addError('error_pesos', ERROR_ORDEN_VALOR_PESOS);

        $total_utilizacion = $utiData->getTotalUtilizacion('ope_id=' . $operador);
        $valor_orden = $ordData->getTotalOrden('ope_id=' . $operador);
        $total_orden = $valor_orden + $valor_pesos;

        $form->addInputText('hidden', 'txt_total_orden', 'txt_total_orden', '20', '20', $total_orden, '', '');
        $form->addInputText('hidden', 'txt_total_utilizacion', 'txt_total_utilizacion', '20', '20', $total_utilizacion, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '20', '20', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_orden();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_orden\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listOrden&operador=' . $operador . '\');"');

        $form->writeForm();

        break;

    case 'saveAddOrden':

        $fecha = $_POST['txt_fecha'];
        $numero = $_POST['txt_numero'];
        $actividad = $_POST['sel_actividad'];
        $concepto = $_POST['sel_concepto'];
        $modalidad = $_POST['sel_modalidad'];
        $tasa = $_POST['txt_tasa'];
        $dolares = $_POST['txt_dolares'];
        $pesos = $_POST['txt_pesos'];
        //echo("<br>mod:".$modalidad);

        $ordenes = new COrdenes($id, $operador, $fecha, $numero, $actividad, $concepto, $modalidad, $tasa, $dolares, $pesos, $ordData);

        $m = $ordenes->saveNewOrden();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listOrden&operador=' . $operador);

        break;

    case 'editOrden':

        $id_edit = $_REQUEST['id_element'];
        $ordenes = new COrdenes($id_edit, '', '', '', '', '', '', '', '', '', $ordData);
        $ordenes->loadOrden();

        if (!isset($_POST['txt_fecha']))
            $fecha = $ordenes->getFecha();
        else
            $fecha = $_REQUEST['txt_fecha'];
        if (!isset($_POST['txt_numero']))
            $numero = $ordenes->getNumero();
        else
            $numero = $_REQUEST['txt_numero'];
        if (!isset($_POST['sel_actividad']))
            $actividad = $ordenes->getRubro();
        else
            $actividad = $_REQUEST['sel_actividad'];
        if (!isset($_POST['sel_concepto']))
            $concepto = $ordenes->getConcepto();
        else
            $concepto = $_REQUEST['sel_concepto'];
        if (!isset($_POST['sel_modalidad']))
            $modalidad = $ordenes->getModalidad();
        else
            $modalidad = $_REQUEST['sel_modalidad'];
        if (!isset($_POST['txt_tasa']))
            $tasa = $ordenes->getTasa();
        else
            $tasa = $_REQUEST['txt_tasa'];
        if (!isset($_POST['txt_dolares']))
            $dolares = $ordenes->getValorDolares();
        else
            $dolares = $_REQUEST['txt_dolares'];
        if (!isset($_POST['txt_pesos']))
            $pesos = $ordenes->getValorPesos();
        else
            $pesos = $_REQUEST['txt_pesos'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_ORDEN);

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->setId('frm_edit_orden');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(ORDEN_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_ORDEN_FECHA);

        $form->addEtiqueta(ORDEN_NUMERO);
        $form->addInputText('text', 'txt_numero', 'txt_numero', '10', '10', $numero, '', 'onkeypress="ocultarDiv(\'error_numero\');"');
        $form->addError('error_numero', ERROR_ORDEN_NUMERO);


        $actividades = $ordData->getRubros($operador);
        $opciones = null;
        if (isset($actividades)) {
            foreach ($actividades as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(ORDEN_ACTIVIDAD);
        $form->addSelect('select', 'sel_actividad', 'sel_actividad', $opciones, ORDEN_ACTIVIDAD, $actividad, '', 'onkeypress="ocultarDiv(\'error_actividad\');"');
        $form->addError('error_actividad', ERROR_ORDEN_ACTIVIDAD);

        $conceptos = $ordData->getConceptos($operador);
        $opciones = null;
        if (isset($conceptos)) {
            foreach ($conceptos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(ORDEN_CONCEPTO);
        $form->addSelect('select', 'sel_concepto', 'sel_concepto', $opciones, ORDEN_CONCEPTO, $concepto, '', 'onkeypress="ocultarDiv(\'error_concepto\');"');
        $form->addError('error_concepto', ERROR_ORDEN_CONCEPTO);

        $modalidades = $ordData->getModalidades($operador);
        $opciones = null;
        if (isset($modalidades)) {
            foreach ($modalidades as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(ORDEN_MODALIDAD);
        $form->addSelect('select', 'sel_modalidad', 'sel_modalidad', $opciones, ORDEN_MODALIDAD, $modalidad, '', 'onkeypress="ocultarDiv(\'error_modalidad\');"');
        $form->addError('error_modalidad', ERROR_ORDEN_MODALIDAD);

        $form->addEtiqueta(ORDEN_TASA);
        $form->addInputText('text', 'txt_tasa', 'txt_tasa', '6', '6', $tasa, '', 'onkeypress="ocultarDiv(\'error_tasa\');"');
        $form->addError('error_tasa', ERROR_ORDEN_TASA);

        $form->addEtiqueta(ORDEN_VALOR_DOLARES);
        $form->addInputText('text', 'txt_dolares', 'txt_dolares', '15', '15', $dolares, '', 'onkeypress="ocultarDiv(\'error_dolares\');"');
        $form->addError('error_dolares', ERROR_ORDEN_VALOR_DOLARES);

        $form->addEtiqueta(ORDEN_VALOR_PESOS);
        $form->addInputText('text', 'txt_pesos', 'txt_pesos', '15', '15', $pesos, '', 'onkeypress="ocultarDiv(\'error_pesos\');"');
        $form->addError('error_pesos', ERROR_ORDEN_VALOR_PESOS);

        $total_utilizacion = $utiData->getTotalUtilizacion('ope_id=' . $operador);
        $valor_orden = $ordData->getTotalOrden('ope_id=' . $operador);
        $total_orden = $valor_orden - $ordenes->getValorPesos();

        $form->addInputText('hidden', 'txt_total_orden', 'txt_total_orden', '20', '20', $total_orden, '', '');
        $form->addInputText('hidden', 'txt_total_utilizacion', 'txt_total_utilizacion', '20', '20', $total_utilizacion, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_orden();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_orden\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listOrden&operador=' . $operador . '\');"');

        $form->writeForm();

        break;

    case 'saveEditOrden':

        $id_edit = $_POST['txt_id'];
        $fecha = $_POST['txt_fecha'];
        $numero = $_POST['txt_numero'];
        $actividad = $_POST['sel_actividad'];
        $concepto = $_POST['sel_concepto'];
        $modalidad = $_POST['sel_modalidad'];
        $tasa = $_POST['txt_tasa'];
        $dolares = $_POST['txt_dolares'];
        $pesos = $_POST['txt_pesos'];

        $ordenes = new COrdenes($id_edit, $operador, $fecha, $numero, $actividad, $concepto, $modalidad, $tasa, $dolares, $pesos, $ordData);

        $m = $ordenes->saveEditOrden();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listOrden&operador=' . $operador);

        break;

    case 'deleteOrden':
        $id_delete = $_REQUEST['id_element'];
        $ordenes = new COrdenes($id_delete, '', '', '', '', '', '', '', '', '', $ordData);
        $ordenes->loadOrden();

        $form = new CHtmlForm();
        $form->setId('frm_delete_orden');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $ordenes->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(RENDIMIENTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteOrden&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_orden','?mod=" . $modulo . "&niv=" . $nivel . "&task=listOrden&operador=" . $operador . "')");
        break;

    case 'confirmDeleteOrden':
        $id_delete = $_REQUEST['id_element'];
        $ordenes = new COrdenes($id_delete, '', '', '', '', '', '', '', '', '', $ordData);
        $ordenes->loadOrden();

        $m = $ordenes->deleteOrden();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listOrden&operador=' . $operador);

        break;
    // ----------------           Rendimientos financieros    --------------------------------------------
    case 'listRendimientos':

        $rendimientos = $renData->getRendimientos($operador, $Ooperador->getSiglas(), 'mec_id');
        $dt = new CHtmlDataTable();
        $titulos = array(RENDIMIENTO_MES, RENDIMIENTO_GENERADO, RENDIMIENTO_DESCUENTO, RENDIMIENTO_CONSIGNADO, RENDIMIENTO_ACUMULADO, RENDIMIENTO_TASA, RENDIMIENTO_FECHA, RENDIMIENTO_ARCHIVO1, RENDIMIENTO_ARCHIVO2);
        $dt->setDataRows($rendimientos);
        $dt->setTitleRow($titulos);
        $dt->setPag(1);

        $dt->setTitleTable(TABLA_RENDIMIENTOS . ' ' . $Ooperador->getNombre() . ' ' . $Ooperador->getContratoNo());

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=editRendimiento" . "&operador=" . $operador);
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=deleteRendimiento" . "&operador=" . $operador);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=addRendimiento" . "&operador=" . $operador);

        $dt->setType(1);

        $dt->writeDataTable($nivel);

        break;

    case 'addRendimiento':
        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_RENDIMIENTO);

        $form->setId('frm_add_rendimiento');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $meses = $renData->getMeses('mec_nombre');
        $opciones = null;
        if (isset($meses)) {
            foreach ($meses as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['mes']);
            }
        }
        $form->addEtiqueta(RENDIMIENTO_MES);
        $form->addSelect('select', 'sel_mes', 'sel_mes', $opciones, RENDIMIENTO_MES, $mes, '', 'onChange="ocultarDiv(\'error_mes\');"');
        $form->addError('error_mes', ERROR_RENDIMIENTO_MES);

        $form->addEtiqueta(RENDIMIENTO_GENERADO);
        $form->addInputText('text', 'txt_rendimiento_generado', 'txt_rendimiento_generado', '11', '11', $rendimiento_generado, '', 'onChange="ocultarDiv(\'error_rendimiento_generado\');"');
        $form->addError('error_rendimiento_generado', ERROR_RENDIMIENTO_GENERADO);

        $form->addEtiqueta(RENDIMIENTO_DESCUENTO);
        $form->addInputText('text', 'txt_descuento', 'txt_descuento', '11', '11', $descuento, '', 'onChange="ocultarDiv(\'error_descuento\');"');
        $form->addError('error_descuento', ERROR_RENDIMIENTO_DESCUENTO);

        $form->addEtiqueta(RENDIMIENTO_TASA);
        $form->addInputText('text', 'txt_tasa', 'txt_tasa', '6', '6', $tasa, '', 'onChange="ocultarDiv(\'error_tasa\');"');
        $form->addError('error_tasa', ERROR_RENDIMIENTO_TASA);

        $form->addEtiqueta(RENDIMIENTO_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_RENDIMIENTO_FECHA);

        $form->addEtiqueta(RENDIMIENTO_ARCHIVO1);
        $form->addInputFile('file', 'file_documento1', 'file_documento1', '100', 'file', 'onChange="ocultarDiv(\'error_documento1\');"');
        $form->addError('error_documento1', ERROR_RENDIMIENTO_ARCHIVO1);

        $form->addEtiqueta(RENDIMIENTO_ARCHIVO2);
        $form->addInputFile('file', 'file_documento2', 'file_documento2', '100', 'file', 'onChange="ocultarDiv(\'error_documento2\');"');
        $form->addError('error_documento2', ERROR_RENDIMIENTO_ARCHIVO2);

        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_rendimiento();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_rendimiento\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listRendimientos&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveAddRendimiento':
        $mes = $_POST['sel_mes'];
        $rendimiento_generado = $_POST['txt_rendimiento_generado'];
        $descuento = $_POST['txt_descuento'];
        $tasa = $_POST['txt_tasa'];
        $fecha = $_POST['txt_fecha'];
        $archivo1 = $_FILES['file_documento1'];
        $archivo2 = $_FILES['file_documento2'];

        $rendimiento = new CRendimiento('', $operador, $mes, $rendimiento_generado, $descuento, $tasa, $archivo_consignacion, $archivo_emision, $fecha, $renData);

        $m = $rendimiento->saveNewRendimiento($archivo1, $archivo2, $Ooperador->getSiglas());

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listRendimientos&operador=' . $operador);

        break;

    case 'editRendimiento':
        $id_edit = $_REQUEST['id_element'];
        $rendimiento = new CRendimiento($id_edit, '', '', '', '', '', '', '', '', $renData);
        $rendimiento->loadRendimiento();

        if (!isset($_POST['txt_mes']))
            $mes = $rendimiento->getMes();
        else
            $mes = $_REQUEST['txt_mes'];
        if (!isset($_POST['txt_rendimiento_generado']))
            $rendimiento_generado = $rendimiento->getRendimientoGenerado();
        else
            $rendimiento_generado = $_REQUEST['txt_rendimiento_generado'];
        if (!isset($_POST['txt_descuento']))
            $descuento = $rendimiento->getDescuento();
        else
            $descuento = $_REQUEST['txt_descuento'];
        if (!isset($_POST['txt_tasa']))
            $tasa = $rendimiento->getRendimientoTasa();
        else
            $tasa = $_REQUEST['txt_tasa'];
        if (!isset($_POST['txt_fecha']))
            $fecha = $rendimiento->getFechaConsignacion();
        else
            $fecha = $_REQUEST['txt_fecha'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_RENDIMIENTO);

        $form->setId('frm_edit_rendimiento');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $id_edit, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');


        $form->addEtiqueta(RENDIMIENTO_GENERADO);
        $form->addInputText('text', 'txt_rendimiento_generado', 'txt_rendimiento_generado', '11', '11', $rendimiento_generado, '', 'onChange="ocultarDiv(\'error_rendimiento_generado\');"');
        $form->addError('error_rendimiento_generado', ERROR_RENDIMIENTO_GENERADO);

        $form->addEtiqueta(RENDIMIENTO_DESCUENTO);
        $form->addInputText('text', 'txt_descuento', 'txt_descuento', '11', '11', $descuento, '', 'onChange="ocultarDiv(\'error_descuento\');"');
        $form->addError('error_descuento', ERROR_RENDIMIENTO_DESCUENTO);

        $form->addEtiqueta(RENDIMIENTO_TASA);
        $form->addInputText('text', 'txt_tasa', 'txt_tasa', '6', '6', $tasa, '', 'onChange="ocultarDiv(\'error_tasa\');"');
        $form->addError('error_tasa', ERROR_RENDIMIENTO_TASA);

        $form->addEtiqueta(RENDIMIENTO_FECHA);
        $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_RENDIMIENTO_FECHA);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_rendimiento();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_rendimiento\',\'?mod=' . $modulo . '&niv=' . $nivel . '&task=listRendimientos&operador=' . $operador . '\');"');

        $form->writeForm();
        break;

    case 'saveEditRendimiento':
        $id_edit = $_POST['txt_id'];
        $rendimiento_generado = $_POST['txt_rendimiento_generado'];
        $descuento = $_POST['txt_descuento'];
        $tasa = $_POST['txt_tasa'];
        $fecha = $_POST['txt_fecha'];
        $archivo1 = $_FILES['file_documento1'];
        $archivo2 = $_FILES['file_documento2'];


        $rendimiento = new CRendimiento($id_edit, '', '', $rendimiento_generado, $descuento, $tasa, '', '', $fecha, $renData);

        $m = $rendimiento->saveEditRendimiento();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listRendimientos&operador=' . $operador);

        break;

    case 'deleteRendimiento':
        $id_delete = $_REQUEST['id_element'];
        $rendimiento = new CRendimiento($id_delete, '', '', '', '', '', '', '', '', $renData);
        $rendimiento->loadRendimiento();

        $form = new CHtmlForm();
        $form->setId('frm_delete_Rendimiento');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $rendimiento->getId(), '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(RENDIMIENTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $nivel . '&task=confirmDeleteRendimiento&id_element=' . $id_delete . '&operador=' . $operador, "cancelarAccion('frm_delete_Rendimiento','?mod=" . $modulo . "&niv=" . $nivel . "&task=listRendimientos&operador=" . $operador . "')");
        break;

    case 'confirmDeleteRendimiento':
        $id_edit = $_REQUEST['id_element'];
        $rendimiento = new CRendimiento($id_edit, '', '', '', '', '', '', '', '', $renData);
        $rendimiento->loadRendimiento();

        $m = $rendimiento->deleteRendimiento();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $nivel . '&task=listRendimientos&operador=' . $operador);

        break;


    default:
        /**
         * en caso de que la variable task no este definida carga la página en construcción
         */
        include('templates/html/under.html');
        break;
}
?>
