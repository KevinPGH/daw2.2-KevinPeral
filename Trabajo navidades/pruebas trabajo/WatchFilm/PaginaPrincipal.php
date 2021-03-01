<?php

require_once "_com/DAO.php";
require_once "_com/Utilidades.php";

$rs = DAO::obtenerusuario();

$identificador = $rs[0]->getIdentificador();
$contrasenna = $rs[0]->getContrasenna();

$usuario = DAO::usuarioObtener($identificador, $contrasenna);

if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) redireccionar("SesionInicioFormulario.php");

if (!DAO::haySesionRamIniciada() && DAO::intentarCanjearSesionCookie()) DAO::marcarSesionComoIniciada(DAO::obtenerUsuarioPorCookie($_COOKIE["codigoCookie"]));


$rsGenero = DAO:: listarGeneros();

$borrado = isset($_REQUEST["borrado"]);

$tema = comprobarTema();

?>


<html lang=''>

<head>
    <meta charset='UTF-8'>
    <title></title>
    <?php if ($tema) { ?>
        <link rel="stylesheet" href="_styles/styleBlack.css">
    <?php } else { ?>
        <link rel="stylesheet" href="_styles/style.css">
    <?php } ?>
</head>

<body>
<header><a href="PaginaPrincipal.php"><img src="_img/logo.png" width="150" height="120"/> </a> </header>


<?php if ($borrado) {
    echo '<div class="borrado">
                   <p style="color: limegreen"><img src="_img/exito.png" height="30" width="30" alt=""> &nbsp; Borrado con éxito</p>
              </div>';
} ?>

<?php pintarInfoSesion(); ?>


<br>
<a href='UsuarioListas.php?id=<?= $_SESSION["id"] ?>'>Ver Mis Listas</a>

<br><br>

<div class="filtroBusqueda">
    <h3><img src="_img/buscar.png" height="30" width="30" alt=''> Buscar:</h3>

    <form method='post' action='Busqueda.php'>
        <strong>Título: </strong>
        <label>
            <input type='text' name='nombre' id='nombre'
                   placeholder="Buscar por Título"
            />
        </label>

        <strong>Director: </strong>
        <label>
            <input type='text' name='director' id='director'
                   placeholder="Buscar por Director"
            />
        </label>

        <strong>Género: </strong>
        <label>
            <select name='genero'>
                <option value="-1" selected>Buscar por Género:</option>
                <?php
                //TODO: Pendiente de mejorar
                foreach ($rsGenero as $filaGeneros) {
                    foreach ($filaGeneros as $generoNombre) {
                        echo "<option value = '$generoNombre' >$generoNombre</option>";
                    }
                } ?>

            </select>
        </label>

        <strong>Puntuación: </strong>
        <label>
            <select name='puntuacion'>
                <option value="-1" selected>Buscar por Puntuacion:</option>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
        </label>
        <br><br>
        <button type='submit' name='buscar' value='buscar'>Buscar</button>
    </form>
</div>

<br><br>
<?php $peliculas = DAO::peliculaObtenerTodas(); ?>

<table>
    <tr>
        <th></th>
        <th>Nombre</th>
        <th>Director</th>
        <th>Genero</th>
        <th>Año</th>
        <th>Puntuación</th>
        <th>Plataforma</th>
    </tr>

    <?php foreach ($peliculas as $pelicula) { ?>

        <tr>
            <td><img src="_img/<?=$pelicula->getId()?>.jpg"  height="150" width="120" /></td>
            <td>
                <a href='https://www.google.com/search?q=ver+<?= $pelicula->getNombre() ?>+en+<?= DAO::peliculaObtenerNombrePlataforma($pelicula->getPlataformaId()) ?>'><?= $pelicula->getNombre() ?> </a>
            </td>
            <td>
                <a href='https://es.wikipedia.org/wiki/<?= $pelicula->getDirector() ?>'><?= $pelicula->getDirector() ?> </a>
            </td>
            <td><p><?= $pelicula->getGenero() ?></p></td>
            <td><p><?= $pelicula->getAnio() ?></p></td>
            <td><p><?= $pelicula->getPuntuacion() ?></p></td>
            <td>
                <a href='https://www.google.com/search?q<?= DAO::peliculaObtenerNombrePlataforma($pelicula->getPlataformaId()) ?>'><?= DAO::peliculaObtenerNombrePlataforma($pelicula->getPlataformaId()) ?></a>
            </td>
            <td>
                <a href='AnnadirPeliculaLista.php?nombre=<?= $pelicula->getNombre() ?>&&id=<?= $pelicula->getId() ?>'><img
                            src="_img/aniadirALista.png" height="30" width="30" alt=''></a>
            </td>
        </tr>

    <?php } ?>

</table>

<br><br><br>

<a href="_pdf/armageddon.php">Ejemplo de lo del PDF</a>



</body>

</html>