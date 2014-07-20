<?php
/**
*/

class CRendimiento{
/**
*identificador unico del rendimiento
*@var integer 
*/
	var $id = null;
	var $operador = null;
	var $mes = null;
	var $rendimiento_generado = null;
	var $descuento = null;
	var $rendimiento_tasa = null;
	var $archivo_consignacion = null;
	var $archivo_emision = null;
	var $fecha_consignacion = null;
/**
*Instancia de la clase CRendimientoData
*@var object 
*/
	var $dr = null;
	var $permitidos = array('pdf','doc','xls','ppt','docx','xlsx','jpg');
/**
*Constructor de la clase
*@param object $dr instancia de la clase CRendimientoData
*/				
	function CRendimiento($id,$operador,$mes,$rendimiento_generado,$descuento,$rendimiento_tasa,$archivo_consignacion,$archivo_emision,$fecha_consignacion,$dr){
		$this->id 					  = $id;
		$this->operador 			  = $operador;
		$this->mes 					  = $mes;
		$this->rendimiento_generado   = $rendimiento_generado;
		$this->descuento 			  = $descuento;
		$this->rendimiento_tasa 	  = $rendimiento_tasa;
		$this->archivo_consignacion   = $archivo_consignacion;
		$this->archivo_emision 		  = $archivo_emision;
		$this->fecha_consignacion 	  = $fecha_consignacion;
		$this->dr 					  = $dr;
	}
/**
*retorna el identificador del rendimiento
*@return integer
*/					
	function getId(){ return $this->id; }
	function getOperador()				{return $this->operador;}
	function getMes()					{return $this->mes;}
	function getRendimientoGenerado()	{return $this->rendimiento_generado;}
	function getDescuento()				{return $this->descuento;}
	function getRendimientoTasa() 		{return $this->rendimiento_tasa;}
	function getArchivoConsignacion()	{return $this->archivo_consignacion;}
	function getArchivoEmision()		{return $this->archivo_emision;}
	function getFechaConsignacion()		{return $this->fecha_consignacion;}
/**
*almacena un rendimiento, validando la no existencia del nombre ingresado y retorna un mensaje del resultado del proceso
*@return string
*/				
	function saveNewRendimiento($archivo1,$archivo2,$nombreOperador){
		$r = "";
		
		$extension1 = explode(".",$archivo1['name']);
		$extension2 = explode(".",$archivo2['name']);
		$noMatch = 0;
		
		$num = count($extension1)-1;
		foreach( $this->permitidos as $p ) {
			if ( strcasecmp( $extension1[$num], $p ) == 0 ) $noMatch = 1;
		}
		$num = count($extension2)-1;
		foreach( $this->permitidos as $p ) {
			if ( strcasecmp( $extension2[$num], $p ) == 0 ) $noMatch = 1;
		}
		
		if($archivo1['name']!=null && $archivo2['name']!=null){
			if($noMatch==1){
				if($archivo1['size'] < MAX_SIZE_DOCUMENTOS || $archivo2['size'] < MAX_SIZE_DOCUMENTOS ){
					$ruta = RUTA_RENDIMIENTOS."/".$nombreOperador."/";
										
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
					
					if(!move_uploaded_file($archivo1['tmp_name'], strtolower($ruta).$archivo1['name']) ||
					   !move_uploaded_file($archivo2['tmp_name'], strtolower($ruta).$archivo2['name'])){
					//echo("hola:");
						$r = ERROR_COPIAR_ARCHIVO;
					}else{
						$this->archivo_consignacion=$archivo1['name'];
						$this->archivo_emision=$archivo2['name'];
						$i = $this->dr->insertRendimiento($this->operador,$this->mes,$this->rendimiento_generado,$this->descuento,$this->rendimiento_tasa,
										  $this->archivo_consignacion,$this->archivo_emision,$this->fecha_consignacion);
						if($i == "true"){
							$r = RENDIMIENTO_AGREGADO;
						}else{
							$r = ERROR_ADD_RENDIMIENTO;
							
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
*carga los valores de un rendimiento por su id
*/				
	function loadRendimiento(){
		$r = $this->dr->getRendimientoById($this->id);
		
		if($r != -1){
			$this->operador 			  = $r['ope_id'];
			$this->mes 					  = $r['mec_id'];
			$this->rendimiento_generado   = $r['ren_generado'];
			$this->descuento 			  = $r['ren_descuento'];
			$this->rendimiento_tasa 	  = $r['ren_tasa'];
			$this->archivo_consignacion   = $r['ren_archivo_consignacion'];
			$this->archivo_emision 		  = $r['ren_archivo_emision'];
			$this->fecha_consignacion 	  = $r['ren_fecha'];
		}else{
			$this->operador 			  = "";
			$this->mes 					  = "";
			$this->rendimiento_generado   = "";
			$this->descuento 			  = "";
			$this->rendimiento_tasa = "";
			$this->archivo_consignacion   = "";
			$this->archivo_emision 		  = "";
			$this->fecha_consignacion 	  = "";
		}
	}
/**
*borra un rendimiento y retorna un mensaje del resultado del proceso
*@return string
*/			
	function deleteRendimiento(){
		$r = $this->dr->deleteRendimiento($this->id);
		if($r=='true'){
			$msg = RENDIMIENTO_BORRADO;		
		}else{
			$msg = ERROR_DEL_RENDIMIENTO;
		}
		return $msg;
	}

/**
*actualiza los valores de un rendimiento y retorna un mensaje del resultado del proceso
*@return string
*/			
	function saveEditRendimiento(){
		$r = $this->dr->updateRendimiento($this->id,$this->rendimiento_generado,$this->descuento,$this->rendimiento_tasa,
										  $this->archivo_consignacion,$this->archivo_emision,$this->fecha_consignacion);
		if($r=='true'){
			$msg = RENDIMIENTO_EDITADO;
		}else{
			$msg = ERROR_EDIT_RENDIMIENTO;
		}
		return $msg;
	}
	
}
?>