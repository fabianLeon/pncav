<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of COperador
 *
 * @author LIONELL
 */
class COperador {
    
/**
*codigo del operador
*@var integer 
*/	    
    var $id = null;
    
/**
*Nombre del operador
*@var String 
*/	    
    var $nombre = null;
    
/**
*Siglas del operador
*@var String 
*/	    
    var $siglas = null;    
    
/**
*Numero del contrato
*@var String 
*/	    
    var $contratoNo = null;
    
/**
*valor del contrato
*@var String 
*/	    
    var $contratoValor = null;    
    
/**
*Instancia de la clase COperadorData
*@var COperadorData 
*/
    var $operadorData = null;
    
/**
*Constructor de la clase
*@param object $data instancia de la clase COperadorData
*/    
    function COperador($id,$nombre,$siglas,$data)
    {
        $this->id =$id;
        $this->nombre=$nombre;
        $this->siglas=$siglas;
        $this->operadorData=$data;
    }  
        
    function getId()
    {
        return $this->id;
    }
    
    function setId($id)
    {
        $this->id=$id;
    }
    
    function getNombre()
    {
        return $this->nombre;
    }
    
    function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    function getSiglas()
    {
        return $this->siglas;        
    }
    
    function setSiglas($siglas)
    {
        $this->siglas =$siglas;
    }
    
    function getContratoNo()
    {
        return $this->contratoNo;        
    }
    
    function setContratoNo($contratoNo)
    {
        $this->contratoNo =$contratoNo;
    }
    
    function getContratoValor()
    {
        return $this->contratoValor;    
    }
    
    function setContratoValor($valor)
    {
        $this->contratoValor = $valor;
    }
    
    function loadOperador()
    {
            $r = $this->operadorData->getOperadorById($this->id);
		if($r != -1){
			$this->nombre = $r["nombre"];
			$this->siglas = $r["siglas"];
			$this->contratoNo = $r["contrato"];			                        			
		}else{
			$this->nombre = "";
			$this->siglas = "";
			$this->contratoNo = "";			                        
		}
    }
            
}

?>
