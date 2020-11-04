<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();

// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
// (y $nueva_entrada tomará false).
$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
    $personaNombre = "<introduzca nombre>";
    $personaTelefono = "<introduzca telefono>";
} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
    $sql = "SELECT nombre, telefono FROM persona WHERE id=?";

    $select = $conexion->prepare($sql);
    $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
    $rs = $select->fetchAll();

    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    $personaNombre = $rs[0]["nombre"];
    $personaTelefono = $rs[0]["telefono"];

}



// INTERFAZ:
// $nuevaEntrada
// $categoriaNombre
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($nuevaEntrada) { ?>
    <h1>Nueva ficha de persona</h1>
<?php } else { ?>
    <h1>Ficha de persona</h1>
<?php } ?>

<form method='post' action='personaGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$personaNombre?>' />
            <input type='text' name='telefono' value='<?=$personaTelefono?>' />
        </li>
    </ul>

    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear persona' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>

<br />

<a href='personaEliminar.php?id=<?=$id?>'>Eliminar persona</a>

<br />
<br />

<a href='personaListado.php'>Volver al listado de personas.</a>

</body>

