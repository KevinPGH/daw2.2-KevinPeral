<?php

require_once "_com/DAO.php";

$listaId = $_REQUEST["listaId"];
$nombre = $_REQUEST["nuevoNombre"];

DAO::modificarLista($nombre, $listaId);

redireccionar("ListaFicha.php?id=$listaId&&nombre=$nombre");