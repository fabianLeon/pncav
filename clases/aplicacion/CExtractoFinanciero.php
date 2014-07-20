<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CExtracto
 *
 * @author alejandro
 */
class CExtractoFinanciero {
    
    var $id;
    var $cuenta;
    var $cuenta_nombre;
    var $cuenta_numero;
    var $mes;
    var $anio;
    var $saldo_inicial;
    var $incrementos;
    var $disminuciones;
    var $saldo_final;
    var $rentabilidad;
    var $observaciones;
    var $documento_soporte;
    var $documento_movimientos;
    var $data;
    
    var $permitidos_soporte = array('pdf','zip','rar','7z');
    var $permitidos_movimiento = array('xls', 'xlsx');
    
    function __construct($id,$data) {
        $this->id = $id;
        $this->data = $data;
    }
    
    function loadExtracto(){
        $r = $this->data->getExtractoById($this->id);
        if($r){
            $this->cuenta = $r['cuenta'];
            $this->cuenta_nombre = $r['cuenta_nombre'];
            $this->cuenta_numero = $r['cuenta_numero'];
            $this->mes = $r['mes'];
            $this->anio = $r['anio'];
            $this->saldo_inicial = $r['saldo_inicial'];
            $this->incrementos = $r['incrementos'];
            $this->disminuciones = $r['disminuciones'];
            $this->saldo_final = $r['saldo_final'];
            $this->rentabilidad = $r['rentabilidad'];
            $this->observaciones = $r['observaciones'];
            $this->documento_soporte = $r['documento_soporte'];
            $this->documento_movimientos = $r['documento_movimientos'];
        }
    }
    
