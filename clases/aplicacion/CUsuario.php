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
 * Clase Usuario
 *
 * @package  clases
 * @subpackage aplicacion
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
class CUsuario {

    var $id = null;
    var $login = null;
    var $password = null;
    var $nombre = null;
    var $apellido = null;
    var $documento = null;
    var $telefono = null;
    var $celular = null;
    var $correo = null;
    var $perfil = null;
    var $estado = null;
    var $fecha = null;
    var $ip = null;
    var $du = null;

    /**
     * * Constructor de la clase CUsuarioData
     * */
    function CUsuario($id, $du) {
        $this->id = $id;
        $this->du = $du;
    }
    
    function setId($val) {
        $this->id = $val;
    }

    function setLogin($val) {
        $this->login = $val;
    }

    function setPassword($val) {
        $this->password = $val;
    }

    function setNombre($val) {
        $this->nombre = $val;
    }

    function setApellido($val) {
        $this->apellido = $val;
    }

    function setDocumento($val) {
        $this->documento = $val;
    }

    function setTelefono($val) {
        $this->telefono = $val;
    }

    function setCelular($val) {
        $this->celular = $val;
    }

    function setCorreo($val) {
        $this->correo = $val;
    }

    function setPerfil($val) {
        $this->perfil = $val;
    }

    function setEstado($val) {
        $this->estado = $val;
    }

    function setFecha($val) {
        $this->fecha = $val;
    }

    function setIp($val) {
        $this->ip = $val;
    }

    function getId() {
        return $this->id;
    }

    function getLogin() {
        return $this->login;
    }

