<?php
include_once URL_APP . '/view/custom/header.php';
include_once URL_APP . '/view/custom/navbar.php';
echo '<pre>';
//var_dump($params['misLikes']);
echo '</pre>';
if ($params['perfil']) {
    $fotoPerfil = URL_PROJECT . '/' . $params['perfil']->fotoPerfil;
} else {
    $fotoPerfil = "https://mdbootstrap.com/img/new/avatars/1.jpg";
}
?>
<!--COLUMNA PERFIL-->
<div class="colLeft">
    <div class="card hovercard">
        <div class="cardheader"></div>
        <div class="avatar">
            <img alt="" src="<?php echo $fotoPerfil ?>">
        </div>
        <div class="info">
            <div class="title">
                <a href="<?php echo URL_PROJECT ?>perfil/<?php echo $params['usuario']->usuario ?>"><?php echo $params['usuario']->usuario ?></a>
            </div>
        </div>
        <div class="bottom">

        </div>
    </div>
    <!--<div class="mt-3" style="background-color: rgba(214, 224, 226, 0.2); border-radius: 20px;border: 1px solid rgba(0,0,0,.125);">
        <div class="col-12 mt-2" style="text-align: center;">
            <h4 class="subTitle"><a class="nav-link" href="<?php echo URL_PROJECT ?>ajustes"><i class="fas fa-cog mr-2" style="color: #6c8195 !important;"></i>Ajustes </a></h4>
        </div>
    </div>-->
</div>

<!--COLUMNA EVENTOS-->
<div class="colRight">
    <div style="background-color: rgba(214, 224, 226, 0.2); border-radius: 20px;border: 1px solid rgba(0,0,0,.125);">
        <div class="col-12 mt-2">
            <h4 class="subTitle"><i class="fab fa-gratipay mr-2" style="color: #6c8195 !important;"></i>Favoritos</h4>
        </div>
        <div id="contentFavoritos">
            <table class="tablaFavoritos">
                <?php foreach ($params['misLikes'] as $misFavoritos) {
                    if ($misFavoritos->fotoPublicacion == "img/imagenesPublicaciones/") { ?>
                        <tr class="mt-3 trFavoritos">
                            <td colspan="2" style="border: 10px solid transparent;">
                                <a href="#publicacion-<?php echo $misFavoritos->idPublicacion; ?>">
                                    <span style="font-size: 13px;"><?php echo substr($misFavoritos->contenidoPublicacion, 0, 70); ?> ...</span>
                                </a>
                            </td>
                        </tr>
                    <?php } else { ?>
                        <tr class="mt-3 trFavoritos">
                            <td style="border: 15px solid transparent;">
                                <a href="#publicacion-<?php echo $misFavoritos->idPublicacion; ?>">
                                    <img class="img-fluid" src="<?php echo URL_PROJECT . '/' . $misFavoritos->fotoPublicacion ?>" alt="">
                                </a>
                            </td>
                            <td style="border: 10px solid transparent;">
                                <a href="#publicacion-<?php echo $misFavoritos->idPublicacion; ?>">
                                    <span style="font-size: 13px;"><?php echo substr($misFavoritos->contenidoPublicacion, 0, 70); ?> ...</span>
                                </a>
                            </td>
                        </tr>
                <?php }
                } ?>
            </table>
        </div>
    </div>
    <div class="mt-3" style="background-color: rgba(214, 224, 226, 0.2); border-radius: 20px;border: 1px solid rgba(0,0,0,.125);">
        <div class="col-12 mt-2">
            <h4 class="subTitle"><i class="fas fa-user-circle mr-1" style="color: #6c8195 !important;"></i>Contactos en linea</h4>
        </div>
        <div class="col-12">
            <ul id="listadoUsuarios" class="pt-3">
                No hay usuarios conectados
            </ul>
        </div>
    </div>
</div>

