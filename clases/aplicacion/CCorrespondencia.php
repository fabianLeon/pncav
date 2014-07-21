<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CCorrespondencia
 *
 * @author Brian Kings
 */
class CCorrespondencia {

    var $id = null;
    var $autor = null;
    var $destinatario = null;
    var $subtema = null;
    var $responsableRespuesta = null;
    var $descripcion = null;
    var $documentoSoporte = null;
    var $tieneAnexos = null;
    var $documentoAnexo = null;
    var $fechaRadicado = null;
    var $tieneSeguimiento = null;
    var $fechaMaxRepuesta = null;
    var $codigoReferencia = null;
    var $documentoRespuesta = null;
    var $consecutivoRespuesta = null;
    var $referenciaRespondido = null;
    var $operador = null;
    var $estado = null;
    var $tipo = 1;
    var $tema = null;
    var $dd = null;
    var $permitidos = array('pdf', 'zip', 'rar');
    var $fechaRepuesta = null;
    /*
     * Constructor de la clase
     */
 /*($tipo, $tema*/
                        
    
    function CCorrespondencia($id, $dd) {
        $this->id = $id;
        $this->dd = $dd;
    }
    public function getId() {
        return $this->id;
    }

    public function getAutor() {
        return $this->autor;
    }
    
    public function getDestinatario() {
        return $this->destinatario;
    }

    public function getSubtema() {
        return $this->subtema;
    }

    public function getResponsableRespuesta() {
        return $this->responsableRespuesta;
    }

    public function getDescripcion() {
        return $this->descripcion;
    }

    public function getDocumentoSoporte() {
        return $this->documentoSoporte;
    }
    
    public function getTieneAnexos() {
        return $this->tieneAnexos;
    }

    public function getDocumentoAnexo() {
        return $this->documentoAnexo;
    }

    public function getFechaRadicado() {
        return $this->fechaRadicado;
    }

    public function getTieneSeguimiento() {
        return $this->tieneSeguimiento;
    }

    public function getFechaMaxRepuesta() {
        return $this->fechaMaxRepuesta;
    }

    public function getCodigoReferencia() {
        return $this->codigoReferencia;
    }

    public function getDocumentoRespuesta() {
        return $this->documentoRespuesta;
    }

    public function getConsecutivoRespuesta() {
        return $this->consecutivoRespuesta;
    }

    public function getReferenciaRespondido() {
        return $this->referenciaRespondido;
    }
    
    function getOperador() {
        return $this->operador;
    }
    
    function getEstado() {
        return $this->estado;
    }
    function getTipo() {
        return $this->tipo;
    }
    function getTema() {
        return $this->tema;
    }
    
    function getFechaRespuesta(){
        return $this->fechaRepuesta;
    }
    
    function setId($val) {
        $this->id = $val;
    }
    
    public function setAutor($val) {
        $this->autor=$val;
    }
    
    public function setDestinatario($val) {
        $this->destinatario=$val;
    }
    
    function setSubtema($val) {
        $this->subtema = $val;
    }

    public function setResponsableRespuesta($val) {
        $this->responsableRespuesta=$val;
    }

    public function setDescripcion($val) {
        $this->descripcion=$val;
    }
      
    public function setDocumentoSoporte($val) {
        $this->documentoSoporte=$val;
    }
    
    public function setTieneAnexos($val) {
        $this->tieneAnexos=$val;
    }

    public function setDocumentoAnexo($val) {
        $this->documentoAnexo=$val;
    }

    public function setFechaRadicado($val) {
        $this->fechaRadicado=$val;
    }

    public function setTieneSeguimiento($val) {
        $this->tieneSeguimiento=$val;
    }

    public function setFechaMaxRepuesta($val) {
        $this->fechaMaxRepuesta=$val;
    }

    public function setCodigoReferencia($val) {
        $this->codigoReferencia=$val;
    }

    public function setDocumentoRespuesta($val) {
        $this->documentoRespuesta=$val;
    }
    
