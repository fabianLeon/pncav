<?php
/**
*/
Class CInversion{
/**
*identificador unico de la Inversion
*@var integer 
*/
	var $id = null;
/**
*identificador del rubro de la Inversion
*@var integer 
*/
	var $rubro = null;
/**
*fecha de la Inversion
*@var mixed 
*/
	var $fecha = null;
/**
*proveedor de la Inversion
*@var string 
*/
	var $proveedor = null;
/**
*documento del proveedor de la Inversion
*@var string 
*/
	var $documento_proveedor = null;
/**
*monto de la Inversion
*@var float 
*/
	var $monto = null;
/**
*identificador del estado de la Inversion
*@var integer 
*/
	var $observaciones = null;
/**
*nombre del documento soporte
*@var string 
*/
	var $documento = null;
        
/**
*nombre del documento soporte
*@var string 
*/
	var $operador = null;
/**
*Instancia de la clase CInversion1Data
*@var CInversionData 	
*/
	var $dd = null;
/**
*retorna el identificador de la Inversion
*@return integer	
*/
	function getId(){ return $this->id; }
/**
*retorna el identificador del rubro de la Inversion
*@return integer	
*/
	function getRubro(){ return $this->rubro; }
/**
*retorna la fecha de la Inversion
*@return mixed
*/
	function getFecha(){ return $this->fecha; }
/**
*retorna el nombre del proveedor de la Inversion
*@return string
*/
	function getProveedor(){ return $this->proveedor; }
/**
*retorna el documento del proveedor de la Inversion
*@return string
*/
	function getDocumentoProveedor(){ return $this->documento_proveedor; }
/**
*retorna el monto de la Inversion
*@return float	
*/
	function getMonto(){ return $this->monto; }
/**
*retorna el identificador del observaciones de la Inversion
*@return integer
*/
	function getObservaciones(){ return $this->observaciones; }
	
/**
*retorna el documento soporte
*@return string
*/
	function getDocumento(){ return $this->documento; }
        
        function getOperador(){return $this->operador;}
/**arreglo de los tipos de documentos permitidos
*@var array
*/
	var $permitidos = array('pdf','doc','xls','ppt','docx','xlsx');	
/**	
/**
*Constructor de la clase
*
*@param integer $id identificador unico de la Inversion
*@param integer $rubro identificador del rubro de la Inversion
*@param mixed $fecha fecha de la Inversion
*@param string $proveedor nombre del proveedor
*@param string $documento_proveedor documento del proveedor
*@param float $monto monto dela Inversion sin iva
*@param integer $observaciones identificador del observaciones de la Inversion
*@param object $dd instancia de la clase CInversion1Data
*/
	function CInversion($id,$rubro,$fecha,$proveedor,$documento_proveedor,$monto,$observaciones,$documento,$operador,$dd){
		$this->id = $id;
		$this->rubro = $rubro;
		$this->fecha = $fecha;
		$this->proveedor = $proveedor;
		$this->documento_proveedor = $documento_proveedor;
		$this->monto = $monto;
		$this->observaciones=$observaciones;
		$this->documento=$documento;
                $this->operador = $operador;
		$this->dd = $dd;
	}
/**
*carga los montos de los atributos de la clase
*/	
	function loadInversion(){
		$r = $this->dd->getInversionById($this->id);
		if($r != -1){
			$this->rubro = $r['rub_id'];
			$this->fecha = $r['inv_fecha'];
			$this->proveedor = $r['inv_proveedor'];
			$this->documento_proveedor = $r['inv_documento_proveedor'];
			$this->monto = $r['inv_monto'];
			$this->observaciones = $r['inv_observaciones'];
			$this->documento = $r['inv_documento'];
			
		}else{
			$this->rubro = "";
			$this->fecha = "";
			$this->proveedor = "";
			$this->documento_proveedor = "";
			$this->monto = "";
			$this->observaciones = "";
			$this->documento = "";
			
		}
	}
/**
*carga los montos de los atributos de la clase para visualizacion
*/	
	function loadSeeInversion($nombreOperador){
		$r = $this->dd->getInversionById($this->id);
                $ruta = str_replace(getcwd(),'.',(RUTA_INVERSION."/".$nombreOperador));
                
		if($r != -1){
			$this->rubro = $r['rub_id'];
			$this->fecha = $r['inv_fecha'];
			$this->proveedor = $r['inv_proveedor'];
			$this->documento_proveedor = $r['inv_documento_proveedor'];
			$this->monto = $r['inv_monto'];
			$this->observaciones = $r['inv_observaciones'];
			$this->documento = "<a href='".$ruta."/".$r['inv_documento']."' target='_blank'>".$r['inv_documento']."</a>";
		}else{
			$this->rubro = "";
			$this->fecha = "";
			$this->proveedor = "";
			$this->documento_proveedor = "";
			$this->monto = "";
			$this->observaciones = "";
			$this->documento = "";
		}
	}
	
/**
*almacena una nueva Inversion verificando que su monto no exceda lo disponible 
*para ejecutar  y retorna el resultado del proceso
*@param float $monto_anticipado monto anticipado hasta la fecha
*@param float $monto_ejecutado monto ejecutado hasta la fecha
*@return string
*/	
	function saveNewInversion($archivo,$nombreOperador){
		$r = "";
		
		$extension = explode(".",$archivo['name']);
		$num = count($extension)-1;
		$noMatch = 0;
		foreach( $this->permitidos as $p ) {
			if ( strcasecmp( $extension[$num], $p ) == 0 ) $noMatch = 1;
		}
		if($archivo['name']!=null){
			if($noMatch==1){
				if($archivo['size'] < 30000000){
					$ruta = RUTA_INVERSION."/".$nombreOperador."/";
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
						$this->nombre=$archivo['name'];
						$i = $this->dd->insertInversion($this->rubro,$this->fecha,$this->proveedor,
										$this->documento_proveedor,$this->monto,$this->observaciones,$this->nombre,$this->operador);
						if($i == "true"){
							$r = EJECUCION_AGREGADO;
						}else{
							$r = ERROR_ADD_EJECUCION;
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
*actualiza una Inversion verificando que su monto no exceda lo disponible 
*para ejecutar  y retorna el resultado del proceso
*@return string
*/		
	function saveEditInversion($archivo,$nombreOperador){
			$r = "";
			
			$extension = explode(".",$archivo['name']);
			$num = count($extension)-1;
			
			$noMatch = 0;
			foreach( $this->permitidos as $p ) {
				if ( strcasecmp( $extension[$num], $p ) == 0 ) $noMatch = 1;
			}
								
			if($archivo['name']!=null){
				if($noMatch==1){
					if($archivo['size'] < 30000000){
						$ruta = RUTA_INVERSION."/".$nombreOperador."/";//echo ("<br>archivo:".$archivo['tmp_name']);
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
						//echo("<br>ruta:".$ruta);
						if(!move_uploaded_file($archivo['tmp_name'], strtolower($ruta).$archivo['name'])){
							$r = ERROR_COPIAR_ARCHIVO;
						}else{
							$this->nombre=$archivo['name'];
							$i = $this->dd->updateInversionArchivo($this->id,$this->rubro,$this->fecha,$this->proveedor,$this->documento_proveedor,
									  $this->monto,$this->observaciones,$this->nombre);
							if($i == "true"){
								$r = EJECUCION_EDITADO;
							}else{
								$r = ERROR_EDIT_EJECUCION;
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
				$i = $this->dd->updateInversion($this->id,$this->rubro,$this->fecha,$this->proveedor,$this->documento_proveedor,
									  $this->monto,$this->observaciones);
				
				//print_r ($r);
				
				if($r=='true'){
					$msg = ERROR_EDIT_EJECUCION;
					
				}else{
					$msg = EJECUCION_EDITADO;
				}
				
				return $msg;
			}

	}	


/**
*elimina una Inversion y retorna el resultado del proceso
*@return string
*/		
	function deleteInversion($archivo,$nombreOperador){
		$r = $this->dd->deleteInversion($this->id);
		if($r=='true'){
			$ruta = RUTA_INVERSION."/".$nombreOperador."/";
			unlink(strtolower($ruta).$archivo);
			$msg = EJECUCION_BORRADO;		
		}else{
			$msg = ERROR_DEL_EJECUCION;
		}
		
		return $msg;
	
	}
	
}
?>