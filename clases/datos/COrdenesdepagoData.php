<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of COrdenesdepagoData
 *
 * @author Personal
 */
class COrdenesdepagoData {

    var $database = null;

    function COrdenesdepagoData($database) {
        $this->database = $database;
    }

    function obtenerOrdenesdepago($parametro) {
        $ordenes = null;
        if ($parametro != '') {
            $sql = "SELECT Id_Orden_Pago, cobro_proveedor_reintegro, Descripcion_Tipo, Descripcion_Actividad ,Nombre_Prove,Descripcion_Moneda,Tasa_Orden,
                    Numero_Orden_Pago, Fecha_Orden_Pago, Numero_Factura,valor_total,estado_orden, Fecha_Pago_Orden
                    ,Archivo_Orden, Observaciones_Orden from ordenesdepago o 
	
				inner join actividades_tipo at on o.Id_Tipo_Actividad = at.Id_Tipo
				inner join actividades a on o.Id_Actividad = a.Id_Actividad
				inner join proveedores p on o.Id_Proveedor = p.Id_Prove
				inner join monedas m on o.Id_Moneda_Orden = m.Id_Moneda	
				inner join estados_ordenes eo on o.Id_Estado_Orden = eo.Id_estado_Ordenes
                                
        WHERE $parametro";
        } else {
            $sql = "SELECT Id_Estado_Orden, Id_Orden_Pago, cobro_proveedor_reintegro, Descripcion_Tipo, Descripcion_Actividad ,Nombre_Prove,Descripcion_Moneda,Tasa_Orden,
                    Numero_Orden_Pago, Fecha_Orden_Pago, Numero_Factura,valor_total,estado_orden, Fecha_Pago_Orden
                    ,Archivo_Orden, Observaciones_Orden from ordenesdepago o 
	
				inner join actividades_tipo at on o.Id_Tipo_Actividad = at.Id_Tipo
				inner join actividades a on o.Id_Actividad = a.Id_Actividad
				inner join proveedores p on o.Id_Proveedor = p.Id_Prove
				inner join monedas m on o.Id_Moneda_Orden = m.Id_Moneda	
				inner join estados_ordenes eo on o.Id_Estado_Orden = eo.Id_estado_Ordenes";
        }

        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {

                $ordenes[$cont]['id'] = $w['Id_Orden_Pago'];
                if (isset($w['cobro_proveedor_reintegro'])) {
                    if($w['cobro_proveedor_reintegro']=='null'){
                        $ordenes[$cont]['tipoReintegro'] = PAGO_PROVEEDOR;
                    }else{
                        $ordenes[$cont]['tipoReintegro'] = CAMPO_REINTEGRO;
                    }
                }else{
                    $ordenes[$cont]['tipoReintegro'] = PAGO_PROVEEDOR;
                }
                $ordenes[$cont]['numerorden'] = $w['Numero_Orden_Pago'];
                $ordenes[$cont]['fecha'] = $w['Fecha_Orden_Pago'];
                $ordenes[$cont]['estado'] = $w['estado_orden'];
                $ordenes[$cont]['tipoactividad'] = $w['Descripcion_Tipo'];
                $ordenes[$cont]['actividad'] = $w['Descripcion_Actividad'];
                $ordenes[$cont]['proveedor'] = $w['Nombre_Prove'];
                $ordenes[$cont]['numerofactura'] = $w['Numero_Factura'];
                if (isset($w['cobro_proveedor_reintegro'])) {
                    if($w['cobro_proveedor_reintegro']=='null'){
                        $ordenes[$cont]['reintegro'] = NO_APLICA;
                    }else{
                        $ordenes[$cont]['reintegro'] = $w['cobro_proveedor_reintegro'];
                    }
                }else{
                    $ordenes[$cont]['reintegro'] = NO_APLICA;
                }
                $ordenes[$cont]['moneda'] = $w['Descripcion_Moneda'];
                $ordenes[$cont]['tasa'] = $w['Tasa_Orden'];
                $ordenes[$cont]['valortotal'] = $w['valor_total'];
                if($w['Id_Estado_Orden']==4){
                    $ordenes[$cont]['fechapago'] = $w['Fecha_Pago_Orden'];
                }else{
                    $ordenes[$cont]['fechapago'] = NO_APLICA;
                }
                $ordenes[$cont]['archivo'] = "<a href='././" . RUTA_ORDENESDEPAGO_SOPORTES . "/OPR/" .
                        ORDEN_DEPAGO_SOPORTE . "(" . $w['Fecha_Orden_Pago'] . ")" . $w['Archivo_Orden'] .
                        "' target='_blank'>{$w['Archivo_Orden']}</a>";
                $ordenes[$cont]['observaciones'] = $w['Observaciones_Orden'];
                $cont++;
            }
        }
        return $ordenes;
    }

    function ObtenerTiposActividades() {
        $TiposActividades = null;
        $sql = "select * from actividades_tipo order by Descripcion_Tipo";
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $TiposActividades[$contador]['idactividadestipo'] = $w['Id_Tipo'];
                $TiposActividades[$contador]['nombreactividadestipo'] = $w['Descripcion_Tipo'];
                $contador++;
            }
        }
        return $TiposActividades;
    }

    function ObtenerActividades($criterio) {
        $actividades = null;
        if ($criterio > 0) {
            $sql = "SELECT Id_Actividad, Descripcion_Actividad ,Descripcion_Tipo
                    FROM actividades
                    JOIN actividades_tipo ON actividades.Id_Tipo = actividades_tipo.Id_Tipo
                    WHERE actividades.Id_Tipo =" . $criterio;
        } else {
            $sql = "select Id_Actividad, Descripcion_Actividad  from actividades order by Descripcion_Actividad ";
        }
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $actividades[$contador]['idactividades'] = $w['Id_Actividad'];
                $actividades[$contador]['nombreactividades'] = $w['Descripcion_Actividad'];
                $contador++;
            }
        }
        return $actividades;
    }

    function ObtenerFamilias() {
        $familias = null;
        $sql = "select * from familias order by Descripcion_Familia";
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $familias[$contador]['idfamilia'] = $w['Id_Familia'];
                $familias[$contador]['nombrefamilia'] = $w['Descripcion_Familia'];
                $contador++;
            }
        }
        return $familias;
    }

    function ObtenerProveedores() {
        $proveedores = null;
        $sql = "select Id_Prove,Nombre_Prove from proveedores order by Nombre_Prove ";
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $proveedores[$contador]['idproveedores'] = $w['Id_Prove'];
                $proveedores[$contador]['nombreproveedores'] = $w['Nombre_Prove'];
                $contador++;
            }
        }
        return $proveedores;
    }

    function ObtenerTipos() {
        $tipos = null;
        $sql = "select * from tipo_ordenes order by Descripcion_tipo_orden";
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $tipos[$contador]['idtipo'] = $w['Id_orden_tipo'];
                $tipos[$contador]['nombretipo'] = $w['Descripcion_tipo_orden'];
                $contador++;
            }
        }
        return $tipos;
    }

    function ObtenerEstados() {
        $estados = null;
        $sql = "select * from estados_ordenes order by estado_orden";
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $estados[$contador]['idestado'] = $w['Id_estado_Ordenes'];
                $estados[$contador]['nombreestado'] = $w['estado_orden'];
                $contador++;
            }
        }
        return $estados;
    }

    function ObtenerMonedas() {
        $monedas = null;
        $sql = "select * from monedas order by Descripcion_Moneda";
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $monedas[$contador]['idmoneda'] = $w['Id_Moneda'];
                $monedas[$contador]['nombremoneda'] = $w['Descripcion_Moneda'];
                $contador++;
            }
        }
        return $monedas;
    }

    function insertarOrdendePago($id, $tipoactividad, $actividad, $numerodeorden
    , $fecha, $numerofactura, $proveedor, $moneda, $tasa, $valortotal, $estado, $fechapago, $observaciones, $cuenta_cobro, $archivo) {

        $tabla = "ordenesdepago";
        $campos = "Id_Orden_Pago,Id_Tipo_Actividad,Id_Actividad,Numero_Orden_Pago,Fecha_Orden_Pago,
				   Numero_Factura,Id_Proveedor,Id_Moneda_Orden,Tasa_Orden,
                                   valor_total,Id_Estado_Orden,Fecha_Pago_Orden,Observaciones_Orden,cobro_proveedor_reintegro,Archivo_Orden";
        $valores = "'" . $id . "','" . $tipoactividad . "','" . $actividad . "'
                   ,'" . $numerodeorden . "','" . $fecha . "','" . $numerofactura . "','" . $proveedor . "',
					'" . $moneda . "','" . $tasa . "','" . $valortotal . "',
                                        '" . $estado . "','" . $fechapago . "','" . $observaciones . "'," .$cuenta_cobro.",'". $archivo . "'";
        $r = $this->database->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }

    function getActividasporId($id) {
        $sql = "select Descripcion_Actividad from actividades where Id_Actividad=" . $id;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    function getDirectorioOperador($id) {
        $sql = "select ope_sigla from operador where ope_id=" . $id;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r)
            return $r['ope_sigla'];
        else
            return -1;
    }

    function Validartasa($id) {
        $TiposActividades = null;
        $sql = "SELECT Descripcion_Moneda
                FROM monedas
                WHERE Id_Moneda=" . $id;
        $r = $this->database->ejecutarConsulta($sql);
        $w = mysql_fetch_array($r);

        if ($w['Descripcion_Moneda'] == Pesos) {
            return true;
        } else {
            return false;
        }
    }

    function obtenerOrdenporId($id) {
        $sql = "select * from ordenesdepago where Id_Orden_Pago=" . $id;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    function borrarorden($id) {
        $tabla = "ordenesdepago";
        $predicado = "Id_Orden_Pago = " . $id;
        $r = $this->database->borrarRegistro($tabla, $predicado);
        return $r;
    }

    function ActualizarOrdendePago($id, $tipo_actividad_edit, $actividad_edit, $numerordendepago_edit, $fechaorden_edit, $numerofactura_edit, $proveedor_edit, $moneda_edit, $tasaorden_edit, $valortotal_edit, $estado_edit, $fechapagoorden_edit, $observacionesorden_edit, $cuenta_cobro, $archivo) {

        $tabla = "ordenesdepago";
        $campos = array('Id_Tipo_Actividad', 'Id_Actividad', 'Numero_Orden_Pago', 'Fecha_Orden_Pago',
            'Numero_Factura', 'Id_Proveedor', 'Id_Moneda_Orden',
            'Tasa_Orden', 'valor_total', 'Id_Estado_Orden', 'Fecha_Pago_Orden', 'Observaciones_Orden','cobro_proveedor_reintegro', 'Archivo_Orden');
        $valores = array("'" . $tipo_actividad_edit . "'", "'" . $actividad_edit . "'", "'" . $numerordendepago_edit . "'", "'" . $fechaorden_edit . "'"
            , "'" . $numerofactura_edit . "'", "'" . $proveedor_edit . "'", "'" . $moneda_edit . "'", "'" . $tasaorden_edit . "'", "'" . $valortotal_edit . "'"
            , "'" . $estado_edit . "'", "'" . $fechapagoorden_edit . "'", "'" . $observacionesorden_edit . "'",$cuenta_cobro ,"'" . $archivo . "'");

        $condicion = "Id_Orden_Pago = " . $id;
        $r = $this->database->actualizarRegistro($tabla, $campos, $valores, $condicion);
        if ($r == "true") {
            return 1;
        } else {
            return 0;
        }
    }

    function ObtenerOrdenesResumenPIA() {
        $resumen = null;
        $sql = "SELECT Nombre_Prove, Fecha_Orden_Pago, Numero_Factura, valor_total
                FROM ordenesdepago o
                INNER JOIN proveedores p ON o.Id_Proveedor = p.Id_Prove
                WHERE Id_Tipo_Actividad =1
                AND (Id_Estado_Orden =1 OR Id_Estado_Orden =4 )";
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $resumen[$contador]['NProveedor'] = $w['Nombre_Prove'];
                $resumen[$contador]['FechaOrden'] = $w['Fecha_Orden_Pago'];
                $resumen[$contador]['NumFactura'] = $w['Numero_Factura'];
                $resumen[$contador]['ValorTotal'] = $w['valor_total'];
                $contador++;
            }
        }
        return $resumen;
    }

}
