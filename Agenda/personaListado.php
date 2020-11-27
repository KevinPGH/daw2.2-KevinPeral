<?php
require_once "varios.php";

$conexionBD = obtenerPdoConexionBD();

recogerTema();

if(isset($_REQUEST["soloEstrellas"])){
    $_SESSION["soloEstrellas"] = true;
}
if(isset($_REQUEST["todos"])){
    unset($_SESSION["soloEstrellas"]);
}

$posibleClausulaWhere = isset($_SESSION["soloEstrellas"]) ? "WHERE p.estrella=1" : "";
$sql = "
               SELECT
                    p.id     AS pId,
                    p.nombre AS pNombre,
                    p.apellidos as pApellidos,
                    p.telefono as pTelefono,
                    p.estrella as pEstrella,
                    c.id     AS cId,
                    c.nombre AS cNombre
                FROM
                   persona AS p INNER JOIN categoria AS c
                   ON p.categoriaId = c.id
                   $posibleClausulaWhere
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

<style>
    body{
        background-color: <?= $_SESSION["fondo"]; ?>;
    }
</style>

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
            <td>
                <?php
                echo "<a href='personaFicha.php?id=$fila[pId]'>";
                echo "$fila[pNombre]";
                echo"</a>";

                $urlImagen = $fila["pEstrella"] ? "img/estrellaRellena.png" : "img/estrellaVacia.png";
                echo  "<a href='personaEstablecerEstadoEstrella.php?id=$fila[pId]'><img src='$urlImagen' width='16' height='16'></a>";
                ?>
            </td>
            <td><?=$fila["pApellidos"]?> </td>
            <td><?=$fila["pTelefono"]?></td>
            <td><?=$fila["cNombre"]?></td>
            <td><a href='personaEliminar.php?id=<?=$fila["pId"]?>'> (X)                   </a></td>

        </tr>
    <?php } ?>

</table>

<br />
<?php if(!isset($_SESSION["soloEstrellas"])){?>
    <a href='personaListado.php?soloEstrellas'>Mostrar solo contactos con estrella</a>
<?php } else {?>
    <a href='personaListado.php?todos'>Mostrar todos los contactos</a>
<?php } ?>
<br>
<br>

<a href='personaFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='categoriaListado.php'>Gestionar listado de Categorias</a>

</body>

