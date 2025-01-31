<!DOCTYPE html>
<html lang="es">

<?php require_once __DIR__ . "/../inicio.part.php"; ?>

<body>
    <?php require_once __DIR__ . "/../navegacion.part.php"; ?>

    <div class="container mt-5">
        <h2 class="text-center">Galería de Imágenes</h2>
        <hr>

        <div id="MostrarGaleria">
            <?php
            // Comprobar si el directorio de imágenes existe
            if (is_dir($rutaGaleria)) {
                $imagenes = array_diff(scandir($rutaGaleria), ['..', '.']); // Ignorar . y ..

                if (!empty($imagenes)) {
                    echo '<div class="row justify-content-center">';

                    foreach ($imagenes as $imagen) {
                        $rutaImagen = $rutaGaleria . $imagen;
                        echo '<div class="col-md-4 mb-4">';
                        echo '<div class="card shadow-sm">';
                        echo '<img src="' . $rutaImagen . '" class="card-img-top img-fluid" style="max-height: 300px; object-fit: cover;" alt="Imagen">';
                        echo '<div class="card-body text-center">';
                        echo '<p class="card-text">' . htmlspecialchars($imagen) . '</p>';
                        echo '</div></div></div>';
                    }

                    echo '</div>';
                } else {
                    echo '<p class="text-center text-muted">No hay imágenes disponibles en la galería.</p>';
                }
            } else {
                echo '<p class="text-center text-danger">No se ha encontrado el directorio de imágenes.</p>';
            }
            ?>
        </div>
    </div>

    <?php require_once __DIR__ . "/../fin.part.php"; ?>

</body>
</html>
