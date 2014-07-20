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
Class CVigenciaData{
    var $db = null;
	
	function CVigenciaData($db){
		$this->db = $db;
	}
	
	function getIngresos($criterio,$orden){
		$des = null;
		$sql = "select * from vigencia_recursos where ". $criterio ." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		//ECHO "<BR>.$sql";
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$des[$cont]['id'] = $w['vir_id'];
				if($w['vir_anticipo']=='S')$des[$cont]['anio'] = VIGENCIA_INGRESOS.' '.$w['vir_anio'].' (Anticipo)';
				else $des[$cont]['anio'] = VIGENCIA_INGRESOS.' '.$w['vir_anio'];
				$des[$cont]['monto'] = $w['vir_monto'];
                                
				$cont++;
			}
		}
		return $des;
	}
	function getEgresos($criterio,$orden){
		$des = null;
		$sql = "select * from vigencia_recursos where ". $criterio ." order by ".$orden;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){ 
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$des[$cont]['id'] = $w['vir_id'];
				if ($w['vir_anticipo']== "S"){
				    $anio = $w['vir_anio'];
					$des[$cont]['anio'] = VIGENCIA_EGRESOS_ANTICIPO.' '.$w['vir_anio'];
					$des[$cont]['monto'] = $w['vir_monto'];
					$sql = "select coalesce(sum(fac_amortiza),0) as amortiza	
								   from factura where ".$criterio;
								   //echo ("<br>sql1:".$sql);
					$rr = $this->db->ejecutarConsulta($sql);
					if($rr){ 
						$cont1 = 0;
						while($x = mysql_fetch_array($rr)){
							$des[$cont]['ejecutado'] = $x['amortiza'];
							$cont1++;
						}
					}	
				}
				else{	
					$anio = $w['vir_anio'];
					$des[$cont]['anio'] = VIGENCIA_EGRESOS.' '.$w['vir_anio'];
					$des[$cont]['monto'] = $w['vir_monto'];
					$sql = "select coalesce(sum(fac_monto),0) as monto,
								   coalesce(sum(fac_amortiza),0) as amortiza					
								   from factura where year(fac_fecha) = ".$anio .' and '.$criterio;
								   //echo ("<br>sql2:".$sql);
					$rr = $this->db->ejecutarConsulta($sql);
					if($rr){ 
						$cont1 = 0;
						while($x = mysql_fetch_array($rr)){
							$des[$cont]['ejecutado'] = $x['monto'] - $x['amortiza'];
							$cont1++;
						}
					}	
					}
				$des[$cont]['porejecutar'] = $des[$cont]['monto'] - $des[$cont]['ejecutado'];
				
				$cont++;
			}
		}
		return $des;
	}
	function getTotalVigencias($criterio){
		$des = null;
		$sql = "select coalesce(sum(vir_monto),0) as monto	
				from vigencia_recursos where ". $criterio;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			while($w = mysql_fetch_array($r)){
				$des['monto'] = $w['monto'];
			}
		}
		return $des;
	}
	
}
?>
	
