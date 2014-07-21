<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CEncuestaData
 *
 * @author Brian Kings
 */
class CEjecucionData {

    var $db = null;

    function CEjecucionData($db) {
        $this->db = $db;
    }
    /*
     * Obtiene el numero de ejes existenes
     */

    function getNumeroEjes() {
        $sql = "select count(*) from eje " ;
        $r = ($this->db->ejecutarConsulta($sql));
        if ($r) {
            $w = mysql_fetch_array($r);
            return $w['count(*)'];
        }
    }
    /*
     * Obtiene el numero total de encuestas ejecutadas en cada tipo de eje
     */

    function getResumenEjecucion($criterio, $excel, $porcentaje) {
        $contadorEje = 1;
        $arreglo = null;
        $resumen = null;
        $total = null;
        $numeroEjes=  $this->getNumeroEjes();
        $divisorTotal = $numeroEjes;
        while ($contadorEje <= $numeroEjes) {  
            $sql = "SELECT pla.eje_id, count(*) FROM encuesta enc left join planeacion pla on pla.pla_id=enc.pla_id 
                    left join eje eje on eje.eje_id = pla.eje_id 
                    left join encuesta_estado ess on ess.ees_id = enc.ees_id 
                    left join municipio m on m.mun_id = pla.mun_id 
                    left join departamento d on d.dep_id = m.dep_id 
                    left join departamento_region der on der.der_id=d.der_id 
                    WHERE enc.ees_id = 1 and pla.eje_id=" . $contadorEje . " and " . $criterio . " group by pla.eje_id";
            //total
            $sql2 = "SELECT pla.eje_id,e.eje_nombre, count(*), SUM(pla.pla_numero_encuestas) FROM planeacion pla 
                    inner join eje e on e.eje_id = pla.eje_id 
                    left join encuesta enc on enc.pla_id = pla.pla_id
                    left join municipio m on m.mun_id = pla.mun_id 
                    left join departamento d on d.dep_id = m.dep_id 
                    left join departamento_region der on der.der_id=d.der_id 
                    left join instrumento t on t.ins_id = e.ins_id
                    where pla.eje_id =" . $contadorEje . " and " . $criterio
                    . " group by eje_id";

            //echo $sql;
            $r = $this->db->ejecutarConsulta($sql);
            $r2 = $this->db->ejecutarConsulta($sql2);
            $w = mysql_fetch_array($r);
            $w2 = mysql_fetch_array($r2);
            if ($w['count(*)'] == '') {
                $resumen[$contadorEje - 1] = '0%';
                $divisorTotal--;
            } else {
                $resumen[$contadorEje - 1] = round(($w['count(*)'] * 100) / ($w2['SUM(pla.pla_numero_encuestas)'] / $w2['count(*)']), 4) . '%';
            }
            if ($w2['count(*)'] != 0 && $w2['SUM(pla.pla_numero_encuestas)'] != 0) {
                $total+=round(($w['count(*)'] * 100) / ($w2['SUM(pla.pla_numero_encuestas)'] / $w2['count(*)']), 4);
            } else {
                $total+=0;
            }
            $contadorEje++;
        }
        if ($divisorTotal > 0) {
            $total = round(($total / $divisorTotal), 4);
        }
        if (!$excel) {
            if ($total <= 51) {
                $total = '<img src=./templates/img/ico/rojo.gif>' . $total . '%';
            } elseif ($total > 51 && $total <= $porcentaje) {
                $total = '<img src=./templates/img/ico/amarillo.gif>' . $total . '%';
            } else {
                $total = '<img src=./templates/img/ico/verde.gif>' . $total . '%';
            }
        }
        $resumen[$contadorEje - 1] = $total;
        return $resumen;
    }

    /*
     * Obtiene todas las encuestas registradas
     */

