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
Class CRendimientoFinancieroInterventoriaData{
    var $db = null;
    /*rfi_id
    cfi_id
    rfi_mes
    rfi_anio
    rfi_rendimiento_financiero
    rfi_descuentos
    rfi_rendimiento_consignado
    rfi_rendimiento_acumulado
    rfi_rentabilidad_tasa
    rfi_fecha_consignacion
    rfi_comprobante_consignacion
    rfi_comprobante_emision
    rfi_valor_fiduciaria
    erf_id
    rfi_observaciones*/
	
	function __construct($db){
		$this->db = $db;
	}
	
	
	function insertRendimiento($rendimiento){
		$tabla = "rendimiento_financiero_int";
		$campos = "cfi_id, rfi_mes, rfi_anio, 
                    rfi_rendimiento_financiero, rfi_descuentos, rfi_rendimiento_consignado, 
                    rfi_rendimiento_acumulado, rfi_rentabilidad_tasa, rfi_fecha_consignacion, 
                    rfi_comprobante_consignacion, rfi_comprobante_emision, rfi_valor_fiduciaria,
                    erf_id, rfi_observaciones";
		$valores = "'".$rendimiento->cuenta."','".$rendimiento->mes."','".$rendimiento->anio."','".
                    $rendimiento->rendimiento_financiero."','".$rendimiento->descuentos."','".$rendimiento->rendimiento_consignado."','". 
                    $rendimiento->rendimiento_acumulado."','".$rendimiento->rentabilidad_tasa."','".$rendimiento->fecha_consignacion."','". 
                    $rendimiento->comprobante_consignacion."','".$rendimiento->comprobante_emision."','".$rendimiento->valor_fiduciaria."','".
                    $rendimiento->estado."','".$rendimiento->observaciones."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
        
        function getSaldoFinalByFecha($cuenta,$mes,$anio){
            $sql = "select efi_saldo_final as saldo
                    from extracto_financiero_int 
                    where cfi_id = ". $cuenta ." and efi_mes=". $mes . " and efi_anio = ". $anio;
            //echo $sql;
            $r = $this->db->ejecutarConsulta($sql);
            if($r){
                $w = mysql_fetch_array($r);
                return $w['saldo'];
            }else{
                return 0;
            }
        }
        
        function getSaldoConsignadoByFecha($cuenta,$mes,$anio){
            $sql = "select sum(rfi_rendimiento_consignado) as saldo
                    from rendimiento_financiero_int
                    where cfi_id = ". $cuenta ." and rfi_mes<=". $mes . " and rfi_anio = ". $anio;
            //echo $sql;
            $r = $this->db->ejecutarConsulta($sql);
            if($r){
                $w = mysql_fetch_array($r);
                return $w['saldo'];
            }else{
                return 0;
            }
        }
                
	function getRendimientoById($id){
		$rendimientos=null;
		$sql = "select r.rfi_id, r.cfi_id, c.cfi_nombre,
                                c.cfi_numero, r.rfi_mes, r.rfi_anio,
                                r.rfi_rendimiento_financiero, r.rfi_descuentos, r.rfi_rendimiento_consignado,
                                r.rfi_rendimiento_acumulado, r.rfi_rentabilidad_tasa, r.rfi_fecha_consignacion,
                                r.rfi_comprobante_consignacion, r.rfi_comprobante_emision, r.rfi_valor_fiduciaria,
                                e.erf_id, e.erf_nombre, r.rfi_observaciones 
                        from rendimiento_financiero_int r 
                        inner join cuentas_financiero c on c.cfi_id = r.cfi_id
                        inner join estado_rendimiento_financiero e on e.erf_id = r.erf_id
                        where rfi_id=". $id;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rendimientos['id'] = $w['rfi_id'];
                                $rendimientos['cuenta'] = $w['cfi_id'];
                                $rendimientos['cuenta_nombre'] = $w['cfi_nombre'];
                                $rendimientos['cuenta_numero'] = $w['cfi_numero'];
                                $rendimientos['mes'] = $w['rfi_mes'];
				$rendimientos['anio'] = $w['rfi_anio'];
				$rendimientos['rendimiento_financiero'] = $w['rfi_rendimiento_financiero'];
                                $rendimientos['descuentos'] = $w['rfi_descuentos'];
                                $rendimientos['rendimiento_consignado'] = $w['rfi_rendimiento_consignado'];
                                $rendimientos['rendimiento_acumulado'] = $w['rfi_rendimiento_acumulado'];
                                $rendimientos['rentabilidad_tasa'] = $w['rfi_rentabilidad_tasa'];
                                $rendimientos['fecha_consignacion'] = $w['rfi_fecha_consignacion'];
				$rendimientos['comprobante_consignacion'] = $w['rfi_comprobante_consignacion'];
                                $rendimientos['comprobante_emision'] = $w['rfi_comprobante_emision'];
                                $rendimientos['valor_fiduciaria'] = $w['rfi_valor_fiduciaria'];
                                $rendimientos['estado'] = $w['erf_id'];
                                $rendimientos['estado_nombre'] = $w['erf_nombre'];
                                $rendimientos['observaciones'] = $w['rfi_observaciones'];
				$cont++;
			}
		}
		return $rendimientos;
	}
	
	function updateRendimiento($rendimiento){
		$tabla = "rendimiento_financiero_int";
		$campos = array('rfi_id', 'cfi_id', 'rfi_mes', 'rfi_anio', 
                    'rfi_rendimiento_financiero', 'rfi_descuentos', 'rfi_rendimiento_consignado', 
                    'rfi_rendimiento_acumulado', 'rfi_rentabilidad_tasa', 'rfi_fecha_consignacion', 
                    'rfi_comprobante_consignacion', 'rfi_comprobante_emision', 'rfi_valor_fiduciaria',
                    'erf_id', 'rfi_observaciones');
		$montos = array("'".$rendimiento->id."'","'".$rendimiento->cuenta."'","'".$rendimiento->mes."'","'".$rendimiento->anio."'","'".
                    $rendimiento->rendimiento_financiero."'","'".$rendimiento->descuentos."'","'".$rendimiento->rendimiento_consignado."'","'". 
                    $rendimiento->rendimiento_acumulado."'","'".$rendimiento->rentabilidad_tasa."'","'".$rendimiento->fecha_consignacion."'","'". 
                    $rendimiento->comprobante_consignacion."'","'".$rendimiento->comprobante_emision."'","'".$rendimiento->valor_fiduciaria."'","'".
                    $rendimiento->estado."'","'".$rendimiento->observaciones."'");
			
		$condicion = "rfi_id = ".$rendimiento->id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	
	function deleteRendimiento($id){
		$tabla = "rendimiento_financiero_int";
		$predicado = "rfi_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function getRendimientos($criterio,$orden){
		$rendimientos=null;
		$sql = "select r.rfi_id, r.cfi_id, c.cfi_nombre,
                                c.cfi_numero, r.rfi_mes, r.rfi_anio,
                                r.rfi_rendimiento_financiero, r.rfi_descuentos, r.rfi_rendimiento_consignado,
                                r.rfi_rendimiento_acumulado, r.rfi_rentabilidad_tasa, r.rfi_fecha_consignacion,
                                r.rfi_comprobante_consignacion, r.rfi_comprobante_emision, r.rfi_valor_fiduciaria,
                                e.erf_id, e.erf_nombre, r.rfi_observaciones 
                        from rendimiento_financiero_int r 
                        inner join cuentas_financiero c on c.cfi_id = r.cfi_id
                        inner join estado_rendimiento_financiero e on e.erf_id = r.erf_id
                        where ". $criterio ." order by ".$orden;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rendimientos[$cont]['id'] = $w['rfi_id'];
                                $rendimientos[$cont]['cuenta'] = $w['cfi_id'];
                                $rendimientos[$cont]['cuenta_nombre'] = $w['cfi_nombre'];
                                $rendimientos[$cont]['cuenta_numero'] = $w['cfi_numero'];
                                $rendimientos[$cont]['mes'] = $w['rfi_mes'];
				$rendimientos[$cont]['anio'] = $w['rfi_anio'];
				$rendimientos[$cont]['rendimiento_financiero'] = $w['rfi_rendimiento_financiero'];
                                $rendimientos[$cont]['descuentos'] = $w['rfi_descuentos'];
                                $rendimientos[$cont]['rendimiento_consignado'] = $w['rfi_rendimiento_consignado'];
                                $rendimientos[$cont]['rendimiento_acumulado'] = $w['rfi_rendimiento_acumulado'];
                                $rendimientos[$cont]['rentabilidad_tasa'] = $w['rfi_rentabilidad_tasa'];
                                $rendimientos[$cont]['fecha_consignacion'] = $w['rfi_fecha_consignacion'];
				$rendimientos[$cont]['comprobante_consignacion'] = $w['rfi_comprobante_consignacion'];
                                $rendimientos[$cont]['comprobante_emision'] = $w['rfi_comprobante_emision'];
                                $rendimientos[$cont]['valor_fiduciaria'] = $w['rfi_valor_fiduciaria'];
                                $rendimientos[$cont]['estado'] = $w['erf_id'];
                                $rendimientos[$cont]['estado_nombre'] = $w['erf_nombre'];
                                $rendimientos[$cont]['observaciones'] = $w['rfi_observaciones'];
				$cont++;
			}
		}
		return $rendimientos;
	}
        
        function getCuentas($criterio,$orden){
		$cuentas=null;
		$sql = "select * from cuentas_financiero  
                        where ". $criterio ." order by ".$orden;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
                                $cuentas[$cont]['id'] = $w['cfi_id'];
                                $cuentas[$cont]['nombre'] = $w['cfi_nombre'];
                                $cuentas[$cont]['numero'] = $w['cfi_numero'];
                                
				$cont++;
			}
		}
		return $cuentas;
	}
        
        function getEstados($criterio,$orden){
		$estados=null;
		$sql = "select * from estado_rendimiento_financiero  
                        where ". $criterio ." order by ".$orden;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
                                $estados[$cont]['id'] = $w['erf_id'];
                                $estados[$cont]['nombre'] = $w['erf_nombre'];
                                
				$cont++;
			}
		}
		return $estados;
	}
        
        function getDirectorioOperador($id) {
            $tabla = 'operador';
            $campo = 'ope_sigla';
            $predicado = 'ope_id = ' . $id;
            if (!isset($id))
                $predicado = 'ope_id=1';
            $r = $this->db->recuperarCampo($tabla, $campo, $predicado);
            $r = $r . "/";
            if ($r)
                return $r;
            else
                return -1;
        }
			
}
?>