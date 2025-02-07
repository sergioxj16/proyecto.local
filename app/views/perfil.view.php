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
                        <h4 class="card-title text-center mb-4">Perfil de Usuario</h4>

                        <!-- Mostrar datos del usuario -->
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Nombre:</strong> <?php echo htmlspecialchars($usuarioActual->getNombre()); ?></li>
                            <li class="list-group-item"><strong>Apellido:</strong> <?php echo htmlspecialchars($usuarioActual->getApellido()); ?></li>
                            <li class="list-group-item"><strong>Correo:</strong> <?php echo htmlspecialchars($usuarioActual->getCorreo()); ?></li>
                            <li class="list-group-item"><strong>Rol:</strong> <?php echo htmlspecialchars($usuarioActual->getRol() === 1 ? 'Usuario' : 'Administrador'); ?></li>
                        </ul>

                        <div class="text-center mt-4">
                            <a href="editarPerfil.php" class="btn btn-primary">Editar Perfil</a>
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
