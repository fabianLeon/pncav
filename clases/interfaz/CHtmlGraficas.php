<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CHtmlGraficas
 *
 * @author Personal
 */
class CHtmlGraficas {

    var $html;

    // crearestidoFadein se encarga de crear el estilo de la ventada fadein
    function crearestidoFadeinGrafica($nombre,$width,$height) {

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
                width:<?php echo $width ?>px;
                min-height:<?php echo $height?>px;
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


           grafica {
                width: 5px;
                height: 390px;
                margin-top: -195px;
                margin-left: -290px;
                left: 50%;
                top: 50%;
                position: absolute;
            }

        </style>
        <script type = "text/javascript" src = "jquery.js"></script>
        <?php
    }

//createFadeIn se encarga de crear a traves del jquery la funcion que genera el fadein
    function createFadeInGrafica($nombre) {
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
            case 'graficaEgresos':
                ?>

                <div id="popup<?php echo $nombre ?>" style="display: none;">
                    <div class="content-popup">
                        <div class="close"><a href="#" id="close<?php echo $nombre ?>"  ><img src="templates/img/close.png"/></a></div>
                        <table>
                            <tr>
                            <img src="soportes/financiero/Graficas/GraficaEgresos.png">
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="popup-<?php echo $nombre ?>"></div>


                <?php
                break;
            case 'graficaDesembolsos':
                ?>

                <div id="popup<?php echo $nombre ?>" style="display: none;">
                    <div class="content-popup">
                        <div class="close"><a href="#" id="close<?php echo $nombre ?>"  ><img src="templates/img/close.png"/></a></div>
                        <table>
                            <tr>
                            <img src="soportes/financiero/Graficas/GraficaDesembolsos.png">
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="popup-<?php echo $nombre ?>"></div>


                <?php
                break;
            case 'graficaUtilidades':
                ?>

                <div id="popup<?php echo $nombre ?>" style="display: none;">
                    <div class="content-popup">
                        <div class="close"><a href="#" id="close<?php echo $nombre ?>"  ><img src="templates/img/close.png"/></a></div>
                        <table>
                            <tr>
                            <img src="soportes/financiero/Graficas/GraficaUtilidades.png">
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
    function createventanadesplegableGrafica($nombre,$width,$height) {
        $this->crearestidoFadeinGrafica($nombre,$width,$height);
        $this->createFadeInGrafica($nombre);
    }

}
