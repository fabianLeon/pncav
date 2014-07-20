<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CPlaneacionData
 *
 * @author Brian Kings
 */
class CPlaneacionData {

    var $db = null;

    function CPlaneacionData($db) {
        $this->db = $db;
    }

    function getRegiones($orden) {
        $sql = "select * from departamento_region order by " . $orden;
        $r = $this->db->ejecutarConsulta($sql);
        $regiones = null;

        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $regiones[$cont]['id'] = $w['der_id'];
                $regiones[$cont]['nombre'] = $w['der_nombre'];
                $cont++;
            }
        }
        return $regiones;
    }

    function getDepartamento($criterio, $orden) {
        $regiones = null;
        $sql = "SELECT * FROM departamento where der_id = " . $criterio . "  order by " . $orden;
        $r = $this->db->ejecutarConsulta($sql);
        //echo $sql;
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $regiones[$cont]['id'] = $w['dep_id'];
                $regiones[$cont]['nombre'] = $w['dep_nombre'];
                $cont++;
            }
        }
        return $regiones;
    }

    function getMunicipio($criterio, $orden) {
        $regiones = null;
        $sql = "SELECT * FROM municipio where dep_id = " . $criterio . "  order by " . $orden;
        $r = $this->db->ejecutarConsulta($sql);

        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $regiones[$cont]['id'] = $w['mun_id'];
                $regiones[$cont]['nombre'] = $w['mun_nombre'];
                $cont++;
            }
        }
        return $regiones;
    }

    function getEjes($orden) {
        $ejes = null;
        $sql = " select * from eje order by " . $orden;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $ejes[$cont]['id'] = $w['eje_id'];
                $ejes[$cont]['nombre'] = $w['eje_nombre'];
                $cont++;
            }
        }
        return $ejes;
    }

    function getPlaneacion($criterio, $orden) {
        $planeacion = null;
        $sql = "SELECT p.pla_id, der.der_nombre,d.dep_nombre,m.mun_nombre,e.eje_nombre, "
                . "p.pla_numero_encuestas, t.ins_nombre, p.pla_fecha_inicio, p.pla_fecha_fin, u.usu_nombre "
                . "FROM planeacion p left join eje e on e.eje_id = p.eje_id "
                . "left join municipio m on m.mun_id = p.mun_id "
                . "left join departamento d on d.dep_id = m.dep_id "
                . "left join departamento_region der on der.der_id=d.der_id "
                . "left join instrumento t on t.ins_id = e.ins_id "
                . "left join usuario u on u.usu_id =p.usu_id where " . $criterio . " order by " . $orden;


        $r = $this->db->ejecutarConsulta($sql);
        //echo $sql;
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $planeacion[$cont]['id_element'] = $w['pla_id'];
                $planeacion[$cont]['der_nombre'] = $w['der_nombre'];
                $planeacion[$cont]['dep_nombre'] = $w['dep_nombre'];
                $planeacion[$cont]['mun_nombre'] = $w['mun_nombre'];
                $planeacion[$cont]['eje_nombre'] = $w['eje_nombre'];
                $planeacion[$cont]['numero_encuestas'] = $w['pla_numero_encuestas'];
                $planeacion[$cont]['ins_nombre'] = $w['ins_nombre'];
                $planeacion[$cont]['pla_fecha_inicio'] = $w['pla_fecha_inicio'];
                $planeacion[$cont]['pla_fecha_fin'] = $w['pla_fecha_fin'];
                $planeacion[$cont]['usu_nombre'] = $w['usu_nombre'];
                $cont++;
            }
        }
        return $planeacion;
    }

    function getPlaneacionVerEjecucion($criterio, $excel) {
        $planeacion = null;
        $sql = "SELECT p.pla_id, der.der_nombre,d.dep_nombre,m.mun_nombre,e.eje_nombre, "
                . "p.pla_numero_encuestas, t.ins_nombre, p.pla_fecha_inicio, p.pla_fecha_fin, u.usu_nombre, ees.ees_nombre "
                . "FROM planeacion p left join eje e on e.eje_id = p.eje_id "
                . "left join municipio m on m.mun_id = p.mun_id "
                . "left join departamento d on d.dep_id = m.dep_id "
                . "left join departamento_region der on der.der_id=d.der_id "
                . "left join instrumento t on t.ins_id = e.ins_id "
                . "left join encuesta_estado ees on  ees.ees_id = p.ees_id "
                . "left join usuario u on u.usu_id = p.usu_id  where " . $criterio . " order by pla_id";
        //echo $sql;

        $r = $this->db->ejecutarConsulta($sql);
        //echo $sql;
        $estadoActualizado = null;
        $estado = null;
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $sql2 = "SELECT count(*) FROM encuesta WHERE pla_id = '" . $w['pla_id'] . "' and ees_id = 1 group by ees_id";
                $r2 = $this->db->ejecutarConsulta($sql2);
                $w2 = mysql_fetch_array($r2);
                $planeacion[$cont]['id_element'] = $w['pla_id'];
                $planeacion[$cont]['der_nombre'] = $w['der_nombre'];
                $planeacion[$cont]['dep_nombre'] = $w['dep_nombre'];
                $planeacion[$cont]['mun_nombre'] = $w['mun_nombre'];
                $planeacion[$cont]['eje_nombre'] = $w['eje_nombre'];
                $planeacion[$cont]['numero_encuestas'] = $w['pla_numero_encuestas'];
                $planeacion[$cont]['ins_nombre'] = $w['ins_nombre'];
                $planeacion[$cont]['pla_fecha_inicio'] = $w['pla_fecha_inicio'];
                $planeacion[$cont]['pla_fecha_fin'] = $w['pla_fecha_fin'];
                $planeacion[$cont]['usu_nombre'] = $w['usu_nombre'];
                $planeacion[$cont]['ees_nombre'] = $w['ees_nombre'];
                $total = round(($w2['count(*)'] * 100) / $w['pla_numero_encuestas'], 0);
                //calcular estado
                $dias = $this->dias_transcurridos_entre_fechas(date('Y-m-d'), $w['pla_fecha_fin']);
                if ($dias >= 0) {
                    $estado = '2';
                } else if ($dias < 0) {
                    $estado = '3';
                }
                if ($excel == false) {
                    if ($total <= 51) {
                        $total = '<img src=./templates/img/ico/rojo.gif>' . $total . '%';
                    } elseif ($total > 51 && $total <= 99) {
                        $total = '<img src=./templates/img/ico/amarillo.gif>' . $total . '%';
                    } else {
                        $total = '<img src=./templates/img/ico/verde.gif>' . $total . '%';
                        $estado = '1';
                    }
                } else {
                    if ($total <= 51) {
                        $total = $total . '%';
                    } elseif ($total > 51 && $total <= 99) {
                        $total = $total . '%';
                    } else {
                        $total = $total . '%';
                        $estado = '1';
                    }
                }
                $planeacion[$cont]['porcentaje_ejecucion'] = $total;
                $cont++;
                //mantener actualizado el estado
                $this->db->actualizarRegistro('planeacion', array('ees_id'), $estado, (" pla_id = " . $w['pla_id']));
            }
        }
        return $planeacion;
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

    function getResumen($criterio) {
        $contadorEje = 1;
        $arreglo = null;
        $resumen = null;
        $total = null;
        while ($contadorEje <= 5) {  // indica los 5 ejes existentes
            $sql = "SELECT p.eje_id,e.eje_nombre, count(*), SUM(pla_numero_encuestas) FROM planeacion p 
                    inner join eje e on e.eje_id = p.eje_id 
                    left join municipio m on m.mun_id = p.mun_id 
                    left join departamento d on d.dep_id = m.dep_id 
                    left join departamento_region der on der.der_id=d.der_id 
                    left join instrumento t on t.ins_id = e.ins_id 
                    left join usuario u on u.usu_id =p.usu_id
                    where p.eje_id =" . $contadorEje . " and " . $criterio
                    . " group by eje_id";
            //echo $sql;
            $r = $this->db->ejecutarConsulta($sql);
            $w = mysql_fetch_array($r);
            if ($w['count(*)'] == '') {
                $resumen[$contadorEje - 1] = 0;
            } else {
                $resumen[$contadorEje - 1] = $w['SUM(pla_numero_encuestas)'];
            }
            $total+=$w['SUM(pla_numero_encuestas)'];
            $contadorEje++;
        }
        $resumen[$contadorEje - 1] = $total;
        return $resumen;
    }

    function insertPlaneacion($municipio, $eje, $numero_encuestas, $fecha_inicio, $fecha_fin, $usuario) {
        $tabla = 'planeacion';
        $campos = 'pla_id,  mun_id,eje_id,pla_numero_encuestas, '
                . 'pla_fecha_inicio,pla_fecha_fin, usu_id';
        $valores = "'','" . $municipio . "','" . $eje . "','"
                . $numero_encuestas . "','" . $fecha_inicio . "','" . $fecha_fin . "','" . $usuario . "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }

    function updatePlaneacion($municipio, $eje, $numero_encuestas, $id, $fecha_inicio, $fecha_fin, $usuario) {
        $tabla = 'planeacion';

        $campos = array(' mun_id', 'eje_id', 'pla_numero_encuestas', 'pla_fecha_inicio', 'pla_fecha_fin', 'usu_id');
        $valores = array("'" . $municipio . "'", "'" . $eje . "'", "'"
            . $numero_encuestas . "'", "'" . $fecha_inicio . "'", "'" . $fecha_fin . "'", "'" . $usuario . "'");
        $condicion = " pla_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    function deletePlaneacion($id) {
        $tabla = "planeacion";
        $predicado = "pla_id = " . $id;
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }

    function getPlaneacionById($id) {
        $plan = null;
        $sql = "SELECT p.pla_id,  d.der_id,d.dep_id,m.mun_id,e.eje_id, p.pla_numero_encuestas,p.pla_fecha_inicio,p.pla_fecha_fin,p.usu_id "
                . "FROM planeacion p left join eje e on e.eje_id = p.eje_id "
                . "left join municipio m on m.mun_id = p.mun_id "
                . "left join departamento d on d.dep_id = m.dep_id where p.pla_id = " . $id;
        //echo $sql;
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));

        if ($r)
            return $r;
        else
            return -1;
    }

    /*
      //Get codigos Eje Paral el modulo Ejecucion
      function getCodigosEje() {
      $codigos_eje = null;
      $sql = "SELECT pla_id FROM planeacion ";
      $r = $this->db->ejecutarConsulta($sql);
      if ($r) {
      $cont = 0;
      while ($w = mysql_fetch_array($r)) {
      $codigos_eje[$cont]['id'] = $w['pla_id'];
      $codigos_eje[$cont]['nombre'] = $w['pla_codigo_eje'];
      $cont++;
      }
      }
      return $codigos_eje;
      }
      //Get codigos Eje Paral el modulo Ejecucion
      function getCodigosEjeById($id) {
      $codigos_eje = null;
      $sql = "SELECT pla_id FROM planeacion where pla_id= " . $id;
      $r = $this->db->ejecutarConsulta($sql);
      if ($r) {
      $w = mysql_fetch_array($r);
      $codigos_eje['id'] = $w['pla_id'];
      $codigos_eje['nombre'] = $w['pla_id'];
      }
      return $codigos_eje['nombre'];
      } */

    function getUsuarios($orden) {
        $usuarios = null;
        $sql = "SELECT  usu_id , usu_nombre from usuario order by " . $orden;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $usuarios[$cont]['id'] = $w['usu_id'];
                $usuarios[$cont]['nombre'] = $w['usu_nombre'];
                $cont++;
            }
        }
        return $usuarios;
    }

    function getMunicipioId($municipio) {
        $sql = "SELECT  mun_id from municipio where mun_nombre = '" . strtoupper($municipio) . "'";
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            return $w['mun_id'];
        }
    }

    function getEjeId($eje) {
        $sql = "SELECT  eje_id from eje where eje_nombre = '" . strtoupper($eje) . "'";
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            return $w['eje_id'];
        }
    }

    function getUsuarioId($documento) {
        $sql = "SELECT  usu_id from usuario where usu_documento = '" . $documento . "'";
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            return $w['usu_id'];
        }
    }

    function createEncuestas($valores) {
        $tabla = 'encuesta';
        $campos = ' enc_consecutivo, pla_id, ees_id ';
        $this->db->insertarRegistro($tabla, $campos, $valores);
    }

    function deleteEncuestas($id) {
        $tabla = "encuesta";
        $predicado = "pla_id= '" . $id . "'";
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }

    /*
     * Obtener el ultimo consecutivo para determinado municipio
     */

    function ultimoConsecutivoEncuesta($id_municipio) {
        $sql = "SELECT  max(enc_consecutivo)as mayor from encuesta where enc_consecutivo LIKE '" . $id_municipio . "%'";
        $r = $this->db->ejecutarConsulta($sql);
        if ($r==NULL) {
            $w = mysql_fetch_array($r);
            
            return $w['mayor'];
        } else {
            return ($id_municipio * 1000);
        }
    }

    /*
     * Obtiene el id del ultimo registro ingresado
     */

    function getUltimoIdPlaneacion() {
        $sql = "SELECT  MAX(pla_id) as mayor from planeacion";
        $r = $this->db->ejecutarConsulta($sql);
        //echo $sql;
        if ($r) {
            $w = mysql_fetch_array($r);
            return $w['mayor'];
        }
    }

}
