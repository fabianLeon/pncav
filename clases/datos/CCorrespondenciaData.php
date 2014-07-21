<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CCorrespondenciaData
 *
 * @author Brian Kings
 */
class CCorrespondenciaData {

    var $db = null;

    /*
     * Constructor de la clase
     */

    function CCorrespondenciaData($db) {
        $this->db = $db;
    }

    /*
     * Accede a la tabla documento_actor y muestra los actores.
     */

    function getActores($criterio, $orden) {
        $actores = null;
        $sql = "select * from documento_actor where " . $criterio . " order by " . $orden;
        //echo ($sql."<br>");
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $actores[$cont]['id'] = $w['doa_id'];
                $actores[$cont]['nombre'] = $w['doa_nombre'];
                $actores[$cont]['sigla'] = $w['doa_sigla'];
                $cont++;
            }
        }
        return $actores;
    }
    
    
    function getResponsables($criterio, $orden) {
        $responsables = null;
        $sql = "select * from usuario where " . $criterio . " order by " . $orden."";
        //echo ($sql."<br>");
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $responsables[$cont]['id'] = $w['usu_id'];
                $responsables[$cont]['nombre'] = $w['usu_nombre'];
                $responsables[$cont]['apellido'] = $w['usu_apellido'];
                $cont++;
            }
        }
        return $responsables;
    }
        
    function getSiglaActoresById($id) {
        //echo $id;
        $tabla="documento_actor";
        $campo="doa_sigla";
        $predicado= " doa_id =" .$id;
        $r = $this->db->recuperarCampo($tabla,$campo,$predicado);
        //echo $r;
        if ($r) {
            return $r;
        } else {
            return -1;
        }
    }
    
    function getCorrespondencia($criterio, $orden) {

        $documentos = null;
        $sql = "select dt.dti_nombre, dot.dot_nombre, d.doc_id, d.dos_id,sd.dos_nombre,
                ac.doa_nombre, ac.doa_sigla, u.usu_nombre, doa_id_dest, des.doa_sigla as des_nomb,
                u.usu_apellido, d.doc_descripcion, d.doc_referencia,
                d.doc_archivo, d.doc_anexo, d.doc_fecha_radicado, d.doc_fecha_respuesta,
                d.doc_referencia_respondido, doc_codigo_ref, doe.doe_nombre, doe.doe_id, dot.dot_nombre
          from documento_comunicado d
          left join documento_actor ac on d.doa_id_autor = ac.doa_id
          left join documento_actor des on d.doa_id_dest = des.doa_id
          left join documento_subtema sd on d.dos_id = sd.dos_id
          left join usuario u on d.usu_id = u.usu_id
          left join documento_estado doe on doe.doe_id=d.doe_id
          left join documento_tipo dt on dt.dti_id = d.dti_id 
          left join documento_tema dot on dot.dot_id = d.dot_id
          where " . $criterio . "
          order by " . $orden;
          //echo("<br>sql:".$sql);
        
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $documentos[$cont]['id'] = $w['doc_id'];
                $documentos[$cont]['area'] = $w['dot_nombre'];
                $documentos[$cont]['subtema'] = $w['dos_nombre'];
                $documentos[$cont]['autor'] = $w['doa_nombre'];
                $documentos[$cont]['destinatario'] = $w['des_nomb'];
                $documentos[$cont]['responsableR'] = $w['usu_nombre']." ".$w['usu_apellido'];
                $documentos[$cont]['descripcion'] = $w['doc_descripcion'];
                $documentos[$cont]['consecutivo_respuesta'] = $w['doc_referencia'];
                $documentos[$cont]['soporte'] = "<a href='././soportes/OPR/" . $w['dti_nombre'] . "/" . $w['doc_archivo'] . "' target='_blank'>{$w['doc_archivo']}</a>";//. $w['dot_nombre'] . "/" 
                $documentos[$cont]['nombre_soporte'] = $w['doc_archivo'];//. $w['dot_nombre'] . "/" 
                $documentos[$cont]['anexo'] = "<a href='././soportes/OPR/" . $w['dti_nombre'] . "/" . $w['doc_anexo'] . "' target='_blank'>{$w['doc_anexo']}</a>";
                $documentos[$cont]['fecha'] = $w['doc_fecha_radicado'];
                $documentos[$cont]['fechamax'] = $w['doc_fecha_respuesta'];
                $documentos[$cont]['codigor'] = $w['doc_codigo_ref'];
                $documentos[$cont]['referencia'] = "<a href='././soportes/OPR/". $w['dti_nombre'] . "/" . $w['doc_referencia_respondido'] . "' target='_blank'>{$w['doc_referencia_respondido']}</a>";
                $documentos[$cont]['estado'] = $w['doe_id'];
                $documentos[$cont]['estado_nombre'] = $w['doe_nombre'];
                
                $cont++;
            }
        }
        return $documentos;
    }

    function getCorrespondenciaAlarmas($criterio, $orden) {

        $documentos = null;
        $sql = "select dt.dti_nombre, dot.dot_nombre, d.doc_id, d.dos_id, sd.dos_nombre,
                        ac.doa_nombre, ac.doa_sigla, u.usu_nombre, doa_id_dest, des.doa_sigla as des_nomb,
                        u.usu_apellido, d.doc_descripcion, d.doc_archivo, d.doc_anexo,
                        d.doc_fecha_radicado, d.doc_fecha_respuesta, d.doc_referencia_respondido,
                        doe.doe_id, doe.doe_nombre, doc_codigo_ref
                from documento_comunicado d
                    left join documento_actor ac on d.doa_id_autor = ac.doa_id
                    left join documento_actor des on d.doa_id_dest = des.doa_id
                    left join documento_subtema sd on d.dos_id = sd.dos_id
                    left join documento_estado doe on doe.doe_id = d.doe_id
                    left join usuario u on d.usu_id = u.usu_id
                    left join documento_tipo dt on dt.dti_id = d.dti_id 
                    left join documento_tema dot on dot.dot_id = d.dot_id
                where " . $criterio . "  
                order by " . $orden;
                //echo("<br>sql:".$sql);
        
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $documentos[$cont]['id'] = $w['doc_id'];
                $documentos[$cont]['subtema'] = $w['dos_nombre'];
                $documentos[$cont]['autor'] = $w['doa_nombre'];
                $documentos[$cont]['destinatario'] = $w['des_nomb'];
                $documentos[$cont]['responsableR'] = $w['usu_nombre']." ".$w['usu_apellido'];
                $documentos[$cont]['descripcion'] = $w['doc_descripcion'];
                $documentos[$cont]['soporte'] = "<a href='././soportes/OPR/" . $w['dti_nombre'] . "/" . $w['doc_archivo'] . "' target='_blank'>{$w['doc_archivo']}</a>";// . $w['dot_nombre'] . "/"
                $documentos[$cont]['anexo'] = "<a href='././soportes/OPR/" . $w['dti_nombre'] . "/" . $w['doc_anexo'] . "' target='_blank'>{$w['doc_anexo']}</a>";
                $documentos[$cont]['fecha'] = $w['doc_fecha_radicado'];
                $documentos[$cont]['fechamax'] = $w['doc_fecha_respuesta'];
                $documentos[$cont]['codigor'] = $w['doc_codigo_ref'];
                $documentos[$cont]['referencia'] = "<a href='././soportes/OPR/". $w['dti_nombre'] . "/" . $w['doc_referencia_respondido'] . "' target='_blank'>{$w['doc_referencia_respondido']}</a>";
                $documentos[$cont]['estado'] = $w['doe_id'];
                $documentos[$cont]['estado'] = $w['doe_nombre'];
                $cont++;
            }
        }
        return $documentos;
    }
        
    function getCorresById($id) {
        $sql = "SELECT doc_id, dti_id, dot_id, dos_id, doa_id_autor, "
                . "doa_id_dest, doc_fecha_radicado, doc_referencia, "
                . "doc_descripcion, doc_archivo, usu_id, doc_fecha_respuesta, "
                . "doc_anexo, doc_codigo_ref, doc_fecha_respondido, "
                . "doc_referencia_respondido, doe_id, ope_id, doc_fecha_respondido "
                . "FROM documento_comunicado "
                . "WHERE doc_id = " . $id;
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r) {
            return $r;
            
        } else {
            return -1;
        }
    }
    
    function deleteDocumento($id) {
        $tabla = "documento_comunicado";
        $predicado = "doc_id = " . $id;
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }
    
    function insertCorrespondencia($tipo, $tema, $subtema, 
                                $autor , $destinatario, $fechaRadicado,
                                $referencia, $descripcion, $documentoSoporte,
                                $responsableRespuesta, $fechaMaxRepuesta, $anexos,
                                $referenciaRespuesta,$fechaRespuesta, $referenciaRespondido, 
                                $estado, $operador) {
        
        $tabla = "documento_comunicado";
        $campos = "dti_id, dot_id, dos_id, "
                . "doa_id_autor, doa_id_dest, doc_fecha_radicado, "
                . "doc_referencia, doc_descripcion, doc_archivo, "
                . "usu_id, doc_fecha_respuesta, doc_anexo, "
                . "doc_codigo_ref, doc_fecha_respondido, doc_referencia_respondido,"
                . "doe_id, ope_id ";
//        if($fechaMaxRepuesta == "") $fechaMaxRepuesta = "0000-00-00";
//        if($fechaRespuesta == "") $fechaRespuesta = "0000-00-00";
//        if($fechaRadicado == "") $fechaRadicado = "0000-00-00";
        $valores = "'" . $tipo . "','" . $tema . "','" . $subtema . "','" 
                        . $autor . "','" . $destinatario . "','" . $fechaRadicado . "','" 
                        . $referencia . "','" . $descripcion . "','" . $documentoSoporte . "','" 
                        . $responsableRespuesta . "','" . $fechaMaxRepuesta . "','" . $anexos . "','" 
                        . $referenciaRespuesta. "','" . $fechaRespuesta . "','" . $referenciaRespondido . "','"
                        . $estado. "','" .$operador ."'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }
    
    function updateCorrespondencia($id,$tipo, $tema, $subtema, 
                                $autor , $destinatario, $fechaRadicado,
                                $referencia, $descripcion, $documentoSoporte,
                                $responsableRespuesta, $fechaMaxRepuesta, $anexos,
                                $referenciaRespuesta,$fechaRespuesta, $referenciaRespondido, 
                                $estado, $operador, $tieneAnexo) {
//        if(isset($fechaMaxRepuesta) && $fechaMaxRepuesta=="0000-00-00"){
//            //$responsableRespuesta="";
//        }
//        if($responsableRespuesta==""){
//            $fechaMaxRepuesta="0000-00-00";
//        }
        $tabla = "documento_comunicado";
//        $campos = array("dti_id", "dot_id", " dos_id", 
//                "doa_id_autor", "doa_id_dest", "doc_fecha_radicado", 
//                "doc_referencia", "doc_descripcion", 
//                "usu_id", "doc_fecha_respuesta", 
//                "doc_codigo_ref", "doc_fecha_respondido", 
//                "doe_id", "ope_id ");
//        $valores = array("'" . $tipo . "'", "'" . $tema . "'", "'" . $subtema . "'", "'" 
//                        . $autor . "'", "'" . $destinatario . "'", "'" . $fechaRadicado . "'", "'" 
//                        . $referencia . "'", "'" . $descripcion . "'", "'" 
//                        . $responsableRespuesta . "'", "'" . $fechaMaxRepuesta . "'", "'" 
//                        . $referenciaRespuesta. "'", "'" . $fechaRespuesta . "'", "'" 
//                        . $estado. "'", "'" . $operador ."'");
        $campos = array("dti_id", "dot_id", " dos_id", 
                "doa_id_autor", "doa_id_dest", "doc_fecha_radicado", 
                "doc_descripcion", 
                "usu_id", "doc_fecha_respuesta", 
                "doc_codigo_ref", "doc_fecha_respondido", 
                "doe_id", "ope_id ");
        if($fechaMaxRepuesta == "") $fechaMaxRepuesta = "0000-00-00";
        if($fechaRespuesta == "") $fechaRespuesta = "0000-00-00";
        if($fechaRadicado == "") $fechaRadicado = "0000-00-00";
        $valores = array("'" . $tipo . "'", "'" . $tema . "'", "'" . $subtema . "'", "'" 
                        . $autor . "'", "'" . $destinatario . "'", "'" . $fechaRadicado . "'", "'" 
                        . $descripcion . "'", "'" 
                        . $responsableRespuesta . "'", "'" . $fechaMaxRepuesta . "'", "'" 
                        . $referenciaRespuesta. "'", "'" . $fechaRespuesta . "'", "'" 
                        . $estado. "'", "'" . $operador ."'");
        $condicion = "doc_id = ".$id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores,$condicion);
        if(isset($documentoSoporte) && $documentoSoporte!=""){
            $campos = array("doc_archivo");
            $valores = array("'".$documentoSoporte."'");
            $this->db->actualizarRegistro($tabla, $campos, $valores,$condicion);
        }
        if(isset($anexos) && $anexos!=""){
            $campos = array("doc_anexo");
            $valores = array("'".$anexos."'");
            $this->db->actualizarRegistro($tabla, $campos, $valores,$condicion);
        }else{
            if($tieneAnexo==2){
                $campos = array("doc_anexo");
                $valores = array("''");
                $this->db->actualizarRegistro($tabla, $campos, $valores,$condicion);
            }
        }
        if(isset($referenciaRespondido) && $referenciaRespondido!=""){
            $campos = array("doc_referencia_respondido");
            $valores = array("'".$referenciaRespondido."'");
            $this->db->actualizarRegistro($tabla, $campos, $valores,$condicion);
        }
        if(isset($fechaMaxRepuesta) && $fechaMaxRepuesta=="0000-00-00"){
            $campos = array("doc_referencia_respondido");
            $valores = array("''");
            $this->db->actualizarRegistro($tabla, $campos, $valores,$condicion);
        }
        return $r;
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
    
    function getCountByName($name) {
        //$sql = "select max(doc_version) from documento where doc_archivo like '" . $name . "%'";
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
    function getEstado($criterio, $orden) {
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
    
    function getCountByReferencia($ref) {
        //$sql = "select max(doc_version) from documento where doc_archivo like '" . $name . "%'";
        $tabla = 'documento_comunicado';
        $campo = 'count(1)';
        $predicado = "doc_codigo_ref = '" . $ref . "'";

        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);
        if ($r) { 
            return $r;
        } else {
            return 0;            
        }
    }
    
    function getCountByReferenciaEdit($id, $ref) {
        //$sql = "select max(doc_version) from documento where doc_archivo like '" . $name . "%'";
        $tabla = 'documento_comunicado';
        $campo = 'count(1)';
        $predicado = " doc_id <> ".$id." and doc_codigo_ref = '" . $ref . "'";

        $r = $this->db->recuperarCampo($tabla, $campo, $predicado);
        if ($r) { 
            return $r;
        } else {
            //echo "error";
            return 0;            
        }
    }
    function getNamePerfilByIdUsuario($id){
        $perfil = null;
        //select u.usu_id, u.per_id, p.per_nombre from usuario u inner join perfil p on p.per_id=u.per_id where usu_id=2
        $sql = "select u.per_id, p.per_nombre"
                . " from usuario u"
                . " inner join perfil p on p.per_id=u.per_id "
                . "where usu_id=" . $id ."";
        //echo ($sql."<br>");
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $w = mysql_fetch_array($r);
            $perfil['perfil_id'] = $w['per_id'];
            $perfil['nombre'] = $w['per_nombre'];
        }
        return $perfil;
    }
    
    function getAreas($criterio, $orden) {
        $areas = null;
        $sql = "select * from documento_tema where " . $criterio . " order by " . $orden;
        //echo("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $areas[$cont]['id'] = $w['dot_id'];
                $areas[$cont]['nombre'] = $w['dot_nombre'];
                $cont++;
            }
        }
        return $areas;
    }
    
    function responderCorrespondencia($id,$consecutivo,$fecha, $documento, $estado) {
        
        $tabla = "documento_comunicado";
        $campos = array("doc_referencia", "doc_fecha_respondido", 
                "doc_referencia_respondido", "doe_id");
        $valores = array("'" . $consecutivo . "'", "'" . $fecha . "'", "'" . $documento . "'", "'" 
                        . $estado. "'");
        $condicion = "doc_id = ".$id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores,$condicion);
        
        return $r;
    }
}
