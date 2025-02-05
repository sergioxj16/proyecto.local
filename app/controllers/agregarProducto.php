<?php
require_once __DIR__ . '/../utils/file.class.php';
require_once __DIR__ . '/../exceptions/fileException.php';
require_once __DIR__ . '/../exceptions/queryException.php';
require_once __DIR__ . '/../exceptions/appException.php';
require_once __DIR__ . '/../entity/iEntity.php';
require_once __DIR__ . '/../entity/imagen.class.php';
require_once __DIR__ . '/../../core/database/connection.class.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../repository/imagenesRepository.php';


// Definir la función para resetear las variables
function resetearVariables()
{
    global $nombre, $descripcion, $categoria, $precio, $fecha;
    // Restablecer las variables a sus valores iniciales
    $nombre = "";
    $descripcion = "";
    $categoria = "";
    $precio = 0;
    $fecha = date('Y-m-d');
}

$errores = [];
$mensaje = "";
$hayError = false;
$rutaGaleria = Imagen::RUTA_IMAGENES_GALERIA;
$nombre = "";
$descripcion = "";
$categoria = "";
$precio = 0;
$fecha = date('Y-m-d');

try {
    $config = getConfig();
    App::bind('config', $config);
    $conexion = App::getConnection();


    // Usamos ImagenesRepository en lugar de QueryBuilder
    $imagenesRepository = new ImagenesRepository();
    $imagenes = $imagenesRepository->findAll();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim(htmlspecialchars($_POST['nombre']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));
        $categoria = trim(htmlspecialchars($_POST['categoria']));
        $precio = floatval($_POST['precio']);
        $fecha = $_POST['fecha'] ?? date('Y-m-d');

        // Validar que la fecha no sea anterior a hoy
        if ($fecha < date('Y-m-d')) {
            throw new FileException("La fecha debe ser hoy o una fecha futura.");
        }

        if ($precio < 0) {
            throw new FileException("El precio no puede ser negativo.");
        }

        $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
        $imagen = new File('imagen', $tiposAceptados);
        $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_GALERIA);

        // Crear instancia de Imagen y guardarla en la base de datos
        $imagenGaleria = new Imagen(
            $imagen->getFileName(),
            $nombre,
            $descripcion,
            $categoria,
            0,
            0,
            $precio
        );

        $imagenGaleria->setFecha($fecha); // Establecer la fecha

        $imagenesRepository->save($imagenGaleria); // Usamos el repositorio para guardar

        $mensaje = "Fichero enviado correctamente";
        $imagenes = $imagenesRepository->findAll();

        // Reiniciar las variables
        resetearVariables();
    }
} catch (FileException | QueryException | AppException $exception) {
    $errores[] = $exception->getMessage();
    $hayError = true;
}

require_once __DIR__ . "/../views/agregarProducto.view.php";
