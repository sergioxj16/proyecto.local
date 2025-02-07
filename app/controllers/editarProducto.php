<?php
use sergio\app\repository\ImagenesRepository;
use sergio\app\exceptions\QueryException;
use sergio\core\App;

$errores = [];
$exito = false;
$imagen = null;

$conexion = App::getConnection();
$repo = new ImagenesRepository();

// Obtener la ID desde la URL
$id = isset($_GET['id']) && is_numeric($_GET['id']) ? (int) $_GET['id'] : null;

if ($id === null) {
    $errores[] = "No se ha proporcionado un ID de imagen válido.";
} else {
    try {
        $imagen = $repo->findByIdDetails($id);
        if (!$imagen) {
            $errores[] = "La imagen solicitada no existe.";
        }
    } catch (QueryException $e) {
        $errores[] = "Error al cargar los datos de la imagen: " . $e->getMessage();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $datos = [];
        if (!empty($_FILES['imagen']['name'])) {
            $directorio = __DIR__ . "/../uploads/";
            $archivo = $directorio . basename($_FILES['imagen']['name']);
            if (move_uploaded_file($_FILES['imagen']['tmp_name'], $archivo)) {
                $datos['imagen'] = "/uploads/" . basename($_FILES['imagen']['name']);
            } else {
                $errores[] = "Error al subir la imagen.";
            }
        }
        if (!empty($_POST['nombre'])) {
            $datos['nombre'] = trim($_POST['nombre']);
        }
        if (!empty($_POST['descripcion'])) {
            $datos['descripcion'] = trim($_POST['descripcion']);
        }
        if (!empty($_POST['categoria'])) {
            $datos['categoria'] = (int) $_POST['categoria'];
        }
        if (!empty($_POST['precio'])) {
            $datos['precio'] = number_format((float) $_POST['precio'], 2, '.', '');
        }
        if (!empty($_POST['fecha'])) {
            $datos['fecha'] = $_POST['fecha'];
        }

        if ($id !== null && $repo->actualizarImagen($id, $datos)) {
            $exito = true;
            $exito = true;
            header("Location: http://proyecto.local/mostrarGaleria");
        } else {
            $errores[] = "No se pudo actualizar la imagen.";
        }
    } catch (QueryException $e) {
        $errores[] = "Error al actualizar la imagen: " . $e->getMessage();
    }
}

require_once __DIR__ . "/../views/editarProducto.view.php";
