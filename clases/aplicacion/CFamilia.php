<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CFamilia
 *
 * @author Personal
 */
class CFamilia {
var $id = null;
var $descripcion = null;
var $ee=null;


//definimos los atributos de la clase y creamos el constructor de la misma
function CFamilia($id, $descripcion,$ee) {
$this->id = $id;
$this->descripcion = $descripcion;
$this->ee=$ee;
}

function getId() {
    return $this->id;
}

function getDescripcion() {
    return $this->descripcion;
}
/**
     * cargarfamilia, permite cargar el objeto familia para modificarlo y eliminarlo 
     */
function cargarfamilia() {
$r = $this->ee->obtenerfamiliaporId($this->id);
if($r != -1){
$this->id = $r['Id_Familia'];
$this->descripcion=$r['Descripcion_Familia'];
}
else{
$this->id = '';
$this->descripcion='';
}
}


   /**
     * eliminarfamilia, elimina el objeto familia de la base de datos
     */
function eliminarfamilia($id){
    
$r = $this->ee->eliminarfamilia($id);

if($r==1){ $ms1=MENSAJE_BORRAR_EXITO_FAMILIA;}
else{ $ms1=MENSAJE_BORRAR_FRACASO_FAMILIA;}
return $ms1;
}


 /**
     * actualizafamilias, actualiza los atributos  del objeto familia de la base de datos
     */

function actualizafamilias($id, $descripcion){
    
$r = $this->ee->actualizafamilia($id, $descripcion);

 if ($r == 1) {
           $ms=MENSAJE_EDITAR_EXITO_FAMILIA;
        } else {
           $ms=MENSAJE_BORRAR_FRACASO_FAMILIA;
        }
return $ms;
}

}
