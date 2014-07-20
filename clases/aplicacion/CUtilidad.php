<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CUtilidad
 *
 * @author Personal
 */
class CUtilidad {

    var $id_utilidad = null;
    var $fecha_comunicado = null;
    var $vigencia=null;
    var $archivo_comunicado = null;
    var $porcentaje_utilizacion = null;
    var $utilizacion_aprobada = null;
    var $fecha_comite = null;
    var $numero_comite = null;
    var $archivo_acta = null;
    var $comentario = null;
    var $database = null;
    var $permitidos_comunicado = array('pdf', 'doc', 'xls', 'ppt', 'docx',
        'xlsx', 'gif', 'jpg', 'png');
    var $permitidos_acta = array('pdf', 'doc', 'xls', 'ppt', 'docx',
        'xlsx', 'gif', 'jpg', 'png');

    //Declaramos los atributos de la clase y generamos el constructor de la misma
    function CUtilidad($id, $fecha_comunicado, $vigencia, $archivo_documento, $porcentaje_utilidad, $utilidad_aprobada, $fecha_comite
    , $numerocomite, $archivo_acta, $comentarios,  $database) {
        $this->id_utilidad = $id;
        $this->fecha_comunicado = $fecha_comunicado;
        $this->vigencia = $vigencia;
        $this->archivo_comunicado = $archivo_documento;
        $this->porcentaje_utilizacion = $porcentaje_utilidad;
        $this->utilizacion_aprobada = $utilidad_aprobada;
        $this->fecha_comite = $fecha_comite;
        $this->numero_comite = $numerocomite;
        $this->archivo_acta = $archivo_acta;
        $this->comentario = $comentarios;
        $this->database = $database;
    }

  

    public function getId_utilidad() {
        return $this->id_utilidad;
    }

    public function getFecha_comunicado() {
        return $this->fecha_comunicado;
    }

    public function getArchivo_comunicado() {
        return $this->archivo_comunicado;
    }

    public function getPorcentaje_utilizacion() {
        return $this->porcentaje_utilizacion;
    }

    public function getUtilizacion_aprobada() {
        return $this->utilizacion_aprobada;
    }

    public function getFecha_comite() {
        return $this->fecha_comite;
    }

    public function getNumero_comite() {
        return $this->numero_comite;
    }

    public function getArchivo_acta() {
        return $this->archivo_acta;
    }

    public function getComentario() {
        return $this->comentario;
    }
    
    public function getVigencia() {
        return $this->vigencia;
    }

    /**
     * La clase cargarUtilidad carga un objeto utilidad por mediante el id
     * y se utiliza en la edicion y eliminacion de dicho objeto
     */
    function CargarUtilidad() {
        $r = $this->database->ObtenerUtilidadporId($this->id_utilidad);
        if ($r) {
            $this->id_utilidad = $r['id_utilidad'];
            $this->vigencia = $r['ano_vigencia'];
            $this->fecha_comunicado = $r['fecha_comuni'];
            $this->archivo_comunicado = $r['doc_soporte_comuni'];
            $this->porcentaje_utilizacion = $r['porcen_utiliacion'];
            $this->utilizacion_aprobada = $r['uti_aprobada'];
            $this->fecha_comite = $r['fecha_comi_fidu'];
            $this->numero_comite = $r['num_comi_fidu'];
            $this->archivo_acta = $r['doc_soporte_act'];
            $this->comentario = $r['comen_utilidades'];
           
        } else {

            $this->id_utilidad = '';
            $this->fecha_comunicado = '';
            $this->archivo_comunicado = '';
            $this->porcentaje_utilizacion = '';
            $this->utilizacion_aprobada = '';
            $this->fecha_comite = '';
            $this->numero_comite = '';
            $this->archivo_acta = '';
            $this->comentario = '';
          
        }
    }

