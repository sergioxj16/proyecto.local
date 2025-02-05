<!DOCTYPE html>
<html lang="es">

<?php
require_once __DIR__ . "/../controllers/inicio.part.php";
?>

<body>
    <!-- Start Header -->
    <?php
    require_once __DIR__ . "/../controllers/navegacion.part.php";
    ?>
    <!-- End Header -->

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center mb-4">Iniciar sesión</h4>
                        <form action="login_process.php" method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Iniciar sesión</button>
                            </div>
                        </form>
                        <div class="mt-3 text-center">
                            <p>¿No tienes una cuenta? <a href="register" class="btn btn-link">Registrarse</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Start Footer -->
    <?php
    require_once __DIR__ . "/../controllers/fin.part.php";
    ?>
    <!-- End Footer -->


</body>

</html>