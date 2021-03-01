<?php
require_once "dao.php";


// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

DAO::personaELiminar($id);
redireccionar("personaListado.php");
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

</body>



<html>

<head>
    <meta charset='UTF-8'>
</head>
