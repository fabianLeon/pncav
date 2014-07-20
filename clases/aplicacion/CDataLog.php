<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CDataLog
 *
 * @author alejandro
 */
class CDataLog {
    var $archivo = DATA_LOG_FILE;
    
    function writeLog($msg){
        //die($this->archivo);
        $file = fopen($this->archivo, "a");
        fwrite($file, date('Y-m-d H:i:s')."|".$_SESSION["usuario_sesion_pry"]."|".$msg . PHP_EOL);
        fclose($file);
    }
}
