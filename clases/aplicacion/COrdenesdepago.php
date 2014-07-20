<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ordenesdepago
 *
 * @author Personal
 */
class COrdenesdepago {

    var $Id_ordenedepago = null;
    var $tipodeactividad_ordenedepago = null;
    var $actividad_ordenedepago = null;
    var $numero_ordenedepago = null;
    var $fecha_ordenedepago = null;
    var $numerofactura_ordenedepago = null;
    var $proveedor_ordenedepago = null;
    var $moneda_ordenedepago = null;
    var $tasa_ordenedepago = null;
    var $valortotal_ordenedepago = null;
    var $estado_ordenedepago = null;
    var $fechapago_ordenedepago = null;
    var $observaciones = null;
    var $archivo = null;
    var $cuenta_cobro = null;
    var $database = null;
    var $permitidos = array('pdf', 'doc', 'xls', 'ppt', 'docx',
        'xlsx', 'gif', 'jpg', 'png', 'tif', 'zip', 'rar');

    //definimos los atributos de la clase y creamos el constructor de la misma

    function COrdenesdepago($id, $tipoactividad, $actividad, $numerodeorden
    , $fecha, $numerofactura, $proveedor,$moneda, $tasa, $valortotal, $estado, 
            $fechapago, $observaciones, $cuenta_cobro, $archivo, $database) {

        $this->Id_ordenedepago = $id;
        $this->tipodeactividad_ordenedepago = $tipoactividad;
        $this->actividad_ordenedepago = $actividad;
        $this->numero_ordenedepago = $numerodeorden;
        $this->fecha_ordenedepago = $fecha;
        $this->numerofactura_ordenedepago = $numerofactura;
        $this->proveedor_ordenedepago = $proveedor;
        $this->moneda_ordenedepago = $moneda;
        $this->tasa_ordenedepago = $tasa;
        $this->valortotal_ordenedepago = $valortotal;
        $this->estado_ordenedepago = $estado;
        $this->fechapago_ordenedepago = $fechapago;
        $this->observaciones = $observaciones;
        $this->cuenta_cobro = $cuenta_cobro;
        $this->archivo = $archivo;
        $this->database = $database;
    }

    public function getId_ordenedepago() {
        return $this->Id_ordenedepago;
    }

    public function getTipodeactividad_ordenedepago() {
        return $this->tipodeactividad_ordenedepago;
    }

    public function getActividad_ordenedepago() {
        return $this->actividad_ordenedepago;
    }

   
    public function getNumero_ordenedepago() {
        return $this->numero_ordenedepago;
    }

    public function getFecha_ordenedepago() {
        return $this->fecha_ordenedepago;
    }

    public function getNumerofactura_ordenedepago() {
        return $this->numerofactura_ordenedepago;
    }

    public function getProveedor_ordenedepago() {
        return $this->proveedor_ordenedepago;
    }

    public function getMoneda_ordenedepago() {
        return $this->moneda_ordenedepago;
    }

    public function getTasa_ordenedepago() {
        return $this->tasa_ordenedepago;
    }

    public function getValortotal_ordenedepago() {
        return $this->valortotal_ordenedepago;
    }

    public function getEstado_ordenedepago() {
        return $this->estado_ordenedepago;
    }

