<?php


    defined('_VALID_PRY') or die('Restricted access');
    $docData 		= new CRegistroInversionData($db);
    $docDataAct         = new CActividadPIAData($db);
    $operador		= $_REQUEST['operador'];
    $task 			= $_REQUEST['task'];
    if (empty($task)) {
        $task = 'list';
    }
    
    switch($task){
        case 'list':
        $form = new CHtmlForm();

        $form->setTitle(TITULO_RESUMEN_REGISTRO_INVERSION);
        $form->setId('frm_list_resumen_registros');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->addEtiqueta('');
        
        $form->writeForm();
        
        $actividades = $docDataAct->getActividadPIA('1=1');
        $formas=null;
        
        $num = count($actividades);
        $cont =0;
        $titulos = array(CAMPO_NOMBRE_PROVEEDOR,CAMPO_NUMERO_DOCUMENTO,CAMPO_FECHA_INVERSION,CAMPO_VALOR_INVERSION);
        $dt=null;
//        $neto =0;
        while($cont<$num){
            $formas[$cont] = new CHtmlForm();
//            $neto = $actividades[$cont]['monto']-$docData->getSumaInversion($actividades[$cont]['id_element']);
            $formas[$cont]->addTitleText('title','');
            $r = $docData->getRegistroInversion(" rin.act_id = ".$actividades[$cont]['id_element']);
            $cont1=0;
            $sum=count($r);
            $registros=null;
            while($cont1<$sum){
                $registros[$cont1]['id']=$r[$cont1]['id_element'];
                $registros[$cont1]['proveedor']=$r[$cont1]['proveedor'];
                $registros[$cont1]['numero_documento']=$r[$cont1]['numero_documento'];
                $registros[$cont1]['fecha']=$r[$cont1]['fecha'];
                $registros[$cont1]['valor']=$r[$cont1]['valor'];
                $cont1++;
            }
            
            $dt[$cont] = new CHtmlDataTable();
            $dt[$cont]->setDataRows($registros);
            $dt[$cont]->setTitleRow($titulos);
            $dt[$cont]->setTitleTable(TITULO_TABLA_RESUMEN_REGISTRO_INVERSION_PARCIAL.$actividades[$cont]['descripcion'].
                    ". ".CAMPO_MONTO." ".number_format($actividades[$cont]['monto'], 0, ',', '.'));
            $dt[$cont]->setType(1);
            $dt[$cont]->setSumColumns(array(4));
            $dt[$cont]->setLabelPrincipal(array(CAMPO_TOTAL));
            $dt[$cont]->setVersusSum(array($actividades[$cont]['monto']));
            $dt[$cont]->setLabelSum(array('Neto = '));
            $dt[$cont]->setPag(1);
            
            $formas[$cont]->writeForm();
            $dt[$cont]->writeDataTable($niv);
            
            echo "";
            $cont++;
        }
        
        
        
        break;
    }
    


?>
