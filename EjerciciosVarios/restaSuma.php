<?php

if (!isset($_REQUEST["acumulado"]) || isset($_REQUEST["reset"])){
$acumulado = 0;
$numero=0;
}else if (isset($_REQUEST["suma"])){
    $acumulado = (int) $_REQUEST["acumulado"] + (int)$_REQUEST["numero"];
    $numero = $_GET["numero"];

}else if (isset($_REQUEST["resta"])) {
    $acumulado = (int)$_REQUEST["acumulado"] - (int)$_REQUEST["numero"];
    $numero = $_GET["numero"];
}

?>

<html>


<form method='get'>

    <input type='hidden' name='acumulado' value='<?=$acumulado?>'>
    <input type="submit" name="resta" value="-">
    <input type="text" name="numero" value="<?=$numero?>">
    <input type="submit" name="suma" value="+" >


    <br /><br />

    <input type='submit' value='Reiniciar' name='reset'>

    <p> <?php echo $acumulado?></p>
    <br /><br />


</form>


</html>


