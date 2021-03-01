<?php

require_once "_com/DAO.php";

$identificador = $_REQUEST["identificador"];
$contrasenna = $_REQUEST["contrasenna"];

$arrayUsuario = DAO::usuarioObtener($_REQUEST["identificador"], $_REQUEST["contrasenna"]);

if ($arrayUsuario) { // HAN venido datos: identificador existía y contraseña era correcta.

    DAO::marcarSesionComoIniciada($arrayUsuario);

    if (isset($_REQUEST["recordar"])) {
        DAO::generarCookieRecordar();
    } else {
        DAO::borrarCookieRecordar();
    }
    redireccionar("PaginaPrincipal.php");

} else {
    redireccionar("SesionInicioFormulario.php?datosErroneos");
}