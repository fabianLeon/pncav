<?php

class CRegistroInversionData {
    var $db = null;

    function CRegistroInversionData($db) {
        $this->db = $db;
    }
    /*
     * Obtiene todos los registros de la base de datos
     */
    function getRegistroInversion($criterio) {
        $resultado = null;
        $sql = "select rin.rin_id ,act.act_descripcion, rin.rin_fecha, pro.nombre_prove, "
                . " rin.rin_numero_documento, rin.rin_valor, rin.rin_observaciones, rin.rin_documento_soporte"
                . " from registro_inversion rin "
                . " left join actividadPIA act on rin.act_id = act.act_id "
                . " left join proveedores pro on pro.id_prove = rin.id_prove"
                . " where " . $criterio;
        //echo $sql;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $resultado[$cont]['id_element'] = $w['rin_id'];
                $resultado[$cont]['actividad'] = $w['act_descripcion'];
                $resultado[$cont]['fecha'] = $w['rin_fecha'];
                $resultado[$cont]['proveedor'] = $w['nombre_prove'];
                $resultado[$cont]['numero_documento'] = $w['rin_numero_documento'];
                $resultado[$cont]['valor'] = $w['rin_valor'];
                $resultado[$cont]['observaciones'] = $w['rin_observaciones'];
                $resultado[$cont]['documento_soporte'] = "<a href='././soportes/Interventoria/Registro Inversion/" .$w['rin_documento_soporte']."' target='_blank'>{$w['rin_documento_soporte']}</a>";
                
                $cont++;
            }
        }
        return $resultado;
    }
    /*
     * insertar un registro en la base de datos
     */
    function insertRegistroInversion($actividad,$fecha ,$proveedor , $numero_documento ,$valor ,$observaciones,$documento_soporte ) {
        $tabla = 'registro_inversion';
        $campos = 'act_id, rin_fecha, id_prove,rin_numero_documento, rin_valor, rin_observaciones, rin_documento_soporte';
        $valores = "'". $actividad . "','" 
                . $fecha . "','" 
                . $proveedor . "','" 
                . $numero_documento . "','" 
                . $valor . "','" 
                . $observaciones . "','" 
                .$documento_soporte. "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        return $r;
    }
    /*
     * Eliminar un registro 
     */
    function deleteRegistroInversion ($id){
        $tabla = 'registro_inversion';
        $predicado = "rin_id = " . $id;
        $r = $this->db->borrarRegistro($tabla, $predicado);
        return $r;
    }
    /*
     * 
     */
    function getRegistroInversionById($id) {
        $sql = "select rin.rin_id ,act.act_id, rin.rin_fecha, pro.id_prove, "
                . " rin.rin_numero_documento, rin.rin_valor, rin.rin_observaciones, rin.rin_documento_soporte"
                . " from registro_inversion rin "
                . " left join actividadPIA act on rin.act_id = act.act_id "
                . " left join proveedores pro on pro.id_prove = rin.id_prove"
                . " where rin.rin_id = " . $id;
        
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));

        if ($r)
            return $r;
        else
            return -1;
    }
    
    function updateRegistroInversion($id, $actividad,$fecha ,$proveedor , $numero_documento ,$valor ,$observaciones,$documento_soporte) {
        $tabla = 'registro_inversion';
        $campos = array('act_id',' rin_fecha',' id_prove','rin_numero_documento',' rin_valor',''
            . ' rin_observaciones',' rin_documento_soporte');
        $valores = array("'" . $actividad . "'",
            "'" . $fecha . "'",
            "'" . $proveedor . "'",
            "'" . $numero_documento . "'",
            "'" . $valor . "'",
            "'" . $observaciones . "'",
            "'" . $documento_soporte ."'");
        $condicion = " rin_id = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        return $r;
    }
    /*
     * Obtiene la lista de actividadPIA
     */
    function getActividades() {
        $resultado = null;
        $sql = "select act_id,act_descripcion from actividadPIA";
        //echo("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $resultado[$cont]['id'] = $w['act_id'];
                $resultado[$cont]['nombre'] = $w['act_descripcion'];
                $cont++;
            }
        }
        return $resultado;
    }
    
    function getProveedores() {
        $resultado = null;
        $sql = "select Id_Prove,Nombre_Prove from proveedores";
        //echo("<br>sql:".$sql);
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;
            while ($w = mysql_fetch_array($r)) {
                $resultado[$cont]['id'] = $w['Id_Prove'];
                $resultado[$cont]['nombre'] = $w['Nombre_Prove'];
                $cont++;
            }
        }
        return $resultado;
    }
}
?>