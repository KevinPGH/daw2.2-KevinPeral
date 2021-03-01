<?php

//Aqui es donde se muestra el resultado de buscar, es decir, los datos de la pelicula y plataforma donde se encuentra

require_once "_com/DAO.php";

$nombre = $_REQUEST["nombre"];
$genero = $_REQUEST["genero"];
$puntuacion = (int)$_REQUEST["puntuacion"];

if ($genero == -1 && $puntuacion == -1) {
    $peliculas = DAO::buscarPeliculaPorNombre($nombre);

} else if ($puntuacion != -1) {
    $peliculas = DAO::buscarPeliculaPorPuntuacion($puntuacion);

} else if ($genero != -1 && $puntuacion == -1) {
    $peliculas = DAO::buscarPeliculaPorGenero($genero);

} else {
    $peliculas = 0;
}

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

<body class='<?= $tema ?>'>

<header><a href="PaginaPrincipal.php"><img src="_img/logo.png" width="150" height="120"/> </a></header>

<?php pintarInfoSesion(); ?>

<?php if (DAO::buscarPeliculaPorNombre($nombre) != null || DAO::buscarPeliculaPorGenero($genero) != null) { ?>

    <h1>Resultados encontrados: </h1>

    <table>


        <?php
        //TODO: Pendiente de mejorar
        foreach ($peliculas as $pelicula) { ?>
            <tr>
                <td><img src="_img/<?=$pelicula->getId()?>.jpg"  height="150" width="120" /></td>
                <td><?php echo "" . $pelicula->getNombre() . "" ?></td>
                <td><?php echo "" . $pelicula->getGenero() . "" ?></td>
                <td><?php echo "" . $pelicula->getDirector() . "" ?></td>
                <td><?php echo "" . $pelicula->getAnio() . "" ?></td>
                <td><?php echo "" . $pelicula->getPuntuacion() . "" ?></td>
                <td>
                    <a href='AnnadirPeliculaLista.php?nombre=<?= $pelicula->getNombre() ?>&&id=<?= $pelicula->getId() ?>'><img
                                src="_img/aniadirALista.png" height="30" width="30" alt=''></a>
                </td>
            </tr>
        <?php } ?>

    </table>

    <a href="_pdf/<?= $nombre ?>.php">Accede a mas informacion</a>

<?php } else { ?>

    <h1>No se han encontrado resultados</h1>

<?php } ?>
<br><br>
<a href='PaginaPrincipal.php'>Volver a la página Principal</a>
</body>

</html>