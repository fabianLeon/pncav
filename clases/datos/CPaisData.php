<?php

/**
 * Clase destinada a la gestión de datos referentes a los paises
 *
 * @version 1.0
 * @since 12/06/2014
 */
class CPaisData {
    /**
     *  Instancia de la clase que conecta la base de datos
     * @var CData 
     */
    var $db = null;
    
    /**
     * Constructor de la clase
     * @param CData $db
     */
    function CPaisData($db){
        $this->db = $db;
    }
    
    /**
     * Función que inserta un nuevo país en la base de datos
     * @param Integer $id
     * @param String $nombre
     * @return Integer 1 si el país fue agregado correctamente, 0 si el país no se agregó
     */
    function insertarPais($id, $nombre){
        $tabla = "pais";
        $campos = "Id_Pais,Nombre_Pais";
        $valores = "'" . $id . "','" . $nombre. "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        if ($r == "true") {
            return MENSAJE_PAIS_INSERTADO;
        } else {
            return MENSAJE_ERROR_PAIS_INSERTADO;
        }
    }
    
    /**
     * Función que retorna una matriz con los datos de todos los paises
     * registrados en la base de datos.
     * @return Array
     */
    function obtenerPais(){
        $sql = "SELECT Id_Pais, Nombre_Pais from pais";
        $paises = null;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                  
                for ($i = 0; $i < count($w)/2; $i++){
                  $paises[$cont][$i] = $w[$i];
                }
                $cont++;
            }
        } 
        return $paises;
    }
    
    function obtenerPaisId($id){
        $sql = "select * from pais where Id_Pais= " . $id;
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }
    
    /**
     * Función que actualiza un registro de país
     * @param Integer $id
     * @param String $nombre
     * @return Integer 1 si la actualización se realizó, 0 si la actualización no fue realizada
     */
    function actualizarPais($id, $nombre){
        $tabla = 'pais';
        $campos = array('Nombre_Pais');
        $valores = array("'" . $nombre ."'");
        $condicion = "Id_Pais = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        if ($r == "true") {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Función que elimina registros de paises en la base de datos
     * @param Integer $id
     * @return Integer 1 si el registro se eliminó satisfactoriamente, 0 si el registro no se eliminó 
     */
    function eliminarPais($id){
        $tabla = "pais";
        $predicado = "Id_Pais=" . $id;
        $e = $this->db->borrarRegistro($tabla, $predicado);
        if ($e == "true") {
            return 1;
        } else {
            return 0;
        }
    }
}