    public function setConsecutivoRespuesta($val) {
        $this->consecutivoRespuesta=$val;
    }

    function setReferenciaRespondido($val) {
        $this->referenciaRespondido=$val;
    }

    function setOperador($val) {
        $this->operador = $val;
    }
    
    function setEstado($val) {
        $this->estado = $val;
    }
    
    function setTema($val) {
        $this->tema = $val;
    }
    
    public function setFechaRepuesta($val) {
        $this->fechaRepuesta=$val;
    }

    /**
     *  carga los valores de un objeto Correspondencia por su id para ser editados
     */
    function loadCorrespondecia() {
        $w = $this->dd->getCorresById($this->id);
        if ($w != -1) {
            $this->autor = $w['doa_id_autor'];
            $this->destinatario = $w['doa_id_dest'];
            $this->subtema = $w['dos_id'];
            $this->responsableRespuesta = $w['usu_id'];
            $this->descripcion = $w['doc_descripcion'];
            $this->documentoSoporte = $w['doc_archivo'];
            if(isset($w['doc_anexo']) && strlen($w['doc_anexo'])>1)
                $this->tieneAnexos = 1;
            else
                $this->tieneAnexos = 2;
            $this->documentoAnexo = $w['doc_anexo'];
            $this->fechaRadicado = $w['doc_fecha_radicado'];
            if(isset($w['doc_referencia_respondido']) && strlen($w['doc_referencia_respondido'])>1)
                $this->tieneSeguimiento = 1;
            else 
                $this->tieneSeguimiento = 2;
            $this->fechaMaxRepuesta = $w['doc_fecha_respuesta'];
            $this->codigoReferencia = $w['doc_codigo_ref'];
            $this->documentoRespuesta = $w['doc_referencia_respondido'];
            $this->consecutivoRespuesta = $w['doc_referencia'];
            $this->referenciaRespondido = $w[''];
            $this->fechaRepuesta = $w['doc_fecha_respondido'];
            $this->operador = $w['ope_id'];
            $this->estado = $w['doe_id'];
            $this->tema = $w['dot_id'];
        } else {
            $this->autor = '';
            $this->destinatario = '';
            $this->subtema = '';
            $this->responsableRespuesta = '';
            $this->descripcion = '';
            $this->documentoSoporte = '';
            $this->tieneAnexos = '';
            $this->documentoAnexo = '';
            $this->fechaRadicado = '';
            $this->tieneSeguimiento = '';
            $this->fechaMaxRepuesta = '';
            $this->codigoReferencia = '';
            $this->documentoRespuesta = '';
            $this->consecutivoRespuesta = '';
            $this->referenciaRespondido = '';
            $this->fechaRepuesta = '';
            $this->operador = '';
            $this->estado = '';
            $this->tema = '';
        }
    }

