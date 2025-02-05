<?php
namespace sergio\app\utils;

class Utils
{
    public static function esOpcionMenuActiva($opcion): bool
    {
        $actual = trim($_SERVER['REQUEST_URI'], '/');
        $opcion = trim($opcion, '/');

        return $actual === $opcion || (empty($actual) && $opcion === ''); 
    }

    public static function existeOpcionMenuActivaEnArray($opciones): bool
    {
        foreach ($opciones as $opcionMenu) {
            if (self::esOpcionMenuActiva($opcionMenu)) {
                return true;
            }
        }
        return false;
    }

    public static function extraeElementosAleatorios($lista, $cantidad): array
    {
        if (!is_array($lista) || empty($lista) || $cantidad < 1) {
            return [];
        }

        shuffle($lista);
        return array_slice($lista, 0, $cantidad);
    }
}
