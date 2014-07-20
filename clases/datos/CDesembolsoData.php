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
*Usada para todas las funciones de acceso a datos referente a desembolsos para el modulo financiero
*
* @package  clases
* @subpackage datos
*/
Class CDesembolsoData{
    var $db = null;
    var $permitidos = array('pdf', 'doc', 'xls', 'ppt', 'docx',
        'xlsx', 'gif', 'jpg', 'png', 'tif', 'zip', 'rar');
	
    function CDesembolsoData($db){
            $this->db = $db;
    }

    function getTotalDesembolso($predicado){		
        $tabla='desembolso';
        $campo='sum(des_efectuado)';
        $r = $this->db->recuperarCampo($tabla,$campo,$predicado);
        if ($r) {
            return $r+0;
        } else
            return -1;
    }
    function getTotalVigencias($tabla,$predicado){		
        $campo='sum(vir_monto)';
        $r = $this->db->recuperarCampo($tabla,$campo,$predicado);

        if($r) return $r; else return -1;
    }
    function getDesembolso($criterio,$orden){
        $desembolso = null;
        $sql = "select * from desembolso where ". $criterio ." order by ".$orden;
//        echo "<br>getDesembolso:".$sql;
        $r = $this->db->ejecutarConsulta($sql);
        if($r){
            $cont=0;
            $acumulado=0;
            while($w = mysql_fetch_array($r)){
                $desembolso[$cont]['id'] 			= $w['des_id'];
                $desembolso[$cont]['fecha'] 			= $w['des_fecha'];
                $desembolso[$cont]['vigencia'] 			= $w['des_ano_vigencia'];
                $desembolso[$cont]['soporte']                   = "<a href='".RUTA_DOCUMENTOS_DESEMBOLSO ."/".$w['des_id']."/".$w['des_documento']."' target='_blank'>{$w['des_documento']}</a>";
                $desembolso[$cont]['condicion'] 		= "<a href='".RUTA_DOCUMENTOS_DESEMBOLSO ."/".$w['des_id']."/".$w['des_condiciones']."' target='_blank'>{$w['des_condiciones']}</a>";
                $desembolso[$cont]['porcentaje'] 		= $w['des_porcentaje'];
                $desembolso[$cont]['aprobado'] 			= $w['des_aprobado'];
                $desembolso[$cont]['porcentaje_amortizacion']   = $w['des_porcentaje_amortizacion'];
                $desembolso[$cont]['amortizacion'] 		= $w['des_amortizacion'];
                $desembolso[$cont]['fecha_cumplimiento'] 	= $w['des_fecha_cumplimiento'];
                $desembolso[$cont]['fecha_tramite'] 		= $w['des_fecha_tramite'];
                $desembolso[$cont]['fecha_efectiva']            = $w['des_fecha_efectiva'];
                $desembolso[$cont]['fecha_limite'] 		= $w['des_fecha_limite'];
                $desembolso[$cont]['efectuado'] 		= $w['des_efectuado'];
                $desembolso[$cont]['observaciones']             = $w['des_observaciones'];
                $cont++;
            }
        }
        return $desembolso;
    }
    function getDesembolsoFormat($criterio,$orden){
        $desembolso = null;
        $sql = "select * from desembolso where ". $criterio ." order by ".$orden;
//        echo "<br>getDesembolso:".$sql;
        $r = $this->db->ejecutarConsulta($sql);
        if($r){
            $cont=0;
            $acumulado=0;
            while($w = mysql_fetch_array($r)){
                $desembolso[$cont]['id'] 			= $w['des_id'];
                $desembolso[$cont]['fecha'] 			= $w['des_fecha'];
                $desembolso[$cont]['vigencia'] 			= $w['des_ano_vigencia'];
                $desembolso[$cont]['soporte']                   = "<a href='".RUTA_DOCUMENTOS_DESEMBOLSO ."/".$w['des_id']."/".$w['des_documento']."' target='_blank'>{$w['des_documento']}</a>";
                $desembolso[$cont]['condicion'] 		= "<a href='".RUTA_DOCUMENTOS_DESEMBOLSO ."/".$w['des_id']."/".$w['des_condiciones']."' target='_blank'>{$w['des_condiciones']}</a>";
                $desembolso[$cont]['porcentaje'] 		= number_format($w['des_porcentaje'],2,',','.').'%';
                $desembolso[$cont]['aprobado'] 			= number_format($w['des_aprobado'],2,',','.');
                $desembolso[$cont]['porcentaje_amortizacion']   = number_format($w['des_porcentaje_amortizacion'],2,',','.').'%';
                $desembolso[$cont]['amortizacion'] 		= number_format($w['des_amortizacion'],2,',','.');
                $desembolso[$cont]['fecha_cumplimiento'] 	= $w['des_fecha_cumplimiento'];
                $desembolso[$cont]['fecha_tramite'] 		= $w['des_fecha_tramite'];
                $desembolso[$cont]['fecha_efectiva']            = $w['des_fecha_efectiva'];
                $desembolso[$cont]['fecha_limite'] 		= $w['des_fecha_limite'];
                $desembolso[$cont]['efectuado'] 		= number_format($w['des_efectuado'],2,',','.');
                $desembolso[$cont]['observaciones']             = $w['des_observaciones'];
                $desembolso[$cont]['neto']                      = number_format(($w['des_aprobado']-$w['des_amortizacion']),2,',','.');
                $desembolso[$cont]['estado']                    = number_format(($w['des_aprobado']-$w['des_amortizacion']-$w['des_efectuado']),2,',','.');
                $cont++;
            }
        }
        return $desembolso;
    }
    function insertDesembolso($numero,$fecha,$year,$soporte,$condiciones,$porcentaje,$aprobado,
            $porcentaje_amortizacion, $amortizacion,$fecha_cumplimiento,$fecha_tramite,
            $fecha_efectiva,$fecha_limite,$efectuado, $observaciones){
        
        $docIngresos = new CIngresosData($this->db);
        $vigencia = $docIngresos->ObtenerValoresIngresos($year);
        $valor = $docIngresos->ObtenerValoresDesembolsos($year);
        if(($valor+$efectuado)>$vigencia[1]){
            return ERROR_ADD_DESEMBOLSO_SOBRECOSTO;
        }
        $tabla = "desembolso";
        
        $campos = "des_id,des_fecha,des_ano_vigencia,des_documento,des_condiciones,des_porcentaje,des_aprobado,"
                . "des_porcentaje_amortizacion,des_amortizacion,des_fecha_cumplimiento,"
                . "des_fecha_tramite,des_fecha_efectiva,des_fecha_limite,des_efectuado, des_observaciones";
        
        $valores = "'".$numero."','".$fecha."',".$year.",'".$soporte['name']."','".$condiciones['name']."',".$porcentaje.",".$aprobado.','.$porcentaje_amortizacion
                .','.$amortizacion.",'".$fecha_cumplimiento."','".$fecha_tramite."','".
                $fecha_efectiva."','".$fecha_limite."',".$efectuado.",'".$observaciones."'";
        
        $extension = explode(".",$soporte['name']);
        $extension2 = explode(".",$condiciones['name']);
	$num = count($extension)-1;
        
        foreach( $this->permitidos as $p ) {
			if ( strcasecmp( $extension[$num], $p ) == 0 && strcasecmp( $extension2[$num], $p ) == 0 ) $noMatch = 1;
		}
        $noMatch=1;
        if($soporte['name']!=null && $condiciones['name']!=null){
			if($noMatch==1){
				if($soporte['size'] < MAX_SIZE_DOCUMENTOS && $condiciones['size'] < MAX_SIZE_DOCUMENTOS){
						
					$ruta = RUTA_DOCUMENTOS_DESEMBOLSO."/".$numero."/";
					$ruta = str_replace("\\",'/' , $ruta);
//					echo ("<br>ruta: ".$ruta);
					//echo ("<br>nombre".$archivo['name']);
					$carpetas = explode("/",substr($ruta,0,strlen($ruta)-1));
					$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
					$ruta_destino = '';
										
					foreach($carpetas as $c){
						$ruta_destino .= strtolower($c)."/";
						if(!is_dir($ruta_destino)) {
							mkdir($ruta_destino,0777);}
						else {
							chmod($ruta_destino, 0777);
						}
                                                
					}
                                        $ruta_destino=$ruta_destino."/";
                                        if(!is_dir($ruta_destino)) {
							mkdir($ruta_destino,0777);}
						else {
							chmod($ruta_destino, 0777);
						}
//                                        echo ("<br>ruta: ".$ruta);
					if(!(move_uploaded_file($soporte['tmp_name'], strtolower($ruta).$soporte['name']) 
                                                && move_uploaded_file($condiciones['tmp_name'], strtolower($ruta).$condiciones['name']))){
						$r = ERROR_COPIAR_ARCHIVO;
					}else{

						$i = $this->db->insertarRegistro($tabla,$campos,$valores);
						if($i == "true"){
							$r = DESEMBOLSO_AGREGADO;
						}else{
							$r = ERROR_ADD_DESEMBOLSO;
						}
					}
				}else{
					$r = ERROR_SIZE_ARCHIVO;
				}
			}else{
				$r = ERROR_FORMATO_ARCHIVO;
			}
		}
        
        return $r;
    }
    
    
    function getDesembolsoById($id){
        $desembolso=null;
        $sql = "select * from desembolso where des_id=". $id;
        //echo ("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if($r){
            $cont = 0;
            while($w = mysql_fetch_array($r)){
                $desembolso['des_id'] 				= $w['des_id'];
                $desembolso['des_fecha'] 			= $w['des_fecha'];
                $desembolso['des_vigencia']                     = $w['des_ano_vigencia'];
                $desembolso['des_condicion'] 			= $w['des_condicion'];
                $desembolso['des_porcentaje'] 			= $w['des_porcentaje'];
                $desembolso['des_aprobado'] 			= $w['des_aprobado'];
                $desembolso['des_porcentaje_amortizacion'] 	= $w['des_porcentaje_amortizacion'];
                $desembolso['des_amortizacion'] 		= $w['des_amortizacion'];
                $desembolso['des_fecha_cumplimiento']           = $w['des_fecha_cumplimiento'];
                $desembolso['des_fecha_tramite'] 		= $w['des_fecha_tramite'];
                $desembolso['des_fecha_efectiva']               = $w['des_fecha_efectiva'];
                $desembolso['des_fecha_limite'] 		= $w['des_fecha_limite'];
                $desembolso['des_efectuado'] 			= $w['des_efectuado'];
                $desembolso['des_observaciones'] 		= $w['des_observaciones'];
                $cont++;
            }
        }
        return $desembolso;
    }

    function updateDesembolso($numero,$fecha,$year,$soporte,$condiciones,$porcentaje,$aprobado,
            $porcentaje_amortizacion, $amortizacion,$fecha_cumplimiento,$fecha_tramite,
            $fecha_efectiva,$fecha_limite,$efectuado, $observaciones){
        
        $docIngresos = new CIngresosData($this->db);
        $vigencia = $docIngresos->ObtenerValoresIngresos($year);
        $valor = $this->getTotalDesembolso("des_ano_vigencia = $year AND des_id!='$numero'");
        if(($valor+$efectuado)>$vigencia[1]){
            return ERROR_ADD_DESEMBOLSO_SOBRECOSTO;
        }
        
        $tabla = "desembolso";
        if($soporte['name']==null && $condiciones['name']==null){
            $campos = array("des_id","des_fecha","des_ano_vigencia","des_porcentaje","des_aprobado","des_porcentaje_amortizacion","des_amortizacion","des_fecha_cumplimiento","des_fecha_tramite","des_fecha_efectiva","des_fecha_limite","des_efectuado","des_observaciones");
            $valores = array("'".$numero."'","'".$fecha."'",$year,$porcentaje,$aprobado,$porcentaje_amortizacion,$amortizacion,"'".$fecha_cumplimiento."'","'".$fecha_tramite."'","'".$fecha_efectiva."'","'".$fecha_limite."'",$efectuado,"'".$observaciones."'");
        }
        else if($soporte['name']!=null && $condiciones['name']!=null){
            $campos = array("des_id","des_fecha","des_ano_vigencia","des_documento","des_condiciones","des_porcentaje","des_aprobado","des_porcentaje_amortizacion","des_amortizacion","des_fecha_cumplimiento","des_fecha_tramite","des_fecha_efectiva","des_fecha_limite","des_efectuado","des_observaciones");
            $valores = array("'".$numero."'","'".$fecha."'",$year,"'".$soporte['name']."'","'".$condiciones['name']."'",$porcentaje,$aprobado,$porcentaje_amortizacion,$amortizacion,"'".$fecha_cumplimiento."'","'".$fecha_tramite."'","'".$fecha_efectiva."'","'".$fecha_limite."'",$efectuado,"'".$observaciones."'");
        }
        else if($soporte['name']!=null && $condiciones['name']==null){
            $campos = array("des_id","des_fecha","des_ano_vigencia","des_documento","des_porcentaje","des_aprobado","des_porcentaje_amortizacion","des_amortizacion","des_fecha_cumplimiento","des_fecha_tramite","des_fecha_efectiva","des_fecha_limite","des_efectuado","des_observaciones");
            $valores = array("'".$numero."'","'".$fecha."'",$year,"'".$soporte['name']."'",$porcentaje,$aprobado,$porcentaje_amortizacion,$amortizacion,"'".$fecha_cumplimiento."'","'".$fecha_tramite."'","'".$fecha_efectiva."'","'".$fecha_limite."'",$efectuado,"'".$observaciones."'");
        }
        else if($soporte['name']==null && $condiciones['name']!=null){
            $campos = array("des_id","des_fecha","des_ano_vigencia","des_condiciones","des_porcentaje","des_aprobado","des_porcentaje_amortizacion","des_amortizacion","des_fecha_cumplimiento","des_fecha_tramite","des_fecha_efectiva","des_fecha_limite","des_efectuado","des_observaciones");
            $valores = array("'".$numero."'","'".$fecha."'",$year,"'".$condiciones['name']."'",$porcentaje,$aprobado,$porcentaje_amortizacion,$amortizacion,"'".$fecha_cumplimiento."'","'".$fecha_tramite."'","'".$fecha_efectiva."'","'".$fecha_limite."'",$efectuado,"'".$observaciones."'");
        }
        
        $predicado = "des_id = ".$numero;
        
        $extension = explode(".",$soporte['name']);
        $extension2 = explode(".",$condiciones['name']);
	$num = count($extension)-1;
        
        foreach( $this->permitidos as $p ) {
			if ( strcasecmp( $extension[$num], $p ) == 0 ) $noMatch = 1;
                        if ( strcasecmp( $extension2[$num], $p ) == 0 ) $noMatch = 1;
		}
        $noMatch=1;
        
        if($soporte['name']!=null && $condiciones['name']!=null){
			if($noMatch==1){
				if($soporte['size'] < MAX_SIZE_DOCUMENTOS && $condiciones['size'] < MAX_SIZE_DOCUMENTOS){
						
					$ruta = RUTA_DOCUMENTOS_DESEMBOLSO."/".$numero."/";
					$ruta = str_replace("\\",'/' , $ruta);
//					echo ("<br>ruta: ".$ruta);
					//echo ("<br>nombre".$archivo['name']);
					$carpetas = explode("/",substr($ruta,0,strlen($ruta)-1));
					$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
					$ruta_destino = '';
										
					foreach($carpetas as $c){
						$ruta_destino .= strtolower($c)."/";
						if(!is_dir($ruta_destino)) {
							mkdir($ruta_destino,0777);}
						else {
							chmod($ruta_destino, 0777);
						}
                                                
					}
                                        $ruta_destino=$ruta_destino."/";
                                        if(!is_dir($ruta_destino)) {
							mkdir($ruta_destino,0777);}
						else {
							chmod($ruta_destino, 0777);
						}
//                                        echo ("<br>ruta: ".$ruta);
					if(!(move_uploaded_file($soporte['tmp_name'], strtolower($ruta).$soporte['name']) 
                                                && move_uploaded_file($condiciones['tmp_name'], strtolower($ruta).$condiciones['name']))){
						$r = ERROR_COPIAR_ARCHIVO;
					}else{

						$i = $this->db->actualizarRegistro($tabla,$campos,$valores,$predicado);
						if($i == "true"){
							$r = DESEMBOLSO_AGREGADO;
						}else{
							$r = ERROR_ADD_DESEMBOLSO;
						}
					}
				}else{
					$r = ERROR_SIZE_ARCHIVO;
				}
			}else{
				$r = ERROR_FORMATO_ARCHIVO;
			}
		}
        if($soporte['name']!=null && $condiciones['name']==null){
			if($noMatch==1){
				if($soporte['size'] < MAX_SIZE_DOCUMENTOS){
						
					$ruta = RUTA_DOCUMENTOS_DESEMBOLSO."/".$numero."/";
					$ruta = str_replace("\\",'/' , $ruta);
//					echo ("<br>ruta: ".$ruta);
					//echo ("<br>nombre".$archivo['name']);
					$carpetas = explode("/",substr($ruta,0,strlen($ruta)-1));
					$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
					$ruta_destino = '';
										
					foreach($carpetas as $c){
						$ruta_destino .= strtolower($c)."/";
						if(!is_dir($ruta_destino)) {
							mkdir($ruta_destino,0777);}
						else {
							chmod($ruta_destino, 0777);
						}
                                                
					}
                                        $ruta_destino=$ruta_destino."/";
                                        if(!is_dir($ruta_destino)) {
							mkdir($ruta_destino,0777);}
						else {
							chmod($ruta_destino, 0777);
						}
//                                        echo ("<br>ruta: ".$ruta);
					if(!(move_uploaded_file($soporte['tmp_name'], strtolower($ruta).$soporte['name']))){
						$r = ERROR_COPIAR_ARCHIVO;
					}else{

						$i = $this->db->actualizarRegistro($tabla,$campos,$valores,$predicado);
						if($i == "true"){
							$r = DESEMBOLSO_AGREGADO;
						}else{
							$r = ERROR_ADD_DESEMBOLSO;
						}
					}
				}else{
					$r = ERROR_SIZE_ARCHIVO;
				}
			}else{
				$r = ERROR_FORMATO_ARCHIVO;
			}
		}
        if($soporte['name']==null && $condiciones['name']!=null){
			if($noMatch==1){
				if($condiciones['size'] < MAX_SIZE_DOCUMENTOS){
						
					$ruta = RUTA_DOCUMENTOS_DESEMBOLSO."/".$numero."/";
					$ruta = str_replace("\\",'/' , $ruta);
//					echo ("<br>ruta: ".$ruta);
					//echo ("<br>nombre".$archivo['name']);
					$carpetas = explode("/",substr($ruta,0,strlen($ruta)-1));
					$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
					$ruta_destino = '';
										
					foreach($carpetas as $c){
						$ruta_destino .= strtolower($c)."/";
						if(!is_dir($ruta_destino)) {
							mkdir($ruta_destino,0777);}
						else {
							chmod($ruta_destino, 0777);
						}
                                                
					}
                                        $ruta_destino=$ruta_destino."/";
                                        if(!is_dir($ruta_destino)) {
							mkdir($ruta_destino,0777);}
						else {
							chmod($ruta_destino, 0777);
						}
//                                        echo ("<br>ruta: ".$ruta);
					if(!(move_uploaded_file($condiciones['tmp_name'], strtolower($ruta).$condiciones['name']))){
						$r = ERROR_COPIAR_ARCHIVO;
					}else{

						$i = $this->db->actualizarRegistro($tabla,$campos,$valores,$predicado);
						if($i == "true"){
							$r = DESEMBOLSO_AGREGADO;
						}else{
							$r = ERROR_ADD_DESEMBOLSO;
						}
					}
				}else{
					$r = ERROR_SIZE_ARCHIVO;
				}
			}else{
				$r = ERROR_FORMATO_ARCHIVO;
			}
		}
        if($soporte['name']==null && $condiciones['name']==null){
			$i = $this->db->actualizarRegistro($tabla,$campos,$valores,$predicado);
                        if($i == "true"){
                                $r = DESEMBOLSO_AGREGADO;
                        }else{
                                $r = ERROR_ADD_DESEMBOLSO;
                        }
		}
        return $r;
    }	
    function deleteDesembolso($id){
        $tabla = "desembolso";
        $predicado = "des_id = ". $id;
        $r = $this->db->borrarRegistro($tabla,$predicado);
        return $r;
    }
}
?>