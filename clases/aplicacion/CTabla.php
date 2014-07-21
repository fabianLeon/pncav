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
Class CTabla {

    var $dt = null;

    /**
     * * Constructor de la clase CTablaData
     * */
    function CTabla($dt) {
        $this->dt = $dt;
    }

    /**
     * * retorna un arreglo con las tablas pertenecientes a tablas basicas
     * */
    function getTablas() {
        $tablas['departamento']['id'] = 'departamento';
        $tablas['departamento']['nombre'] = 'Departamentos';

        $tablas['departamento_region']['id'] = 'departamento_region';
        $tablas['departamento_region']['nombre'] = 'Departamentos (Region)';

        $tablas['municipio']['id'] = 'municipio';
        $tablas['municipio']['nombre'] = 'Municipios';

        $tablas['operador']['id'] = 'operador';
        $tablas['operador']['nombre'] = 'Operador';
        
        $tablas['pais']['id'] = 'pais';
        $tablas['pais']['nombre'] = 'Paises';
        
        $tablas['ciudad']['id'] = 'ciudad';
        $tablas['ciudad']['nombre'] = 'Ciudades';
        
        $tablas['familias']['id'] = 'familias';
        $tablas['familias']['nombre'] = 'Familias';
        
        $tablas['monedas']['id'] = 'monedas';
        $tablas['monedas']['nombre'] = 'Monedas';
        
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
        $modos['departamento'] = 1;
        $modos['departamento_region'] = 1;
        $modos['municipio'] = 1;
        $modos['operador'] = 1;
        $modos['pais'] = 1;
        $modos['ciudad'] = 1;
        $modos['familias'] = 1;
        $modos['monedas'] = 1;
        $modos['cuenta'] = 1;
        $modos['cuentas_financiero'] = 1;
        return $modos;
    }

    /**
     * retorna un arreglo con los titulos para visualizacion de los campos de las tablas pertenecientes a tablas basicas
     */
    function getTitulos() {
        //arreglo para remplazar los titulos de las columnas 
        $titulos_campos['dep_id'] = COD_DEPARTAMENTO;
        $titulos_campos['dep_nombre'] = NOMBRE_DEPARTAMENTO;

        $titulos_campos['der_id'] = COD_DEPARTAMENTO_REGION;
        $titulos_campos['der_nombre'] = NOMBRE_DEPARTAMENTO_REGION;

        $titulos_campos['mun_id'] = COD_MUNICIPIO;
        $titulos_campos['mun_nombre'] = NOMBRE_MUNICIPIO;
        $titulos_campos['mun_poblacion'] = POB_MUNICIPIO;

        $titulos_campos['ope_id'] = OPERADOR;
        $titulos_campos['ope_nombre'] = OPERADOR_NOMBRE;
        $titulos_campos['ope_sigla'] = OPERADOR_SIGLA;
        $titulos_campos['ope_contrato_no'] = OPERADOR_CONTRATO_NRO;
        $titulos_campos['ope_contrato_valor'] = OPERADOR_CONTRATO_VALOR;
        
        $titulos_campos['Id_Ciudad']=TITULO_CIUDAD;
        $titulos_campos['Id_Pais']=NOMBRE_PAIS;
        $titulos_campos['Nombre_Ciudad']=NOMBRE_CIUDAD;
        
        $titulos_campos['Nombre_Pais']=NOMBRE_PAIS;
        
        $titulos_campos['Id_Familia']=TITULO_FAMILIAS;
        $titulos_campos['Descripcion_Familia']=DESCRIPCION_FAMILIA;
        
        $titulos_campos['Id_Moneda']=TITULO_MONEDA;
        $titulos_campos['Descripcion_Moneda']=DESCRIPCION_MONEDA;
        
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
        $relacion_tablas['departamento']['ope_id']['tabla'] = 'operador';
        $relacion_tablas['departamento']['ope_id']['campo'] = 'ope_id';
        $relacion_tablas['departamento']['ope_id']['remplazo'] = 'ope_nombre';
        //---------------------------->DEPARTAMENTO(OPERADOR)
        //---------------------------->DEPARTAMENTO(REGION)
        $relacion_tablas['departamento']['der_id']['tabla'] = 'departamento_region';
        $relacion_tablas['departamento']['der_id']['campo'] = 'der_id';
        $relacion_tablas['departamento']['der_id']['remplazo'] = 'der_nombre';
        //---------------------------->DEPARTAMENTO(REGION)
        //---------------------------->MUNICIPIO(DEPARTAMENTO)
        $relacion_tablas['municipio']['dep_id']['tabla'] = 'departamento';
        $relacion_tablas['municipio']['dep_id']['campo'] = 'dep_id';
        $relacion_tablas['municipio']['dep_id']['remplazo'] = 'dep_nombre';
        //---------------------------->MUNICIPIO(DEPARTAMENTO)
        //---------------------------->CIUDAD
        $relacion_tablas['ciudad']['Id_Pais']['tabla'] = 'pais';
        $relacion_tablas['ciudad']['Id_Pais']['campo'] = 'Id_Pais';
        $relacion_tablas['ciudad']['Id_Pais']['remplazo'] = 'Nombre_Pais';
        //---------------------------->CIUDAD
        
        //---------------------------->CUENTAS
        $relacion_tablas['cuentas_financiero']['cft_id']['tabla'] = 'cuentas_financiero_tipo';
        $relacion_tablas['cuentas_financiero']['cft_id']['campo'] = 'cft_id';
        $relacion_tablas['cuentas_financiero']['cft_id']['remplazo'] = 'cft_nombre';
        //---------------------------->CUENTAS
        
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
            $msg = TABLA_AGREGADA;
        } else {
            $msg = ERROR_ADD_TABLA;
        }

        return $msg;
    }

    /**
     * * actualiza un objeto TABLA y retorna un mensaje del resultado del proceso
     * */
    function saveEditTabla($tabla, $id_elemento, $campos, $valores) {
        $r = $this->dt->saveEditTabla($tabla, $id_elemento, $campos, $valores);
        if ($r == 'true') {
            $msg = TABLA_EDITADO;
        } else {
            $msg = ERROR_EDIT_TABLA;
        }

        return $msg;
    }
    
    function deleteTabla($tabla, $criterio){
        $r = $this->dt->deleteTabla($tabla,$criterio);
        if ($r == 'true') {
            $msg = TABLA_BORRADO;
        } else {
            $msg = ERROR_BORRADO_TABLA;
        }

        return $msg;
    }

}

?>