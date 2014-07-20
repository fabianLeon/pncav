<?php

/**
 * PNCAV
 *
 * <ul>
 * <li> Redcom Ltda <www.redcom.com.co></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */
/**
 * Modulo Compromisos
 * maneja el modulo COMPROMISOS en union con CCompromiso y CCompromisoData
 *
 * @see CCompromiso
 * @see CCompromisoData
 *
 * @package  modulos
 * @subpackage compromisos
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');
$comData = new CCompromisoData($db);
$docData = new CDocumentoData($db);
$resData = new CCompromisoResponsableData($db);

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
        if(isset($_REQUEST['sel_subtema']))
            $subtema = $_REQUEST['sel_subtema'];
        if (isset($_REQUEST['txt_fecha_inicio']) && $_REQUEST['txt_fecha_inicio'] != '') {
            $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        }
        if(isset($_REQUEST['txt_fecha_fin']) && $_REQUEST['txt_fecha_fin'] != '')
            $fecha_fin = $_REQUEST['txt_fecha_fin'];
        if(isset($_REQUEST['sel_responsable']) && $_REQUEST['sel_responsable'] != '')
        $responsable = $_REQUEST['sel_responsable'];
        if(isset($_REQUEST['sel_estado']) && $_REQUEST['sel_estado'] != '')
            $estado = $_REQUEST['sel_estado'];
        if(isset($_REQUEST['txt_actividad']) && $_REQUEST['txt_actividad'] != '')
            $actividad = $_REQUEST['txt_actividad'];
        if(isset($_REQUEST['txt_consecutivo']) && $_REQUEST['txt_consecutivo'] != '')
            $consecutivo = $_REQUEST['txt_consecutivo'];
        if(isset($_REQUEST['txt_palabras']) && $_REQUEST['txt_palabras'] != '')
            $palabras = $_REQUEST['txt_palabras'];
        
        
        $criterio = "";
        //--------------------------------------------------------------------
        if (isset($subtema) && $subtema != -1 && $subtema != ""){
            if ($criterio == '')
                $criterio = " d.dos_id = " . $subtema;
            else
                $criterio .= " and d.dos_id = " . $subtema;
        }
        //---------------------------------------------------------------------
         if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
            if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (c.com_fecha_limite >= '" . $fecha_inicio . "')";
                } else {
                    $criterio .= " and c.com_fecha_limite >= '" . $fecha_inicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = "( c.com_fecha_limite between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                } else {
                    $criterio .= " and c.com_fecha_limite between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                }
            }
        }
        if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
            if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( c.com_fecha_limite <= '" . $fecha_fin . "')";
                } else {
                    $criterio .= " and c.com_fecha_limite <= '" . $fecha_fin . "')";
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
                if($estado == 1){
                    $criterio = " ( c.com_fecha_limite >= '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
                }elseif ($estado == 3) {
                    $criterio = " ( c.com_fecha_limite < '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
                }else{
                    $criterio .= " c.ces_id = " . $estado;
                }
            else
                if($estado == 1){
                    $criterio .= " and ( c.com_fecha_limite >= '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
                }elseif ($estado == 3) {
                    $criterio .= " and ( c.com_fecha_limite < '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
                }else{
                    $criterio .= " and c.ces_id = " . $estado;
                }
                
        }
        if (isset($actividad) && $actividad != -1 && $actividad != '') {
            if ($criterio == "")
                $criterio .= " c.com_actividad like '%" . $actividad . "%'";
            else
                $criterio .= " and c.com_actividad like '%" . $actividad . "%'";
        }
        if (isset($consecutivo) && $consecutivo != -1 && $consecutivo != '') {
            if ($criterio == "")
                $criterio .= " c.com_consecutivo = '" . $consecutivo . "'";
            else
                $criterio .= " and c.com_consecutivo = '" . $consecutivo . "'";
        }
        if(isset($palabras) & $palabras!=''){
            $claves = split(" ",$palabras);
            $criterio_temp = "";
            foreach ($claves as $c){
                if ($criterio_temp == "")
                    $criterio_temp .= " com_actividad like '%". $c ."%' or com_observaciones like  '%". $c ."%' ";
                else
                    $criterio_temp .= " or com_actividad like '%". $c ."%' or com_observaciones like  '%". $c ."%' ";
            }
            
            if($criterio == "")
                $criterio .= $criterio_temp;
            else
                $criterio .= " and (".$criterio_temp.") ";
            
        }
        
        $html = new CHtml();
        $contador = $comData->contarPorEstado('1',$id_usuario);
        $html->generaScriptAlertLink('verAlertasCompromisos('.$id_usuario.')','('.$contador.')');
        
        $form = new CHtmlForm();

        $form->setTitle(LISTAR_COMPROMISOS);
        $form->setId('frm_list_compromisos');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        $form->addEtiqueta(COMPROMISOS_FECHA_INICIO);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', 'onChange="consultar_compromisos();"');

        $form->addEtiqueta(COMPROMISOS_FECHA_FIN);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', 'onChange="consultar_compromisos();"');

        $subtemas = $comData->getFuentesCompromisos('dot_id = ' . ID_ACTAS, 'dos_nombre');
        $opciones = null;

        if (isset($subtemas)) {
            foreach ($subtemas as $s) {
                $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
            }
        }

        $form->addEtiqueta(COMPROMISOS_FUENTE);
        $form->addSelect('select', 'sel_subtema', 'sel_subtema', $opciones, COMPROMISOS_FUENTE, $subtema, '', 'onChange=submit();');
        $form->addError('error_subtema', '');
        
        $responsables = $comData->getResponsablesCompromisos('1', 'usu_nombre, usu_apellido');
        $opciones = null;
        if (isset($responsables)) {
            foreach ($responsables as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']." ".$t['apellido']);
            }
        }
        $form->addEtiqueta(COMPROMISOS_RESPONSABLE);
        $form->addSelect('select', 'sel_responsable', 'sel_responsable', $opciones, COMPROMISOS_RESPONSABLE, $responsable, '', 'onChange="consultar_compromisos();"');

        $estados = $comData->getEstadosCompromisos('1', 'ces_id');
        $opciones = null;
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(COMPROMISOS_ESTADO);
        $form->addSelect('select', 'sel_estado', 'sel_estado', $opciones, COMPROMISOS_ESTADO, $estado, '', 'onChange="consultar_compromisos();"');

        $form->addEtiqueta(COMPROMISOS_CONSECUTIVO);
        $form->addInputText('text', 'txt_consecutivo', 'txt_consecutivo', '30', '30', $actividad, '', 'onChange="consultar_compromisos();"');

        $form->addEtiqueta(COMPROMISOS_PALABRAS);
        $form->addInputText('text', 'txt_palabras', 'txt_palabras', '30', '30', $palabras, '', 'onChange="consultar_compromisos();"');

        
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_compromisos();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', COMPROMISOS_EXPORTAR, 'button', 'onClick=exportar_excel_compromisos();');
        //$form->addInputButton('button', 'btn_exportar', 'btn_exportar', BTN_CANCELAR, 'button', 'onClick=cancelar_busqueda_compromisos();');
        
        $form->addInputText('hidden', 'txt_criterio', 'txt_criterio', '5', '5', '', '', '');
        
        $form->writeForm();
      
        if ($criterio != "")
            $criterio .= ' and d.ope_id = ' . $operador;
//        if ($criterio == "" && $criterio_busqueda == "1")
//             $criterio = "1";
        if($criterio == "")
            $criterio = "1";
        $dirOperador = $docData->getDirectorioOperador($operador);
        $compromisos = $comData->getCompromisos($criterio, ' c.com_fecha_limite', $dirOperador);
        $contador = count($compromisos);
        $cont = 0;
        $elementos = null;
        while ($cont < $contador) {
            $elementos[$cont]['id'] = $compromisos[$cont]['id'];
            $elementos[$cont]['area'] = $compromisos[$cont]['dos_nombre'];
            $elementos[$cont]['actividad'] = $compromisos[$cont]['com_actividad'];
            $elementos[$cont]['fecha_entrega'] = $compromisos[$cont]['com_fecha_entrega'];
            $elementos[$cont]['autor'] = $compromisos[$cont]['doa_nombre'];
            $elementos[$cont]['consecutivo'] = $compromisos[$cont]['com_consecutivo'];
            $elementos[$cont]['referencia'] = $compromisos[$cont]['doc_referencia'];
            $elementos[$cont]['fecha_limite'] = $compromisos[$cont]['com_fecha_limite'];
            
            //$elementos[$cont]['estado'] = $compromisos[$cont]['ces_nombre'];

            if($compromisos[$cont]['ces_id']==2){
               $elementos[$cont]['estado']="<img src='templates/img/ico/verde.gif'>";
            }
            if($compromisos[$cont]['ces_id']==3){
               $elementos[$cont]['estado']="<img src='templates/img/ico/rojo.gif'>";
            }
            if($compromisos[$cont]['ces_id']==1 || $compromisos[$cont]['ces_id']==3){
                $datetime1 = new DateTime("now");
                $datetime2 = new DateTime($compromisos[$cont]['com_fecha_limite']);
                $interval = $datetime1->diff($datetime2);
                $dias = $interval->days+1;
                if($datetime1->format("Y-m-d") ==  $datetime2->format("Y-m-d"))
                    $elementos[$cont]['estado']="<img src='templates/img/ico/amarillo.gif' align='middle'> ".$dias;
                else if(($datetime1 < $datetime2))
                    //$elementos[$cont]['estado']="<img src='templates/img/ico/amarillo.gif'> ".$interval->format('%d días');
                    $elementos[$cont]['estado']="<img src='templates/img/ico/amarillo.gif' align='middle'> ".$dias;
                else
                    $elementos[$cont]['estado']="<img src='templates/img/ico/rojo.gif' align='middle'> ".$dias;
            }
            
            $elementos[$cont]['observaciones'] = $compromisos[$cont]['com_observaciones'];
            $cont++;
        }
                    
        
        
        $dt = new CHtmlDataTableAlignable();
        $dt->alignColumns = array(2=>'left',4=>'left',5=>'right',8=>'left',9=>'left');
        $dt->wrapColumns = array(3=>'nowrap',7=>'nowrap',8=>'nowrap');
        $titulos = array(COMPROMISOS_FUENTE, COMPROMISOS_ACTIVIDAD, COMPROMISOS_FECHA_ENTREGA, 
                         COMPROMISOS_RESPONSABLE, COMPROMISOS_CONSECUTIVO, COMPROMISOS_REFERENCIA, 
                         COMPROMISOS_FECHA_LIMITE, COMPROMISOS_ESTADO, COMPROMISOS_OBSERVACIONES);
        $dt->setDataRows($elementos);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_COMPROMISOS);
        
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador);

        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=edit&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador);
        

        $otros = array('link' => "?mod=" . $modulo . "&niv=" . $niv . "&task=listResponsables&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador, 'img' => 'responsables.gif', 'alt' => ALT_RESPONSABLES);
        $dt->addOtrosLink($otros);
        
        $otros = array('link' => "?mod=" . $modulo . "&niv=" . $niv . "&task=close&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador, 'img' => 'marcado.gif', 'alt' => ALT_RESPONSABLES);
        $dt->addOtrosLink($otros);
        
        $dt->setType(1);
        $pag_crit = "task=list&txt_fecha_inicio=".$fecha_inicio.
                    "&txt_fecha_fin=".$fecha_fin."&sel_responsable=".$responsable. 
                    "&sel_estado=".$estado."&txt_actividad=".$actividad."&operador=" . $operador;
        $dt->setPag(1, $pag_crit);
        //$dt->setSumColumns(array(4));
        $dt->writeDataTable($niv);
        break;
    /**
     * la variable add, permite hacer la carga la página con las variables que componen el objeto COMPROMISO, ver la clase CCompromiso
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


        $form->setTitle(AGREGAR_COMPROMISOS);
        $form->setId('frm_add_compromiso');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $subtemas = $comData->getFuentesCompromisos('dot_id = ' . ID_ACTAS, 'dos_nombre');
        $opciones = null;

        if (isset($subtemas)) {
            foreach ($subtemas as $s) {
                $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
            }
        }

        $form->addEtiqueta(COMPROMISOS_FUENTE);
        $form->addSelect('select', 'sel_subtema_add', 'sel_subtema_add', $opciones, COMPROMISOS_FUENTE, $subtema_add, '', 'onChange=submit();');
        $form->addError('error_subtema', '');

        $form->addEtiqueta(COMPROMISOS_ACTIVIDAD);
        $form->addTextArea('textarea', 'txt_actividad', 'txt_actividad', '100', '2', $actividad, '', 'onkeypress="ocultarDiv(\'error_actividad\');"');
        $form->addError('error_actividad', ERROR_COMPROMISOS_ACTIVIDAD);

        $form->addEtiqueta(COMPROMISOS_CONSECUTIVO);
        $form->addInputText('text', 'txt_consecutivo', 'txt_consecutivo', '30', '30', $consecutivo, '', 'onkeypress="ocultarDiv(\'error_consecutivo\');"');
        $form->addError('error_consecutivo', ERROR_COMPROMISOS_CONSECUTIVO);
        
        $criterio = "usu_estado = 1 ";
        $responsables = $comData->getResponsablesCompromisos($criterio, 'usu_nombre, usu_apellido');
        $opciones = null;
        if (isset($responsables)) {
            foreach ($responsables as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']." ".$t['apellido']);
            }
        }
        $form->addEtiqueta(COMPROMISOS_RESPONSABLE);
        $form->addSelect('select', 'sel_responsable_add', 'sel_responsable_add', $opciones, COMPROMISOS_RESPONSABLE, $responsable, '', '');
        $form->addError('error_responsable', ERROR_COMPROMISOS_RESPONSABLE);

        
        $referencias = $comData->getReferenciasDocumentos(' d.dos_id = ' . $subtema_add . ' and d.ope_id =' . $operador, 'd.dos_id, d.doc_version'); //modificacion
        $opciones = null;
        if (isset($referencias)) {
            foreach ($referencias as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(COMPROMISOS_REFERENCIA);
        $form->addSelect('select', 'sel_referencia', 'sel_referencia', $opciones, COMPROMISOS_REFERENCIA, $referencia, '', '');
        $form->addError('error_referencia', ERROR_COMPROMISOS_REFERENCIA);
        
        $form->addEtiqueta(COMPROMISOS_FECHA_ENTREGA);
        $form->addInputDate('date', 'txt_fecha_entrega', 'txt_fecha_entrega', $fecha_entrega, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_entrega\');"');
        $form->addError('error_fecha_entrega', ERROR_COMPROMISOS_FECHA_ENTREGA);
        
        $form->addEtiqueta(COMPROMISOS_FECHA_LIMITE);
        $form->addInputDate('date', 'txt_fecha_limite_add', 'txt_fecha_limite_add', $fecha_limite_add, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_limite\');"');
        $form->addError('error_fecha_limite', ERROR_COMPROMISOS_FECHA_LIMITE);

//        $estados = $comData->getEstadosCompromisos('1', 'ces_id');
//        $opciones = null;
//        if (isset($estados)) {
//            foreach ($estados as $t) {
//                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
//            }
//        }
//        
//        $form->addEtiqueta(COMPROMISOS_ESTADO);
//        $form->addSelect('select', 'sel_estado_add', 'sel_estado_add', $opciones, COMPROMISOS_ESTADO, $estado_add, '', 'onChange=submit();');
//        $form->addError('error_estado', ERROR_COMPROMISOS_ESTADO);

        $form->addEtiqueta(COMPROMISOS_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones', 'txt_observaciones', '100', '6', $observaciones, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_COMPROMISOS_OBSERVACIONES);
        //--------------------------------------
        //variables cargadas en el list para no perder los filtros
//        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
//        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
//        $form->addInputText('hidden', 'sel_acta', 'sel_acta', '15', '15', $acta, '', '');
//        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', 1, '', '');
//        $form->addInputText('hidden', 'sel_responsable', 'sel_responsable', '15', '15', $responsable, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        //-----------------------------------------

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_compromiso();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_compromiso\',\'?mod=' . $modulo . '&niv=' . $niv . '&sel_responsable=' . $responsable . '&sel_tema=' . $tema . '&sel_subtema=' . $subtema . '&sel_acta=' . $acta . '&sel_estado=' . $estado . '&operador=' . $operador . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveAdd, permite almacenar el objeto COMPROMISO en la base de datos, ver la clase CCompromisoData
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
        

        //instancia de la clase de compromisos
        $compromiso = new CCompromiso('', $comData);
        $compromiso->setSubtema($subtema);
        $compromiso->setActividad($actividad);
        $compromiso->setCosecutivo($consecutivo);
        $compromiso->setReferencia($referencia);
        $compromiso->setFechaLimite($fecha_limite);
        $compromiso->setEstado(1);
        $compromiso->setFechaEntrega($fecha_entrega);
        $compromiso->setObservaciones($observaciones);
        $compromiso->setOperador($operador);
        $compromiso->setResponsable($responsable);
        
        //funcion encargada de el ingreso de un nuevo compromiso
        $m = $compromiso->saveNewCompromiso();
        
        //redirecciona al list despues de terminar la operacion
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;
    /**
     * la variable delete, permite hacer la carga del objeto COMPROMISO y espera confirmacion de eliminarlo, ver la clase CCompromiso
     */
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];

        $compromiso = new CCompromiso($id_delete, $comData);
        $compromiso->loadCompromiso();

        $form = new CHtmlForm();
        $form->setId('frm_delete_compromiso');
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

        echo $html->generaAdvertencia(COMPROMISO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $niv . '&task=confirmDelete&id_element=' . $id_delete . '&sel_tema=' . $tema . '&sel_subtema=' . $subtema . '&sel_responsable=' . $responsable . '&sel_acta=' . $acta . '&sel_estado=' . $estado . '&operador=' . $operador, "cancelarAccion('frm_delete_compromiso','?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_responsable=" . $responsable . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador . "')");

        break;
    /**
     * la variable confirmDelete, permite eliminar el objeto COMPROMISO de la base de datos, ver la clase CCompromisoData
     */
    case 'confirmDelete':
        $id_delete = $_REQUEST['id_element'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];

        $compromiso = new CCompromiso($id_delete, $comData);
        //instancia de la clase compromisos
        $compromiso->loadCompromiso();
        //funcion encargada de la eliminacion de un compromiso
        $m = $compromiso->deleteCompromiso();

        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;
    /**
     * la variable edit, permite hacer la carga del objeto COMPROMISO y espera confirmacion de edicion, ver la clase CCompromiso
     */
    case 'edit':
        //variable id del elemento que se va a editar
        $id_edit = $_REQUEST['id_element'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $subtema = $_REQUEST['sel_subtema'];
        $acta = $_REQUEST['sel_acta'];
        //$estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];

        //instancia de la clase de compromisos
        $compromiso = new CCompromiso($id_edit, $comData);
        //funcion que carga los datos en los filtros
        $compromiso->loadSeeCompromiso();

        if (!isset($_REQUEST['txt_actividad_edit']))
            $actividad_edit = $compromiso->getActividad();
        else
            $actividad_edit = $_REQUEST['txt_actividad_edit'];
        if (!isset($_REQUEST['sel_tema_edit']))
            $tema_edit = $compromiso->getTema();
        else
            $tema_edit = $_REQUEST['sel_tema_edit'];
        if (!isset($_REQUEST['sel_subtema_edit']))
            $subtema_edit = $compromiso->getSubtema();
        else
            $subtema_edit = $_REQUEST['sel_subtema_edit'];
        if (!isset($_REQUEST['sel_referencia_edit']))
            $referencia_edit = $compromiso->getReferencia();
        else
            $referencia_edit = $_REQUEST['sel_referencia_edit'];
        if (!isset($_REQUEST['txt_fecha_limite_edit']))
            $fecha_limite_edit = $compromiso->getFechaLimite();
        else
            $fecha_limite_edit = $_REQUEST['txt_fecha_limite_edit'];
        if (!isset($_REQUEST['txt_fecha_entrega_edit']))
            $fecha_entrega_edit = $compromiso->getFechaEntrega();
        else
            $fecha_entrega_edit = $_REQUEST['txt_fecha_entrega_edit'];
        if (!isset($_REQUEST['sel_estado_edit']))
            $estado_edit = $compromiso->getEstado();
        else
            $estado_edit = $_REQUEST['sel_estado_edit'];
        if (!isset($_REQUEST['txt_observaciones_edit']))
            $observaciones_edit = $compromiso->getObservaciones();
        else
            $observaciones_edit = $_REQUEST['txt_observaciones_edit'];
        if (!isset($_REQUEST['txt_consecutivo_edit']))
            $consecutivo_edit = $compromiso->getConsecutivo();
        else
            $consecutivo_edit = $_REQUEST['txt_consecutivo_edit'];

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_COMPROMISOS);

        $form->setId('frm_edit_compromiso');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $compromiso->getId(), '', '');

        $subtemas = $docData->getSubtemas('dot_id = ' . $tema_edit, 'dos_nombre');
        $opciones = null;

        if (isset($subtemas)) {
            foreach ($subtemas as $s) {
                $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
            }
        }

        $form->addEtiqueta(COMUNICADO_SUBTEMA);
        $form->addSelect('select', 'sel_subtema_edit', 'sel_subtema_edit', $opciones, COMUNICADO_SUBTEMA, $subtema_edit, '', 'onChange=submit();');
        $form->addError('error_subtema', '');
        
        $form->addEtiqueta(COMPROMISOS_ACTIVIDAD);
        $form->addTextArea('textarea', 'txt_actividad_edit', 'txt_actividad_edit', '100', '2', $actividad_edit, '', 'onkeypress="ocultarDiv(\'error_actividad\');"');
        $form->addError('error_actividad', ERROR_COMPROMISOS_ACTIVIDAD);

        $form->addEtiqueta(COMPROMISOS_CONSECUTIVO);
        $form->addInputText('text', 'txt_consecutivo_edit', 'txt_consecutivo_edit', 10, 10, $consecutivo_edit, '', 'onkeypress="ocultarDiv(\'error_consecutivo\');"');
        $form->addError('error_consecutivo', ERROR_COMPROMISOS_CONSECUTIVO);
        
        $referencias = $comData->getReferenciasDocumentos(' d.dos_id = ' . $subtema_edit . ' and d.ope_id =' . $operador, 'd.dos_id, d.doc_version'); //modificacion
        $opciones = null;
        if (isset($referencias)) {
            foreach ($referencias as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(COMPROMISOS_REFERENCIA);
        $form->addSelect('select', 'sel_referencia_edit', 'sel_referencia_edit', $opciones, COMPROMISOS_REFERENCIA, $referencia_edit, '', 'onChange=submit();');
        $form->addError('error_referencia', ERROR_COMPROMISOS_REFERENCIA);

        $form->addEtiqueta(COMPROMISOS_FECHA_ENTREGA);
        $form->addInputDate('date', 'txt_fecha_entrega_edit', 'txt_fecha_entrega_edit', $fecha_entrega_edit, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_entrega\');"');
        $form->addError('error_fecha_entrega', ERROR_COMPROMISOS_FECHA_ENTREGA);
        
        $form->addEtiqueta(COMPROMISOS_FECHA_LIMITE);
        $form->addInputDate('date', 'txt_fecha_limite_edit', 'txt_fecha_limite_edit', $fecha_limite_edit, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_limite\');"');
        $form->addError('error_fecha_limite', ERROR_COMPROMISOS_FECHA_LIMITE);

//        $estados = $comData->getEstadosCompromisos('1', 'ces_id');
//        $opciones = null;
//        if (isset($estados)) {
//            foreach ($estados as $t) {
//                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
//            }
//        }
//        $form->addEtiqueta(COMPROMISOS_ESTADO);
//        $form->addSelect('select', 'sel_estado_edit', 'sel_estado_edit', $opciones, COMPROMISOS_ESTADO, $estado_edit, '', 'onChange=submit();');
//        $form->addError('error_estado', ERROR_COMPROMISOS_ESTADO);

        $form->addEtiqueta(COMPROMISOS_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observaciones_edit', 'txt_observaciones_edit', '100', '6', $observaciones_edit, '', 'onkeypress="ocultarDiv(\'error_observaciones\');"');
        $form->addError('error_observaciones', ERROR_COMPROMISOS_OBSERVACIONES);

        //--------------------------------------
        //variables cargadas en el list para no perder los filtros
        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
        $form->addInputText('hidden', 'sel_acta', 'sel_acta', '15', '15', $acta, '', '');
        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', $estado, '', '');
        $form->addInputText('hidden', 'sel_responsable', 'sel_responsable', '15', '15', $responsable, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');
        //-----------------------------------------

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_compromiso();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_compromiso\',\'?mod=' . $modulo . '&niv=' . $niv . '&operador=' . $operador . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveEdit, permite actualizar el objeto COMPROMISO en la base de datos, ver la clase CCompromisoData
     */
    case 'saveEdit':
        //variables filtro cargadas en el list
        //$estado = $_REQUEST['sel_estado'];
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
        //instancia de la clase compromisos
        $compromiso = new CCompromiso($id_edit, $comData);
        $compromiso->loadCompromiso();
        $compromiso->setActividad($actividad_edit);
        $compromiso->setTema($tema);
        $compromiso->setSubtema($subtema_edit);
        $compromiso->setReferencia($referencia_edit);
        $compromiso->setFechaLimite($fecha_limite_edit);
        $compromiso->setFechaEntrega($fecha_entrega_edit);
        //$compromiso->setEstado($estado_edit);
        $compromiso->setObservaciones($observaciones_edit);
        $compromiso->setOperador($operador);
        $compromiso->setCosecutivo($consecutivo_edit);
        //funcion encargada de la edicion de un compromiso
        $m = $compromiso->saveEditCompromiso();
        //redirecciona al list despues de terminar la operacion
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;
    //permite cambiar el estado del compromiso a respondido
    case 'close':
        //variable id del elemento que se va a editar
        $id_edit = $_REQUEST['id_element'];
        $compromiso = new CCompromiso($id_edit, $comData);
        $compromiso->loadCompromiso();
        if($compromiso->getEstado()!=2)
            $compromiso->setEstado(2);
        else
            $compromiso->setEstado(1);
        //funcion encargada de la edicion de un compromiso
        $m = $compromiso->saveEditCompromiso();
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
        $titulos = array(COMPROMISOS_RESPONSABLE,);

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
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=addResponsable&id_compromiso=" . $id_edit . "&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        $dt->setType(1);

        $dt->writeDataTable($niv);
        $form = new CHtmlForm();
        $form->setId('frm_responsable_compromiso');
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
        $id_compromiso = $_REQUEST['id_compromiso'];
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
        $form->addInputText('hidden', 'id_compromiso', 'id_compromiso', '15', '15', $id_compromiso, '', '');
        $criterio = "usu_estado = 1 and usu_id not in (select usu_id from compromiso_responsable where com_id = ".$id_compromiso.")";
        $responsables = $comData->getResponsablesCompromisos($criterio, 'usu_nombre, usu_apellido');
        $opciones = null;
        if (isset($responsables)) {
            foreach ($responsables as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']." ".$t['apellido']);
            }
        }
        $form->addEtiqueta(COMPROMISOS_RESPONSABLE);
        $form->addSelect('select', 'sel_responsable_add', 'sel_responsable_add', $opciones, COMPROMISOS_RESPONSABLE, $responsable_add, '', 'onChange=submit();');
        $form->addError('error_responsable', ERROR_COMPROMISOS_RESPONSABLE);

        //variables cargadas en el list para no perder los filtros
        $form->addInputText('hidden', 'sel_tema', 'sel_tema', '15', '15', $tema, '', '');
        $form->addInputText('hidden', 'sel_subtema', 'sel_subtema', '15', '15', $subtema, '', '');
        $form->addInputText('hidden', 'sel_acta', 'sel_acta', '15', '15', $acta, '', '');
        $form->addInputText('hidden', 'txt_fecha_limite', 'txt_fecha_limite', '15', '15', $fecha_limite, '', '');
        $form->addInputText('hidden', 'sel_estado', 'sel_estado', '15', '15', $estado, '', '');
        $form->addInputText('hidden', 'sel_responsable', 'sel_responsable', '15', '15', $responsable, '', '');
        $form->addInputText('hidden', 'operador', 'operador', '15', '15', $operador, '', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_responsable();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_responsable\',\'?mod=' . $modulo . '&niv=' . $niv . '&task=listResponsables&id_element=' . $id_compromiso . '&operador=' . $operador . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveAddResponsable, permite almacenar el objeto RESPONSABLE en la base de datos, ver la clase CResponsableData
     */
    case 'saveAddResponsable':
        $compromiso = $_REQUEST['id_compromiso'];
        $nombre = $_REQUEST['sel_responsable_add'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];

        $responsablenuevo = new CCompromisoResponsable('', $compromiso, $nombre, $resData);
        $m = $responsablenuevo->saveNewResponsable();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $niv . '&task=listResponsables&id_element=' . $compromiso . "&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;
    /**
     * la variable deleteResponsable, permite hacer la carga del objeto RESPONSABLE y espera confirmacion de eliminarlo, ver la clase CCompromisoResponsable
     */
    case 'deleteResponsable':
        $id_responsable = $_REQUEST['id_element'];
        $responsables = new CCompromisoResponsable($id_responsable, '', '', $resData);
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
        $form->addInputText('hidden', 'id_compromiso', 'id_compromiso', '15', '15', $responsables->getCompromiso(), '', '');
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
     * la variable confirmDeleteResponsable, permite eliminar el objeto RESPONSABLE de la base de datos, ver la clase CCompromisoResponsableData
     */
    case 'confirmDeleteResponsable':
        $id_responsable = $_REQUEST['id_element'];
        //variables filtro cargadas en el list
        $tema = $_REQUEST['sel_tema'];
        $acta = $_REQUEST['sel_acta'];
        $estado = $_REQUEST['sel_estado'];
        $responsable = $_REQUEST['sel_responsable'];
        $subtema = $_REQUEST['sel_subtema'];
        $responsables = new CCompromisoResponsable($id_responsable, '', '', $resData);
        $responsables->loadResponsable();
        $m = $responsables->deleteResponsable();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=' . $niv . '&task=listResponsables&id_element=' . $responsables->getCompromiso() . "&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . '&operador=' . $operador);

        break;
   
    case 'alertas':
        
        if (isset($_REQUEST['txt_fecha_inicio']) && $_REQUEST['txt_fecha_inicio'] != '') {
            $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        }
        if(isset($_REQUEST['txt_fecha_fin']) && $_REQUEST['txt_fecha_fin'] != '')
            $fecha_fin = $_REQUEST['txt_fecha_fin'];
        if(isset($_REQUEST['sel_responsable']) && $_REQUEST['sel_responsable'] != '')
        $responsable = $_REQUEST['sel_responsable'];
        if(isset($_REQUEST['sel_estado']) && $_REQUEST['sel_estado'] != '')
            $estado = $_REQUEST['sel_estado'];
        if(isset($_REQUEST['txt_actividad']) && $_REQUEST['txt_actividad'] != '')
            $actividad = $_REQUEST['txt_actividad'];
        if(isset($_REQUEST['txt_consecutivo']) && $_REQUEST['txt_consecutivo'] != '')
            $consecutivo = $_REQUEST['txt_consecutivo'];
        
        
        
        $criterio = "";
         if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {
            if (!isset($fecha_fin) || $fecha_fin == '' || $fecha_fin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (c.com_fecha_limite >= '" . $fecha_inicio . "')";
                } else {
                    $criterio .= " and c.com_fecha_limite >= '" . $fecha_inicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = "( c.com_fecha_limite between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                } else {
                    $criterio .= " and c.com_fecha_limite between '" . $fecha_inicio .
                            "' and '" . $fecha_fin . "')";
                    ;
                }
            }
        }
        if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
            if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( c.com_fecha_limite <= '" . $fecha_fin . "')";
                } else {
                    $criterio .= " and c.com_fecha_limite <= '" . $fecha_fin . "')";
                }
            }
        }
        if (isset($responsable) && $responsable != -1 && $responsable != "") {
            if ($criterio == '')
                $criterio = " cr.usu_id = " . $responsable;
            else
                $criterio .= " and cr.usu_id = " . $responsable;
        }else{
            if ($criterio == '')
                $criterio = " cr.usu_id = " . $id_usuario;
            else
                $criterio .= " and cr.usu_id = " . $id_usuario;
        }
        if (isset($estado) && $estado != -1 && $estado != '') {
            if ($criterio == "")
                if($estado == 1){
                    $criterio = " ( c.com_fecha_limite >= '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
                }elseif ($estado == 3) {
                    $criterio = " ( c.com_fecha_limite < '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
                }else{
                    $criterio .= " c.ces_id = " . $estado;
                }
            else
                if($estado == 1){
                    $criterio .= " and ( c.com_fecha_limite >= '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
                }elseif ($estado == 3) {
                    $criterio .= " and ( c.com_fecha_limite < '" . date("Y-m-d") . "') and c.ces_id <> 2 ";
                }else{
                    $criterio .= " and c.ces_id = " . $estado;
                }
                
        }else{
            if ($criterio == ""){
                $criterio = " c.ces_id <> 2 ";
            }else{
                $criterio .= " and c.ces_id <> 2 ";
            }
        }
        if (isset($actividad) && $actividad != -1 && $actividad != '') {
            if ($criterio == "")
                $criterio .= " c.com_actividad like '%" . $actividad . "%'";
            else
                $criterio .= " and c.com_actividad like '%" . $actividad . "%'";
        }
        if (isset($consecutivo) && $consecutivo != -1 && $consecutivo != '') {
            if ($criterio == "")
                $criterio .= " c.com_consecutivo = '" . $consecutivo . "'";
            else
                $criterio .= " and c.com_consecutivo = '" . $consecutivo . "'";
        }
        
        $form = new CHtmlForm();

        $form->setTitle(LISTAR_COMPROMISOS);
        $form->setId('frm_list_compromisos');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        $form->addEtiqueta(COMPROMISOS_FECHA_INICIO);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', 'onChange="consultar_compromisos_alarmas();"');

        $form->addEtiqueta(COMPROMISOS_FECHA_FIN);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', 'onChange="consultar_compromisos_alarmas();"');

        $responsables = $comData->getResponsablesCompromisos('usu_id = '.$id_usuario, 'usu_nombre, usu_apellido');
        $opciones = null;
        if (isset($responsables)) {
            foreach ($responsables as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']." ".$t['apellido']);
            }
        }
        $form->addEtiqueta(COMPROMISOS_RESPONSABLE);
        $form->addSelect('select', 'sel_responsable', 'sel_responsable', $opciones, COMPROMISOS_RESPONSABLE, $responsable, '', 'onChange="consultar_compromisos_alarmas();"');

        $estados = $comData->getEstadosCompromisos('ces_id <> 2', 'ces_id');
        $opciones = null;
        if (isset($estados)) {
            foreach ($estados as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(COMPROMISOS_ESTADO);
        $form->addSelect('select', 'sel_estado', 'sel_estado', $opciones, COMPROMISOS_ESTADO, $estado, '', 'onChange="consultar_compromisos_alarmas();"');

        $form->addEtiqueta(COMPROMISOS_CONSECUTIVO);
        $form->addInputText('text', 'txt_consecutivo', 'txt_consecutivo', '30', '30', $actividad, '', 'onChange="consultar_compromisos_alarmas();"');

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_compromisos_alarmas();');
        //$form->addInputButton('button', 'btn_exportar', 'btn_exportar', COMPROMISOS_EXPORTAR, 'button', 'onClick=exportar_excel_compromisos();');
        //$form->addInputButton('button', 'btn_exportar', 'btn_exportar', BTN_CANCELAR, 'button', 'onClick=cancelar_busqueda_compromisos();');
        
        $form->addInputText('hidden', 'txt_criterio', 'txt_criterio', '5', '5', '', '', '');
        
        $form->writeForm();
      
        if ($criterio != "")
            $criterio .= ' and d.ope_id = ' . $operador;
//        if ($criterio == "" && $criterio_busqueda == "1")
//             $criterio = "1";
        if($criterio == "")
            $criterio = "1";
        $dirOperador = $docData->getDirectorioOperador($operador);
        $compromisos = $comData->getCompromisos($criterio, ' c.com_fecha_limite', $dirOperador);
        $contador = count($compromisos);
        $cont = 0;
        $elementos = null;
        while ($cont < $contador) {
            $elementos[$cont]['id'] = $compromisos[$cont]['id'];
            $elementos[$cont]['area'] = $compromisos[$cont]['dos_nombre'];
            $elementos[$cont]['actividad'] = $compromisos[$cont]['com_actividad'];
            $elementos[$cont]['fecha_entrega'] = $compromisos[$cont]['com_fecha_entrega'];
            $elementos[$cont]['autor'] = $compromisos[$cont]['doa_nombre'];
            $elementos[$cont]['consecutivo'] = $compromisos[$cont]['com_consecutivo'];
            $elementos[$cont]['referencia'] = $compromisos[$cont]['doc_referencia'];
            $elementos[$cont]['fecha_limite'] = $compromisos[$cont]['com_fecha_limite'];
            
            //$elementos[$cont]['estado'] = $compromisos[$cont]['ces_nombre'];

            if($compromisos[$cont]['ces_id']==2){
               $elementos[$cont]['estado']="<img src='templates/img/ico/verde.gif'>";
            }
            if($compromisos[$cont]['ces_id']==3){
               $elementos[$cont]['estado']="<img src='templates/img/ico/rojo.gif'>";
            }
            if($compromisos[$cont]['ces_id']==1 || $compromisos[$cont]['ces_id']==3){
                $datetime1 = new DateTime("now");
                $datetime2 = new DateTime($compromisos[$cont]['com_fecha_limite']);
                $interval = $datetime1->diff($datetime2);
                $dias = $interval->days+1;
                if($datetime1->format("Y-m-d") ==  $datetime2->format("Y-m-d"))
                    $elementos[$cont]['estado']="<img src='templates/img/ico/amarillo.gif' align='middle'> ".$dias;
                else if(($datetime1 < $datetime2))
                    //$elementos[$cont]['estado']="<img src='templates/img/ico/amarillo.gif'> ".$interval->format('%d días');
                    $elementos[$cont]['estado']="<img src='templates/img/ico/amarillo.gif' align='middle'> ".$dias;
                else
                    $elementos[$cont]['estado']="<img src='templates/img/ico/rojo.gif' align='middle'> ".$dias;
            }
            
            $elementos[$cont]['observaciones'] = $compromisos[$cont]['com_observaciones'];
            $cont++;
        }
                    
        
        
        $dt = new CHtmlDataTableAlignable();
        $dt->alignColumns = array(2=>'left',4=>'left',5=>'right',8=>'left',9=>'left');
        $dt->wrapColumns = array(3=>'nowrap',7=>'nowrap',8=>'nowrap');
        $titulos = array(COMPROMISOS_FUENTE, COMPROMISOS_ACTIVIDAD, COMPROMISOS_FECHA_ENTREGA, 
                         COMPROMISOS_RESPONSABLE, COMPROMISOS_CONSECUTIVO, COMPROMISOS_REFERENCIA, 
                         COMPROMISOS_FECHA_LIMITE, COMPROMISOS_ESTADO, COMPROMISOS_OBSERVACIONES);
        $dt->setDataRows($elementos);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_COMPROMISOS);
        
        //$dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador);

        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador);
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=edit&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador);
        

        $otros = array('link' => "?mod=" . $modulo . "&niv=" . $niv . "&task=listResponsables&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador, 'img' => 'responsables.gif', 'alt' => ALT_RESPONSABLES);
        $dt->addOtrosLink($otros);
        
        $otros = array('link' => "?mod=" . $modulo . "&niv=" . $niv . "&task=close&sel_responsable=" . $responsable . "&sel_tema=" . $tema . "&sel_subtema=" . $subtema . "&sel_acta=" . $acta . "&sel_estado=" . $estado . "&operador=" . $operador, 'img' => 'marcado.gif', 'alt' => ALT_RESPONSABLES);
        $dt->addOtrosLink($otros);
        
        $dt->setType(1);
        $pag_crit = "task=alertas&txt_fecha_inicio=".$fecha_inicio.
                    "&txt_fecha_fin=".$fecha_fin."&sel_responsable=".$responsable. 
                    "&sel_estado=".$estado."&txt_actividad=".$actividad."&operador=" . $operador;
        $dt->setPag(1, $pag_crit);
        //$dt->setSumColumns(array(4));
        $dt->writeDataTable($niv);
        break;
    /**
     * en caso de que la variable task no este definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');

        break;
}
?>
