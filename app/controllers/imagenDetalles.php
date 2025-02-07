<?php
use sergio\app\repository\ImagenesRepository;
use sergio\core\App;

$errores = [];
$mensaje = '';
$imagen = null;
$idImagen = $_GET['id'];

if (isset($_GET['id'])) {

    try {
        $conexion = App::getConnection();
        $imagenRepo = new ImagenesRepository();

        $imagen = $imagenRepo->findByIdDetails($idImagen);

        if (!$imagen) {
            $errores[] = 'La imagen solicitada no existe.';
        }

    } catch (Exception $e) {
        $errores[] = 'Error al intentar obtener los detalles de la imagen: ' . $e->getMessage();
    }
} else {
    $errores[] = 'No se ha proporcionado un ID de imagen.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idLike'])) {
    $response = ['success' => false, 'message' => ''];

    try {
        $conexion = App::getConnection();
        $imagenRepo = new ImagenesRepository();

        if ($imagenRepo->darLike($idImagen)) {
            $response['success'] = true;
            $response['message'] = 'Like agregado correctamente.';
        } else {
            $response['message'] = 'Error al dar like.';
        }
    } catch (Exception $e) {
        $response['message'] = 'Error en el servidor: ' . $e->getMessage();
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}


require_once __DIR__ . '/../views/imagenDetalles.view.php';
