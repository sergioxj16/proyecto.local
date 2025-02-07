<?php

namespace sergio\app\controllers;

use sergio\app\entity\User;
use sergio\app\exceptions\ValidationException;
use sergio\app\repository\UserRepository;
use sergio\core\App;
use sergio\core\helpers\FlashMessage;
use sergio\core\Response;
use sergio\core\Security;

class AuthController
{
    public function login()
    {
        // Obtenemos los errores y el correo desde la sesión o los mensajes flash
        $errores = FlashMessage::get('login-error', []);
        $correo = FlashMessage::get('correo', ''); // Si no hay correo, se asigna una cadena vacía

        // Renderiza la vista de login y pasa las variables
        Response::renderView('login', 'layout', compact('errores', 'correo'));
    }


    public function logout()
    {
        if (isset($_SESSION['loguedUser'])) {
            $_SESSION['loguedUser'] = null;
            unset($_SESSION['loguedUser']);
        }
        App::get('router')->redirect('login');
    }

    public function checkLogin()
    {
        try {
            if (!isset($_POST['correo']) || empty($_POST['correo'])) {
                throw new ValidationException('El correo no puede estar vacío');
            }

            if (!isset($_POST['password']) || empty($_POST['password'])) {
                throw new ValidationException('La contraseña no puede estar vacía');
            }

            // Buscar al usuario en la base de datos por correo
            $usuario = App::get(UserRepository::class)->findOneBy([
                'correo' => $_POST['correo']
            ]);

            // Verificar si el usuario existe y si la contraseña es correcta
            if (!is_null($usuario) && Security::checkPassword($_POST['password'], $usuario->getPassword())) {
                // Iniciar sesión
                $_SESSION['loguedUser'] = 1;
                $_SESSION['rol'] = $usuario->getRol();  // Puedes almacenar el rol si lo necesitas para control de acceso
                App::get('router')->redirect('dashboard'); // Redirigir a la página principal
            } else {
                // Error: Credenciales incorrectas
                FlashMessage::set('login-error', ['Correo o contraseña incorrectos']);
                App::get('router')->redirect('login');
            }
        } catch (ValidationException $e) {
            FlashMessage::set('login-error', [$e->getMessage()]);
            App::get('router')->redirect('login');
        }
    }

}
