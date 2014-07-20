<?php


    defined('_VALID_PRY') or die('Restricted access');
    $docData 		= new CDesembolsoData($db);
    $operador		= $_REQUEST['operador'];
    $task 			= $_REQUEST['task'];
    if (empty($task)) {
        $task = 'list';
    }

switch($task){
    
    case 'list':
        $numero = $_REQUEST['txt_numero'];
        $estado	= $_REQUEST['sel_estado'];
        $criterio = " des_id LIKE '$numero%' ";

        //echo ("<br>criterio:<br>".$criterio);

        $form = new CHtmlForm();

        $form->setTitle(TITULO_DESEMBOLSOS);
        $form->setId('frm_list_desembolso');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(CAMPO_NUMERO_DESEMBOLSO);
        $form->addInputText('text', 'txt_numero', 'txt_numero', '30', '30', $numero, '', '');
        $form->addError('error_numero_desembolso','Error1');

        $form->addEtiqueta(CAMPO_ESTADO);
        $dependientes = array(array('value'=>1,'texto'=>'Completado'),array('value'=>2,'texto'=>'Pendiente'));
        $form->addSelect('select', 'sel_estado', 'sel_estado', $dependientes, CAMPO_ESTADO, $estado, '', '');
        $form->addError('error_estado','Error2');
        
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onclick=submit();');
        $form->addInputButton('button', 'btn_exportar_des', 'btn_exportar_des', COMPROMISOS_EXPORTAR, 'button', 'onclick="exportar_archivo_excel_desembolso();"');

        $form->writeForm();
        
        $desembolsos = $docData->getDesembolso($criterio,'des_id');
        $datos = null;
        $cont=0;
        $neto=0;
        $tam = count($desembolsos);
        while($cont<$tam){
            if(($estado!=1 && $estado!=2)||
                    ($estado==1 && $desembolsos[$cont]['aprobado']-$desembolsos[$cont]['amortizacion']-$desembolsos[$cont]['efectuado']==0) || 
                    ($estado==2 &&$desembolsos[$cont]['aprobado']-$desembolsos[$cont]['amortizacion']-$desembolsos[$cont]['efectuado']!=0)){
                $datos[$cont]['temp']=$desembolsos[$cont]['id'];
                $datos[$cont]['id'] = $desembolsos[$cont]['id'];
                $datos[$cont]['fecha'] = $desembolsos[$cont]['fecha'];
                $datos[$cont]['vigencia'] = $desembolsos[$cont]['vigencia'];
                $datos[$cont]['soporte'] = $desembolsos[$cont]['soporte'];
                $datos[$cont]['condicion'] = $desembolsos[$cont]['condicion'];
                $datos[$cont]['porcentaje'] = number_format($desembolsos[$cont]['porcentaje']*100,2,',','.')."%";
                $datos[$cont]['aprobado'] = $desembolsos[$cont]['aprobado'];
                $datos[$cont]['porcentaje_amortizacion'] =  number_format($desembolsos[$cont]['porcentaje_amortizacion']*100,2,',','.')."%";
                $datos[$cont]['amortizacion'] = $desembolsos[$cont]['amortizacion'];
                $neto = $desembolsos[$cont]['aprobado']-$desembolsos[$cont]['amortizacion'];
                $datos[$cont]['valor_neto'] =$neto;
                $datos[$cont]['fecha_cumplimiento'] = $desembolsos[$cont]['fecha_cumplimiento'];
                $datos[$cont]['fecha_tramite'] = $desembolsos[$cont]['fecha_tramite'];
                $datos[$cont]['fecha_limite'] = $desembolsos[$cont]['fecha_limite'];
                $datos[$cont]['fecha_efectiva'] = $desembolsos[$cont]['fecha_efectiva'];
                $datos[$cont]['efectuado'] = $desembolsos[$cont]['efectuado'];
                $datos[$cont]['observaciones'] = $desembolsos[$cont]['observaciones'];
                if($neto-$desembolsos[$cont]['efectuado']==0){
                    $datos[$cont]['estado']="<img src='templates/img/ico/verde.gif'>  ".(number_format($neto-$desembolsos[$cont]['efectuado'],2,',','.'));
                }
                else{
                    if($neto-$desembolsos[$cont]['efectuado']<0){
                        $datos[$cont]['estado']="<img src='templates/img/ico/rojo.gif'>  ".(number_format(($neto-$desembolsos[$cont]['efectuado'])*(-1),2,',','.'));
                    }else{
                        $datos[$cont]['estado']="<img src='templates/img/ico/rojo.gif'>  ".(number_format($neto-$desembolsos[$cont]['efectuado'],2,',','.'));
                    }                    
                }
               
            }
             $cont++;
        }
        

        $dt = new CHtmlDataTable();
        $titulos = array(CAMPO_NUMERO_DESEMBOLSO,CAMPO_FECHA,CAMPO_VIGENCIA,CAMPO_DOCUMENTO_SOPORTE,CAMPO_DOCUMENTO_CONDICIONES,CAMPO_PORCENTAJE_DESEMBOLSO,
            CAMPO_APROBADO,CAMPO_PORCENTAJE_AMORTIZACION,CAMPO_AMORTIZACION,CAMPO_VALOR_NETO,CAMPO_FECHA_CUMPLIMIENTO,
            CAMPO_FECHA_TRAMITE,CAMPO_FECHA_LIMITE,CAMPO_FECHA_EFECTIVA,CAMPO_DESEMBOLSO,
            CAMPO_OBSERVACIONES,CAMPO_ESTADO);
        
        $dt->setDataRows($datos);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TITULO_DESEMBOLSOS);

        $dt->setEditLink  ("?mod=".$modulo."&niv=".$niv."&task=edit");
        $dt->setDeleteLink("?mod=".$modulo."&niv=".$niv."&task=delete");
        $dt->setAddLink   ("?mod=".$modulo."&niv=".$niv."&task=add");
        
        $dt->setType(1);
        $dt->setFormatRow(array(null,null,null,null,null,null,array(2,',','.'),null,
            array(2,',','.'),array(2,',','.'),null,null,null,null,array(2,',','.'),null,null));
        $dt->setSumColumns(array(7,9,10,15));
        $dt->setPag(1);
        $dt->writeDataTable($niv);


    break;
