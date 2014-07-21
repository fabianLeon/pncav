<?php

/**
 * 
 *
 * <ul>
 * <li> Redcom Ltda <www.redcom.com.co></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */

/**
 * Clase Documento
 *
 * @package  clases
 * @subpackage aplicacion
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
Class CDocumento {

    var $id = null;
    var $tipo = null;
    var $tema = null;
    var $subtema = null;
    var $fecha = null;
    var $descripcion = null;
    var $archivo = null;
    var $version = null;
    var $estado = null;
    var $operador = null;
    var $dd = null;
    var $permitidos = array('pdf', 'doc', 'xls', 'ppt', 'docx', 
        'xlsx', 'gif', 'jpg', 'png', 'tif', 'zip', 'rar');

    /**
     * * Constructor de la clase CDocumentoData
     * */
    function CDocumento($id, $dd) {
        $this->id = $id;
        $this->dd = $dd;
    }
    
    function setId($val) {
        $this->id = $val;
    }

    function setTipo($val) {
        $this->tipo = $val;
    }

    function setTema($val) {
        $this->tema = $val;
    }

    function setSubtema($val) {
        $this->subtema = $val;
    }

    function setFecha($val) {
        $this->fecha = $val;
    }

    function setDescripcion($val) {
        $this->descripcion = $val;
    }

    function setArchivo($val) {
        $this->archivo = $val;
    }

    function setVersion($val) {
        $this->version = $val;
    }

    function setEstado($val) {
        $this->estado=$val;
    }

    function setOperador($val) {
        $this->operador = $val;
    }

    function getId() {
        return $this->id;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getTema() {
        return $this->tema;
    }

    function getSubtema() {
        return $this->subtema;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getArchivo() {
        return $this->archivo;
    }

    function getVersion() {
        return $this->version;
    }

    function getEstado() {
        return $this->estado;
    }

    function getOperador() {
        return $this->operador;
    }

    /**
     * * carga los valores de un objeto DOCUMENTO por su id para ser editados
     * */
    function loadDocumento() {

        $r = $this->dd->getDocumentoById($this->id);

        if ($r != -1) {
            $this->tipo = $r['dti_id'];
            $this->tema = $r['dot_id'];
            $this->subtema = $r['dos_id'];
            $this->fecha = $r['doc_fecha'];
            $this->descripcion = $r['doc_descripcion'];
            $this->archivo = $r['doc_archivo'];
            $this->version = $r['doc_version'];
            $this->estado = $r['doe_id'];
            $this->operador = $r['ope_id'];
        } else {
            $this->tipo = "";
            $this->tema = "";
            $this->subtema = "";
            $this->fecha = "";
            $this->descripcion = "";
            $this->archivo = "";
            $this->version = "";
            $this->estado = "";
            $this->operador = "";
        }
    }

    /**
     * * almacena un objeto DOCUMENTO y retorna un mensaje del resultado del proceso
     * */
    function saveNewDocumento($archivo) {

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
                    $tipo = $this->dd->getTipoNombreById($this->tipo);
                    $tema = $this->dd->getTemaNombreById($this->tema);
                    $subtema = $this->dd->getSubtemaNombreById($this->subtema);
                    $nombre_compuesto = strtoupper($tipo."-".$tema."-".$subtema."-");
                    //$version = $this->dd->getCountByName($nombre_compuesto)+1;
                    //$cont_archivos = ($version);
                    //while(strlen($cont_archivos)<LONG_NUMERADOR){
                        //$cont_archivos = "0".$cont_archivos;
                    //}
                    //$nombre_compuesto = $nombre_compuesto.$cont_archivos;
                    $dirOperador = $this->dd->getDirectorioOperador($this->operador);

                    $ruta = (RUTA_DOCUMENTOS . "/" . $dirOperador . $tipo . "/" . $tema . "/");

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
                    //$nombre_compuesto = $nombre_compuesto.".".$extension[$num];
                    if (!move_uploaded_file($archivo['tmp_name'], $ruta . $archivo['name'])) {
                    //if (!move_uploaded_file($archivo['tmp_name'], $ruta . $nombre_compuesto)) {
                        $r = ERROR_COPIAR_ARCHIVO;
                    } else {

                        $this->archivo = $archivo['name'];
                        //$this->archivo = $nombre_compuesto;
                        //$this->version = $version;
                        $i = $this->dd->insertDocumento($this->tipo, $this->tema, $this->subtema, $this->fecha, $this->descripcion, $this->archivo, $this->version, $this->estado, $this->operador);
                        if ($i == "true") {
                            $r = DOCUMENTO_AGREGADO;
                        } else {
                            $r = ERROR_ADD_DOCUMENTO;
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

    /**
     * * elimina un objeto DOCUMENTO y retorna un mensaje del resultado del proceso
     * */
    function deleteDocumento($archivo) {
        $tipo = $this->dd->getTipoNombreById($this->tipo);
        $tema = $this->dd->getTemaNombreById($this->tema);
        $subtema = $this->dd->getSubtemaNombreById($this->subtema);
        $dirOperador = $this->dd->getDirectorioOperador($this->operador);
        $ruta = RUTA_DOCUMENTOS . "/" . $dirOperador . $tipo . "/" . $tema . "/";
        chmod($ruta, 0777);
        $r = $this->dd->deleteDocumento($this->id);
        if ($r == 'true') {
            unlink(strtolower($ruta) . $archivo);
            $msg = DOCUMENTO_BORRADO;
        } else {
            $msg = ERROR_DEL_DOCUMENTO;
        }
        return $msg;
    }

    /**
     * * actualiza un objeto DOCUMENTO y retorna un mensaje del resultado del proceso
     * */
    function saveEditDocumento($archivo, $archivo_anterior) {

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
                    
                    $tipo = $this->dd->getTipoNombreById($this->tipo);
                    $tema = $this->dd->getTemaNombreById($this->tema);
                    $subtema = $this->dd->getSubtemaNombreById($this->subtema);
                    //$nombre_compuesto = strtoupper($tipo."-".$tema."-".$subtema."-");
                    //$version = $this->dd->getCountByName($nombre_compuesto)+1;
                    //$cont_archivos = ($version);
                    while(strlen($cont_archivos)<LONG_NUMERADOR){
                        $cont_archivos = "0".$cont_archivos;
                    }
                    //$nombre_compuesto = $nombre_compuesto.$cont_archivos;
                    $dirOperador = $this->dd->getDirectorioOperador($this->operador);

                    $ruta = (RUTA_DOCUMENTOS . "/" . $dirOperador . $tipo . "/" . $tema . "/");
                    
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
                    //$nombre_compuesto = $nombre_compuesto.".".$extension[$num];
                    unlink(strtolower($ruta) . $archivo_anterior);
                    //die($archivo['name']);
                    if (!move_uploaded_file($archivo['tmp_name'], $ruta . $archivo['name'])) {
                        $r = ERROR_COPIAR_ARCHIVO;
                    } else {
                        $this->archivo = $archivo['name'];
                        //$this->version = $version;
                        $i = $this->dd->updateDocumentoArchivo($this->id, $this->tipo, $this->tema, $this->subtema, $this->fecha, $this->descripcion, $this->version, $this->archivo, $this->estado);
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
            $r = $this->dd->updateDocumento($this->id, $this->tipo, $this->tema, $this->subtema, $this->fecha, $this->descripcion, $this->version, $this->estado);
            if ($r == 'true') {
                $msg = DOCUMENTO_EDITADO;
            } else {
                $msg = ERROR_EDIT_DOCUMENTO;
            }
            return $msg;
        }
    }

}

?>