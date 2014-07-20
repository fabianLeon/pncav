<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CEncuesta
 *
 * @author Brian Kings
 */
class CEncuesta {

    //put your code here
    var $id = null;
    var $consecutivo = null;
    var $pla_id = null;
    var $documento_soporte = null;
    var $fecha = null;
    var $cc = null;
    var $mci = null;
    var $rf = null;
    var $vi = null;
    var $ri = null;
    var $mei = null;
    var $usuario = null;
    var $estado = null;
    var $dd = null;
    var $permitidos = array('pdf');

    public function getId() {
        return $this->id;
    }

    public function getConsecutivo() {
        return $this->consecutivo;
    }

    public function getPla_id() {
        return $this->pla_id;
    }

    public function getDocumento_soporte() {
        return $this->documento_soporte;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getCc() {
        return $this->cc;
    }

    public function getMci() {
        return $this->mci;
    }

    public function getRf() {
        return $this->rf;
    }

    public function getVi() {
        return $this->vi;
    }

    public function getRi() {
        return $this->ri;
    }

    public function getMei() {
        return $this->mei;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setConsecutivo($consecutivo) {
        $this->consecutivo = $consecutivo;
    }

    public function setPla_id($pla_id) {
        $this->pla_id = $pla_id;
    }

    public function setDocumento_soporte($documento_soporte) {
        $this->documento_soporte = $documento_soporte;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    public function setCc($cc) {
        $this->cc = $cc;
    }

    public function setMci($mci) {
        $this->mci = $mci;
    }

    public function setRf($rf) {
        $this->rf = $rf;
    }

    public function setVi($vi) {
        $this->vi = $vi;
    }

    public function setRi($ri) {
        $this->ri = $ri;
    }

    public function setMei($mei) {
        $this->mei = $mei;
    }

    public function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    function CEncuesta($id, $dd) {
        $this->id = $id;
        $this->dd = $dd;
    }

    function deletEncuesta() {

        $r = $this->dd->deleteEncuesta($this->id);
        if ($r == 'true') {
            unlink(strtolower((RUTA_DOCUMENTOS . "/EJECUCION/" . $this->pla_id . "/")) . $this->documento_soporte);
            $msg = EJECUCION_BORRADO;
        } else {
            $msg = ERROR_DE_EJECUCION;
        }
        return $msg;
    }

    function deletEncuestaRespuestas() {
        $r = $this->dd->eliminarRespuestas($this->id);
        if ($r == TRUE) {
            $msg = EJECUCION_BORRADO;
        } else {
            $msg = ERROR_DE_EJECUCION;
        }
        return $msg;
    }

    /*
     * Almacena los datos de una encuesta en especifico en la clase
     */

    function loadEncuesta() {
        $r = $this->dd->getEncuestaById($this->id);

        if ($r != -1) {
            $this->consecutivo = $r['enc_consecutivo'];
            //$this->codigo_eje = $r['pla_codigo_eje'];
            $this->documento_soporte = $r['enc_documento_soporte'];
            $this->fecha = $r['enc_fecha'];
            $this->cc = $r['ecc_id'];
            $this->mci = $r['enc_motivo_cuestionario_incorrecto'];
            $this->rf = $r['erf_id'];
            $this->vi = $r['evi_id'];
            $this->ri = $r['eri_id'];
            $this->mei = $r['enc_motivo_encuesta_incorrecta'];
            $this->usuario = $r['usu_id'];
            $this->estado = $r['ees_id'];
        } else {
            $this->consecutivo = '';
            //$this->codigo_eje = '';
            $this->documento_soporte = '';
            $this->fecha = '';
            $this->cc = '';
            $this->mci = '';
            $this->rf = '';
            $this->vi = '';
            $this->ri = '';
            $this->mei = '';
            $this->usuario = '';
            $this->estado = '';
        }
    }

    /*
     * Guarda los datos de una encuesta, sea por primera vez.
     */

    function saveEditEncuesta($archivo, $archivo_anterior, $pla_id) {
        $r = "";

        $extension = explode(".", $archivo['name']);
        $num = count($extension) - 1;

        $noMatch = 0;
        foreach ($this->permitidos as $p) {
            if (strcasecmp($extension[$num], $p) == 0)
                $noMatch = 1;
        }
        if ($archivo['name'] != null) {
            if ($archivo_anterior != NULL) {
                unlink(strtolower((RUTA_DOCUMENTOS . "/EJECUCION/" . $this->pla_id . "/")) . $archivo_anterior);
            }
            if ($noMatch == 1) {
                if ($archivo['size'] < MAX_SIZE_DOCUMENTOS) {
                    //$nombre_compuesto = strtoupper("Factura-" . $cosecutivo_encuesta);

                    $ruta = (RUTA_DOCUMENTOS . "/EJECUCION/" . $pla_id . "/");

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
                    //$nombre_compuesto = $nombre_compuesto . "." . $extension[$num];

                    if (!move_uploaded_file($archivo['tmp_name'], ($ruta) .$archivo['name'])) {
                        $r = ERROR_COPIAR_ARCHIVO;
                    } else {
                        $this->documento_soporte = ($archivo['name']);
                        
                        $i = $this->dd->updateEjecucion($this->id, $this->documento_soporte,  $this->fecha,  $this->cc,
                                $this->mci,  $this->rf,  $this->vi,  $this->ri,  $this->mei,  $this->usuario,  $this->estado);
                        if ($i == "true") {
                            $r = DOCUMENTO_EDITADO;
                        } else {
                            $r = ERROR_EDIT_DOCUMENTO;
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
            $r = $this->dd->updateEjecucion($this->id,  $archivo_anterior,  $this->fecha,  $this->cc,
                                $this->mci,  $this->rf,  $this->vi,  $this->ri,  $this->mei,  $this->usuario);
            if ($r == 'true') {
                $msg = DOCUMENTO_EDITADO;
            } else {
                $msg = ERROR_EDIT_DOCUMENTO;
            }
            return $msg;
        }
    }

    function saveRespuestasEncuesta($arreglo) {
        $this->dd->eliminarRespuestas($this->id);
        $valores = $valores . "'" . $this->id . "','" . $arreglo[0]['id'] . "','" . $arreglo[0]['respuesta'] . "'),";
        for ($i = 1; $i < (count($arreglo) - 1); $i++) {
            $valores = $valores . "('" . $this->id . "','" . $arreglo[$i]['id'] . "','" . $arreglo[$i]['respuesta'] . "'),";
        }
        $valores = $valores . "('" . $this->id . "','" . $arreglo[(count($arreglo) - 1)]['id'] . "','" . $arreglo[(count($arreglo) - 1)]['respuesta'] . "'";
        $r = $this->dd->setSaveRespuestasEncuesta($valores);
    }

}
