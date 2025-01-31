<?php

use Src\Entity\Imagen;

require_once __DIR__ . '/../src/utils/file.class.php';
require_once __DIR__ . '/../src/exceptions/fileException.php';
require_once __DIR__ . '/../src/exceptions/appException.php';
require_once __DIR__ . '/../src/entity/imagen.class.php';
require_once __DIR__ . '/../src/database/queryBuilder.class.php';
require_once __DIR__ . '/../src/database/connection.class.php';

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
    $config = require_once __DIR__ . '/../app/config.php';
    App::bind('config', $config);

    // Obtener la conexión a la base de datos
    $conexion = App::getConnection();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recoger los datos del formulario
        $titulo = trim(htmlspecialchars($_POST['titulo']));
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

        // Insertar los datos de la imagen en la base de datos
        $sql = "INSERT INTO imagen (imagen, nombre, descripcion, categoria, precio, numLikes, propietario) 
                VALUES (:imagen, :nombre, :descripcion, :categoria, :precio, :numLikes, :propietario)";

        $pdoStatement = $conexion->prepare($sql);

        // Parámetros de la consulta
        $parametros = [
            ':imagen' => $imagen->getFileName(),
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':categoria' => $categoria,
            ':precio' => $precio,
            ':numLikes' => $numLikes,
            ':propietario' => $propietario
        ];

        // Ejecutar la consulta
        if (!$pdoStatement->execute($parametros)) {
            $errores[] = "No se ha podido guardar la imagen en la base de datos";
        }
    }

    // Buscar todas las imágenes en la base de datos
    $queryBuilder = new QueryBuilder('imagenes', 'Imagen');
    $imagenes = $queryBuilder->findAll();

} catch (FileException $fileException) {
    $errores[] = $fileException->getMessage();
} catch (QueryException $queryException) {
    $errores[] = $queryException->getMessage();
} catch (PDOException $pdoException) {
    $errores[] = "Error de conexión a la base de datos: " . $pdoException->getMessage();
}

// Cargar la vista
require_once 'views/mostrargaleria.view.php';
