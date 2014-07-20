<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');


$docData = new CDocumentoData($db);
$corrData = new CCorrespondenciaData($db);
$task = $_REQUEST['task'];
$perfil=$corrData->getNamePerfilByIdUsuario($id_usuario);

if (empty($task)) {
    $task = 'list';
}

switch ($task) {
    /**
     * la variable list, permite hacer la carga la página con la lista de 
     * objetos DOCUMENTO ACTA según los parámetros de entrada
     */
    case 'list':
        $perfil['nombre'];
        $referencia = $_REQUEST['txt_referencia'];
        $operador = $_REQUEST['operador'];
        $fechaInicio = $_REQUEST['txt_fecha_inicio'];
        $fechaFin = $_REQUEST['txt_fecha_fin'];
        $autor = $_REQUEST['sel_autor'];        
        $area = $_REQUEST['sel_area'];
        $subtema = $_REQUEST['sel_subtema'];
        $destinatario = $_REQUEST['sel_destinatario'];
        $codigoReferencia = $_REQUEST['txt_codigo_referencia'];
        if(isset($_REQUEST['txt_palabras']) && $_REQUEST['txt_palabras'] != '')
            $palabras = $_REQUEST['txt_palabras'];
        
        if ($criterio_alarmas == "") {
            $criterio_alarmas = " d.ope_id = " . CORRESPONDECIA_OPERADOR . 
                    " and d.dot_id > 3  and d.usu_id=".$id_usuario;
        }else{
            $criterio_alarmas .= " and d.ope_id = " . CORRESPONDECIA_OPERADOR . 
                    " and d.dot_id > 3  and d.usu_id=".$id_usuario;
            
        }
        if ($criterio_alarmas == "") {
            //$criterio_alarmas = " doe.doe_id <> 1 and doe.doe_id <> 2 ";
            $criterio_alarmas = " doe.doe_id <> 2 ";
        }else{
            //$criterio_alarmas .= " and doe.doe_id <> 1 and doe.doe_id <> 2 ";
            $criterio_alarmas .= " and doe.doe_id <> 2 ";
        }
        $alarmas_correspondencia = $corrData->getCorrespondenciaAlarmas($criterio_alarmas, 'doc_fecha_radicado');
        $cont = count($alarmas_correspondencia);
        
        $criterio = "";
        //-------------------------------criterios---------------------------
        if (isset($fechaInicio) && $fechaInicio != '' && $fechaInicio != '0000-00-00') {
            if (!isset($fechaFin) || $fechaFin == '' || $fechaFin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (d.doc_fecha_radicado >= '" . $fechaInicio . "')";
                } else {
                    $criterio .= " and d.doc_fecha_radicado >= '" . $fechaInicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = " (d.doc_fecha_radicado between '" . $fechaInicio .
                            "' and '" . $fechaFin . "')";
                } else {
                    $criterio .= " and d.doc_fecha_radicado between '" . $fechaInicio .
                            "' and '" . $fechaFin . "')";
                }
            }
        }
        if (isset($fechaFin) && $fechaFin != '' && $fechaFin != '0000-00-00') {
            if (!isset($fechaInicio) || $fechaInicio == '' || $fechaInicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( d.doc_fecha_radicado <= '" . $fechaFin . "')";
                } else {
                    $criterio .= " and d.doc_fecha_radicado <= '" . $fechaFin . "')";
                }
            }
        }
        if($perfil['nombre']!="ANDIRED"){
            if (isset($autor) && $autor != -1 && $autor != '') {
                if ($criterio == "") {
                    $criterio = " d.doa_id_autor = " . $autor;
                } else {
                    $criterio .= " and d.doa_id_autor = " . $autor;
                }
            }
            //////////////////////////////
            if (isset($area) && $area != -1 && $area != '') {
                if ($criterio == "") {
                    $criterio = " d.dot_id = " . $area;
                } else {
                    $criterio .= " and d.dot_id = " . $area;
                }
            }
            //////////////////////////////////////////////
            if (isset($subtema) && $subtema != -1 && $subtema != '') {
                if ($criterio == "") {
                    $criterio = " d.dos_id = " . $subtema;
                } else {
                    $criterio .= " and d.dos_id = " . $subtema;
                }
            }
            if (isset($destinatario) && $destinatario != -1 && $destinatario != '') {
                if ($criterio == "") {
                    $criterio = " d.doa_id_dest = " . $destinatario;
                } else {
                    $criterio .= " and d.doa_id_dest = " . $destinatario;
                }
            }

            if (isset($codigoReferencia) && $codigoReferencia != '') {
                if ($criterio == "") {
                    $criterio = " d.doc_codigo_ref = '" . $codigoReferencia. "'";
                } else {
                    $criterio .= " and d.doc_codigo_ref = '" . $codigoReferencia. "'";
                }
            }
            //-----------------------------------------------------------
            if(isset($palabras) & $palabras!=''){
                $claves = split(" ",$palabras);
                $criterio_temp = "";
                foreach ($claves as $c){
                    if ($criterio_temp == "")
                        $criterio_temp .= " d.doc_descripcion like '%". $c ."%' ";
                    else
                        $criterio_temp .= " or d.doc_descripcion like '%". $c ."%' ";
                }

                if($criterio == "")
                    $criterio .= $criterio_temp;
                else
                    $criterio .= " and (".$criterio_temp.") ";

            }
            //------------------------------------------------------------
        }else{
            if ($criterio == "") {
                $criterio = " d.usu_id = " . $id_usuario;
            } else {
                $criterio .= " and d.usu_id = " . $id_usuario;
            }
        }

        if ($criterio == "") {
            $criterio = " d.ope_id = " . CORRESPONDECIA_OPERADOR . " and d.dot_id > 3 ";
        }

        //-----------------------end criterios-------------
        /*
         * Inicio formulario
         */

        $html = new CHtml('');
        $html->generaScriptAlertLink('verAlertasCorrespondencia()','('.$cont.')');
        
        $form = new CHtmlForm();

        $form->setTitle(TABLA_CORRESPONDENCIA);
        $form->setId('frm_list_correspondencia');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        //$form->setOptions('autoClean', false);

        $form->addEtiqueta(CORRESPONDENCIA_FECHA_INICIO);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fechaInicio, '%Y-%m-%d', '16', '16', '', '');

        $form->addEtiqueta(CORRESPONDENCIA_FECHA_FIN);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fechaFin, '%Y-%m-%d', '16', '16', '', '');
        
        if($perfil['nombre']!="ANDIRED"){
            /*
             * Consultar los autores almacenados, solo siglas.
             */
            $autores = $corrData->getActores(' ope_id = ' . CORRESPONDECIA_OPERADOR, 'doa_sigla');
            $opciones = null;
            if (isset($autores)) {
                foreach ($autores as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addEtiqueta(CORRESPONDENCIA_AUTOR);
            $form->addSelect('select', 'sel_autor', 'sel_autor', $opciones, CORRESPONDENCIA_AUTOR, $autor, '', 'onChange=submit();');

            /*
             * Consultar las areas almacenadas.
             */
            $opciones = null;
            $areas = $corrData->getAreas('dot_id  >3', 'dot_nombre');
            if (isset($areas)) {
                foreach ($areas as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addEtiqueta(CORRESPONDENCIA_AREA);
            $form->addSelect('select', 'sel_area', 'sel_area', $opciones, CORRESPONDENCIA_AREA, $area, '', 'onChange=submit();');

            /*
             * Consultar los subtemas almacenados.
             */
            
            $opciones = null;
            $subtemas = $docData->getSubtemas('dot_id = ' . $area, 'dos_nombre');
            if (isset($subtemas)) {
                foreach ($subtemas as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addEtiqueta(CORRESPONDENCIA_SUBTEMA);
            $form->addSelect('select', 'sel_subtema', 'sel_subtema', $opciones, CORRESPONDENCIA_SUBTEMA, $subtema, '', '');
            
            /*
             * Consultar los autores almacenados, solo siglas.
             */
            $criterioDest=' ope_id = ' . CORRESPONDECIA_OPERADOR;
            if (isset($autor)){           
                $criterioDest.=' and  doa_id != ' . $autor;
            }
            $destinatarios = $corrData->getActores($criterioDest , 'doa_sigla');
            $opciones = null;
            if (isset($destinatarios)) {
                foreach ($destinatarios as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addEtiqueta(CORRESPONDENCIA_DESTINATARIO);
            $form->addSelect('select', 'sel_destinatario', 'sel_destinatario', $opciones, CORRESPONDENCIA_DESTINATARIO, $destinatario, '', '');

            $form->addEtiqueta(CORRESPONDECIA_CODIGO_REFERENCIA);
            $form->addInputText('text', 'txt_codigo_referencia', 'txt_codigo_referencia', 50, 100, $codigoReferencia, '', '');
        
            $form->addEtiqueta(COMPROMISOS_PALABRAS);
            $form->addInputText('text', 'txt_palabras', 'txt_palabras', '30', '30', $palabras, '', 'onChange="consultar_compromisos();"');

        }
        
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=submit();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', COMPROMISOS_EXPORTAR, 'button', 'onClick=exportar_excel_correspondencia();');
        //$form->addInputButton('button', 'btn_cancelar', 'btn_cancelar', BTN_CANCELAR, 'button', 'onClick=cancelar_busqueda_correspondencia();');

        $form->writeForm();
        
        //Inicio tabla
        $correspondencia = $corrData->getCorrespondencia($criterio, 'doc_fecha_radicado');
        $dt = new CHtmlDataTableAlignable();
        $titulos = array(CORRESPONDENCIA_AREA, CORRESPONDENCIA_SUBTEMA, CORRESPONDECIA_CODIGO_REFERENCIA,
            CORRESPONDENCIA_FECHA_RADICADO, CORRESPONDENCIA_DESCRIPCION, 
            CORRESPONDENCIA_DOCUMENTO, CORRESPONDENCIA_FECHA_RESPUESTA,
            CORRESPONDENCIA_RESPONSABLE_RESPUESTA, CORRESPONDENCIA_CONSECUTIVO_RESPUESTA,
            CORRESPONDENCIA_REFERENCIA_RESPUESTA, CORRESPONDENCIA_ANEXOS, CORRESPONDENCIA_ESTADO);
            
            
            
            
        
        
        $contador = 0;
        $cont = count($correspondencia);
        $documentos = null;
        while ($contador < $cont) {
            $documentos[$contador]['id'] = $correspondencia[$contador]['id'];
            $documentos[$contador]['area'] = $correspondencia[$contador]['area'];
            $documentos[$contador]['subtema'] = $correspondencia[$contador]['subtema'];
            $documentos[$contador]['codigor'] = $correspondencia[$contador]['codigor'];
            $documentos[$contador]['fecha'] = $correspondencia[$contador]['fecha'];
            $documentos[$contador]['descripcion'] = $correspondencia[$contador]['descripcion'];
            $documentos[$contador]['soporte'] = $correspondencia[$contador]['soporte'];
            if ($correspondencia[$contador]['fechamax']== "0000-00-00"){
                $documentos[$contador]['fechamax'] = "";
            }else{
                $documentos[$contador]['fechamax'] = $correspondencia[$contador]['fechamax'];
            }
            $documentos[$contador]['responsableR'] = $correspondencia[$contador]['responsableR'];
            $documentos[$contador]['consecutivo_respuesta'] = $correspondencia[$contador]['consecutivo_respuesta'];
            $documentos[$contador]['referencia'] = $correspondencia[$contador]['referencia'];
            $documentos[$contador]['anexo'] = $correspondencia[$contador]['anexo'];
            if($correspondencia[$contador]['estado']==1){
               $documentos[$contador]['estado']=$correspondencia[$contador]['estado_nombre'];
            }
            if($correspondencia[$contador]['estado']==2){
               $documentos[$contador]['estado']="<img src='templates/img/ico/verde.gif'>";
            }
            if($correspondencia[$contador]['estado']==3 || $correspondencia[$contador]['estado']==4){
                $datetime1 = new DateTime("now");
                $datetime2 = new DateTime($correspondencia[$contador]['fechamax']);
                $interval = $datetime1->diff($datetime2);
                $dias = $interval->days + 1;
                if($datetime1->format("Y-m-d") ==  $datetime2->format("Y-m-d"))
                    $documentos[$contador]['estado']="<img src='templates/img/ico/amarillo.gif'> ".$dias;
                else if(($datetime1 < $datetime2))
                    $documentos[$contador]['estado']="<img src='templates/img/ico/amarillo.gif'> ".$dias;
                else
                    $documentos[$contador]['estado']="<img src='templates/img/ico/rojo.gif'> ".$dias;
            }
            //---------------------------------------------------------------------------
            
            //$documentos[$contador]['autor'] = $correspondencia[$contador]['autor'];
            //$documentos[$contador]['destinatario'] = $correspondencia[$contador]['destinatario'];
            $contador++;
        }

        
        
        $dt->setDataRows($documentos);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_CORRESPONDENCIA);

        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv. "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete");
        $otros = array('link' => "?mod=" . $modulo . "&niv=" . $niv . "&task=responder", 'img' => 'marcado.gif', 'alt' => ALT_RESPONSABLES);
        $dt->addOtrosLink($otros);
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add");

        $dt->setType(1);
        $pag_crit = "&txt_fecha_inicio=".$fechaInicio.
                    "&txt_fecha_fin=".$fechaFin.
                    "&sel_autor=".$autor.
                    "&sel_area=".$area.
                    "&sel_subtema=".$subtema.
                    "&sel_destinatario=".$destinatario.
                    "&txt_codigo_referencia=".$codigoReferencia;
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        break;

    /*
     * la variable add, permite Agregar correspondencia.
     */
    case 'add':
        $area = $_REQUEST['sel_area_add'];
        $subtema = $_REQUEST['sel_subtema_add'];
        $autor = $_REQUEST['sel_autor_add'];
        $destinatario = $_REQUEST['sel_destinatario_add'];
        $fechaRadicacion = $_REQUEST['txt_fecha_radicado_add'];
        $consecutivo = $_REQUEST['num_consecutivo_add'];
        $codigoReferencia = $_REQUEST['txt_codigo_referencia'];
        $descripcion = $_REQUEST['txt_descripcion_add'];
        $tieneSeguimiento = $_REQUEST['sel_seguimiento_add'];
        $responsable = $_REQUEST['sel_responsable_add'];
        $fechaRespuesta = $_REQUEST['txt_fecha_respuesta_add'];
        $consecutivoRespuesta = $_REQUEST['num_consecutivo_respuesta_add'];        
        
        $tieneAnexo = $_REQUEST['sel_anexo_add'];
        $estado = $_REQUEST['sel_estado_add'];
        
        //Inicio formulario
        $form = new CHtmlForm();
        $form->setTitle(CORRESPONDENCIA_ADD);
        
        $form->setId('frm_add_correspondencia');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        /*
         * Consultar las areas almacenadas.
         */
        $opciones = null;
        $areas = $corrData->getAreas('dot_id > 3', 'dot_nombre');
        if (isset($areas)) {
            foreach ($areas as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(CORRESPONDENCIA_AREA);
        $form->addSelect('select', 'sel_area_add', 'sel_area_add', $opciones, CORRESPONDENCIA_AREA, $area, '', 'onChange=submit();onChange=ocultarDiv(\'error_area\');');
        $form->addError('error_area', ERROR_CORRESPONDECIA_AREA);

        /*
         * Obtener Arreglo de subtemas almacenados en la clase CCorrespondecia (Area)
         */
        $opciones = null;
        $subtemas = $docData->getSubtemas('dot_id ='. $area, 'dos_nombre');
        if (isset($subtemas)) {
            foreach ($subtemas as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(CORRESPONDENCIA_SUBTEMA);
        $form->addSelect('select', 'sel_subtema_add', 'sel_subtema_add', $opciones, CORRESPONDENCIA_SUBTEMA, $subtema, '', 'onChange=ocultarDiv(\'error_subtema\');');
        $form->addError('error_subtema', ERROR_CORRESPONDECIA_SUBTEMA);
        
        /*
         * Consultar los autores almacenados, solo siglas.
         */
        $autores = $corrData->getActores(' ope_id =' . CORRESPONDECIA_OPERADOR, 'doa_sigla');
        $opciones = null;
        if (isset($autores)) {
            foreach ($autores as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']."-".$t['sigla']);
            }
        }
        $form->addEtiqueta(CORRESPONDENCIA_AUTOR);
        $form->addSelect('select', 'sel_autor_add', 'sel_autor_add', $opciones, CORRESPONDENCIA_AUTOR, $autor, '', 'onChange=ocultarDiv(\'error_autor\');armarReferencia();actualizarDestinatario();');
        $form->addError('error_autor', ERROR_CORRESPONDECIA_AUTOR);

        /*
         * Consultar los destinatarios almacenados, solo siglas.
         */
        $destinatarios = $autores;//$corrData->getActores('  ope_id =' . CORRESPONDECIA_OPERADOR . ' and doa_id != ' . $autor, 'doa_sigla');
        $opciones = null;
        if (isset($destinatarios)) {
            foreach ($destinatarios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']."-".$t['sigla']);
            }
        }
        
        $form->addEtiqueta(CORRESPONDENCIA_DESTINATARIO);
        $form->addSelect('select', 'sel_destinatario_add', 'sel_destinatario_add', $opciones, CORRESPONDENCIA_DESTINATARIO, $destinatario, '', 'onChange=ocultarDiv(\'error_destinatario\');armarReferencia();');
        $form->addError('error_destinatario', ERROR_CORRESPONDECIA_DESTINATARIO);
        
        /*
         * Campo fecha de radicado.
         */        
        $form->addEtiqueta(CORRESPONDENCIA_FECHA_RADICADO);
        $form->addInputDate('date', 'txt_fecha_radicado_add', 'txt_fecha_radicado_add', $fechaRadicacion, "%Y-%m-%d", 16, 16, '', 'onChange="ocultarDiv(\'error_fecha_radicado\');"');
        $form->addError('error_fecha_radicado', ERROR_CORRESPONDECIA_FECHA_RADICADO);
        
        /*
         * Campo consecutivo.
         */    
        $form->addEtiqueta(CORRESPONDECIA_CONSECUTIVO);
        $form->addInputText('text', 'num_consecutivo_add', 'num_consecutivo_add', 15, 5, $consecutivo, '', 'onChange=ocultarDiv(\'error_consecutivo\');armarReferencia();');
        $form->addError('error_consecutivo', ERROR_CORRESPONDENCIA_CONSECUTIVO);
       
        /*
         * 
         * Campo codigo de referencia.
         */
        //$codigoReferencia = "PNCAV-" . $corrData->getSiglaActoresById($autor) . "-" . $corrData->getSiglaActoresById($destinatario) . "-" . $consecutivo . "-".date("Y");
        $form->addEtiqueta(CORRESPONDECIA_CODIGO_REFERENCIA);
        $form->addInputText('text', 'txt_codigo_referencia', 'txt_codigo_referencia', 30, 30, $codigoReferencia, '', '');
        $form->addError('error_consecutivo', ERROR_CORRESPONDENCIA_CODIGO_REFERENCIA);
        
         /*
         * Descripción de los comunicados.
         */ 
//        $form->addEtiqueta(CORRESPONDENCIA_DESCRIPCION);
//        $form->addInputText('text', 'txt_descripcion_add', 'txt_descripcion_add', 100, 100, $descripcion, '', 'onChange=ocultarDiv(\'error_descripcion\');');
//        $form->addError('error_descripcion', ERROR_CORRESPONDENCIA_DESCRIPCION);
//        
        $form->addEtiqueta(CORRESPONDENCIA_DESCRIPCION);
        $form->addTextArea('textarea', 'txt_descripcion_add', 'txt_descripcion_add', '100', '2', $descripcion, '', 'onChange="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_CORRESPONDENCIA_DESCRIPCION);

        /*
         * Consultar los usuarios activos del sistema.
         */
        $responsables = $corrData->getResponsables(' usu_estado = 1 ', 'usu_apellido');
        $opciones = null;
        if (isset($responsables)) {
            foreach ($responsables as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['apellido'] . " " . $t['nombre']);
            }
        }
        $form->addEtiqueta(CORRESPONDENCIA_RESPONSABLE_RESPUESTA);
        $form->addSelect('select', 'sel_responsable_add', 'sel_responsable_add', $opciones, CORRESPONDENCIA_RESPONSABLE_RESPUESTA, $responsable, '', 'onChange=ocultarDiv(\'error_responsable\');');
        $form->addError('error_responsable', ERROR_CORRESPONDECIA_RESPONSABLE_RESPUESTA);
        
//'onClick=consultar_compromisos();'
        
         /*
         * Documento soporte de los comunicados.
         */ 
        $form->addEtiqueta(CORRESPONDENCIA_SOPORTE);
        $form->addInputFile('file', 'file_correspondencia_soporte_add', 'file_correspondencia_soporte_add', '25', 'file', 'onChange="ocultarDiv(\'error_soporte\');"');
        $form->addError('error_soporte', ERROR_CORRESPONDENCIA_SOPORTE);
        
        /*
         * Pregunta por el anexo.
         */
        $anexos[0]['value']=1;
        $anexos[0]['texto']="Si";
        $anexos[1]['value']=2;
        $anexos[1]['texto']="No";
        $form->addEtiqueta(CORRESPONDENCIA_TIENE_ANEXO);
        $form->addSelect('select', 'sel_anexo_add', 'sel_anexo_add', $anexos, CORRESPONDENCIA_ANEXO, $tieneAnexo, '', 'onChange=ocultarDiv(\'error_anexo\');actualizaCampos();');
        $form->addError('error_anexo', ERROR_CORRESPONDECIA_ANEXO);
        
        /*
         * Documento anexo de los comunicados.
         */ 
        $form->addEtiqueta(CORRESPONDENCIA_ANEXO);
        $form->addInputFile('file', 'file_correspondencia_anexo_add', 'file_correspondencia_anexo_add', '25', 'file', 'onChange="ocultarDiv(\'error_documento_anexo\');actualizaCampos();"');
        $form->addError('error_documento_anexo', ERROR_CORRESPONDECIA_ANEXO);
        

        
        //--------------------------------------------respuesta----------------------------------------
        /*
         * Pregunta por el seguimiento.
         */ 
        $seguimiento[0]['value']=1;
        $seguimiento[0]['texto']="Si";
        $seguimiento[1]['value']=2;
        $seguimiento[1]['texto']="No";
        $form->addEtiqueta(CORRESPONDENCIA_TIENE_RESPUESTA);
        $form->addSelect('select', 'sel_seguimiento_add', 'sel_seguimiento_add', $seguimiento, CORRESPONDENCIA_RESPUESTA, $tieneSeguimiento, '', 'onChange=ocultarDiv(\'error_seguimiento\');actualizaCampos();');
        $form->addError('error_seguimiento', ERROR_CORRESPONDECIA_RESPUESTA);
       
        /*
         * Campo fecha de respuesta.
         */ 
        $form->addEtiqueta(CORRESPONDENCIA_FECHA_RESPUESTA);
        $form->addInputDate('date', 'txt_fecha_respuesta_add', 'txt_fecha_respuesta_add', $fechaRespuesta, "%Y-%m-%d", 16, 16, '', 'onChange="ocultarDiv(\'error_fecha_respuesta\');actualizaCampos();"');
        $form->addError('error_fecha_respuesta', ERROR_CORRESPONDECIA_FECHA_RESPUESTA);

        /*
         * Documento respuesta de los comunicados.
         */ 
       
        $form->addInputText('hidden', 'sel_estado_add', 'sel_estado_add', '', '', $estado, '', '');
        $form->addInputFile('hidden', 'file_correspondencia_respuesta_add', 'file_correspondencia_respuesta_add', '25', 'file', '');
        $form->addInputFile('hidden', 'consecutivo_correspondencia_respuesta_add', 'consecutivo_correspondencia_respuesta_add', '25', 'file', '');
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_correspondencia();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_correspondencia\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->addInputText('hidden', 'txt_tiene_documento_respuesta', 'txt_tiene_documento_respuesta', '', '', '', '', '');
        //$form->addInputText('hidden', 'txt_tiene_documento_respuesta', 'txt_tiene_documento_respuesta', '', '', $tieneDocumentoRespuesta, '', '');
        $form->addInputText('hidden', 'txt_requiere_documento_respuesta', 'txt_requiere_documento_respuesta', '', '', $tieneFechaMaxRespuesta, '', '');
        
        
        $form->writeForm();
        ?>
        <script>
            actualizaCampos();
        </script>
        <?php
        break;

    /**
     * la variable saveAdd, permite almacenar el objeto DOCUMENTO en la base de datos, ver la clase CDocumentoData
     */
    case 'saveAdd':
        $area = $_REQUEST['sel_area_add'];
        $subtema = $_REQUEST['sel_subtema_add'];
        $autor = $_REQUEST['sel_autor_add'];
        $destinatario = $_REQUEST['sel_destinatario_add'];
        $fechaRadicacion = $_REQUEST['txt_fecha_radicado_add'];
        //$consecutivo = $_REQUEST['num_consecutivo_add'];
        $codigoReferencia = $_REQUEST['txt_codigo_referencia'];
        $descripcion = $_REQUEST['txt_descripcion_add'];
        $tieneSeguimiento = $_REQUEST['sel_seguimiento_add'];
        if ($_REQUEST['sel_responsable_add']==-1){
            $responsable = "";
        }else{
            $responsable = $_REQUEST['sel_responsable_add'];
        }
        $fechaRespuesta = $_REQUEST['txt_fecha_respuesta_add'];
        $consecutivoRespuesta = $_REQUEST['consecutivo_correspondencia_respuesta_add'];  //num_consecutivo_respuesta_add  
        
        $documentoSoporte = $_FILES['file_correspondencia_soporte_add'];
        $tieneAnexo = $_REQUEST['sel_anexo_add'];
        $documentoAnexo = $_FILES['file_correspondencia_anexo_add'];
        $estado = $_REQUEST['sel_estado_add'];
        $documentoRespuesta = $_REQUEST['file_correspondencia_respuesta_add'];
        
        $doc_correspondencia = new CCorrespondencia('', $corrData);

        $doc_correspondencia->setTema($area);
        $doc_correspondencia->setSubtema($subtema);
        $doc_correspondencia->setAutor($autor);
        $doc_correspondencia->setDestinatario($destinatario);
        $doc_correspondencia->setFechaRadicado($fechaRadicacion);
        
        $doc_correspondencia->setCodigoReferencia($codigoReferencia);
        $doc_correspondencia->setDescripcion($descripcion);
        $doc_correspondencia->setTieneSeguimiento($tieneSeguimiento);        
        $doc_correspondencia->setResponsableRespuesta($responsable);
        
        $doc_correspondencia->setFechaMaxRepuesta($fechaRespuesta);        
        $doc_correspondencia->setConsecutivoRespuesta($consecutivoRespuesta);
        $doc_correspondencia->setDocumentoSoporte($documentoSoporte);        
        $doc_correspondencia->setTieneAnexos($tieneAnexo);
        
        $doc_correspondencia->setDocumentoAnexo($documentoAnexo);
        
        $doc_correspondencia->setEstado($estado);
        $doc_correspondencia->setDocumentoRespuesta($documentoRespuesta);
        $doc_correspondencia->setOperador(OPERADOR_DEFECTO);
        
        $m = $doc_correspondencia->saveNewCorrespondencia($documentoSoporte, $documentoAnexo);

        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");


        break;
    /**
     * la variable delete, permite hacer la carga del objeto correspondencia
     *  y espera confirmacion de eliminarlo
     */
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        
        $form = new CHtmlForm();
        $form->setId('frm_delet_correspondencia');
        $form->setMethod('post');
        $form->writeForm();

        
        echo $html->generaAdvertencia(DOCUMENTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $niv . '&task=confirmDelete&id_element=' . $id_delete, 
                "cancelarAccion('frm_delet_correspondencia','?mod=" . $modulo . "&niv=" . $niv. "');");
      
        break;
    /**
     * la variable confirmDelete, permite eliminar el objeto Correspondencia de la base de datos
     * 
     */
    case 'confirmDelete':

        $id_delete = $_REQUEST['id_element'];
        $correspondencia = $_REQUEST['file_correspondencia_add'];

        $doc_correspondencia = new CCorrespondencia($id_delete, $corrData);
        
        $doc_correspondencia->loadCorrespondecia();
        
        $m = $doc_correspondencia->deleteDocumento();
        
                
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        
        break;



    /**
     * Edit permite hacer la carga del objeto DOCUMENTO 
     * y espera confirmacion de edicion, ver la clase CDocumento
     */
    case 'edit':
        $id_edit = $_REQUEST['id_element'];
        $doc_correspondencia = new CCorrespondencia($id_edit, $corrData);
        $doc_correspondencia->loadCorrespondecia();
       // echo "doc:".$doc_correspondencia->documentoRespuesta;
        if($doc_correspondencia->documentoRespuesta!='')
            $tieneDocumentoRespuesta="si";
        
        if($doc_correspondencia->fechaMaxRepuesta!='' && $doc_correspondencia->fechaMaxRepuesta!='0000-00-00')
            $tieneFechaMaxRespuesta="si";
        
        if(isset($_REQUEST['sel_area_add']) && $_REQUEST['sel_area_add']!=-1){
            $area = $_REQUEST['sel_area_add'];
        }else{
            $area = $doc_correspondencia->getTema();  
        }
         if(isset($_REQUEST['sel_subtema_add']) && $_REQUEST['sel_subtema_add']!=-1){
            $subtema = $_REQUEST['sel_subtema_add'];
        }else{
            $subtema = $doc_correspondencia->getSubtema();  
        }
        
        if(isset($_REQUEST['sel_autor_add']) && $_REQUEST['sel_autor_add']!=-1){
            $autor = $_REQUEST['sel_autor_add'];
        }else {
            $autor = $doc_correspondencia->getAutor();
        }
        
        if(isset($_REQUEST['sel_destinatario_add']) && $_REQUEST['sel_destinatario_add']!=-1){
            $destinatario = $_REQUEST['sel_destinatario_add'];
        }else{
            $destinatario = $doc_correspondencia->getDestinatario(); 
        }
        
        if(isset($_REQUEST['sel_responsable_add']) && $_REQUEST['sel_responsable_add']!=-1){
            $responsable = $_REQUEST['sel_responsable_add'];
        }else{
            $responsable = $doc_correspondencia->getResponsableRespuesta();
        }
        //echo $responsable;
        if(isset($_REQUEST['txt_descripcion_add']) && $_REQUEST['txt_descripcion_add']!=""){
            $descripcion = $_REQUEST['txt_descripcion_add'];
        }else{
            $descripcion = $doc_correspondencia->getDescripcion();
        }
        
        $documentoSoporte = $_FILES['file_correspondencia_soporte_add'];
        
        if(isset($_REQUEST['sel_anexo_add']) && $_REQUEST['sel_anexo_add']!=-1){
            $tieneAnexos = $_REQUEST['sel_anexo_add'];
        }else{
            $tieneAnexos = $doc_correspondencia->getTieneAnexos();
        }
        
        $documentoAnexo = $_FILES['file_correspondencia_anexo_add'];
        
        if(isset($_REQUEST['txt_fecha_radicado_add']) && $_REQUEST['txt_fecha_radicado_add']!="" && $_REQUEST['txt_fecha_radicado_add']!="0000-00-00"){
            $fechaRadicacion = $_REQUEST['txt_fecha_radicado_add'];
        }else{
            $fechaRadicacion = $doc_correspondencia->getFechaRadicado();
        }
        
        if(isset($_REQUEST['sel_seguimiento_add']) && $_REQUEST['sel_seguimiento_add']!=-1){
            $tieneSeguimiento = $_REQUEST['sel_seguimiento_add'];
        }else{
            $tieneSeguimiento = $doc_correspondencia->getTieneSeguimiento();
        }
        
        if(isset($_REQUEST['txt_fecha_respuesta_add']) && $_REQUEST['txt_fecha_respuesta_add']!="" && $_REQUEST['txt_fecha_respuesta_add']!="0000-00-00"){
            $fechaRespuesta = $_REQUEST['txt_fecha_respuesta_add'];
        }else{
            $fechaRespuesta = $doc_correspondencia->getFechaMaxRepuesta();
        }
        
        if(isset($_REQUEST['file_correspondencia_respuesta_add']) && $_REQUEST['file_correspondencia_respuesta_add']!="")
            $documentoRespuesta = $_REQUEST['file_correspondencia_respuesta_add'];
        else
            $documentoRespuesta = $doc_correspondencia->getDocumentoRespuesta();
        //$doc_correspondencia->documentoRespuesta
        
        if(isset($_REQUEST['num_consecutivo_add']) && $_REQUEST['num_consecutivo_add']!=""){
            $consecutivo = $_REQUEST['num_consecutivo_add'];
        }else{
            $arreglo = explode("-",$doc_correspondencia->getCodigoReferencia());
            $consecutivo = $arreglo[3];
        }
        
        if(isset($_REQUEST['txt_codigo_referencia']) && $_REQUEST['txt_codigo_referencia']!=""){
            $codigoReferencia = $_REQUEST['txt_codigo_referencia'];
        }else{
            $codigoReferencia = $doc_correspondencia->getCodigoReferencia();
        }
        
        if(isset($_REQUEST['num_consecutivo_respuesta_add']) && $_REQUEST['num_consecutivo_respuesta_add']!=""){
            $consecutivoRespuesta = $_REQUEST['num_consecutivo_respuesta_add'];
        }else{
            $consecutivoRespuesta = $doc_correspondencia->getConsecutivoRespuesta();
        }
        
        if(isset($_REQUEST['sel_estado_add']) && $_REQUEST['sel_estado_add']!=-1){
            $estado = $_REQUEST['sel_estado_add'];
        }else{
            $estado = $doc_correspondencia->getEstado();
        }
        
        $form = new CHtmlForm();
        $form->setTitle(CORRESPONDENCIA_EDIT);
        $form->setId('frm_edit_correspondencia');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        $form->addInputText('hidden', 'id_element', 'id_element', '', '', $id_edit, '', '');
        
        /*
         * Consultar las areas almacenadas.
         */
        $opciones = null;
        $areas = $corrData->getAreas('dot_id > 3', 'dot_nombre');
        if (isset($areas)) {
            foreach ($areas as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(CORRESPONDENCIA_AREA);
        $form->addSelect('select', 'sel_area_add', 'sel_area_add', $opciones, CORRESPONDENCIA_AREA, $area, '', 'onChange=submit();onChange=ocultarDiv(\'error_area\');');
        $form->addError('error_area', ERROR_CORRESPONDECIA_AREA);

        /*
         * Obtener Arreglo de subtemas almacenados en la clase CCorrespondecia
         */
        $opciones = null;
        $subtemas = $docData->getSubtemas('dot_id='. $area, 'dos_nombre');
        if (isset($subtemas)) {
            foreach ($subtemas as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(CORRESPONDENCIA_SUBTEMA);
        $form->addSelect('select', 'sel_subtema_add', 'sel_subtema_add', $opciones, CORRESPONDENCIA_SUBTEMA, $subtema, '', 'onChange=ocultarDiv(\'error_subtema\');');
        $form->addError('error_subtema', ERROR_CORRESPONDECIA_SUBTEMA);
        
        /*
         * Consultar los autores almacenados, solo siglas.
         */
        $autores = $corrData->getActores(' ope_id =' . CORRESPONDECIA_OPERADOR, 'doa_sigla');
        $opciones = null;
        if (isset($autores)) {
            foreach ($autores as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']."-".$t['sigla']);
            }
        }
        $form->addEtiqueta(CORRESPONDENCIA_AUTOR);
        $form->addSelect('select', 'sel_autor_add', 'sel_autor_add', $opciones, CORRESPONDENCIA_AUTOR, $autor, '', 'onChange=ocultarDiv(\'error_autor\');armarReferencia();actualizarDestinatario();');
        $form->addError('error_autor', ERROR_CORRESPONDECIA_AUTOR);

        /*
         * Consultar los destinatarios almacenados, solo siglas.
         */
        $destinatarios = $autores;//$corrData->getActores('  ope_id =' . CORRESPONDECIA_OPERADOR . ' and doa_id != ' . $autor, 'doa_sigla');
        $opciones = null;
        if (isset($destinatarios)) {
            foreach ($destinatarios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']."-".$t['sigla']);
            }
        }
        
        $form->addEtiqueta(CORRESPONDENCIA_DESTINATARIO);
        $form->addSelect('select', 'sel_destinatario_add', 'sel_destinatario_add', $opciones, CORRESPONDENCIA_DESTINATARIO, $destinatario, '', 'onChange=ocultarDiv(\'error_destinatario\');armarReferencia();');
        $form->addError('error_destinatario', ERROR_CORRESPONDECIA_DESTINATARIO);
        
        /*
         * Campo fecha de radicado.
         */        
        $form->addEtiqueta(CORRESPONDENCIA_FECHA_RADICADO);
        $form->addInputDate('date', 'txt_fecha_radicado_add', 'txt_fecha_radicado_add', $fechaRadicacion, "%Y-%m-%d", 16, 16, '', 'onChange="ocultarDiv(\'error_fecha_radicado\');"');
        $form->addError('error_fecha_radicado', ERROR_CORRESPONDECIA_FECHA_RADICADO);
        
        /*
         * Campo consecutivo.
         */    
        $form->addEtiqueta(CORRESPONDECIA_CONSECUTIVO);
        $form->addInputText('text', 'num_consecutivo_add', 'num_consecutivo_add', 15, 5, $consecutivo, '', 'onChange=ocultarDiv(\'error_consecutivo\');armarReferencia();');
        $form->addError('error_consecutivo', ERROR_CORRESPONDENCIA_CONSECUTIVO);
       
  
        /*
         * 
         * Campo codigo de referencia.
         */
        $form->addEtiqueta(CORRESPONDECIA_CODIGO_REFERENCIA);
        $form->addInputText('text', 'txt_codigo_referencia', 'txt_codigo_referencia', 30, 30, $codigoReferencia, '', '');
        $form->addError('error_consecutivo', ERROR_CORRESPONDENCIA_CODIGO_REFERENCIA);
        
         /*
         * Descripción de los comunicados.
         */ 

        $form->addEtiqueta(CORRESPONDENCIA_DESCRIPCION);
        $form->addTextArea('textarea', 'txt_descripcion_add', 'txt_descripcion_add', '100', '2', $descripcion, '', 'onChange="ocultarDiv(\'error_descripcion\');"');
        $form->addError('error_descripcion', ERROR_CORRESPONDENCIA_DESCRIPCION);
        
        /*
         * Consultar los usuarios activos del sistema.
         */
        $responsables = $corrData->getResponsables(' usu_estado = 1 ', 'usu_apellido');
        $opciones = null;
        if (isset($responsables)) {
            foreach ($responsables as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre'] . " " . $t['apellido']);
            }
        }
        $form->addEtiqueta(CORRESPONDENCIA_RESPONSABLE_RESPUESTA);
        $form->addSelect('select', 'sel_responsable_add', 'sel_responsable_add', $opciones, CORRESPONDENCIA_RESPONSABLE_RESPUESTA, $responsable, '', 'onChange=ocultarDiv(\'error_responsable\');');
        $form->addError('error_responsable', ERROR_CORRESPONDECIA_RESPONSABLE_RESPUESTA);
        
         /*
         * Documento soporte de los comunicados.
         */ 
        $form->addEtiqueta(CORRESPONDENCIA_SOPORTE);
        $form->addInputFile('file', 'file_correspondencia_soporte_add', 'file_correspondencia_soporte_add', '25', 'file', 'onChange="ocultarDiv(\'error_soporte\');"');
        $form->addError('error_soporte', ERROR_CORRESPONDENCIA_SOPORTE);
        
        /*
         * Pregunta por el anexo.
         */
        $anexos[0]['value']=1;
        $anexos[0]['texto']="Si";
        $anexos[1]['value']=2;
        $anexos[1]['texto']="No";
        $form->addEtiqueta(CORRESPONDENCIA_TIENE_ANEXO);
        $form->addSelect('select', 'sel_anexo_add', 'sel_anexo_add', $anexos, CORRESPONDENCIA_ANEXO, $tieneAnexos, '', 'onChange=ocultarDiv(\'error_anexo\');actualizaCampos();');
        $form->addError('error_anexo', ERROR_CORRESPONDECIA_ANEXO);
        
         /*
         * Documento anexo de los comunicados.
         */ 
        $form->addEtiqueta(CORRESPONDENCIA_ANEXO);
        $form->addInputFile('file', 'file_correspondencia_anexo_add', 'file_correspondencia_anexo_add', '25', 'file', 'onChange="ocultarDiv(\'error_documento_anexo\');"');
        $form->addError('error_documento_anexo', ERROR_CORRESPONDECIA_ANEXO);
        
        /*
         * Pregunta por el seguimiento.
         */ 
        $seguimiento[0]['value']=1;
        $seguimiento[0]['texto']="Si";
        $seguimiento[1]['value']=2;
        $seguimiento[1]['texto']="No";
        $form->addEtiqueta(CORRESPONDENCIA_TIENE_RESPUESTA);
        $form->addSelect('select', 'sel_seguimiento_add', 'sel_seguimiento_add', $seguimiento, CORRESPONDENCIA_RESPUESTA, $tieneSeguimiento, '', 'onChange=ocultarDiv(\'error_seguimiento\');actualizaCampos();');
        $form->addError('error_seguimiento', ERROR_CORRESPONDECIA_RESPUESTA);
       
        /*
         * Campo fecha de respuesta.
         */ 
        $form->addEtiqueta(CORRESPONDENCIA_FECHA_RESPUESTA);
        $form->addInputDate('date', 'txt_fecha_respuesta_add', 'txt_fecha_respuesta_add', $fechaRespuesta, "%Y-%m-%d", 16, 16, '', 'onChange="ocultarDiv(\'error_fecha_respuesta\');actualizaCampos();"');
        $form->addError('error_fecha_respuesta', ERROR_CORRESPONDECIA_FECHA_RESPUESTA);

        
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_correspondencia();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_correspondencia\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        //$form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelar_busqueda_correspondencia();"');
        
        //$form->addInputFile('text', 'file_respuesta_temp', 'file_respuesta_temp', 20, 100, $documentoRespuesta, '', '');
        $form->addInputFile('hidden', 'file_correspondencia_respuesta_add', 'file_correspondencia_respuesta_add', '20', '100', $documentoRespuesta, '', '');
        $form->addInputFile('hidden', 'consecutivo_correspondencia_respuesta_add', 'consecutivo_correspondencia_respuesta_add', '20', '100',$consecutivoRespuesta, '', '');
        $form->addInputText('hidden', 'sel_estado_add', 'sel_estado_add', '', '', $estado, '', '');
        $form->addInputText('hidden', 'txt_tiene_documento_respuesta', 'txt_tiene_documento_respuesta', '', '', $tieneDocumentoRespuesta, '', '');
        $form->addInputText('hidden', 'txt_requiere_documento_respuesta', 'txt_requiere_documento_respuesta', '', '', $tieneFechaMaxRespuesta, '', '');
        
        $form->writeForm();
        
        ?>
        <script>
            verificarRespuesta('<?php echo $documentoRespuesta ?>');
            actualizaCampos();
        </script>
        <?php
        //-----------------------------------------------
        
        break;
    /**
     * la variable saveEdit, permite actualizar el objeto DOCUMENTO en la base de datos, ver la clase CDocumentoData
     */
    case 'saveEdit':
        $id = $_REQUEST['id_element'];
        $area = $_REQUEST['sel_area_add'];
        $subtema = $_REQUEST['sel_subtema_add'];
        $autor = $_REQUEST['sel_autor_add'];
        $destinatario = $_REQUEST['sel_destinatario_add'];        
        $fechaRadicacion = $_REQUEST['txt_fecha_radicado_add'];
        //$consecutivo = $_REQUEST['num_consecutivo_add'];
        $codigoReferencia = $_REQUEST['txt_codigo_referencia'];
        $descripcion = $_REQUEST['txt_descripcion_add'];
        $tieneSeguimiento = $_REQUEST['sel_seguimiento_add'];
        $responsable = $_REQUEST['sel_responsable_add'];
        $fechaRespuesta = $_REQUEST['txt_fecha_respuesta_add'];
        $consecutivoRespuesta = $_REQUEST['consecutivo_correspondencia_respuesta_add'];//$_REQUEST['num_consecutivo_respuesta_add'];        
        $documentoSoporte = $_FILES['file_correspondencia_soporte_add'];
        $tieneAnexo = $_REQUEST['sel_anexo_add'];
        $documentoAnexo = $_FILES['file_correspondencia_anexo_add'];
        $estado = $_REQUEST['sel_estado_add'];
        $documentoRespuesta = $_REQUEST['file_correspondencia_respuesta_add'];       
        $tieneAnexos = $_REQUEST['sel_anexo_add'];
        if(!empty($_FILES['file_correspondencia_soporte_add']["tmp_name"]))
            $documentoSoporte = $_FILES['file_correspondencia_soporte_add'];
        else
            $documentoSoporte = NULL;
        if(!empty($_FILES['file_correspondencia_anexo_add']["tmp_name"]))
            $documentoAnexo = $_FILES['file_correspondencia_anexo_add'];
        else 
            $documentoAnexo = NULL;
//        if(!empty($_FILES['file_correspondencia_respuesta_add']["tmp_name"]))
//            $documentoRespuesta = $_FILES['file_correspondencia_respuesta_add'];
//        else 
//            $documentoRespuesta = NULL;
        $estado = $_REQUEST['sel_estado_add'];

        $doc_correspondencia = new CCorrespondencia($id, $corrData);
                
        $doc_correspondencia->setTema($area);
        $doc_correspondencia->setAutor($autor);
        $doc_correspondencia->setDestinatario($destinatario);
        $doc_correspondencia->setSubtema($subtema);
        $doc_correspondencia->setFechaRadicado($fechaRadicacion);
        
        $doc_correspondencia->setDescripcion($descripcion);
        $doc_correspondencia->setDocumentoSoporte($documentoSoporte);
        $doc_correspondencia->setResponsableRespuesta($responsable);
        $doc_correspondencia->setFechaMaxRepuesta($fechaRespuesta);
               
        $doc_correspondencia->setConsecutivoRespuesta($consecutivoRespuesta);
        
        $doc_correspondencia->setTieneAnexos($tieneAnexos);
        $doc_correspondencia->setDocumentoAnexo($documentoAnexo);
        $doc_correspondencia->setTieneSeguimiento($tieneSeguimiento);
        $doc_correspondencia->setCodigoReferencia($codigoReferencia);
        //$doc_correspondencia->setFechaRespuesta("");
        $doc_correspondencia->setDocumentoRespuesta($documentoRespuesta);
        $doc_correspondencia->setOperador(OPERADOR_DEFECTO);
        $doc_correspondencia->setEstado($estado);
        
        $m = $doc_correspondencia->saveEditCorrespondencia($documentoSoporte, $documentoAnexo, $documentoRespuesta);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=1&task=list&sel_area=" . $area . "&txt_descripcion=" . $descripcion);

        break;
        
    /**
     * la variable see, permite hacer la carga del objeto OPCION 
     * para ver sus variables, ver la clase COpcion
     */
    case 'see':
        $id_edit = $_REQUEST['id_element'];

        $corr = new CCorrespondencia($id_edit, ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', ' ', $corrData);
        $corr->loadCorrespondecia();

        $row_corres = array($corr->getSubtema(), $corr->getAutor(), $corr->getResponsableRespuesta(),
            $corr->getDescripcion(), $corr->getDocumentoSoporte(), $corr->getAnexos(), $corr->getFechaRadicado()
            , $corr->getFechaMaxRepuesta(), $corr->getCodigoR(), $corr->getReferenciaRespuesta(), $corr->getEstado());

        //Inicio tabla
        $dt = new CHtmlDataTable();
        $titulos = array(CORRESPONDENCIA_SUBTEMA, CORRESPONDENCIA_AUTOR,
            CORRESPONDENCIA_RESP_R, CORRESPONDENCIA_DESCRIPCION,
            CORRESPONDENCIA_DOCUMENTO, CORRESPONDENCIA_ANEXOS,
            CORRESPONDENCIA_FECHA_RADICADO, CORRESPONDENCIA_FECHA_RESPUESTA,
            CORRESPONDENCIA_CODIGOR, CORRESPONDENCIA_REF_R,
            CORRESPONDENCIA_ESTADO);
        $dt->setDataRows($row_corres);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_CORRESPONDENCIA);

        $dt->setType(2);

        $dt->writeDataTable($niv);
        echo $html->generaScriptLink("cancelarAccion('frm_see_correspondencia','?mod=" . $modulo . "&niv=" . $nivel . "')");


        $form = new CHtmlForm();
        $form->setId('frm_see_correspondencia');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $corr->getId(), '', '');



        $form->writeForm();

        break;

    //------------------------------------------------------------------------
    case 'listAlarmas':

        $referencia = $_REQUEST['txt_referencia'];
        $operador = $_REQUEST['operador'];
        $fechaInicio = $_REQUEST['txt_fecha_inicio'];
        $fechaFin = $_REQUEST['txt_fecha_fin'];
        $autor = $_REQUEST['sel_autor'];
        $subtema = $_REQUEST['sel_subtema'];
        $destinatario = $_REQUEST['sel_destinatario'];
        $codigoReferencia = $_REQUEST['txt_codigo_referencia'];

        $criterio = "";
        //-------------------------------criterios---------------------------
        if (isset($fechaInicio) && $fechaInicio != '' && $fechaInicio != '0000-00-00') {
            if (!isset($fechaFin) || $fechaFin == '' || $fechaFin == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = " (d.doc_fecha_radicado >= '" . $fechaInicio . "')";
                } else {
                    $criterio .= " and d.doc_fecha_radicado >= '" . $fechaInicio . "'";
                }
            } else {
                if ($criterio == "") {
                    $criterio = " (d.doc_fecha_radicado between '" . $fechaInicio .
                            "' and '" . $fechaFin . "')";
                } else {
                    $criterio .= " and d.doc_fecha_radicado between '" . $fechaInicio .
                            "' and '" . $fechaFin . "')";
                }
            }
        }
        if (isset($fechaFin) && $fechaFin != '' && $fechaFin != '0000-00-00') {
            if (!isset($fechaInicio) || $fechaInicio == '' || $fechaInicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( d.doc_fecha_radicado <= '" . $fechaFin . "')";
                } else {
                    $criterio .= " and d.doc_fecha_radicado <= '" . $fechaFin . "')";
                }
            }
        }
        
        if($perfil['nombre']!="ANDIRED"){
            if (isset($autor) && $autor != -1 && $autor != '') {
                if ($criterio == "") {
                    $criterio = " d.doa_id_autor = " . $autor;
                } else {
                    $criterio .= " and d.doa_id_autor = " . $autor;
                }
            }
             //////////////////////////////
            if (isset($area) && $area != -1 && $area != '') {
                if ($criterio == "") {
                    $criterio = " d.dot_id = " . $area;
                } else {
                    $criterio .= " and d.dot_id = " . $area;
                }
            }
            //////////////////////////////////////////////
            if (isset($subtema) && $subtema != -1 && $subtema != '') {
                if ($criterio == "") {
                    $criterio = " d.dos_id = " . $subtema;
                } else {
                    $criterio .= " and d.dos_id = " . $subtema;
                }
            }
            if (isset($destinatario) && $destinatario != -1 && $destinatario != '') {
                if ($criterio == "") {
                    $criterio = " d.doa_id_dest = " . $destinatario;
                } else {
                    $criterio .= " and d.doa_id_dest = " . $destinatario;
                }
            }

            if (isset($codigoReferencia) && $codigoReferencia != '') {
                if ($criterio == "") {
                    $criterio = " d.doc_codigo_ref = '" . $codigoReferencia. "'";
                } else {
                    $criterio .= " and d.doc_codigo_ref = " . $codigoReferencia. "'";
                }
            }
        }
        
        if ($criterio == "") {
            $criterio = " d.ope_id = " . CORRESPONDECIA_OPERADOR . 
                    " and d.dot_id > 3 and d.usu_id=".$id_usuario;
        }else{
            $criterio .= " and d.ope_id = " . CORRESPONDECIA_OPERADOR . 
                    " and d.dot_id > 3 and d.usu_id=".$id_usuario;
        }
        if ($criterio == "") {
            $criterio = " doe.doe_id <> 2 ";
        }else{
            $criterio .= " and doe.doe_id <> 2 ";
        }

       /*
         * Inicio formulario
         */
        
        $form = new CHtmlForm();

        $form->setTitle(TABLA_CORRESPONDENCIA);
        $form->setId('frm_list_correspondencia');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(CORRESPONDENCIA_FECHA_INICIO);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fechaInicio, '%Y-%m-%d', '16', '16', '', '');

        $form->addEtiqueta(CORRESPONDENCIA_FECHA_FIN);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fechaFin, '%Y-%m-%d', '16', '16', '', '');
        
        
        if($perfil['nombre']!="ANDIRED"){
            /*
             * Consultar los autores almacenados, solo siglas.
             */
            $autores = $corrData->getActores(' ope_id = ' . CORRESPONDECIA_OPERADOR, 'doa_sigla');
            $opciones = null;
            if (isset($autores)) {
                foreach ($autores as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addEtiqueta(CORRESPONDENCIA_AUTOR);
            $form->addSelect('select', 'sel_autor', 'sel_autor', $opciones, CORRESPONDENCIA_AUTOR, $autor, '', 'onChange=submit();');

            /*
             * Consultar las areas almacenadas.
             */
            $opciones = null;
            $areas = $corrData->getAreas('dot_id  >3', 'dot_nombre');
            if (isset($areas)) {
                foreach ($areas as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addEtiqueta(CORRESPONDENCIA_AREA);
            $form->addSelect('select', 'sel_area', 'sel_area', $opciones, CORRESPONDENCIA_AREA, $area, '', '');

            /*
             * Consultar los subtemas almacenados.
             */
            /*
            $opciones = null;
            $subtemas = $docData->getSubtemas('dot_id = ' . CORRESPONDECIA_TEMA, 'dos_nombre');
            if (isset($subtemas)) {
                foreach ($subtemas as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addEtiqueta(CORRESPONDENCIA_SUBTEMA);
            $form->addSelect('select', 'sel_subtema', 'sel_subtema', $opciones, CORRESPONDENCIA_SUBTEMA, $subtema, '', '');
            */
            /*
             * Consultar los autores almacenados, solo siglas.
             */
            $criterioDest=' ope_id = ' . CORRESPONDECIA_OPERADOR;
            if (isset($autor)){           
                $criterioDest.=' and  doa_id != ' . $autor;
            }
            $destinatarios = $corrData->getActores($criterioDest , 'doa_sigla');
            $opciones = null;
            if (isset($destinatarios)) {
                foreach ($destinatarios as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }

            $form->addEtiqueta(CORRESPONDENCIA_DESTINATARIO);
            $form->addSelect('select', 'sel_destinatario', 'sel_destinatario', $opciones, CORRESPONDENCIA_DESTINATARIO, $destinatario, '', '');

            $form->addEtiqueta(CORRESPONDECIA_CODIGO_REFERENCIA);
            $form->addInputText('text', 'txt_codigo_referencia', 'txt_codigo_referencia', 50, 100, $codigoReferencia, '', '');
        }
        
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=submit();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', COMPROMISOS_EXPORTAR, 'button', 'onClick=exportar_excel_correspondencia();');
        $form->addInputButton('button', 'btn_cancelar', 'btn_cancelar', BTN_CANCELAR, 'button', 'onClick=cancelar_busqueda_correspondencia();');
        
        $form->setOptions('autoClean', false);
        
        $form->writeForm();
         
        //Inicio tabla
        $correspondencia = $corrData->getCorrespondencia($criterio, 'doc_fecha_radicado');
        $dt = new CHtmlDataTable();
        $titulos = array(CORRESPONDENCIA_AREA,CORRESPONDENCIA_SUBTEMA, CORRESPONDENCIA_AUTOR,
            CORRESPONDENCIA_DESTINATARIO, CORRESPONDENCIA_RESPONSABLE_RESPUESTA,
            CORRESPONDENCIA_DESCRIPCION, CORRESPONDENCIA_DOCUMENTO, CORRESPONDENCIA_ANEXOS,
            CORRESPONDENCIA_FECHA_RADICADO, CORRESPONDENCIA_FECHA_RESPUESTA,
            CORRESPONDECIA_CODIGO_REFERENCIA, CORRESPONDENCIA_REFERENCIA_RESPUESTA,
            CORRESPONDENCIA_ESTADO);
        
        $contador = 0;
        $cont = count($correspondencia);
        $documentos = null;
        while ($contador < $cont) {
            $documentos[$contador]['id'] = $correspondencia[$contador]['id'];
            $documentos[$contador]['area'] = $correspondencia[$contador]['area'];
            $documentos[$contador]['subtema'] = $correspondencia[$contador]['subtema'];
            $documentos[$contador]['autor'] = $correspondencia[$contador]['autor'];
            $documentos[$contador]['destinatario'] = $correspondencia[$contador]['destinatario'];
            $documentos[$contador]['responsableR'] = $correspondencia[$contador]['responsableR'];
            $documentos[$contador]['descripcion'] = $correspondencia[$contador]['descripcion'];
            $documentos[$contador]['soporte'] = $correspondencia[$contador]['soporte'];
            $documentos[$contador]['anexo'] = $correspondencia[$contador]['anexo'];
            $documentos[$contador]['fecha'] = $correspondencia[$contador]['fecha'];
            $documentos[$contador]['fechamax'] = $correspondencia[$contador]['fechamax'];
            $documentos[$contador]['codigor'] = $correspondencia[$contador]['codigor'];
            $documentos[$contador]['referencia'] = $correspondencia[$contador]['referencia'];
            if($correspondencia[$contador]['estado']==1){
               $documentos[$contador]['estado']=$correspondencia[$contador]['estado_nombre'];
            }
            if($correspondencia[$contador]['estado']==2){
               $documentos[$contador]['estado']="<img src='templates/img/ico/verde.gif'>";
            }
            if($correspondencia[$contador]['estado']==3 || $correspondencia[$contador]['estado']==4){
                $datetime1 = new DateTime("now");
                $datetime2 = new DateTime($correspondencia[$contador]['fechamax']);
                $interval = $datetime1->diff($datetime2);
                $dias = $interval->days + 1;
                if($datetime1->format("Y-m-d") ==  $datetime2->format("Y-m-d"))
                    $documentos[$contador]['estado']="<img src='templates/img/ico/amarillo.gif'> ".$dias;
                else if(($datetime1 < $datetime2))
                    $documentos[$contador]['estado']="<img src='templates/img/ico/amarillo.gif'> ".$dias;
                else
                    $documentos[$contador]['estado']="<img src='templates/img/ico/rojo.gif'> ".$dias;
            }
            $contador++;
        }        
        
        $dt->setDataRows($documentos);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_CORRESPONDENCIA);
       
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv. "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete");
        $otros = array('link' => "?mod=" . $modulo . "&niv=" . $niv . "&task=responder", 'img' => 'marcado.gif', 'alt' => ALT_RESPONSABLES);
        $dt->addOtrosLink($otros);

        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        break;

    //---------------------------------------------------------------------------
    case 'responder':
        $id_edit = $_REQUEST['id_element'];
        $doc_correspondencia = new CCorrespondencia($id_edit, $corrData);
        $doc_correspondencia->loadCorrespondecia();
        
        if($doc_correspondencia->fechaMaxRepuesta!='' && $doc_correspondencia->fechaMaxRepuesta!='0000-00-00')
            $requiereRespuesta=TRUE;
        else
            $requiereRespuesta=FALSE;
        
        if($requiereRespuesta){
              
        if(isset($_REQUEST['txt_fecha_respuesta']) && $_REQUEST['txt_fecha_respuesta']!="" && $_REQUEST['txt_fecha_respuesta']!="0000-00-00"){
            $fechaRespuesta = $_REQUEST['txt_fecha_respuesta'];
        }else{
            $fechaRespuesta = $doc_correspondencia->getFechaRespuesta();
        }
        
        if(isset($_REQUEST['num_consecutivo_respuesta']) && $_REQUEST['num_consecutivo_respuesta']!=""){
            $consecutivoRespuesta = $_REQUEST['num_consecutivo_respuesta'];
        }else{
            $consecutivoRespuesta = $doc_correspondencia->getConsecutivoRespuesta();
        }
        
//        if(isset($_REQUEST['file_correspondencia_respuesta_add']) && $_REQUEST['file_correspondencia_respuesta_add']!=""){
//            $documentoRespuesta = $_REQUEST['file_correspondencia_respuesta_add'];
//        }else{
//            $documentoRespuesta = $doc_correspondencia->getDocumentoRespuesta();
//        }
//        
//        if(isset($_REQUEST['consecutivo_correspondencia_respuesta_add']) && $_REQUEST['consecutivo_correspondencia_respuesta_add']!=""){
//            $consecutivoRespuesta = $_REQUEST['consecutivo_correspondencia_respuesta_add'];
//        }else{
//            $consecutivoRespuesta = $doc_correspondencia->getConsecutivoRespuesta();
//        }
//        
//        if(isset($_REQUEST['sel_estado_add']) && $_REQUEST['sel_estado_add']!=""){
//            $estado = $_REQUEST['sel_estado_add'];
//        }else{
//            $estado = $doc_correspondencia->getEstado();
//        }
        
        //die("doc:".$doc_correspondencia->fechaMaxRepuesta);
        
        $form = new CHtmlForm();
        $form->setTitle(CORRESPONDENCIA_RESPONDER);
        $form->setId('frm_responder_correspondencia');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        $form->addInputText('hidden', 'id_element', 'id_element', '', '', $id_edit, '', '');

        /*
         * Campo fecha de respuesta.
         */ 
        $form->addEtiqueta(CORRESPONDENCIA_FECHA_RESPONDIDO);
        $form->addInputDate('date', 'txt_fecha_respuesta', 'txt_fecha_respuesta', $fechaRespuesta, "%Y-%m-%d", 16, 16, '', 'onChange="ocultarDiv(\'error_fecha_respuesta\');submit();"');
        $form->addError('error_fecha_respuesta', ERROR_CORRESPONDECIA_FECHA_RESPUESTA);

        
        $opciones = null;
        $respuestas = $corrData->getCorrespondencia("doc_fecha_radicado ='". $fechaRespuesta ."'", 'doc_codigo_ref');
        if (isset($respuestas)) {
            foreach ($respuestas as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre_soporte']);
            }
        }
        $form->addEtiqueta(CORRESPONDENCIA_RESPUESTA);
        $form->addSelect('select', 'num_consecutivo_respuesta', 'num_consecutivo_respuesta', $opciones, CORRESPONDENCIA_RESPUESTA, $consecutivoRespuesta, '', 'onChange=ocultarDiv(\'error_consecutivo_respuesta\');');
        $form->addError('error_consecutivo_respuesta', ERROR_CORRESPONDECIA_CONSECUTIVO_RESPUESTA);
     
        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_responder_correspondencia();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_responder_correspondencia\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        
//        $form->addInputFile('text', 'file_correspondencia_respuesta_add', 'file_correspondencia_respuesta_add', '20', '100', $documentoRespuesta, '', '');
//        $form->addInputFile('text', 'consecutivo_correspondencia_respuesta_add', 'consecutivo_correspondencia_respuesta_add', '20', '100',$consecutivoRespuesta, '', '');
//        $form->addInputText('text', 'sel_estado_add', 'sel_estado_add', '', '', $estado, '', '');
        
        if($doc_correspondencia->documentoRespuesta!=''){
        ?>
        <script>
            verificarRespuesta2('<?php echo $doc_correspondencia->documentoRespuesta; ?>');
            //actualizaCampos();
        </script>
        <?php
        }
        $form->writeForm();
        
        }else{
            echo $html->generaAviso(NO_REQUIERE_RESPUESTA, "?mod=" . $modulo . "&niv=1&task=list&sel_area=" . $area . "&txt_descripcion=" . $descripcion);
        }
        //-----------------------------------------------
        
        break;
    /**
     * la variable saveEdit, permite actualizar el objeto DOCUMENTO en la base de datos, ver la clase CDocumentoData
     */
    case 'saveResponder':
        $id = $_REQUEST['id_element'];
        $id_respuesta = $_REQUEST['num_consecutivo_respuesta'];

        $doc_correspondencia = new CCorrespondencia($id, $corrData);
        $doc_correspondencia->loadCorrespondecia();
        
        $doc_respuesta = new CCorrespondencia($id_respuesta, $corrData);
        $doc_respuesta->loadCorrespondecia();

        $doc_correspondencia->setFechaRepuesta($doc_respuesta->fechaRadicado);    
        $doc_correspondencia->setConsecutivoRespuesta($doc_respuesta->codigoReferencia);
        $doc_correspondencia->setDocumentoRespuesta($doc_respuesta->documentoSoporte);
        //$doc_correspondencia->setOperador(OPERADOR_DEFECTO);
        if($doc_respuesta->documentoSoporte!='')
            $doc_correspondencia->setEstado(2);
        else
            $doc_correspondencia->setEstado(3);
        
        $m = $doc_correspondencia->saveResponderCorrespondencia();
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=1&task=list&sel_area=" . $area . "&txt_descripcion=" . $descripcion);

        break;
  
    //-----------------------------------------------------------------------------
    /**
     * en caso de que la variable task no este definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');

        break;
}
?>   