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
class CRendimientoFinanciero {
    
    var $id;
    var $cuenta;
    var $cuenta_nombre;
    var $cuenta_numero;
    var $mes;
    var $anio;
    var $rendimiento_financiero;
    var $descuentos;
    var $rendimiento_consignado;
    var $rendimiento_acumulado;
    var $rentabilidad_tasa;
    var $fecha_consignacion;
    var $comprobante_consignacion;
    var $comprobante_emision;
    var $valor_fiduciaria;
    var $estado;
    var $estado_nombre;
    var $observaciones;
    
    
    var $data;
    
    var $permitidos_soporte = array('pdf');
    
    
    function __construct($id,$data) {
        $this->id = $id;
        $this->data = $data;
    }
    
    function loadRendimiento(){
        $r = $this->data->getRendimientoById($this->id);
        if($r){
            $this->cuenta = $r['cuenta'];
            $this->cuenta_nombre = $r['cuenta_nombre'];
            $this->cuenta_numero = $r['cuenta_numero'];
            $this->mes = $r['mes'];
            $this->anio = $r['anio'];
            $this->rendimiento_financiero = $r['rendimiento_financiero'];
            $this->descuentos = $r['descuentos'];
            $this->rendimiento_consignado = $r['rendimiento_consignado'];
            $this->rendimiento_acumulado = $r['rendimiento_acumulado'];
            $this->rentabilidad_tasa = $r['rentabilidad_tasa'];
            $this->fecha_consignacion = $r['fecha_consignacion'];
            $this->comprobante_consignacion = $r['comprobante_consignacion'];
            $this->comprobante_emision = $r['comprobante_emision'];
            $this->valor_fiduciaria = $r['valor_fiduciaria'];
            $this->estado = $r['estado'];
            $this->estado_nombre = $r['estado_nombre'];
            $this->observaciones = $r['observaciones'];
        }
    }
    
    function saveRendimiento($con_archivos=true){
        if($con_archivos){
            $extension_consignacion = explode(".", $this->comprobante_consignacion['name']);
            $extension_emision = explode(".", $this->comprobante_emision['name']);

            $pos_consignacion = count($extension_consignacion) - 1;
            $pos_emision = count($extension_emision) - 1;

            $valido_consignacion = false;
            $valido_emision = false;

            foreach ($this->permitidos_soporte as $p) {
                if (strcasecmp($extension_consignacion[$pos_consignacion], $p) == 0)
                    $valido_consignacion = true;
            }

            foreach ($this->permitidos_soporte as $p) {
                if (strcasecmp($extension_emision[$pos_emision], $p) == 0)
                    $valido_emision = true;
            }

            if(!$valido_consignacion){
                return ERROR_DOCUMENTO_CONSIGNACION_NO_VALIDO;
            }

            if(!$valido_emision){
                return ERROR_DOCUMENTO_EMISION_NO_VALIDO;
            }

            if($this->comprobante_consignacion['name']==NULL || $this->comprobante_consignacion['name'] == ""){
                return ERROR_DOCUMENTO_CONSIGNACION_VACIO;
            }

            if($this->comprobante_emision['name']==NULL || $this->comprobante_emision['name'] == ""){
                return ERROR_DOCUMENTO_EMISION_VACIO;
            }

            if ($this->comprobante_consignacion['size'] > MAX_SIZE_DOCUMENTOS) {
                return ERROR_TAM_ARCHIVO_CONSIGNACION;
            }

            if ($this->comprobante_emision['size'] > MAX_SIZE_DOCUMENTOS) {
                return ERROR_TAM_ARCHIVO_EMISION;
            }

            $dirOperador = $this->data->getDirectorioOperador(OPERADOR_DEFECTO);
            $ruta = (RUTA_RENDIMIENTOS_SOPORTES . "/" . $dirOperador . "/");

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

            $nombre_compuesto_consignacion = RENDIMIENTOS_DOCUMENTO_CONSIGNACION."-".$this->cuenta.$this->anio.$this->mes.".".$extension_consignacion[$pos_consignacion];
            if(!move_uploaded_file($this->comprobante_consignacion['tmp_name'], $ruta . $nombre_compuesto_consignacion)){
                return ERROR_COPIAR_ARCHIVO_RENDIMIENTOS_CONSIGNACION;
            }

            $nombre_compuesto_emision = RENDIMIENTOS_DOCUMENTO_EMISION."-".$this->cuenta.$this->anio.$this->mes.".".$extension_emision[$pos_emision];
            if(!move_uploaded_file($this->comprobante_emision['tmp_name'], $ruta . $nombre_compuesto_emision)){
                return ERROR_COPIAR_ARCHIVO_RENDIMIENTOS_EMISION;

            }
            $this->comprobante_consignacion = $nombre_compuesto_consignacion;
            $this->comprobante_emision = $nombre_compuesto_emision;
        }
        
        
        
        
        $i = $this->data->insertRendimiento($this);
        if ($i == "true") {
            return RENDIMIENTOS_AGREGADO;
        } else {
            return ERROR_ADD_RENDIMIENTOS;
        }
        //die("ok");
        
    }
    
