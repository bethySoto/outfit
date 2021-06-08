<?php
include_once URL_APP . '/view/custom/header.php';
include_once URL_APP . '/view/custom/navbar.php';

if ($params['usuario']->idusuario == $params['OtroUsuario']->idusuario) {
    $usuarioLogueado = true;
} else {
    $usuarioLogueado = false;
}

if ($params['OtroPerfil']) {
    $fotoPerfil = URL_PROJECT . '/' . $params['OtroPerfil']->fotoPerfil;
} else {
    $fotoPerfil = "https://mdbootstrap.com/img/new/avatars/1.jpg";
}

/*echo '<pre>';
var_dump($params['comentarios']);
echo '</pre>';
echo URL_PROJECT;*/
?>

<div class="contenedor">
    <div class="px-4 pt-0 pb-4 cover">

    </div>
    <div class="row justify-content-center">
        <div class="col-md-3">
            <div class="dataUser">
                <div class="avatar">
                    <img alt="" src="<?php echo $fotoPerfil ?>">
                </div>
                <?php if ($usuarioLogueado) { ?>
                    <div class="iconSettings">
                        <i class="fas fa-images fa-lg"></i>
                    </div>
                <?php } ?>
                <div class="pb-4">
                    <?php echo $params['OtroUsuario']->usuario ?>
                </div>
                <?php if ($usuarioLogueado) { ?>
                    <p>
                        <a href="<?php echo URL_PROJECT ?>solicitudes"><i class="fas fa-user-plus"></i> Solicitudes</a>
                    </p>
                    <p>
                        <a href="<?php echo URL_PROJECT ?>notificaciones"><i class="far fa-bell"></i> Notificaciones</a>
                    </p>
                    <p>
                        <a href="<?php echo URL_PROJECT ?>ajustes"><i class="fas fa-cog"></i> Datos</a>
                    </p>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-5">
            <?php if ($usuarioLogueado) { ?>
                <div class="row publicaciones">
                    <div class="col-md-2">
                        <img class="fotoPerfilComentarios" alt="" src="<?php echo $fotoPerfil ?>">
                    </div>
                    <div class="col-md-10">
                        <form>
                            <div class="form-group">
                                <textarea class="form-control textPublicacion" id="exampleFormControlTextarea1" placeholder="¿Qué estas pensando?"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Publicar</button>
                        </form>
                    </div>
                </div>
            <?php } ?>
            <?php foreach ($params['publicaciones'] as $datosPublicacion) : ?>
                <div class="row publicaciones mt-3">
                    <div class="col-md-2">
                        <img class="fotoPerfilComentarios" alt="" src="<?php echo "../" . $datosPublicacion->fotoPerfil ?>">
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
                                    <img class="fotoPerfilComentarios" alt="" src="<?php echo URL_PROJECT. $params['perfil']->fotoPerfil ?>">
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
                                        <img class="fotoPerfilComentarios" alt="" src="<?php echo URL_PROJECT . $datosComentarios->fotoPerfil ?>">
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
        <div class="col-md-3">
            <div style="background-color: rgba(214, 224, 226, 0.2); border-radius: 20px;border: 1px solid rgba(0,0,0,.125);">
                <div class="col-12 mt-2">
                    <h4 class="subTitle"><i class="fas fa-clock mr-2" style="color: #6c8195 !important;"></i>Publicaciones recientes</h4>
                </div>
                <div id="contentFavoritos">
                    <table id="tablaPublicacionesRecientes">
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
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="selectImage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?php echo URL_PROJECT ?>perfil/cambiarImagen/" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_user" value="<?php echo $_SESSION['logueado'] ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="imagen" name="imagen" lang="es" accept="image/x-png,image/gif,image/jpeg">
                            <label class="custom-file-label" for="imagen">Seleccionar una foto</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Cambiar foto</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(".iconSettings").click(function() {
        $('#selectImage').modal('show');
    });

    getPublicacionesRecientes();

    function getPublicacionesRecientes() {
        console.log("<?php echo URL_PROJECT ?>hola");
        $.ajax({
            url: "<?php echo URL_PROJECT ?>perfil/publicacionesRecientes",
            method: "GET",
            success: function(data) {
                var jsonData = JSON.parse(data);
                $("#tablaPublicacionesRecientes").empty();
                for (var i = 0; i < jsonData.length; i++) {
                    var contenido = jsonData[i].contenidoPublicacion;
                    if (jsonData[i].fotoPublicacion == "img/imagenesPublicaciones/") {
                        var datos = '<tr class="mt-3 trFavoritos"><td colspan="2" style="border: 10px solid transparent;">' +
                            '<a href="#">' +
                            '<span style="font-size: 13px;">' + contenido.substring(0, 70) + '...</span>' +
                            '</a>' +
                            '</td></tr>';
                        $("#tablaPublicacionesRecientes").append(datos);
                    } else {
                        var datos = '<tr class="mt-3 trFavoritos"><td style="border: 15px solid transparent;">' +
                            '<a href="#">' +
                            '<img class="img-fluid" src="<?php echo URL_PROJECT . '/' ?>' + jsonData[i].fotoPublicacion + '" alt="">' +
                            '</a></td><td style="border: 10px solid transparent;">' +
                            '<a href="#">' +
                            '<span style="font-size: 13px;">' + contenido.substring(0, 70) + '...</span>' +
                            '</a></td></tr>';
                        $("#tablaPublicacionesRecientes").append(datos);
                    }
                }
            }
        })
    }

    function showComentRow(idPublicacion) {
        console.log(idPublicacion);
        $("#rowComentar" + idPublicacion).toggle();
    }

    //CHAT
    fetch_user();

    setInterval(function() {
        update_last_activity();
        fetch_user();
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
                        $("#listadoUsuarios").append("<li><img class='fotoPerfilListado mr-2' src='<?php echo URL_PROJECT ?>" + jsonData[property].fotoPerfil + "'> <a href='<?php echo URL_PROJECT ?>perfil/" + jsonData[property].usuario + "'>" + jsonData[property].usuario + "</li>");
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