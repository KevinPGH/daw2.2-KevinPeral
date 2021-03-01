<?php

require_once "_com/DAO.php";

if (DAO::haySesionRamIniciada() || DAO::intentarCanjearSesionCookie()) redireccionar("PaginaPrincipal.php");

$datosErroneos = isset($_REQUEST["datosErroneos"]);
$nuevoUsuario = isset($_REQUEST["nuevo"]);
$sesionCerrada = isset($_REQUEST["cerrarSesion"]);

?>


<html lang=''>

<head>
    <meta charset='UTF-8'>
    <title></title>
</head>

<body>

<?php if ($sesionCerrada) { ?>
    <p class='error'>Has cerrado sesión</p>
<?php } ?>

<h1>Iniciar Sesión</h1>

<?php if ($datosErroneos) { ?>
    <p class='error'>Los datos introducidos no son correctos.</p>
<?php } ?>

<?php if ($nuevoUsuario) { ?>
    <p>Te has registrado correctamente.<br>Por favor, inicia sesión.</p>
<?php } ?>

<form method='post' action='SesionInicioComprobar.php'>

    <table>
        <tr>
            <td>
                <strong>Nombre de Usuario: </strong>
                <label>
                    <input type='text' name='identificador' id='identificador' placeholder="Introduce tu nombre."
                           required/>
                </label>
                <br><br>
                <strong>Contraseña: </strong>
                <label>
                    <input type='password' name='contrasenna' id='identificador' placeholder="Introduce tu contraseña."
                           required/>
                </label>
                <br><br>
                <strong>Recuerdame: </strong>
                <label>
                    <input type='checkbox' name='recordar' id='recordar'>
                </label>
            </td>
        </tr>
    </table>
    <br/>

    <button type='submit' name='iniciar' value='Iniciar Sesión'>Iniciar Sesion</button>
    <p>No tengo cuenta: <a href='UsuarioNuevoFormulario.php'>Registrarse.</a></p>
</form>
</body>
</html>