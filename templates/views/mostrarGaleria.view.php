<!DOCTYPE html>
<html lang="es">

<?php require_once __DIR__ . "/../inicio.part.php"; ?>

<body>
    <?php require_once __DIR__ . "/../navegacion.part.php"; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Galería de Imágenes</h2>
        <hr>

        <!-- Mostrar mensajes de error o éxito -->
        <?php if (!empty($errores)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errores as $error): ?>
                        <li><?php echo htmlspecialchars($error); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?php if (!empty($mensaje)): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($mensaje); ?>
            </div>
        <?php endif; ?>

        <div id="MostrarGaleria">
            <?php if (!empty($imagenes)): ?>
                <div class="row">
                    <?php foreach ($imagenes as $imagen): ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100 shadow-sm">
                                <!-- Imagen -->
                                <img src="<?= $imagen->getUrlGaleria() ?>" class="card-img-top img-fluid"
                                    style="height: 200px; object-fit: cover;"
                                    alt="<?= htmlspecialchars($imagen->getNombre()) ?>">

                                <!-- Contenido de la tarjeta -->
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($imagen->getNombre()) ?></h5>
                                    <p class="card-text text-muted"><?= htmlspecialchars($imagen->getDescripcion()) ?></p>
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Categoría:</strong> <?= htmlspecialchars($imagen->getCategoria()) ?>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Likes:</strong> <?= htmlspecialchars($imagen->getNumLikes()) ?>
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Precio:</strong> <?= htmlspecialchars($imagen->getPrecio()) ?>€
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Propietario:</strong> <?= htmlspecialchars($imagen->getPropietario()) ?>
                                        </li>
                                    </ul>
                                </div>

                                <!-- Botón de acción (opcional) -->
                                <div class="card-footer text-center">
                                    <a href="#" class="btn btn-primary btn-sm">Ver más</a>
                                    <a href="#" class="btn btn-danger btn-danger">Borrar</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center text-muted">No hay imágenes disponibles en la galería.</p>
            <?php endif; ?>
        </div>
    </div>

    <?php require_once __DIR__ . "/../fin.part.php"; ?>

</body>

</html>