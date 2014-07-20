<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CProveedorData
 *
 * @author Personal
 */
class CProveedorData {

    var $db = null;

    function CProveedorData($db) {
        $this->db = $db;
    }

    function obtenerproveedores($criterio) {

        if ($criterio == '') {
            $sql = "SELECT Id_Prove, Nit_Prove, Nombre_Prove, Telefono_Prove, 
                CONCAT( Nombre_Pais,  ', ', Nombre_Ciudad,  '. ', Direcc_Prove ) , 
                CONCAT(UPPER(LEFT(Nom_Contac_Prove,1)), LOWER(SUBSTRING(Nom_Contac_Prove,2))
                , ' ', UPPER(LEFT(ApellA_Contac,1)), LOWER(SUBSTRING(ApellA_Contac,2)),  ' ',
                UPPER(LEFT(ApellB_Contac,1)), LOWER(SUBSTRING(ApellB_Contac,2)) ) 
                , Tel_Contac_Prove, Email_Prove
                    FROM proveedores p
                    INNER JOIN pais pa ON p.Pais_Prove = pa.Id_Pais
                    INNER JOIN ciudad c ON p.Ciudad_Prove = c.Id_Ciudad";
        }
        else 
            $sql = "SELECT Id_Prove, Nit_Prove, Nombre_Prove, Telefono_Prove, CONCAT( Nombre_Pais,  ', ', Nombre_Ciudad,  '. ', Direcc_Prove ) , CONCAT( Nom_Contac_Prove,  ' ', ApellA_Contac,  ' ', ApellB_Contac ) , Tel_Contac_Prove, Email_Prove
                    FROM proveedores p
                    INNER JOIN pais pa ON p.Pais_Prove = pa.Id_Pais
                    INNER JOIN ciudad c ON p.Ciudad_Prove = c.Id_Ciudad where Nit_Prove like '%".$criterio."%' OR Nombre_Prove like '%".$criterio."%'";
        
       $provedores = null;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $cont = 0;

            while ($w = mysql_fetch_array($r)) {
                for ($i = 0; $i < count($w) / 2; $i++) {
                    $provedores[$cont][$i] = $w[$i];
                }
                $cont++;
            }
        }

        return $provedores;
    }

    function insertarproveedor($id, $nit, $nombre, $telefono, $pais, $ciudad, $direccion, $contactoprove, $contactoproveA, $contactoproveB, $telcontac, $email) {
        $tabla = "proveedores";
        $campos = "Id_Prove,Nit_Prove,Nombre_Prove,Telefono_Prove,Pais_Prove, 
				   Ciudad_Prove,Direcc_Prove,Nom_Contac_Prove,ApellA_Contac,ApellB_Contac,Tel_Contac_Prove,Email_Prove";
        $valores = "'" . $id . "','" . $nit . "','" . $nombre . "','" . $telefono . "',
					'" . $pais . "','" . $ciudad . "','" . $direccion . "','" . $contactoprove . "','" . $contactoproveA . "','" . $contactoproveB . "','" . $telcontac . "','" . $email . "'";
        $r = $this->db->insertarRegistro($tabla, $campos, $valores);
        if ($r == "true") {
            return MENSAJE_AGREGAR_EXITO_PROVEEDOR;
        } else {
            return MENSAJE_AGREGAR_FRACASO_PROVEEDOR;
        }
    }

    function eliminarprove($r) {
        $tabla = "proveedores";
        $predicado = "Id_Prove=" . $r;
        $e = $this->db->borrarRegistro($tabla, $predicado);
        if ($e == "true") {
            return 1;
        } else {
            return 0;
        }
    }

    function obtenerproveedorbyid($id) {
        $sql = "select * from proveedores where Id_Prove= " . $id;
        $r = $this->db->recuperarResultado($this->db->ejecutarConsulta($sql));
        if ($r)
            return $r;
        else
            return -1;
    }

    function actualizaproveedor($id, $Nit, $NombreProveedor, $TelefonoProveedor, $pais, $ciudad, $Direccion, $NombredelContacto, $apellidoA, $apellidoB, $TelefonodelCotacto, $email) {

        $tabla = "proveedores";
        $campos = array('Nit_Prove', 'Nombre_Prove', 'Telefono_Prove', 'Pais_Prove',
            'Ciudad_Prove', 'Direcc_Prove', 'Nom_Contac_Prove', 'ApellA_Contac', 'ApellB_Contac', 'Tel_Contac_Prove', 'Email_Prove');
        $valores = array("'" . $Nit . "'", "'" . $NombreProveedor . "'", "'" . $TelefonoProveedor . "'", "'" . $pais . "'", "'" . $ciudad . "'", "'" . $Direccion . "'", "'" . $NombredelContacto . "'", "'" . $apellidoA . "'", "'" . $apellidoB . "'", "'" . $TelefonodelCotacto . "'", "'" . $email . "'");

        $condicion = "Id_Prove = " . $id;
        $r = $this->db->actualizarRegistro($tabla, $campos, $valores, $condicion);
        if ($r == "true") {
            return 1;
        } else {
            return 0;
        }
    }
    
    
    function ObtenerPaises() {
        $tipos = null;
        $sql = "select * from pais " ;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $tipos[$contador]['id'] = $w['Id_Pais'];
                $tipos[$contador]['nombre'] = $w['Nombre_Pais'];
                $contador++;
            }
        }
        return $tipos;
    }
    function ObtenerCiudades($id_pais) {
        $tipos = null;
        $sql = "SELECT Id_Ciudad,Nombre_Ciudad  FROM ciudad WHERE Id_Pais =".$id_pais ;
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $tipos[$contador]['id'] = $w['Id_Ciudad'];
                $tipos[$contador]['nombre'] = $w['Nombre_Ciudad'];
                $contador++;
            }
        }
        return $tipos;
    }
    function ObtenerCiudadesFadein() {
        $tipos = null;
        $sql = "SELECT Id_Ciudad,Nombre_Ciudad  FROM ciudad";
        $r = $this->db->ejecutarConsulta($sql);
        if ($r) {
            $contador = 0;
            while ($w = mysql_fetch_array($r)) {
                $tipos[$contador]['id'] = $w['Id_Ciudad'];
                $tipos[$contador]['nombre'] = $w['Nombre_Ciudad'];
                $contador++;
            }
        }
        return $tipos;
    }

}