    function saveExtracto(){
        
        $tipo_cuenta = $this->data->getTipoCuenta($this->cuenta);
        
        $extension_soporte = explode(".", $this->documento_soporte['name']);
        $extension_movimientos = explode(".", $this->documento_movimientos['name']);
        
        $pos_soporte = count($extension_soporte) - 1;
        $pos_movimientos = count($extension_movimientos) - 1;
        
        $valido_soporte = false;
        $valido_movimientos = false;
        
        foreach ($this->permitidos_soporte as $p) {
            if (strcasecmp($extension_soporte[$pos_soporte], $p) == 0)
                $valido_soporte = true;
        }
        
        foreach ($this->permitidos_movimiento as $p) {
            if (strcasecmp($extension_movimientos[$pos_movimientos], $p) == 0)
                $valido_movimientos = true;
        }
        
        if(!$valido_soporte){
            return ERROR_DOCUMENTO_SOPORTE_NO_VALIDO;
        }
        
        if(!$valido_movimientos){
            return ERROR_DOCUMENTO_MOVIMIENTOS_NO_VALIDO;
        }
        
        if($this->documento_soporte['name']==NULL || $this->documento_soporte['name'] == ""){
            return ERROR_DOCUMENTO_SOPORTE_VACIO;
        }
        
        if($this->documento_movimientos['name']==NULL || $this->documento_movimientos['name'] == ""){
            return ERROR_DOCUMENTO_MOVIMIENTOS_VACIO;
        }
        
        if ($this->documento_soporte['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_SOPORTE;
        }
        
        if ($this->documento_movimientos['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_MOVIMIENTOS;
        }
        
        $dirOperador = $this->data->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_EXTRACTOS_SOPORTES . "/" . $dirOperador . "/");
        
        $carpetas = explode("/", substr($ruta, 0, strlen($ruta) - 1));
        $ruta_destino = '';

        foreach ($carpetas as $c) {
            if (strlen($ruta_destino) > 0) {
                $ruta_destino .= "/" . $c;
            } else {
                $ruta_destino = $c;
            }
            //echo $ruta_destino."<br>";
            if (!is_dir($ruta_destino)) {
                mkdir($ruta_destino, 0777);
            } else {
                chmod($ruta_destino, 0777);
            }
        }
        
        $nombre_compuesto_soporte = EXTRACTO_DOCUMENTO_SOPORTE."-".$this->cuenta.$this->anio.$this->mes.".".$extension_soporte[$pos_soporte];
        
        if(!move_uploaded_file($this->documento_soporte['tmp_name'], $ruta . $nombre_compuesto_soporte)){
            return ERROR_COPIAR_ARCHIVO_EXTRACTO_SOPORTE;
        }

        $nombre_compuesto_movimientos = EXTRACTO_DOCUMENTO_MOVIMIENTOS."-".$this->cuenta.$this->anio.$this->mes.".".$extension_movimientos[$pos_movimientos];
        if(!move_uploaded_file($this->documento_movimientos['tmp_name'], $ruta . $nombre_compuesto_movimientos)){
            return ERROR_COPIAR_ARCHIVO_EXTRACTO_MOVIMIENTOS;

        }
        
        
        $data = new Spreadsheet_Excel_Reader();

        $data->setOutputEncoding('CP1251');

        $data->read($ruta . $nombre_compuesto_movimientos);
        
        if($this->saldo_inicial == 0){
            $this->saldo_inicial = $data->sheets[0]['cells'][4][2];
        }
        
        //$tipo_cuenta

        $saldo = $this->saldo_inicial;
        $rendimiento = 0;
        
        $nombre_csv = EXTRACTO_DOCUMENTO_GENERADO."-".$this->cuenta.$this->anio.$this->mes.".xls";
        $fp = fopen($ruta.$nombre_csv,"w");
        fwrite($fp, "<table border='1'>");
        
        
        if($tipo_cuenta == 1){//cuenta colectiva
            fwrite($fp, "<tr>");
            fwrite($fp, "<td>".EXTRACTO_FECHA."</td>"
                    . "<td>".EXTRACTO_SALDO."</td>"
                    . "<td>".EXTRACTO_TASA."</td>"
                    . "<td>".EXTRACTO_UNIDAD."</td>"
                    . "<td>".EXTRACTO_RENDIMIENTO."</td>"
                    . "<td>".EXTRACTO_DEBITO."</td>"
                    . "<td>".EXTRACTO_CREDITO."</td>");
            fwrite($fp, "</tr>");
            for ($j = 8; $j <= count($data->sheets[0]['cells']); $j++) {
                $rentabilidad_diaria = 0;
                $rendimiento_diario = 0;
                $primera_rentabilidad = 0;
                $ultima_rentabilidad = 0;


                $rentabilidad_diaria = $data->sheets[0]['cells'][$j][2]/$data->sheets[0]['cells'][$j-1][2]-1;
                if($primera_rentabilidad==0)$primera_rentabilidad=$rentabilidad_diaria;
                $ultima_rentabilidad=$rentabilidad_diaria;
                $rendimiento_diario = $saldo * $rentabilidad_diaria;
                $saldo = $saldo - $data->sheets[0]['cells'][$j][3] + $data->sheets[0]['cells'][$j][4] + $rendimiento_diario; 
                $rendimiento = $rendimiento + $rendimiento_diario;
                
                fwrite($fp, "<tr>");
                fwrite($fp, "<td>".$data->sheets[0]['cells'][$j][1]."</td>".
                    "<td>".number_format($saldo,5,',','.')."</td>".
                    "<td>".number_format($rentabilidad_diaria,5,',','.')."</td>".
                    "<td>".number_format($data->sheets[0]['cells'][$j][2],5,',','.')."</td>".
                    "<td>".number_format($rendimiento_diario,5,',','.')."</td>".
                    "<td>".number_format($data->sheets[0]['cells'][$j][3],5,',','.')."</td>".
                    "<td>".number_format($data->sheets[0]['cells'][$j][4],5,',','.')."</td>");
                fwrite($fp, "</tr>");
                  
            }
        }else{//cuenta ahorros
            //carga de rangos
            $rangos = null;
            $cont_rangos = 0;
            for($j = 7; $j <= count($data->sheets[0]['cells']); $j++){
                $rangos[$cont_rangos]['base'] = $data->sheets[0]['cells'][$j][6];
                $rangos[$cont_rangos]['tope'] = $data->sheets[0]['cells'][$j][7];
                $rangos[$cont_rangos]['tasa'] = $data->sheets[0]['cells'][$j][8];
                $cont_rangos++;
            }
            
            
            fwrite($fp, "<tr>");
            fwrite($fp, "<td>".EXTRACTO_FECHA."</td>"
                    ."<td>".EXTRACTO_DEBITO."</td>"
                    . "<td>".EXTRACTO_CREDITO."</td>"
                    . "<td>".EXTRACTO_RENDIMIENTO."</td>"
                    . "<td>".EXTRACTO_SALDO."</td>"
                    . "<td>".EXTRACTO_RENDIMIENTO_CONSIGNADO."</td>"
                    . "<td>".EXTRACTO_SALDO_EXTRACTO."</td>");
            fwrite($fp, "</tr>");
            for ($j = 7; $j <= count($data->sheets[0]['cells']); $j++) {
                $rentabilidad_diaria = -1;
                $rendimiento_diario = 0;
                $primera_rentabilidad = 0;
                $ultima_rentabilidad = 0;
                foreach ($rangos as $rang){
                    if($saldo >= $rang['base'] && $saldo <= $rang['tope']){
                        $rentabilidad_diaria = $rang['tasa'];
                    }
                }
                if($rentabilidad_diaria == -1){
                    $rentabilidad_diaria = $rangos[count($rangos)-1]['tasa'];
                }
                if($primera_rentabilidad==0)$primera_rentabilidad=$rentabilidad_diaria;
                $ultima_rentabilidad=$rentabilidad_diaria;

                $rendimiento_diario = $saldo * $rentabilidad_diaria;
                $saldo = $saldo - $data->sheets[0]['cells'][$j][2] + $data->sheets[0]['cells'][$j][3] + $data->sheets[0]['cells'][$j][4]; 
                $rendimiento = $rendimiento + $rendimiento_diario;

                fwrite($fp, "<tr>");
                fwrite($fp, "<td>".$data->sheets[0]['cells'][$j][1]."</td>"
                        ."<td>".number_format($data->sheets[0]['cells'][$j][2],5,',','.')."</td>"
                        . "<td>".number_format($data->sheets[0]['cells'][$j][3],5,',','.')."</td>"
                        . "<td>".number_format($rendimiento_diario,5,',','.')."</td>"
                        . "<td>".number_format($saldo,5,',','.')."</td>"
                        . "<td>".number_format($data->sheets[0]['cells'][$j][4],5,',','.')."</td>"
                        . "<td>".number_format($saldo,5,',','.')."</td>");
                fwrite($fp, "</tr>"); 
            }
        }
        fwrite($fp, "</table>");
        fclose($fp);
        
        $this->rentabilidad = pow(($ultima_rentabilidad/$primera_rentabilidad),(365/31)-1); //$rendimiento/$saldo*100;
        $this->saldo_final = $saldo;
        $this->documento_soporte = $nombre_compuesto_soporte;
        $this->documento_movimientos = $nombre_csv;//$nombre_compuesto_movimientos;
        
        $i = $this->data->insertExtracto($this);
        if ($i == "true") {
            //-----------------------------------------------
            $cuenta = $this->cuenta;
            $mes = $this->mes;
            $anio = $this->anio;
            $dataRendimiento = new CRendimientoFinancieroData($this->data->db);
            $saldo = $dataRendimiento->getSaldoFinalByFecha($cuenta, $mes, $anio);
            $rendimiento_financiero = $saldo;
            $descuentos = 0;
            $rendimiento_consignado = $saldo - $descuentos;
            $saldo_acumulado = $dataRendimiento->getSaldoConsignadoByFecha($cuenta, $mes, $anio);
            $rendimiento_acumulado = $saldo_acumulado;
            $rentabilidad_tasa = $this->rentabilidad;
            
            $rendimiento = new CRendimientoFinanciero('',$dataRendimiento);
            $rendimiento->cuenta = $cuenta;
            $rendimiento->mes = $mes;
            $rendimiento->anio = $anio;
            $rendimiento->rendimiento_financiero = $rendimiento_financiero;
            $rendimiento->descuentos = $descuentos;
            $rendimiento->rendimiento_consignado = $rendimiento_consignado;
            $rendimiento->rendimiento_acumulado = $rendimiento_acumulado;
            $rendimiento->rentabilidad_tasa = $rentabilidad_tasa;
            
            $rendimiento->saveRendimiento(false);
            //-----------------------------------------------
            return EXTRACTO_AGREGADO;
        } else {
            return ERROR_ADD_EXTRACTO;
        }
        //die("ok");
        
    }
    
    function updateExtracto(){
        
        $tipo_cuenta = $this->data->getTipoCuenta($this->cuenta);
        
        $dirOperador = $this->data->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_EXTRACTOS_SOPORTES . "/" . $dirOperador . "/");
        $carpetas = explode("/", substr($ruta, 0, strlen($ruta) - 1));
        $ruta_destino = '';

        foreach ($carpetas as $c) {
            if (strlen($ruta_destino) > 0) {
                $ruta_destino .= "/" . $c;
            } else {
                $ruta_destino = $c;
            }
            //echo $ruta_destino."<br>";
            if (!is_dir($ruta_destino)) {
                mkdir($ruta_destino, 0777);
            } else {
                chmod($ruta_destino, 0777);
            }
        }
        
        
        $extension_soporte = explode(".", $this->documento_soporte['name']);
        $pos_soporte = count($extension_soporte) - 1;
        $valido_soporte = false;
        foreach ($this->permitidos_soporte as $p) {
            if (strcasecmp($extension_soporte[$pos_soporte], $p) == 0)
                $valido_soporte = true;
        }
        if(!$valido_soporte){
            return ERROR_DOCUMENTO_SOPORTE_NO_VALIDO;
        }
        if($this->documento_soporte['name']==NULL || $this->documento_soporte['name'] == ""){
            return ERROR_DOCUMENTO_SOPORTE_VACIO;
        }
        if ($this->documento_soporte['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_SOPORTE;
        }
        $nombre_compuesto_soporte = EXTRACTO_DOCUMENTO_SOPORTE."-".$this->cuenta.$this->anio.$this->mes.".".$extension_soporte[$pos_soporte];
        if(!move_uploaded_file($this->documento_soporte['tmp_name'], $ruta . $nombre_compuesto_soporte)){
            return ERROR_COPIAR_ARCHIVO_EXTRACTO_SOPORTE;
        }
        
              
        $extension_movimientos = explode(".", $this->documento_movimientos['name']);      
        $pos_movimientos = count($extension_movimientos) - 1;
        $valido_movimientos = false;
        foreach ($this->permitidos_movimiento as $p) {
            if (strcasecmp($extension_movimientos[$pos_movimientos], $p) == 0)
                $valido_movimientos = true;
        }
        if(!$valido_movimientos){
            return ERROR_DOCUMENTO_MOVIMIENTOS_NO_VALIDO;
        }        
        if($this->documento_movimientos['name']==NULL || $this->documento_movimientos['name'] == ""){
            return ERROR_DOCUMENTO_MOVIMIENTOS_VACIO;
        }if ($this->documento_movimientos['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_MOVIMIENTOS;
        }
        $nombre_compuesto_movimientos = EXTRACTO_DOCUMENTO_MOVIMIENTOS."-".$this->cuenta.$this->anio.$this->mes.".".$extension_movimientos[$pos_movimientos];
        if(!move_uploaded_file($this->documento_movimientos['tmp_name'], $ruta . $nombre_compuesto_movimientos)){
            return ERROR_COPIAR_ARCHIVO_EXTRACTO_MOVIMIENTOS;

        }
        
        
        $data = new Spreadsheet_Excel_Reader();

        $data->setOutputEncoding('CP1251');

        $data->read($ruta . $nombre_compuesto_movimientos);
        
        if($this->saldo_inicial == 0){
            $this->saldo_inicial = $data->sheets[0]['cells'][4][2];
        }
        
        //$tipo_cuenta

        $saldo = $this->saldo_inicial;
        $rendimiento = 0;
        
        $nombre_csv = EXTRACTO_DOCUMENTO_GENERADO."-".$this->cuenta.$this->anio.$this->mes.".xls";
        $fp = fopen($ruta.$nombre_csv,"w");
        fwrite($fp, "<table border='1'>");
        
        
        if($tipo_cuenta == 1){//cuenta colectiva
            fwrite($fp, "<tr>");
            fwrite($fp, "<td>".EXTRACTO_FECHA."</td>"
                    . "<td>".EXTRACTO_SALDO."</td>"
                    . "<td>".EXTRACTO_TASA."</td>"
                    . "<td>".EXTRACTO_UNIDAD."</td>"
                    . "<td>".EXTRACTO_RENDIMIENTO."</td>"
                    . "<td>".EXTRACTO_DEBITO."</td>"
                    . "<td>".EXTRACTO_CREDITO."</td>");
            fwrite($fp, "</tr>");
            for ($j = 8; $j <= count($data->sheets[0]['cells']); $j++) {
                $rentabilidad_diaria = 0;
                $rendimiento_diario = 0;


                $rentabilidad_diaria = $data->sheets[0]['cells'][$j][2]/$data->sheets[0]['cells'][$j-1][2]-1;
                $rendimiento_diario = $saldo * $rentabilidad_diaria;
                $saldo = $saldo - $data->sheets[0]['cells'][$j][3] + $data->sheets[0]['cells'][$j][4] + $rendimiento_diario; 
                $rendimiento = $rendimiento + $rendimiento_diario;
                
                fwrite($fp, "<tr>");
                fwrite($fp, "<td>".$data->sheets[0]['cells'][$j][1]."</td>".
                    "<td>".$saldo."</td>".
                    "<td>".$rentabilidad_diaria."</td>".
                    "<td>".$data->sheets[0]['cells'][$j][2]."</td>".
                    "<td>".$rendimiento_diario."</td>".
                    "<td>".$data->sheets[0]['cells'][$j][3]."</td>".
                    "<td>".$data->sheets[0]['cells'][$j][4]."</td>");
                fwrite($fp, "</tr>");
                  
            }
        }else{//cuenta ahorros
            //carga de rangos
            $rangos = null;
            $cont_rangos = 0;
            for($j = 7; $j <= count($data->sheets[0]['cells']); $j++){
                $rangos[$cont_rangos]['base'] = $data->sheets[0]['cells'][$j][6];
                $rangos[$cont_rangos]['tope'] = $data->sheets[0]['cells'][$j][7];
                $rangos[$cont_rangos]['tasa'] = $data->sheets[0]['cells'][$j][8];
                $cont_rangos++;
            }
            
            
            fwrite($fp, "<tr>");
            fwrite($fp, "<td>".EXTRACTO_FECHA."</td>"
                    ."<td>".EXTRACTO_DEBITO."</td>"
                    . "<td>".EXTRACTO_CREDITO."</td>"
                    . "<td>".EXTRACTO_RENDIMIENTO."</td>"
                    . "<td>".EXTRACTO_SALDO."</td>"
                    . "<td>".EXTRACTO_RENDIMIENTO_CONSIGNADO."</td>"
                    . "<td>".EXTRACTO_SALDO_EXTRACTO."</td>");
            fwrite($fp, "</tr>");
            for ($j = 7; $j <= count($data->sheets[0]['cells']); $j++) {
                $rentabilidad_diaria = -1;
                $rendimiento_diario = 0;
                foreach ($rangos as $rang){
                    if($saldo >= $rang['base'] && $saldo <= $rang['tope']){
                        $rentabilidad_diaria = $rang['tasa'];
                    }
                }
                if($rentabilidad_diaria == -1){
                    $rentabilidad_diaria = $rangos[count($rangos)-1]['tasa'];
                }

                $rendimiento_diario = $saldo * $rentabilidad_diaria;
                $saldo = $saldo - $data->sheets[0]['cells'][$j][2] + $data->sheets[0]['cells'][$j][3] + $data->sheets[0]['cells'][$j][4]; 
                $rendimiento = $rendimiento + $rendimiento_diario;

                fwrite($fp, "<tr>");
                fwrite($fp, "<td>".$data->sheets[0]['cells'][$j][1]."</td>"
                        ."<td>".$data->sheets[0]['cells'][$j][2]."</td>"
                        . "<td>".$data->sheets[0]['cells'][$j][3]."</td>"
                        . "<td>".$rendimiento_diario."</td>"
                        . "<td>".$saldo."</td>"
                        . "<td>".$data->sheets[0]['cells'][$j][4]."</td>"
                        . "<td>".$saldo."</td>");
                fwrite($fp, "</tr>"); 
            }
        }
        fwrite($fp, "</table>");
        fclose($fp);
        
        $this->rentabilidad = $rendimiento/$saldo*100;
        $this->saldo_final = $saldo;
        $this->documento_soporte = $nombre_compuesto_soporte;
        $this->documento_movimientos = $nombre_compuesto_movimientos;
        
        $i = $this->data->updateExtracto($this);
        if ($i == "true") {
            return EXTRACTO_EDITADO;
        } else {
            return ERROR_EDIT_EXTRACTO;
        }
        //die("ok");
        
    }
    
    function deleteExtracto(){
        
    }
    
    
    
}
