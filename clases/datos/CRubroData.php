<?php
/**
*/
Class CRubroData{
    var $db = null;
	
	function CRubroData($db){
		$this->db = $db;
	}
	
// actividades o rubros para el plan de inversion	
	function insertRubro($nombre,$monto,$operador){
		$tabla = "rubro";
		$campos = "rub_nombre,rub_monto,ope_id";
		$valores = "'".$nombre."','".$monto."','".$operador."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getRubroIdByNombre($nombre){
		$sql = " select *
				from rubro1 r
				where r.rub_nombre = ". $nombre;
				//echo ("<br>sql:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function getRubroById($id){
		$rubros=null;
		$sql = "select * from rubro where rub_id=". $id;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubros['id'] = $w['rub_id'];
				$rubros['nombre'] = $w['rub_nombre'];
				$rubros['monto'] = $w['rub_monto'];
				$cont++;
			}
		}
		return $rubros;
	}
	
	function updateRubro($id,$nombre,$monto){
		$tabla = "rubro";
		$campos = array('rub_nombre','rub_monto');
		$montos = array("'".$nombre."'","'".$monto."'");
			
		$condicion = "rub_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	
	function deleteRubro($id){
		$tabla = "rubro";
		$predicado = "rub_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function getRubros($criterio,$orden){
		$rubros = null;
		$sql = "select * from rubro where ". $criterio ." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubros[$cont]['id'] = $w['rub_id'];
				$rubros[$cont]['nombre'] = $w['rub_nombre'];
				$rubros[$cont]['monto'] = $w['rub_monto'];
				$cont++;
			}
		}
		return $rubros;
	}
// actividades o rubros para las ordenes de pago	
	function insertRubroOP($operador,$nombre,$monto){
		$tabla = "rubro_op";
		$campos = "ope_id,rub_nombre,rub_monto";
		$valores = "'".$operador."','".$nombre."','".$monto."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}

	function getRubroOPById($id){
		$rubros=null;
		$sql = "select * from rubro_op where rub_id=". $id;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubros['id'] = $w['rub_id'];
				$rubros['nombre'] = $w['rub_nombre'];
				$rubros['monto'] = $w['rub_monto'];
				$cont++;
			}
		}
		return $rubros;
	}
	
	function updateRubroOP($id,$nombre,$monto){
		$tabla = "rubro_op";
		$campos = array('rub_nombre','rub_monto');
		$montos = array("'".$nombre."'","'".$monto."'");
			
		$condicion = "rub_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	
	function deleteRubroOP($id){
		$tabla = "rubro_op";
		$predicado = "rub_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function getRubrosOP($operador,$criterio,$orden){
		$rubros = null;
		$sql = "select * from rubro_op where ". $criterio ." and ope_id=".$operador." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubros[$cont]['id'] = $w['rub_id'];
				$rubros[$cont]['nombre'] = $w['rub_nombre'];
				$rubros[$cont]['monto'] = $w['rub_monto'];
				$cont++;
			}
		}
		return $rubros;
	}			
}
?>