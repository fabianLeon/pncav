<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CActividades
 *
 * @author Brian Kings
 */
class CActividadPIA {
    
    var $id = null;
    var $descripcion = null;
    var $monto = null;
    var $dd = null;
    
    function CActividadPIA ($id, $dd) {
        $this->id = $id;
        $this->dd = $dd;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getMonto() {
        return $this->monto;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function setMonto($monto) {
        $this->monto = $monto;
    }
/*
 * Envia los datos necesarios para ingresar un actividadPIA
 */
    function saveActividadPIA(){
        $i = $this->dd->insertActividadPIA($this->descripcion,  $this->monto);

        if ($i == "true") {
            $r = ACTIVIDADES_AGREGADA;
        } else {
            $r = ERROR_ADD_ACTIVIDADES;
        }
        return $r;
    }
    /*
     * Envia la orden de eliminar la actividadPIA con el id que se referencia
     */
    function deletActividadPIA() {
        $r = $this->dd->deleteActividadPIA($this->id);
        if ($r == 'true') {
            $msg = ACTIVIDAD_BORRADO;
        } else {
            $msg = ERROR_DE_ACTIVIDADES;
        }
        return $msg;
    }
    /*
     * Solicita los datos de una actividad en especifico a través de una función,
     * y los almacena en las variables locales
     */
    function loadActividadPIA() {

        $r = $this->dd->getActividadPIAById($this->id);

        if ($r != -1) {
            $this->descripcion = $r['act_descripcion'];
            $this->monto = $r['act_monto'];
        } else {
            $this->descripcion = '';
            $this->monto = '';
        }
    }
    /*
     * Envia los datos necesarios para actualizar los datos de una actividadPIA
     */
    function saveEditActividadPIA() {
        $i = $this->dd->updateActividadPIA($this->id, $this->descripcion, $this->monto);
        if ($i == 'true') {
            $msg = ACTIVIDADES_EDITADO;
        } else {
            $msg = ERROR_DE_ACTIVIDADES_EDIT;
        }
        return $msg;
    }
}
