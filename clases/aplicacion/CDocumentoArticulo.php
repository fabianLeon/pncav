<?php
/**
*
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto PNCAV</li>
*</ul>
*/

/**
* Clase DocumentoArticulo
*
* @package  clases
* @subpackage aplicacion
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/

class CDocumentoArticulo{
	var $id 			=  null;
	var $alcance 		=  null;
	var $documento 		=  null;
	var $nombre 		=  null;
	var $descripcion 	=  null;
	var $ar 			=  null;
/**
** Constructor de la clase CDocumentoArticuloData
**/	
	function CDocumentoArticulo($id,$alcance,$documento,$nombre,$descripcion,$ar){
		$this->id 			=  $id;
		$this->alcance 		=  $alcance;
		$this->documento 	=  $documento;
		$this->nombre 		=  $nombre;
		$this->descripcion	=  $descripcion;
		$this->ar 			=  $ar;
	}
	function getId(){ 			return	$this->id; }
	function getAlcance(){ 	    return	$this->alcance; }
	function getDocumento(){ 	return	$this->documento; }
	function getNombre(){ 		return	$this->nombre; }
	function getDescripcion(){  return	$this->descripcion; }
/**
** carga los valores de un objeto ARTICULO por su id para ser editados
**/
	function loadArticulo(){
			$r = $this->ar->getArticuloById($this->id);
			if($r != -1){
				$this->id 			=  $r['doa_id'];
				$this->alcance 		=  $r['alc_id'];
				$this->documento 	=  $r['doc_id'];
				$this->nombre 		=  $r['doa_nombre'];
				$this->descripcion	=  $r['doa_descripcion'];
			}else{
				$this->id 			=  "";
				$this->alcance 		=  "";
				$this->documento 	=  "";
				$this->nombre 		=  "";
				$this->descripcion	=  "";
			}
	}
/**
** almacena un objeto ARTICULO y retorna un mensaje del resultado del proceso
**/				
function saveNewArticulo(){
		$r = $this->ar->insertArticulo($this->alcance,$this->documento,$this->nombre,$this->descripcion);
		if($r=='true'){
			$msg = ARTICULO_AGREGADO;
		}else{
			$msg = ERROR_ADD_ARTICULO;
		}	
		return $msg;
	}
/**
** elimina un objeto ARTICULO y retorna un mensaje del resultado del proceso
**/				
	function deleteArticulo(){
		$r = $this->ar->deleteArticulo($this->id);
		if($r=='true'){
			$msg = ARTICULO_BORRADO;		
		}else{
			$msg = ERROR_DEL_ARTICULO;
		}
		
		return $msg;
	
	}

/**
** actualiza un objeto ARTICULO y retorna un mensaje del resultado del proceso
**/				
	function saveEditArticulo(){
		$r = $this->ar->updateArticulo($this->id,$this->nombre,$this->descripcion);
		if($r=='true'){
			$msg = ARTICULO_EDITADO;
		}else{
			$msg = ERROR_EDIT_ARTICULO;
		}
		return $msg;	
	}

}	
?>