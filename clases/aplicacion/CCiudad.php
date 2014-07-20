<?php

/**
 * Clase destinada al manejon ordenado de ciudades dentro del sistema
 *
 * @version 1.0
 * @since 12/06/2014
 */
class CCiudad {
    /**
     *  Identificador único interno de cada ciudad
     * @var Integer 
     */
    var $id=null;
    
    /**
     * Identificador de país
     * @var Integer 
     */
    var $pais = null;
    
    /**
     *  Nombre de la ciudad
     * @var String 
     */
    var $nombre=null;
    
    /**
     *  Instancia de la clase CCiudadData
     * @var  CCiudadData
     */
    var $db = null;
    
    /**
     * Constructor para la clase
     * @param Integer $id
     * @param Integer $pais
     * @param String $nombre
     * @param CCiudadData $db
     */
    function CCiudad($id, $pais, $nombre, $db) {
        $this->id = $id;
        $this->pais = $pais;
        $this->nombre = $nombre;
        $this->db = $db;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getPais() {
        return $this->pais;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getDb() {
        return $this->db;
    }

    /**
     * Función que carga los datos de la ciudad dependiendo del Id almacenado
     */
    function cargarCiudad(){
        $r = $this->db->obtenerCiudadId($this->id);
        if($r != -1){ //r contiene la información del país
            $this->id = $r['Id_Ciudad'];
            $this->pais = $r['Id_Pais'];
            $this->nombre=$r['Nombre_ciudad'];
        }
        else{ //Se llenará con espacios vacios
            $this->id = '';
            $this->pais='';
            $this->nombre='';
        }
    }
    
    /**
     * Función que elimina una ciudad
     * @param Integer $id Código único interno la ciudad a eliminar
     * @return string
     */
    function eliminarCiudad($id){
        $r = $this->db->eliminarCiudad($id);

        if($r==1){ $ms1=MENSAJE_CIUDAD_ELIMINADA;}
        else{ $ms1=MENSAJE_ERROR_CIUDAD_ELIMINADA;}
        return $ms1;
    }

    /**
     * Función que actualiza el nombre de una ciudad y su país de procedencia
     * @param Integer $id Código de la ciudad
     * @param Integer $pais Código del país
     * @param Nombre $nombre Nombre nuevo de la ciudad
     * @return string
     */
    function actualizarCiudad($id, $pais, $nombre){
        $r = $this->db->actualizarCiudad($id, $pais, $nombre);
        if($r==1){ $ms2 = MENSAJE_CIUDAD_ACTUALIZADA;}
        else{ $ms2 = MENSAJE_ERROR_CIUDAD_ACTUALIZADA;}
        return $ms2;
    }
}
