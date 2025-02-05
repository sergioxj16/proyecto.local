<?php

require_once __DIR__ . '/../utils/file.class.php';
require_once __DIR__ . '/../exceptions/fileException.php';
require_once __DIR__ . '/../exceptions/appException.php';
require_once __DIR__ . '/../entity/iEntity.php';
require_once __DIR__ . '/../entity/imagen.class.php';
require_once __DIR__ . '/../../core/database/connection.class.php';
require_once __DIR__ . '/../repository/imagenesRepository.php';

// Inicializamos variables
$errores = [];
$imagen = '';
$descripcion = '';
$categoria = '';
$precio = 0;
$numLikes = 0;
$propietario = '';
$rutaImagen = Imagen::RUTA_IMAGENES_GALERIA;

try {
    // Cargar configuración y vincularla al contenedor
    $config = require_once __DIR__ . '/../config.php';
    
    App::bind('config', $config);

    // Obtener la conexión a la base de datos
    $conexion = app::getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recoger los datos del formulario
        $nombre = trim(htmlspecialchars($_POST['titulo']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));
        $categoria = trim(htmlspecialchars($_POST['categoria']));
        $precio = trim(htmlspecialchars($_POST['precio']));
        $numLikes = trim(htmlspecialchars($_POST['numLikes']));
        $propietario = trim(htmlspecialchars($_POST['propietario']));

        // Tipos de imágenes permitidos
        $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];

        // Crear una instancia de la clase File para manejar la imagen
        $imagen = new File('imagen', $tiposAceptados);

        // Guardar la imagen en la ruta especificada
        $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_GALERIA);

        // Insertar los datos de la imagen en la base de datos utilizando el repositorio
        $imagenRepo = new ImagenesRepository();
        $imagenObj = new Imagen(
            $imagen->getFileName(),
            $nombre,
            $descripcion,
            $categoria,
            $propietario,
            $numLikes,
            $precio,
            $fecha
        );

        // Guardamos la imagen en la base de datos
        $imagenRepo->save($imagenObj);
    }

    // Buscar todas las imágenes en la base de datos utilizando el repositorio
    $imagenRepo = new ImagenesRepository();
    $imagenes = $imagenRepo->findAll();

} catch (FileException $fileException) {
    $errores[] = $fileException->getMessage();
} catch (QueryException $queryException) {
    $errores[] = $queryException->getMessage();
} catch (PDOException $pdoException) {
    $errores[] = "Error de conexión a la base de datos: " . $pdoException->getMessage();
}

// Cargar la vista
require_once __DIR__ . "/../views/shop.view.php";
