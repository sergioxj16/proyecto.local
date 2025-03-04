<?php
use sergio\app\exceptions\QueryException;
use sergio\core\App;
use sergio\app\repository\UserRepository;
use function sergio\app\getConfig;
use sergio\app\entity\User;
use sergio\app\exceptions\AppException;

session_start();
$errores = [];
$mensaje = "";
$hayError = false;

try {
    $config = getConfig();
    App::bind('config', $config);
    $conexion = App::getConnection();

    $usersRepository = new UserRepository();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nombre = trim(htmlspecialchars($_POST['nombre']));
        $apellido = trim(htmlspecialchars($_POST['apellido']));
        $email = trim(htmlspecialchars($_POST['email']));
        $password = trim($_POST['password']);
        $passwordConfirm = trim($_POST['password_confirm']);
        $captchaIngresado = trim($_POST['captcha']);

        // Validación del CAPTCHA
        if (!isset($_SESSION['captchaGenerado']) || strtoupper($captchaIngresado) !== $_SESSION['captchaGenerado']) {
            throw new AppException("¡Código de seguridad incorrecto! Inténtelo de nuevo.");
        }

        unset($_SESSION['captchaGenerado']); // Eliminar el CAPTCHA de la sesión

        // Validaciones adicionales
        if (empty($nombre) || empty($apellido) || empty($email) || empty($password) || empty($passwordConfirm)) {
            throw new AppException("Todos los campos son obligatorios.");
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new AppException("El correo electrónico no es válido.");
        }

        if ($password !== $passwordConfirm) {
            throw new AppException("Las contraseñas no coinciden.");
        }

        if ($usersRepository->existeEmail($email)) {
            throw new AppException("El correo electrónico ya está registrado.");
        }

        $user = new User($email, $nombre, $apellido, $password);
        $usersRepository->save($user);

        $mensaje = "Registro exitoso. Ahora puedes iniciar sesión.";
    }
} catch (AppException | QueryException $exception) {
    $errores[] = $exception->getMessage();
    $hayError = true;
}

require_once __DIR__ . '/../views/register.view.php';
