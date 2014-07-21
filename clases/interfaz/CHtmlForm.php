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
 * Clase CHtmlForm
 *
 * genera un formulario en base a los atributos de elementos y etiquetas
 * para esto requiere que se asigne a cada elemento una etiqueta ya que la
 * construccion se hace uno a uno en una tabla html
 *
 *
 * @package  clases
 * @subpackage interfaz
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
class CHtmlForm {

    var $title = null;
    var $etiquetas = null;
    var $elementos = null;
    var $errors = null;
    var $botones = null;
    var $id = null;
    var $method = null;
    var $class_etiquetas = null;
    var $class_form = null;
    var $enctype = null;
    var $spaces = null;
    var $options = null;

    function CHtmlForm() {
        $this->options['autoClean'] = true;
    }

    function setTitle($t) {
        $this->title = $t;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setSpaces($s) {
        $this->spaces = $s;
    }

    function setMethod($m) {
        $this->method = $m;
    }

    function setClassEtiquetas($c) {
        $this->class_etiquetas = $c;
    }

    function setOptions($option, $val) {
        $this->options[$option] = $vall;
    }

    /**
     * adciona etiquetas al formulario html
     * @param $e texto de la etiqueta 
     */
    function addEtiqueta($e) {
        $this->etiquetas[count($this->etiquetas)] = $e;
    }

    function addTitleText($type, $text) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'text' => $text);
    }

    /**
     * adciona cuadros de texto y password al formulario html
     * @param $type tipo del elemento
     * @param $id identificador del elemento
     * @param $name nombre del elemento
     * @param $size tamaño del elemento, aplica para elementos de texto
     * @param $maxlenght maximo contenido del elemento, aplica para elementos de texto
     * @param $class clase del elemento segun hoja de estilos
     * @param $events eventos de tipo javascrip que se manejan para el elemento
     */
    function addInputText($type, $id, $name, $size, $maxlength, $value, $class, $events) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'size' => $size, 'maxlength' => $maxlength, 'value' => $value,
            'class' => $class, 'events' => $events);
    }

    function addTextArea($type, $id, $name, $cols, $rows, $value, $class, $events) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'cols' => $cols, 'rows' => $rows, 'value' => $value,
            'class' => $class, 'events' => $events);
    }

    function addDivision($type, $texto) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'texto' => $texto);
    }

    /**
     * adciona entradas de archivos al formulario html
     * @param $type tipo del elemento
     * @param $id identificador del elemento
     * @param $name nombre del elemento
     * @param $class clase del elemento segun hoja de estilos
     * @param $events eventos de tipo javascrip que se manejan para el elemento
     */
    function addInputFile($type, $id, $name, $size, $class, $events) {
        $this->enctype = "multipart/form-data";
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'size' => $size, 'class' => $class, 'events' => $events);
    }

    /**
     * adciona checkbox al formulario html
     * @param $type tipo del elemento
     * @param $id identificador del elemento
     * @param $name nombre del elemento
     * @param $class clase del elemento segun hoja de estilos
     * @param $events eventos de tipo javascrip que se manejan para el elemento
     */
    function addExtendedCheckBox($type, $id, $name, $subelements, $class, $events) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'subelements' => $subelements, 'class' => $class, 'events' => $events);
    }

    function addRadioButton($type, $id, $name, $dependientes, $value, $class, $events) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'dependientes' => $dependientes, 'value' => $value, 'clase_dep' => $class, 'events' => $events);
    }

    /**
     * adciona checkbox al formulario html
     * @param $type tipo del elemento
     * @param $id identificador del elemento
     * @param $name nombre del elemento
     * @param $class clase del elemento segun hoja de estilos
     * @param $events eventos de tipo javascrip que se manejan para el elemento
     */
    function addCheckBox($type, $id, $name, $subelements, $class, $events) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'subelements' => $subelements, 'class' => $class, 'events' => $events);
    }

    function addCheckBoxAndText($type, $id, $name, $value, $checked, $texto, $txt_value, $hdn_value, $class, $events) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'value' => $value, 'checked' => $checked, 'texto' => $texto,
            'txt_value' => $txt_value, 'hdn_value' => $hdn_value,
            'class' => $class, 'events' => $events);
    }

    /**
     * adciona select al formulario html
     * @param $type tipo del elemento
     * @param $id identificador del elemento
     * @param $name nombre del elemento
     * @param $class clase del elemento segun hoja de estilos
     * @param $events eventos de tipo javascrip que se manejan para el elemento
     */
    function addSelect($type, $id, $name, $options, $texto, $value, $class, $events) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'options' => $options, 'texto' => $texto,
            'value' => $value, 'class' => $class,
            'events' => $events);
    }

    function addSelectLink($type, $id, $name, $options, $texto, $value, $class, $events, $link) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'options' => $options, 'texto' => $texto,
            'value' => $value, 'class' => $class,
            'events' => $events, 'link' => $link);
    }

    /**
     * adciona campos de fecha al formulario html
     * @param $type tipo del elemento
     * @param $id identificador del elemento
     * @param $name nombre del elemento
     * @param $class clase del elemento segun hoja de estilos
     * @param $events eventos de tipo javascrip que se manejan para el elemento
     */
    function addInputDate($type, $id, $name, $value, $format, $size, $maxlength, $class, $events) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'value' => $value, 'format' => $format,
            'size' => $size, 'maxlength' => $maxlength,
            'class' => $class, 'events' => $events);
    }

    /**
     * adciona botones al formulario html
     * @param $type tipo del elemento (button,submit,reset)
     * @param $id identificador del elemento
     * @param $name nombre del elemento
     * @param $value texto del elemento
     * @param $class clase del elemento segun hoja de estilos
     * @param $events eventos de tipo javascrip que se manejan para el elemento
     */
    function addInputButton($type, $id, $name, $value, $class, $events) {
        $this->botones[count($this->botones)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'value' => $value, 'class' => $class, 'events' => $events);
    }

    /**
     * adciona espacios de error al formulario html
     * @param $id identificador del div de error
     * @param $msg texto que contiene el div de error
     */
    function addError($id, $msg) {
        $this->errors[count($this->errors)] = array('id' => $id, 'msg' => $msg);
    }

    /**
     * adiciona una grilla para capturar los datos en una 
     * @param $titulo titulo de la rejilla
     * @param $nombres nombres de los campos
     * @param $longitudes longitudes de los campos
     * @param $tipos tipos de los campos para validacion
     */
    function addGrid($id, $titulos_filas, $titulos_columnas, $campos, $class) {
        $this->elementos[count($this->elementos)] = array('type' => 'grid', 'id' => $id,
            'titulos_filas' => $titulos_filas, 'titulos_columnas' => $titulos_columnas,
            'campos' => $campos, 'maxlength' => $maxlength,
            'class' => $class);
    }

    function addBotonFormulario($type, $id, $name, $class, $events, $value) {
        $this->elementos[count($this->elementos)] = array('type' => $type, 'id' => $id, 'name' => $name,
            'class' => $class, 'events' => $events, 'value' => $value);
    }

    /**
     * funcion que escribe el formulario en el documento html
     * para esto crea una tabla de acuerdo a las etiquetas y elementos
     */
    function writeForm() {
        $html = new Chtml('');
        if (!isset($this->title))
            $this->title = '';
        if (!isset($this->spaces))
            $this->spaces = 0;
        if (count($this->etiquetas) >= 1) {
            $this->class_form = 'formtable';
            $cellspacing = 1;
        } else {
            $this->class_form = 'formhidden';
            $cellspacing = 0;
        }
        ?>
        <form id="<?php echo $this->id; ?>" method="<?php echo $this->method; ?>" enctype="<?php echo $this->enctype; ?>">

            <table width="80%" align="center" border="0" cellpadding="0" cellspacing="<?php echo $cellspacing; ?>" class="<?php echo $this->class_form; ?>">
                <?php if ($this->title != '') { ?>
                    <tr><td colspan="3" class="titleform"><?php echo $html->traducirTildes($this->title); ?></td></tr>
                <?php } ?>
                <?php $cont_e = 0; ?>
                <?php if (isset($this->elementos)) foreach ($this->elementos as $e) { ?>
                        <?php if ($e['type'] != 'hidden') { ?>
                            <?php if ($this->spaces != 0) { ?>
                                <tr><td colspan="3">&nbsp;</td></tr>
                            <?php } ?>
                            <?php if ($e['type'] == 'title') { ?>
                                <tr><td colspan="3" class="titleinform"><?php echo $html->traducirTildes($e['text']); ?></td></tr>
                            <?php } else { ?>
                                <tr>
                                    <td width="20%" class="<?php echo $this->class_etiquetas; ?>" nowrap valign='top'>
                                        <label id="label_<?php echo $cont_e; ?>">   
                                            <?php echo $html->traducirTildes($this->etiquetas[$cont_e]); ?> 
                                        </label>
                                    </td>
                                    <td width="40%">
                                        <?php if ($e['type'] == 'grid') { ?>
                                            <table border="0" cellspacing="1" cellpadding="0">
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <?php foreach ($e['titulos_columnas'] as $t) { ?>
                                                        <td><?php echo $t['nombre'] ?></td>
                                                    <?php } ?>
                                                </tr>
                                                <?php foreach ($e['titulos_filas'] as $f) { ?>
                                                    <tr>
                                                        <td><?php echo $f['nombre'] ?></td>
                                                        <?php foreach ($e['titulos_columnas'] as $t) { ?>
                                                            <td>
                                                                <input type="text" 
                                                                       id="txt_<?php echo $e['id'] . '_' . $t['id'] . "_" . $f['id']; ?>" 
                                                                       name="txt_<?php echo $e['id'] . '_' . $t['id'] . "_" . $f['id']; ?>" 
                                                                       size="5"
                                                                       value="<?php echo $e['campos'][$e['id']][$t['id']][$f['id']] ?>" 
                                                                       maxlength="5" 
                                                                       class=" "
                                                                       />
                                                            </td>
                                                        <?php } ?>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                        <?php if ($e['type'] == 'text' || $e['type'] == 'password') { ?>
                                            <input type="<?php echo $e['type']; ?>" 
                                                   id="<?php echo $e['id']; ?>" 
                                                   name="<?php echo $e['name']; ?>" 
                                                   size="<?php echo $e['size']; ?>"
                                                   value="<?php echo $html->traducirTildes($e['value']); ?>" 
                                                   maxlength="<?php echo $e['maxlength']; ?>" 
                                                   class="<?php echo $e['class']; ?>"
                                                   <?php echo $e['events']; ?> 
                                                   />
                                               <?php } ?>
                                               <?php if ($e['type'] == 'division') { ?>
                                                   <?php echo $e['texto']; ?> 
                                               <?php } ?>
                                               <?php if ($e['type'] == 'mapa') { ?>
                                                   <?php echo "<div id='map' style='width: 500px; height: 300px'></div>"; ?> 
                                               <?php } ?>
                                               <?php if ($e['type'] == 'textarea') { ?>
                                            <textarea id="<?php echo $e['id']; ?>" 
                                                      name="<?php echo $e['name']; ?>" 
                                                      cols="<?php echo $e['cols']; ?>" 
                                                      rows="<?php echo $e['rows']; ?>" 
                                                      class="<?php echo $e['class']; ?>"
                                                      <?php echo $e['events']; ?> 
                                                      ><?php echo $html->traducirTildes($e['value']); ?></textarea>
                                                  <?php } ?>
                                                  <?php if ($e['type'] == 'BotonFormulario') { ?>
                                            <button id="<?php echo $e['id']; ?>" 
                                                    name="<?php echo $e['name']; ?>" 
                                                    class="<?php echo $e['class']; ?>"
                                                    ><?php echo $html->traducirTildes($e['value']); ?></button>
                                                <?php } ?>

                                        <?php if ($e['type'] == 'file') { ?>
                                            <input type="<?php echo $e['type']; ?>" 
                                                   id="<?php echo $e['id']; ?>" 
                                                   name="<?php echo $e['name']; ?>" 
                                                   size="<?php echo $e['size']; ?>"
                                                   class="<?php echo $e['class']; ?>"
                                                   <?php echo $e['events']; ?> 
                                                   />
                                               <?php } ?>
                                               <?php if ($e['type'] == 'date') { ?>
                                            <input type="text>" 
                                                   id="<?php echo $e['id']; ?>" 
                                                   name="<?php echo $e['name']; ?>" 
                                                   size="<?php echo $e['size']; ?>"
                                                   value="<?php echo $html->traducirTildes($e['value']); ?>" 
                                                   maxlength="<?php echo $e['maxlength']; ?>" 
                                                   class="<?php echo $e['class']; ?>"
                                                   <?php echo $e['events']; ?>
                                                   readonly
                                                   onclick="limpiar('<?php echo $e['id']; ?>')"
                                                   />
                                            <img src="templates/img/date.gif" 
                                                 border="0" 
                                                 width="20" 
                                                 id="boton_<?php echo $e['id'] ?>"
                                                 style="cursor: pointer;vertical-align:middle;" 
                                                 title="Date selector"
                                                 />
                                            <script type="text/javascript">
                                                Calendar.setup({
                                                    inputField: "<?php echo $e['id']; ?>", // id of the input field
                                                    ifFormat: "<?php echo $e['format']; ?>", // format of the input field
                                                    showsTime: false, // will display a time selector
                                                    button: "boton_<?php echo $e['id'] ?>", // trigger for the calendar (button ID)
                                                    singleClick: true, // double-click mode
                                                    step: 1                				// show all years in drop-down boxes 
                                                });
                                            </script>
                                        <?php } ?>
                                        <?php if ($e['type'] == 'select') { ?>
                                            <select id="<?php echo $e['id']; ?>" 
                                                    name="<?php echo $e['name']; ?>" 
                                                    class="<?php echo $e['class']; ?>"
                                                    <?php echo $e['events']; ?> 
                                                    >
                                                <option value="-1"><?php echo $html->traducirTildes(SELECCIONE_UN . " " . $e['texto']); ?></option>
                                                <?php foreach ($e['options'] as $s) { ?>
                                                    <option value="<?php echo $s['value']; ?>"
                                                    <?php if ($e['value'] == $s['value']) echo "selected" ?>
                                                            >
                                                                <?php echo $html->traducirTildes($s['texto']); ?>
                                                    </option>
                                                <?php } ?>
                                            </select>
                                        <?php } ?>

                                        <?php if ($e['type'] == 'selectlink') { ?>
                                            <select id="<?php echo $e['id']; ?>" 
                                                    name="<?php echo $e['name']; ?>" 
                                                    class="<?php echo $e['class']; ?>"
                                                    <?php echo $e['events']; ?> 
                                                    >
                                                <option value="-1"><?php echo $html->traducirTildes(SELECCIONE_UN . " " . $e['texto']); ?></option>
                                                <?php foreach ($e['options'] as $s) { ?>
                                                    <option value="<?php echo $s['value']; ?>"
                                                    <?php if ($e['value'] == $s['value']) echo "selected" ?>
                                                            >
                                                                <?php echo $html->traducirTildes($s['texto']); ?>
                                                    </option>

                                                <?php } ?>
                                            </select>
                                            <?php if ($e['link'] != '') echo $e['link'] ?>
                                        <?php } ?>
                                        <?php if ($e['type'] == 'extendedCheckbox') { ?>
                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="optionbox">
                                                <?php foreach ($e['subelements'] as $s) { ?>
                                                    <tr>
                                                        <td class="<?php echo $s['clase']; ?>">
                                                            <input type="checkbox" 
                                                                   id="<?php echo $e['id'] . "_" . $s['value']; ?>" 
                                                                   name="<?php echo $e['name'] . "_" . $s['value']; ?>" 
                                                                   value="<?php echo $s['value']; ?>" 
                                                                   <?php echo $s['events']; ?>
                                                                   <?php echo $s['checked']; ?>> <?php echo $html->traducirTildes($s['texto']); ?>
                                                        </td>
                                                        <td class="<?php echo $s['clase_dep']; ?>">
                                                            <?php $cont_d = 0; ?>
                                                            <?php foreach ($s['dependientes'] as $d) { ?>
                                                                <input type="radio" 
                                                                       id="radio_<?php echo $d['id']; ?>" 
                                                                       name="radio_<?php echo $d['id']; ?>" 
                                                                       value="<?php echo $cont_d; ?>" 
                                                                       <?php echo $d['checked']; ?>> <?php echo $html->traducirTildes($d['texto']); ?>
                                                                       <?php $cont_d++; ?>
                                                                   <?php } ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                        <?php if ($e['type'] == 'radioButton') { ?>
                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="optionbox">

                                                <td class="<?php echo $e['clase_dep']; ?>">
                                                    <?php $cont_d = 0; ?>
                                                    <?php foreach ($e['dependientes'] as $d) { ?>
                                                        <input type="radio" 
                                                               id="radio_<?php echo $d['id']; ?>" 
                                                               name="radio_<?php echo $d['id']; ?>" 
                                                               value="<?php echo $cont_d; ?>" 
                                                               <?php echo $d['checked']; ?>> <?php echo $html->traducirTildes($d['texto']); ?>
                                                               <?php $cont_d++; ?>
                                                           <?php } ?>
                                                </td>
                                            </table>
                                        <?php } ?>									<?php if ($e['type'] == 'checkbox') { ?>
                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="optionbox">
                                                <?php foreach ($e['subelements'] as $s) { ?>
                                                    <tr>
                                                        <td class="<?php echo $s['clase']; ?>">
                                                            <input type="checkbox" 
                                                                   id="<?php echo $e['id'] . "_" . $s['value']; ?>" 
                                                                   name="<?php echo $e['name'] . "_" . $s['value']; ?>" 
                                                                   value="<?php echo $s['value']; ?>" 
                                                                   <?php echo $s['events']; ?>
                                                                   <?php echo $s['checked']; ?>> <?php echo $html->traducirTildes($s['texto']); ?>
                                                        </td>
                                                    </tr>
                                                <?php } ?>
                                            </table>
                                        <?php } ?>
                                        <?php if ($e['type'] == 'checkboxandtext') { ?>
                                            <table width="100%" align="center" border="0" cellpadding="0" cellspacing="0" class="optionbox">
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" 
                                                               id="chk_<?php echo $e['id']; ?>" 
                                                               name="chk_<?php echo $e['name']; ?>" 
                                                               value="<?php echo $e['value']; ?>" 
                                                               <?php echo $e['events']; ?>
                                                               <?php echo $e['checked']; ?>> <?php echo $html->traducirTildes($e['texto']); ?>
                                                    </td>
                                                    <td>
                                                        <input type="text" id="txt_<?php echo $e['id']; ?>" name="txt_<?php echo $e['name']; ?>" value="<?php echo $e['txt_value']; ?>">
                                                        <input type="hidden" id="hdn_<?php echo $e['id']; ?>" name="hdn_<?php echo $e['name']; ?>" value="<?php echo $e['hdn_value']; ?>">
                                                    </td>
                                                </tr>
                                            </table>
                                        <?php } ?>
                                    </td>
                                    <td width="40%">
                                        <div id="<?php echo $this->errors[$cont_e]['id']; ?>" 
                                             class="error" 
                                             style="visibility:hidden; display:none;">
                                                 <?php echo $html->traducirTildes($this->errors[$cont_e]['msg']) ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php $cont_e++; ?>
                            <?php } ?>

                        <?php } else { ?>
                            <input type="<?php echo $e['type']; ?>" 
                                   id="<?php echo $e['id']; ?>" 
                                   name="<?php echo $e['name']; ?>" 
                                   value="<?php echo $e['value']; ?>" 
                                   <?php echo $e['events']; ?> 
                                   />
                               <?php } ?>
                           <?php } ?>
                       <?php if (isset($this->botones)) { ?>
                    <tr>
                        <td colspan="3" class="td_right">
                            <?php foreach ($this->botones as $b) { ?>
                                <?php if ($b['type'] == 'button' || $b['type'] == 'submit' || $b['type'] == 'reset') { ?>
                                    <input type="<?php echo $b['type']; ?>" 
                                           id="<?php echo $b['id']; ?>" 
                                           name="<?php echo $b['name']; ?>" 
                                           value="<?php echo $html->traducirTildes($b['value']); ?>" 
                                           class="<?php echo $b['class']; ?>"
                                           <?php echo $b['events']; ?> 
                                           />
                                       <?php } ?>
                                   <?php } ?>
                                   <?php if ($this->options['autoClean']) { ?>
                                <input type="button" 
                                       id="clear_button" 
                                       name="clear_button" 
                                       value="<?php echo $html->traducirTildes(LIMPIAR_FORMULARIO); ?>" 
                                       class="button"
                                       onClick=limpiarFormulario('<?php echo $this->id ?>') 
                                       />
                                   <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </table>
        </form>
        <?php
    }

    function crearFormulario($id, $method, $enctype) {
        ?>
        <form id="<?php echo $id; ?>" method="<?php echo $method; ?>" enctype="<?php echo $enctype; ?>">
            <?php
        }

        function cerrarFormulario() {
            ?>
        </form>
        <?php
    }

    function crearCheck($id, $valor, $texto, $checked, $events) {
        $html = new Chtml('');
        ?>
        <input type="checkbox" 
               id="<?php echo $id; ?>" 
               name="<?php echo $id; ?>" 
               value="<?php echo $valor; ?>" 
               <?php echo $events; ?>
               <?php echo $checked; ?>> <?php echo $html->traducirTildes($texto); ?>
               <?php
           }

           function crearRadio($id, $valor, $texto, $checked, $events) {
               $html = new Chtml('');
               ?>
        <input type="radio" 
               id="<?php echo $id; ?>" 
               name="<?php echo $id; ?>" 
               value="<?php echo $valor; ?>" 
               <?php echo $events; ?>
               <?php echo $checked; ?>> <?php echo $html->traducirTildes($texto); ?>
               <?php
           }

           function crearTextArea($id, $valor, $cols, $rows, $events) {
               $html = new Chtml('');
               ?>
        <textarea id="<?php echo $id; ?>" 
                  name="<?php echo $id; ?>" 
                  cols="<?php echo $cols; ?>" 
                  rows="<?php echo $rows; ?>" 
                  <?php echo $events; ?> 
                  ><?php echo $html->traducirTildes($valor); ?></textarea>
                  <?php
              }

              function crearTextField($type, $id, $size, $value, $maxlength, $class, $events) {
                  $html = new Chtml('');
                  ?>
        <input type="<?php echo $type; ?>" 
               id="<?php echo $id; ?>" 
               name="<?php echo $id; ?>" 
               size="<?php echo $size; ?>"
               value="<?php echo $html->traducirTildes($value); ?>" 
               maxlength="<?php echo $maxlength; ?>" 
               class="<?php echo $class; ?>"
               <?php echo $events; ?> 
               />
               <?php
               }


               //-----------------------------------------------------
               function crearDateField($id, $size, $value, $format, $maxlength, $class, $events) {
                  $html = new Chtml('');
                  ?>
        <input type="text" 
               id="<?php echo $id; ?>" 
               name="<?php echo $id; ?>" 
               size="<?php echo $size; ?>"
               value="<?php echo $html->traducirTildes($value); ?>" 
               maxlength="<?php echo $maxlength; ?>" 
               class="<?php echo $class; ?>"
               <?php echo $events; ?> 
               readonly
               onclick="limpiar('<?php echo $id; ?>')"
               />
        <img src="templates/img/date.gif" 
             border="0" 
             width="20" 
             id="boton_<?php echo $id ?>"
             style="cursor: pointer;vertical-align:middle;" 
             title="Date selector"
             />
        <script type="text/javascript">
            Calendar.setup({
                inputField: "<?php echo $id; ?>", // id of the input field
                ifFormat: "<?php echo $format; ?>", // format of the input field
                showsTime: false, // will display a time selector
                button: "boton_<?php echo $id ?>", // trigger for the calendar (button ID)
                singleClick: true, // double-click mode
                step: 1                				// show all years in drop-down boxes 
            });
        </script>
               <?php
               }
               
        
        
        
        //-------------------------------------------------

        function crearBoton($tipo, $id, $valor, $events, $class = "button") {
        $html = new Chtml('');
        ?>
        <center>
            <input type="<?php echo $tipo; ?>" 
                   id="<?php echo $id; ?>" 
                   style='width:100px; height:30px'
                   name="<?php echo $id; ?>" 
                   value="<?php echo $html->traducirTildes($valor); ?>" 
                   class="<?php echo $class; ?>"
        <?php echo $events; ?> 
                   />
        </center>
        <?php
    }

    function crearDivError($id, $msg) {
        $html = new Chtml('');
        ?>
        <div id="<?php echo $id; ?>" 
             class="error" 
             style="visibility:hidden; display:none;">
        <?php echo $html->traducirTildes($msg); ?>
        </div>
        <?php
    }

    function crearSelect($id, $name, $class, $events, $texto, $options, $value) {
        $html = new Chtml('');
        ?>
        <select id="<?php echo $id; ?>" 
                name="<?php echo $name; ?>" 
                class="<?php echo $class; ?>"
        <?php echo $events; ?> 
                >
            <option value="-1"><?php echo $html->traducirTildes(SELECCIONE_UN . " " . $texto); ?></option>
                    <?php foreach ($options as $s) { ?>
                <option value="<?php echo $s['value']; ?>"
                            <?php if ($value == $s['value']) echo "selected" ?>>
                <?php echo $html->traducirTildes($s['texto']); ?>
                </option>
        <?php } ?>
        </select>
        <?php
    }

    function crearLabel($href, $id, $value, $color) {
        ?>

        <center>
            <a href="<?php echo $href ?>"    
               id="<?php echo $id ?>"
               style="color:<?php echo $color ?>" 
               ><?php echo $value ?></a>
        </center>

        <?php
    }

}
