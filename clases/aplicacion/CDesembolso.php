<?php
/**
*/

class CDesembolso{
    
    /**
    *Identificador único del rubro
    *@var integer 
    */
    var $id = null;
    
    /**
     * Fecha de desembolso
     * @var date 
     */
    var $fecha = null;
    
    /**
     * Documento de soporte de las condiciones
     * @var Doc 
     */
    var $condicion = null;
    
    /**
     * Porcentaje de desembolso
     * @var real 
     */
    var $porcentaje = null;
    
    /**
     * Variable que determína la aprobación de un desembolso
     * @var real 
     */
    var $aprobado = null;
    
    /**
     * Porcentaje de amortización del desembolso
     * @var real 
     */
    var $porcentaje_amortizacion = null;
    
    /**
     * Valor de amortización del desembolso
     * @var real 
     */
    var $amortizacion = null;
    
    /**
     * Fecha de cumplimiento de metas
     * @var date 
     */
    var $fecha_cumplimiento = null;
    
    /**
     * Fecha de tramide de desembolso
     * @var date 
     */
    var $fecha_tramite = null;
    
    /**
     * Fecha efectiva del desembolso
     * @var date 
     */
    var $fecha_efectiva = null;
    
    /**
     * Fecha límite de desembolso
     * @var date 
     */
    var $fecha_limite = null;
    
    /**
     * Desembolso efectuado
     * @var real 
     */
    var $efectuado = null; 
        
    /**
    *identificador unico del rubro
    *@var CDesembolsoData 
    */
    var $db = null;
    
    /**
    *Constructor de la clase
    *@param object $dr instancia de la clase CDesembolsoData
    */				
   function CDesembolso($id, $operador, $fecha, $condicion, $porcentaje, 
           $aprobado, $porcentaje_amortizacion, $amortizacion, $fecha_cumplimiento, 
           $fecha_tramite, $fecha_efectiva, $fecha_limite, $efectuado, $db) {
       $this->id = $id;
       $this->operador = $operador;
       $this->fecha = $fecha;
       $this->condicion = $condicion;
       $this->porcentaje = $porcentaje;
       $this->aprobado = $aprobado;
       $this->porcentaje_amortizacion = $porcentaje_amortizacion;
       $this->amortizacion = $amortizacion;
       $this->fecha_cumplimiento = $fecha_cumplimiento;
       $this->fecha_tramite = $fecha_tramite;
       $this->fecha_efectiva = $fecha_efectiva;
       $this->fecha_limite = $fecha_limite;
       $this->efectuado = $efectuado;
       $this->db = $db;
   }

   
   /**
    *retorna el identificador del rubro
    *@return integer
    */					
    function getId()				{return $this->id;}
    function getOperador()			{return $this->operador;}
    function getFecha()				{return $this->fecha;}
    function getCondicion()			{return $this->condicion;}
    function getPorcentaje()                    {return $this->porcentaje;}
    function getAprobado()			{return $this->aprobado;}
    function getAmortizacion()                  {return $this->amortizacion;}
    function getFecha_cumplimiento()            {return $this->fecha_cumplimiento;}
    function getFechaCumplimiento()             {return $this->fecha_cumplimiento;}
    function getFechaTramite()                  {return $this->fecha_tramite;}
    function getFechaCertificacion()            {return $this->fecha_efectiva;}
    function getFechaLimite()                   {return $this->fecha_limite;}
    function getEfectuado()			{return $this->efectuado;}

    /**
    *almacena un rubro, validando la no existencia del nombre ingresado y retorna un mensaje del resultado del proceso
    *@return string
    */				
    function saveNewDesembolso(){
        $r = $this->db->insertDesembolso($this->operador,$this->fecha,$this->condicion,$this->porcentaje,$this->aprobado,$this->fecha_cumplimiento,
                                                                        $this->fecha_tramite,$this->fecha_efectiva,$this->fecha_limite,$this->efectuado);
        if($r=='true'){
            $msg = DESEMBOLSO_AGREGADO;
        }else{
            $msg = ERROR_ADD_DESEMBOLSO;
        }
        return $msg;
    }
    
    /**
    *carga los valores de un rubro por su id
    */				
    function loadDesembolso(){
        $r = $this->db->getDesembolsoById($this->id);
        if($r != -1){
            $this->operador 			= $r['ope_id'];
            $this->fecha 				= $r['des_fecha'];
            $this->condicion 			= $r['des_condicion'];
            $this->porcentaje 			= $r['des_porcentaje'];
            $this->aprobado 			= $r['des_aprobado'];
            $this->fecha_cumplimiento 	= $r['des_fecha_cumplimiento'];
            $this->fecha_tramite 		= $r['des_fecha_tramite'];
            $this->fecha_efectiva 	= $r['des_fecha_certificacion'];
            $this->fecha_limite 		= $r['des_fecha_limite'];
            $this->efectuado 			= $r['des_efectuado'];
        }else{
            $this->operador 			= "";
            $this->fecha 				= "";
            $this->condicion 			= "";
            $this->porcentaje 			= "";
            $this->aprobado 			= "";
            $this->fecha_cumplimiento 	= "";
            $this->fecha_tramite 		= "";
            $this->fecha_efectiva 	= "";
            $this->fecha_limite 		= "";
            $this->efectuado 			= "";

        }
    }
    
    /**
    *borra un rubro y retorna un mensaje del resultado del proceso
    *@return string
    */			
    function deleteDesembolso(){
        $r = $this->db->deleteDesembolso($this->id);
        if($r=='true'){
            $msg = DESEMBOLSO_BORRADO;		
        }else{
            $msg = ERROR_DEL_DESEMBOLSO;
        }
        return $msg;
    }

    /**
    *actualiza los valores de un rubro y retorna un mensaje del resultado del proceso
    *@return string
    */			
    function saveEditDesembolso(){
        $r = $this->db->updateDesembolso($this->id,$this->operador,$this->fecha,$this->condicion,$this->porcentaje,$this->aprobado,$this->fecha_cumplimiento,
                                                                        $this->fecha_tramite,$this->fecha_efectiva,$this->fecha_limite,$this->efectuado);
        if($r=='true'){
            $msg = DESEMBOLSO_EDITADO;
        }else{
            $msg = ERROR_EDIT_DESEMBOLSO;
        }
        return $msg;
    }
	
}
?>