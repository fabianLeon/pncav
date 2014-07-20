<?php

/**
 * 
 *
 * <ul>
 * <li> Redcom Ltda <www.redcom.com.co></li>
 * <li> Proyecto PNCAV</li>
 * </ul>
 */

/**
 * Clase DocumentoData
 * Usada para la definicion de todas las funciones propias del objeto DOCUMENTO
 *
 * @package  clases
 * @subpackage datos
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
Class CDocumentoData {

    var $db = null;

    function CDocumentoData($db) {
        $this->db = $db;
    }

    function getTipos($criterio, $orden) {
        $tipos = null;
        $sql = "select * from documento_tipo where " . $criterio . " order by " . $orden;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $tipos[$cont]['id'] = $w['dti_id'];
                $tipos[$cont]['nombre'] = $w['dti_nombre'];
                $cont++;
            }
        }
        return $tipos;
    }

    function getTipoNombreById($id) {
        $tabla = 'documento_tipo';
        $campo = 'dti_nombre';
        $predicado = 'dti_id = ' . $id;
        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);

        if ($r)
            return $r;
        else
            return -1;
    }

    function getControlaResponsableById($id) {
        $tabla = 'documento_tipo';
        $campo = 'dti_responsable';
        $predicado = 'dti_id = ' . $id;
        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);

        if ($r)
            return $r;
        else
            return -1;
    }

    function getTemas($criterio, $orden) {
        $temas = null;
        $sql = "select * from documento_tema where dot_id <> 4 and " . $criterio . " order by " . $orden;
        //echo ($sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $temas[$cont]['id'] = $w['dot_id'];
                $temas[$cont]['nombre'] = $w['dot_nombre'];
                $cont++;
            }
        }
        return $temas;
    }

    function getTemaNombreById($id) {
        $tabla = 'documento_tema';
        $campo = 'dot_nombre';
        $predicado = 'dot_id = ' . $id;
        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);

        if ($r)
            return $r;
        else
            return -1;
    }

    function getSubtemas($criterio, $orden) {
        $subtemas = null;
        $sql = "select * from documento_subtema where " . $criterio . " order by " . $orden;
        //echo("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $subtemas[$cont]['id'] = $w['dos_id'];
                $subtemas[$cont]['nombre'] = $w['dos_nombre'];
                $cont++;
            }
        }
        return $subtemas;
    }

    function getSubtemaNombreById($id) {
        $tabla = 'documento_subtema';
        $campo = 'dos_nombre';
        $predicado = 'dos_id = ' . $id;
        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);

        if ($r)
            return $r;
        else
            return -1;
    }

    function getEstados($criterio, $orden) {
        $controla_estados = null;
        $sql = "select * from documento_estado where doe_id > 0 and " . $criterio . " order by " . $orden;
        //echo("sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $controla_estados[$cont]['id'] = $w['doe_id'];
                $controla_estados[$cont]['nombre'] = $w['doe_nombre'];
                $cont++;
            }
        }
        return $controla_estados;
    }

    function getDirectorioOperador($id) {
        $tabla = 'operador';
        $campo = 'ope_sigla';
        $predicado = 'ope_id = ' . $id;
        if (!isset($id))
            $predicado = 'ope_id=1';
        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);
        $r = $r . "/";
        if ($r)
            return $r;
        else
            return -1;
    }

    function getNombreOperador($id) {
        $tabla = 'operador';
        $campo = 'ope_nombre';
        $predicado = 'ope_id = ' . $id;
        if (!isset($id))
            $predicado = 'ope_id=1';
        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);

        if ($r)
            return $r;
        else
            return -1;
    }

    function getDocumentos($criterio, $orden, $dirOperador) {
        $documentos = null;
        $sql = "select d.doc_id, d.dti_id, 
					   d.dot_id, d.dos_id, d.doc_fecha, 
					   d.doc_descripcion, d.doc_archivo,
					   d.doc_version,td.dti_nombre, 
					   tm.dot_nombre, sd.dos_nombre, ted.doe_nombre
				from documento d
				inner join documento_tipo td on d.dti_id = td.dti_id
				inner join documento_tema tm on d.dot_id = tm.dot_id
				inner join documento_subtema sd on d.dos_id = sd.dos_id
				inner join documento_estado ted on ted.doe_id = d.doe_id
				where " . $criterio . " 
				order by " . $orden;
        //echo ($sql."<br>");
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $documentos[$cont]['id'] = $w['doc_id'];
                $documentos[$cont]['tipo'] = $w['dti_nombre'];
                $documentos[$cont]['tema'] = $w['dot_nombre'];
                $documentos[$cont]['subtema'] = $w['dos_nombre'];
                $documentos[$cont]['descripcion'] = $w['doc_descripcion'];
                $documentos[$cont]['nombre'] = "<a href='././soportes/" . $dirOperador . $w['dti_nombre'] . "/" . $w['dot_nombre'] . "/" . $w['doc_archivo'] . "' target='_blank'>{$w['doc_archivo']}</a>";
                $documentos[$cont]['fecha'] = $w['doc_fecha'];
                $documentos[$cont]['version'] = $w['doc_version'];
                $documentos[$cont]['estado'] = $w['doe_nombre'];
                $cont++;
            }
        }
        return $documentos;
    }

    function getDocumentoById($id) {
        $sql = "select d.doc_id, d.dti_id, 
					d.dot_id, d.dos_id, 
		  			d.doc_fecha, 
					d.doc_descripcion, 
	 				d.doc_archivo, 
	  				td.dti_nombre, tm.dot_nombre, 
	 				d.doc_version, d.doe_id,ted.doe_nombre
				from documento d
				inner join documento_tipo td on d.dti_id = td.dti_id
				inner join documento_tema tm on d.dot_id = tm.dot_id
				inner join documento_subtema sd on d.dos_id = sd.dos_id
				inner join documento_estado ted on d.doe_id = ted.doe_id
				where d.doc_id = " . $id;
        //echo ("<br>".$sql);
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    function insertDocumento($tipo, $tema, $subtema, $fecha, $descripcion, $archivo, $version, $estado, $operador) {
        //if ($estado=='') $estado=11;
        $tabla = "documento";
        $campos = "dti_id,dot_id,dos_id,doc_fecha,
				   doc_descripcion,doc_archivo,doc_version,doe_id,ope_id";
        $valores = "'" . $tipo . "','" . $tema . "','" . $subtema . "',
					'" . $fecha . "','" . $descripcion . "','" . $archivo . "','" . $version . "','" . $estado . "','" . $operador . "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }

    function updateDocumento($id, $tipo, $tema, $subtema, $fecha, $descripcion, $version, $estado) {
        //if ($estado=='') $estado=1;
        $tabla = "documento";
        $campos = array('dti_id', 'dot_id', 'dos_id', 'doc_fecha', 'doc_descripcion', 'doc_version', 'doe_id');
        $valores = array($tipo, $tema, $subtema, "'" . $fecha . "'", "'" . $descripcion . "'", "'" . $version . "'", "'" . $estado . "'");

        $condicion = "doc_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    function updateDocumentoArchivo($id, $tipo, $tema, $subtema, $fecha, $descripcion, $version, $archivo, $estado) {

        if ($estado == '')
            $estado = 6;
        $tabla = "documento";
        $campos = array('dti_id', 'dot_id', 'dos_id', 'doc_fecha', 'doc_descripcion', 'doc_version', 'doc_archivo', 'doe_id');
        $valores = array($tipo, $tema, $subtema, "'" . $fecha . "'", "'" . $descripcion . "'", "'" . $version . "'", "'" . $archivo . "'", "'" . $estado . "'");

        $condicion = "doc_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    function deleteDocumento($id) {
        $tabla = "documento";
        $predicado = "doc_id = " . $id;
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }

    function getDocumentosResumen($criterio, $orden) {
        $documentos = null;
        $sql = "select d.doc_id, d.dti_id, 
					   d.dot_id, d.dos_id, d.doe_id, d.doc_archivo,
					   d.doc_version,td.dti_nombre, 
					   tm.dot_nombre,de.doe_nombre
				from documento d
				inner join documento_tipo td on d.dti_id = td.dti_id
				inner join documento_tema tm on d.dot_id = tm.dot_id
				inner join documento_estado de on de.doe_id = d.doe_id
				where dti_estado='S' and " . $criterio . " 
				order by " . $orden;
        //echo ("<br>getDocumentosResumen:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $documentos[$cont]['id'] = $w['doc_id'];
                $documentos[$cont]['tipo'] = $w['dti_nombre'];
                $documentos[$cont]['tema'] = $w['dot_nombre'];
                $documentos[$cont]['estado'] = $w['doe_nombre'];
                $cont++;
            }
        }
        return $documentos;
    }

    function getResumen($tipo, $tema) {

        $sql = "select *
				from documento_resumen
				where dor_tipo= '" . $tipo . "' and dor_tema= '" . $tema . "'";
        //echo ("<br>getResumen:".$sql);
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    function deleteResumen() {
        $tabla = "documento_resumen";
        $predicado = " 1";
        $n = $this->db->borrarRegistro($tabla, $predicado);
        return $n;
    }

    function insertResumen($tipo, $tema, $generada, $enRevisionI, $enRevisionG, $enRevisionC, $aprobada, $firmasI, $firmasG, $firmasC, $firmada, $noaplica) {
        $tabla = "documento_resumen";
        $campos = "dor_tipo,dor_tema,ces_1,ces_2,ces_3,ces_4,ces_5,ces_6,ces_7,ces_8,ces_9,ces_10";
        $valores = "'" . $tipo . "','" . $tema . "','" . $generada . "','" . $enRevisionI . "','" . $enRevisionG . "','" . $enRevisionC . "','" . $aprobada . "','" . $firmasI . "','" . $firmasG . "','" . $firmasC . "','" . $firmada . "','" . $noaplica . "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }

    function updateResumen($tipo, $tema, $generada, $enRevisionI, $enRevisionG, $enRevisionC, $aprobada, $firmasI, $firmasG, $firmasC, $firmada, $noaplica) {
        $tabla = "documento_resumen";
        $campos = array('ces_1', 'ces_2', 'ces_3', 'ces_4', 'ces_5', 'ces_6', 'ces_7', 'ces_8', 'ces_9', 'ces_10');
        $valores = array($generada, $enRevisionI, $enRevisionG, $enRevisionC, $aprobada, $firmasI, $firmasG, $firmasC, $firmada, $noaplica);

        $condicion = "dor_tipo = '" . $tipo . "' and dor_tema = '" . $tema . "'";
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    function getResumenes() {
        $resumenes = null;
        $sql = "select dor_tipo,dor_tema,ces_1, ces_2, ces_3,ces_4, ces_5, ces_6, ces_7,ces_8,ces_9,ces_10
				from documento_resumen
				where 1 
				order by dor_tipo";

        //echo ("<br>getResumenes:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $resumenes[$cont]['id'] = $cont;
                $resumenes[$cont]['dor_tipo'] = $w['dor_tipo'];
                $resumenes[$cont]['dor_tema'] = $w['dor_tema'];
                $resumenes[$cont]['ces_1'] = $w['ces_1'];
                $resumenes[$cont]['ces_2'] = $w['ces_2'];
                $resumenes[$cont]['ces_3'] = $w['ces_3'];
                $resumenes[$cont]['ces_4'] = $w['ces_4'];
                $resumenes[$cont]['ces_5'] = $w['ces_5'];
                $resumenes[$cont]['ces_6'] = $w['ces_6'];
                $resumenes[$cont]['ces_7'] = $w['ces_7'];
                $resumenes[$cont]['ces_8'] = $w['ces_8'];
                $resumenes[$cont]['ces_9'] = $w['ces_9'];
                $resumenes[$cont]['ces_10'] = $w['ces_10'];
                $cont++;
            }
        }
        return $resumenes;
    }

    function getDestinatarios($criterio, $orden) {
        $destinatarios = null;
        $sql = "select * from documento_actor where " . $criterio . " order by " . $orden;
        //echo ($sql."<br>");
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $destinatarios[$cont]['id'] = $w['doa_id'];
                $destinatarios[$cont]['nombre'] = $w['doa_nombre'];
                $cont++;
            }
        }
        return $destinatarios;
    }

    function getUsersEquipo($criterio, $orden) {
        $users = null;
        $sql = "select * from usuario where " . $criterio . " 
		order by " . $orden;
        //echo ($sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $users[$cont]['id'] = $w['usu_id'];
                $users[$cont]['login'] = $w['usu_login'];
                $users[$cont]['nombre'] = $w['usu_nombre'];
                $users[$cont]['apellido'] = $w['usu_apellido'];
                $users[$cont]['documento'] = $w['usu_documento'];
                $users[$cont]['telefono'] = $w['usu_telefono'];
                $users[$cont]['celular'] = $w['usu_celular'];
                $users[$cont]['correo'] = $w['usu_correo'];
                $cont++;
            }
        }
        return $users;
    }

    function getCountByName($name) {
        $sql = "select max(doc_version) from documento where doc_archivo like '" . $name . "%'";
        $tabla = 'documento';
        $campo = 'max(doc_version)';
        $predicado = "doc_archivo like '" . $name . "%'";

        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);

        if ($r) {
            return $r;
        } else {
            return 0;
        }
    }

}
