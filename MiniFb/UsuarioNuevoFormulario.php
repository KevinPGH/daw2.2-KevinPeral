<?php

require_once "DAO.php";

$error = isset($_REQUEST["error"]);
$contrasennaIncorrecta = isset($_REQUEST["contrasennaIncorrecta"]);
$usuarioErroneo = isset($_REQUEST["usuarioErroneo"]);
$identificador = isset($_REQUEST["identificador"]) ? $_REQUEST["identificador"] : "";
$nombre = isset($_REQUEST["nombre"]) ? $_REQUEST["nombre"] : "";
$apellidos = isset($_REQUEST["apellidos"]) ? $_REQUEST["apellidos"] : "";

?>


<html lang=''>



<body>

<h1>Registrarse</h1>

<?php if ($contrasennaIncorrecta) { ?>
    <p>La contraseña no coincide. <br>Intentelo de nuevo.</p>
<?php } ?>

<?php if ($usuarioErroneo) { ?>
    <p>Alguien usa ya ese identificador. <br>Pruebe otra cosa.</p>
<?php } ?>

<form method='post' action='UsuarioNuevoCrear.php'>

    <table>
        <tr>
            <td><strong>Nombre: </strong>
                <label>
                    <input type='text' name='nombre' id='nombre' value='<?= $nombre ?>'
                           placeholder="Nombre."
                           required/>
                </label>
                <br><br>
                <strong>Apellidos: </strong>
                <label>
                    <input type='text' name='apellidos' id='apellidos' value='<?= $apellidos ?>'
                           placeholder="Apellidos."
                           required/>
                </label>
                <br><br>
                <strong>Identificador: </strong>
                <label>
                    <input type='text' name='identificador' id='identificador' value='<?= $identificador ?>'
                           placeholder="Identificador."
                           required/>
                </label>
                <br><br>
                <strong>Contraseña: </strong>
                <label>
                    <input type='password' name='contrasenna' id='identificador' placeholder="Contraseña."
                           required/>
                </label>
                <br><br>
                <strong>Confirmar Contraseña: </strong>
                <label>
                    <input type='password' name='contrasenna2' id='identificador'
                           placeholder="Contraseña."
                           required/>
                </label>
            </td>
        </tr>
    </table>
    <br/>

    <button type='submit' name='registrarme' value='registrarme'>Registrarme</button>
    <p>Ya tengo cuenta: <a href='SesionInicioFormulario.php'>Iniciar Sesión.</a></p>
</form>
</body>
</html>