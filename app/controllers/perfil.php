<?php
session_start();

use sergio\Core\App;
use sergio\app\repository\UserRepository;

if (!isset($_SESSION['usuario'])) {
    echo "<script>console.log('No hay sesión iniciada');</script>";
    header('Location: login');
    exit;
}

try {
    // Obtiene la conexión
    $conexion = App::getConnection();
    $usuariosRepo = new UserRepository();
    $usuarios = $usuariosRepo->findAll(); // Obtén todos los usuarios desde la base de datos
    

    // Busca el usuario actual en el array de usuarios
    $usuarioActual = null;
    foreach ($usuarios as $usuario) {
        // Verifica si el correo en la sesión coincide con el de algún usuario en la base de datos
        if ($usuario->getCorreo() === $_SESSION['usuario']['correo']) {
            $usuarioActual = $usuario;
            break;
        }
    }
    
    // Si no se encuentra el usuario actual, redirige al login
    if ($usuarioActual === null) {
        echo "<script>console.log('No se encontró el usuario en la base de datos');</script>";
        header('Location: login');
        exit;
    }

} catch (Exception $e) {
    // Maneja los errores en caso de que ocurra algún problema
    $error = "Error al obtener los datos del usuario: " . $e->getMessage();
    echo "<script>console.log('Error:', " . json_encode($error) . ");</script>";
}

require_once __DIR__ . "/../views/perfil.view.php";
?>
