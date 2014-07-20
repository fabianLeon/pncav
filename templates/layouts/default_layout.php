<?php
/**
 * Gestion Interventoria - Gestin
 *
 * <ul>
 * <li> Redcom Ltda <www.redcom.com.co></li>
 * <li> Proyecto RUNT</li>
 * </ul>
 */
/**
 * Default_layout
 *
 * @package  templates
 * @subpackage layouts
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright Ministerio de Transporte
 */
//no permite el acceso directo
defined('_VALID_PRY') or die('Restricted access to this level');
$html = new CHtml(APP_TITLE);
$html->addEstilo('diseno.css');
$html->addEstilo('menuheader.css');
$html->addEstilo('calendar/calendar-blue.css');
$html->addScript('menu/ssm.js');
$handle = opendir('./templates/scripts/validar/');
while ($file = readdir($handle)) {
    if ($file != "." && $file != "..") {
        //include($file);
        if (substr($file, strlen($file) - 3) == '.js') {
            $html->addScript('validar/' . $file);
        }
    }
}
//$html->addScript('validar.js');
$html->addScript('menu/menuheader.js');
$html->addScript('calendar/calendar.js');
$html->addScript('calendar/calendar-es.js');
$html->addScript('calendar/calendar-setup.js');
$html->abrirHtml();
?>

<?php
?>
<?php include('templates/html/header.html'); ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr class="bg_user">

        <td width="60" class="layout_title" nowrap><?php echo $html->traducirTildes(LAYOUT_FECHA); ?></td>
        <td width="250" class="layout_user" nowrap><?php echo $html->fecha($dias, $meses); ?></td>
        <td width="60" class="layout_title" nowrap><?php echo $html->traducirTildes(LAYOUT_HORA); ?></td>
        <td width="150" class="layout_user" nowrap><?php echo date("H:i:s"); ?></td>
        <td width="100" class="layout_title" nowrap><?php echo $html->traducirTildes(FECHA_ULTIMO_INGRESO); ?></td>
        <td width="150" class="layout_user" nowrap><?php echo $html->traducirTildes($fecha_ultimo_ingreso); ?></td>
        <td width="60" class="layout_title" nowrap><?php echo $html->traducirTildes(LAYOUT_ACTIVO); ?></td>
        <td class="layout_user" nowrap><?php echo $html->traducirTildes($nombre_usuario); ?></td>
        <td width="*"></td>
    </tr>

</table>
<div class="bg_menu_user">
    <div id="main">
        <div id="header">
            <ul id="nav">
                <?php
                $cont = 0;
                while ($row = mysql_fetch_array($opciones)) {

                    if ($row["opc_variable"] != "_blank") {
                        if ($row["opn_id"] == 0) {
                            if ($cont == 1) {
                                echo "</ul>";
                                $cont--;
                            }
                            echo "<li class='menua_a'><a href='#'>" . $html->traducirTildes($row["opc_nombre"]) . "</a>";
                        }
                        if ($row["opn_id"] == 1) {
                            if ($cont == 0) {
                                echo "<ul>";
                                $cont++;
                            }
                            echo "<li><a href='?mod=" . $row["opc_variable"] . "&niv=" . $row["pxo_nivel"] . "&operador=" . $row["ope_id"] . "'>" . $html->traducirTildes($row["opc_nombre"]) . "</a>";
                        }
                    } else {
                        if ($row["opn_id"] == 0) {
                            if ($cont == 1) {
                                echo "</ul></li>";
                                $cont--;
                            }
                            echo "<li><a href='#'>" . $html->traducirTildes($row["opc_nombre"]) . "</a>";
                        }
                        if ($row["opn_id"] == 1) {
                            if ($cont == 0) {
                                echo "<ul>";
                                $cont++;
                            }
                            echo "<li><a href='" . $row["opc_url"] . "' target='_blank'>" . $html->traducirTildes($row["opc_nombre"]) . "</a>";
                        }
                    }
                }
                ?>
            </ul></ul>
        </div>

    </div>
    <nav>
        <?php
        $opcionesData = new COpcionData($db);
        $elementos = $opcionesData->getRutaByVar($modulo);
        foreach ($elementos as $e)
            echo "<img src='./templates/img/siguiente.png' width='10px' border='0'></img>" . strtolower($html->traducirTildes($e['nombre']));
        ?>    
    </nav>
</div>
<aside>
    <?php
    echo "<br>";
    if (isset($subopciones)) {
        while ($row = mysql_fetch_array($subopciones)) {
            ?>
            <a href="?mod=<?php echo $row["opc_variable"]; ?>&niv=<?php echo $row["pxo_nivel"]; ?>&operador=<?php echo $row["ope_id"]; ?>">
                <img src='./templates/img/menuBullet.jpg' border='0'></img><?php echo $html->traducirTildes($row["opc_nombre"]); ?>
            </a><br>

            <?php } ?>
       <?php }?>
    </aside>

    <section>
        <?php
        //echo "-".$path_modulo."- ".file_exists($path_modulo);
        if (file_exists($path_modulo))
            include( $path_modulo );
        else {
            ?>
                            <!--div class="error">Error al cargar el modulo <b>'<?php echo $modulo; ?>'</b>. No existe el archivo <b>'<?php echo $conf[$modulo]['archivo']; ?>'</b></div-->
            <?php
            include('templates/html/under.html'); //die('Error al cargar el modulo <b>'.$modulo.'</b>. No existe el archivo <b>'.$conf[$modulo]['archivo'].'</b>');
        }
        ?>
    </section>

    <?php include('templates/html/footer.html'); ?>
    <?php
    $html->cerrarHtml();
    ?>
