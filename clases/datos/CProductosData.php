<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CProductosData
 *
 * @author Personal
 */
class CProductosData {

    var $database = null;

    function CProductosData(CData $database) {
        $this->database = $database;
    }

    function insertarProducto($producto) {
        $tabla = "productos";
        $campos = "id_orden,tipo_produ,familia_produc,descripcion_produc,cantidad_produ,valor_produc";
        $valores = $producto->orden.",'" . $producto->tipo . "','" . $producto->familia . "','" .$producto->descripcion  .
                "','" . $producto->cantidad . "','" . $producto->valorUnitario . "'";
        $r = $this->database->insertarRegistro($tabla, $campos, $valores);
        if($r=='true'){
            return PRODUCTO_AGREGADO;
        }else{
            return ERROR_PRODUCTO_AGREGADO;
        }
    }
    function editarProducto($id, $tipo, $familia, $descripcion, $cantidad, $valorUnitario) {
        $tabla = "productos";
        $campos = array("tipo_produ","familia_produc","descripcion_produc","cantidad_produ","valor_produc");
        $valores = array("'" . $tipo . "'","'" . $familia . "'","'" .$descripcion  .
                "'","'" . $cantidad . "'","'" . $valorUnitario . "'");
        $r = $this->database->actualizarRegistro($tabla, $campos, $valores, " id_produ = ".$id);
        if($r=='true'){
            return PRODUCTO_EDITADO;
        }else{
            return ERROR_PRODUCTO_EDITADO;
        }
    }
    
    function consultarProductoById($id){
        $sql = "SELECT p.*, Descripcion_Familia FROM productos p, familias "
                . "WHERE Id_Familia = familia_produc  AND id_produ = ".$id;
        $r = $this->database->ejecutarConsulta($sql);
        $productos=null;
        if($r){
            while($w = mysql_fetch_array($r)){
                $productos['id']=$w['id_produ'];
                $productos['tipo'] = $w['tipo_produ'];
                $productos['familia']=$w['Descripcion_Familia'];
                $productos['cantidad']=$w['cantidad_produ'];
                $productos['descripcion']=$w['descripcion_produc'];
                $productos['valor']=$w['valor_produc'];
                return $productos;
            }
        }
    }
    
    function consultarProductosByOrden($orden){
        $sql = "SELECT p.*, Descripcion_Familia FROM productos p, familias "
                . "WHERE Id_Familia = familia_produc  AND id_orden = ".$orden;
        $r = $this->database->ejecutarConsulta($sql);
        $productos=null;
        if($r){
            $cont =0;
            while($w = mysql_fetch_array($r)){
                $productos[$cont]['id']=$w['id_produ'];
                if ($w['tipo_produ'] == 1) {
                    $productos[$cont]['tipo'] = "Bien";
                } else {
                    $productos[$cont]['tipo'] = "Servicio";
                }
                $productos[$cont]['familia']=$w['Descripcion_Familia'];
                $productos[$cont]['cantidad']=$w['cantidad_produ'];
                $productos[$cont]['descripcion']=$w['descripcion_produc'];
                $productos[$cont]['valor']=$w['valor_produc'];
                $cont++;
            }
        }
        return $productos;
    }
    
    function eliminarById($id){
        $r=$this->database->borrarRegistro("productos","id_produ = $id");
        if($r=='true') return PRODUCTO_ELIMINADO;
        return ERROR_PRODUCTO_ELIMINADO;
    }
    
    function eliminarByOrden($id){
        $r=$this->database->borrarRegistro("productos","id_orden = $id");
        if($r!=0) return true;
        return false;
    }

}
