<?php
/**
*Redcom Ltda 
*/
Class CRendimientosData{
    var $db = null;
	
	function CRendimientosData($db){
		$this->db = $db;
	}
	
	function getMeses($orden){
		$salida = null;
		$sql = "select * from mes_contrato where 1 order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$salida[$cont]['id'] 					= $w['mec_id'];
				$salida[$cont]['mes'] 			  		= $w['mec_nombre'];
				$cont++;
			}
		}
		return $salida;
	}	
	function insertRendimiento($operador,$mes,$rendimiento_generado,$descuento,$rendimiento_tasa,
										  $archivo_consignacion,$archivo_emision,$fecha_consignacion){
		$tabla = "rendimientos";
		$campos = "ope_id,mec_id,ren_generado,ren_descuento,ren_tasa,
					ren_archivo_consignacion,ren_archivo_emision,ren_fecha";
		$valores = "'".$operador."','".$mes."','".$rendimiento_generado."','".$descuento."','".$rendimiento_tasa."',
						'".$archivo_consignacion."','".$archivo_emision."','".$fecha_consignacion."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function getRendimientoById($id){
		$rendimientos=null;
		$sql = "select * from rendimientos where ren_id=". $id;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rendimientos['ren_id'] 					= $w['ren_id'];
				$rendimientos['ope_id'] 			    	= $w['ope_id'];
				$rendimientos['mec_id'] 			  		= $w['mec_id'];
				$rendimientos['ren_generado'] 				= $w['ren_generado'];
				$rendimientos['ren_descuento'] 			    = $w['ren_descuento'];
				$rendimientos['ren_tasa'] 					= $w['ren_tasa'];
				$rendimientos['ren_archivo_consignacion'] 	= $w['ren_archivo_consignacion'];
				$rendimientos['ren_archivo_emision'] 		= $w['ren_archivo_emision'];
				$rendimientos['ren_fecha'] 					= $w['ren_fecha'];
				
				$cont++;
			}
		}
		return $rendimientos;
	}
	
	function updateRendimiento($id,$rendimiento_generado,$descuento,$rendimiento_tasa,
								   $archivo_consignacion,$archivo_emision,$fecha_consignacion){
		$tabla = "rendimientos";
		$campos = array('ren_generado','ren_descuento','ren_tasa','ren_fecha');
		$valores = array("'".$rendimiento_generado."'","'".$descuento."'","'".$rendimiento_tasa."'","'".$fecha_consignacion."'");
		$condicion = "ren_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function deleteRendimiento($id){
		$tabla = "rendimientos";
		$predicado = "ren_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function getRendimientos($operador,$nombreOPerador,$orden){
		$rendimientos = null;
		$sql = "select r.*,m.mec_nombre from rendimientos r
				inner join mes_contrato m on m.mec_id=r.mec_id
				where r.ope_id=". $operador ." order by ".$orden;                
		$r = $this->db->ejecutarConsulta($sql);
		
		$ruta = str_replace(getcwd(),'.',(RUTA_RENDIMIENTOS."/".$nombreOPerador));
		
		$rendimiento_acumulado=0;
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$rendimientos[$cont]['id'] 						= $w['ren_id'];
				$rendimientos[$cont]['mes'] 			  		= $w['mec_nombre'];
				$rendimientos[$cont]['rendimiento_generado'] 	= number_format($w['ren_generado'],2,',','.');
				$rendimientos[$cont]['descuento'] 			    = number_format($w['ren_descuento'],2,',','.');
				$rendimientos[$cont]['rendimiento_consigando']	= number_format(($w['ren_generado']-$w['ren_descuento']),2,',','.');
				$rendimiento_acumulado                          = $rendimiento_acumulado + $w['ren_generado']-$w['ren_descuento'];
				$rendimientos[$cont]['rendimiento_acumulado']	= number_format($rendimiento_acumulado,2,',','.');
				$rendimientos[$cont]['rendimiento_tasa']  		= number_format($w['ren_tasa'],2,',','.')."%";
				$rendimientos[$cont]['fecha_consignacion'] 		= $w['ren_fecha'];
				$rendimientos[$cont]['archivo_consignacion'] 	= "<a href='".$ruta."/".$w['ren_archivo_consignacion']."' target='_blank'>".$w['ren_archivo_consignacion']."</a>";
				$rendimientos[$cont]['archivo_emision'] 		= "<a href='".$ruta."/".$w['ren_archivo_emision']."' target='_blank'>".$w['ren_archivo_emision']."</a>";
				$cont++;
			}
		}
		return $rendimientos;
	}
			
}
?>