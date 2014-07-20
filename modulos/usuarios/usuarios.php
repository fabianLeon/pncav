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
 * Modulo Usuarios
 * maneja el modulo USUARIOS en union con CUsuario y CUsuarioData
 *
 * @see CUsuario
 * @see CUsuarioData

 * @package  modulos
 * @subpackage usuarios
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');
$task = $_REQUEST['task'];
if (empty($task))
    $task = 'list';

switch ($task) {
    /**
     * la variable list, permite hacer la carga la página con la lista de objetos USUARIO según los parámetros de entrada
     */
    case 'list':
        if ($id_usuario != 1) {
            $criterio_list = 'usu_id <> 1';
        } else {
            $criterio_list = '1';
        }
        $usuarios = $du->getUsers($criterio_list, 'usu_login');
        $dt = new CHtmlDataTableAlignable();
        $titulos = array(USUARIO_LOGIN, USUARIO_NOMBRE, USUARIO_APELLIDO, USUARIO_DOCUMENTO, 
            USUARIO_TELEFONO, USUARIO_PERFIL, USUARIO_CORREO, USUARIO_ESTADO, USUARIO_FECHA);
        $dt->setDataRows($usuarios);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_USUARIOS);

        $dt->setSeeLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=see");
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=delete");

        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=add");

        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        break;
    /**
     * la variable add, permite hacer la carga la página con las variables que componen el objeto USUARIO, ver la clase CUsuario
     */
    case 'add':
        $form = new CHtmlForm();
        $form->setTitle(AGREGAR_USUARIO);

        $form->setId('frm_add_user');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(USUARIO_LOGIN);
        $form->addInputText('text', 'txt_login', 'txt_login', '15', '15', '', '', 'onkeypress="ocultarDiv(\'error_login\');"');
        $form->addError('error_login', ERROR_LOGIN);

        $form->addEtiqueta(USUARIO_PASSWORD);
        $form->addInputText('password', 'txt_password', 'txt_password', '15', '15', '', '', 'onkeypress="ocultarDiv(\'error_password\');"');
        $form->addError('error_password', ERROR_PASSWORD);

        $perfiles = $du->getPerfiles('1', 'per_nombre');
        $opciones = null;
        foreach ($perfiles as $s) {
            $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
        }

        $form->addEtiqueta(USUARIO_PERFIL);
        $form->addSelect('select', 'sel_perfil', 'sel_perfil', $opciones, USUARIO_PERFIL, $perfil, '', 'onChange="ocultarDiv(\'error_perfil\');"');
        $form->addError('error_perfil', ERROR_USUARIO_PERFIL);

        $form->addEtiqueta(USUARIO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '20', '60', '', '', 'onkeypress="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_NOMBRE);

        $form->addEtiqueta(USUARIO_APELLIDO);
        $form->addInputText('text', 'txt_apellido', 'txt_apellido', '20', '60', '', '', 'onkeypress="ocultarDiv(\'error_apellido\');"');
        $form->addError('error_apellido', ERROR_APELLIDO);

        $form->addEtiqueta(USUARIO_DOCUMENTO);
        $form->addInputText('text', 'txt_documento', 'txt_documento', '15', '20', '', '', 'onkeypress="ocultarDiv(\'error_documento\');"');
        $form->addError('error_documento', ERROR_DOCUMENTO);

        $form->addEtiqueta(USUARIO_TELEFONO);
        $form->addInputText('text', 'txt_telefono', 'txt_telefono', '15', '20', '', '', 'onkeypress="ocultarDiv(\'error_telefono\');"');
        $form->addError('error_telefono', ERROR_TELEFONO);

        $form->addEtiqueta(USUARIO_CELULAR);
        $form->addInputText('text', 'txt_celular', 'txt_celular', '15', '20', '', '', 'onkeypress="ocultarDiv(\'error_celular\');"');
        $form->addError('error_celular', ERROR_CELULAR);

        $form->addEtiqueta(USUARIO_CORREO);
        $form->addInputText('text', 'txt_correo', 'txt_correo', '30', '200', '', '', 'onkeypress="ocultarDiv(\'error_correo\');"');
        $form->addError('error_correo', ERROR_CORREO);

        $estados = $du->getTipoActividad();
        $opciones = null;
        foreach ($estados as $s) {
            $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
        }

        $form->addEtiqueta(USUARIO_ESTADO);
        $form->addSelect('select', 'sel_estado', 'sel_estado', $opciones, USUARIO_ESTADO, $estado, '', 'onChange="ocultarDiv(\'error_estado\');"');
        $form->addError('error_estado', ERROR_USUARIO_ESTADO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_user();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_user\',\'?mod=usuarios&niv=1\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveAdd, permite almacenar el objeto USUARIO en la base de datos, ver la clase CUsuarioData
     */
    case 'saveAdd':
        $login = $_POST['txt_login'];
        $password = $_POST['txt_password'];
        $nombre = $_POST['txt_nombre'];
        $apellido = $_POST['txt_apellido'];
        $documento = $_POST['txt_documento'];
        $telefono = $_POST['txt_telefono'];
        $celular = $_POST['txt_celular'];
        $correo = $_POST['txt_correo'];
        $perfil = $_POST['sel_perfil'];
        $estado = $_POST['sel_estado'];
        $fecha = date("Y-m-d");

        $usuario = new CUsuario('', $du);

        $usuario->setLogin($login);
        $usuario->setPassword($password);
        $usuario->setNombre($nombre);
        $usuario->setApellido($apellido);
        $usuario->setDocumento($documento);
        $usuario->setTelefono($telefono);
        $usuario->setCelular($celular);
        $usuario->setCorreo($correo);
        $usuario->setPerfil($perfil);
        $usuario->setEstado($estado);
        $usuario->setFecha($fecha);

        $m = $usuario->saveNewUser();

        echo $html->generaAviso($m, '?mod=usuarios&niv=1');

        break;
    /**
     * la variable delete, permite hacer la carga del objeto USUARIO y espera confirmacion de eliminarlo, ver la clase CUsuario
     */
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        $usuario = new CUsuario($id_delete, $du);

        $form = new CHtmlForm();
        $form->setId('frm_delet_user');
        $form->setMethod('post');

        $form->addInputText('hidden', 'id_element', 'id_element', '15', '15', $usuario->getId(), '', '');

        $form->writeForm();

        echo $html->generaAdvertencia(USUARIO_MSG_BORRADO, '?mod=usuarios&niv=1&task=confirmDelete&id_element=' . $id_delete, "cancelarAccion('frm_delet_user','?mod=usuarios&niv=1')");

        break;
    /**
     * la variable confirmDelete, permite eliminar el objeto USUARIO de la base de datos, ver la clase CUsuarioData
     */
    case 'confirmDelete':
        $id_delete = $_REQUEST['id_element'];
        $usuario = new CUsuario($id_delete, $du);
        $m = $usuario->deleteUser();

        echo $html->generaAviso($m, '?mod=usuarios&niv=1');

        break;
    /**
     * la variable edit, permite hacer la carga del objeto USUARIO y espera confirmacion de edicion, ver la clase CUsuario
     */
    case 'edit':
        $id_edit = $_REQUEST['id_element'];
        $usuario = new CUsuario($id_edit, $du);
        $usuario->loadUser();

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_USUARIO);
        $form->setId('frm_edit_user');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $usuario->getId(), '', '');

        $form->addEtiqueta(USUARIO_LOGIN);
        $form->addInputText('text', 'txt_login', 'txt_login', '15', '15', $usuario->getLogin(), '', 'onkeypress="ocultarDiv(\'error_login\');" readOnly');
        $form->addError('error_login', ERROR_LOGIN);

        $form->addEtiqueta(USUARIO_PASSWORD);
        $form->addInputText('password', 'txt_password', 'txt_password', '15', '15', '', '', 'onkeypress="ocultarDiv(\'error_password\');"');
        $form->addError('error_password', ERROR_PASSWORD);

        $perfiles = $du->getPerfiles('1', 'per_nombre');
        $opciones = null;
        foreach ($perfiles as $s) {
            $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
        }

        $form->addEtiqueta(USUARIO_PERFIL);
        $form->addSelect('select', 'sel_perfil', 'sel_perfil', $opciones, USUARIO_PERFIL, $usuario->getPerfil(), '', 'onkeypress="ocultarDiv(\'error_perfil\');"');
        $form->addError('error_perfil', ERROR_USUARIO_PERFIL);

        $form->addEtiqueta(USUARIO_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '20', '60', $usuario->getNombre(), '', 'onkeypress="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_NOMBRE);

        $form->addEtiqueta(USUARIO_APELLIDO);
        $form->addInputText('text', 'txt_apellido', 'txt_apellido', '20', '60', $usuario->getApellido(), '', 'onkeypress="ocultarDiv(\'error_apellido\');"');
        $form->addError('error_apellido', ERROR_APELLIDO);

        $form->addEtiqueta(USUARIO_DOCUMENTO);
        $form->addInputText('text', 'txt_documento', 'txt_documento', '15', '20', $usuario->getDocumento(), '', 'onkeypress="ocultarDiv(\'error_documento\');"');
        $form->addError('error_documento', ERROR_DOCUMENTO);

        $form->addEtiqueta(USUARIO_TELEFONO);
        $form->addInputText('text', 'txt_telefono', 'txt_telefono', '15', '20', $usuario->getTelefono(), '', 'onkeypress="ocultarDiv(\'error_telefono\');"');
        $form->addError('error_telefono', ERROR_TELEFONO);

        $form->addEtiqueta(USUARIO_CELULAR);
        $form->addInputText('text', 'txt_celular', 'txt_celular', '15', '20', $usuario->getCelular(), '', 'onkeypress="ocultarDiv(\'error_celular\');"');
        $form->addError('error_celular', ERROR_CELULAR);

        $form->addEtiqueta(USUARIO_CORREO);
        $form->addInputText('text', 'txt_correo', 'txt_correo', '30', '200', $usuario->getCorreo(), '', 'onkeypress="ocultarDiv(\'error_correo\');"');
        $form->addError('error_correo', ERROR_CORREO);

        $estados = $du->getTipoActividad();
        $opciones = null;
        foreach ($estados as $s) {
            $opciones[count($opciones)] = array('value' => $s['id'], 'texto' => $s['nombre']);
        }

        $form->addEtiqueta(USUARIO_ESTADO);
        $form->addSelect('select', 'sel_estado', 'sel_estado', $opciones, USUARIO_ESTADO, $usuario->getEstado(), '', 'onChange="ocultarDiv(\'error_estado\');"');
        $form->addError('error_estado', ERROR_USUARIO_ESTADO);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_user();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_user\',\'?mod=usuarios&niv=1\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveEdit, permite actualizar el objeto USUARIO en la base de datos, ver la clase CUsuarioData
     */
    case 'saveEdit':
        $id = $_POST['txt_id'];
        $login = $_POST['txt_login'];
        $password = $_POST['txt_password'];
        $nombre = $_POST['txt_nombre'];
        $apellido = $_POST['txt_apellido'];
        $documento = $_POST['txt_documento'];
        $telefono = $_POST['txt_telefono'];
        $celular = $_POST['txt_celular'];
        $correo = $_POST['txt_correo'];
        $perfil = $_POST['sel_perfil'];
        $estado = $_POST['sel_estado'];

        $usuario = new CUsuario($id, $du);
        $usuario->setLogin($login);
        $usuario->setPassword($password);
        $usuario->setNombre($nombre);
        $usuario->setApellido($apellido);
        $usuario->setDocumento($documento);
        $usuario->setTelefono($telefono);
        $usuario->setCelular($celular);
        $usuario->setCorreo($correo);
        $usuario->setPerfil($perfil);
        $usuario->setEstado($estado);


        if (isset($password) && $password != '') {
            $m = $usuario->saveEditUser();
        } else {
            $m = $usuario->saveEditUserWithOutPassword();
        }

        echo $html->generaAviso($m, '?mod=usuarios&niv=1');

        break;
    /**
     * la variable see, permite hacer la carga del objeto USUARIO para ver sus variables, ver la clase CUsuario
     */
    case 'see':
        $id_edit = $_REQUEST['id_element'];
        $usuario = new CUsuario($id_edit, $du);
        $usuario->loadSeeUser();

        $dt = new CHtmlDataTable();
        $titulos = array(USUARIO_LOGIN, USUARIO_PERFIL, USUARIO_NOMBRE, USUARIO_APELLIDO, USUARIO_DOCUMENTO, USUARIO_TELEFONO, USUARIO_CELULAR, USUARIO_CORREO, USUARIO_ESTADO, USUARIO_FECHA);
        $row_usuario = array($usuario->getLogin(), $usuario->getPerfil(), $usuario->getNombre(), $usuario->getApellido(), $usuario->getDocumento(), $usuario->getTelefono(), $usuario->getCelular(), $usuario->getCorreo(), $usuario->getEstado(), $usuario->getFecha());
        $dt->setDataRows($row_usuario);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_USUARIOS);

        $dt->setType(2);

        $dt->writeDataTable($nivel);

        echo $html->generaScriptLink("cancelarAccion('frm_see_usuario','?mod=usuarios&niv=" . $nivel . "')");

        $form = new CHtmlForm();
        $form->setId('frm_see_usuario');
        $form->setMethod('post');

        $form->addInputText('hidden', 'id_element', 'id_element', '15', '15', $usuario->getId(), '', '');

        $form->writeForm();

        break;

