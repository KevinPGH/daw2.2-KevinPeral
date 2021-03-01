<?php
require_once "Utilidades.php";
require_once "Clases.php";

class DAO
{
    private static ?PDO $pdo = null;

    public static function haySesionRamIniciada(): bool
    {
        return isset($_SESSION["id"]);
    }

    public static function intentarCanjearSesionCookie(): bool
    {
        if ((isset($_COOKIE["identificador"])) && (isset($_COOKIE["codigoCookie"]))) {

            $rs = self::ejecutarConsulta(
                "SELECT * FROM usuario WHERE identificador=? AND BINARY codigoCookie=?",
                [$_COOKIE["identificador"], $_COOKIE["codigoCookie"]]
            );

            $identificador = $rs[0]["identificador"];
            $codigoCookie = $rs[0]["codigoCookie"];

            if ($rs) {
                return true;
            } else {
                setcookie("identificador", $identificador, time() - 3600);
                setcookie("codigoCookie", $codigoCookie, time() - 3600);
                return false;
            }

        }
        return false;

    }

    private static function ejecutarConsulta(string $sql, array $parametros): array
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $select = self::$pdo->prepare($sql);
        $select->execute($parametros);
        return $select->fetchAll();
    }

    /* SESION Y COOKIE */

    private static function obtenerPdoConexionBD(): PDO
    {
        $servidor = "localhost";
        $identificador = "root";
        $contrasenna = "";
        $bd = "watchfilm";
        $opciones = [
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $pdo = new PDO("mysql:host=$servidor;dbname=$bd;charset=utf8", $identificador, $contrasenna, $opciones);
        } catch (Exception $e) {
            error_log("Error al conectar: " . $e->getMessage());
            exit("Error al conectar" . $e->getMessage());
        }
        return $pdo;
    }

    public static function obtenerUsuarioPorCookie(string $codigoCookie): ?Usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE codigoCookie=?",
            [$codigoCookie]
        );
        if ($rs) return self::usuarioCrearDesdeRS($rs[0]);
        else return null;
    }

    private static function usuarioCrearDesdeRS(array $usuario): Usuario
    {
        return new Usuario($usuario["id"], $usuario["identificador"], $usuario["nombre"], $usuario["apellidos"], $usuario["email"], $usuario["contrasenna"], $usuario["codigoCookie"]);
    }

    public static function marcarSesionComoIniciada($usuario)
    {
        $_SESSION["id"] = $usuario->getId();
        $_SESSION["identificador"] = $usuario->getIdentificador();
        $_SESSION["nombre"] = $usuario->getNombre();
        $_SESSION["apellidos"] = $usuario->getApellidos();
        $_SESSION["email"] = $usuario->getEmail();
    }

    public static function generarCookieRecordar()
    {
        $arrayUsuario = DAO::usuarioObtener($_REQUEST["identificador"], $_REQUEST["contrasenna"]);
        $codigoCookie = generarCadenaAleatoria(32);

        self::ejecutarConsulta(
            "UPDATE usuario SET codigoCookie=? WHERE identificador=?",
            [$codigoCookie, $arrayUsuario->getIdentificador()]
        );


        $arrayCookies["identificador"] = setcookie("identificador", $arrayUsuario->getIdentificador(), time() + 60 * 60);
        $arrayCookies["codigoCookie"] = setcookie("codigoCookie", $codigoCookie, time() + 60 * 60);
    }

    public static function usuarioObtener(string $identificador, string $contrasenna): ?Usuario
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario WHERE identificador=? AND contrasenna =?",
            [$identificador, $contrasenna]
        );
        if ($rs) return self::usuarioCrearDesdeRS($rs[0]);
        else return null;
    }

    public static function borrarCookieRecordar()
    {
        $arrayUsuario = DAO::usuarioObtener($_REQUEST["identificador"], $_REQUEST["contrasenna"]);

        self::ejecutarConsulta(
            "UPDATE usuario SET codigoCookie=NULL WHERE identificador=?",
            [$arrayUsuario->getIdentificador()]
        );
        $identificador = $arrayUsuario->getIdentificador();
        setcookie("identificador", $identificador, time() - 3600);

        unset($_COOKIE["codigoCookie"]);
        setcookie("codigoCookie", "", time() - 3600);
        unset($_COOKIE["identificador"]);

    }

    /* USUARIO */

    public static function comprobarIdentificadorDisponible(string $identificador): array
    {
        return self::ejecutarConsulta(
            "SELECT identificador FROM usuario WHERE identificador=?",
            [$identificador]
        );
    }

    public static function obtenerusuario(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM usuario ",
            []
        );

        foreach ($rs as $fila) {
            $usuario = self::usuarioCrearDesdeRS($fila);
            array_push($datos, $usuario);
        }

        return $datos;
    }

    public static function crearUsuario(array $arrayUsuarioNuevo): bool
    {
        return self::ejecutarActualizacion(
            "INSERT INTO usuario (identificador, nombre, apellidos, email, contrasenna, codigoCookie) VALUES (?, ?, ?, ?, ?, NULL)",
            [$arrayUsuarioNuevo["identificador"], $arrayUsuarioNuevo["nombre"], $arrayUsuarioNuevo["apellidos"], $arrayUsuarioNuevo["email"], $arrayUsuarioNuevo["contrasenna"]]
        );
    }

    private static function ejecutarActualizacion(string $sql, array $parametros): bool
    {
        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        $actualizacion = self::$pdo->prepare($sql);
        return $actualizacion->execute($parametros);
    }

    public static function usuarioModificar()
    {
        $identificador = $_REQUEST["identificador"];
        $nombre = $_REQUEST["nombre"];
        $apellidos = $_REQUEST["apellidos"];
        $email = $_REQUEST["email"];


        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();
        self::ejecutarActualizacion("UPDATE usuario SET identificador=?,nombre=?,apellidos=?,email=? WHERE identificador=?", [$identificador, $nombre, $apellidos, $email, $identificador]);
    }

    public static function usuarioModificarContrasenna()
    {
        $identificador = $_REQUEST["identificador"];
        $contrasenna = $_REQUEST["contrasenna"];


        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();
        self::ejecutarActualizacion("UPDATE usuario SET contrasenna=? WHERE identificador=?", [$contrasenna, $identificador]);
    }


    public static function VerFichaUsuario(): array
    {

        $identificador = $_SESSION["identificador"];

        if (!isset(self::$pdo)) self::$pdo = self::obtenerPdoConexionBd();

        return self::ejecutarConsulta("SELECT * FROM usuario WHERE identificador=?", [$identificador]);
    }

    public static function usuarioEliminar(string $identificador)
    {

        if (!isset(Self::$pdo)) Self::$pdo = Self::obtenerPdoConexionBd();

        self::ejecutarActualizacion("DELETE FROM usuario WHERE identificador=?",
            [$identificador]);
    }

    /*----------------------------PELICULA-------------------------------*/

    public static function peliculaObtener(string $nombre): ?Pelicula
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM pelicula WHERE nombre LIKE ?",
            [$nombre]
        );
        if ($rs) return self::peliculaCrearDesdeRS($rs[0]);
        else return null;
    }

    private static function peliculaCrearDesdeRS(array $pelicula): Pelicula
    {
        return new Pelicula($pelicula["id"], $pelicula["nombre"], $pelicula["director"], $pelicula["genero"], $pelicula["anio"], $pelicula["puntuacion"], $pelicula["plataformaId"]);
    }

    public static function peliculasObtenerDesdeLista(int $listaId): ?array //permite obtener todas las peliculas de una lista
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM listausuariopeliculas WHERE listaId=?",
            [$listaId]
        );
        $arrayPeliculasLista = array();
        if ($rs) {
            for ($i = 0; $i < count($rs); $i++) {
                $pelicula = self::peliculaObtenerPorId($rs[$i]["peliculaId"]);
                array_push($arrayPeliculasLista, $pelicula);
            }
            return $arrayPeliculasLista;
        } else return null;
    }

    public static function peliculaObtenerPorId(int $peliculaId): ?Pelicula
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM pelicula WHERE id=?",
            [$peliculaId]
        );
        if ($rs) return self::peliculaCrearDesdeRS($rs[0]);
        else return null;
    }

    public static function peliculaObtenerTodas(): array
    {
        $datos = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM pelicula ORDER BY nombre",
            []
        );

        foreach ($rs as $fila) {
            $persona = self::peliculaCrearDesdeRs($fila);
            array_push($datos, $persona);
        }

        return $datos;
    }

    public static function peliculaObtenerNombrePlataforma(int $id): string
    {
        $categoria = self::plataformaObtenerPorId($id);
        return $categoria->getNombre();
    }

    /*---------------------------------Plataforma---------------------------------------*/

    public static function plataformaObtenerPorId(int $id): ?Plataforma
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM plataforma WHERE id=?",
            [$id]
        );
        if ($rs) return self::plataformaCrearDesdeRs($rs[0]);
        else return null;
    }

    private static function plataformaCrearDesdeRS(array $plataforma): Plataforma
    {
        return new Plataforma($plataforma["id"], $plataforma["nombre"]);
    }

    public static function plataformaObtener(string $nombre): ?Plataforma
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM plataforma WHERE nombre=?",
            [$nombre]
        );
        if ($rs) return self::plataformaCrearDesdeRS($rs[0]);
        else return null;
    }

    /*----------------------------LISTA-------------------------------*/

    public static function listasObtener(int $usuarioId): ?array
    {
        $rs = self::ejecutarConsulta(
            "SELECT * FROM lista WHERE usuarioId=?",
            [$usuarioId]
        );
        $arrayListas = array();
        if ($rs) {
            for ($i = 0; $i < count($rs); $i++) {
                $lista = new Lista($rs[$i]["id"], $rs[$i]["nombre"]);
                array_push($arrayListas, $lista);
            }
            return $arrayListas;
        } else return null;
    }

    public static function crearLista(string $nombre, int $usuarioId)
    {
        if ($nombre != "")
            self::ejecutarActualizacion("INSERT INTO lista (nombre, usuarioId) VALUES (?, ?);",
                [$nombre, $usuarioId]);
    }

    public static function modificarLista(string $nombre, int $id)
    {
        self::ejecutarActualizacion("UPDATE lista SET nombre=? WHERE id=?;",
            [$nombre, $id]);
    }

    public static function borrarLista(string $id, int $usuarioId)
    {
        self::ejecutarActualizacion("DELETE FROM lista WHERE id=? && usuarioId=? ;",
            [$id, $usuarioId]);
    }

    public static function aniadirPeliculaLista(string $idPelicula, string $idLista) //insertar peliculas en una lista si no están ya incluídas en dicha lsita
    {
        self::ejecutarActualizacion("INSERT INTO listausuariopeliculas (peliculaId, listaId) SELECT ?, ? WHERE NOT EXISTS(SELECT peliculaId, listaId FROM listausuariopeliculas WHERE peliculaId=? && listaId=?)", [$idPelicula, $idLista, $idPelicula, $idLista]);
    }

    public static function borrarPeliculaLista(int $idPelicula, int $idLista)
    {
        self::ejecutarActualizacion("DELETE FROM listausuariopeliculas WHERE peliculaId=? && listaId=?", [$idPelicula, $idLista]);
    }

    /*--------------------------------BÚSQUEDA---------------------------------*/

    public static function listarGeneros(): array
    {
        return self::ejecutarConsulta("SELECT DISTINCT genero FROM pelicula", []);
    }

    public static function buscarPeliculaPorNombre(string $nombre): ?array
    {
        $peliculas = [];
        $nombreDef = "%" . $nombre . "%";
        $rs = self::ejecutarConsulta(
            "SELECT * FROM pelicula WHERE nombre LIKE ?",
            [$nombreDef]
        );


        foreach ($rs as $fila) {
            $pelicula = self::peliculaCrearDesdeRS($fila);
            array_push($peliculas, $pelicula);
        }


        if ($rs) {
            return $peliculas;
        } else {
            return null;
        }
    }

    public static function buscarPeliculaPorGenero(string $genero): ?array
    {
        $peliculas = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM pelicula WHERE genero = ?",
            [$genero]
        );


        foreach ($rs as $fila) {
            $pelicula = self::peliculaCrearDesdeRS($fila);
            array_push($peliculas, $pelicula);
        }


        if ($rs) {
            return $peliculas;
        } else {
            return null;
        }
    }

    public static function buscarPeliculaPorPuntuacion(int $puntuacion): ?array
    {
        $peliculas = [];
        $rs = self::ejecutarConsulta(
            "SELECT * FROM pelicula WHERE puntuacion = ?",
            [$puntuacion]
        );


        foreach ($rs as $fila) {
            $pelicula = self::peliculaCrearDesdeRS($fila);
            array_push($peliculas, $pelicula);
        }


        if ($rs) {
            return $peliculas;
        } else {
            return null;
        }
    }
}