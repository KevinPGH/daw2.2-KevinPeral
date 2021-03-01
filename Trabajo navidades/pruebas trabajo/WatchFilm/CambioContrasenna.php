<?php

require_once "_com/DAO.php";

$rs = DAO::VerFichaUsuario();

$identificador = $rs[0]["identificador"];
$contrasenna = $rs[0]["contrasenna"];
$contrasenna2 = $_REQUEST["contrasenna2"];

$tema = comprobarTema();
?>


<html lang=''>
<head>
    <meta charset='UTF-8'>
    <title></title>
    <?php if ($tema) { ?>
        <link rel="stylesheet" href="_styles/styleBlack.css">
    <?php } else { ?>
        <link rel="stylesheet" href="_styles/style.css">
    <?php } ?>
</head>

<body class='<?= $tema ?>'>

<?php
if ($contrasenna == $contrasenna2) { ?>
    <h1 style="color:green">Contraseñas iguales</h1>

    <form action="UsuarioGuardarModificacion.php?id=-1" method="post">
        <ul>
            <li>
                <p>Tu identificador:</p>
                <label>
                    <input type="text" name="identificador" value="<?= $identificador ?>">
                </label>

                <p>Introduce aqui tu nueva contraseña:</p>
                <label>
                    <input type="text" name="contrasenna" value="<?= $contrasenna2 ?>">
                </label>

            </li>

        </ul>

        <input type="submit" name="guardar" value="Guardar cambios"/><br><br>

    </form>
<?php } else { ?>
    <h1 style="color:red">Contraseña incorrecta,vuelve hacia atras y escribela de nuevo</h1>
    <a href="UsuarioFicha.php">Volver a intentar</a>
<?php } ?>
</body>
</html>
