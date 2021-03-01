<?php

require_once "_com/DAO.php";

$listas = DAO::listasObtener($_SESSION["id"]);

//$nombrePelicula = $_REQUEST["nombre"];
$peliculaId = $_REQUEST["id"];

$tema = comprobarTema();

?>

<html lang=''>
<head>
    <meta charset='UTF-8'>
    <title></title>
    <?php if ($tema) { ?>
        <link rel="stylesheet" href="_styles/styleBlack.css">
    <?php } else { ?>
        <link rel="stylesheet" href="_styles/style.css">
    <?php } ?>
</head>

<body class='<?= $tema ?>'>

<h2>Selecciona la lista a la que quieres añadir la película</h2>


<?php for ($i = 0; $i < count($listas); $i++) { ?>
    <li>
        <a href='ListaFicha.php?id=<?= $listas[$i]->getId() ?>&&nombre=<?= $listas[$i]->getNombre() ?>&&peliculaId=<?= $peliculaId ?>&&anadido'> <?= $listas[$i]->getNombre() ?> </a>
    </li>
    <?php
}
?>


</body>
</html>
