<?php

/**
 */
Class COrdenesData {

    var $db = null;

    function COrdenesData($db) {
        $this->db = $db;
    }

    function getTotalOrden($predicado) {
        $tabla = 'ordenes';
        $campo = 'coalesce(sum(ord_pesos),0)';
        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);

        if ($r)
            return $r;
        else
            return 0;
    }

    function getRubros($operador) {
        $salida = null;
        $sql = "select *
				from rubro_op
				where ope_id=" . $operador . " order by rub_nombre";

        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $salida[$cont]['id'] = $w['rub_id'];
                $salida[$cont]['nombre'] = $w['rub_nombre'];
                $cont++;
            }
        }
        return $salida;
    }

    function getConceptos($operador) {
        $salida = null;
        $sql = "select *
				from concepto_op
				where ope_id=" . $operador . " order by cnc_nombre";

        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $salida[$cont]['id'] = $w['cnc_id'];
                $salida[$cont]['nombre'] = $w['cnc_nombre'];
                $cont++;
            }
        }
        return $salida;
    }

    function getModalidades($operador) {
        $salida = null;
        $sql = "select *
				from modalidad_op
				where ope_id=" . $operador . " order by mod_nombre";

        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $salida[$cont]['id'] = $w['mod_id'];
                $salida[$cont]['nombre'] = $w['mod_nombre'];
                $cont++;
            }
        }
        return $salida;
    }

    function getOrden($criterio, $orden) {
        $salida = null;
        $sql = "select * from ordenes o
				inner join rubro_op     r on r.rub_id=o.rub_id
				inner join concepto_op  c on c.cnc_id=o.cnc_id
				inner join modalidad_op m on m.mod_id=o.mod_id
				where " . $criterio . " order by " . $orden;
        //echo "<br>getOrden:".$sql;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            $acumulado = 0;
            while ($w = mysql_fetch_array($r)) {
                $salida[$cont]['id'] = $w['ord_id'];
                $salida[$cont]['fecha'] = $w['ord_fecha'];
                $salida[$cont]['numero'] = $w['ord_numero'];
                $salida[$cont]['rubro'] = $w['rub_nombre'];
                $salida[$cont]['concepto'] = $w['cnc_nombre'];
                $salida[$cont]['modalidad'] = $w['mod_nombre'];
                $salida[$cont]['tasa'] = $w['ord_tasa'];
                $salida[$cont]['dolares'] = number_format($w['ord_dolares'], 2, ',', '.');
                $salida[$cont]['pesos'] = number_format($w['ord_pesos'], 2, ',', '.');
                $acumulado = $acumulado + $w['ord_pesos'];
                $salida[$cont]['acumulado'] = number_format($acumulado, 2, ',', '.');
                $cont++;
            }
        }
        return $salida;
    }

    function insertOrden($operador, $fecha, $numero, $rubro, $concepto, $modalidad, $tasa, $valor_dolares, $valor_pesos) {
        $tabla = "ordenes";
        $campos = "ope_id,ord_fecha,ord_numero,rub_id,cnc_id,
					mod_id,ord_tasa,ord_dolares,ord_pesos";
        $valores = "'" . $operador . "','" . $fecha . "','" . $numero . "','" . $rubro . "','" . $concepto . "',
					'" . $modalidad . "','" . $tasa . "','" . $valor_dolares . "','" . $valor_pesos . "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }

    function getOrdenById($id) {
        $salida = null;
        $sql = "select * from ordenes where ord_id=" . $id;
        //echo ("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $salida['ope_id'] = $w['ope_id'];
                $salida['ord_fecha'] = $w['ord_fecha'];
                $salida['ord_numero'] = $w['ord_numero'];
                $salida['rub_id'] = $w['rub_id'];
                $salida['cnc_id'] = $w['cnc_id'];
                $salida['mod_id'] = $w['mod_id'];
                $salida['ord_tasa'] = $w['ord_tasa'];
                $salida['ord_dolares'] = $w['ord_dolares'];
                $salida['ord_pesos'] = $w['ord_pesos'];
                $cont++;
            }
        }
        return $salida;
    }

    function updateOrden($id, $operador, $fecha, $numero, $rubro, $concepto, $modalidad, $tasa, $valor_dolares, $valor_pesos) {
        $tabla = "ordenes";
        $campos = array('ord_fecha', 'ord_numero', 'rub_id', 'cnc_id',
            'mod_id', 'ord_tasa', 'ord_dolares', 'ord_pesos');
        $valores = array("'" . $fecha . "'", "'" . $numero . "'", "'" . $rubro . "'", "'" . $concepto . "'",
            "'" . $modalidad . "'", "'" . $tasa . "'", "'" . $valor_dolares . "'", "'" . $valor_pesos . "'");
        $predicado = "ord_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $predicado);
        return $r;
    }

    function deleteOrden($id) {
        $tabla = "ordenes";
        $predicado = "ord_id = " . $id;
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }

}

?>