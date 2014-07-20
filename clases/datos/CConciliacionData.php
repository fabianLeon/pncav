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
*Usada para todas las funciones de acceso a datos referente a anticipos para el modulo financiero
*
* @package  clases
* @subpackage datos
*/
Class CConciliacionData{
    var $db = null;
	
	function CConciliacionData($db){
		$this->db = $db;
	}
	
	
	function insertConciliacion($concepto,$fecha,$monto,$observaciones,$operador){
		$tabla = "conciliacion";
		$campos = "cnc_id,cnl_fecha,cnl_monto,cnl_observaciones,ope_id";
		$valores = "'".$concepto."','".$fecha."',
					'".$monto."','".$observaciones."','".$operador."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getConciliacionById($id){
		$sql = " select *
				from conciliacion f
				where f.cnl_id = ". $id;
				//echo ("<br>sql:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function updateConciliacion($id,$concepto,$fecha,$monto,$observaciones){
		$tabla = "conciliacion";
		$campos = array('cnc_id','cnl_fecha','cnl_monto','cnl_observaciones');
		$montos = array("'".$concepto."'","'".$fecha."'",$monto,"'".$observaciones."'");
			
		$condicion = "cnl_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	
	function deleteConciliacion($id){
		$tabla = "conciliacion";
		$predicado = "cnl_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	
	function getYearsConciliacion($operador){
		$years = null;
		$sql = "select year(cnl_fecha) as year 
                        from conciliacion 
                        where ope_id = ".$operador."
                        group by year(cnl_fecha) order by year(cnl_fecha)";
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$years[$cont]['id'] = $w['year'];
				$years[$cont]['nombre'] = $w['year'];
				$cont++;
			}
		}
		return $years;
	}
	
	function getMonthsConciliacion($year,$operador){
		$months = null;
		$sql = "select month(cnl_fecha) as m from conciliacion
                    where year(cnl_fecha) = ".$year." and ope_id =".$operador."
				group by month(cnl_fecha) order by month(cnl_fecha)";
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$months[$cont]['id'] = $w['m'];
				$months[$cont]['nombre'] = $w['m'];
				$cont++;
			}
		}
		return $months;
	}
	
	function getConceptos($criterio,$orden){
		$conceptos = null;
		$sql = "select * from concepto_op where ". $criterio ." order by ".$orden;
		//	echo ("<br>sql:".$sql);
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
	
	function getResumenConciliacion($criterio){
		$rubs = null;
		$sql = "select *
				from conciliacion f
				inner join concepto_op r on r.cnc_id = f.cnc_id
				where ".$criterio;
			//	echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);

		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubs[$cont]['id'] = $w['cnl_id'];
				$rubs[$cont]['concepto'] = $w['cnc_nombre'];
				$rubs[$cont]['fecha'] = $w['cnl_fecha'];
				$rubs[$cont]['monto'] = $w['cnl_monto'];
				$rubs[$cont]['observaciones'] = $w['cnl_observaciones'];
				$cont++;
			}
		}
		return $rubs;
	
	}
	
	function getResumen($criterio){
		$rubs = null;
		$sql = "select r.cnc_id as id,
					   r.cnc_nombre as concepto,
					   coalesce(sum(f.cnl_monto),0) as acumulado,
					   (select coalesce(sum(c.cnl_monto),0)
						from conciliacion c
						where c.cnc_id = r.cnc_id and c.ope_id = f.ope_id) as periodo
				from concepto_op r
				left join conciliacion f on r.cnc_id = f.cnc_id
				where ".$criterio."
				group by r.cnc_id
				order by r.cnc_nombre";
				//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);

		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubs[$cont]['id'] = $w['id'];
				$rubs[$cont]['concepto'] = $w['concepto'];
				$rubs[$cont]['acumulado'] = $w['acumulado'];
				$rubs[$cont]['periodo'] = $w['periodo'];
				$cont++;
			}
		}
		return $rubs;
	
	}
	
	function getConciliaciones($criterio,$orden){
		$inv = null;
		$sql = "select f.*, r.cnc_nombre
				from conciliacion1 f
				inner join concepto1 r on f.cnc_id = r.cnc_id 
				where ". $criterio ." order by ".$orden;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$cnl[$cont]['id'] = $w['cnl_id'];
				$cnl[$cont]['fecha'] = $w['cnl_fecha'];
				$cnl[$cont]['monto'] = $w['cnl_monto'];
				$cont++;
			}
		}
		return $cnl;
	}
	
	function getMontoConcepto($criterio){
		$tabla = 'concepto1';
		$campo = 'cnc_monto';
		$predicado = $criterio;
		
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
		
	}
	function getAnticipo($criterio,$criterio_mes){
		$des = null;
		$sql = "select * from vigencia_recursos where ". $criterio;
		
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			while($w = mysql_fetch_array($r)){
				$des['id'] = $w['vir_id'];
				$des['monto'] = $w['vir_monto'];

				$sql = "select coalesce(sum(fac_amortiza),0) as amortiza	
							   from factura1 f where ".$criterio_mes;
							   //echo ("<br>sql:".$sql);
				$rr = $this->db->ejecutarConsulta($sql);
				if($rr){
					while($x = mysql_fetch_array($rr)){
						$des['ejecutado'] = $x['amortiza'];
					}
				}	
		   }
		}   
		return $des;
	}
	function getDesembolsos($anio,$mes,$operador){
		$tabla='inversion';
		$campo='coalesce(sum(inv_monto),0)';
		$predicado='(year(inv_fecha)  <= '. $anio. ' and month(inv_fecha)  <= '. $mes.') or year(inv_fecha)  < '. ($anio-1) .' and ope_id='.$operador;
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
	}
	function getTotalConciliacion($anio,$mes,$operador){
		$tabla='conciliacion';
		$campo='coalesce(sum(cnl_monto),0)';
		$predicado='(year(cnl_fecha)  <= '. $anio. ' and month(cnl_fecha)  <= '. $mes.') or year(cnl_fecha)  < '. ($anio-1) .' and ope_id='.$operador;
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
	}
}
?>