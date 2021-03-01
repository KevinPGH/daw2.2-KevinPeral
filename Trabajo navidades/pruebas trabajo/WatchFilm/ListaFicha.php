<?php
//Permite modificar nombre de lista, borrar lista, agregar peliculas a la lista y eliminar peliculas de la lista.

require_once "_com/DAO.php";

$listaId = (int)$_REQUEST["id"];
$nombreLista = $_REQUEST["nombre"];

if (isset($_REQUEST["peliculaId"])) {
    $peliculaId = $_REQUEST["peliculaId"];
    DAO::aniadirPeliculaLista($_REQUEST["peliculaId"], $_REQUEST["id"]);
}

$borrado = isset($_REQUEST["borrado"]);
$anadido = isset($_REQUEST["anadido"]);

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

<?php if ($borrado) {
    echo '<div class="borrado">
                   <p style="color: limegreen"><img src="_img/exito.png" alt=""> &nbsp; Borrado con éxito</p>
              </div>';
} ?>

<?php if ($anadido) {
    echo '<div class="anadido">
                   <p style="color: limegreen"><img src="_img/exito.png" alt=""> &nbsp; Añadido con éxito</p>
              </div>';
} ?>

<div class="mostrarPeliculasLista">
    <h2>Películas de la lista <?= $nombreLista ?></h2>

    <?php
    $peliculasLista = DAO::peliculasObtenerDesdeLista($listaId);

    if ($peliculasLista == null) {
        echo "No hay películas en esta lista";
    } else {
        for ($i = 0; $i < count($peliculasLista); $i++) { ?>

            <li><?= $peliculasLista[$i]->getNombre() ?> &nbsp;&nbsp;&nbsp; <a
                        href='BorrarPeliculaLista.php?id=<?= $peliculasLista[$i]->getId() ?>&&listaId=<?= $listaId ?>&&nombreLista=<?= $nombreLista ?>'><img
                            style="width: 15px;height: 15px;" src="_img/borrar.png" alt=""></a></li>

            <?php
        }
    }
    ?>

</div>

<br><br>

<div class="modificarLista">
    <form method='post' action='ModificarLista.php?listaId=<?= $listaId ?>'>
        <label for='nuevoNombre'></label><input type='text' name='nuevoNombre' id='nuevoNombre'
                                                placeholder="Nuevo Nombre Lista"
        />
        <button type='submit' name='modificar' value='modificar'>Modificar</button>
    </form>
</div>

<br><br>

<div>
    <a href='PaginaPrincipal.php'>Volver a la página principal</a>
</div>

<br>


</body>

</html>