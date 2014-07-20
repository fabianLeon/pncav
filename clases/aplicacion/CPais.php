<?php

/**
 * Clase destinada al manejon ordenado de paises dentro del sistema
 *
 * @version 1.0
 * @since 12/06/2014
 */
class CPais {
    /**
     *  Identificador único interno de cada país
     * @var Integer 
     */
    var $id=null;
    
    /**
     *  Nombre del país
     * @var String 
     */
    var $nombre=null;
    
    /**
     *  Instancia de la clase CPaisData
     * @var  CPaisData
     */
    var $db = null;
    
    /**
     * Constructor para la clase CPais
     * @param Integer $id
     * @param String $nombre
     * @param CPaisData $db 
     */
    function CPais($id, $nombre, $db) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->db = $db;
    }
    
    /**
     * Retorna el código interno del País
     * @return Integer
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Retorna el nombre del País
     * @return String
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Función que carga los datos del pais dependiendo del Id almacenado
     */
    function cargarPais(){
        $r = $this->db->obtenerPaisId($this->id);
        if($r != -1){ //r contiene la información del país
            $this->id = $r['Id_Pais'];
            $this->nombre=$r['Nombre_Pais'];
        }
        else{ //Se llenará con espacios vacios
            $this->id = '';
            $this->descripcion='';
        }
    }
    
    /**
     * Función que elimina el país al que pertenece el id entregado
     * @param Integer $id Código único interno del país
     * @return string
     */
    function eliminarPais($id){
        $r = $this->db->eliminarPais($id);

        if($r==1){ $ms1=MENSAJE_PAIS_ELIMINADO;}
        else{ $ms1=MENSAJE_ERROR_PAIS_ELIMINADO;}
        return $ms1;
    }
    
    /**
     * Función que actualiza el nombre de un país
     * @param Integer $id Código del país
     * @param Nombre $nombre Nombre nuevo del país
     * @return string
     */
    function actualizarPais($id, $nombre){
        $r = $this->db->actualizarPais($id, $nombre);
        if($r==1){ $ms2 = MENSAJE_PAIS_ACTUALIZADO;}
        else{ $ms2 = MENSAJE_ERROR_PAIS_ACTUALIZADO;}
        return $ms2;
    }

}
