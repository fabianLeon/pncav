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
* Clase CompromisoResponsable
*
* @package  clases
* @subpackage aplicacion
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/

class CCompromisoResponsable{
	var $id =  null;
	var $compromiso =  null;
	var $destinatario =  null;
	var $db = null;
/**
** Constructor de la clase CCompromisoResponsableData
**/	
	function CCompromisoResponsable($id,$compromiso,$nombre,$db){
		$this->id =  $id;
		$this->compromiso =  $compromiso;
		$this->nombre =  $nombre;
		$this->db =$db;
	}
	function getId(){ return	$this->id; }
	function getCompromiso(){ return	$this->compromiso; }
	function getNombre(){ return	$this->nombre; }
/**
** carga los valores de un objeto RESPONSABLE por su id para ser editados
**/
	function loadResponsable(){
			$r = $this->db->getResponsableById($this->id);
			if($r != -1){
				$this->id 			=  $r['cor_id'];
				$this->compromiso 	=  $r['com_id'];
				$this->nombre 		=  $r['doa_nombre'];
			}else{
				$this->id 			=  "";
				$this->compromiso 	= "";
				$this->nombre 		=  "";
			}
	}
/**
** carga los valores de un objeto RESPONSABLE por su id para ser editados
**/
	function loadResponsables(){
		$r = $this->db->getResponsablesCompromisosCheck('1','r.doa_nombre');
		$responsables = null;
		while($row = mysql_fetch_array($r)){
			if($row['id'] == $this->id) $indicador = 1; 
			else $indicador = 0;
			$responsables[count($responsables)]=array('id'=>$row['doa_id'],'nombre'=>$row['doa_nombre']);
		}
		return $responsables;
	}	
/**
** almacena un objeto RESPONSABLE y retorna un mensaje del resultado del proceso
**/				
function saveNewResponsable(){
		$r = $this->db->insertResponsable($this->compromiso,$this->nombre);
		if($r=='true'){
			$msg = RESPONSABLE_AGREGADO;
		}else{
			$msg = ERROR_ADD_RESPONSABLE;
		}	
		return $msg;
	}
/**
** elimina un objeto RESPONSABLE y retorna un mensaje del resultado del proceso
**/				
	function deleteResponsable(){
		$r = $this->db->deleteResponsable($this->id);
		if($r=='true'){
			$msg = RESPONSABLE_BORRADO;		
		}else{
			$msg = ERROR_DEL_RESPONSABLE;
		}
		
		return $msg;
	
	}
/**
** actualiza un objeto RESPONSABLE y retorna un mensaje del resultado del proceso
**/				
	function saveEditResponsable($responsables){
		if (isset($responsables))
			$i = 0;
		foreach($responsables as $r){
			if($i == 0)
			$responsable .= $r['id'];
			else $responsable .= ",".$r['id'];
			$i++;
		}
		$this->db->updateResponsables($this->id,$responsable);
	}
/**
*agrega un nuevo responsable y retorna el resultado del proceso
*@return string
*/
	
}

	
?>