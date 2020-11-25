<?php

require_once "VariosLiga.php";

$conexionBD = obtenerPdoConexionBD();


//Reocogemos los campos que vamos a utilizar con request
$id = $_REQUEST["id"];
$nombre = $_REQUEST["nombre"];


//Comprobamos si la entrada que queremos guardar es nueva o no. Si lo es, hacemos un insert, si no, update
$nuevaEntrada = ($id== -1);

if($nuevaEntrada){
    $sql = "INSERT INTO equipo (nombre) VALUES (?)";
    $parametros= [$nombre];
}else{
    $sql = "UPDATE equipo SET nombre=? WHERE id=?";
    $parametros= [$nombre, $id];
}

$sentencia= $conexionBD->prepare($sql);
//Comprobamos si el sql que ejecutamos es correcto o no.
$sqlConExito = $sentencia->execute($parametros);


$correcto = ($sqlConExito && $sentencia->rowCount()==1);

$datosNoModificados = ($sqlConExito && $sentencia->rowCount()==0);

?>

<html>

    <head>
        <meta charset="UTF-8">
    </head>

<body>

<?php
    if ($correcto || $datosNoModificados){ ?>
        <?php if ($nuevaEntrada){ ?>
            <h2>Acción Completada</h2>
            <p>Se ha creado el equipo: <?=$nombre?>.</p>
        <?php }else { ?>
            <h2>Acción completada</h2>
        <p>Datos de <?=$nombre?> guardados correctamente</p>
        <?php } ?>


<?php
    }else { ?>
    <?php if ($nuevaEntrada){ ?>
        <h2>Error</h2>
        <p>No hemos podido crear tu equipo</p>
    <?php }else { ?>
        <h2>Error</h2>
        <p>No hemos podido guardar los cambios de tu equipo</p>
<?php }

    }

//INTERFAZ
//$nuevaEntrada
// $correcto
// $datosNoModificados
?>


<a href='equipoListado.php'>Volver al listado de los equipos.</a>

</body>


</html>
