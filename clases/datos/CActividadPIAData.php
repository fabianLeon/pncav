<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CActividadesData
 *
 * @author Brian Kings
 */
class CActividadPIAData {

    //put your code here
    var $db = null;

    /*
     * Constructor de la clase
     */

    function CActividadPIAData($db) {
        $this->db = $db;
    }

    /*
     * Obtiene todas las actividadesPIA que estan registradas en la base de datos 
     * dependiendo del criterio ingresado
     */

    function getActividadPIA($criterio) {
        $actividades = null;
        $sql = "select act.act_id ,act.act_descripcion, act.act_monto from actividadPIA act where " . $criterio;
        //echo $sql;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $actividades[$cont]['id_element'] = $w['act_id'];
                $actividades[$cont]['descripcion'] = $w['act_descripcion'];
                $actividades[$cont]['monto'] = $w['act_monto'];
                $cont++;
            }
        }
        return $actividades;
    }

    /*
     * Insertarmos un nuevo registro de ActividadPIA en la base de datos
     */

    function insertActividadPIA($descripcion, $monto) {
        $tabla = 'actividadPIA';
        $campos = 'act_descripcion,act_monto';
        $valores = "'" . $descripcion . "','" . $monto . "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }

    /*
     * Eliminamos un registro de ActividadPIA de la base de datos
     */

    function deleteActividadPIA($id) {
        $tabla = "actividadPIA";
        $predicado = "act_id = " . $id;
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }

    /*
     * Obtiene los datos de una ActividadPIA a través del id
     */

    function getActividadPIAById($id) {
        $sql = "SELECT act.act_id,act.act_descripcion,act.act_monto from actividadPIA act where act_id = " . $id;

        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));

        if ($r)
            return $r;
        else
            return -1;
    }

    /*
     * Actualiza los datos de un registro de ActividadPIA
     */

    function updateActividadPIA($id, $descripcion, $monto) {
        $tabla = 'actividadPIA';
        $campos = array('act_descripcion', ' act_monto');
        $valores = array("'" . $descripcion . "'", "'" . $monto . "'");
        $condicion = " act_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

}
