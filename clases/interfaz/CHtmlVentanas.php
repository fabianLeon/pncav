<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CHtmlVentanas
 *
 * @author Personal
 */
class CHtmlVentanas {

    var $html;

    // crearestidoFadein se encarga de crear el estilo de la ventada fadein
    function crearestidoFadein($nombre) {

        $this->html = new CHtml('');
        ?> <style>
            #popup<?php echo $nombre ?> {
                left: 0;
                position: absolute;
                top: 0;
                width: 100%;
                z-index: 1001;
            }

            .content-popup {
                margin:10px auto;
                margin-top:120px;
                position:relative;
                padding:10px;
                width:900px;
                min-height:150px;
                border-radius:10px;
                background-color:#D8D8D8;
                box-shadow: 0 2px 5px #DF0101;
            }

            .content-popup h2 {
                color:#48484B;
                border-bottom: 5px solid #48484B;
                margin-top: 6;
                padding-bottom: 4px;
            }

            .popup-<?php echo $nombre ?> {
                left: 0;
                position: absolute;
                top: 0;
                width: 100%;
                z-index: 999;
                display:none;
                background-color: #FFFFFF;
                cursor: pointer;
                opacity: 0;
            }

            .close {
                position: absolute;
                right: 15px;
            }
        </style>
        <script type = "text/javascript" src = "jquery.js"></script>
        <?php
    }

