<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CActividadData
 *
 * @author Personal
 */
class CActividadData {

    var $database = null;

    function CActividadData($database) {
        $this->database = $database;
    }

    function ObtenerActividadporID($id_actividad) {
        $sql = "select * from actividades where Id_Actividad=" . $id_actividad;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    function  ObtenerActividades($criterio) {
        if($criterio>0){
        $sql = "SELECT Id_Actividad, Descripcion_Actividad, Monto_Actividad, Descripcion_Tipo
                FROM actividades
                JOIN actividades_tipo ON actividades.Id_Tipo = actividades_tipo.Id_Tipo
        WHERE actividades.Id_Tipo =" . $criterio;}
        else{
            $sql = "SELECT Id_Actividad, Descripcion_Actividad, Monto_Actividad,Descripcion_Tipo
                FROM actividades
                JOIN actividades_tipo ON actividades.Id_Tipo = actividades_tipo.Id_Tipo";
        }
 
        $actividades = null;
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $actividades[$contador]['id'] = $w['Id_Actividad'];
                $actividades[$contador]['descripcion'] = $w['Descripcion_Actividad'];
                $actividades[$contador]['monto'] = $w['Monto_Actividad'];
                $actividades[$contador]['descripciotipo'] = $w['Descripcion_Tipo'];
                $contador++;
            }
        }

        return $actividades;
    }

   function ObtenerTipos($orden) {
        $tipos = null;
        $sql = "select * from actividades_tipo order by " . $orden;
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $tipos[$contador]['id'] = $w['Id_Tipo'];
                $tipos[$contador]['nombre'] = $w['Descripcion_Tipo'];
                $contador++;
            }
        }
        return $tipos;
    }

    function insertaractividad($id, $descripcion, $monto, $tipo) {
        $tabla = "actividades";
        $campos = "Id_Actividad,Descripcion_Actividad,Monto_Actividad,Id_Tipo";
        $valores = "'" . $id . "','" . $descripcion . "','" . $monto . "','" . $tipo . "'";
        $r = $this->database->insertarRegistro($tabla, $campos, $valores);
        if ($r == "true") {
            return MENSAJE_AGREGAR_EXITO_ACTIVIDAD;
        } else {
            return MENSAJE_AGREGAR_FRACASO_ACTIVIDAD;
        }
    }

    function eliminaractiv($id) {
        $tabla = "actividades";
        $predicado = "Id_Actividad=" . $id;
        $e = $this->database->borrarRegistro($tabla, $predicado);
        if ($e == "true") {
            return 1;
        } else {
            return 0;
        }
    }

    function actualizaActivi($id, $descripcion, $monto, $tipo) {

        $tabla = "actividades";
        $campos = array('Descripcion_Actividad', 'Monto_Actividad', 'Id_Tipo');
        $valores = array("'" . $descripcion . "'", "'" . $monto . "'", "'" . $tipo . "'");

        $condicion = "Id_Actividad  = " . $id;
        $r = $this->database->actualizarRegistro($tabla, $campos, $valores, $condicion);
        if ($r == "true") {
            return 1;
        } else {
            return 0;
        }
    }

}
