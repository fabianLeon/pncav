<?php

/**
 * Archivo de configuracion para la carga de las clases.
 */
/**
 * carga de los achivos de clases
 */
$dir = './clases/datos/';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file != "." && $file != "..") {
        require($dir . $file);
    }
}
closedir($handle);
// Cargamos las clases de la capa de interfaz
$dir = './clases/interfaz/';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file != "." && $file != "..") {
        require($dir . $file);
    }
}
closedir($handle);
// Cargamos las clases de la capa de aplicación
$dir = './clases/aplicacion/';
$handle = opendir($dir);
while ($file = readdir($handle)) {
    if ($file != "." && $file != "..") {
        require($dir . $file);
    }
}
closedir($handle);
//cargamos las clases para generacion de charts

require './clases/libchart/libchart/classes/libchart.php';

//cargamos las clases para lectura de xls
require './clases/Excel/reader.php';
?>