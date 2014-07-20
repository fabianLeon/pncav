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
*CFactura1
*
*Usada para todas las funciones de aplicacion referente a anticipos del modulo financiero
*
* @package  clases
* @subpackage aplicacion
*/
Class CFactura{
/**
*identificador unico de la factura
*@var integer 
*/
	var $id = null;
/**
*identificador del rubro de la factura
*@var string 
*/
	var $descripcion = null;
/**
*fecha de la factura
*@var date 
*/
	var $fecha = null;
/**
*numero de la factura
*@var integer 
*/
	var $numero = null;
/**
*proveedor de la factura
*@var string 
*/
	var $proveedor = null;
/**
*documento del proveedor de la factura
*@var integer 
*/
	var $documento_proveedor = null;
/**
*monto de la factura
*@var float 
*/
	var $monto = null;
/**
*iva de la factura
*@var float 
*/
	var $amortiza = null;
/**
*identificador del estado de la factura
*@var string 
*/
	var $observaciones = null;
/**
*nombre del documento soporte
*@var string 
*/
	var $documento = null;
        
/**
*Operador de la factura
*@var string 
*/
	var $operador = null;
/**
*Instancia de la clase CFactura1Data
*@var object 	
*/
	var $dd = null;
/**
*retorna el identificador de la factura
*@return integer	
*/
	function getId(){ return $this->id; }
/**
*retorna el identificador del rubro de la factura
*@return integer	
*/
	function getDescripcion(){ return $this->descripcion; }
/**
*retorna la fecha de la factura
*@return mixed
*/
	function getFecha(){ return $this->fecha; }
/**
*retorna el numero de la factura
*@return string
*/
	function getNumero(){ return $this->numero; }
/**
*retorna el nombre del proveedor de la factura
*@return string
*/
	function getProveedor(){ return $this->proveedor; }
/**
*retorna el documento del proveedor de la factura
*@return string
*/
	function getDocumentoProveedor(){ return $this->documento_proveedor; }
/**
*retorna el monto de la factura
*@return float	
*/
	function getMonto(){ return $this->monto; }
/**
*retorna el monto del iva de la factura
*@return float	
*/
	function getAmortiza(){ return $this->amortiza; }
/**
*retorna el identificador del observaciones de la factura
*@return string
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
*Constructor de la clase
*
*@param integer $id identificador unico de la factura
*@param integer $descripcion identificador del rubro de la factura
*@param date $fecha fecha de la factura
*@param string $proveedor nombre del proveedor
*@param integer $documento_proveedor documento del proveedor
*@param float $monto monto dela factura sin iva
*@param float $amortiza monto del iva de la factura
*@param integer $numero numero de la factura
*@param string $observaciones identificador del observaciones de la factura
*@param string $documento documento soporte de la factura
*@param object $dd instancia de la clase CFactura1Data
*/
	function CFactura($id,$descripcion,$fecha,$proveedor,$documento_proveedor,$monto,$amortiza,$numero,$observaciones,$documento,$operador,$dd){
		$this->id = $id;
		$this->descripcion = $descripcion;
		$this->fecha = $fecha;
		$this->numero = $numero;
		$this->proveedor = $proveedor;
		$this->documento_proveedor = $documento_proveedor;
		$this->monto = $monto;
		$this->amortiza = $amortiza;
		$this->observaciones=$observaciones;
		$this->documento=$documento;
                $this->operador = $operador;
		$this->dd = $dd;
	}
/**
*carga los montos de los atributos de la clase
*/	
	function loadFactura(){
		$r = $this->dd->getFacturaById($this->id);
		if($r != -1){
			$this->descripcion = $r['fac_descripcion'];
			$this->fecha = $r['fac_fecha'];
			$this->numero = $r['fac_numero'];
			$this->proveedor = $r['fac_proveedor'];
			$this->documento_proveedor = $r['fac_documento_proveedor'];
			$this->monto = $r['fac_monto'];
			$this->amortiza = $r['fac_amortiza'];
			$this->observaciones = $r['fac_observaciones'];
			$this->documento = $r['fac_documento'];
		}else{
			$this->descripcion = "";
			$this->fecha = "";
			$this->numero = "";
			$this->proveedor = "";
			$this->documento_proveedor = "";
			$this->monto = "";
			$this->amortiza = "";
			$this->observaciones = "";
			$this->documento = "";
		}
	}
/**
*carga los montos de los atributos de la clase para visualizacion
*/	
	function loadSeeFactura($nombreOperador){
		$r = $this->dd->getFacturaById($this->id);
                
                $ruta = str_replace(getcwd(),'.',(RUTA_FACTURAS."/".$nombreOperador));
                
		if($r != -1){
			$this->descripcion = $r['fac_descripcion'];
			$this->fecha = $r['fac_fecha'];
			$this->numero = $r['fac_numero'];
			$this->proveedor = $r['fac_proveedor'];
			$this->documento_proveedor = $r['fac_documento_proveedor'];
			$this->monto = $r['fac_monto'];
			$this->amortiza = $r['fac_amortiza'];
			$this->observaciones = $r['fac_observaciones'];
			$this->documento = "<a href='".$ruta."/".$r['fac_documento']."' target='_blank'>".$r['fac_documento']."</a>";
		}else{
			$this->descripcion = "";
			$this->fecha = "";
			$this->numero = "";
			$this->proveedor = "";
			$this->documento_proveedor = "";
			$this->monto = "";
			$this->amortiza = "";
			$this->observaciones = "";
			$this->documento = "";
		}
	}
	
/**
*almacena una nueva factura verificando que su monto no exceda lo disponible 
*para ejecutar  y retorna el resultado del proceso
*@param float $monto_anticipado monto anticipado hasta la fecha
*@param float $monto_ejecutado monto ejecutado hasta la fecha
*@return string
*/	
	function saveNewFactura($archivo,$nombreOperador){
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
					$ruta = RUTA_FACTURAS."/".$nombreOperador."/";
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
						$i = $this->dd->insertFactura($this->descripcion,$this->fecha,$this->proveedor,$this->documento_proveedor,$this->monto,$this->amortiza,
														$this->numero,$this->observaciones,$this->nombre,$this->operador);
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
*actualiza una factura verificando que su monto no exceda lo disponible 
*para ejecutar  y retorna el resultado del proceso
*@param float $monto_anticipado monto anticipado hasta la fecha
*@param float $monto_ejecutado monto ejecutado hasta la fecha
*@return string
*/		
	function saveEditFactura($archivo,$nombreOperador){
	
			
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
						$ruta = RUTA_FACTURAS."/".$nombreOperador."/";//echo ("<br>archivo:".$archivo['tmp_name']);
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
							$i = $this->dd->updateFacturaArchivo($this->id,$this->descripcion,$this->fecha,$this->proveedor,$this->documento_proveedor,
									  $this->monto,$this->amortiza,	$this->numero,$this->observaciones,$this->nombre);
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
				$r = $this->dd->updateFactura($this->id,$this->descripcion,$this->fecha,$this->proveedor,$this->documento_proveedor,
									  $this->monto,$this->amortiza,	$this->numero,$this->observaciones);
				if($r=='true'){
					$msg = EJECUCION_EDITADO;
				}else{
					$msg = ERROR_EDIT_EJECUCION;
				}
				
				return $msg;
			}

	}
	
/**
*elimina una factura y retorna el resultado del proceso
*@return string
*/		
	function deleteEjecucion(){
		$r = $this->dd->deleteFactura($this->id);
		if($r=='true'){
			$msg = EJECUCION_BORRADO;		
		}else{
			$msg = ERROR_DEL_EJECUCION;
		}
		
		return $msg;
	
	}
	
}
?>