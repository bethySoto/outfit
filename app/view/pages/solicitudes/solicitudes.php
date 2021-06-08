<?php
include_once URL_APP . '/view/custom/header.php';
include_once URL_APP . '/view/custom/navbar.php';
//echo '<pre>';
//var_dump($params['amigos']);
//echo '</pre>';
?>

<div class="container body-content">
    <div class="row mt-5 text-center">
        <div class="col-12 ">
            <h2 class="subTitle">Solicitudes de amistad</h2>
            <div class="btn-group mb-3 mt-4">
                <button type="button" class="btn btn-principal activo" id="verSolicitudes"><i class="fas fa-user-plus"></i></button>
                <button type="button" class="btn btn-principal" id="verAmigos"><i class="fas fa-user-friends"></i></button>
            </div>
        </div>
    </div>
    <div class="row mb-5 mt-5 justify-content-center" id="tablaSolicitudesAmistad">
        <div class="col-md-7 mt-2">
            <div class="table-responsive-md">
                <table id="tablaSolicitudes" class="table table-striped w-100  mt-3">
                    <thead hidden>
                        <tr>
                            <th>Username</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($params['solicitudesPendientes'] as $solicitudes) : ?>
                            <tr id="fila<?php echo $solicitudes->idSolicitud ?>">
                                <td>
                                    <img class="fotoPerfilComentarios" style="max-width: 85px;max-height: 85px;" alt="" src="<?php echo URL_PROJECT . '/' . $solicitudes->fotoPerfil ?>">
                                    <a class="font-weight-bold mb-0" href="<?php echo URL_PROJECT ?>perfil/<?php echo $solicitudes->usuario ?>"><?php echo $solicitudes->usuario ?></a>
                                    <p class="font-weight-normal float-right"><?php echo $solicitudes->timestamp ?></p>
                                    <br>
                                    <button type="button" class="btn btn-info btn-xs aceptar" style="margin-left: 4rem!important;" data-idsolicitud="<?php echo $solicitudes->idSolicitud ?>">Aceptar</button>
                                    <button type="button" class="btn btn-secondary btn-xs eliminar" data-idsolicitud="<?php echo $solicitudes->idSolicitud ?>">Eliminar</button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row mb-5 mt-5 justify-content-center" id="tablaAmigos" style="display: none;">
        <div class="col-md-7 mt-2">
            <div class="table-responsive-md">
                <table id="tablaListadoAmigos" class="table table-striped w-100  mt-3">
                    <thead hidden>
                        <tr>
                            <th>Username</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody id="bodyAmigos">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id="user_model_details"></div>
</div>

