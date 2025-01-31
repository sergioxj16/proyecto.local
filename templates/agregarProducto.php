<?php

use Src\Entity\Imagen;

require_once __DIR__ . '/../src/utils/file.class.php';
require_once __DIR__ . '/../src/exceptions/fileException.php';
require_once __DIR__ . '/../src/entity/imagen.class.php';
require_once __DIR__ . '/../src/database/connection.class.php';

$errores = [];
$titulo = "";
$descripcion = "";
$categoria = "";
$precio = 0;
$mensaje = "";
$hayError = false;
$rutaGaleria = Imagen::RUTA_IMAGENES_GALERIA;

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Recoger los datos del formulario
        $titulo = trim(htmlspecialchars($_POST['titulo']));
        $descripcion = trim(htmlspecialchars($_POST['descripcion']));
        $categoria = trim(htmlspecialchars($_POST['categoria']));
        $precio = floatval($_POST['precio']);

        // Verificar si el precio es negativo
        if ($precio < 0) {
            $errores[] = "El precio no puede ser negativo.";
            $hayError = true;
        }

        // Tipos de archivos permitidos
        $tiposAceptados = ['image/jpeg', 'image/gif', 'image/png'];

        // Crear una instancia de la clase File para subir la imagen
        $imagen = new File('imagen', $tiposAceptados);

        // Intentar guardar el archivo subido en el directorio correspondiente
        $imagen->saveUploadFile(Imagen::RUTA_IMAGENES_GALERIA);

        // Si no ocurre ningún error, mostrar mensaje de éxito y resetea los campos
        if (!$hayError) {
            $hayError = false;
            $mensaje = "Fichero enviado correctamente";

            // Insertar en la base de datos
            $conexion = Connection::make();
            $sql = "INSERT INTO imagenes (nombre, descripcion, categoria, precio, imagen) VALUES (:nombre, :descripcion, :categoria, :precio, :imagen)";
            $pdoStatement = $conexion->prepare($sql);
            $parametros = [
                ':nombre' => $titulo, // Guardamos el título de la imagen en la base de datos
                ':descripcion' => $descripcion,
                ':categoria' => $categoria,
                ':precio' => $precio,
                ':imagen' => $imagen->getFileName() // Guardamos la ruta de la imagen
            ];

            $titulo = "";
            $descripcion = "";
            $categoria = "";
            $precio = 0;

            if ($pdoStatement->execute($parametros) === false) {
                $errores[] = "No se ha podido guardar la imagen en la base de datos";
            }
        }
    } catch (FileException $fileException) {
        // Si ocurre un error, capturarlo y mostrar el mensaje
        $errores[] = $fileException->getMessage();
        $hayError = true; // Si hay errores, cambiar a true
        $titulo = "";
        $descripcion = "";
        $categoria = "";
        $precio = 0;
    }
}

if (empty($errores) && $mensaje == "") {
    $mensaje = '';  // Limpiar el mensaje
}

require_once __DIR__ . "/views/agregarProducto.view.php";
?>