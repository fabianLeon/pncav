<?php

/**
 * Gestion Interventoria - Fenix
 *
 * <ul>
 * <li> Redcom Ltda <www.redcom.com.co></li>
 * <li> Proyecto RUNT</li>
 * </ul>
 */

/**
 * Clase Data
 * Usada para la definicion de todas las funciones generales de acceso a la BD
 *
 * @package  clases
 * @subpackage datos
 * @author Redcom Ltda
 * @version 2013.01.00
 * @copyright Ministerio de Transporte
 */
Class CData {

    var $host = null;
    var $usuario = null;
    var $password = null;
    var $database = null;
    var $log = null;

    /**
     * constructor de la clase
     */
    function CData($h, $u, $p, $db) {
        $this->host = $h;
        $this->usuario = $u;
        $this->password = $p;
        $this->database = $db;
        $this->log = new CDataLog();
        //$this->conectar();
    }

    /**
     * hace la coneccion con la base de datos
     */
    function conectar() {
        $link = mysql_pconnect($this->host, $this->usuario, $this->password);
        //echo ("link".$link);
        if (!$link) {
            echo "Imposible conectar";
            exit;
        }
        mysql_select_db($this->database, $link);
    }

    /**
     * ejecuta consultas en la base de datos
     *
     * @param string $sql cadena para consulta
     */
    function ejecutarConsulta($sql) {
        //echo ("<br>sql:".$sql);
        $result = mysql_query($sql);

        if ($result){
            //$this->log->writeLog($sql);
            return $result;
        }
        else {
            $this->log->writeLog($sql."|".mysql_error());
        }
    }

    function recuperarResultado($result) {
        if ($result) {
            $row = mysql_fetch_array($result);
            return $row;
        }
    }

    function liberarResultado() {
        mysql_free_result();
    }

    /**
     * trae un valor de la base de datos cargado usando ejecutarConsulta
     */
    function recuperarCampo($tabla, $campo, $predicado) {
        $sql = "select " . $campo . " as valor from " . $tabla . " where " . $predicado;
        //echo ("<br>sql:".$sql);
        $result = $this->ejecutarConsulta($sql);
        $row = mysql_fetch_array($result);
        return $row["valor"];
    }

    /**
     * almacena en la base datos de acuerdo a los parametros
     *
     * @param string $tabla tabla afectada
     * @param string $campos campos afectados
     * @param string $valores valores almacenados
     */
    function insertarRegistro($tabla, $campos, $valores) {
        $temp = split(",",$valores);
        $valores = "";
        foreach ($temp as $t){
            if($t == "''"){
                $valores .= 'null,';
            }else{
                $valores .= $t.",";
            }
        }
        $valores = substr($valores, 0,  strlen($valores)-1);
        $sql = "insert into `" . $tabla . "`(" . $campos . ")values(" . $valores . ")";
        //echo $sql."<hr>";
        $row = mysql_query($sql);
        if ($row == 1) {
            $this->log->writeLog($sql);
            return "true";
        } else {
            $this->log->writeLog(mysql_error());
            return "false";
        }
    }

    /**
     * borra registros de la base datos de acuerdo a los parametros
     *
     * @param string $tabla tabla afectada
     * @param string $predicado condicion requerida
     */
    function borrarRegistro($tabla, $predicado) {
        $sql = "delete from " . $tabla . " where " . $predicado;
        //echo ("<br>borrar:".$sql);
        $row = mysql_query($sql);
        if ($row == 1) {
            $this->log->writeLog($sql);
            return "true";
        } else {
            $this->log->writeLog(mysql_error());
            return "false";
        }
    }
    
    function eliminarMultiplesRegistros($tabla, $predicado) {
        $sql = "delete from " . $tabla . " where " . $predicado;
        //echo ("<br>borrar:".$sql);
        $row = mysql_query($sql);
        if ($row == 1) {
           $this->log->writeLog($sql);
        } else {
            $this->log->writeLog(mysql_error());
        }
        return $row;
    }

    /**
     * actualiza registros en la base datos de acuerdo a los parametros
     *
     * @param string $tabla tabla afectada
     * @param string $campos campos afectados
     * @param string $valores valores almacenados
     * @param string $condicion where de la sentecia sql
     */
    function actualizarRegistro($tabla, $campos, $valores, $condicion) {
        $sql = "update " . $tabla . " set ";
        $cont = 0;

        foreach ($campos as $c) {
            if($valores[$cont] == "''" || $valores[$cont] == "")
                $sql .= $c . " = null , ";
            else
                $sql .= $c . " = " . $valores[$cont] . ", ";
            $cont++;
        }
        $sql = substr($sql, 0, strlen($sql) - 2);
        $sql .= " where " . $condicion;
        //echo ("<br>actualizar:".$sql);
        $row = mysql_query($sql);
        if ($row == 1) {
            $this->log->writeLog($sql);
            return "true";
        } else {
            $this->log->writeLog(mysql_error());
            return "false";
        }
    }
    
    function getMaxValue($tabla, $campo){
        $sql = "SELECT MAX(".$campo.") AS max FROM ". $tabla;
        $result = $this->ejecutarConsulta($sql);
        $row = mysql_fetch_array($result);
        return $row["max"];
    }

}
?>