<script>
    $('#verAmigos').click(function(e) {
        //verAmigos(e);
        getAmigos();
    });

    $('#verSolicitudes').click(function(e) {
        verSolicitudes(e);
    });

    function verAmigos() {
        $('#tablaSolicitudesAmistad').hide();
        $('#tablaAmigos').show();
        $("#verSolicitudes").removeClass("activo");
        $("#verAmigos").addClass("activo");
        $('h2').empty();
        $('h2').append("Amigos");
    }

    function verSolicitudes(e) {
        e.preventDefault();
        $('#tablaAmigos').hide();
        $('#tablaSolicitudesAmistad').show();
        $("#verAmigos").removeClass("activo");
        $("#verSolicitudes").addClass("activo");
        $('h2').empty();
        $('h2').append("Solicitudes de amistad");
    }

    function getAmigos() {
        $.ajax({
            url: "<?php echo URL_PROJECT ?>Solicitudes/getAmigos",
            method: "POST",
            data: {
                idUser: "<?php echo $params['usuario']->idusuario ?>"
            },
            success: function(data) {
                var jsonData = JSON.parse(data);
                dataTablaAmigos(jsonData);
                //$("#bodyAmigos").empty();
                /*for (const property in jsonData) {
                    $("#bodyAmigos").append('<tr><td>' +
                        '<img class="fotoPerfilComentarios" style="max-width: 85px;max-height: 85px;" alt="" src="' + jsonData[property].fotoPerfil + '">' +
                        '<span class="nameUser">' + jsonData[property].usuario + '</span>' +
                        '</td><td>' +
                        '<i class="far fa-eye fa-lg"></i><a class="font-weight-bold mb-0 ml-2" href="<?php echo URL_PROJECT ?>perfil/' + jsonData[property].usuario + '"> Perfil</a>' +
                        '<p class="mt-2"><i class="fas fa-comment-dots fa-lg"></i> <span data-touserid="' + jsonData[property].idusuario + '" data-tousername="' + jsonData[property].usuario + '" class="font-weight-bold mb-0 ml-2 start_chat"> Chat </span></p>' +
                        '</td></tr>'
                    );
                }*/
                verAmigos();
            }
        });
    }

    //CHAT
    $(document).on('click', '.start_chat', function() {
        var to_user_id = $(this).data('touserid');
        var to_user_name = $(this).data('tousername');
        make_chat_dialog_box(to_user_id, to_user_name);
        $("#user_dialog_" + to_user_id).dialog({
            autoOpen: false,
            width: 400
        });
        $('#user_dialog_' + to_user_id).dialog('open');
        $('#chat_message_' + to_user_id).emojioneArea({
            pickerPosition: "top",
            toneStyle: "bullet"
        });
    });

    function make_chat_dialog_box(to_user_id, to_user_name) {
        var modal_content = '<div id="user_dialog_' + to_user_id + '"  class="user_dialog" title="' + to_user_name.toUpperCase() + '">';
        modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="' + to_user_id + '" id="chat_history_' + to_user_id + '">';
        modal_content += fetch_user_chat_history(to_user_id);
        modal_content += '</div>';
        modal_content += '<div class="form-group">';
        modal_content += '<textarea name="chat_message_' + to_user_id + '" id="chat_message_' + to_user_id + '" class="form-control chat_message"></textarea>';
        modal_content += '</div><div class="form-group" align="right">';
        modal_content += '<button type="button" name="send_chat" id="' + to_user_id + '" class="btn btn-info send_chat"><i class="fas fa-paper-plane"></i> Enviar</button></div></div>';
        $('#user_model_details').html(modal_content);
    }

    function fetch_user_chat_history(to_user_id) {
        $.ajax({
            url: "<?php echo URL_PROJECT ?>chat/userChatHistory",
            method: "POST",
            data: {
                to_user_id: to_user_id,
                from_user_id: "<?php echo $params['usuario']->idusuario ?>"
            },
            success: function(data) {
                $('#chat_history_' + to_user_id).html(data);
            }
        })
    }

    $(document).on('click', '.send_chat', function() {
        var to_user_id = $(this).attr('id');
        var chat_message = $('#chat_message_' + to_user_id).val();
        $.ajax({
            url: "<?php echo URL_PROJECT ?>chat/insertChat",
            method: "POST",
            data: {
                to_user_id: to_user_id,
                from_user_id: "<?php echo $params['usuario']->idusuario ?>",
                chat_message: chat_message
            },
            success: function(data) {
                //$('#chat_message_'+to_user_id).val('');
                var element = $('#chat_message_' + to_user_id).emojioneArea();
                element[0].emojioneArea.setText('');
                $('#chat_history_' + to_user_id).html(data);
            }
        })
    });

    //FIN CHAT


    var tablaSolicitudes = $('#tablaSolicitudes').DataTable({
        "stateSave": false,
        "paging": true,
        "sPaginationType": "full_numbers",
        "language": {
            "search": "",
            "searchPlaceholder": "Buscar...",
            "info": "Página _PAGE_ de _PAGES_",
            "sLengthMenu": "Ver: _MENU_",
            "zeroRecords": "No hay resultados",
            "infoFiltered": "",
            "infoEmpty": "Página 0 de 0",
            "paginate": {
                "first": "<i class='fas fa-step-backward'></i> ",
                "last": " <i class='fas fa-step-forward'></i>",
                "next": " <i class='fas fa-angle-right'></i>",
                "previous": "<i class='fas fa-angle-left'></i> "
            }
        },
        "deferRender": true
    });

    $("#tablaSolicitudes_length").hide();

    /*$('#tablaListadoAmigos').DataTable({
        "stateSave": false,
        "paging": true,
        "sPaginationType": "full_numbers",
        "language": {
            "search": "",
            "searchPlaceholder": "Buscar...",
            "info": "Página _PAGE_ de _PAGES_",
            "sLengthMenu": "Ver: _MENU_",
            "zeroRecords": "No hay resultados",
            "infoFiltered": "",
            "infoEmpty": "Página 0 de 0",
            "paginate": {
                "first": "<i class='fas fa-step-backward'></i> ",
                "last": " <i class='fas fa-step-forward'></i>",
                "next": " <i class='fas fa-angle-right'></i>",
                "previous": "<i class='fas fa-angle-left'></i> "
            }
        },
        "deferRender": true
    });*/

    function dataTablaAmigos(datos) {
        $('#tablaListadoAmigos').DataTable().destroy();
        var paintData = [];
        if (datos != null) {
            for (var i = 0; i < datos.length; i++) {
                var perfil = '<img class="fotoPerfilComentarios" style="max-width: 85px;max-height: 85px;" alt="" src="' + datos[i].fotoPerfil + '">' +
                    '<span class="nameUser">' + datos[i].usuario + '</span>';

                var acciones = '<i class="far fa-eye fa-lg"></i><a class="font-weight-bold mb-0 ml-2" href="<?php echo URL_PROJECT ?>perfil/' + datos[i].usuario + '"> Perfil</a>' +
                    '<p class="mt-2"><i class="fas fa-comment-dots fa-lg"></i> <span data-touserid="' + datos[i].idusuario + '" data-tousername="' + datos[i].usuario + '" class="font-weight-bold mb-0 ml-2 start_chat"> Chat </span></p>';

                paintData.push({
                    perfil: perfil,
                    acciones: acciones
                });
            }
        }

        $('#tablaListadoAmigos').DataTable({
            "data": paintData,
            "columns": [{
                    "data": "perfil"
                },
                {
                    "data": "acciones"
                }
            ],
            "sPaginationType": "full_numbers",
            "lengthChange": false,
            "paging": true,
            "language": {
                "search": "",
                "searchPlaceholder": "Buscar...",
                "info": "Página _PAGE_ de _PAGES_",
                "sLengthMenu": "Ver: _MENU_",
                "zeroRecords": "No hay resultados",
                "infoFiltered": "",
                "infoEmpty": "Página 0 de 0",
                "paginate": {
                    "first": "<i class='fas fa-step-backward'></i> ",
                    "last": " <i class='fas fa-step-forward'></i>",
                    "next": " <i class='fas fa-angle-right'></i>",
                    "previous": "<i class='fas fa-angle-left'></i> "
                }
            },
            "deferRender": true
        });
    }

    $(".aceptar").click(function() {
        var idSolicitud = $(this).data('idsolicitud');
        var fila = $(this).parents('tr');
        $.ajax({
            url: "<?php echo URL_PROJECT ?>Solicitudes/aceptarSolicitud",
            method: "POST",
            data: {
                idSolicitud: idSolicitud
            },
            success: function(data) {
                if (data == 1) {
                    tablaSolicitudes.row(fila).remove().draw(false);
                }
            }
        })
    });

    $(".eliminar").click(function() {
        var idSolicitud = $(this).data('idsolicitud');
        var fila = $(this).parents('tr');
        $.ajax({
            url: "<?php echo URL_PROJECT ?>Solicitudes/eliminarSolicitud",
            method: "POST",
            data: {
                idSolicitud: idSolicitud
            },
            success: function(data) {
                if (data == 1) {
                    //$("#fila" + idSolicitud).remove();
                    tablaSolicitudes.row(fila).remove().draw(false);
                }
            }
        })
    });
</script>

<?php
include_once URL_APP . '/view/custom/footer.php';
?>