<?php

?>



<html>

<head>
    <meta charset='UTF-8'>
</head>



<body>

<h1>Iniciar Sesión</h1>

<form method="post" action="ComprobarNuevoUsuario.php" name="formulario">
    <div>
        <label>Nombre de usuario</label>
        <input type="text" name="identificador" required />
    </div>
    <div>
        <label>Contraseña</label>
        <input type="password" name="contrasenna" required />
    </div>
    <div>
        <label>Nombre</label>
        <input type="text" name="nombre" required />
    </div>
    <div>
        <label>Apellidos</label>
        <input type="text" name="apellidos" required />
    </div>


    <button type="submit" name="login" value="login">Log In</button>
</form>

</body>

</html>
