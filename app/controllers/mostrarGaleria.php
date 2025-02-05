<?php

require_once __DIR__ . '/../utils/file.class.php';
require_once __DIR__ . '/../exceptions/fileException.php';
require_once __DIR__ . '/../exceptions/appException.php';
require_once __DIR__ . '/../entity/iEntity.php';
require_once __DIR__ . '/../entity/imagen.class.php';
require_once __DIR__ . '/../../core/database/connection.class.php';
require_once __DIR__ . '/../repository/imagenesRepository.php';
require_once __DIR__ . '/../config.php';

$errores = [];
$mensaje = '';
$fecha = $_GET['fecha'] ?? '';
$precio = $_GET['precio'] ?? '';
$likes = $_GET['likes'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$ordenar = $_GET['ordenar'] ?? '';

if (isset($_GET['borrar'])) {
    $idImagen = $_GET['borrar'];

    try {
        $conexion = App::getConnection();
        $imagenRepo = new ImagenesRepository();

        $imagen = $imagenRepo->findById($idImagen);

        if ($imagen) {
            $rutaImagen = Imagen::RUTA_IMAGENES_GALERIA . $imagen->getImagen(); // Ajustamos la ruta

            // Verificamos si el archivo existe antes de intentar borrarlo
            if (file_exists($rutaImagen)) {
                if (!unlink($rutaImagen)) { // Intentamos eliminar el archivo
                    throw new Exception("Error al eliminar el archivo de imagen.");
                }
            } else {
                throw new Exception("El archivo de imagen no existe.");
            }

            // Eliminamos la entrada en la base de datos
            if ($imagenRepo->delete($idImagen)) {
                $mensaje = 'La imagen ha sido eliminada correctamente.';
            } else {
                throw new Exception("No se pudo eliminar la imagen de la base de datos.");
            }
        } else {
            $errores[] = 'La imagen no existe.';
        }

    } catch (Exception $e) {
        $errores[] = 'Error al intentar borrar la imagen: ' . $e->getMessage();
    }
}

try {
    $config = getConfig();
    App::bind('config', $config);

    $conexion = App::getConnection();

    $imagenRepo = new ImagenesRepository();
    $imagenes = $imagenRepo->findAll($fecha, $precio, $likes, $categoria, $ordenar);

} catch (FileException $fileException) {
    $errores[] = $fileException->getMessage();
} catch (QueryException $queryException) {
    $errores[] = $queryException->getMessage();
} catch (PDOException $pdoException) {
    $errores[] = "Error de conexión a la base de datos: " . $pdoException->getMessage();
} catch (Exception $e) {
    $errores[] = "Error al intentar realizar la operación: " . $e->getMessage();
}

require_once __DIR__ . '/../views/mostrarGaleria.view.php';

?>