    function updateRendimiento(){
        
        $dirOperador = $this->data->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_RENDIMIENTOS_SOPORTES . "/" . $dirOperador . "/");
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
        
        
        $extension_consignacion = explode(".", $this->comprobante_consignacion['name']);
        $pos_consignacion = count($extension_consignacion) - 1;
        $valido_consignacion = false;
        foreach ($this->permitidos_soporte as $p) {
            if (strcasecmp($extension_consignacion[$pos_consignacion], $p) == 0)
                $valido_consignacion = true;
        }
        if(!$valido_consignacion){
            return ERROR_DOCUMENTO_CONSIGNACION_NO_VALIDO;
        }
        if($this->comprobante_consignacion['name']==NULL || $this->comprobante_consignacion['name'] == ""){
            return ERROR_DOCUMENTO_CONSIGNACION_VACIO;
        }
        if ($this->comprobante_consignacion['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_CONSIGNACION;
        }
        $nombre_compuesto_consignacion = RENDIMIENTOS_DOCUMENTO_CONSIGNACION."-".$this->cuenta.$this->anio.$this->mes.".".$extension_consignacion[$pos_consignacion];
        if(!move_uploaded_file($this->comprobante_consignacion['tmp_name'], $ruta . $nombre_compuesto_consignacion)){
            return ERROR_COPIAR_ARCHIVO_RENDIMIENTOS_CONSIGNACION;
        }
        
              
        $extension_emision = explode(".", $this->comprobante_emision['name']);      
        $pos_emision = count($extension_emision) - 1;
        $valido_emision = false;
        foreach ($this->permitidos_soporte as $p) {
            if (strcasecmp($extension_emision[$pos_emision], $p) == 0)
                $valido_emision = true;
        }
        if(!$valido_emision){
            return ERROR_DOCUMENTO_EMISION_NO_VALIDO;
        }        
        if($this->comprobante_emision['name']==NULL || $this->comprobante_emision['name'] == ""){
            return ERROR_DOCUMENTO_EMISION_VACIO;
        }if ($this->comprobante_emision['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_EMISION;
        }
        $nombre_compuesto_emision = RENDIMIENTOS_DOCUMENTO_EMISION."-".$this->cuenta.$this->anio.$this->mes.".".$extension_emision[$pos_emision];
        if(!move_uploaded_file($this->comprobante_emision['tmp_name'], $ruta . $nombre_compuesto_emision)){
            return ERROR_COPIAR_ARCHIVO_RENDIMIENTOS_EMISION;

        }
        
        $this->comprobante_consignacion = $nombre_compuesto_consignacion;
        $this->comprobante_emision = $nombre_compuesto_emision;
                
        $i = $this->data->updateRendimiento($this);
        if ($i == "true") {
            return RENDIMIENTOS_EDITADO;
        } else {
            return ERROR_EDIT_RENDIMIENTOS;
        }
        //die("ok");
        
    }
}
