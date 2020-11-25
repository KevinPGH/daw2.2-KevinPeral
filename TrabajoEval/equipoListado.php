<?php
require_once "VariosLiga.php";

$conexionBD = obtenerPdoConexionBD();


//Select para recoger los campos que vamos a usar en el listado
$sql = "SELECT id, nombre FROM equipo ORDER BY nombre";

$select = $conexionBD -> prepare($sql);
$select ->execute([]);
$rs = $select -> fetchAll();


// INTERFAZ
//$rs
?>

<html>


<head>
    <meta charset="UTF-8">
</head>

<body>
    <h1> Equipos: </h1>

<br>
    <table border="1">

        <tr>
            <th>Equipo:</th>
        </tr>

        <?php foreach ($rs as $fila){ ?>
            <tr>

                <td> <a href ='equipoFicha.php?id=<?=$fila["id"]?>'> <?=$fila["nombre"]?></a></td>
                <td><a href='equipoEliminar.php?id=<?=$fila["id"]?>'> (X)                   </a></td>
            </tr>

        <?php } ?>

    </table>

    <br><br>

    <a href = 'equipoFicha.php?id=-1'>Crear nuevo equipo</a>


    <br><br>
    <a href='jugadorListado.php'>Gestionar listado de jugadores</a>






</body>






</html>

