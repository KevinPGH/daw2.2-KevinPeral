<?php

if (!isset($_REQUEST["acumulado"]) || isset($_REQUEST["reset"])){
    $acumulado = 0;
} else {
    $acumulado = (int) $_REQUEST["acumulado"] + 1;
}

?>
<html>



<form method='get'>

    <input type='hidden' name='acumulado' value='<?=$acumulado?>'>

    <input type='submit' value=' +1 ' name='suma'>

    <br /><br />

    <input type='submit' value='Reiniciar' name='reset'>

    <p> <?php echo $acumulado?></p>
    <br /><br />


</form>

</html>
