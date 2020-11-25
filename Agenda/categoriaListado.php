<?php
require_once "varios.php";

session_start();
if (!isset($_SESSION["fondo"]) && !isset($_REQUEST["fondo"])){
    $_SESSION["fondo"] = "";
}else if (isset($_REQUEST["fondo"])){
    $_SESSION["fondo"] = $_REQUEST["fondo"];
}
$conexionBD = obtenerPdoConexionBD();

// Los campos que incluyo en el SELECT son los que luego podré leer
// con $fila["campo"].
$sql = "SELECT id, nombre FROM categoria ORDER BY nombre";

$select = $conexionBD->prepare($sql);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$rs = $select->fetchAll();





// INTERFAZ:
// $rs
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

    <?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href=   'categoriaFicha.php?id=<?=$fila["id"]?>&tema'> <?=$fila["nombre"] ?> </a></td>
            <td><a href='categoriaEliminar.php?id=<?=$fila["id"]?>'> (X)                   </a></td>
        </tr>
    <?php } ?>

</table>

<br />

<a href='categoriaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='personaListado.php?tema'>Gestionar listado de Personas</a>
<br>


    <a href='categoriaListado.php?fondo=grey'>Oscuro</a>
    <a href='categoriaListado.php?fondo=white'>Blanco</a>
    <a href='categoriaListado.php?fondo=dodgerblue'>Azul</a>
    <a href='categoriaListado.php?fondo=beige'>Crema</a>


</body>
