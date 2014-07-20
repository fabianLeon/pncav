<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CFamiliaData
 *
 * @author Personal
 */
class CFamiliaData {
  var $database = null;

    function CFamiliaData($db) {
        $this->database= $db;
    }
    function obtenerfamilias() {
        $sql = "SELECT Id_Familia,Descripcion_Familia from familias";
        $familias = null;
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
        
            while ($w = mysql_fetch_array($r)) {
                  for ($i = 0; $i < count($w)/2; $i++){
                  $familias[$cont][$i] = $w[$i];
                }
                 $cont++;
            }
        }
        
        return $familias;
        }
        
    
    function insertarfamilia($id,$descripcion) {
        $tabla = "familias";
        $campos = "Id_Familia,Descripcion_Familia";
        $valores = "'" . $id . "','" . $descripcion. "'";
        $r = $this->database->insertarRegistro($tabla, $campos, $valores);
        if ($r == "true") {
            return "La Familia se agrego con exito";
        } else {
            return "La Familia no se  pudo agregar";
        }
    }
     function eliminarfamilia($id) {
        $tabla = "familias";
        $predicado = "Id_Familia=" . $id;
        $e = $this->database->borrarRegistro($tabla, $predicado);
        if ($e == "true") {
            return 1;
        } else {
            return 0;
        }
    }
    function obtenerfamiliaporId($id) {
        $sql = "select * from familias where Id_Familia= " . $id;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }
    function actualizafamilia($id, $descripcion) {

        $tabla = "familias";
        $campos = array('Descripcion_Familia');
        $valores = array("'" . $descripcion ."'");

        $condicion = "Id_Familia = " . $id;
        $r = $this->database->actualizarRegistro($tabla, $campos, $valores, $condicion);
        if ($r == "true") {
            return 1;
        } else {
            return 0;
        }
    }

}