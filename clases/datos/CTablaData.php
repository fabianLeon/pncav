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
* Clase TablaData
* Usada para la definicion de todas las funciones propias del objeto TABLA
*
* @package  clases
* @subpackage datos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/
Class CTablaData{
    var $db = null;
	
	function CTablaData($db){
		$this->db = $db;
	}
	
	function getCampos($tabla){
		$sql = "show fields from ".$tabla;
		//echo ("<br>sql:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		
		$campos = null;
		while($w = mysql_fetch_array($r)){
			$campos[count($campos)]=$w[0];
			//echo ("<br>campos:".$campos[count($campos)]);
			}
		return $campos;		
	}
	
	function getRegistros($tabla,$campos,$relacion_tablas,$criterio){
		$registros = null;
		$sql = "select ";
		foreach($campos as $c){
			if($relacion_tablas[$tabla][$c]['campo']==$c){
				$sql .= $relacion_tablas[$tabla][$c]['tabla'].".".$relacion_tablas[$tabla][$c]['remplazo'].",";
			}else{
				$sql .= $c.",";
			}
		}
		$sql = substr($sql,0,strlen($sql)-1);
		$sql .= " from ".$tabla;
		foreach($campos as $c){
			if($relacion_tablas[$tabla][$c]['campo']==$c){
				$sql .= " inner join ". $relacion_tablas[$tabla][$c]['tabla'] . " on ". $tabla.".".$c ." = ". $relacion_tablas[$tabla][$c]['tabla'].".".$c;
			}
		}	
		$sql .= " where " . $criterio;	
		//echo ("<br>sql:".$sql);
		
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont_registros = 0;
			while($w = mysql_fetch_array($r)){
				$cont_campos = 0;
				foreach($campos as $c){
					$registros[$cont_registros][$cont_campos] = $w[$cont_campos];
					$cont_campos++;
				}
				$cont_registros++;
			}
		}
		return $registros;
	}
	
	function getTipos($tabla){
		$sql = "select * from " . $tabla ." limit 0,1";
		$result = $this->db->ejecutarConsulta($sql);
		$fields = mysql_num_fields($result);
		$i = 0;
		$tipos = null;		
		while ($i < $fields) {
			$type  = mysql_field_type  ($result, $i);
			$name  = mysql_field_name  ($result, $i);
			$len   = mysql_field_len   ($result, $i);
			$flags = mysql_field_flags ($result, $i);
			$tipos[$name]['type']=$type;
			$tipos[$name]['len']=$len;
			$tipos[$name]['flags']=$flags;
			$i++;
		}
		return $tipos;
	}
	
	function getOpciones($tabla,$campo_id,$campo_nombre){
		$opciones = null;
		$sql = " select ".$campo_id.",".$campo_nombre .
			   " from " .$tabla;
		
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			while($w = mysql_fetch_array($r)){
				$opciones[count($opciones)]=array('value' => $w[$campo_id],'texto' => $w[$campo_nombre]);
			}
		}
		return $opciones;
	}
	
	function saveEditTabla($tabla,$id_elemento,$campos,$valores){
		$f = null;
		$cont = 0;
		foreach($campos as $c){
			if($cont!=0){
				$f[count($f)]=$c;
			}
			$cont++;
		}
		$val=null;
		foreach($valores as $v){
			$val[count($val)]="'".$v."'";
		}
			
		$condicion = $campos[0]." = ".$id_elemento;
		$r = $this->db->actualizarRegistro($tabla,$f,$val,$condicion);
		return $r;
	}
	
	function saveNewTabla($tabla,$campos,$valores){
		$f = null;
		$cont = 0;

		foreach($campos as $c){
			if($cont!=0){
				$f.=$c.",";
			}
			$cont++;
		}
		$f=substr($f,0,strlen($f)-1);
		$val=null;
		foreach($valores as $v){
			$val.="'".$v."',";
		}
		$val=substr($val,0,strlen($val)-1);	
		$condicion = $campos[0]." = ".$id_elemento;
		$r = $this->db->insertarRegistro($tabla,$f,$val);
		return $r;
	}
        
        function deleteTabla($tabla,$predicado){
            $r = $this->db->borrarRegistro($tabla, $predicado);
            return $r;
        }
	
}
?>