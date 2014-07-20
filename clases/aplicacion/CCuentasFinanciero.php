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
 * Clase Tabla
 *
 * @package  clases
 * @subpackage aplicacion
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright SERTIC - MINTICS
 */
Class CCuentaFinanciero {

    var $dt = null;

    /**
     * * Constructor de la clase CTablaData
     * */
    function CCuentaFinanciero($dt) {
        $this->dt = $dt;
    }

    /**
     * * retorna un arreglo con las tablas pertenecientes a tablas basicas
     * */
    function getTablas() {
        $tablas['cuentas_financiero']['id'] = 'cuentas_financiero';
        $tablas['cuentas_financiero']['nombre'] = 'Cuentas';

        asort($tablas);
        return $tablas;
    }

    /**
     * * retorna un arreglo con los modos de las tablas pertenecientes a tablas basicas
     * */
    function getModos() {
        // arreglo para la determinacion del tipo de la tabla 
        // 1 si se les puede agregar registros 0 si no se puede
        $modos['cuentas_financiero'] = 1;
        return $modos;
    }

    /**
     * retorna un arreglo con los titulos para visualizacion de los campos de las tablas pertenecientes a tablas basicas
     */
    function getTitulos() {
        //arreglo para remplazar los titulos de las columnas 
        //$titulos_campos['cfi_id'] = COD_DEPARTAMENTO;
        $titulos_campos['cfi_numero'] = CUENTA_NUMERO;
        $titulos_campos['cfi_nombre'] = CUENTA_NOMBRE;
        $titulos_campos['cft_id'] = CUENTA_TIPO;
        $titulos_campos['cft_nombre'] = CUENTA_TIPO;

        

        return $titulos_campos;
    }

    /**
     * retorna un arreglo con las relaciones existentes entre las tablas pertenecientes a tablas basicas
     * esta relacion es usada para cargar ciertos campos de otras tablas cuanto estas tiene relacion
     * con la tabla basica que se esta editando
     */
    function getRelaciones() {
        //arreglo relacion de tablas
        //---------------------------->DEPARTAMENTO(OPERADOR)
        $relacion_tablas['cuentas_financiero']['cft_id']['tabla'] = 'cuentas_financiero_tipo';
        $relacion_tablas['cuentas_financiero']['cft_id']['campo'] = 'cft_id';
        $relacion_tablas['cuentas_financiero']['cft_id']['remplazo'] = 'cft_nombre';
        //---------------------------->DEPARTAMENTO(OPERADOR)
        
        return $relacion_tablas;
    }

    /**
     * retorna un arreglo con los tipos de los campos de una tabla
     */
    function getTiposCampos($tabla) {
        
        $tipos = $this->dt->getTipos($tabla);
        return $tipos;
    }

    /**
     * retorna un arreglo con los opciones para seleccionar segun la relacion existente entre los campos de las tablas
     */
    function getOpciones($array) {
        $opciones = $this->dt->getOpciones($array['tabla'], $array['campo'], $array['remplazo']);
        return $opciones;
    }

    /**
     * * almacena un objeto TABLA y retorna un mensaje del resultado del proceso
     * */
    function saveNewTabla($tabla, $campos, $valores) {
        $r = $this->dt->saveNewTabla($tabla, $campos, $valores);
        if ($r == 'true') {
            $msg = CUENTA_AGREGADA;
        } else {
            $msg = ERROR_ADD_CUENTA;
        }

        return $msg;
    }

    /**
     * * actualiza un objeto TABLA y retorna un mensaje del resultado del proceso
     * */
    function saveEditTabla($tabla, $id_elemento, $campos, $valores) {
        $r = $this->dt->saveEditTabla($tabla, $id_elemento, $campos, $valores);
        if ($r == 'true') {
            $msg = CUENTA_EDITADO;
        } else {
            $msg = ERROR_EDIT_CUENTA;
        }

        return $msg;
    }
    
    function deleteTabla($tabla, $id_elemento) {
        $predicado = "cfi_id = ".$id_elemento;
        $r = $this->dt->deleteTabla($tabla,$predicado);
        if ($r == 'true') {
            $msg = CUENTA_BORRADO;
        } else {
            $msg = ERROR_BORRAR_CUENTA;
        }

        return $msg;
    }

}

?>