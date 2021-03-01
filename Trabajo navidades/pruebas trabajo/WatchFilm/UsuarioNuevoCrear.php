<?php

require_once "_com/DAO.php";

$arrayUsuarioNuevo["identificador"] = $_REQUEST["identificador"];
$arrayUsuarioNuevo["email"] = $_REQUEST["email"];
$arrayUsuarioNuevo["contrasenna"] = $_REQUEST["contrasenna"];
$arrayUsuarioNuevo["contrasenna2"] = $_REQUEST["contrasenna2"];
$arrayUsuarioNuevo["nombre"] = $_REQUEST["nombre"];
$arrayUsuarioNuevo["apellidos"] = $_REQUEST["apellidos"];

$identificador = $arrayUsuarioNuevo["identificador"];
$nombre = $arrayUsuarioNuevo["nombre"];
$apellidos = $arrayUsuarioNuevo["apellidos"];
$email = $arrayUsuarioNuevo["email"];

if ($arrayUsuarioNuevo["contrasenna"] !== $arrayUsuarioNuevo["contrasenna2"]) {
    redireccionar("UsuarioNuevoFormulario.php?contrasennaIncorrecta&identificador=$identificador&nombre=$nombre&apellidos=$apellidos&email=$email");

} else if (!DAO::comprobarIdentificadorDisponible($arrayUsuarioNuevo["identificador"])) {

    if (DAO::crearUsuario($arrayUsuarioNuevo)) {
        redireccionar("SesionInicioFormulario.php?nuevo");
    }

} else {
    redireccionar("UsuarioNuevoFormulario.php?usuarioNoValido&identificador=$identificador&nombre=$nombre&apellidos=$apellidos&email=$email");
}