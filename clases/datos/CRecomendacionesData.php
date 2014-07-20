<?php
/**
*
*
*<ul>
*<li> Redcom Ltda <www.redcom.com.co></li>
*<li> Proyecto PNCAV</li>
*</ul>
*/

/**
* Clase CompromisoData
* Usada para la definicion de todas las funciones propias del objeto COMPROMISO
*
* @package  clases
* @subpackage datos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/
Class CRecomendacionesData{
    var $db = null;
	
	function CRecomendacionesData($db){
		$this->db = $db;
	}

	function getResponsablesCompromisos($criterio,$orden){
		$responsables = null;
		$sql = "SELECT  u.* 
		FROM  usuario u
                WHERE  ". $criterio ."  order by ".$orden;
		//echo ("<br>getResponsablesCompromisos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$responsables[$cont]['id'] = $w['usu_id'];
				$responsables[$cont]['nombre'] = $w['usu_nombre'];
                                $responsables[$cont]['apellido'] = $w['usu_apellido'];
				$cont++;
			}
		}
		return $responsables;
	}
	
	function getTemas($criterio,$orden){
		$tema = null;
		$sql = "SELECT tema.* 
                        FROM  documento_tema AS tema INNER JOIN 
                              documento_tipo AS tipo ON tema.dti_id = tipo.dti_id
			WHERE  ". $criterio ." order by ".$orden;
		//echo ("<br>getTemas:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$tema[$cont]['id'] = $w['dot_id'];
				$tema[$cont]['nombre'] = $w['dot_nombre'];
				$cont++;
			}
		}
		return $tema;
	}

	function getDocumentos($criterio,$orden){
		$subtema = null;
		$sql = "select doc_id, concat('Acta No.',doc_version) as document  from documento1
				where ". $criterio ." order by ".$orden;
		//echo ("<br>getDocumentos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$subtema[$cont]['id'] = $w['doc_id'];
				$subtema[$cont]['nombre'] = $w['document'];
				$cont++;
			}
		}
		return $subtema;
	}

	function getEstadosCompromisos($criterio,$orden){
		$estados = null;
		$sql = "select * from recomendaciones_estado where ". $criterio ." order by ".$orden;
		//echo ("<br>getEstadosCompromisos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$estados[$cont]['id'] = $w['ces_id'];
				$estados[$cont]['nombre'] = $w['ces_nombre'];
				$cont++;
			}
		}
		return $estados;
	}
        
        function getFuentesCompromisos($criterio,$orden){
            $subtemas = null;
            $sql = "select * from documento_subtema where " . $criterio . " order by " . $orden;
            //echo("<br>sql:".$sql);
            $r = $this->db->ejecutarConsulta($sql);
            if ($r) {
                $cont = 0;
                while ($w = mysql_fetch_array($r)) {
                    $subtemas[$cont]['id'] = $w['dos_id'];
                    $subtemas[$cont]['nombre'] = $w['dos_nombre'];
                    $cont++;
                }
            }
            return $subtemas;
        }

	function getCompromisoById($id){
		$recomendaciones = null;
		$sql = "SELECT  *
			FROM  recomendaciones c
			WHERE com_id= ". $id ;
		//echo ("<br>getCompromisoById:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}

	function getCompromisosSee($id){
		$sql = "SELECT c.com_id, c.com_actividad, c.doc_id, dos_nombre, 
                               c.doc_id, c.com_fecha_limite,
                               c.com_fecha_entrega, te.ces_id, te.ces_nombre, 
                               c.com_observaciones, c.com_consecutivo
                        FROM recomendaciones c 
                        INNER JOIN 
                             documento_subtema dos on c.doc_id=dos.dos_id INNER JOIN 
                             recomendaciones_estado te on te.ces_id = c.ces_id
                        WHERE  c.com_id=". $id;
		//echo ("<br>getCompromisosSee:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}

	function getCompromisos($criterio,$orden,$dirOperador){
		$recomendaciones = null;
		$sql = "SELECT DISTINCT c.com_id, c.com_actividad, dos_nombre,c.com_fecha_limite,
                                        c.com_fecha_entrega, te.ces_nombre, te.ces_id, 
                                        c.com_observaciones, com_consecutivo
                        FROM recomendaciones c 
						INNER JOIN documento_subtema dos ON c.doc_id=dos.dos_id 
						INNER JOIN recomendaciones_estado te ON te.ces_id = c.ces_id 
						LEFT  JOIN recomendaciones_responsable cr ON cr.com_id = c.com_id 
						LEFT  JOIN usuario u ON u.usu_id = cr.usu_id
                        WHERE   ". $criterio ." ORDER  BY ".$orden;
                //echo $sql;
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$responsables = '';
				$sql = "SELECT usu_nombre, usu_apellido 
						FROM usuario u  
                                                INNER JOIN recomendaciones_responsable cr on u.usu_id=cr.usu_id 
                                                INNER JOIN recomendaciones c on cr.com_id=c.com_id
						WHERE cr.com_id=". $w['com_id'] ." order by usu_nombre, usu_apellido";
				$rr = $this->db->ejecutarConsulta($sql);
				//echo ("<br>getCompromisos:".$sql);
				while($x = mysql_fetch_array($rr)){
					$responsables .= $x['usu_nombre']." ".$x['usu_apellido'].",";
				}
				$longitud = strlen($responsables)-1;
				$responsable = substr ($responsables,0,$longitud); 
				$recomendaciones[$cont]['id'] = $w['com_id'];
				$recomendaciones[$cont]['dos_nombre'] = $w['dos_nombre'];
                                $recomendaciones[$cont]['com_fecha_entrega'] = $w['com_fecha_entrega'];
				$recomendaciones[$cont]['doa_nombre'] = $responsable;
				$recomendaciones[$cont]['com_actividad'] = $w['com_actividad'];
				//$recomendaciones[$cont]['doc_referencia'] = 'Acta No. '."<a href='././soportes/".$dirOperador.$w['dti_nombre']."/".$w['dot_nombre']."/".$w['doc_archivo']."' target='_blank'>{$w['doc_version']}</a>";;
				$recomendaciones[$cont]['com_fecha_limite'] = $w['com_fecha_limite'];
				$recomendaciones[$cont]['ces_nombre'] = $w['ces_nombre'];
                                $recomendaciones[$cont]['ces_id'] = $w['ces_id'];
				$recomendaciones[$cont]['com_consecutivo'] = $w['com_consecutivo'];
				$recomendaciones[$cont]['com_observaciones'] = $w['com_observaciones'];
				$cont++;
			}
		}
		return $recomendaciones;
	}

        function getCompromisosToExcell($criterio,$orden,$dirOperador){
		$recomendaciones = null;
		$sql = "SELECT DISTINCT c.com_id, c.com_actividad, dos_nombre, c.com_fecha_limite,
                                        c.com_fecha_entrega, te.ces_nombre, c.com_observaciones, 
                                        com_consecutivo
                        FROM recomendaciones c 
						INNER JOIN documento_subtema dos ON c.doc_id=dos.dos_id 
						INNER JOIN recomendaciones_estado te ON te.ces_id = c.ces_id 
						LEFT  JOIN recomendaciones_responsable cr ON cr.com_id = c.com_id 
						LEFT  JOIN usuario u ON u.usu_id = cr.usu_id
                        WHERE   ". $criterio ." ORDER  BY ".$orden;
                
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$responsables = '';
				$sql = "SELECT usu_nombre, usu_apellido 
						FROM usuario u  
                                                INNER JOIN recomendaciones_responsable cr on u.usu_id=cr.usu_id 
                                                INNER JOIN recomendaciones c on cr.com_id=c.com_id
						WHERE cr.com_id=". $w['com_id'] ." order by usu_nombre, usu_apellido";
				$rr = $this->db->ejecutarConsulta($sql);
				//echo ("<br>getCompromisos:".$sql);
				while($x = mysql_fetch_array($rr)){
					$responsables .= $x['usu_nombre']." ".$x['usu_apellido'].",";
				}
				$longitud = strlen($responsables)-1;
				$responsable = substr ($responsables,0,$longitud); 
				$recomendaciones[$cont]['id'] = $w['com_id'];
				$recomendaciones[$cont]['dos_nombre'] = $w['dos_nombre'];
                                $recomendaciones[$cont]['com_fecha_entrega'] = $w['com_fecha_entrega'];
				$recomendaciones[$cont]['doa_nombre'] = $responsable;
				$recomendaciones[$cont]['com_actividad'] = $w['com_actividad'];
//				$recomendaciones[$cont]['doc_referencia'] = 'Acta No. '.$w['doc_version'];
//				$recomendaciones[$cont]['com_fecha_limite'] = $w['com_fecha_limite'];
				$recomendaciones[$cont]['ces_nombre'] = $w['ces_nombre'];
//				$recomendaciones[$cont]['com_consecutivo'] = $w['com_consecutivo'];
				$recomendaciones[$cont]['com_observaciones'] = $w['com_observaciones'];
				$cont++;
			}
		}
		return $recomendaciones;
	}
        
	function getReferenciasDocumentos($criterio,$orden){
		$referencias = null;
		$sql = "SELECT * 
                        FROM   documento d INNER JOIN 
                               documento_tipo AS tipo ON d.dti_id = tipo.dti_id INNER JOIN  
                               documento_subtema 	ds on ds.dos_id=d.dos_id
                        WHERE  ". $criterio ." ORDER BY ".$orden;
		//echo ("<br>getReferenciasDocumentos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$referencias[$cont]['id'] = $w['doc_id'];
				$referencias[$cont]['nombre'] = $w['dos_nombre'].'-'.'Acta No. '.$w['doc_version'];
				$cont++;
			}
		}
		return $referencias;
	}
	
	function insertCompromiso($recomendaciones){
								  
		$tabla = "recomendaciones";
		$campos = "com_actividad,doc_id,"
                        . "com_fecha_limite,com_fecha_entrega,"
                        . "ces_id,com_observaciones,"
                        . "com_consecutivo,ope_id";
		$valores = "'".$recomendaciones->getActividad()."','";
                $valores .= $recomendaciones->getSubtema()."','";
                $valores .= $recomendaciones->getFechaLimite()."','";
                $valores .= $recomendaciones->getFechaEntrega()."',";
                $valores .= $recomendaciones->getEstado().",'";
                $valores .= $recomendaciones->getObservaciones()."','";
                $valores .= $recomendaciones->getConsecutivo()."','";
                $valores .= $recomendaciones->getOperador()."'";
                
                
                
                $r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function deleteCompromiso($id){
		$tabla = "recomendaciones_responsable";
		$predicado = "com_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		if($r=='true'){	
			$tabla = "recomendaciones";
			$predicado = "com_id = ". $id;
			$r = $this->db->borrarRegistro($tabla,$predicado);
			if($r=='true')	return "true"; else return "false";
		}
		else return "false";
	}
		
	function updateCompromiso($recomendaciones){
                //$id,$actividad,$referencia,$fecha_limite,$fecha_entrega,$estado,$observaciones,$consecutivo
		$tabla = "recomendaciones";
		$campos = array('com_actividad','doc_id',
                                'com_fecha_limite', 'com_fecha_entrega',
                                'ces_id', 'com_observaciones',
                                'com_consecutivo');
		$valores = array("'".$recomendaciones->getActividad()."'","'".$recomendaciones->getSubtema()."'",
                                 "'".$recomendaciones->getFechaLimite()."'","'".$recomendaciones->getFechaEntrega()."'",
                                 $recomendaciones->getEstado(),"'".$recomendaciones->getObservaciones()."'",
                                 "'".$recomendaciones->getConsecutivo()."'");			
		$condicion = "com_id = ".$recomendaciones->getId();
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function updateResponsables($id,$responsables){
							  
		$tabla = "recomendaciones1";
		$campos = array('doa_id_otros');
		$valores = array("'".$responsables."'");
			
		$condicion = "com_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	function getResponsables($criterio,$orden){
		$responsables = null;
		$sql = "SELECT cr.cor_id, cr.com_id,u.usu_nombre,u.usu_apellido,c.com_actividad
                        FROM recomendaciones_responsable cr 
                        INNER JOIN recomendaciones c on cr.com_id = c.com_id 
                        INNER JOIN usuario u on cr.usu_id = u.usu_id
			WHERE ". $criterio." 
			ORDER  BY ".$orden;	
				
		//echo ("<br>getResponsables:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$responsables[$cont]['id'] = $w['cor_id'];
				$responsables[$cont]['com_id'] = $w['com_id'];
				$responsables[$cont]['nombre'] = $w['usu_nombre'];
                                $responsables[$cont]['apellido'] = $w['usu_apellido'];
				$responsables[$cont]['actividad'] = $w['com_actividad'];
				$cont++;
			}
		}
		return $responsables;
	}
	
	function deleteResumen(){
		$tabla = "recomendaciones_resumen";
		$predicado = " 1";
		$n = $this->db->borrarRegistro($tabla,$predicado);
		return $n;
		
	}
	
	function insertResumen($responsable,$abierto,$cerrado,$cancelado,$operador){
		$tabla = "recomendaciones_resumen";
		$campos = "cor_nombre_tmp,ces_1,ces_2,ces_3,ope_id";
		$valores = "'".$responsable."',".$abierto.",".$cerrado.",".$cancelado.",".$operador;
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function updateResumen($responsable,$abierto,$cerrado,$cancelado,$operador){
		$tabla = "recomendaciones_resumen";
		$campos = array('ces_1', 'ces_2', 'ces_3','ope_id');
		$valores = array($abierto,$cerrado,$cancelado,$operador);
			
		$condicion = "cor_nombre_tmp = '".$responsable."'";
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function getResumen($responsable,$operador){
		
		$sql = "select *
				from recomendaciones_resumen
				where cor_nombre_tmp= '". $responsable."' and ope_id=".$operador ;
		//echo ("<br>getResumen:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
			
	function getResumenes($operador){
		$resumenes = null;
		$sql = "select cor_nombre_tmp, ces_1, ces_2, ces_3
				from recomendaciones_resumen
				where ope_id = ".$operador."
				order by cor_nombre_tmp";	
				
		//echo ("<br>getResumenes:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$resumenes[$cont]['id'] = $cont;
				$resumenes[$cont]['cor_nombre_tmp'] = $w['cor_nombre_tmp'];
				$resumenes[$cont]['ces_1'] = $w['ces_1'];
                    		$resumenes[$cont]['ces_2'] = $w['ces_2'];
				$resumenes[$cont]['ces_3'] = $w['ces_3'];
				$cont++;
			}
		}
		return $resumenes;
	}
        
        function contarPorEstado($estado,$usuario){
            $sql = "select count(1) as conteo "
                    . "from recomendaciones c "
                    . "inner join recomendaciones_responsable r on r.com_id = c.com_id "
                    . "where c.ces_id = ". $estado ." and r.usu_id = ".$usuario;
            //echo $sql;
            $r = $this->db->ejecutarConsulta($sql);
            $row = mysql_fetch_array($r);
            return $row["conteo"];
        }
}