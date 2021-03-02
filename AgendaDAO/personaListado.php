<?php
require_once "varios.php";
require_once "dao.php";

establecerTema();

$posibleClausulaWhere = isset($_REQUEST["soloEstrellas"]) ? "WHERE estrella=1" : "";
$personas = DAO::personaObtenerTodas($posibleClausulaWhere);

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

<h1>Listado de Personas</h1>


<table border='1'>

    <tr>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>Telefono</th>
        <th>Categoria</th>
        <th>Eliminar</th>
    </tr>

    <?php foreach ($personas as $persona) { ?>

        <tr>
           <?php $urlImagen = $persona->getEstrella() ? "img/estrellaRellena.png" : "img/estrellaVacia.png";
           ?>

            <td><a href='personaFicha.php?id=<?=$persona->getId()?>'>    <?=$persona->getNombre()?> </a>
                <a href='personaEstablecerEstadoEstrella.php?id=<?=$persona->getId()?>'><img src='<?=$urlImagen?>' width='16' height='16'></a>
            </td>
            <td><a href='personaFicha.php?id=<?=$persona->getId()?>'>    <?=$persona->getApellidos()?> </a></td>
            <td><a href='personaFicha.php?id=<?=$persona->getId()?>'>    <?=$persona->getTelefono()?> </a></td>
            <td><a href='categoriaFicha.php?id=<?= $persona->getCategoriaId() ?>'> <?= DAO::personaObtenerCategoria($persona->getCategoriaId()); ?> </a></td>
            <td><a href='personaEliminar.php?id=<?=$persona->getId()?>'> (X) </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href='personaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<?php if (!isset($_REQUEST["soloEstrellas"])) {?>
    <a href='PersonaListado.php?soloEstrellas'>Mostrar solo contactos con estrella</a>
<?php } else { ?>
    <a href='PersonaListado.php?todos'>Mostrar todos los contactos</a>
<?php } ?>

<br><br>

<a href='CategoriaListado.php?tema'>Gestionar listado de Personas</a>
<br>


<p>
    <a href='categoriaListado.php?fondo=grey'>Oscuro</a>
    <a href='categoriaListado.php?fondo=white'>Blanco</a>
    <a href='categoriaListado.php?fondo=dodgerblue'>Azul</a>
    <a href='categoriaListado.php?fondo=beige'>Crema</a>
</p>

</body>
