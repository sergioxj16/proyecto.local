<?php
use sergio\app\utils\Utils;

?>

<!-- Header -->
<nav class="navbar navbar-expand-lg navbar-light shadow">
    <div class="container d-flex justify-content-between align-items-center">

        <a class="navbar-brand text-success logo h1 align-self-center" href="/">
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

                    <li class="nav-item <?= Utils::esOpcionMenuActiva('') ? 'active' : ''; ?>">
                        <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item <?= Utils::esOpcionMenuActiva('agregarProducto') ? 'active' : ''; ?>">
                        <a class="nav-link" href="agregarProducto">Añadir</a>
                    </li>
                    <li class="nav-item <?= Utils::esOpcionMenuActiva('mostrarGaleria') ? 'active' : ''; ?>">
                        <a class="nav-link" href="mostrarGaleria">Mis productos</a>
                    </li>
                </ul>
            </div>
            <div class="navbar align-self-center d-flex">
                <a class="nav-icon p-1 position-relative text-decoration-none" href="login">
                    <i class="fa fa-fw fa-user text-dark mr-3"></i>
                    <span class="position-absolute top-0 left-100 translate-middle badge rounded-pill bg-light text-dark"></span>
                </a>
            </div>
        </div>

    </div>
</nav>
<!-- Close Header -->
