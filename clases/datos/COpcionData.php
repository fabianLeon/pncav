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
* Clase OpcionData
* Usada para la definicion de todas las funciones propias del objeto OPCION

* @package  clases
* @subpackage datos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/
Class COpcionData{
    var $db = null;
	
	function COpcionData($db){
		$this->db = $db;
	}
	
	function getOpciones($criterio,$orden){
		$opciones = null;
		$sql = "SELECT opc1.* , op.ope_nombre , opc2.opc_nombre as padre , opn_nombre  AS nivel
                        FROM opcion AS opc1  LEFT JOIN 
                                 operador op ON op.ope_id = opc1.ope_id LEFT JOIN 
                                 opcion AS opc2 ON opc1.opc_padre_id = opc2.opc_id LEFT JOIN
                                 opcion_nivel AS nivel ON nivel.opn_id = opc1.opn_id 
                        WHERE ". $criterio ." ORDER BY  ".$orden;
		//echo ("<br>getOpciones:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$opciones[$cont]['id'] = $w['opc_id'];
				$opciones[$cont]['nombre'] = $w['opc_nombre'];
				$opciones[$cont]['variable'] = $w['opc_variable'];
				$opciones[$cont]['url'] = $w['opc_url'];
				$opciones[$cont]['nivel'] = $w['nivel'];
				$opciones[$cont]['padre'] = $w['padre'];
				$opciones[$cont]['orden'] = $w['opc_orden'];
				$opciones[$cont]['layout'] = $w['layout'];
                                $opciones[$cont]['operador'] = $w['ope_nombre'];
				$cont++;
			}
		}
		return $opciones;
	}
	
	
	function insertOpcion($nombre,$variable,$url,$nivel,$padre,$orden,$layout,$operador){
		$tabla = "opcion";
		$campos = "opc_nombre,opc_variable,opc_url,opn_id,opc_padre_id,opc_orden,layout,ope_id";
		$valores = "'".$nombre."','".$variable."',
  					'".$url."','".$nivel."',
					'".$padre."','".$orden."',
					'".$layout."','".$operador."'";
		
                $r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function updateOpcion($id,$nombre,$variable,$url,$nivel,$padre,$orden,$layout,$operador){
		$tabla = "opcion";
		$campos = array('opc_nombre','opc_variable','opc_url','opn_id','opc_padre_id','opc_orden','layout','ope_id');
		$valores = array("'".$nombre."'","'".$variable."'","'".$url."'","'".$nivel."'","'".$padre."'","'".$orden."'","'".$layout."'","'".$operador."'");
		$condicion = "opc_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	
	function deleteOpcion($id){
		$tabla = "opcion";
		$predicado = "opc_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function deleteOpcionPerfiles($id){
		$tabla = "perfil_x_opcion";
		$predicado = "opc_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	
	function getOpcionById($id){
		$opcion = null;
		$sql = "SELECT * 
                        FROM opcion 
                        INNER JOIN operador on operador.ope_id = opcion.ope_id
                        WHERE opc_id = ". $id;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r){
			$opcion["id"] = $r["opc_id"]; 
			$opcion["nombre"] = $r["opc_nombre"];
			$opcion["variable"] = $r["opc_variable"];
			$opcion["url"] = $r["opc_url"];
			$opcion["nivel"] = $r["opn_id"];
                        $opcion["operador"] = $r["ope_id"]==''? "":$r["ope_id"];
			$opcion["padre"] = $r["opc_padre_id"];
			$opcion["orden"] = $r["opc_orden"];
			$opcion["layout"] = $r["layout"];                         
			return $opcion; 
		}else{ 
			return -1;
		}
	}
        
        function getSeeOpcionById($id){
		$opcion = null;
		$sql = "SELECT * 
                        FROM opcion 
                        INNER JOIN operador on operador.ope_id = opcion.ope_id
                        WHERE opc_id = ". $id;
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r){
			$opcion["id"] = $r["opc_id"]; 
			$opcion["nombre"] = $r["opc_nombre"];
			$opcion["variable"] = $r["opc_variable"];
			$opcion["url"] = $r["opc_url"];
			$opcion["nivel"] = $r["opn_id"];
                        $opcion["operador"] = $r["ope_nombre"]==''? "":$r["ope_nombre"];
			$opcion["padre"] = $r["opc_padre_id"];
			$opcion["orden"] = $r["opc_orden"];
			$opcion["layout"] = $r["layout"];                         
			return $opcion; 
		}else{ 
			return -1;
		}
	}
        

	function getNiveles($criterio,$orden){
		$niveles = null;
		$sql = "select * from opcion_nivel where ". $criterio ." order by ".$orden;
		//echo ("<br>getNiveles:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$niveles[$cont]['id'] = $w['opn_id'];
				$niveles[$cont]['nombre'] = $w['opn_nombre'];
				$cont++;
			}
		}
		return $niveles;
	}
	
	function getPadres($nivel,$operador){
		$niveles = null;
		$sql = "SELECT opc_id, opc_nombre 
                        FROM opcion 
                        WHERE opn_id = ". ($nivel - 1) ." AND (ope_id =".$operador.")
                        ORDER BY opc_orden";
		//echo("<br>getPadres:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$niveles[$cont]['id'] = $w['opc_id'];
				$niveles[$cont]['nombre'] = $w['opc_nombre'];
				$cont++;
			}
		}
		return $niveles;
	}
	
	function getContadorOpcionesByNombre($var,$id='-1',$operador){
		$cont = 0;
		$cont = $this->db->recuperarCampo('opcion','count(1)',"opc_nombre = '".$var."' and opc_id <> ".$id." and ope_id=".$operador);
		return $cont;
	}
	
	function getContadorOpcionesByVariable($var,$id='-1',$operador){
		$cont = 0;
		$cont = $this->db->recuperarCampo('opcion','count(1)',"opc_nombre = '".$var."' and opc_id <> ".$id.' and ope_id='.$operador);
		return $cont;
	}
	
	function getContadorOpcionesByUrl($var,$id='-1',$operador){
		$cont = 0;
		$cont = $this->db->recuperarCampo('opcion','count(1)',"opc_nombre = '".$var."' and opc_id <> ".$id.' and ope_id='.$operador);
		return $cont;   
	}
	
	function getContadorOpcionesByOrden($var,$id='-1',$operador){
		$cont = 0;
		$cont = $this->db->recuperarCampo('opcion','count(1)',"opc_nombre = '".$var."' and opc_id <> ".$id.' and ope_id='.$operador);
		return $cont;
	}
        
        function getRutaByVar($var){
            $elementos = NULL;
            $sql = "SELECT `opc_nombre` "
                    . "FROM `opcion` "
                    . "WHERE `opc_variable` = '".$var."' "
                    . "or `opc_id` in "
                        . "(SELECT `opc_padre_id` FROM  `opcion` WHERE `opc_variable` = '".$var."') "
                    . "ORDER BY `opn_id`";
            
            $r = $this->db->ejecutarConsulta($sql);
            if($r){
                    $cont = 0;
                    while($w = mysql_fetch_array($r)){
                            $elementos[$cont]['nombre'] = $w['opc_nombre'];
                            $cont++;
                    }
            }
            return $elementos;
        }
	
}
?>
