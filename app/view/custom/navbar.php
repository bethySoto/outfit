<!-- Navbar-->
<nav class="navbar navbar-expand-lg navbar-light bg-light">

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="container-fluid ">
        <!-- Left elements -->
        <div class="d-flex">
            <!-- Brand -->
            <ul class="navbar-nav flex-row d-none d-md-flex">
            <!--Chat-->
                <li class="nav-item me-3 me-lg-1 ">
                    <a class="nav-link" href="<?php echo URL_PROJECT ?>chat">
                        <i class="fas fa-comments fa-lg"></i>

                        <span class="badge rounded-pill badge-notification bg-danger">6</span>
                    </a>
                </li>
                <li class="nav-item me-3 me-lg-1 active">
                    <a class="nav-link" href="<?php echo URL_PROJECT ?>home">
                        <span><i class="fas fa-home fa-lg"></i></span>
                        <!--<span class="badge rounded-pill badge-notification bg-danger">1</span>-->
                    </a>
                </li>
                <li class="nav-item me-3 me-lg-1">
                    <a class="nav-link" href="<?php echo URL_PROJECT ?>solicitudes">
                        <span><i class="fas fa-users fa-lg"></i></span>
                        <span class="badge rounded-pill badge-notification bg-danger">2</span>
                    </a>
                </li>
            </ul>

            <!-- Search form -->
            <form action="<?php echo URL_PROJECT?>home/buscar" method="POST" class="input-group w-auto my-auto d-none d-sm-flex">
                <input name="buscar" autocomplete="off" type="search" class="form-control rounded" placeholder="Search" style="min-width: 125px;" />
                <button class="input-group-text border-0  my-2 my-sm-0" type="submit"><i class="fas fa-search"></i></button>
            </form>
        </div>
        <!-- Left elements -->

        <!-- Right elements -->
        <ul class="navbar-nav flex-row">

            <li class="nav-item dropdown me-3 me-lg-1">
                <a class="nav-link" href="<?php echo URL_PROJECT ?>notificaciones">
                    <i class="fas fa-bell fa-lg"></i>
                    <?php if ($params['misNotificaciones'] > 0) : ?>
                        <span class="badge rounded-pill badge-notification bg-danger"><?php echo $params['misNotificaciones'] ?></span>
                    <?php endif ?>
                </a>
            </li>
            <li class="nav-item dropdown me-3 me-lg-1">
                <a class="nav-link" href="<?php echo URL_PROJECT ?>ajustes">
                    <i class="fas fa-user-cog fa-lg"></i>
                </a>
            </li>
            <li class="nav-item me-3 me-lg-1">
                <div class="dropdown">
                    <a class="nav-link d-sm-flex align-items-sm-center dropdown-toggle" href="#" data-toggle="dropdown">
                        <?php if ($params['perfil']) {
                            $fotoPerfil = URL_PROJECT . '/' . $params['perfil']->fotoPerfil;
                        } else {
                            $fotoPerfil = "https://mdbootstrap.com/img/new/avatars/1.jpg";
                        } ?>
                        <img src="<?php echo $fotoPerfil ?>" class="rounded-circle" height="22" alt="" loading="lazy" />
                        <strong class="d-none d-sm-block ms-1"><?php echo $params['usuario']->usuario ?></strong>
                    </a>
                    <ul class="dropdown-menu" style="min-width: auto;">
                        <li>
                            <a class="dropdown-item " href="<?php echo URL_PROJECT ?>home/logout">
                                <i class="fas fa-sign-out-alt fa-lg"></i> Salir
                            </a>
                        </li>
                        <li><a class="dropdown-item " href="#">Otros</a></li>
                    </ul>
                </div>
            </li>
        </ul>
        <!-- Right elements -->
    </div>
</nav>
<!-- Navbar -->