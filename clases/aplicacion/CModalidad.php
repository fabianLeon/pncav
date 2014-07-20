<?php
/**
*/

class CModalidad{
/**
*identificador unico del rubro
*@var integer 
*/
	var $id = null;
/**
*nombre
*@var string 
*/
	var $nombre = null;
/**
*Instancia de la clase CModalidad1Data
*@var object 
*/
	var $dr = null;
/**
*Constructor de la clase
*@param object $dr instancia de la clase CModalidad1Data
*/				
	function CModalidad($id,$nombre,$dr){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->dr = $dr;
	}
/**
*retorna el identificador del rubro
*@return integer
*/					
	function getId(){
		return $this->id;
	}
/**
*retorna el nombre
*@return string
*/				
	function getNombre(){
		return $this->nombre;
	}
				
//modalidades para el plan de compras
	function saveNewModalidadOP($operador){
		$r = $this->dr->insertModalidadOP($operador,$this->nombre);
		if($r=='true'){
			$msg = MODALIDAD_AGREGADO;
		}else{
			$msg = ERROR_ADD_MODALIDAD;
		}
		return $msg;
		
	
	}
		
	function loadModalidadOP(){
		$r = $this->dr->getModalidadOPById($this->id);
		if($r != -1){
			$this->nombre = $r['nombre'];
		}else{
			$this->nombre = "";
		}
	}
		
	function deleteModalidadOP(){
		$r = $this->dr->deleteModalidadOP($this->id);
		if($r=='true'){
			$msg = MODALIDAD_BORRADO;		
		}else{
			$msg = ERROR_DEL_MODALIDAD;
		}
		return $msg;
	}
			
	function saveEditModalidadOP(){
		$r = $this->dr->updateModalidadOP($this->id,$this->nombre);
		if($r=='true'){
			$msg = MODALIDAD_EDITADO;
		}else{
			$msg = ERROR_EDIT_MODALIDAD;
		}
		return $msg;
	}
	
}
?>