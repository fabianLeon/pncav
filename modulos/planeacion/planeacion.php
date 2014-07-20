<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
//header('Content-type: application/vnd.ms-excel');
//header("Content-Disposition: attachment; filename=Reporte_planeacion.xls");
// Bloquear acceso por URL
defined('_VALID_PRY') or die('Restricted access');

$operador = OPERADOR_DEFECTO;
$planData = new CPlaneacionData($db);
$task = $_REQUEST['task'];

if (empty($task)) {
    $task = 'list';
}
switch ($task) {
    /**
     * La variable list, permite hacer la carga la página con la lista de 
     * objetos PLANEACION según los parámetros de entrada.
     */
    case 'list':
        //Variables
        //$codigo_eje = $_REQUEST['txt_codigo_eje'];
        $region = $_REQUEST['txt_region'];
        $departamento = $_REQUEST['txt_departamento'];
        $municipio = $_REQUEST['txt_municipio'];
        $eje = $_REQUEST['txt_eje'];
        $criterio = $_REQUEST['txt_criterio'];
        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        $fecha_fin = $_REQUEST['txt_fecha_fin'];
        $usuario = $_REQUEST['txt_usuario'];
        //-------------------------------criterios---------------------------
        $criterio = "";
        if (isset($usuario) && $usuario != -1 && $usuario != '') {
            if ($criterio == "") {
                $criterio = " p.usu_id = " . $usuario;
            } else {
                $criterio .= " and p.usu_id = " . $usuario;
            }
        }
        if (isset($fecha_inicio) && $fecha_inicio != '' && $fecha_inicio != '0000-00-00') {

            if ($criterio == "") {
                $criterio = " (p.pla_fecha_inicio = '" . $fecha_inicio . "')";
            } else {
                $criterio .= " and p.pla_fecha_inicio = '" . $fecha_inicio . "'";
            }
        }

        if (isset($fecha_fin) && $fecha_fin != '' && $fecha_fin != '0000-00-00') {
            if (!isset($fecha_inicio) || $fecha_inicio == '' || $fecha_inicio == '0000-00-00') {
                if ($criterio == "") {
                    $criterio = "( p.pla_fecha_fin = '" . $fecha_fin . "')";
                } else {
                    $criterio .= " and p.pla_fecha_fin = '" . $fecha_fin . "')";
                }
            }
        }/*
        if (isset($codigo_eje) && $codigo_eje != "") {
            if ($criterio == "") {
                $criterio = " (p.pla_codigo_eje LIKE '%" . $codigo_eje . "%')";
            } else {
                $criterio .= " and (p.pla_codigo_eje LIKE '%" . $codigo_eje . "%')";
            }
        }*/
        if (isset($region) && $region != -1 && $region != '') {
            if ($criterio == "") {
                $criterio = " d.der_id = " . $region;
            } else {
                $criterio .= " and d.der_id = " . $region;
            }
        }
        if (isset($departamento) && $departamento != -1 && $departamento != '') {
            if ($criterio == "") {
                $criterio = " d.dep_id = " . $departamento;
            } else {
                $criterio .= " and d.dep_id = " . $departamento;
            }
        }
        if (isset($municipio) && $municipio != -1 && $municipio != '') {
            if ($criterio == "") {
                $criterio = " p.mun_id = " . $municipio;
            } else {
                $criterio .= " and p.mun_id = " . $municipio;
            }
        }
        if (isset($eje) && $eje != -1 && $eje != '') {
            if ($criterio == "") {
                $criterio = " p.eje_id = " . $eje;
            } else {
                $criterio .= " and p.eje_id = " . $eje;
            }
        }
        if ($criterio == "") {
            $criterio = " 1";
        }

        //Inicio Formulario
        $form = new CHtmlForm();
        $form->setTitle(TABLA_PLANEACION);
        $form->setId('frm_list_planeacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        /*
        $form->addEtiqueta(PLANEACION_CODIGO_EJE);
        $form->addInputText('text', 'txt_codigo_eje', 'txt_codigo_eje', 20, 10, $codigo_eje, '', '');
        */
        //Regiones
        $opciones = null;
        $form->addEtiqueta(PLANEACION_REGION);
        $regiones = $planData->getRegiones(' der_nombre');

        if (isset($regiones)) {
            foreach ($regiones as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_region', 'txt_region', $opciones, PLANEACION_REGION, $region, '', 'onChange=submit();');

        //Departamento
        $opciones = null;
        $form->addEtiqueta(PLANEACION_DEPARTAMENTO);
        $departamentos = $planData->getDepartamento($region, ' dep_nombre');
        if (isset($departamentos)) {
            foreach ($departamentos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_departamento', 'txt_departamento', $opciones, PLANEACION_DEPARTAMENTO, $departamento, '', 'onChange=submit();');

        //Municipio
        $form->addEtiqueta(PLANEACION_MUNICIPIO);
        $opciones = null;
        $municipios = $planData->getMunicipio($departamento, ' mun_nombre');
        if (isset($municipios)) {
            foreach ($municipios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_municipio', 'txt_municipio', $opciones, PLANEACION_MUNICIPIO, $municipio, '', 'onChange=submit();');

        //eje
        $form->addEtiqueta(PLANEACION_EJE);
        $opciones = null;
        $ejes = $planData->getEjes(' eje_nombre');
        if (isset($ejes)) {
            foreach ($ejes as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_eje', 'txt_eje', $opciones, PLANEACION_EJE, $eje, '', 'onChange=submit();');

        $form->addEtiqueta(PLANEACION_FECHA_INICIO);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', '');

        $form->addEtiqueta(PLANEACION_FECHA_FIN);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', '');

        $form->addEtiqueta(PLANEACION_USUARIO);
        $opciones = null;
        $usuarios = $planData->getUsuarios('usu_nombre');
        if (isset($usuarios)) {
            foreach ($usuarios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_usuario', 'txt_usuario', $opciones, PLANEACION_USUARIO, $usuario, '', 'onChange=submit();');


        //Botones Formulario
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=consultar_planeacion();');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', PLANEACION_EXPORTAR, 'button', 'onClick=exportar_excel_planeacion();');

        //$form->addInputText('hidden', 'txt_codigo_eje', 'txt_codigo_eje', '', '', $codigo_eje, '', '');
        $form->addInputText('hidden', 'txt_criterio', 'txt_criterio', '5', '5', '', '', '');

        $form->writeForm();
        //Carga filtro de planeaciones
        $planeaciones = $planData->getPlaneacion($criterio, 'pla_id');
        //Inicio Tabla
        $dt = new CHtmlDataTable();
        $titulos = array(PLANEACION_REGION, PLANEACION_DEPARTAMENTO, PLANEACION_MUNICIPIO, PLANEACION_EJE,
            PLANEACION_NUMERO_ENCUESTAS, PLANEACION_TIPO_ENCUESTADO, PLANEACION_FECHA_INICIO, PLANEACION_FECHA_FIN, PLANEACION_USUARIO);
        $dt->setDataRows($planeaciones);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_PLANEACION);

        //OPCIONES DE GESTIÓN
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=delete");
        $dt->setAddLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=add");

        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        //Inicio tabla resumen
        $dtr = new CHtmlDataTable();
        $resumen_planeacion = $planData->getResumen($criterio);
        $titulos_resumen = array(PLANEACION_PVD, PLANEACION_KVD, PLANEACION_IP, PLANEACION_WIFI, PLANEACION_BA,
            PLANEACION_TOTAL_ENCUESTAS);
        $dtr->setDataRows($resumen_planeacion);
        $dtr->setTitleRow($titulos_resumen);
        $dtr->setTitleTable(TABLA_PLANEACION_RESUMEN);

        $dtr->setType(2);
        $dtr->setPag(1, $pag_crit);
        $dtr->writeDataTable($niv);


        break;

    case'add':
        //Variables
        //$codigo_eje = $_REQUEST['txt_codigo_eje'];
        $region = $_REQUEST['txt_region'];
        $departamento = $_REQUEST['txt_departamento'];
        $municipio = $_REQUEST['txt_municipio'];
        $eje = $_REQUEST['txt_eje'];
        $numero_encuestas = $_REQUEST['txt_numero_encuestas'];
        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        $fecha_fin = $_REQUEST['txt_fecha_fin'];
        $usuario = $_REQUEST['txt_usuario'];

        //Inicio Formulario
        $form = new CHtmlForm();
        $form->setTitle(TABLA_PLANEACION);
        $form->setId('frm_add_planeacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        /*
        $form->addEtiqueta(PLANEACION_CODIGO_EJE);
        $form->addInputText('text', 'txt_codigo_eje', 'txt_codigo_eje', 20, 10, $codigo_eje, '', 'onChange="ocultarDiv(\'error_codigo_eje\');"');
        $form->addError('error_codigo_eje', ERROR_PLANEACION_CODIGO_EJE);
        */
        //Regiones 
        $opciones = null;
        $form->addEtiqueta(PLANEACION_REGION);
        $regiones = $planData->getRegiones(' der_nombre');

        if (isset($regiones)) {
            foreach ($regiones as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_region', 'txt_region', $opciones, PLANEACION_REGION, $region, '', 'onChange=submit();');
        $form->addError('error_region', ERROR_PLANEACION_REGION);

        //Departamento
        $opciones = null;
        $form->addEtiqueta(PLANEACION_DEPARTAMENTO);
        $departamentos = $planData->getDepartamento($region, ' dep_nombre');
        if (isset($departamentos)) {
            foreach ($departamentos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_departamento', 'txt_departamento', $opciones, PLANEACION_DEPARTAMENTO, $departamento, '', 'onChange=submit();');
        $form->addError('error_departamento', ERROR_PLANEACION_DEPARTAMENTO);

        //Municipio
        $form->addEtiqueta(PLANEACION_MUNICIPIO);
        $opciones = null;
        $municipios = $planData->getMunicipio($departamento, ' mun_nombre');
        if (isset($municipios)) {
            foreach ($municipios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_municipio', 'txt_municipio', $opciones, PLANEACION_MUNICIPIO, $municipio, '', 'onChange=submit();');
        $form->addError('error_municipio', ERROR_PLANEACION_MUNICIPIO);

        //eje
        $form->addEtiqueta(PLANEACION_EJE);
        $opciones = null;
        $ejes = $planData->getEjes(' eje_nombre');
        if (isset($ejes)) {
            foreach ($ejes as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_eje', 'txt_eje', $opciones, PLANEACION_EJE, $eje, '', 'onChange="ocultarDiv(\'error_eje\');"');
        $form->addError('error_eje', ERROR_PLANEACION_EJE);

        $form->addEtiqueta(PLANEACION_NUMERO_ENCUESTAS);
        $form->addInputText('text', 'txt_numero_encuestas', 'txt_numero_encuestas', 20, 1000, $numero_encuestas, '', 'onChange="ocultarDiv(\'error_numero_encuestas\');"');
        $form->addError('error_numero_encuestas', ERROR_PLANEACION_NUMERO_ENCUESTAS);


        $form->addEtiqueta(PLANEACION_FECHA_INICIO);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_PLANEACION_FECHA);

        $form->addEtiqueta(PLANEACION_FECHA_FIN);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_PLANEACION_FECHA);

        $form->addEtiqueta(PLANEACION_USUARIO);
        $opciones = null;
        $usuarios = $planData->getUsuarios('usu_nombre');
        if (isset($usuarios)) {
            foreach ($usuarios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_usuario', 'txt_usuario', $opciones, PLANEACION_USUARIO, $usuario, '', 'nChange="ocultarDiv(\'error_usuario\');"');
        $form->addError('error_usuario', ERROR_PLANEACION_USUARIO);

        //Botones Formulario
        $form->addInputButton('button', 'btn_add', 'btn_add', BTN_AGREGAR, 'button', 'onClick=validar_add_planeacion();');
        $form->addInputButton('button', 'btn_cancel', 'btn_cancel', BTN_CANCELAR, 'button', 'onClick=cancelarAccion_planeacion(\'frm_add_planeacion\');');
        $form->addInputButton('button', 'btn_carga', 'btn_carga', BTN_CARGA_MASIVA, 'button', 'onClick="ir_a_carga_masiva();"');
        $form->writeForm();

        break;
    /*
     * SaveAdd Almacena la planeacion
     */
    case 'saveAdd':
        //$codigo_eje = $_REQUEST['txt_codigo_eje'];
        $region = $_REQUEST['txt_region'];
        $departamento = $_REQUEST['txt_departamento'];
        $municipio = $_REQUEST['txt_municipio'];
        $eje = $_REQUEST['txt_eje'];
        $numero_encuestas = $_REQUEST['txt_numero_encuestas'];
        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        $fecha_fin = $_REQUEST['txt_fecha_fin'];
        $usuario = $_REQUEST['txt_usuario'];

        $planeacion = new CPlaneacion('', $planData);

        //$planeacion->setCodigo_eje($codigo_eje);
        $planeacion->setMunicipio($municipio);
        $planeacion->setEje($eje);
        $planeacion->setNumero_encuestas($numero_encuestas);
        $planeacion->setFecha_inicio($fecha_inicio);
        $planeacion->setFecha_fin($fecha_fin);
        $planeacion->setUsuario($usuario);

        $mens = $planeacion->savePlaneacion();
        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        $planeacion->createEncuestasAndConsecutive(); 
        break;

    /*
     * Eliminar planeacion
     */

    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        //$codigo_eje = $_REQUEST['txt_codigo_eje'];
        $municipio = $_REQUEST['txt_municipio'];
        $eje = $_REQUEST['txt_eje'];
        $numero_encuestas = $_REQUEST['txt_numero_encuestas'];

        $form = new CHtmlForm();
        $form->setId('frm_delete_planeacion');
        $form->setMethod('post');

        $form->writeForm();
        echo $html->generaAdvertencia(PLANEACION_MSG_BORRADO, '?mod=' . $modulo . '&niv='
                . $niv . '&task=confirmDelete&id_element=' . $id_delete, 'onClick=cancelarAccion_planeacion_carga(\'frm_delete_planeacion\');');

        break;

    /*
     * Confirm Delet
     */

    case 'confirmDelete':
        $id_delete = $_REQUEST['id_element'];
        //$codigo_eje = $_REQUEST['txt_codigo_eje'];

        $planeacion = new CPlaneacion($id_delete, $planData);
        $planeacion->loadPlaneacion();

        //Eliminar encuestas en ejecución.
        $planData->deleteEncuestas($planeacion->getId());

        $mens = $planeacion->deletPlaneacion();
        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");

        break;

    /*
     * Variable edit, para editar valores de una planeacion
     */

    case 'edit':
        $id_edit = $_REQUEST['id_element'];
        $plan = new CPlaneacion($id_edit, $planData);
        $plan->loadPlaneacion();


        //Variables
        //$codigo_eje = $plan->getCodigo_eje();
        if (!isset($_REQUEST['txt_region']) || $_REQUEST['txt_region'] <= 0) {
            $region = $plan->getRegion();
        } else {
            $region = $_REQUEST['txt_region'];
        }
        if (!isset($_REQUEST['txt_departamento']) || $_REQUEST['txt_departamento'] <= 0) {
            $departamento = $plan->getDepartamento();
        } else {
            $departamento = $_REQUEST['txt_departamento'];
        }
        if (!isset($_REQUEST['txt_municipio']) || $_REQUEST['txt_municipio'] <= 0) {
            $municipio = $plan->getMunicipio();
        } else {
            $municipio = $_REQUEST['txt_municipio'];
        }
        if (!isset($_REQUEST['txt_eje']) || $_REQUEST['txt_eje'] <= 0) {
            $eje = $plan->getEje();
        } else {
            $eje = $_REQUEST['txt_eje'];
        }

        $numero_encuestas = $plan->getNumero_encuestas();

        if (!isset($_REQUEST['txt_fecha_inicio']) || $_REQUEST['txt_fecha_inicio'] != '') {
            $fecha_inicio = $plan->getFecha_inicio();
        } else {
            $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        }

        if (!isset($_REQUEST['txt_fecha_fin']) || $_REQUEST['txt_fecha_fin'] != '') {
            $fecha_fin = $plan->getFecha_fin();
        } else {
            $fecha_fin = $_REQUEST['txt_fecha_fin'];
        }

        if (!isset($_REQUEST['txt_usuario']) || $_REQUEST['txt_usuario'] <= 0) {
            $usuario = $plan->getUsuario();
        } else {
            $usuario = $_REQUEST['txt_usuario'];
        }
        //Inicio Formulario
        $form = new CHtmlForm();
        $form->setTitle(TABLA_PLANEACION);
        $form->setId('frm_edit_planeacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        /*
        $form->addEtiqueta(PLANEACION_CODIGO_EJE);
        $form->addInputText('text', 'txt_codigo_eje', 'txt_codigo_eje', 20, 10, $codigo_eje, '', 'onChange="ocultarDiv(\'error_codigo_eje\');"');
        $form->addError('error_codigo_eje', ERROR_PLANEACION_CODIGO_EJE);
        */
        //Regiones
        $opciones = null;
        $form->addEtiqueta(PLANEACION_REGION);
        $regiones = $planData->getRegiones(' der_nombre');

        if (isset($regiones)) {
            foreach ($regiones as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_region', 'txt_region', $opciones, PLANEACION_REGION, $region, '', 'onChange=submit();');
        $form->addError('error_region', ERROR_PLANEACION_REGION);

        //Departamento
        $opciones = null;
        $form->addEtiqueta(PLANEACION_DEPARTAMENTO);
        $departamentos = $planData->getDepartamento($region, ' dep_nombre');
        if (isset($departamentos)) {
            foreach ($departamentos as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_departamento', 'txt_departamento', $opciones, PLANEACION_DEPARTAMENTO, $departamento, '', 'onChange=submit();');
        $form->addError('error_departamento', ERROR_PLANEACION_DEPARTAMENTO);

        //Municipio
        $form->addEtiqueta(PLANEACION_MUNICIPIO);
        $opciones = null;
        $municipios = $planData->getMunicipio($departamento, ' mun_nombre');
        if (isset($municipios)) {
            foreach ($municipios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_municipio', 'txt_municipio', $opciones, PLANEACION_MUNICIPIO, $municipio, '', 'onChange=submit();');
        $form->addError('error_municipio', ERROR_PLANEACION_MUNICIPIO);
        //eje
        $form->addEtiqueta(PLANEACION_EJE);
        $opciones = null;
        $ejes = $planData->getEjes(' eje_nombre');
        if (isset($ejes)) {
            foreach ($ejes as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_eje', 'txt_eje', $opciones, PLANEACION_EJE, $eje, '', 'onChange="ocultarDiv(\'error_eje\');"');
        $form->addError('error_eje', ERROR_PLANEACION_EJE);

        $form->addEtiqueta(PLANEACION_NUMERO_ENCUESTAS);
        $form->addInputText('text', 'txt_numero_encuestas', 'txt_numero_encuestas', 20, 1000, $numero_encuestas, '', 'onChange="ocultarDiv(\'error_numero_encuestas\');"');
        $form->addError('error_numero_encuestas', ERROR_PLANEACION_NUMERO_ENCUESTAS);
        $form->addEtiqueta(PLANEACION_FECHA_INICIO);
        $form->addInputDate('date', 'txt_fecha_inicio', 'txt_fecha_inicio', $fecha_inicio, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_PLANEACION_FECHA);

        $form->addEtiqueta(PLANEACION_FECHA_FIN);
        $form->addInputDate('date', 'txt_fecha_fin', 'txt_fecha_fin', $fecha_fin, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
        $form->addError('error_fecha', ERROR_PLANEACION_FECHA);

        $form->addEtiqueta(PLANEACION_USUARIO);
        $opciones = null;
        $usuarios = $planData->getUsuarios('usu_nombre');
        if (isset($usuarios)) {
            foreach ($usuarios as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_usuario', 'txt_usuario', $opciones, PLANEACION_USUARIO, $usuario, '', 'onChange="ocultarDiv(\'error_usuario\');"');
        $form->addError('error_usuario', ERROR_PLANEACION_USUARIO);
        //Botones Formulario
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=validar_edit_planeacion();');
        $form->addInputButton('button', 'btn_cancelar', 'btn_cancelar', BTN_CANCELAR, 'button', 'onClick=cancelarAccion_planeacion(\'frm_edit_planeacion\');');

        $form->addInputText('hidden', 'txt_id', 'txt_id', '15', '15', $plan->getId(), '', '');


        $form->writeForm();

        break;
    /*
     * Variable saveEdit
     */
    case 'saveEdit':
        $id_edit = $_REQUEST['txt_id'];

        //$codigo_eje = $_REQUEST['txt_codigo_eje'];
        $eje = $_REQUEST['txt_eje'];
        $municipio = $_REQUEST['txt_municipio'];
        $numero_encuestas = $_REQUEST['txt_numero_encuestas'];
        $fecha_inicio = $_REQUEST['txt_fecha_inicio'];
        $fecha_fin = $_REQUEST['txt_fecha_fin'];
        $usuario = $_REQUEST['txt_usuario'];

        $planeacion = new CPlaneacion($id_edit, $planData);

        //$planeacion->setCodigo_eje($codigo_eje);
        $planeacion->setEje($eje);
        $planeacion->setMunicipio($municipio);
        $planeacion->setNumero_encuestas($numero_encuestas);
        $planeacion->setFecha_inicio($fecha_inicio);
        $planeacion->setFecha_fin($fecha_fin);
        $planeacion->setUsuario($usuario);
        $estado = $planeacion->getEstado();

        $planData->deleteEncuestas($planeacion->getId());
        $planeacion->createEncuestasAndConsecutive();

        $m = $planeacion->saveEditPlaneacion($estado);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list");
        break;

    case 'carga':
        //Inicio Formulario
        $form = new CHtmlForm();
        $form->setTitle(PLANEACION);
        $form->setId('frm_carga_planeacion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(PLANEACION_CARGA);
        $form->addInputFile('file', 'file_documento_carga', 'file_documento_carga', 25, 'file', 'onChange="ocultarDiv(\'error_documento_carga\');"');
        $form->addError('error_documento_carga', ERROR_PLANEACION_DOCUMENTO_CARGA);

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=validar_carga_planeacion();');
        $form->addInputButton('button', 'btn_cancelar_carga', 'btn_cancelar_carga', BTN_CANCELAR, 'button', 'onClick=cancelarAccion_planeacion_carga(\'frm_carga_planeacion\');');
        $form->addInputButton('button', 'btn_plantilla', 'btn_plantilla', BTN_PLANTILLA, 'button', 'onClick=exportar_plantilla_planeacion();');
        $form->writeForm();

        break;
    case 'saveCarga':
        $file_carga = $_FILES['file_documento_carga'];
        $plan = new CPlaneacion('', $planData);
        $m = $plan->cargaMasiva($file_carga);
        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=1&operador=1&task=list");

        break;
    /**
     * Cuando la variable task no esta
     * definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');

        break;
}
?>
