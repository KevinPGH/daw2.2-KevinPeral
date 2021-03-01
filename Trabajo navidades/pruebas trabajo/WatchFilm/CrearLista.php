<?php

require_once "_com/DAO.php";

DAO::crearLista($_REQUEST["nombreLista"], $_SESSION["id"]);

redireccionar("PaginaPrincipal.php");