// *******************************************************O P C I O N E S ****************************************************************

    /**
     * la variable editOption, permite hacer la carga de las opciones del objeto USUARIO y espera confirmacion de edicion, ver la clase CUsuario
     */
    case 'editOption':
        $id_edit = $_REQUEST['id_element'];
        $usuario = new CUsuario($id_edit, $du);
        $usuario->loadUser();

        $subelementos = null;

        $opc = $usuario->loadOptionsForUser();

        foreach ($opc as $o) {
            $clase = null;
            switch ($o['nivel']) {
                case 0:
                    $clase = 'opcUno';
                    break;
                case 1:
                    $clase = 'opcDos';
                    break;
                default:
                    $clase = 'opcTres';
                    break;
            }
            if ($o['indicador'] == 1)
                $checked = "checked";
            else
                $checked = "";
            if ($o['acceso'] == 1)
                $sub_check = "checked";
            else
                $sub_check = "";
            if ($o['indicador'] == 1)
                $sub_check .= "";
            else
                $sub_check = " disabled";
            $dependientes[0] = array('id' => $o['id'], 'texto' => NIVEL_ADMIN, 'checked' => $sub_check);
            if ($o['acceso'] == 2)
                $sub_check = "checked";
            else
                $sub_check = "";
            if ($o['indicador'] == 1)
                $sub_check .= "";
            else
                $sub_check = " disabled";
            $dependientes[1] = array('id' => $o['id'], 'texto' => NIVEL_SOLO_LECTURA, 'checked' => $sub_check);
            $subelementos[count($subelementos)] = array('value' => $o['id'],
                'texto' => $o['nombre'],
                'clase' => $clase,
                'checked' => $checked,
                'dependientes' => $dependientes,
                'clase_dep' => 'opcDep',
                'events' => 'onClick = habilitarDependiente(this);');
        }

        $form = new CHtmlForm();
        $form->setTitle(EDITAR_USUARIO_OPCIONES);
        $form->setId('frm_edit_options');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $usuario->getId(), '', '');

        $form->addEtiqueta(USUARIO_LOGIN);
        $form->addInputText('text', 'txt_login', 'txt_login', '15', '15', $usuario->getLogin(), '', 'onkeypress="ocultarDiv(\'error_login\');" readOnly');
        $form->addError('error_login', ERROR_LOGIN);

        $form->addEtiqueta('Opciones');
        $form->addExtendedCheckBox('extendedCheckbox', 'chk_opciones', 'chk_opciones', $subelementos, '', '', '');
        $form->addError('error_opciones', '');

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_options();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_options\',\'?mod=usuarios&niv=1\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveOptions, permite actualizar las opciones del objeto USUARIO en la base de datos, ver la clase CUsuarioData
     */
    case 'saveOptions':
        $id_usu = $_POST['txt_id'];
        $login_usu = $_POST['txt_login'];
        $usuario = new CUsuario($id_usu, $du);
        $usuario->loadUser();

        $opc = $usuario->loadOptionsForUser();

        $options = null;

        foreach ($opc as $o) {
            $var_chk = "chk_opciones_" . $o['id'];
            $var_rdo = "radio_" . $o['id'];

            if (isset($_POST[$var_chk])) {
                if ($_POST[$var_rdo] == '0') {
                    $nivel_opc = 1;
                } else {
                    $nivel_opc = 2;
                }
                $options[count($options)] = array('id' => $_POST[$var_chk], 'nivel' => $nivel_opc);
            }
        }

        $usuario->saveEditUserOptions($options);
        echo $html->generaAviso(MSG_OPCIONES_EDITADAS . " " . $usuario->getLogin(), '?mod=usuarios&niv=1');

        break;
    /**
     * la variable editClave, permite hacer la carga de la clave del objeto USUARIO y espera confirmacion de edicion
     */
    case 'editClave':
        $form = new CHtmlForm();
        $form->setTitle(CAMBIAR_CLAVE);

        $form->setId('frm_cambiar_clave');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(USUARIO_PASSWORD_ANTERIOR);
        $form->addInputText('password', 'txt_password', 'txt_password', '15', '15', '', '', 'onkeypress="ocultarDiv(\'error_password\');"');
        $form->addError('error_password', ERROR_PASSWORD);

        $form->addEtiqueta(USUARIO_NUEVO_PASSWORD);
        $form->addInputText('password', 'txt_nuevo_password', 'txt_nuevo_password', '15', '15', '', '', 'onkeypress="ocultarDiv(\'error_nuevo_password\');"');
        $form->addError('error_nuevo_password', EEROR_USUARIO_NUEVO_PASSWORD);

        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_cambiar_clave();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_cambiar_clave\',\'?mod=home&niv=1\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveOptions, permite actualizar la clave del objeto USUARIO en la base de datos, ver la clase CUsuarioData
     */
    case 'saveEditClave':

        $login = $_SESSION["usuario_sesion_pry"];
        $password = $_POST['txt_password'];
        $nuevo_password = $_POST['txt_nuevo_password'];

        $usuario = new CUsuario('', $du);
        $usuario->setLogin($login);
        $usuario->setPassword($password);
        $usuario->setNombre($nuevo_password);

        $m = $usuario->saveNewClave();

        echo $html->generaAviso($m, '?mod=usuarios?niv=1&task=cambiarClave');

        break;
    /**
     * en caso de que la variable task no este definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');

        break;
}
?>