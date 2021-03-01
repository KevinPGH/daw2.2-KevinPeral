<?php

require_once "_com/DAO.php";

$nombreLista = isset($_REQUEST["nombreLista"]) ? $_REQUEST["nombreLista"] : "";

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

<div class="listasUsuario">
    <h2>Mis Listas</h2>
    <ul>
        <?php
        $listas = DAO::listasObtener($_SESSION["id"]);
        if ($listas == null) //creamos una lista predeterminada al crear un usuario, si no, se muestran las existentes
            DAO::crearLista("Favoritos", $_SESSION["id"]);

        $listas = DAO::listasObtener($_SESSION["id"]);
            echo "<div>";
            for ($i = 0; $i < count($listas); $i++) { ?>
                <li>
                    <a href='ListaFicha.php?id=<?= $listas[$i]->getId() ?>&&nombre=<?= $listas[$i]->getNombre() ?>'> <?= $listas[$i]->getNombre() ?> </a>&nbsp;&nbsp;&nbsp;
                    <a href='BorrarLista.php?listaId=<?= $listas[$i]->getId() ?>'><img style="width: 15px;height: 15px;" src="_img/borrar.png" alt=''></a>
                </li>

                <?php
            }
            echo "</div>";
        ?>
    </ul>
</div>

<div class="crearLista">
    <form method='post' action='CrearLista.php'>
        <strong>Nombre de Lista: </strong>
        <label>
            <input type='text' name='nombreLista' id='nombreLista' value='<?= $nombreLista ?>'
                   placeholder="Nombre de Lista"
            />
        </label>
        <button type='submit' name='crearLista' value='crearLista'>Crear Nueva Lista</button>
    </form>
</div>

<a href='PaginaPrincipal.php'>Volver a la página Principal</a>
</body>
</html>
