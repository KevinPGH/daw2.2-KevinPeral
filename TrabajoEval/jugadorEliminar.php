<?php
require_once "VariosLiga.php";

$conexionBD = obtenerPdoConexionBD();

//Recogemos id de la request
$id = (int)$_REQUEST["id"];


//Creamos la sql que vamos utilizar para borrar el jugador que queremos.
$sql = "DELETE FROM jugador WHERE id=?";

$sentencia = $conexionBD->prepare($sql);
//Ejecutamos la sql y comprobamos si ha salido bien o no
$sqlConExito = $sentencia->execute([$id]);



$correctoNormal = ($sqlConExito && $sentencia->rowCount() == 1);

$noExiste = ($sqlConExito && $sentencia->rowCount() == 0);

//INTERFAZ
//$correctoNormal
//$noExiste
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($correctoNormal) { ?>

    <?php redireccionar("jugadorListado.php")?>

<?php } else if ($noExiste) { ?>

    <h1>Eliminación no realizada</h1>
    <p>No existe el jugador que se quiere eliminar.</p>

<?php } else { ?>

    <h1>Error en la eliminación</h1>
    <p>No se ha podido eliminar el jugador.</p>

<?php } ?>

<a href='jugadorListado.php'>Volver al listado de jugadores.</a>

</body>

