<?php
use sergio\app\entity\User;
use sergio\core\App;
use sergio\app\repository\UserRepository;

session_start();

$error = "";

// Establecemos la conexión a la base de datos
try {
    $conexion = App::getConnection();
    $usuariosRepo = new UserRepository();
    $usuarios = $usuariosRepo->findAll();
} catch (Exception $e) {
    $error = "Error al conectar con la base de datos: " . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['email'];
    $password = $_POST['password'];

    // Buscar al usuario
    foreach ($usuarios as $usuario) {
        if ($usuario->getCorreo() === $correo && $usuario->getPassword() === $password) {
            // Guardamos la información del usuario en la sesión
            $_SESSION['usuario'] = [
                'id' => $usuario->getId(),
                'nombre' => $usuario->getNombre(),
                'rol' => $usuario->getRol(),
                'correo' => $usuario->getCorreo() // Asegúrate de guardar el correo también
            ];
            // Redirigir a la página principal
            header('Location: /');
            exit;
        }
    }

    // Si no se encuentra el usuario
    $error = "Correo o contraseña incorrectos.";
}

// Pasamos la variable de error a la vista
require_once __DIR__ . "/../views/login.view.php";
