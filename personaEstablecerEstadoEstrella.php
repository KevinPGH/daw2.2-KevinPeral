<?php

require_once "varios.php";
$conexion = obtenerPdoConexionBD();

$id= $_REQUEST["id"];
$sql = "UPDATE persona SET estrella = (NOT (SELECT estrella FROM persona WHERE id=?)) WHERE id=?";
$sentencia= $conexion->prepare($sql);
$sentencia->execute([$id,$id]);
redireccionar("personaListado.php");
