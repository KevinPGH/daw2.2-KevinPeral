<?php

require_once "DAO.php";

$arrayUsuarioNuevo = DAO::datosUsuarioNuevo();

$identificador = $arrayUsuarioNuevo["identificador"];
$nombre = $arrayUsuarioNuevo["nombre"];
$apellidos = $arrayUsuarioNuevo["apellidos"];

if ($arrayUsuarioNuevo["contrasenna"] !== $arrayUsuarioNuevo["contrasenna2"]) {
    redireccionar("UsuarioNuevoFormulario.php?contrasennaIncorrecta&identificador=$identificador&nombre=$nombre&apellidos=$apellidos");

} else if (DAO::comprobarIdentificadorDisponible($arrayUsuarioNuevo["identificador"])) {

    if (DAO::crearUsuario($arrayUsuarioNuevo)) {
        redireccionar("SesionInicioFormulario.php?nuevo");
    }

} else {
    redireccionar("UsuarioNuevoFormulario.php?usuarioErroneo&identificador=$identificador&nombre=$nombre&apellidos=$apellidos");
}