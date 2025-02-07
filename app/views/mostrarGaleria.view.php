<!DOCTYPE html>
<html lang="es">

<?php require_once __DIR__ . "/../controllers/inicio.part.php"; ?>

<body>
    <?php require_once __DIR__ . "/../controllers/navegacion.part.php"; ?>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Galería de Imágenes</h2>
        <hr>

        <div class="mb-3">
            <?php
            $filtroActivo = '';
            if (isset($_GET['fecha']) && $_GET['fecha'] !== '') {
                $filtroActivo = 'Filtrando por Fecha: ' . htmlspecialchars($_GET['fecha']);
            } elseif (isset($_GET['precio']) && $_GET['precio'] !== '') {
                $filtroActivo = 'Filtrando por Precio: Hasta ' . htmlspecialchars($_GET['precio']) . '€';
            } elseif (isset($_GET['likes']) && $_GET['likes'] !== '') {
                $filtroActivo = 'Filtrando por Likes: Mínimo ' . htmlspecialchars($_GET['likes']);
            } elseif (isset($_GET['categoria']) && $_GET['categoria'] !== '') {
                $filtroActivo = 'Filtrando por Categoría: ' . htmlspecialchars($_GET['categoria']);
            } elseif (isset($_GET['autor']) && $_GET['autor'] !== '') {
                $filtroActivo = 'Buscando por Autor: ' . htmlspecialchars($_GET['autor']);
            } elseif (isset($_GET['ordenar'])) {
                $filtroActivo = $_GET['ordenar'] === 'precio' ? 'Ordenando por Precio' : 'Ordenando por Likes';
            }
            if ($filtroActivo): ?>
                <div class="alert alert-info">
                    <strong>Filtro activo:</strong> <?= $filtroActivo ?>
                </div>
            <?php endif; ?>
        </div>

        <form method="get" class="mb-4">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="fecha" class="form-label">Filtrar por Fecha</label>
                        <input type="date" class="form-control" id="fecha" name="fecha"
                            value="<?= $_GET['fecha'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="precio" class="form-label">Filtrar por Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" min="0" step="0.01"
                            value="<?= $_GET['precio'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="likes" class="form-label">Filtrar por Likes</label>
                        <input type="number" class="form-control" id="likes" name="likes" min="0"
                            value="<?= $_GET['likes'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="categoria" class="form-label">Filtrar por Categoría</label>
                        <select class="form-control" id="categoria" name="categoria">
                            <option value="">Selecciona una categoría</option>
                            <option value="1" <?= ($_GET['categoria'] ?? '') === '1' ? 'selected' : '' ?>>1</option>
                            <option value="2" <?= ($_GET['categoria'] ?? '') === '2' ? 'selected' : '' ?>>2</option>
                            <option value="3" <?= ($_GET['categoria'] ?? '') === '3' ? 'selected' : '' ?>>3</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="autor" class="form-label">Buscar por Propietario</label>
                        <input type="text" class="form-control" id="autor" name="Propietario"
                            value="<?= $_GET['propietario'] ?? '' ?>" placeholder="Buscar Propietario...">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-primary me-md-2">
                            <i class="bi bi-funnel"></i> Filtrar
                        </button>
                        <a href="mostrarGaleria" class="btn btn-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Limpiar
                        </a>
                    </div>
                </div>
            </div>
        </form>

        <div class="mb-4">
            <a href="mostrarGaleria?ordenar=precio" class="btn btn-success me-2">Ordenar por Precio</a>
            <a href="mostrarGaleria?ordenar=likes" class="btn btn-warning">Ordenar por Likes</a>
        </div>

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
                                <img src="<?= $imagen->getUrlGaleria() ?>" class="card-img-top img-fluid"
                                    style="height: 200px; object-fit: cover;"
                                    alt="<?= htmlspecialchars($imagen->getNombre()) ?>">

                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($imagen->getNombre()) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($imagen->getDescripcion()) ?></p>
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
                                        <li class="list-group-item">
                                            <strong>Fecha:</strong> <?= htmlspecialchars($imagen->getFecha()) ?>
                                        </li>
                                    </ul>
                                </div>

                                <div class="card-footer text-center">
                                    <a href="imagenDetalles?id=<?= $imagen->getId() ?>" class="btn btn-primary">Ver más</a>

                                    <a href="editarProducto?id=<?= $imagen->getId() ?>" class="btn btn-success btn-sm">
                                        <i class="bi bi-eye"></i> Editar
                                    </a>
                                    <a href="mostrarGaleria?borrar=<?= $imagen->getId() ?>" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Borrar
                                    </a>
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

    <?php require_once __DIR__ . "/../controllers/fin.part.php"; ?>
</body>

</html>