    function getEEncuestas($criterio, $excel) {
        $encuesta = null;
        $sql = "SELECT enc.enc_id, enc.enc_consecutivo,pla.pla_id, eje.eje_nombre, enc.enc_documento_soporte ,   
            enc.enc_fecha, ecc.ecc_nombre, enc.enc_motivo_cuestionario_incorrecto, erf.erf_nombre,evi.evi_nombre,eri.eri_nombre,
            enc.enc_motivo_encuesta_incorrecta, CONCAT( usu.usu_nombre,'  ',usu.usu_apellido)AS usu_nombre,ess.ees_nombre,
            pla.pla_fecha_fin,pla.pla_fecha_inicio FROM encuesta enc 
            left join planeacion pla on pla.pla_id = enc.pla_id 
            left join eje eje on eje.eje_id = pla.eje_id 
            left join encuesta_estado ess on ess.ees_id = enc.ees_id 
            left join encuesta_cuestionario_completo ecc on ecc.ecc_id = enc.ecc_id
            left join encuesta_resultado_final erf on erf.erf_id = enc.erf_id
            left join encuesta_validar_inspeccion evi on evi.evi_id = enc.evi_id
            left join encuesta_resultado_inspeccion eri on eri.eri_id = enc.eri_id
            left join usuario usu on usu.usu_id = enc.usu_id
            WHERE " . $criterio;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $encuesta[$cont]['id_element'] = $w['enc_id'];
                $encuesta[$cont]['consecutivo'] = $w['enc_consecutivo'];
                $encuesta[$cont]['eje'] = $w['eje_nombre'];
                $encuesta[$cont]['documento_soporte'] = "<a href='././soportes/EJECUCION/" . $w['pla_id'] . "/" . $w['enc_documento_soporte'] . "' target='_blank'>{$w['enc_documento_soporte']}</a>";
                $encuesta[$cont]['fecha'] = $w['enc_fecha'];
                $encuesta[$cont]['ecc'] = $w['ecc_nombre'];
                $encuesta[$cont]['motivo_ci'] = $w['enc_motivo_cuestionario_incorrecto'];
                $encuesta[$cont]['erf'] = $w['erf_nombre'];
                $encuesta[$cont]['evi'] = $w['evi_nombre'];
                $encuesta[$cont]['eri'] = $w['eri_nombre'];
                $encuesta[$cont]['motivo_ei'] = $w['enc_motivo_encuesta_incorrecta'];
                $encuesta[$cont]['responsable'] = $w['usu_nombre'];
                if (!$excel) {
                    $encuesta[$cont]['estado'] = $this->semaforo_seguimiento($w['pla_fecha_fin'], $w['ees_nombre']);
                } else {
                    if ($w['ees_nombre'] == 'Completo') {
                        $encuesta[$cont]['estado'] = 'Completo';
                    } else {
                        $encuesta[$cont]['estado'] = $this->dias_transcurridos_entre_fechas(date('Y-m-d'), $w['pla_fecha_fin']) . ' días.';
                    }
                }
                $cont++;
            }
        }
        return $encuesta;
    }

    /*
     * Calcula los días entre dos fechas
     */

    function dias_transcurridos_entre_fechas($fecha_i, $fecha_f) {
        $dias = (strtotime($fecha_f) - strtotime($fecha_i)) / 86400;
        //$dias = abs($dias);
        $dias = floor($dias);
        return $dias;
    }

    /*
     * Asigna imagen de color dependiendo de los días entre la fecha
     * actual y la fecha limite de la encuesta.
     */

    function semaforo_seguimiento($fecha_fin, $estado) {
        if ($estado == 'Completo') {
            $dias = '<img src=./templates/img/ico/verde.gif>';
            return $dias;
        } else {
            $dias = null;
            $dias = $this->dias_transcurridos_entre_fechas(date('Y-m-d'), $fecha_fin);
            if ($dias >= 0) {
                $dias = '<img src=./templates/img/ico/amarillo.gif>' . $dias . ' días.';
            }
            if ($dias < 0) {
                $dias = '<img src=./templates/img/ico/rojo.gif>' . ($dias * (-1)) . ' días.';
            }
            return $dias;
        }
    }

    /*
     * Obtiene los tipos de estados
     */

    function getEncuestaEstados() {
        $preguntas = null;
        $sql = "SELECT ees_id, ees_nombre FROM encuesta_estado ";
        $r = $this->db->ejecutarConsulta($sql);
        //echo $sql;
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $preguntas[$cont]['id'] = $w['ees_id'];
                $preguntas[$cont]['nombre'] = $w['ees_nombre'];
                $cont++;
            }
        }
        return $preguntas;
    }

    /*
     * Elimina el dato consecutivo y documento soporte de un registro especifico
     */

    function deleteEncuesta($id) {
        $tabla = "encuesta";
        $campos = array('enc_documento_soporte', 'enc_fecha', 'ecc_id', 'enc_motivo_cuestionario_incorrecto',
            'erf_id', 'evi_id', 'eri_id', 'enc_motivo_encuesta_incorrecta', 'usu_id', 'ees_id');
        $valores = array('NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', 'NULL', "'2'");
        $predicado = " enc_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $predicado);
        return $r;
    }

    /*
     * Obtiene todos los datos de una encuesta especifica, recibe el id
     */

    function getEncuestaById($id) {
        $sql = "select * from encuesta where enc_id = " . $id;
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    /*
     * Actualiza el registro de una encuesta ingresando el consecutivo y archivo digital
     */

    function updateEjecucion($id, $archivo, $fecha, $cc, $mci, $rf, $vi, $ri, $mei, $usuario) {
        $tabla = "encuesta";
        $campos = array('enc_documento_soporte', 'enc_fecha', 'ecc_id', 'enc_motivo_cuestionario_incorrecto',
            'erf_id', 'evi_id', 'eri_id', 'enc_motivo_encuesta_incorrecta', 'usu_id');
        $valores = array("'" . $archivo . " '", "'" . $fecha . "'", "'" . $cc . "'", "'" . $mci . "'", "'" . $rf . "'", "'" . $vi . "'",
            "'" . $ri . "'", "'" . $mei . "'", "'" . $usuario . "'");

        $condicion = "enc_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    /*
     * Existen dos tipos de encuesta que depende del codigo eje, este obtiene el tipo 
     * de encuesta
     */

    function getTipoEncuesta($id_add) {
        $sql = "select eje.ins_id from eje left join planeacion pla on pla.eje_id = eje.eje_id
                left join encuesta enc on enc.pla_id = pla.pla_id where enc_id = " . $id_add;
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r)
            return $r['ins_id'];
        else
            return -1;
    }

//check
    /*
     * Cambiar el estado de una encuesta, este es ejecutado o no ejecutado
     */

    function setEstadoEncuesta($id_add, $estado) {
        $tabla = " encuesta ";
        $campos = array('ees_id');
        $valores = array($estado);

        $condicion = " enc_id = " . $id_add;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    /*
     * --New model------------------------------------------------------------------------------------------------------------
     */

    function getSecciones($tipo) {
        $secciones = null;
        $sql = "select ise_id, ise_nombre, ise_numero "
                . "from instrumento_seccion "
                . "where ins_id = '" . $tipo . "' "
                . "order by ise_orden";

        $r = ($this->db->ejecutarConsulta($sql));
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $secciones[$cont]['id'] = $w['ise_id'];
                $secciones[$cont]['nombre'] = $w['ise_nombre'];
                $secciones[$cont]['numero'] = $w['ise_numero'];
                $cont++;
            }
        }

        return $secciones;
    }

    function getPreguntasBaseBySeccion($seccion) {
        $preguntas = null;
        $sql = "select ipr_id, ipr_nombre, ipr_texto, ipt_id, ipr_descripcion, ipr_padre "
                . "from instrumento_pregunta "
                . "where ise_id = '" . $seccion . "' "
                . "order by ipr_orden";
        // and ipr_padre = 0

        $r = ($this->db->ejecutarConsulta($sql));
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $preguntas[$cont]['id'] = $w['ipr_id'];
                $preguntas[$cont]['nombre'] = $w['ipr_nombre'];
                $preguntas[$cont]['texto'] = $w['ipr_texto'];
                $preguntas[$cont]['descripcion'] = $w['ipr_descripcion'];
                $preguntas[$cont]['tipo'] = $w['ipt_id'];
                $preguntas[$cont]['padre'] = $w['ipr_padre'];
                $cont++;
            }
        }
        return $preguntas;
    }

    /*
     * Obtiene las posibles respuestas de un tipo de pregunta
     */

    function getOpcionesPreguntas($criterio) {
        $preguntas = null;
        $sql = "SELECT ipo_id, ipo_texto FROM instrumento_pregunta_opcion where ipr_id = " . $criterio . " order by ipo_valor";
        $r = $this->db->ejecutarConsulta($sql);
        //echo $sql;
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $preguntas[$cont]['id'] = $w['ipo_id'];
                $preguntas[$cont]['nombre'] = $w['ipo_texto'];
                $cont++;
            }
        }
        return $preguntas;
    }

    /*
     * Determina si la siguiente pregunta depende de la respuesta de esta
     */

    function tieneSalto($id) {
        $sql = "Select ipr_id_salta from instrumento_saltos where ipr_id = " . $id;
        $r = ($this->db->ejecutarConsulta($sql));
        $w = mysql_fetch_array($r);
        if ($w)
            return 1;
        else
            return 0;
    }

    /*
     * Obtiene el id de la pregunta que sigue despues de haber selecionado una respuesta
     */

    function saltarAPregunta($id, $respuesta) {
        if ($this->tieneSalto($id) == 1) {
            $sql = "Select isa.ipr_id_salta from instrumento_saltos isa
                where isa.ipr_id = " . $id . " and isa.ipo_id =" . $respuesta;
            //echo $sql;
            $r = ($this->db->ejecutarConsulta($sql));
            if ($r) {
                $w = mysql_fetch_array($r);
                if ($w) {
                    return $w['ipr_id_salta'];
                } else {
                    return 0;
                }
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    /*
     * arreglo de saltos
     */

    function arregloSaltarAPregunta($id) {
        $preguntas = null;
        if ($this->tieneSalto($id) == 1) {
            $sql = "Select isa.ipo_id , isa.ipr_id_salta from instrumento_saltos isa 
                where isa.ipr_id = " . $id;
            //echo $sql;
            $r = ($this->db->ejecutarConsulta($sql));
            while ($w = mysql_fetch_array($r)) {
                $preguntas = $preguntas . $w['ipo_id'] . '/' . $w['ipr_id_salta'] . '/';
            }
        }
        return $preguntas;
    }

    /*
     * Almacenar respuestas en la base de datos
     */

    function setSaveRespuestasEncuesta($valores) {
        $tabla = 'instrumento_respuestas';
        $campos = 'enc_id,ipr_id,ire_valor';
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }

    function setUpdateRespuestasEncuesta($encuesta_id, $pregunta_id, $respuesta) {
        $tabla = 'instrumento_respuestas';
        $campos = array('ire_valor');
        $valores = array("'" . $respuesta . "'");
        $condicion = ' enc_id= ' . $encuesta_id . ' and ipr_id= ' . $pregunta_id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    /*
     * Obtener la respuesta de la pregunta en la encuesta
     */

    function getRespuestaPreguntaDeEncuesta($pregunta_id, $encuesta_id) {
        $sql = "SELECT ire_valor FROM instrumento_respuestas where enc_id= " . $encuesta_id .
                " and ipr_id= " . $pregunta_id;

        $r = ($this->db->ejecutarConsulta($sql));
        if ($r)
            $w = mysql_fetch_array($r);
        return $w['ire_valor'];
    }

    /*
     * Obtiene la cantidad de posibles respuestas en una pregunta Multiple_opcion
     */

    function getNumeroRespuestaMultipleById($id) {
        $sql = "SELECT count(*) FROM instrumento_pregunta_opcion 
                where ipr_id = " . $id; // el 3 es de Multiple_opcion

        $r = ($this->db->ejecutarConsulta($sql));
        if ($r)
            $w = mysql_fetch_array($r);
        return $w['count(*)'];
    }

    /*
     * obtener el codigo de eje de la encuesta
     */

    function getPla_idByEncuestaId($id) {
        $sql = "SELECT pla_id FROM encuesta where enc_id = '" . $id . "'";
        //echo $sql;
        $r = ($this->db->ejecutarConsulta($sql));
        if ($r) {
            $w = mysql_fetch_array($r);
            return $w['pla_id'];
        }
    }

    /*
     * Devuelve true si el id de la encuesta contiene alguna respuesta
     */

    function tieneRespuestas($id) {
        $sql = "select * from instrumento_respuestas where enc_id=" . $id;
        $r = ($this->db->ejecutarConsulta($sql));

        if ($r) {
            $w = mysql_fetch_array($r);

            return TRUE;
        }
    }

    /*
     * Elimina los datos actuales de la base de datos de respuesta
     */

    function eliminarRespuestas($id) {

        if ($this->tieneRespuestas($id) == TRUE) {
            $predicado = ' enc_id = ' . $id;
            $r = ($this->db->eliminarMultiplesRegistros('instrumento_respuestas', $predicado));
            $this->setEstadoEncuesta($id_add, '2');
            return TRUE;
        }
    }

    /*
     * opciones de CuestionarioCompleto
     */

    function getCuestionarioCompletoOptions() {
        $opciones = null;
        $sql = "SELECT  ecc_id , ecc_nombre from encuesta_cuestionario_completo ";
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $opciones[$cont]['id'] = $w['ecc_id'];
                $opciones[$cont]['nombre'] = $w['ecc_nombre'];
                $cont++;
            }
        }
        return $opciones;
    }

    function getResultadoFinalOptions() {
        $opciones = null;
        $sql = "SELECT  erf_id , erf_nombre from encuesta_resultado_final ";
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $opciones[$cont]['id'] = $w['erf_id'];
                $opciones[$cont]['nombre'] = $w['erf_nombre'];
                $cont++;
            }
        }
        return $opciones;
    }

    function getValidacionInspeccionOptions() {
        $opciones = null;
        $sql = "SELECT  evi_id , evi_nombre from encuesta_validar_inspeccion ";
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $opciones[$cont]['id'] = $w['evi_id'];
                $opciones[$cont]['nombre'] = $w['evi_nombre'];
                $cont++;
            }
        }
        return $opciones;
    }

    function getResultadoInspeccionOptions() {
        $opciones = null;
        $sql = "SELECT  eri_id , eri_nombre from encuesta_resultado_inspeccion ";
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $opciones[$cont]['id'] = $w['eri_id'];
                $opciones[$cont]['nombre'] = $w['eri_nombre'];
                $cont++;
            }
        }
        return $opciones;
    }
    /*
     * Devuelve la cantidad de preguntas de una encuesta dependiendo del consecutivo de la encuesta
     */
    
    function cantidadPreByConsecutivoEncuesta($consecutivo) {
        $sql = "select count(*) from instrumento_pregunta ipr, (select max(ise_id)as maximo , min(ise_id)as minimo from instrumento_seccion where ins_id =(select ins_id from eje where eje_id =(select eje_id from planeacion where pla_id=(SELECT `pla_id` FROM `encuesta` "
                . " WHERE `enc_consecutivo`= ".$consecutivo." )))) val where ipr.ise_id <= val.maximo && ipr.ise_id >= val.minimo";
        //echo $sql;
        $r = ($this->db->ejecutarConsulta($sql));
        if ($r) {
            $w = mysql_fetch_array($r);
            return $w['count(*)'];
        }
    }
    function tipoEncuestaByConsecutivoEncuesta($consecutivo) {
        $sql = "select ins_id from eje where eje_id =(select eje_id from planeacion where pla_id=(SELECT `pla_id` FROM `encuesta` WHERE `enc_consecutivo`= ".$consecutivo." ))";
        //echo $sql;
        $r = ($this->db->ejecutarConsulta($sql));
        if ($r) {
            $w = mysql_fetch_array($r);
            return $w['ins_id'];
        }
    }
    /*
     * Obtiene todos los datos de una encuesta especifica, recibe el id
     */

    function getEncuestaIdByConsecutivo($id) {
        $sql = "select enc_id from encuesta where enc_consecutivo = " . $id;
        $r = ($this->db->ejecutarConsulta($sql));
        if ($r) {
            $w = mysql_fetch_array($r);
            return $w['enc_id'];
        }
    }
}