<div class="container">
    <div class="row mt-3">
        <div class="col-md-3"></div>

        <!--COLUMNA PRINCIPAL-->
        <div class="col-md-6">
            <div class="row publicaciones">
                <div class="col-md-2">
                    <img class="fotoPerfilComentarios" alt="" src="<?php echo $fotoPerfil ?>">
                </div>
                <div class="col-md-10">
                    <form action="<?php echo URL_PROJECT ?>publicaciones/publicar/<?php echo $params['usuario']->idusuario ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <textarea name="contenido" class="form-control textPublicacion" id="exampleFormControlTextarea1" placeholder="¿Qué estas pensando?"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-9">
                                <img class="fas fa-images fa-lg" />
                                <input type="file" class="fotoPublicacion" name="imagen" accept="image/x-png,image/gif,image/jpeg">
                            </div>
                            <div class="col-3">
                                <button type="submit" class="btn btn-primary">Publicar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <?php foreach ($params['publicaciones'] as $datosPublicacion) : ?>
                <div id="publicacion-<?php echo $datosPublicacion->idpublicacion ?>" class="row publicaciones mt-3">
                    <div class="col-md-2">
                        <img class="fotoPerfilComentarios" alt="" src="<?php echo $datosPublicacion->fotoPerfil ?>">
                    </div>
                    <div class="col-md-8 mt-2">
                        <p class="font-weight-bold mb-0"><a href="<?php echo URL_PROJECT ?>perfil/<?php echo $datosPublicacion->usuario ?>"><?php echo $datosPublicacion->usuario ?></a></p>
                        <p class="font-weight-normal"><?php echo $datosPublicacion->fechaPublicacion ?></p>
                    </div>
                    <!--Eliminar publicación-->
                    <div class="col-md-2 mt-2">
                        <?php if ($datosPublicacion->idusuario == $_SESSION['logueado']) : ?>
                            <a href="<?php echo URL_PROJECT ?>publicaciones/eliminar/<?php echo $datosPublicacion->idpublicacion ?>"><i class="fas fa-trash fa-lg"></i></a>
                        <?php endif ?>
                    </div>
                    <div class="row">
                        <div class="col ml-4 mt-3 mr-4">
                            <p class="font-weight-normal"><?php echo $datosPublicacion->contenidoPublicacion ?></p>
                            <img class="img-fluid" src="<?php echo URL_PROJECT . '/' . $datosPublicacion->fotoPublicacion ?>" alt="">
                        </div>
                    </div>
                    <div class="row ml-4 mt-3 mr-4" style="width: 100%;">
                        <!--Like publicación-->
                        <div class="col-11">
                            <a href="<?php echo URL_PROJECT ?>publicaciones/megusta/<?php echo $datosPublicacion->idpublicacion . '/' . $_SESSION['logueado'] . '/' . $datosPublicacion->idusuario ?>">
                                <i class="<?php
                                            foreach ($params['misLikes'] as $misLikesUser) {
                                                if ($misLikesUser->idPublicacion == $datosPublicacion->idpublicacion) {
                                                    echo 'likeActive';
                                                }
                                            }
                                            ?> fas fa-heart fa-lg"></i>
                                <spam><?php echo $datosPublicacion->num_likes ?></spam>
                            </a>
                        </div>
                        <!--Comentar publicación-->
                        <div class="col-1">
                            <a href="javascript:showComentRow(<?php echo  $datosPublicacion->idpublicacion ?>);">
                                <i class="far fa-comment-alt fa-lg"></i>
                            </a>
                        </div>
                    </div>
                    <!--Comentar publicación-->
                    <div id="rowComentar<?php echo  $datosPublicacion->idpublicacion ?>" style="display: none">
                        <form action="<?php echo URL_PROJECT ?>publicaciones/comentar" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="iduserPropietario" value="<?php echo $datosPublicacion->idusuario ?>">
                            <input type="hidden" name="idusuario" value="<?php echo $params['usuario']->idusuario ?>">
                            <input type="hidden" name="idpublicacion" value="<?php echo $datosPublicacion->idpublicacion ?>">
                            <input type="hidden" name="comentarioText" class="comentarioOculto" />
                            <div class="row g-3 ml-4 mt-4 align-items-center">
                                <div class="col-md-2">
                                    <img class="fotoPerfilComentarios" alt="" src="<?php echo $params['perfil']->fotoPerfil ?>">
                                </div>
                                <div class="col-md-8 pl-4">
                                    <div class="comentario" contentEditable=true placeholder="Escribe un comentario" onkeyup="setComentario($(this))"></div>
                                </div>
                                <div class="col-md-2">
                                    <button id="comentar" type="submit" class="btn btn-light"><i class="fas fa-paper-plane fa-lg"></i></button>
                                </div>
                            </div>
                        </form>
                        <!--Historico de comentarios-->
                        <?php foreach ($params['comentarios'] as $datosComentarios) : ?>
                            <?php if ($datosComentarios->idPublicacion == $datosPublicacion->idpublicacion) : ?>
                                <div class="row g-3 ml-4 mt-4 align-items-center">
                                    <div class="col-md-2">
                                        <img class="fotoPerfilComentarios" alt="" src="<?php echo $datosComentarios->fotoPerfil ?>">
                                    </div>
                                    <div class="col-md-10 pt-4">
                                        <?php if ($datosComentarios->iduser == $_SESSION['logueado']) : ?>
                                            <a href="<?php echo URL_PROJECT ?>publicaciones/eliminarComentario/<?php echo $datosComentarios->idcomentario ?>" class="float-right mr-5"><i class="far fa-trash-alt fa-lg"></i></a>
                                        <?php endif ?>
                                        <a class="font-weight-bold mb-0" href="<?php echo URL_PROJECT ?>perfil/<?php echo $datosComentarios->usuario ?>"><?php echo $datosComentarios->usuario ?></a>
                                        <span class="font-weight-normal ml-2"><?php echo $datosComentarios->fechaComentario ?></span>
                                        <p id="textComentario"><?php echo $datosComentarios->contenidoComentario ?></p>
                                    </div>
                                </div>
                            <?php endif ?>
                        <?php endforeach ?>

                    </div>
                </div>
            <?php endforeach ?>

        </div>

        <div class="col-md-3"></div>
    </div>
