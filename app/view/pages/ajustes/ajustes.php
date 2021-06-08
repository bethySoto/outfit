<?php
include_once URL_APP . '/view/custom/header.php';
include_once URL_APP . '/view/custom/navbar.php';
//echo '<pre>';
//var_dump($params);
//echo '</pre>';
?>

<div class="container body-content">
    <div class="row mt-2 text-center">
        <div class="col-12">
            <h2 class="d-inline">
                Perfil
            </h2>
        </div>
    </div>
    <div id="alertError" class="row justify-content-center mt-1" hidden>
        <div class="col-md-7 col-11 alert alert-danger">
            <a href="#" class="close alert-hide" aria-label="close" onclick="$(this).parent().hide();">&times;</a>
            <div id="errorText"></div>
        </div>
    </div>
    <div id="alertSuccess" class="row justify-content-center mt-1" hidden>
        <div class="col-md-7 col-11 alert alert-success">
            <a href="#" class="close alert-hide" aria-label="close" onclick="$(this).parent().hide();">&times;</a>
            <div id="successText"></div>
        </div>
    </div>
    <div class="row justify-content-center mt-4">
        <!--Card perfil foto usuario-->
        <div id="cardTop10Usuarios" class="col-md-5 col-sm-12 mb-5">
            <div class="card shadow cardProfile ml-2 mr-2">
                <div class="cardHeadProfile">
                    <div>
                        <span id="imageProfilePreview" class="imgProfile mw-180 img-fluid"></span>
                    </div>
                </div>
                <div class="card-body text-center">
                    <div id="inputFile">
                        <div id="uploadBtn" class="imagen-para-archivo mt-1 mb-4 mr-5 pr-5" hidden>
                            <label for="boton-archivo" class="btn btn-principal mr-5">
                                <i class="fas fa-images"></i>
                            </label>
                        </div>
                    </div>
                    <div id="cardBodyText">
                        <p class='text-capitalize'>
                            <?php echo $params['usuario']->usuario ?>
                        </p>
                        <p class='text-capitalize'>
                            <?php echo $params['usuario']->correo ?>
                        </p>
                    </div>
                    <button id="btnPwd" type="button" class="btn btn-principal" onclick="changePassword()">
                        <i class="fas fa-key"></i>
                    </button>
                    <button id="btnEditUser" type="button" class="btn btn-principal" onclick="edit()">
                        <i class="far fa-edit"></i>
                    </button>
                </div>
            </div>
        </div>
        <!--Formulario editar usuario-->
        <div id="formDataUser" class="col-md-6 col-sm-12 align-self-center mb-5">
            <div class="row">
                <div class="col-2 col-md-4">
                    <a href="#" class="close text-left" onclick="restartForm()" hidden>×</a>
                </div>
                <div class="col-1 col-md-2"></div>
                <div class="col-9 col-md-6">
                    <h5 class="subTitle mx-w280 border-bottom mb-0 text-right">
                        Preferencias
                    </h5>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-4 text-right">
                    <i class="fas fa-user-circle"></i>
                    Usuario
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" maxlength="50" value="<?php echo $params['usuario']->usuario ?>" class="form-control" id="aliasUser" aria-describedby="SAMAccountName" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-4 text-right">
                    <i class="far fa-user"></i>
                    Nombre
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" maxlength="50" class="form-control" id="NameUser" aria-describedby="nombre" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-4 text-right">
                    <i class="far fa-address-card"></i>
                    Apellidos
                </div>
                <div class="col-12 col-md-8">
                    <input type="text" maxlength="50" class="form-control" id="LastNameUser" aria-describedby="apellidos" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-4 text-right">
                    <i class="fas fa-at"></i>
                    Email
                </div>
                <div class="col-12 col-md-8">
                    <input type="email" maxlength="50" value="<?php echo $params['usuario']->correo ?>" class="form-control" id="EmailUser" aria-describedby="email" placeholder="nameEmail@email.es" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12 col-md-4 text-right">
                    <i class="fas fa-user-slash"></i>
                    Dar de baja
                </div>
                <div class="col-12 col-md-8">
                    <input type="checkbox" class="form-control" id="DeleteUser" disabled>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-5 col-md-7"></div>
                <div class=" col-7 col-md-5">
                    <button id="btnUpdate" type="button" class="btn btn-principal mr-2" onclick="updateUser()" hidden>
                        <i class="far fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
        <!--Fin formulario editar usuario-->

        <!--Formulario cambio de contraseña-->
        <div id="formPassword" class="col-md-6 col-sm-12 align-self-center mb-5" hidden>
            <div class="row mb-3">
                <div class="col-2 col-md-4">
                    <a href="#" class="close text-left" onclick="restartForm()">×</a>
                </div>
                <div class="col-1 col-md-2"></div>
                <div class="col-9 col-md-6">
                    <h5 class="subTitle mx-w280 border-bottom mb-0 text-right">
                        Cambiar contraseña
                    </h5>
                </div>
            </div>
            <div class="row">
                <div class="col-0 col-md-3"></div>
                <div class="col-12 col-md-9">
                    <label for="oldPass">
                        Contraseña actual
                    </label>
                    <div class="input-group groupPassword">
                        <input id="oldPass" type="password" maxlength="40" class="form-control pwdProfile">
                        <span class="input-group-btn">
                            <button class="btn btn-default eyeIcon" type="button" onclick="showHiddePassword($(this))"><i class="fas fa-eye"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-0 col-md-3"></div>
                <div class="col-12 col-md-9">
                    <label for="newPass">
                        Nueva contraseña
                    </label>
                    <div class="input-group groupPassword">
                        <input id="newPass" type="password" maxlength="40" class="form-control pwdProfile">
                        <span class="input-group-btn">
                            <button class="btn btn-default eyeIcon" type="button" onclick="showHiddePassword($(this))"><i class="fas fa-eye"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-0 col-md-3"></div>
                <div class="col-12 col-md-9">
                    <label for="confirmPass">
                        Confirmar contraseña
                    </label>
                    <div class="input-group groupPassword">
                        <input id="confirmPass" type="password" maxlength="40" class="form-control pwdProfile">
                        <span class="input-group-btn">
                            <button class="btn btn-default eyeIcon" type="button" onclick="showHiddePassword($(this))"><i class="fas fa-eye"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-5 col-md-6"></div>
                <div class="col-7 col-md-6">
                    <button type="button" class="btn btn-principal mr-2" onclick="savePassword();">
                        <i class="far fa-save"></i>
                    </button>
                </div>
            </div>
        </div>
        <!--Fin formulario cambio de contraseña-->
        <!--Inicio modal de confirmacion-->
        <div id="confirmAction" class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Confirmación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Confirme que quiere eliminar su cuenta. Tenga en cuenta que la cuenta se elimina de forma permamente sin posibilidad de recuperarla.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="deleteUser()">Confirmar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
        <!--Fín modal de confirmacion-->
        <!-- Modal cargar imagen -->
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
    </div>
