<?php

declare(strict_types=1);

session_start();

function redireccionar(string $url)
{
    header("Location: $url");
    exit;
}

function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}

function obtenerFecha(): string
{
    return date("Y-m-d H:i:s");
}

function generarCadenaAleatoria($longitud): string
{
    for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1; $i != $longitud; $x = rand(0, $z), $s .= $a[$x], $i++) ;
    return $s;
}

function pintarInfoSesion()
{
    if (DAO::haySesionRamIniciada()) {
        echo "<span>Sesión iniciada por <a href='UsuarioFicha.php'>$_SESSION[identificador]</a> ($_SESSION[nombre] $_SESSION[apellidos]) <br><a href='./SesionCerrar.php'>Cerrar sesión</a></span>";
    }
}

function cerrarSesionRamYCookie()
{
    session_destroy();
    unset($_SESSION); // Por si acaso

    if (isset($_COOKIE["codigoCookie"])) {
        unset($_COOKIE["codigoCookie"]);
        setcookie("codigoCookie", "", time() - 3600);
    }

    if (isset($_COOKIE["identificador"])) {
        unset($_COOKIE["identificador"]);
        setcookie("identificador", "", time() - 3600);
    }
}

function comprobarTema(): bool
{
    if (isset($_REQUEST["oscuro"]) || (isset($_SESSION["oscuro"])) && (!isset($_REQUEST["claro"]))) {
        unset($_SESSION["claro"]);
        $_SESSION["oscuro"] = true;
        unset($_SESSION["claro"]);
        $tema = true;
    } else if ((isset($_REQUEST["claro"])) || (!isset($_REQUEST["claro"])) || (isset($_SESSION["claro"]))) {
        unset($_SESSION["oscuro"]);
        $tema = false;
    } else {
        unset($_SESSION["oscuro"]);
        $tema = false;
    }

    return $tema;
}

function cambiarTemaLinks()
{

    $archivoActual = $_SERVER['PHP_SELF'];

    if (isset($_SESSION["oscuro"])) {
        echo "<a class='enlace-volver' href='$archivoActual?claro'>TEMA CLARO</a>";
    } else {
        echo "<a class='enlace-volver' href='$archivoActual?oscuro'>TEMA OSCURO</a>";
    }
}
