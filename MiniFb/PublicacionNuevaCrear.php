<?php

require_once "DAO.php";

if ($_REQUEST["destinatarioId"] == -1) $destinatarioId = null;
else $destinatarioId = $_REQUEST["destinatarioId"];

DAO::crearNuevaPublicacion($destinatarioId, $_REQUEST["asunto"], $_REQUEST["contenido"]);

redireccionar(getenv('HTTP_REFERER'));