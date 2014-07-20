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
 * Clase Opcion
 *
 * @package  clases
 * @subpackage aplicacion
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
class COpcion {

    var $id = null;
    var $nombre = null;
    var $variable = null;
    var $url = null;
    var $nivel = null;
    var $padre = null;
    var $orden = null;
    var $layout = null;
    var $operador = null;
    var $dopc = null;

    /**
     * * Constructor de la clase COpcionData
     * */
    function COpcion($do) {
        $this->dopc = $do;
    }

    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getVariable() {
        return $this->variable;
    }

    function getUrl() {
        return $this->url;
    }

    function getNivel() {
        return $this->nivel;
    }

    function getPadre() {
        return $this->padre;
    }

    function getOrden() {
        return $this->orden;
    }

    function getLayout() {
        return $this->layout;
    }

    function getOperador() {
        return $this->operador;
    }

    /**
     * * establece las variables de la clase Opcion
     * */
    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setVariable($variable) {
        $this->variable = $variable;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setNivel($nivel) {
        $this->nivel = $nivel;
    }

    function setPadre($padre) {
        $this->padre = $padre;
    }

    function setOrden($orden) {
        $this->orden = $orden;
    }

    function setLayout($layout) {
        $this->layout = $layuot;
    }

    function setOperador($operador) {
        $this->operador = $operador;
    }

    /**
     * * carga los valores de un objeto OPCION por su id para ser editados
     * */
    function loadOpcion() {
        $r = $this->dopc->getOpcionById($this->id);
        if ($r != -1) {
            $this->nombre = $r["nombre"];
            $this->variable = $r["variable"];
            $this->url = $r["url"];
            $this->nivel = $r["nivel"];
            $this->padre = $r["padre"];
            $this->orden = $r["orden"];
            $this->layout = $r["layout"];
            $this->operador = $r["operador"];
        } else {
            $this->nombre = "";
            $this->variable = "";
            $this->url = "";
            $this->nivel = "";
            $this->padre = "";
            $this->orden = "";
            $this->layout = "";
            $this->operador = "";
        }
    }

    /**
     * * carga los valores de un objeto OPCION por su id para ser visualizados
     * */
    function loadSeeOpcion() {
        $r = $this->dopc->getSeeOpcionById($this->id);
        if ($r != -1) {
            $this->nombre = $r["nombre"];
            $this->variable = $r["variable"];
            $this->url = $r["url"];
            $this->nivel = $r["nivel"];
            $this->padre = $r["padre"];
            $this->orden = $r["orden"];
            $this->layout = $r["layout"];
            $this->operador = $r["operador"];
        } else {
            $this->nombre = "";
            $this->variable = "";
            $this->url = "";
            $this->nivel = "";
            $this->padre = "";
            $this->orden = "";
            $this->layout = "";
            $this->operador = "";
        }
    }

    /**
     * * almacena un objeto OPCION y retorna un mensaje del resultado del proceso
     * */
    function saveNewOpcion($operador) {
        echo $operador;
        $cont = 0;
        $cont = $cont + $this->dopc->getContadorOpcionesByNombre($this->getNombre(), '-1', $operador);
        $cont = $cont + $this->dopc->getContadorOpcionesByVariable($this->getVariable(), '-1', $operador);
        $cont = $cont + $this->dopc->getContadorOpcionesByUrl($this->getUrl(), '-1', $operador);
        $cont = $cont + $this->dopc->getContadorOpcionesByOrden($this->getOrden(), '-1', $operador);

        if ($cont == 0) {
            $r = $this->dopc->insertOpcion($this->nombre, $this->variable, $this->url, $this->nivel, $this->padre, $this->orden, $this->layout, $this->operador);
            if ($r == 'true') {
                $msg = OPCION_AGREGADO;
            } else {
                $msg = ERROR_ADD_OPCION;
            }
        } else {
            $msg = ERROR_ADD_OPCION;
        }
        return $msg;
    }

    /**
     * * elimina un objeto OPCION y retorna un mensaje del resultado del proceso
     * */
    function deleteOpcion() {
        $r = $this->dopc->deleteOpcionPerfiles($this->id);
        $r = $this->dopc->deleteOpcion($this->id);
        if ($r == 'true') {
            $msg = OPCION_BORRADO;
        } else {
            $msg = ERROR_DEL_OPCION;
        }

        return $msg;
    }

    /**
     * * actualiza un objeto OPCION y retorna un mensaje del resultado del proceso
     * */
    function saveEditOpcion($operador) {
        $cont = 0;
        $cont = $cont + $this->dopc->getContadorOpcionesByNombre($this->getNombre(), $this->getId(), $operador);
        $cont = $cont + $this->dopc->getContadorOpcionesByVariable($this->getVariable(), $this->getId(), $operador);
        $cont = $cont + $this->dopc->getContadorOpcionesByUrl($this->getUrl(), $this->getId(), $operador);
        $cont = $cont + $this->dopc->getContadorOpcionesByOrden($this->getOrden(), $this->getId(), $operador);
        if ($cont == 0) {
            $r = $this->dopc->updateOpcion($this->id, $this->nombre, $this->variable, $this->url, $this->nivel, $this->padre, $this->orden, $this->layout, $this->getOperador());
            if ($r == 'true') {
                $msg = OPCION_EDITADO;
            } else {
                $msg = ERROR_EDIT_OPCION;
            }
        } else {
            $msg = ERROR_EDIT_OPCION;
        }
        return $msg;
    }

    /**
     * carga los nombre de los archivos de un directorio dado, listo para ser utilizado en el combo de opciones
     */
    function getFiles($dir, $extension) {
        $archivos = null;
        $handle = opendir($dir);
        $cont = 0;
        while ($file = readdir($handle)) {
            if ($file != "." && $file != "..") {
                $ext = substr($file, strlen($file) - 3, 3);
                if ($ext == $extension) {
                    $archivos[$cont]["id"] = $file;
                    $archivos[$cont]["nombre"] = substr($file, 0, strlen($file) - 4);
                    $archivos[$cont++]["tipo"] = $ext;
                }
            }
        }
        return $archivos;
    }

}

?>