    public function getFechapago_ordenedepago() {
        return $this->fechapago_ordenedepago;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function getCuenta_cobro() {
        return $this->cuenta_cobro;
    }

        public function getArchivo_Orden() {
        return $this->archivo;
    }
    

    /**
     * cargarordendepago, permite cargar el objeto orden de pago para modificarlo y eliminarlo 
     */
    function cargarordendepago() {
        $r = $this->database->obtenerOrdenporId($this->Id_ordenedepago);
        if ($r != -1) {
            $this->Id_ordenedepago = $r['Id_Orden_Pago'];
            $this->tipodeactividad_ordenedepago = $r['Id_Tipo_Actividad'];
            $this->actividad_ordenedepago = $r['Id_Actividad'];
            $this->numero_ordenedepago = $r['Numero_Orden_Pago'];
            $this->fecha_ordenedepago = $r['Fecha_Orden_Pago'];
            $this->numerofactura_ordenedepago = $r['Numero_Factura'];
            $this->proveedor_ordenedepago = $r['Id_Proveedor'];
            $this->moneda_ordenedepago = $r['Id_Moneda_Orden'];
            $this->tasa_ordenedepago = $r['Tasa_Orden'];
            $this->valortotal_ordenedepago = $r['valor_total'];
            $this->estado_ordenedepago = $r['Id_Estado_Orden'];
            $this->fechapago_ordenedepago = $r['Fecha_Pago_Orden'];
            $this->cuenta_cobro = $r['cobro_proveedor_reintegro'];
            $this->observaciones = $r['Observaciones_Orden'];
            $this->archivo = $r['Archivo_Orden'];
        } else {
            $this->Id_ordenedepago = '';
            $this->tipodeactividad_ordenedepago = '';
            $this->actividad_ordenedepago = '';
            $this->numero_ordenedepago = '';
            $this->fecha_ordenedepago = '';
            $this->numerofactura_ordenedepago = '';
            $this->proveedor_ordenedepago = '';
            $this->moneda_ordenedepago = '';
            $this->tasa_ordenedepago = '';
            $this->valortotal_ordenedepago = '';
            $this->estado_ordenedepago = '';
            $this->fechapago_ordenedepago = '';
            $this->observaciones = '';
            $this->cuenta_cobro = '';
            $this->archivo = '';
        }
    }

    /**
     * GuardarOrden, se encarga de configurar la ruta donde se adjuntara el 
     * archivo, e insertara en la base de datos el objeto orden de pago 
     */
    
    function GuardarOrden() {
        
       
        if ($this->archivo['name'] != NULL || $this->archivo['name'] != "") {
        $extension_comunicado = explode(".", $this->archivo['name']);
        $pos_comunicado = count($extension_comunicado) - 1;
        $valido_archivo = false;
        foreach ($this->permitidos as $p) {
            if (strcasecmp($extension_comunicado[$pos_comunicado], $p) == 0)
                $valido_archivo = true;
        }
        if (!$valido_archivo) {
            return ERROR_ORDEN_NO_VALIDO;
        }

        if ($this->archivo['name'] == NULL || $this->archivo['name'] == "") {
            return ERROR_ORDEN_VACIA;
        }      

        if ($this->archivo['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_COMUNICADO;
        }

        $dirOperadorutilidades = $this->database->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_ORDENESDEPAGO_SOPORTES . "/" . $dirOperadorutilidades . "/");

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

        $nombre_compuesto_comunicado = ORDEN_DEPAGO_SOPORTE . "(" . $this->fecha_ordenedepago . ")" .$this->archivo['name'];
        if (!move_uploaded_file($this->archivo['tmp_name'], $ruta . $nombre_compuesto_comunicado)) {
            return ERROR_COPIAR_ARCHIVO_ORDEN_SOPORTE;
        }
      if ($this->cuenta_cobro != null) {
                if($this->cuenta_cobro=='null'||$this->cuenta_cobro==''){
                    $temp = 'null';
                }else{
                    $temp = "'" . $this->cuenta_cobro . "'";
                }
            } else {
                $temp = 'null';
            }
       $sindocumento = $this->database->insertarOrdendePago($this->Id_ordenedepago, 
               $this->tipodeactividad_ordenedepago, $this->actividad_ordenedepago, $this->numero_ordenedepago,
               $this->fecha_ordenedepago, $this->numerofactura_ordenedepago, $this->proveedor_ordenedepago, 
               $this->moneda_ordenedepago, $this->tasa_ordenedepago, $this->valortotal_ordenedepago,
               $this->estado_ordenedepago, $this->fechapago_ordenedepago, $this->observaciones,$temp,  $this->archivo['name']);
            if ($sindocumento == "true") {
                $r = ORDEN_DE_PAGO_AGREGADA_EXITO;
            } else {
                $r = ORDEN_DE_PAGO_AGREGADA_FRACASO;
            }
        return $r;
        }
        
        else{
            if ($this->cuenta_cobro != null) {
                if($this->cuenta_cobro=='null'||$this->cuenta_cobro==''){
                    $temp = 'null';
                }else{
                    $temp = "'" . $this->cuenta_cobro . "'";
                }
            } else {
                $temp = 'null';
            }
             $sindocumento = $this->database->insertarOrdendePago($this->Id_ordenedepago, 
               $this->tipodeactividad_ordenedepago, $this->actividad_ordenedepago, $this->numero_ordenedepago,
               $this->fecha_ordenedepago, $this->numerofactura_ordenedepago, $this->proveedor_ordenedepago, 
               $this->moneda_ordenedepago, $this->tasa_ordenedepago, $this->valortotal_ordenedepago,
               $this->estado_ordenedepago, $this->fechapago_ordenedepago, $this->observaciones, $temp,  $this->archivo['name']);
            if ($sindocumento == "true") {
                $r = ORDEN_DE_PAGO_AGREGADA_EXITO_DOCUMENTO;
            } else {
                $r = ORDEN_DE_PAGO_AGREGADA_FRACASO;
            }
            return $r;
        }
        
    }
  

    /**
     * deleteOrden, se encarga de configurar la ruta del archivo del  
     * objeto que se va a eliminar, y a su vez lo elimina de la base 
     * de datos 
     */
    function deleteOrden($id, $archivo,$fecha) {
        $dirOperadorutilidades = $this->database->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_ORDENESDEPAGO_SOPORTES . "/" . $dirOperadorutilidades . "/");
        $nombre_compuesto_comunicado = ORDEN_DEPAGO_SOPORTE . "(" . $fecha . ")" .$archivo;
        $r = $this->database->borrarorden($id);
        if ($r == 'true') {
             unlink(strtolower($ruta) . $nombre_compuesto_comunicado);
            $msg = ORDEN_BORRADA;
        } else {
            $msg = ERROR_DEL_BORRADO_ORDEN;
        }
        return $msg;
    }
    
