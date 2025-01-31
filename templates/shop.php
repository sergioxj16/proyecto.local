<?php

use Src\Entity\Imagen;

require_once __DIR__ . '/../src/utils/file.class.php';
require_once __DIR__ . '/../src/exceptions/fileException.php';
require_once __DIR__ . '/../src/entity/imagen.class.php';
require_once __DIR__ . '/../src/database/queryBuilder.class.php';
require_once __DIR__ . '/../src/database/connection.class.php';

$errores = [];
$imagen = '';
$descripcion = '';
$categoria = '';
$precio = 0;
$numLikes = 0;
$propietario = '';
$rutaImagen = Imagen::RUTA_IMAGENES_GALERIA;

try {
    // Establecer conexión con la base de datos
    $conexion = Connection::make();
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Recoger los datos del formulario
        $titulo = trim(htmlspecialchars($_POST['titulo']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));
        $categoria = trim(htmlspecialchars($_POST['categoria']));
        $precio = trim(htmlspecialchars($_POST['precio']));
        $numLikes = trim(htmlspecialchars($_POST['numLikes']));
        $propietario = trim(htmlspecialchars($_POST['propietario']));
        
        $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];
        
        $imagen = new File('imagen', $tiposAceptados);  // 'imagen' es el nombre del campo en el formulario
        
        $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_GALERIA);
        
        $sql = "INSERT INTO imagen (imagen, nombre, descripcion, categoria, precio, numLikes, propietario) 
                VALUES (:imagen, :nombre, :descripcion, :categoria, :precio, :numLikes, :propietario)";

        $pdoStatement = $conexion->prepare($sql);
        
        $parametros = [
            ':imagen' => $imagen->getFileName(),
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':categoria' => $categoria,
            ':precio' => $precio,
            ':numLikes' => $numLikes,
            ':propietario' => $propietario
        ];
        
        if ($pdoStatement->execute($parametros) === false) {
            $errores[] = "No se ha podido guardar la imagen en la base de datos";
        } else {
            $errores[] = "";
        }
    }

    $queryBuilder = new QueryBuilder($conexion);
    $imagenes = $queryBuilder->findAll('imagenes', 'Src\Entity\Imagen');

} catch (FileException $fileException) {
    $errores[] = $fileException->getMessage();
} catch (QueryException $queryException) {
    $errores[] = $queryException->getMessage();
} catch (PDOException $pdoException) {
    $errores[] = "Error de conexión a la base de datos: " . $pdoException->getMessage();
}

require_once 'views/shop.view.php';