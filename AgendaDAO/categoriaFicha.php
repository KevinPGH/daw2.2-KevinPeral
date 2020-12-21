<?php
require_once "varios.php";
require_once "dao.php";

recogerTema();


// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];


$categoria = DAO::categoriaObtenerPorId($id);

if ($categoria == null) {
    $categoriaNombre = "<introduzca nombre>";
}else
    $categoriaNombre = $categoria->getNombre()



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

<?php if ($categoria==null) { ?>
    <h1>Nueva ficha de categoría</h1>
<?php } else { ?>
    <h1>Ficha de categoría</h1>
<?php } ?>

<form method='post' action='categoriaGuardar.php'>

    <input type='hidden' name='id' value='<?=$id?>' />

    <ul>
        <li>
            <strong>Nombre: </strong>
            <input type='text' name='nombre' value='<?=$categoriaNombre?>' />
        </li>
    </ul>
<!--
    <p>Personas que pertenecen actualmente a la categoría:</p>

    <ul>
        <?//php
        //foreach ($rsPersonasDeLaCategoria as $fila) {
         //   echo "<li>$fila[nombre] $fila[apellidos]</li>";
       // }
        ?>
    </ul>
    -->
    <?php if ($categoria==null) { ?>
        <input type='submit' name='crear' value='Crear categoría' />
    <?php } else { ?>
        <input type='submit' name='guardar' value='Guardar cambios' />
    <?php } ?>

</form>

<br />

<a href='categoriaEliminar.php?id=<?=$id?>'>Eliminar categoría</a>

<br />
<br />

<a href='categoriaListado.php'>Volver al listado de categorías.</a>

</body>
