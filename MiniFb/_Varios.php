<?php

declare(strict_types=1);

function obtenerPdoConexionBD(): PDO
{
    $servidor = "localhost";
    $bd = "MiniFb";
    $identificador = "root";
    $contrasenna = "";
    $opciones = [
        PDO::ATTR_EMULATE_PREPARES   => false, // turn off emulation mode for "real" prepared statements
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, //turn on errors in the form of exceptions
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, //make the default fetch be an associative array
    ];

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
    } catch (Exception $e) {
        error_log("Error al conectar: " . $e->getMessage()); // El error se vuelca a php_error.log
        exit('Error al conectar'); //something a user can understand
    }

    return $conexion;
}

session_start();



function obtenerUsuario(string $identificador, string $contrasenna): ? array
{
    // TODO Pendiente hacer.
    $conexion = obtenerPdoConexionBD();

    $sql = "SELECT * FROM Usuario WHERE identificador=? AND contrasenna=?";

    $select = $conexion->prepare($sql);
    $select->execute([$identificador, $contrasenna]);
    $rs = $select->fetchAll();
    // Conectar con BD, lanzar consulta, ver si viene 1 fila o ninguna...

    if ($select->rowCount() == 1) {
        return $rs[0];
    } else if ($select->rowCount() == 0) {
        return null;
    }

}



    function marcarSesionComoIniciada(array $arrayUsuario)
    {
        // TODO Anotar en el post-it todos estos datos:
        $_SESSION["id"] = $arrayUsuario["id"];
        $_SESSION["identificador"] = $arrayUsuario["identificador"];
        $_SESSION["contrasenna"] = $arrayUsuario["contrasenna"];
        $_SESSION["codigoCookie"] = $arrayUsuario["codigoCookie"];
        $_SESSION["tipoUsuario"] = $arrayUsuario["tipoUsuario"];
        $_SESSION["nombre"] = $arrayUsuario["nombre"];
        $_SESSION["apellidos"] = $arrayUsuario["apellidos"];
    }



    function haySesionIniciada(): bool
    {
        // Está iniciada si isset($_SESSION["id"])
        if (isset($_SESSION["id"])){
            return true;
        }else
            return false;
    }



    function crearUsuario(array $nuevaCuenta)
    {
        $sql = "INSERT INTO Usuario (identificador, contrasenna, tipoUsuario, nombre, apellidos) VALUES (?, ?, ?, ?, ?)";


        $sentencia = obtenerPdoConexionBD()->prepare($sql);
        $sentencia->execute([$nuevaCuenta[0], $nuevaCuenta[1], 0, $nuevaCuenta[2], $nuevaCuenta[3]]); // Se añaden los parámetros a la consulta preparada.
    }



    function pintarInfoSesion()
    {
        if (haySesionIniciada()) {
            echo "<span>Sesión iniciada por <a href='UsuarioPerfilVer.php'>$_SESSION[identificador]</a> ($_SESSION[nombre] $_SESSION[apellidos]) <a href='SesionCerrar.php'>Cerrar sesión</a></span>";
        } else {
            echo "<a href='SesionInicioMostrarFormulario.php'>Iniciar sesión</a>";
        }
    }



    function cerrarSesion()
    {
        session_destroy();
        unset($_SESSION);
    }



    function generarCodigoCookie(array $arrayUsuario)
    {
        $codigoCookie = generarCadenaAleatoria(32);

        $sql = "UPDATE Usuario SET codigoCookie=? WHERE identificador=?";

        $sentencia = obtenerPdoConexionBD()->prepare($sql);
        $sentencia ->execute([$codigoCookie, $arrayUsuario["identificador"]]);

        setcookie("codigoCookie", $codigoCookie);
        setcookie("identificador", $arrayUsuario["identificador"]);
    }



    function intentarCanjearCodigoCookie():bool
    {

        if(!isset($_COOKIE["identificador"]) || !isset($_COOKIE["codigoCookie"]))
        {
            return false;
        }

        $codigoCookie = $_COOKIE["codigoCookie"];
        $identificador = $_COOKIE["identificador"];

        $sql= "SELECT * FROM Usuario WHERE identificador=? AND BINARY codigoCookie=?";
        $select = obtenerPdoConexionBD()->prepare($sql);
        $select->execute($codigoCookie, $identificador);

        $rs = $select->fetchAll();


        if ($select->rowCount() == 1) {
            return true;
        } else if ($select->rowCount() == 0) {
            return false;
        }
    }



    function generarCadenaAleatoria(int $longitud): string
    {
        for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789') - 1; $i != $longitud; $x = rand(0, $z), $s .= $a[$x], $i++) ;
        return $s;
    }


    function redireccionar(string $url)
    {
        header("Location: $url");
        exit;
    }

    function syso(string $contenido)
    {
        file_put_contents('php://stderr', $contenido . "\n");
    }
