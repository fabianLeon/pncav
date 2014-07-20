<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CActividad
 *
 * @author Personal
 */
class CActividad {

    var $id_actividad = null;
    var $desp_actividad = null;
    var $monto_actividad = null;
    var $id_tipo = null;
    var $database = null;

//definimos los atributos de la clase y creamos el constructor de la misma
    function CActividad($id_actividad, $desp_actividad, $monto_actividad, $id_tipo, $base) {
        $this->id_actividad = $id_actividad;
        $this->desp_actividad = $desp_actividad;
        $this->monto_actividad = $monto_actividad;
        $this->id_tipo = $id_tipo;
        $this->database = $base;
    }

    public function getId_actividad() {
        return $this->id_actividad;
    }

    public function getDesp_actividad() {
        return $this->desp_actividad;
    }

    public function getMonto_actividad() {
        return $this->monto_actividad;
    }

    public function getId_tipo() {
        return $this->id_tipo;
    }

    /**
     * CargarActivida, permite cargar el objeto activida para modificarlo y eliminarlo
     *      */
    function CargarActividad() {

        $r = $this->database->ObtenerActividadporID($this->id_actividad);
        if ($r) {

            $this->id_actividad = $r['Id_Actividad'];
            $this->desp_actividad = $r['Descripcion_Actividad'];
            $this->monto_actividad = $r['Monto_Actividad'];
            $this->id_tipo = $r['Id_Tipo'];
        } else {

            $this->id_actividad = '';
            $this->desp_actividad = '';
            $this->monto_actividad = '';
            $this->id_tipo = '';
        }
    }

    /**
     * EliminarActividad, elimina el objeto actividad de la base de datos
     */
    function EliminarActividad($id) {

        $r = $this->database->eliminaractiv($id);

        if ($r == 1) {
            $ms1 = MENSAJE_BORRAR_EXITO_ACTIVIDAD;
        } else {
            $ms1 = MENSAJE_BORRAR_FRACASO_ACTIVIDAD;
        }
        return $ms1;
    }

    /**
     * actualizarActividad, actualiza los atributos  del objeto actividad en 
     * la base de datos
     */
    function actualizarActividad($id, $descripcion, $monto, $tipo) {

        $r = $this->database->actualizaActivi($id, $descripcion, $monto, $tipo);

        if ($r == 1) {
            $ms = MENSAJE_EDITAR_EXITO_ACTIVIDAD;
        } else {
            $ms = MENSAJE_EDITAR_FRACASO_ACTIVIDAD;
        }
        return $ms;
    }

}
