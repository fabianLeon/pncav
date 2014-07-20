<?php

/**
 * 
 *
 * <ul>
 * <li> Redcom Ltda <www.redcom.com.co></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */
/**
 * Modulo Compromisos
 * maneja el modulo COMPROMISOS en union con CRecomendaciones y CRecomendacionesData
 *
 * @see CRecomendaciones
 * @see CRecomendacionesData
 *
 * @package  modulos
 * @subpackage recomendaciones
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');
$comData = new CRecomendacionesData($db);
$docData = new CDocumentoData($db);
$resData = new CRecomendacionesResponsableData($db);

$task = $_REQUEST['task'];
if (empty($task))
    $task = 'list';
$tipo = COMUNICADO_TIPO_CODIGO;
$tema = ACTA_TEMA_CODIGO;
$operador = OPERADOR_DEFECTO;
switch ($task) {
    /**
     * la variable list, permite hacer la carga la página con la lista de objetos 
     * COMPROMISO según los parámetros de entrada
     */
    
    case 'list':
        if (isset($_REQUEST['sel_subtema']) && $_REQUEST['sel_subtema'] != '') 
            $subtema = $_REQUEST['sel_subtema'];
        if (isset($_REQUEST['sel_responsable']) && $_REQUEST['sel_responsable'] != '') 
            $responsable = $_REQUEST['sel_responsable'];
        if (isset($_REQUEST['txt_actividad']) && $_REQUEST['txt_actividad'] != '') 
            $actividad = $_REQUEST['txt_actividad'];
        if (isset($_REQUEST['txt_fecha_inicio']) && $_REQUEST['txt_fecha_inicio'] != '') 
            $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        if (isset($_REQUEST['txt_fecha_fin']) && $_REQUEST['txt_fecha_fin'] != '')     
            $fecha_fin = $_REQUEST['txt_fecha_fin'];        
        if (isset($_REQUEST['sel_estado']) && $_REQUEST['sel_estado'] != '') 
            $estado = $_REQUEST['sel_estado'];
        
        
        $criterio = "";
        if (isset($subtema) && $subtema != -1 && $subtema != "") {
            if ($criterio == '')
                $criterio = " c.doc_id = " . $subtema;
            else
                $criterio .= " and c.doc_id = " . $subtema;;
        }
         if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
            if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (c.com_fecha_entrega >= '" . $fecha_inicio . "')";
                } else {
                    $criterio .= " and c.com_fecha_entrega >= '" . $fecha_inicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = "( c.com_fecha_entrega between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                } else {
                    $criterio .= " and c.com_fecha_entrega between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                }
            }
        }
        if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
            if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( c.com_fecha_entrega <= '" . $fecha_fin . "')";
                } else {
                    $criterio .= " and c.com_fecha_entrega <= '" . $fecha_fin . "')";
                }
            }
        }
        if (isset($responsable) && $responsable != -1 && $responsable != "") {
            if ($criterio == '')
                $criterio = " cr.usu_id = " . $responsable;
            else
                $criterio .= " and cr.usu_id = " . $responsable;
        }
        if (isset($estado) && $estado != -1 && $estado != '') {
            if ($criterio == "")
                $criterio .= " c.ces_id = " . $estado;
            else
                $criterio .= " and c.ces_id = " . $estado;
        }
        if (isset($actividad) && $actividad != -1 && $actividad != '') {
            if ($criterio == "")
                $criterio .= " c.com_actividad like '%" . $actividad . "%'";
            else
                $criterio .= " and c.com_actividad like '%" . $actividad . "%'";
        }
        
        if($criterio == "")
            $criterio = "1";
        
//        $html = new CHtml();
//        $contador = $comData->contarPorEstado('1',$id_usuario);
//        $html->generaScriptAlertLink('verAlertasCompromisos('.$id_usuario.')','('.$contador.')');
        
        $form = new CHtmlForm();

        $form->setTitle(LISTAR_RECOMENDACIONES);
        $form->setId('frm_list_recomendaciones');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        $subtemas = $comData->getFuentesCompromisos('dot_id = ' . ID_ACTAS, 'dos_nombre');
        $opciones = null;

        if (isset($subtemas)) {
            foreach ($subtemas as $s) {
                $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
            }
        }

        $form->addEtiqueta(RECOMENDACIONES_FUENTE);
        $form->addSelect('select', 'sel_subtema', 'sel_subtema', $opciones, RECOMENDACIONES_FUENTE, $subtema, '', 'onChange=consultar_recomendaciones();');
        $form->addError('error_subtema', '');
        
        $responsables = $comData->getResponsablesCompromisos('1', 'usu_nombre, usu_apellido');
        $opciones = null;
        if (isset($responsables)) {
            foreach ($responsables as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']." ".$t['apellido']);
            }
        }
        $form->addEtiqueta(RECOMENDACIONES_RESPONSABLE);
        $form->addSelect('select', 'sel_responsable', 'sel_responsable', $opciones, RECOMENDACIONES_RESPONSABLE, $responsable, '', 'onChange=consultar_recomendaciones();');

        $form->addEtiqueta(RECOMENDACIONES_ACTIVIDAD);
        $form->addInputText('text', 'txt_actividad', 'txt_actividad', '50', '50', $actividad, '', 'onChange=consultar_recomendaciones();');
        $form->addError('error_actividad', ERROR_RECOMENDACIONES_ACTIVIDAD);
       
        
        $form->addEtiqueta(RECOMENDACIONES_FECHA_INICIO);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', 'onChange=consultar_recomendaciones();');

        $form->addEtiqueta(RECOMENDACIONES_FECHA_FIN);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', 'onChange=consultar_recomendaciones();');

        
        $estados = $comData->getEstadosCompromisos('1', 'ces_id');
        $opciones = null;
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(RECOMENDACIONES_ESTADO);
        $form->addSelect('select', 'sel_estado', 'sel_estado', $opciones, RECOMENDACIONES_ESTADO, $estado, '', 'onChange=consultar_recomendaciones();');

