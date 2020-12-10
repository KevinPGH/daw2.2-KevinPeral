<?php
require_once "_Varios.php";

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>

<header>

</header>


<body>

<h1>Iniciar Sesión</h1>

<form method="post" action="SesionInicioComprobar.php" name="formulario">
    <div>
        <label>Nombre de usuario</label>
        <input type="text" name="identificador" required />
    </div>
    <div>
        <label>Contraseña</label>
        <input type="password" name="contrasenna" required />
    </div>
    <button type="submit" name="login" value="login">Log In</button>

    <a href="FormularioNuevoUsuario.php">Crear Nuevo Usuario</a>
</form>

</body>

</html>