</div>


<script>
    //var imageSelect = null;

    $("#imageProfilePreview").css('background', 'url( <?php echo URL_PROJECT . $params['perfil']->fotoPerfil ?> ) no-repeat center');
    $("#imageProfilePreview").css('background-size', 'contain');
    var nombreCompleto = "<?php echo $params['perfil']->nombreCompleto ?>";
    $("#NameUser").val(nombreCompleto.split("-")[0]);
    $("#LastNameUser").val(nombreCompleto.split("-")[1]);


    function edit() {
        $("#NameUser").prop("disabled", false);
        $("#LastNameUser").prop("disabled", false);
        $("#EmailUser").prop("disabled", false);
        $("#rolUser").prop("disabled", false);
        $("#userLanguage").prop("disabled", false);
        $("#DeleteUser").prop("disabled", false);
        $("#aliasUser").prop("disabled", false);

        $("#uploadBtn").attr('hidden', false);
        $("#formDataUser").find(".close").prop("hidden", false);
        $("#btnUpdate").prop("hidden", false);
        $("#formDataUser").prop("hidden", false);
        $("#btnPwd").prop("disabled", true);
    }

    function changePassword() {
        $("#listados").attr('hidden', true);
        $("#btnEditUser").attr('disabled', true);
        $("#formDataUser").prop("hidden", true);
        $("#formPassword").prop("hidden", false);
    }

    function restartForm() {
        $('#alertError').attr('hidden', true);
        $("#listados").attr('hidden', false);

        //data user
        disabledItems();
        $("#uploadBtn").attr('hidden', true);
        $("#formDataUser").prop("hidden", false);
        $("#formPassword").prop("hidden", true);
        $("#formDataUser").find('.close').prop("hidden", true);
        $("#btnUpdate").prop("hidden", true);
        $("#btnEditUser").attr('disabled', false);
        $("#btnPwd").attr('disabled', false);

        //password user
        $('.pwdProfile').val('');
        $(".pwdProfile").attr('type', 'password');
        $(".fa-eye").removeClass("fa-eye-slash");
    }

    function disabledItems() {
        $("#NameUser").prop("disabled", true);
        $("#LastNameUser").prop("disabled", true);
        $("#EmailUser").prop("disabled", true);
        $("#rolUser").prop("disabled", true);
        $("#userLanguage").prop("disabled", true);
        $("#usersCP_Carne").prop("disabled", true);
        $("#aliasUser").prop("disabled", true);
    }

    $("#uploadBtn").click(function() {
        $('#selectImage').modal('show');
    });

    function updateUser() {
        var data = {
            userId: "<?php echo $params['usuario']->idusuario ?>",
            aliasUser: $("#aliasUser").val(),
            completeName: $("#NameUser").val() + "-" + $("#LastNameUser").val(),
            email: JSON.stringify($("#EmailUser").val())
        }

        $.ajax({
            url: "<?php echo URL_PROJECT ?>ajustes/actualizarPerfil",
            method: "POST",
            data: data,
            success: function(data) {
                if (data == "el usuario ya existe") {
                    showAlertError("El nombre del usuario ya existe.");
                } else {
                    location.reload();
                }
            }
        })
    }

    function isPasswordValid() {
        if ($("#oldPass").val() == "") {
            showAlertError("Contraseña actual obligatoria");
            return false;
        }
        if ($("#newPass").val() == "") {
            showAlertError("Nueva contraseña obligatorio");
            return false;
        }
        if ($("#confirmPass").val() == "") {
            showAlertError("Confirmar contraseña obligatorio");
            return false;
        }
        if ($("#newPass").val() != $("#confirmPass").val()) {
            showAlertError("La contraseñas no coinciden");
            return false;
        }

        return true;
    }

    function savePassword() {
        if (isPasswordValid()) {
            var data = {
                userId: "<?php echo $params['usuario']->idusuario ?>",
                oldPass: $("#oldPass").val(),
                newPass: $("#newPass").val()
            }

            $.ajax({
                url: "<?php echo URL_PROJECT ?>ajustes/changePassword",
                method: "POST",
                data: data,
                success: function(data) {
                    if (data == "la contraseña antigua no coincide") {
                        showAlertError("La contraseña acual no es correcta.");
                    } else {
                        showSuccess("Se ha cambiado la contraseña correctamente.");
                    }

                }
            })
        }
    }

    /*function loadImage(input) {
        if (input.target.files.length > 0) {

            var fich = input.target.files[0],
                reader = new FileReader();

            var imgType = fich.type.split('/')[0];
            if (imgType != 'image') {
                showAlertError('Debe seleccionar una imagen con formato valido');
                return;
            }

            let urlPreview = URL.createObjectURL(fich);
            $("#imageProfilePreview").css('background', 'url(' + urlPreview + ') no-repeat center');
            $("#imageProfilePreview").css('background-size', 'contain');

            reader.onloadend = function() {
                imageSelect = fich.name;
            };

            reader.readAsDataURL(fich);
        }
    }*/

    function showAlertError(error) {
        $("#errorText").empty();
        $("#errorText").append('Error!' + error);
        $("#alertSuccess").prop("hidden", true);
        $('#alertError').attr('hidden', false);
    }

    function showSuccess(msg) {
        $("#successText").empty();
        $("#successText").append(msg);
        $('#alertError').attr('hidden', true);
        $("#alertSuccess").prop("hidden", false);
    }

    $("#DeleteUser").click(function() {
        $('#confirmAction').modal('show');
    });

    function deleteUser() {
        var data = {
            userId: "<?php echo $params['usuario']->idusuario ?>"
        }

        $.ajax({
            url: "<?php echo URL_PROJECT ?>ajustes/deleteUser",
            method: "POST",
            data: data,
            success: function(data) {
                location.reload();
            }
        })
    }
</script>

<?php
include_once URL_APP . '/view/custom/footer.php';
?>