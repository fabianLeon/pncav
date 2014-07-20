<?php
/**
*/

class CRubro{
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
*monto
*@var string 
*/
	var $monto = null;
        
/**
*operador
*@var string 
*/
	var $operador = null;
/**
*Instancia de la clase CRubroData
*@var CRubroData 
*/
	var $dr = null;
/**
*Constructor de la clase
*@param object $dr instancia de la clase CRubro1Data
*/				
	function CRubro($id,$nombre,$monto,$dr){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->monto = $monto;
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
/**
*retorna el monto
*@return string
*/				
	function getMonto(){
		return $this->monto;
	}
        
        function getOperador()
        {
            return $this->operador;
        }
        
        function setOperador($operador)
        {
            $this->operador = $operador;
        }
        
        
        
/**
*almacena un rubro, validando la no existencia del nombre ingresado y retorna un mensaje del resultado del proceso
*@return string
*/				
	function saveNewRubro(){
		$r = $this->dr->insertRubro($this->nombre,$this->monto,$this->operador);
		if($r=='true'){
			$this->id = $this->dr->getRubroIdByNombre($this->nombre);
			$msg = RUBRO_AGREGADO;
		}else{
			$msg = ERROR_ADD_RUBRO;
		}
		return $msg;
		
	
	}
/**
*carga los valores de un rubro por su id
*/				
	function loadRubro(){
		$r = $this->dr->getRubroById($this->id);
		if($r != -1){
			$this->nombre = $r['nombre'];
			$this->monto = $r['monto'];
		}else{
			$this->nombre = "";
			$this->monto = "";
		}
	}
/**
*borra un rubro y retorna un mensaje del resultado del proceso
*@return string
*/			
	function deleteRubro(){
		$r = $this->dr->deleteRubro($this->id);
		if($r=='true'){
			$msg = RUBRO_BORRADO;		
		}else{
			$msg = ERROR_DEL_RUBRO;
		}
		return $msg;
	}

/**
*actualiza los valores de un rubro y retorna un mensaje del resultado del proceso
*@return string
*/			
	function saveEditRubro(){
		$r = $this->dr->updateRubro($this->id,$this->nombre,$this->monto);
		if($r=='true'){
			$msg = RUBRO_EDITADO;
		}else{
			$msg = ERROR_EDIT_RUBRO;
		}
		return $msg;
	}
	// funciones para las actividades o rubros de los planes de compras
	function saveNewRubroOP($operador){
		$r = $this->dr->insertRubroOP($operador,$this->nombre,$this->monto);
		if($r=='true'){
			$msg = RUBRO_AGREGADO;
		}else{
			$msg = ERROR_ADD_RUBRO;
		}
		return $msg;
		
	
	}
/**
*carga los valores de un rubro por su id
*/				
	function loadRubroOP(){
		$r = $this->dr->getRubroOPById($this->id);
		if($r != -1){
			$this->nombre = $r['nombre'];
			$this->monto = $r['monto'];
		}else{
			$this->nombre = "";
			$this->monto = "";
		}
	}
/**
*borra un rubro y retorna un mensaje del resultado del proceso
*@return string
*/			
	function deleteRubroOP(){
		$r = $this->dr->deleteRubroOP($this->id);
		if($r=='true'){
			$msg = RUBRO_BORRADO;		
		}else{
			$msg = ERROR_DEL_RUBRO;
		}
		return $msg;
	}

/**
*actualiza los valores de un rubro y retorna un mensaje del resultado del proceso
*@return string
*/			
	function saveEditRubroOP(){
		$r = $this->dr->updateRubroOP($this->id,$this->nombre,$this->monto);
		if($r=='true'){
			$msg = RUBRO_EDITADO;
		}else{
			$msg = ERROR_EDIT_RUBRO;
		}
		return $msg;
	}	
}
?>