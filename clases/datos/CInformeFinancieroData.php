<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CInformeFinancieroData
 *
 * @author Brian Kings
 */
class CInformeFinancieroData {

    var $db = null;

    function CInformeFinancieroData($db) {
        $this->db = $db;
    }

    /*
     * Obtiene todos los registros InformeFinanciero de la base de datos
     */

    function getInformeFinanciero($criterio) {
        $resultado = null;
        $sql = "select ifi_id,ifi_numero_factura,ifi_fecha_factura,ifi_numero_radicado_ministerio,ifi_documento_soporte,ifi_descripcion,ifi_valor_factura,"
                . "ifi_amortizacion,ifi_saldo_pendiente_AA,ifi_observaciones,ifi_saldo_contrato"
                . " from informe_financiero "
                . " where " . $criterio;
        //echo $sql;
        $w = $this->db->ejecutarConsulta($sql);
        if ($w) {
            $cont = 0;
            while ($r = mysql_fetch_array($w)) {
                $resultado[$cont]['id_element'] = $r['ifi_id'];
                $resultado[$cont]['numero_factura'] = $r['ifi_numero_factura'];
                $resultado[$cont]['fecha_factura'] = $r['ifi_fecha_factura'];
                $resultado[$cont]['numero_radicado_ministerio'] = $r['ifi_numero_radicado_ministerio'];
                $resultado[$cont]['documento_soporte'] = "<a href='././soportes/Interventoria/Informe Financiero/" . $r['ifi_documento_soporte'] . "' target='_blank'>{$r['ifi_documento_soporte']}</a>";
                $resultado[$cont]['descripcion'] = $r['ifi_descripcion'];
                $resultado[$cont]['valor_factura'] = number_format($r['ifi_valor_factura'],2,",",".");
                $resultado[$cont]['amortizacion'] = number_format($r['ifi_amortizacion'],2,",",".");
                $resultado[$cont]['saldo_pendiente_AA'] = number_format($r['ifi_saldo_pendiente_AA'],2,",",".");
                $resultado[$cont]['observaciones'] = $r['ifi_observaciones'];
                $resultado[$cont]['saldo_contrato'] = number_format($r['ifi_saldo_contrato'],2,",",".");
                $cont++;
            }
        }
        return $resultado;
    }

    /*
     * insertar un registro InformeFinanciero en la base de datos
     */

    function insertInformeFinanciero($numero_factura, $fecha_factura, $numero_radicado_ministerio, $documento_soporte, $descripcion, $valor_factura, $amortizacion, $observaciones) {
        $saldo_pendiente_AA = $this->getSaldoPendienteAA($amortizacion);
        $saldo_contrato = $this->getSaldoContrato($valor_factura);
        $tabla = 'informe_financiero';
        $campos = "ifi_numero_factura,ifi_fecha_factura,ifi_numero_radicado_ministerio,ifi_documento_soporte,ifi_descripcion,ifi_valor_factura,"
                . "ifi_amortizacion,ifi_saldo_pendiente_AA,ifi_observaciones,ifi_saldo_contrato";
        $valores = "'" . $numero_factura . "','"
                . $fecha_factura . "','"
                . $numero_radicado_ministerio . "','"
                . $documento_soporte . "','"
                . $descripcion . "','"
                . $valor_factura . "','"
                . $amortizacion . "','"
                . $saldo_pendiente_AA . "','"
                . $observaciones . "','"
                . $saldo_contrato . "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }

    /*
     * Eliminar un registro  InformeFinanciero
     */

    function deleteInformeFinanciero($id) {
        $tabla = 'informe_financiero';
        $predicado = "ifi_id = " . $id;
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }

    /*
     * Obtiene un InformeFinanciero especifico por id
     */

    function getInformeFinancieroById($id) {
        $sql = "select ifi_numero_factura,ifi_fecha_factura,ifi_numero_radicado_ministerio,ifi_documento_soporte,ifi_descripcion,ifi_valor_factura,"
                . "ifi_amortizacion,ifi_saldo_pendiente_AA,ifi_observaciones,ifi_saldo_contrato"
                . " from informe_financiero "
                . " where ifi_id = " . $id;

        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));

        if ($r)
            return $r;
        else
            return -1;
    }

    /*
     * Actualiza un InformeFinanciero por Id
     */

    function updateInformeFinanciero($id, $numero_factura, $fecha_factura, $numero_radicado_ministerio, $documento_soporte, $descripcion, $valor_factura, $amortizacion, $observaciones) {
        $saldo_pendiente_AA = $this->getSaldoPendienteAA($amortizacion);
        $saldo_contrato = $this->getSaldoContrato($valor_factura);
        
        $tabla = 'informe_financiero';
        $campos = array( ' ifi_numero_factura', ' ifi_fecha_factura', 'ifi_numero_radicado_ministerio', ' ifi_documento_soporte', ''
            . ' ifi_descripcion', ' ifi_valor_factura', ' ifi_amortizacion', ' ifi_saldo_pendiente_AA', ' ifi_observaciones', ' ifi_saldo_contrato');
        $valores = array("'" . $numero_factura . "'",
            "'" . $fecha_factura . "'",
            "'" . $numero_radicado_ministerio . "'",
            "'" . $documento_soporte . "'",
            "'" . $descripcion . "'",
            "'" . $valor_factura . "'",
            "'" . $amortizacion . "'",
            "'" . $saldo_pendiente_AA . "'",
            "'" . $observaciones . "'",
            "'" . $saldo_contrato . "'");
        $condicion = " ifi_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    function getSaldoPendienteAA($amortizacion) {
        $sql = "select SUM(act_monto) from actividadPIA ";
        //echo("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        $w = mysql_fetch_array($r);
        return $w[0]-$amortizacion;
    }

    function getSaldoContrato($valor_factura) {
        return INFORME_FINANCIERO_SALDO_CONTRATO_VALOR-$valor_factura;
    }

}
