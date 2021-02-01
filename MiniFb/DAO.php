<?php

require_once "Clases.php";
require_once "Varios.php";

class DAO
{
    private static ?PDO $pdo = null;

    /* CONEXION Y ACCESO A BASE DE DATOS */

    public static function intentarCanjearSesionCookie(): bool
    {
        if (isset($_COOKIE["identificador"]) && isset($_COOKIE["codigoCookie"])) {
            $arrayUsuario = self::obtenerUsuarioPorCodigoCookie($_COOKIE["identificador"], $_COOKIE["codigoCookie"]);

            if ($arrayUsuario) {
                self::establecerSesionRam($arrayUsuario);
                self::establecerSesionCookie($arrayUsuario);
                return true;
            } else {
                self::borrarCookies();
                return false;
            }
        } else {
            self::borrarCookies();
            return false;
        }
    }

    public static function obtenerUsuarioPorCodigoCookie(string $identificador, string $codigoCookie): ?array
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM Usuario WHERE identificador=? AND BINARY contrasenna=?",
            [$identificador, $codigoCookie]
        );

        return $rs[0];
    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        return $select->fetchAll();
    }

    /* COOKIES Y SESIONES */

    private static function obtenerPdoConexionBD(): PDO
    {
        $servidor = "localhost";
        $bd = "MiniFb";
        $identificador = "root";
        $contrasenna = "";
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $conexion = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit('Error al conectar');
        }

        return $conexion;
    }

    public static function establecerSesionRam(array $arrayUsuario)
    {
        $_SESSION["id"] = $arrayUsuario["id"];
        $_SESSION["identificador"] = $arrayUsuario["identificador"];
        $_SESSION["tipoUsuario"] = $arrayUsuario["tipoUsuario"];
        $_SESSION["nombre"] = $arrayUsuario["nombre"];
        $_SESSION["apellidos"] = $arrayUsuario["apellidos"];
        $_SESSION["codigoCookie"] = $arrayUsuario["codigoCookie"];
    }

    public static function establecerSesionCookie(array $arrayUsuario)
    {
        $codigoCookie = generarCadenaAleatoria(32);

        self::actualizarCodigoCookieEnBD($codigoCookie);

        setcookie("identificador", $arrayUsuario["identificador"], time() + 600);
        setcookie("codigoCookie", $codigoCookie, time() + 600);
    }

    public static function actualizarCodigoCookieEnBD(?string $codigoCookie)
    {
        self::ejecutarActualizacion(
            "UPDATE Usuario SET codigoCookie=? WHERE identificador=?",
            [$codigoCookie, $_SESSION["identificador"]]
        );
    }

    private static function ejecutarActualizacion(string $sql, array $parametros): ?int
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        $sqlConExito = $actualizacion->execute($parametros);

        if (!$sqlConExito) return null;
        else return $actualizacion->rowCount();
    }

    public static function borrarCookies()
    {
        setcookie("identificador", "", time() - 3600);
        setcookie("codigoCookie", "", time() - 3600);
    }

    public static function pintarInfoSesion()
    {
        if (DAO::haySesionRamIniciada()) {
            echo "<span>Sesión iniciada por <a href='UsuarioPerfilVer.php'>$_SESSION[identificador]</a> ($_SESSION[nombre] $_SESSION[apellidos]) <a href='./SesionCerrar.php'>Cerrar sesión</a></span>";
        } else {
            echo "<a href='SesionInicioFormulario.php'>Iniciar sesión</a>";
        }
    }

    public static function haySesionRamIniciada(): bool
    {
        return isset($_SESSION["id"]);
    }


    public static function destruirSesionRamYCookie()
    {
        session_destroy();
        self::actualizarCodigoCookieEnBD(Null);
        self::borrarCookies();
        unset($_SESSION);
    }

    /* -------------------------------------------USUARIOS ------------------------------*/


    public static function usuarioCrearDesdeRs(array $usuario): Usuario
    {
        return new Usuario($usuario["id"], $usuario["identificador"], $usuario["contrasenna"], $usuario["codigoCookie"], $usuario["caducidadCodigoCookie"], $usuario["tipoUsuario"], $usuario["nombre"], $usuario["apellidos"]);
    }


    public static function crearUsuario(array $arrayUsuarioNuevo): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO Usuario (identificador, contrasenna, codigoCookie, caducidadCodigoCookie, tipoUsuario, nombre, apellidos) VALUES (?, ?, NULL, NULL, 0, ?, ?)",
            [$arrayUsuarioNuevo["identificador"], $arrayUsuarioNuevo["contrasenna"], $arrayUsuarioNuevo["nombre"], $arrayUsuarioNuevo["apellidos"]]
        );
    }

    public static function obtenerUsuarioPorContrasenna(string $identificador, string $contrasenna): ?array
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE identificador=? AND BINARY contrasenna=?",
            [$identificador, $contrasenna]
        );

        return $rs[0];
    }

    public static function obtenerNombreUsuario(int $id): ?string
    {
        $usuario = self::obtenerUsuarioPorId($id);
        return $usuario->getNombre();
    }

    public static function obtenerUsuarioPorId(int $id): ?Usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE id=?",
            [$id]
        );

        if ($rs) return self::usuarioCrearDesdeRs($rs[0]);
        else return null;
    }


    public static function datosUsuarioNuevo(): array
    {
        $arrayUsuarioNuevo["identificador"] = $_REQUEST["identificador"];
        $arrayUsuarioNuevo["contrasenna"] = $_REQUEST["contrasenna"];
        $arrayUsuarioNuevo["contrasenna2"] = $_REQUEST["contrasenna2"];
        $arrayUsuarioNuevo["nombre"] = $_REQUEST["nombre"];
        $arrayUsuarioNuevo["apellidos"] = $_REQUEST["apellidos"];

        return $arrayUsuarioNuevo;
    }

    public static function comprobarIdentificadorDisponible(string $identificador): bool
    {

        $rs = self::ejecutarConsulta(
            "SELECT identificador FROM usuario WHERE identificador=?",
            [$identificador]
        );

        if ($rs) return false;
        else return true;
    }


    /* -------------------------------------PUBLICACIONES ----------------------*/

    private static function publicacionCrearDesdeRs(array $publicacion): Publicacion
    {
        return new Publicacion($publicacion["id"], $publicacion["fecha"], $publicacion["emisorId"], $publicacion["destinatarioId"], $publicacion["destacadaHasta"], $publicacion["asunto"], $publicacion["contenido"]);
    }


    public static function obtenerTodasPublicacionesPublicas(): ?array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM publicacion WHERE destinatarioId IS NULL ORDER BY fecha DESC ",
            []
        );

        foreach ($rs as $fila) {
            $publicacion = self::publicacionCrearDesdeRs($fila);
            array_push($datos, $publicacion);
        }

        return $datos;
    }


    public static function obtenerPublicacionesConDestinatario(int $destinatarioId): ?array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM publicacion WHERE destinatarioId = ? ORDER BY fecha DESC",
            [$destinatarioId]
        );

        foreach ($rs as $fila) {
            $publicacion = self::publicacionCrearDesdeRs($fila);
            array_push($datos, $publicacion);
        }

        return $datos;
    }


    public static function crearNuevaPublicacion(?int $destinatarioId, string $asunto, string $contenido)
    {
        self::ejecutarActualizacion(
            "INSERT INTO publicacion (fecha, emisorId, destinatarioId, destacadaHasta, asunto, contenido) VALUES (?, ?, ?, null, ?, ?)",
            [(date('Y-m-d H:i:s')), $_SESSION['id'], $destinatarioId, $asunto, $contenido]
        );

    }
}
