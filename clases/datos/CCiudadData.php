<?php

/**
 * Clase destinada a la gestión de datos referentes a las ciudades
 *
 * @version 1.0
 * @since 12/06/2014
 */
class CCiudadData {
    /**
     *  Instancia de la clase que conecta la base de datos
     * @var CData
     */
    var $db = null;
    
    /**
     * Constructor de la clase
     * @param CData $db
     */
    function CCiudadData($db){
        $this->db = $db;
    }
    
    /**
     * Función que inserta una nueva ciudad en la base de datos
     * @param Integer $id Identificador único de ciudad
     * @param Integer $pais Identificador del país al que pertenece
     * @param String $nombre Nombre de la ciudad
     * @return Integer 1 si la ciudad fue agregada correctamente, 0 si la ciudad no se agregó
     */
    function insertarCiudad($id, $pais, $nombre){
        $tabla = "ciudad";
        $campos = "Id_Ciudad,Id_Pais, Nombre_Ciudad";
        $valores = "'" . $id . "'," . $pais . ",'" . $nombre. "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        if ($r == "true") {
            return MENSAJE_CIUDAD_INSERTADA;
        } else {
            return MENSAJE_ERROR_CIUDAD_INSERTADA;
        }
    }
    
    /**
     * Función que retorna una matriz con los datos de todas las ciudades
     * registrados en la base de datos.
     * @return Array
     */
    function obtenerCiudades(){
        $sql = "SELECT Id_Ciudad, Nombre_Pais, Nombre_ciudad FROM ciudad C, pais P "
                ."WHERE C.Id_Pais = P.Id_Pais";
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
    
    /**
     * Función que devuelve la información contenidad en la base de datos de
     * una ciudad especifica.
     * @param Integer $id Código único de ciudad
     * @return type
     */
    function obtenerCiudadId($id){
        $sql = "SELECT Id_Ciudad, C.Id_Pais, Nombre_Pais, Nombre_ciudad FROM ciudad C, pais P "
                . "WHERE C.Id_Pais = P.Id_Pais AND Id_Ciudad= " . $id;
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }
    
    /**
     * Función que actualiza un registro de ciudad
     * @param Integer $id Código que se va a actualizar
     * @param Integer $pais Identificador de país
     * @param String $nombre Nombre de la ciudad
     * @return Integer 1 si la actualización se realizó, 0 si la actualización no fue realizada
     */
    function actualizarCiudad($id, $pais, $nombre){
        $tabla = 'ciudad';
        $campos = array('Id_Pais','Nombre_Ciudad');
        $valores = array($pais,"'" . $nombre ."'");
        $condicion = "Id_Ciudad = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        if ($r == "true") {
            return 1;
        } else {
            return 0;
        }
    }
    
    /**
     * Función que elimina registros de ciudades en la base de datos
     * @param Integer $id Identificador de la ciudad a borrar
     * @return Integer 1 si el registro se eliminó satisfactoriamente, 0 si el registro no se eliminó 
     */
    function eliminarCiudad($id){
        $tabla = "ciudad";
        $predicado = "Id_Ciudad=" . $id;
        $e = $this->db->borrarRegistro($tabla, $predicado);
        if ($e == "true") {
            return 1;
        } else {
            return 0;
        }
    }
}
