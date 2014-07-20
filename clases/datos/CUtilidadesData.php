<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CUtilidadesData
 *
 * @author Personal
 */
class CUtilidadesData {

    var $database = null;

    function CUtilidadesData($db) {

        $this->database = $db;
    }

    function obtenerUtilidades($criterio) {

        if ($criterio == '') {
            $sql = "SELECT id_utilidad, fecha_comuni, doc_soporte_comuni, porcen_utiliacion,uti_aprobada,
                 fecha_comi_fidu, num_comi_fidu, doc_soporte_act, comen_utilidades from utilidades";
        } else {
            $sql = "SELECT id_utilidad, fecha_comuni, doc_soporte_comuni, porcen_utiliacion, uti_aprobada,
                 fecha_comi_fidu, num_comi_fidu, doc_soporte_act, comen_utilidades from utilidades where num_comi_fidu like '%" . $criterio . "%'";
        }
        $utilidades = null;
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $utilidades[$cont]['id'] = $w['id_utilidad'];
                $utilidades[$cont]['fecha_Comuni'] = $w['fecha_comuni'];
                $utilidades[$cont]['doc_comuni'] = "<a href='././soportes/financiero/utilidades/OPR/" . EXTRACTO_COMUNICADO_SOPORTE . "(" . $w['fecha_comuni'] . ")". $w['doc_soporte_comuni'] . "' target='_blank'>{$w['doc_soporte_comuni']}</a>";
                $utilidades[$cont]['porcentaje'] = $w['porcen_utiliacion'];
                $utilidades[$cont]['util_aprobada'] = $w["uti_aprobada"];
                $utilidades[$cont]['fecha_comi_fidu'] = $w['fecha_comi_fidu'];
                $utilidades[$cont]['numero_comi_fidu'] = $w['num_comi_fidu'];
                $utilidades[$cont]['doc_acta'] = "<a href='././soportes/financiero/utilidades/OPR/" . EXTRACTO_ACTA_SOPORTE . "(" . $w['fecha_comuni'] . ")" . $w['doc_soporte_act'] . "' target='_blank'>{$w['doc_soporte_act']}</a>";
                $utilidades[$cont]['comentarios'] = $w['comen_utilidades'];
                $cont++;
            }
        }
        return $utilidades;
    }

    function obtenerUtilidadesFormat($criterio) {

        if ($criterio == '') {
            $sql = "SELECT id_utilidad, fecha_comuni, ano_vigencia, doc_soporte_comuni, porcen_utiliacion,uti_aprobada,
                 fecha_comi_fidu, num_comi_fidu, doc_soporte_act, comen_utilidades from utilidades";
        } else {
            $sql = "SELECT id_utilidad, fecha_comuni, ano_vigencia, doc_soporte_comuni, porcen_utiliacion, uti_aprobada,
                 fecha_comi_fidu, num_comi_fidu, doc_soporte_act, comen_utilidades from utilidades where num_comi_fidu like '%" . $criterio . "%'";
        }
        $utilidades = null;
        $r = $this->database->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $utilidades[$cont]['i'] = $w['id_utilidad'];
                $utilidades[$cont]['id'] = $w['id_utilidad'];
                $utilidades[$cont]['fecha_Comuni'] = $w['fecha_comuni'];
                $utilidades[$cont]['vigencia'] = $w['ano_vigencia'];
                $utilidades[$cont]['doc_comuni'] = "<a href='././soportes/financiero/utilidades/OPR/" . EXTRACTO_COMUNICADO_SOPORTE . "(" . $w['fecha_comuni'] . ")". $w['doc_soporte_comuni'] . "' target='_blank'>{$w['doc_soporte_comuni']}</a>";
                $utilidades[$cont]['porcentaje'] = $w['porcen_utiliacion'].'%';
                $utilidades[$cont]['util_aprobada'] = $w["uti_aprobada"];
                $utilidades[$cont]['fecha_comi_fidu'] = $w['fecha_comi_fidu'];
                $utilidades[$cont]['numero_comi_fidu'] = $w['num_comi_fidu'];
                $utilidades[$cont]['doc_acta'] = "<a href='././soportes/financiero/utilidades/OPR/" . EXTRACTO_ACTA_SOPORTE . "(" . $w['fecha_comuni'] . ")" . $w['doc_soporte_act'] . "' target='_blank'>{$w['doc_soporte_act']}</a>";
                $utilidades[$cont]['comentarios'] = $w['comen_utilidades'];
                $cont++;
            }
        }
        return $utilidades;
    }
    
    function ObtenerUtilidadporId($id_utilidad) {
        $sql = "select * from utilidades where id_utilidad=" . $id_utilidad;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    function insertarUtilidad($id, $fecha_comunicado, $vigencia, $archivo_documento, $porcentaje_utilidad, $utilidad_aprobada, $fecha_comite
    , $numerocomite, $archivo_acta, $comentarios) {

        $tabla = "utilidades";
        $campos = "id_utilidad, fecha_comuni, ano_vigencia, doc_soporte_comuni, porcen_utiliacion,uti_aprobada,
                 fecha_comi_fidu, num_comi_fidu, doc_soporte_act,comen_utilidades";
        $valores = "'" . $id . "','" . $fecha_comunicado . "'," .$vigencia.",'". $archivo_documento . "','" . $porcentaje_utilidad . "',
					'" . $utilidad_aprobada . "','" . $fecha_comite . "','" . $numerocomite . "','" . $archivo_acta . "','" . $comentarios ."'";
        $r = $this->database->insertarRegistro($tabla, $campos, $valores);
        if ($r == "true") {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function getDirectorioOperador($id) {
        $sql = "select ope_sigla from operador where ope_id=" . $id;
        $r = $this->database->recuperarResultado($this->database->ejecutarConsulta($sql));
        if ($r)
            return $r['ope_sigla'];
        else
            return -1;
    }

    function borrarUtilidad($id) {
        $tabla = "utilidades";
        $predicado = "id_utilidad=" . $id;
        $e = $this->database->borrarRegistro($tabla, $predicado);
        if ($e == "true") {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    function actualizarUtilidad($id, $id_nuevo, $fecha_comunicado_edit, $vigencia,$archivo_documento_edit,
                $porcentaje_utilidad_edit, $utilidad_aprobada_edit, $fecha_comite_edit, $numerocomite_edit, 
                $archivo_acta_edit,$comentarios_edit){
        $tabla = "utilidades";
        $campos = array('id_utilidad','fecha_comuni', 'ano_vigencia','doc_soporte_comuni', 'porcen_utiliacion','uti_aprobada',
                 'fecha_comi_fidu', 'num_comi_fidu', 'doc_soporte_act','comen_utilidades');
        $valores = array("'".$id_nuevo."'","'" . $fecha_comunicado_edit . "'",$vigencia, "'" . $archivo_documento_edit . "'", "'" . $porcentaje_utilidad_edit . "'",
            "'" . $utilidad_aprobada_edit . "'", "'" . $fecha_comite_edit . "'", "'" . $numerocomite_edit . "'",
            "'" . $archivo_acta_edit . "'", "'" . $comentarios_edit . "'");

        $condicion = "id_utilidad = " . $id;
        $r = $this->database->actualizarRegistro($tabla, $campos, $valores, $condicion);
        if ($r == "true") {
            return TRUE;
        } else {
            return FALSE;
        }
        
        
    }
    
   
    
    
    

}
