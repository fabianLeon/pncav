<?php

    header('Content-type: application/vnd.ms-excel');
    header("Content-Disposition: attachment; filename=Informe_Egresos.xls");

    error_reporting(E_ALL - E_NOTICE - E_DEPRECATED - E_WARNING);
    require('../../clases/datos/CIngresosData.php');
    require('../../clases/datos/CData.php');
    require('../../clases/interfaz/CHtml.php');
    include('../../config/conf.php');
    include('../../config/constantes.php');
    require('../../lang/es-co/ingresos-es.php');
    require('../../lang/es-co/actividades_es.php');

    $html = new CHtml('');
    $docData = new CIngresosData($db);
    $Years = $docData->ObtenerYears();
    $vigenciaObjetivo = 2013;
    $actividadObjetivo=ACTIVIDAD_PIA;
    for ($i = 0; $i < count($Years); $i++) {
        $arrayear[$i] = $Years[$i]['A_Ingreso'];
    }
    $tabla_egresos=null;
    $saldo=0;
        for ($i = 0; $i < count($arrayear); $i++){
            $presupuesto_ejecutado=0;
            if($arrayear[$i]==$vigenciaObjetivo){
                for($j =0 ; $j<count($arrayear); $j++){
                    
                    if($arrayear[$j]==$vigenciaObjetivo){
                        $ordenes_aprobadas = $docData->ObtenerValoresOrdenesdePago($arrayear[$j]);
                    }else{
                        $ordenes_aprobadas = $docData->ObtenerValoresOrdenesdePagoByActividad($arrayear[$j],"= $actividadObjetivo");
                    }
                    
                    if($ordenes_aprobadas[0]<0){
                        $presupuesto_ejecutado -= $ordenes_aprobadas[0];
                    }else{
                        $presupuesto_ejecutado += $ordenes_aprobadas[0];
                    }
                }
                }else{
                    $ordenes_aprobadas = $docData->ObtenerValoresOrdenesdePagoByActividad($arrayear[$i],"!= $actividadObjetivo");
                    if($ordenes_aprobadas[0]<0){
                        $presupuesto_ejecutado = $ordenes_aprobadas[0];
                    }else{
                        $presupuesto_ejecutado = $ordenes_aprobadas[0];
                    }
                }
                $utilidades_aprobadas = $docData->ObtenerValoresUtilidades($arrayear[$i]);
                $vigencias_Montos = $docData->ObtenerValoresIngresos($arrayear[$i]);
                if($utilidades_aprobadas[0] != 0){
                    $porcentaje_ejecucion = ($presupuesto_ejecutado * 100) / $utilidades_aprobadas[0];
                }else{
                    $porcentaje_ejecucion = 0;
                }

                $presupuesto_ejecutar = $utilidades_aprobadas[0]-$presupuesto_ejecutado;

                if($arrayear[$i]!=$vigenciaObjetivo){
                    $saldo+=($presupuesto_ejecutado);
                }
                $tabla_egresos[$i]['id'] =                  $i;
                $tabla_egresos[$i]['anio'] =                $arrayear[$i];
                echo $tabla_egresos[$i]['anio']."  ";
                $tabla_egresos[$i]['presAsignado'] =        $vigencias_Montos[1];
                $tabla_egresos[$i]['recAsignado'] =         $utilidades_aprobadas[0];
                $tabla_egresos[$i]['numeroUtilizaciones'] = $utilidades_aprobadas[1];
                $tabla_egresos[$i]['presEjecutado'] =       $presupuesto_ejecutado;
                $tabla_egresos[$i]['presPendiente'] =       $presupuesto_ejecutar;
                $tabla_egresos[$i]['porcentaje'] =          $porcentaje_ejecucion;
        }
        if($saldo>0){
            for ($i = 0; $i <count($tabla_egresos); $i++){
                if ($arrayear[$i] == $vigenciaObjetivo) {
                    continue;
                }
                if($tabla_egresos[$i]['recAsignado']==0){
                    $tabla_egresos[$i]['porcentaje']=0;
                    $tabla_egresos[$i]['presPendiente']=0;
                    $tabla_egresos[$i]['presEjecutado']=0;
                }
                else if($tabla_egresos[$i]['recAsignado']<=$saldo){
                    $tabla_egresos[$i]['presPendiente']=0;
                    $tabla_egresos[$i]['porcentaje']=100;
                    $tabla_egresos[$i]['presEjecutado']=$tabla_egresos[$i]['recAsignado'];
                    $saldo-=$tabla_egresos[$i]['recAsignado'];
                }else{
                    $tabla_egresos[$i]['presPendiente']=$tabla_egresos[$i]['recAsignado']-$saldo;
                    $tabla_egresos[$i]['porcentaje']=100*
                            ($tabla_egresos[$i]['recAsignado']-$tabla_egresos[$i]['presPendiente'])/$tabla_egresos[$i]['recAsignado'];
                    $tabla_egresos[$i]['presEjecutado']=$saldo;
                    $saldo=0;
                }
            }
        }


    echo "<table width='80%' border='0' align='center'>";
    //encabezado
    echo"<tr><th colspan = '8'><center></center></th></tr>";
    echo"<tr><th colspan = '8' bgcolor='#CCCCCC'><center>" . $html->traducirTildes(TABLA_EGRESOS_EXCEL) . "</center></th></tr>";

    //titulos
    echo "<tr>";

    echo "<th>" . $html->traducirTildes(CAMPO_ANIO) . "</th>
            <th>" . $html->traducirTildes(PRESUPUESTO_ASIGNADO) . "</th>
            <th>" . $html->traducirTildes(RECUROS_ASIGNADOS) . "</th>
            <th>" . $html->traducirTildes(NUMERO_UTILIZACIONES) . "</th>
            <th>" . $html->traducirTildes(PRESUPUESTO_EJECUTADO) . "</th>
            <th>" . $html->traducirTildes(PRESUPUESTO_EJECUTAR) . "</th>
            <th>" . $html->traducirTildes(PORCENTAJE_EJECUCION) . "</th>";
    echo "</tr>";


    echo "<tr>";

    //datos 
    $contador = 0;
    $cont = count($tabla_egresos);
    while ($contador < $cont) {

        echo "<tr>";
        echo "<td>" .$tabla_egresos[$contador]['anio']. "</td>	
            <td>" . number_format($tabla_egresos[$contador]['presAsignado'],2,',','.') . "</td>
            <td>" . number_format($tabla_egresos[$contador]['recAsignado'],2,',','.') . "</td>
            <td>" . number_format($tabla_egresos[$contador]['numeroUtilizaciones'],0,'','.') . "</td>
            <td>" . number_format($tabla_egresos[$contador]['presEjecutado'],2,',','.') . "</td>
            <td>" . number_format($tabla_egresos[$contador]['presPendiente'],2,',','.'). "</td>
            <td>" . number_format($tabla_egresos[$contador]['porcentaje'],6,',','.'). "</td>";
        echo "</tr>";
        $contador++;
    }
    echo "</table>";
?>