/**
* la variable add, permite hacer la carga la página con las variables que componen el objeto COMUNICADO, ver la clase CComunicado
*/
    case 'add':
        
        $form = new CHtmlForm();
        $form->setTitle(TITULO_AGREGAR_DESEMBOLSO);
        $form->setId('frm_agregar_desembolso');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        $form->addEtiqueta(CAMPO_NUMERO_DESEMBOLSO);
        $form->addInputText('text', 'txt_numero', 'txt_numero', '20', '20', '', '', 'onkeypress="ocultarDiv(\'error_numero\');"');
        $form->addError('error_numero', ERROR_NUMERO_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA);
        $form->addInputDate('date', 'date_fecha', 'date_fecha', '', '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_VIGENCIA);
        $form->addInputDate('date', 'date_vigencia', 'date_vigencia', '', '%Y', '16', '16', '', 'onkeypress="ocultarDiv(\'error_vigencia\');"');
        $form->addError('error_vigencia', ERROR_VIGENCIA_UTILIDADES);
        
        $form->addEtiqueta(CAMPO_DOCUMENTO_SOPORTE);
        $form->addInputFile('file','file_soporte','file_soporte','25','file','onChange="ocultarDiv(\'error_soporte\');"');
        $form->addError('error_soporte',ERROR_COMUNICADO_ARCHIVO);
        
        $form->addEtiqueta(CAMPO_DOCUMENTO_CONDICIONES);
        $form->addInputFile('file','file_condiciones','file_condiciones','25','file','onChange="ocultarDiv(\'error_condiciones\');"');
        $form->addError('error_condiciones',ERROR_COMUNICADO_ARCHIVO);
        
        $form->addEtiqueta(CAMPO_PORCENTAJE_DESEMBOLSO);
        $form->addInputText('text', 'txt_porcentaje', 'txt_porcentaje', '6', '6', '', '', 'onkeypress="ocultarDiv(\'error_porcentaje\');"');
        $form->addError('error_porcentaje', ERROR_PORCENTAJE_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_APROBADO);
        $form->addInputText('text', 'txt_aprobado', 'txt_aprobado', '20', '20', '', '', 'onkeypress="ocultarDiv(\'error_aprobado\');"');
        $form->addError('error_aprobado', ERROR_APROBADO_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_PORCENTAJE_AMORTIZACION);
        $form->addInputText('text', 'txt_porcentaje_amortizacion', 'txt_porcentaje_amortizacion', '6', '6', '', '', 'onkeypress="ocultarDiv(\'error_porcentaje_amortizacion\');"');
        $form->addError('error_porcentaje_amortizacion', ERROR_PORCENTAJE_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_AMORTIZACION);
        $form->addInputText('text', 'txt_amortizacion', 'txt_amortizacion', '20', '20', '', '', 'onkeypress="ocultarDiv(\'error_amortizacion\');"');
        $form->addError('error_amortizacion', ERROR_APROBADO_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA_CUMPLIMIENTO);
        $form->addInputDate('date', 'date_fecha_cumplimiento', 'date_fecha_cumplimiento', '', '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_cumplimiento\');"');
        $form->addError('error_fecha_cumplimiento', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA_TRAMITE);
        $form->addInputDate('date', 'date_fecha_tramite', 'date_fecha_tramite', '', '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_tramite\');"');
        $form->addError('error_fecha_tramite', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA_LIMITE);
        $form->addInputDate('date', 'date_fecha_limite', 'date_fecha_limite', '', '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_limite\');"');
        $form->addError('error_fecha_limite', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA_EFECTIVA);
        $form->addInputDate('date', 'date_fecha_efectiva', 'date_fecha_efectiva', '', '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_efectiva\');"');
        $form->addError('error_fecha_efectiva', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_DESEMBOLSO);
        $form->addInputText('text', 'txt_desembolso', 'txt_desembolso', '20', '20', '', '', 'onkeypress="ocultarDiv(\'error_desembolso\');"');
        $form->addError('error_desembolso', ERROR_APROBADO_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observacion', 'txt_observacion', '50', '4', '', '', '');
        
        $form->addInputButton('button', 'ok', 'ok', BOTON_INSERTAR, 'button', 'onclick="validar_agregar_desembolso();"');
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionDesembolso(\'frm_agregar_desembolso\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        
        
        break;
    
    case 'guardarDesembolso':
        $numero = $_REQUEST['txt_numero'];
        $fecha = $_REQUEST['date_fecha'];
        $soporte = $_FILES['file_soporte'];
        $condiciones = $_FILES['file_condiciones'];
        $porcentaje = $_REQUEST['txt_porcentaje']/100;
        $aprobado = $_REQUEST['txt_aprobado'];
        $porcentaje_amortizacion = $_REQUEST['txt_porcentaje_amortizacion']/100;
        $amortizacion = $_REQUEST['txt_amortizacion'];
        $fecha_tramite = $_REQUEST['date_fecha_tramite'];
        $fecha_limite = $_REQUEST['date_fecha_limite'];
        $fecha_cumplimiento = $_REQUEST['date_fecha_cumplimiento'];
        $fecha_efectiva = $_REQUEST['date_fecha_efectiva'];
        $efectuado = $_REQUEST['txt_desembolso'];
        $observaciones = $_REQUEST['txt_observacion'];
        $vigencia = $_REQUEST['date_vigencia'];
        
        $nuevoDesenbolso = $docData->insertDesembolso($numero, $fecha, $vigencia,$soporte, 
                $condiciones, $porcentaje, $aprobado, $porcentaje_amortizacion, 
                $amortizacion, $fecha_cumplimiento, $fecha_tramite, $fecha_efectiva, 
                $fecha_limite, $efectuado, $observaciones);
        echo $html->generaAviso($nuevoDesenbolso, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;
    
    case 'edit':
        $id = $_REQUEST['id_element'];
        $desembolso = $docData->getDesembolsoById($id);
        $fecha = $desembolso['des_fecha'];
        $soporte = $_FILES['file_soporte'];
        $condiciones = $_FILES['file_condiciones'];
        $porcentaje = $desembolso['des_porcentaje'];
        $aprobado = $desembolso['des_aprobado'];
        $porcentaje_amortizacion = $desembolso['des_porcentaje_amortizacion'];
        $amortizacion = $desembolso['des_amortizacion'];
        $fecha_tramite = $desembolso['des_fecha_tramite'];
        $fecha_limite = $desembolso['des_fecha_limite'];
        $fecha_cumplimiento = $desembolso['des_fecha_cumplimiento'];
        $fecha_efectiva = $desembolso['des_fecha_efectiva'];
        $efectuado = $desembolso['des_efectuado'];
        $observaciones = $desembolso['des_observaciones'];
        $vigencia = $desembolso['des_vigencia'];
        
        $form = new CHtmlForm();
        $form->setTitle(TITULO_EDITAR_DESEMBOLSO);
        $form->setId('frm_editar_desembolso');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        
        $form->addEtiqueta(CAMPO_NUMERO_DESEMBOLSO);
        $form->addInputText('text', 'txt_numero_edit', 'txt_numero_edit', '20', '20', $id, '', 'onkeypress="ocultarDiv(\'error_numero\');"');
        $form->addError('error_numero', ERROR_NUMERO_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA);
        $form->addInputDate('date', 'date_fecha_edit', 'date_fecha_edit', $fecha.'', '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_VIGENCIA);
        $form->addInputDate('date', 'date_vigencia_edit', 'date_vigencia_edit', $vigencia, '%Y', '16', '16', '', 'onkeypress="ocultarDiv(\'error_vigencia\');"');
        $form->addError('error_vigencia', ERROR_VIGENCIA_UTILIDADES);
        
        $form->addEtiqueta(CAMPO_DOCUMENTO_SOPORTE);
        $form->addInputFile('file','file_soporte_edit','file_soporte_edit','25','file','onChange="ocultarDiv(\'error_soporte\');"');
        $form->addError('error_soporte',ERROR_COMUNICADO_ARCHIVO);
        
        $form->addEtiqueta(CAMPO_DOCUMENTO_CONDICIONES);
        $form->addInputFile('file','file_condiciones_edit','file_condiciones_edit','25','file','onChange="ocultarDiv(\'error_condiciones\');"');
        $form->addError('error_condiciones',ERROR_COMUNICADO_ARCHIVO);
        
        $form->addEtiqueta(CAMPO_PORCENTAJE_DESEMBOLSO);
        $form->addInputText('text', 'txt_porcentaje_edit', 'txt_porcentaje_edit', '6', '6', $porcentaje*100, '', 'onkeypress="ocultarDiv(\'error_porcentaje\');"');
        $form->addError('error_porcentaje', ERROR_PORCENTAJE_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_APROBADO);
        $form->addInputText('text', 'txt_aprobado_edit', 'txt_aprobado_edit', '20', '20', $aprobado, '', 'onkeypress="ocultarDiv(\'error_aprobado\');"');
        $form->addError('error_aprobado', ERROR_APROBADO_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_PORCENTAJE_AMORTIZACION);
        $form->addInputText('text', 'txt_porcentaje_amortizacion_edit', 'txt_porcentaje_amortizacion_edit', '6', '6', $porcentaje_amortizacion*100, '', 'onkeypress="ocultarDiv(\'error_porcentaje_amortizacion\');"');
        $form->addError('error_porcentaje_amortizacion', ERROR_PORCENTAJE_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_AMORTIZACION);
        $form->addInputText('text', 'txt_amortizacion_edit', 'txt_amortizacion_edit', '20', '20', $amortizacion, '', 'onkeypress="ocultarDiv(\'error_amortizacion\');"');
        $form->addError('error_amortizacion', ERROR_APROBADO_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA_CUMPLIMIENTO);
        $form->addInputDate('date', 'date_fecha_cumplimiento_edit', 'date_fecha_cumplimiento_edit', $fecha_cumplimiento, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_cumplimiento\');"');
        $form->addError('error_fecha_cumplimiento', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA_TRAMITE);
        $form->addInputDate('date', 'date_fecha_tramite_edit', 'date_fecha_tramite_edit', $fecha_tramite, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_tramite\');"');
        $form->addError('error_fecha_tramite', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA_LIMITE);
        $form->addInputDate('date', 'date_fecha_limite_edit', 'date_fecha_limite_edit', $fecha_limite, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_limite\');"');
        $form->addError('error_fecha_limite', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_FECHA_EFECTIVA);
        $form->addInputDate('date', 'date_fecha_efectiva_edit', 'date_fecha_efectiva_edit', $fecha_efectiva, '%Y-%m-%d', '16', '16', '', 'onkeypress="ocultarDiv(\'error_fecha_efectiva\');"');
        $form->addError('error_fecha_efectiva', ERROR_FECHA_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_DESEMBOLSO);
        $form->addInputText('text', 'txt_desembolso_edit', 'txt_desembolso_edit', '20', '20', $efectuado, '', 'onkeypress="ocultarDiv(\'error_desembolso\');"');
        $form->addError('error_desembolso', ERROR_APROBADO_DESEMBOLSO);
        
        $form->addEtiqueta(CAMPO_OBSERVACIONES);
        $form->addTextArea('textarea', 'txt_observacion_edit', 'txt_observacion_edit', '50', '4', $observaciones, '', '');
        
        $form->addInputButton('button', 'ok_edit', 'ok_edit', BOTON_EDITAR, 'button', 'onclick="validar_editar_desembolso();"');
        $form->addInputButton('button', 'cancel', 'cancel', BOTON_CANCELAR, 'button', 'onclick="cancelarAccionDesembolso(\'frm_editar_desembolso\',\'?mod=' . $modulo . '&task=list&niv=' . $niv . '\');"');
        $form->writeForm();
        
        break;
    case 'saveEdit':
        
        $numero = $_REQUEST['txt_numero_edit'];
        $fecha = $_REQUEST['date_fecha_edit'];
        $soporte = $_FILES['file_soporte_edit'];
        $condiciones = $_FILES['file_condiciones_edit'];
        $porcentaje = $_REQUEST['txt_porcentaje_edit']/100;
        $aprobado = $_REQUEST['txt_aprobado_edit'];
        $porcentaje_amortizacion = $_REQUEST['txt_porcentaje_amortizacion_edit']/100;
        $amortizacion = $_REQUEST['txt_amortizacion_edit'];
        $fecha_tramite = $_REQUEST['date_fecha_tramite_edit'];
        $fecha_limite = $_REQUEST['date_fecha_limite_edit'];
        $fecha_cumplimiento = $_REQUEST['date_fecha_cumplimiento_edit'];
        $fecha_efectiva = $_REQUEST['date_fecha_efectiva_edit'];
        $efectuado = $_REQUEST['txt_desembolso_edit'];
        $observaciones = $_REQUEST['txt_observacion_edit'];
        $vigencia = $_REQUEST['date_vigencia_edit'];
        $dese= new CDesembolsoData($db);
        $m=$dese->updateDesembolso($numero, $fecha, $vigencia, $soporte, $condiciones, $porcentaje, $aprobado, $porcentaje_amortizacion, $amortizacion, $fecha_cumplimiento, $fecha_tramite, $fecha_efectiva, $fecha_limite, $efectuado, $observaciones);
        
        echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list&txt_fecha_inicio=".$fecha_inicio."&txt_fecha_fin=".$fecha_fin."&sel_autor=".$autor."&sel_destinatario=".$destinatario."&txt_referencia=".$referencia."&sel_tema=".$tema."&sel_subtema=".$subtema."&operador=".$operador);
        
        break;
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        $form = new CHtmlForm();
        $form->setId('frm_delet_correspondencia');
        $form->setMethod('post');
        $form->writeForm();
        
        echo $html->generaAdvertencia(DOCUMENTO_MSG_BORRADO, '?mod=' . $modulo . '&niv=' . $niv . '&task=confirmDelete&id_element=' . $id_delete, 
                "cancelarAccion('frm_delet_desembolso','task=confirmDelete');");
      
        break;
    
    case 'confirmDelete':
            $id_delete 		= $_REQUEST['id_element'];
            $desembolso = new CDesembolso($id_delete,'','','','','','','','','','','','',$docData);
            $m = $desembolso->deleteDesembolso();
            echo $html->generaAviso($m,"?mod=".$modulo."&niv=".$niv."&task=list");

        break;
            
    default:
            include('templates/html/under.html'); 

    break;
}
