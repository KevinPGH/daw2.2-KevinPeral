<?php

trait Identificable
{
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}

abstract class Dato
{
}

/*--------------------------------USUARIO----------------------------------*/

class Usuario extends Dato
{
    use Identificable;

    private string $identificador;

    private string $nombre;

    private string $apellidos;

    private string $email;

    private string $contrasenna;

    public function __construct(int $id, string $identificador, string $nombre, string $apellidos, string $email, string $contrasenna)
    {
        $this->setId($id);
        $this->setIdentificador($identificador);
        $this->setNombre($nombre);
        $this->setApellidos($apellidos);
        $this->setEmail($email);
        $this->setContrasenna($contrasenna);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getIdentificador(): string
    {
        return $this->identificador;
    }

    public function setIdentificador(string $identificador)
    {
        $this->identificador = $identificador;
    }

    public function getApellidos(): string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos)
    {
        $this->apellidos = $apellidos;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getContrasenna(): string
    {
        return $this->contrasenna;
    }

    public function setContrasenna(string $contrasenna)
    {
        $this->contrasenna = $contrasenna;
    }
}

/* ------------------------PELÍCULA----------------------------*/

class Pelicula extends Dato
{
    use Identificable;

    private string $nombre;

    private string $director;

    private string $genero;

    private int $anio;

    private int $puntuacion;

    private int $plataformaId;

    public function __construct(int $id, string $nombre, string $director, string $genero, int $anio, int $puntuacion, int $plataformaId)
    {
        $this->setId($id);
        $this->setNombre($nombre);
        $this->setDirector($director);
        $this->setGenero($genero);
        $this->setAnio($anio);
        $this->setPuntuacion($puntuacion);
        $this->setPlataformaId($plataformaId);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }

    public function getDirector(): string
    {
        return $this->director;
    }

    public function setDirector(string $director)
    {
        $this->director = $director;
    }

    public function getGenero(): string
    {
        return $this->genero;
    }

    public function setGenero(string $genero)
    {
        $this->genero = $genero;
    }

    public function getAnio(): int
    {
        return $this->anio;
    }

    public function setAnio(int $anio)
    {
        $this->anio = $anio;
    }

    public function getPuntuacion(): int
    {
        return $this->puntuacion;
    }

    public function setPuntuacion(int $puntuacion)
    {
        $this->puntuacion = $puntuacion;
    }

    public function getPlataformaId(): int
    {
        return $this->plataformaId;
    }

    public function setPlataformaId(int $plataformaId)
    {
        $this->plataformaId = $plataformaId;
    }
}

/*----------------------------------PLATAFORMA--------------------------------*/

class Plataforma extends Dato
{
    use Identificable;

    private string $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }
}

/*----------------------------------LISTA--------------------------------*/

class Lista extends Dato
{
    use Identificable;

    private string $nombre;

    public function __construct(int $id, string $nombre)
    {
        $this->setId($id);
        $this->setNombre($nombre);
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre)
    {
        $this->nombre = $nombre;
    }
}