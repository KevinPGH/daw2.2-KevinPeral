<?php
require_once "dao.php";


// Se recoge el parámetro "id" de la request.
$id = (int)$_REQUEST["id"];

DAO::categoriaELiminar($id);
redireccionar("categoriaListado.php");
?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

</body>
