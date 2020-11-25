<?php
require_once "VariosLiga.php";

$conexion = obtenerPdoConexionBD();

//Recogemos el id mediante request
$id = (int)$_REQUEST["id"];

//Comprobamos si la entrada es nueva.
$nuevaEntrada = ($id == -1);

//Si es nueva escribimos los datos nuevos
//Si no es nueva. Seleccionamos la escogida mediante el id recogido anteriormente y recogemos los parámetros
// el recordset
if ($nuevaEntrada) {
    $jugadorNombre = "<introduzca nombre>";
    $jugadorApellidos = "<Introduzca apellidos>";
    $jugadorPosicion = "<introduzca posicion>";
    $jugadorLesionado = false;
    $jugadorEquipoId= 0;


} else {
    $sql = "SELECT * FROM jugador WHERE id=?";

    $select = $conexion->prepare($sql);
    $select->execute([$id]);
    $rs = $select->fetchAll();


    $jugadorNombre = $rs[0]["nombre"];
    $jugadorApellidos = $rs[0]["apellidos"];
    $jugadorPosicion = $rs[0]["posicion"];
    $jugadorLesionado = ($rs[0]["lesionado"]==1);
    $jugadorEquipoId = $rs[0]["equipoId"];

}

//Hacemos esta select para poder rellenar el select de los equipos de forma automática
$sqlEquipos = "SELECT id, nombre FROM equipo ORDER BY nombre";

$select = $conexion->prepare($sqlEquipos);
$select->execute([]);
$rsEquipos = $select->fetchAll();


//INTERFAZ:
//$rsEquipos
//$nuevaEntrada

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
    <h1>Nueva ficha de jugador</h1>
<?php } else { ?>
    <h1>Ficha de jugador</h1>
<?php } ?>

<form method='post' action='jugadorGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$jugadorNombre?>' />
        </li>
        <li>
            <strong>Apellido: </strong>
            <input type='text' name='apellidos' value='<?=$jugadorApellidos?>' />
        </li>
        <li>
            <strong>Posicion: </strong>
            <select name='posicion' value='<?=$jugadorPosicion?>'>
                <option name="base">Base</option>
                <option name="escolta">Escolta</option>
                <option name="alero">Alero</option>
                <option name="ala-pivot">Ala-Pivot</option>
                <option name="pivot">Pivot</option>
            </select>

        </li>
        <li>
            <strong>Equipo: </strong>
            <select name="equipoId">

                <?php foreach ($rsEquipos as $filaEquipo) {
                    $equipoId = (int)$filaEquipo["id"];
                    $equipoNombre = $filaEquipo["nombre"];

                    if ($equipoId == $jugadorEquipoId) $seleccion = "selected-'true'";
                    else                                     $seleccion = "";

                    echo "<option value='$equipoId' $seleccion>$equipoNombre</option>";
                }
                ?>

            </select>
        </li>
        <li>
            <strong>Lesionado</strong>
            <input type="checkbox" name="lesionado" <?= $jugadorLesionado ? "checked" : "" ?> />
        </li>
        <br>

        <?php if ($nuevaEntrada) { ?>
            <input type='submit' name='crear' value='Crear jugador' />
        <?php } else { ?>
            <input type='submit' name='guardar' value='Guardar cambios' />
        <?php } ?>

</form>

<br>

<a href='jugadorEliminar.php?id=<?=$id?>'>Eliminar jugador</a>

<br />
<br />

<a href='jugadorListado.php'>Volver al listado de jugadores.</a>

</body>

