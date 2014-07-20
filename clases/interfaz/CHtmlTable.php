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
 * Clase CHtmlTable
 *
 * genera una tabla en base a un arreglo de elementos
 *
 * @package  clases
 * @subpackage interfaz
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
class CHtmlTable {

    function abrirTabla($border, $cellspacing, $cellpadding, $class, $id = '', $style='') {
        ?>
<table width="100%" border="<?php echo $border; ?>" cellpadding="<?php echo $cellpadding; ?>" cellspacing="<?php echo $cellspacing; ?>" class="<?php echo $class; ?>" id="<?php echo $id;?>" style="<?php echo $style;?>">
            <?php
        }

        function cerrarTabla() {
            ?>
        </table>
        <?php
    }

    function abrirFila() {
        ?>
        <tr>
            <?php
        }

        function cerrarFila() {
            ?>
        </tr>
        <?php
    }

    function crearCelda($width, $colspan, $class, $texto, $nowrap = "nowrap", $id = '') {
        $html = new CHtml('');
        ?>
        <td width="<?php echo $width; ?>" colspan="<?php echo $colspan; ?>" class="<?php echo $class; ?>" <?php echo $nowrap ?> id="<?php echo $id;?>">
            <?php echo $html->traducirTildes($texto); ?>
        </td>
        <?php
    }

    function abrirCelda($width, $colspan, $class, $nowrap = "nowrap", $id = '') {
        ?>
        <td width="<?php echo $width; ?>" colspan="<?php echo $colspan; ?>" class="<?php echo $class; ?>" <?php echo $nowrap ?> id="<?php echo $id;?>">
            <?php
        }

        function cerrarCelda() {
            ?>
        </td>
        <?php
    }

}
