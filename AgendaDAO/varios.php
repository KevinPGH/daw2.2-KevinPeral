<?php
declare(strict_types=1);


function syso(string $contenido)
{
    file_put_contents('php://stderr', $contenido . "\n");
}


function recogerTema(){
    session_start();
    if (isset($_REQUEST[$_SESSION["fondo"]])){
        $_SESSION["fondo"] = $_REQUEST["fondo"];
    }
}

function establecerTema()
{
    session_start();
    if (!isset($_SESSION["fondo"]) && !isset($_REQUEST["fondo"])) {
        $_SESSION["fondo"] = "";
    } else if (isset($_REQUEST["fondo"])) {
        $_SESSION["fondo"] = $_REQUEST["fondo"];
    }

}
?>
