<?php
require_once "varios.php";
require_once "dao.php";

recogerTema();


// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];


$persona = DAO::personaObtenerPorId($id);
$categorias = DAO::categoriaObtenerTodas();

if ($persona == null) {
    $personaNombre = "<introduzca nombre>";
    $personaApellidos = "<introduzca apellidos>";
    $personaTelefono = "<introduzca telefono>";

}else {
    $personaNombre = $persona->getNombre();
    $personaApellidos = $persona->getApellidos();
    $personaTelefono = $persona->getTelefono();
    $personaEstrella = $persona->getEstrella();
    $personaCategoriaId = $persona->getCategoriaId();

}


// INTERFAZ:
// $nuevaEntrada
// $categoriaNombre
?>



<html>

<head>
    <style>
        body{
            background-color: <?= $_SESSION["fondo"]; ?> ;
        }
    </style>
    <meta charset='UTF-8'>
</head>



<body>

<?php if ($persona==null) { ?>
    <h1>Nueva ficha de categoría</h1>
<?php } else { ?>
    <h1>Ficha de categoría</h1>
<?php } ?>

<form method='post' action='personaGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$personaNombre?>' />
        </li>

        <li>
            <strong>Apellidos: </strong>
            <input type='text' name='apellidos' value='<?=$personaApellidos?>' />
        </li>

        <li>
            <strong>Telefono: </strong>
            <input type='text' name='telefono' value='<?=$personaTelefono?>' />
        </li>

        <li>
            <strong>Categoria </strong>
            <select name='categoriaId'>
                <?php
                foreach ($categorias as $categoria) {
                        $categoriaId = $categoria->getId();
                        $categoriaNombre = $categoria->getNombre();
                        echo "<option value='$categoriaId' >$categoriaNombre</option>";
                    }
                ?>
        </li>


    </ul>

    <?php if ($persona==null) { ?>
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
