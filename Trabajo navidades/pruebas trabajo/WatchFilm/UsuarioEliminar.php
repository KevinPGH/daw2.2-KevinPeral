<?php

// aqui lo borra pero no redirecciona mirarlo

require_once "_com/DAO.php";

$identificador = $_SESSION["identificador"];
DAO::usuarioEliminar($identificador);
redireccionar("SesionInicioFormulario.php");