    /**
     * La clase guardarUtilidad guradar los archuvos adjutos en los soportes
     * del sistema, evalua que sean validos e ingresa los atributos en la 
     * base de datos
     */
    function guardarutilidad($db) {
        $docIngresos = new CIngresosData($db);
        $fecha = DateTime::createFromFormat("Y-m-d", $this->fecha_comunicado);
        $year = $fecha->format("Y");
        $vigencia = $docIngresos->ObtenerValoresIngresos($year);
        $utilizaciones = $docIngresos->ObtenerValoresUtilidades($year);
        if(($utilizaciones[0]+$this->utilizacion_aprobada)>$vigencia[1]){
            return ERROR_SOBRECOSTO_VIGENCIA;
        }
        $extension_comunicado = explode(".", $this->archivo_comunicado['name']);
        $extension_acta = explode(".", $this->archivo_acta['name']);

        $pos_comunicado = count($extension_comunicado) - 1;
        $pos_acta = count($extension_acta) - 1;

        $valido_comunicado = false;
        $valido_acta = false;

        foreach ($this->permitidos_comunicado as $p) {
            if (strcasecmp($extension_comunicado[$pos_comunicado], $p) == 0)
                $valido_comunicado = true;
        }

        foreach ($this->permitidos_acta as $p) {
            if (strcasecmp($extension_acta[$pos_acta], $p) == 0)
                $valido_acta = true;
        }

        if (!$valido_comunicado) {
            return ERROR_COMUNCADO_NO_VALIDO;
        }

        if (!$valido_acta) {
            return ERROR_ACTA_NO_VALIDA;
        }

        if ($this->archivo_comunicado['name'] == NULL || $this->archivo_comunicado['name'] == "") {
            return ERROR_COMUNICADO_VACIO;
        }

        if ($this->archivo_acta['name'] == NULL || $this->archivo_acta['name'] == "") {
            return ERROR_ACTA_VACIO;
        }

        if ($this->archivo_comunicado['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_COMUNICADO;
        }

        if ($this->archivo_acta['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_ACTA;
        }

        $dirOperadorutilidades = $this->database->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_UTILIDADES_SOPORTES . "/" . $dirOperadorutilidades . "/");

        $carpetas = explode("/", substr($ruta, 0, strlen($ruta) - 1));
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

        $nombre_compuesto_comunicado = EXTRACTO_COMUNICADO_SOPORTE . "(" . $this->fecha_comunicado . ")" .$this->archivo_comunicado['name'];
        if (!move_uploaded_file($this->archivo_comunicado['tmp_name'], $ruta . $nombre_compuesto_comunicado)) {
            return ERROR_COPIAR_ARCHIVO_COMUNICADO_SOPORTE;
        }
        $nombre_compuesto_acta = EXTRACTO_ACTA_SOPORTE . "(" . $this->fecha_comunicado . ")" . $this->archivo_acta['name'];
        if (!move_uploaded_file($this->archivo_acta['tmp_name'], $ruta . $nombre_compuesto_acta)) {
            return ERROR_COPIAR_ARCHIVO_ACTA_SOPORTE;
        }





        $r = $this->database->insertarUtilidad($this->id_utilidad, $this->fecha_comunicado, $this->vigencia, $this->archivo_comunicado['name'], $this->porcentaje_utilizacion, $this->utilizacion_aprobada, $this->fecha_comite, $this->numero_comite, $this->archivo_acta['name'], $this->comentario);
        if ($r) {

            $m = AGREGAR_UTILIDAD_EXITO;
        } else {
            $m = AGREGAR_UTILIDAD_FRACASO;
        }
        return $m;
    }

    /**
     * La clase eliminarUtilidad elimina los archivos adjutos y elimina 
     * el objeto de la base de datos
     */
    function eliminarUtilidad($id) {


        $nombre_compuesto_comunicado = EXTRACTO_COMUNICADO_SOPORTE . "(" . $this->fecha_comunicado . ")" .$this->archivo_comunicado;
        $nombre_compuesto_acta = EXTRACTO_ACTA_SOPORTE . "(" . $this->fecha_comunicado . ")" .$this->archivo_acta;
        //echo $nombre_compuesto_comunicado. " y ".$nombre_compuesto_acta;
        $dirOperadorutilidades = $this->database->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_UTILIDADES_SOPORTES . "/" . $dirOperadorutilidades . "/");
        $r = $this->database->borrarUtilidad($id);
        chmod($ruta, 0777);
        if ($r) {
            unlink(strtolower($ruta) . $nombre_compuesto_comunicado);
            unlink(strtolower($ruta) . $nombre_compuesto_acta);

            $mg = ELIMINAR_UTILIDAD_EXITO;
        } else {
            $mg = ELIMINAR_UTILIDAD_FRACASO;
        }
        return $mg;
    }

