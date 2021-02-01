<?php

require_once "DAO.php";

if (!DAO::haySesionRamIniciada() && !DAO::intentarCanjearSesionCookie()) redireccionar("SesionInicioFormulario.php");

$destinatarioId = isset($_REQUEST["destinatarioId"]) ? $_REQUEST["destinatarioId"] : $_SESSION["id"];

$publicacionesDe = DAO::obtenerPublicacionesConDestinatario($destinatarioId);

?>


<html lang=''>
<style>


    td{
        border: 1px solid black;
    }
</style>


<body>

<?php DAO::pintarInfoSesion(); ?>

<h1>Muro de <?= DAO::obtenerNombreUsuario($destinatarioId); ?></h1>

<form method='post' action='PublicacionNuevaCrear.php?destinatarioId=<?= $destinatarioId ?>'>
    <p><strong>¿Qué estás pensando, <?= $_SESSION["nombre"]?></strong></p>
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
    <?php foreach ($publicacionesDe as $p) { ?>
        <tr>
            <td><?= $p->getFecha() ?> </td>
            <td>
                <a href='MuroVerDe.php?destinatarioId=<?= $p->getEmisorId() ?>'><?= DAO::obtenerNombreUsuario($p->getEmisorId()); ?> </a>
            </td>
            <td><?= $p->getAsunto(); ?> </td>
            <td><?= $p->getContenido(); ?></td>
        </tr>
    <?php } ?>
</table>

<br><br>

<a href='Index.php'>VER PORTADA</a>
<br><br>
<a href='MuroVerGlobal.php'>VER MURO GLOBAL</a>

</body>

</html>