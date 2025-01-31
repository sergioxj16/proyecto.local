<?php

require_once __DIR__ . '/../src/utils/file.class.php';
require_once __DIR__ . '/../src/exceptions/fileException.php';
require_once __DIR__ . '/../src/exceptions/queryException.php';
require_once __DIR__ . '/../src/exceptions/appException.php';
require_once __DIR__ . '/../src/entity/iEntity.php';
require_once __DIR__ . '/../src/entity/imagen.class.php';
require_once __DIR__ . '/../src/database/connection.class.php';
require_once __DIR__ . '/../src/repository/imagenesRepository.php';

$errores = [];
$mensaje = "";
$hayError = false;
$rutaGaleria = Imagen::RUTA_IMAGENES_GALERIA;
$nombre = "";
$descripcion = "";
$categoria = "";
$precio = 0;
$mensaje = "";

try {
    $config = require_once __DIR__ . '/../app/config.php';
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

        $imagenesRepository->save($imagenGaleria); // Usamos el repositorio para guardar

        $mensaje = "Fichero enviado correctamente";
        $imagenes = $imagenesRepository->findAll(); // Recargar imágenes después de guardar
    }
} catch (FileException | QueryException | AppException $exception) {
    $errores[] = $exception->getMessage();
    $hayError = true;
}

require_once __DIR__ . "/views/agregarProducto.view.php";
