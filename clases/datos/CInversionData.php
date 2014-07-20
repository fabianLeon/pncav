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
Class CInversionData{
    var $db = null;
	
	function CInversionData($db){
		$this->db = $db;
	}
	
	
	function insertInversion($rubro,$fecha,$proveedor,$documento_proveedor,$monto,$observaciones,$documento,$operador){
		$tabla = "inversion";
		$campos = "rub_id,inv_fecha,inv_proveedor,inv_documento_proveedor,inv_monto,inv_observaciones,inv_documento,ope_id";
		$valores = "'".$rubro."','".$fecha."','".$proveedor."','".$documento_proveedor."',
					'".$monto."','".$observaciones."','".$documento."','".$operador."'";
	
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getInversionById($id){
		$sql = " select *
				from inversion f
				where f.inv_id = ". $id;
				//echo ("<br>sql:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function updateInversion($id,$rubro,$fecha,$proveedor,$documento_proveedor,$monto,$observaciones){
		$tabla = "inversion1";
		$campos = array('rub_id','inv_fecha','inv_proveedor','inv_documento_proveedor','inv_monto','inv_observaciones');
		$montos = array("'".$rubro."'","'".$fecha."'","'".$proveedor."'","'".$documento_proveedor."'",$monto,"'".$observaciones."'");
			
		$condicion = "inv_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	function updateInversionArchivo($id,$rubro,$fecha,$proveedor,$documento_proveedor,$monto,$observaciones,$documento){
		$tabla = "inversion";
		$campos = array('rub_id','inv_fecha','inv_proveedor','inv_documento_proveedor','inv_monto','inv_observaciones','inv_documento');
		$montos = array("'".$rubro."'","'".$fecha."'","'".$proveedor."'","'".$documento_proveedor."'",$monto,"'".$observaciones."'","'".$documento."'");
			
		$condicion = "inv_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	
	
	
	function deleteInversion($id){
		$tabla = "inversion";
		$predicado = "inv_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	
	function getYearsInversion($operador){
		$years = null;
		$sql = "select year(inv_fecha) as year 
                        from inversion 
                        where ope_id = ".$operador."
                        group by year(inv_fecha) order by year(inv_fecha)";                
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
	
	function getMonthsInversion($year,$operador){
		$months = null;
		$sql = "select month(inv_fecha) as m from inversion where year(inv_fecha) = ".$year." and ope_id = ".$operador."
				group by month(inv_fecha) order by month(inv_fecha)";
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
	
	function getRubros($criterio,$orden){
		$rubros = null;
		$sql = "select * from rubro where ". $criterio ." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubros[$cont]['id'] = $w['rub_id'];
				$rubros[$cont]['nombre'] = $w['rub_nombre'];
				$cont++;
			}
		}
		return $rubros;
	}
	
	function getResumenInversion($criterio){
		$rubs = null;
		$sql = "select *
				from inversion f
				inner join rubro r on r.rub_id = f.rub_id
				where ".$criterio;
				//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);

		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubs[$cont]['id'] = $w['inv_id'];
				$rubs[$cont]['rubro'] = $w['rub_nombre'];
				$rubs[$cont]['proveedor'] = $w['inv_proveedor'];
				$rubs[$cont]['documento'] = $w['inv_documento_proveedor'];
				$rubs[$cont]['fecha'] = $w['inv_fecha'];
				$rubs[$cont]['monto'] = $w['inv_monto'];
				$rubs[$cont]['observaciones'] = $w['inv_observaciones'];
				//$rubs[$cont]['documento'] = $w['inv_documento'];
				$cont++;
			}
		}
		return $rubs;
	
	}
	
	function getResumen($criterio){
		$rubs = null;
		$sql = "select r.rub_id as id,
					   r.rub_nombre as rubro,
					   coalesce(sum(f.inv_monto),0) as acumulado,
					   (select coalesce(sum(inv_monto),0)
						from inversion
						where rub_id = r.rub_id) as periodo
				from rubro r
				left join inversion f on r.rub_id = f.rub_id
				where ".$criterio."
				group by r.rub_id
				order by r.rub_nombre";
			//	echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);

		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubs[$cont]['id'] = $w['id'];
				$rubs[$cont]['rubro'] = $w['rubro'];
				$rubs[$cont]['acumulado'] = $w['acumulado'];
				$rubs[$cont]['periodo'] = $w['periodo'];
				$cont++;
			}
		}
		return $rubs;
	
	}
	
	function getInversiones($criterio,$orden){
		$inv = null;
		$sql = "select f.*, r.rub_nombre
				from inversion f
				inner join rubro r on f.rub_id = r.rub_id 
				where ". $criterio ." order by ".$orden;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$inv[$cont]['id'] = $w['inv_id'];
				//echo ("<br>id:".$inv[$cont]['id']);
				$inv[$cont]['proveedor'] = $w['inv_proveedor'];
				$inv[$cont]['documento'] = $w['inv_documento_proveedor'];
				$inv[$cont]['fecha'] = $w['inv_fecha'];
				$inv[$cont]['monto'] = $w['inv_monto'];
				$cont++;
			}
		}
		return $inv;
	}
	
	function getMontoRubro($criterio){
		$tabla = 'rubro';
		$campo = 'rub_monto';
		$predicado = $criterio;
		
		
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
		
	}
	function getCuadroResumen($operador){
		$rubs = null;
		$sql = "SELECT i.rub_id,r.rub_nombre,r.rub_monto as vigente,sum(inv_monto) as acumulado,r.rub_monto-sum(inv_monto) as diferencia 
				FROM inversion i
				inner join rubro r on r.rub_id=i.rub_id 
				WHERE r.ope_id =".$operador." 
                                group by i.rub_id";
				//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		$vigente= 0;
		$acumulado= 0;
		$diferencia=0;
		
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rubs[$cont]['id'] = $w['id'];
				$rubs[$cont]['rubro'] = $w['rub_nombre'];
				$rubs[$cont]['vigente'] = $w['vigente'];
				$vigente += $w['vigente'];
				$rubs[$cont]['acumulado'] = $w['acumulado'];
				$acumulado += $w['acumulado'];
				$rubs[$cont]['diferencia'] = $w['diferencia'];
				$diferencia += $w['diferencia'];
				$rubs[$cont]['por_acumulado'] = $w['acumulado']/$w['vigente']*100;
				$rubs[$cont]['por_diferencia'] = 100-$w['acumulado']/$w['vigente']*100;
				$cont++;
			}
		}
		/*$rubs[$cont]['id'] = $cont;
		$rubs[$cont]['rubro'] = 'Total';
		$rubs[$cont]['vigente'] = $vigente;
		$rubs[$cont]['acumulado'] = $acumulado;
		$rubs[$cont]['diferencia'] = $diferencia;
		$rubs[$cont]['por_acumulado'] = $acumulado/$vigente*100;
		$rubs[$cont]['por_diferencia'] = 100-$acumulado/$vigente*100;*/
		return $rubs;
	
	}
}
?>