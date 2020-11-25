<?php
require_once "VariosLiga.php";

$conexionBD = obtenerPdoConexionBD();

session_start();
//Comprobamos si viene el parametro lesionadoSi.
//Si viene, guardaremos su estado
if(isset($_REQUEST["lesionadoSi"])){
    $_SESSION["lesionadoSi"] = true;
}//Si lo que viene es el parametro todos
//eliminamos la session creada
if(isset($_REQUEST["todos"])){
    unset($_SESSION["lesionadoSi"]);
}

$clausulaWhere = isset($_SESSION["lesionadoSi"]) ? "WHERE j.lesionado=1" : "";
$sql = "
               SELECT
                    j.id     AS jId,
                    j.nombre AS jNombre,
                    j.apellidos as jApellidos,
                    j.posicion as jPosicion,
                    j.lesionado as jLesionado,
                    e.id     AS eId,
                    e.nombre AS eNombre
                FROM
                   jugador AS j INNER JOIN equipo AS e
                   ON j.equipoId = e.id
                   $clausulaWhere
                ORDER BY jNombre
        ";




$select = $conexionBD->prepare($sql);
$select->execute([]);
$rs = $select->fetchAll();


?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Listado de jugadores <?php echo"<img src='imagenes/nba.png' width='40' height='40'></a>"; ?> </h1>

<table border='1'>

    <tr>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>Posicion</th>
        <th>Equipo</th>
    </tr>

    <?php foreach ($rs as $fila) { ?>
        <tr>
            <td>
                <?php
                echo "<a href='jugadorFicha.php?id=$fila[jId]'>";
                echo "$fila[jNombre]";
                echo"</a>";

                $urlImagen = $fila["jLesionado"] ? "imagenes/lesionadoSi.png" : "imagenes/lesionadoNo.png";
                echo  "<a href='jugadorLesionado.php?id=$fila[jId]'><img src='$urlImagen' width='16' height='16'></a>";
                ?>
            </td>
            <td><?=$fila["jApellidos"]?> </td>
            <td><?=$fila["jPosicion"]?></td>
            <td><?=$fila["eNombre"]?></td>
            <td><a href='jugadorEliminar.php?id=<?=$fila["jId"]?>'> (X) </a></td>

        </tr>
    <?php } ?>

</table>

<br />
<?php if(!isset($_SESSION["lesionadoSi"])){?>
    <a href='jugadorListado.php?lesionadoSi'>Mostrar solo jugadores lesionados</a>
<?php } else {?>
    <a href='jugadorListado.php?todos'>Mostrar todos los jugadores</a>
<?php } ?>
<br>
<br>

<a href='jugadorFicha.php?id=-1'>Crear entrada</a>

<br />
<br />

<a href='equipoListado.php'>Gestionar listado de Equipos</a>

</body>

