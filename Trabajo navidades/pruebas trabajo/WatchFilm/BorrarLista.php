<?php

require_once "_com/DAO.php";

DAO::borrarLista($_REQUEST["listaId"], $_SESSION["id"]);

redireccionar("PaginaPrincipal.php?borrado");