     /**
     * guardarEdicionOrden, se encarga de configurar la ruta del archivo del  
     * objeto que se va a editar, y a su vez lo actualizara en la base 
     * de datos 
     */

    function guardarEdicionOrden($archivo_anterior,$fecha_anterior) {
       
        if ($this->archivo['name'] != NULL || $this->archivo['name'] != "") {
        $extension_comunicado = explode(".", $this->archivo['name']);
        $pos_comunicado = count($extension_comunicado) - 1;
        $valido_archivo = false;
        foreach ($this->permitidos as $p) {
            if (strcasecmp($extension_comunicado[$pos_comunicado], $p) == 0)
                $valido_archivo = true;
        }
        if (!$valido_archivo) {
            return ERROR_ORDEN_NO_VALIDO;
        }

        if ($this->archivo['name'] == NULL || $this->archivo['name'] == "") {
            return ERROR_ORDEN_VACIA;
        }      

        if ($this->archivo['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_COMUNICADO;
        }

        $dirOperadorutilidades = $this->database->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_ORDENESDEPAGO_SOPORTES . "/" . $dirOperadorutilidades . "/");

        $nombre_compuesto_comunicado_anterior=ORDEN_DEPAGO_SOPORTE . "(" . $fecha_anterior . ")" .$archivo_anterior;
        unlink(strtolower($ruta) . $nombre_compuesto_comunicado_anterior);
        $nombre_compuesto_comunicado = ORDEN_DEPAGO_SOPORTE . "(" . $this->fecha_ordenedepago . ")" .$this->archivo['name'];
        if (!move_uploaded_file($this->archivo['tmp_name'], $ruta . $nombre_compuesto_comunicado)) {
            return ERROR_COPIAR_ARCHIVO_ORDEN_SOPORTE;
        }
      if ($this->cuenta_cobro != null) {
                if($this->cuenta_cobro=='null'||$this->cuenta_cobro==''){
                    $temp = 'null';
                }else{
                    $temp = "'" . $this->cuenta_cobro . "'";
                }
            } else {
                $temp = 'null';
            }
       $sindocumento = $this->database->ActualizarOrdendePago($this->Id_ordenedepago,  $this->tipodeactividad_ordenedepago,
       $this->actividad_ordenedepago,  $this->numero_ordenedepago, $this->fecha_ordenedepago, $this->numerofactura_ordenedepago,
       $this->proveedor_ordenedepago,  $this->moneda_ordenedepago, $this->tasa_ordenedepago,  $this->valortotal_ordenedepago,
       $this->estado_ordenedepago, $this->fechapago_ordenedepago,  $this->observaciones, $temp,  $this->archivo['name']);
            if ($sindocumento == 1) {
                $r = ORDEN_DE_PAGO_EDITADA_EXITO;
            } else {
                $r = ORDEN_DE_PAGO_EDITADA_FRACASO;
            }
        return $r;
        }
        
        else{
            if ($this->cuenta_cobro != null) {
                if($this->cuenta_cobro=='null'||$this->cuenta_cobro==''){
                    $temp = 'null';
                }else{
                    $temp = "'" . $this->cuenta_cobro . "'";
                }
            } else {
                $temp = 'null';
            }
            $sindocumento = $this->database->ActualizarOrdendePago($this->Id_ordenedepago,  $this->tipodeactividad_ordenedepago,
       $this->actividad_ordenedepago,  $this->numero_ordenedepago, $this->fecha_ordenedepago, $this->numerofactura_ordenedepago,
       $this->proveedor_ordenedepago,  $this->moneda_ordenedepago, $this->tasa_ordenedepago,  $this->valortotal_ordenedepago,
       $this->estado_ordenedepago, $this->fechapago_ordenedepago,  $this->observaciones, $temp,  $archivo_anterior);
            if ($sindocumento == 1) {
                $r = ORDEN_DE_PAGO_EDITADA_EXITO_SIN_DOCUMENTO;
            } else {
                $r = ORDEN_DE_PAGO_EDITADA_FRACASO;
            }
                    return $r;

        }

}
}
