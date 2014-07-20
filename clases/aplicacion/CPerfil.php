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
* Clase Perfil
*
* @package  clases
* @subpackage aplicacion
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/

class CPerfil{
	var $id = null;
	var $nombre = null;
	var $dper = null;
/**
** Constructor de la clase CPerfilData
**/				
	function CPerfil($dper){	$this->dper = $dper;	}
	function getId(){			return $this->id;		}
	function getNombre(){		return $this->nombre;	}

	function setId($id){		$this->id = $id;		}
	function setNombre($nombre){$this->nombre = $nombre;}
/**
** carga los valores de un objeto PERFIL por su id para ser editados
**/					
	function loadPerfil(){
		$r = $this->dper->getPerfilById($this->id);
		if($r != -1){
			$this->nombre = $r["nombre"];
		}else{
			$this->nombre = "";
		}
	}
/**
** almacena un objeto PERFIL y retorna un mensaje del resultado del proceso
**/		
	function saveNewPerfil(){
		$cont = $this->dper->getContadorPerfilByNombre($this->nombre);
		if($cont == 0){
			$r = $this->dper->insertPerfil($this->nombre);
			if($r=='true'){
				$msg = PERFIL_AGREGADO;
			}else{
				$msg = ERROR_ADD_PERFIL;
			}
		}else{
			$msg = ERROR_ADD_PERFIL;
		}
		return $msg;
	}
/**
** elimina un objeto PERFIL y retorna un mensaje del resultado del proceso
**/		
	function deletePerfil(){
		$cont = $this->dper->getContadorPerfilUsuarios($this->id);
		if($cont == 0){
			$r = $this->dper->deletePerfilOpciones($this->id);
			$r = $this->dper->deletePerfil($this->id);
			if($r=='true'){
				$msg = PERFIL_BORRADO;		
			}else{
				$msg = ERROR_DEL_PERFIL;
			}
		}else{
			$msg = ERROR_DEL_PERFIL_USUARIOS;
		}
		return $msg;
	}
/**
** actualiza un objeto PERFIL y retorna un mensaje del resultado del proceso
**/		
	function saveEditPerfil(){
		$cont = $this->dper->getContadorPerfilByNombre($this->nombre);
		if($cont == 0){
			$r = $this->dper->updatePerfil($this->id,$this->nombre);
			if($r=='true'){
				$msg = PERFIL_EDITADO;
			}else{
				$msg = ERROR_EDIT_PERFIL;
			}
		}else{
			$msg = ERROR_EDIT_PERFIL;
		}
		return $msg;
	}
/**
** carga las opciones de un objeto PERFIL
**/		
	function loadPerfilOpciones(){
		$r = $this->dper->loadPerfilOpciones($this->id);
		$opc = null;
		while($row = mysql_fetch_array($r)){
			if($row['per_id'] == $this->id) $indicador = 1; else $indicador = 0;
			$opc[count($opc)]=array('id'=>$row['opc_id'],
					   	'nombre'=>$row['opc_nombre'],
						'nivel'=>$row['opn_id'],
  						'indicador'=>$indicador,
  						'acceso'=>$row['pxo_nivel']);
		}
		return $opc;
	}	
/**
** actualiza las opciones de un objeto PERFIL
**/		
	function saveEditPerfilOpciones($options){
		$r = $this->dper->deletePerfilOpciones($this->id);
		foreach($options as $o){
			$this->dper->insertPerfilOpcion($this->id,$o['id'],$o['nivel']);
		}
	}
}
?>