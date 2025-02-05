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
                        <h4 class="card-title text-center mb-4">Registro</h4>
                        <form class="form-horizontal" id="formularioRegistro" action="/register" method="post">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($nombre ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellidos</label>
                                <input type="text" class="form-control" id="apellidos" name="apellido" value="<?= htmlspecialchars($apellido ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password_confirm" class="form-label">Confirmar contraseña</label>
                                <input type="password" class="form-control" id="password_confirm" name="password_confirm" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>

                        <?php if ($hayError): ?>
                            <div class="alert alert-danger mt-3">
                                <?php foreach ($errores as $error): ?>
                                    <p><?= htmlspecialchars($error) ?></p>
                                <?php endforeach; ?>
                            </div>
                        <?php elseif ($mensaje): ?>
                            <div class="alert alert-success mt-3">
                                <p><?= htmlspecialchars($mensaje) ?></p>
                            </div>
                        <?php endif; ?>

                        <div class="mt-3 text-center">
                            <p>¿Ya tienes una cuenta? <a href="login" class="btn btn-link">Iniciar sesión</a></p>
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
