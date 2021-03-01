<?php
require_once "varios.php";
require_once "dao.php";

establecerTema();

$personas = DAO::personaObtenerTodas();

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

<h1>Listado de Personas</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Telefono</th>
        <th>Eliminar</th>
    </tr>

    <?php foreach ($personas as $persona) { ?>
        <tr>
            <td><a href='PersonaFicha.php?id=<?=$persona->getId()?>'>    <?=$persona->getNombre()?> </a></td>
            <td><a href='PersonaFicha.php?id=<?=$persona->getId()?>'>    <?=$persona->getApellidos()?> </a></td>
            <td><a href='PersonaFicha.php?id=<?=$persona->getId()?>'>    <?=$persona->getTelefono()?> </a></td>
            <td><a href='PersonaEliminar.php?id=<?=$persona->getId()?>'> (X) </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href='personaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='CategoriaListado.php?tema'>Gestionar listado de Personas</a>
<br>


<p>
    <a href='categoriaListado.php?fondo=grey'>Oscuro</a>
    <a href='categoriaListado.php?fondo=white'>Blanco</a>
    <a href='categoriaListado.php?fondo=dodgerblue'>Azul</a>
    <a href='categoriaListado.php?fondo=beige'>Crema</a>
</p>

</body>
