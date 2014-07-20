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
 * Clase UsuarioData
 * Usada para la definicion de todas las funciones propias del objeto USUARIO
 *
 * @package  clases
 * @subpackage datos
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
Class CUserData {

    var $db = null;

    function CUserData($db) {
        $this->db = $db;
    }

    function opciones($us) {
        $sql = "select o.*,p.pxo_nivel
				from opcion o
				inner join perfil_x_opcion p on p.opc_id = o.opc_id
				inner join usuario u on p.per_id = u.per_id
				where u.usu_id = " . $us . "
				and o.opn_id in(0,1)
				order by o.opc_orden";

        $r = $this->db->ejecutarConsulta($sql);
        if ($r)
            return $r;
    }
    
    function getNivelOpcionByVariable($v){
        $pre = "opc_variable = '" . $v ."'";
        $r = $this->db->recuperarCampo('opcion', 'opn_id', $pre);
        if ($r)
            return $r;
        else
            return -1;
    }
    
    function getPadreOpcionByVariable($v){
        $pre = "opc_variable = '" . $v ."'";
        $r = $this->db->recuperarCampo('opcion', 'opc_padre_id', $pre);
        if ($r)
            return $r;
        else
            return -1;
    }

    function subopciones($us, $v, $operador) {
        $nivel = $this->getNivelOpcionByVariable($v);
        if($nivel==2){
            $padre = $this->getPadreOpcionByVariable($v);
            $sql = "select o.*,p.pxo_nivel 
                                    from opcion o
                                    inner join perfil_x_opcion p on p.opc_id = o.opc_id
                                    inner join usuario u on p.per_id = u.per_id
                                    where u.usu_id = " . $us . "
                            and o.opc_padre_id = '".$padre."'
                                    and o.opn_id in(2)
                                    order by o.opc_orden";
        }else{
            $sql = "select o.*,p.pxo_nivel 
                                    from opcion o
                                    inner join perfil_x_opcion p on p.opc_id = o.opc_id
                                    inner join usuario u on p.per_id = u.per_id
                                    where u.usu_id = " . $us . "
                            and o.opc_padre_id = (select opc_id from opcion where opc_variable = '" . $v . "' and opn_id=1 and ope_id =" . $operador . ")
                                    and o.opn_id in(2)
                                    order by o.opc_orden";
        }
        $r = $this->db->ejecutarConsulta($sql);
        if ($r)
            return $r;
    }

    function getUserId($l, $p) {
        $pre = "usu_login = '" . $l . "' and usu_clave = md5('" . $p . "')";
        $r = $this->db->recuperarCampo('usuario', 'usu_id', $pre);
        if ($r)
            return $r;
        else
            return -1;
    }

    function getUserNivel($id, $task) {
        $pre = "u.usu_id = " . $id . " and o.opc_variable = '" . $task . "'";
        $tablas = "perfil_x_opcion p 
					inner join opcion o on o.opc_id = p.opc_id
					inner join usuario u on p.per_id = u.per_id";
        $r = $this->db->recuperarCampo($tablas, 'pxo_nivel', $pre);
        if ($r)
            return $r;
        else
            return -1;
    }

    function getUserPerfil($id) {
        $pre = "u.usu_id = " . $id;
        $tablas = "usuario u";
        $r = $this->db->recuperarCampo($tablas, 'per_id', $pre);
        if ($r)
            return $r;
        else
            return -1;
    }

    function getUserIdByLogin($l) {
        $pre = "usu_login = '" . $l . "'";
        $r = $this->db->recuperarCampo('usuario', 'usu_id', $pre);
        if ($r)
            return $r;
        else
            return -1;
    }

    function getCountUsersByLogin($l) {
        $pre = "usu_login = '" . $l . "'";
        $r = $this->db->recuperarCampo('usuario', 'count(1)', $pre);
        if ($r)
            return $r;
        else
            return -1;
    }

    function getUserNameById($id) {
        $pre = "usu_id = " . $id;
        $n = $this->db->recuperarCampo('usuario', 'usu_nombre', $pre);
        $a = $this->db->recuperarCampo('usuario', 'usu_apellido', $pre);
        $r = $n . " " . $a;
        if ($r)
            return $r;
        else
            return -1;
    }

    function getUserUltimoIngresoById($id) {
        $pre = "usu_id = " . $id;
        $f = $this->db->recuperarCampo('usuario', 'usu_fecha_ultimo_ingreso', $pre);
        if ($f)
            return $f;
        else
            return -1;
    }

    function getUserIpById($id) {
        $pre = "usu_id = " . $id;
        $f = $this->db->recuperarCampo('usuario', 'usu_ip', $pre);
        if ($f)
            return $f;
        else
            return -1;
    }

    function getUsers($criterio, $orden) {
        $users = null;
        $sql = "select * from usuario u, perfil p where p.per_id=u.per_id and " . $criterio . " order by " . $orden;
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
                $users[$cont]['perfil'] = $w['per_nombre'];
                $users[$cont]['correo'] = $w['usu_correo'];
                if ($w['usu_estado'] == 1)
                    $users[$cont]['estado'] = "Activo";
                else
                    $users[$cont]['estado'] = "Inactivo";
                $users[$cont]['fecha'] = $w['usu_fecha_ultimo_ingreso'];
                $cont++;
            }
        }
        return $users;
    }

    function insertUser($login, $password, $nombre, $apellido, $documento, $telefono, $celular, $correo, $perfil, $estado, $fecha) {
        $tabla = "usuario";
        $campos = "usu_login,usu_clave,usu_nombre,usu_apellido,usu_documento,usu_telefono,usu_celular,usu_correo,per_id,usu_estado,usu_fecha_ultimo_ingreso";
        $valores = "'" . $login . "',md5('" . $password . "'),
					'" . $nombre . "','" . $apellido . "',
					'" . $documento . "','" . $telefono . "',
					'" . $celular . "','" . $correo . "',
					'" . $perfil . "','" . $estado . "','" . $fecha . "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }

    function updateUser($id, $login, $password, $nombre, $apellido, $documento, $telefono, $celular, $correo, $perfil, $estado) {
        $tabla = "usuario";
        if (isset($password) && $password != '') {
            $campos = array('usu_login', 'usu_clave', 'usu_nombre', 'usu_apellido', 'usu_documento', 'usu_telefono', 'usu_celular', 'usu_correo', 'per_id', 'usu_estado');
            $valores = array("'" . $login . "'", "md5('" . $password . "')", "'" . $nombre . "'", "'" . $apellido . "'", "'" . $documento . "'", "'" . $telefono . "'", "'" . $celular . "'", "'" . $correo . "'", "'" . $perfil . "'", "'" . $estado . "'");
        } else {
            $campos = array('usu_login', 'usu_nombre', 'usu_apellido', 'usu_documento', 'usu_telefono', 'usu_celular', 'usu_correo', 'per_id', 'usu_estado');
            $valores = array("'" . $login . "'", "'" . $nombre . "'", "'" . $apellido . "'", "'" . $documento . "'", "'" . $telefono . "'", "'" . $celular . "'", "'" . $correo . "'", "'" . $perfil . "'", "'" . $estado . "'");
        }
        $condicion = "usu_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    function updateUserFecha($id, $fecha) {
        $tabla = "usuario";
        $campos = array('usu_fecha_ultimo_ingreso');
        $valores = array("'" . $fecha . "'");

        $condicion = "usu_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    function deleteUser($id) {
        $tabla = "usuario";
        $predicado = "usu_id = " . $id;
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }

    function deleteUserPerfiles($id) {
        $tabla = "perfil_x_opcion";
        $predicado = "usu_id = " . $id;
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }

    function getUserById($id) {
        $sql = "select u.*,p.per_nombre 
				from usuario u 
				inner join perfil p on u.per_id = p.per_id 
				where u.usu_id = " . $id;
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    function getUserControlById($id) {
        $pre = "usu_id = " . $id;
        $r = $this->db->recuperarCampo('documento_equipo', 'deq_controla_alarmas', $pre);
        if ($r)
            return $r;
        else
            return -1;
    }

    function loadOptionsForUser($id) {
        $sql = "select o.opc_id,o.opc_nombre,o.opn_id,u.usu_id,u.uxo_nivel
				from opcion o
				left join usuario_x_opcion u on u.opc_id = o.opc_id and u.usu_id = " . $id . "
				order by o.opc_orden";
        $r = $this->db->ejecutarConsulta($sql);
        return $r;
    }

    function getPerfiles($criterio, $orden) {
        $perfiles = null;
        $sql = "select * from perfil where " . $criterio . " order by " . $orden;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $perfiles[$cont]['id'] = $w['per_id'];
                $perfiles[$cont]['nombre'] = $w['per_nombre'];
                $cont++;
            }
        }
        return $perfiles;
    }

    function getTipoActividad() {
        $respuestas[0]['id'] = 1;
        $respuestas[0]['nombre'] = 'Activo';
        $respuestas[1]['id'] = 0;
        $respuestas[1]['nombre'] = 'Inactivo';
        return $respuestas;
    }

    function getTipoRespuesta() {
        $respuestas[0]['id'] = 1;
        $respuestas[0]['nombre'] = 'Si';
        $respuestas[1]['id'] = 2;
        $respuestas[1]['nombre'] = 'No';
        return $respuestas;
    }

    function updatePass($id, $password) {
        $tabla = "usuario";
        $campos = array('usu_clave');
        $valores = array("md5('" . $password . "')");
        $condicion = "usu_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }

    function getTipoBusqueda($criterio, $orden) {
        $respuestas = null;
        $sql = "select * from tipo_busqueda_alarmas where " . $criterio . " order by " . $orden;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $respuestas[$cont]['id'] = $w['tib_id'];
                $respuestas[$cont]['nombre'] = $w['tib_nombre'];
                $cont++;
            }
        }
        return $respuestas;
    }

}

?>
