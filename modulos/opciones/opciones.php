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
 * Modulo Opciones
 * maneja el modulo OPCIONES en union con COpcion y COpcionData
 *
 * @see COpcion
 * @see COpcionData
 *
 * @package  modulos
 * @subpackage opciones
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access');
$opcData = new COpcionData($db);
$dirApp = new COpcion('', '', '');
$opeData = new COperadorData($db);
$task = $_REQUEST['task'];
if (empty($task))
    $task = 'list';

switch ($task) {
    /**
     * la variable list, permite hacer la carga la página con la lista de objetos OPCION según los parámetros de entrada
     */
    case 'list':
        $criterio = '1';
        $opciones = $opcData->getOpciones($criterio, 'opc_orden');

        $dt = new CHtmlDataTable();
        $titulos = array(OPCION_NOMBRE, OPCION_VARIABLE, OPCION_URL, OPCION_NIVEL, OPCION_PADRE, OPCION_ORDEN, OPCION_LAYOUT, OPERADOR);
        $dt->setDataRows($opciones);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_OPCIONES);

        $dt->setSeeLink("?mod=" . $modulo . "&niv=" . $niv . "&task=see");
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $niv . "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $niv . "&task=delete");

        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $niv . "&task=add");

        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        break;
    /**
     * la variable add, permite hacer la carga la página con las variables que componen el objeto OPCION, ver la clase COpcion
     */
    case 'add':
        $nombre = $_REQUEST['txt_nombre'];
        $variable = $_REQUEST['txt_variable'];
        $url = $_REQUEST['txt_url'];
        $nivel_opcion = $_REQUEST['sel_nivel'];
        $padre = $_REQUEST['sel_padre'];
        $orden = $_REQUEST['txt_orden'];
        $layout = $_REQUEST['sel_layout'];
        $operador = $_REQUEST['sel_operador'];

        $form = new CHtmlForm();

        $form->setTitle(AGREGAR_OPCION);
        $form->setId('frm_add_opcion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(OPCION_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '30', '60', $nombre, '', 'onkeypress="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_OPCION_NOMBRE);

        $form->addEtiqueta(OPCION_VARIABLE);
        $form->addInputText('text', 'txt_variable', 'txt_variable', '30', '50', $variable, '', 'onkeypress="ocultarDiv(\'error_variable\');"');
        $form->addError('error_variable', ERROR_OPCION_VARIABLE);

        $form->addEtiqueta(OPCION_URL);
        $form->addInputText('text', 'txt_url', 'txt_url', '50', '150', $url, '', 'onkeypress="ocultarDiv(\'error_url\');"');
        $form->addError('error_url', ERROR_OPCION_URL);

        $niveles = $opcData->getNiveles('1', 'opn_nombre');
        $opciones = null;
        if (isset($niveles)) {
            foreach ($niveles as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(OPCION_NIVEL);
        $form->addSelect('select', 'sel_nivel', 'sel_nivel', $opciones, OPCION_NIVEL, $nivel_opcion, '', 'onChange=submit();');
        $form->addError('error_nivel', ERROR_OPCION_NIVEL);

        //----------------->OPERADOR
        $operadores = $opeData->loadOperadores('1', 'ope_nombre');
        $opciones = null;
        if (isset($operadores)) {
            foreach ($operadores as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(OPERADOR);
        $form->addSelect('select', 'sel_operador', 'sel_operador', $opciones, OPERADOR, $operador, '', 'onChange=submit();');
        $form->addError('error_operador', ERROR_OPERADOR);

        $padres = $opcData->getPadres($nivel_opcion, $operador);
        $opciones = null;
        if (isset($padres) && isset($nivel_opcion) && $nivel_opcion != -1) {
            foreach ($padres as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }


        $form->addEtiqueta(OPCION_PADRE);
        $form->addSelect('select', 'sel_padre', 'sel_padre', $opciones, OPCION_PADRE, $padre, '', 'onChange=submit();');
        $form->addError('error_padre', '');

        $form->addEtiqueta(OPCION_ORDEN);
        $form->addInputText('text', 'txt_orden', 'txt_orden', '15', '6', $orden, '', 'onkeypress="ocultarDiv(\'error_orden\');"');
        $form->addError('error_orden', ERROR_OPCION_ORDEN);

        $layouts = $dirApp->getFiles(LAYOUT_PATH, 'php');
        $opciones = null;
        if (isset($layouts) && $nivel_opcion > 0) {
            foreach ($layouts as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form->addEtiqueta(OPCION_LAYOUT);
        $form->addSelect('select', 'sel_layout', 'sel_layout', $opciones, OPCION_LAYOUT, $layout, '', 'onChange=submit();');
        $form->addError('error_layout', '');


        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_add_opcion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_add_opcion\',\'?mod=' . $modulo . '&niv=' . $niv . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveAdd, permite almacenar el objeto OPCION en la base de datos, ver la clase COpcionData
     */
    case 'saveAdd':
        $nombre = $_REQUEST['txt_nombre'];
        $variable = $_REQUEST['txt_variable'];
        $url = $_REQUEST['txt_url'];
        $nivel_opcion = $_REQUEST['sel_nivel'];
        $padre = $_REQUEST['sel_padre'];
        $operador = $_REQUEST['sel_operador'];

        if ($padre == '-1')
            $padre = 0;
        $orden = $_REQUEST['txt_orden'];
        $layout = $_REQUEST['sel_layout'];
        if ($layout == '-1')
            $layout = '';
        $opcion = new COpcion($opcData);
        $opcion->setNombre($nombre);
        $opcion->setVariable($variable);
        $opcion->setUrl($url);
        $opcion->setNivel($nivel_opcion);
        $opcion->setPadre($padre);
        $opcion->setOrden($orden);
        $opcion->setLayout($layout);
        $opcion->setOperador($operador);

        $m = $opcion->saveNewOpcion($operador);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=1&task=list");

        break;
    /**
     * la variable delete, permite hacer la carga del objeto OPCION y espera confirmacion de eliminarlo, ver la clase COpcion
     */
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        $opcion = new COpcion($opcData);
        $opcion->setId($id_delete);

        $form = new CHtmlForm();
        $form->setId('frm_delet_opcion');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $opcion->getId(), '', '');
        $form->writeForm();

        echo $html->generaAdvertencia(OPCION_MSG_BORRADO, '?mod=' . $modulo . '&niv=1&task=confirmDelete&id_element=' . $id_delete, "cancelarAccion('frm_delet_opcion','?mod=" . $modulo . "&niv=1')");

        break;
    /**
     * la variable confirmDelete, permite eliminar el objeto OPCION de la base de datos, ver la clase COpcionData
     */
    case 'confirmDelete':
        $id_delete = $_REQUEST['id_element'];
        $opcion = new COpcion($opcData);
        $opcion->setId($id_delete);

        $m = $opcion->deleteOpcion();

        echo $html->generaAviso($m, '?mod=' . $modulo . '&niv=1');

        break;
    /**
     * la variable edit, permite hacer la carga del objeto OPCION y espera confirmacion de edicion, ver la clase COpcion
     */
    case 'edit':
        $id_edit = $_REQUEST['id_element'];
        $opcion = new COpcion($opcData);
        $opcion->setId($id_edit);
        $opcion->loadOpcion();

        if (!isset($_REQUEST['txt_nombre']))
            $nombre = $opcion->getNombre();
        else
            $nombre = $_REQUEST['txt_nombre'];
        if (!isset($_REQUEST['txt_variable']))
            $variable = $opcion->getVariable();
        else
            $variable = $_REQUEST['txt_variable'];
        if (!isset($_REQUEST['txt_url']))
            $url = $opcion->getUrl();
        else
            $url = $_REQUEST['txt_url'];
        if (!isset($_REQUEST['sel_nivel']))
            $nivel_opcion = $opcion->getNivel();
        else
            $nivel_opcion = $_REQUEST['sel_nivel'];
        if (!isset($_REQUEST['sel_padre']))
            $padre = $opcion->getPadre();
        else
            $padre = $_REQUEST['sel_padre'];
        if (!isset($_REQUEST['txt_orden']))
            $orden = $opcion->getOrden();
        else
            $orden = $_REQUEST['txt_orden'];
        if (!isset($_REQUEST['sel_layout']))
            $layout = $opcion->getLayout();
        else
            $layout = $_REQUEST['sel_layout'];
        if (!isset($_REQUEST['sel_operador']))
            $operador = $opcion->getOperador();
        else
            $operador = $_REQUEST['sel_operador'];

        $form = new CHtmlForm();

        $form->setTitle(AGREGAR_OPCION);
        $form->setId('frm_edit_opcion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $opcion->getId(), '', '');

        $form->addEtiqueta(OPCION_NOMBRE);
        $form->addInputText('text', 'txt_nombre', 'txt_nombre', '30', '60', $nombre, '', 'onkeypress="ocultarDiv(\'error_nombre\');"');
        $form->addError('error_nombre', ERROR_OPCION_NOMBRE);

        $form->addEtiqueta(OPCION_VARIABLE);
        $form->addInputText('text', 'txt_variable', 'txt_variable', '30', '50', $variable, '', 'onkeypress="ocultarDiv(\'error_variable\');"');
        $form->addError('error_variable', ERROR_OPCION_VARIABLE);

        $form->addEtiqueta(OPCION_URL);
        $form->addInputText('text', 'txt_url', 'txt_url', '50', '150', $url, '', 'onkeypress="ocultarDiv(\'error_url\');"');
        $form->addError('error_url', ERROR_OPCION_URL);

        $niveles = $opcData->getNiveles('1', 'opn_nombre');
        $opciones = null;
        if (isset($niveles)) {
            foreach ($niveles as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(OPCION_NIVEL);
        $form->addSelect('select', 'sel_nivel', 'sel_nivel', $opciones, OPCION_NIVEL, $nivel_opcion, '', 'onChange=submit();');
        $form->addError('error_nivel', ERROR_OPCION_NIVEL);

        $operadores = $opeData->loadOperadores('1', 'ope_nombre');
        $opciones = null;
        if (isset($operadores)) {
            foreach ($operadores as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addEtiqueta(OPERADOR);
        $form->addSelect('select', 'sel_operador', 'sel_operador', $opciones, OPERADOR, $operador, '', 'onChange=submit();');
        $form->addError('error_operador', ERROR_OPERADOR);

        $padres = $opcData->getPadres($nivel_opcion, $operador);
        $opciones = null;
        if (isset($padres) && isset($nivel_opcion) && $nivel_opcion != -1) {
            foreach ($padres as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form->addEtiqueta(OPCION_PADRE);
        $form->addSelect('select', 'sel_padre', 'sel_padre', $opciones, OPCION_PADRE, $padre, '', 'onChange=submit();');
        $form->addError('error_padre', '');

        $form->addEtiqueta(OPCION_ORDEN);
        $form->addInputText('text', 'txt_orden', 'txt_orden', '15', '6', $orden, '', 'onkeypress="ocultarDiv(\'error_orden\');"');
        $form->addError('error_orden', ERROR_OPCION_ORDEN);

        $layouts = $dirApp->getFiles(LAYOUT_PATH, 'php');
        $opciones = null;
        if (isset($layouts) && $nivel_opcion > 0) {
            foreach ($layouts as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $form->addEtiqueta(OPCION_LAYOUT);
        $form->addSelect('select', 'sel_layout', 'sel_layout', $opciones, OPCION_LAYOUT, $layout, '', 'onChange=submit();');
        $form->addError('error_layout', '');


        $form->addInputButton('button', 'ok', 'ok', BTN_ACEPTAR, 'button', 'onclick="validar_edit_opcion();"');
        $form->addInputButton('button', 'cancel', 'cancel', BTN_CANCELAR, 'button', 'onclick="cancelarAccion(\'frm_edit_opcion\',\'?mod=' . $modulo . '&niv=' . $niv . '\');"');

        $form->writeForm();

        break;
    /**
     * la variable saveEdit, permite actualizar el objeto OPCION en la base de datos, ver la clase COpcionData
     */
    case 'saveEdit':
        $id_edit = $_REQUEST['txt_id'];
        $nombre = $_REQUEST['txt_nombre'];
        $variable = $_REQUEST['txt_variable'];
        $url = $_REQUEST['txt_url'];
        $nivel_opcion = $_REQUEST['sel_nivel'];
        $padre = $_REQUEST['sel_padre'];
        $operador = $_REQUEST['sel_operador'];
        if ($padre == '-1')
            $padre = 0;
        $orden = $_REQUEST['txt_orden'];
        $layout = $_REQUEST['sel_layout'];
        if ($layout == '-1')
            $layout = '';
        $opcion = new COpcion($opcData);
        $opcion->setId($id_edit);
        $opcion->setNombre($nombre);
        $opcion->setVariable($variable);
        $opcion->setUrl($url);
        $opcion->setNivel($nivel_opcion);
        $opcion->setPadre($padre);
        $opcion->setOrden($orden);
        $opcion->setLayout($layout);
        $opcion->setOperador($operador);

        $m = $opcion->saveEditOpcion($operador);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=1&task=list");

        break;
    /**
     * la variable see, permite hacer la carga del objeto OPCION para ver sus variables, ver la clase COpcion
     */
    case 'see':
        $id_edit = $_REQUEST['id_element'];
        $opcion = new COpcion($opcData);
        $opcion->setId($id_edit);
        $opcion->loadSeeOpcion();

        $dt = new CHtmlDataTable();
        $titulos = array(OPCION_NOMBRE, OPCION_VARIABLE, OPCION_URL, OPCION_NIVEL, OPERADOR, OPCION_PADRE, OPCION_ORDEN, OPCION_LAYOUT);
        $row_opcion = array($opcion->getNombre(), $opcion->getVariable(), $opcion->getUrl(), $opcion->getNivel(),
            $opcion->getOperador(), $opcion->getPadre(), $opcion->getOrden(), $opcion->getLayout());
        $dt->setDataRows($row_opcion);
        $dt->setTitleRow($titulos);

        $dt->setTitleTable(TABLA_OPCIONES);

        $dt->setType(2);

        $dt->writeDataTable($niv);
        echo $html->generaScriptLink("cancelarAccion('frm_see_opcion','?mod=" . $modulo . "&niv=" . $nivel . "')");

        $form = new CHtmlForm();
        $form->setId('frm_see_opcion');
        $form->setMethod('post');
        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $opcion->getId(), '', '');
        $form->writeForm();

        break;
    /**
     * en caso de que la variable task no este definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');

        break;
}
?>