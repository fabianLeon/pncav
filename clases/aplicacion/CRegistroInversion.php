<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CRegistroInventario
 *
 * @author Brian Kings
 */
class CRegistroInversion {

    var $actividad = null;
    var $fecha = null;
    var $proveedor = null;
    var $numero_documento = null;
    var $valor = null;
    var $observaciones = null;
    var $documento_soporte = null;
    var $permitidos = array('pdf', 'doc', 'xls', 'ppt', 'docx',
        'xlsx', 'gif', 'jpg', 'png', 'tif', 'zip', 'rar');
    var $dd = null;

    function CRegistroInversion($id, $dd) {
        $this->id = $id;
        $this->dd = $dd;
    }

    public function getActividad() {
        return $this->actividad;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getProveedor() {
        return $this->proveedor;
    }

    public function getNumero_documento() {
        return $this->numero_documento;
    }

    public function getValor() {
        return $this->valor;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function getDocumento_soporte() {
        return $this->documento_soporte;
    }

    public function setActividad($actividad) {
        $this->actividad = $actividad;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setProveedor($proveedor) {
        $this->proveedor = $proveedor;
    }

    public function setNumero_documento($numero_documento) {
        $this->numero_documento = $numero_documento;
    }

    public function setValor($valor) {
        $this->valor = $valor;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    public function setDocumento_soporte($documento_soporte) {
        $this->documento_soporte = $documento_soporte;
    }
    /*
     * Copiamos el documento soporte a la ruta correspondiente y enviamos los campos 
     * necesarios para almacenar un Registro de Inversion
     */
    function saveRegistroInversion($archivo) {

        $r = "";
        $extension = explode(".", $archivo['name']);
        $num = count($extension) - 1;
        $noMatch = 0;
        foreach ($this->permitidos as $p) {
            if (strcasecmp($extension[$num], $p) == 0)
                $noMatch = 1;
        }
        if ($archivo['name'] != null) {
            if ($noMatch == 1) {
                if ($archivo['size'] < MAX_SIZE_DOCUMENTOS) {

                    $nombre_compuesto = strtoupper("Factura-" . $this->numero_documento);
                    $ruta = (RUTA_DOCUMENTOS . "/Interventoria/Registro Inversion/");

                    $carpetas = explode("/", substr($ruta, 0, strlen($ruta) - 1));
                    $cad = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF'];
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
                    $nombre_compuesto = $nombre_compuesto . "." . $extension[$num];
                    //if (!move_uploaded_file($archivo['tmp_name'], $ruta . $archivo['name'])) {
                    if (!move_uploaded_file($archivo['tmp_name'], $ruta . $nombre_compuesto)) {
                        $r = ERROR_COPIAR_ARCHIVO;
                    } else {

                        //$this->archivo = $archivo['name'];
                        $this->documento_soporte = $nombre_compuesto;

                        //old
                        $i = $this->dd->insertRegistroInversion($this->actividad, $this->fecha, $this->proveedor, $this->numero_documento, $this->valor, $this->observaciones, $this->documento_soporte);

                        if ($i == "true") {
                            $r = REGISTRO_INVERSION_AGREGADA;
                        } else {
                            $r = ERROR_ADD_REGISTRO_INVERSION;
                        }
                    }
                } else {
                    $r = ERROR_SIZE_ARCHIVO;
                }
            } else {
                $r = ERROR_FORMATO_ARCHIVO;
            }
        } else {
            $r = ERROR_CONFIGURACION_RUTA;
        }
        return $r;
    }

    /*
     * Envia los datos de la clase inventario actividades para ser eliminados de la base de datos. 
     */

    function deletRegistroInversion($archivo) {
        $ruta = (RUTA_DOCUMENTOS . "/Interventoria/Registro Inversion/");
        $r = $this->dd->deleteRegistroInversion($this->id);
        if ($r == 'true') {
            unlink(strtolower($ruta) . $archivo);
            $msg = REGISTRO_INVERSION_BORRADO;
        } else {
            $msg = ERROR_DE_REGISTRO_INVERSION;
        }
        return $msg;
    }

    function loadRegistroInversion() {

        $r = $this->dd->getRegistroInversionById($this->id);

        if ($r != -1) {
            $this->actividad = $r['act_id'];
            $this->fecha = $r['rin_fecha'];
            $this->proveedor = $r['id_prove'];
            $this->numero_documento = $r['rin_numero_documento'];
            $this->valor = $r['rin_valor'];
            $this->observaciones = $r['rin_observaciones'];
            $this->documento_soporte = $r['rin_documento_soporte'];
        } else {
            $this->actividad = '';
            $this->fecha = '';
            $this->proveedor = '';
            $this->numero_documento = '';
            $this->valor = '';
            $this->observaciones = '';
            $this->documento_soporte = '';
        }
    }

    function saveEditRegistroInversion($archivo, $archivo_anterior) {
        $r = "";

        $extension = explode(".", $archivo['name']);
        $num = count($extension) - 1;

        $noMatch = 0;
        foreach ($this->permitidos as $p) {
            if (strcasecmp($extension[$num], $p) == 0)
                $noMatch = 1;
        }

        if ($archivo['name'] != null) {
            if ($noMatch == 1) {
                if ($archivo['size'] < MAX_SIZE_DOCUMENTOS) {

                    $nombre_compuesto = strtoupper("Factura-" . $this->numero_documento );
                    $ruta = (RUTA_DOCUMENTOS . "/Interventoria/Registro Inversion/");
                    unlink(strtolower($ruta) . $archivo_anterior);
                    $carpetas = explode("/", substr($ruta, 0, strlen($ruta) - 1));
                    $cad = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF'];
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
                    $nombre_compuesto = $nombre_compuesto . "." . $extension[$num];
                    //if (!move_uploaded_file($archivo['tmp_name'], $ruta . $archivo['name'])) {
                    if (!move_uploaded_file($archivo['tmp_name'], $ruta . $nombre_compuesto)) {
                        $r = ERROR_COPIAR_ARCHIVO;
                    } else {

                        //$this->archivo = $archivo['name'];
                        $this->documento_soporte = $nombre_compuesto;

                        //old
                        $i = $this->dd->updateRegistroInversion($this->id,$this->actividad, $this->fecha, $this->proveedor, $this->numero_documento, $this->valor, $this->observaciones, $this->documento_soporte);

                        if ($i == "true") {
                            $r = REGISTRO_INVERSION_EDITADO;
                        } else {
                            $r = ERROR_EDIT_REGISTRO_INVERSION;
                        }
                    }
                } else {
                    $r = ERROR_SIZE_ARCHIVO;
                }
            } else {
                $r = ERROR_FORMATO_ARCHIVO;
            }
            return $r;
        } else {
            $i = $this->dd->updateRegistroInversion($this->id, $this->actividad, $this->fecha, $this->proveedor, $this->numero_documento, $this->valor, $this->observaciones, $this->documento_soporte);
            if ($i == 'true') {
                $msg = REGISTRO_INVERSION_EDITADO;
            } else {
                $msg = ERROR_DE_REGISTRO_INVERSION_EDIT;
            }
            return $msg;
        }
    }

}
