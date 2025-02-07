<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: login');
    exit;
}

$usuario = $_SESSION['usuario']; // Obtener los datos del usuario desde la sesión
?>

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
                        <h4 class="card-title text-center mb-4">Editar Perfil</h4>

                        <?php if (isset($error)) : ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>

                        <form action="editar-perfil" method="POST">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo htmlspecialchars($usuario['apellido']); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo</label>
                                <input type="email" class="form-control" id="correo" name="correo" value="<?php echo htmlspecialchars($usuario['correo']); ?>" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Actualizar Perfil</button>
                            </div>
                        </form>
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