//        $form->addEtiqueta(RECOMENDACIONES_CONSECUTIVO);
//        $form->addInputText('text', 'txt_consecutivo', 'txt_consecutivo', '30', '30', $actividad, '', '');

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_recomendaciones();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', RECOMENDACIONES_EXPORTAR, 'button', 'onClick=exportar_excel_recomendaciones();');
        //$form->addInputButton('button', 'btn_exportar', 'btn_exportar', BTN_CANCELAR, 'button', 'onClick=cancelar_busqueda_recomendaciones();');
        
        $form->addInputText('hidden', 'txt_criterio', 'txt_criterio', '5', '5', '', '', '');
        
        $form->writeForm();
      
        
        $dirOperador = $docData->getDirectorioOperador($operador);
        $recomendaciones = $comData->getCompromisos($criterio, ' c.com_fecha_entrega', $dirOperador);
        $contador = count($recomendaciones);
        $cont = 0;
        $elementos = null;
        while ($cont < $contador) {
            $elementos[$cont]['id'] = $recomendaciones[$cont]['id'];
            $elementos[$cont]['area'] = $recomendaciones[$cont]['dos_nombre'];
            $elementos[$cont]['autor'] = $recomendaciones[$cont]['doa_nombre'];
            $elementos[$cont]['actividad'] = $recomendaciones[$cont]['com_actividad'];
            $elementos[$cont]['fecha_entrega'] = $recomendaciones[$cont]['com_fecha_entrega'];
//            $elementos[$cont]['consecutivo'] = $recomendaciones[$cont]['com_consecutivo'];
//            $elementos[$cont]['referencia'] = $recomendaciones[$cont]['doc_referencia'];
//            $elementos[$cont]['fecha_limite'] = $recomendaciones[$cont]['com_fecha_limite'];
            
            $elementos[$cont]['estado'] = $recomendaciones[$cont]['ces_nombre'];

//            if($recomendaciones[$cont]['ces_id']==2){
//               $elementos[$cont]['estado']="<img src='templates/img/ico/verde.gif'>";
//            }
//            if($recomendaciones[$cont]['ces_id']==3){
//               $elementos[$cont]['estado']="<img src='templates/img/ico/rojo.gif'>";
//            }
//            if($recomendaciones[$cont]['ces_id']==1 || $recomendaciones[$cont]['ces_id']==3){
//                $datetime1 = new DateTime("now");
//                $datetime2 = new DateTime($recomendaciones[$cont]['com_fecha_limite']);
//                $interval = $datetime1->diff($datetime2);
//                if(($datetime1 <= $datetime2))
//                    $elementos[$cont]['estado']="<img src='templates/img/ico/amarillo.gif'> ".$interval->format('%d días');
//                else
//                    $elementos[$cont]['estado']="<img src='templates/img/ico/rojo.gif'> ".$interval->format('%d días');
//            }
            
            $elementos[$cont]['observaciones'] = $recomendaciones[$cont]['com_observaciones'];
            $cont++;
        }
                    
        
        
        $dt = new CHtmlDataTable();
        $titulos = array(RECOMENDACIONES_FUENTE, RECOMENDACIONES_RESPONSABLE, RECOMENDACIONES_ACTIVIDAD, 
                         RECOMENDACIONES_FECHA_ENTREGA, RECOMENDACIONES_ESTADO, RECOMENDACIONES_OBSERVACIONES);
        $dt->setDataRows($elementos);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_RECOMENDACIONES);
        
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador);

        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=edit&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador);
        

        $otros = array('link' => "?mod=" . $modulo . "&niv=" . $niv . "&task=listResponsables&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador, 'img' => 'responsables.gif', 'alt' => ALT_RESPONSABLES);
        $dt->addOtrosLink($otros);
        
        $dt->setType(1);
        $pag_crit = "task=list&txt_fecha_inicio=".$fecha_inicio.
                    "&txt_fecha_fin=".$fecha_fin."&sel_responsable=".$responsable. 
                    "&sel_estado=".$estado."txt_actividad=".$actividad.
                    "&txt_criterio=".$criterio_busqueda."&operador=" . $operador;
        $dt->setPag(1, $pag_crit);
        //$dt->setSumColumns(array(4));
        $dt->writeDataTable($niv);
        break;
    /**
     * la variable add, permite hacer la carga la página con las variables que componen el objeto COMPROMISO, ver la clase CRecomendaciones
     */
    case 'add':
        //variables filtro cargadas en el list
        $acta = $_REQUEST['sel_acta'];
        $responsable = $_REQUEST['sel_responsable_add'];
        $subtema = $_REQUEST['sel_subtema'];
        $estado = $_REQUEST['sel_estado'];

        //variables del add 
        $actividad = $_REQUEST['txt_actividad'];
        $subtema_add = $_REQUEST['sel_subtema_add'];
        $estado_add = $_REQUEST['sel_estado_add'];
        $referencia = $_REQUEST['sel_referencia'];
        $fecha_limite_add = $_REQUEST['txt_fecha_limite_add'];
        $fecha_entrega = $_REQUEST['txt_fecha_entrega'];
        $estado = $_REQUEST['sel_estado'];
        $consecutivo = $_REQUEST['txt_consecutivo'];
        $observaciones = $_REQUEST['sel_observaciones'];

        $form = new CHtmlForm();


        $form->setTitle(AGREGAR_RECOMENDACIONES);
        $form->setId('frm_add_recomendaciones');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $subtemas = $comData->getFuentesCompromisos('dot_id = ' . ID_ACTAS, 'dos_nombre');
        $opciones = null;

        if (isset($subtemas)) {
            foreach ($subtemas as $s) {
                $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
            }
        }

        $form->addEtiqueta(RECOMENDACIONES_FUENTE);
        $form->addSelect('select', 'sel_subtema_add', 'sel_subtema_add', $opciones, RECOMENDACIONES_FUENTE, $subtema_add, '', 'onChange=submit();');
        $form->addError('error_subtema', ERROR_RECOMENDACIONES_FUENTE);
        
        $criterio = "usu_estado = 1 ";
        $responsables = $comData->getResponsablesCompromisos($criterio, 'usu_nombre, usu_apellido');
        $opciones = null;
        if (isset($responsables)) {
            foreach ($responsables as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']." ".$t['apellido']);
            }
        }
        $form->addEtiqueta(RECOMENDACIONES_RESPONSABLE);
        $form->addSelect('select', 'sel_responsable_add', 'sel_responsable_add', $opciones, RECOMENDACIONES_RESPONSABLE, $responsable, '', '');
        $form->addError('error_responsable', ERROR_RECOMENDACIONES_RESPONSABLE);

        $form->addEtiqueta(RECOMENDACIONES_ACTIVIDAD);
        $form->addTextArea('textarea', 'txt_actividad', 'txt_actividad', '100', '2', $actividad, '', 'onkeypress="ocultarDiv(\'error_actividad\');"');
        $form->addError('error_actividad', ERROR_RECOMENDACIONES_ACTIVIDAD);

//        $form->addEtiqueta(RECOMENDACIONES_CONSECUTIVO);
//        $form->addInputText('text', 'txt_consecutivo', 'txt_consecutivo', '30', '30', $consecutivo, '', 'onkeypress="ocultarDiv(\'error_consecutivo\');"');
//        $form->addError('error_consecutivo', ERROR_RECOMENDACIONES_CONSECUTIVO);
        
//        $referencias = $comData->getReferenciasDocumentos(' d.dos_id = ' . $subtema_add . ' and d.ope_id =' . $operador, 'd.dos_id, d.doc_version'); //modificacion
//        $opciones = null;
//        if (isset($referencias)) {
//            foreach ($referencias as $t) {
//                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
//            }
//        }
//        $form->addEtiqueta(RECOMENDACIONES_REFERENCIA);
//        $form->addSelect('select', 'sel_referencia', 'sel_referencia', $opciones, RECOMENDACIONES_REFERENCIA, $referencia, '', '');
//        $form->addError('error_referencia', ERROR_RECOMENDACIONES_REFERENCIA);
//        
        $form->addEtiqueta(RECOMENDACIONES_FECHA_ENTREGA);
        $form->addInputDate('date', 'txt_fecha_entrega', 'txt_fecha_entrega', $fecha_entrega, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_entrega\');"');
        $form->addError('error_fecha_entrega', ERROR_RECOMENDACIONES_FECHA_ENTREGA);
        
//        $form->addEtiqueta(RECOMENDACIONES_FECHA_LIMITE);
//        $form->addInputDate('date', 'txt_fecha_limite_add', 'txt_fecha_limite_add', $fecha_limite_add, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_limite\');"');
//        $form->addError('error_fecha_limite', ERROR_RECOMENDACIONES_FECHA_LIMITE);

        $estados = $comData->getEstadosCompromisos('1', 'ces_id');
        $opciones = null;
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(RECOMENDACIONES_ESTADO);
        $form->addSelect('select', 'sel_estado_add', 'sel_estado_add', $opciones, RECOMENDACIONES_ESTADO, $estado_add, '', 'onChange=submit();');
        $form->addError('error_estado', ERROR_RECOMENDACIONES_ESTADO);

        $form->addEtiqueta(RECOMENDACIONES_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '100', '6', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_RECOMENDACIONES_OBSERVACIONES);
        //--------------------------------------
        //variables cargadas en el list para no perder los filtros
        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
        $form->addInputText('hidden', 'sel_acta', 'sel_acta', '15', '15', $acta, '', '');
        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', $estado, '', '');
        $form->addInputText('hidden', 'sel_responsable', 'sel_responsable', '15', '15', $responsable, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        //-----------------------------------------

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_recomendaciones();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_recomendaciones\',\'?mod=' . $modulo . '&niv=' . $niv . '&sel_responsable=' . $responsable . '&sel_tema=' . $tema . '&sel_subtema=' . $subtema . '&sel_acta=' . $acta . '&sel_estado=' . $estado . '&operador=' . $operador . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveAdd, permite almacenar el objeto COMPROMISO en la base de datos, ver la clase CRecomendacionesData
     */
    case 'saveAdd':
        //variables filtro cargadas en el list
        $subtema = $_REQUEST['sel_subtema_add'];
        $actividad = $_REQUEST['txt_actividad'];
        $consecutivo = $_REQUEST['txt_consecutivo'];
        $referencia = $_REQUEST['sel_referencia'];
        $responsable = $_REQUEST['sel_responsable_add'];
        $fecha_limite = $_REQUEST['txt_fecha_limite_add'];
        $estado = $_REQUEST['sel_estado_add'];
        $fecha_entrega = $_REQUEST['txt_fecha_entrega'];
        $observaciones = $_REQUEST['txt_observaciones'];
        

        //instancia de la clase de recomendaciones
        $recomendaciones = new CRecomendaciones('', $comData);
        $recomendaciones->setSubtema($subtema);
        $recomendaciones->setActividad($actividad);
        //$recomendaciones->setCosecutivo($consecutivo);
        //$recomendaciones->setReferencia($referencia);
        //$recomendaciones->setFechaLimite($fecha_limite);
        $recomendaciones->setEstado($estado);
        $recomendaciones->setFechaEntrega($fecha_entrega);
        $recomendaciones->setObservaciones($observaciones);
        $recomendaciones->setOperador($operador);
        $recomendaciones->setResponsable($responsable);
        
        //funcion encargada de el ingreso de un nuevo compromiso
        $m = $recomendaciones->saveNewCompromiso();
        
        //redirecciona al list despues de terminar la operacion
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;
    /**
     * la variable delete, permite hacer la carga del objeto COMPROMISO y espera confirmacion de eliminarlo, ver la clase CRecomendaciones
     */
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];

        $recomendaciones = new CRecomendaciones($id_delete, $comData);
        $recomendaciones->loadCompromiso();

        $form = new CHtmlForm();
        $form->setId('frm_delete_recomendaciones');
        $form->setMethod('post');
        //--------------------------------------
        //variables cargadas en el list para no perder los filtros
        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
        $form->addInputText('hidden', 'sel_acta', 'sel_acta', '15', '15', $acta, '', '');
        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', $estado, '', '');
        $form->addInputText('hidden', 'sel_responsable', 'sel_responsable', '15', '15', $responsable, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        //-----------------------------------------
        
        $form->writeForm();

        echo $html->generaAdvertencia(RECOMENDACIONES_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $niv . '&task=confirmDelete&id_element=' . $id_delete . '&sel_tema=' . $tema . '&sel_subtema=' . $subtema . '&sel_responsable=' . $responsable . '&sel_acta=' . $acta . '&sel_estado=' . $estado . '&operador=' . $operador, "cancelarAccion('frm_delete_recomendaciones','?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_responsable=" . $responsable . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador . "')");

        break;
    /**
     * la variable confirmDelete, permite eliminar el objeto COMPROMISO de la base de datos, ver la clase CRecomendacionesData
     */
    case 'confirmDelete':
        $id_delete = $_REQUEST['id_element'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];

        $recomendaciones = new CRecomendaciones($id_delete, $comData);
        //instancia de la clase recomendaciones
        $recomendaciones->loadCompromiso();
        //funcion encargada de la eliminacion de un compromiso
        $m = $recomendaciones->deleteCompromiso();

        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;
    /**
     * la variable edit, permite hacer la carga del objeto COMPROMISO y espera confirmacion de edicion, ver la clase CRecomendaciones
     */
    case 'edit':
        //variable id del elemento que se va a editar
        $id_edit = $_REQUEST['id_element'];
        //variables filtro cargadas en el list
        $subtema = $_REQUEST['sel_subtema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];

        //instancia de la clase de recomendaciones
        $recomendaciones = new CRecomendaciones($id_edit, $comData);
        //funcion que carga los datos en los filtros
        $recomendaciones->loadSeeCompromiso();

        if (!isset($_REQUEST['txt_actividad_edit']))
            $actividad_edit = $recomendaciones->getActividad();
        else
            $actividad_edit = $_REQUEST['txt_actividad_edit'];
        if (!isset($_REQUEST['sel_subtema_edit']))
            $subtema_edit = $recomendaciones->getSubtema();
        else
            $subtema_edit = $_REQUEST['sel_subtema_edit'];
//        if (!isset($_REQUEST['sel_referencia_edit']))
//            $referencia_edit = $recomendaciones->getReferencia();
//        else
//            $referencia_edit = $_REQUEST['sel_referencia_edit'];
//        if (!isset($_REQUEST['txt_fecha_limite_edit']))
//            $fecha_limite_edit = $recomendaciones->getFechaLimite();
//        else
//            $fecha_limite_edit = $_REQUEST['txt_fecha_limite_edit'];
        if (!isset($_REQUEST['txt_fecha_entrega_edit']))
            $fecha_entrega_edit = $recomendaciones->getFechaEntrega();
        else
            $fecha_entrega_edit = $_REQUEST['txt_fecha_entrega_edit'];
        if (!isset($_REQUEST['sel_estado_edit']))
            $estado_edit = $recomendaciones->getEstado();
        else
            $estado_edit = $_REQUEST['sel_estado_edit'];
        if (!isset($_REQUEST['txt_observaciones_edit']))
            $observaciones_edit = $recomendaciones->getObservaciones();
        else
            $observaciones_edit = $_REQUEST['txt_observaciones_edit'];
//        if (!isset($_REQUEST['txt_consecutivo_edit']))
//            $consecutivo_edit = $recomendaciones->getConsecutivo();
//        else
//            $consecutivo_edit = $_REQUEST['txt_consecutivo_edit'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_RECOMENDACIONES);

        $form->setId('frm_edit_recomendaciones');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $recomendaciones->getId(), '', '');

        $subtemas = $comData->getFuentesCompromisos('dot_id = ' . ID_ACTAS, 'dos_nombre');
        $opciones = null;

        if (isset($subtemas)) {
            foreach ($subtemas as $s) {
                $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
            }
        }

        $form->addEtiqueta(COMUNICADO_SUBTEMA);
        $form->addSelect('select', 'sel_subtema_edit', 'sel_subtema_edit', $opciones, COMUNICADO_SUBTEMA, $subtema_edit, '', 'onChange=submit();');
        $form->addError('error_subtema', ERROR_RECOMENDACIONES_FUENTE);
        
        $form->addEtiqueta(RECOMENDACIONES_ACTIVIDAD);
        $form->addTextArea('textarea', 'txt_actividad_edit', 'txt_actividad_edit', '100', '2', $actividad_edit, '', 'onkeypress="ocultarDiv(\'error_actividad\');"');
        $form->addError('error_actividad', ERROR_RECOMENDACIONES_ACTIVIDAD);
//
//        $form->addEtiqueta(RECOMENDACIONES_CONSECUTIVO);
//        $form->addInputText('text', 'txt_consecutivo_edit', 'txt_consecutivo_edit', 10, 10, $consecutivo_edit, '', 'onkeypress="ocultarDiv(\'error_consecutivo\');"');
//        $form->addError('error_consecutivo', ERROR_RECOMENDACIONES_CONSECUTIVO);
        
//        $referencias = $comData->getReferenciasDocumentos(' d.dos_id = ' . $subtema_edit . ' and d.ope_id =' . $operador, 'd.dos_id, d.doc_version'); //modificacion
//        $opciones = null;
//        if (isset($referencias)) {
//            foreach ($referencias as $t) {
//                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
//            }
//        }
//        $form->addEtiqueta(RECOMENDACIONES_REFERENCIA);
//        $form->addSelect('select', 'sel_referencia_edit', 'sel_referencia_edit', $opciones, RECOMENDACIONES_REFERENCIA, $referencia_edit, '', 'onChange=submit();');
//        $form->addError('error_referencia', ERROR_RECOMENDACIONES_REFERENCIA);

        $form->addEtiqueta(RECOMENDACIONES_FECHA_ENTREGA);
        $form->addInputDate('date', 'txt_fecha_entrega_edit', 'txt_fecha_entrega_edit', $fecha_entrega_edit, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_entrega\');"');
        $form->addError('error_fecha_entrega', ERROR_RECOMENDACIONES_FECHA_ENTREGA);
        
//        $form->addEtiqueta(RECOMENDACIONES_FECHA_LIMITE);
//        $form->addInputDate('date', 'txt_fecha_limite_edit', 'txt_fecha_limite_edit', $fecha_limite_edit, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_limite\');"');
//        $form->addError('error_fecha_limite', ERROR_RECOMENDACIONES_FECHA_LIMITE);

        $estados = $comData->getEstadosCompromisos('1', 'ces_id');
        $opciones = null;
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(RECOMENDACIONES_ESTADO);
        $form->addSelect('select', 'sel_estado_edit', 'sel_estado_edit', $opciones, RECOMENDACIONES_ESTADO, $estado_edit, '', 'onChange=submit();');
        $form->addError('error_estado', ERROR_RECOMENDACIONES_ESTADO);

        $form->addEtiqueta(RECOMENDACIONES_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones_edit', 'txt_observaciones_edit', '100', '6', $observaciones_edit, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_RECOMENDACIONES_OBSERVACIONES);

        //--------------------------------------
        //variables cargadas en el list para no perder los filtros
        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
        $form->addInputText('hidden', 'sel_acta', 'sel_acta', '15', '15', $acta, '', '');
        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', $estado, '', '');
        $form->addInputText('hidden', 'sel_responsable', 'sel_responsable', '15', '15', $responsable, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        //-----------------------------------------

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onClick="validar_edit_recomendaciones();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_recomendaciones\',\'?mod=' . $modulo . '&niv=' . $niv . '&operador=' . $operador . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveEdit, permite actualizar el objeto COMPROMISO en la base de datos, ver la clase CRecomendacionesData
     */
    case 'saveEdit':
        //variables filtro cargadas en el list
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];
        //variables cargadas en el edit
        $id_edit = $_REQUEST['txt_id'];
        $actividad_edit = $_REQUEST['txt_actividad_edit'];
        $tema_edit = $_REQUEST['sel_tema_edit'];
        $subtema_edit = $_REQUEST['sel_subtema_edit'];
        $referencia_edit = $_REQUEST['sel_referencia_edit'];
        $fecha_limite_edit = $_REQUEST['txt_fecha_limite_edit'];
        $fecha_entrega_edit = $_REQUEST['txt_fecha_entrega_edit'];
        $estado_edit = $_REQUEST['sel_estado_edit'];
        $observaciones_edit = $_REQUEST['txt_observaciones_edit'];
        $consecutivo_edit = $_REQUEST['txt_consecutivo_edit'];
        //instancia de la clase recomendaciones
        $recomendaciones = new CRecomendaciones($id_edit, $comData);
        $recomendaciones->setActividad($actividad_edit);
        $recomendaciones->setTema($tema);
        $recomendaciones->setSubtema($subtema_edit);
        $recomendaciones->setReferencia($referencia_edit);
        $recomendaciones->setFechaLimite($fecha_limite_edit);
        $recomendaciones->setFechaEntrega($fecha_entrega_edit);
        $recomendaciones->setEstado($estado_edit);
        $recomendaciones->setObservaciones($observaciones_edit);
        $recomendaciones->setOperador($operador);
        $recomendaciones->setCosecutivo($consecutivo_edit);
        //funcion encargada de la edicion de un compromiso
        $m = $recomendaciones->saveEditCompromiso();
        //redirecciona al list despues de terminar la operacion
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;

// **************************************************R E S P O N S A B L E S**************************************************************

    /**
     * la variable listResponsables, permite hacer la carga la página con la lista de objetos RESPONSABLE según los parámetros de entrada
     */
    case 'listResponsables':
        $id_edit = $_REQUEST['id_element'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];
        $responsables = $comData->getResponsables('cr.com_id=' . $id_edit, 'cr.cor_id');

        $dt = new CHtmlDataTable();
        $titulos = array(RECOMENDACIONES_RESPONSABLE,);

        $row_responsables = null;
        $cont = 0;
        if (isset($responsables)) {
            foreach ($responsables as $a) {
                $row_responsables[$cont]['id'] = $a['id'];
                $row_responsables[$cont]['nombre'] = $a['nombre']." ".$a['apellido'];
                $cont++;
            }
        }

        $dt->setDataRows($row_responsables);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_RESPONSABLES);

        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=deleteResponsable&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=addResponsable&id_recomendaciones=" . $id_edit . "&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        $dt->setType(1);

        $dt->writeDataTable($niv);
        $form = new CHtmlForm();
        $form->setId('frm_responsable_recomendaciones');
        $form->setMethod('post');
        //variables cargadas en el list para no perder los filtros
        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
        $form->addInputText('hidden', 'sel_acta', 'sel_acta', '15', '15', $acta, '', '');
        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', $estado, '', '');
        $form->addInputText('hidden', 'sel_responsable', 'sel_responsable', '15', '15', $responsable, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();
        $link = "?mod=" . $modulo . "&task=list&niv=" . $niv . "&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador;
        $html->generaLink($link, 'cancelar.gif', BTN_ATRAS);

        break;
    /**
     * la variable addResponsable, permite hacer la carga la página con las variables que componen el objeto RESPONSABLE, ver la clase CResponsable
     */
    case 'addResponsable':
        $id_recomendaciones = $_REQUEST['id_recomendaciones'];
        $responsable_add = $_REQUEST['sel_responsable_add'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];
        $responsables = $comData->getResponsables('cr.com_id=' . $id_edit, 'cr.cor_id');

        $form = new CHtmlForm();
        $form->setId('frm_add_responsable');
        $form->setClassEtiquetas('td_label');
        $form->setMethod('post');
        $form->addInputText('hidden', 'id_recomendaciones', 'id_recomendaciones', '15', '15', $id_recomendaciones, '', '');
        $criterio = "usu_estado = 1 and usu_id not in (select usu_id from recomendaciones_responsable where com_id = ".$id_recomendaciones.")";
        $responsables = $comData->getResponsablesCompromisos($criterio, 'usu_nombre, usu_apellido');
        $opciones = null;
        if (isset($responsables)) {
            foreach ($responsables as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']." ".$t['apellido']);
            }
        }
        $form->addEtiqueta(RECOMENDACIONES_RESPONSABLE);
        $form->addSelect('select', 'sel_responsable_add', 'sel_responsable_add', $opciones, RECOMENDACIONES_RESPONSABLE, $responsable_add, '', 'onChange=submit();');
        $form->addError('error_responsable', ERROR_RECOMENDACIONES_RESPONSABLE);

        //variables cargadas en el list para no perder los filtros
        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
        $form->addInputText('hidden', 'sel_acta', 'sel_acta', '15', '15', $acta, '', '');
        $form->addInputText('hidden', 'txt_fecha_limite', 'txt_fecha_limite', '15', '15', $fecha_limite, '', '');
        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', $estado, '', '');
        $form->addInputText('hidden', 'sel_responsable', 'sel_responsable', '15', '15', $responsable, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_responsable_recomendaciones();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_responsable\',\'?mod=' . $modulo . '&niv=' . $niv . '&task=listResponsables&id_element=' . $id_recomendaciones . '&operador=' . $operador . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveAddResponsable, permite almacenar el objeto RESPONSABLE en la base de datos, ver la clase CResponsableData
     */
    case 'saveAddResponsable':
        $recomendaciones = $_REQUEST['id_recomendaciones'];
        $nombre = $_REQUEST['sel_responsable_add'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];

        $responsablenuevo = new CRecomendacionesResponsable('', $recomendaciones, $nombre, $resData);
        $m = $responsablenuevo->saveNewResponsable();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $niv . '&task=listResponsables&id_element=' . $recomendaciones . "&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;
    /**
     * la variable deleteResponsable, permite hacer la carga del objeto RESPONSABLE y espera confirmacion de eliminarlo, ver la clase CRecomendacionesResponsable
     */
    case 'deleteResponsable':
        $id_responsable = $_REQUEST['id_element'];
        $responsables = new CRecomendacionesResponsable($id_responsable, '', '', $resData);
        $responsables->loadResponsable();
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];
        $form = new CHtmlForm();
        $form->setId('frm_delete_responsable');
        $form->setMethod('post');
        $form->addInputText('hidden', 'id_responsable', 'id_responsable', '15', '15', $responsables->getId(), '', '');
        $form->addInputText('hidden', 'id_recomendaciones', 'id_recomendaciones', '15', '15', $responsables->getCompromiso(), '', '');
        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
        $form->addInputText('hidden', 'sel_acta', 'sel_acta', '15', '15', $acta, '', '');
        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', $estado, '', '');
        $form->addInputText('hidden', 'sel_responsable', 'sel_responsable', '15', '15', $responsable, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(RESPONSABLE_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $niv . '&task=confirmDeleteResponsable&id_element=' . $id_responsable . "&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador, "cancelarAccion('frm_delete_responsable','?mod=" . $modulo . "&niv=" . $niv . "&task=listResponsables&id_element=" . $responsables->getCompromiso() . "&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador . "')");

        break;
    /**
     * la variable confirmDeleteResponsable, permite eliminar el objeto RESPONSABLE de la base de datos, ver la clase CRecomendacionesResponsableData
     */
    case 'confirmDeleteResponsable':
        $id_responsable = $_REQUEST['id_element'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];
        $responsables = new CRecomendacionesResponsable($id_responsable, '', '', $resData);
        $responsables->loadResponsable();
        $m = $responsables->deleteResponsable();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $niv . '&task=listResponsables&id_element=' . $responsables->getCompromiso() . "&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;
    /**
     * la variable listResumen, permite generar las estadisticas del objeto COMPROMISO a partir de la base de datos
     */
    case 'listResumen':
        $m = $comData->deleteResumen();
        $tema = $_REQUEST['sel_tema'];

        //$criterio = "c.com_id > 0";
        $criterio = 'd.ope_id =' . $operador;
        if (isset($tema) && $tema != -1 && $tema != "") {
            if ($criterio == '')
                $criterio = " d.dot_id = " . $tema;
            else
                $criterio .= " and d.dot_id = " . $tema;
        }

        $form = new CHtmlForm();

        $form->setTitle(RESUMEN_RECOMENDACIONES);
        $form->setId('frm_list_resumen');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $sqlBase = $comData->getCompromisos($criterio, ' c.com_id');
        $cont = 0;
        if (isset($sqlBase)) {
            foreach ($sqlBase as $a) {
                $r = $comData->getResumen($a['doa_nombre'], $operador);
                $cont++;
                if ($r != -1) {
                    $abierto = $r[1];
                    $cerrado = $r[2];
                    $cancelado = $r[3];
                    if ($a[ces_nombre] == 'Abierto')
                        $abierto++;
                    elseif ($a[ces_nombre] == 'Cerrado')
                        $cerrado++;
                    elseif ($a[ces_nombre] == 'Cancelado')
                        $cancelado++;
                    $comData->updateResumen($a['doa_nombre'], $abierto, $cerrado, $cancelado, $operador);
                }
                else {
                    $abierto = 0;
                    $cerrado = 0;
                    $cancelado = 0;
                    if ($a[ces_nombre] == 'Abierto')
                        $abierto = 1;
                    elseif ($a[ces_nombre] == 'Cerrado')
                        $cerrado = 1;
                    elseif ($a[ces_nombre] == 'Cancelado')
                        $cancelado = 1;
                    $comData->insertResumen($a['doa_nombre'], $abierto, $cerrado, $cancelado, $operador);
                }
            }
        }

        $resumen = $comData->getResumenes($operador);
        $dt = new CHtmlDataTable();
        $titulos = array(RECOMENDACIONES_RESPONSABLE, RECOMENDACIONES_ABIERTO,
            RECOMENDACIONES_CERRADO, RECOMENDACIONES_CANCELADO);
        $dt->setDataRows($resumen);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_RECOMENDACIONES);

        $dt->setType(1);
        $pag_crit = "task=listResumen&operador=" . $operador;
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        break;
    /**
     * la variable listResumenExcel, permite generar en excel el objeto DOCUMENTO(comunicado) a partir de la base de datos
     */
    case 'listResumenExcel':

        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        $fecha_fin = $_REQUEST['txt_fecha_fin'];
        $operador = $_REQUEST['operador'];

        $criterio = "";
        if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
            if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (d.doc_fecha >= '" . $fecha_inicio . "' or d.doc_fecha_radicado >= '" . $fecha_inicio . "')";
                } else {
                    $criterio .= " and d.doc_fecha >= '" . $fecha_inicio . "' or d.doc_fecha_radicado >= '" . $fecha_inicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = "( d.doc_fecha between '" . $fecha_inicio . "' and '" . $fecha_fin . "' or d.doc_fecha_radicado between '" . $fecha_inicio . "' and '" . $fecha_fin . "')";
                    ;
                } else {
                    $criterio .= " and d.doc_fecha between '" . $fecha_inicio . "' and '" . $fecha_fin . "' or d.doc_fecha_radicado between '" . $fecha_inicio . "' and '" . $fecha_fin . "')";
                    ;
                }
            }
        }
        if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
            if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( d.doc_fecha <= '" . $fecha_fin . "' or d.doc_fecha_radicado <= '" . $fecha_fin . "')";
                } else {
                    $criterio .= " and d.doc_fecha <= '" . $fecha_fin . "' or d.doc_fecha_radicado <= '" . $fecha_fin . "')";
                }
            }
        }

        $form = new CHtmlForm();
        $form->setTitle(EXCEL_RECOMENDACIONES);
        $form->setId('frm_excel');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(COMPROMISO_FECHA_INICIO_BUSCAR);
        $form->addInputDate('date', 'ftxt_fecha_creacion', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', '');
        $form->addError('error_fecha_inicio', '');

        $form->addEtiqueta(COMPROMISO_FECHA_FIN_BUSCAR);
        $form->addInputDate('date', 'ftxt_fecha_radicacion', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', '');
        $form->addError('error_fecha_fin', '');

        $form->addInputText('hidden', 'txt_host', 'txt_host', '45', '20', $db->host, '', '');
        $form->addInputText('hidden', 'txt_usuario', 'txt_usuario', '45', '20', $db->usuario, '', '');
        $form->addInputText('hidden', 'txt_contrasena', 'txt_password', '45', '20', $db->password, '', '');
        $form->addInputText('hidden', 'txt_basedatos', 'txt_basedatos', '45', '20', $db->database, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '45', '20', $operador, '', '');

        $form->writeForm();

        $form->crearBoton('button', 'guardar', BTN_ACEPTAR, 'onclick="recomendaciones_en_excel();"');

        break;
    /**
     * en caso de que la variable task no este definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');

        break;
}
?>
