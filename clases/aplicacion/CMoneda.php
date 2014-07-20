<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CMoneda
 *
 * @author Personal
 */
class CMoneda {

    var $id = null;
    var $descripcion = null;
    var $ee = null;

    //definimos los atributos de la clase y creamos el constructor de la misma

    function CMoneda($id, $descripcion, $ee) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->ee = $ee;
    }

    function getId() {
        return $this->id;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    /**
     * cargarmoneda, permite cargar el objeto moneda para modificarlo y eliminarlo 
     */
    function cargarmoneda() {
        $r = $this->ee->obtenerMonedaporId($this->id);
        if ($r != -1) {
            $this->id = $r['Id_Moneda'];
            $this->descripcion = $r['Descripcion_Moneda'];
        } else {
            $this->id = '';
            $this->descripcion = '';
        }
    }

    /**
     * eliminarmoneda, elimina el objeto moneda de la base de datos
     */
    function eliminarmoneda($id) {

        $r = $this->ee->eliminarMonedas($id);

        if ($r == 1) {
            $ms1 = MENSAJE_BORRAR_EXITO_MONEDA;
        } else {
            $ms1 = MENSAJE_BORRAR_FRACASO_MONEDA;
        }
        return $ms1;
    }

    /**
     * actualizamoneda, actualiza los atributos  del objeto moneda de la base de datos
     */
    function actualizamoneda($id, $descripcion) {

        $r = $this->ee->actualizaMonedas($id, $descripcion);

        if ($r == 1) {
            $ms = MENSAJE_EDITAR_EXITO_MONEDA;
        } else {
            $ms = MENSAJE_BORRAR_FRACASO_MONEDA;
        }
        return $ms;
    }

}
