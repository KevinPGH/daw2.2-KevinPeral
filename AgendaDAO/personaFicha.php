<?php
require_once "varios.php";

$conexion = obtenerPdoConexionBD();


recogerTema();


// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

// Si id es -1 quieren CREAR una nueva entrada ($nueva_entrada tomará true).
// Sin embargo, si id NO es -1 quieren VER la ficha de una categoría existente
// (y $nueva_entrada tomará false).
$nuevaEntrada = ($id == -1);

if ($nuevaEntrada) { // Quieren CREAR una nueva entrada, así que no se cargan datos.
    $personaNombre = "<introduzca nombre>";
    $personaApellidos = "<Introduzca apellidos>";
    $personaTelefono = "<introduzca telefono>";
    $personaEstrella = false;
    $personaCategoriaId= 0;


} else { // Quieren VER la ficha de una categoría existente, cuyos datos se cargan.
    $sql = "SELECT * FROM persona WHERE id=?";

    $select = $conexion->prepare($sql);
    $select->execute([$id]); // Se añade el parámetro a la consulta preparada.
    $rs = $select->fetchAll();

    // Con esto, accedemos a los datos de la primera (y esperemos que única) fila que haya venido.
    $personaNombre = $rs[0]["nombre"];
    $personaApellidos = $rs[0]["apellidos"];
    $personaTelefono = $rs[0]["telefono"];
    $personaEstrella = ($rs[0]["estrella"]==1);
    $personaCategoriaId = $rs[0]["categoriaId"];

}
// Con lo siguiente se deja preparado un recordset con todas las categorías.

$sqlCategorias = "SELECT id, nombre FROM categoria ORDER BY nombre";

$select = $conexion->prepare($sqlCategorias);
$select->execute([]); // Array vacío porque la consulta preparada no requiere parámetros.
$rsCategorias = $select->fetchAll();



// INTERFAZ:
// $nuevaEntrada
// $categoriaNombre
?>



<html>

<head>
    <style>
    body{
        background-color: <?= $_SESSION["fondo"]; ?>;
        }
    </style>
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
        </li>
        <li>
            <strong>Apellido: </strong>
            <input type='text' name='apellidos' value='<?=$personaApellidos?>' />
        </li>
        <li>
            <strong>Telefono: </strong>
            <input type='text' name='telefono' value='<?=$personaTelefono?>' />
        </li>
        <li>
            <strong>Categoria: </strong>
            <select name="categoriaId">

                <?php foreach ($rsCategorias as $filaCategoria) {
                    $categoriaId = (int)$filaCategoria["id"];
                    $categoriaNombre = $filaCategoria["nombre"];

                    if ($categoriaId == $personaCategoriaId) $seleccion = "selected-'true'";
                    else                                     $seleccion = "";

                    echo "<option value='$categoriaId' $seleccion>$categoriaNombre</option>";
                }
                ?>

            </select>
        </li>
        <li>
            <strong>Favoritos</strong>
            <input type="checkbox" name="estrella" <?= $personaEstrella ? "checked" : "" ?> />
        </li>
        <br>

    <?php if ($nuevaEntrada) { ?>
        <input type='submit' name='crear' value='Crear persona' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>

<br>

<a href='personaEliminar.php?id=<?=$id?>'>Eliminar persona</a>

<br />
<br />

<a href='personaListado.php'>Volver al listado de personas.</a>

</body>

