<?php

require_once "VariosLiga.php";
$conexion = obtenerPdoConexionBD();
//Recogemos la id del jugador seleccionado
$id= $_REQUEST["id"];
//Actualizamos su información del campo lesionado poniendo lo contrario a su estado actual.
$sql = "UPDATE jugador SET lesionado = (NOT (SELECT lesionado FROM jugador WHERE id=?)) WHERE id=?";
$sentencia= $conexion->prepare($sql);
$sentencia->execute([$id,$id]);
redireccionar("jugadorListado.php");
