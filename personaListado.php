<?php
require_once "varios.php";

$conexionBD = obtenerPdoConexionBD();
$sql = "
               SELECT
                    p.id     AS p_id,
                    p.nombre AS p_nombre,
                    p.telefono as p_telefono
                    c.id     AS c_id,
                    c.nombre AS c_nombre
                FROM
                   persona AS p INNER JOIN categoria AS c
                   ON p.categoria_id = c.id
                ORDER BY p.nombre
        ";

// Los campos que incluyo en el SELECT son los que luego podré leer
// con $fila["campo"].
$sql = "SELECT id, nombre, telefono FROM persona ORDER BY nombre";

$select = $conexionBD->prepare($sql);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$rs = $select->fetchAll();

// INTERFAZ:
// $rs
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Listado de persona</h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
        <th>Telefono</th>
    </tr>

    <?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href= 'personaFicha.php?id=<?=$fila["id"]?>'> <?=$fila["nombre"] ?> </a></td>
            <td><a href='personaFicha.php?id=<?=$fila["id"]?>'> <?=$fila["telefono"]?>   </a></td>
            <td><a href='personaEliminar.php?id=<?=$fila["id"]?>'> (X)                   </a></td>

        </tr>
    <?php } ?>

</table>

<br />

<a href='personaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='categoriaListado.php'>Gestionar listado de Categorias</a>

</body>

