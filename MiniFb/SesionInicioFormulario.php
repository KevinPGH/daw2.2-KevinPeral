<?php

require_once "DAO.php";

if (DAO::haySesionRamIniciada()) redireccionar("MuroVerGlobal.php");

$datosErroneos = isset($_REQUEST["datosErroneos"]);

?>


<html lang=''>


<body>

<h1>Iniciar sesión</h1>

<?php if ($datosErroneos) { ?>
    <p>Los datos no son correctos. Inténtelo de nuevo.</p>
<?php } ?>

<form action='SesionInicioComprobar.php' method="post">
    <label for='identificador'>Identificador</label>
    <label>
        <input type='text' name='identificador'>
    </label><br><br>

    <label for='contrasenna'>Contraseña</label>
    <input type='password' name='contrasenna' id='contrasenna'><br><br>

    <label for='recordarme'>Recuérdame</label>
    <input type='checkbox' name='recordar' id='recordarme'><br><br>

    <input type='submit' value='Iniciar Sesión'>
</form>

<p>O, si no tienes una cuenta aún, <a href='UsuarioNuevoFormulario.php'>créala aquí</a>.</p>

</body>

</html>