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
* Clase ComunicadoData
* Usada para la definicion de todas las funciones propias del objeto COMUNICADO
*
* @package  clases
* @subpackage datos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/

Class CComunicadoData{
    var $db = null;
	
	function CComunicadoData($db){
		$this->db = $db;
	}
	

	function getTipoNombreById($id){		
		$tabla='documento_tipo';
		$campo='dti_nombre';
		$predicado='dti_id = '. $id;
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
	}
	function getTemaNombreById($id){		
		$tabla='documento_tema';
		$campo='dot_nombre';
		$predicado='dot_id = '. $id;
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
	}
	function getSubtemaNombreById($id){		
		$tabla='documento_subtema';
		$campo='dos_nombre';
		$predicado='dos_id = '. $id;
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
	}
	function getSubtemas($criterio,$orden){
		$subtemas = null;
		$sql = "select * from documento_subtema where ". $criterio ." order by ".$orden;
		//echo($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$subtemas[$cont]['id'] = $w['dos_id'];
				$subtemas[$cont]['nombre'] = $w['dos_nombre'];
				$cont++;
			}
		}
		return $subtemas;
	}

	function getAutores($criterio,$orden){
		$autores = null;
		$sql = "select * from documento_actor where ". $criterio ." order by ".$orden;
		$r = $this->db->ejecutarConsulta($sql);
		//echo ($sql."<br>");
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$autores[$cont]['id'] = $w['doa_id'];
				$autores[$cont]['nombre'] = $w['doa_nombre'];
				$cont++;
			}
		}
		return $autores;
	}
	
	function getDestinatarios($criterio,$orden){
		$destinatarios = null;
		$sql = "select * from documento_actor where ". $criterio ." order by ".$orden;
		//echo ($sql."<br>");
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$destinatarios[$cont]['id'] = $w['doa_id'];
				$destinatarios[$cont]['nombre'] = $w['doa_nombre'];
				$cont++;
			}
		}
		return $destinatarios;
	}
	
	function getDirectorioOperador($id){		
		$tabla='operador';
		$campo='ope_sigla';
		$predicado='ope_id = '. $id;
		if(!isset($id))
		   $predicado='ope_id=1';
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		$r = $r."/";
		if($r) return $r; else return -1;
	}
	function calculardias($fecha1, $fecha2){ 
		$dato1 = explode("-", $fecha1);   
		$dato2 = explode("-", $fecha2);   
		//defino fecha 1 
		$ano1 = $dato1[0]; 
		$mes1 = $dato1[1]; 
		$dia1 = $dato1[2]; 

		//defino fecha 2 
		$ano2 = $dato2[0]; 
		$mes2 = $dato2[1]; 
		$dia2 = $dato2[2]; 

		//calculo timestam de las dos fechas 
		$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1); 
		// echo ("$timestamp1"."<br>");  
		$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2); 
		// echo ("$timestamp2"."<br>"); 
		$segundos_diferencia = $timestamp2 - $timestamp1; //resto a una fecha la otra 
		// echo ("$segundos_diferencia"."<br>"); 
		$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); //convierto segundos en días 
		$dias_diferencia = round($dias_diferencia); //obtengo el valor absoulto de los días (quito el posible signo negativo) 

		return $dias_diferencia; 
	} 
	function getComunicados($criterio,$orden,$dirOperador){
		$comunicados = null;
		$sql = "select d.doc_id, d.dti_id, ti.dti_nombre, tm.dot_nombre,
					   d.dot_id, d.dos_id, d.doa_id_autor,
					   d.doa_id_dest, d.doc_fecha_radicado,
					   d.doc_referencia_respondido,  d.doc_referencia, d.doc_descripcion, d.doc_archivo,d.doc_fecha_respuesta,
					   sd.dos_nombre,d.doc_alarma,u.*
				from documento_comunicado d
				inner join documento_tipo 	 ti on d.dti_id = ti.dti_id
				inner join documento_tema    tm on d.dot_id = tm.dot_id
				inner join documento_subtema sd on d.dos_id = sd.dos_id
				inner join usuario            u on d.usu_id = u.usu_id
				where ". $criterio ." 
				order by ".$orden;
		//echo("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$comunicados[$cont]['id'] = $w['doc_id'];
				$comunicados[$cont]['subtema'] = $w['dos_nombre'];
				$comunicados[$cont]['responsable'] = $w['usu_nombre']."<br>".$w['usu_apellido'];
				$comunicados[$cont]['descripcion'] = $w['doc_descripcion'];
				$comunicados[$cont]['archivo'] ="<a href='././soportes/".$dirOperador.$w['dti_nombre']."/".$w['dot_nombre']."/".$w['doc_archivo']."' target='_blank'>{$w['doc_archivo']}</a>";
				$comunicados[$cont]['fecha_radicado'] = $w['doc_fecha_radicado'];
				$comunicados[$cont]['fecha_respuesta'] = "";
				if($w['doc_fecha_respuesta']!="0000-00-00") {$comunicados[$cont]['fecha_respuesta'] = $w['doc_fecha_respuesta'];
					
				
				}
				$comunicados[$cont]['referencia'] = $w['doc_referencia'];
                 
				$tabla='documento_comunicado';
				$campo='doc_archivo';
				$predicado='doc_id = '. $w['doc_referencia_respondido'];
				$referencia_respuesta = $this->db->recuperarCampo($tabla,$campo,$predicado);
				$tabla='documento_comunicado dc 
						inner join documento_tipo dti on dti.dti_id=dc.dti_id
						inner join documento_tema dot on dot.dot_id=dc.dot_id';
				$campo="concat(dti_nombre,'/',dot_nombre)";
				$predicado='doc_id = '. $w['doc_referencia_respondido'];
				//echo ("<br>referencia:".$referencia_respuesta);
				$path = $this->db->recuperarCampo($tabla,$campo,$predicado);
				$comunicados[$cont]['referencia_respondido'] = "<a href='././soportes/".$dirOperador.$path."/".$referencia_respuesta."' target='_blank'>{$referencia_respuesta}</a>";
				if ($w['doc_alarma']==1){
		 		    $dias = $this->calculardias ($w['doc_fecha_respuesta'],date("Y-m-d"));
					$tabla='festivos_colombia';
					$campo='count(*)';
					$predicado='fes_id >="'. $w['doc_fecha_respuesta'].'" and fes_id <="'.date("Y-m-d").'"';
					$dias_festivos = $this->db->recuperarCampo($tabla,$campo,$predicado);
					$dato = $w['doc_fecha_respuesta'];
					
					$fin_de_semana=0;
					for($i=1;$i<=$dias;$i++){
					
						$dato = date("Y-m-d", strtotime("$dato +1 day")); 
						//echo ("<br>dato:".$dato);
						$dato_fecha = explode("-", $dato);  						
						//defino fecha 1 
						$year = $dato_fecha[0]; 
						$mes  = $dato_fecha[1]; 
						$dia  = $dato_fecha[2]; 
						//echo ("<br>dia de la semana:".date('D', mktime (0, 0, 0, $mes, $dia, $year)));
						if (date('D', mktime (0, 0, 0, $mes, $dia, $year))=="Sat" || date('D', mktime (0, 0, 0, $mes, $dia, $year)) == "Sun")
							$fin_de_semana++;
					}
					$dias_habiles=$dias-$dias_festivos-$fin_de_semana;
					if($dias_habiles<=10) $comunicados[$cont]['semaforo']= "<a><img src= './templates/img/ico/amarillo.gif'  border='0'  width='20'  alt=''></a>"."(".$dias_habiles.")";
					else $comunicados[$cont]['semaforo']= "<a><img src= './templates/img/ico/rojo.gif'  border='0'  width='20'  alt=''></a>"."(".$dias_habiles.")";
				}
			    else{ 
				if($w['doc_referencia_respondido']!='' && $w['doc_referencia_respondido']!=-1) $comunicados[$cont]['semaforo']= "<a><img src= './templates/img/ico/verde.gif'  border='0'  width='20'  alt=''></a>";
				else $comunicados[$cont]['semaforo']= "No requiere";
				}
				$cont++;
			}
		}
		return $comunicados;
	}
		
	function getComunicadoById($id){
		$sql = "select d.doc_id, d.dti_id, 
					d.dot_id, d.dos_id, 
					d.doa_id_autor, d.doa_id_dest, 
		  			d.doc_fecha_radicado, 
					d.doc_referencia, d.doc_descripcion, 
	 				d.doc_archivo, 
	  				td.dti_nombre, tm.dot_nombre, 
					sd.dos_nombre, ad.doa_nombre as autor, 
					dd.doa_nombre as destinatario, d.usu_id,
					d.doc_fecha_respuesta,d.doc_alarma,
					us.usu_apellido, us.usu_nombre,
	 				d.doc_fecha_respondido,
					d.doc_referencia_respondido
				from documento_comunicado d
				inner join documento_tipo td on d.dti_id = td.dti_id
				inner join documento_tema tm on d.dot_id = tm.dot_id
				inner join documento_subtema sd on d.dos_id = sd.dos_id
				inner join documento_actor ad on d.doa_id_autor = ad.doa_id
				inner join documento_actor dd on d.doa_id_dest = dd.doa_id 
				inner join documento_equipo de on d.doa_id_dest = de.doa_id and de.usu_id=d.usu_id
				inner join usuario us on de.usu_id = us.usu_id
				where d.doc_id = ". $id;
		//echo ("<br>".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}
	
	function insertComunicado(	$tipo,$tema,$subtema,$autor,
								$destinatario,$fecha_radicacion,
								$referencia,$descripcion,$archivo,$responsable,
								$fecha_respuesta,$alarma,$operador){
		$tabla = "documento_comunicado";
		$campos = "dti_id,dot_id,dos_id,doa_id_autor,doa_id_dest,doc_fecha_radicado,
				   doc_referencia,doc_descripcion,doc_archivo,usu_id,doc_fecha_respuesta,doc_alarma,ope_id";
		$valores = "'".$tipo."','".$tema."','".$subtema."',
					'".$autor."','".$destinatario."','".$fecha_radicacion."',
					'".$referencia."','".$descripcion."','".$archivo."','".$responsable."',
					'".$fecha_respuesta."','".$alarma."','".$operador."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function updateComunicado($id,$tipo,$tema,$subtema,$autor,
												$destinatario,$fecha_radicacion,
												$referencia,$descripcion,$responsable,
												$fecha_respuesta,$alarma,
												$fecha_respondido,$referencia_respondido){
		$tabla = "documento_comunicado";
		$campos = array('dti_id', 'dot_id', 'dos_id', 'doa_id_autor', 'doa_id_dest',  'doc_fecha_radicado', 'doc_referencia', 
										'doc_descripcion','usu_id','doc_fecha_respuesta','doc_alarma',
										'doc_fecha_respondido','doc_referencia_respondido');
		$valores = array($tipo,$tema,$subtema,$autor,
							$destinatario,"'".$fecha_radicacion."'",
							"'".$referencia."'","'".$descripcion."'","'".$responsable."'",
							"'".$fecha_respuesta."'","'".$alarma."'",
							"'".$fecha_respondido."'","'".$referencia_respondido."'");
			
		$condicion = "doc_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}

	function updateComunicadoArchivo($id,$tipo,$tema,$subtema,$autor,
												$destinatario,$fecha_radicacion,
												$referencia,$descripcion,$archivo,$responsable,
												$fecha_respuesta,$alarma,
												$fecha_respondido,$referencia_respondido){
												
		$tabla = "documento_comunicado";
		$campos = array('dti_id', 'dot_id', 'dos_id', 'doa_id_autor', 'doa_id_dest','doc_fecha_radicado', 'doc_referencia', 
										'doc_descripcion','usu_id','doc_fecha_respuesta','doc_alarma',
										'doc_fecha_respondido','doc_referencia_respondido','doc_archivo');
		$valores = array($tipo,$tema,$subtema,$autor,
							$destinatario,"'".$fecha_radicacion."'",
							"'".$referencia."'","'".$descripcion."'","'".$responsable."'",
							"'".$fecha_respuesta."'","'".$alarma."'",
							"'".$fecha_respondido."'","'".$referencia_respondido."'","'".$archivo."'");
			
		$condicion = "doc_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	
	function updateAlarma($id,$alarma,$fecha_respondido,$referencia_respondido){
		$tabla = "documento_comunicado";
		
		$campos = array('doc_alarma','doc_fecha_respondido','doc_referencia_respondido');
		$valores = array("'".$alarma."'","'".$fecha_respondido."'","'".$referencia_respondido."'");
		$condicion = "doc_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function deleteComunicado($id){
		$tabla = "documento_comunicado";
		$predicado = "doc_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function getSiglaAutor($autor){
		$tabla = 'documento_actor';
		$campo = 'doa_sigla';
		$predicado = 'doa_id = '.$autor;
		
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
	
	}

	function getReferenciasByAutor($criterio,$orden){
		$tipos = null;
		$sql = "select * from documento_comunicado d
				inner join documento_actor a on a.doa_id=d.doa_id_autor
		        where ".$criterio."
				  order by ".$orden;
		//echo ($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$tipos[$cont]['id'] = $w['doc_id'];
				$tipos[$cont]['nombre'] = $w['doc_referencia'];
				$cont++;
			}
		}
		return $tipos;
	}
	
	function getConteoAlarmas($criterio){
		$tabla = 'documento_comunicado d';
		$campo = 'count(1)';
		$predicado = "d.doc_alarma = 1";
		if($criterio!=''){
			$predicado .= " and ".$criterio;
		}
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		if($r) return $r; else return -1;
	}
	
	function getConteoAlarmasUsuario($id){
		$tabla = 'documento_comunicado d, usuario u';
		$campo = 'count(1)';
		
		$predicado = "d.doc_alarma = 1 and u.usu_id = d.usu_id and d.usu_id=".$id;
		
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		if($r) return $r; else return -1;
	}
			
	function getAlarmas($criterio){
		$predicado = "doc_alarma = 1";
		if($criterio!=''){
			$predicado .= " and ".$criterio;
		}
		//echo("<br>predicado:".$predicado);
		$comunicados = null;
		$sql = "select distinct d.doc_id, d.dti_id, 
					   d.dot_id, d.dos_id, d.doa_id_autor,
					   d.doa_id_dest, d.doc_fecha_radicado,
					   d.doc_referencia, d.doc_descripcion, d.doc_archivo,
					   td.dti_nombre, 
					   tm.dot_nombre, sd.dos_nombre, ad.doa_nombre as autor,
					   d.usu_id, d.doc_fecha_respuesta,d.doc_alarma,
					   us.usu_apellido, us.usu_nombre, dd.doa_nombre as destinatario, d.doc_fecha_respondido
				from documento_comunicado d
				inner join documento_tipo td on d.dti_id = td.dti_id
				inner join documento_tema tm on d.dot_id = tm.dot_id
				inner join documento_subtema sd on d.dos_id = sd.dos_id
				inner join documento_actor ad on d.doa_id_autor = ad.doa_id
				inner join documento_actor dd on d.doa_id_dest = dd.doa_id 
				inner join documento_equipo de on d.doa_id_dest = de.doa_id
				inner join usuario us on d.usu_id = us.usu_id
				where ". $predicado ." 
				order by d.doc_fecha_respuesta";
		//echo ("<br>getAlarmas:".$sql);		
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$comunicados[$cont]['id'] = $w['doc_id'];
				$comunicados[$cont]['tipo'] = $w['dti_nombre'];
				$comunicados[$cont]['tema'] = $w['dot_nombre'];
				$comunicados[$cont]['subtema'] = $w['dos_nombre'];
				$comunicados[$cont]['autor'] = $w['autor'];
				$comunicados[$cont]['destinatario'] = $w['destinatario'];
				$comunicados[$cont]['descripcion'] = $w['doc_descripcion'];
				$comunicados[$cont]['fecha'] = $w['doc_fecha'];
				$comunicados[$cont]['fecha_radicado'] = $w['doc_fecha_radicado'];
				$comunicados[$cont]['responsable'] = $w['usu_apellido']." ".$w['usu_nombre'];
				$comunicados[$cont]['fecha_respuesta'] = $w['doc_fecha_respuesta'];
				$comunicados[$cont]['fecha_respondido'] = $w['doc_fecha_respondido'];
				$comunicados[$cont]['archivo'] = $w['doc_archivo'];
				$comunicados[$cont]['referencia'] = $w['doc_referencia'];
				$cont++;
			}
		}
		return $comunicados;
	}
       
	function getUsersEquipobyDestinatario($criterio,$orden){
		$users = null;
		$sql = "SELECT * 
				FROM documento_equipo de
				INNER JOIN documento_actor da ON da.doa_id = de.doa_id
				INNER JOIN usuario u ON u.usu_id = de.usu_id
				WHERE  ". $criterio ." 
				order by ".$orden;
		//echo ($sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$users[$cont]['id'] = $w['usu_id'];
				$users[$cont]['login'] = $w['usu_login'];
				$users[$cont]['nombre'] = $w['usu_nombre'];
				$users[$cont]['apellido'] = $w['usu_apellido'];
				$users[$cont]['comunicado'] = $w['usu_comunicado'];
				$users[$cont]['telefono'] = $w['usu_telefono'];
				$users[$cont]['celular'] = $w['usu_celular'];
				$users[$cont]['correo'] = $w['usu_correo'];
				$cont++;
			}
		}
		return $users;
	}

	function getResponsableEquipo($id){		
		$tabla='documento_equipo';
		$campo='usu_id';
		$predicado='deq_controla_alarmas="S" and doa_id = '. $id;
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
	}
	

	
}