<!DOCTYPE html>
<html lang="es">

<?php
require_once __DIR__ . "/../inicio.part.php";
$formularioEnviado = !empty($mensaje) && empty($errores);
?>

<body>
    <script src="../../public/js/agregarProducto.js" defer></script>
    <!-- Start Header -->
    <?php
    require_once __DIR__ . "/../navegacion.part.php";
    ?>
    <!-- End Header -->
    <!-- Principal Content Start -->
    <div id="galeria">
        <div class="container">
            <div class="col-xs-12 col-sm-8 col-sm-push-2 pb-5 pt-5">
                <h2 class="text-center">Subir imágenes:</h2>
                <hr>
                <!-- Sección que muestra la confirmación del formulario o bien sus errores -->
                <?php if ($hayError || !empty($mensaje)): ?>
                    <div class="alert alert-<?= $hayError ? 'danger' : 'info'; ?> alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <?php if ($hayError): ?>
                            <ul>
                                <?php foreach ($errores as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                        <?php else: ?>
                            <p><?= $mensaje ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Formulario para subir imagen con su descripción -->
                <form class="form-horizontal" id="formularioSubida" action="<?= $_SERVER['PHP_SELF'] ?>" method="post"
                    enctype="multipart/form-data" onsubmit="return validarPrecio()">

                    <label class="col-sm-3 control-label" for="imagen">Imagen</label>
                    <div class="col-sm-9">
                        <input class="form-control-file" type="file" name="imagen" id="imagen" required>
                    </div>
                    <div class="col-sm-9">
                        <img src="" alt="" id="imgPreview" class="img-thumbnail mb-3 mt-3 d-none">
                    </div>

                    <label class="col-sm-3 control-label" for="titulo">Titulo</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="titulo" name="titulo" value="<?= $titulo ?>"
                            required>
                    </div>
                    <label class="col-sm-3 control-label" for="descripcion">Descripción</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3"
                            required><?= $descripcion ?></textarea>
                    </div>

                    <label class="col-sm-3 control-label" for="categoria">Categoría</label>
                    <div class="col-sm-9">
                        <select class="form-control" id="categoria" name="categoria" required>
                            <option value="" disabled <?= $categoria == '' ? 'selected' : '' ?>>Seleccionar categoría
                            </option>
                            <option value="1" <?= $categoria == '1' ? 'selected' : '' ?>>1</option>
                            <option value="2" <?= $categoria == '2' ? 'selected' : '' ?>>2</option>
                            <option value="3" <?= $categoria == '3' ? 'selected' : '' ?>>3</option>
                        </select>
                    </div>

                    <label class="col-sm-3 control-label" for="precio">Precio</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="precio" name="precio" value="<?= $precio ?>"
                            required>
                    </div>
                    <div id="errorPrecio" class="text-danger" style="display:none;">
                        El precio debe tener solo dos decimales.
                    </div>

                    <div class="col-sm-offset-3 col-sm-9 pt-3 d-flex">
                        <button type="submit" class="btn btn-primary btn-lg" style="margin-right: 10px;">Enviar</button>
                        <button type="reset" class="btn btn-danger btn-lg" onclick="borrarFormulario()">Borrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        <?php if ($formularioEnviado): ?>
            borrarFormulario();
        <?php endif; ?>
    </script>

    <!-- Start Footer -->
    <?php
    require_once __DIR__ . "/../fin.part.php";
    ?>
    <!-- End Footer -->

</body>

</html>
