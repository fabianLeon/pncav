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
* Clase Comunicado
*
* @package  clases
* @subpackage aplicacion
* @author Redcom Ltda
* @version 2013.01.00
* @copyright SERTIC - MINTICS
*/

Class CComunicado{
	var $id = null;
	var $tipo = null;
	var $tema = null;
	var $subtema = null;
	var $autor = null;
	var $destinatario = null;
	var $fecha_radicacion = null;
	var $referencia = null;
	var $descripcion = null;
	var $responsable = null;
	var $fecha_respuesta = null;
	var $alarma = null;
	var $fecha_respondido = null;
	var $referencia_respondido = null;
    var $operador = null;	
    var $dd = null;

	var $permitidos = array('pdf','doc','xls','ppt','docx','xlsx','gif','jpg','png','tif','zip','rar');
/**
** Constructor de la clase CComunicadoData
**/				
	function CComunicado($id,$tipo,$tema,$subtema,$autor,$destinatario,
											$fecha_radicacion,$referencia,$descripcion,$responsable,
											$fecha_respuesta,$alarma,$fecha_respondido,$referencia_respondido,
											$operador,$dd){
		$this->id 					= $id;
		$this->tipo 				= $tipo;
		$this->tema 				= $tema;
		$this->subtema 				= $subtema;
		$this->autor 				= $autor;
		$this->destinatario 		= $destinatario;
		$this->fecha_radicacion 	= $fecha_radicacion;
		$this->referencia 			= $referencia;
		$this->descripcion 			= $descripcion;
		$this->responsable 			= $responsable;
		$this->fecha_respuesta 		= $fecha_respuesta;
		$this->alarma 				= $alarma;
		$this->fecha_respondido 	= $fecha_respondido;
		$this->referencia_respondido= $referencia_respondido;
		$this->operador				= $operador;
		$this->dd 					= $dd;
	}
	function getId(){					return $this->id;					}
	function getTipo(){ 				return $this->tipo;					}
	function getTema(){ 				return $this->tema;					}
	function getSubtema(){ 				return $this->subtema;				}
	function getAutor(){ 				return $this->autor;				}
	function getDestinatario(){ 		return $this->destinatario;			}
	function getFechaRadicacion(){ 		return $this->fecha_radicacion;		}
	function getReferencia(){ 			return $this->referencia;			}
	function getDescripcion(){ 			return $this->descripcion;			}
	function getArchivo(){ 				return $this->archivo;				}
	function getResponsable(){ 			return $this->responsable;			}
	function getFechaRespuesta(){ 		return $this->fecha_respuesta;		}
	function getAlarma(){ 				return $this->alarma;				}
	function getFechaRespondido(){ 		return $this->fecha_respondido;		}
	function getReferenciaRespondido(){ return $this->referencia_respondido;}
	function getOperador(){ 			return $this->operador;				}
/**
** carga los valores de un objeto COMUNICADO por su id para ser editados
**/				
	function loadComunicado(){
	
		$r = $this->dd->getComunicadoById($this->id);

		if($r != -1){
			$this->tipo 				= $r['dti_id'];
			$this->tema 				= $r['dot_id'];
			$this->subtema 				= $r['dos_id'];
			$this->autor 				= $r['doa_id_autor'];
			$this->destinatario 		= $r['doa_id_dest'];
			$this->fecha_radicacion 	= $r['doc_fecha_radicado'];
			$this->referencia 			= $r['doc_referencia'];
			$this->descripcion 			= $r['doc_descripcion'];
			$this->archivo 				= $r['doc_archivo'];
			$this->responsable 			= $r['usu_id'];
			$this->fecha_respuesta 		= $r['doc_fecha_respuesta'];
			$this->alarma				= $r['doc_alarma'];
			$this->fecha_respondido 	= $r['doc_fecha_respondido'];
			$this->referencia_respondido= $r['doc_referencia_respondido'];
		}else{
			$this->tipo 				= "";
			$this->tema 				= "";
			$this->subtema 				= "";
			$this->autor 				= "";
			$this->destinatario 		= "";
			$this->fecha_creacion 		= "";
			$this->fecha_radicacion 	= "";
			$this->referencia 			= "";
			$this->descripcion 			= "";
			$this->archivo 				= "";
			$this->responsable 			= "";
			$this->fecha_respuesta 		= "";
			$this->alarma 				= "";
			$this->fecha_respondido 	= "";
			$this->referencia_respondido= "";
		}
	}
/**
** carga los valores de un objeto COMUNICADO por su id para ser editados
**/				
	function loadSeeComunicado(){
	
		$r = $this->dd->getComunicadoById($this->id);
		
		if($r != -1){
			$this->tipo 				= $r['dti_nombre'];
			$this->tema 				= $r['dot_nombre'];
			$this->subtema 				= $r['dos_nombre'];
			$this->autor 				= $r['autor'];
			$this->destinatario 		= $r['destinatario'];
			$this->fecha_radicacion 	= $r['doc_fecha_radicado'];
			$this->referencia 			= $r['doc_referencia'];
			$this->descripcion 			= $r['doc_descripcion'];
			$this->archivo 				= $r['doc_archivo'];
			$this->responsable 			= $r['usu_nombre'];
			$this->fecha_respuesta 		= $r['doc_fecha_respuesta'];
			$this->alarma				= $r['doc_alarma'];
			$this->fecha_respondido 	= $r['doc_fecha_respondido'];
		}else{
			$this->tipo 				= "";
			$this->tema 				= "";
			$this->subtema 				= "";
			$this->autor 				= "";
			$this->destinatario 		= "";
			$this->fecha_creacion 		= "";
			$this->fecha_radicacion 	= "";
			$this->referencia 			= "";
			$this->descripcion 			= "";
			$this->archivo 				= "";
			$this->responsable 			= "";
			$this->fecha_respuesta 		= "";
			$this->alarma 				= "";
			$this->fecha_respondido 	= "";
		}
	}
/**
** almacena un objeto COMUNICADO y retorna un mensaje del resultado del proceso
**/				
	function saveNewComunicado($archivo){
		$r = "";
		$extension = explode(".",$archivo['name']);
		$num = count($extension)-1;
		$noMatch = 0;
		foreach( $this->permitidos as $p ) {
			if ( strcasecmp( $extension[$num], $p ) == 0 ) $noMatch = 1;
		}
		if($archivo['name']!=null){
			if($noMatch==1){
				if($archivo['size'] < MAX_SIZE_DOCUMENTOS){
					$tipo = $this->dd->getTipoNombreById ($this->tipo);
					$tema = $this->dd->getTemaNombreById ($this->tema);
					$subtema = $this->dd->getSubtemaNombreById ($this->subtema);
										
					$dirOperador=$this->dd->getDirectorioOperador($this->operador);
										
					$ruta = RUTA_DOCUMENTOS."/".$dirOperador.$tipo."/".$tema."/";
					
					//echo ("<br>ruta".$ruta);
					//echo ("<br>nombre".$archivo['name']);
					$carpetas = explode("/",substr($ruta,3,strlen($ruta)-1));
					$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
					$ruta_destino = '';
										
					foreach($carpetas as $c){
						$ruta_destino .= "/".strtolower($c);
						if(!is_dir($ruta_destino)) {
							mkdir($ruta_destino,0777);}
						else {
							chmod($ruta_destino, 0777);
						}
					}
					if(!move_uploaded_file($archivo['tmp_name'], strtolower($ruta).$archivo['name'])){
						$r = ERROR_COPIAR_ARCHIVO;
					}else{

						$this->archivo=$archivo['name'];
						if ($this->responsable == null || $this->responsable == -1  ){
							$this->responsable = $this->dd->getResponsableEquipo($this->destinatario);
						}
						$i = $this->dd->insertComunicado($this->tipo,$this->tema,$this->subtema,$this->autor,
												   		$this->destinatario,$this->fecha_radicacion,
												   		$this->referencia,$this->descripcion,$this->archivo,$this->responsable,
														$this->fecha_respuesta,$this->alarma,$this->operador);
						if($i == "true"){
							$r = COMUNICADO_AGREGADO;
						}else{
							$r = ERROR_ADD_COMUNICADO;
						}
					}
				}else{
					$r = ERROR_SIZE_ARCHIVO;
				}
			}else{
				$r = ERROR_FORMATO_ARCHIVO;
			}
		}else{
			$r = ERROR_CONFIGURACION_RUTA;
		}
		return $r;
	
	}
/**
** elimina un objeto COMUNICADO y retorna un mensaje del resultado del proceso
**/				
	function deleteComunicado($archivo){
		$tipo = $this->dd->getTipoNombreById ($this->tipo);
		$tema = $this->dd->getTemaNombreById ($this->tema);
		$subtema = $this->dd->getSubtemaNombreById ($this->subtema);
		$dirOperador=$this->dd->getDirectorioOperador($this->operador);
		$ruta = RUTA_DOCUMENTOS."/".$dirOperador.$tipo."/".$tema."/";
		//echo("<br>ruta:".$ruta);
		chmod($ruta, 0777);
		$r = $this->dd->deleteComunicado($this->id);
		if($r=='true'){
			unlink(strtolower($ruta).$archivo);
			$msg = COMUNICADO_BORRADO;		
		}else{
			$msg = ERROR_DEL_COMUNICADO;
		}
		return $msg;
	}
/**
** actualiza un objeto COMUNICADO y retorna un mensaje del resultado del proceso
**/				
	function saveEditComunicado($archivo,$archivo_anterior){
			$r = "";
			
			$extension = explode(".",$archivo['name']);
			$num = count($extension)-1;
			
			$noMatch = 0;
			foreach( $this->permitidos as $p ) {
				if ( strcasecmp( $extension[$num], $p ) == 0 ) $noMatch = 1;
			}

			if($archivo['name']!=null){
				if($noMatch==1){
					if($archivo['size'] < MAX_SIZE_DOCUMENTOS){
						$tipo = $this->dd->getTipoNombreById ($this->tipo);
						$tema = $this->dd->getTemaNombreById ($this->tema);
						$subtema = $this->dd->getSubtemaNombreById ($this->subtema);
						$dirOperador=$this->dd->getDirectorioOperador($this->operador);
						$ruta = RUTA_DOCUMENTOS."/".$dirOperador.$tipo."/".$tema."/";
						$carpetas = explode("/",substr($ruta,3,strlen($ruta)-1));
						$cad = $_SERVER['DOCUMENT_ROOT'].$_SERVER['PHP_SELF'];
						$ruta_destino = '';
						foreach($carpetas as $c){
							$ruta_destino .= "/".strtolower($c);
							if(!is_dir($ruta_destino)) {
								mkdir($ruta_destino,0777);}
							else {
								chmod($ruta_destino, 0777);
							}
						}
						unlink(strtolower($ruta).$archivo_anterior);
						if(!move_uploaded_file($archivo['tmp_name'], strtolower($ruta).$archivo['name'])){
							$r = ERROR_COPIAR_ARCHIVO;
						}else{
							$this->nombre=$archivo['name'];
						if ($this->responsable == null || $this->responsable == -1  ){
								$this->responsable = $this->dd->getResponsableEquipo($this->destinatario);
							}
							$i = $this->dd->updateComunicadoArchivo($this->id,$this->tipo,$this->tema,$this->subtema,$this->autor,
															$this->destinatario,$this->fecha_radicacion,
															$this->referencia,$this->descripcion,$this->nombre,$this->responsable,
															$this->fecha_respuesta,$this->alarma,
															$this->fecha_respondido,$this->referencia_respondido);
							if($i == "true"){
								$r = COMUNICADO_EDITADO;
							}else{
								$r = ERROR_EDIT_COMUNICADO;
							}
						}
					}else{
						$r = ERROR_SIZE_ARCHIVO;
					}
				}else{
					$r = ERROR_FORMATO_ARCHIVO;
				}
				return $r;
			}else{
				if ($this->responsable == null){
					$this->responsable = $this->dd->getResponsableEquipo($this->destinatario);
				}
				$r = $this->dd->updateComunicado($this->id,$this->tipo,$this->tema,$this->subtema,$this->autor,
															$this->destinatario,$this->fecha_radicacion,
															$this->referencia,$this->descripcion,$this->responsable,
															$this->fecha_respuesta,$this->alarma,
															$this->fecha_respondido,$this->referencia_respondido);
				if($r=='true'){
					$msg = COMUNICADO_EDITADO;
				}else{
					$msg = ERROR_EDIT_COMUNICADO;
				}
				return $msg;
			}
	}
/**
** almacena un objeto ALARMA y retorna un mensaje del resultado del proceso
**/				
	function saveEditAlarma(){
	
		$r = $this->dd->updateAlarma($this->id,$this->alarma,$this->fecha_respondido,$this->referencia_respondido);
		if($r=='true'){
			$msg = COMUNICADO_EDITADO;
		}else{
			$msg = ERROR_EDIT_COMUNICADO;
		}
		
		return $msg;	
	}
}
?>