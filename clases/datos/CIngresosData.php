<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CIngresosData
 *
 * @author Personal
 */
class CIngresosData {

    var $database = null;

    function CIngresosData($database) {
        $this->database = $database;
    }

    function Obteneringresos() {
        $sql = "SELECT Id_Ingreso,Tipo_Ingreso,A_Ingreso,CONCAT(Tipo_Ingreso ,' ', A_Ingreso)"
                . ",Monto_Ingreso from ingresos ORDER BY A_Ingreso, Tipo_Ingreso Desc ";
        $ingresos = null;
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {

                $ingresos[$cont]['id'] = $w["Id_Ingreso"];
                $ingresos[$cont]['res_vigen'] = $w["CONCAT(Tipo_Ingreso ,' ', A_Ingreso)"];
                $ingresos[$cont]['motoo'] = $w["Monto_Ingreso"];
                $cont++;
            }
        }
        return $ingresos;
    }
    
    function obtenerTotalIngresos(){
        $sql = "SELECT SUM(Monto_Ingreso) FROM ingresos";
        $r = $this->database->ejecutarConsulta($sql);
        if($r){
            while($w = mysql_fetch_array($r)){
                return $w['SUM(Monto_Ingreso)'];
            }
        }
    }

    function obteneranos($ano) {
        $sql = "SELECT A_Ingreso from ingresos where A_Ingreso=" . $ano;
        $r = $this->database->ejecutarConsulta($sql);
        if (mysql_num_rows($r) > 0) {
            return true;
        } else {
            return false;
        }
    }

    function Obtenertipodeingreso($year) {
        $sql = "SELECT Tipo_Ingreso from ingresos where A_Ingreso=" . $year;
        $tipoingresos = null;
        $r = $this->database->ejecutarConsulta($sql);
        $tem = 0;
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                for ($i = 0; $i < count($w) / 2; $i++) {
                    $tipoingresos[$cont][$i] = $w[$i];
                    if ($w[$i] == "Adición") {
                        $temp = 1;
                    } else {
                        $temp = 0;
                    }
                    $cont++;
                }
            }
        }
        return $temp;
    }

    function Insertaringreso($id, $Fecha, $monto, $tipo) {
        $tabla = "ingresos";
        $campos = "Id_Ingreso,A_Ingreso,Monto_Ingreso,Tipo_Ingreso";
        $valores = "'" . $id . "','" . $Fecha . "','" . $monto . "','" . $tipo . "'";
        $r = $this->database->insertarRegistro($tabla, $campos, $valores);
        if ($r == "true") {
            return MENSAJE_AGREGAR_EXITO_INGRESO;
        } else {
            return MENSAJE_AGREGAR_FRACASO_INGRESO;
        }
    }

    function eliminaringresos($id) {
        $tabla = "ingresos";
        $predicado = "Id_Ingreso=" . $id;
        $e = $this->database->borrarRegistro($tabla, $predicado);
        if ($e == "true") {
            return 1;
        } else {
            return 0;
        }
    }

    function obteneringresoporid($id) {
        $sql = "select * from ingresos where Id_Ingreso= " . $id;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    function actualizaringreso($id, $monto) {

        $tabla = "ingresos";
        $campos = array('Monto_Ingreso');
        $valores = array("'" . $monto . "'");

        $condicion = "Id_Ingreso = " . $id;
        $r = $this->database->actualizarRegistro($tabla, $campos, $valores, $condicion);
        if ($r == "true") {
            return 1;
        } else {
            return 0;
        }
    }

    function ObtenerValoresIngresos($year) {
        $sql = "SELECT CONCAT('Vigencia ',A_Ingreso), SUM( Monto_Ingreso) FROM ingresos WHERE A_Ingreso =" . $year;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }
    
    function ObtenerValoresOrdenesdePagoByActividad($year, $tipo) {
        $sql = "SELECT SUM( valor_total ) FROM ordenesdepago WHERE (Id_Estado_Orden =1
                  OR Id_Estado_Orden =4 ) AND YEAR( Fecha_Orden_Pago ) = $year "
                . "AND Id_Tipo_Actividad $tipo";
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }
    
    function ObtenerValoresOrdenesdePago($year) {
        $sql = "SELECT SUM( valor_total ) FROM ordenesdepago WHERE (Id_Estado_Orden =1
                  OR Id_Estado_Orden =4 ) AND YEAR( Fecha_Orden_Pago ) =" . $year;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }

    function ObtenerValoresUtilidades($year) {
        $sql = "SELECT SUM( uti_aprobada ),Count(uti_aprobada) FROM utilidades WHERE ano_vigencia =" . $year;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }
    
    function ObtenerValoresUtilidadesByCriterio($year, $criterio) {
        $sql = "SELECT SUM( uti_aprobada ),Count(uti_aprobada) FROM utilidades WHERE ano_vigencia =$year AND $criterio";
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }

    function ObtenerValoresDesembolsos($year) {
        $sql = "SELECT COUNT( des_efectuado ) , SUM( des_efectuado )FROM desembolso WHERE YEAR( des_fecha_efectiva ) =" . $year;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }

    function ObtenerValoresActividades() {
        $sql = "SELECT SUM( Monto_Actividad ) FROM actividades WHERE Id_Tipo =2";
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }

    function ObtenerOrdenesInversiondelAnticipo() {
        $sql = "SELECT SUM( valor_total )FROM ordenesdepago WHERE Id_Tipo_Actividad =2 AND (Id_Estado_Orden =1
                  OR Id_Estado_Orden =4 )";
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }

    function ObtenerYears() {
        $Years = null;
        $sql = "SELECT A_Ingreso FROM ingresos  GROUP BY  A_Ingreso";
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {

                $Years[$cont]['A_Ingreso'] = $w["A_Ingreso"];
                $cont++;
            }
        }
        return $Years;
    }

    function ObtenerActividaedesInversiondelAnticipo() {
        $actividades = null;
        $sql = "SELECT Id_Actividad, Descripcion_Actividad, Monto_Actividad from actividades where Id_Tipo=2";
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {

                $actividades[$cont]['Id_Actividad'] = $w["Id_Actividad"];
                $actividades[$cont]['Descripcion_Actividad'] = $w["Descripcion_Actividad"];
                $actividades[$cont]['Monto_Actividad'] = $w["Monto_Actividad"];
                $cont++;
            }
        }
        return $actividades;
    }

    function ObtenerValoresActividadesOrdenesdepago($descripcion_actividad) {

        $sql = "SELECT SUM(valor_total) from ordenesdepago WHERE Id_Actividad=$descripcion_actividad AND (Id_Estado_Orden =1
                  OR Id_Estado_Orden =4 )" ;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }

}

?>