    function getPassword() {
        return $this->password;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellido() {
        return $this->apellido;
    }

    function getDocumento() {
        return $this->documento;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getCelular() {
        return $this->celular;
    }

    function getCorreo() {
        return $this->correo;
    }

    function getPerfil() {
        return $this->perfil;
    }

    function getEstado() {
        return $this->estado;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getIp() {
        return $this->ip;
    }

    /**
     * carga los valores de un objeto USUARIO por su id para ser editados
     * */
    function loadUser() {
        $r = $this->du->getUserById($this->id);
        if ($r != -1) {
            $this->login = $r['usu_login'];
            $this->password = $r['usu_clave'];
            $this->nombre = $r['usu_nombre'];
            $this->apellido = $r['usu_apellido'];
            $this->documento = $r['usu_documento'];
            $this->telefono = $r['usu_telefono'];
            $this->celular = $r['usu_celular'];
            $this->correo = $r['usu_correo'];
            $this->perfil = $r['per_id'];
            $this->estado = $r['usu_estado'];
            $this->fecha = $r['usu_fecha_ultimo_ingreso'];
            $this->ip = $r['usu_ip'];
        } else {
            $this->login = "";
            $this->password = "";
            $this->nombre = "";
            $this->apellido = "";
            $this->documento = "";
            $this->telefono = "";
            $this->celular = "";
            $this->correo = "";
            $this->perfil = "";
            $this->estado = "";
            $this->fecha = "";
            $this->ip = "";
        }
    }

    /**
     * * carga los valores de un objeto USUARIO por su id para ser visualizados
     * */
    function loadSeeUser() {
        $r = $this->du->getUserById($this->id);
        if ($r != -1) {
            $this->login = $r['usu_login'];
            $this->password = $r['usu_clave'];
            $this->nombre = $r['usu_nombre'];
            $this->apellido = $r['usu_apellido'];
            $this->documento = $r['usu_documento'];
            $this->telefono = $r['usu_telefono'];
            $this->celular = $r['usu_celular'];
            $this->correo = $r['usu_correo'];
            $this->perfil = $r['per_nombre'];
            if ($r['usu_estado'] == 1)
                $this->estado = "Activo";
            else
                $this->estado = "Inactivo";
            $this->fecha = $r['usu_fecha_ultimo_ingreso'];
            $this->ip = $r['usu_ip'];
        }else {
            $this->login = "";
            $this->password = "";
            $this->nombre = "";
            $this->apellido = "";
            $this->documento = "";
            $this->telefono = "";
            $this->celular = "";
            $this->correo = "";
            $this->perfil = "";
            $this->estado = "";
            $this->fecha = "";
            $this->ip = "";
        }
    }

    /**
     * * almacena un objeto USUARIO y retorna un mensaje del resultado del proceso
     * */
    function saveNewUser() {
        $valid = $this->du->getUserIdByLogin($this->login);
        if ($valid != -1) {
            $msg = USUARIO_EXISTENTE;
        }
        if ($valid == -1) {
            $r = $this->du->insertUser($this->login, $this->password, $this->nombre, $this->apellido, $this->documento, $this->telefono, $this->celular, $this->correo, $this->perfil, $this->estado, $this->fecha);
            if ($r == 'true') {
                $this->id = $this->du->getUserIdByLogin($this->login);
                $msg = USUARIO_AGREGADO;
            } else {
                $msg = ERROR_ADD_USER;
            }
        }
        return $msg;
    }

    /**
     * * elimina un objeto USUARIO y retorna un mensaje del resultado del proceso
     * */
    function deleteUser() {
        $r = $this->du->deleteUserPerfiles($this->id);
        $r = $this->du->deleteUser($this->id);
        if ($r == 'true') {
            $msg = USUARIO_BORRADO;
        } else {
            $msg = ERROR_DEL_USER;
        }
        return $msg;
    }

    /**
     * * actualiza un objeto USUARIO (incluido el password) y retorna un mensaje del resultado del proceso
     * */
    function saveEditUser() {
        $valid = $this->du->getCountUsersByLogin($this->login);
        if ($valid > 1) {
            $msg = USUARIO_EXISTENTE;
        } else {
            $r = $this->du->updateUser($this->id, $this->login, $this->password, $this->nombre, $this->apellido, $this->documento, $this->telefono, $this->celular, $this->correo, $this->perfil, $this->estado);
            if ($r == 'true') {
                $msg = USUARIO_EDITADO;
            } else {
                $msg = ERROR_EDIT_USER;
            }
        }
        return $msg;
    }

    /**
     * * actualiza un objeto USUARIO (sin incluir el password) y retorna un mensaje del resultado del proceso
     * */
    function saveEditUserWithOutPassword() {
        $valid = $this->du->getCountUsersByLogin($this->login);
        if ($valid > 1) {
            $msg = USUARIO_EXISTENTE;
        } else {
            $r = $this->du->updateUser($this->id, $this->login, '', $this->nombre, $this->apellido, $this->documento, $this->telefono, $this->celular, $this->correo, $this->perfil, $this->estado);
            if ($r == 'true') {
                $msg = USUARIO_EDITADO;
            } else {
                $msg = ERROR_EDIT_USER;
            }
        }
        return $msg;
    }

    /**
     * * carga las opciones de un objeto USUARIO
     * */
    function loadOptionsForUser() {
        $r = $this->du->loadOptionsForUser($this->id);
        $opc = null;
        while ($row = mysql_fetch_array($r)) {
            if ($row['usu_id'] == $this->id)
                $indicador = 1;
            else
                $indicador = 0;
            $opc[count($opc)] = array('id' => $row['opc_id'],
                'nombre' => $row['opc_nombre'],
                'nivel' => $row['opc_nivel'],
                'indicador' => $indicador,
                'acceso' => $row['uxo_nivel']);
        }
        return $opc;
    }

    /**
     * * actualiza un objeto USUARIO (solo para el password - cambio de clave)
     * */
    function saveNewClave() {
        $id = $this->du->getUserId($this->login, $this->password);
        if ($id != -1) {
            $r = $this->du->updatePass($id, $this->nombre); //nombre=nuevoPass
            if ($r == 'true') {
                $msg = CLAVE_EDITADA;
            } else {
                $msg = CLAVE_NO_EDITADA;
            }
        } else
            $msg = CLAVE_NO_COINCIDE;
        return $msg;
    }

    /**
     * * actualiza las opciones de un objeto USUARIO
     * */
    function saveEditUserOptions($options) {
        $r = $this->du->deleteUserOptions($this->id);
        foreach ($options as $o) {
            $this->du->insertUserOption($this->id, $o['id'], $o['nivel']);
        }
    }

}

?>