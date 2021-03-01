<?php

require_once "_com/DAO.php";

$rs = DAO::VerFichaUsuario();

$identificador = $rs[0]["identificador"];
$nombre = $rs[0]["nombre"];
$apellidos = $rs[0]["apellidos"];
$email = $rs[0]["email"];
$contrasenna = $rs[0]["contrasenna"];

$contrasenna2 = null;

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

<?php cambiarTemaLinks(); ?>

<br><br>

<h1><img src="_img/usuario.png" alt="">&nbsp; Datos personales</h1>

<form action="UsuarioGuardarModificacion.php" method="post">

    <ul>
        <li>
            <p>Identificador:</p>
            <label>
                <input type="text" name="identificador" value="<?= $identificador ?>">
            </label>
            <p>Nombre:</p>
            <label>
                <input type="text" name="nombre" value="<?= $nombre ?>">
            </label>
            <p>Apellidos:</p>
            <label>
                <input type="text" name="apellidos" value="<?= $apellidos ?>">
            </label>
            <p>Email:</p>
            <label>
                <input type="text" name="email" value="<?= $email ?>">
            </label>


        </li>

    </ul>

    <input type="submit" name="guardar" value="Guardar cambios"/><br><br>

    <a href="./UsuarioEliminar.php?identificador=<?= $identificador ?>">Borrar este usuario</a>

</form>

<form action="CambioContrasenna.php" method="post">
    <ul>
        <li>

            <p>Para cambiar la contraseña introduce tu contraseña anterior</p>
            <label>
                <input type="text" name="contrasenna2" value="<?= $contrasenna2 ?>">
                <input type="submit" name="guardar" value="Guardar cambios"/><br><br>
            </label>

        </li>

    </ul>
</form>

<a href="PaginaPrincipal.php">Volver a Pagina Principal.</a>
</body>
</html>