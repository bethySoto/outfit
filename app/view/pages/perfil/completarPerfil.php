<?php
include_once URL_APP . '/view/custom/header.php';
include_once URL_APP . '/view/custom/navbar.php';
?>

<div class="container ">
    <div class="row">
        <h2>Ajustes de perfil</h2>
    </div>
    <div class="row">
        <form action="<?php echo URL_PROJECT ?>home/insertarRegistrosPerfil" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="id_user" value="<?php echo $_SESSION['logueado'] ?>">
            <div class="form-group">
                <label for="formGroupExampleInput">Nombre</label>
                <input type="text" class="form-control" id="formGroupExampleInput" name="nombre" placeholder="Nombre completo">
            </div>
            <div class="form-group">
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="imagen" name="imagen" accept="image/x-png,image/gif,image/jpeg" lang="es">
                    <label class="custom-file-label" for="imagen">Seleccionar una foto</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>
</div>





<?php
include_once URL_APP . '/view/custom/footer.php';
?>