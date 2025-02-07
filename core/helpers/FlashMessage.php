<?php
namespace sergio\core\helpers;

class FlashMessage
{
    public static function get(string $key, $default = '')
    {
        // Asegúrate de que la sesión esté activa
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['flash-message'])) {
            $value = $_SESSION['flash-message'][$key] ?? $default;
            // Se borra el mensaje después de obtenerlo
            unset($_SESSION['flash-message'][$key]);
        } else {
            $value = $default;
        }
        return $value;
    }

    public static function set(string $key, $value)
    {
        // Asegúrate de que la sesión esté activa antes de almacenar en ella
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        $_SESSION['flash-message'][$key] = $value;
    }

    public static function unset(string $key)
    {
        // Asegúrate de que la sesión esté activa antes de intentar borrar el valor
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (isset($_SESSION['flash-message'][$key])) {
            unset($_SESSION['flash-message'][$key]);
        }
    }
}
