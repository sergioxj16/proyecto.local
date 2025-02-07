<!DOCTYPE html>
<html lang="es">

<?php require_once __DIR__ . "/../controllers/inicio.part.php"; ?>

<body>
    <?php require_once __DIR__ . "/../controllers/navegacion.part.php"; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Detalles del imagen</h2>
        <hr>

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

        <?php if (!empty($imagen)): ?>
            <div class="card shadow-sm">
                <img src="<?= $imagen->getUrlGaleria() ?>" class="card-img-top img-fluid"
                    style="height: 200px; object-fit: cover;" alt="<?= htmlspecialchars($imagen->getNombre()) ?>">
                <div class="card-body">
                    <h3 class="card-title"> <?= htmlspecialchars($imagen->getNombre()) ?> </h3>
                    <p class="card-text"> <?= htmlspecialchars($imagen->getDescripcion()) ?> </p>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Precio:</strong>
                            <?= htmlspecialchars($imagen->getPrecio()) ?>€</li>
                        <li class="list-group-item"><strong>Categoría:</strong>
                            <?= htmlspecialchars($imagen->getCategoria()) ?></li>
                        <li class="list-group-item"><strong>Likes:</strong>
                            <?= htmlspecialchars($imagen->getNumLikes()) ?></li>
                        <li class="list-group-item"><strong>Propietario:</strong>
                            <?= htmlspecialchars($imagen->getPropietario()) ?></li>
                        <li class="list-group-item"><strong>Fecha:</strong> <?= htmlspecialchars($imagen->getFecha()) ?>
                        </li>
                    </ul>
                </div>
                <div class="card-footer text-center">
                    <a href="#" class="btn btn-success like-btn" data-id="<?= $imagen->getId() ?>">Like</a>
                    <a href="index.php" class="btn btn-secondary">Volver</a>
                </div>
            </div>
        <?php else: ?>
            <p class="text-center text-muted">El imagen no está disponible.</p>
        <?php endif; ?>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelector('.like-btn').addEventListener('click', function (event) {
                event.preventDefault();
                let id = this.getAttribute('data-id');

                fetch(window.location.href, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'idLike=' + id
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert(data.message);
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });
    </script>


    <?php require_once __DIR__ . "/../controllers/fin.part.php"; ?>
</body>

</html>