<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

defined('_VALID_PRY') or die('Restricted access');
$tipoEncuesta = 0;
$operador = OPERADOR_DEFECTO;
$planData = new CPlaneacionData($db);
$ejeData = new CEjecucionData($db);

$task = $_REQUEST['task'];

if (empty($task)) {
    $task = 'pre-list';
}
switch ($task) {

    case 'pre-list':
        $region = $_REQUEST['txt_region'];
        $departamento = $_REQUEST['txt_departamento'];
        $municipio = $_REQUEST['txt_municipio'];
        $estado = $_REQUEST['txt_estado'];
        $consecutivo_encuesta = $_REQUEST['txt_consecutivo_encuesta'];
        $eje = $_REQUEST['txt_eje'];
        $criterio = $_REQUEST['txt_criterio'];
        //-------------------------------criterios---------------------------
        $criterio = "";

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
        if (isset($estado) && $estado != -1 && $estado != '') {
            if ($criterio == "") {
                $criterio = " p.ees_id = " . $estado;
            } else {
                $criterio .= " and p.ees_id = " . $estado;
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
        $form->setTitle(TABLA_EJECUCION);
        $form->setId('frm_list_ejecucion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

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
        //Estado
        $form->addEtiqueta(EJECUCION_ESTADO);
        $opciones = null;
        $encuesta_estados = $ejeData->getEncuestaEstados();
        if (isset($encuesta_estados)) {
            foreach ($encuesta_estados as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_estado', 'txt_estado', $opciones, EJECUCION_ESTADO, $estado, '', 'onChange=submit();');

        $form->addEtiqueta(PLANEACION_EJE);
        $opciones = null;
        $ejes = $planData->getEjes(' eje_nombre');
        if (isset($ejes)) {
            foreach ($ejes as $t) {
                $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
        $form->addSelect('select', 'txt_eje', 'txt_eje', $opciones, PLANEACION_EJE, $eje, '', 'onChange=submit();');

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onclick="consultar_ejecucion();"');
        $form->addInputButton('button', 'btn_exportar', 'btn_exportar', BTN_EXPORTAR, 'button', 'onclick="exportar_excel_ejecucion();"');


        $form->addInputText('hidden', 'txt_criterio', 'txt_criterio', '5', '5', '', '', '');
        $form->writeForm();

        //Carga filtro de planeaciones
        $planeaciones = $planData->getPlaneacionVerEjecucion($criterio, false);
        $dt = new CHtmlDataTable();
        $titulos = array(PLANEACION_REGION, PLANEACION_DEPARTAMENTO, PLANEACION_MUNICIPIO, PLANEACION_EJE,
            PLANEACION_NUMERO_ENCUESTAS, PLANEACION_TIPO_ENCUESTADO, PLANEACION_FECHA_INICIO, PLANEACION_FECHA_FIN,
            PLANEACION_USUARIO, EJECUCION_ESTADO, EJECUCION_PORCENTAJE);
        $dt->setDataRows($planeaciones);
        $dt->setTitleRow($titulos);
        $dt->setTitleTable(TABLA_PLANEACION);

        //OPCIONES DE GESTIÓN
        $dt->setSeeLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=list&from=prelist");

        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        //Inicio tabla resumen
        //Obtener datos resumen
        $ejecucion_resumen = $ejeData->getResumenEjecucion('1', false, 99);
        $dtr = new CHtmlDataTable();
        $titulos_resumen = array(EJECUCION_N_PVD, EJECUCION_N_KVD, EJECUCION_N_IP, EJECUCION_N_WIFI, EJECUCUION_N_BA, EJECUCION_PORCENTAJE);
        $dtr->setTitleTable(TABLA_RESUMEN_EJECUCION);
        $dtr->setDataRows($ejecucion_resumen);
        $dtr->setTitleRow($titulos_resumen);

        $dtr->setType(2);
        $dtr->setPag(1, $pag_crit);
        $dtr->writeDataTable($niv);
        break;
    /**
     * La variable list, permite hacer la carga la página con la lista de 
     * objetos PLANEACION según los parámetros de entrada.
     */
    case 'list':
        if ($_REQUEST['from'] == 'prelist') {
            $pla_id = $_REQUEST['id_element'];
        }
        if ($pla_id == '') {
            $pla_id = $ejeData->getPla_idByEncuestaId($_REQUEST['id_element']);
        }

        if (isset($pla_id) && $pla_id != "") {
            if ($criterio == "") {
                $criterio = " (enc.pla_id LIKE '%" . $pla_id . "%')";
            } else {
                $criterio .= " and (enc.pla_id LIKE '%" . $pla_id . "%')";
            }
        }

        $form = new CHtmlForm();
        $form->setId('frm_list_ejecucion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');
        $form->setOptions('autoClean', false);
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ATRAS, 'button', 'onclick="volver_pre_list();"');
        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_IMPORTAR, 'button', 'onclick="importar_excel_ejecucion(\'frm_list_ejecucion\',\'' . $pla_id . '\');"');
        $form->writeForm();

        $ejecuciones_tb = $ejeData->getEEncuestas($criterio, false);
        $dt = new CHtmlDataTable();
        $titulos_ejecucion = array(EJECUCION_CONSECUTIVO_ENCUESTA, PLANEACION_EJE, EJECUCION_DOCUMENTO_SOPORTE,
            EJECUCION_FECHA, EJECUCION_CC, EJECUCION_MCI, EJECUCION_RF, EJECUCION_VI, EJECUCION_RI, EJECUCION_MEI,
            PLANEACION_USUARIO, EJECUCION_ESTADO);
        $dt->setDataRows($ejecuciones_tb);
        $dt->setTitleRow($titulos_ejecucion);
        $dt->setTitleTable(TABLA_EJECUCION);

        //OPCIONES DE GESTIÓN
        //Las opciones de gestión corresponden a Agregar, Editar, Borrar, Editar Encuesta y Borrar Encuesta.
        $dt->setDigitalizationLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=add");
        $dt->setEditLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=edit");
        $dt->setDeleteLink("?mod=" . $modulo . "&niv=" . $nivel . "&task=delete");
        $otros = array('link' => "?mod=" . $modulo . "&niv=" . $niv . "&task=addEncuesta", 'img' => 'hcalc.png', 'alt' => ALT_AGREGAR_ENCUESTA);
        $dt->addOtrosLink($otros);
        $otros = array('link' => "?mod=" . $modulo . "&niv=" . $niv . "&task=deleteEncuesta", 'img' => 'delete.png', 'alt' => ALT_AGREGAR_ENCUESTA);
        $dt->addOtrosLink($otros);

        $dt->setType(1);
        $pag_crit = "";
        $dt->setPag(1, $pag_crit);
        $dt->writeDataTable($niv);

        //Inicio tabla resumen
        //Obtener datos resumen
        $ejecucion_resumen = $ejeData->getResumenEjecucion($criterio, false, 75);
        $dtr = new CHtmlDataTable();
        $titulos_resumen = array(EJECUCION_N_PVD, EJECUCION_N_KVD, EJECUCION_N_IP, EJECUCION_N_WIFI, EJECUCUION_N_BA, EJECUCION_PORCENTAJE);
        $dtr->setTitleTable(TABLA_RESUMEN_EJECUCION);
        $dtr->setDataRows($ejecucion_resumen);
        $dtr->setTitleRow($titulos_resumen);

        $dtr->setType(2);
        $dtr->setPag(1, $pag_crit);
        $dtr->writeDataTable($niv);
        break;

    case 'add':
        $id_element = $_REQUEST['id_element'];
        $encuesta = new CEncuesta($id_element, $ejeData);
        $encuesta->loadEncuesta();
        if ($encuesta->getDocumento_soporte() != '') {
            echo $html->generaAviso(ERORR_EJECUCION_ENCUESTA_AGREGADA, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&id_element=" . $id_element);
        } else {
            $form = new CHtmlForm();
            $form->setId('frm_add_ejecucion');
            $form->setMethod('post');
            $form->setClassEtiquetas('td_label');
            //File
            $form->addEtiqueta(EJECUCION_DOCUMENTO_SOPORTE);
            $form->addInputFile('file', 'file_documento_soporte', 'file_documento_soporte', 25, 'file', 'onChange="ocultarDiv(\'error_documento_soporte\');"');
            $form->addError('error_documento_soporte', ERROR_EJECUCION_DOCUMENTO_SOPORTE);
            /*
              $form->addEtiqueta(EJECUCION_FECHA);
              $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
              $form->addError('error_fecha', ERROR_PLANEACION_FECHA);
              //ecc
              $form->addEtiqueta(EJECUCION_CC);
              $opciones = null;
              $resultado = $ejeData->getCuestionarioCompletoOptions();
              if (isset($resultado)) {
              foreach ($resultado as $t) {
              $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
              }
              }

              $form->addSelect('select', 'txt_cc', 'txt_cc', $opciones, EJECUCION_CC, $cc, '', 'onChange="motivo_onchange(\'error_cc\',\'txt_cc\',\'label_3\',\'txt_mci\');"');
              $form->addError('error_cc', ERROR_EJECUCION_CC);

              $form->addEtiqueta(EJECUCION_MCI);
              $form->addInputText('text', 'txt_mci', 'txt_mci', 40, 500, $mci, '', 'onChange="ocultarDiv(\'error_mci\');"');
              $form->addError('error_mci', ERROR_EJECUCION_MCI);
              //ERF
              $form->addEtiqueta(EJECUCION_RF);
              $opciones = null;
              $resultado = $ejeData->getResultadoFinalOptions();
              if (isset($resultado)) {
              foreach ($resultado as $t) {
              $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
              }
              }
              $form->addSelect('select', 'txt_rf', 'txt_rf', $opciones, EJECUCION_RF, $rf, '', 'onChange="ocultarDiv(\'error_rf\');"');
              $form->addError('error_rf', ERROR_EJECUCION_RF);
              //EVI
              $form->addEtiqueta(EJECUCION_VI);
              $opciones = null;
              $resultado = $ejeData->getValidacionInspeccionOptions();
              if (isset($resultado)) {
              foreach ($resultado as $t) {
              $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
              }
              }
              $form->addSelect('select', 'txt_vi', 'txt_vi', $opciones, EJECUCION_VI, $vi, '', 'onChange="ocultarDiv(\'error_vi\');"');
              $form->addError('error_vi', ERROR_EJECUCION_VI);
              //ERI
              $form->addEtiqueta(EJECUCION_RI);
              $opciones = null;
              $resultado = $ejeData->getResultadoInspeccionOptions();
              if (isset($resultado)) {
              foreach ($resultado as $t) {
              $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
              }
              }
              $form->addSelect('select', 'txt_ri', 'txt_ri', $opciones, EJECUCION_RI, $ri, '', 'onChange="motivo_onchange(\'error_ri\',\'txt_ri\',\'label_7\',\'txt_mei\');"');
              $form->addError('error_ri', ERROR_EJECUCION_RI);

              $form->addEtiqueta(EJECUCION_MEI);
              $form->addInputText('text', 'txt_mei', 'txt_mei', 40, 500, $mei, '', 'onChange="ocultarDiv(\'error_mei\');"');
              $form->addError('error_mei', ERROR_EJECUCION_MEI);


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
             */
            //Botones Formulario
            $form->addInputButton('button', 'btn_add', 'btn_add', BTN_AGREGAR, 'button', 'onClick=validar_add_ejecucion(\'&id_element=' . $id_element . '\');');
            $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_CANCELAR, 'button', 'onclick="cancelarAccion_ejecucion(\'frm_add_ejecucion\',\'&id_element=' . $id_element . '\');"');
            $form->writeForm(); /*
              ?>
              <script>
              ocultarDiv("label_3");
              ocultarDiv('txt_mci');
              ocultarDiv('label_7');
              ocultarDiv('txt_mei');
              </script>
              <?php
             */
        }
        break;
    /*
     * Save add
     */
    case 'saveAdd':
        $id_element = $_REQUEST['id_element'];
        $archivo = $_FILES['file_documento_soporte'];
        $fecha = $_REQUEST['txt_fecha'];
        $cc = $_REQUEST['txt_cc'];
        $mci = $_REQUEST['txt_mci'];
        $rf = $_REQUEST['txt_rf'];
        $vi = $_REQUEST['txt_vi'];
        $ri = $_REQUEST['txt_ri'];
        $mei = $_REQUEST['txt_mei'];
        $usuario = $_REQUEST['txt_usuario'];

        $encuesta = new CEncuesta($id_element, $ejeData);
        $encuesta->loadEncuesta();
        //$encuesta->setConsecutivo($cosecutivo);
        $encuesta->setFecha($fecha);
        $encuesta->setCc($cc);
        $encuesta->setMci($mci);
        $encuesta->setRf($rf);
        $encuesta->setVi($vi);
        $encuesta->setRi($ri);
        $encuesta->setMei($mei);
        $encuesta->setUsuario($usuario);
        $encuesta->saveRDM();
        $m = $encuesta->saveEditEncuesta($archivo, '', $encuesta->getId());

        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&id_element=" . $id_element);
        break;
    /**
     * Edit variable
     */
    case 'edit':
        $id_element = $_REQUEST['id_element'];

        $encuesta = new CEncuesta($id_element, $ejeData);
        $encuesta->loadEncuesta();
        $archivo_anterior = $encuesta->getDocumento_soporte();
        $fecha = $encuesta->getFecha();
        $cc = $encuesta->getCc();
        $mci = $encuesta->getMci();
        $rf = $encuesta->getRf();
        $vi = $encuesta->getVi();
        $ri = $encuesta->getRi();
        $mei = $encuesta->getMei();
        $usuario = $encuesta->getUsuario();
        $estado = $encuesta->getEstado();
        if ($archivo_anterior == '') {
            echo $html->generaAviso(ERORR_EJECUCION_ENCUESTA_EDITADA, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&id_element=" . $id_element);
        } else {
            $form = new CHtmlForm();
            $form->setTitle(EJECUCION_EDITAR);
            $form->setId('frm_edit_ejecucion');
            $form->setMethod('post');
            $form->setClassEtiquetas('td_label');

            //File
            $form->addEtiqueta(EJECUCION_DOCUMENTO_SOPORTE);
            $form->addInputFile('file', 'file_documento_soporte', 'file_documento_soporte', 25, 'file', 'onChange="ocultarDiv(\'error_documento_soporte\');"');
            $form->addError('error_documento_soporte', ERROR_EJECUCION_DOCUMENTO_SOPORTE);

            $form->addEtiqueta(EJECUCION_FECHA);
            $form->addInputDate('date', 'txt_fecha', 'txt_fecha', $fecha, '%Y-%m-%d', '16', '16', '', 'onChange="ocultarDiv(\'error_fecha\');"');
            $form->addError('error_fecha', ERROR_PLANEACION_FECHA);
            //ecc
            $form->addEtiqueta(EJECUCION_CC);
            $opciones = null;
            $resultado = $ejeData->getCuestionarioCompletoOptions();
            if (isset($resultado)) {
                foreach ($resultado as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }

            $form->addSelect('select', 'txt_cc', 'txt_cc', $opciones, EJECUCION_CC, $cc, '', 'onChange="motivo_onchange(\'error_cc\',\'txt_cc\',\'label_3\',\'txt_mci\');"');
            $form->addError('error_cc', ERROR_EJECUCION_CC);

            $form->addEtiqueta(EJECUCION_MCI);
            $form->addInputText('text', 'txt_mci', 'txt_mci', 40, 500, $mci, '', 'onChange="ocultarDiv(\'error_mci\');"');
            $form->addError('error_mci', ERROR_EJECUCION_MCI);
            //ERF
            $form->addEtiqueta(EJECUCION_RF);
            $opciones = null;
            $resultado = $ejeData->getResultadoFinalOptions();
            if (isset($resultado)) {
                foreach ($resultado as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addSelect('select', 'txt_rf', 'txt_rf', $opciones, EJECUCION_RF, $rf, '', 'onChange="ocultarDiv(\'error_rf\');"');
            $form->addError('error_rf', ERROR_EJECUCION_RF);
            //EVI
            $form->addEtiqueta(EJECUCION_VI);
            $opciones = null;
            $resultado = $ejeData->getValidacionInspeccionOptions();
            if (isset($resultado)) {
                foreach ($resultado as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addSelect('select', 'txt_vi', 'txt_vi', $opciones, EJECUCION_VI, $vi, '', 'onChange="ocultarDiv(\'error_vi\');"');
            $form->addError('error_vi', ERROR_EJECUCION_VI);
            //ERI
            $form->addEtiqueta(EJECUCION_RI);
            $opciones = null;
            $resultado = $ejeData->getResultadoInspeccionOptions();
            if (isset($resultado)) {
                foreach ($resultado as $t) {
                    $opciones[count($opciones)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                }
            }
            $form->addSelect('select', 'txt_ri', 'txt_ri', $opciones, EJECUCION_RI, $ri, '', 'onChange="motivo_onchange(\'error_ri\',\'txt_ri\',\'label_7\',\'txt_mei\');"');
            $form->addError('error_ri', ERROR_EJECUCION_RI);

            $form->addEtiqueta(EJECUCION_MEI);
            $form->addInputText('text', 'txt_mei', 'txt_mei', 40, 500, $mei, '', 'onChange="ocultarDiv(\'error_mei\');"');
            $form->addError('error_mei', ERROR_EJECUCION_MEI);


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

            $form->addInputText('hidden', 'archivo_anterior', 'archivo_anterior', '', '', $archivo_anterior, '', '');
            //Botones Formulario
            $form->addInputButton('button', 'btn_add', 'btn_add', BTN_ACEPTAR, 'button', 'onClick=validar_edit_ejecucion(\'&id_element=' . $id_element . '\');');
            $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_CANCELAR, 'button', 'onclick="cancelarAccion_ejecucion(\'frm_edit_ejecucion\',\'&id_element=' . $id_element . '\');"');
            $form->writeForm();
            ?>
            <script>
                if (document.getElementById('txt_cc').value === '2') {
                    mostrarDiv('label_3');
                    mostrarDiv('txt_mci');
                } else {
                    ocultarDiv("label_3");
                    ocultarDiv('txt_mci');
                }
                if (document.getElementById('txt_ri').value === '2') {
                    mostrarDiv('label_7');
                    mostrarDiv('txt_mei');
                } else {
                    ocultarDiv('label_7');
                    ocultarDiv('txt_mei');
                }
            </script>
            <?php
        }
        break;

    case 'saveEdit':

        $id_element = $_REQUEST['id_element'];
        $consecutivo = $_REQUEST['txt_consecutivo_encuesta'];
        $archivo = $_FILES['file_documento_soporte'];
        $fecha = $_REQUEST['txt_fecha'];
        $cc = $_REQUEST['txt_cc'];
        $mci = $_REQUEST['txt_mci'];
        $rf = $_REQUEST['txt_rf'];
        $vi = $_REQUEST['txt_vi'];
        $ri = $_REQUEST['txt_ri'];
        $mei = $_REQUEST['txt_mei'];
        $usuario = $_REQUEST['txt_usuario'];
        $estado = $_REQUEST['txt_estado'];
        $archivo_anterior = $_REQUEST['archivo_anterior'];


        $encuesta = new CEncuesta($id_element, $ejeData);
        $encuesta->loadEncuesta();
        $encuesta->setConsecutivo($cosecutivo);
        $encuesta->setDocumento_soporte($archivo);
        $encuesta->setFecha($fecha);
        $encuesta->setCc($cc);
        $encuesta->setMci($mci);
        $encuesta->setRf($rf);
        $encuesta->setVi($vi);
        $encuesta->setRi($ri);
        $encuesta->setMei($mei);
        $encuesta->setUsuario($usuario);
        $encuesta->setEstado($estado);

        $m = $encuesta->saveEditEncuesta($archivo, $archivo_anterior, $id_element);

        echo $html->generaAviso($m, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&id_element=" . $id_element);


        break;

    /*
     * Delete case
     */
    case 'delete':
        $id_delete = $_REQUEST['id_element'];
        $form = new CHtmlForm();
        $form->setId('frm_delet_ejecucion');
        $form->setMethod('post');

        $form->writeForm();
        echo $html->generaAdvertencia(EJECUCION_MSG_BORRADO, '?mod=' . $modulo . '&niv='
                . $niv . '&task=confirmDelete&id_element=' . $id_delete, 'onClick=cancelarAccion_ejecucion(\'frm_delet_ejecucion\',\'&id_element=' . $id_delete . '\');');
        break;
    /*
     * Confirm Delet
     */

    case 'confirmDelete':
        $id_delete = $_REQUEST['id_element'];
        $ejecucion = new CEncuesta($id_delete, $ejeData);
        $ejecucion->loadEncuesta();
        $mens = $ejecucion->deletEncuesta();
        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&id_element=" . $id_delete);
        break;


    //-----------------------------------------------Encuesta----------------------------------------

    /*
     * Variable add
     */
    case 'addEncuesta':
        $id_add = $_REQUEST['id_element'];
        $ejecucion = new CEncuesta($id_add, $ejeData);
        $ejecucion->loadEncuesta();

        if ($ejecucion->getDocumento_soporte() == '') {
            echo $html->generaAviso(ERORR_EJECUCION_ANTESDEAGREGAR, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&id_element=" . $id_add);
        } else {
            $tipoEncuesta = $ejeData->getTipoEncuesta($id_add);
            $form = new CHtmlForm();
            $form->setId('frm_add');
            $form->setMethod('post');
            $form->setClassEtiquetas('td_label');
            $url = "?mod=" . $modulo . "&niv=" . $niv . "&task=encuesta&id_element=" . $id_add . "&tipoEncuesta=" . $tipoEncuesta;
            $form->addInputText('hidden', 'url', 'url', 500, 500, $url, '', '');
            $form->writeForm();
            ?>
            <script>
                salto_automatico("<?php echo $url; ?>", "<?php echo 'frm_add'; ?>");
            </script>
            <?php
        }
        break;


    /*
     * Encuesta, visualiza la encuesta correspondiente a la que se desea digitalizar
     */
    case 'encuesta':
        //Variables
        $tipoEncuesta = $_REQUEST['tipoEncuesta'];
        $id_add = $_REQUEST['id_element'];

        $secciones = $ejeData->getSecciones($tipoEncuesta);
        $html = new CHtml();
        $form = new CHtmlForm();
        $form->crearFormulario('frm_encuesta', 'post', '');
        $tabla = new CHtmlTable();
        $tabla->abrirTabla(0, 0, 0, 'encuesta');
        $preguntas_a_ocultar;
        foreach ($secciones as $s) {
            $preguntas_base = $ejeData->getPreguntasBaseBySeccion($s['id']);
            $tabla->abrirFila();
            $tabla->abrirCelda('100%', 0, 'encuesta_seccion');
            echo '<a href=# >' . $html->traducirTildes($s['numero'] . " " . $s['nombre']) . "</a>";
            //-----------------preguntas base----------------------------------
            $tabla->abrirTabla(0, 0, 0, 'encuesta', "sec_" . $s['id'], "display: none;");
            //preguntas por seccion
            $form->crearTextField('hidden', 'hdd_pre_inicio_' . $s['id'], '', $preguntas_base[0]['id'], '', '', '');
            $form->crearTextField('hidden', 'hdd_pre_fin_' . $s['id'], '', $preguntas_base[count($preguntas_base) - 1]['id'], '', '', '');
            foreach ($preguntas_base as $pb) {
                $tabla->abrirFila();
                $tabla->abrirCelda('15%', 0, 'encuesta_pregunta', 'nowrap', 'prg_' . $pb['id']);
                echo $html->traducirTildes($pb['nombre'] . " " . $pb['texto']) . "<br>";
                echo $html->traducirTildes($pb['descripcion']);
                $tabla->cerrarCelda();
                $tabla->abrirCelda('*', 0, '', 'nowrap', 'res_' . $pb['id']);
                switch ($pb['tipo']) {
                    case 1:
                        $checked = '';
                        if ($ejeData->getRespuestaPreguntaDeEncuesta($pb['id'], $id_add) == '1') {
                            $checked = 'checked';
                        }
                        //Saltos en cambio de respuesta
                        $saltos = $ejeData->arregloSaltarAPregunta($pb['id']);
                        $form->crearTextField('hidden', 'hdd_checked_' . $pb['id'], '', $checked, '', '', '');
                        $form->crearCheck($pb['id'], '1', '', $checked, 'onChange="saltar_pregunta_onChange(\'' . ($pb['id']) . '\',\'' . $saltos . '\',\'' . $pb['tipo'] . '\');"');
                        $form->crearDivError('error_pregunta_' . $pb['id'], ERROR_EJECUCION_CC);

                        //Saltos por respuesta almacenada
                        if ($checked == 'checked') {
                            $respuestaTemp = '1';
                        }
                        $temp = $ejeData->saltarAPregunta($pb['id'], $respuestaTemp);
                        if ($temp > 0 && $temp != '') {
                            if ($pb['id'] < $temp) {

                                for ($i = ($pb['id'] + 1); $i < $temp; $i++) {
                                    $preguntas_a_ocultar[] = $i;
                                }
                            } else {
                                for ($i = ($temp); $i < $pb['id']; $i++) {
                                    $preguntas_a_ocultar[] = $i;
                                }
                            }
                        }
                        $respuestaTemp = '';
                        break;
                    case 2:
                        $value[$pb['id']] = $ejeData->getRespuestaPreguntaDeEncuesta($pb['id'], $id_add);
                        $opciones_temp = null;
                        $opciones_preguntas = $ejeData->getOpcionesPreguntas($pb['id']);
                        if (isset($opciones_preguntas)) {
                            foreach ($opciones_preguntas as $t) {
                                $opciones_temp[count($opciones_temp)] = array('value' => $t['id'], 'texto' => $t['nombre']);
                            }
                        }
                        //Saltos en cambio de respuesta
                        $saltos = $ejeData->arregloSaltarAPregunta($pb['id']);
                        $form->crearSelect($pb['id'], $pb['id'], '', 'onChange="saltar_pregunta_onChange(\'' . ($pb['id']) . '\',\'' . $saltos . '\',\'' . $pb['tipo'] . '\');"', '', $opciones_temp, $value[$pb['id']]);
                        $form->crearDivError('error_pregunta_' . $pb['id'], ERROR_EJECUCION_CC);

                        //Saltos por respuesta almacenada
                        $temp = $ejeData->saltarAPregunta($pb['id'], $value[$pb['id']]);
                        if ($temp > 0 && $temp != '') {
                            for ($i = ($pb['id'] + 1); $i < $temp; $i++) {
                                $preguntas_a_ocultar[] = $i;
                            }
                        }
                        break;
                    //Multiple_Respuesta
                    case 3:
                        $respuestaMxM = explode('/', $ejeData->getRespuestaPreguntaDeEncuesta($pb['id'], $id_add));
                        $saltos = $ejeData->arregloSaltarAPregunta($pb['id']);
                        $opciones_temp = null;
                        $opciones_preguntas = $ejeData->getOpcionesPreguntas($pb['id']);
                        if (isset($opciones_preguntas)) {
                            $form->crearTextField('hidden', $pb['id'], '', 'PGR-Padre', '', '', $events);
                            $form->crearDivError('error_pregunta_' . $pb['id'], ERROR_EJECUCION_CC);
                            $cont_temp = 1;
                            while ($cont_temp <= count($opciones_preguntas)) {
                                $checked = '';
                                if ($opciones_preguntas[$cont_temp - 1]['id'] == $respuestaMxM[$cont_temp - 1]) {
                                    $checked = 'checked';
                                }
                                $form->crearTextField('hidden', 'hdd_checked_' . $pb['id'] . '_' . $opciones_preguntas[$cont_temp - 1]['id'], '', $checked, '', '', '');
                                $form->crearCheck($pb['id'] . '_' . $opciones_preguntas[$cont_temp - 1]['id'], $opciones_preguntas[$cont_temp - 1]['id'], $opciones_preguntas[$cont_temp - 1]['nombre'], $checked, 'onChange="saltar_pregunta_onChange(\'' . ($pb['id'] . '_' . $opciones_preguntas[$cont_temp - 1]['id']) . '\',\'' . $saltos . '\',\'' . $pb['tipo'] . '\');"');
                                $form->crearDivError('error_pregunta_' . $pb['id'] . '_' . $opciones_preguntas[$cont_temp - 1]['id'], ERROR_EJECUCION_CC);
                                $cont_temp++;

                                //Saltos por respuesta almacenada
                                if ($checked == 'checked') {
                                    $respuestaTemp = $opciones_preguntas[$cont_temp - 1]['id'];
                                }
                                $temp = $ejeData->saltarAPregunta($pb['id'], $respuestaTemp);
                                if ($temp > 0 && $temp != '') {
                                    if ($pb['id'] < $temp) {
                                        for ($i = ($pb['id'] + 1); $i < $temp; $i++) {
                                            $preguntas_a_ocultar[] = $i;
                                        }
                                    } else {
                                        for ($i = ($temp); $i < $pb['id']; $i++) {
                                            $preguntas_a_ocultar[] = $i;
                                        }
                                    }
                                }
                                $respuestaTemp = '';
                            }
                        }

                        break;
                    case 4:
                        $value[$pb['id']] = $ejeData->getRespuestaPreguntaDeEncuesta($pb['id'], $id_add);
                        $saltos = $ejeData->arregloSaltarAPregunta($pb['id']);
                        $form->crearTextArea($pb['id'], $value[$pb['id']], 100, 2, 'onChange="saltar_pregunta_onChange(\'' . ($pb['id']) . '\',\'' . $saltos . '\',\'' . $pb['tipo'] . '\');"');
                        $form->crearDivError('error_pregunta_' . $pb['id'], ERROR_EJECUCION_CC);
                        break;
                    case 5:
                        $value[$pb['id']] = $ejeData->getRespuestaPreguntaDeEncuesta($pb['id'], $id_add);
                        $saltos = $ejeData->arregloSaltarAPregunta($pb['id']);
                        $form->crearTextField('text', $pb['id'], 40, ($value[$pb['id']]), 40, '', 'onChange="saltar_pregunta_onChange(\'' . ($pb['id']) . '\',\'' . $saltos . '\',\'' . $pb['tipo'] . '\');"');
                        $form->crearDivError('error_pregunta_' . $pb['id'], ERROR_EJECUCION_CC);
                        //Saltos por respuesta almacenada
                        if ($value[$pb['id']] != '') {
                            $respuestaTemp = '0';
                        }
                        $temp = $ejeData->saltarAPregunta($pb['id'], $respuestaTemp);
                        if ($temp > 0 && $temp != '') {
                            for ($i = ($pb['id'] + 1); $i < $temp; $i++) {
                                $preguntas_a_ocultar[] = $i;
                            }
                        }
                        $respuestaTemp = '';
                        break;
                    case 6:
                        $form->crearTextField('hidden', $pb['id'], '', 'PGR-Padre', '', '', $events);
                        break;
                    case 7:
                        $value[$pb['id']] = $ejeData->getRespuestaPreguntaDeEncuesta($pb['id'], $id_add);
                        $form->crearDateField($pb['id'], 15, $value[$pb['id']], '%Y-%m-%d', 15, '', '');
                        $form->crearDivError('error_pregunta_' . $pb['id'], ERROR_EJECUCION_CC);
                        break;
                    case 8:
                        $value[$pb['id']] = $ejeData->getRespuestaPreguntaDeEncuesta($pb['id'], $id_add);
                        echo $html->traducirTildes($value[$pb['id']]);
                        $form->crearTextField('hidden', $pb['id'], '', $value[$pb['id']], '', '', $events);
                        break;
                }
                $tabla->cerrarCelda();
                $tabla->cerrarFila();
            }

            $tabla->cerrarTabla();
            //-----------------------------------------------------------------
            $tabla->cerrarCelda();
            $tabla->cerrarFila();
        }

        $tabla->cerrarTabla();
        $tabla->abrirTabla(0, 0, 0, 'botones');
        $tabla->abrirFila();
        $tabla->abrirCelda('25%', 0, 'botones_adelante');
        $form->crearBoton('button', 'btn_adelante', BTN_ADELANTE, 'onclick="save_seccion(\'' . $id_add . '&tipoEncuesta=' . $tipoEncuesta . '\');"');
        $tabla->cerrarCelda();
        $tabla->abrirCelda('25%', 0, 'botones_atras');
        $form->crearBoton('button', 'btn_atras', BTN_ATRAS, 'onclick="devolver_seccion();"');
        $tabla->cerrarCelda();
        $tabla->abrirCelda('25%', 0, 'botones_aceptar');
        $form->crearBoton('button', 'btn_aceptar', BTN_ACEPTAR, 'onclick="save_seccion(\'' . $id_add . '&fin=fin&tipoEncuesta=' . $tipoEncuesta . '\');"');
        $tabla->cerrarCelda();
        $tabla->abrirCelda('25%', 0, 'botones_cancelar');
        $form->crearBoton('button', 'btn_cancelar', BTN_CANCELAR, 'onclick=cancelarAccion_ejecucion(\'frm_encuesta\',\'&id_element=' . $id_add . '\');');
        $tabla->cerrarCelda();

        $tabla->cerrarFila();
        $tabla->cerrarTabla();
        $seccion_actual = $_REQUEST['hdd_seccion'];

        if ($seccion_actual == '') {
            $seccion_actual = $secciones[0]['id'];
        }

        $form->crearTextField('hidden', 'hdd_seccion_atras', '', $seccion_atras, '', '', '');
        $form->crearTextField('hidden', 'hdd_seccion', '', $seccion_actual, '', '', '');
        $form->crearTextField('hidden', 'hdd_inicio', '', $secciones[0]['id'], '', '', '');
        $form->crearTextField('hidden', 'hdd_fin', '', $secciones[count($secciones) - 1]['id'], '', '', '');
        $form->cerrarFormulario();
        //evitar enviar nulos la primera vez
        if (count($preguntas_a_ocultar) > 0) {
            $preguntas_a_ocultar = implode('/', $preguntas_a_ocultar);
        }
        ?>
        <script>
            cambiarVisibilidad();
            ocultar_preguntas('<?php echo $preguntas_a_ocultar; ?>');
            validar_saltar_automatico('<?php echo $id_add; ?>');
        </script>
        <?php
        break;

    /*
     * 
     * Almacenar respuestas de la encuesta
     */
    case 'saveEncuesta':
        $id_add = $_REQUEST['id_element'];
        $tipoEncuesta = $_REQUEST['tipoEncuesta'];
        $secciones = $ejeData->getSecciones($tipoEncuesta);
        $cont = 0;
        foreach ($secciones as $s) {
            $preguntas_base = $ejeData->getPreguntasBaseBySeccion($s['id']);
            foreach ($preguntas_base as $pb) {

                switch ($pb['tipo']) {
                    case 3:
                        $contRespuestasMxM = $ejeData->getOpcionesPreguntas($pb['id']);
                        $temp = 0;
                        while ($temp < count($contRespuestasMxM)) {
                            //guardar respuestas seleccionadas
                            $respuesta = $respuesta . $_REQUEST[($pb['id'] . '_' . $contRespuestasMxM[$temp]['id'])] . '/';
                            $temp++;
                        }
                        $repuestas[$cont]['id'] = $pb['id'];
                        $repuestas[$cont]['respuesta'] = $respuesta;

                        break;
                    default :
                        $repuestas[$cont]['id'] = $pb['id'];
                        $repuestas[$cont]['respuesta'] = $_REQUEST[$pb['id']];
                        break;
                }
                $cont++;
            }
        }

        $form = new CHtmlForm();
        $form->crearFormulario('frm_encuestas', 'post', '');
        $form->crearTextField('hidden', 'hdd_seccion', '', $_REQUEST['hdd_seccion'], '', '', '');
        $form->crearTextField('hidden', 'hdd_inicio', '', $_REQUEST['hdd_inicio'], '', '', '');
        $form->crearTextField('hidden', 'hdd_fin', '', $_REQUEST['hdd_fin'], '', '', '');
        $form->cerrarFormulario();
        $ejecucion = new CEncuesta($id_add, $ejeData);
        $ejecucion->saveRespuestasEncuesta($repuestas);

        if ($_REQUEST['fin'] == 'fin') {

            echo $html->generaAviso(EJECUCION_MNS_AGREGACION, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&id_element=" . $id_add);
            //Cambiar estado al finalizar la encuesta
            $ejeData->setEstadoEncuesta($id_add, '1');
        } else {
            ?>
            <script>
                saltar_seccion('<?php echo $id_add . '&tipoEncuesta=' . $tipoEncuesta; ?>');
            </script>
            <?php
        }

        break;
    /*
     * Delete case
     */
    case 'deleteEncuesta':
        $id_delete = $_REQUEST['id_element'];
        $form = new CHtmlForm();
        $form->setId('frm_delet_ejecucion');
        $form->setMethod('post');

        $form->writeForm();
        echo $html->generaAdvertencia(EJECUCION_MSG_BORRADO_DATOS, '?mod=' . $modulo . '&niv='
                . $niv . '&task=confirmDeleteEncuesta&id_element=' . $id_delete, 'onClick=cancelarAccion_ejecucion(\'frm_delet_ejecucion\',\'&id_element=' . $id_delete . '\');');
        break;
    /*
     * Confirm Delet
     */

    case 'confirmDeleteEncuesta':
        $id_delete = $_REQUEST['id_element'];
        $ejecucion = new CEncuesta($id_delete, $ejeData);
        $ejecucion->loadEncuesta();
        $ejeData->setEstadoEncuesta($id_delete, '2');
        $mens = $ejecucion->deletEncuestaRespuestas();
        $ejecucion->saveRDM();
        echo $html->generaAviso($mens, "?mod=" . $modulo . "&niv=" . $niv . "&task=list&id_element=" . $id_delete);
        break;
    /*
     * Carga Masiva
     */
    case 'carga':
        $id_element = $_REQUEST['id_element'];
        //Inicio Formulario
        $form = new CHtmlForm();
        $form->setTitle(PLANEACION);
        $form->setId('frm_carga_ejecucion');
        $form->setMethod('post');
        $form->setClassEtiquetas('td_label');

        $form->addEtiqueta(PLANEACION_CARGA);
        $form->addInputFile('file', 'file_documento_carga', 'file_documento_carga', 25, 'file', 'onChange="ocultarDiv(\'error_documento_carga\');"');
        $form->addError('error_documento_carga', ERROR_PLANEACION_DOCUMENTO_CARGA);

        $form->addInputButton('button', 'btn_consultar', 'btn_consultar', BTN_ACEPTAR, 'button', 'onClick=validar_carga_ejecucion(\'' . $id_element . '\');');
        $form->addInputButton('button', 'btn_cancelar_carga', 'btn_cancelar_carga', BTN_CANCELAR, 'button', 'onClick=cancelarAccion_ejecucion(\'frm_carga_ejecucion\',\'&from=prelist&id_element=' . $id_element . '\');');
        $form->addInputButton('button', 'btn_plantilla', 'btn_plantilla', BTN_PLANTILLA, 'button', 'onClick=exportar_plantilla_ejecucion();');
        $form->writeForm();

        break;
    case 'saveCarga':
        $id_element = $_REQUEST['id_element'];
        $file_carga = $_FILES['file_documento_carga'];
        $ejecucion = new CEncuesta('', $ejeData);
        $m = $ejecucion->cargaMasiva($file_carga);
        echo $html->generaAviso($m, "?mod=ejecucion&niv=1&operador=1&task=list&from=prelist&id_element=" . $id_element . "");
        break;


    /*
     * definida carga la página en construcción
     */
    default:
        include('templates/html/under.html');
        break;
}
?>