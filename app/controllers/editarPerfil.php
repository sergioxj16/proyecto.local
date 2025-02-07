<?php
session_start();

use sergio\Core\App;
use sergio\app\repository\UserRepository;

if (!isset($_SESSION['usuario'])) {
    header('Location: login');
    exit;
}

$error = "";

$usuarioActual = $_SESSION['usuario']; // Obtener el usuario actual desde la sesión

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];

    // Validar los datos
    if (empty($nombre) || empty($apellido) || empty($correo)) {
        $error = "Todos los campos son obligatorios.";
    } else {
        try {
            // Obtener la conexión y el repositorio
            $conexion = App::getConnection();
            $usuariosRepo = new UserRepository();

            // Actualizamos el usuario en la base de datos
            $usuariosRepo->update($usuarioActual['id'], $nombre, $apellido, $correo);

            // Actualizamos los datos en la sesión
            $_SESSION['usuario'] = [
                'id' => $usuarioActual['id'],
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'rol' => $usuarioActual['rol']
            ];

            // Redirigir al perfil actualizado
            header('Location: perfil');
            exit;

        } catch (Exception $e) {
            $error = "Error al actualizar el perfil: " . $e->getMessage();
        }
    }
}

// Pasamos el usuario actual a la vista
require_once __DIR__ . "/../views/perfil.view.php";
?>
