<?php

/**
 * 
 *
 * <ul>
 * <li> Redcom Ltda <www.redcom.com.co></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */

/**
 * Clase Compromiso
 *
 * @package  clases
 * @subpackage aplicacion
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
Class CRecomendaciones {

    var $id = null;
    var $actividad = null;
    var $tema = null;
    var $subtema = null;
    var $referencia = null;
    var $fecha_limite = null;
    var $fecha_entrega = null;
    var $estado = null;
    var $observaciones = null;
    var $operador = null;
    var $consecutivo = null;
    var $cc = null;
    
    var $responsable = null;

    /**
     * * Constructor de la clase CCompromisoData
     * */
    function CRecomendaciones($id, $cc) {
        $this->id = $id;
        $this->cc = $cc;
    }
    
    function setId($val) {
        $this->id=$val;
    }

    function setActividad($val) {
        $this->actividad=$val;
    }

    function setTema($val) {
        $this->tema=$val;
    }

    function setSubtema($val) {
        $this->subtema=$val;
    }

    function setReferencia($val) {
        $this->referencia=$val;
    }

    function setFechaLimite($val) {
        $this->fecha_limite=$val;
    }

    function setFechaEntrega($val) {
        $this->fecha_entrega=$val;
    }

    function setEstado($val) {
        $this->estado=$val;
    }

    function setObservaciones($val) {
        $this->observaciones=$val;
    }

    function setOperador($val) {
        $this->operador=$val;
    }
    
    function setCosecutivo($val) {
        $this->consecutivo=$val;
    }
    
    function setResponsable($val){
        $this->responsable = $val;
    }

    function getId() {
        return $this->id;
    }

    function getActividad() {
        return $this->actividad;
    }

    function getTema() {
        return $this->tema;
    }

    function getSubtema() {
        return $this->subtema;
    }

    function getReferencia() {
        return $this->referencia;
    }

    function getFechaLimite() {
        return $this->fecha_limite;
    }

    function getFechaEntrega() {
        return $this->fecha_entrega;
    }

    function getEstado() {
        return $this->estado;
    }

    function getObservaciones() {
        return $this->observaciones;
    }

    function getOperador() {
        return $this->operador;
    }
    
    function getConsecutivo() {
        return $this->consecutivo;
    }
    
    function getResponsable(){
        return $this->responsable;
    }

    /**
     * * carga los valores de un objeto COMPROMISO por su id para ser editados
     * */
    function loadCompromiso() {
        $r = $this->cc->getCompromisoById($this->id);
        if ($r != -1) {
            $this->id = $r['com_id'];
            $this->actividad = $r['com_actividad'];
            $this->tema = $r['dot_id'];
            $this->subtema = $r['dos_id'];
            $this->referencia = $r['doc_id'];
            $this->fecha_limite = $r['com_fecha_limite'];
            $this->fecha_entrega = $r['com_fecha_entrega'];
            $this->estado = $r['ces_id'];
            $this->observaciones = $r['com_observaciones'];
            $this->consecutivo = $r['com_consecutivo'];
        } else {
            $this->id = "";
            $this->actividad = "";
            $this->tema = "";
            $this->subtema = "";
            $this->referencia = "";
            $this->fecha_entrega = "";
            $this->fecha_limite = "";
            $this->estado = "";
            $this->observaciones = "";
            $this->consecutivo = "";
        }
    }

    /**
     * * carga los valores de un objeto COMPROMISO por su id para ser visualizados
     * */
    function loadSeeCompromiso() {

        $r = $this->cc->getCompromisosSee($this->id);
        if ($r != -1) {
            $this->id = $r['com_id'];
            $this->actividad = $r['com_actividad'];
            $this->tema = $r['dot_id'];
            $this->subtema = $r['doc_id'];
            $this->referencia = $r['doc_id'];
            $this->fecha_limite = $r['com_fecha_limite'];
            $this->fecha_entrega = $r['com_fecha_entrega'];
            $this->estado = $r['ces_id'];
            $this->observaciones = $r['com_observaciones'];
            $this->consecutivo = $r['com_consecutivo'];
        } else {
            $this->id = "";
            $this->actividad = "";
            $this->tema = "";
            $this->referencia = "";
            $this->fecha_entrega = "";              
            $this->fecha_limite = "";
            $this->estado = "";
            $this->observaciones = "";
            $this->consecutivo = "";
        }
    }

    /**
     * * almacena un objeto COMPROMISO y retorna un mensaje del resultado del proceso
     * */
    function saveNewCompromiso() {
        $i = $this->cc->insertCompromiso($this);

        if ($i == "true") {
            $r = RECOMENDACIONES_AGREGADO;
            $compromiso=$this->cc->db->getMaxValue('recomendaciones','com_id');
            $resData = new CRecomendacionesResponsableData($this->cc->db);
        
            $responsablenuevo = new CRecomendacionesResponsable('', $compromiso, $this->responsable, $resData);
            $responsablenuevo->saveNewResponsable();
            
        } else {
            $r = ERROR_ADD_RECOMENDACIONES;
        }
        return $r;
    }

    /**
     * * elimina un objeto COMPROMISO y retorna un mensaje del resultado del proceso
     * */
    function deleteCompromiso() {
        $r = $this->cc->deleteCompromiso($this->id);
        if ($r == 'true') {
            $msg = RECOMENDACIONES_BORRADO;
        } else {
            $msg = ERROR_DEL_RECOMENDACIONES;
        }
        return $msg;
    }

    /**
     * * actualiza un objeto COMPROMISO y retorna un mensaje del resultado del proceso
     * */
    function saveEditCompromiso() {
        $r = $this->cc->updateCompromiso($this);
        if ($r == 'true') {
            $msg = RECOMENDACIONES_EDITADO;
        } else {
            $msg = ERROR_EDIT_RECOMENDACIONES;
        }
        return $msg;
    }
    
    

}

?>