     /**
     * * almacena un objeto DOCUMENTO y retorna un mensaje del resultado del proceso
     * */
    function saveNewCorrespondencia($archivo1,$archivo2){
        $r = "";
        if($this->dd->getCountByReferencia($this->codigoReferencia)==0){
            
            $archivoAnexo=FALSE;
            $archivoRespuesta=FALSE;
            $extension1 = explode(".", $archivo1['name']);
            $num1 = count($extension1) - 1;
            $noMatch1 = 0;

            if ($extension1[$num1]== 'pdf')
                    $noMatch1 = 1; 
            if($this->tieneAnexos==1){
                $extension2 = explode(".", $archivo2['name']);
                $num2 = count($extension2) - 1;
                $noMatch2 = 0;
                if ($extension2[$num2]== 'zip' || $extension2[$num2]== 'rar'){
                    $noMatch2 = 1;
                    if($archivo2['name'] != null){
                        if($archivo2['size'] < MAX_SIZE_DOCUMENTOS){
                           $archivoAnexo=TRUE;
                        }
                    }
                }
            }

//            if($this->tieneSeguimiento==1 && $archivo3 != ""){
//                $extension3 = explode(".", $archivo3['name']);
//                $num3 = count($extension3) - 1;
//                $noMatch3 = 0;
//                if ($extension3[$num3]== 'pdf'){
//                    $noMatch3 = 1;
//                    if($archivo3['name'] != null){
//                        if($archivo3['size'] < MAX_SIZE_DOCUMENTOS){
//                            $archivoRespuesta=TRUE;
//                        }
//                    }
//                }      
//            }
            if ($archivo1['name'] != null){
                if ($noMatch1 == 1){
                    if ($archivo1['size'] < MAX_SIZE_DOCUMENTOS) {
                        $tipo = $this->dd->getTipoNombreById($this->tipo);
                        $tema = $this->dd->getTemaNombreById($this->tema);

                        $subtema = $this->dd->getSubtemaNombreById($this->subtema);
                        $nombre_compuesto = strtoupper($tipo."-".$tema."-".$subtema."-");

                        $cont_archivos = ($this->dd->getCountByName($nombre_compuesto)+1);                    
                        while(strlen($cont_archivos)<LONG_NUMERADOR){
                            $cont_archivos = "0".$cont_archivos;
                        }
                        //$nombre_compuesto = $nombre_compuesto.$cont_archivos;
                        $nombre_compuesto = $this->codigoReferencia;
                        $dirOperador = $this->dd->getDirectorioOperador($this->getOperador());

                        $ruta = (RUTA_DOCUMENTOS . "/" . $dirOperador . $tipo . "/" );//. $tema . "/"
                        //echo $ruta;
                        $carpetas = explode("/", substr($ruta, 0, strlen($ruta) - 1));
                        $cad = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF'];
                        $ruta_destino = '';

                        foreach ($carpetas as $c) {
                            if (strlen($ruta_destino) > 0) {
                                $ruta_destino .= "/" . $c;
                            } else {
                                $ruta_destino = $c;
                            }
                            //echo $ruta_destino."<br>";
                            if (!is_dir($ruta_destino)) {
                                mkdir($ruta_destino, 0777);
                            } else {
                                chmod($ruta_destino, 0777);
                            }
                        }

                        $control_carga = TRUE;
                        $nombre_compuesto1 = $nombre_compuesto.".".$extension1[$num1];

                        //if(isset($archivo1) && !move_uploaded_file($archivo1['tmp_name'], $ruta . CORRESPONDENCIA_SOPORTE."-".$nombre_compuesto1)){
                        if(isset($archivo1) && !move_uploaded_file($archivo1['tmp_name'], $ruta . $archivo1['name'])){
                            $r = ERROR_COPIAR_ARCHIVO." ".CORRESPONDENCIA_SOPORTE;
                            $control_carga = FALSE;
                        }

                        if($this->tieneAnexos==1 && $noMatch2 == 1){
                            $nombre_compuesto2 = $nombre_compuesto.".".$extension2[$num2];
                            //if(isset($archivo2) && !move_uploaded_file($archivo2['tmp_name'], $ruta . CORRESPONDENCIA_ANEXO."-".$nombre_compuesto2)){
                            if(isset($archivo2) && !move_uploaded_file($archivo2['tmp_name'], $ruta . $archivo2['name'])){
                                $r = ERROR_COPIAR_ARCHIVO." ".CORRESPONDENCIA_ANEXO;
                                $control_carga = FALSE;
                            }
                        }
//                        if($this->tieneSeguimiento==1 && $noMatch3 == 1){
//                            $nombre_compuesto3 = $nombre_compuesto.".".$extension3[$num3];
//
//                            if(isset($archivo3) && !move_uploaded_file($archivo3['tmp_name'], $ruta . CORRESPONDENCIA_RESPUESTA."-".$nombre_compuesto3)){
//                                $r = ERROR_COPIAR_ARCHIVO." ".CORRESPONDENCIA_RESPUESTA;
//                                $control_carga = FALSE;
//                            }
//                        }
                        if($control_carga) {
                            $this->documentoSoporte = $archivo1['name'];//CORRESPONDENCIA_SOPORTE."-".$nombre_compuesto.".".$extension1[$num1]; 
                            if($this->tieneAnexos==1 && $archivo2['name'] != "")
                                $this->documentoAnexo = $archivo2['name'];//CORRESPONDENCIA_ANEXO."-".$nombre_compuesto.".".$extension2[$num2];
                            else 
                                $this->documentoAnexo = "";

//                            if($this->tieneSeguimiento==1 && $archivo3['name'] != "")
//                                $this->documentoRespuesta = CORRESPONDENCIA_RESPUESTA."-".$nombre_compuesto.".".$extension3[$num3];
//                            else 
//                                $this->documentoRespuesta = "";

                            $i = $this->dd->insertCorrespondencia($this->tipo, $this->tema,
                                    $this->subtema, $this->autor, 
                                    $this->destinatario, $this->fechaRadicado, 
                                    $this->consecutivoRespuesta ,$this->descripcion, 
                                    $this->documentoSoporte, $this->responsableRespuesta,
                                    $this->fechaMaxRepuesta, $this->documentoAnexo, 
                                    $this->codigoReferencia, $this->fechaRespondido, 
                                    $this->documentoRespuesta, $this->estado,
                                    $this->operador);

                            if ($i == "true") {
                                $r = DOCUMENTO_AGREGADO;
                            } else {
                                $r = ERROR_ADD_DOCUMENTO;
                            }
                        }
                    } else {
                        $r = ERROR_SIZE_ARCHIVO;
                    }
                } else {
                    $r = ERROR_FORMATO_ARCHIVO;
                }
            } else {
                $r = ERROR_CONFIGURACION_RUTA;
            }
        }else{
            $r = ERROR_REFERENCIA_REPETIDA;
        }
        return $r;
    }

