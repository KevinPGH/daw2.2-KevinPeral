<?php

require_once "_com/DAO.php";

$id = $_REQUEST["id"];
$identificador = $_REQUEST["identificador"];
$contrasenna = $_REQUEST["contrasenna"];

$contrasennaNueva = ($id == -1);
if ($contrasennaNueva) {
    DAO::usuarioModificarContrasenna();

} else {

    $nombre = $_REQUEST["nombre"];
    $apellidos = $_REQUEST["apellidos"];
    $email = $_REQUEST["email"];

    DAO::usuarioModificar();
}
redireccionar("PaginaPrincipal.php");