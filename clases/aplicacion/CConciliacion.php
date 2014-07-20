<?php
/**
*Redcom Ltda 
*<ul> Desarrollado por
*<li> Camaleon Multimedia ltda <www.camaleon.com.co></li>
*<li> Copyright Redcom</li>
*<li> Redcom Ltda</li>
*</ul>
*/

/**
*CConciliacion1
*
*Usada para todas las funciones de aplicacion referente a anticipos del modulo financiero
*
* @package  clases
* @subpackage aplicacion
*/
Class CConciliacion{
/**
*identificador unico de la Conciliacion
*@var integer 
*/
	var $id = null;
/**
*identificador del concepto de la Conciliacion
*@var integer 
*/
	var $concepto = null;
/**
*fecha de la Conciliacion
*@var mixed 
*/
	var $fecha = null;
/**
*monto de la Conciliacion
*@var float 
*/
	var $monto = null;
/**
*identificador del estado de la Conciliacion
*@var integer 
*/
	var $observaciones = null;
        
/**
*Operador
*@var integer 
*/
	var $operador = null;        
        
/**
*Instancia de la clase CConciliacionData
*@var CConciliacionData 	
*/
	var $dd = null;
/**
*retorna el identificador de la Conciliacion
*@return integer	
*/
	function getId(){ return $this->id; }
/**
*retorna el identificador del concepto de la Conciliacion
*@return integer	
*/
	function getConcepto(){ return $this->concepto; }
/**
*retorna la fecha de la Conciliacion
*@return mixed
*/
	function getFecha(){ return $this->fecha; }
/**
*retorna el monto de la Conciliacion
*@return float	
*/
	function getMonto(){ return $this->monto; }
/**
*retorna el identificador del observaciones de la Conciliacion
*@return integer
*/
	function getObservaciones(){ return $this->observaciones; }
        
        function setOperador($operador){ $this->operador=$operador;}
        
        function getOperador(){return $this->operador;}
/**
*Constructor de la clase
*
*@param integer $id identificador unico de la Conciliacion
*@param integer $concepto identificador del concepto de la Conciliacion
*@param mixed $fecha fecha de la Conciliacion
*@param string $proveedor nombre del proveedor
*@param string $documento_proveedor documento del proveedor
*@param float $monto monto dela Conciliacion sin iva
*@param integer $observaciones identificador del observaciones de la Conciliacion
*@param object $dd instancia de la clase CConciliacion1Data
*/
	function CConciliacion($id,$concepto,$fecha,$monto,$observaciones,$dd){
		$this->id = $id;
		$this->concepto = $concepto;
		$this->fecha = $fecha;
		$this->monto = $monto;
		$this->observaciones=$observaciones;
		$this->dd = $dd;
	}
/**
*carga los montos de los atributos de la clase
*/	
	function loadConciliacion(){
		$r  = $this->dd->getConciliacionById($this->id);
		if($r != -1){
			$this->concepto = $r['cnc_id'];
			$this->fecha = $r['cnl_fecha'];
			$this->monto = $r['cnl_monto'];
			$this->observaciones = $r['cnl_observaciones'];
		}else{
			$this->concepto = "";
			$this->fecha = "";
			$this->monto = "";
			$this->observaciones = "";
		}
	}
	
/**
*almacena una nueva Conciliacion verificando que su monto no exceda lo disponible 
*para ejecutar  y retorna el resultado del proceso
*@param float $monto_anticipado monto anticipado hasta la fecha
*@param float $monto_ejecutado monto ejecutado hasta la fecha
*@return string
*/	
	function saveNewConciliacion(){
		$r = "";
		$i = $this->dd->insertConciliacion($this->concepto,$this->fecha,$this->monto,$this->observaciones,$this->operador);
		if($i == true){
			$r = CONCILIACION_AGREGADO;
		}else{
			$r = ERROR_ADD_CONCILIACION;
		}
		return $r;
	}
/**
*actualiza una Conciliacion verificando que su monto no exceda lo disponible 
*para ejecutar  y retorna el resultado del proceso
*@return string
*/		
	function saveEditConciliacion(){
		$r = "";
		$i = $this->dd->updateConciliacion($this->id,$this->concepto,$this->fecha,
									  $this->monto,$this->observaciones);
		if($i == true){
			$r = CONCILIACION_EDITADO;
		}else{
			$r = ERROR_EDIT_CONCILIACION;
		}
		return $r;
	}
	
	
/**
*elimina una Conciliacion y retorna el resultado del proceso
*@return string
*/		
	function deleteConciliacion(){
		$r = $this->dd->deleteConciliacion($this->id);
		if($r=='true'){
			$msg = CONCILIACION_BORRADO;		
		}else{
			$msg = ERROR_DEL_CONCILIACION;
		}
		
		return $msg;
	
	}
	
}
?>