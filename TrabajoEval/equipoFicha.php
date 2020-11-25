<?php

require_once "VariosLiga.php";

$conexion = obtenerPdoConexionBD();

//Recogemos el parametro id.
$id=$_REQUEST["id"];

//Hacemos esto para más tarde poder incluir el listado de aquellos jugadores que pertenecen al equipo
$sql = "SELECT * FROM jugador WHERE equipoId=? ORDER BY nombre";

$select = $conexion->prepare($sql);
$select->execute([$id]);
$rsJugadoresDeEquipo = $select->fetchAll();


//Si queremos crear un nuevo jugador $nuevaEntrada es true (-1), si no false
$nuevaEntrada = ($id == -1);

if($nuevaEntrada){
    $equipoNombre = "<Introduzca nombre del equipo>";
}else {
    //Recogemos los campos que el cleinte necesita ver de un equipo creado
    $sql = "SELECT nombre FROM equipo WHERE id=?";


    $select = $conexion->prepare($sql);
    $select->execute([$id]);
    $rs= $select->fetchAll();


    //Accedemos al nombre de la fila que hemos solicitado
    $equipoNombre = $rs[0]["nombre"];

}

//INTERFAZ
// $nuevaEntrada
// $categoriaNombre
?>



<html>

    <head>
        <meta charset="UTF-8">
    </head>

<body>

    <?php if($nuevaEntrada){ ?>
        <h2>Nuevo Equipo: </h2>
    <?php }else{ ?>
        <h2>Tu equipo:</h2>
    <?php } ?>

<form method="post" action="equipoGuardar.php">
    <input type="hidden" name="id" value="<?=$id?>"/>
    <ul>
        <li>
            <strong>Nombre del equipo:</strong>
            <input type="text" name="nombre" value="<?=$equipoNombre?>">
        </li>
    </ul>

    <p>Jugadores de <?=$equipoNombre?>:</p>

    <ul>
        <?php
        foreach ($rsJugadoresDeEquipo as $fila) {
            echo "<li>$fila[nombre] $fila[apellidos]</li>";
        }
        ?>
    </ul>

    <?php if ($nuevaEntrada){?>
        <input type="submit" name="crear" value="Crear nuevo equipo">
    <?php }else{?>
        <input type="submit" name="guardar" value="Guardar los cambios realizados">
    <?php } ?>
</form>
    
    <a href="equipoListado.php">Volver a la lista de los equipos</a>

</body>
</html>