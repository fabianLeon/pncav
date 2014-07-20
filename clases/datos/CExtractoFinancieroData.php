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
Class CExtractoFinancieroData{
    var $db = null;
    /*efi_id
    cfi_id
    efi_mes
    efi_anio
    efi_saldo_inicial
    efi_saldo_final
    efi_rentabilidad
    efi_observaciones
    efi_documento_soporte
    efi_documento_movimientos*/
	
	function __construct($db){
		$this->db = $db;
	}
	
	
	function insertExtracto($extracto){
		$tabla = "extracto_financiero";
		$campos = "cfi_id,efi_mes, efi_anio, efi_saldo_inicial, efi_incrementos, 
                           efi_disminuciones, efi_saldo_final, 
                           efi_rentabilidad, efi_observaciones, efi_documento_soporte, efi_documento_movimientos";
		$valores = "'".$extracto->cuenta."','".$extracto->mes."','".$extracto->anio."','".
                               $extracto->saldo_inicial."','".$extracto->incrementos."','".                     
                               $extracto->disminuciones."','".$extracto->saldo_final."','".
                               $extracto->rentabilidad."','".$extracto->observaciones."','".
                               $extracto->documento_soporte."','".$extracto->documento_movimientos."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
        
        function getSaldoFinalByFecha($cuenta,$mes,$anio){
            $sql = "select efi_saldo_final as saldo
                    from extracto_financiero 
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
                
	function getExtractoById($id){
		$extractos=null;
		$sql = "select e.efi_id, c.cfi_id, c.cfi_numero, c.cfi_nombre, 
                               e.efi_mes, e.efi_anio, e.efi_saldo_inicial, 
                               e.efi_incrementos, e.efi_disminuciones,
                               e.efi_saldo_final, e.efi_rentabilidad, e.efi_observaciones, 
                               e.efi_documento_soporte, e.efi_documento_movimientos 
                        from extracto_financiero e 
                        inner join cuentas_financiero c on c.cfi_id = e.cfi_id  
                        where efi_id=". $id;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$extractos['id'] = $w['efi_id'];
                                $extractos['cuenta'] = $w['cfi_id'];
                                $extractos['cuenta_nombre'] = $w['cfi_nombre'];
                                $extractos['cuenta_numero'] = $w['cfi_numero'];
                                $extractos['mes'] = $w['efi_mes'];
				$extractos['anio'] = $w['efi_anio'];
				$extractos['saldo_inicial'] = $w['efi_saldo_inicial'];
                                $extractos['incrementos'] = $w['efi_incrementos'];
                                $extractos['disminuciones'] = $w['efi_disminuciones'];
                                $extractos['saldo_final'] = $w['efi_saldo_final'];
                                $extractos['rentabilidad'] = $w['efi_rentabilidad'];
                                $extractos['observaciones'] = $w['efi_observaciones'];
				$extractos['documento_soporte'] = $w['efi_documento_soporte'];
                                $extractos['documento_movimientos'] = $w['efi_documento_movimientos'];
				$cont++;
			}
		}
		return $extractos;
	}
	
	function updateExtracto($extracto){
		$tabla = "extracto_financiero";
		$campos = array('efi_id', 'cfi_id', 'efi_mes',
                    'efi_anio', 'efi_saldo_inicial', 'efi_incrementos',
                    'efi_disminuciones', 'efi_saldo_final',
                    'efi_rentabilidad', 'efi_observaciones', 'efi_documento_soporte',
                    'efi_documento_movimientos');
		$montos = array("'".$extracto->id."'","'".$extracto->cuenta."'","'".$extracto->mes."'",
                    "'".$extracto->anio."'","'".$extracto->saldo_inicial."'","'".$extracto->incrementos."'",
                    "'".$extracto->disminuciones."'","'".$extracto->saldo_final."'",
                    "'".$extracto->rentabilidad."'","'".$extracto->observaciones."'","'".$extracto->documento_soporte."'",
                    "'".$extracto->documento_movimientos."'");
			
		$condicion = "efi_id = ".$extracto->id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$montos,$condicion);
		return $r;
	}
	
	function deleteExtracto($id){
		$tabla = "extracto_financiero";
		$predicado = "efi_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function getExtractos($criterio,$orden){
		$extractos=null;
		$sql = "select e.efi_id, c.cfi_id, c.cfi_numero, c.cfi_nombre, 
                               e.efi_mes, e.efi_anio, e.efi_saldo_inicial, 
                               e.efi_incrementos, e.efi_disminuciones,
                               e.efi_saldo_final, e.efi_rentabilidad, e.efi_observaciones, 
                               e.efi_documento_soporte, e.efi_documento_movimientos 
                        from extracto_financiero e 
                        inner join cuentas_financiero c on c.cfi_id = e.cfi_id  
                        where ". $criterio ." order by ".$orden;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$extractos[$cont]['id'] = $w['efi_id'];
                                $extractos[$cont]['cuenta'] = $w['cfi_id'];
                                $extractos[$cont]['cuenta_nombre'] = $w['cfi_nombre'];
                                $extractos[$cont]['cuenta_numero'] = $w['cfi_numero'];
                                $extractos[$cont]['mes'] = $w['efi_mes'];
				$extractos[$cont]['anio'] = $w['efi_anio'];
				$extractos[$cont]['saldo_inicial'] = $w['efi_saldo_inicial'];
                                $extractos[$cont]['incrementos'] = $w['efi_incrementos'];
                                $extractos[$cont]['disminuciones'] = $w['efi_disminuciones'];
                                $extractos[$cont]['saldo_final'] = $w['efi_saldo_final'];
                                $extractos[$cont]['rentabilidad'] = $w['efi_rentabilidad'];
                                $extractos[$cont]['observaciones'] = $w['efi_observaciones'];
				$extractos[$cont]['documento_soporte'] = $w['efi_documento_soporte'];
                                $extractos[$cont]['documento_movimientos'] = $w['efi_documento_movimientos'];
				$cont++;
			}
		}
		return $extractos;
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
        
        function getTipoCuenta($cuenta) {
            $tabla = 'cuentas_financiero';
            $campo = 'cft_id';
            $predicado = 'cfi_id = ' . $cuenta;
            $r = $this->db->recuperarCampo($tabla, $campo, $predicado);
            if ($r)
                return $r;
            else
                return -1;
        }
			
}
?>