//createFadeIn se encarga de crear a traves del jquery la funcion que genera el fadein
    function createFadeIn($nombre, $task) {
        ?>
        <script type="text/javascript">
            $(document).ready(function() {
                $('#open<?php echo $nombre ?>').click(function() {
                    $('#popup<?php echo $nombre ?>').fadeIn('slow');
                    $('.popup-<?php echo $nombre ?>').fadeIn('slow');
                    $('.popup-<?php echo $nombre ?>').height($(window).height());
                    return false;
                });

                $('#close<?php echo $nombre ?>').click(function() {
                    $('#popup<?php echo $nombre ?>').fadeOut('slow');
                    $('.popup-<?php echo $nombre ?>').fadeOut('slow');
                    return false;
                });
            });
        </script>

        <?php
        switch ($nombre) {
            case 'actividad':
                $db = new CData(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $db->conectar();
                $docData = new COrdenesdepagoData($db);
                $tiposActividades = $docData->ObtenerTiposActividades();
                $opcionestipoactividades = null;
                if (isset($tiposActividades)) {
                    foreach ($tiposActividades as $t) {
                        $opcionestipoactividades[count($opcionestipoactividades)] = array('value' => $t['idactividadestipo'], 'texto' => $t['nombreactividadestipo']);
                    }
                }
                ?>

                <div id="popup<?php echo $nombre ?>" style="display: none;">
                    <div class="content-popup">
                        <div class="close"><a href="#" id="closeactividad"  ><img src="templates/img/close.png"/></a></div>

                        <form id="form_agregar_actividad_ordendepago" method="post">
                            <table width="80%" align="center" border="0" cellpadding="0" cellspacing="1" class="formtable">
                                <tr><td colspan="3" class="titleform">Agregar Actividad</td></tr>
                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        Tipo de actividad 
                                    </td>
                                    <td width="40%">
                                        <select id="Tipo_actividad" 
                                                name="Tipo_actividad" 
                                                class=""

                                                >
                                            <option value="-1">Seleccione  Tipo de actividad</option>
                                            <?php foreach ($opcionestipoactividades as $s) { ?>
                                            <option value='<?php echo $s['value'] ?>'><?php echo $s['texto'] ?></option>
                                            <?php }
                                            ?>
                                        </select>
                                    </td>
                                    <td width="40%">
                                        <div id="error_tipo" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            Seleccione un Tipo de Actividad                </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        Ingrese la Descripcion de la Actividad 
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="Descrip_actividad" 
                                               name="Descrip_actividad" 
                                               size="100"
                                               value="" 
                                               maxlength="100" 
                                               class=""
                                               onkeypress="ocultarDiv('error_descripcion');" 
                                               />
                                    </td>
                                    <td width="40%">
                                        <div id="error_descripcion" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            Escriba una descripcion correcta                </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        Ingrese el Monto de la Actividad 
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="Monto_actividad" 
                                               name="Monto_actividad" 
                                               size="30"
                                               value="" 
                                               maxlength="30" 
                                               class=""
                                               onkeypress="ocultarDiv('error_monto');" 
                                               />
                                    </td>
                                    <td width="40%">
                                        <div id="error_monto" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            Ingrese un monto correcto                </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="td_right">
                                        <input type="button" 
                                               id="ok" 
                                               name="ok" 
                                               value="Insertar" 
                                               class="button"
                                               onclick="validar_agregar_actividad_remota(<?php echo"'" . $task . "'" ?>);" 
                                               />
                                        <input type="button" 
                                               id="clear_button" 
                                               name="clear_button" 
                                               value="Limpiar" 
                                               class="button"
                                               onClick=limpiarFormulario('form_agregar_actividad_ordendepago');
                                               />
                                    </td>
                                </tr>
                            </table>

                        </form>

                    </div>
                </div>
                <div class="popup-<?php echo $nombre ?>"></div>
                <?php
                break;
            case 'familia':
                ?>

                <div id="popup<?php echo $nombre ?>" style="display: none;">
                    <div class="content-popup">
                        <div class="close"><a href="#" id="closefamilia"  ><img src="templates/img/close.png"/></a></div>

                        <form id="form_agregar_familia_ordendepago" method="post">
                            <table width="80%" align="center" border="0" cellpadding="0" cellspacing="1" class="formtable">
                                <tr><td colspan="3" class="titleform">Agregar Familia</td></tr>
                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        Descripcion de la Familia 
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_descripcion" 
                                               name="txt_descripcion" 
                                               size="20"
                                               value="" 
                                               maxlength="20" 
                                               class=""
                                               onkeypress="ocultarDiv('error_descripcion_familia');" 
                                               />
                                    </td>
                                    <td width="40%">
                                        <div id="error_descripcion_familia" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            Ingrese una descripcion correcta                </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="td_right">
                                        <input type="button" 
                                               id="ok" 
                                               name="ok" 
                                               value="Insertar" 
                                               class="button"
                                               onclick="validar_agregar_familia_remota(<?php echo"'" . $task . "'" ?>);" 
                                               />

                                        <input type="button" 
                                               id="clear_button" 
                                               name="clear_button" 
                                               value="Limpiar" 
                                               class="button"
                                               onClick=limpiarFormulario('form_agregar_familia_ordendepago') 
                                               />
                                    </td>
                                </tr>
                            </table>

                        </form>

                    </div>
                </div>
                <div class="popup-<?php echo $nombre ?>"></div>


                <?php
                break;
            case 'moneda':
                ?>
                <div id="popup<?php echo $nombre ?>" style="display: none;">
                    <div class="content-popup">
                        <div class="close"><a href="#" id="closemoneda"  ><img src="templates/img/close.png"/></a></div>

                        <form id="form_agregar_moneda_ordendepago" method="post">
                            <table width="80%" align="center" border="0" cellpadding="0" cellspacing="1" class="formtable">
                                <tr><td colspan="3" class="titleform">Agregar Moneda</td></tr>
                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        Descripcion de la Moneda 
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_descripcion" 
                                               name="txt_descripcion_moneda" 
                                               size="20"
                                               value="" 
                                               maxlength="20" 
                                               class=""
                                               onkeypress="ocultarDiv('error_descripcion_moneda');" 
                                               />
                                    </td>
                                    <td width="40%">
                                        <div id="error_descripcion_moneda" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            Ingrese una descripcion correcta                </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="td_right">
                                        <input type="button" 
                                               id="ok" 
                                               name="ok" 
                                               value="Insertar" 
                                               class="button"
                                               onclick="validar_agregar_moneda_remota(<?php echo"'" . $task . "'" ?>);" 
                                               />

                                        <input type="button" 
                                               id="clear_button" 
                                               name="clear_button" 
                                               value="Limpiar" 
                                               class="button"
                                               onClick=limpiarFormulario('form_agregar_moneda_ordendepago') 
                                               />
                                    </td>
                                </tr>
                            </table>
                        </form>

                    </div>
                </div>
                <div class="popup-<?php echo $nombre ?>"></div>


                <?php
                break;
            case 'proveedor':
                
                $db = new CData(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $db->conectar();
                $basepaises = new CProveedorData($db);
                $paises = $basepaises->ObtenerPaises();
              
                
        $opcionespais = null;
        if (isset($paises)) {
            foreach ($paises as $t) {
                $opcionespais[count($opcionespais)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }

        $ciudades = $basepaises->ObtenerCiudadesFadein();
        $opcionesciudades = null;
        if (isset($ciudades)) {
            foreach ($ciudades as $t) {
                $opcionesciudades[count($opcionesciudades)] = array('value' => $t['id'], 'texto' => $t['nombre']);
            }
        }
                
                ?>
                <div id="popup<?php echo $nombre ?>" style="display: none;">
                    <div class="content-popup">
                        <div class="close"><a href="#" id="close<?php echo $nombre ?>"  ><img src="templates/img/close.png"/></a></div>

                        <form id="frm_agregar_proveedor_remoto" method="post" enctype="">

                            <table width="80%" align="center" border="0" cellpadding="0" cellspacing="1" class="formtable">
                                <tr><td colspan="3" class="titleform">Agregar Proveedores</td></tr>
                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_0">   
                                            Nit 
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_nit_proveedor" 
                                               name="txt_nit_proveedor" 
                                               size="11"
                                               value="" 
                                               maxlength="11" 
                                               class=""
                                               onkeypress="ocultarDiv('error_nit');" 
                                               />


                                    </td>
                                    <td width="40%">
                                        <div id="error_nit" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Verifique que este ingresando un nit correcto                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_1">   
                                            Nombre del Proveedor 
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_nombre_proveedor" 
                                               name="txt_nombre_proveedor" 
                                               size="50"
                                               value="" 
                                               maxlength="50" 
                                               class=""
                                               onkeypress="ocultarDiv('error_nombre');" 
                                               />


                                    </td>
                                    <td width="40%">
                                        <div id="error_nombre" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Debe ingresar el nombre del proveedor                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_2">   
                                            Telefono del Proveedor 
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_telefono_proveedor" 
                                               name="txt_telefono_proveedor" 
                                               size="12"
                                               value="" 
                                               maxlength="12" 
                                               class=""
                                               onkeypress="ocultarDiv('error_telefono');" 
                                               />


                                    </td>
                                    <td width="40%">
                                        <div id="error_telefono" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Verifique que este ingresando un telefono correcto                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_3">   
                                            Pais del Proveedor 
                                        </label>
                                    </td>
                                    <td width="40%">

                                        <select id="sel_pais_proveedor" 
                                                name="sel_pais_proveedor" 
                                                class=""
                                            
                                                >
                                            <option value="-1">Seleccione  Seleccione</option>
                                           <?php foreach ($opcionespais as $s) { ?> 
                                                <option value="<?php echo $s['value'] ?>"><?php echo $s['texto'] ?></option>

                                            <?php }
                                            ?>
                                        </select>

                                    </td>
                                    <td width="40%">
                                        <div id="error_pais" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Debe ingresar un pais                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_4">   
                                            Ciudad del Proveedor 
                                        </label>
                                    </td>
                                    <td width="40%">

                                        <select id="sel_ciudad_proveedor" 
                                                name="sel_ciudad_proveedor" 
                                                class=""
                                               
                                                >
                                            <option value="-1">Seleccione  Seleccione</option>
                                            <?php foreach ($opcionesciudades as $s) { ?> 
                                                <option value="<?php echo $s['value'] ?>"><?php echo $s['texto'] ?></option>

                                            <?php }
                                            ?>
                                        </select>

                                    </td>
                                    <td width="40%">
                                        <div id="error_cuidad" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Debe ingresar una ciudad                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_5">   
                                            Direccion del Proveedor 
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_direccion_proveedor" 
                                               name="txt_direccion_proveedor" 
                                               size="40"
                                               value="" 
                                               maxlength="40" 
                                               class=""
                                               onkeypress="ocultarDiv('error_direccion');" 
                                               />


                                    </td>
                                    <td width="40%">
                                        <div id="error_direccion" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Debe ingresar una direccion                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_6">   
                                            Nombre del Contacto 
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_nombre_contac_proveedor" 
                                               name="txt_nombre_contac_proveedor" 
                                               size="30"
                                               value="" 
                                               maxlength="30" 
                                               class=""
                                               onkeypress="ocultarDiv('error_contacprove');" 
                                               />


                                    </td>
                                    <td width="40%">
                                        <div id="error_contacprove" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Debe ingresar el nombre del contacto                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_7">   
                                            Primer Apellido del Contacto  
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_ApA_contac_proveedor" 
                                               name="txt_ApA_contac_proveedor" 
                                               size="30"
                                               value="" 
                                               maxlength="30" 
                                               class=""
                                               onkeypress="ocultarDiv('error_contacprove_apellido');" 
                                               />


                                    </td>
                                    <td width="40%">
                                        <div id="error_contacprove_apellido" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Debe ingresar por lo menos el primer apellido del contacto                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_8">   
                                            Segundo Apellido del Contacto  
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_ApB_contac_proveedor" 
                                               name="txt_ApB_contac_proveedor" 
                                               size="30"
                                               value="" 
                                               maxlength="30" 
                                               class=""

                                               />


                                    </td>
                                    <td width="40%">
                                        <div id="error_oculto" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_9">   
                                            Telefono de  Contacto  
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_tel_contac_proveedor" 
                                               name="txt_tel_contac_proveedor" 
                                               size="12"
                                               value="" 
                                               maxlength="12" 
                                               class=""
                                               onkeypress="ocultarDiv('error_telcontac');" 
                                               />


                                    </td>
                                    <td width="40%">
                                        <div id="error_telcontac" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Verifique que este ingresando un telefono de contacto correcto                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td width="20%" class="td_label" nowrap valign='top'>
                                        <label id="label_10">   
                                            Email Proveedor y/o contacto 
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <input type="text" 
                                               id="txt_emal_proveedor" 
                                               name="txt_emal_proveedor" 
                                               size="50"
                                               value="" 
                                               maxlength="50" 
                                               class=""
                                               onkeypress="ocultarDiv('error_email');" 
                                               />


                                    </td>
                                    <td width="40%">
                                        <div id="error_email" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                            **Debe ingresar un  email correcto                                    </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="3" class="td_right">
                                        <input type="button" 
                                               id="ok" 
                                               name="ok" 
                                               value="Insertar" 
                                               class="button"
                                               onclick="validar_agregar_proveedor_remoto(<?php echo"'" . $task . "'" ?>);" 
                                               />
                                        
                                        <input type="button" 
                                               id="clear_button" 
                                               name="clear_button" 
                                               value="Limpiar" 
                                               class="button"
                                               onClick=limpiarFormulario('frm_agregar_proveedor_remoto') 
                                               />
                                    </td>
                                </tr>
                            </table>
                        </form>

                    </div>
                </div>
                <div class="popup-<?php echo $nombre ?>"></div>


                <?php
                break;

            case 'producto':
                $db = new CData(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
                $db->conectar();
                $baseFamilia = new COrdenesdepagoData($db);
                $familias = $baseFamilia->ObtenerFamilias();
                $opcionesfamilias = null;
                if (isset($familias)) {
                    foreach ($familias as $t) {
                        $opcionesfamilias [count($opcionesfamilias)] = array('value' => $t['idfamilia'], 'texto' => $t['nombrefamilia']);
                    }
                }
                ?>
                <script>
                    function addRow(idTable) {
                        tbody = document.getElementById(idTable);
                        lastPosition = tbody.rows.length;
                        row = tbody.insertRow(lastPosition);
                        for (i = 0; i < 6; i++) {
                            cell = row.insertCell(i);
                            switch (i) {
                                case 0:
                                    cell.innerHTML = "<select id='" + lastPosition + "" + i
                                            + "' onchange=selectChange(" + lastPosition + "" + i + ","
                                            + lastPosition + "" + (i + 3) + ")>"
                                            + "<option value='-1'>Seleccione un tipo</option>"
                                            + "<option value='1'>Bien</option>"
                                            + "<option value='2'>Servicio</option>"
                                            + "</select>";
                                    break;

                                case 1:
                                    cell.innerHTML = "<select id='" + lastPosition + "" + i + "'>"
                                            + "<option value='-1'>Seleccione una familia</option>"

                <?php foreach ($opcionesfamilias as $s) { ?>
                                        + "<option value='<?php echo $s['value'] ?>'><?php echo $s['texto'] ?></option>"

                <?php }
                ?>
                                    + "</select>";
                                    break;

                                case 2:
                                    cell.innerHTML = "<input id='" + lastPosition + "" + i
                                            + "' type='text'>";
                                    break;

                                case 3:
                                    cell.innerHTML = "<input id='" + lastPosition + "" + i
                                            + "' type='text'>";
                                    break;

                                case 4:
                                    cell.innerHTML = "<input id='" + lastPosition + "" + i
                                            + "' type='text'>";
                                    break;

                                case 5:
                                    cell.innerHTML = "<div id='" + lastPosition + "" + i
                                            + "'></div>";
                                    break;
                            }
                        }
                    }

                    function deleteRow(idTable) {
                        document.getElementById(idTable).deleteRow(-1);
                    }

                    function selectChange(idSelect, idNumber) {
                        selection = document.getElementById(idSelect).value;
                        if (selection === '1') {
                            document.getElementById(idNumber).value = "";
                            document.getElementById(idNumber).disabled = false;
                        }
                        if (selection === '2') {
                            document.getElementById(idNumber).value = 1;
                            document.getElementById(idNumber).disabled = true;
                        }
                    }

                    function saveProductos(idTable) {
                        isok = false;
                        total = 0;
                        table = document.getElementById(idTable);
                        rows = table.rows.length - 1;
                        cells = document.getElementById(idTable).rows[0].cells.length - 1;
                        productos = "";
                        for (i = 0; i < rows; i++) {
                            producto = "";
                            for (j = 0; j < cells; j++) {
                                value = document.getElementById((i + 1) + "" + j).value;
                                error = document.getElementById((i + 1) + "5");
                                switch (j) {
                                    case 0:
                                        if (value === "-1") {
                                            error.innerHTML = "Seleccione un tipo";
                                            return false;

                                        } else {
                                            error.innerHTML = "";
                                            producto += value + ",";

                                        }
                                        break;

                                    case 1:
                                        if (value === "-1") {
                                            error.innerHTML = "Seleccione una familia";
                                            return false;

                                        } else {
                                            error.innerHTML = "";
                                            producto += value + ",";

                                        }
                                        break;

                                    case 2:
                                        if (value === "") {
                                            error.innerHTML = "Escriba una descripci&oacute;n";
                                            return false;

                                        } else {
                                            error.innerHTML = "";
                                            producto += value + ",";

                                        }
                                        break;

                                    case 3:
                                        if (value === "") {
                                            error.innerHTML = "Escriba una cantidad";
                                            return false;

                                        } else if (isNaN(value)) {
                                            error.innerHTML = "Escriba una cantidad correcta";
                                            return false;

                                        } else if (0 > value) {
                                            error.innerHTML = "La cantidad debe ser mayor a -1";
                                            return false;

                                        } else {
                                            error.innerHTML = "";
                                            producto += value + ",";
                                        }
                                        break;

                                    case 4:
                                        if (value === "") {
                                            error.innerHTML = "Escriba un valor unitario";
                                            return false;

                                        } else if (isNaN(value)) {
                                            error.innerHTML = "Escriba un valor unitario correcto";
                                            return false;

                                        } else if (-1 > value) {
                                            error.innerHTML = "El valor unitario debe ser positivo";
                                            return false;

                                        } else {
                                            error.innerHTML = "";
                                            producto += value + ",";

                                        }
                                        break;
                                }
                            }
                            total+=value = parseFloat(document.getElementById((i + 1) + "" + 4).value)*parseFloat(document.getElementById((i + 1) + "" + 3).value);
                            producto = producto.substr(0, producto.length - 1);
                            productos += producto + ";";
                        }
                        if(total>parseFloat(document.getElementById('txt_valor_total_orden').value)){
                            window.alert("El valor total de los productos no debe superar el total de la orden de pago");
                            return false;
                        }
                        document.getElementById('btnGuardar').disable=true;
                        productos = productos.substr(0, productos.length - 1);
                        document.getElementById('txt_productos').value=productos;
                        document.getElementById('frm_agregar_orden').action = "?mod=ordenesdepago&niv=1&task=GuardarOrden";
                        document.getElementById('frm_agregar_orden').submit();
                    }





                </script>


                
                <div id="popup<?php echo $nombre ?>" style="display: none;">
                    <div class="content-popup">
                        <div class="close"><a href="#" id="close<?php echo $nombre ?>"  ><img src="templates/img/close.png"/></a></div>
                        <table id="productos" width="80%" align="center" border="0" cellpadding="0" cellspacing="1" class="datatable" >
                            <thead>
                                <tr>
                                    <th class="titledatatable">Tipo</th>
                                    
                                    <th class="titledatatable">Familia</th>
                                    <th class="titledatatable">Descripci&oacute;n</th>
                                    <th class="titledatatable">Cantidad</th>
                                    <th class="titledatatable">Valor Unitario</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <select id="10" onchange="selectChange('10', '13')">
                                            <option value="-1">Seleccione uno...</option>
                                            <option value="1">Bien</option>
                                            <option value="2">Servicio</option>
                                        </select>
                                    </td>
                                    <td><select id="11">
                                            <option value="-1">Seleccione una Familia</option>
                                            <?php foreach ($opcionesfamilias as $s) { ?> 
                                                <option value="<?php echo $s['value'] ?>"><?php echo $s['texto'] ?></option>

                                            <?php }
                                            ?>

                                        </select></td>
                                    <td><input id="12" type="text"></td>
                                    <td><input id="13" type="text"></td>
                                    <td><input id="14" type="text"></td>
                                    <td><div id="15"></div>
                                </tr>
                            </tbody>
                        </table>
                        
                        <table>
                            <tr>
                                <td>
                                    <button onclick="addRow('productos')"  class="button">Agregar Fila</button>
                                </td>
                                <td>
                                    <button onclick="deleteRow('productos')"  class="button">Eliminar Fila</button>
                                </td>
                                <td>
                                    <button id='btnGuardar' onclick="saveProductos('productos')"  class="button">Guardar</button>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="popup-<?php echo $nombre ?>"></div>
                <?php
                break;

            default:
                break;
        }
        ?>
        <?php
    }

    //une los dos funciones anteriores en una sola
    function createventanadesplegable($nombre, $nombreestilo, $task) {
        $this->crearestidoFadein($nombre);
        $this->createFadeIn($nombreestilo, $task);
    }

}
