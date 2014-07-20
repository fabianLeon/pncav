<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CProveedor
 *
 * @author Personal
 */
class CProveedor {

    var $id = null;
    var $Nit = null;
    var $NombreProveedor = null;
    var $TelefonoProveedor = null;
    var $PaisProveedor = null;
    var $CiudadProveedor = null;
    var $apellido1Proveedor = null;
    var $apellido2Proveedor = null;
    var $Direccion = null;
    var $NombredelContacto = null;
    var $TelefonodelCotacto = null;
    var $email = null;
    var $ee = null;

//definimos los atributos de la clase y creamos el constructor de la misma

    function CProveedor($id, $Nit, $NombreProveedor, $TelefonoProveedor, $pais, $ciudad, $Direccion, $NombredelContacto, $apellido1Proveedor, $apellido2Proveedor, $TelefonodelCotacto, $email, $ee) {
        $this->id = $id;
        $this->Nit = $Nit;
        $this->NombreProveedor = $NombreProveedor;
        $this->TelefonoProveedor = $TelefonoProveedor;
        $this->PaisProveedor = $pais;
        $this->CiudadProveedor = $ciudad;
        $this->Direccion = $Direccion;
        $this->NombredelContacto = $NombredelContacto;
        $this->apellido1Proveedor = $apellido1Proveedor;
        $this->apellido2Proveedor = $apellido2Proveedor;
        $this->TelefonodelCotacto = $TelefonodelCotacto;
        $this->email = $email;

        $this->ee = $ee;
    }

    function getid() {
        return $this->id;
    }

    function getNit() {
        return $this->Nit;
    }

    function getNombreProveedor() {
        return $this->NombreProveedor;
    }

    function getTelefonoProveedor() {
        return $this->TelefonoProveedor;
    }

    function getPaisProveedor() {
        return $this->PaisProveedor;
    }

    function getCiudadProveedor() {
        return $this->CiudadProveedor;
    }

    function getDireccion() {
        return $this->Direccion;
    }

    function getapellidoA() {
        return $this->apellido1Proveedor;
    }

    function getapellidoB() {
        return $this->apellido2Proveedor;
    }

    function getNombredelContacto() {
        return $this->NombredelContacto;
    }

    function getTelefonodelCotacto() {
        return $this->TelefonodelCotacto;
    }

    function getemail() {
        return $this->email;
    }

    /**
     * cargarproveedor, permite cargar el objeto proveedor para modificarlo y eliminarlo 
     */
    function cargarproveedor() {
        $r = $this->ee->obtenerproveedorbyid($this->id);
        if ($r != -1) {
            $this->id = $r['Id_Prove'];
            $this->Nit = $r['Nit_Prove'];
            $this->NombreProveedor = $r['Nombre_Prove'];
            $this->TelefonoProveedor = $r['Telefono_Prove'];
            $this->PaisProveedor = $r['Pais_Prove'];
            $this->CiudadProveedor = $r['Ciudad_Prove'];
            $this->Direccion = $r['Direcc_Prove'];
            $this->NombredelContacto = $r['Nom_Contac_Prove'];
            $this->apellido1Proveedor = $r['ApellA_Contac'];
            $this->apellido2Proveedor = $r['ApellB_Contac'];
            $this->TelefonodelCotacto = $r['Tel_Contac_Prove'];
            $this->email = $r['Email_Prove'];
        } else {
            $this->id = "";
            $this->Nit = "";
            $this->NombreProveedor = "";
            $this->TelefonoProveedor = "";
            $this->PaisProveedor = "";
            $this->CiudadProveedor = "";
            $this->Direccion = "";
            $this->NombredelContacto = "";
            $this->apellido1Proveedor = "";
            $this->apellido2Proveedor = "";
            $this->TelefonodelCotacto = "";
            $this->email = "";
        }
    }

    /**
     * eliminarproveedor, elimina el objeto proveedor de la base de datos
     */
    function eliminarproveedor($id) {

        $r = $this->ee->eliminarprove($id);

        if ($r == 1) {
            $ms1 = MENSAJE_BORRAR_EXITO_PROVEEDOR;
        } else {
            $ms1 = MENSAJE_BORRAR_FRACASO_PROVEEDOR;
        }
        return $ms1;
    }

    /**
     * actualizarproveedor, actualiza los atributos  del objeto proveedor de la base de datos
     */
    function actualizarproveedor($id, $Nit, $NombreProveedor, $TelefonoProveedor, $pais, $ciudad, $Direccion, $NombredelContacto, $apellidoA, $apellidoB, $TelefonodelCotacto, $email) {

        $r = $this->ee->actualizaproveedor($id, $Nit, $NombreProveedor, $TelefonoProveedor, $pais, $ciudad, $Direccion, $NombredelContacto, $apellidoA, $apellidoB, $TelefonodelCotacto, $email);

        if ($r == 1) {
            $ms = MENSAJE_EDITAR_EXITO_PROVEEDOR;
        } else {
            $ms = MENSAJE_BORRAR_FRACASO_PROVEEDOR;
        }
        return $ms;
    }

}
