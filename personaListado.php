<?php
require_once "varios.php";

$conexionBD = obtenerPdoConexionBD();
$sql = "
               SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos as pApellidos,
                    p.telefono as pTelefono,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   persona AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                ORDER BY p.nombre
        ";

// Los campos que incluyo en el SELECT son los que luego podré leer
// con $fila["campo"].


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
        <th>Apellido</th>
        <th>Telefono</th>
        <th>Categoria</th>
    </tr>

    <?php foreach ($rs as $fila) { ?>
        <tr>
            <td><a href= 'personaFicha.php?id=<?=$fila["pId"]?>'> <?=$fila["pNombre"] ?> </a></td>
            <td><?=$fila["pApellidos"]?> </td>
            <td><?=$fila["pTelefono"]?></td>
            <td><?=$fila["cNombre"]?></td>
            <td><a href='personaEliminar.php?id=<?=$fila["pId"]?>'> (X)                   </a></td>

        </tr>
    <?php } ?>

</table>

<br />

<a href='personaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='categoriaListado.php'>Gestionar listado de Categorias</a>

</body>

