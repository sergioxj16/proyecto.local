<?php
use sergio\app\exceptions\FileException;
use sergio\app\exceptions\QueryException;
use sergio\app\entity\Imagen;
use sergio\core\App;
use sergio\app\repository\ImagenesRepository;
use function sergio\app\getConfig;

session_start();
$errores = [];
$mensaje = '';
$fecha = $_GET['fecha'] ?? '';
$precio = $_GET['precio'] ?? '';
$likes = $_GET['likes'] ?? '';
$categoria = $_GET['categoria'] ?? '';
$ordenar = $_GET['ordenar'] ?? '';


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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['idLike'])) {
    $idImagen = $_POST['idLike'];
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


require_once __DIR__ . '/../views/index.view.php';

?>