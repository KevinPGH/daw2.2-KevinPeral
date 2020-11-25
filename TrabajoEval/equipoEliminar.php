<?php
require_once "VariosLiga.php";

$conexionBD = obtenerPdoConexionBD();

//Recojo id de la request
$id = (int)$_REQUEST["id"];

$sql = "DELETE FROM equipo WHERE id=?";

$sentencia = $conexionBD->prepare($sql);
//Comprobamos si la ejecución de la sentencia sql funciona correctamente
$sqlConExito = $sentencia->execute([$id]); // Se añade el parámetro a la consulta preparada.


$correctoNormal = ($sqlConExito && $sentencia->rowCount() == 1);

$noExiste = ($sqlConExito && $sentencia->rowCount() == 0);

//INTERFAZ:
// $correctoNormal
// $noExiste

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($correctoNormal) { ?>

    <h1>Eliminación completada</h1>
    <p>Se ha eliminado correctamente el equipo.</p>

<?php } else if ($noExiste) { ?>

    <h1>No eliminado</h1>
    <p>No existe el equipo que se pretende eliminar.</p>

<?php } else { ?>

    <h1>No se ha podido eliminar el equipo</h1>


<?php } ?>

<a href='EquipoListado.php'>Volver al listado de equipos.</a>

</body>
