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
*Usada para todas las funciones de acceso a datos referente a extractos para el modulo financiero
*
* @package  clases
* @subpackage datos
*/
Class CExtractoData{
    var $db = null;
	
	function CExtractoData($db){
		$this->db = $db;
	}
	
	
	function insertExtracto($anio,$mes,$monto,$documento,$operador){
		$tabla = "extracto";
		$campos = "ext_anio,ext_mes,ext_monto,ext_documento,ope_id";
		$valores = "'".$anio."','".$mes."','".$monto."','".$documento."','".$operador."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getExtractoIdByAnio($anio,$mes){
		$sql = " select *
				from extracto1 r
				where r.ext_anio = ". $anio." and r.ext_mes=".$mes;
				//echo ("<br>sql:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function getExtractoById($id){
		$extractos=null;
		$sql = "select * from extracto where ext_id=". $id;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$extractos['id'] = $w['ext_id'];
				$extractos['anio'] = $w['ext_anio'];
				$extractos['mes'] = $w['ext_mes'];
				$extractos['monto'] = $w['ext_monto'];
				$extractos['documento'] = $w['ext_documento'];
				$cont++;
			}
		}
		return $extractos;
	}
	
	function updateExtracto($id,$anio,$mes,$monto){
		$tabla = "extracto";
		$campos = array('ext_anio','ext_mes','ext_monto');
		$montos = array("'".$anio."'","'".$mes."'","'".$monto."'");
			
		$condicion = "ext_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	function updateExtractoArchivo($id,$anio,$mes,$monto,$documento){
		$tabla = "extracto";
		$campos = array('ext_anio','ext_mes','ext_monto','ext_documento');
		$montos = array("'".$anio."'","'".$mes."'","'".$monto."'","'".$documento."'");
			
		$condicion = "ext_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	
	function deleteExtracto($id){
		$tabla = "extracto";
		$predicado = "ext_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function getExtractos($criterio,$orden,$nombreOperador){
		$extractos = null;
		$sql = "select * from extracto where ". $criterio ." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
                $ruta = str_replace(getcwd(),'.',(RUTA_EXTRACTO."/".$nombreOperador));
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$extractos[$cont]['id'] = $w['ext_id'];
				$extractos[$cont]['anio'] = $w['ext_anio'];
				$extractos[$cont]['mes'] = $w['ext_mes'];
				$extractos[$cont]['monto'] = $w['ext_monto'];
				$extractos[$cont]['documento'] ="<a href='".$ruta."/".$w['ext_documento']."' target='_blank'>".$w['ext_documento']."</a>";
				$cont++;
			}
		}
		return $extractos;
	}
	function getExtractosByMes($anio,$mes,$operador){
		$extracto = null;
		$sql = "select * from extracto where ext_anio=". $anio ." and ext_mes= ".$mes.' and ope_id='.$operador;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$extracto['id'] = $w['ext_id'];
				$extracto['anio'] = $w['ext_anio'];
				$extracto['mes'] = $w['ext_mes'];
				$extracto['monto'] = $w['ext_monto'];
				$cont++;
			}
		}
		return $extracto;
	}		
}
?>