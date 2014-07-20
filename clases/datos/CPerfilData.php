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
* Clase PerfilData
* Usada para la definicion de todas las funciones propias del objeto PERFIL

* @package  clases
* @subpackage datos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/
Class CPerfilData{
    var $db = null;
	
	function CPerfilData($db){
		$this->db = $db;
	}
	
	function getPerfiles($criterio,$orden){
		$perfiles = null;
		$sql = "select * from perfil where ". $criterio ." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$perfiles[$cont]['id'] = $w['per_id'];
				$perfiles[$cont]['nombre'] = $w['per_nombre'];
				
				$cont++;
			}
		}
		return $perfiles;
	}
	
	
	function insertPerfil($nombre){
		$tabla = "perfil";
		$campos = "per_nombre";
		$valores = "'".$nombre."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function updatePerfil($id,$nombre){
		$tabla = "perfil";
		$campos = array('per_nombre');
		$valores = array("'".$nombre."'");
		$condicion = "per_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function deletePerfil($id){
		$tabla = "perfil";
		$predicado = "per_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function deletePerfilOpciones($id){
		$tabla = "perfil_x_opcion";
		$predicado = "per_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function getPerfilById($id){
		$perfil = null;
		$sql = "select * 
				from perfil 
				where per_id = ". $id;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r){
			$perfil["id"] = $r["per_id"]; 
			$perfil["nombre"] = $r["per_nombre"];
			return $perfil; 
		}else{ 
			return -1;
		}
	}

	function insertPerfilOpcion($id_perfil,$id_opcion,$nivel){
		$tabla = "perfil_x_opcion";
		$campos = "per_id,opc_id,pxo_nivel";
		$valores = $id_perfil.",".$id_opcion.",".$nivel;
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getContadorPerfilByNombre($var){
		$cont = 0;
		$cont = $this->db->recuperarCampo('perfil','count(1)',"per_nombre = '".$var."'");
		return $cont;
	}
	
	function getContadorPerfilUsuarios($var){
		$cont = 0;
		$cont = $this->db->recuperarCampo('usuario','count(1)',"per_id = '".$var."'");
		return $cont;
	}
	
	function loadPerfilOpciones($id){
		$sql = "select o.opc_id,o.opc_nombre,o.opn_id,p.per_id,p.pxo_nivel
				from opcion o
				left join perfil_x_opcion p on p.opc_id = o.opc_id and p.per_id = ".$id."
				order by o.opc_orden";		
		$r = $this->db->ejecutarConsulta($sql);
		return $r;
	}
	
}
?>
