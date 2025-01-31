<?php
require_once __DIR__ . '/../src/utils/utils.class.php';
?>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">

        <a class="navbar-brand text-success logo h1 align-self-center" href="index.php">
            Zay
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse"
            data-bs-target="#templatemo_main_nav" aria-controls="navbarSupportedContent" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="align-self-center collapse navbar-collapse flex-fill d-lg-flex justify-content-lg-between"
            id="templatemo_main_nav">
            <div class="flex-fill">
                <ul class="nav navbar-nav d-flex justify-content-between mx-lg-auto">

                    <li class="nav-item <?= Utils::esOpcionMenuActiva('/index.php') || Utils::esOpcionMenuActiva('/') ? 'active' : ''; ?>">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>

                    <li class="nav-item <?= Utils::esOpcionMenuActiva('/shop.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="shop.php">Tienda</a>
                    </li>
                    <li class="nav-item <?= Utils::esOpcionMenuActiva('/agregarProducto.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="agregarProducto.php">Añadir</a>
                    </li>
                    <li class="nav-item <?= Utils::esOpcionMenuActiva('/mostrarGaleria.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="mostrarGaleria.php">Galeria</a>
                    </li>
                    <li class="nav-item <?= Utils::esOpcionMenuActiva('/contact.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item <?= Utils::esOpcionMenuActiva('/about.php') ? 'active' : ''; ?>">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">
                <!-- <a class="nav-icon p-1 position-relative text-decoration-none" href="#">
                    <i class="fa fa-fw fa-cart-arrow-down text-dark mr-1"></i>
                    <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"></span>
                </a> -->
                <a class="nav-icon p-1 position-relative text-decoration-none" href="login.php">
                    <i class="fa fa-fw fa-user text-dark mr-3"></i>
                    <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"></span>
                </a>
            </div>
        </div>

    </div>
</nav>
<!-- Close Header -->
