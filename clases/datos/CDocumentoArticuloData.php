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
* Clase DocumentoArticuloData
* Usada para la definicion de todas las funciones propias del objeto ARTICULO
*
* @package  clases
* @subpackage datos
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/
Class CDocumentoArticuloData{
    var $db = null;
	
	function CDocumentoArticuloData($db){
		$this->db = $db;
	}
	
	function getDocumentosSubtema($criterio,$orden){
		$salida = null;
		$sql = "select * from documento_subtema 
				where ". $criterio ." order by ".$orden;
		//echo ("<br>getDocumentosSubtema:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$salida[$cont]['id'] = $w['dos_id'];
				$salida[$cont]['nombre'] = $w['dos_nombre'];
				$cont++;
			}
		}
		return $salida;
	}

	function getSubtema($id){		
		$tabla='documento';
		$campo='dos_id';
		$predicado='doc_id = '. $id;
		$r = $this->db->recuperarCampo($tabla,$campo,$predicado);
		
		if($r) return $r; else return -1;
	}
	function getArticuloById($id){
		$validacion = null;
		$sql = "SELECT  *
			FROM  documento_articulo a
			WHERE doa_id= ". $id ;
		//echo ("<br>getArticuloById:".$sql);
		$r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
		if($r) return $r; else return -1;
	}

	function getAlcances($criterio,$orden){
		$alcances = null;
		$sql = "SELECT  a.* 
				FROM  alcance a 
				INNER JOIN operador o ON o.ope_id = a.ope_id
                WHERE  ". $criterio ."  order by ".$orden;
		//echo ("<br>getAlcances:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$alcances[$cont]['id'] 		= $w['alc_id'];
				$alcances[$cont]['nombre'] 	= $w['alc_nombre'];
				$cont++;
			}
		}
		return $alcances;
	}
	function getArticulos($criterio){
		$salida = null;
		$sql = "SELECT *
                        FROM documento_articulo a 
						INNER JOIN alcance 			 al  ON a.alc_id=al.alc_id 
						INNER JOIN documento 		 d   ON d.doc_id=a.doc_id 
						INNER JOIN documento_subtema dos ON d.dos_id=dos.dos_id 
                        WHERE   ". $criterio ;
		//echo ("<br>getArticulos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$salida[$cont]['id'] 				= $w['doa_id'];
				$salida[$cont]['alc_nombre'] 			= $w['alc_nombre'];
				$salida[$cont]['doc_version'] 		= $w['dos_nombre'].' '.$w['doc_version'];
				$salida[$cont]['doa_nombre'] 		= $w['doa_nombre'];
				$salida[$cont]['doa_descripcion'] 	= $w['doa_descripcion'];
				$cont++;
			}
		}
		return $salida;
	}

	function getDocumentos($criterio,$orden){
		$salida = null;
		$sql = "SELECT * 
                        FROM   documento d INNER JOIN 
                               documento_tipo     tipo ON d.dti_id = tipo.dti_id INNER JOIN  
                               documento_subtema 	ds on ds.dos_id=d.dos_id
                        WHERE  ". $criterio ." ORDER BY ".$orden;
		//echo ("<br>getDocumentos:".$sql);
		$r = $this->db->ejecutarConsulta($sql);
		if($r){
			$cont = 0;
			while($w = mysql_fetch_array($r)){
				$salida[$cont]['id'] = $w['doc_id'];
				$salida[$cont]['nombre'] = $w['dos_nombre']."-".$w['doc_version'];
				$cont++;
			}
		}
		return $salida;
	}
	
	
	function insertArticulo($alcance,$norma,$nombre,$descripcion){
		$tabla = "documento_articulo";
		$campos = "alc_id,doc_id,doa_nombre,doa_descripcion";
		$valores = "'".$alcance."','".$norma."','".$nombre."','".$descripcion."'";
		$r = $this->db->insertarRegistro($tabla,$campos,$valores);
		return $r;
	}
	
	function deleteArticulo($id){
		$tabla = "documento_articulo";
		$predicado = "doa_id = ". $id;
		$r = $this->db->borrarRegistro($tabla,$predicado);
		return $r;
	}
	function updateArticulo($id,$nombre,$descripcion){
							  
		$tabla = "documento_articulo";
		$campos = array('doa_nombre','doa_descripcion');
		$valores = array("'".$nombre."'","'".$descripcion."'");			
		$condicion = "doa_id = ".$id;
		$r = $this->db->actualizarRegistro($tabla,$campos,$valores,$condicion);
		return $r;
	}
	

}