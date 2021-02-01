<?php

require_once "DAO.php";

DAO::destruirSesionRamYCookie();

redireccionar("Index.php");