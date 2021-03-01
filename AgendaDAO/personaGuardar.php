<?php
require_once "dao.php";


// Se recogen los datos del formulario de la request.
$id = (int)$_REQUEST["id"];
$nombre = $_REQUEST["nombre"];
$apellidos = $_REQUEST["apellidos"];
$telefono = $_REQUEST["telefono"];

if ($id == -1)
{
    DAO::personaCrear($nombre, $apellidos, $telefono);

}else
    DAO::personaActualizar($id, $nombre, $apellidos, $telefono);


redireccionar("personaListado.php");
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php
// Todo bien tanto si se han guardado los datos nuevos como si no se habían modificado.
if ($correcto || $datosNoModificados) { ?>
    <?php if ($nuevaEntrada) { ?>
        <h1>Inserción completada</h1>
        <p>Se ha insertado correctamente la nueva entrada de <?=$nombre?>.</p>
    <?php } else { ?>
        <h1>Guardado completado</h1>
        <p>Se han guardado correctamente los datos de <?=$nombre?>.</p>

        <?php if ($datosNoModificados) { ?>
            <p>En realidad, no había modificado nada, pero no está de más que se haya asegurado pulsando el botón de guardar :)</p>
        <?php } ?>
    <?php }
    ?>

    <?php
} else {
    ?>

    <?php if ($nuevaEntrada) { ?>
        <h1>Error en la creación.</h1>
        <p>No se ha podido crear la nueva persona.</p>
    <?php } else { ?>
        <h1>Error en la modificación.</h1>
        <p>No se han podido guardar los datos de la persona.</p>
    <?php } ?>

    <?php
}
?>

<a href='personaListado.php'>Volver al listado de personas.</a>

</body>
