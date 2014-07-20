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
*CVigencia4
*
*Usada para todas las funciones de aplicacion referente a anticipos del modulo financiero
*
* @package  clases
* @subpackage aplicacion
*/
Class CVigencia4{
/**
*identificador unico del anticipo
*@var integer 
*/
	var $id = null;
/**
*identificador del anio
*@var integer 
*/
	var $anio = null;
/**
*monto del anticipo
*@var double
*/
	var $monto = null;
/**
*anticipo del anticipo
*@var varchar
*/
	var $anticipo = null;
/**
*Instancia de la clase CVigencia4Data
*@var object 
*/
	var $dd = null;
/**
*retorna el identificador del anticipo
*@return integer
*/	
	function getId(){ return $this->id; }
/**
*retorna el identificador del contrato del anticipo
*@return integer
*/
	function getAnio(){ return $this->anio; }
/**
*retorna el monto del anticipo
*@return float
*/
	function getMonto(){ return $this->monto; }
/**
*retorna la señal de si el monto es anticipo o no
*@return varchar
*/
	function getAnticipo(){ return $this->anticipo; }
/**
*constructor de la clase
*
*@param integer $id identificador del anticipo
*@param integer $anio identificador del contrato
*@param float $monto monto del anticipo
*@param float $anticipo anticipo del anticipo
*@param object $dd instancia de la clase CVigencia4Data
*/
	function CVigencia4($id,$anio,$monto,$anticipo,$dd){
		$this->id = $id;
		$this->anio = $anio;
		$this->monto = $monto;
		$this->anticipo = $anticipo;
		$this->dd = $dd;
	}

}
?>