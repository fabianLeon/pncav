<?php
/**
*/
Class CModalidadData{
    var $db = null;
	
	function CModalidadData($db){
		$this->db = $db;
	}
	
	//modalidades del plan de compras
	function insertModalidadOP($operador,$nombre){
		$tabla = "modalidad_op";
		$campos = "ope_id,mod_nombre";
		$valores = "'".$operador."','".$nombre."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getModalidadOPById($id){
		$modalidades=null;
		$sql = "select * from modalidad_op where mod_id=". $id;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$modalidades['id'] = $w['mod_id'];
				$modalidades['nombre'] = $w['mod_nombre'];
				$cont++;
			}
		}
		return $modalidades;
	}
	
	function updateModalidadOP($id,$nombre){
		$tabla = "modalidad_op";
		$campos = array('mod_nombre');
		$valores = array("'".$nombre."'");
			
		$condicion = "mod_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function deleteModalidadOP($id){
		$tabla = "modalidad_op";
		$predicado = "mod_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
		
		
	function getModalidadesOP($operador,$criterio,$orden){
		$modalidades = null;
		$sql = "select * from modalidad_op where ". $criterio ." and ope_id=".$operador." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$modalidades[$cont]['id'] = $w['mod_id'];
				$modalidades[$cont]['nombre'] = $w['mod_nombre'];
				$cont++;
			}
		}
		return $modalidades;
	}
}
?>