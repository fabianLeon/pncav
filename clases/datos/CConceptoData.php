<?php
/**
*/
Class CConceptoData{
    var $db = null;
	
	function CConceptoData($db){
		$this->db = $db;
	}
	
	function insertConcepto($nombre){
		$tabla = "concepto1";
		$campos = "cnc_nombre";
		$valores = "'".$nombre."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getConceptoIdByNombre($nombre){
		$sql = " select *
				from concepto1 r
				where r.cnc_nombre = ". $nombre;
				//echo ("<br>sql:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function getConceptoById($id){
		$conceptos=null;
		$sql = "select * from concepto1 where cnc_id=". $id;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$conceptos['id'] = $w['cnc_id'];
				$conceptos['nombre'] = $w['cnc_nombre'];
				$cont++;
			}
		}
		return $conceptos;
	}
	
	function updateConcepto($id,$nombre){
		$tabla = "concepto1";
		$campos = array('cnc_nombre');
		$valores = array("'".$nombre."'");
			
		$condicion = "cnc_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function deleteConcepto($id){
		$tabla = "concepto1";
		$predicado = "cnc_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
		
		
	function getConceptos($criterio,$orden){
		$conceptos = null;
		$sql = "select * from concepto1 where ". $criterio ." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$conceptos[$cont]['id'] = $w['cnc_id'];
				$conceptos[$cont]['nombre'] = $w['cnc_nombre'];
				$cont++;
			}
		}
		return $conceptos;
	}
	//conceptos del plan de compras
	function insertConceptoOP($operador,$nombre){
		$tabla = "concepto_op";
		$campos = "ope_id,cnc_nombre";
		$valores = "'".$operador."','".$nombre."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getConceptoOPById($id){
		$conceptos=null;
		$sql = "select * from concepto_op where cnc_id=". $id;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$conceptos['id'] = $w['cnc_id'];
				$conceptos['nombre'] = $w['cnc_nombre'];
				$cont++;
			}
		}
		return $conceptos;
	}
	
	function updateConceptoOP($id,$nombre){
		$tabla = "concepto_op";
		$campos = array('cnc_nombre');
		$valores = array("'".$nombre."'");
			
		$condicion = "cnc_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function deleteConceptoOP($id){
		$tabla = "concepto_op";
		$predicado = "cnc_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
		
		
	function getConceptosOP($operador,$criterio,$orden){
		$conceptos = null;
		$sql = "select * from concepto_op where ". $criterio ." and ope_id=".$operador." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$conceptos[$cont]['id'] = $w['cnc_id'];
				$conceptos[$cont]['nombre'] = $w['cnc_nombre'];
				$cont++;
			}
		}
		return $conceptos;
	}
}
?>