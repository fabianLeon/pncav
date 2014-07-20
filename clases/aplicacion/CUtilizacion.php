<?php
/**
*/

class CUtilizacion{
/**
*identificador unico del rubro
*@var integer 
*/
	var $id = null;
	var $operador = null;
	var $fecha = null;
	var $condicion = null;
	var $aprobado = null;
	var $autorizacion = null;
	var $comunicado = null;
	var $comentarios = null;
	var $dr = null;
/**
*Constructor de la clase
*@param object $dr instancia de la clase CUtilizacionData
*/				
	function CUtilizacion($id,$operador,$fecha,$condicion,$aprobado,$autorizacion,$comunicado,
						 $comentarios,$dr){
		$this->id 					= $id;
		$this->operador 			= $operador;
		$this->fecha 				= $fecha;
		$this->condicion 			= $condicion;
		$this->aprobado 			= $aprobado;
		$this->autorizacion 		= $autorizacion;
		$this->comunicado 			= $comunicado;
		$this->comentarios 			= $comentarios;
		$this->dr 					= $dr;
	}
/**
*retorna el identificador del rubro
*@return integer
*/					
	function getId()				 {return $this->id;}
	function getOperador()			 {return $this->operador;}
	function getFecha()				 {return $this->fecha;}
	function getCondicion()			 {return $this->condicion;}
	function getAprobado()			 {return $this->aprobado;}
	function getAutorizacion()  	 {return $this->autorizacion;}
	function getComunicado()		 {return $this->comunicado;}
	function getComentarios() 		 {return $this->comentarios;}
/**
*almacena un rubro, validando la no existencia del nombre ingresado y retorna un mensaje del resultado del proceso
*@return string
*/				
	function saveNewUtilizacion(){
		$r = $this->dr->insertUtilizacion($this->operador,$this->fecha,$this->condicion,$this->aprobado,$this->autorizacion,
										$this->comunicado,$this->comentarios);
		if($r=='true'){
			$msg = UTILIZACION_AGREGADO;
		}else{
			$msg = ERROR_ADD_UTILIZACION;
		}
		return $msg;
	}
/**
*carga los valores de un rubro por su id
*/				
	function loadUtilizacion(){
		$r = $this->dr->getUtilizacionById($this->id);
		if($r != -1){
			$this->operador 			= $r['ope_id'];
			$this->fecha 				= $r['uti_fecha'];
			$this->condicion 			= $r['uti_condicion'];
			$this->aprobado 			= $r['uti_aprobado'];
			$this->autorizacion 		= $r['uti_autorizacion'];
			$this->comunicado 			= $r['uti_comunicado'];
			$this->comentarios 			= $r['uti_comentarios'];

		}else{
			$this->operador 			= "";
			$this->fecha 				= "";
			$this->condicion 			= "";
			$this->aprobado 			= "";
			$this->autorizacion 		= "";
			$this->comunicado 			= "";
			$this->comentarios 			= "";
		
		}
	}
/**
*borra un rubro y retorna un mensaje del resultado del proceso
*@return string
*/			
	function deleteUtilizacion(){
		$r = $this->dr->deleteUtilizacion($this->id);
		if($r=='true'){
			$msg = UTILIZACION_BORRADO;		
		}else{
			$msg = ERROR_DEL_UTILIZACION;
		}
		return $msg;
	}

/**
*actualiza los valores de un rubro y retorna un mensaje del resultado del proceso
*@return string
*/			
	function saveEditUtilizacion(){
		$r = $this->dr->updateUtilizacion($this->id,$this->operador,$this->fecha,$this->condicion,$this->aprobado,$this->autorizacion,
										$this->comunicado,$this->comentarios);
		if($r=='true'){
			$msg = UTILIZACION_EDITADO;
		}else{
			$msg = ERROR_EDIT_UTILIZACION;
		}
		return $msg;
	}
	
}
?>