<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CIngresos
 *
 * @author Personal
 */
class CIngresos {

    //put your codevar $id = null;
    var $id = null;
    var $ano = null;
    var $monto = null;
    var $tipo = null;
    var $database = null;

//definimos los atributos de la clase y creamos el constructor de la misma

    function CIngresos($id, $ano, $monto, $tipo, $database) {
        $this->id = $id;
        $this->ano = $ano;
        $this->monto = $monto;
        $this->tipo = $tipo;
        $this->database = $database;
    }

    function getIdIngreso() {
        return $this->id;
    }

    function getano() {
        return $this->ano;
    }

    function getmonto() {
        return $this->monto;
    }

    function gettipo() {
        return $this->tipo;
    }

    /**
     * Cargaringreso, permite cargar el objeto ingreso para modificarlo y eliminarlo 
     */
    function Cargaringreso() {
        $r = $this->database->obteneringresoporid($this->id);
        if ($r != -1) {
            $this->id = $r['Id_Ingreso'];
            $this->ano = $r['A_Ingreso'];
            $this->monto = $r['Monto_Ingreso'];
            $this->tipo = $r['Tipo_Ingreso'];
        } else {
            $this->id = '';
            $this->ano = '';
            $this->monto = '';
            $this->tipo = '';
        }
    }

    /**
     * EliminarIngreso, elimina el objeto ingreso de la base de datos
     */
    function EliminarIngreso($id) {

        $r = $this->database->eliminaringresos($id);

        if ($r == 1) {
            $ms1 = MENSAJE_BORRAR_EXITO_INGRESO;
        } else {
            $ms1 = MENSAJE_BORRAR_INGRESO_FRACASO;
        }
        return $ms1;
    }

    /**
     * actualizarIngresos, actualiza los atributos  del objeto ingreso de la base de datos
     */
    function actualizarIngresos($id, $monto) {

        $r = $this->database->actualizaringreso($id, $monto);

        if ($r == 1) {
            $ms = MENSAJE_EDITAR_EXITO_INGRESO;
        } else {
            $ms = MENSAJE_BORRAR_FRACASO_INGRESO;
        }
        return $ms;
    }

    //valida que el año que se este ingresando sea una vigencia o una adicion
    function validarano($ano) {
        $r = $this->database->obteneranos($ano);
        return $r;
    }
    //me permite validad si una vigencia tiene adiciones o no
    function validarelimavigencia($year) {
        $r=$this->database->Obtenertipodeingreso($year);
        return $r;
        
    }

}
