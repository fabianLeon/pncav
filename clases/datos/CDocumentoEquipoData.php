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
* Clase DocumentoEquipoData
* Usada para la definicion de todas las funciones propias del objeto DOCUMENTO_EQUIPO
*
* @package  clases
* @subpackage datos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/
Class CDocumentoEquipoData{
    var $db = null;
	
	function CDocumentoEquipoData($db){
		$this->db = $db;
	}
	
	function getEquipos($criterio,$orden){
		$equipo = null;
		$sql = "select d.deq_id,
					   d.usu_id,
					   concat(us.usu_nombre,' ',us.usu_apellido) as responsable,d.deq_controla_alarmas
				from documento_equipo d
				inner join documento_actor da on d.doa_id = da.doa_id 
				inner join usuario us on d.usu_id = us.usu_id 
				where ". $criterio ." 
				order by ".$orden;
		//echo "get equipos".$sql;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$equipo[$cont]['id'] = $w['deq_id'];
				$equipo[$cont]['responsable'] = $w['responsable'];
				$equipo[$cont]['controla_alarmas'] = $w['deq_controla_alarmas'];
				$cont++;
			}
		}
		return $equipo;
	}
	function getEquipoById($id){
		$sql = "select d.deq_id, 
					da.doa_nombre, d.usu_id,
					us.usu_apellido, us.usu_nombre
				from documento_equipo d
				inner join documento_actor da on d.doa_id = da.doa_id 
				left join usuario us on d.usu_id = us.usu_id
				where d.deq_id = ". $id;
				//echo ($sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function insertEquipo($actor,$responsable,$controla_alarmas){
		$tabla = "documento_equipo";
		$campos = "doa_id,usu_id,deq_controla_alarmas";
		$valores = "'".$actor."','".$responsable."','".$controla_alarmas."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function deleteEquipo($id){
		$tabla = "documento_equipo";
		$predicado = "deq_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
}