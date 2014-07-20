<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CInformeFinanciero
 *
 * @author Brian Kings
 */
class CInformeFinanciero {

    var $id = null;
    var $numero_factura = null;
    var $fecha_factura = null;
    var $numero_radicado_ministerio = null;
    var $documento_soporte = null;
    var $descripcion = null;
    var $valor_factura = null;
    var $amortizacion = null;
    var $observaciones = null;
    //variables calculadas por  el sistema
    var $saldo_pendiente_AA = null;
    var $saldo_contrato = null;
    
    
    var $permitidos = array('pdf', 'doc', 'xls', 'ppt', 'docx',
        'xlsx', 'gif', 'jpg', 'png', 'tif', 'zip', 'rar');
    var $dd = null;

    function CInformeFinanciero($id, $dd) {
        $this->id = $id;
        $this->dd = $dd;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getNumero_factura() {
        return $this->numero_factura;
    }

    public function getFecha_factura() {
        return $this->fecha_factura;
    }

    public function getNumero_radicado_ministerio() {
        return $this->numero_radicado_ministerio;
    }

    public function getDocumento_soporte() {
        return $this->documento_soporte;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getValor_factura() {
        return $this->valor_factura;
    }

    public function getAmortizacion() {
        return $this->amortizacion;
    }

    public function getObservaciones() {
        return $this->observaciones;
    }

    public function setNumero_factura($numero_factura) {
        $this->numero_factura = $numero_factura;
    }

    public function setFecha_factura($fecha_factura) {
        $this->fecha_factura = $fecha_factura;
    }

    public function setNumero_radicado_ministerio($numero_radicado_ministerio) {
        $this->numero_radicado_ministerio = $numero_radicado_ministerio;
    }

    public function setDocumento_soporte($documento_soporte) {
        $this->documento_soporte = $documento_soporte;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setValor_factura($valor_factura) {
        $this->valor_factura = $valor_factura;
    }

    public function setAmortizacion($amortizacion) {
        $this->amortizacion = $amortizacion;
    }

    public function setObservaciones($observaciones) {
        $this->observaciones = $observaciones;
    }

    public function getSaldo_pendiente_AA() {
        return $this->saldo_pendiente_AA;
    }

    public function getSaldo_contrato() {
        return $this->saldo_contrato;
    }

    public function setSaldo_pendiente_AA($saldo_pendiente_AA) {
        $this->saldo_pendiente_AA = $saldo_pendiente_AA;
    }

    public function setSaldo_contrato($saldo_contrato) {
        $this->saldo_contrato = $saldo_contrato;
    }

    /*
     * Copiamos el documento soporte a la ruta correspondiente y enviamos los campos 
     * necesarios para almacenar un Informe Financiero
     */

    function saveInformeFinanciero($archivo) {
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

                    $nombre_compuesto = strtoupper("Factura-" . $this->numero_factura);
                    $ruta = (RUTA_DOCUMENTOS . "/Interventoria/Informe Financiero/");

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
                        $this->documento_soporte = $nombre_compuesto;
                        $i = $this->dd->insertInformeFinanciero($this->numero_factura, $this->fecha_factura, $this->numero_radicado_ministerio, $this->documento_soporte, $this->descripcion, $this->valor_factura, $this->amortizacion, $this->observaciones);

                        if ($i == "true") {
                            $r = INFORME_FINANCIERO_ADD;
                        } else {
                            $r = ERROR_ADD_INFORME_FINANCIERO;
                        }
                    }
                } else {
                    $r = ERROR_SIZE_INFORME_FINANCIERO;
                }
            } else {
                $r = ERROR_FORMATO_INFORME_FINANCIERO;
            }
        } else {
            $r = ERROR_CONFIGURACION_RUTA;
        }
        return $r;
    }

    /*
     * Envia EL ID  de la clase INFORME_FINANCIERO para ser eliminados de la base de datos. 
     * ademas de eliminar el documento soporte
     */

    function deletInformeFinanciero($archivo) {
        $ruta = (RUTA_DOCUMENTOS . "/Interventoria/Informe Financiero/");
        $r = $this->dd->deleteInformeFinanciero($this->id);
        if ($r == 'true') {
            unlink(strtolower($ruta) . $archivo);
            $msg = INFORME_FINANCIERO_BORRADO;
        } else {
            $msg = ERROR_DE_INFORME_FINANCIERO;
        }
        return $msg;
    }

    /*
     * Obtiene los datos de un INFORME_FINANCIERO especifico a través del Id
     */

    function loadInformeFinanciero() {

        $r = $this->dd->getInformeFinancieroById($this->id);

        if ($r != -1) {
            $this->numero_factura = $r['ifi_numero_factura'];
            $this->fecha_factura = $r['ifi_fecha_factura'];
            $this->numero_radicado_ministerio = $r['ifi_numero_radicado_ministerio'];
            $this->documento_soporte = $r['ifi_documento_soporte'];
            $this->descripcion = $r['ifi_descripcion'];
            $this->valor_factura = $r['ifi_valor_factura'];
            $this->amortizacion = $r['ifi_amortizacion'];
            $this->saldo_pendiente_AA = $r['ifi_saldo_pendiente_AA'];
            $this->observaciones = $r['ifi_observaciones'];
            $this->saldo_contrato = $r['ifi_saldo_contrato'];
        } else {
            $this->numero_factura = '';
            $this->fecha_factura = '';
            $this->numero_radicado_ministerio = '';
            $this->documento_soporte = '';
            $this->descripcion = '';
            $this->valor_factura = '';
            $this->amortizacion = '';
            $this->saldo_pendiente_AA = '';
            $this->observaciones = '';
            $this->saldo_contrato = '';
        }
    }
    /*
     * Editar un INFORME_FINANCIERO, revisa si se cambio el documento soporte, en caso afirmativo elimina el anterior 
     * y almacena el nuevo, además de actualizar todos los demás datos que se cambiaron.
     */
    function saveEditInformeFinanciero($archivo, $archivo_anterior) {
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

                    $nombre_compuesto = strtoupper("Factura-". $this->numero_factura);
                    $ruta = (RUTA_DOCUMENTOS . "/Interventoria/Informe Financiero/");
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
                        if (!is_dir($ruta_destino)) {
                            mkdir($ruta_destino, 0777);
                        } else {
                            chmod($ruta_destino, 0777);
                        }
                    }
                    $nombre_compuesto = $nombre_compuesto . "." . $extension[$num];
                    if (!move_uploaded_file($archivo['tmp_name'], $ruta . $nombre_compuesto)) {
                        $r = ERROR_COPIAR_ARCHIVO;
                    } else {
                        $this->documento_soporte = $nombre_compuesto;
                        $i = $this->dd->updateInformeFinanciero($this->id, $this->numero_factura, $this->fecha_factura, $this->numero_radicado_ministerio, $this->documento_soporte, $this->descripcion, $this->valor_factura, $this->amortizacion, $this->observaciones);

                        if ($i == "true") {
                            $r = INFORME_FINANCIERO_EDIT;
                        } else {
                            $r = ERROR_EDIT_INFORME_FINANCIERO;
                        }
                    }
                } else {
                    $r = ERROR_SIZE_INFORME_FINANCIERO;
                }
            } else {
                $r = ERROR_FORMATO_INFORME_FINANCIERO;
            }
            return $r;
        } else {
            $i = $this->dd->updateInformeFinanciero($this->id, $this->numero_factura, $this->fecha_factura, $this->numero_radicado_ministerio, $this->documento_soporte, $this->descripcion, $this->valor_factura, $this->amortizacion, $this->observaciones);
            if ($i == 'true') {
                $msg = INFORME_FINANCIERO_EDIT;
            } else {
                $msg = ERROR_EDIT_INFORME_FINANCIERO;
            }
            return $msg;
        }
    }

}
