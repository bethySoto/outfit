<?php
include_once URL_APP . '/view/custom/header.php';
include_once URL_APP . '/view/custom/navbar.php';
//echo '<pre>';
//var_dump($params['listaUsuarios']);
//echo '</pre>';
?>

<div class="container">
    <div class="table-responsive">
        <h4 class="mt-5 mb-5 text-center">Online User</h4>
        <div id="user_details">
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th width="70%">Username
                        </th>
                        <th width="20%">Status
                        </th>
                        <th width="10%">Action
                        </th>
                    </tr>
                    <?php foreach ($params['listaUsuarios'] as $datosUsuario) : ?>
                        <tr>
                            <td>
                                <img class="fotoPerfilComentarios" alt="" src="<?php echo $datosUsuario->fotoPerfil ?>">
                                <?php echo $datosUsuario->usuario ?>
                            </td>
                            <td><span class="label label-danger" id="access_<?php echo $datosUsuario->idusuario ?>">Offline</span></td>
                            <td><button type="button" class="btn btn-info btn-xs start_chat" data-touserid="<?php echo $datosUsuario->idusuario ?>" data-tousername="<?php echo $datosUsuario->usuario ?>">Start Chat</button></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
        <div id="user_model_details"></div>
    </div>

</div>

<script>
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
        var modal_content = '<div id="user_dialog_' + to_user_id + '" style="background-color: white;"  class="user_dialog" title="You have chat with ' + to_user_name + '">';
        modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="' + to_user_id + '" id="chat_history_' + to_user_id + '">';
        modal_content += fetch_user_chat_history(to_user_id);
        modal_content += '</div>';
        modal_content += '<div class="form-group">';
        modal_content += '<textarea name="chat_message_' + to_user_id + '" id="chat_message_' + to_user_id + '" class="form-control chat_message"></textarea>';
        modal_content += '</div><div class="form-group" align="right">';
        modal_content += '<button type="button" name="send_chat" id="' + to_user_id + '" class="btn btn-info send_chat">Send</button></div></div>';
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
                var element = $('#chat_message_' + to_user_id).emojioneArea();
                element[0].emojioneArea.setText('');
                $('#chat_history_' + to_user_id).html(data);
            }
        })
    });

    setInterval(function() {
        update_last_activity();
        fetch_user();
        update_chat_history_data();
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
                for (const property in jsonData) {
                    var idUser = jsonData[property].idusuario;
                    var userLastAccess = new Date(jsonData[property].lastAccess);
                    //var segundosRestar = "2021-05-16 19:04:00";
                    var currentDate = new Date(Date.now() - 10000);
                    console.log(currentDate);
                    if (userLastAccess > currentDate) {
                        $("#access_" + idUser).empty();
                        $("#access_" + idUser).append("Online");
                    }
                }

                console.log(jsonData);
            }
        })
    }

    function update_chat_history_data() {
        $('.chat_history').each(function() {
            var to_user_id = $(this).data('touserid');
            fetch_user_chat_history(to_user_id);
        });
    }
</script>

<?php
include_once URL_APP . '/view/custom/footer.php';
?>