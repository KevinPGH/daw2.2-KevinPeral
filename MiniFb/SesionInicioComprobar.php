<?php

require_once "DAO.php";

$arrayUsuario = DAO::obtenerUsuarioPorContrasenna($_REQUEST["identificador"], $_REQUEST["contrasenna"]);
$recordarme = $_REQUEST["recordarme"];

if ($arrayUsuario) {
    DAO::establecerSesionRam($arrayUsuario);
    redireccionar("MuroVerGlobal.php");
    if (isset($recordarme)) DAO::establecerSesionCookie($arrayUsuario);


} else {
    redireccionar("SesionInicioFormulario.php?datosErroneos");
}