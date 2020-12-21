<?php
require_once "varios.php";
require_once "dao.php";

establecerTema();

$categorias = DAO::categoriaObtenerTodas();

?>



<html>

<head>
    <meta charset='UTF-8'>
    <style>
        body{
            background-color: <?= $_SESSION["fondo"]; ?>;
        }
    </style>
</head>



<body>

<h1>Listado de Categorías</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
    </tr>

    <?php foreach ($categorias as $categoria) { ?>
        <tr>
            <td><a href='CategoriaFicha.php?id=<?=$categoria->getId()?>'>    <?=$categoria->getNombre()?> </a></td>
            <td><a href='CategoriaEliminar.php?id=<?=$categoria->getId()?>'> (X) </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href='categoriaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='personaListado.php?tema'>Gestionar listado de Personas</a>
<br>


<p>
    <a href='categoriaListado.php?fondo=grey'>Oscuro</a>
    <a href='categoriaListado.php?fondo=white'>Blanco</a>
    <a href='categoriaListado.php?fondo=dodgerblue'>Azul</a>
    <a href='categoriaListado.php?fondo=beige'>Crema</a>
</p>

</body>
