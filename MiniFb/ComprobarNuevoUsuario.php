<?php

require_once "_Varios.php";

$nuevaCuenta[0] = $_REQUEST["identificador"];
$nuevaCuenta[1] = $_REQUEST["contrasenna"];
$nuevaCuenta[2] = $_REQUEST["nombre"];
$nuevaCuenta[3] = $_REQUEST["apellidos"];

crearUsuario($nuevaCuenta);

redireccionar("SesionInicioMostrarFormulario.php");