    /**
     * La clase editarUtilidad actualiza los archivos adjutos(elimina los anteriores)
     *  y actualiza el objeto de la base de datos
     */
    function editarutilidad($archivo_anterior_acta, $archivo_anterior_documento, $fecha_anteior, $id_nuevo, $db) {
        $docIngresos = new CIngresosData($db);
        $fecha = DateTime::createFromFormat("Y-m-d", $this->fecha_comunicado);
        $year = $fecha->format("Y");
        $vigencia = $docIngresos->ObtenerValoresIngresos($year);
        $utilizaciones = $docIngresos->ObtenerValoresUtilidadesByCriterio($year," id_utilidad != ".$this->id_utilidad);
        if(($utilizaciones[0]+$this->utilizacion_aprobada)>$vigencia[1]){
            return ERROR_SOBRECOSTO_VIGENCIA;
        }
        $extension_comunicado = explode(".", $this->archivo_comunicado['name']);
        $extension_acta = explode(".", $this->archivo_acta['name']);

        $pos_comunicado = count($extension_comunicado) - 1;
        $pos_acta = count($extension_acta) - 1;

        $valido_comunicado = false;
        $valido_acta = false;

        foreach ($this->permitidos_comunicado as $p) {
            if (strcasecmp($extension_comunicado[$pos_comunicado], $p) == 0)
                $valido_comunicado = true;
        }

        foreach ($this->permitidos_acta as $p) {
            if (strcasecmp($extension_acta[$pos_acta], $p) == 0)
                $valido_acta = true;
        }

      //  if (!$valido_comunicado) {
        //    return ERROR_COMUNCADO_NO_VALIDO;
       // }

        //if (!$valido_acta) {
          //  return ERROR_ACTA_NO_VALIDA;
        //}

        //if ($this->archivo_comunicado['name'] == NULL || $this->archivo_comunicado['name'] == "") {
         //   return ERROR_COMUNICADO_VACIO;
        //}

       // if ($this->archivo_acta['name'] == NULL || $this->archivo_acta['name'] == "") {
         //   return ERROR_ACTA_VACIO;
        //}

        if ($this->archivo_comunicado['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_COMUNICADO;
        }

        if ($this->archivo_acta['size'] > MAX_SIZE_DOCUMENTOS) {
            return ERROR_TAM_ARCHIVO_ACTA;
        }

        $dirOperadorutilidades = $this->database->getDirectorioOperador(OPERADOR_DEFECTO);
        $ruta = (RUTA_UTILIDADES_SOPORTES . "/" . $dirOperadorutilidades . "/");

        $carpetas = explode("/", substr($ruta, 0, strlen($ruta) - 1));
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

        if($this->archivo_comunicado['name'] !=''){
       
        $nombre_compuesto_comunicado = EXTRACTO_COMUNICADO_SOPORTE . "(" . $this->fecha_comunicado . ")" . $this->archivo_comunicado['name'];
        $nombre_compuesto_comunicado_anterior = EXTRACTO_COMUNICADO_SOPORTE . "(" . $fecha_anteior . ")" . $archivo_anterior_documento;
        
       
         unlink(strtolower($ruta) . $nombre_compuesto_comunicado_anterior);
        
                
        if (!move_uploaded_file($this->archivo_comunicado['tmp_name'], $ruta . $nombre_compuesto_comunicado)) {
            return ERROR_COPIAR_ARCHIVO_COMUNICADO_SOPORTE;
        }
        }
        else {
            $this->archivo_comunicado['name']=$archivo_anterior_documento;
        }
       if($this->archivo_acta['name']!=''){
       $nombre_compuesto_acta = EXTRACTO_ACTA_SOPORTE . "(" . $this->fecha_comunicado . ")" . $this->archivo_acta['name'];
       $nombre_compuesto_acta_anterior = EXTRACTO_ACTA_SOPORTE . "(" . $fecha_anteior . ")".$archivo_anterior_acta ;
       chmod($ruta, 0777);
       unlink(strtolower($ruta) . $nombre_compuesto_acta_anterior);
      
        if (!move_uploaded_file($this->archivo_acta['tmp_name'], $ruta . $nombre_compuesto_acta)) {
            return ERROR_COPIAR_ARCHIVO_ACTA_SOPORTE;
        }
        }
        else{
            $this->archivo_acta['name']=$archivo_anterior_acta;
        }

        $r = $this->database->actualizarUtilidad($this->id_utilidad,$id_nuevo, $this->fecha_comunicado,  $this->vigencia, $this->archivo_comunicado['name'], $this->porcentaje_utilizacion, $this->utilizacion_aprobada, $this->fecha_comite, $this->numero_comite, $this->archivo_acta['name'],  $this->comentario);
        if ($r) {

            $m = EDITAR_UTILIDAD_EXITO;
        } else {
            $m = EDITAR_UTILIDAD_FRACASO;
        }
        return $m;
    }

}
