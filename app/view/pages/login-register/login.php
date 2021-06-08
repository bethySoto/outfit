<?php
include_once URL_APP . '/view/custom/header.php';
//var_dump($params);
?>

<div class="container">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-3">
            <h4>Iniciar sesión</h4>
            <!--Alert error login-->
            <?php if(isset($_SESSION['errorLogin'] )): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['errorLogin']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php unset($_SESSION['errorLogin'] ); endif ?>
            <!--Fin alert error login-->
            <!--Alert registro correcto-->
            <?php if(isset($_SESSION['registerComplete'] )): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo $_SESSION['registerComplete']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php unset($_SESSION['registerComplete'] ); endif ?>
            <!--Fin alert registro correcto-->

            <form action="<?php echo URL_PROJECT?>home/login" method="POST">
            <div class="mb-3">
                    <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
                </div>
                <button type="submit" class="btn btn-primary">Ingresar</button>
            </form>
            <div class="contenido-link mt-2">
                <span class="mr-2">¿No tiene una cuenta?</span><a href="<?php echo URL_PROJECT?>home/register">Registrarme</a>
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