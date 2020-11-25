<?php
//recogemos el número pasado de formulario.php
if(isset($_REQUEST['numero'])) {
    $numero = $_REQUEST['numero'];
    if(!isset($_REQUEST["intentado"])){
        $intentado = 0;
    }else
        $intentado = $_POST['intentado'] + 1;

//las próximas veces, usaremos la variable que ya existirá en este mismo archivo
}else{
    $numero = $_POST['numero'];
}
?>

<!DOCTYPE html>
<html lang="">
<head>
    <title>Adivina mi numero</title>
</head>

<body>
<h1>Adivina mi número, Jugador 2!</h1>

<p>Intenta adivinar un número</p>

<!--PHP-SELF me enviará los datos al mismo PHP todas las veces que necesite
 //Con número recogemos el número pasado (la primera vez de formulario.php y las siguientes de juegoDEF,php
  y lo metemos en un input, ponemos type= "hidden" para que el jugador 2 no pueda verlo.
  Con el número de intentos ($intentado) hacemos lo mismo-->

<form  method="post" name="adivinar-numero">
    <label>Ingresa un número, llevas <?=$intentado?> intentos</label><br/ >
    <label for="adivina"></label><input type="text" id="adivina" name="adivina" />
    <label>
        <input name="numero" type="hidden" value="<?=$numero?>" />
    </label>
    <input name="intentado" type="hidden" value="<?= $intentado ?>" />
    <input name="submit" type="submit" value="Averiguar" />
</form>




<?php
//En esta función reocgemos los atributos adivina, numero e intentado de los inputs.
//Comparamos adivina y numero para que dependiendo del resultado lance un mensaje u otro
//Y todo eso lo metemos dentro de un if, que irá comparando mientras el numero de intentos sea menor que 10.
//Cuando pasemos del número de intentos, pondremos el mensaje de se agotaron las oportunidades.

if(isset($_POST["adivina"])){

    $adivina  = $_POST['adivina'];
    $numero  = $_POST['numero'];
    $intentado = $_POST['intentado'];

    if ($intentado < 10) {
        echo "<h4>NOTA: El máximo serán 10 puntos, cada vez que se intente, restarás 1 a tu puntuación. (Número máx intentos: 10)</h4>";
        if ($adivina < $numero) {
            echo "NO! Intenta con un número más alto. <br><br>";
            if (($numero - $adivina) < 50){
                echo "Proximidad: Cerca";
            }else if(($numero - $adivina) > 50 && (($numero - $adivina) < 100)){
                echo"Proximidad: Media";
            }else{
                echo "Proximidad: Lejos";
            }
        } elseif ($adivina > $numero) {
            echo "NO! Intenta con un número más bajo. <br><br>";
            if (($adivina - $numero) < 50){
                echo "Proximidad: Cerca";
            }else if(($adivina - $numero) > 50 && (($adivina - $numero) < 100)){
                echo"Proximidad: Media";
            }else{
                echo "Proximidad: Lejos";
            }

        } elseif ($adivina == $numero) {
            echo "<p>Muy Bien!!! Lo has adivinado!!!</p>";
            echo "<p>Obtuviste " . (10 - $intentado) . " puntos! (Número de intentos: " . ($intentado) . ")</p>";
            echo "<form action='formularioAdivina.php' method='get'>
                <input type='submit' value='Jugar de nuevo'>";
        }


    }else{
        echo "<h3>GAME OVER -->Agotaste el número de intentos máximo (10)</h3>";
        echo "<form action='formularioAdivina.php' method='get'>
                <input type='submit' value='Jugar de nuevo'>";
    }
}

?>

</body>
</html>