<?php

require_once "_Varios.php";


$identificador = $_REQUEST["identificador"];
$contrasenna = $_REQUEST["contrasenna"];
$recordarme = $_REQUEST["recordarme"];

// TODO Verificar (usar funciones de _Varios.php) identificador y contrasenna recibidos y redirigir a ContenidoPrivado1 (si OK) o a iniciar sesión (si NO ok).

$arrayUsuario = obtenerUsuario($identificador, $contrasenna);

if ($arrayUsuario)
{ // HAN venido datos: identificador existía y contraseña era correcta.
    marcarSesionComoIniciada($arrayUsuario);
    redireccionar("ContenidoPrivado1.php?");
    if(isset($recordarme)){
        generarCodigoCookie();
    }
} else
    {
    redireccionar("SesionInicioMostrarFormulario.php");
    }