</div>
<script>
    fetch_user();

    function setComentario(that) {

        $(".comentarioOculto").val(that.text());
        console.log($(".comentarioOculto").val());
    }

    function showComentRow(idPublicacion) {
        console.log(idPublicacion);
        $("#rowComentar" + idPublicacion).toggle();
    }

    //CHAT

    setInterval(function() {
        update_last_activity();
        fetch_user();
        //update_chat_history_data();
    }, 5000);


    function update_last_activity() {
        $.ajax({
            url: "<?php echo URL_PROJECT ?>chat/LastAccessUser",
            method: "POST",
            data: {
                userId: "<?php echo $params['usuario']->idusuario ?>",
            },
            success: function() {

            }
        })
    }

    function fetch_user() {
        $.ajax({
            url: "<?php echo URL_PROJECT ?>chat/listUsers",
            method: "POST",
            data: {
                userId: "<?php echo $params['usuario']->idusuario ?>",
            },
            success: function(data) {
                var jsonData = JSON.parse(data);
                var usuarioEnLinea = false;
                console.log(jsonData);
                for (const property in jsonData) {
                    var idUser = jsonData[property].idusuario;
                    var userLastAccess = new Date(jsonData[property].lastAccess);
                    //var segundosRestar = "2021-05-16 19:04:00";
                    var currentDate = new Date(Date.now() - 10000);
                    if (userLastAccess > currentDate) {
                        usuarioEnLinea = true;
                        console.log("online");
                        $("#listadoUsuarios").empty();
                        $("#listadoUsuarios").append("<li><img class='fotoPerfilListado mr-2' src='" + jsonData[property].fotoPerfil + "'> <a href='<?php echo URL_PROJECT ?>perfil/" + jsonData[property].usuario + "'>" + jsonData[property].usuario + "</li>");
                    }
                }
                /*if (!usuarioEnLinea) {
                    $("#listadoUsuarios").empty();
                    $("#listadoUsuarios").append("No hay usuarios conectados");
                }*/
            }
        })
    }

    //FIN CHAT
</script>
<?php
include_once URL_APP . '/view/custom/footer.php';
?>
