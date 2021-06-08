<?php
include_once URL_APP . '/view/custom/header.php';
include_once URL_APP . '/view/custom/navbar.php';
//echo '<pre>';
//var_dump($params['resultado']);
//var_dump($params['peticiones']);
//echo '</pre>';
$peticionEnviada = false;
?>

<div class="container">
    <div class="table-responsive">
        <h4 class="mt-5 mb-5 text-center">Resultados de la busqueda</h4>
        <div id="user_details">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="70%">Username
                        </th>
                        <th width="10%">Action
                        </th>
                    </tr>
                    <?php foreach ($params['resultado'] as $usuariosRegistrados) :   $peticionEnviada = false; ?>
                        <?php foreach ($params['peticiones'] as $peticiones) {
                            if ($peticiones->paraIdUser == $usuariosRegistrados->idusuario || $peticiones->deIdUser == $usuariosRegistrados->idusuario) {
                                $peticionEnviada = true;
                            }
                        }
                        ?>
                        <tr>
                            <td>
                                <img class="fotoPerfilComentarios" alt="" src="<?php echo URL_PROJECT . '/' . $usuariosRegistrados->fotoPerfil ?>">
                                <a class="font-weight-bold mb-0" href="<?php echo URL_PROJECT ?>perfil/<?php echo $usuariosRegistrados->usuario ?>"><?php echo $usuariosRegistrados->usuario ?></a>
                            </td>
                            <td>
                                <i id="check<?php echo $usuariosRegistrados->idusuario ?>" class="fas fa-check" <?php if ($peticionEnviada) : ?>></i>
                            <?php else : ?>
                                style="display: none;"></i>
                                <button id="button<?php echo $usuariosRegistrados->idusuario ?>" type="button" class="btn btn-info btn-xs followUser" data-touserid="<?php echo $usuariosRegistrados->idusuario ?>">Follow</button>
                            <?php endif ?>

                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div id="user_model_details"></div>
    </div>
</div>

<script>
    $(".followUser").click(function() {
        var to_user_id = $(this).data('touserid');
        $.ajax({
            url: "<?php echo URL_PROJECT ?>Solicitudes/followUser",
            method: "POST",
            data: {
                paraIdUser: to_user_id,
                deIdUser: "<?php echo $params['usuario']->idusuario ?>"
            },
            success: function(data) {
                if (data == 1) {
                    $("#check" + to_user_id).show();
                    $("#button" + to_user_id).hide();
                }
            }
        })
    });
</script>

<?php
include_once URL_APP . '/view/custom/footer.php';
?>