    /**
     * * elimina un objeto DOCUMENTO y retorna un mensaje del resultado del proceso
     * */
    function deleteDocumento() {
        $tipo = $this->dd->getTipoNombreById($this->tipo);
        $tema = $this->dd->getTemaNombreById($this->tema);
        $subtema = $this->dd->getSubtemaNombreById($this->subtema);
        $dirOperador = $this->dd->getDirectorioOperador($this->operador);
        $ruta = RUTA_DOCUMENTOS . "/" . $dirOperador . $tipo . "/";// . $tema . "/"
        //echo $ruta;
        chmod($ruta, 0777);
        $r = $this->dd->deleteDocumento($this->id);
        if ($r == 'true') {
            unlink(($ruta) . $this->getDocumentoSoporte());
            unlink(($ruta) . $this->getDocumentoAnexo());
            unlink(($ruta) . $this->getDocumentoRespuesta());
            $msg = DOCUMENTO_BORRADO;
        } else {
            $msg = ERROR_DEL_DOCUMENTO;
        }
        return $msg;
    }

    //------------------------------------------------------------------------------
    function saveEditCorrespondencia($archivo1,$archivo2){
        $r = "";
        
        if($this->dd->getCountByReferenciaEdit($this->id, $this->codigoReferencia)==0){
            $archivoAnexo=FALSE;
            $archivoRespuesta=FALSE;
            
            $extension1 = explode(".", $archivo1['name']);
            $num1 = count($extension1) - 1;
            $noMatch1 = 0;
            if ($extension1[$num1]== 'pdf')
                    $noMatch1 = 1; 
            if($this->tieneAnexos==1){
                $extension2 = explode(".", $archivo2['name']);
                $num2 = count($extension2) - 1;
                $noMatch2 = 0;
                if ($extension2[$num2]== 'zip' || $extension2[$num2]== 'rar'){
                    $noMatch2 = 1;
                    if($archivo2['name'] != null){
                        if($archivo2['size'] < MAX_SIZE_DOCUMENTOS){
                           $archivoAnexo=TRUE;
                        }
                    }
                }
            }
            
//            if($this->tieneSeguimiento==1){
//                $extension3 = explode(".", $archivo3['name']);
//                $num3 = count($extension3) - 1;
//                $noMatch3 = 0;
//                if ($extension3[$num3]== 'pdf'){
//                    $noMatch3 = 1;
//                    if($archivo3['name'] != null){
//                        if($archivo3['size'] < MAX_SIZE_DOCUMENTOS){
//                            $archivoRespuesta=TRUE;
//                        }
//                    }
//                }      
//            }
            //if ($archivo1['name'] != null){
                //if ($noMatch1 == 1){
                    if ($archivo1['size'] < MAX_SIZE_DOCUMENTOS) {
                        //$archivoAnexo=TRUE$archivoRespuesta=TRUE;
                        $tipo = $this->dd->getTipoNombreById($this->tipo);
                        $tema = $this->dd->getTemaNombreById($this->tema);

                        $subtema = $this->dd->getSubtemaNombreById($this->subtema);
                        $nombre_compuesto = strtoupper($tipo."-".$tema."-".$subtema."-");

                        $cont_archivos = ($this->dd->getCountByName($nombre_compuesto)+1);                    
                        while(strlen($cont_archivos)<LONG_NUMERADOR){
                            $cont_archivos = "0".$cont_archivos;
                        }
                        //$nombre_compuesto = $nombre_compuesto.$cont_archivos;
                        $nombre_compuesto = $this->codigoReferencia;

                        $dirOperador = $this->dd->getDirectorioOperador($this->getOperador());

                        $ruta = (RUTA_DOCUMENTOS . "/" . $dirOperador . $tipo . "/");// . $tema . "/"
                        //echo $ruta;
                        $carpetas = explode("/", substr($ruta, 0, strlen($ruta) - 1));
                        $cad = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF'];
                        $ruta_destino = '';

                        foreach ($carpetas as $c) {
                            if (strlen($ruta_destino) > 0) {
                                $ruta_destino .= "/" . $c;
                            } else {
                                $ruta_destino = $c;
                            }
                            //echo $ruta_destino."<br>";
                            if (!is_dir($ruta_destino)) {
                                mkdir($ruta_destino, 0777);
                            } else {
                                chmod($ruta_destino, 0777);
                            }
                        }

                        $control_carga = TRUE;
                        $nombre_compuesto1 = $nombre_compuesto.".".$extension1[$num1];
                        
                        if(isset($archivo1)){
                            //if(isset($archivo1) && !move_uploaded_file($archivo1['tmp_name'], $ruta . CORRESPONDENCIA_SOPORTE."-".$nombre_compuesto1)){
                            if(isset($archivo1) && !move_uploaded_file($archivo1['tmp_name'], $ruta . $archivo1['name'])){
                                $r = ERROR_COPIAR_ARCHIVO." ".CORRESPONDENCIA_SOPORTE;
                                $control_carga = FALSE;
                            }
                        }
                        if(isset($archivo2)){
                            if($this->tieneAnexos==1 && $noMatch2 == 1){
                                $nombre_compuesto2 = $nombre_compuesto.".".$extension2[$num2];
                                //if(isset($archivo2) && !move_uploaded_file($archivo2['tmp_name'], $ruta . CORRESPONDENCIA_ANEXO."-".$nombre_compuesto2)){
                                if(isset($archivo2) && !move_uploaded_file($archivo2['tmp_name'], $ruta . $archivo2['name'])){
                                    $r = ERROR_COPIAR_ARCHIVO." ".CORRESPONDENCIA_ANEXO;
                                    $control_carga = FALSE;
                                }
                            }
                        }
//                        if(isset($archivo3)){
//                            if($this->tieneSeguimiento==1 && $noMatch3 == 1){
//                                $nombre_compuesto3 = $nombre_compuesto.".".$extension3[$num3];
//
//                                if(isset($archivo3) && !move_uploaded_file($archivo3['tmp_name'], $ruta . CORRESPONDENCIA_RESPUESTA."-".$nombre_compuesto3)){
//                                    $r = ERROR_COPIAR_ARCHIVO." ".CORRESPONDENCIA_RESPUESTA;
//                                    $control_carga = FALSE;
//                                }
//                            }
//                        }
                        if($control_carga) {
                            if(isset($archivo1))
                                $this->documentoSoporte = $archivo1['name'];//CORRESPONDENCIA_SOPORTE."-".$nombre_compuesto.".".$extension1[$num1];
                            else
                                $this->documentoSoporte = "";
                            if($this->tieneAnexos==1){
                                if(isset($archivo2))
                                    $this->documentoAnexo = $archivo2['name'];//CORRESPONDENCIA_ANEXO."-".$nombre_compuesto.".".$extension2[$num2];
                                else
                                    $this->documentoAnexo = "";
                            }else{
                                $this->documentoAnexo = "";
                            }
                            if($this->tieneSeguimiento==1){
//                                if(isset($archivo3))
//                                    $this->documentoRespuesta = CORRESPONDENCIA_RESPUESTA."-".$nombre_compuesto.".".$extension3[$num3];
//                                else{
//                                    $this->documentoRespuesta = "";
//                                    //$this->fechaMaxRepuesta = "0000-00-00";
//                                    //$this->responsableRespuesta = "";
//                                }
                            }else{
                                $this->documentoRespuesta = "";
                                $this->fechaMaxRepuesta = "0000-00-00";
                                //$this->responsableRespuesta = "";
                            }
                            
                            $i = $this->dd->updateCorrespondencia($this->id,'1', $this->tema,
                                    $this->subtema, $this->autor, 
                                    $this->destinatario, $this->fechaRadicado, 
                                    $this->consecutivoRespuesta ,$this->descripcion, 
                                    $this->documentoSoporte, $this->responsableRespuesta,
                                    $this->fechaMaxRepuesta, $this->documentoAnexo, 
                                    $this->codigoReferencia, $this->fechaRespuesta, 
                                    $this->documentoRespuesta, $this->estado, 
                                    $this->operador, $this->tieneAnexos);

                            if ($i == "true") {
                                $r = DOCUMENTO_EDITADO;
                            } else {
                                $r = ERROR_EDIT_DOCUMENTO;
                            }
                        }
                    } else {
                        $r = ERROR_SIZE_ARCHIVO;
                    }
                /*} else {
                    $r = ERROR_FORMATO_ARCHIVO;
                }*/
            /*} else {
                $r = ERROR_CONFIGURACION_RUTA;*/
            //}
        }else{
            $r = ERROR_REFERENCIA_REPETIDA;
        }
        return $r;
    }
    //------------------------------------------------------------------------------
    /**
     * * actualiza un objeto DOCUMENTO y retorna un mensaje del resultado del proceso
     * */
    function saveEditDocumento($archivo, $archivo_anterior) {

        $r = "";

        $extension = explode(".", $archivo['name']);
        $num = count($extension) - 1;

        $noMatch = 0;
        foreach ($this->permitidos as $p) {
            if (strcasecmp($extension[$num], $p) == 0)
                $noMatch = 1;
        }

        if ($archivo['name'] != null) {
            if ($noMatch == 1) {
                if ($archivo['size'] < MAX_SIZE_DOCUMENTOS) {
                    
                    $tipo = $this->dd->getTipoNombreById($this->tipo);
                    $tema = $this->dd->getTemaNombreById($this->tema);
                    $subtema = $this->dd->getSubtemaNombreById($this->subtema);
                    $nombre_compuesto = strtoupper($tipo."-".$tema."-".$subtema."-");
                    $cont_archivos = ($this->dd->getCountByName($nombre_compuesto)+1);
                    while(strlen($cont_archivos)<LONG_NUMERADOR){
                        $cont_archivos = "0".$cont_archivos;
                    }
                    //$nombre_compuesto = $nombre_compuesto.$cont_archivos;
                    $nombre_compuesto = $this->codigoReferencia;
                    $dirOperador = $this->dd->getDirectorioOperador($this->operador);

                    $ruta = (RUTA_DOCUMENTOS . "/" . $dirOperador . $tipo . "/");// . $tema . "/"

                    $carpetas = explode("/", substr($ruta, 0, strlen($ruta) - 1));
                    $cad = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['PHP_SELF'];
                    $ruta_destino = '';

                    foreach ($carpetas as $c) {
                        if (strlen($ruta_destino) > 0) {
                            $ruta_destino .= "/" . $c;
                        } else {
                            $ruta_destino = $c;
                        }
                        //echo $ruta_destino."<br>";
                        if (!is_dir($ruta_destino)) {
                            mkdir($ruta_destino, 0777);
                        } else {
                            chmod($ruta_destino, 0777);
                        }
                    }
                    $nombre_compuesto = $nombre_compuesto.".".$extension[$num];
                    unlink(strtolower($ruta) . $archivo_anterior);
                    if (!move_uploaded_file($archivo['tmp_name'], strtolower($ruta) . $nombre_compuesto)) {
                        $r = ERROR_COPIAR_ARCHIVO;
                    } else {
                        $this->archivo = $nombre_compuesto;
                        $i = $this->dd->updateDocumentoArchivo($this->id, $this->tipo, $this->tema, $this->subtema, $this->fecha, $this->descripcion, $this->version, $this->archivo, $this->estado);
                        if ($i == "true") {
                            $r = DOCUMENTO_EDITADO;
                        } else {
                            $r = ERROR_EDIT_DOCUMENTO;
                        }
                    }
                } else {
                    $r = ERROR_SIZE_ARCHIVO;
                }
            } else {
                $r = ERROR_FORMATO_ARCHIVO;
            }
            return $r;
        } else {
            $r = $this->dd->updateDocumento($this->id, $this->tipo, $this->tema, $this->subtema, $this->fecha, $this->descripcion, $this->version, $this->estado);
            if ($r == 'true') {
                $msg = DOCUMENTO_EDITADO;
            } else {
                $msg = ERROR_EDIT_DOCUMENTO;
            }
            return $msg;
        }
    }
    /*
     * Recibe la correspondecia y los anexos, los valida y los almacena.
     */


