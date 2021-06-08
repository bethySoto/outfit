<?php
include_once URL_APP . '/view/custom/header.php';
include_once URL_APP . '/view/custom/navbar.php';
//echo '<pre>';
//var_dump($params['notificaciones']);
//echo '</pre>';
?>

<div class="container">
    <div class="row mt-3" style="background-color: green;">
        <h3>Tienes <?php echo $params['misNotificaciones'] ?> notificaciones</h3>
        <hr>
    </div>

    <div class="container">
        <?php foreach ($params['notificaciones'] as $datosNotificacion) : ?>
            <a href="<?php echo URL_PROJECT ?>/notificaciones/eliminar/ <?php echo $datosNotificacion->idnotificacion ?>" class="links">
                <div class="alert alert-success"><?php echo $datosNotificacion->usuario . ' ' . $datosNotificacion->mensajeNotificacion ?></div>
            </a>

        <?php endforeach ?>
    </div>

</div>

<?php
include_once URL_APP . '/view/custom/footer.php';
?>