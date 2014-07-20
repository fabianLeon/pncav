<?php
/**
*/

class CConcepto{
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
*Instancia de la clase CConcepto1Data
*@var object 
*/
	var $dr = null;
/**
*Constructor de la clase
*@param object $dr instancia de la clase CConcepto1Data
*/				
	function CConcepto($id,$nombre,$dr){
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
				
	function saveNewConcepto(){
		$r = $this->dr->insertConcepto($this->nombre);
		if($r=='true'){
			$this->id = $this->dr->getConceptoIdByNombre($this->nombre);
			$msg = CONCEPTO_AGREGADO;
		}else{
			$msg = ERROR_ADD_CONCEPTO;
		}
		return $msg;
		
	
	}
				
	function loadConcepto(){
		$r = $this->dr->getConceptoById($this->id);
		if($r != -1){
			$this->nombre = $r['nombre'];
		}else{
			$this->nombre = "";
		}
	}
		
	function deleteConcepto(){
		$r = $this->dr->deleteConcepto($this->id);
		if($r=='true'){
			$msg = CONCEPTO_BORRADO;		
		}else{
			$msg = ERROR_DEL_CONCEPTO;
		}
		return $msg;
	}
		
	function saveEditConcepto(){
		$r = $this->dr->updateConcepto($this->id,$this->nombre);
		if($r=='true'){
			$msg = CONCEPTO_EDITADO;
		}else{
			$msg = ERROR_EDIT_CONCEPTO;
		}
		return $msg;
	}
//conceptos para el plan de compras
	function saveNewConceptoOP($operador){
		$r = $this->dr->insertConceptoOP($operador,$this->nombre);
		if($r=='true'){
			$msg = CONCEPTO_AGREGADO;
		}else{
			$msg = ERROR_ADD_CONCEPTO;
		}
		return $msg;
		
	
	}
		
	function loadConceptoOP(){
		$r = $this->dr->getConceptoOPById($this->id);
		if($r != -1){
			$this->nombre = $r['nombre'];
		}else{
			$this->nombre = "";
		}
	}
		
	function deleteConceptoOP(){
		$r = $this->dr->deleteConceptoOP($this->id);
		if($r=='true'){
			$msg = CONCEPTO_BORRADO;		
		}else{
			$msg = ERROR_DEL_CONCEPTO;
		}
		return $msg;
	}
			
	function saveEditConceptoOP(){
		$r = $this->dr->updateConceptoOP($this->id,$this->nombre);
		if($r=='true'){
			$msg = CONCEPTO_EDITADO;
		}else{
			$msg = ERROR_EDIT_CONCEPTO;
		}
		return $msg;
	}
	
}
?>