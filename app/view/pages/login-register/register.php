<?php
include_once URL_APP . '/view/custom/header.php';
?>

<div class="container">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-3">
            <h4>Registrarme</h4>

            <?php if(isset($_SESSION['usuarioError'] )): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['usuarioError']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php unset($_SESSION['usuarioError'] ); endif ?>

            <form action="<?php echo URL_PROJECT?>home/register" method="POST">
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Contraseña" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="confirmPassword" placeholder="Confirmar contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Registrarme</button>
            </form>
            <div class="contenido-link mt-2">
                <span class="mr-2">¿Ya tienes una cuenta?</span><a href="<?php echo URL_PROJECT?>home/login">Ingresar</a>
            </div>
        </div>
        <div class="col-6">
            <img src="<?php echo URL_PROJECT?>img/vector.png" alt="Imagen de inicio de sesión">
        </div>
    </div>
</div>


<?php 
    include_once URL_APP . '/view/custom/footer.php';
?>