    function saveNewCorrespondenciaOtro($archivo, $anexo) {
        //validar y almacenar
        $listoParaAlmacenar = null;
        //$listoParaAlmacenar = $this->guardarArchivos($archivo);
        if ($anexo != '') {
            $listoParaAlmacenar = $this->guardarArchivos($anexo);
        }
        if ($listoParaAlmacenar == TRUE) {
            //almacenar basededatos
            $i = $this->dd->updateCorrespondencia($this->id,CORRESPONDECIA_TIPO, CORRESPONDECIA_TEMA, $this->subtema, $this->fechaRadicado, $this->descripcion, $this->documentoSoporte, '0', $this->estado, CORRESPONDECIA_OPERADOR, $this->anexos, $this->autor, $this->fechaMaxRepuesta, $this->referenciaRespuesta, $this->responsableRespuesta, $this->consecutivo);
            if ($i == "true") {
                $r = DOCUMENTO_AGREGADO;
            } else {
                $r = ERROR_ADD_DOCUMENTO;
            }
            return $r;
        }
    }
    
    
    
    //------------------------------------------------------------------------------------------------------------
    //------------------------------------------------------------------------------
    function saveResponderCorrespondencia(){
        $r = "";
        $i = $this->dd->responderCorrespondencia($this->id,
                $this->consecutivoRespuesta ,$this->fechaRespuesta, 
                $this->documentoRespuesta, $this->estado);

        if ($i == "true") {
            $r = DOCUMENTO_EDITADO;
        } else {
            $r = ERROR_EDIT_DOCUMENTO;
        }
        
        return $r;
    }

}
