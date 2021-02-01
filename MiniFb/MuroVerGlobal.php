<?php

require_once "DAO.php";

if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) redireccionar("SesionInicioFormulario.php");

$publicaciones = DAO::obtenerTodasPublicacionesPublicas();

?>


<html lang=''>
<head>
    <style>


        td{
            border: 1px solid black;
        }
    </style>
</head>

<body>

<?php DAO::pintarInfoSesion(); ?>

<h1>Muro global</h1>

<form method='post' action='PublicacionNuevaCrear.php?destinatarioId=-1'>
    <p><strong>¿Qué estás pensando, <?= $_SESSION["nombre"]?> ?</strong></p>
    <label for='asunto'>Asunto: </label>
    <input type='text' id='asunto' name='asunto' required>
    <label for='contenido'>Contenido: </label>
    <input type='text' id='contenido' name='contenido' required>
    <button type='submit'>Enviar</button>
</form>

<table>
    <tr>
        <th>FECHA</th>
        <th>USUARIO</th>
        <th>ASUNTO</th>
        <th>CONTENIDO</th>
    </tr>
    <?php foreach ($publicaciones as $p) { ?>
        <tr>

            <td><?= $p->getFecha() ?></td>
            <td>
                <a href='MuroVerDe.php?destinatarioId=<?= $p->getEmisorId() ?>'><?= DAO::obtenerNombreUsuario($p->getEmisorId()); ?></a>
            </td>
            <td><?= $p->getAsunto(); ?></td>
            <td><?= $p->getContenido(); ?></td>
        </tr>
    <?php } ?>
</table>

<br><br>
<a href='./MuroVerDe.php'>VER MI MURO</a>

</body>

</html>