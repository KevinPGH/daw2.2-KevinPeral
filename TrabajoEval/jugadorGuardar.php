<?php
require_once "VariosLiga.php";

$conexion = obtenerPdoConexionBD();


//Recojo los datos del formlulario
$id = (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];
$posicion = $_REQUEST["posicion"];
$equipoId = (int)$_REQUEST["equipoId"];
$lesionado = isset($_REQUEST["lesionado"]);

//Si nuestro id no existe anteriormente(-1). Hacemos un INSERT, de lo contrario hacemos un UPDATE

$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) {
    $sql = "INSERT INTO jugador (nombre, apellidos, posicion, lesionado, equipoId) VALUES (?, ?, ?, ?, ?)";
    $parametros = [$nombre, $apellidos, $posicion, $lesionado, $equipoId];
} else {
    $sql = "UPDATE jugador SET nombre=?, apellidos=?, posicion=?, lesionado=?, equipoId=? WHERE id=?";
    $parametros = [$nombre, $apellidos, $posicion, $lesionado?1:0, $equipoId, $id];
}

$sentencia = $conexion->prepare($sql);
//Ejecutamos la sentencia sql
$sqlConExito = $sentencia->execute($parametros);

//Comprobamos si se ha guardado de forma correcta
$numFilasAfectadas = $sentencia->rowCount();
$unaFilaAfectada = ($numFilasAfectadas == 1);
$ningunaFilaAfectada = ($numFilasAfectadas == 0);


$correcto = ($sqlConExito && $unaFilaAfectada);



$datosNoModificados = ($sqlConExito && $ningunaFilaAfectada);
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php
if ($correcto || $datosNoModificados) { ?>

    <?php if ($id == -1) { ?>
        <?php redireccionar("jugadorListado.php")?>
    <?php } else { ?>
        <?php redireccionar("jugadorListado.php")?>
    <?php }
    ?>

    <?php
} else {
    ?>

    <h1>Error en la modificación.</h1>
    <p>No se han podido guardar los datos del jugador.</p>

    <?php
}
?>

<a href='jugadorListado.php'>Volver al listado de jugadores.</a>

</body>

</html>