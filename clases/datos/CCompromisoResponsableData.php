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
* Clase CompromisoResponsableData
* Usada para la definicion de todas las funciones propias del objeto COMPROMISO_RESPONSABLE
*
* @package  clases
* @subpackage datos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/
Class CCompromisoResponsableData{
    var $db = null;
	
	function CCompromisoResponsableData($db){
		$this->db = $db;
	}
	
	function getResponsableById($id){
		$sql = "SELECT cr.cor_id,cr.com_id,cr.usu_id, u.usu_nombre, u.usu_apellido
                        FROM compromiso_responsable cr, usuario u 
			WHERE u.usu_id = cr.usu_id and cr.cor_id= ". $id;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function insertResponsable($compromiso,$nombre){
		$tabla = "compromiso_responsable";
		$campos = "com_id,usu_id";
		$valores = "'".$compromiso."','".$nombre."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function deleteResponsable($id){
		$tabla = "compromiso_responsable";
		$predicado = "cor_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
}