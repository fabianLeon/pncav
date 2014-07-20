<?php


    defined('_VALID_PRY') or die('Restricted access');
    $docData 		= new COrdenesdepagoData($db);
    $docDataAct         = new CActividadData($db);
    $operador		= $_REQUEST['operador'];
    $task 			= $_REQUEST['task'];
    if (empty($task)) {
        $task = 'list';
    }
    
    switch($task){
        case 'list':
        $form = new CHtmlForm();

        $form->setTitle(TITULO_RESUMEN_REGISTRO_INVERSION);
        $form->setId('frm_list_resumen_registros_anticipo');
        $form->setMethod('post');
        $form->options['autoClean'] = false;
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', COMPROMISOS_EXPORTAR, 'button', 'onClick=exportar_invsersiondelanticipo_excel();');
        $form->setClassEtiquetas('td_label');
        $form->addEtiqueta('');
        
        $form->writeForm();
        
        $actividades = $docDataAct->ObtenerActividades(ACTIVIDAD_PIA);
        $formas=null;
        
        $num = count($actividades);
        $cont =0;
        $titulos = array(ORDEN_DE_PAGO,CAMPO_NOMBRE_PROVEEDOR,CAMPO_NUMERO_DOCUMENTO,CAMPO_FECHA_INVERSION,CAMPO_VALOR_INVERSION);
        $dt=null;
//        $neto =0;
        while($cont<$num){
            $formas[$cont] = new CHtmlForm();
//            $neto = $actividades[$cont]['monto']-$docData->getSumaInversion($actividades[$cont]['id_element']);
            $formas[$cont]->addTitleText('title','');
            $formas[$cont]->writeForm();
            $r = $docData->obtenerOrdenesdepago(" o.id_actividad = ".
                    $actividades[$cont]['id']." AND (o.id_estado_orden = 1 OR o.id_estado_orden = 4)");
            $registros=null;
            $cont1=0;
            $sum=count($r);
            while($cont1<$sum){
                $registros[$cont1]['id']=       $cont1;
                $registros[$cont1]['numeroOrden']=   $r[$cont1]['numerorden'];
                $registros[$cont1]['prove']=    $r[$cont1]['proveedor'];
                $registros[$cont1]['numeroFactura']=   $r[$cont1]['numerofactura'];
                $registros[$cont1]['factura']=  $r[$cont1]['fecha'];
                $registros[$cont1]['total']=    $r[$cont1]['valortotal']; 
                $cont1++;
            }
            
            $dt[$cont] = new CHtmlDataTable();
            $dt[$cont]->setTitleTable(TITULO_TABLA_RESUMEN_REGISTRO_INVERSION_PARCIAL.$actividades[$cont]['descripcion'].
                    ". ".CAMPO_MONTO." ".number_format($actividades[$cont]['monto'], 0, ',', '.'));
            $dt[$cont]->setDataRows($registros);
            $dt[$cont]->setTitleRow($titulos);
            
            
            $dt[$cont]->setType(1);
            $dt[$cont]->setSumColumns(array(5));
            $dt[$cont]->setFormatRow(array(null,null,null,null,array(2,',','.')));
            $dt[$cont]->setLabelPrincipal(array(CAMPO_TOTAL));
            $dt[$cont]->setVersusSum(array($actividades[$cont]['monto']));
            $dt[$cont]->setLabelSum(array(null,null,null,null,null,CAMPO_NETO));
            $dt[$cont]->setPag(1);
            
            $dt[$cont]->writeDataTable($niv);
            
            $cont++;
        }
        
        
        
        break;
    }
    


?>
