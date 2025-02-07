<!DOCTYPE html>
<html lang="es">

<?php
require_once __DIR__ . "/../controllers/inicio.part.php";
?>

<body>
    <?php require_once __DIR__ . "/../controllers/navegacion.part.php"; ?>

    <div id="galeria">
        <div class="container">
            <div class="col-xs-12 col-sm-8 col-sm-push-2 pb-5 pt-5">
                <h2 class="text-center">Editar Imagen</h2>
                <hr>

                <?php if (!empty($errores) || $exito): ?>
                    <div class="alert alert-<?= $exito ? 'success' : 'danger'; ?> alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php if (!$exito): ?>
                            <ul>
                                <?php foreach ($errores as $error): ?>
                                    <li><?= htmlspecialchars($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p>Imagen actualizada con éxito.</p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <form method="POST" enctype="multipart/form-data" action="?id=<?= htmlspecialchars($_GET['id']) ?>">

                    <label class="col-sm-3 control-label" for="imagen">Imagen</label>
                    <div class="col-sm-9">
                        <input class="form-control-file" type="file" name="imagen" id="imagen">
                    </div>
                    <div class="col-sm-9">
                        <?php if ($imagen && $imagen->getUrlGaleria()): ?>
                            <img src="<?= htmlspecialchars($imagen->getUrlGaleria()) ?>" alt="Imagen actual" id="imgPreview"
                                class="img-thumbnail mb-3 mt-3">
                        <?php else: ?>
                            <p class="text-muted">No hay imagen previa</p>
                        <?php endif; ?>
                    </div>

                    <label class="col-sm-3 control-label" for="nombre">Nombre</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nombre" name="nombre"
                            value="<?= htmlspecialchars($imagen ? $imagen->getNombre() : '') ?>" required>
                    </div>

                    <label class="col-sm-3 control-label" for="descripcion">Descripción</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="descripcion" id="descripcion"
                            rows="3"><?= htmlspecialchars($imagen ? $imagen->getDescripcion() : '') ?></textarea>
                    </div>

                    <label class="col-sm-3 control-label" for="categoria">Categoría</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="categoria" name="categoria" required>
                            <?php
                            $categorias = [1, 2, 3];
                            foreach ($categorias as $cat):
                                ?>
                                <option value="<?= $cat ?>" <?= $imagen && $imagen->getCategoria() == $cat ? 'selected' : '' ?>><?= $cat ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <label class="col-sm-3 control-label" for="precio">Precio</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="precio" name="precio"
                            value="<?= htmlspecialchars($imagen ? number_format($imagen->getPrecio(), 2, '.', '') : '') ?>"
                            required>
                    </div>
                    <div id="errorPrecio" class="text-danger" style="display:none;">El precio debe tener solo dos
                        decimales.</div>

                    <label class="col-sm-3 control-label" for="fecha">Fecha</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="fecha" name="fecha"
                            value="<?= htmlspecialchars($imagen ? date('Y-m-d', strtotime($imagen->getFecha())) : '') ?>"
                            required>
                    </div>

                    <div class="col-sm-offset-3 col-sm-9 pt-3 d-flex">
                        <button type="submit" class="btn btn-primary btn-lg" style="margin-right: 10px;">Guardar
                            Cambios</button>
                        <a href="mostrarGaleria" class="btn btn-secondary btn-lg">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        <?php if ($exito): ?>
            borrarFormulario();
        <?php endif; ?>
    </script>

    <?php require_once __DIR__ . "/../controllers/fin.part.php"; ?>
</body>

</html>