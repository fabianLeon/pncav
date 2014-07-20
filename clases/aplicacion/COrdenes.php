<?php
/**
*/

class COrdenes{
/**
*identificador unico del rubro
*@var integer 
*/
	var $id = null;
	var $operador = null;
	var $fecha = null;
	var $numero = null;
	var $rubro = null;
	var $concepto = null;
	var $modalidad = null;
	var $tasa = null;
	var $valor_dolares = null;
	var $valor_pesos = null;
	var $dr = null;
/**
*Constructor de la clase
*@param object $dr instancia de la clase COrdenesData
*/				
	function COrdenes($id,$operador,$fecha,$numero,$rubro,$concepto,$modalidad,
						 $tasa,$valor_dolares,$valor_pesos,$dr){
		$this->id 					= $id;
		$this->operador 			= $operador;
		$this->fecha 				= $fecha;
		$this->numero 				= $numero;
		$this->rubro 				= $rubro;
		$this->concepto 			= $concepto;
		$this->modalidad 			= $modalidad;
		$this->tasa 				= $tasa;
		$this->valor_dolares 		= $valor_dolares;
		$this->valor_pesos 			= $valor_pesos;
		$this->dr 					= $dr;
	}
/**
*retorna el identificador del rubro
*@return integer
*/					
	function getId()				{return $this->id;}
	function getOperador()			{return $this->operador;}
	function getFecha()				{return $this->fecha;}
	function getNumero()			{return $this->numero;}
	function getRubro()			 	{return $this->rubro;}
	function getConcepto()  	 	{return $this->concepto;}
	function getModalidad()		 	{return $this->modalidad;}
	function getTasa() 		 		{return $this->tasa;}
	function getValorDolares() 		{return $this->valor_dolares;}
	function getValorPesos()  		{return $this->valor_pesos;}
			
	function saveNewOrden(){
		$r = $this->dr->insertOrden($this->operador,$this->fecha,$this->numero,$this->rubro,$this->concepto,
										$this->modalidad,$this->tasa,$this->valor_dolares,$this->valor_pesos);
		if($r=='true'){
			$msg = ORDEN_AGREGADO;
		}else{
			$msg = ERROR_ADD_ORDEN;
		}
		return $msg;
	}
/**
*carga los valores de un rubro por su id
*/				
	function loadOrden(){
		$r = $this->dr->getOrdenById($this->id);
		if($r != -1){
			$this->operador 			= $r['ope_id'];
			$this->fecha 				= $r['ord_fecha'];
			$this->numero 				= $r['ord_numero'];
			$this->rubro 				= $r['rub_id'];
			$this->concepto 			= $r['cnc_id'];
			$this->modalidad 			= $r['mod_id'];
			$this->tasa 				= $r['ord_tasa'];
			$this->valor_dolares 		= $r['ord_dolares'];
			$this->valor_pesos 			= $r['ord_pesos'];

		}else{
			$this->operador 			= "";
			$this->fecha 				= "";
			$this->numero 				= "";
			$this->rubro 				= "";
			$this->concepto 			= "";
			$this->modalidad 			= "";
			$this->tasa 				= "";
			$this->valor_dolares 		= "";
			$this->valor_pesos 			= "";
		
		}
	}
/**
*borra un rubro y retorna un mensaje del resultado del proceso
*@return string
*/			
	function deleteOrden(){
		$r = $this->dr->deleteOrden($this->id);
		if($r=='true'){
			$msg = ORDEN_BORRADO;		
		}else{
			$msg = ERROR_DEL_ORDEN;
		}
		return $msg;
	}

/**
*actualiza los valores de un rubro y retorna un mensaje del resultado del proceso
*@return string
*/			
	function saveEditOrden(){
		$r = $this->dr->updateOrden($this->id,$this->operador,$this->fecha,$this->numero,$this->rubro,$this->concepto,
										$this->modalidad,$this->tasa,$this->valor_dolares,$this->valor_pesos);
		if($r=='true'){
			$msg = ORDEN_EDITADO;
		}else{
			$msg = ERROR_EDIT_ORDEN;
		}
		return $msg;
	}
	
}
?>