<?php

$numero1 = $_GET['numero1'];
$numero2 = $_GET['numero2'];
$operador = $_GET['operador'];

if($operador == "+"){
    $solucion = $numero1 + $numero2;
}else if($operador == "-"){
    $solucion = $numero1 - $numero2;
}else if($operador == "*"){
    $solucion = $numero1 * $numero2;
}else if($operador == "/"){
    if($numero2 == 0){
        $solucion = "Error, no se puede dividir entre 0";
    }else {
        $solucion = $numero1 / $numero2;
    }
}
echo "La solución es: ".$solucion;
?>
