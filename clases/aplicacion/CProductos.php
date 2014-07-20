<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CProductos
 *
 * @author Personal
 */
class CProductos {
    
    var $orden = null;
    var $tipo=null;
    var $familia=null;
    var $cantidad=null;
    var $valorUnitario=null;
    var $descripcion=null;
            
    function CProductos($orden,$tipo,$familia,$descricion,$cantidad,$valorunitario) {
        $this->orden = $orden;
        $this->tipo=$tipo;
        $this->familia=$familia;
        $this->cantidad=$cantidad;
        $this->valorUnitario=$valorunitario;
        $this->descripcion=$descricion;                
      }
    
    function Productos() {
        $this->orden = null;
        $this->tipo=null;
        $this->familia=null;
        $this->cantidad=null;
        $this->valorUnitario=null;
        $this->descripcion=null;                
      }
     
  }
