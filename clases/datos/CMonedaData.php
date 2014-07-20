<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CMonedaData
 *
 * @author Personal
 */
class CMonedaData { 
    var $database = null;

    function CMonedaData($db) {
        $this->database= $db;
    }
    function obtenerMonedas() {
        $sql = "SELECT Id_Moneda,Descripcion_Moneda from monedas";
        $monedas = null;
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
        
            while ($w = mysql_fetch_array($r)) {
                  for ($i = 0; $i < count($w)/2; $i++){
                  $monedas[$cont][$i] = $w[$i];
                }
                 $cont++;
            }
        }
        
        return $monedas;
        }
        
    
    function insertarMoneda($id,$descripcion) {
        $tabla = "monedas";
        $campos = "Id_Moneda,Descripcion_Moneda";
        $valores = "'" . $id . "','" . $descripcion. "'";
        $r = $this->database->insertarRegistro($tabla, $campos, $valores);
        if ($r == "true") {
            return "La Moneda se agrego con exito";
        } else {
            return "La Moneda no se  pudo agregar";
        }
    }
     function eliminarMonedas($id) {
        $tabla = "monedas";
        $predicado = "Id_Moneda=" . $id;
        $e = $this->database->borrarRegistro($tabla, $predicado);
        if ($e == "true") {
            return 1;
        } else {
            return 0;
        }
    }
    function obtenerMonedaporId($id) {
        $sql = "select * from monedas where Id_Moneda= " . $id;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }
    function actualizaMonedas($id, $descripcion) {

        $tabla = "monedas";
        $campos = array('Descripcion_Moneda');
        $valores = array("'" . $descripcion ."'");

        $condicion = "Id_Moneda = " . $id;
        $r = $this->database->actualizarRegistro($tabla, $campos, $valores, $condicion);
        if ($r == "true") {
            return 1;
        } else {
            return 0;
        }
    }

}