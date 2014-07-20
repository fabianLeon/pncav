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
Class CFacturaData{
    var $db = null;
	
	function CFacturaData($db){
		$this->db = $db;
	}
	
	function getFacturas($criterio,$orden){
		$fac = null;
		$sql = "select f.*, r.fac_descripcion
				from factura1 f
				inner join rubro1 r on f.fac_descripcion = r.fac_descripcion 
				where ". $criterio ." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$fac[$cont]['id'] = $w['fac_id'];
				$fac[$cont]['descripcion'] = $w['fac_descripcion'];
				$fac[$cont]['rubro_nombre'] = $w['fac_descripcion'];
				$fac[$cont]['fecha'] = $w['fac_fecha'];
				$fac[$cont]['proveedor'] = $w['fac_proveedor'];
				$fac[$cont]['documento_proveedor'] = $w['fac_documento_proveedor'];
				$fac[$cont]['monto'] = $w['fac_monto'];
				$fac[$cont]['amortiza'] = $w['fac_amortiza'];
				$fac[$cont]['numero'] = $w['fac_numero'];
				$cont++;
			}
		}
		return $fac;
	}
	
	function getResumenFactura($criterio,$orden,$contrato,$anticipo,$nombreOPerador){
		$fac = null;
		$sql = "select *
				from factura f
				where ". $criterio ." order by ".$orden;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
                
                $ruta = str_replace(getcwd(),'.',(RUTA_FACTURAS."/".$nombreOPerador));
                
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$fac[$cont]['id'] = $w['fac_id'];
				$fac[$cont]['numero'] = $w['fac_numero'];
				$fac[$cont]['fecha'] = $w['fac_fecha'];
				$fac[$cont]['descripcion'] = $w['fac_descripcion'];
				$fac[$cont]['factura'] = ($w['fac_monto']-$w['fac_amortiza']);	
				if ($cont==0){
					$fac[$cont]['saldo'] = $contrato - $anticipo - ($w['fac_monto']-$w['fac_amortiza']);	
					}
				else{
					$fac[$cont]['saldo'] = $saldo - ($w['fac_monto']-$w['fac_amortiza']);	
					}
				$saldo=	$fac[$cont]['saldo'];	
				$fac[$cont]['monto'] = $w['fac_monto'];
				$fac[$cont]['amortiza'] = $w['fac_amortiza'];
				if ($cont==0){
					$fac[$cont]['saldo_anticipo'] = $anticipo -$w['fac_amortiza'];	
					}
				else{
					$fac[$cont]['saldo_anticipo'] = $saldo_anticipo - $w['fac_amortiza'];	
					}
				$saldo_anticipo=	$fac[$cont]['saldo_anticipo'];	
				$fac[$cont]['observaciones'] = $w['fac_observaciones'];
				$fac[$cont]['documento'] = "<a href='".$ruta."/".$w['fac_documento']."' target='_blank'>".$w['fac_documento']."</a>";                                
				$cont++;
			}
		}
		return $fac;
	}
	
	
	function getAnticipo($criterio,$orden){
		$contrato = null;
		$sql = "select * from vigencia_recursos where ". $criterio ." order by ".$orden;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			while($w = mysql_fetch_array($r)){
				$contrato['id'] = $w['vir_id'];
				$contrato['valor'] = $w['vir_monto'];
                                $contrato['anio'] = $w['vir_anio'];
			}
		}
		return $contrato;
	}
	
	function insertFactura($descripcion,$fecha,$proveedor,$documento_proveedor,$monto,$amortiza,$numero,$observaciones,$documento,$operador){
		$tabla = "factura";
		$campos = "fac_descripcion,fac_fecha,fac_proveedor,fac_documento_proveedor,fac_monto,fac_amortiza,
					fac_numero,fac_observaciones,fac_documento,ope_id";
		$valores = "'".$descripcion."','".$fecha."','".$proveedor."','".$documento_proveedor."',
					'".$monto."','".$amortiza."','".$numero."','".$observaciones."','".$documento."','".$operador."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getFacturaById($id){
		$sql = " select *
				from factura f
				where f.fac_id = ". $id;
				//echo ("<br>sql:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function updateFactura($id,$descripcion,$fecha,$proveedor,$documento_proveedor,$monto,$amortiza,
							$numero,$observaciones){
		$tabla = "factura";
		$campos = array('fac_descripcion','fac_fecha','fac_proveedor','fac_documento_proveedor','fac_monto','fac_amortiza',
						'fac_numero','fac_observaciones');
		$montos = array("'".$descripcion."'","'".$fecha."'","'".$proveedor."'","'".$documento_proveedor."'",$monto,$amortiza,
						"'".$numero."'","'".$observaciones."'");
			
		$condicion = "fac_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	
	function updateFacturaArchivo($id,$descripcion,$fecha,$proveedor,$documento_proveedor,$monto,$amortiza,
							$numero,$observaciones,$documento){
		$tabla = "factura";
		$campos = array('fac_descripcion','fac_fecha','fac_proveedor','fac_documento_proveedor','fac_monto','fac_amortiza',
						'fac_numero','fac_observaciones','fac_documento');
		$montos = array("'".$descripcion."'","'".$fecha."'","'".$proveedor."'","'".$documento_proveedor."'",$monto,$amortiza,
						"'".$numero."'","'".$observaciones."'","'".$documento."'");
			
		$condicion = "fac_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	
	function deleteFactura($id){
		$tabla = "factura";
		$predicado = "fac_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	
	function getYearsFactura(){
		$years = null;
		$sql = "select year(fac_fecha) as year from factura1 group by year(fac_fecha) order by year(fac_fecha)";
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
	
	function getMonthsFactura($year){
		$months = null;
		$sql = "select month(fac_fecha) as m from factura1 where year(fac_fecha) = ".$year."
				group by month(fac_fecha) order by month(fac_fecha)";
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
	
	
}
?>