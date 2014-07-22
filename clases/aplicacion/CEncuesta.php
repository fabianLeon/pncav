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
            unlink(strtolower((RUTA_DOCUMENTOS . "/EJECUCION/" . $this->getConsecutivo() . "/")) . $this->documento_soporte);
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
                unlink(strtolower((RUTA_DOCUMENTOS . "/EJECUCION/" . $this->getConsecutivo() . "/")) . $archivo_anterior);
            }
            if ($noMatch == 1) {
                if ($archivo['size'] < MAX_SIZE_DOCUMENTOS) {
                    $ruta = (RUTA_DOCUMENTOS . "/EJECUCION/" . $this->getConsecutivo() . "/");
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
                    if (!move_uploaded_file($archivo['tmp_name'], ($ruta) . $archivo['name'])) {
                        $r = ERROR_COPIAR_ARCHIVO;
                    } else {
                        $this->documento_soporte = ($archivo['name']);

                        $i = $this->dd->updateEjecucion($this->id, $this->documento_soporte, $this->fecha, $this->cc, $this->mci, $this->rf, $this->vi, $this->ri, $this->mei, $this->usuario, $this->estado);
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
            $r = $this->dd->updateEjecucion($this->id, $archivo_anterior, $this->fecha, $this->cc, $this->mci, $this->rf, $this->vi, $this->ri, $this->mei, $this->usuario);
            if ($r == 'true') {
                $msg = DOCUMENTO_EDITADO;
            } else {
                $msg = ERROR_EDIT_DOCUMENTO;
            }
            return $msg;
        }
    }

    /*
     * Guardar respuestas de una encuesta
     */

    function saveRespuestasEncuesta($arreglo) {
        $this->dd->eliminarRespuestas($this->getId());
        $valores = $valores . "'" . $this->getId() . "','" . $arreglo[0]['id'] . "','" . $arreglo[0]['respuesta'] . "'),";
        for ($i = 1; $i < (count($arreglo) - 1); $i++) {
            $valores = $valores . "('" . $this->getId() . "','" . $arreglo[$i]['id'] . "','" . $arreglo[$i]['respuesta'] . "'),";
        }
        $valores = $valores . "('" . $this->getId() . "','" . $arreglo[(count($arreglo) - 1)]['id'] . "','" . $arreglo[(count($arreglo) - 1)]['respuesta'] . "'";
        $r = $this->dd->setSaveRespuestasEncuesta($valores);
    }

    /*
     * Convierte el formato de la fecha 01/02/2014 a Y-m-d
     */

    function obtenerFechaFormato($fechaC) {
        $fecha = explode('/', $fechaC);
        return $fecha[2] . '-' . $fecha[1] . '-' . $fecha[0];
    }

    /*
     * Almacenar Region, departamento y municipio por defecto
     */

    function saveRDM() {
        $tipo_encuesta = 0;
        $tipo_encuesta = $this->dd->getTipoEncuesta($this->getId());
        $arreglo=  $this->dd->getRDMByEncuestaId($this->getId());
        
        if ($tipo_encuesta == 1) {
            $valores = $valores . "'" . $this->getId() . "','" . '3' . "','" . $arreglo[0]['region'] . "'),";
            $valores = $valores . "('" . $this->getId() . "','" . '4' . "','" . $arreglo[0]['departamento'] . "'),";
            $valores = $valores . "('" . $this->getId() . "','" . '5' . "','" . $arreglo[0]['municipio'] . "'";
        } else if ($tipo_encuesta == 2) {
            $valores = $valores . "'" . $this->getId() . "','" . '161' . "','" . $arreglo[0]['region'] . "'),";
            $valores = $valores . "('" . $this->getId() . "','" . '162' . "','" . $arreglo[0]['departamento'] . "'),";
            $valores = $valores . "('" . $this->getId() . "','" . '163' . "','" . $arreglo[0]['municipio'] . "'";
        }
        $r = $this->dd->setSaveRespuestasEncuesta($valores);
    }

    /*
     * Importar encuestas
     */

    function cargaMasiva($file_carga) {
        require_once './clases/Excel/reader.php';
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('CP1251');
        $data->read($file_carga['tmp_name']);
        error_reporting(E_ALL ^ E_NOTICE);
        $filas = $data->sheets[0]['numRows'];
        //obtener la cantidad de preguntas
        $cantidadPreguntas = $this->dd->cantidadPreByConsecutivoEncuesta($data->sheets[0]['cells'][1][3]);
        //if ($cantidadPreguntas == ($filas - 1)) {
        //desplazamiento entre columnas
        for ($i = 3; $i <= $columnas; $i++) {
            //Pertenece al tipo de encuesta dada la cantidad de filas
            $tipoEncuesta = $this->dd->tipoEncuestaByConsecutivoEncuesta($data->sheets[0]['cells'][1][$i]);
            $this->setId($this->dd->getEncuestaIdByConsecutivo($data->sheets[0]['cells'][1][$i]));
            //desplazamiento entre filas
            $secciones = $this->dd->getSecciones($tipoEncuesta);
            $cont = 0;
            echo $data->sheets[0]['cells'][15][3];
            foreach ($secciones as $s) {
                $preguntas_base = $this->dd->getPreguntasBaseBySeccion($s['id']);
                foreach ($preguntas_base as $pb) {
                    $repuestas[$cont]['id'] = null;
                    $repuestas[$cont]['respuesta'] = null;
                    switch ($pb['tipo']) {
                        case 1:
                            $resp = null;
                            $resp = $data->sheets[0]['cells'][$cont + 2][$i];
                            $repuestas[$cont]['id'] = $pb['id'];
                            if ($resp == 'Si') {
                                $repuestas[$cont]['respuesta'] = '1';
                            } else {
                                $repuestas[$cont]['respuesta'] = '';
                            }
                            break;
                        //selección
                        case 2:
                            $contRespuestasMxM = null;
                            $contRespuestasMxM = $this->dd->getOpcionesPreguntas($pb['id']);
                            $temp = 0;
                            $repuestas[$cont]['id'] = $pb['id'];
                            while ($temp < count($contRespuestasMxM)) {
                                if ($contRespuestasMxM[$temp]['nombre'] == $data->sheets[0]['cells'][$cont + 2][$i]) {
                                    //guardar respuestas seleccionadas
                                    $repuestas[$cont]['respuesta'] = ($contRespuestasMxM[$temp]['id']);
                                }
                                $temp++;
                            }
                            break;
                        //seleccion multiple
                        case 3:
                            $contRespuestasMxM = null;
                            $resp = null;
                            $resp = explode("+", ($data->sheets[0]['cells'][$cont + 2][$i]));
                            $contRespuestasMxM = $this->dd->getOpcionesPreguntas($pb['id']);
                            $temp = 0;
                            $respuesta = null;
                            while ($temp < (count($contRespuestasMxM))) {
                                $tempRespuesta = null;
                                for ($m = 0; $m < count($resp); $m++) {
                                    if (($temp + 1) == $resp[$m]) {
                                        //guardar respuestas seleccionadas
                                        $tempRespuesta = $contRespuestasMxM[$temp]['id'];
                                    }
                                }
                                $respuesta = $respuesta . $tempRespuesta . '/';
                                $temp++;
                            }
                            $repuestas[$cont]['id'] = $pb['id'];
                            $repuestas[$cont]['respuesta'] = $respuesta;
                            break;
                        case 7:
                            $repuestas[$cont]['id'] = $pb['id'];
                            $repuestas[$cont]['respuesta'] = $this->obtenerFechaFormato($data->sheets[0]['cells'][$cont + 2][$i]); //Se inicia en la tercera columna
                            break;
                        default :
                            $repuestas[$cont]['id'] = $pb['id'];
                            $repuestas[$cont]['respuesta'] = $data->sheets[0]['cells'][$cont + 2][$i]; //Se inicia en la tercera columna
                            break;
                    }
                    $cont++;
                }
            }
            $this->saveRespuestasEncuesta($repuestas);
        }
        //}
        return 'Carga Exitosa';
    }

}
