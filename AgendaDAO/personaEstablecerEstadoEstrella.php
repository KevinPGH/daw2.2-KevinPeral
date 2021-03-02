<?php

require_once "dao.php";
$id = $_REQUEST["id"];
$estrella = DAO::personaCambiarEstrella($id);

redireccionar("PersonaListado.php");